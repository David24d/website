<?php 
// Parámetros de conexión a la base de datos
$servidor="localhost";
$baseDeDatos="website";
$usuario="root";
$contrasenia="";
//Establecer la conexión utilizando PDO
try{
    $conexion=new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
   
// En caso de error, imprimir el mensaje de error
}catch(Exception $error){
    echo $error->getMessage();
}

?>