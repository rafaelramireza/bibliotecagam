<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    include('./conexion.php');

    $errores=array();

    $nombres=(isset($_POST['nombres']))?$_POST['nombres']:null;
    $apellidos=(isset($_POST['apellidos']))?$_POST['apellidos']:null;
    $email=(isset($_POST['email']))?$_POST['email']:null;
    $password=(isset($_POST['password']))?$_POST['password']:null;
    $licenciatura=(isset($_POST['licenciatura']))?$_POST['licenciatura']:null;
    $semestre=(isset($_POST['semestre']))?$_POST['semestre']:null;
    $confirmarPassword=(isset($_POST['confirmarPassword']))?$_POST['confirmarPassword']:null;
    
    if(empty($nombres)){
        $errores['nombres']= "El campo nombres es requerido";
    }
    if(empty($apellidos)){
        $errores['apellidos']= "El campo apellidos es requerido";
    }
    
    if(empty($licenciatura)){
        $errores['licenciatura']= "El campo licenciatura es requerido";
    }
    if(empty($semestre)){
        $errores['semestre']= "El campo semestre es requerido";
    }

    if(empty($email)){
        $errores['email']= "El campo email es requerido";        
        
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errores['email']="El email no es válido";
    }

    if(empty($password)){
        $errores['password']= "El campo password es requerido";
    }

    if(empty($confirmarPassword)){
        $errores['confirmarPassword']= "Confirma la contraseña";
    }elseif($password!=$confirmarPassword){
        $errores['confirmarPassword']="Las contraseñas no coinciden";
    }

    foreach($errores as $error){
        echo "<br/>".$error."<br/>";
    }

    if(empty($errores)){

        try{

            $pdo=new PDO("mysql:host=$direccionservidor;dbname=$baseDatos",$usuarioBD,$passwordBD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Establece el modo de error
    
            $nuevoPassword=password_hash($password, PASSWORD_DEFAULT);

            $sql="INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `email`, `password`, `licenciatura`, `semestre`)
            VALUES (NULL, :nombres, :apellidos, :email, :password, :licenciatura, :semestre);";
            
            $resultado=$pdo->prepare($sql);
            $resultado->execute(array(
                ':nombres'=>$nombres,
                ':apellidos'=>$apellidos,
                ':email'=>$email,
                ':password'=>$nuevoPassword,
                ':licenciatura'=>$licenciatura,
                ':semestre'=>$semestre
            ));
            header('Location:./login.html');
    
        } catch(PDOException $e){
    
            echo "Error al conectar a la base de datos", $e->getMessage();
        }

    }else{
        echo "<br/> <a href='./registro.html'>Registro</a>";
    }
}    

?>