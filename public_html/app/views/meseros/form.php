<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $mesero ? 'Editar Mesero' : 'Agregar Mesero' ?> — Casa T'ÖHÖ</title>
    <style>
        :root {
            --primary: #d8a54a;
            --bg: #000000;
            --surface: rgba(0,0,0,0.7);
            --text: #ffffff;
            --red: #e05555;
        }
        @font-face {
            font-family: 'Thurkle';
            src: url('./../../../../public/fonts/Thurkle.ttf') format('truetype');
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--bg);
            background-image:
                repeating-radial-gradient(circle at center, rgba(216,165,74,0.05) 0px, rgba(216,165,74,0.05) 1px, transparent 1px, transparent 50px),
                linear-gradient(135deg, rgba(216,165,74,0.1) 0%, rgba(0,0,0,0.2) 100%);
            color: var(--text);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }
        .container {
            width: 100%;
            max-width: 500px;
        }
        h1 {
            font-family: 'Thurkle', serif;
            font-size: 2rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(216,165,74,0.5);
        }
        .card {
            background: var(--surface);
            border: 1px solid rgba(216,165,74,0.3);
            border-radius: 16px;
            box-shadow: 0 0 5px var(--primary);
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(216,165,74,0.4);
            border-radius: 8px;
            color: var(--text);
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
        }
        input[type="text"]:focus {
            border-color: var(--primary);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }
        .checkbox-group label { margin: 0; cursor: pointer; }
        .error {
            background: rgba(224,85,85,0.15);
            border: 1px solid var(--red);
            color: var(--red);
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .btn-row {
            display: flex;
            gap: 12px;
            margin-top: 1.5rem;
        }
        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: var(--primary); color: #000; }
        .btn-secondary { background: rgba(255,255,255,0.1); color: var(--text); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body>
<div class="container">
    <h1><?= $mesero ? 'Editar Mesero' : 'Agregar Mesero' ?></h1>

    <div class="card">
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del mesero</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Ej: Juan García"
                    value="<?= htmlspecialchars($mesero['nombre'] ?? '') ?>"
                    required
                    autofocus
                >
            </div>

            <?php if ($mesero): ?>
            <div class="form-group">
                <div class="checkbox-group">
                    <input
                        type="checkbox"
                        id="activo"
                        name="activo"
                        <?= $mesero['activo'] ? 'checked' : '' ?>
                    >
                    <label for="activo">Mesero activo (aparece en el formulario de encuesta)</label>
                </div>
            </div>
            <?php endif; ?>

            <div class="btn-row">
                <a href="/meseros-admin" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <?= $mesero ? 'Guardar Cambios' : 'Agregar Mesero' ?>
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
