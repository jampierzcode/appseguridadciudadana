<?php
include_once "Conexion.php";

class Usuario
{
    var $datos;
    var $mensaje;

    public function __construct()
    {
        // se va a conectar a la base de datos
        $db = new Conexion(); // $db ya no es una variable es un objeto
        $this->conexion = $db->pdo;
        // $this hace referencia al objeto que se crea en una instancia de clase
    }

    function Loguearse($dni, $password)
    {
        $sql = "SELECT * FROM usuario WHERE dni=:dni and password=:password";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':dni' => $dni, ':password' => $password));
        $this->datos = $query->fetchAll(); // retorna objetos o no
        return $this->datos;
    }

    function actualizar_foto_user($id_usuario, $nombre)
    {
        $sql = "SELECT foto FROM usuario where id_usuario=:id";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id' => $id_usuario));
        $this->datos = $query->fetchall();
        if (!empty($this->datos)) {
            $sql = "UPDATE usuario SET foto=:nombre where id_usuario=:id";
            try {
                $query = $this->conexion->prepare($sql);
                $query->execute(array(':id' => $id_usuario, ':nombre' => $nombre));
                echo "foto_add";
            } catch (\Throwable $th) {
                echo "foto_noadd";
            }
        }
    }
    // ----------------FUNCIONES DEL DASHBOARD DEL ADMINISTRADOR -------------------//

    function buscar_cant_alumnos()
    {
        $sql = "SELECT id_usuario FROM usuario where us_tipo=:us_tipo";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':us_tipo' => 2));
        $this->datos = $query->fetchAll(); // retorna objetos o no
        return $this->datos;
    }
    function buscar_cant_docentes()
    {
        $sql = "SELECT id_usuario FROM usuario where us_tipo=:us_tipo";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':us_tipo' => 3));
        $this->datos = $query->fetchAll(); // retorna objetos o no
        return $this->datos;
    }
    function buscar_cant_clases()
    {
        $sql = "SELECT id_class FROM class";
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $this->datos = $query->fetchAll(); // retorna objetos o no
        return $this->datos;
    }



    // ----------------FIN DE FUNCIONES DEL DASHBOARD DEL ADMINISTRADOR -------------------//


    function obtener_datos($id_usuario)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario=:id_usuario";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_usuario' => $id_usuario));
        $this->datos = $query->fetchAll(); // retorna objetos o no
        return $this->datos;
    }

    // --------------SECTION DE ALUMNOS ---------------------//

    // Crear al alumno desde el administrador
    function crear_alumno($name, $lastname, $edad, $dni, $sexo, $foto, $password, $salon, $us_tipo)
    {
        $sql = "INSERT INTO usuario(nombres, apellidos, edad, dni, sexo, foto, password, salon_id, us_tipo) VALUES(:name, :lastname, :edad, :dni, :sexo, :foto, :password, :id_salon, :us_tipo)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':name' => $name, ':lastname' => $lastname, ':edad' => $edad, ':dni' => $dni, ':sexo' => $sexo, ':foto' => $foto, ':password' => $password, ':id_salon' => $salon, ':us_tipo' => $us_tipo));
            echo "add-alumno";
        } catch (\Throwable $th) {
            echo "noadd-alumno";
        }
    }
    // Buscar Alumnos
    function buscar_alumnos()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT U.id_usuario, U.dni, U.password, U.foto, U.nombres, U.apellidos, S.nombre_salon, N.nombre_nivel FROM usuario as U inner join salon as S on U.salon_id=S.id_salon inner join niveles as N on S.nivel_id=N.id_niveles where ((apellidos LIKE :consulta) AND U.us_tipo=:us_tipo) OR ((nombres LIKE :consulta) AND U.us_tipo=:us_tipo)";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%", ':us_tipo' => 2));
            $this->datos = $query->fetchall();
            if (empty($this->datos)) {
                $this->mensaje = "no-alumno";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        } else {
            $sql = "SELECT U.id_usuario,U.dni, U.password, U.nombres, U.apellidos, U.foto, S.nombre_salon, N.nombre_nivel FROM usuario as U inner join salon as S on U.salon_id=S.id_salon inner join niveles as N on S.nivel_id=N.id_niveles where U.us_tipo=:us_tipo";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':us_tipo' => 2));
            $this->datos = $query->fetchAll();
            if (empty($this->datos)) {
                $this->mensaje = "no-register";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        }
    }

    // Buscar salon para el alumno
    function buscar_salon_alumno()
    {
        $sql = "SELECT S.id_salon, S.nombre_salon, N.nombre_nivel FROM salon as S inner join niveles as N on S.nivel_id=N.id_niveles";
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $this->datos = $query->fetchAll();
        return $this->datos;
    }
    // -----------FIN DE SECTION DE ALUMNOS------------------//


    // ----------------------SECTION DE DOCENTES------------------------//
    // Crear al docente desde el administrador
    function crear_docente($name, $lastname, $edad, $dni, $sexo, $foto, $password, $us_tipo)
    {
        $sql = "INSERT INTO usuario(nombres, apellidos, edad, dni, sexo, foto, password, us_tipo) VALUES(:name, :lastname, :edad, :dni, :sexo, :foto, :password, :us_tipo)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':name' => $name, ':lastname' => $lastname, ':edad' => $edad, ':dni' => $dni, ':sexo' => $sexo, ':foto' => $foto, ':password' => $password, ':us_tipo' => $us_tipo));
            echo "add-docente";
        } catch (\Throwable $th) {
            echo "noadd-docente";
        }
    }
    function buscar_docentes()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT U.id_usuario, U.dni, U.password, U.foto, U.nombres, U.apellidos FROM usuario as U where ((U.apellidos LIKE :consulta) AND U.us_tipo=:us_tipo) OR ((U.nombres LIKE :consulta) AND U.us_tipo=:us_tipo)";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%", ':us_tipo' => 3));
            $this->datos = $query->fetchall();
            if (empty($this->datos)) {
                $this->mensaje = "no-docente";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        } else {
            $sql = "SELECT U.id_usuario, U.dni, U.password, U.nombres, U.apellidos, U.foto FROM usuario as U where U.us_tipo=:us_tipo";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':us_tipo' => 3));
            $this->datos = $query->fetchAll();
            if (empty($this->datos)) {
                $this->mensaje = "no-register";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        }
    }
    // ----------------------FIN DE SECTION DE DOCENTES------------------------//


    // Eliminar usuarios

    function eliminar_usuario($id_user)
    {
        $sql = "DELETE FROM usuario WHERE id_usuario=:id_usuario";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':id_usuario' => $id_user));
            echo "delete_usuario";
        } catch (\Throwable $th) {
            echo "no_delete_usuario";
        }
    }

    // -----------------GESTION SALON----------------------//

    // Crear al salon desde el administrador
    function crear_salon($name, $id_nivel)
    {
        $sql = "INSERT INTO salon(nombre_salon, nivel_id) VALUES(:nombre, :nivel)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':nombre' => $name, ':nivel' => $id_nivel));
            echo "add-salon";
        } catch (\Throwable $th) {
            echo "noadd-salon";
        }
    }
    // Buscar Salon
    function buscar_salon()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT S.id_salon, S.nombre_salon, N.nombre_nivel FROM salon as S inner join niveles as N on S.nivel_id=N.id_niveles where nombre_salon LIKE :consulta";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->datos = $query->fetchall();
            if (empty($this->datos)) {
                $this->mensaje = "no-salon";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        } else {
            $sql = "SELECT S.id_salon, S.nombre_salon, N.nombre_nivel FROM salon as S inner join niveles as N on S.nivel_id=N.id_niveles";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $this->datos = $query->fetchAll();
            if (empty($this->datos)) {
                $this->mensaje = "no-register";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        }
    }
    // Buscar nivel para el salon
    function buscar_nivel_salon()
    {
        $sql = "SELECT id_niveles, nombre_nivel FROM niveles";
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $this->datos = $query->fetchAll();
        return $this->datos;
    }

    // -----------FIN DE SECTION SALONES-------------------//


    // -----------SECTION CURSOS-------------------//


    // Crear el curso desde el administrador
    function crear_curso($name)
    {
        $sql = "INSERT INTO cursos(nombre_curso) VALUES(:nombre)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':nombre' => $name));
            echo "add-curso";
        } catch (\Throwable $th) {
            echo "noadd-curso";
        }
    }

    // Buscar Cursos
    function buscar_curso()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT id_cursos, nombre_curso FROM cursos where nombre_curso LIKE :consulta";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->datos = $query->fetchall();
            if (empty($this->datos)) {
                $this->mensaje = "no-curso";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        } else {
            $sql = "SELECT id_cursos, nombre_curso FROM cursos";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $this->datos = $query->fetchAll();
            if (empty($this->datos)) {
                $this->mensaje = "no-register";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        }
    }
    // -----------FIN DE SECTION CURSOS-------------------//


    // -----------SECTION CLASES-------------------//

    // Crear clases
    function crear_clase($salon, $docente, $curso)
    {
        $sql = "INSERT INTO class(salon_id, docente_id, curso_id) VALUES(:salon, :docente, :curso)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':salon' => $salon, ':docente' => $docente, ':curso' => $curso));
            echo "add-clase";
        } catch (\Throwable $th) {
            echo "noadd-clase";
        }
    }
    // Buscar clases
    function buscar_clase()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT CL.id_class, (SELECT SA.nombre_salon FROM salon as SA where SA.id_salon=CL.salon_id) as salon, (SELECT NI.nombre_nivel as nivel FROM salon as SA inner join niveles as NI on nivel_id=id_niveles where SA.id_salon=CL.salon_id) as nivel, (SELECT CONCAT_WS(' ', US.nombres, US.apellidos) FROM usuario as US WHERE us_tipo=3 AND US.id_usuario=CL.docente_id) as docente, (SELECT US.foto FROM usuario as US WHERE us_tipo=3 AND US.id_usuario=CL.docente_id) as foto,(SELECT CUR.nombre_curso FROM cursos as CUR WHERE CUR.id_cursos=CL.curso_id) as curso FROM class as CL inner join cursos as CUR on CL.curso_id=CUR.id_cursos WHERE (CUR.nombre_curso LIKE :consulta)  ORDER BY nivel ASC";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->datos = $query->fetchall();
            if (empty($this->datos)) {
                $this->mensaje = "no-clase";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        } else {
            $sql = "SELECT CL.id_class, (SELECT SA.nombre_salon FROM salon as SA where SA.id_salon=CL.salon_id) as salon, (SELECT NI.nombre_nivel as nivel FROM salon as SA inner join niveles as NI on nivel_id=id_niveles where SA.id_salon=CL.salon_id) as nivel, (SELECT CONCAT_WS(' ', US.nombres, US.apellidos) FROM usuario as US WHERE us_tipo=3 AND US.id_usuario=CL.docente_id) as docente, (SELECT US.foto FROM usuario as US WHERE us_tipo=3 AND US.id_usuario=CL.docente_id) as foto, (SELECT CUR.nombre_curso FROM cursos as CUR WHERE CUR.id_cursos=CL.curso_id) as curso FROM class as CL ORDER BY nivel ASC";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $this->datos = $query->fetchAll();
            if (empty($this->datos)) {
                $this->mensaje = "no-register";
                return $this->mensaje;
            } else {
                return $this->datos;
            }
        }
    }
    // Buscar clase para el alumno
    function buscar_courses_alumno($id_usuario)
    {
        $sql = "SELECT CL.id_class, (SELECT SA.nombre_salon FROM salon as SA where SA.id_salon=CL.salon_id) as salon, (SELECT NI.nombre_nivel as nivel FROM salon as SA inner join niveles as NI on SA.nivel_id=NI.id_niveles where SA.id_salon=CL.salon_id) as nivel, (SELECT CONCAT_WS(' ', US.nombres, US.apellidos) FROM usuario as US WHERE US.us_tipo=3 AND US.id_usuario=CL.docente_id) as docente, (SELECT US.foto FROM usuario as US WHERE US.us_tipo=3 AND US.id_usuario=CL.docente_id) as foto, (SELECT CUR.nombre_curso FROM cursos as CUR WHERE CUR.id_cursos=CL.curso_id) as curso FROM class as CL inner join salon as SA on CL.salon_id=SA.id_salon WHERE SA.id_salon=(SELECT US.salon_id FROM usuario as US WHERE US.id_usuario=:id_usuario)";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_usuario' => $id_usuario));
        $this->datos = $query->fetchAll();
        if (empty($this->datos)) {
            $this->mensaje = "no-register";
            return $this->mensaje;
        } else {
            return $this->datos;
        }
    }
    // Buscar clase por key id especifico
    function buscar_clase_work($id_class)
    {
        $sql = "SELECT CL.id_class, (SELECT SA.nombre_salon FROM salon as SA where SA.id_salon=CL.salon_id) as salon, (SELECT NI.nombre_nivel FROM salon as SA inner join niveles as NI on nivel_id=id_niveles where SA.id_salon=CL.salon_id) as nivel, (SELECT CUR.nombre_curso FROM cursos as CUR WHERE CUR.id_cursos=CL.curso_id) as curso FROM class as CL WHERE CL.id_class=:id_class";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_class' => $id_class));
        $this->datos = $query->fetchAll();
        if (empty($this->datos)) {
            $this->mensaje = "no-register";
            return $this->mensaje;
        } else {
            return $this->datos;
        }
    }
    // Buscar tareas de clase en especifico id
    function buscar_tareas_clase($id_class)
    {
        $sql = "SELECT WK.id_work_class, WK.titulo, WK.descripcion, WK.url, WK.fecha_creacion, WK.fecha_entrega, WK.archivo_class, WKT.nombre_work as nombre_work, WK.puntos FROM work_class as WK inner join work_type as WKT on WK.id_work_type=WKT.id_work_type WHERE id_class=:id_class ORDER BY WK.fecha_creacion DESC";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_class' => $id_class));
        $this->datos = $query->fetchAll();
        if (empty($this->datos)) {
            $this->mensaje = "no-register";
            return $this->mensaje;
        } else {
            return $this->datos;
        }
    }
    function crear_tarea_clase($titulo, $tipo_tarea, $descripcion, $fecha_creacion, $fecha_entrega, $calificacion, $ruta, $id_class)
    {
        $sql = "INSERT INTO work_class(titulo, descripcion, fecha_creacion, fecha_entrega,  archivo_class, id_work_type, puntos, id_class) VALUES(:titulo, :descripcion, :fecha_creacion, :fecha_entrega, :archivo_class, :tipo_tarea, :puntos, :id_class)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':titulo' => $titulo, ':descripcion' => $descripcion, ':fecha_creacion' => $fecha_creacion, ':fecha_entrega' => $fecha_entrega, ':archivo_class' => $ruta, ':tipo_tarea' => $tipo_tarea, ':puntos' => $calificacion, ':id_class' => $id_class));
            echo "add-tarea";
        } catch (\Throwable $th) {
            echo "noadd-tarea" . $th;
        }
    }
    function crear_material_clase($titulo, $tipo_tarea, $descripcion, $fecha_creacion, $ruta, $id_class)
    {
        $sql = "INSERT INTO work_class(titulo, descripcion,fecha_creacion, archivo_class, id_work_type, id_class) VALUES(:titulo, :descripcion, :fecha_creacion, :archivo_class, :tipo_tarea, :id_class)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':titulo' => $titulo, ':descripcion' => $descripcion, ':fecha_creacion' => $fecha_creacion, ':archivo_class' => $ruta, ':tipo_tarea' => $tipo_tarea, ':id_class' => $id_class));
            echo "add-material";
        } catch (\Throwable $th) {
            echo "noadd-material" . $th;
        }
    }
    // Buscar tarea por id o key
    function buscar_detail_tarea($id_work)
    {
        $sql = "SELECT WK.id_work_class, WK.id_class, WK.titulo, WK.descripcion, WK.fecha_creacion, WK.fecha_entrega, WK.archivo_class, WKT.nombre_work as nombre_work, WK.puntos FROM work_class as WK inner join work_type as WKT on WK.id_work_type=WKT.id_work_type WHERE WK.id_work_class=:id_work";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_work' => $id_work));
        $this->datos = $query->fetchAll();
        if (empty($this->datos)) {
            $this->mensaje = "no-register";
            return $this->mensaje;
        } else {
            return $this->datos;
        }
    }
    // 
    // Buscar tarea para calificar
    function buscar_tareas_calificar($id_tarea)
    {
        $sql = "SELECT TS.id_tarea_subida, TS.estado_entrega, TS.archivo_entrega, TS.calificacion, TS.fecha_subida, US.nombres, US.apellidos, US.foto FROM tarea_subida as TS inner join usuario as US WHERE US.id_usuario=TS.alumno_id AND TS.tarea_id=:id_work";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_work' => $id_tarea));
        $this->datos = $query->fetchAll();
        if (empty($this->datos)) {
            $this->mensaje = "no-register";
            return $this->mensaje;
        } else {
            return $this->datos;
        }
    }
    // 
    function buscar_tarea_subida($id_tarea, $id_usuario)
    {
        $sql = "SELECT TS.id_tarea_subida, WK.id_work_type as work_type, WK.puntos, TS.estado_entrega, TS.archivo_entrega, TS.calificacion, TS.fecha_subida, WK.fecha_entrega FROM tarea_subida as TS inner join work_class as WK on TS.tarea_id=WK.id_work_class WHERE TS.tarea_id=:id_tarea AND TS.alumno_id=:id_alumno AND WK.id_work_type=1";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_tarea' => $id_tarea, ':id_alumno' => $id_usuario));
        $this->datos = $query->fetchAll();
        if (empty($this->datos)) {
            $sql = "SELECT fecha_entrega, id_work_type as work_type FROM work_class WHERE id_work_class=:id_tarea";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':id_tarea' => $id_tarea));
            $this->datos = $query->fetchAll();
            $this->mensaje = "no-register";
            return array($this->mensaje, $this->datos);
        } else {
            return $this->datos;
        }
    }
    function buscar_estados_docentes_envios($id_tarea)
    {
        $sql = "SELECT COUNT(TS.id_tarea_subida) as enviados, (SELECT COUNT(US.id_usuario) FROM usuario as US WHERE US.salon_id=(SELECT SA.id_salon FROM work_class as WK inner join class as CL inner join salon as SA WHERE WK.id_work_class=9 AND WK.id_class=CL.id_class AND CL.salon_id=SA.id_salon)) as personas, WK.fecha_entrega FROM tarea_subida as TS inner join work_class as WK on TS.tarea_id=WK.id_work_class WHERE WK.id_work_class=:id_tarea";

        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_tarea' => $id_tarea));
        $this->datos = $query->fetchAll();
        return $this->datos;
    }
    function buscar_tipo_work($id_tarea)
    {
        $sql = "SELECT id_work_type FROM work_class WHERE id_work_class=:id_tarea";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_tarea' => $id_tarea));
        $this->datos = $query->fetchAll();
        return $this->datos;
    }


    // ---------------
    function subir_tarea_alumno($id_tarea, $id_usuario, $fecha_subida, $ruta)
    {
        $sql = "INSERT INTO tarea_subida(estado_entrega, alumno_id, tarea_id, archivo_entrega, fecha_subida) VALUES(:estado_entrega, :alumno_id, :tarea_id, :archivo_entrega, :fecha_subida)";
        try {
            $query = $this->conexion->prepare($sql);
            $query->execute(array(':estado_entrega' => "entregado", ':alumno_id' => $id_usuario, ':tarea_id' => $id_tarea, ':archivo_entrega' => $ruta, ':fecha_subida' => $fecha_subida));
            echo "add-alumno-tarea";
        } catch (\Throwable $th) {
            echo "noadd-alumno-tarea";
        }
    }

    // Buscar clase para el docente
    function buscar_courses_docente($id_usuario)
    {
        $sql = "SELECT CL.id_class, (SELECT SA.nombre_salon FROM salon as SA where SA.id_salon=CL.salon_id) as salon, (SELECT NI.nombre_nivel as nivel FROM salon as SA inner join niveles as NI on nivel_id=id_niveles where SA.id_salon=CL.salon_id) as nivel, (SELECT CONCAT_WS(' ', US.nombres, US.apellidos) FROM usuario as US WHERE us_tipo=3 AND US.id_usuario=CL.docente_id) as docente, (SELECT US.foto FROM usuario as US WHERE us_tipo=3 AND US.id_usuario=CL.docente_id) as foto, (SELECT CUR.nombre_curso FROM cursos as CUR WHERE CUR.id_cursos=CL.curso_id) as curso FROM class as CL WHERE CL.docente_id=:id_usuario";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_usuario' => $id_usuario));
        $this->datos = $query->fetchAll();
        if (empty($this->datos)) {
            $this->mensaje = "no-register";
            return $this->mensaje;
        } else {
            return $this->datos;
        }
    }

    // BUscar salones para la clase
    function buscar_salon_clase()
    {
        $sql = "SELECT SA.id_salon, SA.nombre_salon, NI.nombre_nivel FROM salon as SA inner join niveles as NI on SA.nivel_id=NI.id_niveles";
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $this->datos = $query->fetchAll();
        return $this->datos;
    }
    // BUscar docentes para la clase
    function buscar_docente_clase()
    {
        $sql = "SELECT id_usuario, nombres, apellidos FROM usuario WHERE us_tipo=3";
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $this->datos = $query->fetchAll();
        return $this->datos;
    }
    // BUscar cursos para la clase
    function buscar_curso_clase()
    {
        $sql = "SELECT id_cursos, nombre_curso FROM cursos";
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $this->datos = $query->fetchAll();
        return $this->datos;
    }

    // -----------FIN DE SECTION CLASES-------------------//
}
