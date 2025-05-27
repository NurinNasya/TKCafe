/*document.addEventListener('DOMContentLoaded', function () {
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

 document.querySelectorAll('.select-btn').forEach(button => {
  button.addEventListener('click', async (e) => {
    e.preventDefault();
    const id = button.getAttribute('data-id');
    const popup = document.getElementById('popup');

    // Load the full detailed view via AJAX
    try {
      const response = await fetch(`/TKCafe/Controller/menuController.php?id=${id}`);
      const html = await response.text();
      
     popup.innerHTML = html;
    popup.style.display = 'block';

    // Re-bind everything inside the popup
    bindQuantityControls();
    bindAddToCart();
    bindClosePopup();


      // Rebind quantity controls (since they're newly added)
      bindQuantityControls();
    } catch (err) {
      console.error('Error:', err);
      alert('Failed to load item details.');
    }
  });
});

// Helper function to rebind quantity buttons
function bindQuantityControls() {
  document.querySelectorAll('.quantity-btn.plus').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.quantity-controls').querySelector('.quantity-input');
      input.value = parseInt(input.value) + 1;
    });
  });

  document.querySelectorAll('.quantity-btn.minus').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.quantity-controls').querySelector('.quantity-input');
      if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    });
  });
}

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

  document.getElementById('close-popup').addEventListener('click', () => {
  document.getElementById('popup').style.display = 'none';
});

// Track current category
let currentCategory = 'all';

// Set active category when buttons are clicked
document.querySelectorAll('.category').forEach(button => {
  button.addEventListener('click', function() {
    // Remove active class from all buttons
    document.querySelectorAll('.category').forEach(btn => {
      btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    this.classList.add('active');
    
    // Store the selected category
    currentCategory = this.getAttribute('data-category');
    
    // Update URL without reload (optional)
    history.pushState(null, null, `?category=${currentCategory}`);
  });
});

// Initialize from URL on page load
window.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const categoryParam = urlParams.get('category');
  
  if (categoryParam) {
    currentCategory = categoryParam;
    const activeBtn = document.querySelector(`.category[data-category="${currentCategory}"]`);
    if (activeBtn) {
      document.querySelectorAll('.category').forEach(btn => btn.classList.remove('active'));
      activeBtn.classList.add('active');
    }
  }
});

function bindQuantityControls() {
  document.querySelectorAll('.quantity-btn.plus').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.quantity-controls').querySelector('.quantity-input');
      input.value = parseInt(input.value) + 1;
    });
  });

  document.querySelectorAll('.quantity-btn.minus').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.quantity-controls').querySelector('.quantity-input');
      if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    });
  });
}

function bindAddToCart() {
  const btn = document.querySelector('.add-to-cart-btn');
  if (btn) {
    btn.addEventListener('click', () => {
      const itemId = btn.getAttribute('data-id');
      const quantity = document.querySelector('.quantity-input').value;
      alert(`Add to cart\nItem ID: ${itemId}\nQuantity: ${quantity}`);
    });
  }
}

function bindClosePopup() {
  const btn = document.querySelector('.back-button');
  if (btn) {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      document.getElementById('popup').style.display = 'none';
    });
  }
}*/

// menu.js - Handles ONLY menu/popup functionality
document.addEventListener('DOMContentLoaded', function() {
  // Category filtering
  const categories = document.querySelectorAll('.category');
  const items = document.querySelectorAll('.menu-item');

  categories.forEach(button => {
    button.addEventListener('click', function() {
      categories.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      const selectedCategory = this.getAttribute('data-category');

      items.forEach(item => {
        item.style.display = 
          (selectedCategory === 'all' || item.getAttribute('data-category') === selectedCategory) 
          ? 'flex' : 'none';
      });
    });
  });

  // Default to 'all' category
  document.querySelector('[data-category="all"]')?.click();

  // Popup handling
  document.querySelectorAll('.select-btn').forEach(button => {
    button.addEventListener('click', async (e) => {
      e.preventDefault();
      const popup = document.getElementById('popup');
      
      try {
        const response = await fetch(`/TKCafe/Controller/menuController.php?id=${button.dataset.id}`);
        popup.innerHTML = await response.text();
        popup.style.display = 'block';
        
        // Notify other scripts that popup loaded
        document.dispatchEvent(new CustomEvent('popupContentLoaded'));
      } catch (err) {
        console.error('Popup loading failed:', err);
        alert('Failed to load details');
      }
    });
  });
});
