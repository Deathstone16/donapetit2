<?php
if (!isset($producto) || !is_array($producto)) {
    echo '<p class="py-8 text-sm text-red-600">Producto no disponible.</p>';
    return;
}

$id = htmlspecialchars((string)($producto['id_producto'] ?? ''), ENT_QUOTES, 'UTF-8');
$nombre = htmlspecialchars((string)($producto['nom_producto'] ?? ''), ENT_QUOTES, 'UTF-8');
$unidad = htmlspecialchars((string)($producto['unidad'] ?? ''), ENT_QUOTES, 'UTF-8');
$cantidad = htmlspecialchars((string)($producto['cantidad'] ?? '--'), ENT_QUOTES, 'UTF-8');
$fechaVencimiento = htmlspecialchars((string)($producto['fecha_vencimiento'] ?? '--'), ENT_QUOTES, 'UTF-8');
$estado = htmlspecialchars((string)($producto['estado'] ?? ''), ENT_QUOTES, 'UTF-8');
$comentarios = htmlspecialchars((string)($producto['comentarios'] ?? ''), ENT_QUOTES, 'UTF-8');
$createdAt = htmlspecialchars((string)($producto['created_at'] ?? ''), ENT_QUOTES, 'UTF-8');
$updatedAt = htmlspecialchars((string)($producto['updated_at'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<section class="py-8">
  <a href="index.php?controller=Producto&action=index" class="inline-flex items-center gap-2 text-sm text-brand hover:underline">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
    </svg>
    Volver al listado
  </a>

  <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <header class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-900"><?php echo $nombre; ?></h1>
        <p class="text-sm text-slate-500">ID: <?php echo $id; ?></p>
      </div>
      <span class="inline-flex items-center rounded-full bg-brand/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand">
        <?php echo $estado; ?>
      </span>
    </header>

    <dl class="mt-6 grid gap-5 md:grid-cols-2">
      <div>
        <dt class="text-xs uppercase tracking-wide text-slate-500">Unidad</dt>
        <dd class="text-base font-medium text-slate-900"><?php echo $unidad; ?></dd>
      </div>
      <div>
        <dt class="text-xs uppercase tracking-wide text-slate-500">Cantidad</dt>
        <dd class="text-base font-medium text-slate-900"><?php echo $cantidad; ?></dd>
      </div>
      <div>
        <dt class="text-xs uppercase tracking-wide text-slate-500">Fecha de vencimiento</dt>
        <dd class="text-base font-medium text-slate-900"><?php echo $fechaVencimiento; ?></dd>
      </div>
      <div>
        <dt class="text-xs uppercase tracking-wide text-slate-500">Última actualización</dt>
        <dd class="text-base font-medium text-slate-900"><?php echo $updatedAt ?: '--'; ?></dd>
      </div>
    </dl>

    <div class="mt-6">
      <h2 class="text-sm font-semibold text-slate-600">Comentarios</h2>
      <p class="mt-2 rounded-lg border border-slate-200 bg-slate-50 p-3 text-sm text-slate-700">
        <?php echo $comentarios !== '' ? $comentarios : 'Sin comentarios adicionales.'; ?>
      </p>
    </div>

    <footer class="mt-6 flex flex-wrap gap-3">
      <a href="index.php?controller=Producto&action=edit&id=<?php echo $id; ?>"
         class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand/90">
        Editar
      </a>
      <a href="index.php?controller=Producto&action=destroy&id=<?php echo $id; ?>"
         onclick="return confirm('¿Eliminar producto?');"
         class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
        Eliminar
      </a>
    </footer>

    <p class="mt-6 text-xs text-slate-400">Creado el <?php echo $createdAt ?: '--'; ?></p>
  </div>
</section>