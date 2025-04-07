<?php

function ListarModelos($vConexion)
{

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT M.id, M.descripcion, M.idGrupo, M.asientos, M.puertas
        FROM modelos M
        ORDER BY M.descripcion";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
    $rs = mysqli_query($vConexion, $SQL);

    //3) el resultado deberá organizarse en una matriz, entonces lo recorro
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ID_MODELO'] = $data['id'];
        $Listado[$i]['DESCRIPCION'] = $data['descripcion'];
        $Listado[$i]['ID_GRUPO'] = $data['id'];
        $Listado[$i]['ASIENTOS'] = $data['asientos'];
        $Listado[$i]['PUERTAS'] = $data['puertas'];

        $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;
}

function ListarGrupos($vConexion)
{

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT id, descripcion, nombre
        FROM gruposvehiculos
        ORDER BY id";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
    $rs = mysqli_query($vConexion, $SQL);

    //3) el resultado deberá organizarse en una matriz, entonces lo recorro
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ID'] = $data['id'];
        $Listado[$i]['DESCRIPCION'] = $data['descripcion'];
        $Listado[$i]['NOMBRE'] = $data['nombre'];

        $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;
}

function ListarCombustibles($vConexion)
{

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT C.id, C.descripcion
        FROM combustibles C
        ORDER BY C.descripcion";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
    $rs = mysqli_query($vConexion, $SQL);

    //3) el resultado deberá organizarse en una matriz, entonces lo recorro
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ID'] = $data['id'];
        $Listado[$i]['DESCRIPCION'] = $data['descripcion'];

        $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;
}


function Validar_Datos()
{

    $_POST['Matricula'] = trim($_POST['Matricula']);
    $_POST['Matricula'] = strip_tags($_POST['Matricula']);
    $_POST['IdModelo'] = trim($_POST['IdModelo']);
    $_POST['IdModelo'] = strip_tags($_POST['IdModelo']);
    $_POST['anio'] = trim($_POST['anio']);
    $_POST['anio'] = strip_tags($_POST['anio']);
    $_POST['color'] = trim($_POST['color']);
    $_POST['color'] = strip_tags($_POST['color']);
    $_POST['fechaCompra'] = trim($_POST['fechaCompra']);
    $_POST['fechaCompra'] = strip_tags($_POST['fechaCompra']);
    $_POST['fechaVenta'] = trim($_POST['fechaVenta']);
    $_POST['fechaVenta'] = strip_tags($_POST['fechaVenta']);
    $_POST['numeroMotor'] = trim($_POST['numeroMotor']);
    $_POST['numeroMotor'] = strip_tags($_POST['numeroMotor']);
    $_POST['numeroChasis'] = trim($_POST['numeroChasis']);
    $_POST['numeroChasis'] = strip_tags($_POST['numeroChasis']);
    $_POST['tipoCombustible'] = trim($_POST['tipoCombustible']);
    $_POST['tipoCombustible'] = strip_tags($_POST['tipoCombustible']);
    $_POST['kilometraje'] = trim($_POST['kilometraje']);
    $_POST['kilometraje'] = strip_tags($_POST['kilometraje']);
    $_POST['Observaciones'] = trim($_POST['Observaciones']);
    $_POST['Observaciones'] = strip_tags($_POST['Observaciones']);

    $vMensaje = '';


    if (strlen($_POST['Matricula']) < 6 || strlen($_POST['Matricula']) > 7) {
        $vMensaje .= 'La matricula debe tener entre 6 y 7 caracteres. <br />';
    }
    if (empty($_POST['IdModelo'])) {
        $vMensaje .= 'Debes seleccionar un modelo. <br />';
    }
    if (empty($_POST['anio'])) {
        $vMensaje .= 'Debes ingresar el año de fabricación. <br />';
    }
    if (strlen($_POST['anio']) != 4) {
        $vMensaje .= 'El año de fabricación debe tener 4 digitos. <br />';
    }
    if (empty($_POST['color'])) {
        $vMensaje .= 'Debes ingresar el color. <br />';
    }

    if (!is_string($_POST['color'])) {
        $vMensaje .= 'Debes ingresar un color válido. <br />';
    }

    if (empty($_POST['tipoCombustible'])) {
        $vMensaje .= 'Debes seleccionar el tipo de combustible. <br />';
    }

    if (empty($_POST['kilometraje'])) {
        $vMensaje .= 'Debes ingresar el kilometraje del vehículo. <br />';
    }


    // $_POST = array();
    return $vMensaje;
}

function InsertarVehiculo($vConexion)
{


    $esAutomatico = isset($_POST['Automatico']);
    $aireAcondicionado = isset($_POST['Aire']);
    $direccionHidraulica = isset($_POST['Direccion']);

    $SQL_Insert = "INSERT INTO vehiculos (matricula, 
                                        color, 
                                        fecha_compra, 
                                        fecha_venta, 
                                        anio, 
                                        numero_motor, 
                                        numero_chasis, 
                                        es_automatico, 
                                        aire_acondicionado, 
                                        dir_hidraulica, 
                                        disponible, 
                                        kilometraje, 
                                        km_aceite, 
                                        km_neumaticos, 
                                        km_correas, 
                                        id_modelo, 
                                        id_combustible, 
                                        observaciones)

                 VALUES ('" . $_POST['Matricula'] . "', 
                        '" . $_POST['color'] . "', 
                        '" . $_POST['fechaCompra'] . "', 
                        '" . $_POST['fechaVenta'] . "', 
                        '" . $_POST['anio'] . "', 
                        '" . $_POST['numeroMotor'] . "', 
                        '" . $_POST['numeroChasis'] . "', 
                        '" . $esAutomatico . "', 
                        '" . $aireAcondicionado . "', 
                        '" . $direccionHidraulica . "', 
                        '" . $_POST['disponible'] . "', 
                        '" . $_POST['kilometraje'] . "', 
                        '" . $_POST['kilometraje'] . "', 
                        '" . $_POST['kilometraje'] . "', 
                        '" . $_POST['kilometraje'] . "', 
                        '" . $_POST['IdModelo'] . "', 
                        '" . $_POST['tipoCombustible'] . "', 
                        '" . $_POST['Observaciones'] . "')";

    if (!mysqli_query($vConexion, $SQL_Insert)) {
        //si surge un error, finalizo la ejecucion del script con un mensaje
        die('<h4>Error al intentar insertar el registro.</h4>');
    }

    return true;
}

function VerificarVehiculoExiste($vConexion)
{
    //1) Genero la consulta
    $SQL = "SELECT COUNT(*) AS total FROM vehiculos WHERE matricula = '" . $_POST['Matricula'] . "'";

    //2) Ejecuto la consulta
    $rs = mysqli_query($vConexion, $SQL);

    //3) Obtengo el resultado
    $row = mysqli_fetch_assoc($rs);

    //4) Verifico si el vehículo ya existe
    return $row['total'] == 0;
}

function Listar_Vehiculos($conexion)
{

    $Listado = array();

    // Genero la consulta que deseo
    $SQL = "SELECT V.matricula, V.id_modelo, V.id_combustible, V.disponible, M.id, M.descripcion AS modelo, M.idGrupo, C.id, C.descripcion AS combustible

            FROM vehiculos V, modelos M, combustibles C
            WHERE V.id_modelo = M.id 
            AND V.id_combustible = c.id 
            AND V.disponible = 1
            ORDER BY V.matricula, M.descripcion; ";

    $rs = mysqli_query($conexion, $SQL);

    // El resultado debe organizarse en una matriz, entonces lo recorro:

    $i = 0;

    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['MATRICULA'] = $data['matricula'];
        $Listado[$i]['DISPONIBLE'] = $data['disponible'];
        $Listado[$i]['MODELO'] = $data['modelo'];
        $Listado[$i]['GRUPO'] = $data['idGrupo'];
        $Listado[$i]['COMBUSTIBLE'] = $data['combustible'];

        $i++;
    }

    // Devuelvo el listado (puede salir vacio o con datos)
    return $Listado;
}

function Procesar_Consulta()
{

    isset($_POST['Matricula']) ? $_POST['Matricula'] = strip_tags(trim($_POST['Matricula'])) : "";
    isset($_POST['Modelo']) ? $_POST['Modelo'] = strip_tags(trim($_POST['Modelo'])) : "";
    isset($_POST['Grupo']) ? $_POST['Grupo'] = strip_tags(trim($_POST['Grupo'])) : "";
}
function Consulta_Vehiculo($matricula, $modelo, $grupo, $activo, $conexion)
{

    $Listado = array();

    // Genero la consulta que deseo
    $SQL = "SELECT V.matricula, V.id_modelo, V.id_combustible, V.disponible, M.id, M.descripcion AS modelo, M.idGrupo, C.id, C.descripcion AS combustible

            FROM vehiculos V, modelos M, combustibles C
            WHERE V.id_modelo = M.id 
            AND V.id_combustible = c.id";

    if (!empty($matricula)) {
        $SQL .= " AND V.matricula = '" . $matricula . "' ";
    }

    if (!empty($modelo)) {
        $SQL .= " AND V.id_modelo = '" . $modelo . "' ";
    }

    if (!empty($grupo)) {
        $SQL .= "AND M.idGrupo = '" . $grupo . "' ";
    }

    if ($activo == "S") {
        $SQL .= " AND V.disponible = 1 ";
    } elseif ($activo == "N") {
        $SQL .= " AND V.disponible = 0 ";
    }

    $SQL .= " ORDER BY V.matricula";

    $rs = mysqli_query($conexion, $SQL);

    // El resultado debe organizarse en una matriz, entonces lo recorro:

    $i = 0;

    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['MATRICULA'] = $data['matricula'];
        $Listado[$i]['DISPONIBLE'] = $data['disponible'];
        $Listado[$i]['MODELO'] = $data['modelo'];
        $Listado[$i]['GRUPO'] = $data['idGrupo'];
        $Listado[$i]['COMBUSTIBLE'] = $data['combustible'];


        $i++;
    }

    // Devuelvo el listado (puede salir vacio o con datos)
    return $Listado;
}

function Consultar_Vehiculo($matricula, $conexion)
{

    $Listado = array();

    // Genero la consulta que deseo
    $SQL = "SELECT V.matricula, V.id_modelo, V.anio, V.color, V.fecha_compra, V.fecha_venta, V.numero_motor, V.numero_chasis, M.idGrupo, V.id_combustible, V.disponible, 
                    V.kilometraje, V.es_automatico, V.aire_acondicionado, V.dir_hidraulica, V.observaciones, M.id, M.puertas, M.asientos,
                    M.descripcion AS modelo, C.id, C.descripcion AS combustible
            FROM vehiculos V, modelos M, combustibles C
            WHERE V.id_modelo = M.id 
            AND V.id_combustible = c.id
            AND V.matricula = $matricula";

    $rs = mysqli_query($conexion, $SQL);

    // El resultado debe organizarse en una matriz, entonces lo recorro:

    $i = 0;

    while ($data = mysqli_fetch_array($rs)) {

        $auto = [
            "Matricula" => $data['matricula'],
            "Modelo" => $data['modelo'],
            "IdModelo" => $data['id_modelo'],
            "Grupo" => $data['idGrupo'],
            "Anio" => $data['anio'],
            "Color" => $data['color'],
            "FechaCompra" => $data['fecha_compra'],
            "FechaVenta" => $data['fecha_venta'],
            "Motor" => $data['numero_motor'] == "" ?  "-" : $data['numero_motor'],
            "Chasis" => $data['numero_chasis'] == "" ? "-" : $data['numero_chasis'],
            "Combustible" => $data['combustible'],
            "idCombustible" => $data['id'],
            "Puertas" => $data['puertas'],
            "Asientos" => $data['asientos'],
            "Activo" => $data['disponible'],
            "Kilometraje" => $data['kilometraje'],
            "Automatico" => $data['es_automatico'],
            "Aire" => $data['aire_acondicionado'],
            "Direccion" => $data['dir_hidraulica'],
            "Observaciones" => $data['observaciones'] == "" ? "-" : $data['observaciones']
        ];

        $i++;
    }

    // Devuelvo el listado (puede salir vacio o con datos)
    return $auto;
}
