<?php
include("../../conexion.php");

$query = "SELECT * FROM acudientes";
$result = $conexion->query($query);

// Verificar si hay resultados
if ($result) {
    // Obtener los datos de la consulta
    $acudientes = array();
    while ($row = $result->fetch_assoc()) {
        $acudientes[] = $row;
    }
} else {
    // Manejar el caso de error de la consulta
    echo "Error en la consulta: " . $conexion->error;
}

if(isset($_GET['id'])){
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("DELETE FROM acudientes WHERE ide_acu = ?");
    $stm->bind_param("i", $txtid); // "i" indica que $txtid es un entero
    try {
        $stm->execute();
        header("location:index.php");
    } catch (mysqli_sql_exception $exception) {
        // Capturar la excepción
        $errorMessage = "No se puede eliminar este acudiente porque está relacionado con uno o más estudiantes.";
        // mostrar el error
        echo($errorMessage);
    }
}

// Cerrar la conexión
$conexion->close();
?>
 
<?php include("../../template/header.php");?>
<?php include("create.php");?>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
  Agregar acudiente
</button>

<div
    class="table-responsive"
>
    <table
        class="table"
    >
        <thead class="table table-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Dirección</th>
                <th scope="col">Apellido</th>
                <th scope="col">Nombre</th>
                <th scope="col">Telefono</th>
                <th scope="col">Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($acudientes as $acudiente) { ?>
            <tr class="">
                <td scope="row"><?php echo $acudiente ['ide_acu'];?></td>
                <td><?php echo $acudiente ['dir_acu'];?></td>
                <td><?php echo $acudiente ['ape_acu'];?></td>
                <td><?php echo $acudiente ['nom_acu'];?></td>
                <td><?php echo $acudiente ['tel_acu'];?></td>
                <td><?php echo $acudiente ['ema_acu'];?></td>
                <td>
                <a href="index.php?id=<?php echo $acudiente ['ide_acu'];?>" class="btn btn-danger"> Eliminar</a>
                <a href="editar.php?id=<?php echo $acudiente ['ide_acu'];?>" class="btn btn-success"> Editar</a>
                <td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>