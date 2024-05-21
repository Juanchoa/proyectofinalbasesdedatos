<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "escuela1"; 

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

?>