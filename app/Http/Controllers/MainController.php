<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonado;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->input('criterio', 'celular');
        $valor    = trim($request->input('valor'));

        $abonado = null;
        $cliente = null;
        $cuenta  = null;

        // Solo busca si el usuario ingresó un valor diferente de vacío o del marcador '#'
        if ($valor && $valor !== '#') {
            $query = Abonado::with(['cuenta', 'cliente']);

            switch ($criterio) {
                case 'Celular':
                case 'celular':
                    $query->where('numero_celular', $valor);
                    break;
                case 'No. Abonado':
                    $query->where('numero_abonado', $valor);
                    break;
                case 'No. Cuenta':
                case 'cuenta':
                    $query->whereHas('cuenta', function ($q) use ($valor) {
                        $q->where('id', $valor); // O 'numero_cuenta' según tu campo en BD
                    });
                    break;
                case 'No. Cliente':
                case 'cliente':
                    $query->whereHas('cliente', function ($q) use ($valor) {
                        $q->where('id', $valor); // O 'numero_cliente' según tu campo en BD
                    });
                    break;
                default:
                    $query->where('numero_celular', $valor);
                    break;
            }

            $abonado = $query->first();

            if ($abonado) {
                $cliente = $abonado->cliente;
                $cuenta  = $abonado->cuenta;

                // CAMBIO AQUÍ: Cargamos los abonados y clientes de esta cuenta
                // para que la pestaña "Información de Cuenta" los pueda contar y listar
                if ($cuenta) {
                    $cuenta->load(['abonados', 'clientes']);
                }
            }
        }

        // Devolvemos los objetos directamente a la vista
        return view('gac.main', compact('abonado', 'cliente', 'cuenta'));
    }
}
