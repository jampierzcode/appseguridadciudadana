$(document).ready(function () {
  var funcion = "";
  var us_tipo = $("#se-us_tipo").attr("us_tipo");
  var id_work = $("#work-id").attr("id_work");
  buscar_tipo_work();
  function buscar_tipo_work() {
    funcion = "buscar_tipo_work";
    $.post(
      "../controlador/UsuarioController.php",
      { funcion, id_work },
      (response) => {
        const respuesta = JSON.parse(response);
        respuesta.forEach((resp) => {
          let tipo = resp.work_tipo;
          if (tipo == 1) {
            buscar_tarea_subida();
          }
        });
      }
    );
  }
  function buscar_tarea_subida() {
    funcion = "buscar_tarea_subida";
    $.post(
      "../controlador/UsuarioController.php",
      { funcion, id_work },
      (response) => {
        let template = "";
        const respuesta = JSON.parse(response);
        respuesta.forEach((resp) => {
          if (resp.no_register) {
            const f = new Date();
            const fecha_entrega = new Date(resp.fecha_entrega);
            const resta_fecha = fecha_entrega - f;
            template += `
                  <h1>Mi envio <span> sin entregar</span></h1>
                                  <div class="estado_envio">
                                      <p id="time-retraso"></p>
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
                                                      <div id="chose-file">Subir tarea</div>
                                                  </div>
                                                  <div id="btn-cancel-file" class="cancel-btn"><i class="fas fa-times"></i></div>
                                              </div>
                                              <input id="default-btn" type="file" name="tarea" hidden>
                                              <input type="text" name="funcion" value="alumno-tarea-subida" hidden>
                                          </div>
                                      </div>
                                      <button id="btn-tarea-completed">
                                          Marcar tarea completada
                                      </button>
                                  </div>
                  `;
            $("#mi_envio").html(template);
            regresar_tiempo(resta_fecha);
            if (us_tipo == 2) {
              active_entrega();
            }
          } else {
            let fecha_subida = new Date(resp.fecha_subida);
            let fecha_entrega = new Date(resp.fecha_entrega);
            let resta_time_retraso = fecha_entrega - fecha_subida;

            let work_archivo = resp.archivo_entrega;
            let nombre_archivo = work_archivo.split("/");
            let nombre = nombre_archivo[nombre_archivo.length - 1];
            template += `                 
              <p class="calificacion">${resp.calificacion}/${resp.puntos}</p>
              <h1>Mi envio <span class="entrega-check"> ${resp.estado_entrega}</span></h1>
              <div class="estado_envio">
                  <p id="estado-envio"></p>
                  <span class="doc-work-subido">
                    <ion-icon name="document-text-outline"></ion-icon>
                    <a target="_blank" href="${resp.archivo_entrega}">${nombre}</a>
                  </span>
                  <button class="entrega-null">
                      Anular entrega
                  </button>
              </div>
            `;
            $("#mi_envio").html(template);
            restar_tiempo(resta_time_retraso);
          }
        });
      }
    );
    function restar_tiempo(resta_time_retraso) {
      let fecha = 0;
      let template = "";
      if (resta_time_retraso < 0) {
        template = "Entrega con retraso: ";
        fecha = Math.abs(resta_time_retraso);
      } else {
        fecha = resta_time_retraso;
        template += `Entrega a tiempo: `;
      }
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
        $("#estado-envio").html(template);
      } else {
        if (hours != 0) {
          template += `${hours + " horas y " + minutoss + " minutos"}`;
          $("#estado-envio").html(template);
        } else {
          if (minutoss != 0) {
            template += `${minutoss + " minutos y " + seconds + " segundos"}`;
            $("#estado-envio").html(template);
          }
        }
      }
    }
    function regresar_tiempo(resta_fecha) {
      let fecha = 0;
      let template = "";
      if (resta_fecha < 0) {
        template = "Tiempo retrasado: ";
        fecha = Math.abs(resta_fecha);
      } else {
        fecha = resta_fecha;
        template += `Tiempo restante: `;
      }
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
        $("#time-retraso").html(template);
      } else {
        if (hours != 0) {
          template += `${hours + " horas y " + minutoss + " minutos"}`;
          $("#time-retraso").html(template);
        } else {
          if (minutoss != 0) {
            template += `${minutoss + " minutos y " + seconds + " segundos"}`;
            $("#time-retraso").html(template);
          }
        }
      }
    }
    $("#form-tarea-alumno").submit((e) => {
      e.preventDefault();
      let file = new FormData($("#form-tarea-alumno")[0]);
      $.ajax({
        url: "../controlador/UsuarioController.php",
        type: "POST",
        data: file,
        cache: false,
        processData: false,
        contentType: false,
      }).done(function (response) {
        if (response.trim() == "doc_noadmitido") {
        } else {
          let ruta = response;
          funcion = "subir-tarea-alumno";
          let f = new Date();
          let fecha_subida = "";
          fecha_subida =
            f.getFullYear() +
            "/" +
            (f.getMonth() + 1) +
            "/" +
            f.getDate() +
            " " +
            f.getHours() +
            ":" +
            f.getMinutes() +
            ":" +
            f.getSeconds();
          $.post(
            "../controlador/UsuarioController.php",
            { funcion, id_work, fecha_subida, ruta },
            (response) => {
              if (response.trim() == "add-alumno-tarea") {
                buscar_tarea_subida();
              }
            }
          );
        }
      });
    });
  }
});
