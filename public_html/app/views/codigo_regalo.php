<?php
// app/views/codigo_regalo.php
$codigoUrl = isset($_GET['c']) ? htmlspecialchars($_GET['c']) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./../../public/images/logo/isotipo.ico">
    <title>¡Tienes un Regalo! - Casa T'ÖHÖ x ZÄNÄ</title>
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
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--negro);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            overflow-x: hidden;
        }

        .container {
            background: var(--blanco);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(216, 165, 74, 0.5);
            padding: 25px 20px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            position: relative;
        }

        .logo-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .logo-content {
            display: flex;
            align-items: center;
        }

        .logo-icon {
            width: 35px;
            height: 35px;
            margin-right: 10px;
        }

        .logo-text {
            font-family: 'Thurkle', serif;
            font-size: 1.8em;
            font-weight: bold;
            color: var(--dorado);
            line-height: 1;
        }

        /* Pantalla inicial - Regalo animado */
        .gift-screen {
            display: block;
        }

        .gift-screen.hidden {
            display: none;
        }

        .gift-box {
            font-size: 7em;
            margin: 30px 0;
            cursor: pointer;
            transition: transform 0.3s;
            animation: bounce 2s infinite;
            user-select: none;
        }

        .gift-box:active {
            transform: scale(0.95);
            animation: none;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .gift-screen h2 {
            color: var(--negro);
            font-size: 1.4em;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .gift-screen p {
            color: #666;
            font-size: 1.05em;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .gift-hint {
            font-size: 0.85em;
            color: #999;
            margin-top: 10px;
        }

        /* Pantalla de celebración */
        .celebration-screen {
            display: none;
        }

        .celebration-screen.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .heart {
            position: fixed;
            font-size: 30px;
            color: var(--dorado);
            animation: fall 4s linear forwards;
            pointer-events: none;
            z-index: 9999;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        .prize-text {
            color: var(--negro);
            font-size: 1.1em;
            margin: 10px 0 15px 0;
        }

        .prize-name {
            color: var(--dorado);
            font-size: 1.5em;
            font-weight: bold;
            margin: 15px 0;
            line-height: 1.3;
        }

        .prize-description {
            color: #666;
            font-size: 0.95em;
            margin: 15px 0;
            line-height: 1.6;
        }

        .usos-info {
            background-color: rgba(216, 165, 74, 0.1);
            border-radius: 10px;
            padding: 12px;
            margin: 15px 0;
            font-size: 0.9em;
            color: #666;
        }

        .code-display {
            background-color: rgba(216, 165, 74, 0.1);
            border: 2px dashed var(--dorado);
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
        }

        .code-display p {
            color: #666;
            margin-bottom: 5px;
            font-size: 0.9em;
        }

        .code-display strong {
            color: var(--dorado);
            font-size: 1.3em;
            letter-spacing: 2px;
            font-family: 'Seguisbi', monospace;
        }

        .contact-section {
            background-color: var(--negro);
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
        }

        .contact-section h3 {
            color: var(--dorado);
            margin-bottom: 15px;
            font-size: 1.1em;
            font-weight: 600;
        }

        .contact-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .contact-info {
            color: var(--blanco);
            margin: 15px 0 0 0;
            font-size: 0.9em;
            line-height: 1.8;
        }

        .contact-info p {
            margin-bottom: 8px;
        }

        .contact-info a {
            color: var(--dorado);
            text-decoration: none;
            transition: color 0.3s;
        }

        .contact-info a:hover {
            color: #e6b84d;
            text-decoration: underline;
        }

        .contact-btn {
            background-color: var(--dorado);
            color: var(--negro);
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95em;
            transition: all 0.3s;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            flex: 1;
        }

        .contact-btn:active {
            transform: scale(0.95);
        }

        .contact-btn:hover {
            background-color: #c99938;
        }

        .whatsapp-btn {
            background-color: #25D366;
            color: var(--blanco);
        }

        .whatsapp-btn:hover {
            background-color: #1fb855;
        }

        .error-message {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        /* Responsivo para móviles */
        @media screen and (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 20px 15px;
                border-radius: 15px;
            }

            .logo-icon {
                width: 30px;
                height: 30px;
            }

            .logo-text {
                font-size: 1.4em;
            }

            .gift-box {
                font-size: 6em;
            }

            .gift-screen h2 {
                font-size: 1.3em;
            }

            .gift-screen p {
                font-size: 1em;
            }

            .prize-name {
                font-size: 1.3em;
            }

            .contact-buttons {
                flex-direction: column;
            }

            .contact-btn {
                width: 100%;
                padding: 14px 20px;
            }

            .contact-section {
                padding: 15px;
            }

            .code-display strong {
                font-size: 1.1em;
                word-break: break-all;
            }
        }

        @media screen and (max-width: 360px) {
            .logo-text {
                font-size: 1.2em;
            }

            .gift-box {
                font-size: 5em;
            }

            .gift-screen h2 {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo Header -->
        <div class="logo-header">
            <div class="logo-content">
                <img src="./../../public/images/logo/isotipo.png" alt="Casa T'ÖHÖ x ZÄNÄ" class="logo-icon">
                <span class="logo-text">CASA T'ÖHÖ x ZÄNÄ</span>
            </div>
            <img src="./../../public/images/logo/zana.png" alt="Logo" class="logo-icon">
        </div>
        
        <!-- Pantalla 1: Regalo animado -->
        <div class="gift-screen" id="giftScreen">
            <h2>Alguien especial te ha enviado un regalo</h2>
            <div class="gift-box" onclick="abrirRegalo()">🎁</div>
            <p class="gift-hint">Toca el regalo para descubrirlo</p>
        </div>

        <!-- Pantalla 2: Celebración y regalo -->
        <div class="celebration-screen" id="celebrationScreen">
            <div class="prize-text">Te han regalado un:</div>
            <div class="prize-name" id="prizeName">...</div>
            <div class="prize-description" id="prizeDescription">...</div>
            <div class="usos-info" id="usosInfo"></div>

            <div class="code-display">
                <p>Tu código es:</p>
                <strong id="displayCode">...</strong>
            </div>

            <div class="contact-section">
                <h3>Agenda tu cita</h3>
                
                <div class="contact-buttons">
                    <a href="tel:7751195568" class="contact-btn">Llamar</a>
                    <a href="#" id="whatsappBtn" class="contact-btn whatsapp-btn" target="_blank">WhatsApp</a>
                </div>

                <div class="contact-info">
                    <p>Te esperamos en Casa T'ÖHÖ x ZÄNÄ</p>
                    <a href="https://www.google.com/maps/place/Casa+T'%C3%B6h%C3%B6/@20.0768913,-98.3740768,17z/data=!3m1!4b1!4m6!3m5!1s0x85d057afb853c80d:0xb31e1c137b7d7eaf!8m2!3d20.0768913!4d-98.3740768!16s%2Fg%2F11x785v_kn?entry=ttu&g_ep=EgoyMDI1MTAxNC4wIKXMDSoASAFQAw%3D%3D" target="_blank">
                        Calle Gral Lázaro Cárdenas 206, C. Benito Juarez, 43670 Tulancingo, Hgo.
                    </a>
                </div>
            </div>
        </div>

        <!-- Mensaje de error (si el código es inválido) -->
        <div class="error-message" id="errorMessage">
            Lo sentimos, este código no es válido o el enlace es incorrecto.
        </div>
    </div>

    <script>
        const codigoUrl = '<?php echo $codigoUrl; ?>';
        let regaloData = null;

        // Si NO hay código en la URL, mostrar error
        if (!codigoUrl) {
            document.getElementById('giftScreen').style.display = 'none';
            document.getElementById('errorMessage').textContent = 'No se proporcionó un código válido. Por favor usa el enlace que te enviaron.';
            document.getElementById('errorMessage').classList.add('show');
        }

        function abrirRegalo() {
            if (!codigoUrl) return;
            
            // Detener animación del regalo
            const giftBox = document.querySelector('.gift-box');
            giftBox.style.animation = 'none';
            
            verificarCodigoAutomatico(codigoUrl);
        }

        async function verificarCodigoAutomatico(codigo) {
            try {
                
            console.log('Iniciando verificación para código:', codigo);
        console.log('URL base:', window.location.origin);
        console.log('URL completa:', window.location.href);
        
        const url = `${window.location.origin}/verificar-codigo`;
        console.log('Haciendo petición a:', url);
        
        const response = await fetch(url, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ codigo: codigo })
        });

        console.log('Response status:', response.status);
        console.log('Response headers:', [...response.headers.entries()]);
        
        const contentType = response.headers.get("content-type");
        console.log('Content-Type:', contentType);
        
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error('Respuesta NO ES JSON:', text.substring(0, 500));
            throw new Error('El servidor no devolvió JSON válido');
        }

        const result = await response.json();
        console.log('Resultado:', result);

                if (result.success) {
                    regaloData = result.regalo;
                    mostrarCelebracion(result.regalo);
                } else {
                    document.getElementById('giftScreen').classList.add('hidden');
                    document.getElementById('errorMessage').textContent = result.message || 'Este código no es válido';
                    document.getElementById('errorMessage').classList.add('show');
                }
            } catch (error) {
                document.getElementById('giftScreen').classList.add('hidden');
                document.getElementById('errorMessage').textContent = 'Error al verificar el código. Por favor intenta más tarde.';
                document.getElementById('errorMessage').classList.add('show');
                console.error('Error:', error);
            }
        }

        function mostrarCelebracion(regalo) {
            document.getElementById('giftScreen').classList.add('hidden');
            document.getElementById('celebrationScreen').classList.add('active');
            
            // Mostrar información del regalo
            document.getElementById('prizeName').textContent = regalo.nombre;
            
            // Si no hay descripción, mostrar mensaje por defecto
            const descripcion = regalo.descripcion && regalo.descripcion.trim() !== '' 
                ? regalo.descripcion 
                : '¡Que lo disfrutes!';
            document.getElementById('prizeDescription').textContent = descripcion;
            
            document.getElementById('displayCode').textContent = regalo.codigo;

            // Mostrar info de usos si es mayor a 1
            const usosInfo = document.getElementById('usosInfo');
            if (regalo.cantidad_total > 1) {
                const usosRestantes = regalo.cantidad_total - regalo.usos_realizados;
                if (usosRestantes > 0) {
                    usosInfo.innerHTML = `<strong>Este código tiene ${regalo.cantidad_total} usos</strong><br>Tienes ${usosRestantes} uso${usosRestantes > 1 ? 's' : ''} disponible${usosRestantes > 1 ? 's' : ''}`;
                } else {
                    usosInfo.innerHTML = `<strong>Este código tiene ${regalo.cantidad_total} usos</strong><br>Ya fueron utilizados todos los usos`;
                }
                usosInfo.style.display = 'block';
            } else {
                usosInfo.style.display = 'none';
            }

            // Configurar WhatsApp
            const mensaje = `Hola! Me regalaron un servicio en Casa T'ÖHÖ x ZÄNÄ. Mi código es: ${regalo.codigo}. ¿Qué días tienen disponibles para agendar?`;
            const whatsappUrl = `https://wa.me/5217751195568?text=${encodeURIComponent(mensaje)}`;
            document.getElementById('whatsappBtn').href = whatsappUrl;
            
            // Crear corazones
            crearCorazones();
        }

        function crearCorazones() {
            const numCorazones = 30;
            
            for (let i = 0; i < numCorazones; i++) {
                setTimeout(() => {
                    const heart = document.createElement('div');
                    heart.className = 'heart';
                    heart.innerHTML = '✨';
                    heart.style.left = Math.random() * 100 + '%';
                    heart.style.animationDuration = (Math.random() * 2 + 3) + 's';
                    heart.style.fontSize = (Math.random() * 20 + 20) + 'px';
                    document.body.appendChild(heart);
                    
                    setTimeout(() => heart.remove(), 5000);
                }, i * 100);
            }
        }
    </script>
</body>
</html>