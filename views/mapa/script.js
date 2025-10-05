// Inicializa el mapa centrado en Buenos Aires (puedes cambiar coordenadas)
const map = L.map('map').setView([-34.6037, -58.3816], 14);

// Capa base de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Marcadores simulados
const negocios = [
  { name: "El Molino", coords: [-34.603, -58.383] },
  { name: "La Esquina", coords: [-34.602, -58.379] },
  { name: "Don Pedro", coords: [-34.606, -58.385] },
  { name: "El Sabor", coords: [-34.604, -58.380] }
];

negocios.forEach(n => {
  L.marker(n.coords)
    .addTo(map)
    .bindPopup(`<b>${n.name}</b><br>Productos disponibles`);
});

// Control de radio de búsqueda
const range = document.getElementById('radius');
const value = document.getElementById('radius-value');

range.addEventListener('input', () => {
  value.textContent = `${range.value} km`;
});
