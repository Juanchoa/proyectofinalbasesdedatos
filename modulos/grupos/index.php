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

// Cerrar la conexión
$conexion->close();
?>
 
<?php include("../../template/header.php");?>

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
                <td> Editar|Eliminar </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>