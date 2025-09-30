<?php
$user = htmlspecialchars($data['userName'] ?? 'Usuario', ENT_QUOTES, 'UTF-8');
require __DIR__ . '/../layouts/header.php';
?>

<section class="mt-6 md:mt-10 text-center">
  <h1 class="text-2xl md:text-4xl font-extrabold">
    Bienvenido <span class="italic"><?php echo $user; ?></span>
  </h1>
</section>

<section class="mt-8 md:mt-10">
  <div class="relative mx-auto max-w-4xl">
    <div class="hidden md:block absolute -left-24 top-1/2 -translate-y-1/2 w-16 h-40 bg-brand/70 rounded-r-2xl rotate-180"></div>
    <div class="hidden md:block absolute -left-10 top-1/2 -translate-y-1/2 w-28 h-48 bg-brand/80 rounded-2xl -skew-x-6"></div>

    <div class="hidden md:block absolute -right-24 top-1/2 -translate-y-1/2 w-16 h-40 bg-brand/70 rounded-l-2xl"></div>
    <div class="hidden md:block absolute -right-10 top-1/2 -translate-y-1/2 w-28 h-48 bg-brand/80 rounded-2xl skew-x-6"></div>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 shadow-soft bg-white">
      <ul id="slider" class="flex">
        <li class="min-w-full aspect-[16/9] grid place-items-center bg-brand/60 text-white text-xl">
          <span class="opacity-90">Slide 1</span>
        </li>
        <li class="min-w-full aspect-[16/9] grid place-items-center bg-brand/50 text-white text-xl">
          <span class="opacity-90">Slide 2</span>
        </li>
        <li class="min-w-full aspect-[16/9] grid place-items-center bg-brand/40 text-white text-xl">
          <span class="opacity-90">Slide 3</span>
        </li>
      </ul>
    </div>

    <button id="prev" class="absolute left-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white shadow-soft hover:scale-105" aria-label="Anterior">&lt;</button>
    <button id="next" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white shadow-soft hover:scale-105" aria-label="Siguiente">&gt;</button>
  </div>
</section>

<section class="mt-10 md:mt-12 mx-auto max-w-3xl space-y-6">
  <a href="#" data-action="cargar" class="group flex items-center justify-between gap-4 px-6 py-4 rounded-full bg-brand text-white hover:brightness-110 shadow-soft">
    <span class="mx-auto text-center">
      <div class="font-semibold">Cargar producto</div>
      <div class="opacity-90 text-sm">Agregar donacion</div>
    </span>
    <span class="text-2xl font-bold group-hover:rotate-90">+</span>
  </a>

  <a href="#" data-action="mis-productos" class="group flex items-center justify-between gap-4 px-6 py-4 rounded-full bg-brand text-white hover:brightness-110 shadow-soft">
    <span class="mx-auto text-center">
      <div class="font-semibold">Mis productos</div>
      <div class="opacity-90 text-sm">Ver o editar donaciones</div>
    </span>
    <span class="text-xl">&rsaquo;</span>
  </a>

  <a href="#" data-action="estadisticas" class="group flex items-center justify-between gap-4 px-6 py-4 rounded-full bg-brand text-white hover:brightness-110 shadow-soft">
    <span class="mx-auto text-center">
      <div class="font-semibold">Estadisticas</div>
      <div class="opacity-90 text-sm">Ver metricas</div>
    </span>
    <span class="text-xl">&rsaquo;</span>
  </a>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>