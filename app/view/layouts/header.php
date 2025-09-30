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
            brand: { DEFAULT: '#6B9F90' }
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
<body class="bg-zinc-100 text-zinc-800 min-h-screen">
  <header class="w-full">
    <nav class="mx-auto max-w-6xl flex items-center justify-between p-4">
      <div class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-xl bg-white shadow-soft grid place-items-center">
          <span class="text-xl font-semibold">DA</span>
        </div>
        <span class="font-semibold">DonAppetit</span>
      </div>

      <button id="btnMenu" class="p-2 rounded-lg hover:bg-white hover:shadow-soft md:hidden" aria-label="Abrir menu">
        <div class="w-6 h-[2px] bg-zinc-800 mb-1"></div>
        <div class="w-6 h-[2px] bg-zinc-800 mb-1"></div>
        <div class="w-6 h-[2px] bg-zinc-800"></div>
      </button>

      <ul id="menu" class="hidden md:flex items-center gap-6">
        <li><a href="#" class="hover:underline">Inicio</a></li>
        <li><a href="#" class="hover:underline">Productos</a></li>
        <li><a href="#" class="hover:underline">Estadisticas</a></li>
        <li><a href="#" class="hover:underline">Salir</a></li>
      </ul>
    </nav>
  </header>

  <main class="mx-auto max-w-6xl px-4">