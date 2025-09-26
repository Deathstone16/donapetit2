<?php
// Disponés de $data['userName'] que envió el controlador.
$user = htmlspecialchars($data['userName'] ?? 'Usuario');
require __DIR__ . '/../layouts/header.php';
?>

<!-- Saludo -->
<section class="mt-6 md:mt-10 text-center">
  <h1 class="text-2xl md:text-4xl font-extrabold">
    Bienvenido <span class="italic">[<?= $user ?>]</span>! <span class="inline-block">👋</span>
  </h1>
</section>

<!-- Carrusel “ilustrativo” --> 
<section class="mt-8 md:mt-10">
  <div class="relative mx-auto max-w-4xl">
    <!-- Piezas laterales (decorativas, simulando el mockup) -->
    <div class="hidden md:block absolute -left-24 top-1/2 -translate-y-1/2 w-16 h-40 bg-brand/70 rounded-r-2xl rotate-180"></div>
    <div class="hidden md:block absolute -left-10 top-1/2 -translate-y-1/2 w-28 h-48 bg-brand/80 rounded-2xl -skew-x-6"></div>

    <div class="hidden md:block absolute -right-24 top-1/2 -translate-y-1/2 w-16 h-40 bg-brand/70 rounded-l-2xl"></div>
    <div class="hidden md:block absolute -right-10 top-1/2 -translate-y-1/2 w-28 h-48 bg-brand/80 rounded-2xl skew-x-6"></div>

    <!-- Contenedor principal del carrusel --> 
    <div class="overflow-hidden rounded-2xl border border-zinc-200 shadow-soft bg-white">
      <ul id="slider" class="flex">
        <!-- Slide 1 -->
        <li class="min-w-full aspect-[16/9] grid place-items-center bg-brand/60 text-white text-xl">
          <span class="opacity-90">Slide 1 (imagen principal)</span>
        </li>
        <!-- Slide 2 -->
        <li class="min-w-full aspect-[16/9] grid place-items-center bg-brand/50 text-white text-xl">
          <span class="opacity-90">Slide 2</span>
        </li>
        <!-- Slide 3 -->
        <li class="min-w-full aspect-[16/9] grid place-items-center bg-brand/40 text-white text-xl">
          <span class="opacity-90">Slide 3</span>
        </li>
      </ul>
    </div>

    <!-- Controles -->
    <button id="prev" class="absolute left-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white shadow-soft hover:scale-105" aria-label="Anterior">‹</button>
    <button id="next" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white shadow-soft hover:scale-105" aria-label="Siguiente">›</button>
  </div>
</section>

<!-- Botones grandes -->
<section class="mt-10 md:mt-12 mx-auto max-w-3xl space-y-6">
  <!-- Cargar producto -->
  <a href="#" data-action="cargar" class="group flex items-center justify-between gap-4 px-6 py-4 rounded-full bg-brand text-white hover:brightness-110 shadow-soft">
    <span class="mx-auto text-center">
      <div class="font-semibold">Cargar producto</div>
      <div class="opacity-90 text-sm">Agregar donación</div>
    </span>
    <span class="text-2xl font-bold group-hover:rotate-90">+</span>
  </a>

  <!-- Mis productos -->
  <a href="#" data-action="mis-productos" class="group flex items-center justify-between gap-4 px-6 py-4 rounded-full bg-brand text-white hover:brightness-110 shadow-soft">
    <span class="mx-auto text-center">
      <div class="font-semibold">Mis productos</div>
      <div class="opacity-90 text-sm">Ver/editar donaciones</div>
    </span>
    <span class="text-xl">📦</span>
  </a>

  <!-- Estadísticas -->
  <a href="#" data-action="estadisticas" class="group flex items-center justify-between gap-4 px-6 py-4 rounded-full bg-brand text-white hover:brightness-110 shadow-soft">
    <span class="mx-auto text-center">
      <div class="font-semibold">Estadísticas</div>
      <div class="opacity-90 text-sm">Ver métricas</div>
    </span>
    <span class="text-xl">📊</span>
  </a>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
