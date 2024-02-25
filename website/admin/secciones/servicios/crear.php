<?php 
// Incluir el archivo de conexión a la base de datos
include("../../bd.php"); 

// Verificar si se ha enviado un formulario (POST)
if($_POST){

     // Recepcionamos los valores del formulario
    $icono=(isset($_POST['icono']))?$_POST['icono']:"";
    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";

     // Insertar un nuevo registro en la tabla tbl_servicios
    $sentencia=$conexion->prepare("INSERT INTO `tbl_servicios` (`ID`,`icono`,`titulo`, `descripcion`) 
    VALUES (NULL, :icono, :titulo, :descripcion);");
    
    $sentencia->bindParam(":icono",$icono);
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->bindParam(":descripcion",$descripcion);

    $sentencia->execute();

     // Redireccionar a la página principal de servicios con un mensaje de éxito
    $mensaje="Registro agregado con éxito.";
    header("Location:index.php?mensaje=".$mensaje);
}

// Incluir el archivo de cabecera (header.php) para mantener consistencia en el diseño
include("../../templates/header.php"); 
?>

<div class="card">
    
    <div class="card-header">
        Crear servicios 
    </div>
    
    <div class="card-body">
    
    <form action="" enctype="multipart/form-data" method="post">

    <div class="mb-3">
      <label for="icono" class="form-label">Icono:</label>
      <input type="text"
        class="form-control" name="icono" id="icono" aria-describedby="helpId" placeholder="Icono">
    </div>

    <div class="mb-3">
      <label for="titulo" class="form-label">Título:</label>
      <input type="text"
        class="form-control" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción:</label>
      <input type="text"
        class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
      
    </div>


    <button type="submit" class="btn btn-success">Agregar</button>

    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    



    </form>

    
    
    </div>
    
    <div class="card-footer text-muted"> 


    </div>
</div>


<?php include("../../templates/footer.php"); ?>