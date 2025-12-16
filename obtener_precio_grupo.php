<?php
// Asegurar que la respuesta sea JSON

// INICIO DE SESIÓN Y VALIDACIÓN DE USUARIO
session_start();
require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario();

header('Content-Type: application/json');

// Requerir la conexión a la base de datos (según tu estructura)
require_once 'conn/conexion.php'; 
$MiConexion = ConexionBD();

// Inicializar la respuesta
$respuesta = ['success' => false, 'precio' => 0.00, 'message' => ''];

// Verificar si se recibió el ID del vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idVehiculo'])) {
    
    // 1. Obtener y sanitizar el ID del vehículo
    $idVehiculo = intval($_POST['idVehiculo']);

    if ($idVehiculo > 0) {
        
        // 2. Consulta SQL para obtener el precio del grupo
        // Se asume que:
        // - La tabla de vehículos se llama 'vehiculos'.
        // - La tabla de grupos se llama 'grupo-vehiculos'.
        // - 'vehiculos' tiene el campo 'idGrupo'.
        // - 'grupo-vehiculos' tiene los campos 'idGrupo' y 'precioGrupo'.
        $SQL_PRECIO = "SELECT g.precioGrupo 
                       FROM vehiculos v
                       INNER JOIN `grupos-vehiculos` g ON v.idGrupoVehiculo = g.idGrupo
                       WHERE v.idVehiculo = $idVehiculo";
        
        $rs = mysqli_query($MiConexion, $SQL_PRECIO);

        if ($rs && $data = mysqli_fetch_assoc($rs)) {
            // Éxito: Encontramos el precio
            $respuesta['success'] = true;
            // Convertimos a float para asegurar el formato numérico
            $respuesta['precio'] = (float) $data['precioGrupo']; 
        } else {
            $respuesta['message'] = 'Vehículo o precio de grupo no encontrado.';
        }
        
        // Liberar el resultado
        if ($rs) {
            mysqli_free_result($rs);
        }
        
    } else {
        $respuesta['message'] = 'ID de vehículo inválido.';
    }

} else {
    $respuesta['message'] = 'Método no permitido o ID de vehículo faltante.';
}

// 3. Devolver la respuesta JSON
echo json_encode($respuesta);

// Cerrar la conexión
if (isset($MiConexion)) {
    mysqli_close($MiConexion);
}
?>