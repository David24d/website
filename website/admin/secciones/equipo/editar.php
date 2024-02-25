<?php 
// Incluir el archivo de conexión a la base de datos
include("../../bd.php");
  // Verificar si se ha recibido un ID para editar un registro existente
if(isset($_GET['txtID'])){

    // Obtener el ID desde la URL
    $txtID=( isset($_GET['txtID']) )?$_GET['txtID']:"";
    
    // Obtener los detalles del registro existente para mostrar en el formulario
    $sentencia=$conexion->prepare(" SELECT * FROM tbl_equipo WHERE id=:id ");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
     
     // Asignar valores a variables para utilizar en el formulario
    $imagen=$registro["imagen"];
    $nombrecompleto=$registro["nombrecompleto"];
    $puesto=$registro["puesto"];
    $twitter=$registro["twitter"];
    $facebook=$registro["facebook"];
    $linkedin=$registro["linkedin"];
  
  }
  // Verificar si se ha enviado el formulario para actualizar el registro

  if($_POST){
    
    // Obtener valores del formulario
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";
    $nombrecompleto=(isset($_POST["nombrecompleto"]))?$_POST["nombrecompleto"]:"";
    $puesto=(isset($_POST['puesto']))?$_POST['puesto']:"";
    $twitter=(isset($_POST["twitter"]))?$_POST["twitter"]:"";
    $facebook=(isset($_POST["facebook"]))?$_POST["facebook"]:"";
    $linkedin=(isset($_POST["linkedin"]))?$_POST["linkedin"]:"";
    
    // Preparar la sentencia SQL para actualizar el registro
    $sentencia=$conexion->prepare("UPDATE tbl_equipo SET
    nombrecompleto=:nombrecompleto,
    puesto=:puesto,
    twitter=:twitter,
    facebook=:facebook,
    linkedin=:linkedin
    WHERE ID=:id ");

    $sentencia->bindParam(":nombrecompleto",$nombrecompleto);
    $sentencia->bindParam(":puesto",$puesto);
    $sentencia->bindParam(":twitter",$twitter);
    $sentencia->bindParam(":facebook",$facebook);
    $sentencia->bindParam(":linkedin",$linkedin);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    // Vincular parámetros y ejecutar la sentenci
  if($_FILES["imagen"]["tmp_name"]!=""){
    
     // Obtener detalles de la imagen actual
    $imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";
    $fecha_imagen=new DateTime();
    $nombre_archivo_imagen=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";

    $tmp_imagen=$_FILES["imagen"]["tmp_name"];
  
    // Mover la nueva imagen al directorio y eliminar la imagen anterior
    move_uploaded_file($tmp_imagen,"../../../assets/img/team/".$nombre_archivo_imagen);
    $sentencia=$conexion->prepare("SELECT imagen FROM tbl_equipo WHERE id=:id ");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);
  
    // Verificar y eliminar la imagen anterior
    if(isset($registro_imagen["imagen"])){
        if(file_exists("../../../assets/img/team/".$registro_imagen["imagen"])){
            unlink("../../../assets/img/team/".$registro_imagen["imagen"]);
        }
    }
    // Actualizar el nombre de la imagen en la base de datos
    $sentencia=$conexion->prepare("UPDATE tbl_equipo SET imagen=:imagen WHERE id=:id ");
    $sentencia->bindParam(":imagen",$nombre_archivo_imagen);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $imagen=$nombre_archivo_imagen;
  }
  // Redireccionar a la página de listado con un mensaje de éxito
  $mensaje="Registro modificado con éxito.";
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
      <label for="" class="form-label">ID:</label>
      <input readonly value="<?php echo $txtID;?>" type="text"    
        class="form-control" name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
      
    </div>

    <div class="mb-3">
   
      <label for="imagen" class="form-label">Imagen:</label>
      <img width="50" src="../../../assets/img/team/<?php echo $imagen;?>" />
      <input type="file"
        class="form-control" name="imagen" id="imagen" aria-describedby="helpId" placeholder="Imagen">
    </div>
    <div class="mb-3">
      <label for="nombrecompleto" class="form-label">Nombre completo:</label>
      <input type="text"
        class="form-control" value="<?php echo $nombrecompleto;?>" name="nombrecompleto" id="nombrecompleto" aria-describedby="helpId" placeholder="Nombre">
      
    </div>
    <div class="mb-3">
      <label for="puesto" class="form-label">Puesto:</label>
      <input type="text"
        class="form-control"value="<?php echo $puesto;?>" name="puesto" id="puesto" aria-describedby="helpId" placeholder="Puesto">
      
    </div>

    <div class="mb-3">
      <label for="twitter" class="form-label">Twitter:</label>
      <input type="text"
        class="form-control" value="<?php echo $twitter;?>" name="twitter" id="twitter" aria-describedby="helpId" placeholder="Twitter">
      
    </div>

    <div class="mb-3">
      <label for="facebook" class="form-label">Facebook:</label>
      <input type="text"
        class="form-control" value="<?php echo $facebook;?>" name="facebook" id="facebook" aria-describedby="helpId" placeholder="Facebook">
     
    </div>

    <div class="mb-3">
      <label for="linkedin" class="form-label">Linkedin:</label>
      <input type="text"
        class="form-control" value="<?php echo $linkedin;?>" name="linkedin" id="linkedin" aria-describedby="helpId" placeholder="Linkedin">
      
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>

<a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


    </form>

   
    

    </div>
    <div class="card-footer text-muted">
        
    </div>
</div>


<?php include("../../templates/footer.php"); ?>