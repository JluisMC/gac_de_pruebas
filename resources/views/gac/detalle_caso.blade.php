<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAC - Detalle de Atencion</title>

    <link rel="stylesheet" href="{{ asset('css/detalle_histo.css') }}">
</head>
<body>

    <!-- INFORMACIÓN GENERAL -->
    <div class="section-box">
        <div class="section-header">INFORMACIÓN GENERAL</div>
        <table class="detail-table">
            <tr>
                <td style="width: 50%;">
                    <span class="label-bold">No. solicitud:</span> {{ $caso->no_solicitud }}
                </td>
                <td style="width: 50%;">
                    <span class="label-bold">Celular / Teléfono:</span> {{ $caso->abonado?->numero_celular ?? $caso->abonado?->numero_abonado ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label-bold">Reportado por:</span> {{ $caso->user?->name ?? 'N/A' }}
                </td>
                <td>
                    <span class="label-bold">Estado:</span> {{ strtoupper($caso->estado) }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label-bold">Tipo:</span> {{ strtoupper($caso->tipo?->nombre ?? 'N/A') }}
                </td>
                <td>
                    <span class="label-bold">Categoría:</span> {{ strtoupper($caso->categoria?->nombre ?? 'N/A') }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label-bold">Tipología:</span> {{ strtoupper($caso->tipologia?->nombre ?? 'N/A') }}
                </td>
                <td>
                    <span class="label-bold">Sub Tipología I:</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label-bold">Sub Tipología II:</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="label-bold" style="margin-bottom: 2px;">Descripción del caso:</div>
                    <textarea class="textarea-readonly" readonly>{{ $caso->descripcion_cliente }}</textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label-bold">Fecha Inicio:</span> {{ $caso->created_at->format('d/m/Y H:i:s') }}
                </td>
                <td>
                    <span class="label-bold">Fecha de Cierre:</span> {{ $caso->estado === 'Cerrado' ? $caso->updated_at->format('d/m/Y H:i:s') : '' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="label-bold" style="margin-bottom: 2px;">Solución del caso:</div>
                    <textarea class="textarea-readonly" readonly>{{ $caso->solucion ?? $caso->comentario_ejecutivo }}</textarea>
                </td>
            </tr>
        </table>
    </div>

    <!-- DETALLE DE LA ATENCIÓN -->
    <div class="section-box">
        <div class="section-header">DETALLE DE LA ATENCIÓN</div>
        <table class="detail-table">
            <tr>
                <td style="width: 70%; border-right: none;">
                    <p style="margin: 2px 0;"><span class="label-bold">Etapa:</span> 1</p>
                    <p style="margin: 2px 0;"><span class="label-bold">Línea de Atención:</span> PRIMERA LINEA</p>
                    <br>
                    <p style="margin: 2px 0;"><span class="label-bold">Usuario:</span> {{ strtoupper($caso->user?->username ?? $caso->user?->name) }}</p>
                    <br>
                    <p style="margin: 2px 0;"><span class="label-bold">{{ strtoupper($caso->origen) }} /</span> {{ strtoupper($caso->user?->name) }}</p>
                </td>
                <td style="width: 30%; border-left: none;">
                    <p style="margin: 2px 0;"><span class="label-bold">Status:</span> {{ $caso->estado === 'Cerrado' ? 'Completado' : 'En Proceso' }}</p>
                    <p style="margin: 2px 0;"><span class="label-bold">Fecha Inicio:</span> {{ $caso->created_at->format('d/m/Y H:i:s A') }}</p>
                    <p style="margin: 2px 0;"><span class="label-bold">Fecha Final:</span> {{ $caso->updated_at->format('d/m/Y H:i:s A') }}</p>
                    <p style="margin: 2px 0;"><span class="label-bold">Tiempo etapa:</span> 1 SEGUNDO</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label-bold">Comentario:</span> {{ $caso->comentario_ejecutivo }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label-bold">Tipología:</span> {{ strtoupper($caso->tipo?->nombre) }} / {{ strtoupper($caso->categoria?->nombre) }} / {{ strtoupper($caso->tipologia?->nombre) }}
                </td>
            </tr>
        </table>

        <div class="pagination-container">
            <button class="btn-page">|&lt;</button>
            <button class="btn-page">&lt;</button>
            <span style="font-size: 11px; font-weight: bold; margin: 0 5px;">Page 1 of 1</span>
            <button class="btn-page">&gt;</button>
            <button class="btn-page">&gt;|</button>
        </div>
    </div>

</body>
</html>