<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="icon" type="image/png" href="./../../public/images/logo/isotipo.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descubre Casa T'ÖHÖ / Casa Toho: un espacio donde la tradición y la modernidad se fusionan para ofrecer experiencias únicas. Diseño auténtico, esencia cultural y hospitalidad excepcional en cada detalle. ¡Visítanos y vive la diferencia!">
    <meta name="keywords" content="Casa T'ÖHÖ, Casa Toho, Casa TOHO, identidad cultural, tradición, modernidad, diseño auténtico, hospitalidad, experiencias únicas">
    <meta name="author" content="Casa T'ÖHÖ">
    <meta property="og:title" content="Casa T'ÖHÖ - Tradición y Modernidad en Armonía">
    <meta property="og:description" content="Vive la esencia de Casa T'ÖHÖ, donde el diseño auténtico y la hospitalidad se encuentran.">
  
  <link rel="stylesheet" href="./../../app/css/styles.css?v=2.2">
  <title>Casa T'öhö - Fluye en equilibrio</title>
  <style>
  </style>
</head>
<body>
  
<!-- 1. MODIFICAR EL HEADER (reemplazar el header existente) -->
<header id="header">
  <div class="container nav-container">
    <a href="#" class="logo" id="mobile-logo-btn">
      <img src="./../../public/images/logo/isotipo.png" class="logo-icon" viewBox="0 0 100 100"/>
      <span class="logo-text">CASA T'ÖHÖ</span>
    </a>
    <a href="/menu" class="mobile-menu-btn">Menú</a>
    <nav class="desktop-nav">
      <ul>
        <li><a href="#home">Inicio</a></li>
        <li><a href="#espacios">Espacios</a></li>
        <li><a href="#about">Nosotros</a></li>
        <li><a href="#valores">Valores</a></li>
        <li><a href="#contacto">Contacto</a></li>
        <li><a href="menu" class="menu-btn-nav">Menú</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- Menú lateral móvil -->
<div class="mobile-menu" id="mobile-menu">
  <div class="mobile-menu-header">
    <span class="mobile-logo">CASA T'ÖHÖ</span>
    <button class="mobile-close-btn" id="mobile-close-btn">&times;</button>
  </div>
  <ul class="mobile-menu-nav">
    <li><a href="#home" class="mobile-menu-item">Inicio</a></li>
    <li><a href="#espacios" class="mobile-menu-item">Espacios</a></li>
    <li><a href="#about" class="mobile-menu-item">Nosotros</a></li>
    <li><a href="#valores" class="mobile-menu-item">Valores</a></li>
    <li><a href="#contacto" class="mobile-menu-item">Contacto</a></li>
    <li><a href="/menu" class="mobile-menu-item">Menú</a></li>
  </ul>
</div>

<!-- 3. AGREGAR DESPUÉS DEL MENÚ MÓVIL (elemento completamente nuevo) -->
<!-- Overlay para cerrar menú -->
<div class="mobile-overlay" id="mobile-overlay"></div>
  <section id="home" class="hero">
    <div class="mountain-decoration">
      <div class="mountain mountain-1"></div>
      <div class="mountain mountain-2"></div>
      <div class="mountain mountain-3"></div>
      <div class="mountain mountain-4"></div>
      <div class="mountain mountain-5"></div>
    </div>
    <div class="hero-content">
      <h1>CASA T'ÖHÖ</h1>
      <p class="slogan">Fluye en equilibrio</p>
      <p>Un espacio que celebra nuestras raíces otomíes y honra la conexión con la naturaleza, ofreciendo una experiencia única donde lo antiguo y lo moderno convergen.</p>
      <div>
        <a href="#espacios" class="btn">Descubre nuestros espacios</a>
        <a href="#contacto" class="btn">Contáctanos</a>
      </div>
    </div>
  </section>

  <section id="espacios" class="espacios">
    <div class="container">
      <div class="section-title">
        <h2>Nuestros Espacios</h2>
        <p>Áreas diseñadas para ofrecer experiencias únicas que conectan tradición y modernidad</p>
      </div>
      <div class="espacios-container">
        <div class="espacio-card">
          <img src="./../../public/images/resources/Xánthe.webp" alt="Xánthe - Área lúdica" class="espacio-img">
          <div class="espacio-content">
            <h3 class="espacio-title">Xánthe (Bosque)</h3>
            <p class="espacio-description">Área lúdica donde la diversión y el entretenimiento se fusionan en un ambiente natural y acogedor.<br>&nbsp;</p>
          </div>
        </div>
        <div class="espacio-card">
          <img src="./../../public/images/resources/Póthe.webp" alt="Póthe - Barra de café" class="espacio-img">
          <div class="espacio-content">
            <h3 class="espacio-title">Póthe (Manantial)</h3>
            <p class="espacio-description">Nuestra barra de café, donde cada taza es una celebración de aromas y sabores.<br>&nbsp;</p>
          </div>
        </div>
        <div class="espacio-card">
          <img src="./../../public/images/resources/Xui.webp" alt="Xui / Tso - Vinos y Mixología" class="espacio-img">
          <div class="espacio-content">
            <h3 class="espacio-title">Xui / Tso (Noche/estrella)</h3>
            <p class="espacio-description">Vinos y mixología selecta para iluminar tus sentidos bajo un ambiente elegante y sofisticado.<br>&nbsp;</p>
          </div>
        </div>
        <div class="espacio-card">
          <img src="./../../public/images/resources/Xiza.webp" alt="Xiza - Salón Multifuncional" class="espacio-img">
          <div class="espacio-content">
            <h3 class="espacio-title">Xiza (Encino)</h3>
            <p class="espacio-description">Salón multifuncional adaptable a distintos eventos, tan versátil y resistente como el encino mismo.<br>&nbsp;</p>
          </div>
        </div>
        <div class="espacio-card">
          <img src="./../../public/images/resources/Túmú.webp" alt="Túmú - Cosmetología" class="espacio-img">
          <div class="espacio-content">
            <h3 class="espacio-title">Túmú (Mariposa)</h3>
            <p class="espacio-description">Área de cosmetología donde experimentarás una transformación tan bella como el vuelo de una mariposa.</p>
          </div>
        </div>
        <div class="espacio-card">
          <img src="./../../public/images/resources/Záná.webp" alt="Záná - Estudio de relajación" class="espacio-img">
          <div class="espacio-content">
            <h3 class="espacio-title">Záná (Luna)</h3>
            <p class="espacio-description">Estudio de relajación que te guiará hacia la paz interior y la armonía, como la serena luz lunar.<br>&nbsp;</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="about">

    <div class="container about-container">
      <img src="./../../public/images/resources/Sobre.webp" alt="Sobre Casa T'öhö" class="about-img">
      <div class="about-content">
        <h2>Nuestra Historia</h2>
        <p>Casa T'öhö nace como un homenaje a las raíces otomíes y a la profunda conexión con la naturaleza que caracteriza a esta cultura ancestral. Inspirados en la montaña, símbolo de fortaleza y espiritualidad, hemos creado un espacio donde lo antiguo y lo moderno convergen en perfecta armonía.</p>
        <p>Cada rincón de Casa T'öhö ha sido cuidadosamente diseñado para ofrecer una experiencia integral que celebra nuestro patrimonio cultural mientras brinda servicios contemporáneos de la más alta calidad, desde gastronomía y bienestar hasta cultura y recreación.</p>

      </div>
    </div>
  </section>

  <section id="valores" class="valores">
    <div class="container">
      <div class="section-title">
        <h2>Nuestros Valores</h2>
        <p>Los pilares que sostienen nuestra filosofía y guían nuestras acciones</p>
      </div>
      <div class="valores-container">
        <div class="valor-card">
          <img src="./../../public/images/resources/Autenticidad.webp" alt="Ícono Autenticidad" class="valor-icon-img filtro-dorado">
          <h3 class="valor-title">Autenticidad</h3>
          <p>Celebramos nuestras raíces mexicanas, reflejando su riqueza cultural en cada detalle.</p>
        </div>
        <div class="valor-card">
          <img src="./../../public/images/resources/Sostenibilidad.webp" alt="Ícono Sostenibilidad" class="valor-icon-img filtro-dorado">
          <h3 class="valor-title">Sostenibilidad</h3>
          <p>Actuamos con respeto hacia la naturaleza, integrando prácticas responsables en todas nuestras operaciones.</p>
        </div>
        <div class="valor-card">
          <img src="./../../public/images/resources/Inclusion.webp" alt="Ícono Inclusión" class="valor-icon-img filtro-dorado">
          <h3 class="valor-title">Inclusión</h3>
          <p>Valoramos y respetamos la diversidad, creando un espacio donde todos se sientan bienvenidos.</p>
        </div>
        <div class="valor-card">
          <img src="./../../public/images/resources/Excelencia.webp" alt="Ícono Excelencia" class="valor-icon-img filtro-dorado">
          <h3 class="valor-title">Excelencia</h3>
          <p>Nos comprometemos a ofrecer servicios de la más alta calidad para superar las expectativas de nuestros visitantes.</p>
        </div>
      </div>
    </div>
  </section>


  <section id="contacto" class="contacto">
    <div class="container">
      <div class="section-title">
        <h2>Contáctanos</h2>
        <p>Estamos aquí para atenderte a través de nuestros canales digitales</p>
      </div>
      <div class="contacto-container">
        <div class="contacto-info">
          <h3>Información de Contacto</h3>
          <div class="contacto-detalles">
          <div class="contacto-item">
            <img src="./../../public/images/resources/Dirección.webp" alt="Dirección" class="contacto-icon-img filtro-dorado">
                        <a href="https://maps.app.goo.gl/Dq5V9UYTokyLq38E6" target="_blank">
              <p>Calle Gral Lázaro Cárdenas 206, C. Benito Juarez, 43670 Tulancingo, Hgo.</p>
            </a>
          </div>
          <div class="contacto-item">
            <img src="./../../public/images/resources/Teléfono.webp" alt="Teléfono" class="contacto-icon-img filtro-dorado">
            <a href="https://wa.me/5217757842023" target="_blank">
              <p>+52 775 784 2023</p>
            </a>
          </div>
          <div class="contacto-item">
            <img src="./../../public/images/resources/Correo.webp" alt="Correo" class="contacto-icon-img filtro-dorado">
            <a href="mailto:administracion@casa-toho.com">
              <p>administracion@casa-toho.com</p>
            </a>

          </div>
          <div class="contacto-item">
            <img src="./../../public/images/resources/Horario.webp" alt="Horario" class="contacto-icon-img filtro-dorado">
            <p>Lunes a Domingo: 7:00 AM - 11:30 PM</p>
            
          </div>

          </div>
        </div>
        
        <div class="contacto-social">
          <h3>Nuestras Redes Sociales</h3>
          <p>La manera más rápida de contactarnos es a través de nuestras redes:</p>
          
          <div class="social-links">
            <a href="https://www.facebook.com/profile.php?id=61573699391820" target="_blank"><img src="./../../public/images/social-icons/facebook.png" alt="Facebook"/></a>
            <a href="https://www.instagram.com/casa.toho01" target="_blank"><img src="./../../public/images/social-icons/instagram.png" alt="Instagram"/></a>
            <a href="https://maps.app.goo.gl/Dq5V9UYTokyLq38E6" target="_blank"><img src="./../../public/images/resources/Dirección.webp" alt="Ubicación"/></a>
          </div>

          <div class="whatsapp-contact">
            <a href="https://wa.me/5217757842023" class="btn whatsapp-btn" target="_blank">
              Escríbenos por WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <a href="#" class="footer-logo">CASA T'ÖHÖ</a>
      <nav class="footer-nav">
        <ul>
          <li><a href="#home">Inicio</a></li>
          <li><a href="#espacios">Espacios</a></li>
          <li><a href="#about">Nosotros</a></li>
          <li><a href="#valores">Valores</a></li>
          <li><a href="#contacto">Contacto</a></li>
        </ul>
      </nav>

      <div class="footer-bottom">
        <p>&copy; 2025 Casa T'öhö. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>

  <script>
// Simple sticky header
window.addEventListener('scroll', function() {
  const header = document.getElementById('header');
  if (window.scrollY > 100) {
    header.classList.add('header-scrolled');
  } else {
    header.classList.remove('header-scrolled');
  }
});

// Menú móvil functionality
const mobileLogoBtn = document.getElementById('mobile-logo-btn');
const mobileMenu = document.getElementById('mobile-menu');
const mobileOverlay = document.getElementById('mobile-overlay');
const mobileCloseBtn = document.getElementById('mobile-close-btn');
const mobileMenuItems = document.querySelectorAll('.mobile-menu-item');

// Función para abrir menú
function openMobileMenu() {
  mobileMenu.classList.add('active');
  mobileOverlay.classList.add('active');
  document.body.style.overflow = 'hidden'; // Prevenir scroll del body
}

// Función para cerrar menú
function closeMobileMenu() {
  mobileMenu.classList.remove('active');
  mobileOverlay.classList.remove('active');
  document.body.style.overflow = ''; // Restaurar scroll del body
}

// Event listeners para abrir menú
// Solo el logo abre el menú en móvil

// En móvil, hacer que el logo abra el menú
mobileLogoBtn.addEventListener('click', function(e) {
  if (window.innerWidth <= 768) {
    e.preventDefault();
    openMobileMenu();
  }
});

// Event listeners para cerrar menú
mobileCloseBtn.addEventListener('click', closeMobileMenu);
mobileOverlay.addEventListener('click', closeMobileMenu);

// Cerrar menú al hacer clic en un item
mobileMenuItems.forEach(item => {
  item.addEventListener('click', closeMobileMenu);
});

// Cerrar menú con tecla Escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
    closeMobileMenu();
  }
});

// Ajustar comportamiento según tamaño de pantalla
window.addEventListener('resize', function() {
  if (window.innerWidth > 768) {
    closeMobileMenu();
  }
});




</script>
</body>
</html>
