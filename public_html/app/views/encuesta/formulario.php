<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa T'ÖHÖ - Encuesta de Satisfacción</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-text {
            max-width: 200px;
            height: auto;
        }

        .encuesta-container {
            background-color: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .encuesta-title {
            font-family: 'Thurkle', sans-serif;
            font-size: 2.5rem;
            color: var(--dorado);
            text-align: center;
            margin-bottom: 30px;
        }

        .progress-bar {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.1);
            margin-bottom: 30px;
            border-radius: 20px;
            overflow: hidden;
            height: 8px;
        }

        .progress {
            height: 100%;
            background: linear-gradient(90deg, var(--dorado), #f4d03f);
            width: 0%;
            transition: width 0.5s ease;
            border-radius: 20px;
        }

        .paso-contador {
            text-align: center;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .step {
            display: none;
            animation: fadeIn 0.5s ease-in;
        }

        .step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pregunta {
            font-size: 1.3rem;
            margin-bottom: 25px;
            text-align: center;
            color: var(--blanco);
        }

        /* Mesero select */
        .mesero-label {
            font-size: 1.3rem;
            margin-bottom: 20px;
            text-align: center;
            color: var(--blanco);
            display: block;
        }

        select {
            width: 100%;
            padding: 14px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(216, 165, 74, 0.3);
            border-radius: 8px;
            color: var(--blanco);
            font-size: 1rem;
            cursor: pointer;
            transition: border-color 0.3s ease;
            margin-bottom: 10px;
        }

        select:focus {
            outline: none;
            border-color: var(--dorado);
            box-shadow: 0 0 10px rgba(216, 165, 74, 0.3);
        }

        select option {
            background-color: #1a1a1a;
            color: var(--blanco);
        }

        /* Opciones de respuesta */
        .opciones-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .opcion-btn {
            padding: 18px 15px;
            background-color: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(216, 165, 74, 0.3);
            border-radius: 8px;
            color: var(--blanco);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: center;
        }

        .opcion-btn:hover {
            background-color: rgba(216, 165, 74, 0.2);
            border-color: var(--dorado);
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(216, 165, 74, 0.3);
        }

        .opcion-btn.seleccionada {
            background-color: var(--dorado);
            border-color: var(--dorado);
            color: var(--negro);
            box-shadow: 0 0 20px rgba(216, 165, 74, 0.7);
            transform: scale(1.03);
        }

        /* Comentarios */
        .comentarios-section {
            text-align: center;
        }

        .textarea-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .comentarios-section textarea {
            width: 100%;
            padding: 16px;
            padding-bottom: 48px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(216, 165, 74, 0.3);
            border-radius: 8px;
            color: var(--blanco);
            font-size: 1rem;
            min-height: 120px;
            resize: vertical;
            transition: border-color 0.3s ease;
            font-family: inherit;
            box-sizing: border-box;
        }

        .comentarios-section textarea:focus {
            outline: none;
            border-color: var(--dorado);
            box-shadow: 0 0 10px rgba(216, 165, 74, 0.3);
        }

        .comentarios-section textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-mic {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 36px;
            height: 36px;
            background-color: rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(216, 165, 74, 0.5);
            border-radius: 50%;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            padding: 0;
            line-height: 1;
        }

        .btn-mic:hover {
            background-color: rgba(216, 165, 74, 0.3);
            border-color: var(--dorado);
            transform: scale(1.1);
        }

        .btn-mic.recording {
            background-color: rgba(231, 76, 60, 0.6);
            border-color: #e74c3c;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Botones navegación */
        .botones-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }

        .btn {
            padding: 12px 25px;
            background-color: transparent;
            color: var(--dorado);
            border: 2px solid var(--dorado);
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            max-width: 150px;
        }

        .btn:hover {
            background-color: var(--dorado);
            color: var(--negro);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(216, 165, 74, 0.3);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn:disabled:hover {
            background-color: transparent;
            color: var(--dorado);
        }

        .btn-submit {
            background-color: var(--dorado);
            color: var(--negro);
        }

        .btn-submit:hover {
            background-color: #c99938;
            color: var(--negro);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 6px;
            text-align: center;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        /* Mensaje de éxito */
        .mensaje-exito {
            display: none;
            text-align: center;
            padding: 40px;
        }

        .mensaje-exito.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }

        .mensaje-exito h3 {
            font-family: 'Thurkle', sans-serif;
            color: var(--dorado);
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .mensaje-exito p {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .icono-exito {
            font-size: 4rem;
            color: var(--dorado);
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
                align-items: flex-start;
                padding-top: 20px;
            }

            .encuesta-container {
                padding: 20px;
            }

            .encuesta-title {
                font-size: 1.8rem;
            }

            .pregunta, .mesero-label {
                font-size: 1.1rem;
                margin-bottom: 18px;
            }

            .opciones-container {
                gap: 10px;
            }

            .opcion-btn {
                padding: 14px 10px;
                font-size: 0.9rem;
            }

            .botones-container {
                flex-direction: row;
            }

            .btn {
                max-width: none;
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="encuesta-container">
        <div class="logo">
            <h1><img src="./../../public/images/logo/logo.png" alt="Casa T'öhö | Casa Toho | Casa TOHO" class="logo-text"/></h1>
        </div>

        <h2 class="encuesta-title">Encuesta de Satisfacción</h2>

        <div class="paso-contador" id="contador">
            Pregunta <span id="paso-actual">1</span> de <span id="total-pasos">6</span>
        </div>

        <div class="progress-bar">
            <div class="progress" id="progress"></div>
        </div>

        <form id="formEncuesta" action="/guardar-respuesta" method="POST">

            <!-- Paso 1: Pregunta 1 -->
            <div class="step active" id="step-0">
                <p class="pregunta">¿Cómo calificarías la limpieza del restaurante?</p>
                <div class="opciones-container">
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(0, 'Excelente')">Excelente</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(0, 'Buena')">Buena</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(0, 'Regular')">Regular</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(0, 'Mala')">Mala</button>
                </div>
                <input type="hidden" name="respuesta1" id="respuesta0">
            </div>

            <!-- Paso 2: Pregunta 2 -->
            <div class="step" id="step-1">
                <p class="pregunta">¿Cómo fue el trato del personal?</p>
                <div class="opciones-container">
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(1, 'Excelente')">Excelente</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(1, 'Buena')">Buena</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(1, 'Regular')">Regular</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(1, 'Mala')">Mala</button>
                </div>
                <input type="hidden" name="respuesta2" id="respuesta1">
            </div>

            <!-- Paso 3: Pregunta 3 -->
            <div class="step" id="step-2">
                <p class="pregunta">¿Qué te pareció la calidad de la comida?</p>
                <div class="opciones-container">
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(2, 'Excelente')">Excelente</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(2, 'Buena')">Buena</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(2, 'Regular')">Regular</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(2, 'Mala')">Mala</button>
                </div>
                <input type="hidden" name="respuesta3" id="respuesta2">
            </div>

            <!-- Paso 4: Pregunta 4 -->
            <div class="step" id="step-3">
                <p class="pregunta">¿Recomendarías nuestro restaurante a otras personas?</p>
                <div class="opciones-container">
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(3, 'Excelente')">Excelente</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(3, 'Buena')">Buena</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(3, 'Regular')">Regular</button>
                    <button type="button" class="opcion-btn" onclick="seleccionarOpcion(3, 'Mala')">Mala</button>
                </div>
                <input type="hidden" name="respuesta4" id="respuesta3">
            </div>

            <!-- Paso 5: Comentarios -->
            <div class="step" id="step-4">
                <div class="comentarios-section">
                    <p class="pregunta">¿Tienes algún comentario adicional?</p>
                    <div class="textarea-wrapper">
                        <textarea name="comentarios" id="comentarios" placeholder="Comparte tu experiencia o sugerencias..."></textarea>
                        <button type="button" class="btn-mic" id="btnGrabar" onclick="iniciarGrabacion()" title="Grabar comentario">🎤</button>
                        <button type="button" class="btn-mic recording" id="btnDetener" onclick="detenerGrabacion()" title="Detener grabación" style="display: none;">⏹️</button>
                    </div>
                    <div class="error-message" id="comentarioError">Por favor escribe o graba un comentario</div>
                </div>
            </div>

            <!-- Paso 6: Mesero (opcional) -->
            <div class="step" id="step-5">
                <p class="pregunta">¿Quién fue tu mesero? <span style="font-size:0.85rem; color: rgba(255,255,255,0.5);">(opcional)</span></p>
                <div class="opciones-container meseros-container">
                    <?php foreach ($meseros as $m): ?>
                    <button type="button" class="opcion-btn" onclick="seleccionarMesero(<?= (int)$m['id'] ?>, '<?= htmlspecialchars($m['nombre'], ENT_QUOTES) ?>')">
                        <?= htmlspecialchars($m['nombre']) ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="mesero_id" id="mesero_id">
            </div>

            <div class="botones-container">
                <button type="button" class="btn" id="btnAnterior" onclick="anteriorPaso()" disabled>Anterior</button>
                <button type="button" class="btn" id="btnSiguiente" onclick="siguientePaso()">Siguiente</button>
                <button type="submit" class="btn btn-submit" id="btnEnviar" style="display: none;">Enviar Encuesta</button>
            </div>
        </form>

        <div class="mensaje-exito" id="mensajeExito">
            <div class="icono-exito">✓</div>
            <h3>¡Gracias por tu opinión!</h3>
            <p>Tu encuesta ha sido enviada exitosamente. Valoramos mucho tu retroalimentación.</p>
        </div>
    </div>

    <script>
        let pasoActual = 0;
        const pasos = document.querySelectorAll('.step');
        const progreso = document.getElementById('progress');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnEnviar = document.getElementById('btnEnviar');
        const contador = document.getElementById('contador');
        const pasoActualSpan = document.getElementById('paso-actual');
        const totalPasosSpan = document.getElementById('total-pasos');

        totalPasosSpan.textContent = pasos.length;

        function mostrarPaso(n) {
            pasos.forEach((p, i) => p.classList.toggle('active', i === n));
            progreso.style.width = ((n + 1) / pasos.length) * 100 + '%';
            pasoActualSpan.textContent = n + 1;

            btnAnterior.disabled = n === 0;

            if (n === pasos.length - 1) {
                btnSiguiente.style.display = 'none';
                btnEnviar.style.display = 'block';
                contador.style.display = 'none';
            } else {
                btnSiguiente.style.display = 'block';
                btnEnviar.style.display = 'none';
                contador.style.display = 'block';
            }
        }

        function siguientePaso() {
            // Validar preguntas (pasos 0-3)
            if (pasoActual >= 0 && pasoActual <= 3) {
                const respuesta = document.getElementById('respuesta' + pasoActual);
                if (!respuesta || !respuesta.value) {
                    alert('Por favor selecciona una opción antes de continuar.');
                    return;
                }
            }

            if (pasoActual < pasos.length - 1) {
                pasoActual++;
                mostrarPaso(pasoActual);
            }
        }

        function anteriorPaso() {
            if (pasoActual > 0) {
                pasoActual--;
                mostrarPaso(pasoActual);
            }
        }

        function seleccionarOpcion(preguntaIndex, valor) {
            // preguntaIndex 0-3 corresponde directamente a los pasos 0-3
            const opciones = pasos[preguntaIndex].querySelectorAll('.opcion-btn');
            opciones.forEach(function(opcion) {
                opcion.classList.remove('seleccionada');
                if (opcion.textContent.trim() === valor) {
                    opcion.classList.add('seleccionada');
                }
            });
            document.getElementById('respuesta' + preguntaIndex).value = valor;

            // Auto-avanzar al siguiente paso después de un breve delay visual
            setTimeout(function() {
                if (pasoActual < pasos.length - 1) {
                    pasoActual++;
                    mostrarPaso(pasoActual);
                }
            }, 350);
        }

        function seleccionarMesero(id, nombre) {
            const opciones = pasos[5].querySelectorAll('.opcion-btn');
            opciones.forEach(function(opcion) {
                opcion.classList.remove('seleccionada');
                if (opcion.textContent.trim() === nombre) {
                    opcion.classList.add('seleccionada');
                }
            });
            document.getElementById('mesero_id').value = id;
        }

        // Reconocimiento de voz
        let isRecording = false;
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = SpeechRecognition ? new SpeechRecognition() : null;

        if (recognition) {
            recognition.lang = 'es-ES';
            recognition.continuous = true;
            recognition.interimResults = true;

            recognition.onstart = function() {
                isRecording = true;
                document.getElementById('btnGrabar').classList.add('recording');
                document.getElementById('btnGrabar').style.display = 'none';
                document.getElementById('btnDetener').style.display = 'flex';
            };

            recognition.onresult = function(event) {
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    if (event.results[i].isFinal) {
                        document.getElementById('comentarios').value += event.results[i].transcript + ' ';
                    }
                }
            };

            recognition.onerror = function(event) {
                console.error('Error en reconocimiento de voz:', event.error);
                isRecording = false;
                document.getElementById('btnGrabar').classList.remove('recording');
                document.getElementById('btnGrabar').style.display = 'flex';
                document.getElementById('btnDetener').style.display = 'none';

                if (event.error === 'not-allowed') {
                    alert('Permiso de micrófono denegado. Permite el acceso al micrófono en tu navegador e intenta de nuevo.');
                } else if (event.error === 'network') {
                    alert('Error de red. El reconocimiento de voz requiere conexión a internet.');
                } else {
                    alert('Error en reconocimiento de voz: ' + event.error + '. Por favor, escribe tu comentario manualmente.');
                }
            };

            recognition.onend = function() {
                isRecording = false;
                document.getElementById('btnGrabar').classList.remove('recording');
                document.getElementById('btnGrabar').style.display = 'flex';
                document.getElementById('btnDetener').style.display = 'none';
            };
        }

        function iniciarGrabacion() {
            if (!recognition) {
                alert('Tu navegador no soporta reconocimiento de voz. Por favor, escribe tu comentario manualmente.');
                return;
            }
            if (!isRecording) {
                try {
                    recognition.start();
                } catch (e) {
                    console.error('No se pudo iniciar el reconocimiento:', e);
                    alert('No se pudo iniciar el micrófono. Por favor, escribe tu comentario manualmente.');
                }
            }
        }

        function detenerGrabacion() {
            if (isRecording && recognition) {
                recognition.stop();
            }
        }

        document.getElementById('comentarios').addEventListener('input', function() {
            document.getElementById('comentarioError').classList.remove('show');
        });

        // Envío del formulario
        document.getElementById('formEncuesta').addEventListener('submit', function(e) {
            e.preventDefault();

            const comentarios = document.getElementById('comentarios').value.trim();
            if (!comentarios) {
                // Navegar al paso de comentarios para mostrar el error
                pasoActual = 4;
                mostrarPaso(pasoActual);
                document.getElementById('comentarioError').classList.add('show');
                return;
            }
            document.getElementById('comentarioError').classList.remove('show');

            // Verificar que todas las respuestas estén completas
            for (let i = 0; i < 4; i++) {
                const r = document.getElementById('respuesta' + i);
                if (!r || !r.value) {
                    alert('Por favor, responde todas las preguntas antes de enviar.');
                    return;
                }
            }

            // Calcular promedio para Google Reviews
            const valorMap = { 'Excelente': 4, 'Buena': 3, 'Regular': 2, 'Mala': 1 };
            let total = 0;
            for (let i = 0; i < 4; i++) {
                total += valorMap[document.getElementById('respuesta' + i).value] || 0;
            }
            const promedio = total / 4;

            btnEnviar.textContent = 'Enviando...';
            btnEnviar.disabled = true;

            const formData = new FormData(this);

            fetch('/guardar-respuesta', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                if (response.ok) {
                    document.querySelector('.encuesta-container').innerHTML = `
                        <div class="logo">
                            <h1><img src="./../../public/images/logo/logo.png" alt="Casa T'öhö | Casa Toho | Casa TOHO" class="logo-text"/></h1>
                        </div>
                        <div class="mensaje-exito active">
                            <div class="icono-exito">✓</div>
                            <h3>¡Gracias por tu opinión!</h3>
                            <p>Tu encuesta ha sido enviada exitosamente. Valoramos mucho tu retroalimentación.</p>
                        </div>
                    `;

                    if (promedio >= 3) {
                        setTimeout(function() {
                            if (confirm('¡Gracias por tu opinión! 😊\n¿Nos dejarías una reseña en Google?')) {
                                window.location.href = 'https://www.google.com/search?client=opera-gx&hs=TWa&sca_esv=68280c2e20e84069&sxsrf=AE3TifMoDSjHoRqJ8Gw44Zyh9WGFfXwxNQ:1754851485335&q=casa+toho&si=AMgyJEtREmoPL4P1I5IDCfuA8gybfVI2d5Uj7QMwYCZHKDZ-E97YhinM03hU0Xm2grilV92p6E0JdUCE0D9GA3Zs9z_gMW5Jsg25LfCCdZNVf3vG4yI7kRWdbkW2JBE3GgYOysqBmaxn&sa=X&ved=2ahUKEwjd2qqb84CPAxXJNEQIHU7ZEBUQrrQLegQIGhAA&biw=1490&bih=706&dpr=1.25#lrd=0x85d057afb853c80d:0xb31e1c137b7d7eaf,1,,,,';
                            }
                        }, 500);
                    }
                } else {
                    throw new Error('Error en el servidor');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('Hubo un error al enviar la encuesta. Por favor, inténtalo de nuevo.');
                btnEnviar.textContent = 'Enviar Encuesta';
                btnEnviar.disabled = false;
            });
        });

        // Inicializar
        mostrarPaso(pasoActual);
    </script>
</body>
</html>
