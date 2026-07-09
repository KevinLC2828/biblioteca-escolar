<?php

require_once __DIR__ . "/../config/conexion.php";

class sanciones{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT
        h.id, h.estudiante_id, p.nombres AS nombre_estudiante, p.apellidos, h.motivo, h.monto, h.fecha_sancion, h.estado
        FROM sanciones h
        INNER JOIN estudiantes p
        ON h.estudiante_id = p.id
        ORDER BY h.id DESC";
        $res = $conn->query($sql);

        $sancionesLista = [];
        while ($fila = $res->fetch_assoc()) {
            $sancionesLista[] = $fila;
        }
        return $sancionesLista;
    }

    public static function busqueda($id, $motivo)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_motivo = $conn->real_escape_string($motivo);

        $sql = "SELECT
        h.id, h.estudiante_id, p.nombres AS nombre_estudiante, p.apellidos, h.motivo, h.monto, h.fecha_sancion, h.estado
        FROM sanciones h
        INNER JOIN estudiantes p
        ON h.estudiante_id = p.id
        WHERE (h.id = '$bd_id' OR h.motivo = '$bd_motivo')
        LIMIT 5";
        $res = $conn->query($sql);

        $sancionesLista = [];
        while ($fila = $res->fetch_assoc()) {
            $sancionesLista[] = $fila;
        }
        return $sancionesLista;
    }

    public static function crear($estudiante_id, $motivo, $monto, $fecha_sancion, $estado)
    {
        $conn = Conexion::conectar();
        $bd_estudiante_id = $conn->real_escape_string($estudiante_id);
        $bd_motivo = $conn->real_escape_string($motivo);
        $bd_monto = $conn->real_escape_string($monto);
        $bd_fecha_sancion = $conn->real_escape_string($fecha_sancion);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "INSERT INTO sanciones (estudiante_id, motivo, monto, fecha_sancion, estado) VALUES ('$bd_estudiante_id', '$bd_motivo', '$bd_monto', '$bd_fecha_sancion', '$bd_estado')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $estudiante_id, $motivo, $monto, $fecha_sancion, $estado)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_estudiante_id = $conn->real_escape_string($estudiante_id);
        $bd_motivo = $conn->real_escape_string($motivo);
        $bd_monto = $conn->real_escape_string($monto);
        $bd_fecha_sancion = $conn->real_escape_string($fecha_sancion);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "UPDATE sanciones SET estudiante_id='$bd_estudiante_id',motivo='$bd_motivo',monto='$bd_monto',fecha_sancion='$bd_fecha_sancion',estado='$bd_estado' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM sanciones WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>