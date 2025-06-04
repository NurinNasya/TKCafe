
// cart.js - Handles ALL cart-related functionality
/*document.addEventListener('DOMContentLoaded', initCart); -- original

function initCart() {
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
}

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

function handleAddToCart(button) {
  const container = button.closest('.menu-details-container');
  const priceText = container.querySelector('.menu-price').textContent;
  
  const cartData = {
    menu_id: button.dataset.id,
    quantity: container.querySelector('.quantity-input').value,
    price: parseFloat(priceText.replace(/[^\d.]/g, ''))
  };

  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=add&menu_id=${cartData.menu_id}&quantity=${cartData.quantity}&price=${cartData.price}`
  })
  .then(response => response.json())
  .then(data => {
    alert(data.success ? 'Added to cart!' : 'Error: ' + (data.error || 'Unknown error'));
    refreshCartDisplay();
  })
  .catch(err => {
    console.error('Cart error:', err);
    alert('Failed to add item');
  });
}

function refreshCartDisplay() {
  fetch('/TKCafe/Controller/cartController.php?action=list')
    .then(response => response.json())
    .then(renderCart)
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
    html += `
      <div class="cart-item">
        <p><strong>${item.name || 'Item #'+item.menu_id}</strong></p>
        <p>Qty: ${item.quantity} × RM ${item.price.toFixed(2)}</p>
        <p>Subtotal: RM ${subtotal.toFixed(2)}</p>
      </div>
    `;
  });

  container.innerHTML = html;
  document.getElementById('cart-total').textContent = `Total: RM ${total.toFixed(2)}`;
}

// Add to cart.js
document.querySelectorAll('.remove-item-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    const itemId = this.dataset.id;
    // Add AJAX call to remove item
  });
});

// Add this to your cart.js file
document.addEventListener('DOMContentLoaded', function() {
  // Handle quantity changes
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const itemId = this.dataset.id;
      const isMinus = this.classList.contains('minus');
      const quantityElement = this.parentElement.querySelector('.quantity-value');
      let quantity = parseInt(quantityElement.textContent);

      if (isMinus) {
        if (quantity === 1) {
          // Show delete confirmation
          if (confirm('Do you want to delete this item?')) {
            removeItem(itemId);
          }
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
      const itemId = this.dataset.id;
      if (confirm('Are you sure you want to remove this item?')) {
        removeItem(itemId);
      }
    });
  });
});

function updateQuantity(itemId, newQuantity) {
  console.log('Attempting to update item:', itemId, 'to quantity:', newQuantity); // Debug log
  
  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=update&id=${itemId}&quantity=${newQuantity}`
  })
  .then(response => {
    console.log('Raw response:', response); // Debug log
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log('Response data:', data); // Debug log
    if (data.success) {
      location.reload();
    } else {
      alert('Failed to update quantity: ' + (data.error || 'Unknown error'));
    }
  })
  .catch(err => {
    console.error('Full error:', err); // Debug log
    alert('Error updating quantity. Check console for details.');
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
      location.reload(); // Refresh to show updated cart
    } else {
      alert('Failed to remove item');
    }
  })
  .catch(err => {
    console.error('Error:', err);
    alert('Error removing item');
  });
}

// Handle dine-in/takeaway selection
document.querySelectorAll('.order-type-btn').forEach(button => {
  button.addEventListener('click', function() {
    // Remove active class from all buttons
    document.querySelectorAll('.order-type-btn').forEach(btn => {
      btn.classList.remove('active');
    });
    
    // Add active class to clicked button
    this.classList.add('active');
    
    // You can store the selection in a hidden field or variable
    const orderType = this.dataset.type;
    // You might want to use this later when submitting the order
  });
}); original */ 

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

  // Handle dine-in/takeaway selection
  document.querySelectorAll('.order-type-btn').forEach(button => {
    button.addEventListener('click', function() {
      // Remove active class from all buttons
      document.querySelectorAll('.order-type-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      
      // Add active class to clicked button
      this.classList.add('active');
      
      // Store the selection
      const orderType = this.dataset.type;
      // Can be used later when submitting the order
    });
  });
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
  const priceText = container.querySelector('.menu-price').textContent;
  
  const cartData = {
    menu_id: button.dataset.id,
    quantity: container.querySelector('.quantity-input').value,
    price: parseFloat(priceText.replace(/[^\d.]/g, ''))
  };

  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=add&menu_id=${cartData.menu_id}&quantity=${cartData.quantity}&price=${cartData.price}`
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
}

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
    html += `
      <div class="cart-item">
        <p><strong>${item.name || 'Item #'+item.menu_id}</strong></p>
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