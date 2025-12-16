<?php

session_start();

require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario();

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Obtener filtros del formulario
$filtros = [
    'numero' => isset($_GET['NumeroContrato']) ? trim($_GET['NumeroContrato']) : '',
    'matricula' => isset($_GET['MatriculaContrato']) ? trim($_GET['MatriculaContrato']) : '',
    'apellido' => isset($_GET['ApellidoContrato']) ? trim($_GET['ApellidoContrato']) : '',
    'nombre' => isset($_GET['NombreContrato']) ? trim($_GET['NombreContrato']) : '',
    'documento' => isset($_GET['DocContrato']) ? trim($_GET['DocContrato']) : '',
    'estado' => isset($_GET['EstadoContrato']) ? trim($_GET['EstadoContrato']) : '',
    'preciodia' => isset($_GET['PrecioDiaContrato']) ? trim($_GET['PrecioDiaContrato']) : '',
    'cantidaddias' => isset($_GET['CantidadDiasContrato']) ? trim($_GET['CantidadDiasContrato']) : '',
    'montototal' => isset($_GET['MontoTotalContrato']) ? trim($_GET['MontoTotalContrato']) : '',
    'retirodesde' => isset($_GET['RetiroDesde']) ? trim($_GET['RetiroDesde']) : '',
    'retirohasta' => isset($_GET['RetiroHasta']) ? trim($_GET['RetiroHasta']) : '',
    'devoluciondesde' => isset($_GET['DevolucionDesde']) ? trim($_GET['DevolucionDesde']) : '',
    'devolucionhasta' => isset($_GET['DevolucionHasta']) ? trim($_GET['DevolucionHasta']) : '',
];


// Generación del listado de contratos
require_once 'funciones/CRUD-Contratos.php';
$ListadoContratos = Listar_Contratos($conexion);
$CantidadContratos = count($ListadoContratos);


// Consulta por medio de formulario de Filtro
if (!empty($_GET['BotonFiltrar'])) {

    // require_once 'funciones/vehiculo consulta.php';
    Procesar_ConsultaContratos();

    $ListadoContratos = array();
    $CantidadContratos = '';
    $ListadoContratos = Consulta_Contratos($_GET['NumeroContrato'], $_GET['MatriculaContrato'], $_GET['ApellidoContrato'], $_GET['NombreContrato'], $_GET['DocContrato'], $_GET['EstadoContrato'], $_GET['PrecioDiaContrato'], $_GET['CantidadDiasContrato'], $_GET['MontoTotalContrato'], $_GET['RetiroDesde'], $_GET['RetiroHasta'], $_GET['DevolucionDesde'], $_GET['DevolucionHasta'], $conexion);
    $CantidadContratos = count($ListadoContratos);
} else {

    // Listo la totalidad de los registros en la tabla "contratos". 
    $ListadoContratos = Listar_Contratos($conexion);
    $CantidadContratos = count($ListadoContratos);
}

if (!empty($_GET['BotonLimpiarFiltros'])) {

    header('Location: contratosAlquiler.php');
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

<body style="margin: 0 auto;">

    <style>
    .form-control:focus {
        border-color: #c7240e;
    }
    </style>

    <div class="wrapper" style="margin-bottom: 100px; min-height: 100%;">

        <?php
        include('sidebarGOp.php');
        $tituloPagina = "CONTRATOS";
        include('topNavBar.php');

        if (isset($_GET['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_GET['mensaje'] . '</div>';
        }

        ?>

        <div class="container" style="margin-top: 10%; margin-left: 1%; margin-right: 1%;">

            <!-- Algunos efectos moderno para el form de consultas ;) -->
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
                /* Hace que el cuadro "aparezca suavemente" */
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
                /* Resalta con dorado */
                box-shadow: rgba(152, 10, 10, 0.81);
            }

            .btn-filtrar {
                transition: transform 0.3s ease-in-out;
            }

            .btn-filtrar:hover {
                transform: scale(1.1);
                /* Botón se agranda ligeramente */
            }
            </style>

            <div class="filtro-consultas"
                style="margin-top: 20px; margin-bottom: 50px; padding: 35px; max-width: 97%; background-color: white; border: 1px solid #c7240e; border-radius: 14px;">
                <div style='color: #c7240e; margin-bottom: 30px;'>
                    <h3 class="fw-bold"> Contratos </h3>
                </div>

                <!-- Formulario de filtros -->
                <form class="row g-3" action="contratosAlquiler.php" method="get" onsubmit="scrollToTable()">

                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número de Contrato</label>
                        <input type="text" class="form-control" id="numero" name="NumeroContrato"
                            value="<?= htmlspecialchars($filtros['numero']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control" id="matricula" name="MatriculaContrato"
                            value="<?= htmlspecialchars($filtros['matricula']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="ApellidoContrato"
                            value="<?= htmlspecialchars($filtros['apellido']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="NombreContrato"
                            value="<?= htmlspecialchars($filtros['nombre']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="DocContrato"
                            value="<?= htmlspecialchars($filtros['documento']) ?>">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-2">
                        <label for="estado" class="form-label">Estado del Contrato</label>
                        <input type="text" class="form-control" id="estado" name="EstadoContrato"
                            value="<?= htmlspecialchars($filtros['estado']) ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="preciodia" class="form-label">Precio por día</label>
                        <input type="number" min="20" max="999999999" step="0.01" class="form-control" id="preciodia"
                            name="PrecioDiaContrato" value="<?= htmlspecialchars($filtros['preciodia']) ?>"
                            title="Filtrar por precio hasta los...">
                    </div>

                    <?php
                    $minCantDias = 1;
                    $maxCantDias = 45;
                    ?>
                    <div class="col-md-2">
                        <label for="cantidaddias" class="form-label">Cantidad de días</label>
                        <input type="number" min="<? echo $minCantDias; ?>" max="<?php echo $maxCantDias; ?>"
                            class="form-control" id="cantidaddias" name="CantidadDiasContrato"
                            value="<?= htmlspecialchars($filtros['cantidaddias']) ?>"
                            title="Cantidad exacta de días entre 1 y 45">
                    </div>

                    <div class="col-md-2">
                        <label for="montototal" class="form-label">Monto total</label>
                        <input type="number" min="20" max="999999999" step="0.01" class="form-control" id="montototal"
                            name="MontoTotalContrato" value="<?= htmlspecialchars($filtros['montototal']) ?>"
                            title="Filtrar por monto total hasta los...">
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="col-md-4">
                        <label for="retiro" class="form-label">Fecha de Inicio del contrato entre</label>
                        <div class="d-flex">
                            <input type="date" id="retirodesde" class="form-control me-2" name="RetiroDesde"
                                value="<?= htmlspecialchars($filtros['retirodesde']) ?>">

                            <input type="date" id="retirohasta" class="form-control" name="RetiroHasta"
                                value="<?= htmlspecialchars($filtros['retirohasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="devolucion" class="form-label">Fecha de Finalización del contrato entre</label>
                        <div class="d-flex">
                            <input type="date" id="devoluciondesde" class="form-control me-2" name="DevolucionDesde"
                                value="<?= htmlspecialchars($filtros['devoluciondesde']) ?>">

                            <input type="date" id="devolucionhasta" class="form-control" name="DevolucionHasta"
                                value="<?= htmlspecialchars($filtros['devolucionhasta']) ?>">
                        </div>
                    </div>

                    <div class="col-md-2">
                    </div>

                    <div class="w-100"></div> <!-- salto de linea -->
                    <div class="d-flex flex-wrap justify-content-between align-items-end mt-3">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" style="background-color: #c7240e; color: white;"
                                class="btn btn-filtrar" name="BotonFiltrar" value="FiltrandoContratos">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button type="submit" class="btn btn-warning btn-filtrar" name="BotonLimpiarFiltros"
                                value="LimpiandoFiltros">
                                <i class="fas fa-ban"></i> Limpiar Filtros
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <div style="padding-bottom: 100px;">

                <!-- Listado de contratos -->
                <h3 class="fw-bold" style="margin-top: 5%;"> Listado de Contratos </h3>
                <div id="tablaContratosContenedor" class="table-responsive mt-4"
                    style="max-width: 97%; max-height: 700px; border: 1px solid #444444; border-radius: 14px;">
                    <table class="table table-striped table-hover" id="tablaContratos">
                        <thead>
                            <tr>
                                <!-- <th style='color: #c7240e;'>
                                    <h3>#</h3>
                                </th> -->
                                <th>Número Contrato</th>
                                <th>Estado Contrato</th>

                                <th
                                    title="Fecha de inicio del contrato. No corresponde necesariamente con la fecha de entrega del vehículo. Formato de fecha: YYYY/mm/dd">
                                    Inicio Contrato
                                </th>
                                <th
                                    title="Fecha de finalización del contrato. No corresponde necesariamente con la fecha de devolución del vehículo. Formato de fecha: YYYY/mm/dd">
                                    Finalización Contrato
                                </th>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Matrícula</th>
                                <th>Vehiculo</th>
                                <th>Oficina Ret.</th>
                                <th>Oficina Dev.</th>
                                <th>Precio día</th>
                                <th>Cantidad días</th>
                                <th>Monto total</th>
                                <th>Ver reserva</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $contador = 1;


                            for ($i = 0; $i < $CantidadContratos; $i++) { ?>

                            <tr class='contrato' data-id='<?php echo $ListadoContratos[$i]['IdContrato']; ?>'
                                onclick="selectRow(this, '<?= $ListadoContratos[$i]['IdContrato'] ?>')">

                                <!-- <td><span style='color: #c7240e;'>
                                            <h4> <?php echo $contador; ?> </h4>
                                        </span></td> -->

                                <td> <?php echo $ListadoContratos[$i]['IdContrato']; ?> </td>
                                <td><?php
                                        $estado = strtolower($ListadoContratos[$i]['EstadoContrato']);
                                        $clase = '';

                                        switch ($estado) {
                                            case 'firmado':
                                                $clase = 'primary'; // azul
                                                break;
                                            case 'activo':
                                                $clase = 'success'; // verde
                                                break;
                                            case 'cancelado':
                                                $clase = 'danger'; // rojo
                                                break;
                                            case 'finalizado':
                                                $clase = 'warning'; // naranja
                                                break;
                                            case 'renovado':
                                                $clase = 'secondary'; // púrpura
                                                break;
                                            default:
                                                $clase = 'info'; // celeste
                                                break;
                                        }
                                        echo "<span class='badge badge-$clase'>" . $ListadoContratos[$i]['EstadoContrato'] . "</span>"; ?>
                                </td>
                                <td
                                    title="Fecha de inicio del contrato. No corresponde necesariamente con la fecha de entrega del vehículo. Formato de fecha: YYYY/mm/dd">
                                    <?php echo date('d/m/Y', strtotime($ListadoContratos[$i]['FechaInicioContrato'])); ?>
                                </td>
                                <td
                                    title="Fecha de finalización del contrato. No corresponde necesariamente con la fecha de devolución del vehículo. Formato de fecha: YYYY/mm/dd">
                                    <?php echo date('d/m/Y', strtotime($ListadoContratos[$i]['FechaFinContrato'])); ?>
                                </td>
                                <td> <?php echo $ListadoContratos[$i]['apellidoCliente']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['nombreCliente']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['dniCliente']; ?> </td>
                                <td> <?php echo $ListadoContratos[$i]['vehiculoMatricula']; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['vehiculoModelo']}, {$ListadoContratos[$i]['vehiculoGrupo']}"; ?>
                                </td>
                                <td> <?php echo "{$ListadoContratos[$i]['CiudadSucursal']}, {$ListadoContratos[$i]['DireccionSucursal']}"; ?>
                                </td>
                                <td> <?php echo "{$ListadoContratos[$i]['CiudadSucursal']}, {$ListadoContratos[$i]['DireccionSucursal']}"; ?>
                                </td>
                                <td> <?php echo "{$ListadoContratos[$i]['PrecioPorDiaContrato']} US$"; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['CantidadDiasContrato']} días"; ?> </td>
                                <td> <?php echo "{$ListadoContratos[$i]['MontoTotalContrato']} US$"; ?> </td>
                                <td>
                                    <?php
                                        if ($ListadoContratos[$i]['IdReserva'] == "No existe") {
                                            echo "<span class='badge badge-danger'>{$ListadoContratos[$i]['NumReserva']}</span>";
                                        } else {
                                            echo "<span class='badge badge-warning'><a href='reservas.php?NumeroReserva={$ListadoContratos[$i]['NumReserva']}&MatriculaReserva=&ApellidoReserva=&NombreReserva=&DocReserva=&RetiroDesde=&RetiroHasta=&BotonFiltrar=FiltrandoReservas'>Nº: {$ListadoContratos[$i]['NumReserva']}</a></span>";
                                        }
                                        ?>
                                </td>
                            </tr>
                            <?php $contador++; ?>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

                <br><br>
                <!-- Recuadro con cantidad total de registros encontrados -->
                <style>
                .no-btn-effect {
                    pointer-events: none;
                    /* Evita que se comporte como un botón */
                    box-shadow: none !important;
                    cursor: default !important;
                    /* Hace que el cursor no cambie */
                    border: none;
                }
                </style>
                <p class="btn no-btn-effect"
                    style="background-color: rgb(153, 6, 6); color: #ffffff; margin-left: 25px;">
                    Total de registros encontrados: <?php echo $CantidadContratos; ?>
                </p>


                <!-- Botones de acción -->
                <div>
                    <div class="container d-flex justify-content-center">

                        <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
                            <i class="fas fa-plus-circle"></i> Nuevo
                        </button>

                        <button class="btn btn-warning me-2" id="btnModificar" onclick="modificarContrato()" disabled>
                            Modificar
                        </button>

                        <!-- <button class="btn btn-danger me-2" id="btnEliminar" onclick="eliminarContrato()" disabled>
                            Eliminar
                        </button> -->

                        <a href="ReporteContratos.php"> <button class="btn btn-primary">
                                Imprimir
                            </button></a>
                    </div>

                </div>

                <!-- Reportes estadísticos -->
                <div style="margin: auto; max-width: 95%; padding: 150px 0 5px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h2 class="mb-1 " style="padding: 0; margin: 10px 0 0 0;">
                            <strong style="color: #a80a0a;">Reportes Estadísticos</strong>
                        </h2>
                    </div>
                </div>

                <style>
                .hoverImage {
                    position: relative;
                    align-self: stretch;
                    height: 650px;
                    flex-shrink: 0;
                    object-fit: cover;
                    border-radius: 10px;
                    max-width: 100%;
                }

                .centrar {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                </style>

                <div style="margin: auto; max-width: 95%; padding: 10px 0 40px 0;">
                    <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
                        <h4 class="mb-1 " style="padding: 0; margin: 30px 0 0 0;">
                            <strong style="color: #a80a0a;">Reporte:</strong> Contratos por mes
                            segmentados por estado </a>
                        </h4>


                        <div class="mb-1 hoverImageWrapper centrar" style="padding: 0; margin: 50px 0 0 0;">
                            <img class="hoverImage" src="assets/img/reports/reporte-contratosmensualesestados.jpeg"
                                alt="Contratos por mes segmentados por estado"
                                style="max-width: 99%; border-radius: 25px;">
                        </div>
                        </a>

                        <style>
                        .btn-inversion {
                            padding-left: 30px;
                            padding-right: 30px;
                            background-color: #262626;
                            color: #e04709;
                            font-weight: 500;
                            border: 1px solid #d64004;
                            border-radius: 20px;

                            transition: all 0.5s ease-in-out;
                            -webkit-transition: all 0.5s ease-in-out;
                            -moz-transition: all 0.5s ease-in-out;
                            -o-transition: all 0.5s ease-in-out;
                        }

                        .btn-inversion:hover {
                            background-color: #a80a0a;
                            color: white;
                            font-weight: 100;
                            border: 1px solid #a80a0a;
                        }
                        </style>

                        <div class="container d-flex justify-content-center" style="margin: 70px 0 50px 0;">
                            <!-- Dropdown de selección de año -->
                            <select id="anioSeleccionado" class="form-select me-3" style="width: auto;">
                                <option value="2023">2023</option>
                                <option value="2024" selected>2024</option>
                                <option value="2025">2025</option>
                            </select>

                            <!-- Botón con link dinámico -->
                            <a id="reporteLink" href="ReporteContratos_FrecMensuales.php?anio=2024">
                                <button class="btn btn-inversion">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bar-chart" viewBox="0 0 16 16">
                                        <path
                                            d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
                                    </svg>
                                    Reporte
                                </button>
                            </a>
                        </div>

                    </div>
                </div>


                <!-- Modal para Nuevo Contrato -->
                <div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="nuevoRegistroModalLabel">Agregar Nuevo Contrato</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="Nuevo_Contrato.php" method="post">
                                <div class="modal-body">

                                    <!-- Campo oculto para almacenar el ID del cliente seleccionado -->
                                    <input type="hidden" id="idClienteNuevoContrato" name="idCliente" value="">

                                    <div class="mb-3">
                                        <label for="buscadorClienteContrato" class="form-label">Buscar Cliente (por DNI o Apellido)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="buscadorClienteContrato"
                                                onkeyup="buscarClienteEnModal(this.value, 'cliente-search-results-contrato')"
                                                placeholder="Escribe para buscar..." autocomplete="off" required>
                                        </div>
                                        <!-- Contenedor para los resultados de búsqueda -->
                                        <div id="cliente-search-results-contrato" class="list-group mt-1 position-absolute" style="z-index: 1056;"></div>
                                    </div>

                                    <!-- Estilos para los resultados de búsqueda (igual que en reservas) -->
                                    <style>
                                        #cliente-search-results-contrato .list-group-item { display: flex; flex-direction: column; justify-content: center; line-height: 1.3; }
                                        #cliente-search-results-contrato .list-group-item strong { font-family: inherit; font-weight: 700; }
                                        #cliente-search-results-contrato .list-group-item small { font-family: inherit; font-size: 0.85em; color: #6c757d; margin-top: 2px; }
                                    </style>

                                    <div class="mb-3">
                                        <label for="apellidoClienteContrato" class="form-label">Apellido</label>
                                        <input type="text" class="form-control bg-light" id="apellidoClienteContrato" name="apellidoCliente" readonly required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nombreClienteContrato" class="form-label">Nombre</label>
                                        <input type="text" class="form-control bg-light" id="nombreClienteContrato" name="nombreCliente" readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="documentoClienteContrato" class="form-label">Documento</label>
                                        <input type="text" class="form-control bg-light" id="documentoClienteContrato" name="documentoCliente" readonly required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="idVehiculoNuevo" class="form-label">Vehículo</label>
                                        <select class="form-select" aria-label="Selector" id="idVehiculoNuevo"
                                            name="idVehiculo" required onchange="obtenerPrecioSugeridoContratoNuevo()">
                                            <option value="" selected>Selecciona una opción</option>

                                            <?php
                            // Lógica PHP para Vehículos (no se toca)
                            if (!empty($ListadoVehiculos)) {
                                $selected = '';
                                for ($i = 0; $i < $CantidadVehiculos; $i++) {
                                    $selected = (!empty($_POST['idVehiculo']) && $_POST['idVehiculo'] == $ListadoVehiculos[$i]['IdVehiculo']) ? 'selected' : '';
                                    echo "<option value='{$ListadoVehiculos[$i]['IdVehiculo']}' $selected> {$ListadoVehiculos[$i]['matricula']} - {$ListadoVehiculos[$i]['modelo']} - {$ListadoVehiculos[$i]['grupo']}  </option>";
                                }
                            } else {
                                echo "<option value=''>No se encontraron vehículos</option>";
                            }
                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechaRetiroContratoNuevo" class="form-label">Fecha de Retiro</label>
                                        <input type="date" class="form-control" id="fechaRetiroContratoNuevo"
                                            name="fecharetiro" value="" required
                                            onchange="calcularTotalContratoNuevo()">
                                    </div>

                                    <div class="mb-3">
                                        <label for="fechaDevolucionContratoNuevo" class="form-label">Fecha de
                                            Devolución</label>
                                        <input type="date" class="form-control" id="fechaDevolucionContratoNuevo"
                                            name="fechadevolucion" value="" required
                                            onchange="calcularTotalContratoNuevo()">
                                    </div>

                                    <div class="mb-3">
                                        <label for="precioPorDiaNuevo" class="form-label">Precio por día</label>
                                        <input type="number" min="20" max="1000" step="0.01"
                                            title="Mínimo 20 USD y máximo 1000 USD" class="form-control"
                                            id="precioPorDiaNuevo" name="precioporDia" required
                                            oninput="calcularTotalContratoNuevo()">
                                    </div>

                                    <div class="mb-3">
                                        <label for="montoTotalNuevo" class="form-label">Monto Total</label>
                                        <input type="number" class="form-control" id="montoTotalNuevo" name="MontoTotal"
                                            readonly placeholder="Calculado Automáticamente" required>
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


            </div>
        </div>

        <div>
            <?php require_once "foot.php"; ?>
        </div>
    </div>

    <!-- Script que actualiza el href según el año seleccionado -->
    <script>
    const select = document.getElementById("anioSeleccionado");
    const link = document.getElementById("reporteLink");

    select.addEventListener("change", function() {
        const anio = this.value;
        link.href = `ReporteContratos_FrecMensuales.php?anio=${anio}`;
    });
    </script>

    <script>
    // Efecto sobre la imagen del reporte
    window.onload = function() {

        const imageElement = document.querySelector('.hoverImage');

        if (imageElement) {
            const handleMouseMove = (e) => {
                let rect = imageElement.getBoundingClientRect();
                let x = e.clientX - rect.left;
                let y = e.clientY - rect.top;

                let dx = (x - rect.width / 2) / (rect.width / 2);
                let dy = (y - rect.height / 2) / (rect.height / 2);

                imageElement.style.transform =
                    `perspective(500px) rotateY(${dx * 5}deg) rotateX(${-dy * 5}deg)`;
            };

            const handleMouseLeave = () => {
                imageElement.style.transform = "";
            };

            imageElement.addEventListener('mousemove', handleMouseMove);
            imageElement.addEventListener('mouseleave', handleMouseLeave);
        }
    }
    </script>

    <script>
    // --- LÓGICA DE BÚSQUEDA DE CLIENTES PARA NUEVO CONTRATO ---

    /**
     * Busca clientes en tiempo real y muestra los resultados en una lista desplegable.
     * @param {string} query - El texto de búsqueda.
     * @param {string} resultsDivId - El ID del div donde se mostrarán los resultados.
     */
    function buscarClienteEnModal(query, resultsDivId) {
        const resultadosDiv = document.getElementById(resultsDivId);
        if (query.trim().length < 2) { // Empezar a buscar después de 2 caracteres
            resultadosDiv.innerHTML = '';
            return;
        }

        // Usamos el endpoint existente para buscar clientes
        fetch(`funciones/Buscar_Cliente.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                resultadosDiv.innerHTML = ''; // Limpiar resultados anteriores
                if (data.length > 0) {
                    data.forEach(cliente => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.innerHTML = `<strong>${cliente.apellido}, ${cliente.nombre}</strong> <br><small>DNI: ${cliente.documento}</small>`;
                        
                        // Escapamos las comillas para evitar errores en el onclick
                        const safeApellido = cliente.apellido.replace(/'/g, "\\'");
                        const safeNombre = cliente.nombre.replace(/'/g, "\\'");

                        item.onclick = (e) => {
                            e.preventDefault();
                            seleccionarCliente(cliente.id, cliente.documento, safeApellido, safeNombre, resultsDivId);
                        };
                        resultadosDiv.appendChild(item);
                    });
                } else {
                    resultadosDiv.innerHTML = '<span class="list-group-item disabled">No se encontraron clientes. Puede registrar uno nuevo.</span>';
                    // Habilitar campos para nuevo cliente
                    document.getElementById('idClienteNuevoContrato').value = ''; // Limpiar ID
                    
                    const apellidoInput = document.getElementById('apellidoClienteContrato');
                    const nombreInput = document.getElementById('nombreClienteContrato');
                    const docInput = document.getElementById('documentoClienteContrato');

                    apellidoInput.readOnly = false;
                    nombreInput.readOnly = false;
                    docInput.readOnly = false;
                    apellidoInput.classList.remove('bg-light');
                    nombreInput.classList.remove('bg-light');
                    docInput.classList.remove('bg-light');
                }
            })
            .catch(error => console.error('Error al buscar clientes:', error));
    }

    /**
     * Rellena los campos del formulario cuando se selecciona un cliente de la lista.
     * @param {string} id - ID del cliente.
     * @param {string} documento - Documento del cliente.
     * @param {string} apellido - Apellido del cliente.
     * @param {string} nombre - Nombre del cliente.
     * @param {string} resultsDivId - El ID del div de resultados para limpiarlo.
     */
    function seleccionarCliente(id, documento, apellido, nombre, resultsDivId) {
        // Rellenar los campos del formulario de Nuevo Contrato
        document.getElementById('idClienteNuevoContrato').value = id;
        document.getElementById('buscadorClienteContrato').value = `${apellido}, ${nombre}`; // Actualiza el campo de búsqueda
        document.getElementById('documentoClienteContrato').value = documento;
        document.getElementById('apellidoClienteContrato').value = apellido;
        document.getElementById('nombreClienteContrato').value = nombre;

        // Asegurarse de que los campos vuelvan a ser de solo lectura
        const apellidoInput = document.getElementById('apellidoClienteContrato');
        const nombreInput = document.getElementById('nombreClienteContrato');
        const docInput = document.getElementById('documentoClienteContrato');
        apellidoInput.readOnly = true;
        nombreInput.readOnly = true;
        docInput.readOnly = true;
        apellidoInput.classList.add('bg-light');
        nombreInput.classList.add('bg-light');
        docInput.classList.add('bg-light');

        // Ocultar la lista de resultados
        document.getElementById(resultsDivId).innerHTML = '';
    }
    </script>

    <script>
    // ===================================================================
    // FUNCIONES DE CÁLCULO Y AJAX PARA NUEVO CONTRATO
    // ===================================================================

    /**
     * Calcula la diferencia en días entre dos fechas (mínimo 1 día si las fechas son iguales).
     */
    function diferenciaEnDias(fecha1, fecha2) {
        const date1 = new Date(fecha1);
        const date2 = new Date(fecha2);
        
        if (isNaN(date1.getTime()) || isNaN(date2.getTime()) || date2 < date1) {
            return 0;
        }

        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)); 
        
        return (diffDays > 0) ? diffDays : 1; 
    }

    /**
     * Calcula el monto total del contrato: Precio * Días.
     */
    function calcularTotalContratoNuevo() {
        const inputPrecio = document.getElementById('precioPorDiaNuevo');
        const inputInicio = document.getElementById('fechaRetiroContratoNuevo'); 
        const inputFin = document.getElementById('fechaDevolucionContratoNuevo'); 
        const inputTotal = document.getElementById('montoTotalNuevo');

        if (!inputPrecio || !inputInicio || !inputFin || !inputTotal) return;

        const precio = parseFloat(inputPrecio.value);
        const fechaInicio = inputInicio.value;
        const fechaFin = inputFin.value;

        if (isNaN(precio) || precio <= 0 || !fechaInicio || !fechaFin) {
            inputTotal.value = '0.00';
            return;
        }

        const dias = diferenciaEnDias(fechaInicio, fechaFin);
        inputTotal.value = (dias > 0) ? (precio * dias).toFixed(2) : '0.00';
    }

    /**
     * Obtiene el precio sugerido por AJAX al cambiar el vehículo.
     */
    function obtenerPrecioSugeridoContratoNuevo() {
        const selectVehiculo = document.getElementById('idVehiculoNuevo'); 
        const inputPrecio = document.getElementById('precioPorDiaNuevo');
        const idVehiculo = selectVehiculo.value;

        if (!idVehiculo) {
            inputPrecio.value = '';
            calcularTotalContratoNuevo(); 
            return;
        }

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
                inputPrecio.value = data.success ? parseFloat(data.precio).toFixed(2) : '';
                calcularTotalContratoNuevo(); 
            })
            .catch(error => {
                console.error('Error de la solicitud AJAX:', error);
                alert('Ocurrió un error al obtener el precio sugerido para el contrato.');
                calcularTotalContratoNuevo();
            });
    }
    </script>

    <script>
    // Desplazamiento vertical al listado luego de consulta
    function scrollToTable() {
        localStorage.setItem('scrollToTable', 'true'); // Guardar indicador antes de enviar
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (localStorage.getItem('scrollToTable') === 'true') {
            setTimeout(() => {
                document.getElementById('tablaContratosContenedor').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
            }, 500);
        }
    });

    let reservaSeleccionada = null;

    // Selección de fila en la Tabla de Contratos al hacer clic en la misma
    document.querySelectorAll('#tablaContratos .contrato').forEach(row => {
        row.addEventListener('click', () => {
            // Desmarcar cualquier fila previamente seleccionada
            document.querySelectorAll('.contrato').forEach(row => row.classList.remove('table-active'));
            // Marcar la fila seleccionada
            row.classList.add('table-active');
            reservaSeleccionada = row.dataset.id;
            // Habilitar los botones
            document.getElementById('btnModificar').disabled = false;
            document.getElementById('btnEliminar').disabled = false;
        });
    });

    // Función para redirigir a ModificarCliente.php con el ID del cliente seleccionado
    function modificarContrato() {
        if (reservaSeleccionada) {
            window.location.href = 'ModificarContrato.php?id=' + reservaSeleccionada;
        }
    }

    // Función para redirigir a EliminarCliente.php con el ID del cliente seleccionado
    function eliminarContrato() {
        if (reservaSeleccionada) {
            if (confirm('¿Estás seguro de que quieres eliminar este contrato?')) {
                window.location.href = 'EliminarContrato.php?id=' + reservaSeleccionada;
            }
        }
    }

    // ===================================================================
// FUNCIONES DE CÁLCULO Y AJAX PARA NUEVO CONTRATO
// ===================================================================

/**
 * Calcula la diferencia en días entre dos fechas (mínimo 1 día si las fechas son iguales).
 */
function diferenciaEnDias(fecha1, fecha2) {
    const date1 = new Date(fecha1);
    const date2 = new Date(fecha2);
    
    // Si las fechas no son válidas o la fecha fin es anterior a la inicio, retorna 0
    if (isNaN(date1.getTime()) || isNaN(date2.getTime()) || date2 < date1) {
        return 0;
    }

    const diffTime = Math.abs(date2 - date1);
    // Calcula la diferencia en días. Usa Math.round para evitar problemas con cambios de hora/DST.
    const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)); 
    
    // Retorna la diferencia, asegurando que sea al menos 1 día si se selecciona el mismo día.
    return (diffDays > 0) ? diffDays : 1; 
}

/**
 * Calcula el monto total del contrato: Precio * Días.
 */
function calcularTotalContratoNuevo() {
    // IDs de los campos en el formulario del modal de Nuevo Contrato
    const inputPrecio = document.getElementById('precioPorDiaNuevo');
    const inputInicio = document.getElementById('fechaRetiroContratoNuevo'); 
    const inputFin = document.getElementById('fechaDevolucionContratoNuevo'); 
    const inputTotal = document.getElementById('montoTotalNuevo');

    if (!inputPrecio || !inputInicio || !inputFin || !inputTotal) {
        return; 
    }

    const precio = parseFloat(inputPrecio.value);
    const fechaInicio = inputInicio.value;
    const fechaFin = inputFin.value;

    if (isNaN(precio) || precio <= 0 || !fechaInicio || !fechaFin) {
        inputTotal.value = '0.00';
        return;
    }

    const dias = diferenciaEnDias(fechaInicio, fechaFin);

    if (dias > 0) {
        const total = precio * dias;
        inputTotal.value = total.toFixed(2);
    } else {
        inputTotal.value = '0.00';
    }
}


/**
 * Obtiene el precio sugerido por AJAX al cambiar el vehículo.
 */
function obtenerPrecioSugeridoContratoNuevo() {
    // ID del select de vehículo (debe coincidir con el HTML modificado)
    const selectVehiculo = document.getElementById('idVehiculoNuevo'); 
    const inputPrecio = document.getElementById('precioPorDiaNuevo');
    const idVehiculo = selectVehiculo.value;

    if (!idVehiculo || idVehiculo === "") {
        inputPrecio.value = '';
        calcularTotalContratoNuevo(); 
        return;
    }

    // Lógica AJAX a obtener_precio_grupo.php
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
            // Asignar el precio devuelto y forzar 2 decimales
            inputPrecio.value = parseFloat(data.precio).toFixed(2);
        } else {
            console.error('Error del servidor:', data.message);
            inputPrecio.value = ''; 
        }
        // Llamar al cálculo de total después de obtener (o fallar al obtener) el precio
        calcularTotalContratoNuevo(); 
    })
    .catch(error => {
        console.error('Error de la solicitud AJAX:', error);
        inputPrecio.value = '';
        alert('Ocurrió un error al obtener el precio sugerido para el contrato.');
        calcularTotalContratoNuevo();
    });
}
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>