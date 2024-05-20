<?php
include("../../conexion.php");

$query = "SELECT * FROM grupos";
$result = $conexion->query($query);

// Verificar si hay resultados
if ($result) {
    // Obtener los datos de la consulta
    $grupos = array();
    while ($row = $result->fetch_assoc()) {
        $grupos[] = $row;
    }
} else {
    // Manejar el caso de error de la consulta
    echo "Error en la consulta: " . $conexion->error;
}

if(isset($_GET['id'])){
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("DELETE FROM grupos WHERE ide_gru = ?");
    $stm->bind_param("s", $txtid); // "i" indica que $txtid es un entero
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
  Agregar grupo
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
                <th scope="col">Capacidad de estudiantes</th>
                <th scope="col">Grado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($grupos as $grupo) { ?>
            <tr class="">
                <td scope="row"><?php echo $grupo ['ide_gru'];?></td>
                <td><?php echo $grupo ['cap_est_gru'];?></td>
                <td><?php echo $grupo ['num_gra'];?></td>
                <td> 
                <a href="index.php?id=<?php echo $grupo ['ide_gru'];?>" class="btn btn-danger"> Eliminar</a>
                <a href="editar.php?id=<?php echo $grupo ['ide_gru'];?>" class="btn btn-success"> Editar</a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>