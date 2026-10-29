<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAC - Consulta Historica de Caso</title>

    <link rel="stylesheet" href="{{ asset('css/histo_consult.css') }}">
    <script src="{{ asset('js/template.js') }}" defer></script>
</head>

<body>

    <div class="header-title">
        Tiempo Máximo Para Realizar Consultas 1 Año
    </div>

    <form method="GET" action="{{ route('casos.consulta_historica') }}" id="formConsulta">
        <input type="hidden" name="filtrar" value="1">

        <div class="search-box">
            <table class="form-table">
                <tr>
                    <td class="label">Criterio:</td>
                    <td>
                        <select name="criterio" class="selectText" style="width: 140px;">
                            <option value="celular" {{ request('criterio', $criterio) == 'celular' ? 'selected' : '' }}>
                                Celular</option>
                            <option value="cuenta" {{ request('criterio', $criterio) == 'cuenta' ? 'selected' : '' }}>
                                Cuenta</option>
                        </select>
                    </td>

                    <td class="label" style="padding-left: 10px;">Valor:</td>
                    <td>
                        <input type="text" name="valor" class="inputText" style="width: 105px;"
                            value="{{ request('valor', $valor) }}">
                    </td>

                    <td class="label" style="padding-left: 10px;">Fecha Inicio:</td>
                    <td style="white-space: nowrap;">
                        <input type="text" id="fecha_inicio_text" class="inputText" style="width: 85px;"
                            value="{{ request('fecha_inicio') ? \Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y') : date('d/m/Y', strtotime('-1 month')) }}"
                            readonly>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="date-picker-hidden"
                            value="{{ request('fecha_inicio', date('Y-m-d', strtotime('-1 month'))) }}"
                            onchange="actualizarTextoFecha('fecha_inicio', 'fecha_inicio_text')">
                        <button type="button" class="btn-cal" onclick="abrirCalendario('fecha_inicio')">📅</button>
                    </td>

                    <td class="label" style="padding-left: 10px;">Fecha Fin:</td>
                    <td style="white-space: nowrap;">
                        <input type="text" id="fecha_fin_text" class="inputText" style="width: 85px;"
                            value="{{ request('fecha_fin') ? \Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y') : date('d/m/Y') }}"
                            readonly>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="date-picker-hidden"
                            value="{{ request('fecha_fin', date('Y-m-d')) }}"
                            onchange="actualizarTextoFecha('fecha_fin', 'fecha_fin_text')">
                        <button type="button" class="btn-cal" onclick="abrirCalendario('fecha_fin')">📅</button>
                    </td>

                    <td style="text-align: right; width: 100%; padding-left: 10px;">
                        <button type="submit" class="btnOpc">Buscar [+]</button>
                        <a href="{{ route('casos.consulta_historica', ['criterio' => request('criterio'), 'valor' => request('valor')]) }}"
                            class="btnOpc"
                            style="text-decoration: none; display: inline-block; margin-left: 3px;">Limpiar [-]</a>
                    </td>
                </tr>

                <tr>
                    <td class="label">Estado:</td>
                    <td>
                        <select name="estado" class="selectText" style="width: 140px;">
                            <option value="--Todas--" {{ request('estado') == '--Todas--' ? 'selected' : '' }}>
                                --Todas--</option>
                            <option value="Abierto" {{ request('estado') == 'Abierto' ? 'selected' : '' }}>Abierto
                            </option>
                            <option value="Cerrado" {{ request('estado') == 'Cerrado' ? 'selected' : '' }}>Cerrado
                            </option>
                        </select>
                    </td>

                    <td class="label" style="padding-left: 10px;">Registros a mostrar:</td>
                    <td>
                        <select name="registros" class="selectText" style="width: 50px;">
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </td>

                    <td colspan="5"></td>
                </tr>
            </table>
        </div>
    </form>

    <!-- Tabla de Casos -->
    <table class="historico-table">
        <thead>
            <tr>
                <th style="width: 13%;">Fecha Ing.</th>
                <th style="width: 15%;">Origen</th>
                <th style="width: 33%;">Tipologia</th>
                <th style="width: 2%;"></th><!-- Columna divisora vacía -->
                <th style="width: 12%;">Cerrado Por</th>
                <th style="width: 11%;">Fecha Sol.</th>
                <th style="width: 8%;">Nº Sol.</th>
                <th style="width: 6%;">Estado</th>
                <th style="width: 2%;"></th><!-- Columna icono -->
            </tr>
        </thead>
        <tbody>
            @forelse($casos as $caso)
                <tr>
                    <td>
                        {{ $caso->created_at->format('d/m/Y') }}<br>
                        <span style="color: #444;">{{ $caso->created_at->format('h:i:s A') }}</span>
                    </td>
                    <td>{{ strtoupper($caso->origen) }}</td>
                    <td>{{ $caso->tipologia?->nombre ?? 'N/A' }}</td>
                    <td></td>
                    <td>{{ $caso->user?->username ?? ($caso->user?->name ?? 'N/A') }}</td>
                    <td>
                        {{ $caso->updated_at->format('d/m/Y') }}<br>
                        <span style="color: #444;">12:00:00 AM</span>
                    </td>
                    <td>{{ number_format($caso->no_solicitud ?? 0) }}</td>
                    <td>{{ strtoupper($caso->estado) }}</td>
                    <td style="text-align: center; cursor: pointer;" onclick="abrirDetalle('{{ $caso->id }}')">🔍
                    </td>
                </tr>
            @empty
                <tr style="height: 25px;">
                    <td colspan="9" style="text-align: center;">No se encontraron registros.</td>
                </tr>
            @endforelse

            <tr class="pagination-row">
                <td colspan="9">
                    <div class="pagination-container">
                        <button class="btn-page">|&lt;</button>
                        <button class="btn-page">&lt;</button>
                        <span style="font-size: 11px; font-weight: bold; margin: 0 5px;">Page 1 of 1</span>
                        <button class="btn-page">&gt;</button>
                        <button class="btn-page">&gt;|</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer-btn">
        <button type="button" class="btn-regresar" onclick="window.close();">🔄 Regresar</button>
    </div>

</body>

</html>
