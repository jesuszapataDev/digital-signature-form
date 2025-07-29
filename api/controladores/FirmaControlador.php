<?php
require_once __DIR__ . '/../modelos/FirmaModelo.php';
require_once __DIR__ . '/../configuraciones/baseDatos.php';
require_once __DIR__ . '/../auxiliares/ClientEnvironmentInfo.php';
require_once __DIR__ . '/../auxiliares/TimezoneManager.php';

class FirmaControlador
{
    public static function guardarFirma(array $datos)
    {
        if (
            !isset($datos['acuerdo_id']) ||
            !isset($datos['participante_id']) ||
            !isset($datos['decision']) ||
            !isset($datos['firma_base64'])
        ) {
            return ['estado' => 'error', 'mensaje' => 'Faltan datos requeridos.', 'status' => 400];
        }

        $acuerdoId = intval($datos['acuerdo_id']);
        $participanteId = intval($datos['participante_id']);
        $decision = $datos['decision'];
        $firmaBase64 = $datos['firma_base64'];

        if (FirmaModelo::yaFirmo($acuerdoId, $participanteId)) {
            return ['estado' => 'error', 'mensaje' => 'Este participante ya ha firmado este acuerdo.', 'status' => 409];
        }

        // Guardar firma como imagen
        $nombreArchivo = "firmas_{$acuerdoId}_{$participanteId}.png";
        $rutaRelativa = "/../../uploads/firmas/$nombreArchivo";
        $rutaCompleta = __DIR__ . "/$rutaRelativa";

        if (!is_dir(dirname($rutaCompleta))) {
            mkdir(dirname($rutaCompleta), 0775, true);
        }

        $firmaLimpia = preg_replace('#^data:image/\w+;base64,#i', '', $firmaBase64);
        $datosImagen = base64_decode($firmaLimpia);

        if (!$datosImagen || !@imagecreatefromstring($datosImagen)) {
            return ['estado' => 'error', 'mensaje' => 'La imagen de la firma es inválida.', 'status' => 400];
        }

        if (!file_put_contents($rutaCompleta, $datosImagen)) {
            return ['estado' => 'error', 'mensaje' => 'No se pudo guardar la firma.', 'status' => 500];
        }

        // Preparar metadatos
        $db = (new Database())->connect();
        $env = new ClientEnvironmentInfo();
        (new TimezoneManager($db))->applyTimezone();

        $fechaFirma = $env->getCurrentDatetime();
        $metadatos = $env->getAllClientMetadata();

        // Guardar en la base de datos
        $resultado = FirmaModelo::guardar($db, [
            'acuerdo_id' => $acuerdoId,
            'participante_id' => $participanteId,
            'decision' => $decision,
            'ruta_firma' => $rutaRelativa,
            'fecha_firma' => $fechaFirma
        ], $metadatos);

        return [
            'estado' => $resultado['estado'],
            'mensaje' => $resultado['mensaje'],
            'status' => $resultado['estado'] === 'exito' ? 201 : 500
        ];
    }
}
