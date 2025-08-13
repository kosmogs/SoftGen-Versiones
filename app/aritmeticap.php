<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aritmetica</title>
</head>
<body>
    <h1>Resultado</h1>
    <?php
        if (isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['num3'])){

        $num1 = (int)$_POST['num1'];
        $num2 = (int)$_POST['num2'];
        $num3 = (int)$_POST['num3'];

     $promedio = ($num1 + $num2 + $num3) /3;

        echo "La media aritmetica de los digitos: ". "\n" .htmlspecialchars($num1). "," . "\n" . htmlspecialchars($num2). 
        "\n", "y" . "\n" . htmlspecialchars($num3). "\n" ;
        echo "Es" , "\n". htmlspecialchars($promedio), "\n";
    }
?>
<br>
<a href="aritmetica.php">Volver</a>
</body>
</html>