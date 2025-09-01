<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="suma.php" method="post">
        <label>Select Quantity:</label><br>
        <input type="text" name="quantity"><br>
        <input type="submit" value="Total"><br>
    </form>
    
</body>
</html>
<?php
    $item = "lomito comun";
    $precio = 14000;
    $quantity = $_POST["quantity"];

    $total = $quantity * $precio;

    echo "Selecciono {$quantity} de {$item}. Debe pagar: $ {$total}";

?>