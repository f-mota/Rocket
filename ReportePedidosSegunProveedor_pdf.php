<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

$idProveedor = $_GET['mensaje'];

// Generación del listado de pedidos a proveedores
require_once 'funciones/CRUD-PedidosProv.php';
$ListadoPedidos = Listar_PedidosProveedoresSegunProveedor($conexion, $idProveedor);
$CantidadPedidos = count($ListadoPedidos);

include('head.php');

?>

<body style="margin: 0; padding: 0; font-family: 'Helvetica', sans-serif; color: #444;">

    <style>
        /* ESTILO PROFESIONAL ROCKET V2 - FILTRADO POR PROVEEDOR */
        .header-main {
            width: 100%;
            border-bottom: 3px solid #a80a0a;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-img { width: 150px; }
        .report-title {
            text-align: right;
            vertical-align: bottom;
        }
        .report-title h1 {
            color: #a80a0a;
            margin: 0;
            font-size: 20pt;
            text-transform: uppercase;
        }
        
        .pedido-container {
            margin-bottom: 30px;
            border: 1px solid #eee;
            border-radius: 5px;
            overflow: hidden;
            page-break-inside: avoid; /* Evita que un pedido se corte entre dos páginas */
        }
        .pedido-header {
            background-color: #fcfcfc;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .pedido-id {
            color: #a80a0a;
            font-size: 13pt;
            font-weight: bold;
        }
        
        .table-info {
            width: 100%;
            margin: 10px;
            font-size: 9pt;
        }
        .table-info td { padding: 4px; }
        .label { color: #888; text-transform: uppercase; font-size: 7pt; font-weight: bold; }

        .table-items {
            width: 100%;
            border-collapse: collapse;
        }
        .table-items th {
            background-color: #f4f4f4;
            color: #555;
            font-size: 8pt;
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .table-items td {
            padding: 8px;
            font-size: 8.5pt;
            border-bottom: 1px solid #f0f0f0;
        }
        .row-item:nth-child(even) { background-color: #fafafa; }
        
        .total-box {
            background-color: #a80a0a;
            color: white;
            padding: 10px;
            text-align: right;
            font-size: 11pt;
            font-weight: bold;
        }

        .pdf-footer {
            position: fixed;
            bottom: -10px;
            width: 100%;
            text-align: center;
            font-size: 7pt;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>

    <table class="header-main">
        <tr>
            <td><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/proyectos/rocket/assets/img/logo-red.png" class="logo-img"></td>
            <td class="report-title">
                <h1>Reporte por Proveedor</h1>
                <span style="font-size: 9pt;">Historial Detallado de Pedidos</span>
            </td>
        </tr>
    </table>

    <p style="font-size: 8pt; color: #666; margin-bottom: 20px;">
        <strong>Proveedor ID:</strong> <?php echo $idProveedor; ?> | 
        <strong>Emisión:</strong> <?php echo date("d/m/Y H:i"); ?> | 
        <strong>Total Pedidos Encontrados:</strong> <?php echo $CantidadPedidos; ?>
    </p>

    <?php 
    $contador = 1;
    foreach ($ListadoPedidos as $ppIdPedido => $Pedido) { ?>
        
        <div class="pedido-container">
            <div class="pedido-header">
                <table style="width: 100%;">
                    <tr>
                        <td class="pedido-id">ORDEN DE COMPRA #<?php echo $Pedido['ppIdPedido']; ?></td>
                        <td style="text-align: right; font-size: 8pt; color: #888;">Registro N° <?php echo $contador; ?></td>
                    </tr>
                </table>
            </div>

            <table class="table-info">
                <tr>
                    <td width="35%">
                        <span class="label">Datos del Proveedor</span><br>
                        <strong><?php echo $Pedido['NombreProveedor']; ?></strong><br>
                        <small>CUIT: <?php echo $Pedido['CuitProveedor']; ?></small><br>
                        <small><?php echo $Pedido['MailProveedor']; ?></small>
                    </td>
                    <td width="30%">
                        <span class="label">Cronología</span><br>
                        Emisión: <?php echo $Pedido['FechaPedido']; ?><br>
                        Entrega: <?php echo $Pedido['FechaEntrega']; ?>
                    </td>
                    <td width="35%">
                        <span class="label">Estado y Logística</span><br>
                        <strong><?php echo strtoupper($Pedido['EstadoPedido']); ?></strong><br>
                        <small><?php echo $Pedido['CondicionesDeEntrega']; ?></small>
                    </td>
                </tr>
            </table>

            <table class="table-items">
                <thead>
                    <tr>
                        <th width="15%">TIPO</th>
                        <th width="45%">ARTÍCULO / DESCRIPCIÓN</th>
                        <th width="10%" style="text-align: center;">CANT.</th>
                        <th width="15%" style="text-align: right;">P. UNIT</th>
                        <th width="15%" style="text-align: right;">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Pedido['Detalles'] as $detalleId => $Detalle) { ?>
                        <tr class="row-item">
                            <td style="font-size: 7pt; color: #888;"><?php echo $Detalle['TipoInsumo']; ?></td>
                            <td>
                                <strong><?php 
                                    if ($Detalle['TipoInsumo'] == "Repuesto") echo $Detalle['NombreRepuesto'];
                                    elseif ($Detalle['TipoInsumo'] == "Producto") echo $Detalle['NombreProducto'];
                                    elseif ($Detalle['TipoInsumo'] == "Accesorio") echo $Detalle['NombreAccesorio'];
                                ?></strong><br>
                                <small style="color: #777;">
                                    <?php 
                                        if ($Detalle['TipoInsumo'] == "Repuesto") echo $Detalle['DescripcionRepuesto'];
                                        elseif ($Detalle['TipoInsumo'] == "Producto") echo $Detalle['DescripcionProducto'];
                                        elseif ($Detalle['TipoInsumo'] == "Accesorio") echo $Detalle['DescripcionAccesorio'];
                                    ?>
                                </small>
                            </td>
                            <td style="text-align: center;"><?php echo $Detalle['CantidadUnidades']; ?></td>
                            <td style="text-align: right;"><?php echo $Detalle['PrecioPorUnidad']; ?> USD</td>
                            <td style="text-align: right; font-weight: bold;"><?php echo $Detalle['Subtotal']; ?> USD</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="total-box">
                TOTAL PEDIDO: <?php echo $Pedido['TotalPedido']; ?> USD
            </div>
        </div>

    <?php $contador++; } ?>

    <div class="pdf-footer">
        &copy; <?php echo date("Y"); ?> Rocket Rent a Car | Reporte de Auditoría de Proveedores | Generado por Rocket Team
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
$dompdf->setPaper('A4', 'portrait');  
$dompdf->render();

$dompdf->stream("Reporte-Pedidos-Proveedor-".$idProveedor, array("Attachment" => false)); 
?>