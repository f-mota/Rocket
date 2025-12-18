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
        /* 1. Reset Básico y Tipografía (Copiado de ReporteContratos) */
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* 2. Cabecera del Documento */
        .header-pdf {
            width: 100%;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #a80a0a;
        }
        .header-pdf table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-pdf .logo {
            width: 150px;
        }
        .header-pdf .titulo-reporte {
            text-align: right;
            color: #a80a0a;
        }
        .header-pdf h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }

        /* 3. Información de Metadatos */
        .info-meta {
            width: 100%;
            margin-bottom: 15px;
            font-size: 8.5pt;
            color: #555;
        }

        /* 4. Estilos de la Tabla Principal */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #a80a0a;
            color: white;
            text-transform: uppercase;
            font-size: 8.5pt;
            padding: 8px;
            border: 1px solid #860808;
            text-align: center;
        }
        .table td {
            padding: 7px;
            border: 1px solid #ddd;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* 5. Clases de Utilidad */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .precio {
            color: #c7240e;
            font-weight: bold;
            font-size: 10pt;
        }
        .label-secundario {
            color: #666;
            font-size: 7.5pt;
        }

        /* 6. Pie de Página */
        .pdf-footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 8pt;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header-pdf">
        <table>
            <tr>
                <td class="logo">
                    <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/rocket/img/logo_rojo.png" alt="Logo" style="width: 140px;">
                </td>
                <td class="titulo-reporte">
                    <h1>Reporte General</h1>
                    <p style="margin: 5px 0 0 0; font-weight: bold;">Listado de Devoluciones de Vehículos</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-meta">
        <tr>
            <td><strong>Fecha de emisión:</strong> <?php echo date("d/m/Y H:i"); ?></td>
            <td class="text-right"><strong>Registros encontrados:</strong> <?php echo $CantidadDevolucion; ?></td>
        </tr>
        <tr>
            <td><strong>Generado por:</strong> <?php echo $_SESSION['Usuario']; ?></td>
            <td class="text-right">Rocket Rent a Car - Sistema de Gestión</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 40px;">#</th>
                <th style="width: 60px;">Contrato</th>
                <th>Fecha/Hora Dev.</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Estado y Aclaraciones</th>
                <th>Costos Detallados</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $contador = 1;
            foreach ($ListadoDevolucion as $devolucion): 
            ?>
                <tr>
                    <td class="text-center font-bold" style="color: #a80a0a;"><?php echo $contador++; ?></td>
                    <td class="text-center font-bold"><?php echo $devolucion['IdContrato']; ?></td>
                    <td>
                        <?php echo date("d/m/Y", strtotime($devolucion['FechaDevolucion'])); ?><br>
                        <span class="label-secundario"><?php echo $devolucion['HoraDevolucion']; ?> hs</span>
                    </td>
                    <td>
                        <span class="font-bold"><?php echo $devolucion['apellidoCliente'] . ", " . $devolucion['nombreCliente']; ?></span><br>
                        <span class="label-secundario">DNI: <?php echo $devolucion['dniCliente']; ?></span>
                    </td>
                    <td>
                        <span class="font-bold"><?php echo $devolucion['vehiculoMatricula']; ?></span><br>
                        <span class="label-secundario"><?php echo $devolucion['vehiculoModelo']; ?></span>
                    </td>
                    <td>
                        <span class="font-bold">Estado:</span> <?php echo $devolucion['EstadoDevolucion']; ?><br>
                        <span class="label-secundario"><?php echo $devolucion['AclaracionesDevolucion']; ?></span>
                    </td>
                    <td>
                        <div style="margin-bottom: 5px;">
                            <span class="label-secundario">Infracciones:</span><br>
                            <span class="precio"><?php echo number_format($devolucion['CostosInfracciones'], 2); ?> US$</span>
                        </div>
                        <div>
                            <span class="label-secundario">Cargo Extra:</span><br>
                            <span class="precio"><?php echo number_format($devolucion['MontoExtra'], 2); ?> US$</span>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pdf-footer">
        <p style="margin: 0 0 3px 0;">
            &copy; <?php echo date("Y"); ?> Rocket Rent a Car. Todos los derechos reservados.
        </p>
        <p style="margin: 0;">
            NS | BC | FM - Reporte de Control Interno
        </p>
    </div>

</body>
</html>
<?php 

// -------------------------------------------------------------------------
// 7. FINALIZACIÓN Y GENERACIÓN DEL PDF (DOMPDF)
// --------------------------------------------------------------------------

$html = ob_get_clean();

require_once 'administrador/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();  

$options = $dompdf->getOptions();  
$options->set(array('isRemoteEnabled' => true));  
$dompdf->setOptions($options);  

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // Se recomienda horizontal por la cantidad de columnas
$dompdf->render();

$dompdf->stream("Reporte_Devoluciones_" . date('Ymd') . ".pdf", array("Attachment" => false));
?>