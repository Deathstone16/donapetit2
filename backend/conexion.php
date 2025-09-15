<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "donappetit";

    try {
        $conexion = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    } catch(mysqli_sql_exception) {
        echo "Error de conexión:";
    }

    if ($conexion) {
        echo "Conexión exitosa";
    } else {
        echo "No se pudo conectar a la base de datos";
    }
?>