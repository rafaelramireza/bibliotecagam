<?php

session_start();
if(!isset($_SESSION['usuario_id'])){
    header("location:login.html");
    exit();

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<a href="https://www.uacm.edu.mx">UACM</a>
|
<a href="https://www.google.com.mx">Google</a>
|
<a href="cerrar.php"></a>
<br>

<h2> Bienvenido a la aplicación <?php echo $_SESSION['usuario_nombre'];?></h2>
<p> Este es el inicio de la aplicación </p>
    
</body>
</html>