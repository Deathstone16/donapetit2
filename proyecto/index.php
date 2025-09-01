<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login simple</title>
</head>
<body>
  <h2>Login</h2>
  <?php
  include "conexion_db.php";
  include "controlador.php";
  ?>
  <form action="index.php" method="POST">
    <label for="usuario">Usuario:</label>
    <input type="text" required id="usuario" name="usuario"><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" ><br><br>

    <button name = "btningresar" type="submit">Ingresar</button>
  </form>
</body>
</html>
