<div class="tab-panel-container">

    <!-- 1. Cuadro Superior: Información de Cuenta -->
    <table class="table-retro-info">
        <thead>
            <tr>
                <th colspan="4" class="header-title">Información de Cuenta</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 22%;" class="field-label">Número de Cuenta :</td>
                <td style="width: 28%;">{{ $abonado->cuenta->numero_cuenta ?? '' }}</td>
                <td style="width: 22%;" class="field-label">Fecha Alta :</td>
                <td style="width: 28%;">{{ $cuenta?->created_at ? $cuenta->created_at->format('d-M-Y') : '' }}</td>
            </tr>
            <tr>
                <td class="field-label">Nombre de Cuenta :</td>
                <td>{{ $cuenta?->nombre_cuenta }}</td>
                <td class="field-label">Tipo Cuenta :</td>
                <td>{{ $cuenta?->tipo_cuenta }}</td>
            </tr>
            <tr>
                <td class="field-label">Responsable de Cuenta :</td>
                <td>{{ $cuenta?->responsable_cuenta }}</td>
                <td class="field-label">Categoría :</td>
                <td>
                    @if ($cuenta)
                        {{ $cuenta->tipo_cuenta === 'PREPAGO' ? 'E - Prepago' : ($cuenta->tipo_cuenta === 'Individual' ? 'E - Residencial' : 'C - Corporativo') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="field-label">Identificación :</td>
                <td>{{ $cuenta?->identificacion }}</td>
                <td class="field-label">Consulta de OOSS :</td>
                <td><a href="#" class="commandLink">Haga click aquí</a></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="field-label">Consulta de OOSS Pendientes :</td>
                <td><a href="#" class="commandLink">Haga click aquí</a></td>
            </tr>
        </tbody>
    </table>

    <!-- 2. Bloque Medio: Pospago, Híbrido, Prepago -->
    <div class="pospago-grid">
        <!-- Pospago -->
        <table class="table-plan-status">
            <thead>
                <tr>
                    <th colspan="2">Pospago</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="field-label">Activo:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Pospago')->where('situacion', 'Alta Activa De Abonado')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Baja:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Pospago')->where('situacion', 'Baja Activa de Abonado')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Robo:</td>
                    <td class="val-col">0</td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Límite de Consumo:</td>
                    <td class="val-col">0</td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Cobros:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Pospago')->where('situacion', 'Suspensión Activa de Abonado')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Susp. Voluntaria:</td>
                    <td class="val-col">0</td>
                </tr>
            </tbody>
        </table>

        <!-- Híbrido -->
        <table class="table-plan-status">
            <thead>
                <tr>
                    <th colspan="2">Híbrido</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="field-label">Activo:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Movil Hibrido')->where('situacion', 'Alta Activa De Abonado')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Baja:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Movil Hibrido')->where('situacion', 'Baja Activa de Abonado')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Robo:</td>
                    <td class="val-col">0</td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Cobros:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Movil Hibrido')->where('situacion', 'Suspensión Activa de Abonado')->count() : 0 }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Prepago -->
        <table class="table-plan-status">
            <thead>
                <tr>
                    <th colspan="2">Prepago</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="field-label">Activo:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Prepago')->where('situacion', 'Alta Activa De Abonado')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Baja:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Prepago')->where('situacion', 'Baja Activa de Abonado')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Robo:</td>
                    <td class="val-col">
                        {{ $cuenta ? $cuenta->abonados->where('producto', 'Prepago')->where('situacion', 'Suspensión Activa de Abonado')->count() : 0 }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 3. Listado de Clientes -->
    <div class="box-listado-clientes">
        <div class="box-listado-title">Listado de Clientes</div>

        <div class="filtros-container">
            <div class="filter-row">
                <span class="filter-label">Código Cliente:</span>
                <input type="text" class="inputText" style="width: 120px;">
            </div>
            <div class="filter-row">
                <span class="filter-label">Nombre:</span>
                <input type="text" class="inputText" style="width: 270px;">
            </div>

            <button type="button" class="btnOpc btn-filtrar-pos">Filtrar</button>

            <div class="dates-header-row">
                <span>Fecha Desde:</span>
                <span style="margin-left: 65px;">Fecha Hasta:</span>
            </div>

            <div class="dates-subheader-row">
                <span>Dia&nbsp;&nbsp;&nbsp;Mes&nbsp;&nbsp;&nbsp;Año</span>
                <span style="margin-left: 45px;">Dia&nbsp;&nbsp;&nbsp;Mes&nbsp;&nbsp;&nbsp;Año</span>
            </div>

            <div class="filter-row">
                <span class="filter-label">Fecha Alta:</span>
                <input type="checkbox" style="margin-right: 8px;">

                <select class="selectText" style="width: 38px;">
                    <option>23</option>
                </select>
                <select class="selectText" style="width: 32px;">
                    <option>8</option>
                </select>
                <select class="selectText" style="width: 55px;">
                    <option>2026</option>
                </select>

                <div style="margin-left: 20px;">
                    <select class="selectText" style="width: 38px;">
                        <option>23</option>
                    </select>
                    <select class="selectText" style="width: 32px;">
                        <option>9</option>
                    </select>
                    <select class="selectText" style="width: 55px;">
                        <option>2026</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla de Resultados -->
        <div class="table-container-scroll">
            <table class="table table-clientes">
                <thead class="table-light">
                    <tr>
                        <th style="width: 100px;">Código Cliente</th>
                        <th style="width: 260px;">Nombre</th>
                        <th style="width: 170px;">Fecha Alta</th>
                        <th style="width: 170px;">Aceptación Venta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cuenta && $cuenta->clientes)
                        @forelse($cuenta->clientes as $clienteItem)
                            <tr>
                                {{-- Usamos $clienteItem para extraer el código propio de CADA cliente --}}
                                <td>
                                    <a href="#" class="commandLink">
                                        {{ $clienteItem->numero_cliente ?? $clienteItem->id }}
                                    </a>
                                </td>

                                <td>{{ $clienteItem->nombre_cliente }}</td>

                                {{-- Fechas tomadas directamente de $clienteItem --}}
                                <td>
                                    {{ $clienteItem->created_at ? $clienteItem->created_at->format('d-M-Y') : '' }}
                                </td>
                                <td>
                                    {{ $clienteItem->created_at ? $clienteItem->created_at->format('d-M-Y') : '' }}
                                </td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No hay clientes asociados.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginación Inferior -->
        <div class="paging-bar-clientes">
            <div style="display: flex; align-items: center; gap: 3px;">
                <select class="selectText" style="width: 45px;">
                    <option>10</option>
                </select>
                <button class="pagination-btn">⏮</button>
                <button class="pagination-btn">◀</button>
                <span style="margin: 0 4px;">Página</span>
                <input type="text" class="inputText" value="1" style="width: 25px; text-align: center;">
                <span style="margin: 0 4px;">de 1</span>
                <button class="pagination-btn">▶</button>
                <button class="pagination-btn">⏭</button>
                <button class="pagination-btn" style="margin-left: 4px;">🔄</button>
            </div>
            <div>
                Mostrando 1 a {{ $cuenta?->clientes?->count() ?? 0 }} de {{ $cuenta?->clientes?->count() ?? 0 }}
                registros
            </div>
        </div>

    </div>

</div>
