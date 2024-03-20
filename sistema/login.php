<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){

    include("./conexion.php");
    print_r($_POST);

    $email=(isset($_POST['email']))?htmlspecialchars($_POST['email']):null; 
    $password=(isset($_POST['password']))?$_POST['password']:null;

    try{

        $pdo=new PDO("mysql:host=$direccionservidor;dbname=$baseDatos",$usuarioBD,$passwordBD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql="SELECT * FROM usuarios WHERE email=:email";
        $sentencia=$pdo->prepare($sql);
        $sentencia->execute(['email'=>$email]);

        $usuarios=$sentencia->fetch(PDO::FETCH_ASSOC);
        print_r($usuarios);
    
    }catch(PDOException $e){
    
    

    }

}

?>