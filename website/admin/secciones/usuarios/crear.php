<?php 
include("../../bd.php"); 

// Verificar si se envió el formulario
if($_POST){
    // Recibir valores del formulario
    $usuario=(isset($_POST['usuario']))?$_POST['usuario']:"";
    $password=(isset($_POST["password"]))?$_POST["password"]:"";
    $correo=(isset($_POST["correo"]))?$_POST["correo"]:"";
    
    // Preparar y ejecutar la sentencia de inserción
    $sentencia=$conexion->prepare("INSERT INTO `tbl_usuarios`
    (`ID`, `usuario`, `password`, `correo`) 
    VALUES (NULL,:usuario,:password,:correo);");

   $sentencia->bindParam(":usuario",$usuario);
   $sentencia->bindParam(":password",$password);
   $sentencia->bindParam(":correo",$correo);
   $sentencia->execute();
   
    // Redireccionar con mensaje de éxito
   $mensaje="Registro modificado con éxito.";
   header("Location:index.php?mensaje=".$mensaje);

}
include("../../templates/header.php"); 

?>

<div class="card">
    <div class="card-header">
        Usuario
    </div>
    <div class="card-body">
    
<form action="" method="post">
    <div class="mb-3">
      <label for="" class="form-label">Nombre del usaurio:</label>
      <input type="text"
        class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">

    </div>   
    <div class="mb-3">
      <label for="" class="form-label">Password</label>
      <input type="password"
        class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password">
      
    </div>    
    
    <div class="mb-3">
      <label for="correo" class="form-label">Correo:</label>
      <input type="email" class="form-control" name="correo" id="correo" aria-describedby="emailHelpId" placeholder="Correo">
      
    </div>

    <button type="submit" class="btn btn-success">Agregar</button>

<a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>




</form>

    </div>
    <div class="card-footer text-muted">
        
    </div>
</div>



<?php include("../../templates/footer.php"); ?>