<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion.php");

// Verificar si se ha recibido el parámetro ide_grado_seleccionado
if(isset($_GET['id'])) {
    // Obtener el valor del parámetro ide_grado_seleccionado
    $num_grado_seleccionado = $_GET['id'];
    // Consulta SQL para obtener las materias del grupo
    $sql_materias = "SELECT * FROM materiasgrados WHERE num_gra = '$num_grado_seleccionado'";

    $result_materias = $conexion->query($sql_materias);
    $materias = array();
    // Verificar si se encontraron materias para este grupo
    if($result_materias->num_rows > 0) {
        // Si hay materias, guardarlas en el array $materias
        while ($row = $result_materias->fetch_assoc()){
            $materias[] = $row;
        }
    } else {
        // Si no se encontraron materias, imprimir el mensaje correspondiente
        echo "No se encontraron materias para este grupo.";
    }
}

// Cerrar la conexión a la base de datos MySQL
$conexion->close();
?>

<?php include("../../template/header.php");?>

    <?php include("crearmateriagrado.php");?>
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
                    <th scope="col">Grado</th>
                    <th scope="col">Materia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($materias as $materia) { ?>
                <tr class="">
                    <td scope="row"><?php echo $materia ['num_gra'];?></td>
                    <td scope="row"><?php echo $materia ['ide_mat'];?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

<?php include("../../template/footer.php");?>