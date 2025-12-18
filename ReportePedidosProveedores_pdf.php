<?php
session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Generación del listado de pedidos a proveedores
require_once 'funciones/CRUD-PedidosProv.php'; 
$ListadoPedidos = Listar_PedidosProveedores($conexion); 
$CantidadPedidos = count($ListadoPedidos);

include('head.php');
?>

<body style="margin: 0; padding: 0; font-family: 'Helvetica', sans-serif; color: #444;">

    <style>
        /* ESTILO PROFESIONAL ROCKET V2 */
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
            font-size: 22pt;
            text-transform: uppercase;
        }
        
        /* Contenedor de cada pedido */
        .pedido-container {
            margin-bottom: 30px;
            border: 1px solid #eee;
            border-radius: 5px;
            overflow: hidden;
        }
        .pedido-header {
            background-color: #fcfcfc;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .pedido-id {
            color: #a80a0a;
            font-size: 14pt;
            font-weight: bold;
        }
        
        /* Tabla de metadatos del pedido (Proveedor, Fechas) */
        .table-info {
            width: 100%;
            margin: 10px;
            font-size: 9pt;
        }
        .table-info td { padding: 4px; }
        .label { color: #888; text-transform: uppercase; font-size: 7pt; font-weight: bold; }

        /* Tabla de artículos */
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
            font-size: 12pt;
            font-weight: bold;
        }

        .footer {
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
                <h1>Reporte de Compras</h1>
                <span style="font-size: 9pt;">Gestión de Pedidos a Proveedores</span>
            </td>
        </tr>
    </table>

    <p style="font-size: 8pt; color: #666;">Emitido el: <?php echo date("d/m/Y H:i"); ?> | Total Pedidos: <?php echo $CantidadPedidos; ?></p>

    <?php 
    $contador = 1;
    foreach ($ListadoPedidos as $ppIdPedido => $Pedido) { ?>
        
        <div class="pedido-container">
            <div class="pedido-header">
                <table style="width: 100%;">
                    <tr>
                        <td class="pedido-id">PEDIDO #<?php echo $Pedido['ppIdPedido']; ?></td>
                        <td style="text-align: right; font-size: 9pt;">Fila: <?php echo $contador; ?></td>
                    </tr>
                </table>
            </div>

            <table class="table-info">
                <tr>
                    <td width="33%">
                        <span class="label">Proveedor</span><br>
                        <strong><?php echo $Pedido['NombreProveedor']; ?></strong><br>
                        <?php echo $Pedido['CuitProveedor']; ?>
                    </td>
                    <td width="33%">
                        <span class="label">Fechas</span><br>
                        Pedido: <?php echo $Pedido['FechaPedido']; ?><br>
                        Entrega: <?php echo $Pedido['FechaEntrega']; ?>
                    </td>
                    <td width="33%">
                        <span class="label">Estado</span><br>
                        <strong><?php echo strtoupper($Pedido['EstadoPedido']); ?></strong><br>
                        <small><?php echo $Pedido['CondicionesDeEntrega']; ?></small>
                    </td>
                </tr>
            </table>

            <table class="table-items">
                <thead>
                    <tr>
                        <th>TIPO</th>
                        <th>DESCRIPCIÓN DEL ARTÍCULO</th>
                        <th style="text-align: center;">CANT.</th>
                        <th style="text-align: right;">P. UNIT</th>
                        <th style="text-align: right;">SUBTOTAL</th>
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
                                <small style="color: #666; font-style: italic;">
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
                MONTO TOTAL: <?php echo $Pedido['TotalPedido']; ?> USD
            </div>
        </div>

    <?php $contador++; } ?>

    <div class="footer">
        Rocket Rent a Car - Gestión Interna de Proveedores - Página de reporte confidencial.
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
$dompdf->stream("ReportePedidosAProveedores", array("Attachment" => false)); 
?>