<?php

namespace App\Http\Controllers;

use App\Models\Abonado;
use Illuminate\Http\Request;

class AbonadoController extends Controller
{
    public function exportarExcel()
    {
        $fileName = 'reporte_clientes_abonados_' . date('Y-m-d_H-i-s') . '.csv';

        // Cargamos el abonado, su cuenta y el cliente dueño de esa cuenta
        $abonados = Abonado::with(['cuenta.clientes'])->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($abonados) {
            $file = fopen('php://output', 'w');

            // BOM para que Excel reconozca tildes y eñes correctamente en UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Encabezados exactos pedidos
            fputcsv($file, [
                'Nombre Cliente',
                'Número Cliente',
                'Identificación',
                'Ciclo de Facturación',
                'Situación Abonado',
                'Número Celular',
                'Producto',
                'Plan Tarifario',
                'Modelo de Equipo'
            ]);

            // Recorremos cada abonado para extraer los campos específicos
            foreach ($abonados as $abonado) {
                // Obtenemos la cuenta asociada
                $cuenta = $abonado->cuenta;
                // Como en tu modelo Cuenta pusiste un hasMany(Cliente::class), 
                // tomamos el primer cliente relacionado (o ajustamos si es hasOne/belongsTo)
                $cliente = $cuenta ? $cuenta->clientes->first() : null;

                fputcsv($file, [
                    $cliente->nombre_cliente ?? 'N/D',               // De Clientes
                    $cliente->numero_cliente ?? 'N/D',       // De Clientes
                    $cliente->identificacion ?? 'N/D',       // De Clientes
                    $cliente->ciclo_facturacion ?? 'N/D',    // De Clientes
                    $abonado->situacion ?? 'N/D',            // De Abonado
                    $abonado->numero_celular ?? 'N/D',       // De Abonado (cambia si tu columna se llama diferente, ej: telefono)
                    $abonado->producto ?? 'N/D',             // De Abonado
                    $abonado->plan_tarifario ?? 'N/D',       // De Abonado
                    $abonado->modelo_equipo ?? 'N/D',        // De Abonado
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
