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

// Se asume que Listar_Clientes() está en funciones/Select_Tablas.php y no se usa directamente en el modal modificado.
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

        // Se elimina el código para mostrar el alert de $_GET['mensaje'] aquí.
        // Ahora se usa un modal al final del archivo.

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
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

            .input-group-append .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
            </style>

            <div class="filtro-consultas"
                style="margin-top: 20px;margin-bottom: 80px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #16719e; border-radius: 14px;">
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
                                <button type="submit" class="btn btn-info btn-filtrar" name="BotonFiltrar"
                                    value="FiltrandoReservas">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                                <button type="submit" class="btn btn-warning btn-filtrar" name="BotonLimpiarFiltros"
                                    value="LimpiandoFiltros">
                                    <i class="fas fa-ban"></i> Limpiar Filtros
                                </button>
                            </div>

                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" id="mostrarCanceladas"
                                    name="MostrarCanceladas" <?php echo $mostrarCanceladas ? 'checked' : ''; ?>>
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
                <div id="tablaReservasContenedor" class="table-responsive mt-4"
                    style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
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

                                // Definir la variable que se mostrará en la columna de número de reserva
                                $display_reserva = $ListadoReservas[$i]['idReserva'];
                                
                                ?>

                            <tr class='<?php echo $claseFila; ?>' data-id='<?php echo $ListadoReservas[$i]['idReserva']; ?>'
                                data-activo='<?php echo $activo; ?>'>


                                <td> <?php echo $display_reserva; ?> </td>

                                <td> <?php echo $ListadoReservas[$i]['apellidoCliente']; ?> </td>

                                <td> <?php echo $ListadoReservas[$i]['nombreCliente']; ?> </td>

                                <td> <?php echo $ListadoReservas[$i]['dniCliente']; ?> </td>

                                <td> <?php echo $ListadoReservas[$i]['vehiculoMatricula']; ?> </td>

                                <td> <?php echo $ListadoReservas[$i]['vehiculoGrupo']; ?> </td>

                                <td> <?php echo $ListadoReservas[$i]['vehiculoModelo']; ?> </td>

                                <td> <?php echo date('d/m/Y', strtotime($ListadoReservas[$i]['fechaInicioReserva'])); ?> </td>

                                <td> <?php echo date('d/m/Y', strtotime($ListadoReservas[$i]['fechaFinReserva'])); ?> </td>

                                <td>
                                    <span style="font-size: 12px;">
                                        <?php echo "$ {$ListadoReservas[$i]['precioPorDiaReserva']} USD/día <br>
                                                        {$ListadoReservas[$i]['cantidadDiasReserva']} días <br> 
                                                        Total: $ {$ListadoReservas[$i]['totalReserva']} USD";
                                            ?>
                                    </span>
                                </td>

                                <td>
                                    <span
                                        class="badge badge-<?php echo $ListadoReservas[$i]['ContratoColorAdvertencia']; ?>">
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
                <p class="btn no-btn-effect"
                    style="background-color: rgb(153, 6, 6); color: #ffffff; margin-left: 25px;">
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

                        <button type="button" class="btn btn-danger me-2" id="btnEliminar" onclick="eliminarReserva()"
                            disabled>
                            Cancelar
                        </button>

                        <a href="ReporteReservas.php"> <button class="btn btn-primary">
                                Imprimir
                            </button></a>
                    </div>
                </div>


                <div class="modal fade" id="nuevaReserva" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Agregar Nueva Reserva</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="Procesar_Nueva_Reserva.php" method="post"
                                onsubmit="return validarFechasReserva()">
                                <div class="modal-body">

                                    <input type="hidden" id="idCliente" name="idCliente" value="">

                                    <div class="mb-3">
                                        <label for="documentoCliente" class="form-label">Buscar Cliente (por Documento o Apellido)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="documentoCliente"
                                                name="documentoCliente"
                                                onkeyup="buscarClienteEnModal(this.value)"
                                                placeholder="Escribe para buscar..."
                                                autocomplete="off">
                                        </div>
                                        <!-- Contenedor para mostrar los resultados de la búsqueda -->
                                        <div id="cliente-search-results" class="list-group mt-1 position-absolute" style="z-index: 1056;"></div>
                                    </div>

                                    <!-- Estilos para alinear y dar formato a los resultados de búsqueda de clientes -->
                                    <style>
                                        #cliente-search-results .list-group-item {
                                            display: flex;
                                            flex-direction: column;
                                            justify-content: center;
                                            line-height: 1.3; /* Ajusta el espaciado entre líneas */
                                        }
                                        #cliente-search-results .list-group-item strong {
                                            /* Hereda la fuente y asegura la negrita */
                                            font-family: inherit;
                                            font-weight: 700;
                                        }
                                        #cliente-search-results .list-group-item small {
                                            /* Hereda la fuente, ajusta tamaño y color */
                                            font-family: inherit;
                                            font-size: 0.85em;
                                            color: #6c757d; /* Color gris secundario */
                                            margin-top: 2px; /* Añade un pequeño margen superior para separar del nombre */
                                        }
                                    </style>

                                    <div class="mb-3">
                                        <label for="apellidoCliente" class="form-label">Apellido *</label>
                                        <input type="text" class="form-control bg-light" id="apellidoCliente"
                                            name="apellidoCliente" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nombreCliente" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="nombreCliente" name="nombreCliente"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="idVehiculo" class="form-label">Vehículo *</label>
                                        <select class="form-select" aria-label="Selector" id="selectVehiculo"
                                            name="idVehiculo" required onchange="obtenerPrecioSugerido()">
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
                                        <label for="preciopordia" class="form-label">Precio por día *</label>
                                        <div class="input-container">
                                            <input type="number" min="20" max="1000" step="0.01" class="form-control"
                                                style="max-width: 120px;" id="inputPrecioPorDia" name="PrecioPorDia"
                                                title="Mínimo $ 20 USD y máximo 1000 USD" value="" required>
                                            <span style="padding: 0 0 0 10px;"> $ USD por día </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fecharetiro" class="form-label">Fecha de Retiro *</label>
                                        <input type="date" class="form-control" id="fecharetiro" name="fecharetiro"
                                            required>
                                        <div class="invalid-feedback" id="feedbackRetiro"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechadevolucion" class="form-label">Fecha de Devolución *</label>
                                        <input type="date" class="form-control" id="fechadevolucion"
                                            name="fechadevolucion" required>
                                        <div class="invalid-feedback" id="feedbackDevolucion"></div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal para Confirmar Cancelación -->
                <div class="modal fade" id="cancelarReservaModal" tabindex="-1"
                    aria-labelledby="cancelarReservaModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelarReservaModalLabel">Confirmar Cancelación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de que quieres CANCELAR esta reserva?</p>
                                <form id="formCancelarReserva">
                                    <div class="mb-3">
                                        <label for="comentarioCancelacion" class="form-label">Motivo de la cancelación
                                            (obligatorio):</label>
                                        <textarea class="form-control" id="comentarioCancelacion" name="comentario"
                                            rows="3" required></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-danger" onclick="confirmarCancelacion()">Confirmar
                                    Cancelación</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="confirmationModalBody">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                            </div>
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
    let reservaActivaEstado = null;
    const today = new Date().toISOString().split('T')[0];
    const MAX_DAYS = 30; // Nuevo límite de días

    // Desplazamiento vertical al listado luego de consulta
    function scrollToTable() {
        localStorage.setItem('scrollToTable', 'true');
    }

    document.addEventListener('DOMContentLoaded', () => {

        // LÓGICA DEL MODAL DE CONFIRMACIÓN (omito el código por simplicidad, se mantiene igual)
        const urlParams = new URLSearchParams(window.location.search);
        const mensaje = urlParams.get('mensaje');
        const status = urlParams.get('status');

        if (mensaje) {
            const modalElement = document.getElementById('confirmationModal');
            const modalTitle = document.getElementById('confirmationModalLabel');
            const modalBody = document.getElementById('confirmationModalBody');

            let titleText = "Notificación";
            let titleClass = "text-primary";

            if (status === 'success') {
                titleText = "¡Éxito!";
                titleClass = "text-success";
            } else if (status === 'error') {
                titleText = "Error";
                titleClass = "text-danger";
            }

            modalTitle.textContent = titleText;
            modalTitle.classList.add(titleClass);
            modalBody.textContent = decodeURIComponent(mensaje);

            const myModal = new bootstrap.Modal(modalElement);
            myModal.show();

            // Limpiar los parámetros de la URL para que el modal no se muestre al recargar
            if (window.history.replaceState) {
                const newUrl = window.location.protocol + "//" + window.location.host + window.location
                .pathname;
                window.history.replaceState({
                    path: newUrl
                }, '', newUrl);
            }
        }


        if (localStorage.getItem('scrollToTable') === 'true') {
            setTimeout(() => {
                document.getElementById('tablaReservasContenedor').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                localStorage.removeItem('scrollToTable');
            }, 500);
        }

        // Inicializar Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Selección de fila en la Tabla de Reservas al hacer clic en la misma
        document.querySelectorAll('#tablaReservas .reserva').forEach(row => {
            row.addEventListener('click', () => {
                document.querySelectorAll('.reserva').forEach(row => row.classList.remove(
                    'table-active'));
                row.classList.add('table-active');

                reservaSeleccionada = row.dataset.id;
                reservaActivaEstado = row.dataset.activo;

                document.getElementById('btnModificar').disabled = false;

                const btnCancelar = document.getElementById('btnEliminar');

                if (reservaActivaEstado === 'S') {
                    btnCancelar.disabled = false;
                    btnCancelar.textContent = "Cancelar";
                } else {
                    btnCancelar.disabled = true;
                    btnCancelar.textContent = "Cancelada";
                }
            });
        });

        // Inicializar el campo de fecha de retiro para que no permita fechas anteriores a hoy
        document.getElementById('fecharetiro').setAttribute('min', today);

        // Listener para actualizar el mínimo de fecha de devolución y activar validación de 30 días
        document.getElementById('fecharetiro').addEventListener('change', (e) => {
            const retiroDate = e.target.value;
            if (retiroDate) {
                const minDevolucionDate = new Date(retiroDate);
                minDevolucionDate.setDate(minDevolucionDate.getDate() + 1);
                document.getElementById('fechadevolucion').setAttribute('min', minDevolucionDate
                    .toISOString().split('T')[0]);
            }
            validarFechasReserva(); // Validar al cambiar la fecha de retiro
        });

        document.getElementById('fechadevolucion').addEventListener('change',
        validarFechasReserva); // Validar al cambiar la fecha de devolución
    });

    // Función de Validación de Fechas (Front-end) - ACTUALIZADA CON LÍMITE DE 30 DÍAS
    function validarFechasReserva() {
        const fechaRetiro = document.getElementById('fecharetiro');
        const fechaDevolucion = document.getElementById('fechadevolucion');
        let esValido = true;

        // Limpiar validaciones anteriores
        fechaRetiro.classList.remove('is-invalid');
        fechaDevolucion.classList.remove('is-invalid');
        document.getElementById('feedbackRetiro').textContent = '';
        document.getElementById('feedbackDevolucion').textContent = '';

        // 1. Validar que la fecha de retiro no sea anterior a hoy
        if (fechaRetiro.value < today) {
            fechaRetiro.classList.add('is-invalid');
            document.getElementById('feedbackRetiro').textContent = 'La fecha de retiro no puede ser anterior a hoy.';
            esValido = false;
        }

        if (!fechaRetiro.value || !fechaDevolucion.value) {
            return esValido;
        }

        const dateRetiro = new Date(fechaRetiro.value);
        const dateDevolucion = new Date(fechaDevolucion.value);

        // 2. Validar que la fecha de devolución sea posterior a la de retiro
        if (dateDevolucion <= dateRetiro) {
            fechaDevolucion.classList.add('is-invalid');
            document.getElementById('feedbackDevolucion').textContent =
                'La fecha de devolución debe ser posterior a la fecha de retiro.';
            esValido = false;
        }

        // 3. NUEVA VALIDACIÓN: Limite de 30 días
        const diffTime = Math.abs(dateDevolucion.getTime() - dateRetiro.getTime());
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > MAX_DAYS) {
            fechaDevolucion.classList.add('is-invalid');
            document.getElementById('feedbackDevolucion').textContent =
                `La duración máxima de una reserva es de ${MAX_DAYS} días. Su reserva dura ${diffDays} días.`;
            esValido = false;
        }

        return esValido;
    }


    // Función para redirigir a ModificarReserva.php con el ID del cliente seleccionado (omito por simplicidad)
    function modificarReserva() {
        if (reservaSeleccionada) {
            window.location.href = 'ModificarReserva.php?id=' + reservaSeleccionada;
        }
    }

    // Función para ABRIR el modal de cancelación
    function eliminarReserva() {
        if (reservaSeleccionada) {
            const cancelarModal = new bootstrap.Modal(document.getElementById('cancelarReservaModal'));
            cancelarModal.show();
        }
    }

    // Función para PROCESAR la cancelación desde el modal
    function confirmarCancelacion() {
        const comentarioInput = document.getElementById('comentarioCancelacion');
        const comentario = comentarioInput.value.trim();

        if (comentario === '') {
            alert('El motivo de la cancelación es obligatorio.');
            comentarioInput.focus();
        } else {
            const comentarioCodificado = encodeURIComponent(comentario);
            window.location.href = `EliminarReserva.php?id=${reservaSeleccionada}&comentario=${comentarioCodificado}`;
        }
    }

    // --- NUEVA LÓGICA DE BÚSQUEDA DE CLIENTES (SIN MODAL ANIDADO) ---

    /**
     * Busca clientes en tiempo real y muestra los resultados en una lista desplegable.
     */
    function buscarClienteEnModal(query) {
        const resultadosDiv = document.getElementById('cliente-search-results');
        if (query.trim().length < 2) { // Empezar a buscar después de 2 caracteres
            resultadosDiv.innerHTML = '';
            return;
        }

        // Usamos el mismo endpoint, pero ahora pasamos un parámetro genérico 'query'
        fetch(`funciones/Buscar_Cliente.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                resultadosDiv.innerHTML = ''; // Limpiar resultados anteriores
                if (data.length > 0) {
                    data.forEach(cliente => {
                        // Creamos un elemento 'a' por cada resultado
                        const item = document.createElement('a');
                        item.href = '#';
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.innerHTML = `<strong>${cliente.apellido}, ${cliente.nombre}</strong> <br><small>DNI: ${cliente.documento}</small>`;
                        
                        // Escapamos las comillas en los nombres/apellidos para evitar errores en el onclick
                        const safeApellido = cliente.apellido.replace(/'/g, "\\'");
                        const safeNombre = cliente.nombre.replace(/'/g, "\\'");

                        item.onclick = (e) => {
                            e.preventDefault();
                            seleccionarCliente(cliente.id, cliente.documento, safeApellido, safeNombre);
                        };
                        resultadosDiv.appendChild(item);
                    });
                } else {
                    resultadosDiv.innerHTML = '<span class="list-group-item disabled">No se encontraron clientes. Puede registrarlo.</span>';
                }
            })
            .catch(error => console.error('Error al buscar clientes:', error));
    }

    /**
     * Rellena los campos del formulario cuando se selecciona un cliente de la lista.
     */
    function seleccionarCliente(id, documento, apellido, nombre) {
        document.getElementById('idCliente').value = id;
        document.getElementById('documentoCliente').value = documento;
        document.getElementById('apellidoCliente').value = apellido;
        document.getElementById('nombreCliente').value = nombre;

        // Ocultar la lista de resultados
        document.getElementById('cliente-search-results').innerHTML = '';
    }

    function obtenerPrecioSugerido() {
    // 1. Obtener el ID del vehículo seleccionado
    const selectVehiculo = document.getElementById('selectVehiculo');
    const inputPrecio = document.getElementById('inputPrecioPorDia');
    const idVehiculo = selectVehiculo.value;

    // Si no hay vehículo seleccionado o la opción es inválida, limpiar el campo
    if (!idVehiculo || idVehiculo === "") {
        inputPrecio.value = '';
        return;
    }

    // 2. Realizar la solicitud AJAX al script PHP
    const formData = new FormData();
    formData.append('idVehiculo', idVehiculo);

    // Ruta al archivo que crearemos en el paso 3
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
        // 3. Procesar la respuesta
        if (data.success) {
            // Asignar el precio devuelto. Usamos toFixed(2) para 2 decimales.
            inputPrecio.value = parseFloat(data.precio).toFixed(2);
        } else {
            console.error('Error del servidor:', data.message);
            // Si hay un error, dejamos el campo vacío o con un valor por defecto
            inputPrecio.value = ''; 
        }
    })
    .catch(error => {
        console.error('Error de la solicitud AJAX:', error);
        inputPrecio.value = '';
        alert('Ocurrió un error al obtener el precio sugerido.');
    });
}

    </script>
</body>

</html>