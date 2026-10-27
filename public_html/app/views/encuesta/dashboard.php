<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Casa T'ÖHÖ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <style>
        :root {
            --primary-color: #d8a54a;
            --white-color: #ffffff;
            --black-color: #000000;
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
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        h1 {
            font-family: 'Thurkle', serif;
            font-size: 3rem;
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(216, 165, 74, 0.5);
            animation: glow 3s ease-in-out infinite;
        }

        h2 {
            font-family: 'Seguisbi', sans-serif;
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }

        h3 {
            font-family: 'Seguisbi', sans-serif;
            color: var(--white-color);
            margin-bottom: 1rem;
            text-align: center;
            font-size: 1.2rem;
        }

        @keyframes glow {
            0%, 100% {
                text-shadow: 0 0 10px rgba(216, 165, 74, 0.5);
            }
            50% {
                text-shadow: 0 0 20px rgba(216, 165, 74, 0.8);
            }
        }

        .container {
            background-color: rgba(0,0,0,0.7);
            border-radius: 20px;
            box-shadow: 0 0 5px var(--primary-color);
            position: relative;
            z-index: 10;
            padding: 2rem;
            margin-bottom: 2rem;
            animation: containerGlow 3s ease-in-out infinite;
        }

        @keyframes containerGlow {
            0%, 100% {
                box-shadow: 0 0 5px var(--primary-color);
            }
            50% {
                box-shadow: 0 0 20px var(--primary-color);
            }
        }

        /* Grid para las gráficas principales */
        .charts-main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .chart-main-item {
            background-color: rgba(0,0,0,0.7);
            border-radius: 20px;
            box-shadow: 0 0 5px var(--primary-color);
            padding: 2rem;
            animation: containerGlow 3s ease-in-out infinite;
        }

        /* Grid para las gráficas de distribución */
        .charts-distribution-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-distribution-item {
            background-color: rgba(0,0,0,0.7);
            border-radius: 15px;
            box-shadow: 0 0 5px var(--primary-color);
            padding: 1.5rem;
            animation: containerGlow 3s ease-in-out infinite;
            min-height: 350px;
            display: flex;
            flex-direction: column;
        }


        .filtros {
            margin-bottom: 30px;
            text-align: center;
        }

        .filtros form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filtros label {
            color: var(--primary-color);
            font-weight: bold;
        }

        .filtros input[type="date"] {
            background-color: rgba(216, 165, 74, 0.1);
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            padding: 8px;
            color: var(--white-color);
            font-size: 14px;
        }

        .filtros input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        .filtros button {
            background-color: var(--primary-color);
            color: var(--black-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filtros button:hover {
            background-color: var(--white-color);
            transform: scale(1.05);
        }

        .summary {
            background-color: rgba(216, 165, 74, 0.1);
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 0 10px 10px 0;
        }

        .summary strong {
            color: var(--primary-color);
        }

        .chart-container {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            border: 1px solid rgba(216, 165, 74, 0.3);
            flex-grow: 1;
            position: relative;
            min-height: 280px;
        }

        canvas {
            max-width: 100%;
        }

        .comentarios {
            background: rgba(216, 165, 74, 0.1);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 40px;
            border: 1px solid var(--primary-color);
        }

        .comentario-item {
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(216, 165, 74, 0.3);
            padding-bottom: 10px;
        }

        .comentario-item:last-child {
            border-bottom: none;
        }

        .comentario-fecha {
            font-size: 0.8em;
            color: var(--primary-color);
            font-style: italic;
            margin-top: 8px;
        }

        .comentario-mesero {
            font-size: 0.85em;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 5px;
            font-weight: 600;
        }

        .btn-seccion {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-seccion:hover {
            background-color: var(--primary-color);
            color: var(--black-color);
        }

        .btn-seccion.active {
            background-color: var(--primary-color);
            color: var(--black-color);
        }

        /* Responsivo */
        @media (max-width: 1200px) {
            .charts-distribution-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .container {
                padding: 1rem;
            }
            
            .charts-main-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .charts-distribution-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem;
            }

            .chart-main-item,
            .chart-distribution-item {
                padding: 1rem;
            }

            .chart-distribution-item {
                min-height: 380px;
            }

            .chart-container {
                min-height: 300px;
            }
            
            .filtros form {
                flex-direction: column;
                gap: 10px;
            }

            /* ---- Meseros: cards en móvil ---- */
            .mesero-table-wrap { display: none; }
            .mesero-cards { display: flex; flex-direction: column; gap: 1rem; }
            .mesero-card {
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(216,165,74,0.2);
                border-radius: 12px;
                padding: 1rem;
            }
            .mesero-card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 0.75rem;
            }
            .mesero-card-name {
                font-weight: 700;
                font-size: 1rem;
            }
            .mesero-card-avg {
                font-weight: 700;
                font-size: 1.1rem;
            }
            .mesero-card-bar {
                background: rgba(255,255,255,0.1);
                border-radius: 4px;
                height: 6px;
                overflow: hidden;
                margin-bottom: 0.75rem;
            }
            .mesero-card-bar-fill {
                height: 100%;
                border-radius: 4px;
                transition: width 0.6s;
            }
            .mesero-card-stats {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 6px 12px;
            }
            .mesero-stat {
                display: flex;
                justify-content: space-between;
                font-size: 0.82rem;
            }
            .mesero-stat-label { color: rgba(255,255,255,0.5); }
            .mesero-stat-val   { font-weight: 600; color: rgba(255,255,255,0.9); }
            .mesero-encuestas-badge {
                font-size: 0.78rem;
                color: rgba(255,255,255,0.45);
                margin-top: 0.5rem;
            }
        }

        @media (min-width: 641px) {
            .mesero-table-wrap { display: block; overflow-x: auto; }
            .mesero-cards { display: none; }
        }
    </style>
</head>
<body>

<div class="main-container">
    <h1>Dashboard Casa T'ÖHÖ</h1>

    <div class="container">
        <div class="filtros">
            <form method="GET" action="/dashboard">
                <label for="fecha_inicio">Fecha inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? date('Y-m-01')) ?>" required>
                
                <label for="fecha_fin">Fecha fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($_GET['fecha_fin'] ?? date('Y-m-d')) ?>" required>
                
                <button type="submit">Filtrar</button>
            </form>
        </div>

        <div class="summary">
            <strong>Total de encuestas recibidas:</strong> <?= $total ?><br>
            <strong>Fecha del último registro:</strong> 
            <?php
            // OPCIÓN 1: Usar el nuevo método (recomendado)
            if (isset($fechaUltimoRegistro) && $fechaUltimoRegistro) {
                echo htmlspecialchars($fechaUltimoRegistro);
            } 
            ?>
        </div>
    </div>

    <!-- Gráficas principales en horizontal -->
    <div class="charts-main-grid">
        <div class="chart-main-item">
            <h2>Satisfacción General Promedio</h2>
            <div class="chart-container">
                <canvas id="satisfaccionGeneral"></canvas>
            </div>
        </div>

        <div class="chart-main-item">
            <h2>Respuestas por dia</h2>
            <div class="chart-container">
                <canvas id="tendenciaDiaria"></canvas>
            </div>
        </div>
    </div>

    <!-- Título para las gráficas de distribución -->
    <div class="container" style="padding: 1rem 2rem; margin-bottom: 1rem;">
        <h2 style="text-align: center; border: none; margin: 0;">Distribución de respuestas por pregunta</h2>
    </div>

    <!-- Gráficas de distribución - 4 preguntas (2 filas de 2) -->
    <?php 
        $preguntas = [
            "Limpieza del restaurante",
            "Trato del personal", 
            "Calidad de la comida",
            "Recomendación"
        ];
        $claves = array_keys($distribuciones);
    ?>

    <div class="charts-distribution-grid">
        <?php for($i = 0; $i < 4 && $i < count($claves); $i++): ?>
            <div class="chart-distribution-item">
                <h3><?= $preguntas[$i] ?></h3>
                <div class="chart-container">
                    <canvas id="<?= $claves[$i] ?>"></canvas>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- ============================================================ -->
    <!-- SECCIÓN: Estadísticas por Mesero                             -->
    <!-- ============================================================ -->
    <div class="container">
        <h2>Desempeño por Mesero</h2>

        <div style="display:flex; justify-content:flex-end; margin-bottom:1rem;">
            <a href="/meseros-admin"
               style="color:#d8a54a; font-size:0.9rem; text-decoration:none; border:1px solid #d8a54a; padding:7px 16px; border-radius:8px; font-weight:600; transition:background 0.2s;"
               onmouseover="this.style.background='rgba(216,165,74,0.12)'"
               onmouseout="this.style.background='transparent'">
                ⚙ Gestionar Meseros
            </a>
        </div>

        <?php if (empty($estadisticasMeseros)): ?>
            <p style="color:rgba(255,255,255,0.5); text-align:center; padding:2rem 0;">
                No hay encuestas con mesero registrado en el período seleccionado.
            </p>
        <?php else: ?>

        <!-- Gráfica horizontal — altura dinámica según número de meseros -->
        <?php $chartHeightPx = max(200, count($estadisticasMeseros) * 72); ?>
        <div style="position:relative; width:100%; height:<?= $chartHeightPx ?>px; margin-bottom:2rem;">
            <canvas id="chartMeseros"></canvas>
        </div>

        <!-- Tabla: visible solo en escritorio -->
        <div class="mesero-table-wrap">
        <table style="width:100%; border-collapse:collapse; font-size:0.9rem;">
            <thead>
                <tr style="background:rgba(216,165,74,0.12);">
                    <th style="padding:12px 14px; text-align:left; color:#d8a54a; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.05em;">Mesero</th>
                    <th style="padding:12px 14px; text-align:center; color:#d8a54a; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.05em;">Encuestas</th>
                    <th style="padding:12px 14px; text-align:center; color:#d8a54a; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.05em;">Promedio General</th>
                    <th style="padding:12px 14px; text-align:center; color:#d8a54a; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.05em;">Limpieza</th>
                    <th style="padding:12px 14px; text-align:center; color:#d8a54a; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.05em;">Trato</th>
                    <th style="padding:12px 14px; text-align:center; color:#d8a54a; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.05em;">Comida</th>
                    <th style="padding:12px 14px; text-align:center; color:#d8a54a; text-transform:uppercase; font-size:0.8rem; letter-spacing:0.05em;">Recomendación</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($estadisticasMeseros as $idx => $m):
                $pct = round(($m['avg_general'] / 4) * 100);
                $color = $pct >= 75 ? '#4caf74' : ($pct >= 50 ? '#d8a54a' : '#e05555');
                $medal = $idx === 0 ? '🥇 ' : ($idx === 1 ? '🥈 ' : ($idx === 2 ? '🥉 ' : ''));
            ?>
            <tr style="border-top:1px solid rgba(255,255,255,0.07);">
                <td style="padding:12px 14px; font-weight:600;"><?= $medal . htmlspecialchars($m['mesero']) ?></td>
                <td style="padding:12px 14px; text-align:center;"><?= $m['total'] ?></td>
                <td style="padding:12px 14px; text-align:center;">
                    <span style="font-weight:700; color:<?= $color ?>; font-size:1.05rem;"><?= $m['avg_general'] ?>/4</span>
                    <div style="background:rgba(255,255,255,0.1); border-radius:4px; height:6px; margin-top:5px; overflow:hidden;">
                        <div style="background:<?= $color ?>; width:<?= $pct ?>%; height:100%; border-radius:4px;"></div>
                    </div>
                </td>
                <td style="padding:12px 14px; text-align:center; color:rgba(255,255,255,0.8);"><?= $m['avg_r1'] ?></td>
                <td style="padding:12px 14px; text-align:center; color:rgba(255,255,255,0.8);"><?= $m['avg_r2'] ?></td>
                <td style="padding:12px 14px; text-align:center; color:rgba(255,255,255,0.8);"><?= $m['avg_r3'] ?></td>
                <td style="padding:12px 14px; text-align:center; color:rgba(255,255,255,0.8);"><?= $m['avg_r4'] ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        <!-- Cards: visibles solo en móvil -->
        <div class="mesero-cards">
        <?php foreach ($estadisticasMeseros as $idx => $m):
            $pct   = round(($m['avg_general'] / 4) * 100);
            $color = $pct >= 75 ? '#4caf74' : ($pct >= 50 ? '#d8a54a' : '#e05555');
            $medal = $idx === 0 ? '🥇 ' : ($idx === 1 ? '🥈 ' : ($idx === 2 ? '🥉 ' : ''));
        ?>
        <div class="mesero-card">
            <div class="mesero-card-header">
                <span class="mesero-card-name"><?= $medal . htmlspecialchars($m['mesero']) ?></span>
                <span class="mesero-card-avg" style="color:<?= $color ?>"><?= $m['avg_general'] ?>/4</span>
            </div>
            <div class="mesero-card-bar">
                <div class="mesero-card-bar-fill" style="width:<?= $pct ?>%; background:<?= $color ?>;"></div>
            </div>
            <div class="mesero-card-stats">
                <div class="mesero-stat">
                    <span class="mesero-stat-label">Limpieza</span>
                    <span class="mesero-stat-val"><?= $m['avg_r1'] ?></span>
                </div>
                <div class="mesero-stat">
                    <span class="mesero-stat-label">Trato</span>
                    <span class="mesero-stat-val"><?= $m['avg_r2'] ?></span>
                </div>
                <div class="mesero-stat">
                    <span class="mesero-stat-label">Comida</span>
                    <span class="mesero-stat-val"><?= $m['avg_r3'] ?></span>
                </div>
                <div class="mesero-stat">
                    <span class="mesero-stat-label">Recomendación</span>
                    <span class="mesero-stat-val"><?= $m['avg_r4'] ?></span>
                </div>
            </div>
            <div class="mesero-encuestas-badge"><?= $m['total'] ?> encuesta<?= $m['total'] != 1 ? 's' : '' ?></div>
        </div>
        <?php endforeach; ?>
        </div>

        <p style="margin-top:0.75rem; font-size:0.8rem; color:rgba(255,255,255,0.4);">
            Escala de calificación: 1 (Mala) — 2 (Regular) — 3 (Buena) — 4 (Excelente)
        </p>

        <script>
        (function() {
            const meseroData = <?= json_encode($estadisticasMeseros) ?>;
            const labels = meseroData.map(m => m.mesero);
            const avgGen = meseroData.map(m => parseFloat(m.avg_general));
            const avgR1  = meseroData.map(m => parseFloat(m.avg_r1));
            const avgR2  = meseroData.map(m => parseFloat(m.avg_r2));
            const avgR3  = meseroData.map(m => parseFloat(m.avg_r3));
            const avgR4  = meseroData.map(m => parseFloat(m.avg_r4));

            new Chart(document.getElementById('chartMeseros').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Promedio General', data: avgGen, backgroundColor: 'rgba(216,165,74,0.85)', borderRadius: 5 },
                        { label: 'Limpieza',         data: avgR1,  backgroundColor: 'rgba(74,144,226,0.75)', borderRadius: 5 },
                        { label: 'Trato',            data: avgR2,  backgroundColor: 'rgba(76,175,116,0.75)', borderRadius: 5 },
                        { label: 'Comida',           data: avgR3,  backgroundColor: 'rgba(243,156,18,0.75)', borderRadius: 5 },
                        { label: 'Recomendación',    data: avgR4,  backgroundColor: 'rgba(231,76,60,0.75)',  borderRadius: 5 }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#ffffff',
                                font: { size: 11 },
                                boxWidth: 12,
                                padding: 14
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.x}/4`
                            }
                        }
                    },
                    scales: {
                        x: {
                            min: 0, max: 4,
                            ticks: { color: '#ffffff', stepSize: 1 },
                            grid: { color: 'rgba(216,165,74,0.2)' }
                        },
                        y: {
                            ticks: {
                                color: '#d8a54a',
                                font: { weight: 'bold', size: 12 }
                            },
                            grid: { color: 'rgba(216,165,74,0.1)' }
                        }
                    }
                }
            });
        })();
        </script>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>Comentarios</h2>

        <!-- Botones para seleccionar sección -->
        <div style="text-align:center; margin-bottom: 1.5rem;">
            <button type="button" class="btn-seccion active" data-seccion="recientes" style="margin-right: 10px;">Recientes</button>
            <button type="button" class="btn-seccion" data-seccion="hoy" style="margin-right: 10px;">Del Día</button>
            <button type="button" class="btn-seccion" data-seccion="rango">En Rango</button>
        </div>

        <!-- Sección: Comentarios recientes -->
        <div class="seccion-comentarios" id="recientes">
            <?php if (count($ultimosComentarios) == 0): ?>
                <p>No hay comentarios aún.</p>
            <?php else: ?>
                <div class="comentarios">
                    <?php foreach($ultimosComentarios as $c): ?>
                        <div class="comentario-item">
                            <p><?= nl2br(htmlspecialchars($c['comentarios'])) ?></p>
                            <?php if (!empty($c['mesero'])): ?>
                                <div class="comentario-mesero">👤 <?= htmlspecialchars($c['mesero']) ?></div>
                            <?php endif; ?>
                            <div class="comentario-fecha"><?= $c['fecha'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sección: Comentarios del día -->
        <div class="seccion-comentarios" id="hoy" style="display:none; max-height: 300px; overflow-y: auto;">
            <?php if (count($comentariosHoy) == 0): ?>
                <p>No hay comentarios para hoy.</p>
            <?php else: ?>
                <div class="comentarios">
                    <?php foreach($comentariosHoy as $c): ?>
                        <div class="comentario-item">
                            <p><?= nl2br(htmlspecialchars($c['comentarios'])) ?></p>
                            <?php if (!empty($c['mesero'])): ?>
                                <div class="comentario-mesero">👤 <?= htmlspecialchars($c['mesero']) ?></div>
                            <?php endif; ?>
                            <div class="comentario-fecha"><?= $c['fecha'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sección: Comentarios en rango -->
        <div class="seccion-comentarios" id="rango" style="display:none; max-height: 300px; overflow-y: auto;">
            <?php if (count($comentariosRango) == 0): ?>
                <p>No hay comentarios en este rango.</p>
            <?php else: ?>
                <div class="comentarios">
                    <?php foreach($comentariosRango as $c): ?>
                        <div class="comentario-item">
                            <p><?= nl2br(htmlspecialchars($c['comentarios'])) ?></p>
                            <?php if (!empty($c['mesero'])): ?>
                                <div class="comentario-mesero">👤 <?= htmlspecialchars($c['mesero']) ?></div>
                            <?php endif; ?>
                            <div class="comentario-fecha"><?= $c['fecha'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="summary" style="margin-top: 1.5rem;">
            <strong>Total de comentarios:</strong> <?= $totalComentarios ?>
        </div>
    </div>
</div>

<script>
    // Datos PHP a JS
    const distribuciones = <?= json_encode($distribuciones) ?>;
    const tendencia = <?= json_encode($tendencia) ?>;
    const promedios = <?= json_encode($promedios) ?>;

    // Satisfacción General Promedio (promedio de los 4 promedios)
    // Los promedios ya vienen calculados del modelo (0-4, donde 4=Excelente, 1=Mala)
    const promedioGeneral = Object.values(promedios).reduce((a,b) => a + parseFloat(b), 0) / 4;

    // Gráfico de satisfacción general (doughnut) con colores de Casa T'ÖHÖ
    const ctxGeneral = document.getElementById('satisfaccionGeneral').getContext('2d');
    new Chart(ctxGeneral, {
        type: 'doughnut',
        data: {
            labels: ['Satisfacción'],
            datasets: [{
                label: 'Promedio General',
                data: [promedioGeneral, 4 - promedioGeneral],
                backgroundColor: ['#d8a54a', 'rgba(255,255,255,0.1)'],
                borderColor: ['#d8a54a', 'rgba(255,255,255,0.3)'],
                borderWidth: 2,
                hoverOffset: 30
            }]
        },
        options: {
            circumference: 180,
            rotation: 270,
            cutout: '70%',
            plugins: {
                tooltip: { 
                    enabled: true,
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#d8a54a',
                    bodyColor: '#ffffff'
                },
                legend: { display: false }
            }
        },
        plugins: [{
            afterDraw: function(chart) {
                const {ctx, width, height} = chart;
                ctx.restore();
                ctx.font = "bold 24px Arial";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#d8a54a";

                const text = promedioGeneral.toFixed(2) + " / 4";
                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                const textY = height / 1.5;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    });

    // Tendencia diaria (línea) con colores de Casa T'ÖHÖ
    const ctxTendencia = document.getElementById('tendenciaDiaria').getContext('2d');
    new Chart(ctxTendencia, {
        type: 'line',
        data: {
            labels: tendencia.map(d => d.dia),
            datasets: [{
                label: 'Número de encuestas por día',
                data: tendencia.map(d => d.total_encuestas),
                borderColor: '#d8a54a',
                backgroundColor: 'rgba(216, 165, 74, 0.2)',
                fill: true,
                tension: 0.3,
                borderWidth: 3,
                pointBackgroundColor: '#d8a54a',
                pointBorderColor: '#ffffff',
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true,
                    suggestedMax: 10,
                    grid: {
                        color: 'rgba(216, 165, 74, 0.2)'
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(216, 165, 74, 0.2)'     
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#d8a54a'
                    }
                }
            }
        }
    });


    // Gráficas circulares por pregunta con las nuevas opciones
    Object.keys(distribuciones).forEach(key => {
        const ctx = document.getElementById(key).getContext('2d');
        const data = distribuciones[key];

        // Orden: Excelente, Buena, Regular, Mala
        const valores = [
            data['Excelente'] || 0,
            data['Buena'] || 0,
            data['Regular'] || 0,
            data['Mala'] || 0
        ];

        const colores = [
            '#d8a54a',   // Excelente - Dorado (color principal)
            '#4a90e2',   // Buena - Azul
            '#f39c12',   // Regular - Naranja
            '#e74c3c'    // Mala - Rojo
        ];

        const isMobile = window.innerWidth < 640;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Excelente', 'Buena', 'Regular', 'Mala'],
                datasets: [{
                    label: 'Cantidad de respuestas',
                    data: valores,
                    backgroundColor: colores,
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: isMobile ? 'right' : 'bottom',
                        labels: {
                            color: '#ffffff',
                            padding: isMobile ? 8 : 15,
                            font: {
                                size: isMobile ? 10 : 11
                            },
                            boxWidth: isMobile ? 10 : 14
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#d8a54a',
                        bodyColor: '#ffffff'
                    },
                    datalabels: {
                        color: '#ffffff',
                        formatter: (value, ctx) => {
                            const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = sum === 0 ? 0 : (value / sum * 100);
                            return percentage > 0 ? percentage.toFixed(1) + '%' : '';
                        },
                        font: {
                            weight: 'bold',
                            size: isMobile ? 10 : 12
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

    });

    const botones = document.querySelectorAll('.btn-seccion');
    const secciones = document.querySelectorAll('.seccion-comentarios');

    botones.forEach(btn => {
        btn.addEventListener('click', () => {
            // Quitar clase active de todos los botones
            botones.forEach(b => b.classList.remove('active'));
            // Agregar active al botón clickeado
            btn.classList.add('active');

            // Ocultar todas las secciones
            secciones.forEach(sec => sec.style.display = 'none');
            // Mostrar la sección seleccionada
            const id = btn.getAttribute('data-seccion');
            document.getElementById(id).style.display = 'block';
        });
    });
</script>

</body>
</html>