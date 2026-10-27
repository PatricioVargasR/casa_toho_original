<?php
// app/views/codigo_regalo_admin.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./../../public/images/logo/isotipo.ico">
    <title>Administrar Códigos de Regalo - Casa Toho</title>
    <style>
        :root {
            --dorado: #d8a54a;
            --negro: #000000;
            --blanco: #FFFFFF;
        }

        @font-face {
            font-family: 'Thurkle';
            src: url('./../../public/fonts/Thurkle.ttf') format('truetype');
            font-display: swap; 
        }

        @font-face {
            font-family: 'Seguisbi';
            src: url('./../../public/fonts/seguisbi.ttf') format('truetype');
            font-display: swap; 
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--negro);
            color: var(--blanco);
            line-height: 1.6;
            padding: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--dorado);
            padding-bottom: 15px;
        }

        .header h1 {
            font-family: 'Thurkle', serif;
            color: var(--dorado);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(216, 165, 74, 0.1);
            border: 2px solid var(--dorado);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            color: var(--dorado);
            font-weight: bold;
        }

        .stat-label {
            color: var(--blanco);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .section {
            margin-bottom: 30px;
            background: rgba(216, 165, 74, 0.1);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid var(--dorado);
        }

        .section h2 {
            font-family: 'Seguisbi', sans-serif;
            color: var(--dorado);
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            color: var(--dorado);
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--dorado);
            border-radius: 5px;
            color: var(--blanco);
            font-size: 0.95rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--blanco);
            background-color: rgba(255, 255, 255, 0.15);
        }

        textarea.form-control {
            min-height: 80px;
            resize: vertical;
        }

        .btn {
            background-color: var(--dorado);
            color: var(--negro);
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px 5px 5px 0;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn:active {
            transform: scale(0.95);
        }

        .btn:hover {
            background-color: var(--blanco);
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 0.75rem;
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--blanco);
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-success {
            background-color: #28a745;
            color: var(--blanco);
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: #ffc107;
            color: var(--negro);
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-info {
            background-color: #17a2b8;
            color: var(--blanco);
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .search-box {
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--dorado);
            border-radius: 5px;
            color: var(--blanco);
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .search-box:focus {
            outline: none;
            border-color: var(--blanco);
        }

        .filter-buttons {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filter-buttons .btn {
            flex: 1;
            min-width: 100px;
            font-size: 0.85rem;
            padding: 10px;
        }

        .filter-buttons .btn.active {
            background-color: var(--blanco);
            color: var(--negro);
        }

        .table-container {
            overflow-x: auto;
            margin-top: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(0, 0, 0, 0.3);
            font-size: 0.85rem;
        }

        th, td {
            padding: 10px 8px;
            text-align: left;
            border-bottom: 1px solid rgba(216, 165, 74, 0.3);
        }

        th {
            background-color: rgba(216, 165, 74, 0.2);
            color: var(--dorado);
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:hover {
            background-color: rgba(216, 165, 74, 0.1);
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: var(--negro);
        }

        .message {
            padding: 12px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .success {
            background-color: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #28a745;
        }

        .error {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        .loading {
            display: none;
            text-align: center;
            color: var(--dorado);
            font-size: 1.1rem;
            margin: 20px 0;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        .url-display {
            background-color: rgba(216, 165, 74, 0.1);
            border: 2px dashed var(--dorado);
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            display: none;
        }

        .url-display.show {
            display: block;
        }

        .url-display p {
            color: var(--dorado);
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .url-text {
            background-color: rgba(0, 0, 0, 0.3);
            padding: 10px;
            border-radius: 5px;
            color: var(--blanco);
            word-break: break-all;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .copy-btn {
            background-color: var(--dorado);
            color: var(--negro);
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.85rem;
            width: 100%;
        }

        .usos-column {
            white-space: nowrap;
        }

        .usos-controls {
            display: flex;
            align-items: center;
            gap: 5px;
            justify-content: center;
        }

        .usos-display {
            font-weight: bold;
            color: var(--dorado);
            min-width: 40px;
            text-align: center;
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-number {
                font-size: 1.8rem;
            }

            .section {
                padding: 15px;
            }

            table {
                font-size: 0.75rem;
            }

            th, td {
                padding: 8px 5px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .filter-buttons .btn {
                flex: 1 1 45%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎁 Admin Códigos</h1>
        <p style="font-size: 0.9rem;">Casa Toho</p>
        <button class="logout-btn" onclick="cerrarSesion()">Cerrar Sesión</button>
    </div>

    <!-- Estadísticas -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number" id="statTotal">0</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="statDisponibles">0</div>
            <div class="stat-label">Disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="statCompletados">0</div>
            <div class="stat-label">Completados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="statUsosPendientes">0</div>
            <div class="stat-label">Usos Pendientes</div>
        </div>
    </div>

    <div class="loading" id="loading">Cargando...</div>
    <div id="messages"></div>

    <!-- Crear nuevo código -->
    <div class="section">
        <h2>Crear Nuevo Código</h2>
        <form id="createForm">
            <div class="form-group">
                <label>Código *</label>
                <input type="text" class="form-control" id="codigo" placeholder="Ej: TOHO2024" required 
                       style="text-transform: uppercase;">
            </div>
            <div class="form-group">
                <label>Nombre del Regalo *</label>
                <input type="text" class="form-control" id="nombreRegalo" 
                       placeholder="Ej: Masaje Relajante" required>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" id="descripcion" 
                          placeholder="Descripción del regalo"></textarea>
            </div>
            <div class="form-group">
                <label>Cantidad de Usos *</label>
                <input type="number" class="form-control" id="cantidad" 
                       placeholder="Ej: 1 o 10" min="1" value="1" required>
                <small style="color: #999; font-size: 0.8rem;">¿Cuántas veces se puede usar este código?</small>
            </div>
            <button type="submit" class="btn">Crear Código</button>
        </form>

        <!-- URL generada -->
        <div class="url-display" id="urlDisplay">
            <p>✅ Código creado. Comparte este enlace:</p>
            <div class="url-text" id="urlText"></div>
            <button class="copy-btn" onclick="copiarURL()">📋 Copiar Enlace</button>
        </div>
    </div>

    <!-- Buscador y Lista de códigos -->
    <div class="section">
        <h2>Códigos Registrados</h2>
        
        <input type="text" 
               class="search-box" 
               id="searchBox" 
               placeholder="🔍 Buscar por código o nombre..."
               oninput="buscarCodigos()">
        
        <div class="filter-buttons">
            <button class="btn active" onclick="filtrarCodigos('todos')">Todos</button>
            <button class="btn" onclick="filtrarCodigos('disponibles')">Disponibles</button>
            <button class="btn" onclick="filtrarCodigos('completados')">Completados</button>
            <button class="btn" onclick="filtrarCodigos('inactivos')">Inactivos</button>
        </div>

        <div class="table-container">
            <table id="codigosTable">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Regalo</th>
                        <th class="usos-column">Usos</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="codigosBody">
                    <!-- Se llena dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        class CodigoAdmin {
            constructor() {
                this.filtroActual = 'todos';
                this.busquedaActual = '';
                this.init();
            }

            init() {
                this.loadCodigos();
                this.setupEventListeners();
            }

            setupEventListeners() {
                document.getElementById('createForm').addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.crearCodigo();
                });

                // Auto-uppercase para el código
                document.getElementById('codigo').addEventListener('input', (e) => {
                    e.target.value = e.target.value.toUpperCase();
                });
            }

            async loadCodigos(filtro = 'todos', busqueda = '') {
                this.showLoading(true);
                
                try {
                    const response = await fetch(`/admin/codigos/get?filtro=${filtro}&busqueda=${encodeURIComponent(busqueda)}`);
                    const data = await response.json();
                    
                    if (data.success) {
                        this.updateStats(data.estadisticas);
                        this.renderCodigos(data.codigos);
                    }
                } catch (error) {
                    this.showMessage('Error al cargar códigos', 'error');
                    console.error('Error:', error);
                }
                
                this.showLoading(false);
            }

            updateStats(stats) {
                document.getElementById('statTotal').textContent = stats.total || 0;
                document.getElementById('statDisponibles').textContent = stats.disponibles || 0;
                document.getElementById('statCompletados').textContent = stats.completados || 0;
                document.getElementById('statUsosPendientes').textContent = stats.usos_pendientes || 0;
            }

            renderCodigos(codigos) {
                const tbody = document.getElementById('codigosBody');
                tbody.innerHTML = '';

                if (codigos.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="empty-state">
                                No se encontraron códigos
                            </td>
                        </tr>
                    `;
                    return;
                }

                codigos.forEach(codigo => {
                    const tr = document.createElement('tr');
                    
                    let estadoBadge = '';
                    if (codigo.usado == 1) {
                        estadoBadge = '<span class="badge badge-danger">Completado</span>';
                    } else if (codigo.activo == 0) {
                        estadoBadge = '<span class="badge badge-warning">Inactivo</span>';
                    } else {
                        estadoBadge = '<span class="badge badge-success">Disponible</span>';
                    }

                    const usosRestantes = codigo.cantidad_total - codigo.usos_realizados;
                    const fechaCreacion = new Date(codigo.fecha_creacion).toLocaleDateString('es-MX');

                    // Controles de usos
                    let usosControl = '';
                    if (codigo.usado == 0 && codigo.activo == 1) {
                        usosControl = `
                            <div class="usos-controls">
                                <button class="btn btn-info btn-small" onclick="admin.restarUso(${codigo.id})" ${codigo.usos_realizados <= 0 ? 'disabled' : ''}>
                                    -
                                </button>
                                <span class="usos-display">${codigo.usos_realizados}/${codigo.cantidad_total}</span>
                                <button class="btn btn-success btn-small" onclick="admin.sumarUso(${codigo.id})" ${usosRestantes <= 0 ? 'disabled' : ''}>
                                    +
                                </button>
                            </div>
                        `;
                    } else {
                        usosControl = `<span class="usos-display">${codigo.usos_realizados}/${codigo.cantidad_total}</span>`;
                    }

                    let acciones = '';
                    if (codigo.usado == 0) {
                        if (codigo.activo == 1) {
                            acciones = `
                                <button class="btn btn-warning btn-small" onclick="admin.desactivarCodigo(${codigo.id})">
                                    Desactivar
                                </button>
                            `;
                        } else {
                            acciones = `
                                <button class="btn btn-success btn-small" onclick="admin.activarCodigo(${codigo.id})">
                                    Activar
                                </button>
                            `;
                        }
                    }
                    acciones += `
                        <button class="btn btn-danger btn-small" onclick="admin.eliminarCodigo(${codigo.id})">
                            Eliminar
                        </button>
                    `;

                    tr.innerHTML = `
                        <td><strong style="font-size: 0.9rem;">${codigo.codigo}</strong></td>
                        <td>${codigo.nombre_regalo}</td>
                        <td class="usos-column">${usosControl}</td>
                        <td>${estadoBadge}</td>
                        <td>${fechaCreacion}</td>
                        <td style="white-space: nowrap;">${acciones}</td>
                    `;
                    
                    tbody.appendChild(tr);
                });
            }

            async crearCodigo() {
                const codigo = document.getElementById('codigo').value.trim();
                const nombreRegalo = document.getElementById('nombreRegalo').value.trim();
                const descripcion = document.getElementById('descripcion').value.trim();
                const cantidad = document.getElementById('cantidad').value;

                if (!codigo || !nombreRegalo || !cantidad) {
                    this.showMessage('Por favor completa los campos obligatorios', 'error');
                    return;
                }

                if (cantidad < 1) {
                    this.showMessage('La cantidad debe ser al menos 1', 'error');
                    return;
                }

                this.showLoading(true);

                try {
                    const response = await fetch('/admin/codigos/crear', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            codigo: codigo,
                            nombre_regalo: nombreRegalo,
                            descripcion: descripcion,
                            cantidad: cantidad
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showMessage('Código creado exitosamente', 'success');
                        document.getElementById('createForm').reset();
                        document.getElementById('cantidad').value = '1';
                        
                        // Mostrar URL
                        document.getElementById('urlText').textContent = result.url;
                        document.getElementById('urlDisplay').classList.add('show');
                        
                        this.loadCodigos(this.filtroActual, this.busquedaActual);
                        
                        // Scroll al URL
                        document.getElementById('urlDisplay').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    } else {
                        this.showMessage(result.message || 'Error al crear código', 'error');
                    }
                } catch (error) {
                    this.showMessage('Error al crear código', 'error');
                    console.error('Error:', error);
                }

                this.showLoading(false);
            }

            async sumarUso(id) {
                if (!confirm('¿Registrar que esta persona vino por su servicio?')) return;

                this.showLoading(true);

                try {
                    const response = await fetch('/admin/codigos/sumar-uso', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showMessage('Uso registrado correctamente', 'success');
                        this.loadCodigos(this.filtroActual, this.busquedaActual);
                    } else {
                        this.showMessage('Error al registrar uso', 'error');
                    }
                } catch (error) {
                    this.showMessage('Error al registrar uso', 'error');
                    console.error('Error:', error);
                }

                this.showLoading(false);
            }

            async restarUso(id) {
                if (!confirm('¿Restar un uso a este código?')) return;

                this.showLoading(true);

                try {
                    const response = await fetch('/admin/codigos/restar-uso', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showMessage('Uso restado correctamente', 'success');
                        this.loadCodigos(this.filtroActual, this.busquedaActual);
                    } else {
                        this.showMessage('Error al restar uso', 'error');
                    }
                } catch (error) {
                    this.showMessage('Error al restar uso', 'error');
                    console.error('Error:', error);
                }

                this.showLoading(false);
            }

            async desactivarCodigo(id) {
                if (!confirm('¿Desactivar este código?')) return;

                this.showLoading(true);

                try {
                    const response = await fetch('/admin/codigos/desactivar', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showMessage('Código desactivado', 'success');
                        this.loadCodigos(this.filtroActual, this.busquedaActual);
                    } else {
                        this.showMessage('Error al desactivar código', 'error');
                    }
                } catch (error) {
                    this.showMessage('Error al desactivar código', 'error');
                    console.error('Error:', error);
                }

                this.showLoading(false);
            }

            async activarCodigo(id) {
                if (!confirm('¿Activar este código?')) return;

                this.showLoading(true);

                try {
                    const response = await fetch('/admin/codigos/activar', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showMessage('Código activado', 'success');
                        this.loadCodigos(this.filtroActual, this.busquedaActual);
                    } else {
                        this.showMessage('Error al activar código', 'error');
                    }
                } catch (error) {
                    this.showMessage('Error al activar código', 'error');
                    console.error('Error:', error);
                }

                this.showLoading(false);
            }

            async eliminarCodigo(id) {
                if (!confirm('¿Eliminar permanentemente este código? Esta acción no se puede deshacer.')) return;

                this.showLoading(true);

                try {
                    const response = await fetch('/admin/codigos/eliminar', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showMessage('Código eliminado', 'success');
                        this.loadCodigos(this.filtroActual, this.busquedaActual);
                    } else {
                        this.showMessage('Error al eliminar código', 'error');
                    }
                } catch (error) {
                    this.showMessage('Error al eliminar código', 'error');
                    console.error('Error:', error);
                }

                this.showLoading(false);
            }

            showLoading(show) {
                document.getElementById('loading').style.display = show ? 'block' : 'none';
            }

            showMessage(message, type) {
                const container = document.getElementById('messages');
                const div = document.createElement('div');
                div.className = `message ${type}`;
                div.textContent = message;
                
                container.appendChild(div);
                
                setTimeout(() => {
                    div.remove();
                }, 5000);
            }
        }

        function filtrarCodigos(filtro) {
            // Actualizar botones activos
            document.querySelectorAll('.filter-buttons .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Cargar códigos filtrados
            window.admin.filtroActual = filtro;
            window.admin.loadCodigos(filtro, window.admin.busquedaActual);
        }

        function buscarCodigos() {
            const busqueda = document.getElementById('searchBox').value;
            window.admin.busquedaActual = busqueda;
            window.admin.loadCodigos(window.admin.filtroActual, busqueda);
        }

        function copiarURL() {
            const urlText = document.getElementById('urlText').textContent;
            
            // Usar API moderna de clipboard
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(urlText).then(() => {
                    alert('✅ Enlace copiado al portapapeles');
                }).catch(() => {
                    copiarURLFallback(urlText);
                });
            } else {
                copiarURLFallback(urlText);
            }
        }

        function copiarURLFallback(text) {
            // Método alternativo para navegadores antiguos
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                alert('✅ Enlace copiado al portapapeles');
            } catch (err) {
                alert('❌ No se pudo copiar. Por favor copia manualmente.');
            }
            document.body.removeChild(textArea);
        }

        function cerrarSesion() {
            if (confirm('¿Cerrar sesión?')) {
                window.location.href = '/admin/cerrar-sesion';
            }
        }

        // Inicializar
        window.addEventListener('load', () => {
            window.admin = new CodigoAdmin();
        });
    </script>
</body>
</html>