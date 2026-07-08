<?php
class Conexion
{
    public static function conectar()
    {
        // Detecta automaticamente el entorno segun el dominio desde el
        // que se esta accediendo (localhost/127.0.0.1 = XAMPP local,
        // cualquier otro = InfinityFree en produccion).
        $host_actual = $_SERVER['HTTP_HOST'] ?? '';
        $esLocal = (strpos($host_actual, 'localhost') !== false)
                || (strpos($host_actual, '127.0.0.1') !== false);

        if ($esLocal) {
            // ---------- Configuracion LOCAL (XAMPP) ----------
            $host    = "127.0.0.1";
            $bd      = "biblioteca_escolar";
            $usuario = "root";
            $clave   = "";
            $puerto  = "3306";
        } else {
            // ---------- Configuracion PRODUCCION (InfinityFree) ----------
            $host    = "sql112.infinityfree.com";
            $bd      = "if0_42359828_biblioteca_escolar";
            $usuario = "if0_42359828";
            $clave   = "bibliotecaUG";
            $puerto  = "3306";
        }

        $conn = new mysqli($host, $usuario, $clave, $bd, (int) $puerto);

        if ($conn->connect_error) {
            die("Error de conexion: " . $conn->connect_error);
        }

        $conn->set_charset('utf8mb4');

        return $conn;
    }
}