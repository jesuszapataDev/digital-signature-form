<?php
// En /api/controllers/PdfController.php

// Importar Dompdf
require_once __DIR__ . '/../../vendor/autoload.php'; // Ajusta la ruta a tu 'autoload.php' de Composer
use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../modelos/AcuerdosModelo.php';

class PdfController
{

    public function generarPdfAcuerdo($acuerdo_id)
    {
        // 1. Obtener los datos completos del acuerdo desde el modelo
        $acuerdoModel = new AcuerdosModelo();
        $datos_acuerdo = $acuerdoModel->findAcuerdoCompleto($acuerdo_id);

        if (!$datos_acuerdo) {
            die("Acuerdo no encontrado");
        }

        // 2. Cargar el HTML de la plantilla en una variable
        // (ob_start y ob_get_clean son una forma limpia de hacer esto)
        ob_start();
        require __DIR__ . '/../templates/pdf-template.php';
        $html = ob_get_clean();

        // 3. Configurar e instanciar Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes desde URLs
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Enviar el PDF al navegador
        // El segundo parámetro false hace que se muestre en el navegador en lugar de descargarse
        $dompdf->stream("acuerdo-" . $acuerdo_id . ".pdf", ["Attachment" => false]);
    }
}