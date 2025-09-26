// public/js/dashboard.js

// 1) Menú hamburguesa (mostrar/ocultar en mobile)
const btnMenu = document.getElementById('btnMenu');
const menu = document.getElementById('menu');
if (btnMenu && menu) {
  btnMenu.addEventListener('click', () => {
    menu.classList.toggle('hidden');  // si está oculto, lo muestra; si está visible, lo oculta
  });
}

// 2) Carrusel básico
const slider = document.getElementById('slider');
const prev = document.getElementById('prev');
const next = document.getElementById('next');

let index = 0; // slide actual (0, 1, 2)
const total = slider ? slider.children.length : 0;

function goTo(i) {
  index = (i + total) % total; // si te vas de rango, vuelve a empezar
  const offset = -index * 100; // -100%, -200%...
  slider.style.transform = `translateX(${offset}%)`;
}

if (slider) {
  // Botones
  if (prev) prev.addEventListener('click', () => goTo(index - 1));
  if (next) next.addEventListener('click', () => goTo(index + 1));

  // Auto-rotación cada 4 segundos
  setInterval(() => goTo(index + 1), 4000);
}

// 3) Acciones de los botones grandes
document.querySelectorAll('[data-action]').forEach(el => {
  el.addEventListener('click', (e) => {
    e.preventDefault();
    const action = el.dataset.action;

    // Acá redirigís a tus rutas reales del backend:
    switch (action) {
      case 'cargar':
        // window.location.href = '/donaciones/crear';
        alert('Ir a: Crear donación');
        break;
      case 'mis-productos':
        // window.location.href = '/donaciones/mis-productos';
        alert('Ir a: Mis productos');
        break;
      case 'estadisticas':
        // window.location.href = '/estadisticas';
        alert('Ir a: Estadísticas');
        break;
    }
  });
});
