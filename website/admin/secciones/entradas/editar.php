<?php 
// Inclusión del archivo de conexión a la base de datos
include("../../bd.php"); 
// Verificación si se ha proporcionado el ID a través de la variable GET
if(isset($_GET['txtID'])){
  // Obtener el ID desde la variable GET
  $txtID=( isset($_GET['txtID']) )?$_GET['txtID']:"";

  // Obtener los datos del registro a través del ID
  $sentencia=$conexion->prepare(" SELECT * FROM tbl_entradas WHERE id=:id ");
  $sentencia->bindParam(":id",$txtID);
  $sentencia->execute();
  $registro=$sentencia->fetch(PDO::FETCH_LAZY);
  
  // Asignar valores a variables para su uso en el formulario de edición
  $fecha=$registro["fecha"];
  $titulo=$registro['titulo'];
  $imagen=$registro["imagen"];
  $descripcion=$registro["descripcion"];
// Verificación si se ha enviado el formulario mediante el método POST
}
if($_POST){
 
  // Obtener valores desde el formulario
  $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
  $fecha=(isset($_POST["fecha"]))?$_POST["fecha"]:"";
  $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
  $descripcion=(isset($_POST["descripcion"]))?$_POST["descripcion"]:"";
  
  // Actualizar los datos del registro en la base de datos
  $sentencia=$conexion->prepare("UPDATE `tbl_entradas`
  SET fecha=:fecha,titulo=:titulo,descripcion=:descripcion WHERE id=:id ");

  $sentencia->bindParam(":fecha",$fecha);
  $sentencia->bindParam(":titulo",$titulo);
  $sentencia->bindParam(":descripcion",$descripcion);
  $sentencia->bindParam(":id",$txtID);
  $sentencia->execute();

  // Verificación si se ha proporcionado una nueva imagen en el formulario
  if($_FILES["imagen"]["tmp_name"]!=""){

    $imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";
    $fecha_imagen=new DateTime();
    $nombre_archivo_imagen=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";

    $tmp_imagen=$_FILES["imagen"]["tmp_name"];
    // Mover el archivo de imagen al directorio correspondiente
    move_uploaded_file($tmp_imagen,"../../../assets/img/about/".$nombre_archivo_imagen);
    
    //Borrado del archivo anterior
    $sentencia=$conexion->prepare("SELECT imagen FROM tbl_entradas WHERE id=:id ");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);

    if(isset($registro_imagen["imagen"])){
        if(file_exists("../../../assets/img/about/".$registro_imagen["imagen"])){
            unlink("../../../assets/img/about/".$registro_imagen["imagen"]);
        }
    }
    // Actualizar el nombre de la imagen en la base de datos
    $sentencia=$conexion->prepare("UPDATE tbl_entradas SET imagen=:imagen WHERE id=:id ");
    $sentencia->bindParam(":imagen",$nombre_archivo_imagen);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $imagen=$nombre_archivo_imagen;
  }
  // Redireccionar a la página de índice con un mensaje de éxito
  $mensaje="Registro modificado con éxito.";
  header("Location:index.php?mensaje=".$mensaje);

}
// Inclusión del archivo de encabezado
include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">
            Entradas 
    </div>
    <div class="card-body">

    <form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
      <label for="" class="form-label">ID:</label>
      <input type="text"
        class="form-control" readonly value="<?php echo $txtID;?>" name="txtID" id="txtID" aria-describedby="helpId" placeholder="">
     
    </div>

    <div class="mb-3">
         <label for="fecha" class="form-label">Fecha:</label>
         <input type="date"
           class="form-control" value="<?php echo $fecha;?>" name="fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha ">
       
       </div>

       <div class="mb-3">
         <label for="titulo" class="form-label">Título:</label>
         <input type="text"
           class="form-control" value="<?php echo $titulo;?>" name="titulo" id="titulo" aria-describedby="helpId" placeholder="Título">
       </div>

       <div class="mb-3">
         <label for="descripcion" class="form-label">Descripción:</label>
         <input type="text"
           class="form-control" value="<?php echo $descripcion;?>" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="Descripción">
       </div>

        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen:</label>
          <img width="50" src="../../../assets/img/about/<?php echo $imagen;?>" />
          <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Imagen" aria-describedby="fileHelpId">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>

<a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


    </form>

       
    


    </div>
    <div class="card-footer text-muted">
    </div>
</div>
<?php include("../../templates/footer.php"); ?>