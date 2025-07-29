<?php
// api/models/UsuarioModelo.php
require_once 'baseDatos.php';

class UsuarioModelo extends Database
{
    private $table_name = "usuarios";

    // CREATE: Crea un nuevo usuario
    public function create($nombre, $rol, $codigo, $admin_id)
    {
        $query = "INSERT INTO " . $this->table_name . " (nombre_completo, rol, codigo_acceso, creado_por) VALUES (:nombre, :rol, :codigo, :admin_id)";

        $this->connect();
        $stmt = $this->conn->prepare($query);

        // 1. Limpia los datos y guárdalos en nuevas variables
        $nombre_limpio = htmlspecialchars(strip_tags($nombre));
        $rol_limpio = htmlspecialchars(strip_tags($rol));

        // 2. Ahora, pasa las variables limpias a bindParam()
        $stmt->bindParam(':nombre', $nombre_limpio);
        $stmt->bindParam(':rol', $rol_limpio);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':admin_id', $admin_id);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // READ: Obtiene todos los usuarios
    public function findAll()
    {
        $query = "SELECT id, nombre_completo, rol, fecha_creacion FROM " . $this->table_name;
        $this->connect();
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ: Obtiene un usuario por su ID
    public function findById($id)
    {
        $query = "SELECT id, nombre_completo, rol, codigo_acceso, fecha_creacion FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $this->connect();
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // READ: Obtiene un usuario por su código de acceso
    public function findByCodigo($codigo)
    {
        $query = "SELECT id, nombre_completo, rol FROM " . $this->table_name . " WHERE codigo_acceso = :codigo LIMIT 1";
        $this->connect();
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE: Actualiza los datos de un usuario por su ID
    public function update($id, $nombre, $rol)
    {
        $query = "UPDATE " . $this->table_name . " SET nombre_completo = :nombre, rol = :rol WHERE id = :id";

        $this->connect();
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        // 1. Limpia los datos y guárdalos en nuevas variables
        $nombre_limpio = htmlspecialchars(strip_tags($nombre));
        $rol_limpio = htmlspecialchars(strip_tags($rol));

        // 2. Ahora, pasa las variables limpias a bindParam()
        $stmt->bindParam(':nombre', $nombre_limpio);
        $stmt->bindParam(':rol', $rol_limpio);

        return $stmt->execute();
    }

    // DELETE: Elimina un usuario por su ID
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $this->connect();
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}