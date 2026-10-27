<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/png" href="./../../public/images/logo/isotipo.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Promocionales</title>
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
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid var(--dorado);
            padding-bottom: 20px;
        }

        .header h1 {
            font-family: 'Thurkle', serif;
            color: var(--dorado);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .section {
            margin-bottom: 40px;
            background: rgba(216, 165, 74, 0.1);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid var(--dorado);
        }

        .section h2 {
            font-family: 'Seguisbi', sans-serif;
            color: var(--dorado);
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .refresh-button {
            margin-left: 10px;
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .image-card {
            background: var(--negro);
            border: 1px solid var(--dorado);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(216, 165, 74, 0.3);
        }

        .image-preview {
            width: 100%;
            max-width: 200px;
            height: 150px;
            object-fit: contain;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 1px solid var(--dorado);
        }

        .image-name {
            color: var(--blanco);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .order-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .order-buttons .small-btn {
            padding: 4px 8px;
            font-size: 0.8rem;
        }

        .duration-control {
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: var(--dorado);
        }

        .duration-control input {
            width: 80px;
            padding: 4px;
            border-radius: 4px;
            border: 1px solid var(--dorado);
            background: var(--negro);
            color: var(--blanco);
            font-size: 0.85rem;
        }

        .horario-control {
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: var(--dorado);
        }

        .horario-control input[type="time"] {
            width: 100px;
            padding: 4px;
            border-radius: 4px;
            border: 1px solid var(--dorado);
            background: var(--negro);
            color: var(--blanco);
            font-size: 0.85rem;
            margin: 0 4px;
        }

        .btn {
            background-color: var(--dorado);
            color: var(--negro);
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: var(--blanco);
            transform: scale(1.05);
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

        .upload-section {
            background: rgba(216, 165, 74, 0.2);
            border: 2px dashed var(--dorado);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .upload-input {
            background: var(--negro);
            border: 1px solid var(--dorado);
            color: var(--blanco);
            padding: 10px;
            border-radius: 5px;
            margin: 10px;
        }

        .loading {
            display: none;
            text-align: center;
            color: var(--dorado);
            font-size: 1.2rem;
            margin: 20px 0;
        }

        .message {
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Administrador de Promocionales</h1>
        <p>
            Gestiona las imágenes promocionales activas y archivadas
            <button id="refresh-admin" class="btn refresh-button">Recargar lista</button>
        </p>
    </div>

    <!-- Sección de carga -->
    <div class="upload-section">
        <h3 style="color: var(--dorado); margin-bottom: 15px;">Subir Nuevo Promocional</h3>
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="imagen" accept="image/*,video/*" class="upload-input" required>
            <br>
            <label style="color: var(--dorado); font-size: 0.9rem;">
                Duración (segundos, opcional):
                <input type="number" name="duracion" min="1" step="1" class="upload-input" style="width: 120px;">
            </label>
            <br>
            <label style="color: var(--dorado); font-size: 0.9rem;">
                Horario (opcional):
                <input type="time" name="hora_inicio" class="upload-input" style="width: 120px;" placeholder="Hora inicio">
                <span style="margin: 0 8px;">-</span>
                <input type="time" name="hora_fin" class="upload-input" style="width: 120px;" placeholder="Hora fin">
            </label>
            <br>
            <button type="submit" class="btn">Subir Archivo</button>
        </form>
    </div>

    <div class="loading" id="loading">Procesando...</div>
    <div id="messages"></div>

    <!-- Imágenes Activas -->
    <div class="section">
        <h2>Promocionales Activos</h2>
        <div class="images-grid" id="active-images">
            <!-- Se cargan dinámicamente -->
        </div>
    </div>

    <!-- Imágenes Archivadas -->
    <div class="section">
        <h2>Promocionales Archivados</h2>
        <div class="images-grid" id="archived-images">
            <!-- Se cargan dinámicamente -->
        </div>
    </div>

    <script>
        class PromocionalAdmin {
            constructor() {
                this.currentVersion = null;
                this.init();
            }

            init() {
                this.loadImages();
                this.setupEventListeners();
                this.fetchVersion();
            }

            setupEventListeners() {
                document.getElementById('uploadForm').addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.uploadImage();
                });

                const refreshBtn = document.getElementById('refresh-admin');
                if (refreshBtn) {
                    refreshBtn.addEventListener('click', () => {
                        this.loadImages();
                        this.bumpVersion();
                    });
                }
            }

            async fetchVersion() {
                try {
                    const response = await fetch('?action=get_version');
                    const data = await response.json();
                    if (data.success) {
                        this.currentVersion = data.version;
                    }
                } catch (e) {
                    console.error('No se pudo obtener la versión de promociones', e);
                }
            }

            async bumpVersion() {
                try {
                    const response = await fetch('?action=bump_version', { 
                        cache: 'no-store',
                        method: 'GET'
                    });
                    const result = await response.json();
                    if (result.success) {
                        console.log('Versión incrementada a:', result.version);
                    } else {
                        console.error('Error al incrementar versión:', result.message);
                    }
                } catch (e) {
                    console.error('No se pudo incrementar la versión de promociones', e);
                }
            }

            async loadImages() {
                this.showLoading(true);
                
                try {
                    const response = await fetch('?action=get_images', { cache: 'no-store' });
                    const data = await response.json();

                    this.renderImages('active-images', data.active || [], 'active');
                    this.renderImages('archived-images', data.archived || [], 'archived');
                    
                } catch (error) {
                    this.showMessage('Error al cargar los elementos', 'error');
                    console.error('Error:', error);
                }
                
                this.showLoading(false);
            }

            renderImages(containerId, images, type) {
                const container = document.getElementById(containerId);
                container.innerHTML = '';

                if (images.length === 0) {
                    container.innerHTML = '<p style="text-align: center; color: var(--dorado);">No hay elementos ' + 
                                         (type === 'active' ? 'activos' : 'archivados') + '</p>';
                    return;
                }

                images.forEach((image, index) => {
                    const card = document.createElement('div');
                    card.className = 'image-card';

                    const isActive = type === 'active';

                    const ext = (image.extension || (image.name.split('.').pop() || '')).toLowerCase();
                    const isVideo = ['mp4', 'webm', 'ogg'].includes(ext);

                    // Si no hay duración guardada en BD, mostrar el valor por defecto (30s para todo)
                    let durationSeconds;
                    if (image.duration_ms && image.duration_ms > 0) {
                        durationSeconds = Math.round(image.duration_ms / 1000);
                    } else {
                        durationSeconds = 30;
                    }

                    // Obtener horarios
                    const horaInicio = image.hora_inicio || '';
                    const horaFin = image.hora_fin || '';

                    card.innerHTML = `
                        ${isVideo
                            ? `<video src="${image.path}" class="image-preview" muted playsinline loop></video>`
                            : `<img src="${image.path}" alt="${image.name}" class="image-preview">`
                        }
                        <div class="image-name">
                            ${image.name}
                            <br>
                            <small style="color: var(--dorado); text-transform: uppercase;">${isVideo ? 'VIDEO' : 'IMAGEN'}</small>
                        </div>
                        <div class="duration-control">
                            Duración:
                            <input type="number" min="1" step="1" value="${durationSeconds}" 
                                   placeholder="por defecto 30s si no cambias este valor"
                                   onchange="admin.updateMediaDuration('${image.name}', this.value)">
                            <span>s</span>
                        </div>
                        <div class="horario-control" data-filename="${image.name}">
                            Horario:
                            <input type="time" class="hora-inicio" data-filename="${image.name}" value="${horaInicio}" 
                                   onchange="admin.updateHorarioFromInputs('${image.name}')">
                            <span>-</span>
                            <input type="time" class="hora-fin" data-filename="${image.name}" value="${horaFin}" 
                                   onchange="admin.updateHorarioFromInputs('${image.name}')">
                        </div>
                        ${isActive ? `
                            <div class="order-buttons">
                                <button class="btn small-btn" onclick="admin.reorderImageAbsolute('${image.name}', 'first')" ${index === 0 ? 'disabled' : ''}>&laquo;</button>
                                <button class="btn small-btn" onclick="admin.reorderImage('${image.name}', 'up')" ${index === 0 ? 'disabled' : ''}>&uarr;</button>
                                <button class="btn small-btn" onclick="admin.reorderImage('${image.name}', 'down')" ${index === images.length - 1 ? 'disabled' : ''}>&darr;</button>
                                <button class="btn small-btn" onclick="admin.reorderImageAbsolute('${image.name}', 'last')" ${index === images.length - 1 ? 'disabled' : ''}>&raquo;</button>
                            </div>
                        ` : ''}
                        <div>
                            ${isActive ? 
                                `<button class="btn btn-danger" onclick="admin.archiveImage('${image.name}')">Archivar</button>` :
                                `<button class="btn btn-success" onclick="admin.activateImage('${image.name}')">Activar</button>`
                            }
                            <button class="btn btn-danger" onclick="admin.deleteImage('${image.name}', '${type}')">Eliminar</button>
                        </div>
                    `;
                    
                    container.appendChild(card);
                });
            }

            async archiveImage(filename) {
                if (!confirm('¿Estás seguro de que quieres archivar este elemento?')) return;
                
                this.showLoading(true);
                
                try {
                    const response = await fetch('?action=archive_image', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ filename })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.showMessage('Elemento archivado correctamente', 'success');
                        this.loadImages();
                    } else {
                        this.showMessage(result.message || 'Error al archivar la imagen', 'error');
                    }
                    
                } catch (error) {
                    this.showMessage('Error al archivar el elemento', 'error');
                    console.error('Error:', error);
                }
                
                this.showLoading(false);
            }

            async activateImage(filename) {
                if (!confirm('¿Estás seguro de que quieres activar este elemento?')) return;
                
                this.showLoading(true);
                
                try {
                    const response = await fetch('?action=activate_image', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ filename })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.showMessage('Elemento activado correctamente', 'success');
                        this.loadImages();
                    } else {
                        this.showMessage(result.message || 'Error al activar la imagen', 'error');
                    }
                    
                } catch (error) {
                    this.showMessage('Error al activar el elemento', 'error');
                    console.error('Error:', error);
                }
                
                this.showLoading(false);
            }

            async deleteImage(filename, type) {
                if (!confirm('¿Estás seguro de que quieres eliminar permanentemente este elemento?')) return;
                
                this.showLoading(true);
                
                try {
                    const response = await fetch('?action=delete_image', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ filename, type })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.showMessage('Elemento eliminado correctamente', 'success');
                        this.loadImages();
                    } else {
                        this.showMessage(result.message || 'Error al eliminar la imagen', 'error');
                    }
                    
                } catch (error) {
                    this.showMessage('Error al eliminar el elemento', 'error');
                    console.error('Error:', error);
                }
                
                this.showLoading(false);
            }

            async reorderImage(filename, direction) {
                this.showLoading(true);

                try {
                    const response = await fetch('?action=reorder_image', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ filename, direction })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.loadImages();
                    } else {
                        this.showMessage(result.message || 'No se pudo actualizar el orden', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showMessage('Error al actualizar el orden', 'error');
                }

                this.showLoading(false);
            }

            async reorderImageAbsolute(filename, position) {
                this.showLoading(true);

                try {
                    const response = await fetch('?action=reorder_image_absolute', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ filename, position })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.loadImages();
                    } else {
                        this.showMessage(result.message || 'No se pudo actualizar el orden', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showMessage('Error al actualizar el orden', 'error');
                }

                this.showLoading(false);
            }
            async updateMediaDuration(filename, value) {
                const duration = parseInt(value, 10);

                this.showLoading(true);

                try {
                    // Obtener valores actuales de horario para no perderlos
                    const card = Array.from(document.querySelectorAll('.image-card')).find(card => {
                        return card.querySelector('.image-name').textContent.trim().split('\n')[0] === filename;
                    });
                    
                    let horaInicio = '';
                    let horaFin = '';
                    if (card) {
                        const horarioInputs = card.querySelectorAll('.horario-control input[type="time"]');
                        if (horarioInputs.length >= 2) {
                            horaInicio = horarioInputs[0].value || null;
                            horaFin = horarioInputs[1].value || null;
                        }
                    }

                    const response = await fetch('?action=update_media', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            filename,
                            duration_seconds: isNaN(duration) || duration <= 0 ? null : duration,
                            hora_inicio: horaInicio || null,
                            hora_fin: horaFin || null,
                        }),
                    });

                    const result = await response.json();

                    if (!result.success) {
                        this.showMessage(result.message || 'No se pudo actualizar la duración', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showMessage('Error al actualizar la duración', 'error');
                }

                this.showLoading(false);
            }

            async updateHorarioFromInputs(filename) {
                // Obtener valores de los inputs de horario
                const horarioControl = document.querySelector(`.horario-control[data-filename="${filename}"]`);
                if (!horarioControl) return;

                const horaInicioInput = horarioControl.querySelector('.hora-inicio');
                const horaFinInput = horarioControl.querySelector('.hora-fin');
                
                const horaInicio = horaInicioInput ? horaInicioInput.value : null;
                const horaFin = horaFinInput ? horaFinInput.value : null;

                this.updateHorario(filename, horaInicio, horaFin);
            }

            async updateHorario(filename, horaInicio, horaFin) {
                this.showLoading(true);

                try {
                    // Obtener valor actual de duración para no perderlo
                    const card = Array.from(document.querySelectorAll('.image-card')).find(card => {
                        return card.querySelector('.image-name').textContent.trim().split('\n')[0] === filename;
                    });
                    
                    let duration = null;
                    if (card) {
                        const durationInput = card.querySelector('.duration-control input[type="number"]');
                        if (durationInput) {
                            const durationValue = parseInt(durationInput.value, 10);
                            duration = isNaN(durationValue) || durationValue <= 0 ? null : durationValue;
                        }
                    }

                    const response = await fetch('?action=update_media', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            filename,
                            duration_seconds: duration,
                            hora_inicio: horaInicio || null,
                            hora_fin: horaFin || null,
                        }),
                    });

                    const result = await response.json();

                    if (!result.success) {
                        this.showMessage(result.message || 'No se pudo actualizar el horario', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showMessage('Error al actualizar el horario', 'error');
                }

                this.showLoading(false);
            }

            async uploadImage() {
                const form = document.getElementById('uploadForm');
                const formData = new FormData(form);
                
                this.showLoading(true);
                
                try {
                    const response = await fetch('?action=upload_image', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.showMessage('Archivo subido correctamente', 'success');
                        form.reset();
                        this.loadImages();
                    } else {
                        this.showMessage(result.message || 'Error al subir el archivo', 'error');
                    }
                    
                } catch (error) {
                    this.showMessage('Error al subir el archivo', 'error');
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

        // Inicializar cuando cargue la página
        window.addEventListener('load', () => {
            window.admin = new PromocionalAdmin();
        });
    </script>
</body>
</html>