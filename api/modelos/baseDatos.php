<?php
// api/models/Database.php

class Database
{
    private $host = 'localhost'; // o tu host de BD
    private $db_name = 'sistema_firmas'; // el nombre de tu BD
    private $username = 'root'; // tu usuario de BD
    private $password = ''; // tu contraseña de BD
    protected $conn;

    // Obtener la conexión a la base de datos
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8',
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error de Conexión: ' . $e->getMessage();
        }
        return $this->conn;
    }
}