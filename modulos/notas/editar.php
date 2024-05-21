<?php
include("../../conexion.php");

$idnota = $numeronota = $tema = $calificacion = $idmateria = $idestudiante = "";

if (isset($_GET['id'])) {
    $txtid = $_GET['id'];
    $stm = $conexion->prepare("SELECT * FROM notas WHERE ide_not = ?");
    $stm->bind_param("i", $txtid);
    $stm->execute();
    $resultado = $stm->get_result();
    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        $idnota = $registro['ide_not'];
        $numeronota = $registro['num_not'];
        $tema = $registro['tem_not'];
        $calificacion = $registro['cal_not'];
        $idmateria = $registro['ide_mat'];
        $idestudiante = $registro['ide_est'];
    } else {
        echo "Nota no encontrada.";
        exit;
    }

    if($_POST){
        $idmateria = $_POST['idmateria'];
        $idestudiante = $_POST['idestudiante'];

        $consulta_materia = $conexion->prepare("SELECT ide_mat FROM materias WHERE ide_mat = ?");
        $consulta_materia->bind_param("s", $idmateria);
        $consulta_materia->execute();
        $resultado_materia = $consulta_materia->get_result();

        $consulta_estudiante = $conexion->prepare("SELECT ide_est FROM estudiantes WHERE ide_est = ?");
        $consulta_estudiante->bind_param("s", $idestudiante);
        $consulta_estudiante->execute();
        $resultado_estudiante = $consulta_estudiante->get_result();

        if ($resultado_materia->num_rows === 0  ) {
            echo "La materia especificada no existe.";
        }
        else if($resultado_estudiante->num_rows === 0){
            echo "El estudiante especificado no existe.";
        }   
        else {
            $numeronota = $_POST['numeronota'];
            $tema = $_POST['tema'];
            $calificacion = $_POST['calificacion'];
            $idmateria = $_POST['idmateria'];
            $idestudiante = $_POST['idestudiante'];

            $stm = $conexion->prepare("UPDATE notas SET num_not=?, tem_not=?, cal_not=?, ide_mat=?, ide_est=? WHERE ide_not=?");
            $stm->bind_param("ssssss", $numeronota, $tema, $calificacion, $idmateria, $idestudiante, $txtid);

            if (!$stm->execute()) {
                die("Error al ejecutar la consulta: " . $stm->error);
            }

            header("location:index.php");
            exit();
        }
    } 
}

?>
<?php include("../../template/header.php"); ?>

<form action="" method="post">
    <input type="hidden" name="txtid" value="<?php echo $idnota; ?>">
    <label for="">Numero de la nota</label>
    <input type="text" class="form-control" name="numeronota" value="<?php echo $numeronota; ?>" placeholder="Ingresar numero de la nota">
    <label for="">Tema</label>
    <input type="text" class="form-control" name="tema" value="<?php echo $tema; ?>" placeholder="Ingresar tema">
    <label for="">Calificaion</label>
    <input type="text" class="form-control" name="calificacion" value="<?php echo $calificacion; ?>" placeholder="Ingresar calificacion">
    <label for="">Id de la materia</label>
    <input type="text" class="form-control" name="idmateria" value="<?php echo $idmateria; ?>" placeholder="Ingresar id de la materia">
    <label for="">Id del estudiante </label>
    <input type="text" class="form-control" name="idestudiante" value="<?php echo $idestudiante; ?>" placeholder="Ingresar id del estudiante">
    <div class="modal-footer">
        <a href="index.php" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
</form>

<?php include("../../template/footer.php"); ?>
