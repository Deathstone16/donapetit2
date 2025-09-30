<?php
// Vista administrativa para el catalogo de productos.
$productos = $productos ?? [];
$filters = $filters ?? [];
$searchTerm = (string)($filters['search'] ?? '');
$estadoFiltro = (string)($filters['estado'] ?? '');
$orderFiltro = (string)($filters['order'] ?? 'recent');
$estadoOpciones = $estadoOpciones ?? ['Disponible', 'Agotado', 'En revision'];

$successMessage = $_SESSION['success'] ?? null;
$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$totales = [
  'total' => count($productos),
  'activos' => 0,
  'bajos' => 0,
];

foreach ($productos as $producto) {
  $estado = strtolower((string)($producto['estado'] ?? ''));
  if ($estado === 'disponible' || $estado === 'activo') {
    $totales['activos']++;
  }

  if (isset($producto['cantidad']) && is_numeric($producto['cantidad']) && (int)$producto['cantidad'] <= 5) {
    $totales['bajos']++;
  }
}

$hasProductos = !empty($productos);
?>
<section class="py-8" id="catalogo-admin-view" data-has-productos="<?php echo $hasProductos ? '1' : '0'; ?>">
  <header class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <p class="text-xs uppercase tracking-wide text-slate-500">Panel de administracion</p>
      <h1 class="text-2xl font-bold text-slate-900">Catalogo de productos</h1>
      <p class="text-sm text-slate-600">Gestiona y revisa el estado de cada item disponible.</p>
    </div>
    <a href="index.php?controller=Producto&action=create"
       class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-emerald-700">
      <span>Nuevo producto</span>
    </a>
  </header>

  <div class="mb-6 grid gap-3 sm:grid-cols-3">
    <article class="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
      <p class="text-xs uppercase tracking-wide text-slate-500">Total</p>
      <p class="mt-1 text-2xl font-semibold text-slate-900">
        <span id="catalog-total-count"><?php echo (int)$totales['total']; ?></span>
      </p>
      <p class="text-xs text-slate-500">Productos registrados</p>
    </article>
    <article class="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
      <p class="text-xs uppercase tracking-wide text-slate-500">Disponibles</p>
      <p class="mt-1 text-2xl font-semibold text-emerald-600">
        <span id="catalog-activos-count"><?php echo (int)$totales['activos']; ?></span>
      </p>
      <p class="text-xs text-slate-500">Marcados como activos</p>
    </article>
    <article class="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
      <p class="text-xs uppercase tracking-wide text-slate-500">Stock bajo</p>
      <p class="mt-1 text-2xl font-semibold text-amber-600">
        <span id="catalog-bajos-count"><?php echo (int)$totales['bajos']; ?></span>
      </p>
      <p class="text-xs text-slate-500">Con 5 unidades o menos</p>
    </article>
  </div>

  <?php if ($successMessage): ?>
    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      <?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?>
    </div>
  <?php endif; ?>

  <?php if ($errorMessage): ?>
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
      <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
    </div>
  <?php endif; ?>

  <form id="catalogFilters" method="get" class="mb-6 grid gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-4" autocomplete="off">
    <div class="sm:col-span-2">
      <label for="catalog-search" class="text-xs uppercase tracking-wide text-slate-500">Buscar</label>
      <input id="catalog-search" name="search" type="search" value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>"
             class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500"
             placeholder="Nombre, unidad o comentarios" />
    </div>

    <div>
      <label for="catalog-estado" class="text-xs uppercase tracking-wide text-slate-500">Estado</label>
      <select id="catalog-estado" name="estado"
              class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500">
        <option value="">Todos</option>
        <?php foreach ($estadoOpciones as $estado): ?>
          <option value="<?php echo htmlspecialchars($estado, ENT_QUOTES, 'UTF-8'); ?>"
                  <?php echo $estadoFiltro === (string)$estado ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($estado, ENT_QUOTES, 'UTF-8'); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="catalog-order" class="text-xs uppercase tracking-wide text-slate-500">Orden</label>
      <select id="catalog-order" name="order"
              class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500">
        <option value="recent" <?php echo $orderFiltro === 'recent' ? 'selected' : ''; ?>>Mas recientes</option>
        <option value="oldest" <?php echo $orderFiltro === 'oldest' ? 'selected' : ''; ?>>Mas antiguos</option>
        <option value="cantidad_desc" <?php echo $orderFiltro === 'cantidad_desc' ? 'selected' : ''; ?>>Mayor cantidad</option>
        <option value="cantidad_asc" <?php echo $orderFiltro === 'cantidad_asc' ? 'selected' : ''; ?>>Menor cantidad</option>
      </select>
    </div>

    <div class="flex items-end justify-end gap-2 sm:col-span-4">
      <button type="submit"
              class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
        Aplicar filtros
      </button>
      <button type="button" id="catalog-reset"
              class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">
        Limpiar
      </button>
    </div>
  </form>

  <?php if (!empty($productos)): ?>
    <div id="catalog-table-wrapper" class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
      <table id="catalogTable" class="min-w-full divide-y divide-slate-200 text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
          <tr>
            <th scope="col" class="px-4 py-3 text-left">ID</th>
            <th scope="col" class="px-4 py-3 text-left">Producto</th>
            <th scope="col" class="px-4 py-3 text-left">Unidad</th>
            <th scope="col" class="px-4 py-3 text-right">Cantidad</th>
            <th scope="col" class="px-4 py-3 text-left">Vencimiento</th>
            <th scope="col" class="px-4 py-3 text-left">Estado</th>
            <th scope="col" class="px-4 py-3 text-left">Comentarios</th>
            <th scope="col" class="px-4 py-3 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200" id="catalogTableBody">
          <?php foreach ($productos as $index => $producto): ?>
            <tr data-product-row
                data-index="<?php echo (int)$index; ?>"
                data-name="<?php echo htmlspecialchars((string)($producto['nom_producto'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                data-categoria="<?php echo htmlspecialchars((string)($producto['categoria'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                data-unit="<?php echo htmlspecialchars((string)($producto['unidad'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                data-cantidad="<?php echo htmlspecialchars((string)($producto['cantidad'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                data-estado="<?php echo htmlspecialchars(strtolower((string)($producto['estado'] ?? '')), ENT_QUOTES, 'UTF-8'); ?>"
                data-fecha="<?php echo htmlspecialchars((string)($producto['fecha_vencimiento'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                data-comments="<?php echo htmlspecialchars((string)($producto['comentarios'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
              <td class="px-4 py-3 font-mono text-xs">
                <?php echo htmlspecialchars((string)($producto['id_producto'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
              </td>
              <td class="px-4 py-3 text-slate-900">
                <div class="font-medium"><?php echo htmlspecialchars((string)($producto['nom_producto'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="text-xs text-slate-500">
                  <?php echo htmlspecialchars((string)($producto['categoria'] ?? 'Sin categoria'), ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
              <td class="px-4 py-3 text-slate-600">
                <?php echo htmlspecialchars((string)($producto['unidad'] ?? '--'), ENT_QUOTES, 'UTF-8'); ?>
              </td>
              <td class="px-4 py-3 text-right font-medium">
                <?php echo htmlspecialchars((string)($producto['cantidad'] ?? '--'), ENT_QUOTES, 'UTF-8'); ?>
              </td>
              <td class="px-4 py-3 text-slate-600">
                <?php echo htmlspecialchars((string)($producto['fecha_vencimiento'] ?? '--'), ENT_QUOTES, 'UTF-8'); ?>
              </td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
                  <?php echo htmlspecialchars((string)($producto['estado'] ?? 'Sin estado'), ENT_QUOTES, 'UTF-8'); ?>
                </span>
              </td>
              <td class="px-4 py-3 text-slate-600">
                <?php echo htmlspecialchars((string)($producto['comentarios'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
              </td>
              <td class="px-4 py-3 text-right">
                <div class="inline-flex items-center gap-2 text-xs">
                  <a class="text-sky-600 hover:underline"
                     href="index.php?controller=Producto&action=show&id=<?php echo urlencode((string)($producto['id_producto'] ?? '')); ?>">Ver</a>
                  <a class="text-amber-600 hover:underline"
                     href="index.php?controller=Producto&action=edit&id=<?php echo urlencode((string)($producto['id_producto'] ?? '')); ?>">Editar</a>
                  <a class="text-red-600 hover:underline"
                     href="index.php?controller=Producto&action=destroy&id=<?php echo urlencode((string)($producto['id_producto'] ?? '')); ?>"
                     onclick="return confirm('Eliminar producto?');">Eliminar</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div id="catalog-empty-state" class="hidden rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-sm text-slate-600">
      No se encontraron resultados para los filtros seleccionados.
    </div>
  <?php else: ?>
    <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-sm text-slate-600">
      No hay productos para mostrar en el catalogo todavia.
      <a class="text-emerald-600 underline-offset-2 hover:underline"
         href="index.php?controller=Producto&action=create">Cargar el primero</a>.
    </div>
  <?php endif; ?>
</section>
<script defer src="/donapetit2/public/assets/js/catalogo_admin.js"></script>