<?php
include("../../conexion.php");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if($_POST){

  // 2. Obtener los valores del formulario
  $id = isset($_POST['id']) ? $_POST['id'] : "";
  $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : "";
  $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
  $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
  $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
  $email = isset($_POST['email']) ? $_POST['email'] : "";

  // 3. Preparar la consulta SQL
  $stm = $conexion->prepare("INSERT INTO acudientes(ide_acu, dir_acu, ape_acu, nom_acu, tel_acu, ema_acu) VALUES(?, ?, ?, ?, ?, ?)");

  // Verificar si la preparación de la consulta fue exitosa
  if ($stm === false) {
    die("Error al preparar la consulta: " . $conexion->error);
  }

  // 4. Enlazar los parámetros
  $stm->bind_param("ssssss", $id, $direccion, $apellido, $nombre, $telefono, $email);

  // 5. Ejecutar la consulta
  $result = $stm->execute();

  // Verificar si la ejecución de la consulta fue exitosa
  if ($result === false) {
    die("Error al ejecutar la consulta: " . $stm->error);
  }

  // Redirigir después de la inserción
  header("location:index.php");
  exit(); // Importante para evitar que se siga ejecutando el código después de la redirección
}
?>






<!-- Modal create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AGREGAR ACUDIENTE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
            <div class="modal-body">
                <label for="">Id</label>
                <input type="text" class="form-control" name="id" value="" placeholder="Ingresar id">

                <label for="">Direccion</label>
                <input type="text" class="form-control" name="direccion" value="" placeholder="Ingresar direccion">

                <label for="">Apellido</label>
                <input type="text" class="form-control" name="apellido" value="" placeholder="Ingresar apellido">

                <label for="">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="" placeholder="Ingresar nombre">

                <label for="">Telefono</label>
                <input type="text" class="form-control" name="telefono" value="" placeholder="Ingresar telefono">

                <label for="">Email </label>
                <input type="text" class="form-control" name="email" value="" placeholder="Ingresar email">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
      </form>
    </div>
  </div>
</div>