<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Meseros — Casa T'ÖHÖ</title>
    <style>
        :root {
            --primary: #d8a54a;
            --bg: #000000;
            --surface: rgba(0,0,0,0.7);
            --text: #ffffff;
            --red: #e05555;
            --green: #4caf74;
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
            padding: 30px 20px;
        }
        h1 {
            font-family: 'Thurkle', serif;
            font-size: 2.5rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(216,165,74,0.5);
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: var(--primary); color: #000; }
        .btn-secondary { background: rgba(255,255,255,0.1); color: var(--text); border: 1px solid rgba(255,255,255,0.2); }
        .btn-danger { background: var(--red); color: #fff; }
        .btn-edit { background: rgba(216,165,74,0.15); color: var(--primary); border: 1px solid var(--primary); }
        .btn-sm { padding: 6px 14px; font-size: 0.85rem; }
        .card {
            background: var(--surface);
            border: 1px solid rgba(216,165,74,0.3);
            border-radius: 16px;
            box-shadow: 0 0 5px var(--primary);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: rgba(216,165,74,0.12);
        }
        th {
            padding: 14px 16px;
            text-align: left;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td {
            padding: 12px 16px;
            border-top: 1px solid rgba(255,255,255,0.07);
            vertical-align: middle;
        }
        tr:hover td { background: rgba(216,165,74,0.04); }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-active { background: rgba(76,175,116,0.2); color: var(--green); border: 1px solid var(--green); }
        .badge-inactive { background: rgba(224,85,85,0.15); color: var(--red); border: 1px solid var(--red); }
        .td-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        form.inline { display: inline; }
        .empty { text-align: center; padding: 40px; color: rgba(255,255,255,0.4); font-size: 1rem; }
        .back-link { color: var(--primary); text-decoration: none; font-size: 0.9rem; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h1>Gestión de Meseros</h1>

    <div class="actions">
        <a href="/dashboard" class="back-link">← Volver al Dashboard</a>
        <a href="/meseros-admin/crear" class="btn btn-primary">+ Agregar Mesero</a>
    </div>

    <div class="card">
        <?php if (empty($meseros)): ?>
            <div class="empty">No hay meseros registrados aún.</div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Registrado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($meseros as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['id']) ?></td>
                    <td><?= htmlspecialchars($m['nombre']) ?></td>
                    <td>
                        <?php if ($m['activo']): ?>
                            <span class="badge badge-active">Activo</span>
                        <?php else: ?>
                            <span class="badge badge-inactive">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($m['creado_en']))) ?></td>
                    <td>
                        <div class="td-actions">
                            <a href="/meseros-admin/editar?id=<?= $m['id'] ?>" class="btn btn-edit btn-sm">Editar</a>
                            <form class="inline" method="POST" action="/meseros-admin/eliminar"
                                  onsubmit="return confirm('¿Eliminar/desactivar a <?= htmlspecialchars(addslashes($m['nombre'])) ?>?')">
                                <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <p style="margin-top:1rem; font-size:0.8rem; color:rgba(255,255,255,0.4);">
        * Si un mesero tiene encuestas asociadas, se desactivará en lugar de eliminarse.
    </p>
</div>
</body>
</html>
