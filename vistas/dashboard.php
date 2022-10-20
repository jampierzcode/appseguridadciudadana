<?php
session_start();
if (empty($_SESSION["id_usuario"])) {
    session_destroy();
    header("Location: ../index.php");
} else {
    include_once "./Layouts/header.php";

?>

    <link rel="stylesheet" href="../css/aula.css">
    <link rel="stylesheet" href="../css/alumno-escritorio.css">
    <link rel="stylesheet" href="../css/modal-create.css">
    <link rel="stylesheet" href="../css/dang-drop.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https: // unpkg .com / ionicons @ 5.5.2 / dist / ionicons / ionicons.js "></script>
    <title>Aula Virtual</title>
    </head>

    <body>
        <div id="modal-edit-foto" class="modal-create">
            <div class="container-modal">
                <div class="header-modal">
                    <div id="toast-exito" class="toast-response exito-response-modal">
                        <h1>Foto actualizada correctamente</h1>
                    </div>
                    <div id="toast-fracaso" class="toast-response fracaso-response-modal">
                        <h1>No se pudo subir el archivo</h1>
                    </div>
                    <div id="toast-fracaso-format" class="toast-response fracaso-response-modal">
                        <h1>extension no aceptada, pruebe con (jpg,png,jpeg)</h1>
                    </div>
                    <h1 class="title-create">Actualizar foto</h1>
                    <div class="close-modal">
                        <ion-icon id="modal-close" name="close-outline"></ion-icon>
                    </div>
                </div>
                <div class="body-modal">
                    <form id="form-edit-foto" class="create-alumno">
                        <div class="change-file">
                            <div id="dang_drop" class="container">
                                <div class="wrapper">
                                    <div class="image">
                                        <img id="img-file-foto" src="" alt="">
                                        <div class="file-name">File name here</div>
                                    </div>
                                    <div class="content">
                                        <div class="icon">
                                            <ion-icon name="cloud-upload"></ion-icon>
                                        </div>
                                        <div class="text">No se ha subido ningun archivo!</div>
                                        <div id="chose-file">Subir foto</div>
                                    </div>
                                    <div id="btn-cancel-file" class="cancel-btn"><i class="fas fa-times"></i></div>

                                </div>
                                <input id="default-btn" type="file" name="photo" hidden>
                                <input type="text" name="funcion" value="actualizar_foto" hidden>
                            </div>
                            <button class="btn-submit" type="submit">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once "../components/sidebar.php" ?>


        <?php
        if ($_SESSION["us_tipo"] == 1) {
        ?>

            <li class="links-sidebar"><a class="link-active" href="./aula_virtual.php"><i class="fas fa-tachometer-alt"></i>
                    <p>Escritorio</p>
                </a></li>
            <span class="title-section">Registro de usuarios</span>
            <li class="links-sidebar"><a href="./alumno.php"><i class="fas fa-user-graduate"></i>
                    <p>Alumnos</p>
                </a></li>
            <li class="links-sidebar"><a href="./docente.php"><i class="fas fa-user"></i>
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
        <?php
        } ?>
        <?php if ($_SESSION["us_tipo"] == 2) {
        ?>


            <li class="links-sidebar"><a class="link-active" href="./aula_virtual.php"><i class="fas fa-tachometer-alt"></i>
                    <p>Escritorio</p>
                </a></li>
            <span class="title-section">Area personal</span>
            <li class="links-sidebar"><a href="./miperfil.php"><i class="far fa-user"></i></i>
                    <p>Mi perfil</p>
                </a></li>
            <span class="title-section">Mis clases</span>
            <li class="links-sidebar"><a href="../course/misclases.php"><i class="fas fa-chalkboard-teacher"></i>
                    <p>Cursos</p>
                </a></li>
            <li class="links-sidebar"><a href="../course/calificaciones.php"><i class="far fa-clipboard"></i></i>
                    <p>Mis Calificaciones</p>
                </a></li>
            <span class="title-section">Sesion</span>
            <li class="links-sidebar logout-session"><a href="../controlador/LogoutController.php"><i class="fas fa-chevron-left"></i>
                    <p>Cerrar Sesion</p>
                </a></li>
        <?php
        } ?>
        <?php if ($_SESSION["us_tipo"] == 3) {
        ?>
            <li class="links-sidebar"><a class="link-active" href="./aula_virtual.php"><i class="fas fa-tachometer-alt"></i>
                    <p>Escritorio</p>
                </a></li>
            <span class="title-section">Area personal</span>
            <li class="links-sidebar"><a href="./miperfil.php"><i class="far fa-user"></i></i>
                    <p>Mi perfil</p>
                </a></li>
            <span class="title-section">Mis clases</span>
            <li class="links-sidebar"><a href="../clases/"><i class=" fas fa-chalkboard-teacher"></i>
                    <p>Clases que enseño</p>
                </a></li>
            <span class="title-section">Sesion</span>
            <li class="links-sidebar logout-session"><a href="../controlador/LogoutController.php"><i class="fas fa-chevron-left"></i>
                    <p>Cerrar Sesion</p>
                </a></li>
        <?php
        } ?>
        </ul>
        </div>
        </aside>
        <div class="content-dashboard">
            <div class="route-page">
                <p>Home / Escritorio</p>
            </div>
            <!-- <div class="list-products" id="productsdata">

            </div> -->
            <div class="dates-user">
                <dvi id="card-user" class="user-card">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="img-card">
                                <img id="foto_user" class="profile-img" src="../img/<?php echo $_SESSION["foto_user"] ?>" alt="">
                                <button id="btn-edit-foto" class="btn-edit-foto">
                                    <ion-icon name="cog-outline"></ion-icon>
                                </button>
                            </div>
                            <p id="name_user" class="name-user"></p>
                            <p id="apellido_user" class="name-user"></p>
                            <ul class="info-user">
                                <li>DNI: <span id="dni_user" class="float-right"></span></li>
                                <li>Edad: <span id="edad_user" class="float-right"></span></li>
                                <li>Tipo de usuario: <span id="tipo_user" class="float-right"></span></li>
                            </ul>
                        </div>
                    </div>
                </dvi>
                <?php
                if ($_SESSION["us_tipo"] == 1) {
                ?>
                    <div class="info-details">
                        <div class="details">
                            <div class="card-info">
                                <div class="detail-dates">
                                    <span id="number-students" class="number-details"></span>
                                    <p>Numero de estudiantes</p>
                                </div>
                                <div class="icon-ionics">
                                    <ion-icon name="school-outline"></ion-icon>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="detail-dates">
                                    <span id="number-teachers" class="number-details">32</span>
                                    <p>Numero de docentes</p>
                                </div>
                                <div class="icon-ionics">
                                    <ion-icon name="book-outline"></ion-icon>
                                </div>
                            </div>
                        </div>
                        <div class="details">
                            <div class="card-info">
                                <div class="detail-dates">
                                    <span class="number-details">0</span>
                                    <p>Numero de personal</p>
                                </div>
                                <div class="icon-ionics">
                                    <ion-icon name="people-outline"></ion-icon>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="detail-dates">
                                    <span id="number-class" class="number-details"></span>
                                    <p>Numero de clases</p>
                                </div>
                                <div class="icon-ionics">
                                    <ion-icon name="desktop-outline"></ion-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                if ($_SESSION["us_tipo"] == 3) {
                ?>
                    <div class="info-details">
                        <div class="details">
                            <div class="card-info">
                                <div class="detail-dates">
                                    <span id="number-cursos" class="number-details">2</span>
                                    <p>Cursos que enseño</p>
                                </div>
                                <div class="icon-ionics">
                                    <ion-icon name="school-outline"></ion-icon>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="detail-dates">
                                    <span id="number-class-all" class="number-details">10</span>
                                    <p>Clases asignadas</p>
                                </div>
                                <div class="icon-ionics">
                                    <ion-icon name="book-outline"></ion-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                if ($_SESSION["us_tipo"] == 2) {
                ?>
                    <div class="container-clases">
                        <div class="header-course">
                            <h1>Mis cursos</h1>
                        </div>
                        <div class="body-course" id="list-courses">
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
        <div class="overlay-sidebar"></div>
        </div>
    </body>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/user.js"></script>
    <script src="../js/sidebar.js"></script>
    <script src="../components/modal.js"></script>
    <script src="../components/dang-drop.js"></script>
    <script src="../components/calc-person-admin.js"></script>
    <?php
    if ($_SESSION["us_tipo"] == 2) {
    ?>
        <script src="../js/courses-alumno.js"></script>
    <?php } ?>

    </html>
<?php
}
?>