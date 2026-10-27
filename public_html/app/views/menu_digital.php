<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Tohó - Menú</title>
    <style>
        :root {
            --primary-color: #d8a54a;
            --white-color: #ffffff;
            --black-color: #000000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--black-color);
            color: var(--white-color);
            line-height: 1.2;
            height: 100vh;
            overflow-x: hidden;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="coffee" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="%23333" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23coffee)"/></svg>');
        }

        .header {
            text-align: center;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, #b8914a 100%);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--white-color);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 0.5rem;
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .nav-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid var(--primary-color);
            color: var(--white-color);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        .nav-btn.active {
            background: var(--primary-color);
        }

        .menu-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.5rem;
            height: calc(100vh - 140px);
            overflow-y: auto;
            overflow-x: hidden;
            display: grid;
            gap: 0.5rem;
        }

        /* Desktop: Grid de 4 columnas */
        @media (min-width: 1200px) {
            .menu-container {
                grid-template-columns: 1fr 1fr 1fr 1fr;
            }
        }

        /* Tablet y móvil: Grid de 2 columnas */
        @media (max-width: 1199px) {
            .menu-container {
                grid-template-columns: 1fr 1fr;
                gap: 0.3rem;
            }
        }

        .menu-column {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 0.8rem;
            border: 1px solid rgba(216, 165, 74, 0.3);
        }

        /* En móvil, columnas más sutiles */
        @media (max-width: 767px) {
            .menu-column {
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(216, 165, 74, 0.1);
                padding: 0.5rem;
                border-radius: 8px;
            }
        }

        .section-title {
            color: var(--primary-color);
            font-size: 0.65rem;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid var(--primary-color);
            padding: 0.4rem 0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            user-select: none;
        }

        .section-title:hover {
            background: rgba(216, 165, 74, 0.1);
            border-radius: 5px;
            padding: 0.4rem 0.4rem;
        }

        .section-title::after {
            content: '▼';
            font-size: 0.5rem;
            transition: transform 0.3s ease;
        }

        .section-title.collapsed::after {
            transform: rotate(-90deg);
        }

        .menu-items {
            max-height: 1000px;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.3s ease;
            opacity: 1;
        }

        .menu-items.collapsed {
            max-height: 0;
            opacity: 0;
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.4rem 0;
            border-bottom: 1px dotted rgba(216, 165, 74, 0.2);
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: bold;
            flex: 1;
            text-transform: uppercase;
            font-size: 0.55rem;
            line-height: 1.1;
        }

        .item-price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 0.6rem;
            margin-left: 0.5rem;
            white-space: nowrap;
        }

        .menu-section {
            margin-bottom: 0.8rem;
        }

        /* En móvil, secciones más compactas */
        @media (max-width: 767px) {
            .menu-section {
                margin-bottom: 0.5rem;
            }
        }

        .menu-section:last-child {
            margin-bottom: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 0.5rem;
            background: rgba(216, 165, 74, 0.1);
            border-top: 1px solid var(--primary-color);
            z-index: 10;
        }

        .contact-info {
            color: var(--primary-color);
            font-size: 0.6rem;
            line-height: 1.3;
        }

        .website {
            color: var(--white-color);
            text-decoration: none;
            font-weight: bold;
        }

        .website:hover {
            color: var(--primary-color);
        }

        /* Botón para expandir/colapsar todo */
        .expand-all-btn {
            position: fixed;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: var(--primary-color);
            border: none;
            color: var(--white-color);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 0.7rem;
            box-shadow: 0 4px 12px rgba(216, 165, 74, 0.4);
            transition: all 0.3s ease;
            z-index: 100;
        }

        .expand-all-btn:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 16px rgba(216, 165, 74, 0.6);
        }

        /* Animaciones sutiles */
        .menu-item:hover {
            background: rgba(216, 165, 74, 0.1);
            border-radius: 3px;
            transition: all 0.2s ease;
        }

        .menu-column {
            animation: fadeInUp 0.4s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar personalizado para el contenedor principal */
        .menu-container::-webkit-scrollbar {
            width: 4px;
        }

        .menu-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .menu-container::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Media queries para móvil */
        @media (max-width: 768px) {
            .header {
                padding: 0.8rem;
            }
            
            .logo {
                font-size: 1.4rem;
                margin-bottom: 0.3rem;
            }
            
            .nav-buttons {
                gap: 0.5rem;
                margin-top: 0.3rem;
            }
            
            .nav-btn {
                padding: 0.3rem 0.6rem;
                font-size: 0.65rem;
            }
            
            .menu-container {
                height: calc(100vh - 120px);
                padding: 0.3rem;
            }
            
            .section-title {
                font-size: 0.55rem;
                padding: 0.3rem 0;
            }
            
            .section-title:hover {
                padding: 0.3rem 0.3rem;
            }
            
            .menu-item {
                padding: 0.3rem 0;
            }
            
            .item-name {
                font-size: 0.48rem;
            }
            
            .item-price {
                font-size: 0.52rem;
            }
            
            .expand-all-btn {
                width: 28px;
                height: 28px;
                right: 8px;
                font-size: 0.55rem;
            }
            
            .footer {
                padding: 0.3rem;
            }
            
            .contact-info {
                font-size: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CASA TOHÓ MENÚ</div>
        <div class="nav-buttons">
            <button class="nav-btn active">Cafetería</button>
            <button class="nav-btn">Comida</button>
            <button class="nav-btn">Mixología</button>
        </div>
    </div>

    <button class="expand-all-btn" onclick="toggleAllSections()" title="Expandir/Colapsar Todo">
        ⚡
    </button>

    <div class="menu-container">
        <!-- Primera Columna -->
        <div class="menu-column">
            <!-- Cafés Calientes -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Cafés Calientes
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Americano</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Latte</span>
                        <span class="item-price">$45</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Capuccino</span>
                        <span class="item-price">$45</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Mocaccino</span>
                        <span class="item-price">$50</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Latte Vainilla</span>
                        <span class="item-price">$50</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Caramel Macchiato</span>
                        <span class="item-price">$50</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Orange Flat White</span>
                        <span class="item-price">$40</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Espresso</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Espresso Cortado</span>
                        <span class="item-price">$45</span>
                    </div>
                </div>
            </div>

            <!-- Cafés Fríos -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Cafés Fríos
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Freddo Latte</span>
                        <span class="item-price">$40</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Freddo Americano</span>
                        <span class="item-price">$30</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Ice Caramel Macchiato</span>
                        <span class="item-price">$50</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Freddo Capuccino</span>
                        <span class="item-price">$50</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda Columna -->
        <div class="menu-column">
            <!-- Bebidas Calientes -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Bebidas Calientes
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Chocolate</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Taro Latte</span>
                        <span class="item-price">$55</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Matcha Latte</span>
                        <span class="item-price">$55</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Té Negro</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Té Blanco</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Té Verde</span>
                        <span class="item-price">$35</span>
                    </div>
                </div>
            </div>

            <!-- Malteadas -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Malteadas
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Malteada Vainilla</span>
                        <span class="item-price">$60</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Malteada Cacao</span>
                        <span class="item-price">$60</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Malteada Fresa</span>
                        <span class="item-price">$60</span>
                    </div>
                </div>
            </div>

            <!-- Frappés -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Frappés
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Caramel Matcha Frappe</span>
                        <span class="item-price">$60</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Caramel Macchiato Frappe</span>
                        <span class="item-price">$60</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Cacao Frappe</span>
                        <span class="item-price">$60</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tercera Columna -->
        <div class="menu-column">
            <!-- Bebidas Frías -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Bebidas Frías
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Strawberry Refresher</span>
                        <span class="item-price">$30</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Strawberry Latte</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Ice Matcha</span>
                        <span class="item-price">$55</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Ice Chocolate</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Afogato</span>
                        <span class="item-price">$40</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Ice Taro Latte</span>
                        <span class="item-price">$55</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Vaso Leche Deslactosada</span>
                        <span class="item-price">$25</span>
                    </div>
                </div>
            </div>

            <!-- Pan Dulce -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Pan Dulce
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Croissant Elote</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Croissant Maracuyá</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Croissant Pistache</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Croissant Piñón</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Croissant Almendra</span>
                        <span class="item-price">$35</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Carteritas Avellana</span>
                        <span class="item-price">$35</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuarta Columna -->
        <div class="menu-column">
            <!-- Barritas -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Barritas
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Barrita Energía</span>
                        <span class="item-price">$25</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Barrita Premium</span>
                        <span class="item-price">$35</span>
                    </div>
                </div>
            </div>

            <!-- Refrescos -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Refrescos
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Fanta</span>
                        <span class="item-price">$23</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Coca Cola</span>
                        <span class="item-price">$23</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Coca Zero</span>
                        <span class="item-price">$23</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Botella de Agua</span>
                        <span class="item-price">$25</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Agua Mineral Ciel</span>
                        <span class="item-price">$23</span>
                    </div>
                </div>
            </div>

            <!-- Jugos -->
            <div class="menu-section">
                <h2 class="section-title" onclick="toggleSection(this)">
                    Jugos
                </h2>
                <div class="menu-items">
                    <div class="menu-item">
                        <span class="item-name">Jugo Verde</span>
                        <span class="item-price">$40</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Jugo de Zanahoria</span>
                        <span class="item-price">$40</span>
                    </div>
                    <div class="menu-item">
                        <span class="item-name">Jugo de Naranja</span>
                        <span class="item-price">$45</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="contact-info">
            <a href="http://www.casa-toho.com" class="website">www.casa-toho.com</a> | 775-784-2023 | Calle Lázaro Cárdenas #206, Col. Benito Juárez, Tulancingo
        </div>
    </div>

    <script>
        function toggleSection(titleElement) {
            const menuItems = titleElement.nextElementSibling;
            const isCollapsed = menuItems.classList.contains('collapsed');
            
            if (isCollapsed) {
                // Expandir
                menuItems.classList.remove('collapsed');
                titleElement.classList.remove('collapsed');
            } else {
                // Colapsar
                menuItems.classList.add('collapsed');
                titleElement.classList.add('collapsed');
            }
        }

        let allExpanded = true;
        
        function toggleAllSections() {
            const allSections = document.querySelectorAll('.menu-items');
            const allTitles = document.querySelectorAll('.section-title');
            
            if (allExpanded) {
                // Colapsar todo
                allSections.forEach(section => section.classList.add('collapsed'));
                allTitles.forEach(title => title.classList.add('collapsed'));
                allExpanded = false;
            } else {
                // Expandir todo
                allSections.forEach(section => section.classList.remove('collapsed'));
                allTitles.forEach(title => title.classList.remove('collapsed'));
                allExpanded = true;
            }
        }

        // Inicializar algunas secciones colapsadas para demostrar la funcionalidad
        document.addEventListener('DOMContentLoaded', function() {
            // En móvil, colapsar más secciones para que quepa todo
            const isMobile = window.innerWidth <= 767;
            
            let sectionsToCollapse;
            if (isMobile) {
                // En móvil, mostrar solo las secciones más importantes expandidas
                sectionsToCollapse = [
                    'Cafés Fríos', 'Bebidas Calientes', 'Malteadas', 'Frappés', 
                    'Bebidas Frías', 'Pan Dulce', 'Barritas', 'Refrescos', 'Jugos'
                ];
            } else {
                // En desktop, colapsar menos secciones
                sectionsToCollapse = [
                    'Malteadas', 'Frappés', 'Barritas', 'Refrescos'
                ];
            }
            
            sectionsToCollapse.forEach(sectionName => {
                const titleElement = Array.from(document.querySelectorAll('.section-title'))
                    .find(title => title.textContent.trim() === sectionName);
                if (titleElement) {
                    toggleSection(titleElement);
                }
            });
            
            allExpanded = false;
        });
    </script>
</body>
</html>
