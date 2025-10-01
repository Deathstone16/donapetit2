<?php
// Obtiene el nombre de usuario desde la variable $userName, o desde la sesión si no está definida
$userName = $userName ?? ($_SESSION['user']['name'] ?? 'Usuario');

// Obtiene el avatar del usuario si está disponible
$userAvatar = $userAvatar ?? ($_SESSION['user']['avatar'] ?? null);

// Define los ítems del menú de navegación, usando los valores por defecto si no se pasan desde el controlador
$menuItems = $menuItems ?? [
    ['label' => 'Inicio',      'url' => 'index.php?controller=Home&action=index'],
    ['label' => 'Productos',   'url' => 'index.php?controller=Producto&action=index'],
    ['label' => 'Nuevo producto', 'url' => 'index.php?controller=Producto&action=create'],
    ['label' => 'Solicitudes', 'url' => '#'],
    ['label' => 'Salir',       'url' => '#'],
];

// Obtiene la inicial del nombre de usuario para mostrar en el avatar si no hay imagen
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
                    colors: { brand: { DEFAULT: '#0f1629' } },
                    boxShadow: { soft: '0 8px 30px rgba(0,0,0,.08)' }
                }
            }
        }
    </script>
    <style>
        * { transition: all .15s ease-in-out }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col">
    <!-- Encabezado principal con barra de navegación -->
    <header class="w-full bg-brand text-white shadow">
        <nav class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-3">
            <!-- IZQUIERDA: Logo y nombre -->
            <a href="index.php?controller=Home&action=index" class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-white/20 shadow-soft">
                    <span class="text-xl font-semibold">DA</span>
                </div>
                <span class="text-lg font-semibold tracking-tight">DonAppetit</span>
            </a>

            <!-- DERECHA: Menú y usuario -->
            <div class="flex items-center gap-4">
                <!-- Menú desplegable para escritorio -->
                <div class="relative hidden md:block">
                    <button id="navDropdownToggle"
                        class="inline-flex items-center justify-center rounded-lg bg-white/10 p-2 hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60"
                        aria-label="Abrir menú desplegable" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        </svg>
                        <span class="sr-only">Abrir menú</span>
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

                <!-- Botón menú móvil -->
                <button id="btnMenu"
                    class="inline-flex items-center justify-center rounded-lg bg-white/10 px-3 py-2 text-sm font-medium hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 md:hidden"
                    aria-label="Abrir menu móvil" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                </button>

                <!-- Usuario -->
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

        <!-- Menú móvil (solo visible en pantallas pequeñas) -->
        <div id="mobileMenu" class="md:hidden hidden border-t border-white/20 bg-brand/95">
            <?php foreach ($menuItems as $item): ?>
                <a href="<?php echo htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8'); ?>"
                    class="block px-4 py-2 text-sm text-white hover:bg-white/15">
                    <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </header>

    <!-- Contenedor principal para el contenido de la página -->
    <main class="mx-auto w-full max-w-6xl flex-1 px-4">