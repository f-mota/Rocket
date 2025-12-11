<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

// Verificar si el ID de la reserva está presente en la URL
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];
    
    // Capturar el comentario enviado desde el front-end.
    // Se decodifica por si contiene caracteres especiales
    $comentario = isset($_GET['comentario']) ? urldecode($_GET['comentario']) : 'Cancelada por acción directa del usuario.';
    
    // Consulta para CANCELAR (Actualización Lógica) la reserva en la tabla `reservas-vehiculos`:
    // 1. Establecer 'activo' a 0 (Falso/Cancelada).
    // 2. Establecer el 'comentario'.
    $SQLupdate = "UPDATE `reservas-vehiculos` 
                  SET activo = 0, comentario = ?
                  WHERE idReserva = ?";
    
    $stmt = $MiConexion->prepare($SQLupdate);
    // Bind: 's' para el comentario (string), 'i' para el idReserva (integer)
    $stmt->bind_param("si", $comentario, $idReserva);
    $stmt->execute();

    // Verificar si la cancelación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Redirigir al listado de reservas con un mensaje de éxito
        header('Location: reservas.php?status=success&mensaje=La reserva ha sido CANCELADA correctamente.');
        exit();
    } else if ($stmt->affected_rows === 0 && $stmt->error == "") {
        // Si affected_rows es 0 y no hay error, puede que la reserva ya estuviera cancelada
        header('Location: reservas.php?status=error&mensaje=La reserva ya estaba cancelada o no se realizaron cambios.');
        exit();
    } else {
        // Mostrar un mensaje de error de la base de datos
        header('Location: reservas.php?status=error&mensaje=Error al CANCELAR la reserva: ' . $stmt->error);
        exit();
    }
} 
else {
    // Si no se pasó un ID, redirigir al listado de reservas
    header('Location: reservas.php?status=error&mensaje=No se reconoció ninguna reserva para cancelar.');
    exit();
}

?>