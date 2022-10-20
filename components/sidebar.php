<div class="wraper">
    <nav class="nav-plataforms">
        <div id="collapse-nav" class="drop-down">
            <ion-icon name="menu-outline"></ion-icon>
            <div class="foto-user-nav">
                <img src="../img/<?php echo $_SESSION["foto_user"] ?>" alt="">
                <ion-icon id="headeer-bottom" name="chevron-down-outline"></ion-icon>
                <ul class="nav-menu-header-user hidden-nav">
                    <li><a href="../vistas/miperfil.php">
                            <ion-icon name="person-sharp"></ion-icon> Mi perfil
                        </a></li>
                    <li><a href="../controlador/LogoutController.php">
                            <ion-icon name="log-out"></ion-icon> Cerrar sesion
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>
    <aside class="sidebar open-sidebar">
        <div class="header-sidebar">
            <img class="logo-sidebar" src="../img/logo.png" alt="">
            <p>Aula Virtual</p>
        </div>
        <div class="body-sidebar">
            <ul class="nav-links">