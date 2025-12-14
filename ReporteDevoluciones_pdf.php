<?php
session_start();

// -------------------------------------------------------------------------
// 1. INICIALIZACIÓN Y VALIDACIÓN DE DATOS
// -------------------------------------------------------------------------

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

// Inicio del buffer de salida para capturar todo el HTML
ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Generación del listado de Devolucion
require_once 'funciones/CRUD-Devolucion.php';
$ListadoDevolucion = Listar_Devolucion($conexion); 
$CantidadDevolucion = count($ListadoDevolucion);
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General de Devoluciones</title>
    
    <style>
        /* 1. Reset Básico y Tipografía */
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* 2. Cabecera del Documento (Limpia y Informativa) */
        .header-pdf {
            width: 100%;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #a80a0a; /* Color corporativo */
            overflow: hidden;
        }
        .header-pdf img {
            float: right;
            margin-left: 20px;
        }
        .header-pdf h1 {
            color: #12374e;
            font-size: 18pt;
            margin: 0 0 5px 0;
        }
        .header-pdf p {
            font-size: 10pt;
            color: #555;
            margin: 0;
        }

        /* 3. Estilo de Tabla Profesional (table-report) */
        .table-report {
            width: 100%;
            border-collapse: collapse; 
            margin-top: 15px;
            border: 1px solid #ddd;
        }
        .table-report th, .table-report td {
            border: 1px solid #ddd; 
            padding: 6px 8px; 
            text-align: left;
            font-size: 9pt;
            vertical-align: top;
        }
        
        /* Estilo de Encabezados (TH) */
        .table-report thead th {
            background-color: #a80a0a; /* Tu color rojo oscuro */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #a80a0a;
            font-size: 10pt;
            text-align: center;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        /* Estilo de Filas (Zebra stripe) */
        .table-report tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        
        /* 4. Manejo de Paginación (CRUCIAL para Dompdf) */
        .table-report thead {
            display: table-header-group; /* Hace que el encabezado se repita en cada página */
        }
        .table-report tbody tr { 
            page-break-inside: avoid; /* Evita cortar filas */
        }
        
        /* Estilo para el número de fila y Monto */
        .contador-col {
            text-align: center;
            font-weight: bold;
            color: #a80a0a;
        }
        .detalle-col {
            text-align: right;
            font-weight: bold;
            color: #12374e; /* Azul para el detalle */
        }

        /* 5. Pie de Página (Para el PDF) */
        .pdf-footer {
            width: 100%;
            text-align: center;
            position: fixed; 
            bottom: 10px; /* Distancia desde el borde inferior */
            left: 0;
            right: 0;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            font-size: 7.5pt;
            color: #777;
        }
        .pdf-footer a {
            color: #a80a0a;
            text-decoration: none;
        }
    </style>
</head>

<body style="margin: 0 2% 0 2%;">
    
    <div class="header-pdf">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Proyectos/Rocket/assets/img/logo-red.png" height="40" alt="Logo" />
        <h1>Reporte General de Devoluciones de Vehículos</h1>
        <p>Generado el: <?php echo date("d/m/Y H:i:s"); ?></p>
        <p>Total de Devoluciones en el Reporte: <strong><?php echo $CantidadDevolucion; ?></strong></p>
    </div>

    <?php if ($CantidadDevolucion > 0) { ?>
        <table class="table-report">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 10%;">Nro. Contrato</th>
                    <th style="width: 20%;">Cliente</th>
                    <th style="width: 15%;">Vehículo</th>
                    <th style="width: 15%;">Fecha Devolución</th>
                    <th style="width: 15%;">Oficina</th>
                    <th style="width: 20%;">Detalle Devolución</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $contador = 1; 
                foreach ($ListadoDevolucion as $devolucion) { ?>   
                    <tr>
                        <td class="contador-col">
                            <?php echo $contador; ?> 
                        </td>
                        <td> 
                            <?php 
                                // Clave: IdContrato
                                echo htmlspecialchars($devolucion['IdContrato'] ?? 'N/A'); 
                            ?>
                        </td>
                        <td> 
                            <?php 
                                // Claves: apellidoCliente, nombreCliente, dniCliente
                                $nombreCompleto = ($devolucion['apellidoCliente'] ?? '') . ', ' . ($devolucion['nombreCliente'] ?? '');
                                echo htmlspecialchars(trim($nombreCompleto)); ?> <br> 
                            <span style="font-size: 0.9em; color: #777;">DNI: <?php echo htmlspecialchars($devolucion['dniCliente'] ?? 'N/A'); ?></span>
                        </td>
                        <td> 
                            <?php 
                                // Claves: vehiculoMatricula, vehiculoModelo, vehiculoGrupo
                                $vehiculo = 'Patente ' . ($devolucion['vehiculoMatricula'] ?? 'N/A');
                                echo htmlspecialchars($vehiculo); ?> <br> 
                            <span style="font-size: 0.9em; color: #777;"><?php echo htmlspecialchars(($devolucion['vehiculoModelo'] ?? '') . ', ' . ($devolucion['vehiculoGrupo'] ?? '')); ?></span>
                        </td>
                        <td> 
                            <?php 
                                // CLAVE ASUMIDA: FechaDevolucion
                                echo htmlspecialchars($devolucion['FechaDevolucion'] ?? 'N/A'); 
                            ?>
                        </td>
                        <td> 
                            <?php 
                                // Claves: CiudadSucursal, DireccionSucursal (Asumida como Oficina de Devolución)
                                echo htmlspecialchars($devolucion['CiudadSucursal'] ?? 'N/A'); ?><br>
                            <span style="font-size: 0.9em; color: #777;"><?php echo htmlspecialchars($devolucion['DireccionSucursal'] ?? 'N/A'); ?></span>
                        </td>
                        <td class="detalle-col" style="text-align: right; padding: 4px;"> 
                            
                            <span style="font-size: 0.8em; color: #555; display: block; line-height: 1.2;">
                                Km Final: <?php echo htmlspecialchars($devolucion['KilometrajeDevolucion'] ?? 'N/A'); ?>
                            </span>
                            <span style="font-size: 0.8em; color: #555; display: block; line-height: 1.2;">
                                Combustible: <?php echo htmlspecialchars($devolucion['NivelCombustibleDevolucion'] ?? 'N/A'); ?>
                            </span>
                            <span style="font-size: 1em; color: #a80a0a; display: block; font-weight: bold; line-height: 1.2; border-top: 1px solid #ddd; padding-top: 2px; margin-top: 2px;">
                                Penalidades: $ <?php echo htmlspecialchars($devolucion['MontoPenalidades'] ?? '0.00'); ?> USD
                            </span>
                        </td>
                    </tr>
                    <?php $contador++; ?>
                <?php 
                } 
                ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p style="text-align: center; color: #a80a0a; font-weight: bold; margin-top: 30px;">
            No se encontraron registros de devoluciones para este reporte.
        </p>
    <?php } ?>

    <div class="pdf-footer">
        <p style="margin: 0 0 3px 0;">
            &copy; <?php echo date("Y"); ?> Rocket Rent a Car. Todos los derechos reservados.
        </p>
        <p style="margin: 0;">
            Desarrollado por: 
            <a href="https://www.linkedin.com/in/nicolas-servidio-del-monte/">NS</a> |
            <a href="https://www.linkedin.com/in/bruno-carossi-1b43b8178/">BC</a> |
            <a href="https://www.linkedin.com/in/facundo-mota-123380257/">FM</a>
        </p>
    </div>

</body>
</html>

<?php 

// -------------------------------------------------------------------------
// 7. FINALIZACIÓN Y GENERACIÓN DEL PDF (DOMPDF)
// --------------------------------------------------------------------------

$html = ob_get_clean(); // La variable $html ahora contiene la totalidad de la página.

require_once 'administrador/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();  

// Activamos la opción que nos permite mostrar imágenes remotas (logo)
$options = $dompdf->getOptions();  
$options->set(array('isRemoteEnabled' => true));  
$dompdf->setOptions($options);  

$dompdf->loadHtml($html);

// Generar el documento PDF:
// 'A4' y 'landscape' para una mejor visualización de muchas columnas
$dompdf->setPaper('A4', 'landscape');  

// Hacemos el render
$dompdf->render();

// Enviamos el documento al navegador
$dompdf->stream("ReporteDevoluciones", array("Attachment" => false));

// Finaliza el script
exit;
?>