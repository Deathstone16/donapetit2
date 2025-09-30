<div class="py-6">
  <div class="mb-6 flex items-center gap-3">
    <button type="button" class="p-2 rounded hover:bg-zinc-100 border border-zinc-200" onclick="history.back()" aria-label="Volver">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <h1 class="text-xl font-semibold">Cargar producto</h1>
  </div>

  <div class="bg-white border rounded-xl shadow-sm p-4 md:p-6">
    <div id="errors" class="hidden mb-4 rounded-lg border border-red-300 bg-red-50 text-red-800 text-sm p-3"></div>

    <form id="loadProductForm"
          action="index.php?controller=Producto&action=store"
          method="post"
          novalidate
          class="space-y-5">

      <div>
        <label class="block text-sm font-medium mb-1">Tipo de producto <span class="text-red-600">*</span></label>
        <div class="flex flex-col sm:flex-row gap-3">
          <select id="tipoProducto"
                  name="tipoProducto"
                  class="flex-1 rounded-lg border-zinc-300 focus:border-emerald-500 focus:ring-emerald-500"
                  aria-label="Seleccionar tipo de producto">
            <option value="">Seleccionar tipo de producto</option>
            <option value="Arroz">Arroz</option>
            <option value="Fideos">Fideos</option>
            <option value="Leche">Leche</option>
            <option value="Aceite">Aceite</option>
            <option value="Harina">Harina</option>
          </select>

          <input id="otroProducto"
                 name="otroProducto"
                 type="text"
                 class="hidden flex-1 rounded-lg border-zinc-300 focus:border-emerald-500 focus:ring-emerald-500"
                 placeholder="Escribir producto" />

          <button id="otroBtn" type="button"
                  class="shrink-0 inline-flex items-center justify-center rounded-lg border px-3 py-2 text-sm font-medium border-zinc-300 text-zinc-700 hover:bg-zinc-50">
            Otro producto
          </button>
        </div>
      </div>

      <div>
        <label for="unidad" class="block text-sm font-medium mb-1">
          Unidad o presentacion <span class="text-red-600">*</span>
        </label>
        <input id="unidad" name="unidad" type="text"
               class="w-full rounded-lg border-zinc-300 focus:border-emerald-500 focus:ring-emerald-500"
               placeholder="Ej.: kg, unidades, paquetes" />
      </div>

      <div>
        <label for="cantidad" class="block text-sm font-medium mb-1">
          Cantidad disponible <span class="text-red-600">*</span>
        </label>
        <input id="cantidad" name="cantidad" type="number" inputmode="numeric" min="1" step="1"
               class="w-full rounded-lg border-zinc-300 focus:border-emerald-500 focus:ring-emerald-500"
               placeholder="Ej.: 10" />
        <p class="text-xs text-zinc-500 mt-1">Solo enteros positivos.</p>
      </div>

      <div>
        <label for="vencimiento" class="block text-sm font-medium mb-1">
          Fecha de vencimiento <span class="text-red-600">*</span>
        </label>
        <input id="vencimiento" name="vencimiento" type="date"
               class="w-full rounded-lg border-zinc-300 focus:border-emerald-500 focus:ring-emerald-500" />
      </div>

      <div>
        <label for="comentarios" class="block text-sm font-medium mb-1">Comentarios (opcional)</label>
        <textarea id="comentarios" name="comentarios" rows="4"
                  class="w-full rounded-lg border-zinc-300 focus:border-emerald-500 focus:ring-emerald-500"
                  placeholder="Informacion adicional, por ejemplo marca o empaque"></textarea>
      </div>

      <input type="hidden" id="productoNombre" name="nombre" value="" />

      <div class="pt-2 flex flex-col sm:flex-row gap-3">
        <button id="guardarBtn" type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 font-medium">
          Guardar producto
        </button>

        <button type="button"
                onclick="history.back()"
                class="inline-flex items-center justify-center rounded-lg bg-zinc-200 hover:bg-zinc-300 text-zinc-800 px-4 py-2 font-medium">
          Cancelar
        </button>
      </div>
    </form>
  </div>
</div>

<script src="/donapetit2/public/assets/js/product_load.js"></script>