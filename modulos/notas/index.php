<?php
include("../../conexion.php");

$query = "SELECT * FROM notas";
$result = $conexion->query($query);

// Verificar si hay resultados
if ($result) {
    // Obtener los datos de la consulta
    $notas = array();
    while ($row = $result->fetch_assoc()) {
        $notas[] = $row;
    }
} else {
    // Manejar el caso de error de la consulta
    echo "Error en la consulta: " . $conexion->error;
}


if(isset($_GET['id'])){
    $txtid = isset($_GET['id']) ? $_GET['id'] : "";
    $stm = $conexion->prepare("DELETE FROM notas WHERE ide_not = ?");
    $stm->bind_param("i", $txtid); // "i" indica que $txtid es un entero
    $stm->execute();
    header("location:index.php");
}


$conexion->close();


?>
 
<?php include("../../template/header.php");?>
<?php include("create.php");?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
  Agregar nota
</button>

<div
    class="table-responsive"
>
    <table
        class="table"
    >
        <thead class="table table-dark">
            <tr>
                <th scope="col">Id de la nota</th>
                <th scope="col">Numero de la nota</th>
                <th scope="col">Tema de la nota</th>
                <th scope="col">Calificaion</th>
                <th scope="col">Id de la materia</th>
                <th scope="col">Id del estudiante</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($notas as $nota) { ?>
            <tr class="">
                <td scope="row"><?php echo $nota ['ide_not'];?></td>
                <td><?php echo $nota ['num_not'];?></td>
                <td><?php echo $nota ['tem_not'];?></td>
                <td><?php echo $nota ['cal_not'];?></td>
                <td><?php echo $nota ['ide_mat'];?></td>
                <td><?php echo $nota ['ide_est'];?></td>
                <td> 

                <a href="index.php?id=<?php echo $nota ['ide_not'];?>" class="btn btn-danger"> Eliminar</a>
                <a href="editar.php?id=<?php echo $nota ['ide_not'];?>" class="btn btn-success"> Editar</a>


                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>