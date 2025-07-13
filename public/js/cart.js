// cart.js - Handles ALL cart-related functionality

if (window.cartInitialized) {
    console.warn('Cart system already initialized!');
} else {
    window.cartInitialized = true;

    document.addEventListener('DOMContentLoaded', function() {
        // System state
        let itemToDelete = null;
        const deleteModal = document.getElementById('deleteModal');

        // Initialize cart
        updateCartBadge();
        refreshCartDisplay();

        // SINGLE event delegation for all cart actions
        document.addEventListener('click', function(e) {
            const target = e.target;
            // 1. Place Order Button (NEW - added first)
            if (target.closest('.checkout-btn')) {
                e.preventDefault();
                placeOrder();
            }
            // QUANTITY control ONLY for menu_popup.php
              document.addEventListener('click', function(e) {
                  const target = e.target;
                  const popup = document.querySelector('.menu-details-container');
                  if (popup && target.closest('.quantity-btn')) {
                      const btn = target.closest('.quantity-btn');
                      const input = popup.querySelector('.quantity-input');
                      let quantity = parseInt(input.value);

                      if (btn.classList.contains('minus')) {
                          if (quantity > 1) input.value = quantity - 1;
                      } else {
                          input.value = quantity + 1;
                      }

                      e.stopImmediatePropagation(); // prevent global handler
                  }
              }, true);
              
            // 1. Add to Cart
            if (target.closest('.add-to-cart-btn')) {
                e.stopImmediatePropagation();
                handleAddToCart(target.closest('.add-to-cart-btn'));
            }
            
            // 2. Quantity Buttons
            else if (target.closest('.quantity-btn')) {
                const btn = target.closest('.quantity-btn');
                const itemId = btn.dataset.id;
                const isMinus = btn.classList.contains('minus');
                let quantityElement = btn.parentElement.querySelector('.quantity-value, .quantity-input');
                let quantity = parseInt(quantityElement.value || quantityElement.textContent);

                // const quantityElement = btn.parentElement.querySelector('.quantity-value');
                // let quantity = parseInt(quantityElement.textContent);

                if (isMinus) {
                    if (quantity === 1) {
                        itemToDelete = itemId;
                        deleteModal.style.display = 'flex';
                    } else {
                        updateQuantity(itemId, quantity - 1);
                    }
                } else {
                    updateQuantity(itemId, quantity + 1);
                }
            }
            
            // 3. Remove Item
            else if (target.closest('.remove-item-btn')) {
                itemToDelete = target.closest('.remove-item-btn').dataset.id;
                deleteModal.style.display = 'flex';
            }
        });

        // Modal handlers (one-time binding)
        const confirmBtn = document.querySelector('.confirm-btn');
        const cancelBtn = document.querySelector('.cancel-btn');
        
        if (confirmBtn && !confirmBtn._bound) {
            confirmBtn._bound = true;
            confirmBtn.addEventListener('click', function() {
                if (itemToDelete) removeItem(itemToDelete);
                deleteModal.style.display = 'none';
            });
            
            cancelBtn.addEventListener('click', function() {
                itemToDelete = null;
                deleteModal.style.display = 'none';
            });
            
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    itemToDelete = null;
                    deleteModal.style.display = 'none';
                }
            });
        }
    });

    // ========== CART FUNCTIONS ==========

    function placeOrder() {
    const btn = document.querySelector('.checkout-btn');
    if (!btn) {
        console.error('Checkout button not found!');
        return;
    }

    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner"></span> PROCESSING...';

    const cutleryChecked = document.getElementById('cutlerySwitch')?.checked ? 1 : 0;

    fetch('/TKCafe/Controller/orderController.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded' 
            // 'Content-Type': 'application/json',
        },
        credentials: 'same-origin',
        body: `cutlery=${cutleryChecked}`
        // body: 'cutlery=${cutleryChecked}'
        // body: JSON.stringify({ action: 'place_order' }) 
    })
    .then(async response => {
        const contentType = response.headers.get("Content-Type") || "";

        if (!response.ok) {
            if (contentType.includes("application/json")) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Something went wrong');
            } else {
                throw new Error('Network error: ' + response.status);
            }
        }

        return response.json();
    })
    .then(data => {
        if (!data.success) throw new Error(data.error || 'Order failed');
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            throw new Error('No redirect URL received');
        }
    })
    .catch(error => {
        console.error('Order Error:', error);
        alert('Order failed: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

    
    const handleAddToCart = (button) => {
    if (button._processing) return;
    button._processing = true;
    
    const container = button.closest('.menu-details-container');
    const formData = new URLSearchParams();
    
    // Required fields
    formData.append('action', 'add');
    formData.append('menu_id', button.dataset.id);
    formData.append('quantity', container.querySelector('.quantity-input').value || 1);
    formData.append('price', parseFloat(container.querySelector('.menu-price').textContent.replace(/[^\d.]/g, '')) || 0);
    
    // Optional fields
    const remarks = document.getElementById('remarks')?.value;
    if (remarks) formData.append('remarks', remarks);
    
    // Combo customization
    if (container.querySelector('.combo-customization')) {
        const drink = container.querySelector('input[name="drink"]:checked');
        if (!drink) {
            alert('Please select a drink option');
            button._processing = false;
            return;
        }
        formData.append('customizations', JSON.stringify({ drink: drink.value }));
    }

    fetch('/TKCafe/Controller/cartController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) throw new Error(data.error || 'Failed to add item');
        alert('Added to cart!');

          const remarksField = document.getElementById('remarks');
      if (remarksField) {
        remarksField.value = '';
      }
      updateCartBadge();
        // document.getElementById('remarks').value = '';
        // updateCartBadge();
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message);
    })
    .finally(() => {
        button._processing = false;
    });
};

    const updateCartBadge = () => {
        fetch('/TKCafe/Controller/cartController.php?action=count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.cart-badge');
                if (badge) {
                    badge.style.display = data.count > 0 ? 'block' : 'none';
                    badge.textContent = data.count > 0 ? data.count : '';
                }
            })
            .catch(console.error);
    };

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


}
