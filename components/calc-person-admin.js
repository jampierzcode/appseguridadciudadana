$(document).ready(function () {
  var funcion = "";
  buscar_cant_alumnos();
  buscar_cant_docentes();
  //   buscar_cant_personal();
  buscar_cant_clases();

  function buscar_cant_alumnos() {
    funcion = "buscar_cant_alumnos";
    $.post("../controlador/UsuarioController.php", { funcion }, (response) => {
      const count = JSON.parse(response);
      $("#number-students").html(count.length);
    });
  }
  function buscar_cant_docentes() {
    funcion = "buscar_cant_docentes";
    $.post("../controlador/UsuarioController.php", { funcion }, (response) => {
      const count = JSON.parse(response);
      $("#number-teachers").html(count.length);
    });
  }
  function buscar_cant_clases() {
    funcion = "buscar_cant_clases";
    $.post("../controlador/UsuarioController.php", { funcion }, (response) => {
      const count = JSON.parse(response);
      $("#number-class").html(count.length);
    });
  }
});
