<?php
include("../../conexion.php");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if($_POST){

  // Obtener el valor del campo idgrupo del formulario
  $idmateria = isset($_POST['idmateria']) ? $_POST['idmateria'] : "";
  $idestudiante = isset($_POST['idmateria']) ? $_POST['idmateria'] : "";

  // Verificar si existen las llaves foraneas y el id existe en la tabla grupos
  $consulta_materia = $conexion->prepare("SELECT ide_mat FROM materias WHERE ide_mat = ?");
  $consulta_materia->bind_param("i", $idmateria);
  $consulta_materia->execute();
  $resultado_materia = $consulta_materia->get_result();

  $consulta_estudiante = $conexion->prepare("SELECT ide_est FROM estudiantes WHERE ide_est = ?");
  $consulta_estudiante->bind_param("i", $idestudiante);
  $consulta_estudiante->execute();
  $resultado_estudiante = $consulta_estudiante->get_result();


// Verificar si se encontró el grupo
  if ($resultado_materia->num_rows === 0  ) {
      // El grupo no existe, mostrar un mensaje de error o manejar la situación de alguna otra manera
      echo "La materia especificado no existe.";
  }
  else if($resultado_estudiante->num_rows === 0){
    echo "El estudiante especificado no existe.";
  }   

  // Verificar campos obligatorios
  $campos_obligatorios = array('numeronota', 'tema', 'calificacion', 'idmateria', 'idestudiante');
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
    $numeronota = isset($_POST['numeronota']) ? $_POST['numeronota'] : "";
    $tema = isset($_POST['tema']) ? $_POST['tema'] : "";
    $calificacion = isset($_POST['calificacion']) ? $_POST['calificacion'] : "";
    $idmateria = isset($_POST['idmateria']) ? $_POST['idmateria'] : "";
    $idestudiante = isset($_POST['idestudiante']) ? $_POST['idestudiante'] : "";
    

    // Preparar la consulta SQL para la inserción en la tabla estudiantes
    $stm = $conexion->prepare("INSERT INTO notas(num_not, tem_not, cal_not, ide_mat, ide_est) VALUES(?, ?, ?, ?, ?)");

    // Enlazar los parámetros
    $stm->bind_param("sssss", $numeronota, $tema, $calificacion, $idmateria, $idestudiante);

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
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR NOTA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
          <div class="modal-body">
            <label for="">Numero de nota</label>
            <input type="text" class="form-control" name="numeronota" value="" placeholder="Ingresar el numero de la nota">

            <label for="">Tema</label>
            <input type="text" class="form-control" name="tema" value="" placeholder="Ingresar el tema">

            <label for="">Calificaion</label>
            <input type="text" class="form-control" name="calificacion" value="" placeholder="Ingresar la calificaion">

            <label for="">Id materia</label>
            <input type="text" class="form-control" name="idmateria" value="" placeholder="Ingresar id de la materia">

            <label for="">Id estudiante</label>
            <input type="text" class="form-control" name="idestudiante" value="" placeholder="Ingresar id del estudiante">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>