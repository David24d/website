<?php 
// Inclusión del archivo de conexión a la base de datos
include("../../bd.php"); 

// Verifica si se ha enviado el formulario de creación
if($_POST){
    // Obtiene valores del formulario
    $fecha=(isset($_POST["fecha"]))?$_POST["fecha"]:"";
    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST["descripcion"]))?$_POST["descripcion"]:"";
    $imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";

    // Genera un nombre único para el archivo de imagen
    $fecha_imagen=new DateTime();
    $nombre_archivo_imagen=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";
  
    // Ruta temporal del archivo de imagen
    $tmp_imagen=$_FILES["imagen"]["tmp_name"];

    // Mueve la imagen a la carpeta de destino
    if($tmp_imagen!=""){
      move_uploaded_file($tmp_imagen,"../../../assets/img/about/".$nombre_archivo_imagen);
    }

    // Prepara la consulta de inserción
    $sentencia=$conexion->prepare("INSERT INTO `tbl_entradas`
    (`ID`,`fecha`,`titulo`,`descripcion`,`imagen`) 
    VALUES (NULL,:fecha,:titulo,:descripcion,:imagen);");

   // Asocia parámetros y ejecuta la consulta de inserción
   $sentencia->bindParam(":fecha",$fecha);
   $sentencia->bindParam(":titulo",$titulo);
   $sentencia->bindParam(":descripcion",$descripcion);
   $sentencia->bindParam(":imagen",$nombre_archivo_imagen);
   $sentencia->execute();

   // Redirecciona con un mensaje de éxito
   $mensaje="Registro agregado con éxito.";
   header("Location:index.php?mensaje=".$mensaje);

}

// Inclusión del archivo de encabezado
include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
            Entradas 
    </div>
    <div class="card-body">

    <form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
         <label for="fecha" class="form-label">Fecha:</label>
         <input type="date"
           class="form-control" name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha ">
       
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

        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen:</label>
          <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Imagen" aria-describedby="fileHelpId">
        </div>

        <button type="submit" class="btn btn-success">Agregar</button>

<a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


    </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>

<?php include("../../templates/footer.php"); ?>