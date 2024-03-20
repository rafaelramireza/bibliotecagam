<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){

    include("./conexion.php");
    $errores=array();

    $email=(isset($_POST['email']))?htmlspecialchars($_POST['email']):null; 
    $password=(isset($_POST['password']))?$_POST['password']:null;

    if(empty($email)){
        $errores['email']= "El campo email es requerido";        
        
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errores['email']="El email no es válido";
    }

    if(empty($password)){
        $errores['password']= "El campo password es requerido";
    }

    if(empty($errores)){

    try{

        $pdo=new PDO("mysql:host=$direccionservidor;dbname=$baseDatos",$usuarioBD,$passwordBD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql="SELECT * FROM usuarios WHERE email=:email";
        $sentencia=$pdo->prepare($sql);
        $sentencia->execute(['email'=>$email]);

        $usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        // print_r($usuarios);

        $login=false;
        foreach($usuarios as $usuario){
             if(password_verify($password,$usuario['password'])){
                //$_SESSION["loggedUser"]=$usuario;
                $login=true;
            }
                
        }
        

        if($login){

            echo "Existe el usuario en la BD";
            header("Location: ./index.php");

        }else{

            echo "no Existe el usuario en la BD";
        }
    
    }catch(PDOException $e){
    
    

    }

}else{

    foreach($errores as $error){
        echo "<br/>".$error."<br/>";
    }
    echo "<br/> <a href='./login.html'>Regresar al login</a>";

}

}
?>