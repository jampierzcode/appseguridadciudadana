$(document).ready(function () {
  var id_work = $("#work-id").attr("id_work");
  var funcion = "";
  buscar_tareas_calificar();
  function buscar_tareas_calificar() {
    funcion = "buscar_tareas_calificar";
    $.post(
      "../controlador/UsuarioController.php",
      { funcion, id_work },
      (response) => {
        const tareas = JSON.parse(response);
        let template = "";
        tareas.forEach((tarea) => {
          template += `
          <tr id="${tarea.id_tarea_subida}">
            <td class="img-table"><img class="img-user" src="../img/${tarea.foto}" alt="foto_alumno"></td>
            <td>${tarea.nombres} ${tarea.apellidos}</td>
            <td>${tarea.estado_entrega}</td>
            <td>${tarea.fecha_subida}</td>
            <td class="link-tarea"><a href="${tarea.archivo_entrega}">ver archivo</a></td>
            `;

          if (tarea.calificacion == 0) {
            template += `<td class="calificacion">
                <input type="number" value="${tarea.calificacion}">
                <button id="calificar">calificar</button>
            </td>
          </tr>`;
          } else {
            template += `
            <td class="calificacion">
              <input type="number" value="${tarea.calificacion}" disabled>
              <button id="editar">Editar</button>
            </td>
          </tr>
            `;
          }
        });
        $("#list_tareas_alumnos").html(template);
        $("#list-calificar").DataTable();
      }
    );
  }
});
