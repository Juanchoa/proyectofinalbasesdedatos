<?php
include("../../conexion.php");

$query = "SELECT * FROM grados";
$result = $conexion->query($query);

// Verificar si hay resultados
if ($result) {
    // Obtener los datos de la consulta
    $grados = array();
    while ($row = $result->fetch_assoc()) {
        $grados[] = $row;
    }
} else {
    // Manejar el caso de error de la consulta
    echo "Error en la consulta: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
 
<?php include("../../template/header.php");?>
<?php include("create.php");?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
  Agregar grado
</button>

<div
    class="table-responsive"
>
    <table
        class="table"
    >
        <thead class="table table-dark">
            <tr>
                <th scope="col">Grado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($grados as $grado) { ?>
            <tr class="">
                <td scope="row"><?php echo $grado ['num_gra'];?></td>
                <td> Editar|Eliminar </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>


<?php include("../../template/footer.php");?>