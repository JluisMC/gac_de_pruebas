<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAC - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main2.css') }}">

    @yield('styles')
</head>

<body>

    <div class="tabla_principal">

        <!-- Encabezado con banner/imágenes -->
        <header class="header-container">
            <img class="agent-img" src="/img/banner.png" alt="Banner GAC" fetchpriority="high">
        </header>

        <!-- Barra divisoria con menú superior e información de sesión -->
        <div class="barra-divisoria barra-divisoria-flex">
            <div class="menu-container">
                <a href="#" class="menu-link">Inicio</a>

                <!-- Menú Desplegable de Consultas -->
                <div class="dropdown-menu-custom">
                    <a href="#" class="menu-link dropdown-toggle-custom">Consultas</a>
                    <div class="dropdown-content-custom">
                        <a href="#">Consulta APC</a>
                        <a href="#">Consulta Facturas</a>
                        <a href="#">Consulta Imei Simcard Abonado</a>
                        <a href="#">Consulta Límite Consumo</a>
                        <a href="#">Consulta de Planes</a>
                        <a href="#">Consulta de Ventas</a>
                        <a href="#">Consulta Historia Número Celular</a>
                        <a href="#">Historia del Imei y Simcard</a>
                        <a href="#">Consulta Historial ICC/IMEI</a>
                        <a href="#">Consulta HLR</a>
                        <a href="#">Consulta Series Y Números</a>
                        <a href="#">Consumo General</a>
                        <a href="#">Consulta Pasa Saldo</a>
                        <a href="#">Prueba DGI</a>
                        <a href="#">Consulta Docs. APC</a>
                    </div>
                </div>

                <a href="#" class="menu-link">Cola Atención</a>

                <!-- Menú Desplegable de Operaciones -->
                <div class="dropdown-menu-custom">
                    <a href="#" class="menu-link dropdown-toggle-custom">Operaciones</a>
                    <div class="dropdown-content-custom">
                        <a href="#">Recaudacion</a>
                        <a href="#">Act-Des SMS y Call id</a>
                        <a href="#">Ordenes de Servicio &gt;</a>
                        <a href="#">Cambio Estado IMEI</a>
                        <a href="#">Cambio Estado SIMCARD</a>
                        <a href="#">Corrección de Depósitos</a>
                        <a href="#">Verificación Correo de voz</a>
                        <a href="#">Manejar APN</a>
                        <a href="#">Desregistro HLR</a>
                        <a href="#">Cancelar Beneficio Individual</a>
                        <a href="#">Cancelar Beneficio Masivo</a>
                        <a href="#">Reporte de Recaudación</a>
                        <a href="#">Cambio de Serie</a>
                        <a href="#">Portal Xpress</a>
                        <a href="#">Monitor Portal Express</a>
                    </div>
                </div>

                <!-- Menú Desplegable de Aplicaciones -->
                <div class="dropdown-menu-custom">
                    <a href="#" class="menu-link dropdown-toggle-custom">Aplicaciones</a>
                    <div class="dropdown-content-custom">
                        <a href="#">Intranet</a>
                        <a href="#">Portal Comercial Ventas</a>
                        <a href="#">Sistema Comercial Crédito</a>
                        <a href="#">Portal RDS</a>
                        <a href="#">Herramienta VPN</a>
                        <a href="#">Ficha de Cliente</a>
                        <a href="#">Portal SPN</a>
                        <a href="#">ProcessMaker</a>
                        <a href="#">MTH</a>
                        <a href="#">IVR Panama</a>
                        <a href="#">AVI</a>
                    </div>
                </div>

                <a href="#" class="menu-link">Agenda</a>

                <!-- Opciones del administrador -->
                <div class="dropdown-menu-custom">
                    <a href="#" class="menu-link dropdown-toggle-custom">Administrador</a>
                    <div class="dropdown-content-custom">
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('usuarios.index') }}">Usuarios</a>
                            <a href="{{ route('abonados.exportar') }}" class="href">Reporte</a>
                        @endif
                    </div>
                </div>

                <!-- Enlace Salir que envía el formulario POST de logout -->
                <a href="#" class="menu-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <!-- Muestra dinámicamente el grupo/ubicación y usuario en sesión -->
            <div class="output_datos">
                {{ Auth::user()->grupo ?? 'CALLCENTER GT°' }} / {{ Auth::user()->username ?? 'OUTS_JOMENDEZ' }}
            </div>
        </div>

        <!-- Cuerpo del Dashboard con Pestañas -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Pie de página -->
        <footer class="pie-pagina"></footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    @stack('scripts')
</body>

</html>
