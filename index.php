<?php
session_start();
if (!empty($_SESSION["id_usuario"])) {
    header("Location: vistas/aula_virtual.php");
} else {

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Link de font google -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Style Icons -->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
        <!-- Icon Title Page -->
        <link rel="icon" href="img/logo.png">
        <!-- Link de los estilos principales -->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/login.css">

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https: // unpkg .com / ionicons @ 5.5.2 / dist / ionicons / ionicons.js "></script>
        <title>Login AppCharvisSecurity</title>
    </head>

    <body>

        <div class="container_login">
            <div class="form_login">
                <div class="container_img">
                    <img width="150px" src="img/logo.png" alt="logo_login_appsegurity">
                </div>
                <h1 class="title_school">AppCharvisSecurity</h1>
                <?php

                if (!empty($_SESSION["error"])) {
                    $error = $_SESSION["error"];

                ?>
                    <div id="toast">
                        <p><?php echo $_SESSION["error"] ?></p>
                    </div>
                <?php
                    session_destroy();
                }
                ?>
                <form action="controlador/LoginController.php" method="post">
                    <div class="controls_form">
                        <ion-icon name="person-sharp"></ion-icon>
                        <input name="username" type="text" placeholder="Ingresa DNI" required>
                        <!-- <i class="far fa-user"></i> -->
                    </div>
                    <div class="controls_form">
                        <ion-icon name="lock-closed"></ion-icon>
                        <input name="password" type="password" placeholder="Ingresa tu password" required>
                        <!-- <i class="fas fa-lock"></i> -->
                    </div>
                    <button class="btn_submit" type="submit">Acceder</button>

                    <p>Inicia sesion para continuar</p>
                </form>

            </div>
        </div>
    </body>

    </html>
<?php
}
?>