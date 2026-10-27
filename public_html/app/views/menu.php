<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="description" content="Menú de Casa T'ÖHÖ, Tulancingo: desayuno, comida y bebidas.">
<meta name="theme-color" content="#000000">
<link rel="icon" type="image/png" href="/public/images/logo/isotipo.ico">
<title>Menú · Casa T'öhö</title>
<style>
:root{--dorado:#d8a54a;--negro:#000;--blanco:#fff;--panel:rgba(255,255,255,.03);--linea:rgba(255,255,255,.12);--gris:rgba(255,255,255,.62);color-scheme:dark}
@font-face{font-family:'Thurkle';src:url('/public/fonts/Thurkle.ttf') format('truetype');font-display:swap}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
html{scroll-behavior:smooth;scroll-padding-top:150px}
body{background:var(--negro);color:var(--blanco);line-height:1.6}
.container{width:90%;max-width:1000px;margin:0 auto}
a{color:inherit}

/* Header: el mismo de la página principal (sin el botón "Menú") */
header{padding:20px 0;position:absolute;width:100%;top:0;z-index:100}
.nav-container{display:flex;justify-content:space-between;align-items:center}
.logo{font-family:'Thurkle',sans-serif;font-size:2rem;color:var(--dorado);text-decoration:none;display:flex;align-items:center}
.logo-icon{width:40px;height:40px;margin-right:10px}
.desktop-nav ul{display:flex;list-style:none}
.desktop-nav ul li{margin-left:30px}
.desktop-nav ul li a{color:var(--blanco);text-decoration:none;font-size:1rem;transition:color .3s;text-transform:uppercase;letter-spacing:1px;font-weight:300}
.desktop-nav ul li a:hover{color:var(--dorado)}
nav a{text-decoration:none;font-size:1rem;text-transform:uppercase;letter-spacing:1px;font-weight:300;transition:color .3s}
nav a:hover,nav a.on{color:var(--dorado)}

/* Botón "Inicio" (solo móvil, en el lugar del botón Menú del header original) */
.mobile-menu-btn{display:none}
@keyframes pulse-glow{
  0%{box-shadow:0 0 5px var(--dorado);background-color:var(--dorado)}
  50%{box-shadow:0 0 10px var(--dorado),0 0 15px rgba(216,165,74,.6);background-color:#e6b84d}
  100%{box-shadow:0 0 5px var(--dorado);background-color:var(--dorado)}
}

/* Menú lateral móvil (igual al de la página principal) */
.mobile-menu{position:fixed;top:0;left:-300px;width:300px;height:100vh;background-color:var(--negro);border-right:2px solid var(--dorado);transition:left .3s ease;z-index:1000;padding:20px}
.mobile-menu.active{left:0}
.mobile-menu-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;padding-bottom:20px;border-bottom:1px solid var(--dorado)}
.mobile-logo{font-family:'Thurkle',sans-serif;font-size:1.5rem;color:var(--dorado)}
.mobile-close-btn{background:none;border:none;color:var(--blanco);font-size:2rem;cursor:pointer;padding:0;line-height:1}
.mobile-menu-nav{list-style:none;padding:0;margin:0}
.mobile-menu-nav li{margin-bottom:20px}
.mobile-menu-nav a{color:var(--blanco);text-decoration:none;font-size:1.1rem;text-transform:uppercase;letter-spacing:1px;padding:15px 10px;display:block;transition:all .3s;border-left:3px solid transparent}
.mobile-menu-nav a:hover{color:var(--dorado);border-left-color:var(--dorado);padding-left:20px;background-color:rgba(216,165,74,.1)}
.mobile-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.7);z-index:999;opacity:0;visibility:hidden;transition:all .3s ease}
.mobile-overlay.active{opacity:1;visibility:visible}

/* Hero */
.hero{text-align:center;padding:130px 20px 50px;background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.85)),url('/public/images/resources/hero.webp') center/cover}
.hero h1{font-family:'Thurkle',sans-serif;font-size:3.5rem;color:var(--dorado);line-height:1.1}
.slogan{font-style:italic;font-size:1.4rem;color:var(--dorado);margin:10px 0 28px}
.btn{display:inline-block;padding:12px 30px;border:2px solid var(--dorado);color:var(--dorado);text-decoration:none;font-weight:600;letter-spacing:1px;transition:all .3s;margin:6px;background:none;cursor:pointer;font-size:1rem}
.btn:hover,.btn:focus-visible{background:var(--dorado);color:var(--negro);outline:none}

/* Barra fija: buscador, cartas y categorías */
.barra{position:sticky;top:0;z-index:50;background:rgba(0,0,0,.95);backdrop-filter:blur(6px);border-bottom:1px solid var(--linea);padding-top:env(safe-area-inset-top,0px)}
.buscador{position:relative;margin-top:12px}
.buscador input{width:100%;padding:13px 44px 13px 18px;background:rgba(255,255,255,.1);border:none;border-radius:5px;color:var(--blanco);font-size:16px;-webkit-appearance:none;appearance:none}
.buscador input::placeholder{color:rgba(255,255,255,.5)}
.buscador input:focus{outline:2px solid var(--dorado)}
.buscador input::-webkit-search-cancel-button{display:none}
.buscador button{position:absolute;right:6px;top:50%;transform:translateY(-50%);width:34px;height:34px;border:none;background:none;color:var(--gris);font-size:24px;cursor:pointer}
.tabs{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;padding-top:12px}
.tabs button{font-family:'Thurkle',sans-serif;font-size:1.25rem;color:var(--blanco);background:none;border:2px solid var(--linea);padding:8px 4px;cursor:pointer;transition:all .3s}
.tabs button:hover{border-color:var(--dorado);color:var(--dorado)}
.tabs button[aria-selected="true"]{background:var(--dorado);border-color:var(--dorado);color:var(--negro)}
.cats{display:flex;gap:8px;overflow-x:auto;padding:12px 0;scrollbar-width:none}
.cats::-webkit-scrollbar{display:none}
.cats a{flex:none;padding:6px 14px;border:1px solid var(--linea);border-radius:20px;color:var(--gris);text-decoration:none;font-size:.9rem;white-space:nowrap;transition:all .3s}
.cats a:hover{color:var(--dorado);border-color:var(--dorado)}
.cats a.activo{background:var(--dorado);border-color:var(--dorado);color:var(--negro);font-weight:600}
.barra.buscando .tabs,.barra.buscando .cats{display:none}
.barra.buscando{padding-bottom:12px}

/* Destacado */
.destacado{margin:40px 0 0;padding:24px 28px;border:2px solid var(--dorado);border-radius:5px;background:var(--panel)}
.destacado small{color:var(--gris);font-size:.9rem}
.destacado h3{font-family:'Thurkle',sans-serif;font-size:1.8rem;color:var(--dorado);display:flex;justify-content:space-between;gap:12px;font-weight:normal}
.destacado p{margin-top:4px}

/* Secciones */
section{padding:56px 0 0}
.section-title{text-align:center;margin-bottom:36px;position:relative;padding-bottom:6px}
.section-title h2{font-family:'Thurkle',sans-serif;font-size:2.2rem;color:var(--dorado);font-weight:normal}
.section-title::after{content:'';position:absolute;width:100px;height:3px;background:var(--dorado);bottom:-12px;left:50%;transform:translateX(-50%)}
.section-title p{color:var(--gris);font-style:italic;font-size:.95rem;margin-top:4px}
.items{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px}
.item{padding:22px 24px;background:var(--panel);border-radius:5px;transition:transform .3s}
.item:hover{transform:translateY(-4px)}
.fila{display:flex;align-items:baseline;gap:10px}
.nombre{font-weight:600;font-size:1.1rem}
.puntos{flex:1;border-bottom:1px dotted var(--linea);min-width:12px;transform:translateY(-4px)}
.precio{color:var(--dorado);font-weight:700;font-size:1.15rem;white-space:nowrap}
.precio.pend{font-size:.9rem;font-style:italic;font-weight:400}
.desc{color:var(--gris);font-size:.95rem;margin-top:6px}
.extra{margin-top:10px;display:flex;flex-wrap:wrap;gap:6px 18px;font-size:.9rem;color:var(--gris)}
.extra b{color:var(--dorado)}
.res-carta{color:var(--dorado);font-size:.85rem;margin-bottom:4px}
.sin-res{text-align:center;padding:50px 0;color:var(--gris)}

/* Footer */
footer{margin-top:80px;padding:50px 0 30px;text-align:center;background:rgba(0,0,0,.8);border-top:1px solid var(--linea)}
.footer-logo{font-family:'Thurkle',sans-serif;font-size:2rem;color:var(--dorado);text-decoration:none;display:inline-block;margin-bottom:20px}
.avisos{max-width:620px;margin:0 auto 24px;text-align:left;display:grid;gap:8px;font-size:.9rem;color:var(--gris)}
.avisos p::before{content:"· ";color:var(--dorado)}
.dato{margin-top:6px}
.dato a{color:var(--dorado);text-decoration:none}
.footer-bottom{margin-top:30px;padding-top:20px;border-top:1px solid var(--linea);font-size:.8rem;color:rgba(255,255,255,.5)}

@media(max-width:768px){
  .desktop-nav{display:none}
  .logo-text{display:none}
  .logo{cursor:pointer}
  .hero{padding:110px 20px 36px}.hero h1{font-size:2.6rem}
  .section-title h2{font-size:1.8rem}
  section{padding-top:44px}
  .items{grid-template-columns:1fr}
  .tabs button{font-size:1.05rem}
}
@media(max-width:768px){.mobile-menu-btn{display:block;background-color:var(--dorado);color:var(--negro);padding:8px 16px;border-radius:20px;font-weight:bold;text-decoration:none;font-size:.9rem;border:2px solid transparent;animation:pulse-glow 1.5s infinite ease-in-out}}
@media(min-width:769px){.mobile-menu,.mobile-overlay{display:none!important}}
@media(prefers-reduced-motion:reduce){*{transition:none!important;scroll-behavior:auto!important;animation:none!important}}
</style>
</head>
<body>

<header>
  <div class="container nav-container" style="max-width:1200px">
    <a href="/" class="logo" id="mobile-logo-btn">
      <img src="/public/images/logo/isotipo.png" class="logo-icon" alt="">
      <span class="logo-text">CASA T'ÖHÖ</span>
    </a>
    <a href="/" class="mobile-menu-btn">Inicio</a>
    <nav class="desktop-nav" aria-label="Principal">
      <ul>
        <li><a href="/#home">Inicio</a></li>
        <li><a href="/#espacios">Espacios</a></li>
        <li><a href="/#about">Nosotros</a></li>
        <li><a href="/#valores">Valores</a></li>
        <li><a href="/#contacto">Contacto</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- Menú lateral móvil (se abre tocando el logo) -->
<div class="mobile-menu" id="mobile-menu">
  <div class="mobile-menu-header">
    <span class="mobile-logo">CASA T'ÖHÖ</span>
    <button class="mobile-close-btn" id="mobile-close-btn" aria-label="Cerrar menú">&times;</button>
  </div>
  <ul class="mobile-menu-nav">
    <li><a href="/#home" class="mobile-menu-item">Inicio</a></li>
    <li><a href="/#espacios" class="mobile-menu-item">Espacios</a></li>
    <li><a href="/#about" class="mobile-menu-item">Nosotros</a></li>
    <li><a href="/#valores" class="mobile-menu-item">Valores</a></li>
    <li><a href="/#contacto" class="mobile-menu-item">Contacto</a></li>
  </ul>
</div>
<div class="mobile-overlay" id="mobile-overlay"></div>

<section class="hero" style="padding-bottom:50px">
  <h1>Nuestro Menú</h1>
  <p class="slogan">Sabores con raíz, en el corazón de Tulancingo</p>
  <a class="btn" href="https://wa.me/5217757842023" target="_blank" rel="noopener">Reservar</a>
  <a class="btn" href="https://search.google.com/local/writereview?placeid=ChIJDchTuK9X0IURr359exMcHrM" target="_blank" rel="noopener">Déjanos tu reseña</a>
</section>

<div class="barra">
  <div class="container">
    <div class="buscador">
      <input type="search" id="buscar" placeholder="Busca un platillo o bebida" aria-label="Buscar en el menú" autocomplete="off">
      <button type="button" id="limpiar" aria-label="Borrar búsqueda" hidden>×</button>
    </div>
    <div class="tabs" role="tablist" id="tabs"></div>
    <nav class="cats" id="cats" aria-label="Categorías del menú"></nav>
  </div>
</div>

<main class="container" id="cartas"></main>

<footer>
  <div class="container">
    <a href="/" class="footer-logo">CASA T'ÖHÖ</a>
    <div class="avisos">
      <p>Apoyando el consumo local, usamos huevo criollo de gallina libre, frijol cacahuate, queso de tenate, nata de rancho, quesos de PROUNILAC (UAEH), y frutas, verduras, hojas y legumbres de la región.</p>
      <p>Pregunta por nuestra variedad de vinos y licores.</p>
      <p>Venta de bebidas alcohólicas solo a mayores de edad.</p>
      <p>Las bebidas alcohólicas se sirven únicamente en compañía de alimentos.</p>
      <p>En Casa Töhö respetamos a las familias que nos visitan, por lo que no permitimos visitas en evidente estado de ebriedad.</p>
    </div>
    <p class="dato">Lunes a domingo · 7:00 am a 11:30 pm</p>
    <p class="dato">Reservaciones <a href="https://wa.me/5217757842023" target="_blank" rel="noopener">775 784 2023</a></p>
    <p class="dato">Calle Gral. Lázaro Cárdenas #206, Col. Benito Juárez, Tulancingo, Hgo.</p>
    <div class="footer-bottom">&copy; 2025 Casa T'öhö. Todos los derechos reservados.</div>
  </div>
</footer>

<script>
/* ===== PARA ACTUALIZAR EL MENÚ, EDITA SOLO ESTA LISTA =====
   n: nombre · d: descripción · p: precio (null = "Consultar") · x: opciones extra [["Con huevo",120]] */
const FRIO="Haz cualquier bebida fría o frappé por $10 más.";
const CARTAS=[
{id:"desayuno",titulo:"Desayuno",
 destacado:{etiqueta:"Combo de desayuno",titulo:"Hazlo combo",precio:"+$60",texto:"Agrega $60 a tu plato fuerte y llévate un plato de fruta pequeño o jugo, y un café del día."},
 secciones:[
 {id:"comenzar",titulo:"Para comenzar",items:[
  {n:"Bowl de frutas",d:"Melón, piña, frutos rojos, miel, yogurt y granola.",p:95},
  {n:"Toast de frutos rojos",d:"Hogaza de masa madre, nata, frutos rojos, miel de abeja y granola.",p:125},
  {n:"Chía pudding",d:"Pudín de chía, frutos rojos, maple y granola.",p:125}]},
 {id:"primeros",titulo:"Primeros platos",items:[
  {n:"Sopes",d:"3 piezas con salsa de tu elección, queso tenate, cebolla y cilantro.",p:68,x:[["Huevo o pollo",105],["Chorizo",120],["Arrachera",125]]},
  {n:"Huevos al gusto",d:"Dos huevos a elegir: mexicana, rancheros, jamón, tocino o chorizo. Con frijoles refritos y ensalada de hojas de temporada.",p:90},
  {n:"Chilaquiles",d:"Totopos hechos en casa, con la salsa de tu elección, queso, crema, cebolla y cilantro.",p:85,x:[["Con huevo o pollo",110],["Con arrachera",130]]},
  {n:"Enchiladas",d:"Rellenas de pollo, bañadas con la salsa de tu elección, queso, crema, cebolla y cilantro.",p:110},
  {n:"Enchiladas suizas",d:"Rellenas de pollo, con salsa verde, gratinadas con queso gouda, crema, queso, cebolla y cilantro.",p:130},
  {n:"Enmoladas",d:"Rellenas de pollo, bañadas con nuestro mole especial, crema, queso, cebolla y cilantro.",p:130},
  {n:"Enfrijoladas",d:"Rellenas de pollo, con salsa cremosa de frijol, crema, queso, cebolla, cilantro y chorizo.",p:105},
  {n:"Omelette",d:"Jamón con queso gouda, acompañado de ensalada de hojas de temporada.",p:110},
  {n:"Omelette ligero",d:"Aguacate, hongos y queso panela, acompañado de hojas de temporada.",p:110},
  {n:"Molletes",d:"Pan de vapor, frijoles cremosos, chorizo, queso tenate, pico de gallo y hojas de temporada.",p:120},
  {n:"Toast de aguacate",d:"Hummus de alverjón, aguacate, ensalada de hojas de temporada y queso tenate.",p:100,x:[["Con huevo",120],["Con salmón",150]]}]},
 {id:"dulce",titulo:"La parte dulce",items:[
  {n:"Waffles belgas",d:"Mantequilla, miel maple y compota de frutos rojos.",p:120,x:[["Con tocino",150]]},
  {n:"Pan francés",d:"Pan brioche bañado en nuestra salsa secreta, con helado de vainilla y preparado de frutos rojos.",p:120},
  {n:"Hot cakes",d:"Esponjosos, coronados con frutos rojos y lechera.",p:80}]},
 {id:"inf-desayuno",titulo:"Infantil",items:[
  {n:"Pequeño gran desayuno",d:"Medio waffle belga de mantequilla, miel maple, frutos rojos, tira de tocino y 1 huevo estrellado o revuelto.",p:120}]},
 {id:"bagels-d",titulo:"Bagel sándwich · todo el día",ref:"bagels"}]},

{id:"comida",titulo:"Comida",
 destacado:{etiqueta:"Lunes a viernes · 1:00 a 4:00 pm",titulo:"Menú ejecutivo",precio:"$98",texto:"Sopa del día, ensalada, plato fuerte del día y vaso de agua de temporada."},
 secciones:[
 {id:"entradas",titulo:"Entradas",items:[
  {n:"Guacamole Töhö",p:120,x:[["Con chapulines (de temporada)",160]]},
  {n:"Toast de hongos",d:"Con hojas de temporada y hummus de alverjón.",p:110},
  {n:"Queso tenate asado",d:"Con sofrito de pimientos y tortilla para acompañar.",p:160},
  {n:"Tabla de quesos regionales",d:"Acompañados de frutos, ate de guayaba, miel y pan hogaza tostado.",p:350}]},
 {id:"ensaladas",titulo:"Ensaladas",items:[
  {n:"Ensalada de betabel",d:"Betabel rostizado, nata, supremas de naranja, zarzamora y aderezo de pasas.",p:120},
  {n:"Ensalada verde",d:"Hojas de temporada, manzana verde, aguacate, pera, pistache garapiñado y vinagreta de miel con cítricos.",p:160},
  {n:"Ensalada de frutos rojos",d:"Mix de hojas, frambuesa, zarzamora, fresa, ate de guayaba, queso tenate y balsámico.",p:140}]},
 {id:"sopas",titulo:"Sopas, pastas y arroces",items:[
  {n:"Sopa del día",d:"Déjate sorprender por nuestra cocina.",p:80},
  {n:"Sopa de tortilla",d:"La clásica con un toque de casa.",p:100},
  {n:"Pasta Töhö",d:"Fettuccine con hongos y crema de flor de calabaza.",p:140},
  {n:"Pasta con camarones",d:"Fettuccine en crema de chipotle y finas hierbas.",p:180},
  {n:"Risotto de hongos",d:"Arroz cocinado en caldo de verduras, con hongos y setas regionales y un toque de queso tenate rallado.",p:140},
  {n:"Fettuccine Alfredo",d:"Salsa Alfredo con tocino.",p:130}]},
 {id:"tacos",titulo:"Tacos",items:[
  {n:"Tacos de camarón estilo Baja",d:"3 piezas, rebozados, con ensalada de col.",p:220},
  {n:"Tacos de arrachera",d:"3 piezas, acompañados de guacamole y salsa.",p:220}]},
 {id:"fuertes",titulo:"Platos fuertes",items:[
  {n:"Pechuga de pollo",d:"Con salsa cassoulet de hongos.",p:190},
  {n:"Milanesa de pollo",d:"Con ensalada de hojas de temporada.",p:140},
  {n:"Rib eye prime sonorense",d:"Con papas fritas.",p:340},
  {n:"Arrachera prime sonorense",d:"Con papas fritas.",p:240},
  {n:"Hamburguesa de arrachera",d:"150 g de arrachera con guacamole y papas fritas.",p:190},
  {n:"Hamburguesa Töhö",d:"Bollo brioche, molida especial prime 70/30, hojas de temporada, mayonesa, queso tenate, cebolla morada y jitomate bola. Servida con papas fritas.",p:210},
  {n:"Dogo Töhö",d:"Medianoche brioche, chorizo argentino, mayonesa y chimichurri. Servido con papas fritas.",p:160},
  {n:"Salmón con sofrito de pimientos",d:"Sofrito de pimiento, ajo frito, hojas de temporada y limón asado.",p:240},
  {n:"Pulpo zarandeado",d:"Bañado en salsa de chipotle, acompañado de ensalada.",p:220},
  {n:"Toast de aguacate",d:"Hummus de alverjón, aguacate, ensalada de hojas de temporada y queso tenate.",p:100,x:[["Con salmón o arrachera",180]]},
  {n:"Tuétanos de res",d:"Sobre una cama de esquites con chapulín.",p:195}]},
 {id:"pizza",titulo:"Pizza",nota:"Masa madre elaborada en casa y salsa pomodoro artesanal al vino tinto. Te sugerimos acompañarla con una ensalada y vino tinto. Pide peperoncino o vinagre balsámico.",items:[
  {n:"Pizza Margarita",d:"Queso mozzarella, jitomate bola y albahaca.",p:190},
  {n:"Pizza pepperoni",d:"Queso mozzarella y pepperoni.",p:185},
  {n:"Pizza Töhö",d:"Hongos, flor de calabaza, elote, cebolla morada y pimiento morrón. Los ingredientes pueden cambiar por temporada.",p:260},
  {n:"Pizza 4 estaciones",d:"Dividida en 4: jamón de pavo, hongos, jamón serrano y hojas de temporada.",p:260},
  {n:"Pizza ibérica",d:"Jamón serrano, pera y hojas de temporada.",p:280}]},
 {id:"bagels",titulo:"Bagel sándwich · todo el día",items:[
  {n:"Bagel ligero",d:"Cremoso de jocoque, aguacate, jitomate, pepino, pera y miel de abeja.",p:90},
  {n:"Bagel de pechuga de pavo",d:"Cremoso de jocoque, queso gouda, hojas de temporada y jitomate.",p:125},
  {n:"Bagel Töhö",d:"Cremoso de jocoque, milanesa de pollo, queso gouda, jitomate, aguacate, hojas de temporada y cebolla encurtida.",p:150},
  {n:"Bagel ibérico",d:"Cremoso de jocoque, hojas de temporada, jamón serrano, pera y queso gouda.",p:160}]},
 {id:"infantil",titulo:"Infantil · todo el día",items:[
  {n:"Waffle belga",d:"1 pieza con mantequilla, miel maple y compota de frutos rojos.",p:60},
  {n:"Sincronizada",d:"Jamón y queso gouda, acompañada de papas a la francesa.",p:90},
  {n:"Pizza bagel",d:"Salsa de tomate, queso mozzarella y pechuga de pavo.",p:90},
  {n:"Papas a la francesa",p:80},{n:"Malteada de chocolate",p:70},{n:"Juguito de manzana",p:35}]},
 {id:"postres",titulo:"Postres",items:[
  {n:"Flan Töhö",p:80},
  {n:"Flan de la casa",d:"Con frutos rojos, mermelada de fresa o maracuyá.",p:80},
  {n:"Cheesecake de maracuyá",p:80},{n:"Pay de manzana",p:65},{n:"Churros de pan francés",p:90},
  {n:"Postres de vitrina",d:"Pregunta por los de hoy.",p:100},
  {n:"Tarta vasca de la casa",d:"Con queso tenate.",p:120},
  {n:"Copa de frutos rojos",d:"Con nata y pistaches.",p:140}]}]},

{id:"bebidas",titulo:"Bebidas",
 destacado:{etiqueta:"Café de especialidad",titulo:"Leche orgánica Bové",precio:"",texto:"Puedes cambiarla por bebida vegetal sin costo adicional. Cualquier bebida fría o frappé, $10 más."},
 secciones:[
 {id:"sin-leche",titulo:"Café sin leche",items:[
  {n:"Café del día",d:"Americano de percoladora, clásico y suave.",p:50},
  {n:"Espresso",d:"Espresso doble con chaser de agua mineral.",p:55},
  {n:"Americano",d:"Espresso doble y agua caliente, clásico e intenso.",p:60},
  {n:"Americano frío",d:"Americano con hielo, intenso y refrescante.",p:60},
  {n:"Cold brew",d:"Extracción en frío, intensa y energizante.",p:60},
  {n:"Espresso tonic",d:"Espresso doble, agua tónica y hielo.",p:75},
  {n:"Cold brew tonic",d:"Extracción en frío con agua tónica.",p:75}]},
 {id:"con-leche",titulo:"Café con leche",nota:FRIO,items:[
  {n:"Macchiato",d:"Espresso doble manchado con microespuma de leche.",p:60},
  {n:"Cortado",d:"Espresso doble cortado con leche emulsionada.",p:65},
  {n:"Flat white",d:"Ristretto y leche emulsionada. Corta, sedosa y dulce.",p:70},
  {n:"Cappuccino",d:"Espresso y leche emulsionada, balanceado, sedoso y dulce.",p:75},
  {n:"Latte",d:"Espresso y leche emulsionada, suave, sedoso y dulce.",p:80},
  {n:"Cold brew latte",d:"Cold brew, leche y hielo. Suave, energizante y dulce.",p:80}]},
 {id:"extras",titulo:"Extras",items:[
  {n:"Extra espresso",d:"Carga adicional para intensificar tu bebida.",p:15},
  {n:"Extra shot de leche",d:"Leche emulsionada o fría.",p:15},
  {n:"Extra shot de jarabe",d:"Vainilla, caramelo o cajeta.",p:15}]},
 {id:"matcha",titulo:"Matcha bar",nota:FRIO,items:[
  {n:"Matcha ceremonial",d:"Auténtico matcha japonés con agua, sabor intenso.",p:70},
  {n:"Matcha latte",d:"Matcha japonés con leche emulsionada.",p:80},
  {n:"Matcha fresa latte",d:"Matcha japonés, coulis de fresa, leche emulsionada y hielo.",p:85},
  {n:"Matcha citrus",d:"Matcha japonés, óleo de cítricos, agua tónica y hielo.",p:85}]},
 {id:"chai",titulo:"Chai y especialidades",nota:FRIO,items:[
  {n:"Chai latte",d:"Té negro especiado y endulzado con leche emulsionada.",p:80},
  {n:"Taro latte",d:"Taro y leche emulsionada.",p:80},
  {n:"Golden milk",d:"Especiada, base cúrcuma, preparada en agua.",p:80},
  {n:"Dirty chai",d:"Té chai y espresso con leche emulsionada.",p:95}]},
 {id:"chocolate",titulo:"Chocolate y mocha",nota:FRIO,items:[
  {n:"Chocolate caliente",d:"Chocolate Oaxaca almendrado, especiado y endulzado, con leche emulsionada o agua.",p:70},
  {n:"Mocha",d:"Chocolate Oaxaca y espresso con leche emulsionada.",p:85},
  {n:"Vainilla latte",d:"Espresso, jarabe de vainilla y leche emulsionada.",p:85},
  {n:"Caramel latte",d:"Espresso, jarabe de caramelo y leche emulsionada.",p:85},
  {n:"Cajeta latte",d:"Espresso, jarabe de cajeta y leche emulsionada.",p:85},
  {n:"Affogato",d:"Espresso con helado.",p:90}]},
 {id:"te",titulo:"Té, tisana e infusiones",nota:FRIO,items:[
  {n:"Té Dilmah",d:"Variedades en sobre de la India y Asia.",p:60},
  {n:"Té ceremonial",d:"Negro, verde, blanco o rojo. Variedades asiáticas de temporada.",p:70},
  {n:"Tisana",d:"Variedades frutales de temporada.",p:70},
  {n:"Té inglés",d:"Earl Grey con leche emulsionada.",p:80},
  {n:"Té negro-limón",d:"Earl Grey con rodajas de limón eureka, toque de óleo cítrico y hielo.",p:85}]},
 {id:"jugos",titulo:"Jugos, sodas y refrescos",items:[
  {n:"Jugo de naranja",p:48},{n:"Jugo verde",p:48},{n:"Limonada / naranjada",p:50},
  {n:"Töhö Fizz",d:"Cordial de fruta natural de temporada, agua mineral y hielo.",p:60},
  {n:"Refrescos",d:"Coca-Cola clásica, sin azúcar o light, Sprite, Sprite sin azúcar, Fanta, Sidral o Squirt.",p:40},
  {n:"Rusa / suero",d:"Vaso escarchado con sal, limón, agua mineral y hielo.",p:35},
  {n:"Jarra de agua de frutas",p:60}]},
 {id:"cerveza",titulo:"Cerveza",items:[
  {n:"Nacionales",d:"Corona, Corona Light, Victoria, Pacífico, Modelo Especial, Negra Modelo.",p:65},
  {n:"Premium",d:"Ultra Michelob, Heineken, Stella Artois.",p:75},
  {n:"Artesanales",d:"Selección de temporada.",p:90},
  {n:"Vaso chelado",d:"Vaso escarchado y jugo de limón.",p:20},
  {n:"Vaso michelado",d:"Vaso escarchado con salsas negras y picantes.",p:30},
  {n:"Vaso clamato",d:"Vaso escarchado, salsas negras, picante, clamato y apio.",p:45}]},
 {id:"vino",titulo:"Vino",items:[
  {n:"Copa blanco o tinto de la casa",d:"Sencillo y fácil de degustar.",p:90},
  {n:"Botella",d:"Regionales (Hidalgo), nacionales e importados. Pregunta al mesero.",p:null}]},
 {id:"brunch",titulo:"Brunch cocktail",items:[
  {n:"Mimosa",d:"Espumoso prosecco con jugo de naranja.",p:120},
  {n:"Bellini",d:"Prosecco y jugo de durazno-melocotón.",p:120},
  {n:"Jarra de clericot blanco",d:"Vino blanco, frutas frescas, agua mineral y refresco de limón.",p:360},
  {n:"Jarra de clericot rojo",d:"Vino tinto, frutas frescas, agua mineral y refresco de limón.",p:360},
  {n:"Mimosa mocktail",d:"Espumoso sin alcohol con jugo de naranja.",p:100},
  {n:"Bellini mocktail",d:"Vino blanco espumoso sin alcohol y jugo de durazno-melocotón.",p:100},
  {n:"Jarra de clericot blanco mocktail",p:310}]},
 {id:"cocteles",titulo:"Cocktail bar",items:[
  {n:"Aperol Spritz",d:"Prosecco, Aperol y agua mineral.",p:148},
  {n:"Mezcalina",d:"Mezcal, coulis de fruta de temporada, agua mineral y hielo.",p:148},
  {n:"Negroni",d:"Ginebra, Campari y vermut dulce.",p:160},
  {n:"Martini",d:"Ginebra y vermut.",p:160},
  {n:"Gin & Tonic",d:"Ginebra, frutos, especias y agua tónica.",p:170},
  {n:"Töhö Especial",d:"Especial de temporada.",p:180},
  {n:"Cuba libre",d:"Ron blanco, refresco de cola y agua mineral.",p:110},
  {n:"Paloma",d:"Tequila, jugo de limón y refresco de toronja, en vaso escarchado.",p:120},
  {n:"Whiskey & soda",d:"Whiskey escocés y agua mineral.",p:140},
  {n:"Frozen margarita",p:160},{n:"Frozen daiquiri",p:160}]},
 {id:"aperitivos",titulo:"Aperitivos y digestivos",items:[
  {n:"Tequila",p:120},{n:"Mezcal",p:120},{n:"Espresso Carajillo 43",p:120},{n:"Espresso Baileys",p:120},
  {n:"Sambuca",p:110},{n:"Licor 43",p:100},{n:"Baileys",p:100},{n:"Anís seco / dulce",p:90}]}]}
];

/* ===== De aquí para abajo no hace falta tocar nada ===== */
const $=s=>document.querySelector(s);
const porId={};CARTAS.forEach(c=>c.secciones.forEach(s=>{if(s.items)porId[s.id]=s}));
const precio=p=>p==null?'<span class="precio pend">Consultar</span>':`<span class="precio">$${p}</span>`;
const item=i=>`<div class="item"><div class="fila"><span class="nombre">${i.n}</span><span class="puntos"></span>${precio(i.p)}</div>${i.d?`<p class="desc">${i.d}</p>`:''}${i.x?`<p class="extra">${i.x.map(o=>`<span>${o[0]} · <b>$${o[1]}</b></span>`).join('')}</p>`:''}</div>`;

$('#cartas').innerHTML=CARTAS.map(c=>`<div class="carta" id="carta-${c.id}" role="tabpanel" hidden>
 ${c.destacado?`<div class="destacado"><small>${c.destacado.etiqueta}</small><h3>${c.destacado.titulo}${c.destacado.precio?`<span>${c.destacado.precio}</span>`:''}</h3><p>${c.destacado.texto}</p></div>`:''}
 ${c.secciones.map(s=>`<section id="${s.id}"><div class="section-title"><h2>${s.titulo}</h2>${s.nota?`<p>${s.nota}</p>`:''}</div><div class="items">${(s.ref?porId[s.ref].items:s.items).map(item).join('')}</div></section>`).join('')}
</div>`).join('');
$('#tabs').innerHTML=CARTAS.map(c=>`<button role="tab" id="tab-${c.id}" aria-selected="false">${c.titulo}</button>`).join('');

let links=[],tabActual=null;
function abrir(id,subir){
  tabActual=id;
  CARTAS.forEach(c=>{const on=c.id===id;$('#carta-'+c.id).hidden=!on;$('#tab-'+c.id).setAttribute('aria-selected',on)});
  const c=CARTAS.find(c=>c.id===id);
  $('#cats').innerHTML=c.secciones.map(s=>`<a href="#${s.id}">${s.titulo.split(' · ')[0]}</a>`).join('');
  links=[...document.querySelectorAll('#cats a')];
  if(links[0])links[0].classList.add('activo');
  $('#cats').scrollLeft=0;
  if(subir){const t=$('.barra').getBoundingClientRect().top+scrollY;if(scrollY>t)scrollTo(0,t)}
}
$('#tabs').addEventListener('click',e=>{const b=e.target.closest('button');if(b)abrir(b.id.replace('tab-',''),true)});

const obs=new IntersectionObserver(es=>es.forEach(e=>{
  if(!e.isIntersecting)return;
  links.forEach(a=>a.classList.toggle('activo',a.getAttribute('href')==='#'+e.target.id));
  const act=links.find(a=>a.classList.contains('activo'));
  if(act){const b=act.parentElement;b.scrollLeft=act.offsetLeft-(b.clientWidth-act.offsetWidth)/2}
}),{rootMargin:'-40% 0px -55% 0px'});
document.querySelectorAll('section[id]').forEach(s=>obs.observe(s));

/* Buscador (sin importar acentos) */
const norm=t=>t.normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLowerCase();
const indice=[];
CARTAS.forEach(c=>c.secciones.forEach(s=>{if(!s.items)return;s.items.forEach(i=>indice.push({i,carta:c.titulo,sec:s.titulo.split(' · ')[0],texto:norm([i.n,i.d||'',s.titulo,(i.x||[]).map(o=>o[0]).join(' ')].join(' '))}))}));
const res=document.createElement('div');res.hidden=true;$('#cartas').prepend(res);
function buscar(){
  const v=$('#buscar').value,q=norm(v.trim()),on=q.length>=2;
  $('#limpiar').hidden=!v;
  $('.barra').classList.toggle('buscando',on);
  document.querySelectorAll('.carta').forEach(el=>el.hidden=on?true:el.id!=='carta-'+tabActual);
  res.hidden=!on;
  if(!on){res.innerHTML='';return}
  const ps=q.split(/\s+/),h=indice.filter(r=>ps.every(p=>r.texto.includes(p)));
  res.innerHTML=h.length
   ?`<section><div class="section-title"><h2>${h.length} resultado${h.length>1?'s':''}</h2></div><div class="items">${h.map(r=>item(r.i).replace('<div class="item">',`<div class="item"><p class="res-carta">${r.carta} · ${r.sec}</p>`)).join('')}</div></section>`
   :`<p class="sin-res">No encontramos "${v.replace(/[<>&"]/g,'')}". Prueba con otra palabra o pregunta a tu mesero.</p>`;
  const t=$('.barra').getBoundingClientRect().top+scrollY;if(scrollY>t)scrollTo(0,t);
}
$('#buscar').addEventListener('input',buscar);
$('#limpiar').addEventListener('click',()=>{$('#buscar').value='';buscar();$('#buscar').focus()});
$('#buscar').addEventListener('keydown',e=>{if(e.key==='Enter')e.target.blur()});

/* Abre la carta del enlace (#desayuno, #comida, #bebidas) o la de la hora del día */
const pedido=(location.hash||'').slice(1),hr=new Date().getHours();
abrir(CARTAS.some(c=>c.id===pedido)?pedido:(hr<13?'desayuno':'comida'),false);
</script>
<script>
/* Menú lateral móvil: el logo lo abre (solo en pantallas chicas) */
(function(){
  const menu=document.getElementById('mobile-menu'),overlay=document.getElementById('mobile-overlay');
  const abrirMenu=()=>{menu.classList.add('active');overlay.classList.add('active');document.body.style.overflow='hidden'};
  const cerrarMenu=()=>{menu.classList.remove('active');overlay.classList.remove('active');document.body.style.overflow=''};
  document.getElementById('mobile-logo-btn').addEventListener('click',e=>{if(innerWidth<=768){e.preventDefault();abrirMenu()}});
  document.getElementById('mobile-close-btn').addEventListener('click',cerrarMenu);
  overlay.addEventListener('click',cerrarMenu);
  document.querySelectorAll('.mobile-menu-item').forEach(a=>a.addEventListener('click',cerrarMenu));
  document.addEventListener('keydown',e=>{if(e.key==='Escape')cerrarMenu()});
  addEventListener('resize',()=>{if(innerWidth>768)cerrarMenu()});
})();
</script>
</body>
</html>