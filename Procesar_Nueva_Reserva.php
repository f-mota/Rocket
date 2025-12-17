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

// Estado inicial del contrato (1 = En preparación)
$estadocontrato = 1;

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
    
    // 6. Transacción completa: Reserva + DetalleContrato + Contrato + Update
    mysqli_query($conexion, "START TRANSACTION;");

    try {
        // 1. Insertar Reserva (sin numeroReserva)
        $SQL = "INSERT INTO `reservas-vehiculos` 
                (fechaReserva, fechaInicioReserva, fechaFinReserva, 
                precioPorDiaReserva, cantidadDiasReserva, totalReserva, 
                idCliente, idSucursal, idVehiculo, activo) 
                VALUES (NOW(), '$fechaRetiro', '$fechaDevolucion', 
                        $precioPorDiaDecimal, $cantidadDias, $totalReserva, 
                        $idCliente, $idSucursal, $idVehiculo, 1);";

        if (!mysqli_query($conexion, $SQL)) {
            throw new Exception("Error al agregar reserva: " . mysqli_error($conexion));
        }

        $idReservaRecuperada = mysqli_insert_id($conexion);

        // 2. Insertar Detalle del Contrato
        $SQL_DetalleContrato = "INSERT INTO `detalle-contratos` 
                                (precioPorDiaContrato, cantidadDiasContrato, montoTotalContrato) 
                                VALUES ($precioPorDiaDecimal, $cantidadDias, $totalReserva);";

        if (!mysqli_query($conexion, $SQL_DetalleContrato)) {
            throw new Exception("Error al agregar detalle del contrato: " . mysqli_error($conexion));
        }

        $IdDetalleContrato = mysqli_insert_id($conexion);

        // 3. Insertar Contrato
        $SQL_Contrato = "INSERT INTO `contratos-alquiler` 
                        (fechaInicioContrato, fechaFinContrato, idCliente, idVehiculo, idDetalleContrato, idEstadoContrato) 
                        VALUES ('$fechaRetiro', '$fechaDevolucion', $idCliente, $idVehiculo, $IdDetalleContrato, $estadocontrato);";

        if (!mysqli_query($conexion, $SQL_Contrato)) {
            throw new Exception("Error al insertar en contratos: " . mysqli_error($conexion));
        }

        $IdContratoRecuperado = mysqli_insert_id($conexion);

        // 4. Actualizar Reserva con ID del Contrato
        $SQL_Reserva = "UPDATE `reservas-vehiculos` 
                        SET idContrato = $IdContratoRecuperado 
                        WHERE idReserva = $idReservaRecuperada;";

        if (!mysqli_query($conexion, $SQL_Reserva)) {
            throw new Exception("Error al actualizar número de contrato en la tabla de reservas: " . mysqli_error($conexion));
        }

        // CONFIRMAR TRANSACCIÓN
        mysqli_query($conexion, "COMMIT;");

        // Redirección usando el ID de la reserva recién creada
        $mensaje = "Reserva ID {$idReservaRecuperada} agregada exitosamente. El contrato que le corresponde se encuentra asociado y en preparación.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'reservas.php?NumeroReserva={$idReservaRecuperada}&MatriculaReserva=&ApellidoReserva=&NombreReserva=&DocReserva=&RetiroDesde=&RetiroHasta=&BotonFiltrar=FiltrandoReservas';
        </script>";
        exit();

    } 
    catch (Exception $e) {
        // REVERTIR TRANSACCIÓN EN CASO DE ERROR
        mysqli_query($conexion, "ROLLBACK;");
        $mensaje = $e->getMessage();
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'reservas.php';
        </script>";
        exit();
    }

    
} catch (Exception $e) {
    // Manejo de errores de la transacción
    // REDIRECCIÓN DE ERROR CORREGIDA
    header("Location: reservas.php?status=error&mensaje=" . rawurlencode("Error al procesar la reserva: " . $e->getMessage()));
}

$conexion->close();
die();
?>