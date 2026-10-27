<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="./../../public/images/logo/isotipo.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada | Casa T'ÖHÖ</title>
    <style>
        :root {
            --primary-color: #d8a54a;
            --white-color: #ffffff;
            --black-color: #000000;
        }
        @font-face {
            font-family: 'Seguisbi';
            src: url('./../../public/fonts/seguisbi.ttf') format('truetype');
            font-display: swap;
        }
        body {
            background-color: var(--black-color);
            background-image: 
                repeating-radial-gradient(
                    circle at center, 
                    rgba(216, 165, 74, 0.05) 0px, 
                    rgba(216, 165, 74, 0.05) 1px, 
                    transparent 1px, 
                    transparent 50px
                ),
                linear-gradient(
                    135deg, 
                    rgba(216, 165, 74, 0.1) 0%, 
                    rgba(0,0,0,0.2) 100%
                );
            color: var(--white-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }
        .container {
            text-align: center;
            max-width: 600px;
            min-height: 500px; /* Altura fija para mantener el tamaño */
            padding: .1rem .1rem .1rem .1rem;
            background-color: rgba(0,0,0,0.7);
            border-radius: 20px;
            box-shadow: 0 0 5px var(--primary-color);
            position: relative;
            z-index: 10;
            animation: glow 3s ease-in-out infinite;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centra verticalmente el contenido */
        }
        .logo img {
            max-width: 250px; 
            max-height: 250px; 
            width: auto; 
            height: auto; 
            display: block; 
            margin: 0 auto; 
            object-fit: contain; 
        }
        .error-message {
            font-family: 'Seguisbi';
            font-size: 1.9rem;
            margin-bottom: 1.5rem;
            flex-grow: 0; /* Evita que el texto expanda el contenedor */
            
            max-width: 300px;
        }
        .return-link {
            display: inline-block;
            color: var(--primary-color);
            text-decoration: none;
            font-family: 'Seguisbi';
            font-size: 1.2rem;
            border: 2px solid var(--primary-color);
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            align-self: center; /* Centra el enlace horizontalmente */
        }
        .return-link:hover {
            background-color: var(--primary-color);
            color: var(--black-color);
        }
         @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 5px var(--primary-color);
            }
            50% {
                box-shadow: 0 0 20px var(--primary-color);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="./../../public/images/logo/logo.webp" alt="Casa T'öhö | Casa Toho | Casa TOHO"  width="250" 
     height="250" 
     />
        </div>
        <p class="error-message">404 - Página no encontrada</p>
        <a href="/" class="return-link">Regresar al Inicio</a>
    </div>
</body>
</html>