<?php

session_start();

require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Incluyo las funciones necesarias para listado y consulta
require_once 'funciones/vehiculos listado.php';
require_once 'funciones/vehiculo consulta.php';
require_once 'funciones/Select_Tablas.php'; // AÑADIDO: Necesario para listar sucursales

// Filtrado de vehículos

$matricula = isset($_POST['Matricula']) ? $_POST['Matricula'] : '';
$modelo = isset($_POST['Modelo']) ? $_POST['Modelo'] : '';
$grupo = isset($_POST['Grupo']) ? $_POST['Grupo'] : '';
$color = isset($_POST['Color']) ? $_POST['Color'] : '';
$combustible = isset($_POST['Combustible']) ? $_POST['Combustible'] : '';
$disponibilidad = isset($_POST['Disponibilidad']) ? $_POST['Disponibilidad'] : '';
// REMOVIDOS los filtros individuales por texto: ciudadsucursal, direccionsucursal, telsucursal
$idSucursalFiltro = isset($_POST['IdSucursalFiltro']) ? $_POST['IdSucursalFiltro'] : ''; // NUEVO: Filtro por ID de Sucursal

$puertas = isset($_POST['Puertas']) ? $_POST['Puertas'] : '';
$asientos = isset($_POST['Asientos']) ? $_POST['Asientos'] : '';
$automatico = isset($_POST['Automatico']) ? $_POST['Automatico'] : '';
$aireacondicionado = isset($_POST['AireAcondicionado']) ? $_POST['AireAcondicionado'] : '';
$direccionhidraulica = isset($_POST['DireccionHidraulica']) ? $_POST['DireccionHidraulica'] : '';
$fabricaciondesde = isset($_POST['FabricacionDesde']) ? $_POST['FabricacionDesde'] : '';
$fabricacionhasta = isset($_POST['FabricacionHasta']) ? $_POST['FabricacionHasta'] : '';
$adquisiciondesde = isset($_POST['AdquisicionDesde']) ? $_POST['AdquisicionDesde'] : '';
$adquisicionhasta = isset($_POST['AdquisicionHasta']) ? $_POST['AdquisicionHasta'] : '';
$preciodesde = isset($_POST['PrecioDesde']) ? $_POST['PrecioDesde'] : '';
$preciohasta = isset($_POST['PrecioHasta']) ? $_POST['PrecioHasta'] : '';

// Obtener listado de sucursales para el SELECT del filtro
$sucursalesDisponibles = Listar_Sucursal($conexion);

// Lógica principal de consulta y filtrado
if (!empty($_POST['BotonFiltro'])) {

    Procesar_Consulta();

    // Lógica del filtro 'Activo'
    $activo_filtro = isset($_POST['MostrarInactivos']) && $_POST['MostrarInactivos'] == 'on' ? '0' : '1';

    // MODIFICADO: Se pasa $idSucursalFiltro en lugar de ciudad, dirección y teléfono
    $ListadoVehiculos = Consulta_Vehiculo(
        $_POST['Matricula'],
        $_POST['Modelo'],
        $_POST['Grupo'],
        $_POST['Color'],
        $_POST['Combustible'],
        $_POST['Disponibilidad'],
        $idSucursalFiltro,
        '',
        '', // ID, y dos strings vacíos para compatibilidad de firma (serán ignorados en vehiculo consulta.php)
        $_POST['Puertas'],
        $_POST['Asientos'],
        $_POST['Automatico'],
        $_POST['AireAcondicionado'],
        $_POST['DireccionHidraulica'],
        $_POST['FabricacionDesde'],
        $_POST['FabricacionHasta'],
        $_POST['AdquisicionDesde'],
        $_POST['AdquisicionHasta'],
        $_POST['PrecioDesde'],
        $_POST['PrecioHasta'],
        $activo_filtro,
        $conexion
    );
    $CantidadVehiculos = count($ListadoVehiculos);
} else {

    // Si no hay filtro aplicado (carga inicial o desfiltrar no presionado), se muestra el listado por defecto: solo vehículos ACTIVOS (activo = '1')
    $activo_filtro = '1';
    // MODIFICADO: Se pasan parámetros de sucursal vacíos
    $ListadoVehiculos = Consulta_Vehiculo(
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '', // Tres strings vacíos para sucursal (ID, Dir, Tel)
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        $activo_filtro,
        $conexion
    );
    $CantidadVehiculos = count($ListadoVehiculos);
}

if (!empty($_POST['BotonDesfiltrar'])) {

    // Desfiltrar vuelve a la vista por defecto: solo activos (activo = '1')
    $activo_filtro = '1';
    // MODIFICADO: Se pasan parámetros de sucursal vacíos
    $ListadoVehiculos = Consulta_Vehiculo(
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '', // Tres strings vacíos para sucursal (ID, Dir, Tel)
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        $activo_filtro,
        $conexion
    );
    $CantidadVehiculos = count($ListadoVehiculos);

    // Limpiar variables POST para el formulario
    $_POST['Matricula'] = "";
    $_POST['Modelo'] = "";
    $_POST['Grupo'] = "";
    $_POST['Color'] = "";
    $_POST['Combustible'] = "";
    $_POST['Disponibilidad'] = "";
    $_POST['IdSucursalFiltro'] = ""; // NUEVO: Limpiar el ID de Sucursal
    // REMOVIDOS: CiudadSucursal, DireccionSucursal, TelSucursal de la limpieza
    $_POST['Puertas'] = "";
    $_POST['Asientos'] = "";
    $_POST['Automatico'] = "";
    $_POST['AireAcondicionado'] = "";
    $_POST['DireccionHidraulica'] = "";
    $_POST['FabricacionDesde'] = "";
    $_POST['FabricacionHasta'] = "";
    $_POST['AdquisicionDesde'] = "";
    $_POST['AdquisicionHasta'] = "";
    $_POST['PrecioDesde'] = "";
    $_POST['PrecioHasta'] = "";
    $_POST['MostrarInactivos'] = ""; // Limpiar el checkbox
}


// Variables usadas en nuevos Registros
$matri = '';
$dispo = '';
$model = '';
$grup = '';
$combus = '';
$sucurs = '';
$activoREG = '1'; // Estado activo por defecto (1)

// Registrar nuevo vehiculo
require_once 'funciones/RegistrarVehiculo.php';

if (!empty($_POST['BotonRegistrarVehiculo'])) {

    // Capturo los datos
    $matri = $_POST['MatriculaREG'];
    $matri = "$matri";
    $model = $_POST['ModeloREG'];
    $grup = $_POST['GrupoREG'];
    $dispo = $_POST['DisponibilidadREG'];
    $activoREG = '1'; // Se registra siempre como activo

    $idVehiculo = Registrar_Vehiculo($matri, $model, $grup, $dispo, $activoREG, $conexion);

    $mensaje = "Se registró exitosamente el vehículo de ID: {$idVehiculo} y matrícula: {$matri}.";
    echo "<script>
          alert('$mensaje');
          window.location.href = 'OpVehiculos.php';
    </script>";
    exit();
}

// SELECCIONES para combo boxes del Registro de nuevo vehículo
// Estas funciones ya están incluidas por require_once 'funciones/Select_Tablas.php';

$ListadoGrupo = Listar_Grupo($conexion);
$CantidadGrupo = count($ListadoGrupo);

$ListadoModelo = Listar_Modelo($conexion);
$CantidadModelo = count($ListadoModelo);


require_once "head.php";
?>

<body>

    <?php
    $tituloPagina = "VEHÍCULOS";
    require_once "topNavBar.php";
    require_once "sidebarGop.php";
    ?>

    <div style="margin-top: 8%; margin-bottom: 8%; min-height: 100%; ">

        <main class="d-flex flex-column justify-content-center align-items-center h-100 bg-light bg-gradient p-4">

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

            <div class="card col-10 bg-white p-4 rounded shadow mb-4 filtro-consultas">
                <h4 class="text-center mb-4">Filtrar Vehículos</h4>

                <form action="OpVehiculos.php" method="post" onsubmit="scrollToTable()">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" name="Matricula" value="<?php echo !empty($_POST['Matricula']) ? $_POST['Matricula'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="text" class="form-control" id="grupo" name="Grupo" value="<?php echo !empty($_POST['Grupo']) ? $_POST['Grupo'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="Modelo" value="<?php echo !empty($_POST['Modelo']) ? $_POST['Modelo'] : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="Color" value="<?php echo !empty($_POST['Color']) ? $_POST['Color'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="combustible" class="form-label">Combustible</label>
                            <input type="text" class="form-control" id="combustible" name="Combustible" value="<?php echo !empty($_POST['Combustible']) ? $_POST['Combustible'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="disponibilidad" class="form-label">Disponibilidad</label>
                            <select class="form-select" id="disponibilidad" name="Disponibilidad">
                                <option value="" selected>Disponibilidad para arrendar...</option>
                                <option value="S" <?php echo (isset($_POST['Disponibilidad']) && $_POST['Disponibilidad'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                <option value="N" <?php echo (isset($_POST['Disponibilidad']) && $_POST['Disponibilidad'] == 'N') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="automatico" class="form-label">Automático</label>
                            <select class="form-select" id="automatico" name="Automatico">
                                <option value="" selected>Seleccionar...</option>
                                <option value="S" <?php echo (isset($_POST['Automatico']) && $_POST['Automatico'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                <option value="N" <?php echo (isset($_POST['Automatico']) && $_POST['Automatico'] == 'N') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="aireacondicionado" class="form-label">Aire acondicionado</label>
                            <select class="form-select" id="aireacondicionado" name="AireAcondicionado">
                                <option value="" selected>Seleccionar...</option>
                                <option value="S" <?php echo (isset($_POST['AireAcondicionado']) && $_POST['AireAcondicionado'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                <option value="N" <?php echo (isset($_POST['AireAcondicionado']) && $_POST['AireAcondicionado'] == 'N') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="direccionhidraulica" class="form-label">Dirección hidráulica</label>
                            <select class="form-select" id="direccionhidraulica" name="DireccionHidraulica">
                                <option value="" selected>Seleccionar...</option>
                                <option value="S" <?php echo (isset($_POST['DireccionHidraulica']) && $_POST['DireccionHidraulica'] == 'S') ? 'selected' : ''; ?>>Sí</option>
                                <option value="N" <?php echo (isset($_POST['DireccionHidraulica']) && $_POST['DireccionHidraulica'] == 'N') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="idSucursalFiltro" class="form-label">Sucursal Asignada</label>
                            <select class="form-select" id="idSucursalFiltro" name="IdSucursalFiltro">
                                <option value="" selected>Filtrar por Sucursal...</option>
                                <?php
                                if (!empty($sucursalesDisponibles)) {
                                    foreach ($sucursalesDisponibles as $suc) {
                                        $selected = (isset($_POST['IdSucursalFiltro']) && $_POST['IdSucursalFiltro'] == $suc['IdSucursal']) ? 'selected' : '';
                                        echo "<option value='{$suc['IdSucursal']}' $selected >";
                                        echo htmlspecialchars("{$suc['CiudadSucursal']} - {$suc['DireccionSucursal']}");
                                        echo "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Puertas / Asientos</label>
                            <div class="d-flex">
                                <input type="text" class="form-control me-2" id="puertas" name="Puertas" placeholder="Puertas"
                                    value="<?php echo !empty($_POST['Puertas']) ? $_POST['Puertas'] : ''; ?>">
                                <input type="text" class="form-control" id="asientos" name="Asientos" placeholder="Asientos"
                                    value="<?php echo !empty($_POST['Asientos']) ? $_POST['Asientos'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="aniofabricacion" class="form-label">Año de fabricación</label>
                            <div class="d-flex">
                                <input type="number" step="1" min="1900" max="2050" id="fabricaciondesde" title="Desde..." class="form-control me-2" name="FabricacionDesde"
                                    value="<?php echo !empty($_POST['FabricacionDesde']) ? $_POST['FabricacionDesde'] : ''; ?>">

                                <input type="number" step="1" min="1900" max="2050" id="fabricacionhasta" title="Hasta..." class="form-control" name="FabricacionHasta"
                                    value="<?php echo !empty($_POST['FabricacionHasta']) ? $_POST['FabricacionHasta'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fechacompra" class="form-label">Fecha de adquisición</label>
                            <div class="d-flex">
                                <input type="date" id="adquisiciondesde" title="Desde..." class="form-control me-2" name="AdquisicionDesde"
                                    value="<?php echo !empty($_POST['AdquisicionDesde']) ? $_POST['AdquisicionDesde'] : ''; ?>">

                                <input type="date" id="adquisicionhasta" title="Hasta..." class="form-control" name="AdquisicionHasta"
                                    value="<?php echo !empty($_POST['AdquisicionHasta']) ? $_POST['AdquisicionHasta'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="precio" class="form-label">Precio vehículo</label>
                            <div class="d-flex">
                                <input type="number" min="0" max="1000000000" id="preciodesde" title="Desde..." class="form-control me-2" name="PrecioDesde"
                                    value="<?php echo !empty($_POST['PrecioDesde']) ? $_POST['PrecioDesde'] : ''; ?>">

                                <input type="number" min="0" max="1000000000" id="preciohasta" title="Hasta..." class="form-control" name="PrecioHasta"
                                    value="<?php echo !empty($_POST['PrecioHasta']) ? $_POST['PrecioHasta'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <br><br>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-black btn-filtrar" name="BotonFiltro" value="Filtrando">Filtrar</button>
                            <button type="submit" class="btn btn-warning btn-filtrar" name="BotonDesfiltrar" value="Desfiltrando">Limpiar Filtros</button>
                        </div>

                        <div class="form-check d-flex align-items-center" style="height: 58px;">
                            <input class="form-check-input" type="checkbox" id="mostrarInactivos" name="MostrarInactivos"
                                <?php echo (isset($_POST['MostrarInactivos']) && $_POST['MostrarInactivos'] == 'on') ? 'checked' : ''; ?>>
                            <label class="form-check-label ms-2" for="mostrarInactivos">
                                Mostrar solo Vehículos Inactivos/Eliminados
                            </label>
                        </div>
                    </div>
                </form>

            </div>

            <div id="tablaVehiculosContenedor" class="card col-10 bg-white p-4 rounded shadow mb-4" style="margin-top: 5%;">
                <h4 class="text-center mb-3">Listado de Vehículos</h4> <br>
                <div class="table-responsive" style="max-height: 700px;">

                    <table class="table table-bordered table-hover table-striped" id="tablaVehiculos">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col"> # </th>
                                <th scope="col"> Matrícula </th>
                                <th scope="col"> Vehículo </th>
                                <th scope="col"> Combustible </th>
                                <th scope="col"> Sucursal </th>
                                <th scope="col"> Disp. </th>
                                <th scope="col"> Estado </th>
                                <th scope="col"> Puertas y asientos </th>
                                <th scope="col"> Automático </th>
                                <th scope="col"> Aire acondicionado </th>
                                <th scope="col"> Dirección Hidráulica </th>
                                <th scope="col"> Kilometraje </th>
                                <th scope="col"> Motor y chasis </th>
                                <th scope="col"> Estado físico </th>
                                <th scope="col"> Año de fabricación </th>
                                <th scope="col"> Adquisición </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            for ($i = 0; $i < $CantidadVehiculos; $i++) { ?>

                                <tr class='vehiculo'
                                    data-id="<?= $ListadoVehiculos[$i]['vID'] ?>"
                                    data-activo="<?= $ListadoVehiculos[$i]['vActivo'] ?>" data-matricula="<?= $ListadoVehiculos[$i]['vMatricula'] ?>"
                                    data-modelo="<?= $ListadoVehiculos[$i]['vModelo'] ?>"
                                    data-grupo="<?= $ListadoVehiculos[$i]['vGrupo'] ?>"
                                    data-combustible="<?= $ListadoVehiculos[$i]['vCombustible'] ?>"
                                    data-sucursal="<?= "{$ListadoVehiculos[$i]['vSucursalDireccion']}, {$ListadoVehiculos[$i]['vSucursalCiudad']}" ?>"
                                    data-disponibilidad="<?= $ListadoVehiculos[$i]['vDisponibilidad'] ?>"
                                    onclick="selectRow(this)">

                                    <td> <?php echo $i + 1; ?> </td>

                                    <td> <?php echo $ListadoVehiculos[$i]['vMatricula']; ?> </td>

                                    <td title="Modelo del vehículo y grupo al que pertenece">
                                        <b>Modelo:</b> <?php echo $ListadoVehiculos[$i]['vModelo']; ?> <br><br>
                                        <b>Grupo:</b> <?php echo $ListadoVehiculos[$i]['vGrupo']; ?> <br><br>
                                        <b>Color:</b> <?php echo $ListadoVehiculos[$i]['vColor']; ?>
                                    </td>

                                    <td> <?php echo $ListadoVehiculos[$i]['vCombustible']; ?> </td>

                                    <td> <?php echo "{$ListadoVehiculos[$i]['vSucursalCiudad']},
                                                {$ListadoVehiculos[$i]['vSucursalDireccion']}"; ?> <br><br>
                                        <b>Tel:</b> <?php echo $ListadoVehiculos[$i]['vSucursalTel']; ?>
                                    </td>

                                    <td title="Disponibilidad">
                                        <span class="badge badge-<?php echo $ListadoVehiculos[$i]['ColorAdvertencia']; ?>">
                                            <?php echo $ListadoVehiculos[$i]['vDisponibilidad']; ?>
                                        </span>
                                    </td>

                                    <td title="Estado de actividad">
                                        <span class="badge bg-<?php echo $ListadoVehiculos[$i]['ColorActivo']; ?>">
                                            <?php echo $ListadoVehiculos[$i]['TextoActivo']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <b>Puertas:</b> <?php echo $ListadoVehiculos[$i]['vNumeroPuertas']; ?> <br><br>
                                        <b>Asientos:</b> <?php echo $ListadoVehiculos[$i]['vNumeroAsientos']; ?> pasajeros
                                    </td>

                                    <td title="Automático"> <?php echo $ListadoVehiculos[$i]['vAutomatico']; ?> </td>

                                    <td title="Aire acondicionado"> <?php echo $ListadoVehiculos[$i]['vAire']; ?> </td>

                                    <td title="Dirección hidráulica"> <?php echo $ListadoVehiculos[$i]['vHidraulica']; ?> </td>

                                    <td title="Kilometraje"> <?php echo $ListadoVehiculos[$i]['vKilometraje']; ?> </td>

                                    <td>
                                        <b>NºMotor:</b> <?php echo $ListadoVehiculos[$i]['vNumeroMotor']; ?> <br><br>
                                        <b>NºChasis:</b> <?php echo $ListadoVehiculos[$i]['vNumeroChasis']; ?>
                                    </td>

                                    <td title="Estado físico del vehículo"> <?php echo $ListadoVehiculos[$i]['vEstadoFisico']; ?> </td>

                                    <td title="Año de fabricación del vehículo"> <?php echo $ListadoVehiculos[$i]['vAnio']; ?> </td>

                                    <td title="Fecha de compra y precio al que la empresa adquirió el vehículo">
                                        <b>Fecha:</b><br> <?php echo $ListadoVehiculos[$i]['vFechaCompra']; ?> <br><br>
                                        <b>Precio:</b><br>
                                        <?php
                                        if ($ListadoVehiculos[$i]['vPrecioCompra'] != "Sin información") {
                                            echo "$ ";
                                            echo $ListadoVehiculos[$i]['vPrecioCompra'];
                                            echo " USD";
                                        } else {
                                            echo $ListadoVehiculos[$i]['vPrecioCompra'];
                                        }
                                        ?>
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>

                    </table>
                </div>
            </div>

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
            <p class="btn no-btn-effect" style="background-color: rgb(153, 6, 6); color: #ffffff; margin-left: 25px;">
                Total de registros encontrados: <?php echo $CantidadVehiculos; ?>
            </p>

            <br><br><br>
            <div class="d-flex justify-content-between col-8">
                <button type="button" class="btn btn-dark btn-filtrar" data-bs-toggle="modal" data-bs-target="#nuevoVehiculo">Nuevo</button>
                <button type="button" class="btn btn-warning btn-filtrar" id="btnModificar" onclick="modificarVehiculo()" disabled>Modificar</button>
                <button type="button" class="btn btn-danger btn-filtrar" id="btnEliminar" disabled>Eliminar</button>
            </div>

        </main>
    </div>

    <div class="modal fade" id="nuevoVehiculo" tabindex="-1" aria-labelledby="nuevoVehiculoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoVehiculoLabel">Agregar Nuevo Vehículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post">

                        <div class="mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" maxlength="12" class="form-control" title="Máximo de 12 caracteres."
                                name="MatriculaREG" value="" required>
                        </div>
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <select class="form-select" aria-label="Selector" id="selector" name="ModeloREG" required>
                                <option value="" selected>Selecciona una opción</option>

                                <?php
                                // Asegúrate de que $ListadoModelo contiene datos antes de procesarlo
                                if (!empty($ListadoModelo)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadModelo; $i++) {
                                        // Lógica para verificar si el grupo debe estar seleccionado
                                        $selected = (!empty($_POST['ModeloREG']) && $_POST['ModeloREG'] == $ListadoModelo[$i]['IdModelo']) ? 'selected' : '';
                                        echo "<option value='{$ListadoModelo[$i]['IdModelo']}' $selected>{$ListadoModelo[$i]['NombreModelo']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No se encontraron modelos</option>";
                                }
                                ?>
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="grupo" class="form-label">Grupo</label>
                            <select class="form-select" aria-label="Selector" id="selector" name="GrupoREG" required>
                                <option value="" selected>Selecciona una opción</option>

                                <?php
                                // Asegúrate de que $ListadoGrupo contiene datos antes de procesarlo
                                if (!empty($ListadoGrupo)) {
                                    $selected = '';
                                    for ($i = 0; $i < $CantidadGrupo; $i++) {
                                        // Lógica para verificar si el grupo debe estar seleccionado
                                        $selected = (!empty($_POST['GrupoREG']) && $_POST['GrupoREG'] == $ListadoGrupo[$i]['IdGrupo']) ? 'selected' : '';
                                        echo "<option value='{$ListadoGrupo[$i]['IdGrupo']}' $selected>{$ListadoGrupo[$i]['NombreGrupo']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No se encontraron grupos</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="disponible" class="form-label">Disponible</label>
                            <select class="form-select" name="DisponibilidadREG" required>
                                <option value="S">Sí</option>
                                <option value="N">No</option>
                            </select>
                        </div>

                        <input type="hidden" name="ActivoREG" value="1">

                        <button type="submit" class="btn btn-primary btn-filtrar" name="BotonRegistrarVehiculo" value="RegistrandoVehiculo">Agregar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div>
        <?php require_once "foot.php"; ?>
    </div>

    <script>
        let vehiculoSeleccionado = null;
        let vehiculoActivo = null;

        // Función para manejar la selección de fila (adaptada)
        document.querySelectorAll('.vehiculo').forEach(row => {
            row.addEventListener('click', () => {
                // Desmarcar cualquier fila previamente seleccionada
                document.querySelectorAll('.vehiculo').forEach(r => r.classList.remove('table-active'));
                // Marcar la fila seleccionada
                row.classList.add('table-active');

                vehiculoSeleccionado = row.dataset.id;
                vehiculoActivo = row.dataset.activo; // Obtener el estado 'activo'

                // Habilitar el botón Modificar
                document.getElementById('btnModificar').disabled = false;

                const btnEliminar = document.getElementById('btnEliminar');

                // Lógica para deshabilitar el botón de Eliminación Lógica si ya está inactivo (activo = 0)
                if (vehiculoActivo === '0') {
                    btnEliminar.disabled = true;
                    btnEliminar.textContent = 'Inactivo';
                } else {
                    btnEliminar.disabled = false;
                    btnEliminar.textContent = 'Eliminar';
                }
            });
        });

        // Función para desplazar la pantalla hasta la tabla de resultados
        function scrollToTable() {
            localStorage.setItem('scrollToTable', 'true'); // Guardar indicador antes de enviar
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('scrollToTable') === 'true') {
                setTimeout(() => {
                    document.getElementById('tablaVehiculosContenedor').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    localStorage.removeItem('scrollToTable'); // Limpiar indicador después del scroll
                }, 500);
            }

            // Asocia el listener a la función de eliminarVehiculo
            document.getElementById('btnEliminar').addEventListener('click', eliminarVehiculo);
        });

        // Función para redirigir a ModificarVehiculo.php con el ID del Vehículo seleccionado
        function modificarVehiculo() {
            if (vehiculoSeleccionado) {
                window.location.href = 'ModificarVehiculo.php?id=' + vehiculoSeleccionado;
            }
        }

        // Función para redirigir a EliminarVehiculo.php con el ID del Vehículo seleccionado (Eliminación Lógica)
        function eliminarVehiculo() {
            if (vehiculoSeleccionado && vehiculoActivo === '1') {
                if (confirm('¿Estás seguro de que quieres eliminar este Vehículo?')) {
                    window.location.href = 'EliminarVehiculo.php?id=' + vehiculoSeleccionado;
                }
            } 
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>