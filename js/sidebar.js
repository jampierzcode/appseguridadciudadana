$(document).ready(function () {
  $("#collapse-nav>ion-icon").click(() => {
    if ($(".sidebar").hasClass("open-sidebar")) {
      $(".sidebar").removeClass("open-sidebar");
      $(".sidebar").addClass("close-sidebar");
      $(".nav-plataforms").addClass("collapse-close-sidebar");
      $(".content-dashboard").addClass("collapse-close-sidebar");
      // Para mobil estilos
      $(".overlay-sidebar").addClass("overlay-sidebar-show");
    } else {
      $(".sidebar").removeClass("close-sidebar");
      $(".sidebar").addClass("open-sidebar");
      $(".nav-plataforms").removeClass("collapse-close-sidebar");
      $(".content-dashboard").removeClass("collapse-close-sidebar");

      // mobile estilos
      $(".overlay-sidebar").removeClass("overlay-sidebar-show");
    }
  });
  $(".overlay-sidebar").click(() => {
    $(".sidebar").removeClass("close-sidebar");
    $(".sidebar").addClass("open-sidebar");
    $(".overlay-sidebar").removeClass("overlay-sidebar-show");
    $(".nav-plataforms").removeClass("collapse-close-sidebar");
    $(".content-dashboard").removeClass("collapse-close-sidebar");
  });
  $("#headeer-bottom").on("click", function () {
    if ($(".nav-menu-header-user").hasClass("hidden-nav")) {
      $(".nav-menu-header-user").removeClass("hidden-nav");
    } else {
      $(".nav-menu-header-user").addClass("hidden-nav");
    }
  });
});
