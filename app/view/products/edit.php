<?php
if (!isset($producto) || !is_array($producto)) {
    echo '<p class="py-8 text-sm text-red-600">Producto no disponible.</p>';
    return;
}

$id = htmlspecialchars((string)($producto['id_producto'] ?? ''), ENT_QUOTES, 'UTF-8');
$nombre = htmlspecialchars((string)($producto['nom_producto'] ?? ''), ENT_QUOTES, 'UTF-8');
$unidad = htmlspecialchars((string)($producto['unidad'] ?? ''), ENT_QUOTES, 'UTF-8');
$cantidad = htmlspecialchars((string)($producto['cantidad'] ?? ''), ENT_QUOTES, 'UTF-8');
$fechaVencimiento = htmlspecialchars((string)($producto['fecha_vencimiento'] ?? ''), ENT_QUOTES, 'UTF-8');
$comentarios = htmlspecialchars((string)($producto['comentarios'] ?? ''), ENT_QUOTES, 'UTF-8');
$estadoActual = htmlspecialchars((string)($producto['estado'] ?? 'DISPONIBLE'), ENT_QUOTES, 'UTF-8');

$estados = [
    'DISPONIBLE' => 'Disponible',
    'RESERVADO'  => 'Reservado',
    'ENTREGADO'  => 'Entregado',
    'VENCIDO'    => 'Vencido',
    'CANCELADO'  => 'Cancelado',
];
?>
<section class="py-8">
  <div class="mb-6 flex items-center gap-2 text-sm">
    <a href="index.php?controller=Producto&action=index" class="inline-flex items-center gap-2 text-brand hover:underline">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
      </svg>
      Volver al listado
    </a>
  </div>

  <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <header class="mb-6">
      <h1 class="text-2xl font-bold text-slate-900">Editar producto</h1>
      <p class="text-sm text-slate-500">ID: <?php echo $id; ?></p>
    </header>

    <form action="index.php?controller=Producto&action=update" method="post" class="space-y-5">
      <input type="hidden" name="id" value="<?php echo $id; ?>" />

      <div>
        <label class="block text-sm font-medium text-slate-700">Nombre <span class="text-red-600">*</span></label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>"
               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand" />
      </div>

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-sm font-medium text-slate-700">Unidad <span class="text-red-600">*</span></label>
          <input type="text" name="unidad" value="<?php echo $unidad; ?>"
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand" />
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700">Cantidad</label>
          <input type="number" name="cantidad" min="1" value="<?php echo $cantidad; ?>"
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand" />
        </div>
      </div>

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-sm font-medium text-slate-700">Fecha de vencimiento</label>
          <input type="date" name="vencimiento" value="<?php echo $fechaVencimiento; ?>"
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand" />
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700">Estado</label>
          <select name="estado"
                  class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
            <option value="">Seleccionar</option>
            <?php foreach ($estados as $valor => $etiqueta): ?>
              <option value="<?php echo $valor; ?>" <?php echo $estadoActual === $valor ? 'selected' : ''; ?>>
                <?php echo $etiqueta; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700">Comentarios</label>
        <textarea name="comentarios" rows="4"
                  class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand"><?php echo $comentarios; ?></textarea>
      </div>

      <div class="flex flex-wrap gap-3">
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand/90">
          Guardar cambios
        </button>
        <a href="index.php?controller=Producto&action=show&id=<?php echo $id; ?>"
           class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</section>