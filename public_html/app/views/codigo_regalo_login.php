<?php
// app/views/codigo_regalo_login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./../../public/images/logo/isotipo.ico">
    <title>Acceso Administrativo - Casa Toho</title>
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
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--negro);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: var(--blanco);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(216, 165, 74, 0.5);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .logo {
            font-family: 'Thurkle', serif;
            font-size: 2.5em;
            font-weight: bold;
            color: var(--dorado);
            margin-bottom: 10px;
        }

        h2 {
            color: var(--negro);
            margin-bottom: 30px;
            font-size: 1.5em;
        }

        .pin-input {
            width: 100%;
            padding: 15px;
            font-size: 1.5em;
            border: 2px solid #ddd;
            border-radius: 10px;
            text-align: center;
            letter-spacing: 10px;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        .pin-input:focus {
            outline: none;
            border-color: var(--dorado);
        }

        .btn {
            background-color: var(--dorado);
            color: var(--negro);
            border: none;
            padding: 15px 40px;
            font-size: 1.1em;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #c99938;
            transform: translateY(-2px);
        }

        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            border-radius: 8px;
            padding: 10px;
            margin-top: 15px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .loading {
            display: none;
            color: var(--dorado);
            margin-top: 15px;
        }

        .loading.show {
            display: block;
        }

        @media screen and (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .logo {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">🔐 Casa Toho</div>
        <h2>Acceso Administrativo</h2>
        <p style="color: #666; margin-bottom: 20px;">Ingresa el PIN de 6 dígitos</p>
        
        <form id="loginForm">
            <input type="password" 
                   class="pin-input" 
                   id="pinInput" 
                   placeholder="••••••" 
                   maxlength="6"
                   inputmode="numeric"
                   pattern="[0-9]*"
                   autocomplete="off">
            <div class="error-message" id="errorMessage">PIN incorrecto</div>
            <div class="loading" id="loading">Verificando...</div>
            <button type="submit" class="btn" id="loginBtn">Acceder</button>
        </form>
    </div>

    <script>
        const pinInput = document.getElementById('pinInput');
        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');
        const loading = document.getElementById('loading');
        const loginBtn = document.getElementById('loginBtn');

        // Solo permitir números
        pinInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const pin = pinInput.value.trim();
            
            if (pin.length !== 6) {
                errorMessage.textContent = 'El PIN debe tener 6 dígitos';
                errorMessage.classList.add('show');
                return;
            }

            loginBtn.disabled = true;
            loading.classList.add('show');
            errorMessage.classList.remove('show');

            try {
                const response = await fetch('/admin/verificar-pin', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ pin: pin })
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = '/codigo-regalo-admin';
                } else {
                    errorMessage.textContent = result.message || 'PIN incorrecto';
                    errorMessage.classList.add('show');
                    pinInput.value = '';
                    pinInput.focus();
                }
            } catch (error) {
                errorMessage.textContent = 'Error al verificar PIN';
                errorMessage.classList.add('show');
                console.error('Error:', error);
            } finally {
                loginBtn.disabled = false;
                loading.classList.remove('show');
            }
        });

        // Auto-focus
        pinInput.focus();
    </script>
</body>
</html>