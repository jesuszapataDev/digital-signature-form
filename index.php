<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Acuerdo de Firma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="login-card text-center">
        <h1 class="h3 mb-3 fw-normal">Acceso al Acuerdo</h1>
        <p class="text-muted mb-4">Introduce tu clave secreta personal para acceder.</p>

        <form onsubmit="realizarLogin(event)">
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="claveSecreta" placeholder="Clave Secreta">
                <label for="claveSecreta">Clave Secreta</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>
        </form>
        <p class="mt-4 text-muted small">Al ingresar, serás redirigido al formulario de firma.</p>
    </div>

    <script>
        function realizarLogin(event) {
            event.preventDefault(); // Previene el envío real del formulario

            // --- LÓGICA DE BACKEND (SIMULADA AQUÍ) ---
            // 1. Obtienes la clave del input.
            const clave = document.getElementById('claveSecreta').value;

            // 2. Enviarías la 'clave' a un endpoint PHP (ej: /api/login).
            //    El backend validaría la clave y devolvería el ID del participante.
            //    Por ahora, vamos a simular que la clave corresponde al participante #2.

            const participanteId = 2; // ID que el backend debería devolver.

            if (clave === "") {
                alert("Por favor, introduce una clave.");
                return;
            }

            // 3. Rediriges al usuario al formulario, pasando el ID en la URL.
            window.location.href = `formulario.php?participante=${participanteId}`;
        }
    </script>
</body>

</html>