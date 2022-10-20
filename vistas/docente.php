<?php
session_start();
if (empty($_SESSION["id_usuario"])) {
    session_destroy();
    header("Location: ../index.php");
} else {
    include_once "./Layouts/header.php";

?>

    <link rel="stylesheet" href="../css/crud.css">
    <link rel="stylesheet" href="../css/docente.css">
    <link rel="stylesheet" href="../css/modal-create.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https: // unpkg .com / ionicons @ 5.5.2 / dist / ionicons / ionicons.js "></script>
    <title>Aula Virtual</title>
    </head>

    <body>
        <div id="modal-docente" class="modal-create">
            <div class="container-modal">
                <div class="header-modal">
                    <div id="toast-exito" class="toast-response exito-response-modal">
                        <h1>docente creado correctamente</h1>
                    </div>
                    <div id="toast-fracaso" class="toast-response fracaso-response-modal">
                        <h1>No se pudo crear al estudiante</h1>
                    </div>
                    <h1 class="title-create">Crear docente</h1>
                    <div class="close-modal">
                        <ion-icon id="modal-close" name="close-outline"></ion-icon>
                    </div>
                </div>
                <div class="body-modal">
                    <form id="form-docente" class="create-docente">
                        <span class="label-controls">Nombres:</span>
                        <input id="docente-nombres" type="text" class="input-controls" placeholder="Ingresa los nombres">
                        <span class="label-controls">Apellidos:</span>
                        <input id="docente-apellidos" type="text" class="input-controls" placeholder="Ingresa los apellidos">
                        <span class="label-controls">Fecha de nacimiento:</span>
                        <input id="docente-edad" type="date" class="input-controls">
                        <span class="label-controls">Dni:</span>
                        <input id="docente-dni" type="text" class="input-controls" placeholder="Ingresa su dni">
                        <span class="label-controls">Sexo:</span>
                        <select id="docente-sexo" class="input-controls">
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                        <span class="label-controls">Contraseña:</span>
                        <input id="docente-password" type="text" class="input-controls" placeholder="Ingresa la contraseña">
                        <button class="btn-submit" type="submit">Crear docente</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include_once "../components/sidebar.php" ?>
        <li class="links-sidebar"><a href="./aula_virtual.php"><i class="fas fa-tachometer-alt"></i>
                <p>Escritorio</p>
            </a></li>
        <span class="title-section">Registro de usuarios</span>
        <li class="links-sidebar"><a href="./alumno.php"><i class="fas fa-user-graduate"></i>
                <p>Alumnos</p>
            </a></li>
        <li class="links-sidebar"><a class="link-active" href="./docente.php"><i class="fas fa-user"></i>
                <p>Docentes</p>
            </a></li>
        <span class="title-section">Registro de Clases</span>
        <li class="links-sidebar"><a href="./crear_salon.php"><i class="fas fa-users"></i>
                <p>Crear Salon</p>
            </a></li>
        <li class="links-sidebar"><a href="./clases.php"><i class="fas fa-chalkboard-teacher"></i>
                <p>Crear clases</p>
            </a></li>
        <li class="links-sidebar"><a href="./cursos.php"><i class="fas fa-book"></i>
                <p>Crear curso</p>
            </a></li>
        <li class="links-sidebar logout-session"><a href="../controlador/LogoutController.php"><i class="fas fa-chevron-left"></i>
                <p>Cerrar Sesion</p>
            </a></li>
        </ul>
        </div>
        </aside>
        <div class="content-dashboard">
            <div class="route-page">
                <p>Home / Docentes</p>
            </div>
            <div class="create-new-object">
                <button id="modal-show-btn" class="btn-add-object">Crear docente</button>
            </div>
            <div class="search-new-object">
                <h1>Buscar Docentes</h1>
                <div>
                    <input type="text" id="search-docente" class="search-object" placeholder="Ingrese el nombre o apellido del docente">

                </div>
            </div>
            <div id="list-docentes" class="list-docentes">
            </div>

        </div>
        <div class="overlay-sidebar"></div>
        </div>
    </body>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/sidebar.js"></script>
    <script src="../components/modal.js"></script>
    <script src="../js/gestion-docente.js"></script>


    </html>
<?php
}
?>