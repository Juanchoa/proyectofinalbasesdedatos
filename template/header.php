<?php $url_base="http://localhost/proyectofinal/"; ?>


<!doctype html>
<html lang="en">
    <head>
        <title>Escuelita Bellavista</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo $url_base?>" aria-current="page"
                        >Escuelita <span class="visually-hidden">(current)</span></a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/estudiantes/">Estudiantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/acudientes/">Acudientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/grados/">Grados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/grupos/">Grupos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/docentes/">Docentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/materias/">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/boletin/">Boletin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url_base;?>modulos/notas/">Notas</a>
                </li>

            </ul>
        </nav>
        
        <main class="container">
            <br><br>