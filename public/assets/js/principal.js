// Menu lateral
const openBtn = document.getElementById('openSidebar');
const closeBtn = document.getElementById('closeSidebar');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

function openMenu() {
  sidebar.classList.remove('translate-x-full');
  overlay.classList.remove('hidden');
  requestAnimationFrame(() => overlay.classList.remove('opacity-0'));
  openBtn.setAttribute('aria-expanded', 'true');
}
function closeMenu() {
  sidebar.classList.add('translate-x-full');
  overlay.classList.add('opacity-0');
  openBtn.setAttribute('aria-expanded', 'false');
  setTimeout(() => overlay.classList.add('hidden'), 300);
}

if (openBtn) openBtn.addEventListener('click', openMenu);
if (closeBtn) closeBtn.addEventListener('click', closeMenu);
if (overlay) overlay.addEventListener('click', closeMenu);
window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMenu(); });

// Anio en el footer
const yearEl = document.getElementById('year');
if (yearEl) {
  yearEl.textContent = new Date().getFullYear();
}