<?php
    include ("../backend/conexion.php");
?>


<!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href= "login.css" >
    </head>
    <body>
        <div class="conteiner_login">
            <h1>LOGIN</h1>
            <form>
                <label class="name"> Nombre </label>
                <input type="address"><br>
                <label class="password">Contraseña</label>
                <input type="password"> <br> 
                <input type="button" value="enviar">

            </form>
        </div>
    </body>
    </html>