<div class="tab-content tab-panel-container" id="gacTabsContent">

    <!-- Pestaña 1: Ingreso de Casos -->
    <div class="tab-pane fade show active" id="dvCasos" role="tabpanel">

        <form action="{{ route('main.index') }}" method="GET">
            <div class="search-container">
                <!-- Fila 1: Labels + Visita -->
                <div class="labels-row">
                    <label for="cbCriterio" style="width: 85px;">Criterio:</label>
                    <label for="edValor" style="width: 110px;">Valor:</label>
                    <label for="edNombre" style="width: 220px;">Nombre:</label>
                    <label for="edTelContacto" style="width: 120px;">Tel. Contacto:</label>
                    <div class="visita-row">
                        Atendiendo visita #: <span class="visita-val">---</span>
                    </div>
                </div>

                <!-- Fila 2: Inputs y Botones -->
                <div class="controls-row">
                    <select id="cbCriterio" name="criterio" class="selectText" style="width: 85px;">
                        <option value="celular" {{ request('criterio') == 'celular' ? 'selected' : '' }}>Celular
                        </option>
                        <option value="cuenta" {{ request('criterio') == 'cuenta' ? 'selected' : '' }}>Cuenta</option>
                        <option value="cliente" {{ request('criterio') == 'cliente' ? 'selected' : '' }}>Cliente
                        </option>
                    </select>

                    <input type="text" id="edValor" name="valor" class="inputText" style="width: 110px;"
                        value="{{ request('valor') }}">
                    <input type="text" id="edNombre" name="nombre" class="inputText" style="width: 220px;"
                        value="{{ $cliente->nombre_cliente ?? ($abonado?->cliente?->nombre_cliente ?? '') }}" readonly>
                    <input type="text" id="edTelContacto" name="tel_contacto" class="inputText" style="width: 120px;"
                        value="{{ $cliente->telefono_contacto ?? request('tel_contacto') }}">

                    <button type="submit" class="btnOpc">Buscar [+]</button>
                    <button type="button" class="btnOpc">Busqueda Avanzada [+]</button>
                    <a href="{{ route('main.index') }}" class="btnOpc"
                        style="text-decoration: none; text-align: center; display: inline-block;">Limpiar [-]</a>
                </div>
            </div>
        </form>

        <!-- Paneles Principales (3 Columnas) -->
        <div class="panels-grid">

            <!-- Panel: DATOS DE LA CUENTA -->
            <div class="panel-box">
                <div class="panel-header">DATOS DE LA CUENTA</div>
                <div class="panel-body">
                    <div><span class="field-label">Nombre:</span> {{ $abonado?->cuenta?->nombre_cuenta ?? '' }}</div>
                    <div><span class="field-label">No. Cuenta:</span> {{ $abonado?->cuenta?->numero_cuenta ?? '' }}
                    </div>
                    <div><span class="field-label">Responsable:</span>
                        {{ $abonado?->cuenta?->responsable_cuenta ?? '' }}</div>
                    <div><span class="field-label">Vendedor:</span> {{ $abonado?->cuenta?->vendedor ?? '' }}</div>
                    <div><span class="field-label">Tipo:</span> {{ $abonado?->cuenta?->tipo_cuenta ?? '' }}</div>
                    <div>
                        <span class="field-label">Otros:</span>
                        <span class="icon-lupa" style="float: right;">🔍</span>
                        {{ $abonado?->cuenta?->otros ?? '' }}
                    </div>
                </div>
            </div>

            <!-- Panel: DATOS DEL CLIENTE -->
            <div class="panel-box">
                <div class="panel-header">DATOS DEL CLIENTE</div>
                <div class="panel-body">
                    <div><span class="field-label">Nombre:</span> <span
                            id="lblNombreCliente">{{ $cliente->nombre_cliente ?? ($abonado?->cliente?->nombre_cliente ?? '') }}</span>
                    </div>
                    <div><span class="field-label">No. Cliente:</span> <span
                            id="lblNoCliente">{{ $cliente->numero_cliente ?? ($cliente->id ?? ($abonado?->cliente?->numero_cliente ?? ($abonado?->cliente?->id ?? ''))) }}</span>
                    </div>
                    <div><span class="field-label">Cedula:</span>
                        {{ $cliente->identificacion ?? ($abonado?->cliente?->identificacion ?? '') }}</div>
                    <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                        <div>
                            <div>
                                <span class="field-label">Abonados:</span>
                                {{ $cliente ? $cliente->abonados->count() : ($abonado?->cliente ? $abonado->cliente->abonados->count() : '') }}
                            </div>
                            <div><span class="field-label">Teléfonos:</span> <span
                                    id="lblTelContacto">{{ $cliente->telefono_contacto ?? ($abonado?->cliente?->telefono_contacto ?? '') }}</span>
                            </div>
                            <div><span class="field-label">Producto:</span> {{ $abonado?->producto ?? '' }}</div>
                            <div>
                                <span class="field-label">Comentario:</span>
                                <span style="margin-left: 15px;">💾</span>
                                <span class="icon-lupa">🔍</span>
                            </div>
                        </div>
                        <div style="margin-right: 40px;">
                            <span class="field-label">Ciclo Fact:</span>
                            {{ $cliente->ciclo_facturacion ?? ($abonado?->cliente?->ciclo_facturacion ?? '') }}
                        </div>
                    </div>

                    <div
                        style="position: absolute; bottom: 8px; left: 8px; right: 8px; display: flex; justify-content: space-between; align-items: flex-end;">
                        <div style="display: flex; align-items: flex-start; gap: 8px;">
                            <span class="field-label">Responsable /<br>Apoderado:</span>
                            <span>{{ $abonado?->cuenta?->responsable_cuenta ?? ($abonado?->cliente?->nombre_cliente ?? '') }}</span>
                            <span class="icon-lupa">🔍</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel: DATOS DEL ABONADO -->
            <div class="panel-box">
                <div class="panel-header">DATOS DEL ABONADO</div>
                <div class="panel-body">
                    <div><span class="field-label">Nombre:</span> {{ $abonado?->cliente?->nombre_cliente ?? '' }}</div>
                    <div><span class="field-label">No. Abonado:</span> <span
                            id="lblNoAbonado">{{ $abonado?->numero_abonado ?? ($abonado?->numero_celular ?? '') }}</span>
                    </div>
                    <div><span class="field-label">Tecnología:</span> {{ $abonado?->tecnologia ?? '' }}</div>
                    <div><span class="field-label">Situación:</span> {{ $abonado?->situacion ?? '' }}</div>
                    <div>
                        <span class="field-label">Plan Tarifario:</span> {{ $abonado?->plan_tarifario ?? '' }}
                        <span class="icon-lupa" style="float: right;">🔍</span>
                    </div>
                    <div><span class="field-label">Fecha Alta:</span>
                        {{ isset($abonado?->fecha_alta) ? date('d-M-Y', strtotime($abonado->fecha_alta)) : '' }}</div>
                    <div>
                        <span class="field-label">Fecha Exp:</span>
                        <span style="{{ $abonado?->estaExpirado() ? 'color: red; font-weight: bold;' : '' }}">
                            {{ isset($abonado?->fecha_expiracion) ? date('d-M-Y', strtotime($abonado->fecha_expiracion)) : '' }}
                        </span>
                    </div>
                    <div><span class="field-label">Cualitativo:</span> {{ $abonado?->cualitativo ?? '' }}</div>
                    <div><span class="field-label">Cumpleaños:</span> {{ $abonado?->cumpleanos ?? '' }}</div>
                    <div>
                        <span class="field-label">Promoción:</span>
                        <span class="field-value">{{ $abonado?->promocion ?? '' }}<span
                                class="icon-lupa">🔍</span></span>
                    </div>
                    <div>
                        <span class="field-label">Tipo de Plan:</span>
                        <span class="field-value">{{ $abonado?->tipo_plan ?? '' }}</span>
                    </div>
                    <div>
                        <span class="field-label">Tipo de Sim Card:</span>
                        <span class="field-value">{{ $abonado?->tipo_simcard ?? '' }}</span>
                    </div>
                    <br>
                    <div>
                        <span class="field-label">Recordatorio:</span>
                        <span class="field-value">{{ $abonado?->recordatorio ?? '' }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Secciones Inferiores y Acciones -->
        <div class="bottom-layout" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

            <!-- Lado Izquierdo: Terminal y Botones -->
            <div>
                <div class="collapsible-header" onclick="toggleSection('body-terminal', 'icon-terminal')"
                    style="cursor: pointer;">
                    <span>DATOS DE TERMINAL</span>
                    <span class="arrow-icon" id="icon-terminal">︾</span>
                </div>

                <div id="body-terminal"
                    style="display: none; border: 1px solid #7f9db9; padding: 5px; background: #fff; margin-bottom: 5px;">
                    <table class="table-retro-info" style="width: 100%; font-size: 11px;">
                        <tr>
                            <td class="field-label">Marca / Modelo:</td>
                            <td>{{ $abonado?->modelo_equipo ?? 'MOTOROLA V3' }}</td>
                            <td class="field-label">Asegurado:</td>
                            <td>{{ $abonado?->asegurado ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="field-label">Nº ICC: 🔍</td>
                            <td>{{ $abonado?->simcard ?? '' }}</td>
                            <td class="field-label">Siniestro:</td>
                            <td>{{ $abonado?->siniestro ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="field-label">Nº IMEI: 🔍</td>
                            <td>{{ $abonado?->imei ?? '00000000000010' }}</td>
                            <td class="field-label">Fec. Cambio:</td>
                            <td>{{ isset($abonado?->fecha_cambio_equipo) ? date('d-M-Y', strtotime($abonado->fecha_cambio_equipo)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="field-label">Precio Regular:</td>
                            <td>{{ ($abonado?->precio_regular ?? 0) > 0 ? '$' . number_format($abonado->precio_regular, 2) : '$0' }}
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="field-label">Precio Venta:</td>
                            <td>{{ ($abonado?->precio_venta ?? 0) > 0 ? '$' . number_format($abonado->precio_venta, 2) : '$0' }}
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="field-label">Monto Subsidio:</td>
                            <td>${{ number_format($abonado?->monto_subsidio ?? 0, 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                </div>

                <div class="left-actions" style="margin-top: 5px;">
                    <button type="button" id="btnConsultaHistorica" class="btnOpc">Consulta Historica</button>
                    <!-- ID para capturar el click desde public/js/app.js -->
                    <button type="button" id="btnIngresarSolicitud" class="btnOpc">Ingresar Solicitud</button>
                </div>
            </div>

            <!-- Lado Derecho: Bloques Desplegables -->
            <div class="right-collapsibles">
                <div class="collapsible-header" onclick="toggleSection('body-facturacion', 'icon-facturacion')"
                    style="cursor: pointer;">
                    <span>DIRECCION DE FACTURACION Y COBRANZA</span>
                    <span class="arrow-icon" id="icon-facturacion">︾</span>
                </div>
                <div id="body-facturacion"
                    style="display: none; border: 1px solid #7f9db9; padding: 5px; background: #fff; margin-bottom: 5px;">
                    <table class="table-retro-info" style="width: 100%; font-size: 11px;">
                        <tr>
                            <td class="field-label">Provincia:</td>
                            <td>{{ $abonado?->cuenta?->provincia ?? '' }}</td>
                            <td class="field-label">Calle:</td>
                            <td>{{ $abonado?->cuenta?->calle ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="field-label">Distrito:</td>
                            <td>{{ $abonado?->cuenta?->distrito ?? '' }}</td>
                            <td class="field-label">Casa / Apto:</td>
                            <td>{{ $abonado?->cuenta?->casa_apto ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="field-label">Corregimiento:</td>
                            <td>{{ $abonado?->cuenta?->corregimiento ?? '' }}</td>
                            <td class="field-label">Estafeta:</td>
                            <td>{{ $abonado?->cuenta?->estafeta ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="field-label">Email: 🔍</td>
                            <td>{{ $abonado?->cuenta?->email ?? ($cliente->email ?? '') }}</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="field-label">Casilla:</td>
                            <td>{{ $abonado?->cuenta?->casilla ?? '' }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                </div>

                <div class="collapsible-header" onclick="toggleSection('body-recaudacion', 'icon-recaudacion')"
                    style="cursor: pointer; margin-top: 4px;">
                    <span>INFORMACION DE RECAUDACION</span>
                    <span class="arrow-icon" id="icon-recaudacion">︾</span>
                </div>
                <div id="body-recaudacion"
                    style="display: none; border: 1px solid #7f9db9; padding: 5px; background: #fff; margin-bottom: 5px;">
                    <table class="table-retro-info" style="width: 100%; font-size: 11px;">
                        <tr>
                            <td class="field-label">Saldo cuenta:</td>
                            <td>${{ number_format($abonado?->cuenta?->saldo ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="field-label">Saldo cliente:</td>
                            <td>${{ number_format($cliente->saldo ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="field-label">Castigo Contable:</td>
                            <td>${{ number_format($abonado?->cuenta?->castigo_contable ?? 0, 2) }} 🔍</td>
                        </tr>
                        <tr>
                            <td class="field-label">Fecha de ultimo pago:</td>
                            <td>{{ isset($abonado?->cuenta?->fecha_ultimo_pago) ? date('d-M-Y', strtotime($abonado->cuenta->fecha_ultimo_pago)) : 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="field-label">Monto de ultimo pago:</td>
                            <td>{{ isset($abonado?->cuenta?->monto_ultimo_pago) ? '$' . number_format($abonado->cuenta->monto_ultimo_pago, 2) : 'N/A' }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="collapsible-header" onclick="toggleSection('body-altamira', 'icon-altamira')"
                    style="cursor: pointer; margin-top: 4px;">
                    <span>DATOS ALTAMIRA</span>
                    <span class="arrow-icon" id="icon-altamira">︾</span>
                </div>
                <div id="body-altamira"
                    style="display: none; border: 1px solid #7f9db9; padding: 5px; background: #fff; margin-bottom: 5px;">
                    <div style="font-size: 11px; padding: 5px;">Sin datos Altamira disponibles.</div>
                </div>
            </div>

        </div>

        <!-- Bloque Consulta Histórica -->
        <div class="full-width-collapsible" style="margin-top: 10px;">
            <div class="collapsible-header"
                onclick="toggleSection('body-historica-container', 'icon-historica-container')"
                style="cursor: pointer;">
                <span>CONSULTA HISTORICA</span>
                <span class="arrow-icon" id="icon-historica-container">︾</span>
            </div>
        </div>

        <div id="body-historica-container">
            <div class="historico-filters">
                <div class="filter-row">
                    <label style="margin-left: 30px;">Criterio:</label>
                    <select class="selectText" style="width: 220px;">
                        <option>Celular</option>
                    </select>
                    <label style="margin-left: 10px;">Valor:</label>
                    <input type="text" class="inputText" value="" style="width: 140px;">
                    <label style="margin-left: 10px;">Fecha Inicio:</label>
                    <input type="text" class="inputText" style="width: 100px;">
                    <button type="button" class="btn-calendar">📅</button>
                    <label style="margin-left: 10px;">Fecha Fin:</label>
                    <input type="text" class="inputText" style="width: 100px;">
                    <button type="button" class="btn-calendar">📅</button>
                </div>

                <div class="filter-row" style="margin-top: 2px;">
                    <label style="margin-left: 35px;">Estado:</label>
                    <select class="selectText" style="width: 220px;">
                        <option>Todos</option>
                    </select>
                    <button type="button" class="btnOpc" style="margin-left: 10px;">Buscar [+]</button>
                    <button type="button" class="btnOpc">Limpiar búsqueda</button>
                </div>
            </div>

            <table class="historico-table">
                <thead>
                    <tr>
                        <th style="width: 11%;">Fecha Ing.</th>
                        <th style="width: 13%;">Origen</th>
                        <th style="width: 32%;">Tipología</th>
                        <th style="width: 10%;">Caso Reabierto</th>
                        <th style="width: 11%;">Fecha Sol.</th>
                        <th style="width: 11%;">No. Solicitud</th>
                        <th style="width: 10%;">Estado</th>
                        <th style="width: 2%;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historico ?? [] as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->origen }}</td>
                            <td>{{ $item->tipologia }}</td>
                            <td>No</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ $item->no_solicitud }}</td>
                            <td>{{ $item->estado }}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center;">No hay historial disponible</td>
                        </tr>
                    @endforelse
                    <tr class="pagination-row">
                        <td colspan="8">
                            <div class="pagination-container">
                                <button class="btn-page">|&lt;</button>
                                <button class="btn-page">&lt;</button>
                                <span class="page-info">Page 1 of 1</span>
                                <button class="btn-page">&gt;</button>
                                <button class="btn-page">&gt;|</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
