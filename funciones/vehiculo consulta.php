<?php

function Procesar_Consulta() {

    $_POST['Matricula'] = trim($_POST['Matricula']);
    $_POST['Modelo'] = trim($_POST['Modelo']);
    $_POST['Grupo'] = trim($_POST['Grupo']);
    $_POST['Matricula'] = strip_tags($_POST['Matricula']);
    $_POST['Modelo'] = strip_tags($_POST['Modelo']);
    $_POST['Grupo'] = strip_tags($_POST['Grupo']);

    $_POST['Color'] = trim($_POST['Color']);
    $_POST['Color'] = strip_tags($_POST['Color']);

    $_POST['Combustible'] = trim($_POST['Combustible']);
    $_POST['Combustible'] = strip_tags($_POST['Combustible']);

    // REMOVIDOS: Los trims y strip_tags para CiudadSucursal, DireccionSucursal, TelSucursal, 
    // ya que ahora se espera un ID de Sucursal en su lugar, que no necesita limpieza de tags/trim,
    // y los otros dos campos de sucursal ya no existen en el formulario.
    // $_POST['CiudadSucursal'] = trim($_POST['CiudadSucursal']);
    // $_POST['CiudadSucursal'] = strip_tags($_POST['CiudadSucursal']);
    // ...

    $_POST['Puertas'] = trim($_POST['Puertas']);
    $_POST['Puertas'] = strip_tags($_POST['Puertas']);

    $_POST['Asientos'] = trim($_POST['Asientos']);
    $_POST['Asientos'] = strip_tags($_POST['Asientos']);

    // Proceso las fechas. Es mucho mejor hacerlo de este modo que de la forma especificada en los demás módulos:
    if (!empty($_POST['AdquisicionDesde'])) {
        $_POST['AdquisicionDesde'] = date("Y-m-d", strtotime($_POST['AdquisicionDesde']));
    } 

    if (!empty($_POST['AdquisicionHasta'])) {
        $_POST['AdquisicionHasta'] = date("Y-m-d", strtotime($_POST['AdquisicionHasta']));
    } 

}


// MODIFICADO: $ciudadsucursal ahora se utiliza para pasar el ID de Sucursal ($idSucursalFiltro). 
// Las variables $direccionsucursal y $telsucursal se mantienen para no romper la firma, pero se ignoran.
function Consulta_Vehiculo($matricula, $modelo, $grupo, $color, $combustible, $disponibilidad, $idSucursalFiltro, $direccionsucursal, $telsucursal, $puertas, $asientos, $automatico, $aireacondicionado, $direccionhidraulica, $fabricaciondesde, $fabricacionhasta, $adquisiciondesde, $adquisicionhasta, $preciodesde, $preciohasta, $activo, $conexion) {

    if ($disponibilidad != "S" && $disponibilidad != "N") {
        $disponibilidad = null;
    }
    if ($automatico != "S" && $automatico != "N") {
        $automatico = null;
    }
    if ($aireacondicionado != "S" && $aireacondicionado != "N") {
        $aireacondicionado = null;
    }
    if ($direccionhidraulica != "S" && $direccionhidraulica != "N") {
        $direccionhidraulica = null;
    }
    
    // Asumimos que $activo viene como '1' (por defecto) o '0' (si se marcó el filtro)
    if ($activo !== '0') {
        $activo = '1';
    }


    $Listado = array();
    
    // Genero la consulta que deseo
    $SQL = "SELECT v.idVehiculo as vID,
                   v.matricula as vMatricula, 
                   v.color as vColor,
                   v.fechaCompra as vFechaCompra,
                   v.precioCompra as vPrecioCompra,
                   v.anio as vAnio,
                   v.numeroMotor as vNumeroMotor,
                   v.numeroChasis as vNumeroChasis,
                   v.puertas as vNumeroPuertas,
                   v.asientos as vNumeroAsientos,
                   v.esAutomatico as vAutomatico,
                   v.aireAcondicionado as vAire,
                   v.dirHidraulica as vHidraulica,
                   v.estadoFisicoDelVehiculo as vEstadoFisico,
                   v.disponibilidad as vDisponibilidad,
                   v.activo as vActivo,              /* AÑADIDO: Columna activo */
                   v.kilometraje as vKilometraje,
                   v.idModelo,
                   v.idCombustible,
                   v.idGrupoVehiculo,
                   v.idSucursal,
                   m.idModelo,
                   m.nombreModelo as vModelo,
                   m.descripcionModelo as vDescripcionModelo,
                   c.idCombustible,
                   c.tipoCombustible as vCombustible,
                   g.idGrupo,
                   g.nombreGrupo as vGrupo,
                   g.descripcionGrupo as vDescripcionGrupo,
                   s.idSucursal,
                   s.numeroSucursal as vSucursal,
                   s.direccionSucursal as vSucursalDireccion,
                   s.ciudadSucursal as vSucursalCiudad,
                   s.telefonoSucursal as vSucursalTel
            FROM vehiculos v, modelos m, combustibles c, `grupos-vehiculos` g, sucursales s
            WHERE m.idModelo = v.idModelo 
            AND c.idCombustible = v.idCombustible 
            AND g.idGrupo = v.idGrupoVehiculo
            AND s.idSucursal = v.idSucursal 
            "; // Condición base de JOINs

    // AÑADIDO: Lógica de filtrado por activo.
    $SQL .= " AND v.activo = '$activo' ";


    // Concateno el resto de la consulta para poder agregar condicionales
    if (!empty($matricula)) {
        $SQL .= " AND v.matricula LIKE '%$matricula%' ";
    }
    if (!empty($modelo)) {
        $SQL .= " AND m.nombreModelo LIKE '%$modelo%' ";
    }
    if (!empty($grupo)) {
        $SQL .= " AND g.nombreGrupo LIKE '%$grupo%' ";
    }
    if (!empty($color)) {
        $SQL .= " AND v.color LIKE '%$color%' ";
    }
    if (!empty($combustible)) {
        $SQL .= " AND c.tipoCombustible LIKE '%$combustible%' ";
    }
    if (!empty($disponibilidad)) {
        $SQL .= " AND v.disponibilidad = '$disponibilidad' ";
    }
    
    // MODIFICADO: Aplicar filtro por ID de Sucursal si está presente.
    if (!empty($idSucursalFiltro)) {
        $SQL .= " AND s.idSucursal = '$idSucursalFiltro' ";
    }
    // REMOVIDOS los antiguos filtros por LIKE para ciudad, direccion y telefono

    if (!empty($puertas)) {
        $SQL .= " AND v.puertas = '$puertas' ";
    }
    if (!empty($asientos)) {
        $SQL .= " AND v.asientos = '$asientos' ";
    }
    if (!empty($automatico)) {
        $SQL .= " AND v.esAutomatico = '$automatico' ";
    }
    if (!empty($aireacondicionado)) {
        $SQL .= " AND v.aireAcondicionado = '$aireacondicionado' ";
    }
    if (!empty($direccionhidraulica)) {
        $SQL .= " AND v.dirHidraulica = '$direccionhidraulica' ";
    }
    if (!empty($fabricaciondesde)) {
        $SQL .= " AND v.anio >= '$fabricaciondesde' ";
    }
    if (!empty($fabricacionhasta)) {
        $SQL .= " AND v.anio <= '$fabricacionhasta' ";
    }
    if (!empty($adquisiciondesde)) {
        $SQL .= " AND v.fechaCompra >= '$adquisiciondesde' ";
    }
    if (!empty($adquisicionhasta)) {
        $SQL .= " AND v.fechaCompra <= '$adquisicionhasta' ";
    }
    if (!empty($preciodesde)) {
        $SQL .= " AND v.precioCompra >= '$preciodesde' ";
    }
    if (!empty($preciohasta)) {
        $SQL .= " AND v.precioCompra <= '$preciohasta' ";
    }


    $SQL .= " ORDER BY v.idVehiculo ASC ";

    $rs = mysqli_query($conexion, $SQL);

    if ($rs) {
        $i = 0;
        while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['vID'] = $data['vID'];
            $Listado[$i]['vMatricula'] = $data['vMatricula'];
            $Listado[$i]['vColor'] = $data['vColor'];
            $Listado[$i]['vFechaCompra'] = $data['vFechaCompra'];

            $Listado[$i]['vPrecioCompra'] = $data['vPrecioCompra'];
            if (is_null($data['vPrecioCompra'])) {
                $Listado[$i]['vPrecioCompra'] = "Sin información";
            }

            $Listado[$i]['vAnio'] = $data['vAnio'];
            if (is_null($data['vAnio'])) {
                $Listado[$i]['vAnio'] = "A definir.";
            }

            $Listado[$i]['vNumeroMotor'] = $data['vNumeroMotor'];
            if (is_null($data['vNumeroMotor'])) {
                $Listado[$i]['vNumeroMotor'] = "A definir.";
            }

            $Listado[$i]['vNumeroChasis'] = $data['vNumeroChasis'];
            if (is_null($data['vNumeroChasis'])) {
                $Listado[$i]['vNumeroChasis'] = "A definir.";
            }

            $Listado[$i]['vNumeroPuertas'] = $data['vNumeroPuertas'];
            if (is_null($data['vNumeroPuertas'])) {
                $Listado[$i]['vNumeroPuertas'] = "A definir.";
            }

            $Listado[$i]['vNumeroAsientos'] = $data['vNumeroAsientos'];
            if (is_null($data['vNumeroAsientos'])) {
                $Listado[$i]['vNumeroAsientos'] = "A definir.";
            }

            $Listado[$i]['vAutomatico'] = $data['vAutomatico'];
            if ($Listado[$i]['vAutomatico'] == "S") {
                $Listado[$i]['vAutomatico'] = "Sí";
            }
            else {
                $Listado[$i]['vAutomatico'] = "No";
            }

            $Listado[$i]['vAire'] = $data['vAire'];
            if ($Listado[$i]['vAire'] == "S") {
                $Listado[$i]['vAire'] = "Sí";
            }
            else {
                $Listado[$i]['vAire'] = "No";
            }

            $Listado[$i]['vHidraulica'] = $data['vHidraulica'];
            if ($Listado[$i]['vHidraulica'] == "S") {
                $Listado[$i]['vHidraulica'] = "Sí";
            }
            else {
                $Listado[$i]['vHidraulica'] = "No";
            }

            $Listado[$i]['vEstadoFisico'] = $data['vEstadoFisico'];
            if (is_null($data['vEstadoFisico'])) {
                $Listado[$i]['vEstadoFisico'] = "A definir.";
            }

            $Listado[$i]['vDisponibilidad'] = $data['vDisponibilidad'];

            if ($Listado[$i]['vDisponibilidad'] == "S") {
                $Listado[$i]['vDisponibilidad'] = "Sí";
                $Listado[$i]['ColorAdvertencia'] = "success";
            }
            else {
                $Listado[$i]['vDisponibilidad'] = "No";
                $Listado[$i]['ColorAdvertencia'] = "danger";
            }

            // AÑADIDO: Procesamiento de activo
            $Listado[$i]['vActivo'] = $data['vActivo']; // Se almacena 1 o 0
            if ($data['vActivo'] == 1) {
                 $Listado[$i]['TextoActivo'] = "Activo";
                 $Listado[$i]['ColorActivo'] = "success";
            } else {
                 $Listado[$i]['TextoActivo'] = "Inactivo/Eliminado";
                 $Listado[$i]['ColorActivo'] = "secondary";
            }
            // FIN AÑADIDO

            $Listado[$i]['vKilometraje'] = $data['vKilometraje'];
            $Listado[$i]['vModelo'] = $data['vModelo'];
            $Listado[$i]['vDescripcionModelo'] = $data['vDescripcionModelo'];

            $Listado[$i]['vCombustible'] = $data['vCombustible'];
            if (is_null($data['vCombustible'])) {
                $Listado[$i]['vCombustible'] = "A definir.";
            }

            $Listado[$i]['vGrupo'] = $data['vGrupo'];
            $Listado[$i]['vDescripcionGrupo'] = $data['vDescripcionGrupo'];
            $Listado[$i]['vSucursal'] = $data['vSucursal'];

            $Listado[$i]['vSucursalDireccion'] = $data['vSucursalDireccion'];
            if (is_null($data['vSucursalDireccion'])) {
                $Listado[$i]['vSucursalDireccion'] = "A definir.";
            }

            $Listado[$i]['vSucursalCiudad'] = $data['vSucursalCiudad'];
            if (is_null($data['vSucursalCiudad'])) {
                $Listado[$i]['vSucursalCiudad'] = "A definir.";
            }

            $Listado[$i]['vSucursalTel'] = $data['vSucursalTel'];
            if (is_null($data['vSucursalTel'])) {
                $Listado[$i]['vSucursalTel'] = "A definir.";
            }

            $i++;
        }
    } else {
        // En caso de error
    }

    return $Listado;
}