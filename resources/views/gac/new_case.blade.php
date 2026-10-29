<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Caso</title>

    <link rel="stylesheet" href="{{ asset('css/emer_tipi.css') }}">
    <script src="{{ asset('js/template.js') }}" defer></script>
</head>

<body>

    <div class="header-title">
        <div class="header-icon"></div>
        <h2>Nuevo Caso</h2>
    </div>

    <form action="{{ route('casos.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
        @csrf
        <input type="hidden" name="abonado_id" value="{{ $abonadoId }}">

        <div class="layout-grid">

            <!-- COLUMNA IZQUIERDA -->
            <div class="col-left">
                <!-- Cliente -->
                <div class="form-row">
                    <span class="lbl-left">Cliente:</span>
                    <div class="lbl-val">
                        <span class="val-text">{{ $clienteId ?? '---' }}</span>
                        <button type="button" class="btn-gac">Seleccionar Abonados</button>
                    </div>
                </div>

                <!-- Nombre Contacto -->
                <div class="form-row">
                    <span class="lbl-left">Nombre Contacto:</span>
                    <div class="lbl-val">
                        <span>{{ $nombre ?? '' }}</span>
                    </div>
                </div>

                <!-- Teléfono Contacto -->
                <div class="form-row">
                    <span class="lbl-left">Teléfono Contacto:</span>
                    <div class="lbl-val">
                        <span>{{ $telefono ?? '' }}</span>
                    </div>
                </div>

                <!-- Buscar Tipología -->
                <div class="form-row" style="margin-top: 10px;">
                    <span class="lbl-left">Buscar Tipología:</span>
                    <div class="lbl-val">
                        <input type="text" id="txtBuscarTipologia" class="input-gac" style="width: 250px;">
                        <button type="button" class="btn-gac btn-x"
                            onclick="document.getElementById('txtBuscarTipologia').value=''">X</button>
                    </div>
                </div>

                <!-- 1. Tipo -->
                <div class="form-row">
                    <span class="lbl-left">* Tipo:</span>
                    <div class="lbl-val">
                        <select id="select_tipo" name="tipo_id" class="select-gac" required>
                            <option value="">Seleccionar ---</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 2. Categoría (Oculto inicialmente) -->
                <div class="form-row" id="row_categoria" style="display: none;">
                    <span class="lbl-left">* Categoría:</span>
                    <div class="lbl-val">
                        <select id="select_categoria" name="categoria_id" class="select-gac" required>
                            <option value="">Seleccionar ---</option>
                        </select>
                    </div>
                </div>

                <!-- 3. Tipología (Oculto inicialmente) -->
                <div class="form-row" id="row_tipologia" style="display: none;">
                    <span class="lbl-left">* Tipología:</span>
                    <div class="lbl-val">
                        <select id="select_tipologia" name="tipologia_id" class="select-gac" required>
                            <option value="">Seleccionar ---</option>
                        </select>
                    </div>
                </div>
                <!-- Bloque condicional de Campos de Venta -->
                <div id="bloque-campos-venta" style="display: none;">
                    <div class="form-row">
                        <span class="lbl-left">¿Tipo de venta?:</span>
                        <div class="lbl-val">
                            <select name="tipo_venta" class="select-gac">
                                <option value="">Seleccionar ---</option>
                                <option value="EQUIPO INCLUIDO APC B-">EQUIPO INCLUIDO APC B-</option>
                                <option value="EQUIPO INCLUIDO APC B-">EQUIPO INCLUIDO APC C</option>
                                <option value="EQUIPO INCLUIDO APC B-">EQUIPO INCLUIDO APC D</option>
                                <option value="EQUIPO A CUOUTAS APC B-">EQUIPO A CUOTAS APC B-</option>
                                <option value="EQUIPO A CUOUTAS APC C">EQUIPO A CUOTAS APC C</option>
                                <option value="EQUIPO A CUOUTAS APC D">EQUIPO A CUOTAS APC D</option>
                                <!-- Agrega aquí las opciones que necesites -->
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <span class="lbl-left">* ¿Que lo motivo a visitar nuestra tienda?:</span>
                        <div class="lbl-val">
                            <select name="motivo_visita" class="select-gac">
                                <option value="">Seleccionar ---</option>
                                <option value="VOLANTE EN CALLE">VOLANTE EN CALLE</option>
                                <option value="PUBLICIDAD RADIO">PUBLICIDAD RADIO</option>
                                <option value="PUBLICIDAD TV">PUBLICIDAD TV</option>
                                <option value="PUBLICIDAD PERIODICO">PUBLICIDAD PERIODICO</option>
                                <option value="PUBLICIDAD CORREO ELECTRONICO">PUBLICIDAD CORREO ELECTRONICO</option>
                                <option value="PAGINA WEB">PAGINA WEB</option>
                                <option value="INTERES PROPIO"> INTERES PROPIO</option>
                                <option value="REFERIDO DE ALGUIEN">REFERIDO DE ALGUIEN</option>
                                <option value="REDES SOCIALES">REDES SOCIALES</option>
                                <option value="SMS PROMOCIONAL">SMS PROMOCIONAL</option>
                                <option value="TELEMARKETING">TELEMARKETING</option>
                                <!-- Agrega aquí las opciones que necesites -->
                            </select>
                        </div>
                    </div>
                </div>

                <!-- BLOQUE DE CAMPOS TÉCNICOS ADICIONALES (Oculto inicialmente) -->
                <div id="bloque_campos_tecnicos" style="display: none;">

                    <!-- Provincia -->
                    <div class="form-row">
                        <span class="lbl-left">* ¿Provincia?:</span>
                        <div class="lbl-val">
                            <select name="provincia_id" class="select-gac">
                                <option value="">Seleccionar ---</option>
                                @foreach ($provincias as $provincia)
                                    <option value="{{ $provincia->id }}">{{ $provincia->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Ubicación -->
                    <div class="form-row">
                        <span class="lbl-left">¿Ubicación?:<br><span
                                style="font-size: 11px; font-weight: normal;">(lugar específico / punto de
                                referencia)</span></span>
                        <div class="lbl-val">
                            <textarea name="ubicacion" class="textarea-gac" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Coordenadas -->
                    <div class="form-row">
                        <span class="lbl-left">¿Coordenadas?:</span>
                        <div class="lbl-val">
                            <textarea name="coordenadas" class="textarea-gac" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Fecha del inconveniente -->
                    <div class="form-row">
                        <span class="lbl-left">* ¿Desde qué fecha presenta el inconveniente?<br>(DD/MM/AAAA):</span>
                        <div class="lbl-val">
                            <input type="date" name="fecha_inconveniente" class="input-gac">
                        </div>
                    </div>

                    <!-- Estado en CBS -->
                    <div class="form-row">
                        <span class="lbl-left">* Estado en CBS:</span>
                        <div class="lbl-val">
                            <select name="estado_cbs" class="select-gac">
                                <option value="">Seleccionar ---</option>
                                <option value="Activo">Activo</option>
                                <option value="Preactivo">Preactivo</option>
                                <option value="Precarga">Precarga</option>
                            </select>
                        </div>
                    </div>

                    <!-- Registro en SGSN -->
                    <div class="form-row">
                        <span class="lbl-left">* ¿Registro en SGSN?:</span>
                        <div class="lbl-val">
                            <select name="registro_sgsn" class="select-gac">
                                <option value="">Seleccionar ---</option>
                                <option value="REGISTRADO">REGISTRADO</option>
                                <option value="UNKNOWN">UNKNOWN</option>
                                <option value="PURGED">PURGED</option>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Descripción del Caso -->
                <div class="block-row" style="margin-top: 15px;">
                    <label class="lbl-block">Descripción del Caso (Dada por el cliente):</label>
                    <textarea name="descripcion_cliente" class="textarea-gac" rows="4" required></textarea>
                </div>

                <!-- Comentario del ejecutivo -->
                <div class="block-row" style="margin-top: 10px;">
                    <label class="lbl-block">* Comentario del ejecutivo:</label>
                    <textarea name="comentario_ejecutivo" class="textarea-gac" rows="4" required></textarea>
                </div>

                <div class="campo-obligatorio">* Campo obligatorio</div>
            </div>

            <!-- COLUMNA DERECHA (Oculta inicialmente hasta seleccionar Tipología Nivel 3) -->
            <div class="col-right" id="col_derecha_opciones" style="display: none;">

                <div class="row-buzon">
                    <label class="lbl-bold">Acción:</label>
                    <span class="lbl-buzon">Buzón:</span>
                </div>
                <select id="campo_accion" name="accion" class="select-gac-right">
                    <option value="">Seleccionar ---</option>
                    <option value="Caso resuelto">Caso resuelto</option>
                    <option value="Escalamiento">Escalamiento</option>
                </select>

                <div style="margin-top: 10px;">
                    <label class="lbl-bold">* Solución del caso:</label>
                    <textarea id="campo_solucion" name="solucion" class="textarea-gac" rows="4"></textarea>
                </div>

                <div style="margin-top: 12px;">
                    <label class="lbl-bold">Clasificación:</label>
                    <div class="lbl-sub">¿Este reclamo lleva ajuste o recarga?</div>

                    <div class="radio-group" style="margin-top: 5px;">
                        <label class="radio-label">
                            <input type="radio" name="lleva_ajuste" value="SI"> SI
                        </label>
                        <span class="inline-input">N. Crédito: <input type="text" name="n_credito"
                                class="input-inline"></span>
                        <span class="inline-input">Monto: <input type="text" name="monto"
                                class="input-inline"></span>
                    </div>

                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="lleva_ajuste" value="NO"> NO
                        </label>
                    </div>

                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="lleva_ajuste" value="NO_APLICA"> No aplica el reclamo
                        </label>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <label class="lbl-bold">Tipos de Cierre:</label>
                    <div class="checkbox-group" style="margin-top: 6px;">
                        <label class="check-label"><input type="checkbox" name="tipo_cierre[]" value="CALL BACK">
                            CALL BACK</label>
                        <label class="check-label"><input type="checkbox" name="tipo_cierre[]"
                                value="CASO RESUELTO"> CASO RESUELTO</label>
                        <label class="check-label"><input type="checkbox" name="tipo_cierre[]" value="INCIDENCIA 1">
                            INCIDENCIA 1</label>
                    </div>
                </div>

            </div>
        </div>

        <!-- Botones Inferiores -->
        <div class="footer-actions">
            <div class="btn-group-center">
                <button type="button" class="btn-gac" onclick="window.close()">Cerrar</button>
                <button type="button" class="btn-gac"
                    onclick="document.getElementById('inputAdjunto').click()">Adjuntar archivos</button>
                <input type="file" id="inputAdjunto" name="archivos[]" multiple style="display: none;">
                <button type="submit" class="btn-gac">Procesar solicitud</button>
            </div>
            <!-- El botón Enviar SMS también se oculta/muestra dinámicamente -->
            <button type="button" id="btn_enviar_sms" class="btn-gac btn-sms" style="display: none;">Enviar
                SMS</button>
        </div>
    </form>

</body>

</html>
