<?php

session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();

// Primero se traen los datos de la reserva y de vehículos disponibles para mostrar en pantalla y permitir la selección
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    $reserva = array();

    // Obtener los datos de la reserva (Se añade r.activo)
    $ConsultaReservas = "SELECT r.idReserva,
                        r.numeroReserva as NumeroReserva,
                        r.fechaInicioReserva as FechaRetiro,
                        r.FechaFinReserva as FechaDevolucion,
                        r.precioPorDiaReserva as PrecioDiario,
                        r.idCliente as IDCliente,
                        r.idVehiculo as IDVehiculo,
                        r.idContrato as IDContrato,
                        r.activo as ActivoReserva,      /* <--- CAMBIO: AÑADIDO CAMPO ACTIVO */
                        c.idCliente,
                        c.nombreCliente as NombreCliente,
                        c.apellidoCliente as ApellidoCliente,
                        c.nacionalidadCliente, 
                        c.dniCliente as DocumentoCliente,
                        v.idVehiculo,
                        v.matricula as Matricula,
                        v.disponibilidad as Disponibilidad,
                        v.idModelo,
                        v.idGrupoVehiculo,
                        m.idModelo, 
                        m.nombreModelo as Modelo,
                        m.descripcionModelo,
                        g.idGrupo,
                        g.nombreGrupo as Grupo,
                        g.descripcionGrupo 
                 FROM `reservas-vehiculos` r, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g 
                 WHERE r.idReserva = $idReserva 
                 AND r.idCliente = c.idCliente 
                 AND r.idVehiculo = v.idVehiculo 
                 AND v.idModelo = m.idModelo 
                 AND v.idGrupoVehiculo = g.idGrupo; ";


    $rs = mysqli_query($conexion, $ConsultaReservas);

    $reserva = mysqli_fetch_array($rs);
    
    // Determinar si la reserva está cancelada (0 = Cancelada)
    $esCancelada = ($reserva['ActivoReserva'] == 0);


    // Además se trae el contrato asociado a la reserva, en caso de existir, para corroborar si el estado es "En Preparación"
    $estadoContrato = "";

    if(!empty($reserva['IDContrato'])) {

        $idContrato = $reserva['IDContrato'];

        $contrato = array();

        // Obtener los datos del contrato
        $ConsultaContrato = "SELECT co.idContrato,
                                    co.idEstadoContrato as IdEstadoContrato,
                                    e.idEstadoContrato,
                                    e.estadoContrato as EstadoContrato,
                                    e.descripcionEstadoContrato as DescripcionEstado 
                    FROM `contratos-alquiler` co, `estados-contratos` e 
                    WHERE co.idContrato = $idContrato 
                    AND e.idEstadoContrato = co.idEstadoContrato; ";

        $rs = mysqli_query($conexion, $ConsultaContrato);

        $contrato = mysqli_fetch_array($rs);
        
        if ($contrato['EstadoContrato'] == "En Preparación") {
            $estadoContrato = "En Preparación";
        }
    }
    else {
        $estadoContrato = "No existe";
    }

    // Se traen todos los vehículos disponibles para dropdown list:
    $vehiculosDisponibles = array();
    
    require_once 'funciones/Select_Tablas.php';
    $vehiculosDisponibles = Listar_Vehiculos_Disponibles($conexion);
    $cantidadVehiculos = count($vehiculosDisponibles);
} 

else {
    // Si no se pasa un ID, se redirige al listado de reservas
    header('Location: reservas.php');
    exit();
}


// A continuación se hace UPDATE de los datos luego de cliquear el botón "Guardar Cambios" (los elementos POST proceden de este mismo archivo)
$mensajeError = "";

// -------------------------------------------------------------
// NUEVO: Lógica para REACTIVAR la Reserva (activo = 1)
// -------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['BotonReactivarReserva'])) {
    
    // El ID de la reserva se pasa como campo oculto
    $idReserva = $_POST['idReservaReactivar']; 
    $numreserva = $reserva['NumeroReserva']; 
    
    // Consulta para reactivar: activo=1 y limpiar el comentario de cancelación
    $SQLupdate = "UPDATE `reservas-vehiculos` 
                  SET activo = 1, comentario = NULL 
                  WHERE idReserva = $idReserva";

    $rs = mysqli_query($conexion, $SQLupdate);
    
    if (!$rs) {
        $mensajeError = "No se pudo acceder a la base de datos. Error al intentar reactivar la reserva.";
    } else {
        $mensajeError = "Reserva número " . trim($numreserva) . " reactivada exitosamente. Ahora está activa.";
        // Redirigir para recargar la página con el nuevo estado
        header("Location: ModificarReserva.php?id=$idReserva&mensaje=" . urlencode($mensajeError));
        exit();
    }
}
// -------------------------------------------------------------
// FIN: Lógica para REACTIVAR la Reserva
// -------------------------------------------------------------


if ($_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_POST['BotonModificarReserva'])) {

    $idCliente = $reserva['IDCliente'];
    $numreserva = $reserva['NumeroReserva'];
    $idVehiculo = $_POST['VehiculosDisponibles'];  
    $precioDiarioReserva = $_POST['PrecioPorDia'];

    
    // Validaciones de fechas
    $errores = [];

    if (empty($_POST['FechaRetiro'])) {
        $errores[] = "La fecha de retiro es obligatoria.";
    }
    if (empty($_POST['FechaDevolucion'])) {
        $errores[] = "La fecha de devolución es obligatoria.";
    }
    if (!empty($_POST['FechaRetiro']) && !empty($_POST['FechaDevolucion'])) {
        $fechaRetiro = new DateTime($_POST['FechaRetiro']);
        $fechaDevolucion = new DateTime($_POST['FechaDevolucion']);

        if ($fechaRetiro > $fechaDevolucion) {
            $errores[] = "La fecha de retiro no puede ser posterior a la fecha de devolución.";
        }
        else {
            // Validación de duración máxima de reserva (1 mes)
            $intervalo = $fechaRetiro->diff($fechaDevolucion);
            if ($intervalo->days > 30) { 
                $errores[] = "Las reservas no pueden superar 1 mes de duración.";
            }
        }
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensajeDeError = implode(' ', $errores);
        // Redirigir con mensaje de error para que lo muestre el modal
        header("Location: reservas.php?status=error&mensaje=" . urlencode($mensajeDeError));
        exit();
    }

    // Se calcula cantidad de días de reserva
    $fechaInicial = new DateTime($_POST['FechaRetiro']);
    $fechaFinal = new DateTime($_POST['FechaDevolucion']);
    // Calcular la diferencia de días
    $intervalo = $fechaInicial->diff($fechaFinal);
    $diferenciaDias = $intervalo->days; // Obtiene la cantidad de días exacta
    // Se calcula monto total
    $montoTotal = $precioDiarioReserva * $diferenciaDias;

    // Se cambia formato de las fechas y se almacenan para el update:
    $fechaEspanol = $_POST['FechaRetiro'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year-$mo-$day";
    $fecharetiro = $fechaIngles;

    $fechaEspanol = $_POST['FechaDevolucion'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year-$mo-$day";
    $fechadevolucion = $fechaIngles;

    require_once 'funciones/CRUD-Reservas.php';
    
    if ($idVehiculo) {   

        // Actualizar los datos de la reserva
        $ModificacionReserva = "UPDATE `reservas-vehiculos` 
                                SET fechaReserva = NOW(), 
                                    fechaInicioReserva = '$fecharetiro', 
                                    FechaFinReserva = '$fechadevolucion',
                                    precioPorDiaReserva = '$precioDiarioReserva', 
                                    cantidadDiasReserva = '$diferenciaDias',
                                    totalReserva = '$montoTotal',
                                    idCliente = $idCliente, 
                                    idVehiculo = $idVehiculo 
                                WHERE idReserva = ?"; 

        $stmt = $conexion->prepare($ModificacionReserva);
        if (!$stmt) {
            $mensajeError = "Error al preparar la consulta: " . $conexion->error;
            header("Location: reservas.php?status=error&mensaje=" . urlencode($mensajeError));
            exit();
        }

        $stmt->bind_param("i", $idReserva);
        $rs = $stmt->execute();

        if (!$rs) {

            $mensajeError = "No se pudo acceder a la base de datos. Error al intentar modificar la reserva";
            //si surge un error, finalizo la ejecucion del script con un mensaje 
            header("Location: reservas.php?mensaje=" . urlencode($mensajeError));
            exit();
            $stmt->close();
        }
        else {

            // Redirigir después de la actualización
            $mensajeExito = "Reserva modificada exitosamente.";
            // Redirigir con mensaje de éxito para que lo muestre el modal
            header("Location: reservas.php?status=success&mensaje=" . urlencode($mensajeExito));
            $stmt->close();
            exit();
        }
    }

    else {
        $mensajeError = "No se puede realizar la reserva.";
    }
}


// -------------------------------------------------------------
// Lógica para deshabilitar campos y botones:
// -------------------------------------------------------------

// Determinar la condición general de deshabilitación de campos
$isDisabledGeneral = false;
// 1. Contrato firmado (lógica existente)
$contratoFirmado = ($estadoContrato != "En Preparación" && $estadoContrato != "No existe"); 

// 2. Si el contrato está firmado O si la reserva está cancelada, deshabilitar
if ($contratoFirmado || $esCancelada) {
    $isDisabledGeneral = true;
}

$disabledAttr = $isDisabledGeneral ? 'disabled' : '';

?>

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php 
        
        include('sidebarGOp.php'); 
        include('topNavBar.php'); 
        
        ?>

        <div class="p-5 mb-4 bg-white shadow-sm"
            style="margin-top: 150px; margin-bottom: 100px; margin-left: 1%; max-width: 98%; border: 1px solid #444444; border-radius: 14px;">

            <?php 

            if ($mensajeError) { ?>
            <div class="alert alert-danger mt-3">
                <?php 
                        echo "Error al intentar modificar el vehículo. <br><br>"; 
                        echo $mensajeError; 
                    ?>
            </div>
            <?php } 
            
            if (isset($_GET['mensaje'])) { ?>
            <div class="alert alert-success mt-3">
                <?php 
                        echo htmlspecialchars($_GET['mensaje']); 
                    ?>
            </div>
            <?php } 

            ?>

            <h5 class="mb-4 text-secondary"><strong>Modificar Reserva</strong></h5>

            <?php 
                $alerta = "success";
                $mensajeAlerta = "";

                if ($esCancelada) {
                    $alerta = "danger";
                    $mensajeAlerta = "Esta reserva figura como CANCELADA. Para realizar modificaciones, primero debe reactivarla.";
                } elseif ($contratoFirmado) {
                    $alerta = "danger";
                    $mensajeAlerta = "El contrato ya fue firmado o cancelado. Los campos están deshabilitados.";
                } else {
                    $alerta = "success";
                    $mensajeAlerta = "Todos los campos son obligatorios para la modificación.";
                }
            ?>
            <div class="alert alert-<?php echo $alerta; ?> mt-5">
                <br>
                <h6 class='mb-4 text-secondary'><?php echo $mensajeAlerta; ?></h6>
            </div><br><br>

            <form method="POST" onsubmit="return validarFechasModificacion()">
                <input type="hidden" name="idReservaReactivar" value="<?php echo $idReserva; ?>">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="NombreCliente"
                        value="<?php echo htmlspecialchars(trim($reserva['NombreCliente'])); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="ApellidoCliente"
                        value="<?php echo htmlspecialchars(trim($reserva['ApellidoCliente'])); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="documento" class="form-label">Documento</label>
                    <input type="text" class="form-control" id="documento" name="DocumentoCliente"
                        value="<?php echo htmlspecialchars(trim($reserva['DocumentoCliente'])); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="numero" class="form-label">Número de Reserva</label>
                    <input type="text" class="form-control" id="numero" name="NumeroReserva"
                        value="<?php echo htmlspecialchars(trim($reserva['NumeroReserva'])); ?> " disabled>
                </div>

                <div class="mb-3">
                    <label for="vehiculosdisponibles" class="form-label"> Vehículos disponibles </label>
                    <select class="form-select" aria-label="Selector" id="vehiculosdisponibles"
                        name="VehiculosDisponibles" <?php echo $disabledAttr; ?>
                        <?php if (!$isDisabledGeneral) { echo "required"; } ?>
                        onchange="obtenerPrecioSugeridoModificacion()">
                        <option value="" selected>Selecciona una opción</option>

                        <?php 
                        if (!empty($vehiculosDisponibles)) {
                            $selected = '';

                            for ($i = 0; $i < $cantidadVehiculos; $i++) {
                                // Lógica para verificar si el grupo debe estar seleccionado
                                $selected = (!empty($reserva['IDVehiculo']) && $reserva['IDVehiculo'] == $vehiculosDisponibles[$i]['IdVehiculo']) ? 'selected' : '';
                                echo "<option value='{$vehiculosDisponibles[$i]['IdVehiculo']}' $selected > 
                                        MATRÍCULA: {$vehiculosDisponibles[$i]['matricula']} - {$vehiculosDisponibles[$i]['modelo']}, {$vehiculosDisponibles[$i]['grupo']}  
                                     </option>";
                            }
                        } 
                        else {
                            echo "<option value=''> En este momento no existen vehículos disponibles. </option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecharetiro" class="form-label">Fecha de Retiro</label>
                    <input type="date" class="form-control" id="fecharetiro" name="FechaRetiro"
                        value="<?php echo htmlspecialchars($reserva['FechaRetiro']); ?>" <?php echo $disabledAttr; ?>
                        <?php if (!$isDisabledGeneral) { echo "required"; } ?>>
                </div>

                <div class="mb-3">
                    <label for="fechadevolucion" class="form-label">Fecha de Devolución</label>
                    <input type="date" class="form-control" id="fechadevolucion" name="FechaDevolucion"
                        value="<?php echo htmlspecialchars($reserva['FechaDevolucion']); ?>"
                        <?php echo $disabledAttr; ?> <?php if (!$isDisabledGeneral) { echo "required"; } ?>>
                </div>

                <div class="mb-3 col-md-4">
                    <label for="inputPrecioPorDiaMod" class="form-label">Precio por Día (Modificable)</label>
                    <input type="number" min="20" max="1000" step="0.01" class="form-control" id="inputPrecioPorDiaMod"
                        name="PrecioPorDia" value="<?php echo $reserva['PrecioDiario']; ?>" required
                        oninput="calcularTotalReservaModificacion()">
                </div>

                <div class="mb-3 col-md-4">
                    <label for="inputTotalReservaMod" class="form-label">Monto Total</label>
                    <input type="number" class="form-control" id="inputTotalReservaMod" name="MontoTotal" readonly
                        placeholder="Calculado Automáticamente">
                </div>

                <div class="d-flex justify-content-start gap-2 mt-5">

                    <?php if (!$esCancelada): ?>

                    <button type="submit" class="btn btn-primary" name="BotonModificarReserva"
                        value="modificandoReserva" <?php echo $disabledAttr; ?>>
                        Guardar Cambios
                    </button>



                    <?php else: ?>

                    <button type="submit" class="btn btn-success" name="BotonReactivarReserva"
                        value="reactivandoReserva">
                        Reactivar Reserva
                    </button>

                    <?php endif; ?>

                    <a href="reservas.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>

        </div>

        <div style="margin-top: 100px;">
            <?php require_once "foot.php"; ?>
        </div>

    </div>

    <script>
    const MAX_DAYS = 30;

    function validarFechasModificacion() {
        const fechaRetiroInput = document.getElementById('fecharetiro');
        const fechaDevolucionInput = document.getElementById('fechadevolucion');

        if (!fechaRetiroInput.value || !fechaDevolucionInput.value) {
            alert('Ambas fechas son obligatorias.');
            return false;
        }

        const fechaRetiro = new Date(fechaRetiroInput.value);
        const fechaDevolucion = new Date(fechaDevolucionInput.value);

        if (fechaDevolucion <= fechaRetiro) {
            alert('La fecha de devolución debe ser posterior a la fecha de retiro.');
            return false;
        }

        const diffTime = Math.abs(fechaDevolucion - fechaRetiro);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > MAX_DAYS) {
            alert(`La duración máxima de la reserva es de ${MAX_DAYS} días. Su selección es de ${diffDays} días.`);
            return false;
        }

        return true; // Envía el formulario si todo es correcto
    }

    document.addEventListener('DOMContentLoaded', () => {
        const fechaRetiroInput = document.getElementById('fecharetiro');
        const fechaDevolucionInput = document.getElementById('fechadevolucion');

        if (fechaRetiroInput && fechaDevolucionInput) {
            fechaRetiroInput.addEventListener('change', () => {
                fechaDevolucionInput.min = fechaRetiroInput.value;
            });
        }
    });

    function diferenciaEnDias(fecha1, fecha2) {
        const date1 = new Date(fecha1);
        const date2 = new Date(fecha2);

        if (isNaN(date1.getTime()) || isNaN(date2.getTime()) || date2 < date1) {
            return 0;
        }

        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));

        return diffDays;
    }

    /**
     * 1. Calcula el monto total de la reserva: Precio * Días.
     */
    function calcularTotalReservaModificacion() {
        // IDs de los campos en el formulario de ModificarReserva.php
        const inputPrecio = document.getElementById('inputPrecioPorDiaMod');
        const inputRetiro = document.getElementById('fecharetiro');
        const inputDevolucion = document.getElementById('fechadevolucion');
        const inputTotal = document.getElementById('inputTotalReservaMod');

        if (!inputPrecio || !inputRetiro || !inputDevolucion || !inputTotal) {
            return;
        }

        const precio = parseFloat(inputPrecio.value);
        const fechaRetiro = inputRetiro.value;
        const fechaDevolucion = inputDevolucion.value;

        if (isNaN(precio) || precio <= 0 || !fechaRetiro || !fechaDevolucion) {
            inputTotal.value = '0.00';
            return;
        }

        const dias = diferenciaEnDias(fechaRetiro, fechaDevolucion);

        if (dias > 0) {
            const total = precio * dias;
            inputTotal.value = total.toFixed(2);
        } else {
            inputTotal.value = '0.00';
        }
    }


    /**
     * 2. Obtiene el precio sugerido por AJAX al cambiar el vehículo.
     */
    function obtenerPrecioSugeridoModificacion() {
        const selectVehiculo = document.getElementById('vehiculosdisponibles');
        const inputPrecio = document.getElementById('inputPrecioPorDiaMod');
        const idVehiculo = selectVehiculo.value;

        if (!idVehiculo || idVehiculo === "") {
            inputPrecio.value = '';
            calcularTotalReservaModificacion();
            return;
        }

        // Lógica AJAX (reutilizando obtener_precio_grupo.php)
        const formData = new FormData();
        formData.append('idVehiculo', idVehiculo);

        fetch('obtener_precio_grupo.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error de red al obtener el precio: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    inputPrecio.value = parseFloat(data.precio).toFixed(2);
                } else {
                    console.error('Error del servidor:', data.message);
                    inputPrecio.value = '';
                }
                calcularTotalReservaModificacion();
            })
            .catch(error => {
                console.error('Error de la solicitud AJAX:', error);
                inputPrecio.value = '';
                alert('Ocurrió un error al obtener el precio sugerido para la modificación.');
                calcularTotalReservaModificacion();
            });
    }


    // ===================================================================
    // INICIALIZACIÓN Y FUNCIONES ORIGINALES
    // ===================================================================

    // Inicializa el cálculo del total con los datos de la reserva actual al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(calcularTotalReservaModificacion, 100);
    });
    </script>

</body>

</html>