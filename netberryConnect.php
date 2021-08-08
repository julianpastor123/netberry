<?php

function func_mysqli_connect () {
  $link = @mysqli_connect("localhost", "root", "root","netberry");
  mysqli_set_charset ( $link , 'utf8');
  if (!$link){echo "No se pudo conectar a la bd";exit;}
  $GLOBALS["conexion_mysqli"] = $link;
}

?>
