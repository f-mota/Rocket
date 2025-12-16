<?php

/**
 * Script para actualizar/restaurar la base de datos desde/hacia el archivo rocket.sql.
 * Este script es para entornos de desarrollo y no debe usarse en producción.
 * No requiere autenticación.
 */

function exportar_base_de_datos($conexion, $ruta_archivo) {
    try {
        $sql_content = "-- Rocket Rent a Car - Backup\n";
        $sql_content .= "-- Generation Time: " . date('Y-m-d H:i:s') . "\n\n";
        $sql_content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $sql_content .= "START TRANSACTION;\n";
        $sql_content .= "SET time_zone = \"+00:00\";\n\n";

        $result_tablas = $conexion->query("SHOW TABLES");
        if (!$result_tablas) throw new Exception("Error al obtener las tablas: " . $conexion->error);

        while ($fila_tabla = $result_tablas->fetch_row()) {
            $tabla = $fila_tabla[0];

            // Estructura de la tabla
            $sql_content .= "-- --------------------------------------------------------\n";
            $sql_content .= "-- Table structure for table `{$tabla}`\n";
            $sql_content .= "-- --------------------------------------------------------\n\n";
            $sql_content .= "DROP TABLE IF EXISTS `{$tabla}`;\n";

            $result_create = $conexion->query("SHOW CREATE TABLE `{$tabla}`");
            if (!$result_create) throw new Exception("Error al obtener la estructura de la tabla {$tabla}: " . $conexion->error);
            $fila_create = $result_create->fetch_assoc();
            $sql_content .= $fila_create['Create Table'] . ";\n\n";
            $result_create->free();

            // Datos de la tabla
            $result_datos = $conexion->query("SELECT * FROM `{$tabla}`");
            if ($result_datos->num_rows > 0) {
                $sql_content .= "--\n-- Dumping data for table `{$tabla}`\n--\n\n";
                while ($fila_datos = $result_datos->fetch_assoc()) {
                    $sql_content .= "INSERT INTO `{$tabla}` (";
                    $sql_content .= "`" . implode("`, `", array_keys($fila_datos)) . "`) VALUES (";
                    $valores = [];
                    foreach ($fila_datos as $valor) {
                        if (is_null($valor)) {
                            $valores[] = "NULL";
                        } else {
                            $valores[] = "'" . $conexion->real_escape_string($valor) . "'";
                        }
                    }
                    $sql_content .= implode(", ", $valores) . ");\n";
                }
                $sql_content .= "\n";
            }
            $result_datos->free();
        }
        $result_tablas->free();

        $sql_content .= "COMMIT;\n";

        if (file_put_contents($ruta_archivo, $sql_content) === false) {
            throw new Exception("No se pudo escribir en el archivo SQL. Verifica los permisos.");
        }

        return "<h2 style='color: green;'>¡Base de datos exportada correctamente al archivo <code>" . htmlspecialchars($ruta_archivo) . "</code>!</h2>";

    } catch (Exception $e) {
        return "<p style='color: red;'><strong>Error durante la exportación:</strong> " . $e->getMessage() . "</p>";
    }
}

function actualizar_base_de_datos($conexion, $ruta_archivo) {
    if (!file_exists($ruta_archivo)) {
        return "<p style='color: red;'><strong>Error:</strong> No se encontró el archivo <code>" . htmlspecialchars($ruta_archivo) . "</code>.</p>";
    }

    $sql_content = file_get_contents($ruta_archivo);
    if ($sql_content === false) {
        return "<p style='color: red;'><strong>Error:</strong> No se pudo leer el contenido del archivo SQL.</p>";
    }

    // Desactivar temporalmente el reporte de excepciones para manejarlo manualmente
    mysqli_report(MYSQLI_REPORT_OFF);

    if (!mysqli_multi_query($conexion, $sql_content)) {
        return "<p style='color: red;'><strong>Error al iniciar la ejecución de consultas:</strong> " . htmlspecialchars(mysqli_error($conexion)) . "</p>";
    }

    // Recorrer todos los resultados para limpiar el buffer y detectar errores
    do {
        if ($result = mysqli_store_result($conexion)) {
            mysqli_free_result($result);
        }
    } while (mysqli_more_results($conexion) && mysqli_next_result($conexion));

    if (mysqli_error($conexion)) {
        return "<p style='color: red;'><strong>Error durante la ejecución de consultas:</strong> " . htmlspecialchars(mysqli_error($conexion)) . "</p>";
    }

    return "<h2 style='color: green;'>¡Base de datos actualizada correctamente desde el archivo!</h2>";
}

$mensaje_resultado = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once 'conn/conexion.php';
    $conexion = ConexionBD();
    $sql_file = __DIR__ . '/BASE DE DATOS/rocket.sql';

    if ($conexion->connect_error) {
        $mensaje_resultado = "<p style='color: red;'><strong>Error de conexión:</strong> " . htmlspecialchars($conexion->connect_error) . "</p>";
    } else {
        if ($_POST['action'] === 'update') {
            $mensaje_resultado = actualizar_base_de_datos($conexion, $sql_file);
        } elseif ($_POST['action'] === 'export') {
            $mensaje_resultado = exportar_base_de_datos($conexion, $sql_file);
        }
    }
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizador de Base de Datos</title>
    <style>
        body { font-family: sans-serif; margin: 2em; background-color: #f4f4f4; }
        .container { max-width: 800px; margin: auto; background: white; padding: 2em; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .button-container { display: flex; gap: 1em; margin-top: 1.5em; }
        button {
            padding: 0.8em 1.5em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-update { background-color: #28a745; }
        .btn-update:hover { background-color: #218838; }
        .btn-export { background-color: #007bff; }
        .btn-export:hover { background-color: #0056b3; }
        .result { margin-top: 2em; padding: 1em; border-radius: 5px; background-color: #e9ecef; }
        code { background-color: #ddd; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Actualizador de Base de Datos</h1>
        <p>Usa los botones a continuación para gestionar la base de datos de tu entorno de pruebas.</p>
        
        <form method="post">
            <div class="button-container">
                <button type="submit" name="action" value="update" class="btn-update">
                    Actualizar BD desde Archivo
                </button>
                <button type="submit" name="action" value="export" class="btn-export">
                    Exportar BD a Archivo
                </button>
            </div>
        </form>

        <?php if (!empty($mensaje_resultado)): ?>
            <div class="result">
                <?php echo $mensaje_resultado; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>