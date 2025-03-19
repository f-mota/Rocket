<?php
session_start();
require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();

require_once "funciones/FuncionesVehiculos.php"; // Importo las funciones para completar los select y las validaciones
require_once "head.php";

$Mensaje = '';
$Estilo = 'warning';
$titulo = "";
$disabled = "";

if (isset($_POST['RegistrarVehiculo'])) {
    $titulo = "Registro de Vehículo";
} elseif (isset($_POST['ModificarVehiculo'])) {
    $titulo = "Modificar Vehículo";
} elseif (isset($_POST['ConsultarVehiculo'])) {
    $titulo = "Consultar Vehículo";
    $disabled = "disabled";
} elseif (isset($_POST['ConsultarVehiculo'])) {
    $titulo = "Eliminar Vehículo";
    $disabled = "disabled";
}

// Hay que modificar la forma de entrar al modo del formulario, porque en algun momento van a quedar todos seteados (registrar, modificar, etc) y va a traer conflictos
// Podria ser utilizar un POST "Volver" ,por ejemplo, al darle click a cancelar y al recibirlo en el opvehiculos un if, si recibe eso $_POST = []


if (isset($_POST['BotonRegistrar'])) {
    if (isset($_POST['RegistrarVehiculo']) || isset($_POST['ModificarVehiculo'])) {
        $Mensaje = Validar_Datos(); // Valido los datos
        if (empty($Mensaje)) {
            if (isset($_POST['RegistrarVehiculo'])) {
                if (VerificarVehiculoExiste($conexion)) {
                    if (InsertarVehiculo($conexion) != false) {
                        $Mensaje = 'Los datos se guardaron correctamente!';
                        $_POST = array();
                        $Estilo = 'success';
                    }
                } else {
                    $Mensaje = "El vehículo ya existe. Debes modificarlo desde la opcion correspondiente";
                }
            } elseif (isset($_POST['ModificarVehiculo'])) {
                # code...
            }
        }
    }


    if (isset($_POST['EliminarVehiculo'])) {
        # code...
    }
}

if (isset($_POST["ConsultarVehiculo"])) {

    $consultarVehiculo = Consultar_Vehiculo($_POST["ConsultarVehiculo"], $conexion);
}
?>


<body>
    <?php
    require_once "topNavBar.php";
    require_once "sidebarGop.php";
    ?>

    <div class="container d-flex justify-content-center align-items-center">

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><?php echo $titulo ?></h4>
            </div>
            <div class="card-body ">
                <form role="form" method="post" action="">
                    <div class="row ">
                        <div class="col-md-2">
                            <label class="form-label">Matrícula</label>
                            <input type="text" class="form-control" placeholder="Ingrese matrícula" name="Matricula" <?php echo $disabled ?>
                                value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["Matricula"] : ""; ?><?php echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["MATRICULA"] : ""; ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Modelo</label>
                            <select class="form-select" name="IdModelo" <?php echo $disabled ?>>
                                <option value="">Seleccione un modelo</option>

                                <?php
                                $ListadoModelos = ListarModelos($conexion);
                                if (isset($_POST["ConsultarVehiculo"])) {
                                ?>
                                    <option value="<?php echo $consultarVehiculo[0]['ID_MODELO']; ?>" selected>
                                        <?php echo $consultarVehiculo[0]['MODELO']; ?>
                                    </option>
                                    <?php
                                } else {
                                    for ($i = 0; $i < count($ListadoModelos); $i++) {
                                    ?>

                                        <option value="<?php echo $ListadoModelos[$i]['ID_MODELO']; ?>"
                                            <?php echo $ListadoModelos[$i]['ID_MODELO'] == $_POST["IdModelo"] ? "selected" : "" ?>>
                                            <?php echo $ListadoModelos[$i]['DESCRIPCION']; ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>

                        <?php if (!isset($_POST['RegistrarVehiculo']) || !isset($_POST['ModificarVehiculo'])) { ?>

                            <div class="col-md-1">
                                <label class="form-label">Grupo</label>
                                <input class="form-control" disabled value="<?php echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["GRUPO"] : ""; ?>"></input>
                            </div>

                        <?php } ?>

                        <div class="col-md-1">
                            <label class="form-label">Año</label>
                            <input type="text" class="form-control" placeholder="Año" name="anio" <?php echo $disabled ?>
                                value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["anio"] : "";
                                        echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["ANIO"] : ""; ?>
                                ">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" placeholder="Color del vehículo" name="color" <?php echo $disabled ?>
                                value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["color"] : "";
                                        echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["COLOR"] : ""; ?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Fecha de Compra</label>
                            <input type="date" class="form-control" name="fechaCompra" <?php echo $disabled ?>
                                value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["fechaCompra"] : "";
                                        echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["FECHA_COMPRA"] : ""; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha de Venta</label>
                            <input type="date" class="form-control" name="fechaVenta" <?php echo $disabled ?>
                                value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["fechaVenta"] : "";
                                        echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["FECHA_VENTA"] : ""; ?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label">Número de Motor</label>
                            <input type="text" class="form-control" placeholder="Ingrese número de motor" <?php echo $disabled ?>
                                name="numeroMotor" value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["numeroMotor"] : "";
                                                            echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["NUMERO_MOTOR"] : ""; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Número de Chasis</label>
                            <input type="text" class="form-control" placeholder="Ingrese número de chasis" <?php echo $disabled ?>
                                name="numeroChasis" value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["numeroChasis"] : "";
                                                            echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["NUMERO_CHASIS"] : ""; ?>">
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Tipo de Combustible</label>
                            <select class="form-select" name="tipoCombustible" <?php echo $disabled ?>>
                                <option value="">Seleccione</option>

                                <?php
                                $ListadoCombustibles = ListarCombustibles($conexion);
                                if (isset($_POST["ConsultarVehiculo"])) {
                                ?>
                                    <option value="<?php echo $consultarVehiculo[0]['ID_COMBUSTIBLE']; ?>" selected>
                                        <?php echo $consultarVehiculo[0]['COMBUSTIBLE']; ?>
                                    </option>
                                    <?php
                                } else {

                                    for ($i = 0; $i < count($ListadoCombustibles); $i++) {
                                    ?>

                                        <option value="<?php echo $ListadoCombustibles[$i]['ID']; ?>"
                                            <?php echo $ListadoCombustibles[$i]['ID'] == $_POST["tipoCombustible"] ? "selected" : "" ?>>
                                            <?php echo $ListadoCombustibles[$i]['DESCRIPCION']; ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>

                        <?php if (!isset($_POST['RegistrarVehiculo']) || !isset($_POST['ModificarVehiculo'])) { ?>

                            <div class="col-md-1">
                                <label class="form-label">Puertas</label>
                                <input type="text" class="form-control" disabled value="<?php echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["PUERTAS"] : ""; ?>">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Asientos</label>
                                <input type="text" class="form-control" disabled value="<?php echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["ASIENTOS"] : ""; ?>">
                            </div>

                        <?php } ?>


                        <div class="col-md-1">
                            <label class="form-label">Activo</label>
                            <select class="form-select" name="disponible" <?php echo $disabled ?>>
                            
                                <option value="1" <?php echo $consultarVehiculo[0]["DISPONIBLE"] == 1 ? "selected" : "" ?>>Sí</option>
                                <option value="0"<?php echo $consultarVehiculo[0]["DISPONIBLE"] == 0 ? "selected" : "" ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kilometraje</label>
                            <input type="number" class="form-control" placeholder="Kilometraje actual" <?php echo $disabled ?>
                                name="kilometraje" value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["kilometraje"] : "";
                                                            echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["KILOMETRAJE"] : ""; ?>">
                        </div>
                    </div>

                    <div class="row mt-3">


                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="automatico" name="Automatico" <?php echo $disabled ?>
                                    <?php echo isset($_POST["Automatico"]) ? "checked" : ""; 
                                    echo $consultarVehiculo[0]["AUTOMATICO"] == 1 ? "checked" : ""; ?>>
                                <label class="form-check-label" for="automatico">Automático</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aire" name="Aire" <?php echo $disabled ?>
                                    <?php echo isset($_POST["Aire"]) ? "checked" : "";
                                    echo $consultarVehiculo[0]["AIRE"] == 1 ? "checked" : ""; ?>>
                                <label class="form-check-label" for="aire">Aire Acondicionado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="direccion" name="Direccion" <?php echo $disabled ?>
                                    <?php echo isset($_POST["Direccion"]) ? "checked" : ""; 
                                    echo $consultarVehiculo[0]["DIRECCION"] == 1 ? "checked" : "";?>>
                                <label class="form-check-label" for="direccion">Dirección Hidráulica</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" rows="3" placeholder="Notas adicionales" <?php echo $disabled ?>
                                name="Observaciones"><?php echo isset($_POST['BotonRegistrar']) ? $_POST["Observaciones"] : "";
                                                        echo isset($_POST["ConsultarVehiculo"]) ? $consultarVehiculo[0]["OBSERVACIONES"] : ""; ?></textarea>
                        </div>
                    </div>


                    <?php if (!empty($Mensaje) && $Estilo == "warning") { ?>
                        <div class="mt-3 alert alert-<?php echo $Estilo; ?> alert-dismissible fade show" role="alert">
                            <?php echo $Mensaje; ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($Mensaje) && $Estilo == "success") { ?>
                        <div class="alert alert-<?php echo $Estilo; ?> alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            <?php echo $Mensaje; ?>
                        </div>
                    <?php } ?>


                    <div class="mt-4 d-flex d-flex justify-content-around">

                        <button type="submit" class="btn btn-primary" name="BotonRegistrar" <?php echo $disabled ?>>Confirmar</button>
                </form>
                <form method="post" action="OpVehiculos.php">
                    <input type="hidden" name="Volver" value="Volver">
                    <button type="submit" class="btn btn-danger" name="BotonCancelar">Cancelar</button>
                </form>

            </div>


        </div>
    </div>
    </div>


    <?php
    require_once "foot.php";
    ?>