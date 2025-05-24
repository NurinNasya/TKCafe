document.addEventListener('DOMContentLoaded', function () {
  const categories = document.querySelectorAll('.category');
  const items = document.querySelectorAll('.menu-item');

  categories.forEach(button => {
    button.addEventListener('click', function () {
      categories.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');

      const selectedCategory = this.getAttribute('data-category');

      items.forEach(item => {
        const itemCategory = item.getAttribute('data-category');

        // ✅ Show all items if 'all' is selected
        if (selectedCategory === 'all' || itemCategory === selectedCategory) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  // ✅ Default to 'all' category on page load
  const defaultButton = document.querySelector('[data-category="all"]');
  if (defaultButton) {
    defaultButton.click();
  }
});

 // Move your select-btn event listeners here:
  document.querySelectorAll('.select-btn').forEach(button => {
    button.addEventListener('click', () => {
      const id = button.getAttribute('data-id');
      window.location.href = `/TKCafe/Controller/menuController.php?id=${id}`;
    });
  });

  //add qty
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.quantity-btn.plus').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = btn.closest('.quantity-controls').querySelector('.quantity-input');
        input.value = parseInt(input.value) + 1;
      });
    });

    document.querySelectorAll('.quantity-btn.minus').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = btn.closest('.quantity-controls').querySelector('.quantity-input');
        if (parseInt(input.value) > 1) {
          input.value = parseInt(input.value) - 1;
        }
      });
    });

    // Optional: Add to cart functionality
    document.querySelector('.add-to-cart-btn')?.addEventListener('click', () => {
      const itemId = event.target.getAttribute('data-id');
      const quantity = document.querySelector('.quantity-input').value;
      alert(`Item ID: ${itemId}\nQuantity: ${quantity}\n`);
    });
  });
