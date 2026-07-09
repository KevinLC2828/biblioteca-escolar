<?php

require_once __DIR__ . "/../config/conexion.php";

class empleado{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT id, nombres, apellidos, cargo, telefono, email FROM empleados ORDER BY id DESC";
        $res = $conn->query($sql);

        $empleados = [];
        while ($fila = $res->fetch_assoc()) {
            $empleados[] = $fila;
        }
        return $empleados;
    }

    public static function busqueda($id, $nombres, $apellidos)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombres = $conn->real_escape_string($nombres);
        $bd_apellidos = $conn->real_escape_string($apellidos);

        $sql = "SELECT id, nombres, apellidos, cargo, telefono, email
                FROM empleados
                WHERE id = '$bd_id' OR nombres = '$bd_nombres' OR apellidos = '$bd_apellidos'
                LIMIT 5";
        $res = $conn->query($sql);

        $empleados = [];
        while ($fila = $res->fetch_assoc()) {
            $empleados[] = $fila;
        }
        return $empleados; //retorna null si no existe
    }

    public static function crear($nombres, $apellidos, $cargo, $telefono, $email)
    {
        $conn = Conexion::conectar();
        $bd_nombres = $conn->real_escape_string($nombres);
        $bd_apellidos = $conn->real_escape_string($apellidos);
        $bd_cargo = $conn->real_escape_string($cargo);
        $bd_telefono = $conn->real_escape_string($telefono);
        $bd_email = $conn->real_escape_string($email);

        $sql = "INSERT INTO empleados (nombres, apellidos, cargo, telefono, email) VALUES ('$bd_nombres', '$bd_apellidos', '$bd_cargo', '$bd_telefono', '$bd_email')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $nombres, $apellidos, $cargo, $telefono, $email)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_nombres = $conn->real_escape_string($nombres);
        $bd_apellidos = $conn->real_escape_string($apellidos);
        $bd_cargo = $conn->real_escape_string($cargo);
        $bd_telefono = $conn->real_escape_string($telefono);
        $bd_email = $conn->real_escape_string($email);

        $sql = "UPDATE empleados SET nombres='$bd_nombres',apellidos='$bd_apellidos',cargo='$bd_cargo',telefono='$bd_telefono',email='$bd_email' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM empleados WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>