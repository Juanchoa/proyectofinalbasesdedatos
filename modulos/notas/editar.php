<?php
include("../../conexion.php");

$idnota = $numeronota = $tema = $calificacion = $idmateria = $idestudiante = "";

if (isset($_GET['id'])) {
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("SELECT * FROM notas WHERE ide_not = ?");
    $stm->bind_param("i", $txtid);
    $stm->execute();
    $resultado = $stm->get_result();
    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        // Verificar si las claves del array están definidas antes de acceder a ellas
        if (isset($registro['num_not'])) $id = $registro['num_not'];
        if (isset($registro['tem_not'])) $nombre = $registro['tem_not'];
        if (isset($registro['cal_not'])) $apellido = $registro['cal_not'];
        if (isset($registro['ide_mat'])) $direccion = $registro['ide_mat'];
        if (isset($registro['ide_est'])) $idegrupo = $registro['ide_est'];
    } else {
        // Manejo de error si no se encuentra el estudiante
        echo "Nota no encontrada.";
        exit; // Salir del script para evitar procesamiento adicional
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
            $stm = $conexion->prepare("UPDATE estudiantes SET num_not=?, tem_not=?, cal_not=?, ide_mat=?, ide_est=? WHERE ide_not=?");

            // Enlazar los parámetros
            $stm->bind_param("ssssss", $numeronota, $tema, $calificacion, $idmateria, $idestudiante,$id);

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

    <label for="">Numero de la nota</label>
    <input type="text" class="form-control" name="numeronota" value="<?php echo $numeronota; ?>" placeholder="Ingresar nombre">

    <label for="">Tema</label>
    <input type="text" class="form-control" name="tema" value="<?php echo $tema; ?>" placeholder="Ingresar apellido">

    <label for="">Calificaion</label>
    <input type="text" class="form-control" name="calificacion" value="<?php echo $calificacion; ?>" placeholder="Ingresar dirección">

    <label for="">Id de la materia</label>
    <input type="text" class="form-control" name="idmateria" value="<?php echo $idmateria; ?>" placeholder="Ingresar ide del grupo">

    <label for="">Id del estudiante </label>
    <input type="text" class="form-control" name="idestudiante" value="<?php echo $idestudiante; ?>" placeholder="Ingresar ide del acudiente">

    <div class="modal-footer">
        <a href="index.php" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
</form>

<?php include("../../template/footer.php"); ?>