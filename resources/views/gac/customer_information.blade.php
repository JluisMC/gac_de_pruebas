<div class="tab-panel-container">

    <!-- 1. Cuadro Superior: Información del Cliente -->
    <table class="table-retro-info">
        <thead>
            <tr>
                <th colspan="4" class="header-title">Información del Cliente</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 22%;" class="field-label">Código Cuenta :</td>
                <td style="width: 28%;">
                    {{ $abonado?->cuenta?->numero_cuenta ?? ($cliente?->cuenta?->numero_cuenta ?? '') }}</td>
                <td style="width: 22%;" class="field-label">Responsable :</td>
                <td style="width: 28%;">
                    {{ $abonado?->cuenta?->responsable_cuenta ?? ($cliente?->nombre_cliente ?? '') }}
                    <i class="bi bi-search ms-1" style="font-size: 10px; cursor: pointer;"></i>
                </td>
            </tr>
            <tr>
                <td class="field-label">Número de Cliente :</td>
                <td>{{ $cliente?->numero_cliente ?? ($cliente?->id ?? ($abonado?->cliente?->numero_cliente ?? '')) }}
                </td>
                <td class="field-label">No. Venta :</td>
                <td>{{ $cliente?->abonados?->first()?->numero_venta ?? ($abonado?->numero_venta ?? '') }}</td>
            </tr>
            <tr>
                <td class="field-label">Nombre de Cliente :</td>
                <td>{{ $cliente?->nombre_cliente ?? ($abonado?->cliente?->nombre_cliente ?? '') }}</td>
                <td class="field-label">Tipo Persona :</td>
                <td>{{ $cliente?->tipo_persona ?? '' }}</td>
            </tr>
            <tr>
                <td class="field-label">Número Principal :</td>
                <td>{{ $cliente?->telefono_contacto ?? ($abonado?->numero_celular ?? '') }}</td>
                <td class="field-label">Categoría :</td>
                <td>
                    {{ $cliente?->categoria ?? '' }}
                    <i class="bi bi-search ms-1" style="font-size: 10px; cursor: pointer;"></i>
                </td>
            </tr>
            <tr>
                <td class="field-label">Identificación :</td>
                <td>{{ $cliente?->identificacion ?? ($abonado?->cliente?->identificacion ?? '') }}</td>
                <td class="field-label">Ciclo de Facturación :</td>
                <td>{{ $cliente?->ciclo_facturacion ?? ($abonado?->cliente?->ciclo_facturacion ?? '') }}</td>
            </tr>
            <tr>
                <td class="field-label">Direcciones Cliente :</td>
                <td><a href="#" class="commandLink">Haga click aquí</a></td>
                <td class="field-label">Teléfono de Contacto :</td>
                <td>{{ $cliente?->telefono_contacto ?? '' }}</td>
            </tr>
            <tr>
                <td class="field-label">Fecha de Alta :</td>
                <td>{{ isset($cliente?->fecha_alta) ? date('d/m/Y', strtotime($cliente->fecha_alta)) : ($abonado?->fecha_alta ? date('d/m/Y', strtotime($abonado->fecha_alta)) : '') }}
                </td>
                <td class="field-label">Saldo :</td>
                <td>{{ isset($cliente?->saldo) ? '$' . number_format($cliente->saldo, 2) : '' }}</td>
            </tr>
            <tr>
                <td class="field-label">Fecha de Baja :</td>
                <td>{{ isset($cliente?->fecha_baja) ? date('d/m/Y', strtotime($cliente->fecha_baja)) : '' }}</td>
                <td class="field-label">Tarjeta de Crédito :</td>
                <td>{{ $cliente?->tarjeta_credito ?? '' }}</td>
            </tr>
            <tr>
                <td class="field-label">Fecha Aceptación de Venta :</td>
                <td>{{ isset($cliente?->fecha_aceptacion_venta) ? date('d/m/Y', strtotime($cliente->fecha_aceptacion_venta)) : '' }}
                </td>
                <td class="field-label">Consulta de OOSS :</td>
                <td><a href="#" class="commandLink">Haga click aquí</a></td>
            </tr>
            <tr>
                <td class="field-label">Vencimiento Tarjeta Crédito :</td>
                <td>{{ $cliente?->vencimiento_tarjeta ?? '' }}</td>
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
                    <td class="field-label">Alta :</td>
                    <td class="val-col">
                        {{ $cliente ? $cliente->abonados->where('producto', 'POSPAGO')->where('situacion', 'Activo')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Baja :</td>
                    <td class="val-col">
                        {{ $cliente ? $cliente->abonados->where('producto', 'POSPAGO')->where('situacion', 'Inactivo')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Robo :</td>
                    <td class="val-col">0</td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Límite de Consumo :</td>
                    <td class="val-col">0</td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Cobros :</td>
                    <td class="val-col">0</td>
                </tr>
                <tr>
                    <td class="field-label">Susp. Voluntario :</td>
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
                    <td class="field-label">Alta :</td>
                    <td class="val-col">
                        {{ $cliente ? $cliente->abonados->where('producto', 'HIBRIDO')->where('situacion', 'Activo')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Baja :</td>
                    <td class="val-col">
                        {{ $cliente ? $cliente->abonados->where('producto', 'HIBRIDO')->where('situacion', 'Inactivo')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Robo :</td>
                    <td class="val-col">0</td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Cobro :</td>
                    <td class="val-col">0</td>
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
                    <td class="field-label">Alta :</td>
                    <td class="val-col">
                        {{ $cliente ? $cliente->abonados->where('producto', 'PREPAGO')->where('situacion', 'Activo')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Baja :</td>
                    <td class="val-col">
                        {{ $cliente ? $cliente->abonados->where('producto', 'PREPAGO')->where('situacion', 'Inactivo')->count() : 0 }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Susp. por Robo :</td>
                    <td class="val-col">0</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 3. Listado de Abonados -->
    <div class="box-listado-clientes">
        <div class="box-listado-title">Listado de Abonados</div>

        <div class="filtros-container">
            <div class="filter-row">
                <span class="filter-label">Código Abonado:</span>
                <input type="text" class="inputText" style="width: 120px;">
            </div>
            <div class="filter-row">
                <span class="filter-label">Nombre:</span>
                <input type="text" class="inputText" style="width: 270px;">
            </div>
            <div class="filter-row">
                <span class="filter-label">Numero de Celular:</span>
                <input type="text" class="inputText" style="width: 120px;">
            </div>

            <!-- Botón Filtrar alineado a la derecha -->
            <button type="button" class="btnOpc btn-filtrar-pos">Filtrar</button>

            <!-- Títulos de Fecha Desde / Fecha Hasta -->
            <div class="dates-header-row">
                <span>Fecha Desde:</span>
                <span style="margin-left: 65px;">Fecha Hasta:</span>
            </div>

            <!-- Sub-encabezados Dia Mes Año -->
            <div class="dates-subheader-row">
                <span>Dia&nbsp;&nbsp;&nbsp;Mes&nbsp;&nbsp;&nbsp;Año</span>
                <span style="margin-left: 45px;">Dia&nbsp;&nbsp;&nbsp;Mes&nbsp;&nbsp;&nbsp;Año</span>
            </div>

            <!-- Controles de selección de fecha -->
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
                        <th style="width: 100px;">No. Abonado</th>
                        <th style="width: 100px;">Celular</th>
                        <th style="width: 260px;">Nombre</th>
                        <th style="width: 170px;">Fecha Alta</th>
                        <th style="width: 150px;">Situación</th>
                        <th style="width: 100px;">No. Venta</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $listaAbonados = $cliente?->abonados ?? ($abonado?->cliente?->abonados ?? collect());
                    @endphp

                    @forelse($listaAbonados as $ab)
                        <tr>
                            <td><a href="#" class="commandLink">{{ $ab->numero_abonado ?? $ab->id }}</a></td>
                            <td>{{ $ab->numero_celular ?? '' }}</td>
                            <td>{{ $cliente->nombre_cliente ?? ($ab->cliente?->nombre_cliente ?? '') }}</td>
                            <td>{{ isset($ab->fecha_alta) ? date('d/m/Y', strtotime($ab->fecha_alta)) : '' }}</td>
                            <td>{{ $ab->situacion ?? 'Activo' }}</td>
                            <td>{{ $ab->numero_venta ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">No se encontraron abonados para este
                                cliente</td>
                        </tr>
                    @endforelse
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
                Mostrando 1 a {{ $listaAbonados->count() }} de {{ $listaAbonados->count() }} registros
            </div>
        </div>

    </div>
</div>
