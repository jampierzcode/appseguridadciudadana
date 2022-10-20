$(document).ready(function () {
  var funcion = ""; //funcion para method post

  buscar_alumno();
  buscar_salon();
  $("#modal-close").on("click", (e) => {
    $("#form-alumno").trigger("reset");
  });
  // buscar alumnos
  function buscar_alumno(consulta) {
    funcion = "buscar_alumnos";
    $.post(
      "../controlador/UsuarioController.php",
      { funcion, consulta },
      (response) => {
        let template1 = "";
        if (response.trim() == "no-alumno") {
          template1 += `<h1 class="error-search">No existe el alumno</h1>`;
        } else {
          if (response.trim() == "no-register") {
            template1 += `<h1 class="error-search">No hay alumnos creados</h1>`;
          } else {
            const alumnos = JSON.parse(response);
            alumnos.forEach((alumno) => {
              template1 += `
                  <div class="card-alumnos" key_user="${alumno.id_usuario}">
                    <div class="img-alumno">
                        <img src="../img/${alumno.foto}" alt="">
                    </div>
                    <div class="info-alumno">
                        <h1 class="list-name">
                            ${alumno.nombres} ${alumno.apellidos}
                        </h1>
                        <p class="list-salon">
                            Salon: <span>${alumno.salon} de ${alumno.nivel}</span>
                        </p>
                        <p class="list-salon">
                            Dni: <span>${alumno.dni}</span>
                        </p>
                        <p class="list-salon">
                            Contraseña: <span>${alumno.password}</span>
                        </p>
                    </div>                    
                    <div class="card-btn-user">
                    <button id="edit-btn-card" class="btn-edit"> <ion-icon name="cog-outline"></ion-icon> Editar</button>
                      <button id="delete-btn-card" class="btn-delete"> <ion-icon name="trash-outline"></ion-icon> Eliminar</button>
                      </div>
                      <div class="matricula">
                        <p>Matriculado</p>
                    </div>
                  </div>
                  </div>
                    `;
            });
          }
        }
        $("#list-alumnos").html(template1);
      }
    );
  }
  // keyup de carga de input de busqueda
  $(document).on("keyup", "#search-alumno", function () {
    let valor = $(this).val();
    if (valor != "") {
      buscar_alumno(valor);
    } else {
      buscar_alumno();
    }
  });

  // actualizar dando click en boton
  $(document).on("click", "#delete-btn-card", (e) => {
    let respuesta = confirm("Esta seguro de eliminar al usuario?");
    if (respuesta == true) {
      const elemento = $(this)[0].activeElement.parentElement.parentElement;
      const id_user = $(elemento).attr("key_user");
      console.log(id_user);
      funcion = "eliminar_usuario";
      $.post(
        "../controlador/UsuarioController.php",
        { funcion, id_user },
        (response) => {
          console.log(response);
          buscar_alumno();
        }
      );
    }
  });

  // funcion de buscar salon
  function buscar_salon() {
    funcion = "buscar_salon_alumno";
    $.post("../controlador/UsuarioController.php", { funcion }, (response) => {
      let template = "";
      const salones = JSON.parse(response);
      salones.forEach((salon) => {
        template += `
          <option value="${salon.id_salon}">${salon.nombre_salon} ${salon.nivel}</option>
          `;
      });
      $("#alumno-salon").html(template);
    });
  }

  // funcion de crear alumno

  $("#form-alumno").submit(function (e) {
    funcion = "crear-alumno";
    e.preventDefault();
    const name = $("#alumno-nombres").val();
    const lastname = $("#alumno-apellidos").val();
    const edad = $("#alumno-edad").val();
    const dni = $("#alumno-dni").val();
    const sexo = $("#alumno-sexo").val();
    const password = $("#alumno-password").val();
    const salon = $("#alumno-salon").val();
    const us_tipo = 2; // el tipo 2 corresponde al usuario de alumno
    $.post(
      "../controlador/UsuarioController.php",
      {
        funcion,
        name,
        lastname,
        edad,
        dni,
        sexo,
        password,
        salon,
        us_tipo,
      },
      (response) => {
        console.log(response);
        if (response.trim() == "add-alumno") {
          buscar_alumno();
          $("#form-alumno").trigger("reset");
          $("#toast-exito").addClass("toast-show");
          setInterval(() => {
            $("#toast-exito").removeClass("toast-show");
          }, 3000);
        } else {
          $("#toast-fracaso").addClass("toast-show");
          setInterval(() => {
            $("#toast-fracaso").removeClass("toast-show");
          }, 3000);
        }
      }
    );
  });
});
