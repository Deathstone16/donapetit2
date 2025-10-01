(function () {
      // Obtiene referencias a los elementos del formulario y campos relevantes
      const form           = document.getElementById('loadProductForm');
      const errorsBox      = document.getElementById('errors');

      const selectProd     = document.getElementById('tipoProducto');
      const otroBtn        = document.getElementById('otroBtn');
      const otroInput      = document.getElementById('otroProducto');
      const hiddenNombre   = document.getElementById('productoNombre');

      const unidadInput    = document.getElementById('unidad');
      const cantidadInput  = document.getElementById('cantidad');
      const fechaInput     = document.getElementById('vencimiento');

      let customMode = false; // false = usando el dropdown, true = usando el input personalizado

      // Alterna entre el select y el input de "Otro producto"
      otroBtn.addEventListener('click', function () {
        customMode = !customMode;

        if (customMode) {
          // Oculta el select y muestra el input de texto
          selectProd.classList.add('hidden');
          otroInput.classList.remove('hidden');
          otroInput.focus();
          otroBtn.textContent = 'Usar lista';
        } else {
          // Muestra el select, oculta el input y lo limpia
          otroInput.classList.add('hidden');
          selectProd.classList.remove('hidden');
          otroInput.value = '';
          otroBtn.textContent = 'Otro producto';
        }
      });

      // Solo permite números enteros positivos en "Cantidad"
      cantidadInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D+/g, '');
        if (this.value !== '' && parseInt(this.value, 10) <= 0) this.value = '';
      });

      // Validación al enviar el formulario
      form.addEventListener('submit', function (e) {
        const errs = [];

        let producto = '';
        if (customMode) {
          // Si está en modo personalizado, toma el valor del input de texto
          producto = (otroInput.value || '').trim();
          if (producto === '') errs.push('Debes escribir el nombre del producto.');
        } else {
          // Si está usando el select, toma el valor seleccionado
          producto = selectProd.value;
          if (!producto) errs.push('Debes seleccionar un tipo de producto.');
        }
        hiddenNombre.value = producto;

        // Valida la unidad/presentación
        const unidad = (unidadInput.value || '').trim();
        if (!unidad) errs.push('La unidad o presentacion es obligatoria.');

        // Valida la cantidad
        const cantidad = (cantidadInput.value || '').trim();
        if (!cantidad) errs.push('La cantidad disponible es obligatoria.');
        else if (!/^[1-9]\d*$/.test(cantidad)) errs.push('La cantidad debe ser un entero positivo.');

        // Valida la fecha de vencimiento
        if (!fechaInput.value) errs.push('La fecha de vencimiento es obligatoria.');

        // Si hay errores, los muestra y evita el envío del formulario
        if (errs.length) {
          e.preventDefault();
          errorsBox.innerHTML = '<ul class="list-disc list-inside">' + errs.map(x => `<li>${x}</li>`).join('') + '</ul>';
          errorsBox.classList.remove('hidden');
          errorsBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
          errorsBox.classList.add('hidden');
        }
      });
    })();