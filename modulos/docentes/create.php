<?php
include("../../conexion.php");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if($_POST){

  // Obtener el valor del campo idgrupo del formulario
  $id = isset($_POST['id']) ? $_POST['id'] : "";

  // Verificar si existen las llaves foraneas y el id existe en la tabla grupos

  $consulta_id = $conexion->prepare("SELECT ide_doc FROM docentes WHERE ide_doc = ?");
  $consulta_id->bind_param("s", $id);
  $consulta_id->execute();
  $resultado_id = $consulta_id->get_result();


// Verificar si se encontró el grupo
  if($resultado_id->num_rows != 0){
    echo "El id especificado ya existe.";
  } 

  // Verificar campos obligatorios
  $campos_obligatorios = array('id', 'nombre', 'apellido', 'direccion');
  $campos_vacios = array();
  foreach($campos_obligatorios as $campo) {
    if(empty($_POST[$campo])) {
      $campos_vacios[] = $campo;
    }
  }

  if(!empty($campos_vacios)) {
    echo "Los siguientes campos son obligatorios y no pueden estar vacíos: " . implode(', ', $campos_vacios);
  }

  else {
    
        // Obtener los valores de los otros campos del formulario
        $id = isset($_POST['id']) ? $_POST['id'] : "";
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
        $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : "";
        

        // Preparar la consulta SQL para la inserción en la tabla estudiantes
        $stm = $conexion->prepare("INSERT INTO docentes(ide_doc, nom_doc, ape_doc, dir_doc) VALUES(?, ?, ?, ?)");

        // Enlazar los parámetros
        $stm->bind_param("ssss", $id, $nombre, $apellido, $direccion);

        // Ejecutar la consulta
        $result = $stm->execute();

        // Verificar si la ejecución de la consulta fue exitosa
        if ($result === false) {
            die("Error al ejecutar la consulta: " . $stm->error);
        }

        // Redirigir después de la inserción
        header("location:index.php");
        exit(); // Importante para evitar que se siga ejecutando el código después de la redirección
  }
}
?>

<!-- Modal create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR DOCENTE </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
          <div class="modal-body">
            <label for="">Id</label>
            <input type="text" class="form-control" name="id" value="" placeholder="Ingresar id">

            <label for="">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="" placeholder="Ingresar nombre">

            <label for="">Apellido</label>
            <input type="text" class="form-control" name="apellido" value="" placeholder="Ingresar apellido">

            <label for="">direccion</label>
            <input type="text" class="form-control" name="direccion" value="" placeholder="Ingresar dirección">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>