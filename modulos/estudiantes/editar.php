<?php
include("../../conexion.php");

$id = $nombre = $apellido = $direccion = $idegrupo = $ideacudiente = "";

if (isset($_GET['id'])) {
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("SELECT * FROM estudiantes WHERE ide_est = ?");
    $stm->bind_param("i", $txtid);
    $stm->execute();
    $resultado = $stm->get_result();
    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        // Verificar si las claves del array están definidas antes de acceder a ellas
        if (isset($registro['ide_est'])) $id = $registro['ide_est'];
        if (isset($registro['nom_est'])) $nombre = $registro['nom_est'];
        if (isset($registro['ape_est'])) $apellido = $registro['ape_est'];
        if (isset($registro['dir_est'])) $direccion = $registro['dir_est'];
        if (isset($registro['ide_gru'])) $idegrupo = $registro['ide_gru'];
        if (isset($registro['ide_acu'])) $ideacudiente = $registro['ide_acu'];
    } else {
        // Manejo de error si no se encuentra el estudiante
        echo "Estudiante no encontrado.";
        exit; // Salir del script para evitar procesamiento adicional
    }

    if($_POST){

        // Obtener el valor del campo idgrupo del formulario
        $idgrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";
        $ideacudiente = isset($_POST['idacudiente']) ? $_POST['idacudiente'] : "";
        $id = isset($_POST['id']) ? $_POST['id'] : "";
      
        // Verificar si el grupo existe en la tabla grupos
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
            $campos_obligatorios = array('nombre', 'apellido', 'direccion', 'idgrupo', 'idacudiente');
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
          $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
          $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
          $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : "";
          $ideacudiente = isset($_POST['idacudiente']) ? $_POST['idacudiente'] : "";
          $idegrupo = isset($_POST['idgrupo']) ? $_POST['idgrupo'] : "";
      
          $stm = $conexion->prepare("UPDATE estudiantes SET nom_est=?, ape_est=?, dir_est=?, ide_gru=?, ide_acu=? WHERE ide_est=?");

            // Enlazar los parámetros
            $stm->bind_param("ssssss", $nombre, $apellido, $direccion, $idgrupo, $ideacudiente, $txtid);

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

    <label for="">Nombre</label>
    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" placeholder="Ingresar nombre">

    <label for="">Apellido</label>
    <input type="text" class="form-control" name="apellido" value="<?php echo $apellido; ?>" placeholder="Ingresar apellido">

    <label for="">Direccion</label>
    <input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>" placeholder="Ingresar dirección">

    <label for="">Id del grupo</label>
    <input type="text" class="form-control" name="idgrupo" value="<?php echo $idegrupo; ?>" placeholder="Ingresar ide del grupo">

    <label for="">Id del acudiente </label>
    <input type="text" class="form-control" name="idacudiente" value="<?php echo $ideacudiente; ?>" placeholder="Ingresar ide del acudiente">

    <div class="modal-footer">
        <a href="index.php" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
</form>

<?php include("../../template/footer.php"); ?>