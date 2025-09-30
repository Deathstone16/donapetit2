(function () {
  const mobileToggle = document.getElementById('btnMenu');
  const mobileMenu = document.getElementById('mobileMenu');
  const dropdownToggle = document.getElementById('navDropdownToggle');
  const dropdownMenu = document.getElementById('navDropdownMenu');

  const closeDropdown = () => {
    if (dropdownMenu) dropdownMenu.classList.add('hidden');
    if (dropdownToggle) dropdownToggle.setAttribute('aria-expanded', 'false');
  };

  const closeMobileMenu = () => {
    if (mobileMenu) mobileMenu.classList.add('hidden');
    if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
  };

  if (dropdownToggle && dropdownMenu) {
    dropdownToggle.addEventListener('click', (event) => {
      event.stopPropagation();
      const isOpen = !dropdownMenu.classList.contains('hidden');
      if (isOpen) {
        closeDropdown();
      } else {
        dropdownMenu.classList.remove('hidden');
        dropdownToggle.setAttribute('aria-expanded', 'true');
      }
    });
  }

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', (event) => {
      event.stopPropagation();
      const isOpen = !mobileMenu.classList.contains('hidden');
      if (isOpen) {
        closeMobileMenu();
      } else {
        mobileMenu.classList.remove('hidden');
        mobileToggle.setAttribute('aria-expanded', 'true');
      }
    });
  }

  document.addEventListener('click', (event) => {
    if (dropdownMenu && !dropdownMenu.contains(event.target) && event.target !== dropdownToggle) {
      closeDropdown();
    }
    if (mobileMenu && !mobileMenu.contains(event.target) && event.target !== mobileToggle) {
      closeMobileMenu();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeDropdown();
      closeMobileMenu();
    }
  });

  const yearEl = document.getElementById('year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }
})();