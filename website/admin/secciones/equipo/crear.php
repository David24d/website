<?php 
// Incluir el archivo de conexión a la base de datos
include("../../bd.php");
// Verificar si se ha enviado un formulario mediante POST
if($_POST){
       // Obtener valores del formulario
        $imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";
        $nombrecompleto=(isset($_POST["nombrecompleto"]))?$_POST["nombrecompleto"]:"";
        $puesto=(isset($_POST['puesto']))?$_POST['puesto']:"";
        $twitter=(isset($_POST["twitter"]))?$_POST["twitter"]:"";
        $facebook=(isset($_POST["facebook"]))?$_POST["facebook"]:"";
        $linkedin=(isset($_POST["linkedin"]))?$_POST["linkedin"]:"";

        
        // Crear una instancia de DateTime para generar un nombre único para la imagen

        $fecha_imagen=new DateTime();
        $nombre_archivo_imagen=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";

        // Obtener la ubicación temporal de la imagen
        $tmp_imagen=$_FILES["imagen"]["tmp_name"];
 
        // Mover la imagen al directorio de imágenes del equipo
        if($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen,"../../../assets/img/team/".$nombre_archivo_imagen);
        }

        // Preparar y ejecutar la sentencia SQL para insertar en la tabla tbl_equipo

        $sentencia=$conexion->prepare("INSERT INTO `tbl_equipo`
        (`ID`,`imagen`,`nombrecompleto`,`puesto`,`twitter`,`facebook`,`linkedin`) 
        VALUES (NULL,:imagen,:nombrecompleto,:puesto,:twitter,:facebook,:linkedin);");

        $sentencia->bindParam(":imagen",$nombre_archivo_imagen);
        $sentencia->bindParam(":nombrecompleto",$nombrecompleto);
        $sentencia->bindParam(":puesto",$puesto);
        $sentencia->bindParam(":twitter",$twitter);
        $sentencia->bindParam(":facebook",$facebook);
        $sentencia->bindParam(":linkedin",$linkedin);

        $sentencia->execute();
        // Redirigir a la página de listado con un mensaje de éxito

        $mensaje="Registro agregado con éxito.";
        header("Location:index.php?mensaje=".$mensaje);
}


// Incluir el encabezado de la página
include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        Datos de la persona
    </div>
    <div class="card-body">
    
    <form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen:</label>
      <input type="file"
        class="form-control" name="imagen" id="imagen" aria-describedby="helpId" placeholder="Imagen">
    </div>
    <div class="mb-3">
      <label for="nombrecompleto" class="form-label">Nombre completo:</label>
      <input type="text"
        class="form-control" name="nombrecompleto" id="nombrecompleto" aria-describedby="helpId" placeholder="Nombre">
      
    </div>
    <div class="mb-3">
      <label for="puesto" class="form-label">Puesto:</label>
      <input type="text"
        class="form-control" name="puesto" id="puesto" aria-describedby="helpId" placeholder="Puesto">
      
    </div>

    <div class="mb-3">
      <label for="twitter" class="form-label">Twitter:</label>
      <input type="text"
        class="form-control" name="twitter" id="twitter" aria-describedby="helpId" placeholder="Twitter">
      
    </div>

    <div class="mb-3">
      <label for="facebook" class="form-label">Facebook:</label>
      <input type="text"
        class="form-control" name="facebook" id="facebook" aria-describedby="helpId" placeholder="Facebook">
     
    </div>

    <div class="mb-3">
      <label for="linkedin" class="form-label">Linkedin:</label>
      <input type="text"
        class="form-control" name="linkedin" id="linkedin" aria-describedby="helpId" placeholder="Linkedin">
      
    </div>

    <button type="submit" class="btn btn-success">Agregar</button>

<a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


    </form>

   
    

    </div>
    <div class="card-footer text-muted">
        
    </div>
</div>

<?php include("../../templates/footer.php"); ?>