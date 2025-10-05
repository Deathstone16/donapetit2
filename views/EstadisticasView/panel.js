// Chart 1: Productos más frecuentes
const ctx1 = document.getElementById('productosChart').getContext('2d');
new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: ['Pan', 'Frutas', 'Verduras', 'Lácteos', 'Cereales'],
    datasets: [{
      label: 'Cantidad',
      data: [25, 40, 30, 20, 15],
      backgroundColor: ['#3d538f', '#212E50FF', '#161D30FF', '#2F3953FF', '#1B2B55FF'],
      borderRadius: 6,
      barThickness: 25
    }]
  },
  options: {
    indexAxis: 'y',
    plugins: { legend: { display: false } },
    scales: {
      x: { beginAtZero: true, grid: { display: false } },
      y: { grid: { display: false } }
    }
  }
});

// Chart 2: Frecuencia mensual
const ctx2 = document.getElementById('frecuenciaChart').getContext('2d');
new Chart(ctx2, {
  type: 'line',
  data: {
    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
    datasets: [{
      label: 'Donaciones',
      data: [20, 25, 18, 30, 28, 26, 24, 35],
      borderColor: '#3d538f',
      backgroundColor: 'rgba(65, 109, 86, 0.1)',
      tension: 0.4,
      fill: true,
      pointRadius: 3
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, grid: { color: '#eee' } },
      x: { grid: { display: false } }
    }
  }
});
