<?php
/** @var array $productos */
$page = $page ?? 1;

$successMessage = $_SESSION['success'] ?? null;
$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Listado de productos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
  <div class="bg-slate-900 text-white">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="index.php?controller=Home&action=index" class="font-semibold text-lg">DonAppetit</a>
      <nav class="flex items-center gap-4 text-sm">
        <a href="index.php?controller=Producto&action=create" class="hover:underline">Cargar</a>
        <a href="index.php?controller=Producto&action=index" class="hover:underline">Listado</a>
      </nav>
    </div>
  </div>

  <main class="max-w-6xl mx-auto px-4 py-8">
    <header class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold">Productos</h1>
        <p class="text-sm text-slate-600">Pagina <?php echo (int)$page; ?></p>
      </div>
      <a href="index.php?controller=Producto&action=create"
         class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-white shadow hover:bg-emerald-700">
        <span>Nuevo producto</span>
      </a>
    </header>

    <?php if ($successMessage): ?>
      <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
        <?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
        <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($productos)): ?>
      <div class="overflow-x-auto shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 bg-white">
          <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr>
              <th scope="col" class="px-4 py-3 text-left">ID</th>
              <th scope="col" class="px-4 py-3 text-left">Nombre</th>
              <th scope="col" class="px-4 py-3 text-left">Unidad</th>
              <th scope="col" class="px-4 py-3 text-right">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 text-sm">
            <?php foreach ($productos as $producto): ?>
              <tr>
                <td class="px-4 py-3 font-mono text-xs">
                  <?php echo htmlspecialchars((string)($producto['id_producto'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td class="px-4 py-3">
                  <?php echo htmlspecialchars((string)($producto['nom_producto'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td class="px-4 py-3">
                  <?php echo htmlspecialchars((string)($producto['unidad'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td class="px-4 py-3 text-right">
                  <a class="text-sky-600 hover:underline mr-3" href="index.php?controller=Producto&action=show&id=<?php echo urlencode((string)($producto['id_producto'] ?? '')); ?>">
                    Ver
                  </a>
                  <a class="text-amber-600 hover:underline mr-3" href="index.php?controller=Producto&action=edit&id=<?php echo urlencode((string)($producto['id_producto'] ?? '')); ?>">
                    Editar
                  </a>
                  <a class="text-red-600 hover:underline" href="index.php?controller=Producto&action=destroy&id=<?php echo urlencode((string)($producto['id_producto'] ?? '')); ?>"
                     onclick="return confirm('Eliminar producto?');">
                    Eliminar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="rounded-lg border border-slate-200 bg-white px-4 py-6 text-sm text-slate-600">
        No hay productos cargados aun.
      </div>
    <?php endif; ?>
  </main>

  <footer class="py-6 text-center text-xs text-slate-500">
    &copy; <?php echo date('Y'); ?> DonAppetit
  </footer>

  <script src="/donapetit2/public/assets/js/principal.js" defer></script>
</body>
</html>