<?php
include("../../conexion.php");

$query = "SELECT * FROM estudiantes";
$result = $conexion->query($query);

// Verificar si hay resultados
if ($result) {
    // Obtener los datos de la consulta
    $estudiantes = array();
    while ($row = $result->fetch_assoc()) {
        $estudiantes[] = $row;
    }
} else {
    // Manejar el caso de error de la consulta
    echo "Error en la consulta: " . $conexion->error;
}


if(isset($_GET['id'])){
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("DELETE FROM estudiantes WHERE ide_est = ?");
    $stm->bind_param("i", $txtid); // "i" indica que $txtid es un entero
    $stm->execute();
    header("location:index.php");
}


$conexion->close();


?>
 
<?php include("../../template/header.php");?>
<?php include("create.php");?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
  Agregar estudiante
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
                <th scope="col">Apellido</th>
                <th scope="col">Dirección</th>
                <th scope="col">Id del grupo</th>
                <th scope="col">Id del acudiente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($estudiantes as $estudiante) { ?>
            <tr class="">
                <td scope="row"><?php echo $estudiante ['ide_est'];?></td>
                <td><?php echo $estudiante ['nom_est'];?></td>
                <td><?php echo $estudiante ['ape_est'];?></td>
                <td><?php echo $estudiante ['dir_est'];?></td>
                <td><?php echo $estudiante ['ide_gru'];?></td>
                <td><?php echo $estudiante ['ide_acu'];?></td>
                <td> 

                <a href="index.php?id=<?php echo $estudiante ['ide_est'];?>" class="btn btn-danger"> Eliminar</a>
                <a href="editar.php?id=<?php echo $estudiante ['ide_est'];?>" class="btn btn-success"> Editar</a>


                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>