<?php
// Procesar_Nueva_Reserva.php
session_start(); 

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

// 1. Incluir conexión
require_once "conn/conexion.php";
$conexion = ConexionBD();

// Verificar si la petición es POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: reservas.php?status=error&mensaje=" . rawurlencode("Acceso denegado."));
    die();
}

// 2. Obtener datos del formulario
$idCliente = $_POST['idCliente'] ?? null;
$documentoCliente = trim($_POST['documentoCliente']);
$apellidoCliente = trim($_POST['apellidoCliente']);
$nombreCliente = trim($_POST['nombreCliente']);
$idVehiculo = $_POST['idVehiculo'];
$precioPorDia = $_POST['PrecioPorDia'];
$fechaRetiro = $_POST['fecharetiro'];
$fechaDevolucion = $_POST['fechadevolucion'];

// Obtener idSucursal (AJUSTAR ESTA LÍNEA SEGÚN CÓMO MANEJES LA SUCURSAL DEL USUARIO LOGUEADO)
// Asumimos que la sucursal del usuario logueado está en $_SESSION['idSucursal']
$idSucursal = $_SESSION['idSucursal'] ?? 1; // Default a 1 si no se encuentra en sesión

// 3. Validación de Fechas (Back-end)
$hoy = date('Y-m-d');

if ($fechaRetiro < $hoy) {
    header("Location: reservas.php?status=error&mensaje=" . rawurlencode("Error: La fecha de retiro no puede ser anterior a hoy ({$hoy})."));
    die();
}

if ($fechaDevolucion <= $fechaRetiro) {
    header("Location: reservas.php?status=error&mensaje=" . rawurlencode("Error: La fecha de devolución ({$fechaDevolucion}) debe ser posterior a la fecha de retiro ({$fechaRetiro})."));
    die();
}

// 4. Manejo del Cliente (Existente o Nuevo)
try {
    
    // Si el idCliente no viene oculto, o si los datos del cliente son esenciales para la reserva
    if (empty($idCliente)) {
        
        // 4a. Buscar cliente por DNI por si fue ingresado manualmente
        $SQL_BUSCAR = "SELECT idCliente FROM clientes WHERE dniCliente = ?";
        $stmt = $conexion->prepare($SQL_BUSCAR);
        $stmt->bind_param("s", $documentoCliente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            // Cliente encontrado, lo usamos.
            $data = $resultado->fetch_assoc();
            $idCliente = $data['idCliente'];
            
        } else {
            // 4b. Cliente no encontrado, lo insertamos
            if (empty($apellidoCliente) || empty($nombreCliente) || empty($documentoCliente)) {
                throw new Exception("Datos de cliente incompletos (Documento, Nombre y Apellido) para crear uno nuevo.");
            }
            
            $SQL_INSERT_CLIENTE = "INSERT INTO clientes (dniCliente, nombreCliente, apellidoCliente) VALUES (?, ?, ?)";
            $stmt_insert = $conexion->prepare($SQL_INSERT_CLIENTE);
            $stmt_insert->bind_param("sss", $documentoCliente, $nombreCliente, $apellidoCliente);
            
            if (!$stmt_insert->execute()) {
                throw new Exception("Error al insertar nuevo cliente: " . $stmt_insert->error);
            }
            
            // Obtener el ID del cliente recién creado
            $idCliente = $conexion->insert_id;
            $stmt_insert->close();
        }
        $stmt->close();
    }
    
    if (empty($idCliente)) {
        throw new Exception("No se pudo identificar o crear el cliente.");
    }
    
    // 5. Cálculo de días y monto total
    $fecha1 = new DateTime($fechaRetiro);
    $fecha2 = new DateTime($fechaDevolucion);
    $diferencia = $fecha1->diff($fecha2);
    $cantidadDias = $diferencia->days;
    
    // VALIDACIÓN: Máximo 30 días
    if ($cantidadDias > 30) {
        throw new Exception("La duración de la reserva ({$cantidadDias} días) excede el límite máximo de 30 días.");
    }
    
    $precioPorDiaDecimal = floatval($precioPorDia);
    $totalReserva = $precioPorDiaDecimal * $cantidadDias;
    
    // 6. Inserción de la Reserva
    // El nombre de la tabla se mantiene como `reservas-vehiculos` (corregido previamente)
    $SQL_INSERT_RESERVA = "INSERT INTO `reservas-vehiculos` (
        fechaInicioReserva, FechaFinReserva, precioPorDiaReserva, 
        cantidadDiasReserva, totalReserva, idCliente, idVehiculo, 
        idSucursal, activo
    ) VALUES (
        ?, ?, ?, 
        ?, ?, ?, ?, 
        ?, 1 
    )"; // 'activo' = 1 (Activa)
    
    $stmt = $conexion->prepare($SQL_INSERT_RESERVA);
    
    // TIPOS: s=string, d=double/float, i=integer. Orden: s s d i d i i i
    $stmt->bind_param(
        "ssdisiii", 
        $fechaRetiro, $fechaDevolucion, $precioPorDiaDecimal, 
        $cantidadDias, $totalReserva, $idCliente, $idVehiculo, 
        $idSucursal
    );
    
    if ($stmt->execute()) {
        $idReservaInsertada = $conexion->insert_id;
        $stmt->close();
        // REDIRECCIÓN DE ÉXITO CORREGIDA
        header("Location: reservas.php?status=success&mensaje=" . rawurlencode("Reserva N° {$idReservaInsertada} creada exitosamente."));
    } else {
        throw new Exception("Error al guardar la reserva: " . $stmt->error);
    }
    
} catch (Exception $e) {
    // Manejo de errores de la transacción
    // REDIRECCIÓN DE ERROR CORREGIDA
    header("Location: reservas.php?status=error&mensaje=" . rawurlencode("Error al procesar la reserva: " . $e->getMessage()));
}

$conexion->close();
die();
?>