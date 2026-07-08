<?php

require_once __DIR__ . "/../config/conexion.php";

class prestamos{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT 
        p.id, l.titulo, p.nombre_prestatario, p.curso_grado, p.fecha_prestamo, p.fecha_devolucion_esperada, p.fecha_devolucion_real, p.estado 
        FROM prestamos p 
        INNER JOIN libros l
        ON p.libro_id = l.id";
        $res = $conn->query($sql);

        $prestamos = [];
        while ($fila = $res->fetch_assoc()) {
            $prestamos[] = $fila;
        }
        return $prestamos;
    }

    public static function busqueda($id, $titulo, $autor, $prestatario)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_titulo = $conn->real_escape_string($titulo);
        $bd_autor = $conn->real_escape_string($autor);
        $bd_prestatario = $conn->real_escape_string($prestatario);


        $sql = "SELECT 
        p.id, l.titulo, p.nombre_prestatario, p.curso_grado, p.fecha_prestamo, p.fecha_devolucion_esperada, p.fecha_devolucion_real, p.estado 
        FROM prestamos p 
        INNER JOIN libros l
        ON p.libro_id = l.id 
        WHERE (p.id = '$bd_id' OR l.titulo = '$bd_titulo' OR l.autor = '$bd_autor' OR p.nombre_prestatario = '$bd_prestatario') 
        LIMIT 5";
        $res = $conn->query($sql);

        $prestamos = [];
        while ($fila = $res->fetch_assoc()) {
            $prestamos[] = $fila;
        }
        return $prestamos;
    }

    public static function crear($libro_id , $nombre_prestatario, $curso_grado, $fecha_prestamo, $fecha_devolucion_esperada, $fecha_devolucion_real, $estado)
    {
        $conn = Conexion::conectar();
        $bd_libro_id = $conn->real_escape_string($libro_id);
        $bd_nombre_prestatario = $conn->real_escape_string($nombre_prestatario);
        $bd_curso_grado = $conn->real_escape_string($curso_grado);
        $bd_fecha_prestamo = $conn->real_escape_string($fecha_prestamo);
        $bd_fecha_devolucion_esperada = $conn->real_escape_string($fecha_devolucion_esperada);
        $bd_fecha_devolucion_real = $conn->real_escape_string($fecha_devolucion_real);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "INSERT INTO prestamos (libro_id , nombre_prestatario, curso_grado, fecha_prestamo, fecha_devolucion_esperada, fecha_devolucion_real, estado) VALUES ('$bd_libro_id', '$bd_nombre_prestatario', '$bd_curso_grado', '$bd_fecha_prestamo', '$bd_fecha_devolucion_esperada', '$bd_fecha_devolucion_real', '$bd_estado')";
        return $conn->query($sql);
    }


    public static function actualizar($id, $fecha_devolucion_real, $estado)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_fecha_devolucion_real = $conn->real_escape_string($fecha_devolucion_real);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "UPDATE prestamos 
                SET fecha_devolucion_real='$bd_fecha_devolucion_real',estado='$bd_estado' 
                WHERE id='$bd_id'";
        return $conn->query($sql);
    }


    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM prestamos WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>