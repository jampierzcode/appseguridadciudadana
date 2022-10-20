$(document).ready(function () {
  // cerrar modal dando click al "x"
  $("#modal-close").click(function () {
    $(".modal-create").removeClass("modal-visible");
  });
  //   abrir modal en los botones con el id #modal-show-btn
  $("#modal-show-btn").click(function () {
    $(".modal-create").addClass("modal-visible");
  });
});
