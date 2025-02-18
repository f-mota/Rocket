<?php
session_start();
require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

require_once "conn/conexion.php";
$conexion = ConexionBD();

require_once "head.php";


?>
<body>

<?php
require_once "topNavBar.php";

require_once "sidebarGop.php";

?>

<div class="container mt-7" >

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registro de Vehículo</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Matrícula</label>
                        <input type="text" class="form-control" placeholder="Ingrese matrícula">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Código Grupo</label>
                        <select class="form-select">
                            <option value="">Seleccione un grupo</option>
                            <option value="A">Grupo A</option>
                            <option value="B">Grupo B</option>
                            <option value="C">Grupo C</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Modelo</label>
                        <select class="form-select">
                            <option value="">Seleccione un modelo</option>
                            <option value="sedan">Sedán</option>
                            <option value="suv">SUV</option>
                            <option value="pickup">Pickup</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Color</label>
                        <input type="text" class="form-control" placeholder="Color del vehículo">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Compra</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Venta</label>
                        <input type="date" class="form-control">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Número de Motor</label>
                        <input type="text" class="form-control" placeholder="Ingrese número de motor">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Número de Chasis</label>
                        <input type="text" class="form-control" placeholder="Ingrese número de chasis">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Año</label>
                        <input type="number" class="form-control" placeholder="Año de fabricación">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Puertas</label>
                        <input type="number" class="form-control" placeholder="Cantidad de puertas">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Asientos</label>
                        <input type="number" class="form-control" placeholder="Cantidad de asientos">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Disponible</label>
                        <select class="form-select">
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Combustible</label>
                        <select class="form-select">
                            <option value="">Seleccione</option>
                            <option value="gasolina">Gasolina</option>
                            <option value="diesel">Diésel</option>
                            <option value="hibrido">Híbrido</option>
                            <option value="electrico">Eléctrico</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kilometraje</label>
                        <input type="number" class="form-control" placeholder="Kilometraje actual">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="automatico">
                            <label class="form-check-label" for="automatico">Automático</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="aire">
                            <label class="form-check-label" for="aire">Aire Acondicionado</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="direccion">
                            <label class="form-check-label" for="direccion">Dirección Hidráulica</label>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" rows="3" placeholder="Notas adicionales"></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Guardar Vehículo</button>
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                </div>

            </form>
        </div>
    </div>
</div>


<?php
    require_once "foot.php";
?>