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
        $vMensaje .= 'Debes el año de fabricación debe tener 4 digitos. <br />';
    }
    if (empty($_POST['color'])) {
        $vMensaje .= 'Debes ingresar el color. <br />';
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

function VerificarVehiculoExiste($vConexion){
    //1) Genero la consulta
    $SQL = "SELECT COUNT(*) AS total FROM vehiculos WHERE matricula = '" . $_POST['Matricula'] . "'";

    //2) Ejecuto la consulta
    $rs = mysqli_query($vConexion, $SQL);

    //3) Obtengo el resultado
    $row = mysqli_fetch_assoc($rs);

    //4) Verifico si el vehículo ya existe
    return $row['total'] == 0;
}



?>
