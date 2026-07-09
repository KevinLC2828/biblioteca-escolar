<?php

require_once __DIR__ . "/../config/conexion.php";

class turnos{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT
        h.id, h.empleado_id, p.nombres AS nombre_empleado, p.apellidos, h.dia_semana, h.hora_inicio, h.hora_fin, h.area
        FROM turnos h
        INNER JOIN empleados p
        ON h.empleado_id = p.id
        ORDER BY h.id DESC";
        $res = $conn->query($sql);

        $turnosLista = [];
        while ($fila = $res->fetch_assoc()) {
            $turnosLista[] = $fila;
        }
        return $turnosLista;
    }

    public static function busqueda($id, $area)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_area = $conn->real_escape_string($area);

        $sql = "SELECT
        h.id, h.empleado_id, p.nombres AS nombre_empleado, p.apellidos, h.dia_semana, h.hora_inicio, h.hora_fin, h.area
        FROM turnos h
        INNER JOIN empleados p
        ON h.empleado_id = p.id
        WHERE (h.id = '$bd_id' OR h.area = '$bd_area')
        LIMIT 5";
        $res = $conn->query($sql);

        $turnosLista = [];
        while ($fila = $res->fetch_assoc()) {
            $turnosLista[] = $fila;
        }
        return $turnosLista;
    }

    public static function crear($empleado_id, $dia_semana, $hora_inicio, $hora_fin, $area)
    {
        $conn = Conexion::conectar();
        $bd_empleado_id = $conn->real_escape_string($empleado_id);
        $bd_dia_semana = $conn->real_escape_string($dia_semana);
        $bd_hora_inicio = $conn->real_escape_string($hora_inicio);
        $bd_hora_fin = $conn->real_escape_string($hora_fin);
        $bd_area = $conn->real_escape_string($area);

        $sql = "INSERT INTO turnos (empleado_id, dia_semana, hora_inicio, hora_fin, area) VALUES ('$bd_empleado_id', '$bd_dia_semana', '$bd_hora_inicio', '$bd_hora_fin', '$bd_area')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $empleado_id, $dia_semana, $hora_inicio, $hora_fin, $area)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_empleado_id = $conn->real_escape_string($empleado_id);
        $bd_dia_semana = $conn->real_escape_string($dia_semana);
        $bd_hora_inicio = $conn->real_escape_string($hora_inicio);
        $bd_hora_fin = $conn->real_escape_string($hora_fin);
        $bd_area = $conn->real_escape_string($area);

        $sql = "UPDATE turnos SET empleado_id='$bd_empleado_id',dia_semana='$bd_dia_semana',hora_inicio='$bd_hora_inicio',hora_fin='$bd_hora_fin',area='$bd_area' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM turnos WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>