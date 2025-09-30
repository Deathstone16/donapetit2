<?php
$userName = $userName ?? ($_SESSION['user']['name'] ?? 'Usuario');
$userAvatar = $userAvatar ?? ($_SESSION['user']['avatar'] ?? null);
$menuItems = $menuItems ?? [
    ['label' => 'Inicio',      'url' => 'index.php?controller=Home&action=index'],
    ['label' => 'Productos',   'url' => 'index.php?controller=Producto&action=index'],
    ['label' => 'Nuevo producto', 'url' => 'index.php?controller=Producto&action=create'],
    ['label' => 'Solicitudes', 'url' => '#'],
    ['label' => 'Salir',       'url' => '#'],
];

$initial = strtoupper(mb_substr($userName, 0, 1, 'UTF-8'));
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DonAppetit</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
          colors: {
            brand: { DEFAULT: '#1D4ED8' }
          },
          boxShadow: {
            soft: '0 8px 30px rgba(0,0,0,.08)'
          }
        }
      }
    }
  </script>

  <style>
    * { transition: all .15s ease-in-out }
  </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col">
  <header class="w-full bg-brand text-white shadow">
    <nav class="mx-auto flex w-full max-w-6xl items-center gap-4 px-4 py-3">
      <a href="index.php?controller=Home&action=index" class="flex items-center gap-3">
        <div class="grid h-10 w-10 place-items-center rounded-xl bg-white/20 shadow-soft">
          <span class="text-xl font-semibold">DA</span>
        </div>
        <span class="text-lg font-semibold tracking-tight">DonAppetit</span>
      </a>

      <div class="ml-auto flex items-center gap-4">
        <div class="relative hidden md:block">
          <button id="navDropdownToggle"
                  class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-3 py-2 text-sm font-medium hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
            Menú
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.585l3.71-3.354a.75.75 0 0 1 1 1.12l-4.25 3.84a.75.75 0 0 1-1 0l-4.25-3.84a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
            </svg>
          </button>
          <div id="navDropdownMenu"
               class="absolute right-0 mt-2 w-52 overflow-hidden rounded-lg bg-white text-slate-800 shadow-lg ring-1 ring-black/5 hidden">
            <?php foreach ($menuItems as $item): ?>
              <a href="<?php echo htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8'); ?>"
                 class="block px-4 py-2 text-sm hover:bg-slate-100">
                <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <button id="btnMenu"
                class="inline-flex items-center justify-center rounded-lg bg-white/10 px-3 py-2 text-sm font-medium hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 md:hidden"
                aria-label="Abrir menú móvil" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
          </svg>
        </button>

        <div class="flex items-center gap-3">
          <div class="hidden text-right leading-tight sm:block">
            <span class="block text-xs opacity-70">Bienvenido</span>
            <span class="block text-sm font-semibold">
              <?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?>
            </span>
          </div>
          <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white/20 text-base font-semibold">
            <?php if ($userAvatar): ?>
              <img src="<?php echo htmlspecialchars($userAvatar, ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar de <?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?>" class="h-full w-full object-cover" />
            <?php else: ?>
              <span><?php echo htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>

    <div id="mobileMenu" class="md:hidden hidden border-t border-white/20 bg-brand/95">
      <?php foreach ($menuItems as $item): ?>
        <a href="<?php echo htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8'); ?>"
           class="block px-4 py-2 text-sm text-white hover:bg-white/15">
          <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </header>

  <main class="mx-auto w-full max-w-6xl flex-1 px-4">