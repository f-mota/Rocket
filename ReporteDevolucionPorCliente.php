<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {?>

<?php

    $idCliente = $_POST['idCliente'];

    // Generación del listado de Devolucion
    require_once 'funciones/CRUD-Devolucion.php';
    $ListadoDevolucion = Listar_DevolucionSegunCliente($idCliente, $conexion);
    $CantidadDevolucion = count($ListadoDevolucion);

    include('head.php');

    ?>

<body class="bg-light" style="margin: 0 auto;">
    <div class="wrapper" style="margin-bottom: 0; min-height: 100%;">
        <div class="container" style="max-width: 97%;">

            <div class="table-responsive p-5 mb-4 bg-white shadow-sm"
                style="max-width: 97%; max-height: 700px; margin-top: 10%;">

                <h3 class="mb-4 " style="color: rgb(18, 55, 78); padding: 0 0 20px 0;">
                    <strong>Reporte: Devolucion de vehículos según cliente </strong>
                </h3>


                <?php // solo genero el reporte si $ListadoDevolucion no está vacío
                    
                    if(!empty($ListadoDevolucion)) {?>

                <h5 class="mb-4 " style="color:rgb(18, 55, 78); padding: 0 0 20px 0;">
                    Cliente:
                    <?php echo "{$ListadoDevolucion[0]['apellidoCliente']} {$ListadoDevolucion[0]['nombreCliente']} (DNI: {$ListadoDevolucion[0]['dniCliente']})"; ?>
                </h5>

                <table class="table table-striped table-hover" id="tablaDevolucion">
                    <thead>
                        <tr>
                            <th style='color: #12374e;'>
                                <h3>#</h3>
                            </th>
                            <th>Contrato</th>
                            <th>Fecha Dev.</th>
                            <th>Hora Dev.</th>
                            <th>Vehículo</th>
                            <th>Oficina Dev.</th>
                            <th>Estado del Vehículo</th>
                            <th>Aclaraciones sobre el estado</th>
                            <th>Infracciones</th>
                            <th>Costos por Infracciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
    $contador = 1; 
    for ($i=0; $i < $CantidadDevolucion; $i++) { ?>

                        <tr class='devolucion'>
                            <td><span style='color: #12374e;'>
                                    <h4> <?php echo $contador; ?> </h4>
                                </span></td>
                            <td> <?php echo $ListadoDevolucion[$i]['IdContrato']; ?> </td>
                            <td> <?php echo $ListadoDevolucion[$i]['FechaDevolucion']; ?> </td>
                            <td> <?php echo $ListadoDevolucion[$i]['HoraDevolucion']; ?> </td>
                            <td> <?php echo "Patente {$ListadoDevolucion[$i]['vehiculoMatricula']} </br> {$ListadoDevolucion[$i]['vehiculoModelo']}, {$ListadoDevolucion[$i]['vehiculoGrupo']}"; ?>
                            </td>
                            <td> <?php echo "{$ListadoDevolucion[$i]['CiudadSucursal']}, {$ListadoDevolucion[$i]['DireccionSucursal']}"; ?>
                            </td>

                            <td> <?php echo $ListadoDevolucion[$i]['EstadoDevolucion']; ?> </td>
                            <td> <?php echo $ListadoDevolucion[$i]['AclaracionesDevolucion']; ?> </td>
                            <td> <?php echo $ListadoDevolucion[$i]['InfraccionesDevolucion']; ?> </td>
                            <td>
                                Costos
                                por<br>infracciones:<br><b><?php echo $ListadoDevolucion[$i]['CostosInfracciones']; ?>
                                    US$</b><br><br>
                                Cargo adicional:<br><b><?php echo $ListadoDevolucion[$i]['MontoExtra']; ?> US$</b>
                            </td>
                        </tr>
                        <?php $contador++; ?>
                        <?php 
    } 
    ?>
                    </tbody>
                </table>
                <?php } 

                    else { ?>

                <h5 class="mb-4 " style="color:rgb(18, 55, 78); padding: 0 0 20px 0;">
                    No existen registros asociados al cliente
                </h5>

                <?php } ?>

            </div>
        </div>

        <!-- Botón de acción -->
        <div style="margin-top: 5%; margin-bottom: 5%;">
            <div class="container d-flex justify-content-center">
                <span style="margin-right: 10%;">
                    <a href="DevolucionVehiculo.php"> <button class="btn"
                            style="color: white; background-color: #a80a0a;">
                            Volver
                        </button></a>
                </span>

                <?php if(!empty($ListadoDevolucion)) {?>
                <a href="ReporteDevolucionPorCliente_pdf.php?mensaje=<?php echo urlencode($idCliente); ?> ">
                    <button class="btn btn-warning">
                        Exportar
                    </button>
                </a>
                <?php } ?>
            </div>
        </div>

    </div>

    <div style="">
        <?php require_once "foot.php"; ?>
    </div>

</body>

</html>

<?php } ?>

<?php
$html = ob_get_clean();
echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

?>