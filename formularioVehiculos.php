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

if (isset($_POST['BotonRegistrar'])) {

    // Valido los datos
    $Mensaje = Validar_Datos();

    if (empty($Mensaje)) {

        if (VerificarVehiculoExiste($conexion)) {


            if (InsertarVehiculo($conexion) != false) {

                $Mensaje = 'Los datos se guardaron correctamente!';
                $_POST = array();
                $Estilo = 'success';
                // }
            }
        } else {
            $Mensaje = "El vehículo ya existe. Debes modificarlo desde la opcion correspondiente";
        }
    }
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
                <h4 class="mb-0">Registro de Vehículo</h4>
            </div>
            <div class="card-body ">
                <form role="form" method="post" action="">
                    <div class="row ">
                        <div class="col-md-2">
                            <label class="form-label">Matrícula</label>
                            <input type="text" class="form-control" placeholder="Ingrese matrícula" name="Matricula"
                                value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["Matricula"] : ""?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Modelo</label>
                            <select class="form-select" name="IdModelo"  >
                                <option value="">Seleccione un modelo</option>

                                <?php
                                $ListadoModelos = ListarModelos($conexion);
                                for ($i = 0; $i < count($ListadoModelos); $i++) {
                                ?>

                                <option value="<?php echo $ListadoModelos[$i]['ID_MODELO'];?>" 
                                <?php echo $ListadoModelos[$i]['ID_MODELO'] == $_POST["IdModelo"] ? "selected" : "" ?>>
                                    <?php echo $ListadoModelos[$i]['DESCRIPCION']; ?>
                                </option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>

                        <div class="col-md-1">
                            <label class="form-label">Grupo</label>
                            <input class="form-control" disabled></input>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Año</label>
                            <input type="text" class="form-control" placeholder="Año" name="anio" 
                            value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["anio"] : ""?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" placeholder="Color del vehículo" name="color" 
                            value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["color"] : ""?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Fecha de Compra</label>
                            <input type="date" class="form-control" name="fechaCompra"
                            value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["fechaCompra"] : ""?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha de Venta</label>
                            <input type="date" class="form-control" name="fechaVenta"
                            value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["fechaVenta"] : ""?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label">Número de Motor</label>
                            <input type="text" class="form-control" placeholder="Ingrese número de motor"
                                name="numeroMotor" value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["numeroMotor"] : ""?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Número de Chasis</label>
                            <input type="text" class="form-control" placeholder="Ingrese número de chasis"
                                name="numeroChasis" value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["numeroChasis"] : ""?>">
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Tipo de Combustible</label>
                            <select class="form-select" name="tipoCombustible">
                                <option value="">Seleccione</option>

                                <?php
                                $ListadoCombustibles = ListarCombustibles($conexion);
                                for ($i = 0; $i < count($ListadoCombustibles); $i++) {
                                ?>

                                <option value="<?php echo $ListadoCombustibles[$i]['ID']; ?>"
                                <?php echo $ListadoCombustibles[$i]['ID'] == $_POST["tipoCombustible"] ? "selected" : "" ?>>
                                    <?php echo $ListadoCombustibles[$i]['DESCRIPCION']; ?>
                                </option>
                                <?php
                                }
                                ?>




                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Puertas</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Asientos</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Disponible</label>
                            <select class="form-select" name="disponible">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kilometraje</label>
                            <input type="number" class="form-control" placeholder="Kilometraje actual"
                                name="kilometraje" value="<?php echo isset($_POST['BotonRegistrar']) ? $_POST["kilometraje"] : ""?>">
                        </div>
                    </div>

                    <div class="row mt-3">


                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="automatico" name="Automatico" 
                                <?php echo isset($_POST["Automatico"]) ? "checked" : "" ; ?>>
                                <label class="form-check-label" for="automatico">Automático</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aire" name="Aire" 
                                <?php echo isset($_POST["Aire"]) ? "checked" : "" ; ?>>
                                <label class="form-check-label" for="aire">Aire Acondicionado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="direccion" name="Direccion" 
                                <?php echo isset($_POST["Direccion"]) ? "checked" : "" ; ?>>
                                <label class="form-check-label" for="direccion">Dirección Hidráulica</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" rows="3" placeholder="Notas adicionales"
                                name="Observaciones"><?php echo isset($_POST['BotonRegistrar']) ? $_POST["Observaciones"] : ""?></textarea>
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


                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary" name="BotonRegistrar">Confirmar</button>
                        <button type="button" class="btn btn-danger" name="cancelarS">Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <?php
    require_once "foot.php";
    ?>