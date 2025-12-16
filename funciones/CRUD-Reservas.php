<?php

// EMITIR LISTADO con todas las Reservas
// Se agrega el parámetro $estado (1 para Activas, 0 para Canceladas)
function Listar_Reservas($conexion, $estado = '1') { 

    $Listado = array();

    // Convertir el parámetro de estado a 1 o 0
    $filtro_activo = ($estado === 'S' || $estado === '1') ? 1 : 0;
    
    //1) genero la consulta que deseo (TABLA: reservas-vehiculos)
    $SQL = "SELECT r.idReserva as rIdReserva, 
                   r.fechaReserva as rFechaReserva, 
                   r.fechaInicioReserva as rFechaInicioReserva, 
                   r.FechaFinReserva as rFechaFinReserva, 
                   r.precioPorDiaReserva as rPrecioPorDiaReserva, 
                   r.cantidadDiasReserva as rCantidadDiasReserva, 
                   r.totalReserva as rTotalReserva, 
                   r.idCliente as rIdCliente, 
                   r.idContrato as rIdContrato,
                   r.idSucursal as rIdSucursal,
                   r.idVehiculo as rIdVehiculo,
                   r.activo as rActivo,           
                   r.comentario as rComentario,   
                   c.idCliente as cIdCliente,
                   c.nombreCliente as cNombreCliente,
                   c.apellidoCliente as cApellidoCliente,
                   c.dniCliente as cDniCliente,
                   v.idVehiculo as vIdVehiculo,
                   v.matricula as vMatricula,
                   v.idModelo as vIdModelo,
                   v.idGrupoVehiculo as vIdGrupoVehiculo,
                   m.idModelo as  mIdModelo,
                   m.nombreModelo as mNombreModelo,
                   g.idGrupo as gIdGrupo,
                   g.nombreGrupo as gNombreGrupo
            FROM `reservas-vehiculos` r
            JOIN clientes c ON r.idCliente = c.idCliente
            JOIN vehiculos v ON r.idVehiculo = v.idVehiculo
            JOIN modelos m ON v.idModelo = m.idModelo
            JOIN `grupos-vehiculos` g ON v.idGrupoVehiculo = g.idGrupo
            WHERE r.activo = {$filtro_activo} 
            ORDER BY r.idReserva ASC";
    
    //2) corroboro si fue exitosa la consulta
    $rs = mysqli_query($conexion, $SQL);

    if ($rs == false) {
        die(mysqli_error($conexion));
    }

    //3) Genero mi arreglo
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['idReserva'] = $data['rIdReserva'];
            $Listado[$i]['fechaReserva'] = $data['rFechaReserva'];
            $Listado[$i]['fechaInicioReserva'] = $data['rFechaInicioReserva'];
            $Listado[$i]['fechaFinReserva'] = $data['rFechaFinReserva'];
            $Listado[$i]['precioPorDiaReserva'] = $data['rPrecioPorDiaReserva'];
            $Listado[$i]['cantidadDiasReserva'] = $data['rCantidadDiasReserva'];
            $Listado[$i]['totalReserva'] = $data['rTotalReserva'];
            $Listado[$i]['idContrato'] = $data['rIdContrato'];

            // Nuevos campos
            $Listado[$i]['activo'] = ($data['rActivo'] == 1) ? 'S' : 'N'; 
            $Listado[$i]['comentario'] = $data['rComentario'];

            // Lógica de Contrato Asociado (se mantiene)
            if (is_null($Listado[$i]['idContrato'])) {
                $Listado[$i]['ContratoAsociado'] = "No registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "danger";
                $Listado[$i]['idContrato'] = "No existe";
            }
            else {
                $Listado[$i]['ContratoAsociado'] = "Registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "success";
            }

            $Listado[$i]['idCliente'] = $data['rIdCliente'];
            $Listado[$i]['apellidoCliente'] = $data['cApellidoCliente'];
            $Listado[$i]['nombreCliente'] = $data['cNombreCliente'];
            $Listado[$i]['dniCliente'] = $data['cDniCliente'];
            $Listado[$i]['vehiculoMatricula'] = $data['vMatricula'];
            $Listado[$i]['vehiculoGrupo'] = $data['gNombreGrupo'];
            $Listado[$i]['vehiculoModelo'] = $data['mNombreModelo'];
            
            $i++;
    }

    return $Listado;
}


// CONSULTAR RESERVAS (POR FILTRO)
// Se agrega el parámetro $estado (1 para Activas, 0 para Canceladas)
function Consulta_Reservas($numero, $matricula, $apellido, $nombre, $documento, $retirodesde, $retirohasta, $conexion, $estado = '1') {
    
    $Listado = array();

    // Convertir el parámetro de estado a 1 o 0
    $filtro_activo = ($estado === 'S' || $estado === '1') ? 1 : 0;
    
    // 1) Genero la consulta base con los nuevos campos (TABLA: reservas-vehiculos)
    $SQL = "SELECT r.idReserva as rIdReserva, 
                   r.fechaReserva as rFechaReserva, 
                   r.fechaInicioReserva as rFechaInicioReserva, 
                   r.FechaFinReserva as rFechaFinReserva, 
                   r.precioPorDiaReserva as rPrecioPorDiaReserva, 
                   r.cantidadDiasReserva as rCantidadDiasReserva, 
                   r.totalReserva as rTotalReserva, 
                   r.idCliente as rIdCliente, 
                   r.idContrato as rIdContrato,
                   r.idSucursal as rIdSucursal,
                   r.idVehiculo as rIdVehiculo,
                   r.activo as rActivo,           
                   r.comentario as rComentario,   
                   c.idCliente as cIdCliente,
                   c.nombreCliente as cNombreCliente,
                   c.apellidoCliente as cApellidoCliente,
                   c.dniCliente as cDniCliente,
                   v.idVehiculo as vIdVehiculo,
                   v.matricula as vMatricula,
                   v.idModelo as vIdModelo,
                   v.idGrupoVehiculo as vIdGrupoVehiculo,
                   m.idModelo as  mIdModelo,
                   m.nombreModelo as mNombreModelo,
                   g.idGrupo as gIdGrupo,
                   g.nombreGrupo as gNombreGrupo
            FROM `reservas-vehiculos` r
            JOIN clientes c ON r.idCliente = c.idCliente
            JOIN vehiculos v ON r.idVehiculo = v.idVehiculo
            JOIN modelos m ON v.idModelo = m.idModelo
            JOIN `grupos-vehiculos` g ON v.idGrupoVehiculo = g.idGrupo
            WHERE r.activo = {$filtro_activo} "; // FILTRO INICIAL POR ESTADO ACTIVO/CANCELADO
    
    // 2) Armo la cláusula WHERE con los filtros adicionales
    if (!empty($numero)) {
        $SQL .= " AND r.idReserva = '{$numero}' ";
    }
    if (!empty($matricula)) {
        $SQL .= " AND v.matricula LIKE '%{$matricula}%' ";
    }
    if (!empty($apellido)) {
        $SQL .= " AND c.apellidoCliente LIKE '%{$apellido}%' ";
    }
    if (!empty($nombre)) {
        $SQL .= " AND c.nombreCliente LIKE '%{$nombre}%' ";
    }
    if (!empty($documento)) {
        $SQL .= " AND c.dniCliente LIKE '%{$documento}%' ";
    }
    if (!empty($retirodesde)) {
        $SQL .= " AND r.fechaInicioReserva >= '{$retirodesde}' ";
    }
    if (!empty($retirohasta)) {
        $SQL .= " AND r.fechaInicioReserva <= '{$retirohasta}' ";
    }

    $SQL .= " ORDER BY r.idReserva ASC";
    
    //3) corroboro si fue exitosa la consulta
    $rs = mysqli_query($conexion, $SQL);

    if ($rs == false) {
        die(mysqli_error($conexion));
    }

    //4) Genero mi arreglo
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['idReserva'] = $data['rIdReserva'];
            $Listado[$i]['fechaReserva'] = $data['rFechaReserva'];
            $Listado[$i]['fechaInicioReserva'] = $data['rFechaInicioReserva'];
            $Listado[$i]['fechaFinReserva'] = $data['rFechaFinReserva'];
            $Listado[$i]['precioPorDiaReserva'] = $data['rPrecioPorDiaReserva'];
            $Listado[$i]['cantidadDiasReserva'] = $data['rCantidadDiasReserva'];
            $Listado[$i]['totalReserva'] = $data['rTotalReserva'];
            $Listado[$i]['idContrato'] = $data['rIdContrato'];

            // Nuevos campos
            $Listado[$i]['activo'] = ($data['rActivo'] == 1) ? 'S' : 'N'; 
            $Listado[$i]['comentario'] = $data['rComentario'];

            // Lógica de Contrato Asociado (se mantiene)
            if (is_null($Listado[$i]['idContrato'])) {
                $Listado[$i]['ContratoAsociado'] = "No registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "danger";
                $Listado[$i]['idContrato'] = "No existe";
            }
            else {
                $Listado[$i]['ContratoAsociado'] = "Registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "success";
            }

            $Listado[$i]['idCliente'] = $data['rIdCliente'];
            $Listado[$i]['apellidoCliente'] = $data['cApellidoCliente'];
            $Listado[$i]['nombreCliente'] = $data['cNombreCliente'];
            $Listado[$i]['dniCliente'] = $data['cDniCliente'];
            $Listado[$i]['vehiculoMatricula'] = $data['vMatricula'];
            $Listado[$i]['vehiculoGrupo'] = $data['gNombreGrupo'];
            $Listado[$i]['vehiculoModelo'] = $data['mNombreModelo'];
            
            $i++;
    }

    return $Listado;
}


// No estamos usándolo en ningún lado mepa, al final seguimos otra estrategia
function Corroborar_FechasReserva($fecharetiro, $fechadevolucion) {
 
    $Fecha_actual = date("y-m-d");
    $Fecha_manana = date("y-m-d", strtotime($Fecha_actual . "+ 1 day"));
    
    // La fecha de retiro debe ser superior a hoy y la de devolución debe ser superior a la de retiro

    if ($fecharetiro < $Fecha_manana) {
        return "Fecha de retiro debe ser posterior a mañana";
    }

    if ($fechadevolucion <= $fecharetiro) {
        return "Fecha de devolución debe ser posterior a la fecha de retiro";
    }

    return "Fechas OK";
}
?>