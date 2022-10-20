<?php
include_once '../modelo/Usuario.php';
$usuario = new Usuario();
session_start();
$id_usuario = $_SESSION["id_usuario"];


// BUSCAMOS AL USUARIO LOGUEADO
if ($_POST["funcion"] == 'buscar_usuario') {
    $json = array();
    $fecha_actual = new DateTime();
    $usuario->obtener_datos($id_usuario);
    foreach ($usuario->datos as $objeto) {
        $nacimiento = new DateTime($objeto->edad);
        $edaduser = $nacimiento->diff($fecha_actual);
        $edad_years = $edaduser->y;
        if ($objeto->us_tipo == 1) {
            $tipo = "Administrador";
        }
        if ($objeto->us_tipo == 2) {
            $tipo = "Estudiante";
        }
        if ($objeto->us_tipo == 3) {
            $tipo = "Docente";
        }
        $json[] = array(
            'nombre' => $objeto->nombres,
            'apellido' => $objeto->apellidos,
            'edad' => $edad_years,
            'dni' => $objeto->dni,
            'tipo' => $tipo,
            'foto' => $objeto->foto
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
if ($_POST["funcion"] == "actualizar_foto") {
    if (($_FILES['photo']['type'] == 'image/jpeg') || ($_FILES['photo']['type'] == 'image/png') || ($_FILES['photo']['type'] == 'image/jpg')) {
        $nombre = uniqid() . '-' . $_FILES['photo']['name'];
        $ruta = '../img/' . $nombre;
        move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
        $usuario->actualizar_foto_user($id_usuario, $nombre);
    } else {
        echo "format_foto" . $_FILES['photo']['name'];
    }
}

// ----------------FUNCIONES DEL DASHBOARD DEL ADMINISTRADOR --------------------------//

if ($_POST["funcion"] == "buscar_cant_alumnos") {
    $json = array();
    $usuario->buscar_cant_alumnos();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_usuario' => $objeto->id_usuario
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST["funcion"] == "buscar_cant_docentes") {
    $json = array();
    $usuario->buscar_cant_docentes();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_usuario' => $objeto->id_usuario
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST["funcion"] == "buscar_cant_clases") {
    $json = array();
    $usuario->buscar_cant_clases();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_class' => $objeto->id_class
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// ----------------FIN DE FUNCIONES DEL DASHBOARD DEL ADMINISTRADOR --------------------------//



// SECTION DE ALUMNOS

// Creamos al alumno por el formulario #form-alumno
if ($_POST["funcion"] == "crear-alumno") {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $edad = $_POST["edad"];
    $dni = $_POST["dni"];
    $sexo = $_POST["sexo"];
    if ($sexo == "Hombre") {
        $foto = "avatar_alumno.png";
    } else {
        $foto = "avatar_alumna.png";
    }
    $password = $_POST["password"];
    $salon = $_POST["salon"];
    $us_tipo = $_POST["us_tipo"];

    $usuario->crear_alumno($name, $lastname, $edad, $dni, $sexo, $foto, $password, $salon, $us_tipo);
}



// Buscar alumnos 
if ($_POST["funcion"] == "buscar_alumnos") {
    $usuario->buscar_alumnos();
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-alumno") {
            echo "no-alumno";
        } else {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_usuario' => $objeto->id_usuario,
                'nombres' => $objeto->nombres,
                'apellidos' => $objeto->apellidos,
                'dni' => $objeto->dni,
                'password' => $objeto->password,
                'foto' => $objeto->foto,
                'salon' => $objeto->nombre_salon,
                'nivel' => $objeto->nombre_nivel

            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}


// Buscar salones para crear los alumnos

if ($_POST["funcion"] == "buscar_salon_alumno") {
    $usuario->buscar_salon_alumno();
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_salon' => $objeto->id_salon,
            'nombre_salon' => $objeto->nombre_salon,
            'nivel' => $objeto->nombre_nivel
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// ---------------Eliminar usuarios-------------------------//

if ($_POST["funcion"] == "eliminar_usuario") {
    $id_user = $_POST["id_user"];
    $usuario->eliminar_usuario($id_user);
}


// SECTION DE DOCENTES
// Creamos al docente por el formulario #form-docente
if ($_POST["funcion"] == "crear-docente") {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $edad = $_POST["edad"];
    $dni = $_POST["dni"];
    $sexo = $_POST["sexo"];
    if ($sexo == "Hombre") {
        $foto = "avatar_docente.png";
    } else {
        $foto = "avatar_profesora.png";
    }
    $password = $_POST["password"];
    $us_tipo = $_POST["us_tipo"];

    $usuario->crear_docente($name, $lastname, $edad, $dni, $sexo, $foto, $password, $us_tipo);
}
// Buscar docentes 
if ($_POST["funcion"] == "buscar_docentes") {
    $usuario->buscar_docentes();
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-docente") {
            echo "no-docente";
        } else {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_usuario' => $objeto->id_usuario,
                'nombres' => $objeto->nombres,
                'dni' => $objeto->dni,
                'password' => $objeto->password,
                'apellidos' => $objeto->apellidos,
                'foto' => $objeto->foto,

            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// SECTION DE SALONES


// Creamos salon o por el formulario #form-salon
if ($_POST["funcion"] == "crear-salon") {
    $name = $_POST["name"];
    $id_nivel = $_POST["id_nivel"];
    $usuario->crear_salon($name, $id_nivel);
}
// Buscar salones 
if ($_POST["funcion"] == "buscar_salon") {
    $usuario->buscar_salon();
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-salon") {
            echo "no-salon";
        } else {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_salon' => $objeto->id_salon,
                'nombre_salon' => $objeto->nombre_salon,
                'nombre_nivel' => $objeto->nombre_nivel
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
// Buscar niveles para crear los salones

if ($_POST["funcion"] == "buscar_nivel_salon") {
    $usuario->buscar_nivel_salon();
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_nivel' => $objeto->id_niveles,
            'nombre_nivel' => $objeto->nombre_nivel
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// ----------fin de SECTION SALONES ------------------//

// ------------------SECTION CURSOS-----------------//

// Creamos curso por el formulario #form-curso
if ($_POST["funcion"] == "crear-curso") {
    $name = $_POST["name"];
    $usuario->crear_curso($name);
}

// Buscar cursos
if ($_POST["funcion"] == "buscar_curso") {
    $usuario->buscar_curso();
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-curso") {
            echo "no-curso";
        } else {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_curso' => $objeto->id_cursos,
                'nombre_curso' => $objeto->nombre_curso
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// ------------------FIN DE SECTION CURSOS-----------------//


// ------------------SECTION CLASES-----------------//

// Creamos clase por el formulario #form-clase
if ($_POST["funcion"] == "crear-clase") {
    $salon = $_POST["salon"];
    $docente = $_POST["docente"];
    $curso = $_POST["curso"];
    $usuario->crear_clase($salon, $docente, $curso);
}


// Buscar clases
if ($_POST["funcion"] == "buscar_clase") {
    $usuario->buscar_clase();
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-clase") {
            echo "no-clase";
        } else {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_clase' => $objeto->id_class,
                'salon' => $objeto->salon,
                'nivel' => $objeto->nivel,
                'docente' => $objeto->docente,
                'curso' => $objeto->curso,
                'foto' => $objeto->foto
                // 'profesor' => $objeto->nombres
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
// Buscar salones para crear clase
if ($_POST["funcion"] == "buscar_salon_clase") {
    $usuario->buscar_salon_clase();
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_salon' => $objeto->id_salon,
            'salon' => $objeto->nombre_salon,
            'nivel' => $objeto->nombre_nivel
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
// Buscar salones para crear clase
if ($_POST["funcion"] == "buscar_docente_clase") {
    $usuario->buscar_docente_clase();
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_docente' => $objeto->id_usuario,
            'nombres' => $objeto->nombres,
            'apellidos' => $objeto->apellidos
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
// Buscar cursos para crear clase
if ($_POST["funcion"] == "buscar_curso_clase") {
    $usuario->buscar_curso_clase();
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_curso' => $objeto->id_cursos,
            'nombre' => $objeto->nombre_curso,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
// Buscar tareas de la clase
if ($_POST["funcion"] == "buscar_tareas_clase") {
    $id_class = $_POST["id_class"];
    $usuario->buscar_tareas_clase($id_class);
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-register") {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_work_class' => $objeto->id_work_class,
                'titulo' => $objeto->titulo,
                'fecha_entrega' => $objeto->fecha_entrega,
                'nombre_work' => $objeto->nombre_work
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

if ($_POST["funcion"] == "subir_archivo_tarea") {
    if ($_FILES['archivo_material'] == "") {
        echo "null";
    } else {
        if (($_FILES['archivo_material']['type'] == 'application/pdf') || ($_FILES['archivo_material']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') || ($_FILES['archivo_material']['type'] == 'application/pptx') || ($_FILES['archivo_material']['type'] == 'application/xls')) {

            $nombre = uniqid() . '-' . $_FILES['archivo_material']['name'];
            $ruta = '../archivos/tareas/' . $nombre;
            move_uploaded_file($_FILES['archivo_material']['tmp_name'], $ruta);

            echo $ruta;
        } else {
            echo "doc_noadmitido";
        }
    }
}
if ($_POST["funcion"] == "crear_tarea_clase") {
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_entrega = $_POST["fecha_entrega"];
    $fecha_creacion = $_POST["fecha_creacion"];
    $calificacion = $_POST["calificacion"];
    $ruta = $_POST["ruta"];
    $tipo_tarea = $_POST["tipo_tarea"];
    $id_class = $_POST["id_class"];
    $usuario->crear_tarea_clase($titulo, $tipo_tarea, $descripcion, $fecha_creacion, $fecha_entrega, $calificacion, $ruta, $id_class);
}
if ($_POST["funcion"] == "crear_material_clase") {
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_creacion = $_POST["fecha_creacion"];
    $ruta = $_POST["ruta"];
    $tipo_tarea = $_POST["tipo_tarea"];
    $id_class = $_POST["id_class"];
    $usuario->crear_material_clase($titulo, $tipo_tarea, $descripcion, $fecha_creacion, $ruta, $id_class);
}


// Buscar tarea detallada por key o id
if ($_POST["funcion"] == "buscar_detail_tarea") {
    $id_work = $_POST["id_work"];
    $usuario->buscar_detail_tarea($id_work);
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-register") {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_work_class' => $objeto->id_work_class,
                'id_class' => $objeto->id_class,
                'titulo' => $objeto->titulo,
                'descripcion' => $objeto->descripcion,
                'fecha_creacion' => $objeto->fecha_creacion,
                'fecha_entrega' => $objeto->fecha_entrega,
                'archivo_class' => $objeto->archivo_class,
                'nombre_work' => $objeto->nombre_work,
                'puntos' => $objeto->puntos,
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
// Buscar clase para work - tarea - material
if ($_POST["funcion"] == "buscar_clase_work") {
    $id_class = $_POST["id_class"];
    $usuario->buscar_clase_work($id_class);
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-register") {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_clase' => $objeto->id_class,
                'salon' => $objeto->salon,
                'nivel' => $objeto->nivel,
                'curso' => $objeto->curso
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// CREAR Tarea subida  POR ALUMNO
if ($_POST["funcion"] == "alumno-tarea-subida") {
    if ($_FILES['tarea'] == "") {
        echo "null";
    } else {
        if (($_FILES['tarea']['type'] == 'application/pdf') || ($_FILES['tarea']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') || ($_FILES['tarea']['type'] == 'application/pptx') || ($_FILES['tarea']['type'] == 'application/xls')) {

            $nombre = uniqid() . '-' . $_FILES['tarea']['name'];
            $ruta = '../archivos/tareas_subidas/' . $nombre;
            move_uploaded_file($_FILES['tarea']['tmp_name'], $ruta);
            echo $ruta;
        } else {
            echo "doc_noadmitido";
        }
    }
}
// SUBIR TAREA POR EL ALUMNO
if ($_POST["funcion"] == "subir-tarea-alumno") {
    $id_tarea = $_POST["id_work"];
    $fecha_subida = $_POST["fecha_subida"];
    $ruta = $_POST["ruta"];
    $usuario->subir_tarea_alumno($id_tarea, $id_usuario, $fecha_subida, $ruta);
}

// BUSCAR TAREA SEBIDA POR ALUMNO
if ($_POST["funcion"] == "buscar_tarea_subida") {
    $id_tarea = $_POST["id_work"];
    $usuario->buscar_tarea_subida($id_tarea, $id_usuario);
    if ($usuario->mensaje == "no-register") {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'fecha_entrega' => $objeto->fecha_entrega,
                'no_register' => $usuario->mensaje
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_tarea_subida' => $objeto->id_tarea_subida,
                'estado_entrega' => $objeto->estado_entrega,
                'archivo_entrega' => $objeto->archivo_entrega,
                'calificacion' => $objeto->calificacion,
                'puntos' => $objeto->puntos,
                'fecha_subida' => $objeto->fecha_subida,
                'fecha_entrega' => $objeto->fecha_entrega
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
// Buscar datos sobre estados de entregas por parte del docente
if ($_POST["funcion"] == "buscar_estados_docentes_envios") {
    $id_tarea = $_POST["id_work"];
    $usuario->buscar_estados_docentes_envios($id_tarea);
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'personas' => $objeto->personas,
            'enviados' => $objeto->enviados,
            'fecha' => $objeto->fecha_entrega
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
// Buscar tipo de trabajo tarea o material
if ($_POST["funcion"] == "buscar_tipo_work") {
    $id_tarea = $_POST["id_work"];
    $usuario->buscar_tipo_work($id_tarea);
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'work_tipo' => $objeto->id_work_type
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
// Buscar tareas subidas para calificar
if ($_POST["funcion"] == "buscar_tareas_calificar") {
    $id_tarea = $_POST["id_work"];
    $usuario->buscar_tareas_calificar($id_tarea);
    $json = array();
    foreach ($usuario->datos as $objeto) {
        $json[] = array(
            'id_tarea_subida' => $objeto->id_tarea_subida,
            'estado_entrega' => $objeto->estado_entrega,
            'archivo_entrega' => $objeto->archivo_entrega,
            'calificacion' => $objeto->calificacion,
            'fecha_subida' => $objeto->fecha_subida,
            'nombres' => $objeto->nombres,
            'apellidos' => $objeto->apellidos,
            'foto' => $objeto->foto
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// ------------------FIN DE SECTION CLASES-----------------//


// -----------------------SESION DE ADMINISTRADOR FIN -----------------//


// SESION DE ALUMNOS INICIADOS//

// Buscar cursos para los alumnos
if ($_POST["funcion"] == "buscar_courses_alumno") {
    $usuario->buscar_courses_alumno($id_usuario);
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-register") {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_clase' => $objeto->id_class,
                'salon' => $objeto->salon,
                'nivel' => $objeto->nivel,
                'docente' => $objeto->docente,
                'curso' => $objeto->curso,
                'foto' => $objeto->foto
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
// FIN DE SESION DE ALUMNOS INICIADOS//


// SESION DE DOCENTES INICIADOS//

// Buscar cursos para los docentes

if ($_POST["funcion"] == "buscar_class_docente") {
    $usuario->buscar_courses_docente($id_usuario);
    if (empty($usuario->datos)) {
        if ($usuario->mensaje == "no-register") {
            echo "no-register";
        }
    } else {
        $json = array();
        foreach ($usuario->datos as $objeto) {
            $json[] = array(
                'id_clase' => $objeto->id_class,
                'salon' => $objeto->salon,
                'nivel' => $objeto->nivel,
                'docente' => $objeto->docente,
                'curso' => $objeto->curso,
                'foto' => $objeto->foto
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
