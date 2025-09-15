<?php
    include("conexion.php");
    // si el boton ingresar es presionado y no esta vacio se ejecuta el siguiente codigo
    if (!empty($_POST['ingresar'])) {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            echo "<script>alert('Los campos son obligatorios');</script>";
        } else {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            // Consulta SQL para verificar las credenciales del usuario
            $sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE Nombre = '$usuario' AND Contraseña = '$clave'");

            if (!$sql) {
                // Mostrar el error de SQL
                echo "Error en la consulta: " . mysqli_error($conexion);
                exit;
            }
            // Verificar si se encontró un usuario con las credenciales proporcionadas
            if ($datos = mysqli_fetch_object($sql)) {
                if ($datos->rol == 'administrador') {
                    echo '<h1>soy admin</h1>';
                } else {
                    echo '<h1>soy usser</h1>';
                }
                exit;
            } else {
                echo "<script>alert('Usuario o contraseña incorrectos');</script>";
            }
        }
    }
?>