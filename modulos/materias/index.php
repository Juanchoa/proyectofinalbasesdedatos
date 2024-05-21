<?php
include("../../conexion.php");

$query = "SELECT * FROM materias";
$result = $conexion->query($query);

// Verificar si hay resultados
if ($result) {
    // Obtener los datos de la consulta
    $materias = array();
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }
} else {
    // Manejar el caso de error de la consulta
    echo "Error en la consulta: " . $conexion->error;
}


if(isset($_GET['id'])){
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("DELETE FROM materias WHERE ide_mat = ?");
    $stm->bind_param("i", $txtid); // "i" indica que $txtid es un entero
    try {
        $stm->execute();
        header("location:index.php");
    } catch (mysqli_sql_exception $exception) {
        // Capturar la excepción
        $errorMessage = "No se puede eliminar este acudiente porque está relacionado con uno o más grupos.";
        // mostrar el error
        echo($errorMessage);
    }
}

$conexion->close();


?>
 
<?php include("../../template/header.php");?>
<?php include("create.php");?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
  Agregar materia
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
                <th scope="col">Nombre</th>
                <th scope="col">Id del Docente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($materias as $materia) { ?>
            <tr class="">
                <td scope="row"><?php echo $materia ['ide_mat'];?></td>
                <td><?php echo $materia ['nom_mat'];?></td>
                <td><?php echo $materia ['ide_doc'];?></td>
                <td> 

                <a href="index.php?id=<?php echo $materia ['ide_mat'];?>" class="btn btn-danger"> Eliminar</a>
                <a href="editar.php?id=<?php echo $materia ['ide_mat'];?>" class="btn btn-success"> Editar</a>

                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>