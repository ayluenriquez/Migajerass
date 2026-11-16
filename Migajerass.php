<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Migajeras - Panificación y Alfajorería Artesanal</title>
</head>
<body>

    <!-- BARRA SUPERIOR DE ANUNCIOS -->
    <div class="top-bar">
        <div class="top-bar-info">
            <span>🛵 Envíos a domicilio y entregas programadas</span>
            <span>📍 Venta directa y a almacenes</span>
        </div>
        <div>
            <span>🛒 Realizá tu pedido 100% online</span>
        </div>
    </div>

    <!-- NAVBAR PRINCIPAL -->
    <nav class="navbar">
        <a href="#" class="brand-logo">
            <img src="imagenes/log.jpg" alt="Migajeras Logo">
            <span class="brand-title">Migajeras</span>
        </a>
        <div class="navbar-search">
            <input type="text" class="search-bar" placeholder="Buscar alfajores, panes caseros, chipá..." aria-label="Buscar productos">
        </div>
        <div class="nav-actions">
            <a href="#quienes-somos" class="nav-link">Quiénes Somos</a>
            <button class="btn-cart-nav" onclick="abrirCarrito()">
                🛒 Ver Mi Pedido (<span id="cart-count">0</span>)
            </button>
        </div>
    </nav>

    <!-- BARRA DE CATEGORÍAS -->
    <nav class="categories-nav">
        <ul id="lista-categorias"></ul>
    </nav>

    <!-- HERO BANNER -->
    <section class="hero-banner">
        <h1>Migajeras</h1>
        <p>Panificación y Alfajorería Artesanal</p>
        <a href="#productos" class="btn-main">Ver Productos y Pedir</a>
    </section>

    <!-- PROPUESTA DE VALOR -->
    <section class="features-section">
        <div class="feature-item"><h4>🍞 100% Casero</h4><p>Elaboración artesanal con el mejor sabor casero.</p></div>
        <div class="feature-item"><h4>🌿 Sin Conservantes</h4><p>Ingredientes seleccionados de primera calidad.</p></div>
        <div class="feature-item"><h4>🏷️ Precios Accesibles</h4><p>Opciones individuales, combos y ventas mayoristas.</p></div>
        <div class="feature-item"><h4>❤️ Atención Personalizada</h4><p>Hacemos tus pedidos a la medida de tus momentos.</p></div>
    </section>

    <div class="container">
        <!-- ACA APARECE EL PEDIDO CONFIRMADO -->
        <div id="exito-box" style="display:none;"></div>
        <div id="productos"></div>
    </div>

    <!-- SECCIÓN QUIÉNES SOMOS -->
    <section id="quienes-somos" class="about-section">
        <h2>Un poco de nosotros</h2>
        <p>Nuestro emprendimiento surge a partir de nuestro gusto por cocinar y preparar productos caseros. Nos gusta la idea de poder compartir algo que hacemos con dedicación y convertirlo en una oportunidad para emprender. Nuestra idea es ofrecer opciones artesanales de alfajorería y panificación, cuidando cada detalle de su elaboración.</p>
        <p><strong>Nuestro objetivo:</strong> Ofrecer productos caseros, ricos y de buena calidad, elaborados sin conservantes. Buscamos satisfacer a nuestros clientes, brindar una excelente atención y acompañarte en cada merienda.</p>
        <div class="team-badge">👥 Emprendedores: Catalina Correa, Aylen Enríquez, Milagros Francesconi y Matías Serra.</div>
    </section>

    <!-- MODAL CARRITO -->
    <div class="modal-overlay" id="modal-carrito">
        <div class="modal-content">
            <button class="modal-close" onclick="cerrarCarrito()">&times;</button>
            <h2 class="modal-title">Tu Pedido</h2>
            <div id="carrito-items-container"></div>
            <div class="cart-total" id="cart-total-display">Total: $0</div>
            <form id="form-pedido">
                <div class="form-group"><label for="nombre">Nombre Completo *</label><input type="text" id="nombre" required placeholder="Ej. Juan Pérez"></div>
                <div class="form-group"><label for="telefono">Teléfono / Celular de Contacto *</label><input type="tel" id="telefono" required placeholder="Ej. 11 2345-6789"></div>
                <div class="form-group"><label for="direccion">Dirección de Entrega o Retiro *</label><input type="text" id="direccion" required placeholder="Ej. Av. San Martín 1234 / Retiro en local"></div>
                <div class="form-group"><label for="notas">Aclaraciones o Notas Adicionales</label><textarea id="notas" rows="2" placeholder="Ej. Horario preferido de entrega..."></textarea></div>
                <button type="submit" class="btn-confirmar-pedido">✅ Enviar Pedido</button>
            </form>
        </div>
    </div>

    <footer id="contacto">
        <div class="footer-content">
            <div class="footer-col"><h4>Migajeras</h4><p>Panificación y alfajorería artesanal hecha con dedicación y amor casero.</p></div>
            <div class="footer-col"><h4>Categorías</h4><ul id="footer-categorias"></ul></div>
            <div class="footer-col"><h4>Atención & Pedidos</h4><ul><li>🛵 Envíos a domicilio directos</li><li>🏬 Venta a almacenes y comercios</li></ul></div>
        </div>
        <div class="footer-bottom"><p>&copy; <span id="anio"></span> Migajeras Panificación - Escuela Técnica N° 5. Todos los derechos reservados.</p></div>
    </footer>

<script>
const categorias = {
  "Alfajores": { id: "alfajores", items: [
    { id_prod: "alf1", nombre: "Alfajor de Chocolate Negro", desc: "Masa suave de cacao, abundante dulce de leche repostero y baño de chocolate semiamargo.", img: "imagenes/alfa1.webp", precio: 2000 },
    { id_prod: "alf2", nombre: "SIN STOCK", desc: "Capas de masa suave de vainilla, dulce de leche tradicional y baño de chocolate blanco.", img: "imagenes/alfa2.webp", precio: 0 },
    { id_prod: "alf3", nombre: "Alfajor de Maicena", desc: "Masa suave que se deshace en la boca, relleno de dulce de leche y rebozado en coco rallado.", img: "imagenes/alfa.jpg", precio: 800 },
    { id_prod: "alf4", nombre: "SIN STOCK", desc: "Masa suave, corazón de dulce de leche y nueces.", img: "imagenes/afa.webp", precio: 0 }
  ]},
  "Panes": { id: "panes", items: [
    { id_prod: "pan1", nombre: "SIN STOCK", desc: "Hogaza rústica estilo masa madre con corteza dorada y crujiente.", img: "imagenes/pan3.webp", precio: 0 },
    { id_prod: "pan2", nombre: "Panes de salame", desc: "Bollitos suaves con salame picado.", img: "imagenes/pann.webp", precio: 1000 },
    { id_prod: "pan3", nombre: "SIN STOCK", desc: "Panecillos salados con trozos de jamón, queso derretido y hierbas.", img: "imagenes/pan1.webp", precio: 0 },
    { id_prod: "pan4", nombre: "Pan con chicharon", desc: "masa de pan tradicional, con chicharones crocantes.", img: "imagenes/panc.webp", precio: 800 }
  ]}
};

const numeroWA = "5493364662135";
let carrito = [];
document.getElementById('anio').textContent = new Date().getFullYear();

// Renderizar categorías y productos
const listaCat = document.getElementById('lista-categorias');
const footerCat = document.getElementById('footer-categorias');
const contProductos = document.getElementById('productos');

Object.entries(categorias).forEach(([nombreCat, datos]) => {
  listaCat.innerHTML += `<li><a href="#${datos.id}">${nombreCat}</a></li>`;
  footerCat.innerHTML += `<li><a href="#${datos.id}">${nombreCat}</a></li>`;
  let html = `<h2 id="${datos.id}" class="section-title">${nombreCat}</h2><div class="grid-productos">`;
  datos.items.forEach(item => {
    const sinStock = item.precio === 0;
    html += `<div class="tarjeta-producto">
      <img src="${item.img}" alt="${item.nombre}">
      <div class="contenido-producto">
        <h3>${item.nombre}</h3>
        <div class="precio-tag">${sinStock ? 'Sin stock' : '$' + item.precio.toLocaleString('es-AR')}</div>
        <p>${item.desc}</p>
        <button class="btn-agregar" ${sinStock ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''} onclick="agregarAlCarrito('${item.id_prod}', '${item.nombre.replace(/'/g, "\\'")}', ${item.precio})">➕ Agregar al Pedido</button>
      </div></div>`;
  });
  html += `</div>`;
  contProductos.innerHTML += html;
});

function agregarAlCarrito(id, nombre, precio) {
  const ex = carrito.find(p => p.id === id);
  if (ex) ex.cantidad++; else carrito.push({ id, nombre, precio, cantidad: 1 });
  actualizarCarritoUI();
}
function cambiarCantidad(id, cambio) {
  const item = carrito.find(p => p.id === id);
  if (item) { item.cantidad += cambio; if (item.cantidad <= 0) carrito = carrito.filter(p => p.id !== id); }
  actualizarCarritoUI();
}
function actualizarCarritoUI() {
  const totalItems = carrito.reduce((a,p)=>a+p.cantidad,0);
  document.getElementById('cart-count').textContent = totalItems;
  const container = document.getElementById('carrito-items-container');
  container.innerHTML = '';
  if (carrito.length === 0) { container.innerHTML = '<p style="text-align:center;color:#777;">Tu carrito está vacío.</p>'; document.getElementById('cart-total-display').textContent = 'Total: $0'; return; }
  let total = 0;
  carrito.forEach(prod => {
    const subtotal = prod.precio * prod.cantidad; total += subtotal;
    const div = document.createElement('div'); div.className = 'cart-item';
    div.innerHTML = `<div><strong>${prod.nombre}</strong><br><small>$${prod.precio} c/u</small></div><div class="cart-item-controls"><button class="btn-cant" onclick="cambiarCantidad('${prod.id}', -1)">-</button><span>${prod.cantidad}</span><button class="btn-cant" onclick="cambiarCantidad('${prod.id}', 1)">+</button><span style="font-weight:bold;margin-left:10px;">$${subtotal}</span></div>`;
    container.appendChild(div);
  });
  document.getElementById('cart-total-display').textContent = `Total: $${total}`;
}
function abrirCarrito(){ document.getElementById('modal-carrito').style.display='flex'; }
function cerrarCarrito(){ document.getElementById('modal-carrito').style.display='none'; }

// Enviar pedido por WhatsApp
document.getElementById('form-pedido').addEventListener('submit', function(e){
  e.preventDefault();
  if (carrito.length === 0){ alert('Por favor agrega al menos un producto al carrito antes de enviar el pedido.'); return; }
  const nombre = document.getElementById('nombre').value;
  const telefono = document.getElementById('telefono').value;
  const direccion = document.getElementById('direccion').value;
  const notas = document.getElementById('notas').value;
  const numOrden = Math.floor(1000 + Math.random()*9000);
  let total = 0;
  let mensaje = `NUEVO PEDIDO - MIGAJERAS\nOrden: #${numOrden}\n\nNombre: ${nombre}\nTeléfono: ${telefono}\nEntrega / Retiro: ${direccion}\n`;
  if (notas) mensaje += `Notas: ${notas}\n`;
  mensaje += `\nPEDIDO:\n`;
  let listaHtml = '';
  carrito.forEach(item => {
    const sub = item.cantidad * item.precio; total += sub;
    mensaje += `- ${item.cantidad}x ${item.nombre} - $${sub}\n`;
    listaHtml += `<li>• ${item.nombre} x${item.cantidad} - $${sub.toLocaleString('es-AR')}</li>`;
  });
  mensaje += `\nTotal: $${total}`;
  const urlWhatsApp = `https://wa.me/${numeroWA}?text=${encodeURIComponent(mensaje)}`;

  const box = document.getElementById('exito-box');
  box.style.display = 'block';
  box.innerHTML = `<div class="exito-box"><h2>🎉 ¡Pedido N° #${numOrden} Confirmado Exitosamente!</h2><p><strong>Gracias, ${nombre}.</strong> Hemos recibido tu solicitud.</p><hr style="margin:15px 0;"><p>📍 <strong>Dirección:</strong> ${direccion}</p><p>📞 <strong>Teléfono:</strong> ${telefono}</p><h3>Resumen:</h3><ul style="list-style:none;padding:10px 0;">${listaHtml}</ul><p style="font-size:1.2rem;font-weight:bold;color:#9c542a;">Total: $${total.toLocaleString('es-AR')}</p><a href="${urlWhatsApp}" target="_blank" style="background:#25D366;color:white;padding:12px 20px;border-radius:8px;text-decoration:none;display:inline-block;">Enviar pedido por WhatsApp</a></div>`;
  cerrarCarrito();
  carrito = []; actualizarCarritoUI();
  box.scrollIntoView({behavior:'smooth'});
  window.open(urlWhatsApp, '_blank');
});

// Buscador
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('.search-bar');
  searchInput.addEventListener('input', (e) => {
    const busqueda = e.target.value.toLowerCase().trim();
    document.querySelectorAll('.tarjeta-producto').forEach(tarjeta => {
      const titulo = tarjeta.querySelector('h3').textContent.toLowerCase();
      const desc = tarjeta.querySelector('p').textContent.toLowerCase();
      tarjeta.style.display = (titulo.includes(busqueda) || desc.includes(busqueda)) ? 'flex' : 'none';
    });
    document.querySelectorAll('.section-title').forEach(cat => {
      const grid = cat.nextElementSibling;
      if (grid && grid.classList.contains('grid-productos')) {
        const visibles = grid.querySelectorAll('.tarjeta-producto:not([style*="display: none"])');
        cat.style.display = visibles.length > 0 ? 'block' : 'none';
      }
    });
  });
});
</script>
</body>
</html>