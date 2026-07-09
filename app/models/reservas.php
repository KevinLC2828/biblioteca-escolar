<?php

require_once __DIR__ . "/../config/conexion.php";

class reservas{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT
        h.id, h.sala_id, p.nombre AS nombre_sala, h.nombre_solicitante, h.fecha_reserva, h.hora_inicio, h.hora_fin, h.motivo, h.estado
        FROM reservas h
        INNER JOIN salas p
        ON h.sala_id = p.id
        ORDER BY h.id DESC";
        $res = $conn->query($sql);

        $reservasLista = [];
        while ($fila = $res->fetch_assoc()) {
            $reservasLista[] = $fila;
        }
        return $reservasLista;
    }

    public static function busqueda($id, $nombre_solicitante)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombre_solicitante = $conn->real_escape_string($nombre_solicitante);

        $sql = "SELECT
        h.id, h.sala_id, p.nombre AS nombre_sala, h.nombre_solicitante, h.fecha_reserva, h.hora_inicio, h.hora_fin, h.motivo, h.estado
        FROM reservas h
        INNER JOIN salas p
        ON h.sala_id = p.id
        WHERE (h.id = '$bd_id' OR h.nombre_solicitante = '$bd_nombre_solicitante')
        LIMIT 5";
        $res = $conn->query($sql);

        $reservasLista = [];
        while ($fila = $res->fetch_assoc()) {
            $reservasLista[] = $fila;
        }
        return $reservasLista;
    }

    public static function crear($sala_id, $nombre_solicitante, $fecha_reserva, $hora_inicio, $hora_fin, $motivo, $estado)
    {
        $conn = Conexion::conectar();
        $bd_sala_id = $conn->real_escape_string($sala_id);
        $bd_nombre_solicitante = $conn->real_escape_string($nombre_solicitante);
        $bd_fecha_reserva = $conn->real_escape_string($fecha_reserva);
        $bd_hora_inicio = $conn->real_escape_string($hora_inicio);
        $bd_hora_fin = $conn->real_escape_string($hora_fin);
        $bd_motivo = $conn->real_escape_string($motivo);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "INSERT INTO reservas (sala_id, nombre_solicitante, fecha_reserva, hora_inicio, hora_fin, motivo, estado) VALUES ('$bd_sala_id', '$bd_nombre_solicitante', '$bd_fecha_reserva', '$bd_hora_inicio', '$bd_hora_fin', '$bd_motivo', '$bd_estado')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $sala_id, $nombre_solicitante, $fecha_reserva, $hora_inicio, $hora_fin, $motivo, $estado)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_sala_id = $conn->real_escape_string($sala_id);
        $bd_nombre_solicitante = $conn->real_escape_string($nombre_solicitante);
        $bd_fecha_reserva = $conn->real_escape_string($fecha_reserva);
        $bd_hora_inicio = $conn->real_escape_string($hora_inicio);
        $bd_hora_fin = $conn->real_escape_string($hora_fin);
        $bd_motivo = $conn->real_escape_string($motivo);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "UPDATE reservas SET sala_id='$bd_sala_id',nombre_solicitante='$bd_nombre_solicitante',fecha_reserva='$bd_fecha_reserva',hora_inicio='$bd_hora_inicio',hora_fin='$bd_hora_fin',motivo='$bd_motivo',estado='$bd_estado' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM reservas WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>