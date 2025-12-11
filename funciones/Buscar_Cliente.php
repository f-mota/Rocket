<?php
// funciones/Buscar_Cliente.php

require_once "../conn/conexion.php";
$conexion = ConexionBD();

// Establecer el encabezado para responder con JSON
header('Content-Type: application/json');

// =================================================================
// Lógica de Autocompletado (por Documento)
// =================================================================
if (isset($_GET['documento']) && !empty($_GET['documento'])) {
    // Usamos prepared statements para mayor seguridad
    $SQL_BUSCAR = "SELECT idCliente, nombreCliente, apellidoCliente FROM clientes WHERE dniCliente = ? LIMIT 1";
    $stmt = $conexion->prepare($SQL_BUSCAR);
    $documento = trim($_GET['documento']);
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $data = $resultado->fetch_assoc();
        $stmt->close();
        echo json_encode([
            'encontrado' => true,
            'id' => $data['idCliente'],
            'nombre' => $data['nombreCliente'],
            'apellido' => $data['apellidoCliente']
        ]);
    } else {
        $stmt->close();
        echo json_encode(['encontrado' => false]);
    }
    exit;
}

// =================================================================
// Lógica de Búsqueda de Clientes (para el Modal)
// =================================================================
if (isset($_GET['searchDoc']) || isset($_GET['searchApellido'])) {
    $searchDoc = trim($_GET['searchDoc'] ?? '');
    $searchApellido = trim($_GET['searchApellido'] ?? '');

    $where_clauses = [];
    $tipos = '';
    $parametros = [];

    if (!empty($searchDoc)) {
        // Búsqueda parcial por documento
        $where_clauses[] = "dniCliente LIKE ?";
        $tipos .= 's';
        $parametros[] = "%{$searchDoc}%";
    }
    if (!empty($searchApellido)) {
        // Búsqueda parcial por apellido
        $where_clauses[] = "apellidoCliente LIKE ?";
        $tipos .= 's';
        $parametros[] = "%{$searchApellido}%";
    }

    $ListadoClientes = [];

    if (!empty($where_clauses)) {
        $where_sql = implode(' OR ', $where_clauses);
        
        $SQL = "SELECT idCliente, dniCliente, nombreCliente, apellidoCliente FROM clientes WHERE {$where_sql} ORDER BY apellidoCliente ASC LIMIT 100"; 
        
        $stmt = $conexion->prepare($SQL);
        
        // Se usa call_user_func_array para bind_param dinámico
        if (!empty($parametros)) {
            $stmt->bind_param($tipos, ...$parametros);
        }

        $stmt->execute();
        $rs = $stmt->get_result();

        if ($rs) {
            while ($data = $rs->fetch_assoc()) {
                $ListadoClientes[] = [
                    'id' => $data['idCliente'],
                    'documento' => $data['dniCliente'],
                    'nombre' => $data['nombreCliente'],
                    'apellido' => $data['apellidoCliente']
                ];
            }
        }
        $stmt->close();
    }
    
    echo json_encode($ListadoClientes);
    exit;
}

// Si no se proporciona ningún parámetro de búsqueda válido
echo json_encode([]);

?>