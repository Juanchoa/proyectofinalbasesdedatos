<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion.php");

// Verificar si se ha recibido el parámetro ide_grado_seleccionado
if(isset($_GET['id'])) {
    // Obtener el valor del parámetro ide_grado_seleccionado
    $idestudiante = $_GET['id'];
    
    // Realizar la consulta SQL
    $sql = "SELECT notas.ide_est, CONCAT(estudiantes.nom_est, ' ', estudiantes.ape_est) AS nombre_estudiante, materias.nom_mat, ROUND(AVG(notas.cal_not),2) AS nota
            FROM notas 
            INNER JOIN estudiantes ON notas.ide_est = estudiantes.ide_est
            INNER JOIN materias ON notas.ide_mat = materias.ide_mat
            WHERE estudiantes.ide_est = '$idestudiante'
            GROUP BY notas.ide_est, CONCAT(estudiantes.nom_est, ' ', estudiantes.ape_est), materias.nom_mat";

    $resultado = $conexion->query($sql);

    // Verificar si hay resultados
    if ($resultado->num_rows > 0) {
        // Iterar sobre los resultados y guardarlos en variables
        while ($fila = $resultado->fetch_assoc()) {
            $ide_estudiante = $fila['ide_est'];
            $nombre_estudiante = $fila['nombre_estudiante'];
            $nombre_materia = $fila['nom_mat'];
            $nota = $fila['nota'];

            // Verificar si el registro ya existe en la tabla boletin
            $sql_existencia = "SELECT COUNT(*) AS existencia FROM boletin WHERE ide_est = '$ide_estudiante' AND nom_mat = '$nombre_materia'";
            $resultado_existencia = $conexion->query($sql_existencia);
            $fila_existencia = $resultado_existencia->fetch_assoc();
            $existencia = $fila_existencia['existencia'];

            if ($existencia == 0) {
                // Insertar los valores en otra tabla
                $sql_insert = "INSERT INTO boletin (ide_est, nom_est, nom_mat, nota) 
                            VALUES ('$ide_estudiante', '$nombre_estudiante', '$nombre_materia', '$nota')";
                // Ejecutar la inserción
                if ($conexion->query($sql_insert) === TRUE) {
                    echo "Los datos se insertaron correctamente en otra_tabla.";
                } else {
                    echo "Error al insertar datos: " . $conexion->error;
                }
            } else {
                echo "El registro para el estudiante '$nombre_estudiante' y la materia '$nombre_materia' ya existe en la tabla boletin. No se realizó la inserción.";
            }
        }
    } else {
        echo "El estudiante no tiene notas ingresadas.";
    }
}

// Cerrar la conexión a la base de datos MySQL
$conexion->close();
?>
