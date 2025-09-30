(function () {
      const form           = document.getElementById('loadProductForm');
      const errorsBox      = document.getElementById('errors');

      const selectProd     = document.getElementById('tipoProducto');
      const otroBtn        = document.getElementById('otroBtn');
      const otroInput      = document.getElementById('otroProducto');
      const hiddenNombre   = document.getElementById('productoNombre');

      const unidadInput    = document.getElementById('unidad');
      const cantidadInput  = document.getElementById('cantidad');
      const fechaInput     = document.getElementById('vencimiento');

      let customMode = false; // false = using dropdown, true = using custom input

      // Toggle: "Otro producto" replaces dropdown with a text input
      otroBtn.addEventListener('click', function () {
        customMode = !customMode;

        if (customMode) {
          // Hide select, show input
          selectProd.classList.add('hidden');
          otroInput.classList.remove('hidden');
          otroInput.focus();
          otroBtn.textContent = 'Usar lista';
        } else {
          // Show select, hide input and clear it
          otroInput.classList.add('hidden');
          selectProd.classList.remove('hidden');
          otroInput.value = '';
          otroBtn.textContent = 'Otro producto';
        }
      });

      // Only allow positive integers in "Cantidad"
      cantidadInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D+/g, '');
        if (this.value !== '' && parseInt(this.value, 10) <= 0) this.value = '';
      });

      // Validate on submit
      form.addEventListener('submit', function (e) {
        const errs = [];

        let producto = '';
        if (customMode) {
          producto = (otroInput.value || '').trim();
          if (producto === '') errs.push('Debes escribir el nombre del producto.');
        } else {
          producto = selectProd.value;
          if (!producto) errs.push('Debes seleccionar un tipo de producto.');
        }
        hiddenNombre.value = producto;

        const unidad = (unidadInput.value || '').trim();
        if (!unidad) errs.push('La unidad o presentacion es obligatoria.');

        const cantidad = (cantidadInput.value || '').trim();
        if (!cantidad) errs.push('La cantidad disponible es obligatoria.');
        else if (!/^[1-9]\d*$/.test(cantidad)) errs.push('La cantidad debe ser un entero positivo.');

        if (!fechaInput.value) errs.push('La fecha de vencimiento es obligatoria.');

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