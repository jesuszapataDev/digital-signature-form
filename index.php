<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Acuerdo de Firma</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/js/head.js"></script>

    <!-- Bootstrap css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style">

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="assets/libs/sweetalert2/sweetalert2.min.css">


</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-brand">
                                    <a href="index.html" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="assets/images/logo-dark.png" alt="" height="22">
                                        </span>
                                    </a>

                                    <a href="index.html" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="assets/images/logo-light.png" alt="" height="22">
                                        </span>
                                    </a>
                                </div>
                                <h1 class="h3 mb-3 fw-normal">Acceso al Acuerdo</h1>
                                <p class="text-muted mb-4">Introduce tu clave secreta personal para acceder.</p>
                            </div>



                            <form onsubmit="realizarLogin(event)">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="claveSecreta"
                                        placeholder="Clave Secreta">
                                    <label for="claveSecreta">Clave Secreta</label>
                                </div>
                                <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>
                            </form>
                            <p class="mt-4 text-muted small">Al ingresar, serás redirigido al formulario de firma.</p>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="auth-recoverpw.html" class="text-white-50 ms-1">Forgot your password?</a></p>
                            <p class="text-white-50">Don't have an account? <a href="auth-register.html"
                                    class="text-white ms-1"><b>Sign Up</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>



    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <script>
        function realizarLogin(event) {
            event.preventDefault(); // Previene el envío real del formulario

            const clave = document.getElementById('claveSecreta').value;

            // 1. Validar si el campo está vacío usando SweetAlert2
            if (clave === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Campo Vacío',
                    text: 'Por favor, introduce una clave para continuar.'
                });
                return;
            }

            // 2. Simular carga mientras se verifica la clave
            Swal.fire({
                title: 'Verificando...',
                text: 'Por favor, espera.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // 3. Simular la llamada a la API y la redirección
            // En una aplicación real, aquí harías la llamada fetch() al /api/login
            // y la redirección estaría en el .then() de la promesa.
            setTimeout(() => {
                const participanteId = 4; // ID que el backend debería devolver.
                window.location.href = `ciews/formulario?participante=${participanteId}`;
            }, 1500); // Pequeño retraso para que la animación de carga sea visible
        }
    </script>
</body>

</html>