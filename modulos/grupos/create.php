<?php
include("../../conexion.php");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if($_POST){

  // Obtener el valor del campo idgrupo del formulario
  $id = isset($_POST['id']) ? $_POST['id'] : "";
  $numgrado = isset($_POST['num_gra']) ? $_POST['num_gra'] : "";

  // Verificar si existen las llaves foraneas y el id existe en la tabla grupos

  $consulta_id = $conexion->prepare("SELECT ide_gru FROM grupos WHERE ide_gru = ?");
  $consulta_id->bind_param("s", $id);
  $consulta_id->execute();
  $resultado_id = $consulta_id->get_result();
  
  $consulta_grado = $conexion->prepare("SELECT num_gra FROM grados WHERE num_gra = ?");
  $consulta_grado->bind_param("s", $numgrado);
  $consulta_grado->execute();
  $resultado_grado = $consulta_grado->get_result();

// Verificar si se encontró el grupo
  if($resultado_id->num_rows != 0){
    echo "El id especificado ya existe.";
  }
  if ($resultado_grado->num_rows === 0  ) {
    // El grupo no existe, mostrar un mensaje de error o manejar la situación de alguna otra manera
    echo "El grado especificado no existe.";
}
  
  // Verificar campos obligatorios
  $campos_obligatorios = array('id', 'capacidad', 'grado');
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
    $capacidad = isset($_POST['capacidad']) ? $_POST['capacidad'] : "";
    $grado = isset($_POST['grado']) ? $_POST['grado'] : "";
    

    // Preparar la consulta SQL para la inserción en la tabla estudiantes
    $stm = $conexion->prepare("INSERT INTO grupos(ide_gru, cap_est_gru, num_gra) VALUES(?, ?, ?)");

    // Enlazar los parámetros
    $stm->bind_param("sss", $id, $capacidad, $grado);

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
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR GRUPO </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
          <div class="modal-body">

            <label for="">Id</label>
            <input type="text" class="form-control" name="id" value="" placeholder="Ingresar id">

            <label for="">Capacidad de estudiantes</label>
            <input type="text" class="form-control" name="capacidad" value="" placeholder="Ingresar nombre">

            <label for="">Grado</label>
            <input type="text" class="form-control" name="grado" value="" placeholder="Ingresar el grado del grupo">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>