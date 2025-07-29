<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acuerdo de Rifa</title>
    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1,
        h2 {
            text-align: center;
        }

        .agreement-text {
            text-align: justify;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .signature-img {
            width: 150px;
            height: auto;
        }

        .page-break {
            page-break-after: always;
        }

        .evidence-block {
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 20px;
        }

        .evidence-block h3 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <h1><?php echo htmlspecialchars($datos_acuerdo['detalles']['titulo']); ?></h1>
    <p class="agreement-text"><?php echo htmlspecialchars($datos_acuerdo['detalles']['descripcion']); ?></p>

    <h2>Registro de Firmas</h2>
    <table>
        <thead>
            <tr>
                <th>Participante</th>
                <th>Decisión</th>
                <th>Firma</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos_acuerdo['participantes'] as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['nombre_completo']); ?></td>
                    <td>
                        <?php if ($p['decision'] === 'sí' || $p['decision'] === 'no'): ?>
                            <strong><?php echo strtoupper(htmlspecialchars($p['decision'])); ?></strong>
                        <?php else: ?>
                            <em>Pendiente de firma</em>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($p['ruta_firma']): ?>
                            <img src="<?php echo htmlspecialchars($p['ruta_firma']); ?>" class="signature-img">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="page-break"></div>

    <?php foreach ($datos_acuerdo['participantes'] as $p): ?>
        <?php if ($p['fecha_firma']): // Solo generar página si ha firmado ?>

            <h2>Evidencia de Firma Digital</h2>
            <div class="evidence-block">
                <h3>Datos del Firmante</h3>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($p['nombre_completo']); ?></p>
                <p><strong>Decisión:</strong> <?php echo strtoupper(htmlspecialchars($p['decision'])); ?></p>
                <p><strong>Fecha y Hora:</strong> <?php echo date("d/m/Y h:i:s A", strtotime($p['fecha_firma'])); ?></p>
                <p><strong>Firma Registrada:</strong></p>
                <img src="<?php echo htmlspecialchars($p['ruta_firma']); ?>" class="signature-img">
            </div>

            <div class="evidence-block">
                <h3>Evidencia Técnica y Geográfica</h3>
                <p><strong>Dirección IP:</strong> <?php echo htmlspecialchars($p['ip']); ?></p>
                <p><strong>Ubicación (País, Región, Ciudad):</strong>
                    <?php echo htmlspecialchars(implode(', ', [$p['pais'], $p['region'], $p['ciudad']])); ?></p>
                <p><strong>Coordenadas (Lat, Long):</strong> <?php echo htmlspecialchars($p['coordenadas']); ?></p>
                <p><strong>Dispositivo:</strong> <?php echo htmlspecialchars($p['dispositivo']); ?></p>
                <p><strong>User Agent:</strong> <?php echo htmlspecialchars($p['user_agent']); ?></p>
            </div>

            <div class="page-break"></div>

        <?php endif; ?>
    <?php endforeach; ?>

</body>

</html>