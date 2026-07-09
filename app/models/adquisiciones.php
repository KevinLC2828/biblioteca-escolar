<?php

require_once __DIR__ . "/../config/conexion.php";

class adquisiciones{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT
        h.id, h.editorial_id, p.nombre AS nombre_editorial, h.titulo_obra, h.cantidad, h.fecha_adquisicion, h.costo_unitario, h.estado
        FROM adquisiciones h
        INNER JOIN editoriales p
        ON h.editorial_id = p.id
        ORDER BY h.id DESC";
        $res = $conn->query($sql);

        $adquisicionesLista = [];
        while ($fila = $res->fetch_assoc()) {
            $adquisicionesLista[] = $fila;
        }
        return $adquisicionesLista;
    }

    public static function busqueda($id, $titulo_obra)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_titulo_obra = $conn->real_escape_string($titulo_obra);

        $sql = "SELECT
        h.id, h.editorial_id, p.nombre AS nombre_editorial, h.titulo_obra, h.cantidad, h.fecha_adquisicion, h.costo_unitario, h.estado
        FROM adquisiciones h
        INNER JOIN editoriales p
        ON h.editorial_id = p.id
        WHERE (h.id = '$bd_id' OR h.titulo_obra = '$bd_titulo_obra')
        LIMIT 5";
        $res = $conn->query($sql);

        $adquisicionesLista = [];
        while ($fila = $res->fetch_assoc()) {
            $adquisicionesLista[] = $fila;
        }
        return $adquisicionesLista;
    }

    public static function crear($editorial_id, $titulo_obra, $cantidad, $fecha_adquisicion, $costo_unitario, $estado)
    {
        $conn = Conexion::conectar();
        $bd_editorial_id = $conn->real_escape_string($editorial_id);
        $bd_titulo_obra = $conn->real_escape_string($titulo_obra);
        $bd_cantidad = $conn->real_escape_string($cantidad);
        $bd_fecha_adquisicion = $conn->real_escape_string($fecha_adquisicion);
        $bd_costo_unitario = $conn->real_escape_string($costo_unitario);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "INSERT INTO adquisiciones (editorial_id, titulo_obra, cantidad, fecha_adquisicion, costo_unitario, estado) VALUES ('$bd_editorial_id', '$bd_titulo_obra', '$bd_cantidad', '$bd_fecha_adquisicion', '$bd_costo_unitario', '$bd_estado')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $editorial_id, $titulo_obra, $cantidad, $fecha_adquisicion, $costo_unitario, $estado)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_editorial_id = $conn->real_escape_string($editorial_id);
        $bd_titulo_obra = $conn->real_escape_string($titulo_obra);
        $bd_cantidad = $conn->real_escape_string($cantidad);
        $bd_fecha_adquisicion = $conn->real_escape_string($fecha_adquisicion);
        $bd_costo_unitario = $conn->real_escape_string($costo_unitario);
        $bd_estado = $conn->real_escape_string($estado);

        $sql = "UPDATE adquisiciones SET editorial_id='$bd_editorial_id',titulo_obra='$bd_titulo_obra',cantidad='$bd_cantidad',fecha_adquisicion='$bd_fecha_adquisicion',costo_unitario='$bd_costo_unitario',estado='$bd_estado' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM adquisiciones WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>