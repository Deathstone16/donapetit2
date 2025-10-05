// Control dinámico del valor del slider
const radio = document.getElementById('radio');
const radioValue = document.getElementById('radio-value');

radio.addEventListener('input', () => {
  radioValue.textContent = radio.value;
});
