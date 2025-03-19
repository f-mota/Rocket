<?php

session_start();
require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();

if (isset($_POST['BotonCancelar'])) {
    $_POST = array(); // Cuando recibo el BotonCancelar vacío el array para evitar conflictos en el modo del formulario
}

// Incluyo el script con la funcion que genera mi listado
require_once "funciones/FuncionesVehiculos.php";













//                                                  ACA--------------------------


// Filtrado de vehículos
// Consulta por medio de formulario de Filtro
if (!empty($_POST['BotonFiltro'])) {

    Procesar_Consulta();

    $ListadoVehiculos = array();
    $ListadoVehiculos = Consulta_Vehiculo($_POST['Matricula'], $_POST['Modelo'], $_POST['Grupo'], $_POST['Disponible'], $conexion);
} else {

    // Listo la totalidad de los registros en la tabla "vehiculos".
    $ListadoVehiculos = Listar_Vehiculos($conexion);
}

if (!empty($_POST['BotonDesfiltrar'])) {

    // Listo la totalidad de los registros en la tabla "vehiculos"
    $ListadoVehiculos = Listar_Vehiculos($conexion);
    $CantidadVehiculos = count($ListadoVehiculos);
}


// Variables usadas en Registros, Modificaciones, etc.
$matri = '';
$dispo = '';
$model = '';
$grup = '';
$combus = '';
$sucurs = '';


// SELECCIONES para combo boxes
require_once 'funciones/Select_Tablas.php';

// $ListadoGrupo = Listar_Grupo($conexion);
// $CantidadGrupo = count($ListadoGrupo);

// $ListadoModelo = Listar_Modelo($conexion);
// $CantidadModelo = count($ListadoModelo);

// $ListadoCombustible = Listar_Combustible($conexion);
// $CantidadCombustible = count($ListadoCombustible);




//                                      ------------------------- ACA -----------------



require_once "head.php";
?>

<body>

    <?php
    require_once "topNavBar.php";
    require_once "sidebarGop.php";
    ?>

    <div style="margin-top: 8%; margin-bottom: 8%; min-height: 100%; ">

        <main class="d-flex flex-column justify-content-center align-items-center h-100 bg-light bg-gradient p-4">

            <div class="card col-8 bg-white p-4 rounded shadow mb-4">
                <h4 class="text-center mb-4">Filtrar Vehículos</h4>

                <form method="post">
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" name="Matricula"
                                value="<?php echo !empty($_POST['Matricula']) ? $_POST['Matricula'] : ''; ?> ">
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="grupo" class="form-label">Grupo</label>
                            <select class="form-select" name="IdGrupo">
                                <option value=""></option>

                                <?php
                                $ListadoGrupos = ListarGrupos($conexion);
                                for ($i = 0; $i < count($ListadoGrupos); $i++) {
                                ?>

                                    <option value="<?php echo $ListadoGrupos[$i]['ID']; ?>">
                                        <?php echo $ListadoGrupos[$i]['ID'] . " - " . $ListadoGrupos[$i]['NOMBRE'] . " " . $ListadoGrupos[$i]['DESCRIPCION']  ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>

                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="disponible" class="form-label">Activo</label>
                            <select class="form-select" name="Disponible">
                                <option value="S">Solo activos</option>
                                <option value="N">Solo no activos</option>
                                <option value="T">Todos</option>
                            </select>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <select class="form-select" name="IdModelo">
                                <option value=""></option>

                                <?php
                                $ListadoModelos = ListarModelos($conexion);
                                for ($i = 0; $i < count($ListadoModelos); $i++) {
                                ?>

                                    <option value="<?php echo $ListadoModelos[$i]['ID_MODELO']; ?>">
                                        <?php echo $ListadoModelos[$i]['DESCRIPCION']; ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="mt-4 d-flex d-flex justify-content-around">
                        <button type="submit" class="btn btn-primary" name="BotonFiltro" value="Filtrando">Filtrar</button>
                        <button type="submit" class="btn btn-primary btn-danger" name="BotonDesfiltrar" value="Desfiltrando">Limpiar Filtros</button>
                    </div>
                </form>

            </div>

            <div class="card col-8 bg-white p-4 rounded shadow mb-4">
                <h4 class="text-center mb-3">Lista de Vehículos</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="vehicleTable">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Matrícula</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Grupo</th>
                                <th scope="col">Combustible</th>
                                <th scope="col">Activo</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php for ($i = 0; $i < count($ListadoVehiculos); $i++) { ?>
                                <td>
                                    <form method="post" action="formularioVehiculos.php">
                                        <input type="hidden" name="ConsultarVehiculo" value="<?php echo $ListadoVehiculos[$i]['MATRICULA']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i></button>
                                    </form>
                                </td>
                                <td> <?php echo $ListadoVehiculos[$i]['MATRICULA']; ?> </td>
                                <td> <?php echo $ListadoVehiculos[$i]['MODELO']; ?> </td>
                                <td> <?php echo $ListadoVehiculos[$i]['GRUPO']; ?> </td>
                                <td> <?php echo $ListadoVehiculos[$i]['COMBUSTIBLE']; ?> </td>
                                <td> <?php echo $ListadoVehiculos[$i]['DISPONIBLE']; ?> </td>
                                <td> <button type="button" class="btn btn-warning btn-sm mx-3" name="BotonModificarVehiculo"><i class="icon-note"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>
                                </td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>

                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-between col-8">
                <form method="post" action="formularioVehiculos.php">
                    <input type="hidden" name="RegistrarVehiculo" value="Registrar">
                    <button type="submit" class="btn btn-success">Nuevo</button>
                </form>




                <!-- Esto hay que cambiarlo porque van a cada boton individual!!! -->
                <form method="post" action="formularioVehiculos.php">
                    <input type="hidden" name="ConsultarVehiculo" value="Registrar">
                    <button type="submit" class="btn btn-success">Consultar</button>
                </form>

                <form method="post" action="formularioVehiculos.php">
                    <input type="hidden" name="ModificarVehiculo" value="Registrar">
                    <button type="submit" class="btn btn-success">Modificar</button>
                </form>

                <form method="post" action="formularioVehiculos.php">
                    <input type="hidden" name="EliminarVehiculo" value="Registrar">
                    <button type="submit" class="btn btn-success">Eliminar</button>
                </form>

                <!-- Esto hay que cambiarlo porque van a cada boton individual!!! -->

            </div>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <?php require_once "foot.php"; ?>

</body>

</html>