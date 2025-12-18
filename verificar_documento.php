<?php
session_start();

require_once 'corroborar_usuario.php';
Corroborar_Usuario();

require_once '../conn/conexion.php';

if (isset($_POST['documento'])) {
    $documento = trim($_POST['documento']);
    $response = ['exists' => false];

    if (!empty($documento) && is_numeric($documento)) {
        $conexion = ConexionBD();
        $query = "SELECT idCliente FROM clientes WHERE dniCliente = ? AND activo = 1";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $documento);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $response['exists'] = true;
        }
        $stmt->close();
        $conexion->close();
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>