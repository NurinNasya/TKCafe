// cart.js - Handles ALL cart-related functionality
document.addEventListener('DOMContentLoaded', function() {
  // Modal variables
  let itemToDelete = null;
  const deleteModal = document.getElementById('deleteModal');
  const confirmBtn = document.querySelector('.confirm-btn');
  const cancelBtn = document.querySelector('.cancel-btn');

  // Initialize cart badge on load
  updateCartBadge();

  // 1. Setup event delegation for cart buttons
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-to-cart-btn')) {
      handleAddToCart(e.target);
    }
  });

  // 2. Rebind quantity controls when popup loads
  document.addEventListener('popupContentLoaded', function() {
    bindQuantityControls();
  });

  // 3. Load initial cart view
  refreshCartDisplay();

  // Initialize modal handlers
  if (confirmBtn && cancelBtn) {
    confirmBtn.addEventListener('click', function() {
      if (itemToDelete) {
        removeItem(itemToDelete);
      }
      deleteModal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', function() {
      itemToDelete = null;
      deleteModal.style.display = 'none';
    });
  }

  // Close modal when clicking outside
  if (deleteModal) {
    deleteModal.addEventListener('click', function(e) {
      if (e.target === deleteModal) {
        itemToDelete = null;
        deleteModal.style.display = 'none';
      }
    });
  }

  // Handle quantity changes
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const itemId = this.dataset.id;
      const isMinus = this.classList.contains('minus');
      const quantityElement = this.parentElement.querySelector('.quantity-value');
      let quantity = parseInt(quantityElement.textContent);

      if (isMinus) {
        if (quantity === 1) {
          // Show delete confirmation modal
          itemToDelete = itemId;
          deleteModal.style.display = 'flex';
        } else {
          updateQuantity(itemId, quantity - 1);
        }
      } else {
        updateQuantity(itemId, quantity + 1);
      }
    });
  });

  // Handle remove item button
  document.querySelectorAll('.remove-item-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      itemToDelete = this.dataset.id;
      deleteModal.style.display = 'flex';
    });
  });
});

// Add this to cart.js (place it with the other event listeners)
document.querySelector('.checkout-btn')?.addEventListener('click', async function() {
    try {
        const response = await fetch('/TKCafe/Controller/orderController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert('Order failed: ' + (data.error || 'Unknown error'));
        }
    } catch (err) {
        console.error('Checkout error:', err);
        alert('Failed to process order');
    }
});

// ========== CART FUNCTIONS ==========
function bindQuantityControls() {
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const input = this.closest('.quantity-controls').querySelector('.quantity-input');
      input.value = this.classList.contains('plus') 
        ? parseInt(input.value) + 1 
        : Math.max(1, parseInt(input.value) - 1);
    });
  });
}

// NEW: Update cart badge (red dot)
function updateCartBadge() {
  fetch('/TKCafe/Controller/cartController.php?action=count')
    .then(response => response.json())
    .then(data => {
      const badge = document.querySelector('.cart-badge');
      if (badge) {
        badge.style.display = data.count > 0 ? 'block' : 'none';
        badge.textContent = data.count > 0 ? data.count : '';
      }
    })
    .catch(err => console.error('Badge update error:', err));
}

function handleAddToCart(button) {
  const container = button.closest('.menu-details-container');
  
  // Get and parse the price text safely
  const priceText = container.querySelector('.menu-price').textContent;
  const priceValue = priceText.split('RM')[1]?.trim() || '0'; // Extract numeric part after RM
  const price = parseFloat(priceValue) || 0;
  
  // Check if this is a combo
  const isCombo = container.querySelector('.combo-customization') !== null;
  
  const cartData = {
    menu_id: button.dataset.id,
    quantity: parseInt(container.querySelector('.quantity-input').value) || 1,
    price: price
  };

  // Handle drink selection for combos
  if (isCombo) {
    const selectedDrink = container.querySelector('input[name="drink"]:checked');
    if (!selectedDrink) {
      alert('Please select a drink option');
      return;
    }
    cartData.customizations = {
      drink: selectedDrink.value
    };
  }

  // Prepare form data
  const formData = new URLSearchParams();
  formData.append('action', 'add');
  formData.append('menu_id', cartData.menu_id);
  formData.append('quantity', cartData.quantity);
  formData.append('price', cartData.price);
  
  if (isCombo) {
    formData.append('customizations', JSON.stringify(cartData.customizations));
  }

  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      updateCartBadge();
      alert('Added to cart!');
      refreshCartDisplay();
    } else {
      alert('Error: ' + (data.error || 'Failed to add item'));
    }
  })
  .catch(err => {
    console.error('Cart error:', err);
    alert('Failed to add item. Please check console for details.');
  });
}

/*function handleAddToCart(button) {
  const container = button.closest('.menu-details-container');
  const priceText = container.querySelector('.menu-price').textContent;

   // Check if this is a combo (has customization section)
  const isCombo = container.querySelector('.combo-customization') !== null;
  
  const cartData = {
    menu_id: button.dataset.id,
    quantity: container.querySelector('.quantity-input').value,
    price: parseFloat(priceText.replace(/[^\d.]/g, ''))
  };

   // Add customizations if this is a combo
  if (isCombo) {
    cartData.customizations = {
      drink: container.querySelector('.drink-select').value,
    };
  }

  // Prepare form data
  const formData = new URLSearchParams();
  formData.append('action', 'add');
  formData.append('menu_id', cartData.menu_id);
  formData.append('quantity', cartData.quantity);
  formData.append('price', cartData.price);
  
  // Add customizations if they exist
  if (isCombo) {
    formData.append('customizations', JSON.stringify(cartData.customizations));
  }

  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      updateCartBadge(); // Update the badge
      alert('Added to cart!');
      refreshCartDisplay();
    } else {
      alert('Error: ' + (data.error || 'Failed to add item'));
    }
  })
  .catch(err => {
    console.error('Cart error:', err);
    alert('Failed to add item');
  });
}*/

function refreshCartDisplay() {
  fetch('/TKCafe/Controller/cartController.php?action=list')
    .then(response => response.json())
    .then(data => {
      renderCart(data.items);
      updateCartBadge(); // Update the badge
    })
    .catch(err => {
      console.error('Cart load failed:', err);
      document.getElementById('cart-items').innerHTML = '<p>Error loading cart</p>';
    });
}

function renderCart(items) {
  const container = document.getElementById('cart-items');
  if (!items || items.length === 0) {
    container.innerHTML = '<p>Your cart is empty</p>';
    return;
  }

  let html = '';
  let total = 0;
  
items.forEach(item => {
    const subtotal = item.price * item.quantity;
    total += subtotal;
    
    // Parse customizations if they exist
    const customizations = item.customizations ? JSON.parse(item.customizations) : null;
    
    html += `
      <div class="cart-item">
        <p><strong>${item.name || 'Item #'+item.menu_id}</strong></p>
        ${customizations ? `
          <div class="customization-details">
            <p>Drink: ${customizations.drink}</p>
          </div>
        ` : ''}
        <p>Qty: ${item.quantity} × RM ${item.price.toFixed(2)}</p>
        <p>Subtotal: RM ${subtotal.toFixed(2)}</p>
      </div>
    `;
  });

  container.innerHTML = html;
  document.getElementById('cart-total').textContent = `Total: RM ${total.toFixed(2)}`;
}


function updateQuantity(itemId, newQuantity) {
  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=update&id=${itemId}&quantity=${newQuantity}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      updateCartBadge(); // Update the badge
      location.reload();
    } else {
      alert('Failed to update quantity: ' + (data.error || 'Unknown error'));
    }
  })
  .catch(err => {
    console.error('Update error:', err);
    alert('Error updating quantity');
  });
}

function removeItem(itemId) {
  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=remove&id=${itemId}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      updateCartBadge(); // Update the badge
      location.reload();
    } else {
      alert('Failed to remove item');
    }
  })
  .catch(err => {
    console.error('Remove error:', err);
    alert('Error removing item');
  });
}

