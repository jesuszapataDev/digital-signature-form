<?php
require_once __DIR__ . '/../configuraciones/baseDatos.php';

class FirmaModelo
{
    public static function yaFirmo(int $acuerdoId, int $participanteId): bool
    {
        $db = (new Database())->connect();
        $sql = "SELECT COUNT(*) FROM firmas WHERE acuerdo_id = :acuerdo_id AND participante_id = :participante_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':acuerdo_id', $acuerdoId, PDO::PARAM_INT);
        $stmt->bindParam(':participante_id', $participanteId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public static function guardar(PDO $conexion, array $datos, array $meta): array
    {
        try {
            $conexion->beginTransaction();

            // 1. Insertar en firmas
            $sqlFirma = "INSERT INTO firmas (
                acuerdo_id, participante_id, decision, ruta_firma, fecha_firma
            ) VALUES (
                :acuerdo_id, :participante_id, :decision, :ruta_firma, :fecha_firma
            )";
            $stmt = $conexion->prepare($sqlFirma);
            $stmt->execute([
                ':acuerdo_id'      => $datos['acuerdo_id'],
                ':participante_id' => $datos['participante_id'],
                ':decision'        => $datos['decision'],
                ':ruta_firma'      => $datos['ruta_firma'],
                ':fecha_firma'     => $datos['fecha_firma'],
            ]);

            // Obtener el ID de la firma insertada
            $firmaId = $conexion->lastInsertId();

            // 2. Insertar en metadatos_firma
            $sqlMeta = "INSERT INTO metadatos_firma (
                firma_id, ip, pais, region, ciudad, codigo_postal, coordenadas,
                zona_horaria, geo_ip_timestamp, dominio, hostname,
                sistema_operativo, navegador, user_agent, dispositivo,
                request_uri, server_hostname, device_id
            ) VALUES (
                :firma_id, :ip, :pais, :region, :ciudad, :codigo_postal, :coordenadas,
                :zona_horaria, :geo_ip_timestamp, :dominio, :hostname,
                :sistema_operativo, :navegador, :user_agent, :dispositivo,
                :request_uri, :server_hostname, :device_id
            )";
            $stmtMeta = $conexion->prepare($sqlMeta);
            $stmtMeta->execute([
                ':firma_id'         => $firmaId,
                ':ip'               => $meta['ip'],
                ':pais'             => $meta['pais'],
                ':region'           => $meta['region'],
                ':ciudad'           => $meta['ciudad'],
                ':codigo_postal'    => $meta['codigo_postal'],
                ':coordenadas'      => $meta['coordenadas'],
                ':zona_horaria'     => $meta['zona_horaria'],
                ':geo_ip_timestamp' => $meta['geo_ip_timestamp'],
                ':dominio'          => $meta['dominio'],
                ':hostname'         => $meta['hostname'],
                ':sistema_operativo'=> $meta['sistema_operativo'],
                ':navegador'        => $meta['navegador'],
                ':user_agent'       => $meta['user_agent'],
                ':dispositivo'      => $meta['dispositivo'],
                ':request_uri'      => $meta['request_uri'],
                ':server_hostname'  => $meta['server_hostname'],
                ':device_id'        => $meta['device_id'] ?? null
            ]);

            $conexion->commit();
            return ['estado' => 'exito', 'mensaje' => 'Firma guardada con éxito'];
        } catch (PDOException $e) {
            $conexion->rollBack();
            error_log("❌ Error al guardar firma: " . $e->getMessage());
            return ['estado' => 'error', 'mensaje' => 'Error al guardar la firma'];
        }
    }
}
