/*document.addEventListener('DOMContentLoaded', () => {
  const addToCartBtn = document.querySelector('.add-to-cart-btn');
  const quantityInput = document.querySelector('.quantity-input');

  // ========== ADD TO CART LOGIC ==========
  if (addToCartBtn && quantityInput) {
    addToCartBtn.addEventListener('click', () => {
      const menu_id = addToCartBtn.getAttribute('data-id');
      const quantity = quantityInput.value;

   const priceText = document.querySelector('.menu-price').textContent || '';
  const price = parseFloat(priceText.replace(/[^\d.]/g, '')); // Better parsing

      if (!menu_id || !quantity || !price) {
        alert('Missing data!');
        return;
      }

      addToCart(menu_id, quantity, price);
    });
  }

  // ========== VIEW CART LOGIC ==========
  const cartItemsDiv = document.getElementById('cart-items');
  const totalDiv = document.getElementById('cart-total');

  if (cartItemsDiv && totalDiv) {
    fetch('/TKCafe/Controller/cartController.php?action=list')
      .then(response => response.json())
      .then(data => {
        if (!data || data.length === 0) {
          cartItemsDiv.innerHTML = '<p>Your cart is empty.</p>';
          totalDiv.textContent = '';
          return;
        }

        let total = 0;
        cartItemsDiv.innerHTML = '';
        data.forEach(item => {
          const itemDiv = document.createElement('div');
          itemDiv.classList.add('cart-item');

          const subtotal = item.price * item.quantity;
          total += subtotal;

          itemDiv.innerHTML = `
            <p><strong>Item ID:</strong> ${item.menu_id}</p>
            <p><strong>Quantity:</strong> ${item.quantity}</p>
            <p><strong>Price:</strong> RM ${parseFloat(item.price).toFixed(2)}</p>
            <p><strong>Subtotal:</strong> RM ${subtotal.toFixed(2)}</p>
          `;

          cartItemsDiv.appendChild(itemDiv);
        });

        totalDiv.textContent = `Total: RM ${total.toFixed(2)}`;
      })
      .catch(error => {
        cartItemsDiv.innerHTML = '<p>Error loading cart.</p>';
        console.error('Error:', error);
      });
  }
});

function addToCart(menu_id, quantity, price) {
  fetch('/TKCafe/Controller/cartController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=add&menu_id=${encodeURIComponent(menu_id)}&quantity=${encodeURIComponent(quantity)}&price=${encodeURIComponent(price)}`
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Added to cart!');
      } else {
        alert('Failed to add to cart.');
      }
    })
    .catch(() => alert('Error adding to cart.'));
}


/*document.addEventListener("DOMContentLoaded", () => {
  const addToCartBtn = document.querySelector(".add-to-cart-btn");

  addToCartBtn.addEventListener("click", () => {
    const itemId = addToCartBtn.getAttribute("data-id");
    const quantity = document.querySelector(".quantity-input").value;

    fetch("/TKCafe/Controllers/cart_controller.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        action: "add",
        id: itemId,
        quantity: quantity
      })
    })
      .then(response => response.json())
      .then(data => {
        alert(data.message || "Added to cart!");
      })
      .catch(err => console.error("Cart Error:", err));
  });
});*/

// cart.js - Handles ALL cart-related functionality
document.addEventListener('DOMContentLoaded', initCart);

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
});