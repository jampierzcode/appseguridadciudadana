$(document).ready(function () {
  var funcion = "";
  var id_work = $("#work-id").attr("id_work");
  buscar_estados_docentes_envios();
  function buscar_estados_docentes_envios() {
    funcion = "buscar_estados_docentes_envios";
    $.post(
      "../controlador/UsuarioController.php",
      { funcion, id_work },
      (response) => {
        const respuesta = JSON.parse(response);
        respuesta.forEach((resp) => {
          let rest_envios = resp.personas - resp.enviados;
          $("#persons").html(resp.personas);
          $("#envios").html(resp.enviados);
          $("#rest-envio").html(rest_envios);
          let f = new Date();
          let fecha_entrega = new Date(resp.fecha);
          let resta_time_retraso = fecha_entrega - f;
          restar_tiempo(resta_time_retraso);
        });
      }
    );
  }
  function restar_tiempo(resta_time_retraso) {
    let fecha = 0;
    let template = "";
    if (resta_time_retraso < 0) {
      template = "Tarea finalizada";
      $("#time-docente-envio").html(template);
    } else {
      fecha = resta_time_retraso;
      template += `Faltan: `;

      let days = Math.floor(fecha / (1000 * 60 * 60 * 24)),
        hours = (
          "0" + Math.floor((fecha % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
        ).slice(-2),
        minutoss = (
          "0" + Math.floor((fecha % (1000 * 60 * 60)) / (1000 * 60))
        ).slice(-2),
        seconds = ("0" + Math.floor((fecha % (1000 * 60)) / 1000)).slice(-2);

      if (days != 0) {
        template += `${days + " dias y " + hours + " horas"}`;
        $("#time-docente-envio").html(template);
      } else {
        if (hours != 0) {
          template += `${hours + " horas y " + minutoss + " minutos"}`;
          $("#time-docente-envio").html(template);
        } else {
          if (minutoss != 0) {
            template += `${minutoss + " minutos y " + seconds + " segundos"}`;
            $("#time-docente-envio").html(template);
          }
        }
      }
    }
  }
});
