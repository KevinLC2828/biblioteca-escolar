<?php

require_once __DIR__ . "/../config/conexion.php";

class estudiante{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT id, nombres, apellidos, curso_grado, cedula, email FROM estudiantes ORDER BY id DESC";
        $res = $conn->query($sql);

        $estudiantes = [];
        while ($fila = $res->fetch_assoc()) {
            $estudiantes[] = $fila;
        }
        return $estudiantes;
    }

    public static function busqueda($id, $nombres, $apellidos)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombres = $conn->real_escape_string($nombres);
        $bd_apellidos = $conn->real_escape_string($apellidos);

        $sql = "SELECT id, nombres, apellidos, curso_grado, cedula, email
                FROM estudiantes
                WHERE id = '$bd_id' OR nombres = '$bd_nombres' OR apellidos = '$bd_apellidos'
                LIMIT 5";
        $res = $conn->query($sql);

        $estudiantes = [];
        while ($fila = $res->fetch_assoc()) {
            $estudiantes[] = $fila;
        }
        return $estudiantes; //retorna null si no existe
    }

    public static function crear($nombres, $apellidos, $curso_grado, $cedula, $email)
    {
        $conn = Conexion::conectar();
        $bd_nombres = $conn->real_escape_string($nombres);
        $bd_apellidos = $conn->real_escape_string($apellidos);
        $bd_curso_grado = $conn->real_escape_string($curso_grado);
        $bd_cedula = $conn->real_escape_string($cedula);
        $bd_email = $conn->real_escape_string($email);

        $sql = "INSERT INTO estudiantes (nombres, apellidos, curso_grado, cedula, email) VALUES ('$bd_nombres', '$bd_apellidos', '$bd_curso_grado', '$bd_cedula', '$bd_email')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $nombres, $apellidos, $curso_grado, $cedula, $email)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombres = $conn->real_escape_string($nombres);
        $bd_apellidos = $conn->real_escape_string($apellidos);
        $bd_curso_grado = $conn->real_escape_string($curso_grado);
        $bd_cedula = $conn->real_escape_string($cedula);
        $bd_email = $conn->real_escape_string($email);

        $sql = "UPDATE estudiantes SET nombres='$bd_nombres',apellidos='$bd_apellidos',curso_grado='$bd_curso_grado',cedula='$bd_cedula',email='$bd_email' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM estudiantes WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>