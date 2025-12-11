<?php

session_start();

require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario();

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'numero' => isset($_GET['NumeroReserva']) ? trim($_GET['NumeroReserva']) : '',
    'matricula' => isset($_GET['MatriculaReserva']) ? trim($_GET['MatriculaReserva']) : '',
    'apellido' => isset($_GET['ApellidoReserva']) ? trim($_GET['ApellidoReserva']) : '',
    'nombre' => isset($_GET['NombreReserva']) ? trim($_GET['NombreReserva']) : '',
    'documento' => isset($_GET['DocReserva']) ? trim($_GET['DocReserva']) : '',
    'retirodesde' => isset($_GET['RetiroDesde']) ? trim($_GET['RetiroDesde']) : '',
    'retirohasta' => isset($_GET['RetiroHasta']) ? trim($_GET['RetiroHasta']) : '',
];

// Lógica de filtrado por estado 'activo'
$mostrarCanceladas = isset($_GET['MostrarCanceladas']) && $_GET['MostrarCanceladas'] == 'on';

// Si el checkbox está marcado, filtramos por 'N' (Cancelada). Por defecto, es 'S' (Activa).
// 'S' y 'N' se mapean a 1 y 0 respectivamente en CRUD-Reservas.php
$estadoReserva = $mostrarCanceladas ? 'N' : 'S'; 

// Generación del listado de reservas
require_once 'funciones/CRUD-Reservas.php';

// Se asume que Listar_Reservas() ahora acepta el parámetro $estadoReserva
$ListadoReservas = Listar_Reservas($conexion, $estadoReserva); 
$CantidadReservas = count($ListadoReservas);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    // Se asume que Procesar_ConsultaReservas() existe si es necesario
    // Procesar_ConsultaReservas(); 

    $ListadoReservas = array();
    $CantidadReservas = '';
    // Se pasa el nuevo parámetro $estadoReserva a la consulta
    $ListadoReservas = Consulta_Reservas($_GET['NumeroReserva'], $_GET['MatriculaReserva'], $_GET['ApellidoReserva'], $_GET['NombreReserva'], $_GET['DocReserva'], $_GET['RetiroDesde'], $_GET['RetiroHasta'], $conexion, $estadoReserva);
    $CantidadReservas = count($ListadoReservas);
} 

if (!empty($_GET['BotonLimpiarFiltros'])) {

    header('Location: reservas.php');
    die();
}


// SELECCIONES para combo boxes
require_once 'funciones/Select_Tablas.php';

$ListadoVehiculos = Listar_VehiculosReservados($conexion);
$CantidadVehiculos = count($ListadoVehiculos);

$ListadoClientes = Listar_Clientes($conexion);
$CantidadClientes = count($ListadoClientes);



include('head.php');

?>

<body>
    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php
        include('sidebarGOp.php');
        $tituloPagina = "RESERVAS";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <style>
                @keyframes fadeInUp {
                    from { opacity: 0; transform: translateY(30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .filtro-consultas {
                    transition: all 0.4s ease-in-out; 
                    border-radius: 15px; 
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); 
                    animation: fadeInUp 0.8s ease-in-out;
                }
                .filtro-consultas:hover {
                    transform: translateY(-5px); 
                    box-shadow: 0px 10px 20px rgba(198, 167, 31, 0.5);
                }
                .form-control {
                    transition: all 0.3s ease-in-out;
                    border: 1px solid;
                }
                .form-control:focus {
                    border: 2px solid rgb(160, 4, 4); 
                    box-shadow: rgba(152, 10, 10, 0.81);
                }
                .btn-filtrar {
                    transition: transform 0.3s ease-in-out;
                }
                .btn-filtrar:hover {
                    transform: scale(1.1); 
                }
            </style>

           <div class="filtro-consultas" style="margin-top: 20px;margin-bottom: 80px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #16719e; border-radius: 14px;">
    <div style='color: #0a8acf; margin-bottom: 30px;'>
        <h3 class="fw-bold"> Reservas </h3>
    </div>

    <form class="row g-3" action="reservas.php" method="get" onsubmit="scrollToTable()">

        <div class="col-md-2">
            <label for="numero" class="form-label">Número de Reserva</label>
            <input type="text" class="form-control" id="numero" name="NumeroReserva"
                value="<?= htmlspecialchars($filtros['numero']) ?>">
        </div>

        <div class="col-md-2">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="MatriculaReserva"
                value="<?= htmlspecialchars($filtros['matricula']) ?>">
        </div>

        <div class="col-md-2">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="ApellidoReserva"
                value="<?= htmlspecialchars($filtros['apellido']) ?>">
        </div>

        <div class="col-md-2">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="NombreReserva"
                value="<?= htmlspecialchars($filtros['nombre']) ?>">
        </div>

        <div class="col-md-2">
            <label for="documento" class="form-label">Documento</label>
            <input type="text" class="form-control" id="documento" name="DocReserva"
                value="<?= htmlspecialchars($filtros['documento']) ?>">
        </div>

        <div class="w-100"></div> 
        
        <div class="col-md-4">
            <label for="retiro" class="form-label">Retiro entre</label>
            <div class="d-flex">
                <input type="date" id="retirodesde" class="form-control me-2" name="RetiroDesde"
                    value="<?= htmlspecialchars($filtros['retirodesde']) ?>">

                <input type="date" id="retirohasta" class="form-control" name="RetiroHasta"
                    value="<?= htmlspecialchars($filtros['retirohasta']) ?>">
            </div>
        </div> 
        
        <div class="col-md-8 d-flex justify-content-end align-items-end mt-3" style="padding-top: 20px;">
            <div class="d-flex justify-content-between w-100">
                
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-info btn-filtrar" name="BotonFiltrar" value="FiltrandoReservas">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button type="submit" class="btn btn-warning btn-filtrar" name="BotonLimpiarFiltros" value="LimpiandoFiltros">
                        <i class="fas fa-ban"></i> Limpiar Filtros
                    </button>
                </div>
                
                <div class="form-check d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="mostrarCanceladas" name="MostrarCanceladas" 
                        <?php echo $mostrarCanceladas ? 'checked' : ''; ?>>
                    <label class="form-check-label ms-2" for="mostrarCanceladas">
                        Mostrar reservas canceladas
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>

            <div style="padding-bottom: 100px;">

                <h3 class="fw-bold" style="margin-top: 5%;"> Listado de Reservas </h3>
                <div id="tablaReservasContenedor" class="table-responsive mt-4" style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover" id="tablaReservas">
                        <thead>
                            <tr>
                                <th>Número Reserva</th>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Matrícula</th>
                                <th>Grupo</th>
                                <th>Modelo</th>
                                <th>Fec. Ret.</th>
                                <th>Fec. Dev.</th>
                                <th>Montos</th>
                                <th>Contrato</th>
                                <th>Activo</th> 
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            for ($i = 0; $i < $CantidadReservas; $i++) { 
                                
                                // Lógica de estado 'activo' y comentario
                                $activo = $ListadoReservas[$i]['activo'] ?? 'S'; // 'S' o 'N'
                                $esActiva = ($activo === 'S');
                                $estadoColor = $esActiva ? 'success' : 'danger';
                                $estadoTexto = $esActiva ? 'Activa' : 'Cancelada';
                                $claseFila = $esActiva ? 'reserva' : 'reserva table-secondary';
                                $comentario = htmlspecialchars($ListadoReservas[$i]['comentario'] ?? '');
                                
                                // Determinar el tooltip (solo para canceladas)
                                $tooltip = '';
                                if (!$esActiva && !empty($comentario)) {
                                    $tooltip = "data-bs-toggle='tooltip' data-bs-placement='top' data-bs-html='true' title='**Motivo de Cancelación**:<br>{$comentario}'";
                                }
                                
                                ?>

                                <tr class='<?php echo $claseFila; ?>' 
                                    data-id='<?php echo $ListadoReservas[$i]['idReserva']; ?>'
                                    data-activo='<?php echo $activo; ?>'
                                >

                                    
                                    <td> <?php echo $ListadoReservas[$i]['numeroReserva']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['apellidoCliente']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['nombreCliente']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['dniCliente']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['vehiculoMatricula']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['vehiculoGrupo']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['vehiculoModelo']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['fechaInicioReserva']; ?> </td>

                                    <td> <?php echo $ListadoReservas[$i]['fechaFinReserva']; ?> </td>

                                    <td>
                                        <span style="font-size: 12px;">
                                            <?php echo "$ {$ListadoReservas[$i]['precioPorDiaReserva']} USD/día <br>
                                                        {$ListadoReservas[$i]['cantidadDiasReserva']} días <br> 
                                                        Total: $ {$ListadoReservas[$i]['totalReserva']} USD";
                                            ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-<?php echo $ListadoReservas[$i]['ContratoColorAdvertencia']; ?>">
                                            <?php echo $ListadoReservas[$i]['ContratoAsociado']; ?>
                                        </span><br><br>
                                        <span>Ver contrato: </span>
                                        <span class='badge badge-warning'> 
                                            <?php
                                            if ($ListadoReservas[$i]['idContrato'] == "No existe") {
                                                echo $ListadoReservas[$i]['idContrato']; 
                                            } 
                                            else {
                                                echo "<a href='contratosAlquiler.php?NumeroContrato={$ListadoReservas[$i]['idContrato']}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos'>ID: {$ListadoReservas[$i]['idContrato']}</a>"; 
                                            } 
                                            ?>
                                        </span>

                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo $estadoColor; ?>" <?php echo $tooltip; ?>>
                                            <?php echo $estadoTexto; ?>
                                        </span>
                                    </td>
                                    
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <br><br>

                <style>
                    .no-btn-effect {
                        pointer-events: none; 
                        box-shadow: none !important; 
                        cursor: default !important; 
                        border: none; 
                    }
                </style>
                <p class="btn no-btn-effect" style="background-color: rgb(153, 6, 6); color: #ffffff; margin-left: 25px;">
                    Total de registros encontrados: <?php echo $CantidadReservas; ?>
                </p>


                <div style="margin-top: 8%;">
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#nuevaReserva">
                            <i class="fas fa-plus-circle"></i> Nueva
                        </button>

                        <button class="btn btn-warning me-2" id="btnModificar" onclick="modificarReserva()" disabled>
                            Modificar
                        </button>

                        <button type="button" class="btn btn-danger me-2" id="btnEliminar" onclick="eliminarReserva()" disabled>
                            Cancelar
                        </button>

                        <a href="ReporteReservas.php"> <button class="btn btn-primary">
                                Imprimir
                            </button></a>
                    </div>
                </div>


                <div class="modal fade" id="nuevaReserva" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Agregar Nueva Reserva</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form action="Nueva_Reserva.php" method="post">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="idCliente" class="form-label">Cliente</label>
                                        <select class="form-select" aria-label="Selector" id="selector" name="idCliente" required>
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php
                                            if (!empty($ListadoClientes)) {
                                                $selected = '';
                                                for ($i = 0; $i < $CantidadClientes; $i++) {
                                                    $selected = (!empty($_POST['idCliente']) && $_POST['idCliente'] == $ListadoClientes[$i]['idCliente']) ? 'selected' : '';
                                                    echo "<option value='{$ListadoClientes[$i]['idCliente']}' $selected> 
                                                        {$ListadoClientes[$i]['apellidoCliente']} {$ListadoClientes[$i]['nombreCliente']} ({$ListadoClientes[$i]['dniCliente']}) <br> 
                                                        TEL: {$ListadoClientes[$i]['telefonoCliente']} 
                                                    </option>";
                                                }
                                            } else {
                                                echo "<option value=''>No se encontraron clientes</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="numreserva" class="form-label">Número de reserva</label>
                                        <input type="text" class="form-control" id="numreserva" name="numreserva" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="idVehiculo" class="form-label">Vehículo</label>
                                        <select class="form-select" aria-label="Selector" id="selector" name="idVehiculo" required>
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php
                                            if (!empty($ListadoVehiculos)) {
                                                $selected = '';
                                                for ($i = 0; $i < $CantidadVehiculos; $i++) {
                                                    $selected = (!empty($_POST['idVehiculo']) && $_POST['idVehiculo'] == $ListadoVehiculos[$i]['IdVehiculo']) ? 'selected' : '';
                                                    echo "<option value='{$ListadoVehiculos[$i]['IdVehiculo']}' $selected> {$ListadoVehiculos[$i]['matricula']} - {$ListadoVehiculos[$i]['modelo']} - {$ListadoVehiculos[$i]['grupo']}  </option>";
                                                }
                                            } else {
                                                echo "<option value=''>No se encontraron vehículos</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <style>
                                        .input-container {

                                            display: flex;
                                            align-items: center;
                                        }
                                    </style>

                                    <div class="mb-3">
                                        <label for="preciopordia" class="form-label">Precio por día</label>
                                        <div class="input-container">
                                            <input type="number" min="20" max="1000" step="0.01" class="form-control" style="max-width: 120px;"
                                                id="preciopordia" name="PrecioPorDia" title="Mínimo $ 20 USD y máximo 1000 USD"
                                                value="" required>
                                            <span style="padding: 0 0 0 10px;"> $ USD por día </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecharetiro" class="form-label">Fecha de Retiro</label>
                                        <input type="date" class="form-control" id="fecharetiro" name="fecharetiro" value="" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechadevolucion" class="form-label">Fecha de Devolución</label>
                                        <input type="date" class="form-control" id="fechadevolucion" name="fechadevolucion" value="" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div>
            <?php require_once "foot.php"; ?>
        </div>
    </div>


    <script>

        let reservaSeleccionada = null;
        // Nueva variable para almacenar el estado de la reserva seleccionada ('S' o 'N')
        let reservaActivaEstado = null; 

        // Desplazamiento vertical al listado luego de consulta
        function scrollToTable() {
            localStorage.setItem('scrollToTable', 'true'); // Guardar indicador antes de enviar
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('scrollToTable') === 'true') {
                setTimeout(() => {
                    document.getElementById('tablaReservasContenedor').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
                }, 500); 
            }
            
            // Inicializar Tooltips de Bootstrap (Necesario para el Tooltip condicional)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Selección de fila en la Tabla de Reservas al hacer clic en la misma
            document.querySelectorAll('#tablaReservas .reserva').forEach(row => {
                row.addEventListener('click', () => {
                    // Desmarcar cualquier fila previamente seleccionada
                    document.querySelectorAll('.reserva').forEach(row => row.classList.remove('table-active'));
                    // Marcar la fila seleccionada
                    row.classList.add('table-active');
                    
                    reservaSeleccionada = row.dataset.id;
                    // CAPTURAR EL ESTADO ACTIVO/CANCELADO de la fila
                    reservaActivaEstado = row.dataset.activo; 
                    
                    // Habilitar el botón Modificar (siempre permitido)
                    document.getElementById('btnModificar').disabled = false;
                    
                    // Lógica para habilitar/deshabilitar el botón CANCELAR
                    const btnCancelar = document.getElementById('btnEliminar');

                    if (reservaActivaEstado === 'S') {
                        // Si la reserva está activa, se puede cancelar
                        btnCancelar.disabled = false; 
                        btnCancelar.textContent = "Cancelar";
                    } else {
                        // Si la reserva ya está cancelada ('N'), se deshabilita el botón
                        btnCancelar.disabled = true; 
                        btnCancelar.textContent = "Cancelada"; // Feedback visual
                    }
                });
            });
        });

        // Función para redirigir a ModificarReserva.php con el ID del cliente seleccionado
        function modificarReserva() {
            if (reservaSeleccionada) {
                window.location.href = 'ModificarReserva.php?id=' + reservaSeleccionada;
            }
        }

        // Función para CANCELAR la reserva (Eliminación Lógica)
        function eliminarReserva() {
            // Se asume que el botón está habilitado (reservaActivaEstado === 'S') al llegar aquí
            if (reservaSeleccionada) {
                
                // 1. Confirmar la acción
                if (confirm('¿Estás seguro de que quieres CANCELAR esta reserva?')) {
                    
                    let comentario = null;
                    let esValido = false;

                    // 2. Bucle para solicitar el comentario hasta que sea válido o el usuario cancele
                    while (!esValido) {
                        // Usamos prompt() para solicitar el comentario
                        comentario = prompt('⚠️ Ingrese el motivo de la cancelación (campo obligatorio):');

                        if (comentario === null) {
                            // El usuario presionó "Cancelar" en el prompt. Detener el proceso.
                            return; 
                        }

                        // Verificar si el comentario está vacío después de quitar espacios
                        if (comentario.trim() === '') {
                            alert('El motivo de la cancelación es obligatorio. Por favor, ingrese un comentario válido.');
                        } else {
                            esValido = true; // El comentario es válido (no nulo y no vacío).
                        }
                    }
                    
                    // 3. Procesar la cancelación con el comentario válido
                    // Codificar el comentario para que pueda viajar seguro en la URL
                    let comentarioCodificado = encodeURIComponent(comentario.trim());

                    // 4. Redirigir a EliminarReserva.php enviando el ID y el comentario
                    window.location.href = 'EliminarReserva.php?id=' + reservaSeleccionada + '&comentario=' + comentarioCodificado;
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    
</body>

</html>