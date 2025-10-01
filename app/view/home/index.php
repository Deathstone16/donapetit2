<?php
$user = htmlspecialchars($userName ?? 'Usuario', ENT_QUOTES, 'UTF-8');
?>
<section class="py-10 text-center">
  <h1 class="text-3xl font-extrabold text-slate-900">
    Bienvenido <span class="italic text-brand/90"><?php echo $user; ?></span>
  </h1>
  <p class="mt-3 text-slate-600">Gestioná tus donaciones y hacé seguimiento de los productos disponibles.</p>
</section>

<section class="mx-auto grid max-w-4xl gap-6 py-8 md:grid-cols-3">
  <article class="rounded-2xl border border-slate-200 bg-white p-6 text-left shadow-sm">
    <h2 class="text-lg font-semibold text-slate-900">Cargar producto</h2>
    <p class="mt-2 text-sm text-slate-600">Agregá nuevas donaciones indicando stock, vencimiento y comentarios.</p>
    <a href="index.php?controller=Producto&action=create"
       class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-3 py-2 text-sm font-medium text-white hover:bg-brand/90">
      Ir al formulario
    </a>
  </article>

  <article class="rounded-2xl border border-slate-200 bg-white p-6 text-left shadow-sm">
    <h2 class="text-lg font-semibold text-slate-900">Mis productos</h2>
    <p class="mt-2 text-sm text-slate-600">Consultá el estado, actualizá datos y reservá donaciones.</p>
    <a href="index.php?controller=Producto&action=index"
       class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-3 py-2 text-sm font-medium text-white hover:bg-brand/90">
      Ver listado
    </a>
  </article>

  <article class="rounded-2xl border border-slate-200 bg-white p-6 text-left shadow-sm">
    <h2 class="text-lg font-semibold text-slate-900">Dashboard</h2>
    <p class="mt-2 text-sm text-slate-600">Accedé a métricas rápidas sobre productos disponibles y entregados.</p>
    <a href="#"
       class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-3 py-2 text-sm font-medium text-white hover:bg-brand/90">
      Próximamente
    </a>
  </article>
</section>