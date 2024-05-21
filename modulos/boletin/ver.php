<?php
include("../../conexion.php");

$query = "SELECT * FROM boletin";
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


$conexion->close();


?>
 
<?php include("../../template/header.php");?>
<?php include("create.php");?>


<div
    class="table-responsive"
>
    <table
        class="table"
    >
        <thead class="table table-dark">
            <tr>
                <th scope="col">Id estudiante</th>
                <th scope="col">Nombre estudiante</th>
                <th scope="col">Nombre materia</th>
                <th scope="col">Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($estudiantes as $estudiante) { ?>
            <tr class="">
                <td scope="row"><?php echo $estudiante ['ide_est'];?></td>
                <td><?php echo $estudiante ['nom_est'];?></td>
                <td><?php echo $estudiante ['nom_mat'];?></td>
                <td><?php echo $estudiante ['nota'];?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>