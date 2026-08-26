<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Facturador SUNAT Peru') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700|ibm-plex-mono:400,500,600" rel="stylesheet">
    <style>
        :root {
            --paper: #f7f3ea;
            --ink: #1c2328;
            --muted: #65717c;
            --line: #d9d1c2;
            --panel: #fffaf1;
            --panel-strong: #f0eadf;
            --blue: #005eb8;
            --blue-dark: #00457f;
            --red: #c93d2b;
            --green: #117a54;
            --mono: "IBM Plex Mono", ui-monospace, SFMono-Regular, Menlo, monospace;
            --sans: "IBM Plex Sans", Aptos, "Segoe UI", sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            background:
                linear-gradient(90deg, rgba(0, 94, 184, .06) 1px, transparent 1px),
                linear-gradient(rgba(0, 94, 184, .05) 1px, transparent 1px),
                var(--paper);
            background-size: 28px 28px;
            font-family: var(--sans);
            letter-spacing: 0;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        .shell {
            display: grid;
            grid-template-columns: 320px minmax(0, 1fr);
            min-height: 100vh;
        }

        .rail {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: auto;
            border-right: 1px solid var(--line);
            background: rgba(255, 250, 241, .88);
            padding: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .brand-mark {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            border: 2px solid var(--ink);
            border-radius: 8px;
            background: #fff;
            font-weight: 700;
            color: var(--blue);
        }

        .brand h1 {
            margin: 0;
            font-size: 21px;
            line-height: 1.08;
        }

        .brand span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            margin-top: 4px;
        }

        .status-stack {
            display: grid;
            gap: 8px;
            margin-bottom: 22px;
        }

        .status-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fffdf8;
            padding: 10px 12px;
            font-size: 13px;
        }

        .pill {
            border-radius: 999px;
            padding: 4px 8px;
            font: 600 11px/1 var(--mono);
            text-transform: uppercase;
        }

        .pill.idle {
            background: #e6e0d3;
            color: #4c4a45;
        }

        .pill.ok {
            background: #dff1e7;
            color: var(--green);
        }

        .pill.warn {
            background: #f5e6bd;
            color: #75510b;
        }

        .pill.bad {
            background: #f5d5d0;
            color: var(--red);
        }

        .nav {
            display: grid;
            gap: 7px;
            margin: 0 0 24px;
            padding: 0;
            list-style: none;
        }

        .nav button {
            width: 100%;
            border: 1px solid transparent;
            border-radius: 8px;
            background: transparent;
            padding: 11px 12px;
            text-align: left;
            font-weight: 600;
            color: #303941;
        }

        .nav button.active,
        .nav button:hover {
            border-color: var(--line);
            background: var(--panel-strong);
        }

        .rail footer {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.45;
        }

        main {
            padding: 28px;
            overflow: hidden;
        }

        .topbar {
            display: flex;
            gap: 16px;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .topbar h2 {
            margin: 0;
            font-size: 30px;
            line-height: 1.05;
        }

        .topbar p {
            margin: 7px 0 0;
            max-width: 740px;
            color: var(--muted);
            line-height: 1.45;
        }

        .base-url {
            width: min(440px, 100%);
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fffdf8;
            padding: 12px;
        }

        .base-url label,
        label {
            display: block;
            color: #4c5964;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 16px;
            align-items: start;
        }

        .panel {
            grid-column: span 6;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: rgba(255, 250, 241, .94);
            overflow: hidden;
        }

        .panel.wide {
            grid-column: span 12;
        }

        .panel.narrow {
            grid-column: span 4;
        }

        .panel.medium {
            grid-column: span 8;
        }

        .panel-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            background: #f1eadc;
        }

        .panel-head h3 {
            margin: 0;
            font-size: 16px;
        }

        .panel-body {
            padding: 16px;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .field-grid.three {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .field {
            display: grid;
            gap: 6px;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid #cfc5b3;
            border-radius: 7px;
            background: #fffdf8;
            color: var(--ink);
            padding: 10px 11px;
            outline: none;
        }

        input:focus,
        textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0, 94, 184, .16);
        }

        textarea {
            min-height: 260px;
            resize: vertical;
            font-family: var(--mono);
            font-size: 12px;
            line-height: 1.5;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 14px;
        }

        .btn {
            border: 1px solid var(--ink);
            border-radius: 8px;
            background: var(--ink);
            color: #fff;
            padding: 10px 13px;
            font-weight: 700;
        }

        .btn.secondary {
            background: #fffdf8;
            color: var(--ink);
        }

        .btn.blue {
            border-color: var(--blue-dark);
            background: var(--blue);
        }

        .btn.green {
            border-color: #0f6648;
            background: var(--green);
        }

        .btn.red {
            border-color: #9f2c20;
            background: var(--red);
        }

        .mini-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .mini-table th,
        .mini-table td {
            border-bottom: 1px solid var(--line);
            padding: 9px 8px;
            text-align: left;
            vertical-align: top;
        }

        .mini-table th {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
        }

        .result {
            min-height: 360px;
            max-height: 68vh;
            overflow: auto;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #171b1f;
            color: #eaf1f7;
            padding: 14px;
            font: 12px/1.55 var(--mono);
            white-space: pre-wrap;
        }

        .split-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 12px;
        }

        .hint {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.4;
        }

        @media (max-width: 980px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .rail {
                position: relative;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }

            .topbar {
                flex-direction: column;
            }

            .panel,
            .panel.narrow,
            .panel.medium {
                grid-column: span 12;
            }
        }

        @media (max-width: 640px) {
            main {
                padding: 18px;
            }

            .field-grid,
            .field-grid.three {
                grid-template-columns: 1fr;
            }

            .topbar h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
<div class="shell">
    <aside class="rail">
        <div class="brand">
            <div class="brand-mark">CPE</div>
            <div>
                <h1>Facturador SUNAT</h1>
                <span>Panel de pruebas API</span>
            </div>
        </div>

        <div class="status-stack">
            <div class="status-line">
                <span>API</span>
                <strong id="apiStatus" class="pill idle">sin probar</strong>
            </div>
            <div class="status-line">
                <span>Token</span>
                <strong id="tokenStatus" class="pill idle">vacio</strong>
            </div>
            <div class="status-line">
                <span>Empresa</span>
                <strong id="companyStatus" class="pill idle">sin datos</strong>
            </div>
        </div>

        <ul class="nav">
            <li><button class="active" data-tab="setup">Setup</button></li>
            <li><button data-tab="documents">Documentos</button></li>
            <li><button data-tab="payloads">Payloads</button></li>
            <li><button data-tab="responses">Respuestas</button></li>
        </ul>

        <footer>
            UBL 2.1, factura serie F, boleta serie B, moneda PEN y ambiente beta por defecto.
        </footer>
    </aside>

    <main>
        <div class="topbar">
            <div>
                <h2>Banco de pruebas operativo</h2>
                <p>Flujo minimo para levantar base, autenticar, registrar empresa beta y crear comprobantes con reglas comunes de SUNAT Peru.</p>
            </div>
            <div class="base-url">
                <label for="baseUrl">Base URL</label>
                <input id="baseUrl" autocomplete="off">
            </div>
        </div>

        <section id="setup" class="section active">
            <div class="grid">
                <article class="panel">
                    <div class="panel-head">
                        <h3>Sistema</h3>
                        <span class="pill warn">publico</span>
                    </div>
                    <div class="panel-body">
                        <div class="actions">
                            <button class="btn blue" id="checkStatusBtn">Estado</button>
                            <button class="btn secondary" id="migrateBtn">Migrar</button>
                            <button class="btn secondary" id="seedBtn">Seeders</button>
                        </div>
                    </div>
                </article>

                <article class="panel">
                    <div class="panel-head">
                        <h3>Sesion</h3>
                        <span class="pill warn">sanctum</span>
                    </div>
                    <div class="panel-body">
                        <div class="field-grid">
                            <div class="field">
                                <label for="userName">Nombre</label>
                                <input id="userName" value="Admin SUNAT">
                            </div>
                            <div class="field">
                                <label for="userEmail">Email</label>
                                <input id="userEmail" type="email" value="admin@demo.pe">
                            </div>
                            <div class="field">
                                <label for="userPassword">Clave</label>
                                <input id="userPassword" type="password" value="Admin1234">
                            </div>
                            <div class="field">
                                <label for="token">Bearer token</label>
                                <input id="token" autocomplete="off">
                            </div>
                        </div>
                        <div class="actions">
                            <button class="btn green" id="initializeBtn">Initialize</button>
                            <button class="btn blue" id="loginBtn">Login</button>
                            <button class="btn secondary" id="meBtn">Me</button>
                            <button class="btn red" id="clearTokenBtn">Limpiar token</button>
                        </div>
                    </div>
                </article>

                <article class="panel wide">
                    <div class="panel-head">
                        <h3>Empresa beta</h3>
                        <span class="pill idle">emisor</span>
                    </div>
                    <div class="panel-body">
                        <div class="field-grid three">
                            <div class="field">
                                <label for="companyRuc">RUC</label>
                                <input id="companyRuc" value="20161515648" maxlength="11">
                            </div>
                            <div class="field">
                                <label for="companyName">Razon social</label>
                                <input id="companyName" value="EMPRESA DE PRUEBA SUNAT">
                            </div>
                            <div class="field">
                                <label for="companyTrade">Nombre comercial</label>
                                <input id="companyTrade" value="PRUEBAS CPE">
                            </div>
                            <div class="field">
                                <label for="companyAddress">Direccion</label>
                                <input id="companyAddress" value="AV. LIMA 123">
                            </div>
                            <div class="field">
                                <label for="companyUbigeo">Ubigeo</label>
                                <input id="companyUbigeo" value="150101" maxlength="6">
                            </div>
                            <div class="field">
                                <label for="companyDistrict">Distrito</label>
                                <input id="companyDistrict" value="LIMA">
                            </div>
                            <div class="field">
                                <label for="companyProvince">Provincia</label>
                                <input id="companyProvince" value="LIMA">
                            </div>
                            <div class="field">
                                <label for="companyDepartment">Departamento</label>
                                <input id="companyDepartment" value="LIMA">
                            </div>
                            <div class="field">
                                <label for="solUser">Usuario SOL</label>
                                <input id="solUser" value="MODDATOS">
                            </div>
                            <div class="field">
                                <label for="solPassword">Clave SOL</label>
                                <input id="solPassword" type="password" value="moddatos">
                            </div>
                            <div class="field">
                                <label for="companyEmail">Email</label>
                                <input id="companyEmail" type="email" value="facturacion@demo.pe">
                            </div>
                            <div class="field">
                                <label for="companyPhone">Telefono</label>
                                <input id="companyPhone" value="999999999">
                            </div>
                        </div>
                        <div class="actions">
                            <button class="btn green" id="setupCompanyBtn">Guardar setup</button>
                            <button class="btn blue" id="loadCompaniesBtn">Cargar empresas</button>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section id="documents" class="section">
            <div class="grid">
                <article class="panel wide">
                    <div class="panel-head">
                        <h3>Contexto</h3>
                        <span class="pill idle">IDs</span>
                    </div>
                    <div class="panel-body">
                        <div class="field-grid three">
                            <div class="field">
                                <label for="companyId">Empresa ID</label>
                                <input id="companyId" inputmode="numeric">
                            </div>
                            <div class="field">
                                <label for="branchId">Sucursal ID</label>
                                <input id="branchId" inputmode="numeric">
                            </div>
                            <div class="field">
                                <label for="issueDate">Fecha emision</label>
                                <input id="issueDate" type="date">
                            </div>
                        </div>
                    </div>
                </article>

                <article class="panel">
                    <div class="panel-head">
                        <h3>Factura 01</h3>
                        <span class="pill idle">F001</span>
                    </div>
                    <div class="panel-body">
                        <div class="field-grid">
                            <div class="field">
                                <label for="invoiceSerie">Serie</label>
                                <input id="invoiceSerie" value="F001" maxlength="4">
                            </div>
                            <div class="field">
                                <label for="invoiceClientDoc">RUC cliente</label>
                                <input id="invoiceClientDoc" value="20600055519" maxlength="11">
                            </div>
                            <div class="field">
                                <label for="invoiceClientName">Cliente</label>
                                <input id="invoiceClientName" value="CLIENTE FACTURA DEMO SAC">
                            </div>
                            <div class="field">
                                <label for="invoicePrice">Valor unitario</label>
                                <input id="invoicePrice" type="number" min="0" step="0.01" value="100.00">
                            </div>
                        </div>
                        <div class="actions">
                            <button class="btn secondary" id="buildInvoiceBtn">Preparar JSON</button>
                            <button class="btn green" id="createInvoiceBtn">Crear factura</button>
                            <button class="btn blue" id="pdfInvoiceBtn">PDF A4</button>
                            <button class="btn red" id="sendInvoiceBtn">Enviar SUNAT</button>
                        </div>
                    </div>
                </article>

                <article class="panel">
                    <div class="panel-head">
                        <h3>Boleta 03</h3>
                        <span class="pill idle">B001</span>
                    </div>
                    <div class="panel-body">
                        <div class="field-grid">
                            <div class="field">
                                <label for="boletaSerie">Serie</label>
                                <input id="boletaSerie" value="B001" maxlength="4">
                            </div>
                            <div class="field">
                                <label for="boletaClientDoc">DNI cliente</label>
                                <input id="boletaClientDoc" value="12345678" maxlength="8">
                            </div>
                            <div class="field">
                                <label for="boletaClientName">Cliente</label>
                                <input id="boletaClientName" value="CONSUMIDOR DEMO">
                            </div>
                            <div class="field">
                                <label for="boletaPrice">Valor unitario</label>
                                <input id="boletaPrice" type="number" min="0" step="0.01" value="35.00">
                            </div>
                        </div>
                        <div class="actions">
                            <button class="btn secondary" id="buildBoletaBtn">Preparar JSON</button>
                            <button class="btn green" id="createBoletaBtn">Crear boleta</button>
                            <button class="btn blue" id="pdfBoletaBtn">PDF ticket</button>
                            <button class="btn red" id="sendBoletaBtn">Enviar SUNAT</button>
                        </div>
                    </div>
                </article>

                <article class="panel wide">
                    <div class="panel-head">
                        <h3>Empresas cargadas</h3>
                        <span class="pill idle" id="companyCount">0</span>
                    </div>
                    <div class="panel-body">
                        <table class="mini-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>RUC</th>
                                <th>Razon social</th>
                                <th>Sucursales</th>
                                <th>Modo</th>
                            </tr>
                            </thead>
                            <tbody id="companiesTable">
                            <tr><td colspan="5">Sin datos</td></tr>
                            </tbody>
                        </table>
                    </div>
                </article>
            </div>
        </section>

        <section id="payloads" class="section">
            <div class="grid">
                <article class="panel">
                    <div class="panel-head">
                        <h3>Factura JSON</h3>
                        <span class="pill idle">request</span>
                    </div>
                    <div class="panel-body">
                        <textarea id="invoicePayload"></textarea>
                        <div class="actions">
                            <button class="btn green" id="createInvoiceFromJsonBtn">Crear desde JSON</button>
                        </div>
                    </div>
                </article>

                <article class="panel">
                    <div class="panel-head">
                        <h3>Boleta JSON</h3>
                        <span class="pill idle">request</span>
                    </div>
                    <div class="panel-body">
                        <textarea id="boletaPayload"></textarea>
                        <div class="actions">
                            <button class="btn green" id="createBoletaFromJsonBtn">Crear desde JSON</button>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section id="responses" class="section">
            <div class="grid">
                <article class="panel medium">
                    <div class="panel-head">
                        <h3>Respuesta</h3>
                        <span class="pill idle" id="lastStatus">sin request</span>
                    </div>
                    <div class="panel-body">
                        <pre id="result" class="result"></pre>
                        <div class="split-actions">
                            <span class="hint" id="lastRequest">Esperando accion</span>
                            <button class="btn secondary" id="clearResultBtn">Limpiar</button>
                        </div>
                    </div>
                </article>

                <article class="panel narrow">
                    <div class="panel-head">
                        <h3>Ultimos IDs</h3>
                        <span class="pill idle">local</span>
                    </div>
                    <div class="panel-body">
                        <div class="status-stack">
                            <div class="status-line">
                                <span>Factura</span>
                                <strong id="lastInvoiceId" class="pill idle">-</strong>
                            </div>
                            <div class="status-line">
                                <span>Boleta</span>
                                <strong id="lastBoletaId" class="pill idle">-</strong>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </main>
</div>

<script>
    const state = {
        baseUrl: localStorage.getItem('sunatApiBase') || window.location.origin,
        token: localStorage.getItem('sunatToken') || '',
        lastInvoiceId: localStorage.getItem('lastInvoiceId') || '',
        lastBoletaId: localStorage.getItem('lastBoletaId') || '',
    };

    const $ = (id) => document.getElementById(id);

    const today = new Date();
    $('issueDate').value = today.toISOString().slice(0, 10);
    $('baseUrl').value = state.baseUrl;
    $('token').value = state.token;
    $('lastInvoiceId').textContent = state.lastInvoiceId || '-';
    $('lastBoletaId').textContent = state.lastBoletaId || '-';

    function setPill(el, label, type = 'idle') {
        el.textContent = label;
        el.className = `pill ${type}`;
    }

    function updateStateBadges() {
        const hasCompany = $('companyId').value && $('branchId').value;
        setPill($('tokenStatus'), state.token ? 'activo' : 'vacio', state.token ? 'ok' : 'idle');
        setPill($('companyStatus'), hasCompany ? 'listo' : 'sin datos', hasCompany ? 'ok' : 'idle');
    }

    function setResult(label, response) {
        setPill($('lastStatus'), String(response.status || 'local'), response.ok ? 'ok' : 'bad');
        $('lastRequest').textContent = label;
        $('result').textContent = JSON.stringify(response.data ?? response.text ?? response, null, 2);
        document.querySelector('[data-tab="responses"]').click();
    }

    async function api(path, options = {}) {
        const base = $('baseUrl').value.replace(/\/$/, '');
        state.baseUrl = base;
        localStorage.setItem('sunatApiBase', base);

        const headers = {
            Accept: 'application/json',
            ...(options.headers || {}),
        };

        let body = options.body;
        if (body && !(body instanceof FormData) && typeof body !== 'string') {
            headers['Content-Type'] = 'application/json';
            body = JSON.stringify(body);
        }

        if (state.token) {
            headers.Authorization = `Bearer ${state.token}`;
        }

        const response = await fetch(`${base}${path}`, {
            method: options.method || 'GET',
            headers,
            body,
        });

        const text = await response.text();
        let data = text;
        try {
            data = text ? JSON.parse(text) : null;
        } catch (error) {
            data = { raw: text };
        }

        setPill($('apiStatus'), response.ok ? 'ok' : String(response.status), response.ok ? 'ok' : 'bad');
        return { ok: response.ok, status: response.status, data, text };
    }

    async function run(label, fn) {
        try {
            const response = await fn();
            setResult(label, response);
            return response;
        } catch (error) {
            const response = { ok: false, status: 'ERR', data: { message: error.message } };
            setResult(label, response);
            return response;
        } finally {
            updateStateBadges();
        }
    }

    function saveToken(token) {
        state.token = token || '';
        $('token').value = state.token;
        if (state.token) {
            localStorage.setItem('sunatToken', state.token);
        } else {
            localStorage.removeItem('sunatToken');
        }
        updateStateBadges();
    }

    function numberValue(id) {
        return Number($(id).value || 0);
    }

    function commonContext() {
        return {
            company_id: Number($('companyId').value),
            branch_id: Number($('branchId').value),
            fecha_emision: $('issueDate').value,
        };
    }

    function invoicePayload() {
        return {
            ...commonContext(),
            serie: $('invoiceSerie').value.toUpperCase(),
            fecha_vencimiento: $('issueDate').value,
            moneda: 'PEN',
            tipo_operacion: '0101',
            forma_pago_tipo: 'Contado',
            client: {
                tipo_documento: '6',
                numero_documento: $('invoiceClientDoc').value,
                razon_social: $('invoiceClientName').value,
                direccion: 'AV. CLIENTE 456',
                ubigeo: '150101',
                distrito: 'LIMA',
                provincia: 'LIMA',
                departamento: 'LIMA',
            },
            detalles: [
                {
                    codigo: 'SERV-001',
                    descripcion: 'Servicio de prueba gravado',
                    unidad: 'NIU',
                    cantidad: 1,
                    mto_valor_unitario: numberValue('invoicePrice'),
                    porcentaje_igv: 18,
                    tip_afe_igv: '10',
                    codigo_producto_sunat: '81111811',
                },
            ],
            usuario_creacion: 'panel-pruebas',
        };
    }

    function boletaPayload() {
        return {
            ...commonContext(),
            serie: $('boletaSerie').value.toUpperCase(),
            ubl_version: '2.1',
            tipo_operacion: '0101',
            moneda: 'PEN',
            metodo_envio: 'individual',
            forma_pago_tipo: 'Contado',
            client: {
                tipo_documento: '1',
                numero_documento: $('boletaClientDoc').value,
                razon_social: $('boletaClientName').value,
                direccion: 'LIMA',
            },
            detalles: [
                {
                    codigo: 'PROD-001',
                    descripcion: 'Producto de prueba gravado',
                    unidad: 'NIU',
                    cantidad: 1,
                    mto_valor_unitario: numberValue('boletaPrice'),
                    porcentaje_igv: 18,
                    tip_afe_igv: '10',
                    factor_icbper: 0,
                },
            ],
            usuario_creacion: 'panel-pruebas',
        };
    }

    function refreshPayloads() {
        $('invoicePayload').value = JSON.stringify(invoicePayload(), null, 2);
        $('boletaPayload').value = JSON.stringify(boletaPayload(), null, 2);
    }

    function setupPayload() {
        return {
            environment: 'beta',
            modo_produccion: false,
            activo: true,
            company: {
                ruc: $('companyRuc').value,
                razon_social: $('companyName').value,
                nombre_comercial: $('companyTrade').value,
                direccion: $('companyAddress').value,
                ubigeo: $('companyUbigeo').value,
                distrito: $('companyDistrict').value,
                provincia: $('companyProvince').value,
                departamento: $('companyDepartment').value,
                telefono: $('companyPhone').value,
                email: $('companyEmail').value,
                usuario_sol: $('solUser').value,
                clave_sol: $('solPassword').value,
            },
        };
    }

    function captureCreatedDocument(type, response) {
        const id = response.data?.data?.id;
        if (!id) return;

        if (type === 'invoice') {
            state.lastInvoiceId = String(id);
            localStorage.setItem('lastInvoiceId', state.lastInvoiceId);
            $('lastInvoiceId').textContent = state.lastInvoiceId;
        } else {
            state.lastBoletaId = String(id);
            localStorage.setItem('lastBoletaId', state.lastBoletaId);
            $('lastBoletaId').textContent = state.lastBoletaId;
        }
    }

    function parseJson(id) {
        return JSON.parse($(id).value);
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, (char) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        }[char]));
    }

    async function loadCompanies() {
        const response = await api('/api/v1/companies');
        if (!response.ok) return response;

        const companies = response.data?.data || [];
        $('companyCount').textContent = String(companies.length);
        $('companiesTable').innerHTML = companies.length
            ? companies.map((company) => {
                const branchText = (company.branches || [])
                    .map((branch) => `${escapeHtml(branch.id)}: ${escapeHtml(branch.nombre || branch.codigo)}`)
                    .join('<br>') || '-';

                return `<tr>
                    <td>${escapeHtml(company.id)}</td>
                    <td>${escapeHtml(company.ruc)}</td>
                    <td>${escapeHtml(company.razon_social)}</td>
                    <td>${branchText}</td>
                    <td>${company.modo_produccion ? 'produccion' : 'beta'}</td>
                </tr>`;
            }).join('')
            : '<tr><td colspan="5">Sin datos</td></tr>';

        const first = companies[0];
        const branch = first?.branches?.[0];
        if (first && !$('companyId').value) $('companyId').value = first.id;
        if (branch && !$('branchId').value) $('branchId').value = branch.id;
        updateStateBadges();

        return response;
    }

    document.querySelectorAll('[data-tab]').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('[data-tab]').forEach((item) => item.classList.remove('active'));
            document.querySelectorAll('.section').forEach((section) => section.classList.remove('active'));
            button.classList.add('active');
            $(button.dataset.tab).classList.add('active');
        });
    });

    $('checkStatusBtn').addEventListener('click', () => run('GET /api/system/info', () => api('/api/system/info')));
    $('migrateBtn').addEventListener('click', () => run('POST /api/setup/migrate', () => api('/api/setup/migrate', { method: 'POST', body: {} })));
    $('seedBtn').addEventListener('click', () => run('POST /api/setup/seed', () => api('/api/setup/seed', { method: 'POST', body: {} })));

    $('initializeBtn').addEventListener('click', () => run('POST /api/auth/initialize', async () => {
        const response = await api('/api/auth/initialize', {
            method: 'POST',
            body: {
                name: $('userName').value,
                email: $('userEmail').value,
                password: $('userPassword').value,
            },
        });
        if (response.data?.access_token) saveToken(response.data.access_token);
        return response;
    }));

    $('loginBtn').addEventListener('click', () => run('POST /api/auth/login', async () => {
        const response = await api('/api/auth/login', {
            method: 'POST',
            body: {
                email: $('userEmail').value,
                password: $('userPassword').value,
            },
        });
        if (response.data?.access_token) saveToken(response.data.access_token);
        return response;
    }));

    $('meBtn').addEventListener('click', () => run('GET /api/v1/auth/me', () => api('/api/v1/auth/me')));
    $('clearTokenBtn').addEventListener('click', () => {
        saveToken('');
        setResult('local token clear', { ok: true, status: 'LOCAL', data: { token: 'cleared' } });
    });
    $('token').addEventListener('change', () => saveToken($('token').value.trim()));

    $('setupCompanyBtn').addEventListener('click', () => run('POST /api/v1/setup/complete', async () => {
        const response = await api('/api/v1/setup/complete', { method: 'POST', body: setupPayload() });
        if (response.ok) {
            const companyId = response.data?.company?.id;
            const branchId = response.data?.branch?.id;
            if (companyId) $('companyId').value = companyId;
            if (branchId) $('branchId').value = branchId;
            await loadCompanies();
        }
        return response;
    }));

    $('loadCompaniesBtn').addEventListener('click', () => run('GET /api/v1/companies', loadCompanies));

    $('buildInvoiceBtn').addEventListener('click', () => {
        $('invoicePayload').value = JSON.stringify(invoicePayload(), null, 2);
        document.querySelector('[data-tab="payloads"]').click();
    });
    $('buildBoletaBtn').addEventListener('click', () => {
        $('boletaPayload').value = JSON.stringify(boletaPayload(), null, 2);
        document.querySelector('[data-tab="payloads"]').click();
    });

    $('createInvoiceBtn').addEventListener('click', () => run('POST /api/v1/invoices', async () => {
        const response = await api('/api/v1/invoices', { method: 'POST', body: invoicePayload() });
        captureCreatedDocument('invoice', response);
        return response;
    }));
    $('createBoletaBtn').addEventListener('click', () => run('POST /api/v1/boletas', async () => {
        const response = await api('/api/v1/boletas', { method: 'POST', body: boletaPayload() });
        captureCreatedDocument('boleta', response);
        return response;
    }));
    $('createInvoiceFromJsonBtn').addEventListener('click', () => run('POST /api/v1/invoices', async () => {
        const response = await api('/api/v1/invoices', { method: 'POST', body: parseJson('invoicePayload') });
        captureCreatedDocument('invoice', response);
        return response;
    }));
    $('createBoletaFromJsonBtn').addEventListener('click', () => run('POST /api/v1/boletas', async () => {
        const response = await api('/api/v1/boletas', { method: 'POST', body: parseJson('boletaPayload') });
        captureCreatedDocument('boleta', response);
        return response;
    }));

    $('pdfInvoiceBtn').addEventListener('click', () => run('POST /api/v1/invoices/{id}/generate-pdf', () => {
        if (!state.lastInvoiceId) throw new Error('No hay factura creada');
        return api(`/api/v1/invoices/${state.lastInvoiceId}/generate-pdf?format=A4`, { method: 'POST', body: {} });
    }));
    $('pdfBoletaBtn').addEventListener('click', () => run('POST /api/v1/boletas/{id}/generate-pdf', () => {
        if (!state.lastBoletaId) throw new Error('No hay boleta creada');
        return api(`/api/v1/boletas/${state.lastBoletaId}/generate-pdf?format=ticket`, { method: 'POST', body: {} });
    }));
    $('sendInvoiceBtn').addEventListener('click', () => run('POST /api/v1/invoices/{id}/send-sunat', () => {
        if (!state.lastInvoiceId) throw new Error('No hay factura creada');
        return api(`/api/v1/invoices/${state.lastInvoiceId}/send-sunat`, { method: 'POST', body: {} });
    }));
    $('sendBoletaBtn').addEventListener('click', () => run('POST /api/v1/boletas/{id}/send-sunat', () => {
        if (!state.lastBoletaId) throw new Error('No hay boleta creada');
        return api(`/api/v1/boletas/${state.lastBoletaId}/send-sunat`, { method: 'POST', body: {} });
    }));

    $('clearResultBtn').addEventListener('click', () => {
        $('result').textContent = '';
        setPill($('lastStatus'), 'sin request', 'idle');
        $('lastRequest').textContent = 'Esperando accion';
    });

    ['companyId', 'branchId', 'issueDate', 'invoiceSerie', 'invoiceClientDoc', 'invoiceClientName', 'invoicePrice', 'boletaSerie', 'boletaClientDoc', 'boletaClientName', 'boletaPrice'].forEach((id) => {
        $(id).addEventListener('change', refreshPayloads);
        $(id).addEventListener('input', refreshPayloads);
    });

    refreshPayloads();
    updateStateBadges();
</script>
</body>
</html>
