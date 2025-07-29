<?php
// api/models/AcuerdosModelo.php
require_once 'baseDatos.php';

class AcuerdosModelo extends Database
{

    public function findAcuerdoCompleto($id)
    {
        $acuerdo = [];
        $this->connect();

        // 1. Obtener los detalles del acuerdo
        $stmt_acuerdo = $this->conn->prepare("SELECT * FROM acuerdos WHERE id = :id");
        $stmt_acuerdo->bindParam(':id', $id);
        $stmt_acuerdo->execute();
        $acuerdo['detalles'] = $stmt_acuerdo->fetch(PDO::FETCH_ASSOC);

        if (!$acuerdo['detalles'])
            return null;

        // 2. Obtener TODOS los participantes, con o sin firma
        $query_participantes = "
        SELECT 
            u.id, u.nombre_completo,
            f.decision, f.ruta_firma, f.fecha_firma,
            m.*
        FROM usuarios u
        LEFT JOIN firmas f ON u.id = f.participante_id AND f.acuerdo_id = :id
        LEFT JOIN metadatos_firma m ON f.id = m.firma_id
        WHERE u.rol = 'participante'
        ORDER BY u.id
    ";
        $stmt_participantes = $this->conn->prepare($query_participantes);
        $stmt_participantes->bindParam(':id', $id);
        $stmt_participantes->execute();
        $acuerdo['participantes'] = $stmt_participantes->fetchAll(PDO::FETCH_ASSOC);

        return $acuerdo;
    }
}