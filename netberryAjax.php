<?php

include("netberryConnect.php");

func_mysqli_connect();

if(isset($_POST['TIPO']) && $_POST['TIPO']=="NUEVO"){
  $categoria=implode(',',$_POST['CATEGORIA']);
  $insertTarea="INSERT INTO tarea(IDCATEGORIA,NOMBRE)VALUES('$categoria','$_POST[NOMBRE]')";
  $linkInsertTarea=mysqli_query($GLOBALS["conexion_mysqli"],$insertTarea);
  if($linkInsertTarea){
    echo json_encode(mysqli_insert_id($GLOBALS["conexion_mysqli"]));
  }else{
    echo "no";
  }
}

if(isset($_POST['TIPO']) && $_POST['TIPO']=="ELIMINAR"){
  $eliminarTarea="DELETE FROM tarea WHERE IDTAREA=$_POST[ID]";
  $linkEliminarTarea=mysqli_query($GLOBALS["conexion_mysqli"],$eliminarTarea);
  if($linkEliminarTarea){
    echo "ok";
  }else{
    echo "no";
  }
}

?>
