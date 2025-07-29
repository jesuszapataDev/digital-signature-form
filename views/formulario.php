<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acuerdo de Rifa - Firma Digital</title>

  <link rel="shortcut icon" href="../assets/images/favicon.ico">

  <script src="../assets/js/head.js"></script>

  <!-- Bootstrap css -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style">

  <!-- App css -->
  <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css">

  <!-- Icons css -->
  <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">

  <!-- sweetalertw -->
  <link rel="stylesheet" href="../assets/libs/sweetalert2/sweetalert2.min.css">


  <style>
    body {
      background-color: #f8f9fa;
    }

    .header-actions {
      background-color: #fff;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .participant-row {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 1rem;
      padding: 1rem;
      transition: opacity 0.3s ease;
    }

    .participant-row .name {
      flex-grow: 1;
      font-weight: 500;
    }

    .signature-link {
      font-weight: bold;
      color: #0d6efd;
      cursor: pointer;
      text-decoration: underline;
    }

    .participant-row.firmado {
      background-color: #e9ecef;
      opacity: 0.7;
    }

    .participant-row.firmado .btn-group,
    .participant-row.firmado .signature-link {
      pointer-events: none;
    }

    .participant-row.deshabilitado {
      opacity: 0.5;
      pointer-events: none;
      background-color: #f8f9fa;
    }

    #signature-pad {
      border: 1px dashed #6c757d;
      border-radius: 0.25rem;
      cursor: crosshair;
    }

    .modal-header {}

    .decision-modal-container {
      border-top: 1px solid #eee;
      margin-top: 1rem;
      padding-top: 1rem;
    }
  </style>
</head>

<body>
  <div class="container my-4">
    <div class="header-actions d-flex justify-content-end gap-2">
      <button class="btn btn-success" onclick="compartirFormulario()">
        <i class="fas fa-share-alt"></i> Compartir
      </button>
      <button type="button" class="btn btn-secondary" onclick="copiarEnlaceAlPortapapeles('URL_PARA_COPIAR')">
        <i class="fas fa-copy"></i> Copiar Enlace
      </button>

      <button class="btn btn-danger"><i class="fas fa-file-pdf"></i> Descargar PDF</button>
    </div>


    <div class="card">
      <div class="card-header">
        <div class="text-center mb-4">
          <h1 class="h3">Acuerdo Legal - Distribución de Herencia por Rifa</h1>
          <p class="lead">Bienvenido. Por favor, marque su decisión y firme para registrar su conformidad.</p>
        </div>
        <h5 class="card-title mb-0">Lista de Participantes</h5>
      </div>
      <div class="card-body">
        <div class="list-group" id="lista-participantes"></div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="signatureModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Realizar Firma</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Firmando como: <strong id="modalParticipantName"></strong></p>
          <p class="text-muted small">Por favor, firme en el recuadro.</p>
          <canvas id="signature-pad" width="460" height="200"></canvas>

          <div class="decision-modal-container text-center">
            <p class="mb-2 fw-bold">Confirme o cambie su decisión:</p>
            <div class="btn-group" role="group">
              <input type="radio" class="btn-check" name="decision-modal" id="decision-modal-si" autocomplete="off">
              <label class="btn btn-outline-primary px-4" for="decision-modal-si">Sí</label>
              <input type="radio" class="btn-check" name="decision-modal" id="decision-modal-no" autocomplete="off">
              <label class="btn btn-outline-secondary px-4" for="decision-modal-no">No</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" onclick="limpiarFirma()">Limpiar Firma</button>
          <button type="button" class="btn btn-primary" onclick="guardarFirma()">Guardar Firma</button>
        </div>
      </div>
    </div>
  </div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/signature-pad.js"></script>

  <script src="../assets/js/vendor.min.js"></script>
  <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <script src="../assets/js/app.min.js"></script>
<script>
  
(function() {
  function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0,
          v = c == 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }

  if (!document.cookie.includes('device_id=')) {
    const id = generateUUID();
    document.cookie = "device_id=" + id + "; path=/; max-age=" + (60*60*24*365*2);
  }
})();

</script>
  <script>
    const participantes = [
      "José Reyes Pérez Muñoz", "Patricia Pérez Muñoz", "Silvia Pérez Muñoz", "José Abel Pérez Muñoz",
      "Verónica Pérez Muñoz", "Mario Pérez Muñoz", "Antonia Pérez Muñoz", "Virginia Pérez Muñoz",
      "Leonardo Pérez Muñoz", "Miguel Pérez Muñoz", "Abraham Pérez Muñoz", "Saúl Pérez Muñoz", "Angélica Pérez Muñoz"
    ];
    let currentParticipantId = null;
    const signaturePad = new SignaturePad(document.getElementById('signature-pad'));

    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      const loggedInParticipantId = parseInt(urlParams.get('participante'), 10);

      if (!loggedInParticipantId) {
        window.location.href = 'login.html';
        return;
      }

      const listaContainer = document.getElementById('lista-participantes');
      participantes.forEach((nombre, index) => {
        const id = index + 1;
        const row = document.createElement('div');
        row.className = 'list-group-item participant-row';
        row.id = `participante-${id}`;
        row.innerHTML = `
                    <div class="name">${id}. ${nombre}</div>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="decision-${id}" id="decision-${id}-si" autocomplete="off">
                        <label class="btn btn-outline-primary" for="decision-${id}-si">Sí</label>
                        <input type="radio" class="btn-check" name="decision-${id}" id="decision-${id}-no" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="decision-${id}-no">No</label>
                    </div>
                    <div class="signature-link" onclick="prepararFirma(${id}, '${nombre}')">
                        <i class="fas fa-pencil-alt"></i> Firma aquí
                    </div>
                `;
        listaContainer.appendChild(row);

        if (id !== loggedInParticipantId) {
          row.classList.add('deshabilitado');
        }
      });
    });

    function prepararFirma(id, nombre) {
      currentParticipantId = id;
      document.getElementById('modalParticipantName').textContent = nombre;
      signaturePad.clear();

      // Sincronizar la decisión del formulario con el modal
      const decisionForm = document.querySelector(`input[name="decision-${id}"]:checked`);
      if (decisionForm) {
        if (decisionForm.id.includes('-si')) {
          document.getElementById('decision-modal-si').checked = true;
        } else {
          document.getElementById('decision-modal-no').checked = true;
        }
      } else {
        // Si no hay nada seleccionado, limpiar la selección en el modal
        document.getElementById('decision-modal-si').checked = false;
        document.getElementById('decision-modal-no').checked = false;
      }

      // Abrir el modal de Bootstrap
      const signatureModal = new bootstrap.Modal(document.getElementById('signatureModal'));
      signatureModal.show();
    }

    function limpiarFirma() {
      signaturePad.clear();
    }

 function guardarFirma() {
  const decisionModal = $('input[name="decision-modal"]:checked');

  if (decisionModal.length === 0) {
    Swal.fire({
      icon: 'error',
      title: 'Opción no seleccionada',
      text: 'Debes seleccionar "Sí" o "No" antes de guardar.'
    });
    return;
  }

  if (signaturePad.isEmpty()) {
    Swal.fire({
      icon: 'error',
      title: 'Firma vacía',
      text: 'Por favor, proporciona tu firma en el recuadro.'
    });
    return;
  }

  const decisionTexto = decisionModal.attr('id').includes('-si') ? 'sí' : 'no';
  const decisionClase = decisionModal.attr('id').includes('-si') ? 'text-success' : 'text-danger';

  Swal.fire({
    title: '¿Confirmar y Guardar?',
    html: `Has seleccionado: <strong class="${decisionClase}">${decisionTexto.toUpperCase()}</strong>.<br><br>Esta acción es final y <strong>no se podrá modificar</strong>.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#0d6efd',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Sí, guardar',
    cancelButtonText: 'Cancelar'
  }).then(result => {
    if (result.isConfirmed) {
      const firmaBase64 = signaturePad.toDataURL('image/png');

      const acuerdoId = 1; // Estático por ahora, puedes hacerlo dinámico
      const participanteId = currentParticipantId;

      const payload = {
        acuerdo_id: acuerdoId,
        participante_id: participanteId,
        decision: decisionTexto,
        firma_base64: firmaBase64
      };

      console.log('📤 Enviando datos de firma:', payload);

const formData = new FormData();
formData.append('accion', 'guardar_firma');
formData.append('acuerdo_id', acuerdoId);
formData.append('participante_id', participanteId);
formData.append('decision', decisionTexto);
formData.append('firma_base64', firmaBase64);

$.ajax({
  url: '../api/ajax/firma.ajax.php',
  method: 'POST',
  data: formData,
  processData: false,
  contentType: false,
  dataType: 'json',
  success: function (data) {
    console.log('✅ Respuesta del servidor:', data);

    if (data.mensaje) {
      const modal = bootstrap.Modal.getInstance(document.getElementById('signatureModal'));
      modal.hide();

      const row = document.getElementById(`participante-${participanteId}`);
      if (row) {
        row.classList.add('firmado');
        const link = row.querySelector('.signature-link');
        if (link) link.innerHTML = '<i class="fas fa-check"></i> Firmado';
      }

      const finalDecisionId = `decision-${participanteId}-${decisionTexto.toLowerCase()}`;
      const radio = document.getElementById(finalDecisionId);
      if (radio) radio.checked = true;

      Swal.fire('¡Firmado!', data.mensaje, 'success');
    } else if (data.error) {
      Swal.fire('Error', data.error, 'error');
    } else {
      Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
    }
  },
  error: function (xhr, status, error) {
    console.error('❌ Error AJAX:', {
      status,
      error,
      response: xhr.responseText
    });
    Swal.fire('Error', 'No se pudo conectar con el servidor. Intenta más tarde.', 'error');
  }
});

    }
  });
}

    // Añade esta función a tu bloque <script> en formulario.html

    function compartirFormulario() {
      // --- IMPORTANTE: Cambia esta URL por la de tu sitio en producción ---
      // La URL debe apuntar a la página de login, ya que cada usuario necesita su código.
      const urlParaCompartir = 'http://tusitio.com/login';

      const datosParaCompartir = {
        title: 'Acuerdo Legal por Rifa',
        text: 'Por favor, ingresa con tu clave para firmar el acuerdo de la rifa:',
        url: urlParaCompartir,
      };

      // --- Método 1: Usar la API Web Share (la mejor opción en móviles) ---
      if (navigator.share) {
        navigator.share(datosParaCompartir)
          .then(() => console.log('Contenido compartido exitosamente'))
          .catch((error) => console.error('Error al compartir:', error));
      } else {
        // --- Método 2: Fallback con SweetAlert2 para navegadores no compatibles ---
        const textoCodificado = encodeURIComponent(`${datosParaCompartir.text} ${datosParaCompartir.url}`);

        Swal.fire({
          title: 'Compartir Formulario',
          html: `
                <p>Usa una de las siguientes opciones para compartir el enlace de acceso:</p>
                <div class="d-grid gap-2">
                    <a href="httpsa://wa.me/?text=${textoCodificado}" target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i> Compartir por WhatsApp
                    </a>
                    <a href="sms:?body=${textoCodificado}" class="btn btn-primary">
                        <i class="fas fa-comment-sms"></i> Compartir por SMS
                    </a>
                    <button class="btn btn-secondary" onclick="copiarEnlaceAlPortapapeles('${datosParaCompartir.url}')">
                        <i class="fas fa-copy"></i> Copiar Enlace
                    </button>
                </div>
            `,
          showConfirmButton: false,
          showCloseButton: true
        });
      }
    }

    // Función auxiliar para el botón de copiar enlace
    function copiarEnlaceAlPortapapeles(enlace) {
      navigator.clipboard.writeText(enlace).then(() => {
        Swal.fire({
          icon: 'success',
          title: '¡Enlace Copiado!',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          backdrop: false,
          timer: 2000
        });
      }).catch(err => {
        console.error('Error al copiar el enlace: ', err);
        Swal.fire('Error', 'No se pudo copiar el enlace.', 'error');
      });
    }
  </script>
</body>

</html>