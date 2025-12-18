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

// Obtener el ID del cliente de la URL
$idCliente = $_GET['mensaje'];

// Generación del listado de Devolucion, filtrado por cliente
require_once 'funciones/CRUD-Devolucion.php';
$ListadoDevolucion = Listar_DevolucionSegunCliente($idCliente, $conexion); 
$CantidadDevolucion = count($ListadoDevolucion);

// Obtener datos del cliente (si hay devoluciones)
$datosCliente = [];
if ($CantidadDevolucion > 0) {
    $datosCliente = $ListadoDevolucion[0]; 
}

$nombreCliente = htmlspecialchars($datosCliente['nombreCliente'] ?? 'N/A');
$apellidoCliente = htmlspecialchars($datosCliente['apellidoCliente'] ?? 'N/A');
$dniCliente = htmlspecialchars($datosCliente['dniCliente'] ?? 'N/A');
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Devoluciones por Cliente</title>
    
    <style>
        /* ESTILO COPIADO EXACTAMENTE DE REPORTE CONTRATOS */
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .header-pdf {
            width: 100%;
            margin-bottom: 25px;
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

        .info-meta {
            width: 100%;
            margin-bottom: 20px;
            font-size: 9pt;
            color: #444;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #a80a0a;
            color: white;
            text-transform: uppercase;
            font-size: 9pt;
            padding: 10px;
            border: 1px solid #860808;
            text-align: center;
        }
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
            font-size: 9pt;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .precio {
            color: #c7240e;
            font-weight: bold;
        }

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
                    <h1>Reporte por Cliente</h1>
                    <p style="margin: 5px 0 0 0; font-weight: bold;">Historial de Devoluciones de Vehículos</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-meta">
        <tr>
            <td><strong>Cliente:</strong> <?php echo $apellidoCliente . ", " . $nombreCliente; ?></td>
            <td class="text-right"><strong>DNI:</strong> <?php echo $dniCliente; ?></td>
        </tr>
        <tr>
            <td><strong>Fecha de emisión:</strong> <?php echo date("d/m/Y H:i"); ?></td>
            <td class="text-right"><strong>Registros:</strong> <?php echo $CantidadDevolucion; ?></td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Contrato</th>
                <th>Fecha Dev.</th>
                <th>Hora Dev.</th>
                <th>Vehículo</th>
                <th>Estado del Vehículo</th>
                <th>Costos por Infracciones</th>
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
                    <td class="text-center"><?php echo $devolucion['FechaDevolucion']; ?></td>
                    <td class="text-center"><?php echo $devolucion['HoraDevolucion']; ?></td>
                    <td>
                        <strong><?php echo $devolucion['vehiculoMatricula']; ?></strong><br>
                        <?php echo $devolucion['vehiculoModelo']; ?>
                    </td>
                    <td>
                        <strong><?php echo $devolucion['EstadoDevolucion']; ?></strong><br>
                        <small><?php echo $devolucion['AclaracionesDevolucion']; ?></small>
                    </td>
                    <td>
                        <div style="font-size: 8pt;">
                            <?php echo $devolucion['InfraccionesDevolucion']; ?>
                        </div><br>
                        <span class="precio">Infracciones: <?php echo $devolucion['CostosInfracciones']; ?> US$</span><br>
                        <span class="precio">Adicional: <?php echo $devolucion['MontoExtra']; ?> US$</span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pdf-footer">
        <p style="margin: 0 0 3px 0;">
            &copy; <?php echo date("Y"); ?> Rocket Rent a Car. Todos los derechos reservados.
        </p>
        <p style="margin: 0;">NS | BC | FM - Reporte de Control Interno</p>
    </div>

</body>
</html>
<?php 
$html = ob_get_clean();

require_once 'administrador/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();  

$options = $dompdf->getOptions();  
$options->set(array('isRemoteEnabled' => true));  
$dompdf->setOptions($options);  

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); 
$dompdf->render();

$dompdf->stream("Reporte_Devoluciones_Cliente.pdf", array("Attachment" => false));
?>