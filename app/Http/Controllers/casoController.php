<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use App\Models\Abonado;
use App\Models\Caso;
use App\Models\Tipologia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CasoController extends Controller
{
    /**
     * Muestra la ventana emergente para crear un nuevo caso.
     */

    public function create(Request $request)
    {
        // Capturar los parámetros pasados en la URL desde el JavaScript
        $clienteId = $request->query('cliente_id');
        $nombre = $request->query('nombre');
        $telefono = $request->query('telefono');
        $abonadoId = $request->query('abonado_id');

        // Obtener solo las opciones principales de Nivel 1 (TIPO)
        $tipos = Tipologia::where('nivel', 1)->where('activo', true)->get();

        // Obtener las provincias activas de la base de datos
        $provincias = Provincia::where('activo', true)->get();

        return view('gac.new_case', compact('clienteId', 'nombre', 'telefono', 'abonadoId', 'tipos', 'provincias'));
    }

    /**
     * Obtener Categorías (Nivel 2) según el Tipo (Nivel 1) seleccionado.
     */
    public function getCategorias($tipoId)
    {
        $categorias = Tipologia::where('parent_id', $tipoId)
            ->where('activo', true)
            ->get(['id', 'nombre']);

        return response()->json($categorias);
    }

    /**
     * Obtener Tipologías (Nivel 3) según la Categoría (Nivel 2) seleccionada.
     */
    public function getTipologias($categoriaId)
    {
        $tipologias = Tipologia::where('parent_id', $categoriaId)
            ->where('activo', true)
            ->get(['id', 'nombre', 'accion', 'solucion', 'clasificacion', 'tipo_cierre']);

        return response()->json($tipologias);
    }

    /**
     * Procesa y guarda el nuevo caso desde la ventana emergente con todos los campos.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario (incluyendo los nuevos campos técnicos)
        $validated = $request->validate([
            'abonado_id'           => 'nullable|string',
            'tipo_id'              => 'required|exists:tipologias,id',
            'categoria_id'         => 'required|exists:tipologias,id',
            'tipologia_id'         => 'required|exists:tipologias,id',
            'descripcion_cliente'  => 'required|string',
            'comentario_ejecutivo' => 'required|string',
            'accion'               => 'nullable|string',
            'solucion'             => 'nullable|string',
            'lleva_ajuste'         => 'nullable|in:SI,NO,NO_APLICA',
            'n_credito'            => 'nullable|string|max:50',
            'monto'                => 'nullable|numeric',
            'tipo_cierre'          => 'nullable|array',
            // Validación de campos técnicos adicionales:
            'provincia_id'         => 'nullable|exists:provincias,id',
            'ubicacion'            => 'nullable|string',
            'coordenadas'          => 'nullable|string',
            'fecha_inconveniente'  => 'nullable|date',
            'estado_cbs'           => 'nullable|string|max:100',
            'registro_sgsn'        => 'nullable|string|max:50',
            'tipo_venta'           => 'nullable|string|max:100',
            'motivo_visita'        => 'nullable|string|max:100',
        ]);

        // 2. Búsqueda del ID real en la tabla abonados
        $abonadoInput = $request->input('abonado_id');
        $abonadoRealId = null;

        if ($abonadoInput) {
            $abonado = Abonado::where('id', $abonadoInput)
                ->orWhere('numero_abonado', $abonadoInput)
                ->orWhere('numero_celular', $abonadoInput)
                ->first();

            $abonadoRealId = $abonado ? $abonado->id : null;
        }

        // 3. Generación del número único de solicitud
        $noSolicitud = rand(10000000, 99999999);

        // 4. Determinación del estado inicial del caso
        $estadoInicial = ($request->input('accion') === 'Caso resuelto') ? 'Cerrado' : 'Abierto';

        // 5. Creación del registro en la base de datos
        $caso = Caso::create([
            'user_id'              => Auth::id() ?? 1,
            'abonado_id'           => $abonadoRealId,
            'no_solicitud'         => $noSolicitud,
            'origen'               => 'Call Center',
            'tipo_id'              => $validated['tipo_id'],
            'categoria_id'         => $validated['categoria_id'],
            'tipologia_id'         => $validated['tipologia_id'],
            'descripcion_cliente'  => $validated['descripcion_cliente'],
            'comentario_ejecutivo' => $validated['comentario_ejecutivo'],
            'accion'               => $request->input('accion'),
            'solucion'             => $request->input('solucion'),
            'lleva_ajuste'         => $request->input('lleva_ajuste', 'NO_APLICA'),
            'n_credito'            => $request->input('n_credito'),
            'monto'                => $request->input('monto'),
            'tipo_cierre'          => $request->input('tipo_cierre', []),
            'estado'               => $estadoInicial,
            // Nuevos campos técnicos a guardar:
            'provincia_id'         => $request->input('provincia_id'),
            'ubicacion'            => $request->input('ubicacion'),
            'coordenadas'          => $request->input('coordenadas'),
            'fecha_inconveniente'  => $request->input('fecha_inconveniente'),
            'estado_cbs'           => $request->input('estado_cbs'),
            'registro_sgsn'        => $request->input('registro_sgsn'),
            'tipo_venta'           => $request->input('tipo_venta'),
            'motivo_visita'        => $request->input('motivo_visita'),
        ]);

        // 6. Script para notificar, recargar la vista principal y cerrar la ventana emergente
        return response("<script>
            alert('Solicitud registrada correctamente. No. Caso: {$caso->no_solicitud}');
            if (window.opener && !window.opener.closed) {
                window.opener.location.reload();
            }
            window.close();
        </script>");
    }

    /**
     * Muestra la ventana emergente de consulta histórica de casos.
     */
    public function consultaHistorica(Request $request)
    {
        $criterio = $request->query('criterio');
        $valor = $request->query('valor');
        $estado = $request->query('estado');
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');
        $filtrar = $request->has('filtrar');

        $casos = collect();

        if ($filtrar) {
            $query = Caso::with(['tipologia', 'user', 'abonado']);

            if ($valor) {
                if ($criterio === 'celular') {
                    $query->whereHas('abonado', function ($q) use ($valor) {
                        $q->where('numero_celular', $valor)
                            ->orWhere('numero_abonado', $valor);
                    });
                } elseif ($criterio === 'cuenta') {
                    $query->whereHas('cuenta', function ($q) use ($valor) {
                        $q->where('numero_cuenta', $valor);
                    });
                }
            }

            if ($estado && $estado !== '--Todas--') {
                $query->where('estado', $estado);
            }

            // CORRECCIÓN AQUÍ: Usamos Carbon::parse() que reconoce automáticamente 'YYYY-MM-DD'
            if ($fechaInicio && $fechaFin) {
                try {
                    $inicio = \Carbon\Carbon::parse($fechaInicio)->startOfDay();
                    $fin = \Carbon\Carbon::parse($fechaFin)->endOfDay();

                    $query->whereBetween('created_at', [$inicio, $fin]);
                } catch (\Exception $e) {
                    // Si ocurre error en la fecha
                }
            }

            $casos = $query->orderBy('created_at', 'desc')->get();
        }

        return view('gac.consulta_historica', compact('casos', 'valor', 'criterio', 'fechaInicio', 'fechaFin'));
    }

    /**
     * Muestra la ventana emergente con el detalle de la atención del caso.
     */
    public function detalle($id)
    {
        $caso = Caso::with(['user', 'abonado', 'tipo', 'categoria', 'tipologia'])->findOrFail($id);

        return view('gac.detalle_caso', compact('caso'));
    }
}
