<?php
include("../../conexion.php");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if($_POST){

  // Obtener el valor del campo idgrupo del formulario
  $idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";
  $ideacudiente = isset($_POST['idacudiente']) ? $_POST['idacudiente'] : "";
  $id = isset($_POST['id']) ? $_POST['id'] : "";

  // Verificar si existen las llaves foraneas y el id existe en la tabla grupos
  $consulta_grupo = $conexion->prepare("SELECT ide_gru FROM grupos WHERE ide_gru = ?");
  $consulta_grupo->bind_param("s", $idgrupo);
  $consulta_grupo->execute();
  $resultado_grupo = $consulta_grupo->get_result();

  $consulta_acudiente = $conexion->prepare("SELECT ide_acu FROM acudientes WHERE ide_acu = ?");
  $consulta_acudiente->bind_param("s", $ideacudiente);
  $consulta_acudiente->execute();
  $resultado_acudiente = $consulta_acudiente->get_result();

  $consulta_id = $conexion->prepare("SELECT ide_est FROM estudiantes WHERE ide_est = ?");
  $consulta_id->bind_param("s", $id);
  $consulta_id->execute();
  $resultado_id = $consulta_id->get_result();


// Verificar si se encontró el grupo
  if ($resultado_grupo->num_rows === 0  ) {
      // El grupo no existe, mostrar un mensaje de error o manejar la situación de alguna otra manera
      echo "El grupo especificado no existe.";
  }
  else if($resultado_acudiente->num_rows === 0){
    echo "El acudiente especificado no existe.";
  }   
  else if($resultado_id->num_rows != 0){
    echo "El id especificado ya existe.";
  } 

  // Verificar campos obligatorios
  $campos_obligatorios = array('id', 'nombre', 'apellido', 'direccion', 'idgrupo', 'idacudiente');
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
    // El grupo existe, continuar con la inserción en la tabla estudiantes

    // Obtener los valores de los otros campos del formulario
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : "";
    $ideacudiente = isset($_POST['idacudiente']) ? $_POST['idacudiente'] : "";
    $idegrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";

    // Preparar la consulta SQL para la inserción en la tabla estudiantes
    $stm = $conexion->prepare("INSERT INTO estudiantes(ide_est, nom_est, ape_est, dir_est, ide_gru, ide_acu) VALUES(?, ?, ?, ?, ?, ?)");

    // Enlazar los parámetros
    $stm->bind_param("ssssss", $id, $nombre, $apellido, $direccion, $idgrupo, $ideacudiente);

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
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR ESTUDIANTE</h5>
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

            <label for="">Direccion</label>
            <input type="text" class="form-control" name="direccion" value="" placeholder="Ingresar dirección">

            <label for="">Id del grupo</label>
            <input type="text" class="form-control" name="idgrupo" value="" placeholder="Ingresar id del grupo">

            <label for="">Id del acudiente </label>
            <input type="text" class="form-control" name="idacudiente" value="" placeholder="Ingresar id del acudiente">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>