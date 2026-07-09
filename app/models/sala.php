<?php

require_once __DIR__ . "/../config/conexion.php";

class sala{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT id, nombre, capacidad, ubicacion, estado FROM salas ORDER BY id DESC";
        $res = $conn->query($sql);

        $salas = [];
        while ($fila = $res->fetch_assoc()) {
            $salas[] = $fila;
        }
        return $salas;
    }

    public static function busqueda($id, $nombre, $ubicacion)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombre = $conn->real_escape_string($nombre);
        $bd_ubicacion = $conn->real_escape_string($ubicacion);

        $sql = "SELECT id, nombre, capacidad, ubicacion, estado
                FROM salas
                WHERE id = '$bd_id' OR nombre = '$bd_nombre' OR ubicacion = '$bd_ubicacion'
                LIMIT 5";
        $res = $conn->query($sql);

        $salas = [];
        while ($fila = $res->fetch_assoc()) {
            $salas[] = $fila;
        }
        return $salas; //retorna null si no existe
    }

    public static function crear($nombre, $capacidad, $ubicacion, $estado)
    {
        $conn = Conexion::conectar();
        $bd_nombre = $conn->real_escape_string($nombre);
        $bd_capacidad = $conn->real_escape_string($capacidad);
        $bd_ubicacion = $conn->real_escape_string($ubicacion);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "INSERT INTO salas (nombre, capacidad, ubicacion, estado) VALUES ('$bd_nombre', '$bd_capacidad', '$bd_ubicacion', '$bd_estado')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $nombre, $capacidad, $ubicacion, $estado)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombre = $conn->real_escape_string($nombre);
        $bd_capacidad = $conn->real_escape_string($capacidad);
        $bd_ubicacion = $conn->real_escape_string($ubicacion);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "UPDATE salas SET nombre='$bd_nombre',capacidad='$bd_capacidad',ubicacion='$bd_ubicacion',estado='$bd_estado' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM salas WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>