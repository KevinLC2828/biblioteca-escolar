<?php

require_once __DIR__ . "/../config/conexion.php";

class libro{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT id, titulo, autor, editorial, anio_publicacion, isbn, stock FROM libros";
        $res = $conn->query($sql);

        $libros = [];
        while ($fila = $res->fetch_assoc()) {
            $libros[] = $fila;
        }
        return $libros;
    }

    public static function busqueda($id, $titulo, $autor)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_titulo = $conn->real_escape_string($titulo);
        $bd_autor = $conn->real_escape_string($autor);


        $sql = "SELECT 
                    id, titulo, autor, editorial, anio_publicacion, isbn, stock 
                FROM libros
                WHERE 
                    id = '$bd_id' OR titulo = '$bd_titulo' OR autor = '$bd_autor' 
                LIMIT 5";
        $res = $conn->query($sql);

        $libros = [];
        while ($fila = $res->fetch_assoc()) {
            $libros[] = $fila;
        }
        return $libros; //retorna null si no existe
    }

    public static function crear($titulo, $autor, $editorial, $año_pub, $isbn, $stock)
    {
        $conn = Conexion::conectar();
        $bd_titulo = $conn->real_escape_string($titulo);
        $bd_autor = $conn->real_escape_string($autor);
        $bd_editorial = $conn->real_escape_string($editorial);
        $bd_año_pub = $conn->real_escape_string($año_pub);
        $bd_isbn = $conn->real_escape_string($isbn);
        $bd_stock = $conn->real_escape_string($stock);

        $sql = "INSERT INTO libros (titulo, autor, editorial, anio_publicacion, isbn, stock) VALUES ('$bd_titulo', '$bd_autor', '$bd_editorial', '$bd_año_pub', '$bd_isbn', '$bd_stock')";
        return $conn->query($sql);
    }

    public static function actualizar($id, $titulo, $autor, $editorial, $año_pub, $isbn, $stock)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;
        $bd_titulo = $conn->real_escape_string($titulo);
        $bd_autor = $conn->real_escape_string($autor);
        $bd_editorial = $conn->real_escape_string($editorial);
        $bd_año_pub = $conn->real_escape_string($año_pub);
        $bd_isbn = $conn->real_escape_string($isbn);
        $bd_stock = $conn->real_escape_string($stock);

        $sql = "UPDATE libros SET titulo='$bd_titulo',autor='$bd_autor' , editorial='$bd_editorial', anio_publicacion='$bd_año_pub', isbn='$bd_isbn', stock='$bd_stock' WHERE id='$bd_id'";
        return $conn->query($sql);
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $bd_id = (int)$id;

        $sql = "DELETE FROM libros WHERE id='$bd_id'";
        return $conn->query($sql);
    }

}

?>