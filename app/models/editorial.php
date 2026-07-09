<?php

require_once __DIR__ . "/../config/conexion.php";

class editorial{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT id, nombre, pais, telefono, email FROM editoriales ORDER BY id DESC";
        $res = $conn->query($sql);

        $editoriales = [];
        while ($fila = $res->fetch_assoc()) {
            $editoriales[] = $fila;
        }
        return $editoriales;
    }

    public static function busqueda($id, $nombre, $pais)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombre = $conn->real_escape_string($nombre);
        $bd_pais = $conn->real_escape_string($pais);

        $sql = "SELECT id, nombre, pais, telefono, email
                FROM editoriales
                WHERE id = '$bd_id' OR nombre = '$bd_nombre' OR pais = '$bd_pais'
                LIMIT 5";
        $res = $conn->query($sql);

        $editoriales = [];
        while ($fila = $res->fetch_assoc()) {
            $editoriales[] = $fila;
        }
        return $editoriales; //retorna null si no existe
    }

    public static function crear($nombre, $pais, $telefono, $email)
    {
        $conn = Conexion::conectar();
        $bd_nombre = $conn->real_escape_string($nombre);
        $bd_pais = $conn->real_escape_string($pais);
        $bd_telefono = $conn->real_escape_string($telefono);
        $bd_email = $conn->real_escape_string($email);

        $sql = "INSERT INTO editoriales (nombre, pais, telefono, email) VALUES ('$bd_nombre', '$bd_pais', '$bd_telefono', '$bd_email')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $nombre, $pais, $telefono, $email)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombre = $conn->real_escape_string($nombre);
        $bd_pais = $conn->real_escape_string($pais);
        $bd_telefono = $conn->real_escape_string($telefono);
        $bd_email = $conn->real_escape_string($email);

        $sql = "UPDATE editoriales SET nombre='$bd_nombre',pais='$bd_pais',telefono='$bd_telefono',email='$bd_email' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM editoriales WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>