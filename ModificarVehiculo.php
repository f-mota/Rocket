<?php

session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();

// Importo funciones para listar tablas auxiliares
require_once 'funciones/Select_Tablas.php';

$ListadoCombustible = Listar_Combustible($conexion);
$CantidadCombustible = count($ListadoCombustible);

$ListadoGrupo = Listar_Grupo($conexion);
$CantidadGrupo = count($ListadoGrupo);

$ListadoModelo = Listar_Modelo($conexion);
$CantidadModelo = count($ListadoModelo);

$sucursalesDisponibles = Listar_Sucursal($conexion);
$cantidadSucursales = count($sucursalesDisponibles);


// Primero se traen los datos del vehículo para mostrar en pantalla y permitir modificar cualquiera de sus campos
if (isset($_GET['id'])) {
    $idVehiculo = $_GET['id'];

    $vehiculo = array();

    // Obtener los datos del contrato seleccionado
    $SQL = "SELECT v.idVehiculo as vID,
                   v.matricula as vMatricula, 
                   v.color as vColor,
                   v.fechaCompra as vFechaCompra,
                   v.precioCompra as vPrecioCompra,
                   v.anio as vAnio,
                   v.numeroMotor as vNumeroMotor,
                   v.numeroChasis as vNumeroChasis,
                   v.puertas as vNumeroPuertas,
                   v.asientos as vNumeroAsientos,
                   v.esAutomatico as vAutomatico,
                   v.aireAcondicionado as vAire,
                   v.dirHidraulica as vHidraulica,
                   v.estadoFisicoDelVehiculo as vEstadoFisico,
                   v.disponibilidad as vDisponibilidad,
                   v.activo as vActivo,              /* AÑADIDO: Columna activo */
                   v.kilometraje as vKilometraje,
                   v.idModelo as vIdModelo,
                   v.idCombustible as vIdCombustible,
                   v.idGrupoVehiculo as vIdGrupo,
                   v.idSucursal as vIdSucursal,
                   m.nombreModelo as vModelo,
                   c.tipoCombustible as vCombustible,
                   g.nombreGrupo as vGrupo,
                   s.direccionSucursal as vSucursalDireccion,
                   s.ciudadSucursal as vSucursalCiudad
            FROM vehiculos v, modelos m, combustibles c, `grupos-vehiculos` g, sucursales s
            WHERE m.idModelo = v.idModelo 
            AND c.idCombustible = v.idCombustible 
            AND g.idGrupo = v.idGrupoVehiculo
            AND s.idSucursal = v.idSucursal 
            AND v.idVehiculo = $idVehiculo "; 

    $rs = mysqli_query($conexion, $SQL);

    if ($rs) {
        $vehiculo = mysqli_fetch_assoc($rs);
    } else {
        $mensajeError = "Error al consultar los datos del vehículo.";
        echo "<script>alert('$mensajeError'); window.location.href = 'OpVehiculos.php';</script>";
        exit();
    }
} 
else {
    header('Location: OpVehiculos.php');
    exit();
}

// Por último se hace UPDATE de los datos luego de cliquear el botón "Guardar Cambios" (los elementos POST proceden del form debajo)
$mensajeError = "";

// Manejo de la reactivación del vehículo con el botón específico
if (isset($_POST['BotonReactivar'])) {
    $idVehiculoReactivar = $_GET['id'];

    // Se cambia el estado a activo (1) y la disponibilidad a Sí ('S')
    $sqlUpdateReactivar = "UPDATE vehiculos SET activo = '1', disponibilidad = 'S' WHERE idVehiculo = $idVehiculoReactivar";
    $rsReactivar = mysqli_query($conexion, $sqlUpdateReactivar);

    if ($rsReactivar) {
        // Redirigir a OpVehiculos.php con el parámetro para mostrar el modal de reactivación exitosa.
        header('Location: OpVehiculos.php?reactivado=exito');
        exit();
    } else {
        $mensajeError = "Error al reactivar el vehículo: " . mysqli_error($conexion);
        echo "<script>alert('$mensajeError');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_POST['BotonModificarVehiculo'])) {

    // Primero capturo todos los valores del formulario
    $matricula = isset($_POST['Matricula']) ? $_POST['Matricula'] : $vehiculo['vMatricula'];
    $color = isset($_POST['Color']) ? $_POST['Color'] : $vehiculo['vColor'];
    $fechaCompra = isset($_POST['FechaCompra']) ? $_POST['FechaCompra'] : $vehiculo['vFechaCompra'];
    $precioCompra = isset($_POST['PrecioCompra']) ? $_POST['PrecioCompra'] : $vehiculo['vPrecioCompra'];
    $anio = isset($_POST['Anio']) ? $_POST['Anio'] : $vehiculo['vAnio'];

    // Validación: fecha de compra no puede ser anterior al año de fabricación
    if (!empty($fechaCompra) && !empty($anio) && is_numeric($anio)) {
        // Construimos el mínimo permitido: 1 de enero del año de fabricación
        $limiteInferior = DateTime::createFromFormat('Y-m-d', $anio . '-01-01');
        $compraDT = DateTime::createFromFormat('Y-m-d', $fechaCompra);

        if ($limiteInferior && $compraDT && $compraDT < $limiteInferior) {
            $mensajeError = "La fecha de compra ($fechaCompra) no puede ser anterior al año de fabricación ($anio).";
            echo "<script>alert('$mensajeError'); window.location.href = 'ModificarVehiculo.php?id=$idVehiculo';</script>";
            exit();
        }
    }

    $numeroMotor = isset($_POST['NumeroMotor']) ? $_POST['NumeroMotor'] : $vehiculo['vNumeroMotor'];
    $numeroChasis = isset($_POST['NumeroChasis']) ? $_POST['NumeroChasis'] : $vehiculo['vNumeroChasis'];
    $puertas = isset($_POST['Puertas']) ? $_POST['Puertas'] : $vehiculo['vNumeroPuertas'];

    // Validación del número de puertas
    if (!is_numeric($puertas) || $puertas < 1 || $puertas > 6) {
        $mensajeError = "El número de puertas debe ser un valor entre 1 y 6.";
        echo "<script>alert('$mensajeError'); window.location.href = 'ModificarVehiculo.php?id=$idVehiculo';</script>";
        exit();
    }

    $asientos = isset($_POST['Asientos']) ? $_POST['Asientos'] : $vehiculo['vNumeroAsientos'];

    // Validación del número de asientos
    if (!is_numeric($asientos) || $asientos < 1 || $asientos > 9) {
        $mensajeError = "El número de asientos debe ser un valor entre 1 y 9.";
        echo "<script>alert('$mensajeError'); window.location.href = 'ModificarVehiculo.php?id=$idVehiculo';</script>";
        exit();
    }

    $kilometraje = isset($_POST['Kilometraje']) ? $_POST['Kilometraje'] : $vehiculo['vKilometraje'];
    $estadoVehiculo = isset($_POST['EstadoVehiculo']) ? $_POST['EstadoVehiculo'] : $vehiculo['vEstadoFisico'];
    $idModelo = isset($_POST['IdModelo']) ? $_POST['IdModelo'] : $vehiculo['vIdModelo'];
    $idGrupo = isset($_POST['IdGrupo']) ? $_POST['IdGrupo'] : $vehiculo['vIdGrupo'];
    $idCombustible = isset($_POST['IdCombustible']) ? $_POST['IdCombustible'] : $vehiculo['vIdCombustible'];
    $idSucursal = isset($_POST['IdSucursal']) ? $_POST['IdSucursal'] : $vehiculo['vIdSucursal'];

    // Procesamiento de campos binarios
    $automatico = null;
    if ($_POST['Automatico'] == "S" || $_POST['Automatico'] == "N") {
        $automatico = $_POST['Automatico'];
    } 
    else {
        $automatico = null;
    }

    $aireAcondicionado = null;
    if ($_POST['AireAcondicionado'] == "S" || $_POST['AireAcondicionado'] == "N") {
        $aireAcondicionado = $_POST['AireAcondicionado'];
    } 
    else {
        $aireAcondicionado = null;
    }

    $direccionHidraulica = isset($_POST['DireccionHidraulica']) && in_array($_POST['DireccionHidraulica'], ['S', 'N']) ? $_POST['DireccionHidraulica'] : null;
    
    // Captura del estado 'activo'
    $activo = null;
    if (isset($_POST['Activo']) && ($_POST['Activo'] == '1' || $_POST['Activo'] == '0')) {
        $activo = $_POST['Activo'];
    }

    $disponibilidad = isset($_POST['Disponibilidad']) && in_array($_POST['Disponibilidad'], ['S', 'N']) ? $_POST['Disponibilidad'] : null;

    // **********************************************
    // MODIFICACIÓN CRÍTICA: LÓGICA DE CONSISTENCIA
    // **********************************************
    // Si el estado 'activo' viene del formulario y es '0' (inactivo)
    if (isset($_POST['Activo']) && $_POST['Activo'] === '0') {
        // Si el vehículo se marca como INACTIVO (0), su disponibilidad DEBE ser 'N'.
        $disponibilidad = 'N'; 
    }
    // **********************************************
    
    // MODIFICANDO el vehículo

    $SqlUpdate = "UPDATE vehiculos 
                                        SET matricula = '$matricula', 
                                            color = '$color',
                                            fechaCompra = '$fechaCompra', 
                                            precioCompra = '$precioCompra', 
                                            anio = '$anio', 
                                            numeroMotor = '$numeroMotor', 
                                            numeroChasis = '$numeroChasis', 
                                            puertas = '$puertas', 
                                            asientos = '$asientos', 
                                            kilometraje = '$kilometraje',
                                            idModelo = '$idModelo', 
                                            idGrupoVehiculo = '$idGrupo', 
                                            idCombustible = '$idCombustible',
                                            idSucursal = '$idSucursal',
                                            disponibilidad = '$disponibilidad', /* Esto usará 'N' si activo=0, o el valor del form si activo=1 */
                                            esAutomatico = '$automatico', 
                                            aireAcondicionado = '$aireAcondicionado', 
                                            dirHidraulica = '$direccionHidraulica', 
                                            activo = '$activo',                           
                                            estadoFisicoDelVehiculo = '$estadoVehiculo' 
                                        WHERE idVehiculo = $idVehiculo; "; 

    $rs = mysqli_query($conexion, $SqlUpdate);

    if ($rs) {
        // Redirigir a OpVehiculos.php consultando automáticamente el vehículo modificado por matrícula
        header("Location: OpVehiculos.php?modificado=exito&MatriculaVehiculo=" . urlencode($matricula));
        exit();
    } else {
        $mensajeError = "Error al modificar el vehículo: " . mysqli_error($conexion);
        echo "<script>alert('$mensajeError');</script>";
    }
}


?>

<body class="bg-light" style="margin: 0 auto;">

    <?php
    $tituloPagina = "MODIFICAR VEHÍCULO";
    require_once "topNavBar.php";
    require_once "sidebarGop.php";
    ?>

    <div class="container-fluid" style="margin-top: 8%; min-height: 80vh;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-4">
                    <h2 class="card-title text-center mb-4">Modificar Vehículo #<?php echo $idVehiculo; ?></h2>
                    <form method="post" action="ModificarVehiculo.php?id=<?php echo $idVehiculo; ?>">

                        <?php
                        // Variable para deshabilitar campos si el vehículo está inactivo
                        $disabled = (isset($vehiculo['vActivo']) && $vehiculo['vActivo'] == '0') ? 'disabled' : '';
                        ?>

                        <fieldset <?php echo $disabled; ?>>

                        <h5 class="mt-4 mb-3">Información General</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="matricula" class="form-label">Matrícula <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="matricula" name="Matricula" value="<?php echo htmlspecialchars($vehiculo['vMatricula']); ?>" maxlength="12" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" class="form-control" id="color" name="Color" value="<?php echo htmlspecialchars($vehiculo['vColor']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label>
                                <select class="form-select" id="modelo" name="IdModelo" required>
                                    <?php foreach ($ListadoModelo as $mod) : ?>
                                        <option value="<?php echo $mod['IdModelo']; ?>" <?php echo ($vehiculo['vIdModelo'] == $mod['IdModelo']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($mod['NombreModelo']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="grupo" class="form-label">Grupo <span class="text-danger">*</span></label>
                                <select class="form-select" id="grupo" name="IdGrupo" required>
                                    <?php foreach ($ListadoGrupo as $gru) : ?>
                                        <option value="<?php echo $gru['IdGrupo']; ?>" <?php echo ($vehiculo['vIdGrupo'] == $gru['IdGrupo']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($gru['NombreGrupo']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Detalles Técnicos</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="puertas" class="form-label">Puertas</label>
                                <input type="number" class="form-control" id="puertas" name="Puertas" value="<?php echo htmlspecialchars($vehiculo['vNumeroPuertas']); ?>" min="1" max="6">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="asientos" class="form-label">Asientos</label>
                                <input type="number" class="form-control" id="asientos" name="Asientos" value="<?php echo htmlspecialchars($vehiculo['vNumeroAsientos']); ?>" min="1" max="9">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="kilometraje" class="form-label">Kilometraje</label>
                                <input type="number" class="form-control" id="kilometraje" name="Kilometraje" value="<?php echo htmlspecialchars($vehiculo['vKilometraje']); ?>" min="0">
                            </div>
                        </div>
                        
                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label for="numeroMotor" class="form-label">Número de Motor</label>
                                <input type="text" class="form-control" id="numeroMotor" name="NumeroMotor" value="<?php echo htmlspecialchars($vehiculo['vNumeroMotor']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="numeroChasis" class="form-label">Número de Chasis</label>
                                <input type="text" class="form-control" id="numeroChasis" name="NumeroChasis" value="<?php echo htmlspecialchars($vehiculo['vNumeroChasis']); ?>">
                            </div>
                        </div>


                        <h5 class="mt-4 mb-3">Equipamiento</h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="automatico" class="form-label">Automático</label>
                                <select class="form-select" id="automatico" name="Automatico">
                                    <option value="">Selecciona una opción</option>
                                    <option value="S" <?php echo (isset($vehiculo['vAutomatico']) && $vehiculo['vAutomatico'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                    <option value="N" <?php echo (isset($vehiculo['vAutomatico']) && $vehiculo['vAutomatico'] == 'N') ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="aireacondicionado" class="form-label">Aire acondicionado</label>
                                <select class="form-select" id="aireacondicionado" name="AireAcondicionado">
                                    <option value="">Selecciona una opción</option>
                                    <option value="S" <?php echo (isset($vehiculo['vAire']) && $vehiculo['vAire'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                    <option value="N" <?php echo (isset($vehiculo['vAire']) && $vehiculo['vAire'] == 'N') ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="direccionhidraulica" class="form-label">Dirección hidráulica</label>
                                <select class="form-select" id="direccionhidraulica" name="DireccionHidraulica">
                                    <option value="">Selecciona una opción</option>
                                    <option value="S" <?php echo (isset($vehiculo['vHidraulica']) && $vehiculo['vHidraulica'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                    <option value="N" <?php echo (isset($vehiculo['vHidraulica']) && $vehiculo['vHidraulica'] == 'N') ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                             <div class="col-md-3 mb-3">
                                <label for="combustible" class="form-label">Combustible <span class="text-danger">*</span></label>
                                <select class="form-select" id="combustible" name="IdCombustible" required>
                                    <?php foreach ($ListadoCombustible as $com) : ?>
                                        <option value="<?php echo $com['IdCombustible']; ?>" <?php echo ($vehiculo['vIdCombustible'] == $com['IdCombustible']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($com['TipoCombustible']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Estado y Ubicación</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="disponibilidad" class="form-label">Disponibilidad para arrendar </label>
                                <select class="form-select" aria-label="Selector" id="disponibilidad" name="Disponibilidad" <?php echo (isset($vehiculo['vActivo']) && $vehiculo['vActivo'] == '0') ? 'disabled' : ''; ?>>
                                    <option value="">Selecciona una opción</option>
                                    <option value="S" <?php echo (isset($vehiculo['vDisponibilidad']) && $vehiculo['vDisponibilidad'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                    <option value="N" <?php echo (isset($vehiculo['vDisponibilidad']) && $vehiculo['vDisponibilidad'] == 'N') ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="estadoVehiculo" class="form-label">Estado Físico del Vehículo</label>
                                <input type="text" class="form-control" id="estadoVehiculo" name="EstadoVehiculo" value="<?php echo htmlspecialchars($vehiculo['vEstadoFisico']); ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sucursal" class="form-label">Sucursal Asignada <span class="text-danger">*</span></label>
                            <select class="form-select" aria-label="Selector" id="sucursal" name="IdSucursal" required>
                                <option value="">Selecciona una sucursal</option>
                                <?php 
                                if (!empty($sucursalesDisponibles)) {
                                    $selected = '';

                                    for ($i = 0; $i < $cantidadSucursales; $i++) {  
                                        // Lógica para verificar la sucursal seleccionada:
                                        $selected = (!empty($vehiculo['vIdSucursal']) && $vehiculo['vIdSucursal'] == $sucursalesDisponibles[$i]['IdSucursal']) ? 'selected' : '';
                                        // Generación de opciones:
                                        echo "<option value='{$sucursalesDisponibles[$i]['IdSucursal']}' $selected > 
                                                Ciudad: {$sucursalesDisponibles[$i]['CiudadSucursal']} - Dirección: {$sucursalesDisponibles[$i]['DireccionSucursal']} 
                                              </option>";
                                    }
                                } 
                                else {
                                    echo "<option value=''> No se encuentran sucursales disponibles. </option>";
                                }
                                ?>
                            </select>
                        </div>
                        

                        <h5 class="mt-4 mb-3">Datos de Adquisición</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="fechaCompra" class="form-label">Fecha de Compra</label>
                                <input type="date" class="form-control" id="fechaCompra" name="FechaCompra" value="<?php echo htmlspecialchars($vehiculo['vFechaCompra']); ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="precioCompra" class="form-label">Precio de Compra (USD)</label>
                                <input type="number" class="form-control" id="precioCompra" name="PrecioCompra" value="<?php echo htmlspecialchars($vehiculo['vPrecioCompra']); ?>" step="0.01" min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="anio" class="form-label">Año de Fabricación</label>
                                <input type="number" class="form-control" id="anio" name="Anio" value="<?php echo htmlspecialchars($vehiculo['vAnio']); ?>" min="1900" max="2050">
                            </div>
                        </div>

                        </fieldset>

                        <!-- Campo oculto para enviar el estado 'activo' actual del vehículo -->
                        <input type="hidden" name="Activo" value="<?php echo htmlspecialchars($vehiculo['vActivo']); ?>">

                        <br>
                        <div class="d-flex justify-content-start gap-2">
                            <?php if (isset($vehiculo['vActivo']) && $vehiculo['vActivo'] == '0') : ?>
                                <button type="submit" name="BotonReactivar" class="btn btn-success">Reactivar Vehículo</button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-dark" name="BotonModificarVehiculo" value="modificandoVehiculo">
                                    Guardar Cambios
                                </button>
                            <?php endif; ?>
                            <a href="OpVehiculos.php" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const activoSelect = document.getElementById('activo');
            const disponibilidadSelect = document.getElementById('disponibilidad');

            function updateDisponibilidadState() {
                // Si el estado seleccionado es Inactivo (0), deshabilitar la disponibilidad
                if (activoSelect.value === '0') {
                    disponibilidadSelect.disabled = true;
                    // Opcional: mostrar visualmente que se forzará a 'No'
                    disponibilidadSelect.value = 'N'; 
                } else {
                    disponibilidadSelect.disabled = false;
                    // Asegurarse de que el valor original se restaure si es necesario, aunque el PHP lo recalcula.
                    // Para el front, simplemente lo habilitamos.
                }
            }

            activoSelect.addEventListener('change', updateDisponibilidadState);

            // Ejecutar al cargar para manejar el estado inicial (si viene de la DB como inactivo)
            updateDisponibilidadState();
        });
    </script>
    
    
    <script>
    // script para validación de fecha de compra vs año de fabricación

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const fechaCompraInput = document.getElementById('fechaCompra');
        const anioInput = document.getElementById('anio');

        form.addEventListener('submit', function (e) {
            const fechaCompra = fechaCompraInput.value;      // formato YYYY-MM-DD
            const anioFab = parseInt(anioInput.value, 10);

            if (!isNaN(anioFab) && fechaCompra) {
                const limiteInferior = new Date(anioFab, 0, 1);     // 1 de enero del año de fabricación
                const compra = new Date(fechaCompra);

                if (compra < limiteInferior) {
                    e.preventDefault();
                    alert('La fecha de compra no puede ser anterior al año de fabricación.');
                    fechaCompraInput.focus();
                }
            }
        });
    });
    </script>

</body>
</html>