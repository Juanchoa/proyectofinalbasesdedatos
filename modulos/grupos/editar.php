<?php
include("../../conexion.php");

$id = $capacidad = $grado = "";

if (isset($_GET['id'])) {
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("SELECT * FROM grupos WHERE ide_gru = ?");
    $stm->bind_param("i", $txtid);
    $stm->execute();
    $resultado = $stm->get_result();
    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        // Verificar si las claves del array están definidas antes de acceder a ellas
        if (isset($registro['ide_gru'])) $id = $registro['ide_gru'];
        if (isset($registro['cap_est_gru'])) $capacidad = $registro['cap_est_gru'];
        if (isset($registro['num_gra'])) $grado = $registro['num_gra'];
    } else {
        // Manejo de error si no se encuentra el estudiante
        echo "Estudiante no encontrado.";
        exit; // Salir del script para evitar procesamiento adicional
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
        $campos_obligatorios = array( 'capacidad', 'grado');
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
          $stm = $conexion->prepare("UPDATE grupos SET cap_est_gru=?, num_gra=? WHERE ide_gru=?");

          // Enlazar los parámetros
          $stm->bind_param("sss", $capacidad, $grado, $txtid);

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
    }
?>
<?php include("../../template/header.php"); ?>

<form action="" method="post">
    <label for="">Id</label>
    <input type="hidden" class="form-control" name="txtid" value="<?php echo $txtid; ?>" placeholder="Ingresar id">

    <label for="">Capacidad de estudiantes</label>
    <input type="text" class="form-control" name="capacidad" value="<?php echo $capacidad; ?>" placeholder="Ingresar nombre">

    <label for="">Grado</label>
    <input type="text" class="form-control" name="grado" value="<?php echo $grado; ?>" placeholder="Ingresar apellido">

    <div class="modal-footer">
        <a href="index.php" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
</form>

<?php include("../../template/footer.php"); ?>