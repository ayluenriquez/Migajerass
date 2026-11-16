<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php
// Configuración básica del sitio
$nombreSitio = "Migajeras";
$subtituloSitio = "Panificación y Alfajorería Artesanal";

// Arreglo Dinámico de Productos en PHP (Solo Alfajores y Panes)
$categorias =[ 
    "Alfajores" => [
        "id" => "alfajores",
        "items" => [
            ["id_prod" => "alf1", "nombre" => "Alfajor de Chocolate Negro", "desc" => "Masa suave de cacao, abundante dulce de leche repostero y baño de chocolate semiamargo.", "img" => "imagenes/alfa1.webp", "precio" => 2000],
            ["id_prod" => "alf2", "nombre" => "SIN STOCK", "desc" => "Capas de masa suave de vainilla, dulce de leche tradicional y bso de chocolate blanco.", "img" => "imagenes/alfa2.webp", "precio" => 0],
            ["id_prod" => "alf3", "nombre" => "Alfajor de Maicena", "desc" => "Masa suave que se deshace en la boca, relleno de dulce de leche y rebozado en coco rallado.", "img" => "imagenes/alfa.jpg", "precio" => 800],
            ["id_prod" => "alf4", "nombre" => "SIN STOCK", "desc" => "Masa suave, corazón de dulce de leche y nueces.", "img" => "imagenes/afa.webp", "precio" => 0 ]
             ]
         ], 
    "Panes" => [
        "id" => "panes",
        "items" => [
            ["id_prod" => "pan1", "nombre" => "SIN STOCK", "desc" => "Hogaza rústica estilo masa madre con corteza dorada y crujiente.", "img" => "imagenes/pan3.webp", "precio" => 0],
            ["id_prod" => "pan2", "nombre" => "Panes de salame", "desc" => "Bollitos suaves con salame picado.", "img" => "imagenes/pann.webp", "precio" => 1000],
            ["id_prod" => "pan3", "nombre" => "SIN STOCK", "desc" => "Panecillos salados con trozos de jamón, queso derretido y hierbas.", "img" => "imagenes/pan1.webp", "precio" => 0],
            ["id_prod" => "pan4", "nombre" => "Pan con chicharon", "desc" => "masa de pan tradicional, con chicharones crocantes.", "img" => "imagenes/panc.webp", "precio" => 800],
            ]
         ],
      ];
// Procesamiento del pedido enviado desde la misma plataforma
$pedidoConfirmado = false;
    // Si querés que se a
$detallePedidoEnviado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pedido'])) {
    $clienteNombre = htmlspecialchars($_POST['nombre']);
    $clienteTelefono = htmlspecialchars($_POST['telefono']);
    $clienteDireccion = htmlspecialchars($_POST['direccion']);
    $clienteNotas = htmlspecialchars($_POST['notas']);
    $itemsJson =$_POST['carrito_data'];
    $itemsPedido = json_decode($itemsJson, true); 
     }

    if (!empty($itemsPedido)) {$pedidoConfirmado = true;
        $numOrden = rand(1000, 9999);$detallePedidoEnviado = [
            'orden' => $numOrden,
            'nombre' => $clienteNombre,
            'telefono' => $clienteTelefono,
            'direccion' => $clienteDireccion,
            'notas' => $clienteNotas,
            'items' => $itemsPedido
        ];
        // Armar mensaje para WhatsApp
$mensajeWA = "NUEVO PEDIDO - MIGAJERAS\n";
$mensajeWA .= "Orden: #" . $numOrden . "\n\n";
$mensajeWA .= "Nombre: " . $clienteNombre . "\n";
$mensajeWA .= "Teléfono: " . $clienteTelefono . "\n";
$mensajeWA .= "Entrega / Retiro: " . $clienteDireccion . "\n";
if (!empty($clienteNotas)) {
    $mensajeWA .= "Notas: " . $clienteNotas . "\n";
}
$mensajeWA .= "\nPEDIDO:\n";

$totalWA = 0;
foreach ($itemsPedido as $item) {
    $nombreItem = $item['nombre'] ?? $item['name'] ?? 'Producto';
    $cant = $item['cantidad'] ?? $item['qty'] ?? 1;
    $precio = $item['precio'] ?? $item['price'] ?? 0;
    $subtotal = $cant * $precio;
    $totalWA += $subtotal;
    $mensajeWA .= "- {$cant}x {$nombreItem} - \${$subtotal}\n";
}
$mensajeWA .= "\nTotal: \${$totalWA}";

$numeroWA = "5493364662135"; // <-- poné TU número con 54 9, sin + ni espacios
$urlWhatsApp = "https://wa.me/" . $numeroWA . "?text=" . urlencode($mensajeWA);
         }
?>
<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombreSitio . " - " . $subtituloSitio; ?></title>
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
            <span class="brand-title"><?php echo $nombreSitio; ?></span>
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
        <ul>
            <?php foreach ($categorias as $nombreCat =>$datosCat): ?>
                <li><a href="#<?php echo $datosCat['id']; ?>"><?php echo $nombreCat; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- HERO BANNER -->
    <section class="hero-banner">
        <h1><?php echo $nombreSitio; ?></h1>
        <p><?php echo $subtituloSitio; ?></p>
        <a href="#productos" class="btn-main">Ver Productos y Pedir</a>
    </section>

    <!-- PROPUESTA DE VALOR / FORTALEZAS -->
    <section class="features-section">
        <div class="feature-item">
            <h4>🍞 100% Casero</h4>
            <p>Elaboración artesanal con el mejor sabor casero.</p>
        </div>
        <div class="feature-item">
            <h4>🌿 Sin Conservantes</h4>
            <p>Ingredientes seleccionados de primera calidad.</p>
        </div>
        <div class="feature-item">
            <h4>🏷️ Precios Accesibles</h4>
            <p>Opciones individuales, combos y ventas mayoristas.</p>
        </div>
        <div class="feature-item">
            <h4>❤️ Atención Personalizada</h4>
            <p>Hacemos tus pedidos a la medida de tus momentos.</p>
        </div>
    </section>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="container">

        <?php if ($pedidoConfirmado &&$detallePedidoEnviado): ?>
            <!-- RESUMEN DE PEDIDO CONFIRMADO DENTRO DE LA MISMA WEB -->
            <div class="exito-box">
                <h2>🎉 ¡Pedido N° #<?php echo $detallePedidoEnviado['orden']; ?> Confirmado Exitosamente!</h2>
                <p><strong>Gracias, <?php echo $detallePedidoEnviado['nombre']; ?>.</strong> Hemos recibido tu solicitud correctamente en nuestro sistema.</p>
                <hr style="margin: 15px 0; border: 0; border-top: 1px solid #ccc;">
                <p>📍 <strong>Dirección de Entrega:</strong> <?php echo $detallePedidoEnviado['direccion']; ?></p>
                <p>📞 <strong>Teléfono de Contacto:</strong> <?php echo $detallePedidoEnviado['telefono']; ?></p>
                <br>
                <h3>Resumen de lo solicitado:</h3>
                <ul style="list-style: none; padding: 10px 0;">
                    <?php $totalProcesado = 0; ?>
                    <?php foreach ($detallePedidoEnviado['items'] as$it): ?>
                        <?php $sub = $it['precio'] *$it['cantidad']; $totalProcesado +=$sub; ?>
                        <li>• <?php echo $it['nombre']; ?> x<?php echo$it['cantidad']; ?> - $<?php echo number_format($sub, 0, ',', '.'); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p style="font-size: 1.2rem; font-weight: bold; color: #9c542a;">Total Abarcado: $<?php echo number_format($totalProcesado, 0, ',', '.'); ?></p>
            </div>
            <?php if ($pedidoConfirmado): ?>
  <div>
    <h2>¡Pedido confirmado! Orden #<?= $numOrden ?></h2>
    <p>Total: $<?= $totalWA ?></p>
    <a href="<?= $urlWhatsApp ?>" target="_blank" style="background:#25D366; color:white; padding:12px 20px; border-radius:8px; text-decoration:none; display:inline-block;">
      Enviar pedido por WhatsApp
    </a>
  </div>
  <script>
    // Si querés que se abra solo, sin tocar nada:
    // window.open("<?= $urlWhatsApp ?>", "_blank");
  </script>
<?php endif; ?>
        <?php endif; ?>

        <div id="productos"></div>

        <!-- RENDERIZADO DINÁMICO DE PRODUCTOS CON PHP -->
        <?php foreach ($categorias as $nombreCat =>$datosCat): ?>
            <h2 id="<?php echo $datosCat['id']; ?>" class="section-title"><?php echo $nombreCat; ?></h2>
            <div class="grid-productos">
                <?php foreach ($datosCat['items'] as$item): ?>
                    <div class="tarjeta-producto">
                        <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['nombre']; ?>">
                        <div class="contenido-producto">
                            <h3><?php echo $item['nombre']; ?></h3>
                            <div class="precio-tag">$<?php echo number_format($item['precio'], 0, ',', '.'); ?></div>
                            <p><?php echo $item['desc']; ?></p>
                            <button class="btn-agregar" onclick="agregarAlCarrito('<?php echo $item['id_prod']; ?>', '<?php echo addslashes($item['nombre']); ?>', <?php echo$item['precio']; ?>)">
                                ➕ Agregar al Pedido
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <!-- SECCIÓN QUIÉNES SOMOS -->
        <section id="quienes-somos" class="about-section">
            <h2>Un poco de nosotros</h2>
            <p>
                Nuestro emprendimiento surge a partir de nuestro gusto por cocinar y preparar productos caseros. Nos gusta la idea de poder compartir algo que hacemos con dedicación y convertirlo en una oportunidad para emprender. Nuestra idea es ofrecer opciones artesanales de alfajorería y panificación, cuidando cada detalle de su elaboración.
            </p>
            <p>
                <strong>Nuestro objetivo:</strong> Ofrecer productos caseros, ricos y de buena calidad, elaborados sin conservantes. Buscamos satisfacer a nuestros clientes, brindar una excelente atención y acompañarte en cada merienda.
            </p>
            <div class="team-badge">
                👥 Emprendedores: Catalina Correa, Aylen Enríquez, Milagros Francesconi y Matías Serra.
            </div>
        </section>

    </div>

    <!-- VENTANA MODAL DEL CARRITO Y FORMULARIO -->
    <div class="modal-overlay" id="modal-carrito">
        <div class="modal-content">
            <button class="modal-close" onclick="cerrarCarrito()">&times;</button>
            <h2 class="modal-title">Tu Pedido</h2>
            
            <div id="carrito-items-container">
                <!-- Se llena dinámicamente con JavaScript -->
            </div>

            <div class="cart-total" id="cart-total-display">
                Total: $0
            </div>

            <!-- Formulario directo de pedido -->
            <form action="" method="POST" id="form-pedido" onsubmit="return validarEnvioPedido()">
                <input type="hidden" name="carrito_data" id="carrito_data_input">
                <input type="hidden" name="confirmar_pedido" value="1">

                <div class="form-group">
                    <label for="nombre">Nombre Completo *</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ej. Juan Pérez">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono / Celular de Contacto *</label>
                    <input type="tel" id="telefono" name="telefono" required placeholder="Ej. 11 2345-6789">
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección de Entrega o Retiro *</label>
                    <input type="text" id="direccion" name="direccion" required placeholder="Ej. Av. San Martín 1234 / Retiro en local">
                </div>

                <div class="form-group">
                    <label for="notas">Aclaraciones o Notas Adicionales</label>
                    <textarea id="notas" name="notas" rows="2" placeholder="Ej. Horario preferido de entrega..."></textarea>
                </div>

                <button type="submit" class="btn-confirmar-pedido">
                    ✅ Enviar Pedido
                </button>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <footer id="contacto">
        <div class="footer-content">
            <div class="footer-col">
                <h4><?php echo $nombreSitio; ?></h4>
                <p>Panificación y alfajorería artesanal hecha con dedicación y amor casero.</p>
            </div>
            <div class="footer-col">
                <h4>Categorías</h4>
                <ul>
                    <?php foreach ($categorias as $nombreCat =>$datosCat): ?>
                        <li><a href="#<?php echo $datosCat['id']; ?>"><?php echo $nombreCat; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Atención & Pedidos</h4>
                <ul>
                    <li>🛵 Envíos a domicilio directos</li>
                    <li>🏬 Venta a almacenes y comercios</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> <?php echo $nombreSitio; ?> Panificación - Escuela Técnica N° 5. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- SCRIPT JS PARA BÚSQUEDA Y MANEJO DEL CARRITO -->
    <script>
      let carrito = [];

      function agregarAlCarrito(id, nombre, precio) {
        const itemExistente = carrito.find(p => p.id === id);
        if (itemExistente) {
            itemExistente.cantidad++;
        } else {
            carrito.push({ id, nombre, precio, cantidad: 1 });
        }
        actualizarCarritoUI();
      }

      function cambiarCantidad(id, cambio) {
        const item = carrito.find(p => p.id === id);
        if (item) {
            item.cantidad += cambio;
            if (item.cantidad <= 0) {
                carrito = carrito.filter(p => p.id !== id);
            }
        }
        actualizarCarritoUI();
      }

      function actualizarCarritoUI() {
        const totalItems = carrito.reduce((acc, p) => acc + p.cantidad, 0);
        document.getElementById('cart-count').textContent = totalItems;

        const container = document.getElementById('carrito-items-container');
        container.innerHTML = '';

        if (carrito.length === 0) {
            container.innerHTML = '<p style="text-align: center; color: #777;">Tu carrito está vacío.</p>';
            document.getElementById('cart-total-display').textContent = 'Total: $0';
            return;
        }

        let total = 0;
        carrito.forEach(prod => {
            const subtotal = prod.precio * prod.cantidad;
            total += subtotal;

            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <div>
                    <strong>${prod.nombre}</strong><br>
                    <small>$${prod.precio} c/u</small>
                </div>
                <div class="cart-item-controls">
                    <button class="btn-cant" onclick="cambiarCantidad('${prod.id}', -1)">-</button>
                    <span>${prod.cantidad}</span>
                    <button class="btn-cant" onclick="cambiarCantidad('${prod.id}', 1)">+</button>
                    <span style="font-weight: bold; margin-left: 10px;">$${subtotal}</span>
                </div>
            `;
            container.appendChild(div);
        });

        document.getElementById('cart-total-display').textContent = `Total: $${total}`;
      }

      function abrirCarrito() {
        document.getElementById('modal-carrito').style.display = 'flex';
      }

      function cerrarCarrito() {
        document.getElementById('modal-carrito').style.display = 'none';
      }

      function validarEnvioPedido() {
        if (carrito.length === 0) {
            alert('Por favor agrega al menos un producto al carrito antes de enviar el pedido.');
            return false;
        }
        document.getElementById('carrito_data_input').value = JSON.stringify(carrito);
        return true;
      }

      // Buscador en tiempo real
      document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('.search-bar');
        const tarjetas = document.querySelectorAll('.tarjeta-producto');
        const titulosCategorias = document.querySelectorAll('.section-title');

        searchInput.addEventListener('input', (e) => {
          const busqueda = e.target.value.toLowerCase().trim();

          tarjetas.forEach((tarjeta) => {
            const titulo = tarjeta.querySelector('h3').textContent.toLowerCase();
            const descripcion = tarjeta.querySelector('p').textContent.toLowerCase();

            if (titulo.includes(busqueda) || descripcion.includes(busqueda)) {
              tarjeta.style.display = 'flex';
            } else {
              tarjeta.style.display = 'none';
            }
          });

          titulosCategorias.forEach((cat) => {
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