<?php

function ConexionBD() {
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "rocket";
    } else {
        $host = getenv('MYSQLHOST');
        $user = getenv('MYSQLUSER');
        $pass = getenv('MYSQLPASSWORD');
        $db   = getenv('MYSQLDATABASE');
    }

    $linkConexion = mysqli_connect($host, $user, $pass, $db);
    mysqli_set_charset($linkConexion, "utf8mb4");

    if ($linkConexion != false) {
        return $linkConexion;
    } else {
        die("No se pudo establecer la conexión.");
    }
}

/*
function ConexionBD($Host = "localhost", $User = "root", $Password = "", $BaseDeDatos = "rocket") {
    
    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos,);
    mysqli_set_charset($linkConexion, "utf8mb4");
    if ($linkConexion != false) {
        return $linkConexion;
    } 
    else {
        die("No se pudo establecer la conexión.");
    }
}

*/

?>