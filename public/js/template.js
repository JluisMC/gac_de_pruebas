function toggleSection(contentId, iconId) {
    const content = document.getElementById(contentId);
    const icon = document.getElementById(iconId);

    if (!content || !icon) return;

    if (content.style.display === "none" || content.style.display === "") {
        content.style.display = "block";
        icon.textContent = "︽";
    } else {
        content.style.display = "none";
        icon.textContent = "︾";
    }
}

// --- FUNCIONES GLOBALES (Invocadas directamente desde atributos HTML onclick/onchange) ---

function abrirCalendario(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        if ('showPicker' in HTMLInputElement.prototype) {
            input.showPicker();
        } else {
            input.focus();
        }
    }
}

function actualizarTextoFecha(dateInputId, textInputId) {
    const dateInput = document.getElementById(dateInputId);
    const textInput = document.getElementById(textInputId);
    if (dateInput && textInput && dateInput.value) {
        const parts = dateInput.value.split('-'); // Formato HTML5: YYYY-MM-DD
        if (parts.length === 3) {
            textInput.value = `${parts[2]}/${parts[1]}/${parts[0]}`; // Formato desplegado: DD/MM/YYYY
        }
    }
}

function abrirDetalle(id) {
    const url = `/casos/detalle/${id}`;
    const width = 900;
    const height = 650;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;

    window.open(
        url,
        'DetalleCasoPopup',
        `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes`
    );
}

// --- EVENTOS AL CARGAR EL DOM ---

document.addEventListener('DOMContentLoaded', function () {

   document.getElementById('txtUsuario').addEventListener('input', function (e) {
            this.value = this.value.toUpperCase();
        }); 

    // --- 1. LÓGICA VISTA PRINCIPAL (Abrir Pop-Up Ingresar Solicitud) ---
    const btnIngresarSolicitud = document.getElementById('btnIngresarSolicitud');

    if (btnIngresarSolicitud) {
        btnIngresarSolicitud.addEventListener('click', function () {
            const clienteId = document.getElementById('lblNoCliente')?.innerText.trim();
            const nombre = document.getElementById('lblNombreCliente')?.innerText.trim();
            const telefono = document.getElementById('lblTelContacto')?.innerText.trim();
            const abonadoId = document.getElementById('lblNoAbonado')?.innerText.trim();

            if (!clienteId || clienteId === '---' || clienteId === '') {
                alert('Debe buscar e ingresar un número de celular/cliente antes de ingresar una solicitud.');
                return;
            }

            const params = new URLSearchParams({
                cliente_id: clienteId,
                nombre: nombre || 'N/A',
                telefono: telefono || 'N/A',
                abonado_id: abonadoId || ''
            });

            const url = `/casos/crear?${params.toString()}`;
            const opciones = 'width=780,height=600,scrollbars=yes,resizable=yes,status=no,toolbar=no,menubar=no,location=no';

            window.open(url, 'CreacionCasoGAC', opciones);
        });
    }

    // --- 2. LÓGICA VISTA PRINCIPAL (Abrir Pop-Up Consulta Histórica) ---
    const btnConsultaHistorica = document.getElementById('btnConsultaHistorica');

    if (btnConsultaHistorica) {
        btnConsultaHistorica.addEventListener('click', function () {
            const clienteId = document.getElementById('lblNoCliente')?.innerText.trim();
            const valorInput = document.getElementById('edValor')?.value.trim() || '';
            const criterioInput = document.getElementById('cbCriterio')?.value || 'celular';

            if (!clienteId || clienteId === '---' || clienteId === '' || (!valorInput && criterioInput === 'celular')) {
                alert('Debe buscar e ingresar un número de celular/cliente antes de consultar el historial.');
                return;
            }

            const url = `/casos/consulta-historica?criterio=${encodeURIComponent(criterioInput)}&valor=${encodeURIComponent(valorInput)}`;

            const width = 1100;
            const height = 550;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;

            window.open(
                url,
                'ConsultaHistoricaPopup',
                `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes`
            );
        });
    }

    // --- 3. LÓGICA VENTANA EMERGENTE (Cascada de Tipologías y Campos Dinámicos) ---
    const selectTipo = document.getElementById('select_tipo');
    const selectCategoria = document.getElementById('select_categoria');
    const selectTipologia = document.getElementById('select_tipologia');

    const rowCategoria = document.getElementById('row_categoria');
    const rowTipologia = document.getElementById('row_tipologia');
    const colDerechaOpciones = document.getElementById('col_derecha_opciones');
    const btnEnviarSms = document.getElementById('btn_enviar_sms');
    const bloqueCamposTecnicos = document.getElementById('bloque_campos_tecnicos');
    const bloqueVenta = document.getElementById('bloque-campos-venta');

    // Función para evaluar los campos de venta (Trámite -> Venta -> Requiere Nivel 3 específico)
    function evaluarCamposVenta() {
        if (!selectTipo || !selectCategoria || !selectTipologia || !bloqueVenta) return;

        const tipoText = selectTipo.options[selectTipo.selectedIndex]?.text.trim().toUpperCase() || '';
        const categoriaText = selectCategoria.options[selectCategoria.selectedIndex]?.text.trim().toUpperCase() || '';
        const tipologiaId = selectTipologia.value; // Obtenemos el ID seleccionado del Nivel 3
        const tipologiaText = selectTipologia.options[selectTipologia.selectedIndex]?.text.trim().toUpperCase() || '';

        // Condición: Nivel 1 es TRAMITE, Nivel 2 es VENTA, hay un Nivel 3 seleccionado, y NO es adquisición de paquete
        const esTramiteVenta = (tipoText === 'TRAMITE' && categoriaText === 'VENTA');
        const esAdquisicionPaquete = (tipologiaText.includes('ADQUISICION') && tipologiaText.includes('PAQUETE'));

        if (esTramiteVenta && tipologiaId && !esAdquisicionPaquete) {
            bloqueVenta.style.display = 'block';
        } else {
            bloqueVenta.style.display = 'none';
        }
    }

    if (selectTipo && selectCategoria && selectTipologia) {

        selectTipo.addEventListener('change', function () {
            const tipoId = this.value;

            selectCategoria.innerHTML = '<option value="">Seleccionar ---</option>';
            selectTipologia.innerHTML = '<option value="">Seleccionar ---</option>';

            if (rowCategoria) rowCategoria.style.display = 'none';
            if (rowTipologia) rowTipologia.style.display = 'none';
            if (colDerechaOpciones) colDerechaOpciones.style.display = 'none';
            if (btnEnviarSms) btnEnviarSms.style.display = 'none';
            if (bloqueCamposTecnicos) bloqueCamposTecnicos.style.display = 'none';
            if (bloqueVenta) bloqueVenta.style.display = 'none';

            if (tipoId) {
                fetch(`/api/categorias/${tipoId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            if (rowCategoria) rowCategoria.style.display = 'flex';
                            data.forEach(item => {
                                selectCategoria.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
                            });
                        }
                    })
                    .catch(err => console.error('Error al cargar categorías:', err));
            }
            evaluarCamposVenta();
        });

        selectCategoria.addEventListener('change', function () {
            const categoriaId = this.value;

            selectTipologia.innerHTML = '<option value="">Seleccionar ---</option>';

            if (rowTipologia) rowTipologia.style.display = 'none';
            if (colDerechaOpciones) colDerechaOpciones.style.display = 'none';
            if (btnEnviarSms) btnEnviarSms.style.display = 'none';
            if (bloqueCamposTecnicos) bloqueCamposTecnicos.style.display = 'none';
            if (bloqueVenta) bloqueVenta.style.display = 'none';

            if (categoriaId) {
                fetch(`/api/tipologias/${categoriaId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            if (rowTipologia) rowTipologia.style.display = 'flex';
                            data.forEach(item => {
                                selectTipologia.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
                            });
                        }
                    })
                    .catch(err => console.error('Error al cargar tipologías:', err));
            }
            evaluarCamposVenta();
        });

        selectTipologia.addEventListener('change', function () {
            const tipologiaId = this.value;

            // Obtener el texto de la categoría seleccionada (Nivel 2) en mayúsculas
            const categoriaText = selectCategoria.options[selectCategoria.selectedIndex]?.text.trim().toUpperCase() || '';
            const categoriasTecnicas = ['DATA', 'COMUNICACIÓN', 'RED', 'ROAMING'];

            if (tipologiaId) {
                if (colDerechaOpciones) colDerechaOpciones.style.display = 'block';
                if (btnEnviarSms) btnEnviarSms.style.display = 'inline-block';

                // Mostrar campos técnicos solo si la categoría seleccionada coincide con la lista
                if (bloqueCamposTecnicos) {
                    if (categoriasTecnicas.includes(categoriaText)) {
                        bloqueCamposTecnicos.style.display = 'block';
                    } else {
                        bloqueCamposTecnicos.style.display = 'none';
                    }
                }
            } else {
                if (colDerechaOpciones) colDerechaOpciones.style.display = 'none';
                if (btnEnviarSms) btnEnviarSms.style.display = 'none';
                if (bloqueCamposTecnicos) bloqueCamposTecnicos.style.display = 'none';
            }

            // Evaluar la lógica de los campos de venta
            evaluarCamposVenta();
        });
    }
});