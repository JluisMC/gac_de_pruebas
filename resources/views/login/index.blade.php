<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAC - Ingreso de Usuario</title>

    <link rel="preconnect" href="https://lh3.googleusercontent.com">
    <link rel="dns-prefetch" href="https://lh3.googleusercontent.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="tabla_principal">

        <header class="header-container">
            <img class="agent-img" src="/img/banner.png" alt="Banner GAC" fetchpriority="high">
        </header>

        <div class="barra-divisoria"></div>

        <main class="flex-grow-1 d-flex justify-content-center align-items-center py-5">
            <div class="cuadro-login">

                <!-- Formulario conectado a la ruta de Login -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <span class="output_datos">Ingreso</span>
                    </div>

                    <!-- Mensaje de Error en caso de Credenciales Inválidas -->
                    @if ($errors->any())
                        <div class="alert alert-danger p-1 text-center style="font-size: 11px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-2 row align-items-center">
                        <label for="txtUsuario" class="col-4 text-end pe-1 output_datos">Usuario:</label>
                        <div class="col-8">
                            <input id="txtUsuario" name="username" type="text" class="inputText w-100"
                                value="{{ old('username') }}" style="text-transform: uppercase;" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label for="txtClave" class="col-4 text-end pe-1 output_datos">Clave:</label>
                        <div class="col-8">
                            <input id="txtClave" name="password" type="password" class="inputSecret w-100" required>
                        </div>
                    </div>

                    <div class="text-end mb-2">
                        <button type="submit" class="btnOpc">Ingresar</button>
                    </div>

                    <div class="text-start ms-1">
                        <a href="#" class="commandLink">Cambiar contraseña</a>
                    </div>

                </form>
            </div>
        </main>

        <footer class="pie-pagina"></footer>

    </div>

</body>

</html>
