<?php
include("../../conexion.php");

$id = $nombre = $apellido = $direccion = $email = $telefono = "";

if (isset($_GET['id'])) {
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("SELECT * FROM acudientes WHERE ide_acu = ?");
    $stm->bind_param("i", $txtid);
    $stm->execute();
    $resultado = $stm->get_result();
    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        // Verificar si las claves del array están definidas antes de acceder a ellas
        if (isset($registro['ide_acu'])) $id = $registro['ide_acu'];
        if (isset($registro['dir_acu'])) $direccion = $registro['dir_acu'];
        if (isset($registro['ape_acu'])) $apellido = $registro['ape_acu'];
        if (isset($registro['nom_acu'])) $nombre = $registro['nom_acu'];
        if (isset($registro['tel_acu'])) $telefono = $registro['tel_acu'];
        if (isset($registro['ema_acu'])) $email = $registro['ema_acu'];
    } else {
        // Manejo de error si no se encuentra el estudiante
        echo "Acudiente no encontrado.";
        exit; // Salir del script para evitar procesamiento adicional
    }

    if($_POST){

        // Obtener el valor del campo idgrupo del formulario
        $id = isset($_POST['id']) ? $_POST['id'] : "";

        // Verificar si existen las llaves foraneas y el id existe en la tabla grupos

        $consulta_id = $conexion->prepare("SELECT ide_acu FROM acudientes WHERE ide_acu = ?");
        $consulta_id->bind_param("s", $id);
        $consulta_id->execute();
        $resultado_id = $consulta_id->get_result();


        // Verificar si se encontró el grupo
        if($resultado_id->num_rows != 0){
            echo "El id especificado ya existe.";
        } 

        // Verificar campos obligatorios
        $campos_obligatorios = array('direccion', 'apellido', 'nombre', 'telefono', 'email');
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
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : "";
            $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
            $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
            $email = isset($_POST['email']) ? $_POST['email'] : "";

            // Preparar la consulta SQL para la inserción en la tabla estudiantes
            $stm = $conexion->prepare("UPDATE acudientes SET dir_acu=?, ape_acu=?, nom_acu=?, tel_acu=?, ema_acu=? WHERE ide_acu=?");

            // Enlazar los parámetros
            $stm->bind_param("ssssss", $direccion, $apellido, $nombre, $telefono, $email, $txtid);

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

    <label for="">Direccion</label>
    <input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>" placeholder="Ingresar nombre">

    <label for="">Apellido</label>
    <input type="text" class="form-control" name="apellido" value="<?php echo $apellido; ?>" placeholder="Ingresar apellido">

    <label for="">Nombre</label>
    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" placeholder="Ingresar dirección">

    <label for="">Telefono</label>
    <input type="text" class="form-control" name="telefono" value="<?php echo $telefono; ?>" placeholder="Ingresar ide del grupo">

    <label for="">Email </label>
    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Ingresar ide del acudiente">

    <div class="modal-footer">
        <a href="index.php" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
</form>

<?php include("../../template/footer.php"); ?>