<?php

include("netberryConnect.php");

func_mysqli_connect();

$selectTareas="SELECT * FROM tarea ORDER BY NOMBRE ASC";
$linkSelectTareas=mysqli_query($GLOBALS["conexion_mysqli"],$selectTareas);

$selectCategoria="SELECT * FROM categoria ORDER BY NOMBRE ASC";
$linkSelectCategoria=mysqli_query($GLOBALS["conexion_mysqli"],$selectCategoria);

$listadoCategorias=array();
?>
<style media="screen">
  .imgLogo{
    text-align: center;
  }
  #imgNetberry{
    width: 30%;
  }
  .container{
    width: 80%;
    margin: 0 auto;
    text-align: center;
  }
  h1{
    text-align: center;
    text-decoration: underline;
  }
  .gestorTarea{
    font-family: sans-serif !important;
    font-weight: 100;
    text-decoration: none;
  }
  .gestorTarea,#btnNuevaTarea{
    display: inline-block;
  }
  #btnNuevaTarea{
    margin-left: 2%;
    background-color: white;
    border: none;
  }
  #btnNuevaTarea:hover{
    cursor: pointer;
  }
  table{
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
  }
  thead{
    background-color: rgba(255, 108, 0, 0.85);
  }
  thead tr td{
    padding: 1%;
    border: solid 1px black;
    text-align: center;
    overflow: hidden;
  }
  tbody tr td{
    padding: 1%;
    border: solid 1px black;
  }
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.25);
    max-height: 100% !important;
  }
  .modal-header,.modal-content,.headerModal{
    padding: 0px !important;
  }
  .headerModal{
    font-size: 2rem;
    width: 100%;
    text-align: center;
    margin-bottom: 4% !important;
    color: black;
    font-family: sans-serif;
    font-weight: 100;
    margin: 4% !important;
  }
  .headerModal,.modal-header{
    background-color: white;
  }
  .modal-content {
    margin: 10% auto;
    width: 45%;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 7px 20px 0 rgba(0, 0, 0, 0.17);
    animation-name: modalopen;
    animation-duration: var(--modal-duration);
    background-color: white;
    border-radius: 30px;
  }

  .modal-header h2,.modal-footer h3 {
    margin: 0;
    text-align: center;
  }
  .buttons{
    text-align: center;
  }
  .modal-header {
    padding: 15px;
    color: #fff;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }
  .modal-body {
    padding: 10px 20px;
    background: #fff;
    overflow: hidden;
    border-radius: 30px;
  }
  .modal-footer {
    background: var(--modal-color);
    padding: 10px;
    color: #fff;
    text-align: center;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
  }
  .close {
    color: #000;
    float: right;
    font-size: 30px;
    position: relative;
    transform: translateX(-5px);
  }
  .close:hover,.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
  .btnModal{
    text-align: center;
    border-radius: 5px;
    color: white;
  }
  .acciones{
    text-align: center;
  }
  .acciones button{
    border: none;
    background-color: white;
  }
  .acciones button:hover{
    cursor: pointer;
  }
  form input,select{
    width: 50%;
    padding: 1%;
    border-radius: 5px;
    border: solid 1px rgb(111, 112, 112);
  }
  label{
    vertical-align: top;
    margin-top: 2%;
  }
  form{
    text-align: center;
  }
  span{
    padding: 1%;
    margin: 2%;
  }
  .buscador{
    text-align: center;
    width: 60%;
    margin: 0 auto;
  }
  .buscador input{
    width: 100%;
    border: none;
    padding: 2%;
    margin-bottom: 2%;
    border-bottom: solid 1px black;
  }
  .buscador input::-webkit-input-placeholder {
    font-size: 1.2rem;
    font-family: sans-serif;
  }
</style>
<div id="my-modal" class="modal">
  <div class="modal-content">
    <div class="modal-body">
      <span class="close">×</span>
      <h2 class="headerModal">AÑADIR TAREA</h2>
      <form class="" action="" method="post">
        <label for="NAME">Nombre: </label> <input id="NAME" type="text" name="NAME" placeholder="Ingrese el nombre de la tarea"><br><br>
        <label for="CATEGORIA">Categoria: </label> <select id="CATEGORIA" multiple class="" name="CATEGORIA">
          <?php while ($rowSelectCategoria = mysqli_fetch_assoc($linkSelectCategoria)) {
            $listadoCategorias[$rowSelectCategoria['IDCATEGORIA']]=$rowSelectCategoria['NOMBRE'];
            echo "<option value='".$rowSelectCategoria['IDCATEGORIA']."'>".$rowSelectCategoria['NOMBRE']."</option>";
          } ?>
        </select><br><br>
        <button type="button" name="ENVIAR" id="btnAñadir">Añadir</button>
      </form>
    </div>
  </div>
</div>
<div class="imgLogo">
  <img src="logotipo-netberry.png" id="imgNetberry">
</div>
<div class="container">
  <h1 class="gestorTarea">GESTOR DE TAREAS</h1><button type="button" name="button" id="btnNuevaTarea">Añadir</button>
  <div class="buscador">
    <input type='text' name='filtrar' class='buscador_faltantes' onkeyup='buscarCoincidencias(this, ".marco_busqueda", ".item_buscar")' placeholder="Buscar tarea">
  </div>
  <table>
    <thead>
      <tr>
        <td>Tarea</td>
        <td>Categoria</td>
        <td>Acciones</td>
      </tr>
    </thead>
    <tbody class="marco_busqueda">
      <?php while ($rowSelectTarea = mysqli_fetch_assoc($linkSelectTareas)) {
        $categoriasTarea= explode(',',$rowSelectTarea['IDCATEGORIA']);
        $nombreCategoria="";
        foreach ($categoriasTarea as $key => $value) {
          $nombreCategoria.="<span>".$listadoCategorias[$value]."</span>";
        }
        echo "<tr class='item_buscar' id='".$rowSelectTarea['IDTAREA']."'>";
        echo "<td>".$rowSelectTarea['NOMBRE']."</td>";
        echo "<td>".$nombreCategoria."</td>";
        echo "<td class='acciones'><button class='btnEliminar' id='".$rowSelectTarea['IDTAREA']."'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></button></td>";
        echo "</tr>";
      } ?>
    </tbody>
  </table>
</div>
<script src="https://use.fontawesome.com/1331e5c578.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
  const modal = document.querySelector('#my-modal');
  var tareaCategorias=<?php echo json_encode($listadoCategorias); ?>;
  $('#btnNuevaTarea').click(function(){
    openModal();
  });
  function openModal() {
    $('#my-modal').fadeIn("fast");
    $('.modal-content').fadeIn("slow");
  }
  function closeModal() {
    $('#my-modal').fadeOut("fast");
    $('.modal-content').fadeOut("slow");
  }

  $('.close').click(function(){
    closeModal();
  });
  $('.btnEliminar').click(function(){
    var idTarea= this.id;
    $.ajax({
       url: 'netberryAjax.php',
       type: 'POST',
       data: {
         ID:idTarea,
         TIPO: 'ELIMINAR'
       }
     })
     .done(function(respuesta){
       if(respuesta == "ok"){
         alert("Tarea eliminada correctamente");
         $('tr#'+idTarea).remove();
       }else{
         alert("Error al eliminar la tarea");
       }
     })
  });

  $('#btnAñadir').click(function(){
    if($('#NAME').val()==""){
      alert("Debes indicar el nombre de la tarea");
      return false;
    }
    if(!$('#CATEGORIA').val()){
      alert("Debes indicar la categoría de la tarea");
      return false;
    }
    $.ajax({
       url: 'netberryAjax.php',
       type: 'POST',
       data: {
         NOMBRE:$('#NAME').val(),
         CATEGORIA:$('#CATEGORIA').val(),
         TIPO: 'NUEVO'
       }
     })
     .done(function(respuesta){
       if(respuesta!='no'){
         alert("Tarea añadida correctamente");
         var categoria=$('#CATEGORIA').val();
         var nombreCategoria="";
         categoria.forEach(function(element){
           nombreCategoria+="<span>"+tareaCategorias[element]+"</span>";
         });
         $("tbody").append($("<tr id='"+respuesta+"'><td>"+$('#NAME').val()+"</td><td>"+nombreCategoria+"</td><td class='acciones'><button class='btnEliminar' id='"+respuesta+"'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></i></button></td></tr>"));
         permitirBorrar(respuesta);
         $('#NAME').val('');
         $('#CATEGORIA').val('');
       }else{
         alert("Error al añadir la tarea");
       }
     })
  });
  function permitirBorrar(id){
    $('#'+id+'.btnEliminar').click(function(){
      var idTarea= id;
      $.ajax({
         url: 'netberryAjax.php',
         type: 'POST',
         data: {
           ID:idTarea,
           TIPO: 'ELIMINAR'
         }
       })
       .done(function(respuesta){
         if(respuesta == "ok"){
           alert("Tarea eliminada correctamente");
           $('tr#'+idTarea).remove();
         }else{
           alert("Error al eliminar la tarea");
         }
       })
    });
  }
  function buscarCoincidencias (input, contenedor, hijo) {
    var valor = $.trim($(input).val());
    $(contenedor).find(hijo).hide();
    if (valor == "") {
         $(contenedor).find(hijo).show();
    } else {
        document.querySelectorAll(hijo).forEach(function(elem){
          if(elem.innerText.toUpperCase().includes(valor.toUpperCase())){
            var opcion=$(contenedor).find(elem);
            opcion.show();
          }
        });
    }
  }
</script>
