<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('head.php');
include('conn/conexion.php');

$conexion = ConexionBD();

// Verificar si el ID del vehículo está presente en la URL
if (isset($_GET['id'])) {
    $idVehiculo = $_GET['id'];

    // MODIFICADO: Consulta para cambiar los atributos 'activo' a 0 y 'disponibilidad' a 'N' (eliminación lógica)
    $sql = "UPDATE vehiculos SET activo = 0, disponibilidad = 'N' WHERE idVehiculo=?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idVehiculo);
    $stmt->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Redirigir al listado de vehículos con el parámetro para mostrar el modal de éxito.
        header('Location: OpVehiculos.php?eliminado=exito');
        exit();
    } else {
        // Si no se actualizó ningún registro, mostrar un mensaje de error
        header('Location: OpVehiculos.php?mensaje=Error al marcar el vehículo como INACTIVO. Puede que ya lo esté o el ID es incorrecto.');
        exit();
    }
} else {
    // Si no se pasa un ID, redirigir al listado de vehículos
    header('Location: OpVehiculos.php?mensaje=No se reconoce ningún ID.');
    exit();
}