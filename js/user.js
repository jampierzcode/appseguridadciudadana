$(document).ready(function () {
  var funcion = "";
  buscar_user();
  function buscar_user() {
    funcion = "buscar_usuario";
    $.post("../controlador/UsuarioController.php", { funcion }, (response) => {
      let nombre = "";
      let apellido = "";
      let edad = "";
      let dni = "";
      let tipo = "";
      let foto = "";
      const usuario = JSON.parse(response);
      nombre += `${usuario.nombre}`;
      apellido += `${usuario.apellido}`;
      edad += `${usuario.edad}`;
      dni += `${usuario.dni}`;
      tipo += `${usuario.tipo}`;
      foto += `../img/${usuario.foto}`;
      $("#name_user").html(nombre);
      $("#apellido_user").html(apellido);
      $("#edad_user").html(edad);
      $("#dni_user").html(dni);
      $("#tipo_user").html(tipo);
      $("#foto_user").attr("src", foto);
      $(".drop-down .foto-user-nav > img").attr("src", foto);
    });
  }
  $("#btn-edit-foto").on("click", function () {
    console.log("boton perfil");
    $("#modal-edit-foto").addClass("modal-visible");
  });
  $("#form-edit-foto").submit((e) => {
    let formData = new FormData($("#form-edit-foto")[0]);
    console.log(formData);
    $.ajax({
      url: "../controlador/UsuarioController.php",
      type: "POST",
      data: formData,
      cache: false,
      processData: false,
      contentType: false,
    }).done(function (response) {
      if (response.trim() == "foto_add") {
        buscar_user();
        $("#form-edit-foto").trigger("reset");
        $("#toast-exito").addClass("toast-show");
        $(".wrapper .image").removeClass("view-change");
        $("#btn-cancel-file").removeClass("view-change");
        $("#default-btn").val("");
        setInterval(() => {
          $("#toast-exito").removeClass("toast-show");
        }, 3000);
      } else {
        if (response.trim() == "foto_noadd") {
          $("#toast-fracaso").addClass("toast-show");
          setInterval(() => {
            $("#toast-fracaso").removeClass("toast-show");
          }, 3000);
        } else {
          $("#toast-fracaso-format").addClass("toast-show");
          setInterval(() => {
            $("#toast-fracaso-format").removeClass("toast-show");
          }, 3000);
        }
      }
    });
    e.preventDefault();
  });
});
