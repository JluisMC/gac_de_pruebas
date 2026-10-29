<main class="main-content">
    <div class="tab-panel-container">

        <!-- 1. Cuadro Superior: Información de Abonado -->
        <table class="table-retro-info">
            <thead>
                <tr>
                    <th colspan="4" class="header-title">Información de Abonado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 22%;" class="field-label">Código Cuenta :</td>
                    <td style="width: 28%;">{{ $abonado?->cuenta?->numero_cuenta ?? ($cuenta?->numero_cuenta ?? '') }}
                    </td>
                    <td style="width: 22%;" class="field-label">Fecha de Alta :</td>
                    <td style="width: 28%;">
                        {{ isset($abonado?->fecha_alta) ? date('d/m/Y', strtotime($abonado->fecha_alta)) : '' }}</td>
                </tr>
                <tr>
                    <td class="field-label">Código Cliente :</td>
                    <td>{{ $abonado?->cliente?->numero_cliente ?? ($cliente?->numero_cliente ?? '') }}</td>
                    <td class="field-label">Fin de Contrato :</td>
                    <td>{{ isset($abonado?->fecha_expiracion) ? date('d/m/Y', strtotime($abonado->fecha_expiracion)) : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="field-label">Número de Abonado :</td>
                    <td>{{ $abonado?->numero_abonado ?? '' }}</td>
                    <td class="field-label">Fecha de Baja :</td>
                    <td>{{ isset($abonado?->fecha_baja) ? date('d/m/Y', strtotime($abonado->fecha_baja)) : '' }}</td>
                </tr>
                <tr>
                    <td class="field-label">Número de Celular :</td>
                    <td>{{ $abonado?->numero_celular ?? '' }}</td>
                    <td class="field-label">Activación Centrales :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Código Usuario :</td>
                    <td>
                        {{ $abonado?->codigo_usuario ?? '17229930' }}
                        <a href="#" class="commandLink ms-1">Consulta OOSS</a>
                    </td>
                    <td class="field-label">Aceptación de Ventas :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Nombre :</td>
                    <td>{{ $abonado?->cliente?->nombre_cliente ?? ($cliente?->nombre_cliente ?? '') }}</td>
                    <td class="field-label">Cambio de Plan :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Situación :</td>
                    <td>
                        {{ $abonado?->situacion ?? '' }}
                        <i class="bi bi-search ms-1" style="font-size: 10px; cursor: pointer;"></i>
                    </td>
                    <td class="field-label">Mod. Limite Consumo:</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Indicador Suspensión :</td>
                    <td></td>
                    <td class="field-label">No. Venta</td>
                    <td>{{ $cliente?->abonados?->first()?->numero_venta ?? ($abonado?->numero_venta ?? '') }}</td>
                </tr>
                <tr>
                    <td class="field-label">Tiempo de contrato :</td>
                    <td></td>
                    <td class="field-label">Beneficios :</td>
                    <td><a href="#" class="commandLink">Haga click aquí</a></td>
                </tr>
                <tr>
                    <td class="field-label">Tipo de plan tarifario :</td>
                    <td>{{ $abonado?->producto ?? '' }}</td>
                    <td class="field-label">Serv. Suplementarios :</td>
                    <td><a href="#" class="commandLink">Haga click aquí</a></td>
                </tr>
                <tr>
                    <td class="field-label">Plan Tarifario :</td>
                    <td>{{ $abonado?->plan_tarifario ?? '' }}</td>
                    <td class="field-label">Saldo :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Código Plan :</td>
                    <td></td>
                    <td class="field-label">Monto Garantía :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Detalles de Equipo :</td>
                    <td><a href="#" class="commandLink">Haga click aquí</a></td>
                    <td class="field-label">Fecha Baja Monto :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Empresa :</td>
                    <td></td>
                    <td class="field-label">Fecha de pago Garantía :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Números Favoritos :</td>
                    <td><a href="#" class="commandLink">Haga click aquí</a></td>
                    <td class="field-label">Estado Monto Garantía :</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field-label">Tipo de Plan:</td>
                    <td>{{ $abonado?->tipo_plan ?? '' }}</td>
                    <td class="field-label">Consulta de OOSS Pendientes :</td>
                    <td><a href="#" class="commandLink">Haga click aquí</a></td>
                </tr>
                <tr>
                    <td class="field-label">Tipo de Sim Card:</td>
                    <td>{{ $abonado?->tipo_simcard ?? '' }}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="field-label">Recordatorio:</td>
                    <td colspan="3" style="font-weight: bold; color: #000;">
                        {{ $abonado?->recordatorio ?? 'La simcard No es LTE realizar cambio de simcard' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 2. Bloque Medio: Datos del Equipo / Lim. Consumo x Servicio -->
        <div class="bloque-medio-grid">
            <!-- Datos del Equipo -->
            <table class="table-bloque-medio">
                <thead>
                    <tr>
                        <th colspan="2">Datos del Equipo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 45%;" class="field-label">Número de Simcard :</td>
                        <td>{{ $abonado?->simcard ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Número de IMEI :</td>
                        <td>{{ $abonado?->imei ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Modelo del Equipo :</td>
                        <td>{{ $abonado?->modelo_equipo ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Descripción :</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="field-label">Código Artículo :</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="field-label">Procedencia :</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="field-label">Ultimo Cambio Equipo :</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <!-- Lim. Consumo x Servicio -->
            <table class="table-bloque-medio">
                <thead>
                    <tr>
                        <th colspan="2">Lim. Consumo x Servicio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 45%;" class="field-label">LDI :</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="field-label">LDN :</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="field-label">SMS :</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="field-label">Límite de Consumo:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="field-label">Cod. Límite de Consumo:</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 3. Lista de OOSS -->
        <div class="box-listado-clientes">
            <div class="box-listado-title">Lista de OOSS</div>

            <div class="filtros-container">
                <div class="filter-row">
                    <span class="filter-label">Gestion:</span>
                    <input type="text" class="inputText" style="width: 180px;">
                </div>
                <div class="filter-row">
                    <span class="filter-label">Responsable:</span>
                    <input type="text" class="inputText" style="width: 240px;">
                </div>
                <div class="filter-row">
                    <span class="filter-label">Usuario Gac:</span>
                    <input type="text" class="inputText" style="width: 240px;">
                </div>

                <!-- Botón Filtrar alineado a la derecha -->
                <button type="button" class="btnOpc btn-filtrar-pos">Filtrar</button>

                <!-- Títulos de Fecha Desde / Fecha Hasta -->
                <div class="dates-header-row">
                    <span>Fecha Inicio:</span>
                    <span style="margin-left: 65px;">Fecha Fin:</span>
                </div>

                <!-- Sub-encabezados Dia Mes Año -->
                <div class="dates-subheader-row">
                    <span>Dia&nbsp;&nbsp;&nbsp;Mes&nbsp;&nbsp;&nbsp;Año</span>
                    <span style="margin-left: 45px;">Dia&nbsp;&nbsp;&nbsp;Mes&nbsp;&nbsp;&nbsp;Año</span>
                </div>

                <!-- Controles de selección de fecha -->
                <div class="filter-row">
                    <span class="filter-label">Fecha:</span>
                    <input type="checkbox" style="margin-right: 8px;">

                    <select class="selectText" style="width: 38px;">
                        <option>{{ date('d') }}</option>
                    </select>
                    <select class="selectText" style="width: 32px;">
                        <option>{{ date('m') }}</option>
                    </select>
                    <select class="selectText" style="width: 55px;">
                        <option>{{ date('Y') }}</option>
                    </select>

                    <div style="margin-left: 20px;">
                        <select class="selectText" style="width: 38px;">
                            <option>{{ date('d') }}</option>
                        </select>
                        <select class="selectText" style="width: 32px;">
                            <option>{{ date('m') }}</option>
                        </select>
                        <select class="selectText" style="width: 55px;">
                            <option>{{ date('Y') }}</option>
                        </select>
                    </div>
                </div>

                <div class="mt-2">
                    <a href="#" class="commandLink">Reimpresión / Reseteos</a>
                </div>
            </div>

            <!-- Tabla de Resultados -->
            <div class="table-container-scroll">
                <table class="table table-clientes">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 90px;">No. OOSS</th>
                            <th style="width: 180px;">Gestión</th>
                            <th style="width: 110px;">Responsable</th>
                            <th style="width: 100px;">Usuario Gac</th>
                            <th style="width: 140px;">Procesada</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($oossList ?? [] as $ooss)
                            <tr>
                                <td><a href="#" class="commandLink">{{ $ooss->numero_ooss }}</a></td>
                                <td>{{ $ooss->gestion }}</td>
                                <td>{{ $ooss->responsable }}</td>
                                <td>{{ $ooss->usuario_gac ?? '-' }}</td>
                                <td>{{ $ooss->procesada }}</td>
                                <td>{{ $ooss->comentario }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td><a href="#" class="commandLink"></a></td>
                                <td></td>
                                <td></td>
                                <td>-</td>
                                <td></td>
                                <td></td>
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
                    Mostrando 1 a 4 de 4 registros
                </div>
            </div>

        </div>

    </div>
</main>
