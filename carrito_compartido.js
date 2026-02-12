let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

function actualizarContador() {
  const contador = document.getElementById('cartCount');
  if (contador) {
    const total = carrito.reduce((acc, p) => acc + p.cantidad, 0);
    contador.textContent = total;
  }
}

function guardarCarrito() {
  localStorage.setItem('carrito', JSON.stringify(carrito));
  actualizarContador();
}

// FUNCIÓN PARA MOSTRAR NOTIFICACIÓN
function mostrarNotificacion(mensaje) {
  const notificacion = document.getElementById('notificacion');
  const notificacionTexto = document.getElementById('notificacion-texto');
  
  if (notificacion && notificacionTexto) {
    notificacionTexto.textContent = mensaje;
    notificacion.classList.add('mostrar');
    
    setTimeout(() => {
      notificacion.classList.remove('mostrar');
    }, 3000);
  } else {
    // Fallback: si no existe la notificación, usar alert
    alert(mensaje);
  }
}

document.querySelectorAll('.btn-agregar').forEach(btn => {
  btn.addEventListener('click', () => {
    const nombre = btn.getAttribute('data-nombre');
    const precio = parseFloat(btn.getAttribute('data-precio'));
    const existente = carrito.find(p => p.nombre === nombre);
    
    if (existente) {
      existente.cantidad++;
    } else {
      carrito.push({ nombre, precio, cantidad: 1 });
    }
    
    guardarCarrito();
    
    // Efecto visual en el botón
    const originalBg = btn.style.background;
    btn.style.background = 'linear-gradient(180deg, #4CAF50 0%, #2E7D32 100%)';
    setTimeout(() => {
      btn.style.background = originalBg;
    }, 300);
    
    // Mostrar notificación elegante
    mostrarNotificacion(`✅ ${nombre} agregado al carrito`);
  });
});

// Código para la página del carrito
const contenedor = document.getElementById('carrito-contenedor');
if (contenedor) {
  const totalTexto = document.getElementById('total');
  const vaciarBtn = document.getElementById('vaciar');

  function renderCarrito() {
    contenedor.innerHTML = '';
    if (carrito.length === 0) {
      contenedor.innerHTML = '<p>Tu carrito está vacío ☕</p>';
      if (totalTexto) totalTexto.textContent = 'Total: $0';
      return;
    }

    let total = 0;
    
    // Crear tabla para el carrito
    const tabla = document.createElement('table');
    tabla.className = 'tabla-carrito';
    tabla.innerHTML = `
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    `;
    
    const tbody = tabla.querySelector('tbody');
    
    carrito.forEach((p, index) => {
      const subtotal = p.precio * p.cantidad;
      total += subtotal;
      
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${p.nombre}</td>
        <td>$${p.precio}</td>
        <td>
          <button class="cantidad-btn" data-index="${index}" data-action="decrement">-</button>
          ${p.cantidad}
          <button class="cantidad-btn" data-index="${index}" data-action="increment">+</button>
        </td>
        <td>$${subtotal}</td>
        <td>
          <button class="eliminar-btn" data-index="${index}">Eliminar</button>
        </td>
      `;
      tbody.appendChild(tr);
    });

    contenedor.appendChild(tabla);
    
    // Agregar total y botones
    const totalContainer = document.createElement('div');
    totalContainer.className = 'total-carrito';
    totalContainer.innerHTML = `
      <p>Total: $${total}</p>
      <div>
        <button id="vaciar" class="btn-pago">Vaciar Carrito</button>
        <button class="btn-pago">Proceder al Pago</button>
      </div>
    `;
    contenedor.appendChild(totalContainer);
    
    if (totalTexto) totalTexto.textContent = `Total: $${total}`;
    
    // Re-asignar event listeners a los nuevos botones
    document.querySelectorAll('.cantidad-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const index = parseInt(e.target.dataset.index);
        const action = e.target.dataset.action;
        
        if (action === 'increment') {
          carrito[index].cantidad++;
        } else if (action === 'decrement') {
          if (carrito[index].cantidad > 1) {
            carrito[index].cantidad--;
          } else {
            carrito.splice(index, 1);
          }
        }
        
        guardarCarrito();
        renderCarrito();
      });
    });
    
    document.querySelectorAll('.eliminar-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const index = parseInt(e.target.dataset.index);
        carrito.splice(index, 1);
        guardarCarrito();
        renderCarrito();
      });
    });
    
    document.getElementById('vaciar').addEventListener('click', () => {
      carrito = [];
      guardarCarrito();
      renderCarrito();
    });
  }

  renderCarrito();
}

// Inicializar contador al cargar la página
actualizarContador();