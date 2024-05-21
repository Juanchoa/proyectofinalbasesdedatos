<?php include("template/header.php");?>

<?php
include("conexion.php");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if($_POST){
  // Verificar campos obligatorios
  $campos_obligatorios = array('email','nombre', 'apellido', 'telefono');
  $campos_vacios = array();
  foreach($campos_obligatorios as $campo) {
    if(empty($_POST[$campo])) {
      $campos_vacios[] = $campo;
    }
  }
  if(!empty($campos_vacios)) {
    echo "Los siguientes campos son obligatorios y no pueden estar vacíos: " . implode(', ', $campos_vacios);
  }

  else {
    // Obtener los valores de los otros campos del formulario
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";

    // Preparar la consulta SQL para la inserción en la tabla estudiantes
    $stm = $conexion->prepare("INSERT INTO interesados(ema_int, nom_int, ape_int, tel_int) VALUES(?, ?, ?, ?)");

    // Enlazar los parámetros
    $stm->bind_param("ssss", $email, $nombre, $apellido, $telefono);

    // Ejecutar la consulta
    $result = $stm->execute();

    // Verificar si la ejecución de la consulta fue exitosa
    if ($result === false) {
        die("Error al ejecutar la consulta: " . $stm->error);
    }

    // Redirigir después de la inserción
    header("location:index.php");
    exit(); // Importante para evitar que se siga ejecutando el código después de la redirección
  }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Sobre nosotros</h2>
            <p>Bienvenido a Escuelita Bellavista, donde la excelencia educativa se fusiona con la pasión por el aprendizaje. Desde nuestra fundación, nos hemos comprometido a proporcionar una experiencia educativa integral que nutra el intelecto, fomente la creatividad y promueva los valores fundamentales del respeto, la responsabilidad y la colaboración.

                En Bellavista, cada alumno es considerado único y valioso. Nuestra comunidad escolar está dedicada a cultivar un ambiente inclusivo donde cada estudiante pueda prosperar y alcanzar su máximo potencial. Nuestro equipo de educadores altamente calificados está comprometido a brindar una enseñanza inspiradora y personalizada que estimule el crecimiento académico, emocional y social de cada niño.

                Nuestra visión va más allá de la mera transmisión de conocimientos; aspiramos a formar líderes del mañana, dotados de las habilidades, la confianza y la ética necesarias para enfrentar los desafíos del mundo moderno. Con un enfoque en el pensamiento crítico, la resolución de problemas y la colaboración, preparamos a nuestros estudiantes para convertirse en ciudadanos globales informados y comprometidos.

                En Bellavista, creemos en el poder transformador de la educación y nos esforzamos por crear un entorno en el que cada estudiante se sienta valorado, motivado y apoyado en su viaje hacia el éxito. Nos enorgullece ser una comunidad vibrante y diversa que celebra la singularidad de cada individuo y fomenta el respeto mutuo.

                Explora nuestro sitio web para conocer más sobre nuestra historia, nuestro currículo innovador, nuestras instalaciones de vanguardia y las numerosas oportunidades extracurriculares que ofrecemos. Te invitamos a unirte a nuestra familia en [Nombre del Colegio], donde cada día es una oportunidad para aprender, crecer y alcanzar nuevas alturas.

                ¡Esperamos darle la bienvenida a nuestra comunidad escolar!</p>
        </div>
        <div class="col-md-6">
            <h2>Nuestros servicios</h2>
            <p>Escuelita bella vista es una ins.tución educa.va ubicada en el barrio Chipre de la ciudad 
                  de Manizales en donde se forman personas con valores, contamos con un amplio sistema 
                  de docentes y estudiantes los cuales están divididos en una formación académica desde el 
                  grado transición hasta grado quinto; Las materias que oriente nuestra ins.tución pueden 
                  ser exclusivas de un solo grado académico o ser dictados en diferentes grados con 
                  diferentes logros de aprendizaje dependiendo del mismo. Nuestro sistema de calificación 
                  está basado en una escala de 1 a 5 en donde una nota menor a 3 es insuficiente, una igual 
                  o inferior a 3,9 es básica y superior o igual a 4 es sobresaliente, estas notas se asignarán
                  por el cumplimiento de logros durante los 2 semestres académicos los cuales .enen una 
                  duración de 4 meses aprox que al culminarlos se hará la entrega en un reporte(boleNn) a 
                  cada acudiente.</p>
        </div>
        <div class="col-md-6">
            <h2>Contáctenos</h2>
            <p>Por favor, complete el siguiente formulario para ponerse en contacto con nosotros:</p>
        <form action="" method="post">
          <div class="modal-body">
            <label for="">Email</label>
            <input type="text" class="form-control" name="email" value="" placeholder="Ingresar Email">

            <label for="">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="" placeholder="Ingresar nombre">

            <label for="">Apellido</label>
            <input type="text" class="form-control" name="apellido" value="" placeholder="Ingresar apellido">

            <label for="">Telefono</label>
            <input type="text" class="form-control" name="telefono" value="" placeholder="Ingresar telefono">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
          <br>
          <br>
      </form>
        </div>
    </div>
</div>




















<?php include("template/footer.php");?>
