<?php
    include ("../backend/controlador-loguin.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>

</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="" method="post">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <button type="submit" name="ingresar" value="1">Entrar</button>
        </form>
        <a href="recuperar_contraseña.php" class="recuperar">¿Olvidaste tu contraseña?</a>
    </div>
</body>
</html>