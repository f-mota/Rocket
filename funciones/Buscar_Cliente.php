<?php
require_once '../conn/conexion.php';
$conexion = ConexionBD();

header('Content-Type: application/json');

$response = [];

// Lógica para la búsqueda en tiempo real desde el modal de Nueva Reserva
if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conexion, $_GET['query']);

    // Buscar por documento O por apellido
    $sql = "SELECT idCliente as id, dniCliente as documento, apellidoCliente as apellido, nombreCliente as nombre 
            FROM clientes 
            WHERE dniCliente LIKE '$query%' OR apellidoCliente LIKE '$query%'
            LIMIT 10";

    $result = mysqli_query($conexion, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
    }
} 
// Mantengo la lógica anterior por si se usa en otra parte del sistema
else if (isset($_GET['documento'])) {
    $documento = mysqli_real_escape_string($conexion, $_GET['documento']);
    $sql = "SELECT idCliente as id, apellidoCliente as apellido, nombreCliente as nombre FROM clientes WHERE dniCliente = '$documento'";
    $result = mysqli_query($conexion, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $response = ['encontrado' => true] + $row;
    } else {
        $response = ['encontrado' => false];
    }
}

mysqli_close($conexion);
echo json_encode($response);
?>