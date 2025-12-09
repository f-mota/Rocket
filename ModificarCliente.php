<?php
session_start();

require_once 'funciones/corroborar_usuario.php';
Corroborar_Usuario(); // No se puede ingresar a la página php a menos que se haya iniciado sesión

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

if (isset($_GET['id'])) {
    $idCliente = (int) $_GET['id'];

    // Obtener los datos del cliente
    $consulta = "SELECT * FROM clientes WHERE idCliente = ?";
    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $cliente = $resultado->fetch_assoc();

    // Si no existe el cliente, redirigir al listado
    if (!$cliente) {
        header('Location: clientes.php');
        exit();
    }
} else {
    // Si no se pasa un ID, redirigir al listado
    header('Location: clientes.php');
    exit();
}

// Manejo de POST: dos caminos:
// 1) Guardar cambios (form original)
// 2) Reactivar cliente (botón de reactivate desde modal)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --- REACTIVAR (viene desde el modal) ---
    if (isset($_POST['accion']) && $_POST['accion'] === 'reactivar') {
        // Realizar la actualización activo = 1
        $consultaReactivar = "UPDATE clientes SET activo = 1 WHERE idCliente = ?";
        $stmtRe = $MiConexion->prepare($consultaReactivar);
        $stmtRe->bind_param("i", $idCliente);
        $stmtRe->execute();

        // Mensaje para el listado
        $mensaje = "El cliente con ID {$idCliente} ha sido reactivado correctamente.";
        // Redirigir al listado (modo normal)
        header('Location: clientes.php?mensaje=' . urlencode($mensaje));
        exit();
    }

    // --- GUARDAR CAMBIOS DEL FORMULARIO ---
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';

    // Validaciones básicas
    $mensaje = "";
    $errores = [];

    if (empty($nombre) || strlen($nombre) < 3) {
        $errores[] = "El nombre es obligatorio y no puede presentar menos de 3 caracteres.";
    }
    if (strlen($nombre) > 50) {
        $errores[] = "El nombre no puede presentar más de 50 caracteres.";
    }
    if (empty($apellido) || strlen($apellido) < 3) {
        $errores[] = "El apellido es obligatorio y no puede presentar menos de 3 caracteres.";
    }
    if (strlen($apellido) > 50) {
        $errores[] = "El apellido no puede presentar más de 50 caracteres.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }
    if (strlen($email) > 50) {
        $errores[] = "El correo electrónico no puede presentar más de 50 caracteres.";
    }
    if (empty($telefono) || !preg_match('/^[0-9]{7,15}$/', $telefono)) {
        $errores[] = "El teléfono debe contener entre 7 y 15 dígitos.";
    }
    if (empty($direccion) || strlen($direccion) < 5) {
        $errores[] = "La dirección es obligatoria y no puede presentar menos de 5 caracteres.";
    }
    if (strlen($direccion) > 50) {
        $errores[] = "La dirección no puede presentar más de 50 caracteres.";
    }

    // Si hay errores, mostrar alert y volver al listado con el documento como filtro (como antes)
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        // Escapar para JS
        $mensaje_js = addslashes($mensaje);
        $dni = isset($cliente['dniCliente']) ? $cliente['dniCliente'] : '';
        echo "<script> 
            alert('{$mensaje_js}');
            window.location.href = 'clientes.php?documento={$dni}&nombre=&apellido=&email=&telefono=&direccion=';
        </script>";
        exit();
    }

    // Actualizar los datos del cliente
    $consulta = "UPDATE clientes 
                    SET nombreCliente = ?, 
                        apellidoCliente = ?, 
                        mailCliente = ?, 
                        telefonoCliente = ?, 
                        direccionCliente = ? 
                    WHERE idCliente = ? ";

    $stmt = $MiConexion->prepare($consulta);
    $stmt->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $direccion, $idCliente);
    $stmt->execute();

    // Redirigir después de la actualización con mensaje
    $mensaje = "El cliente de ID: {$idCliente} y documento: {$cliente['dniCliente']} ha sido modificado exitosamente.";
    $mensaje_js = addslashes($mensaje);
    $dni = isset($cliente['dniCliente']) ? $cliente['dniCliente'] : '';
    echo "<script> 
        alert('{$mensaje_js}');
        window.location.href = 'clientes.php?documento={$dni}&nombre=&apellido=&email=&telefono=&direccion=';
    </script>";
    exit();
}
?>

<body class="bg-light">
    <div style="min-height: 100%">
        <div class="wrapper">
            <?php include('sidebarGOp.php');
            include('topNavBar.php'); ?>

            <div class="p-5 mb-4 bg-white shadow-sm" style="margin-top: 10%; margin-left: 1%; max-width: 98%; border: 1px solid #444444; border-radius: 14px;">

                <h5 class="mb-4 text-secondary"><strong>Modificar Cliente</strong></h5>

                <!-- Formulario para modificar el cliente -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cliente['nombreCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($cliente['apellidoCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($cliente['mailCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefonoCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($cliente['direccionCliente']); ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="clientes.php" class="btn btn-secondary">Cancelar</a>

                        <?php if (isset($cliente['activo']) && $cliente['activo'] == 0): ?>
                            <!-- Botón que abre el modal de confirmación para reactivar -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmReactivarModal">
                                Reactivar Cliente
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para Reactivar -->
    <div class="modal fade" id="confirmReactivarModal" tabindex="-1" aria-labelledby="confirmReactivarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="accion" value="reactivar">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmReactivarModalLabel">Confirmar reactivación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro que querés <strong>reactivar</strong> este cliente (ID: <?php echo htmlspecialchars($cliente['idCliente']); ?>, Documento: <?php echo htmlspecialchars($cliente['dniCliente']); ?>)?
                        <p class="mt-2 text-muted">Esta acción dejará el cliente como <strong>activo</strong> nuevamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar Reactivación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="padding-top: 5%; padding-bottom: 20px;">
        <?php require_once "foot.php"; ?>
    </div>

    <!-- Bootstrap JS (asegurarse que esté cargado una vez) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>