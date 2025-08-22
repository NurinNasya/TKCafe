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
    const orderId = document.getElementById('current_order_id')?.value; 

    fetch('/TKCafe/Controller/orderController.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded' 
            // 'Content-Type': 'application/json',
        },
        credentials: 'same-origin',
        body: `cutlery=${cutleryChecked}&order_id=${orderId}` // ✅ ADD ORDER_ID HERE
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
    const orderId = document.getElementById('current_order_id')?.value;

    if (!orderId) {
        alert('Order ID missing. Please refresh the page.');
        button._processing = false;
        return;
    }

    const formData = new URLSearchParams();

    // Required fields
    formData.append('action', 'add');
    formData.append('order_id', orderId);
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
        if (remarksField) remarksField.value = '';
        updateCartBadge();
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
    const orderId = document.getElementById('current_order_id')?.value;
    if (!orderId) return;

    fetch(`/TKCafe/Controller/cartController.php?action=count&order_id=${orderId}`)
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
  const orderId = document.getElementById('current_order_id')?.value;
  if (!orderId) return;

  fetch(`/TKCafe/Controller/cartController.php?action=list&order_id=${orderId}`)
    .then(response => response.json())
    .then(data => {
      renderCart(data); // use data directly, not data.items
      updateCartBadge();
    })
    .catch(err => {
      console.error('Cart load failed:', err);
      const container = document.getElementById('cart-items');
      if (container) container.innerHTML = '<p>Error loading cart</p>';
    });
}

function renderCart(items) {
  const container = document.getElementById('cart-items');
  if (!container) return;

  if (!items || items.length === 0) {
    container.innerHTML = '<p>Your cart is empty</p>';
    return;
  }

  let html = '';
  items.forEach(item => {
    const subtotal = item.price * item.quantity;
    const customizations = item.customizations ? JSON.parse(item.customizations) : null;

    html += `
      <div class="cart-item">
        <p><strong>${item.name || 'Item #' + item.menu_id}</strong></p>
        ${customizations ? `<p>Drink: ${customizations.drink}</p>` : ''}
        <p>Qty: ${item.quantity} × RM ${item.price.toFixed(2)}</p>
        <p>Subtotal: RM ${subtotal.toFixed(2)}</p>
      </div>
    `;
  });

  container.innerHTML = html;
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

// voucher //
// cart.js
document.addEventListener('DOMContentLoaded', function () {
  // --- Elements ---
  const voucherForm = document.getElementById('voucherForm');
  const openPopupBtn = document.getElementById('openVoucherPopup');
  const voucherPopup = document.getElementById('voucherPopup');
  const closePopupBtn = document.getElementById('closeVoucherPopup');
  const errorMsg = document.getElementById('voucherError');
  const discountRow = document.getElementById('voucherDiscountRow');
  const discountValue = document.getElementById('voucherDiscount');
  const grandTotalText = document.getElementById('grandTotal');

  // --- Popup Handlers ---
  if (openPopupBtn && voucherPopup) {
    openPopupBtn.addEventListener('click', () => voucherPopup.style.display = 'flex');
  }

  if (closePopupBtn) {
    closePopupBtn.addEventListener('click', () => voucherPopup.style.display = 'none');
  }

  // --- Apply Voucher via AJAX ---
  function applyVoucher(voucherCode) {
    const formData = new FormData();
    formData.append('voucher_code', voucherCode);

    fetch('/TKCafe/Controller/ajaxVoucherController.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Update totals and display
          if (discountRow) discountRow.style.display = 'flex';
          if (discountValue) discountValue.textContent = `- RM ${parseFloat(data.discount).toFixed(2)}`;
          const summaryRows = document.querySelectorAll('.summary-row');
          if (summaryRows[0]) summaryRows[0].querySelector('span:last-child').textContent = `RM ${parseFloat(data.subtotal).toFixed(2)}`;
          if (summaryRows[1]) summaryRows[1].querySelector('span:last-child').textContent = `RM ${parseFloat(data.service_charge).toFixed(2)}`;
          if (grandTotalText) grandTotalText.textContent = `RM ${parseFloat(data.grand_total).toFixed(2)}`;

          // Update display input
          const voucherDisplay = document.querySelector('.voucher-display');
          if (voucherDisplay) voucherDisplay.value = data.voucher_code;

          // Clear errors
          if (errorMsg) {
            errorMsg.textContent = '';
            errorMsg.style.display = 'none';
          }
        } else {
          // Handle failure
          if (discountRow) discountRow.style.display = 'none';
          if (discountValue) discountValue.textContent = `- RM 0.00`;
          if (grandTotalText && data.subtotal) grandTotalText.textContent = `RM ${parseFloat(data.subtotal).toFixed(2)}`;
          if (errorMsg) {
            errorMsg.textContent = data.error || 'Failed to apply voucher.';
            errorMsg.style.display = 'block';
          }
        }
      })
      .catch(err => {
        console.error('Voucher error:', err);
        if (errorMsg) {
          errorMsg.textContent = 'Server error';
          errorMsg.style.display = 'block';
        }
      });
  }

  // --- Voucher Form Submit ---
    // --- Voucher Form Submit ---
  if (voucherForm) {
    voucherForm.addEventListener('submit', function (e) {
      e.preventDefault();
      errorMsg.textContent = '';

      const selectedRadio = voucherForm.querySelector('input[name="voucher_code"]:checked');
      if (!selectedRadio) {
        alert("Please select a voucher.");
        return;
      }

      const voucherCode = selectedRadio.value.trim();
      applyVoucher(voucherCode);

      // Close popup
      if (voucherPopup) voucherPopup.style.display = 'none';
    });
  }

});

// --- Auto-apply existing voucher on page load ---
window.addEventListener('load', () => {
  const voucherDisplay = document.querySelector('.voucher-display');
  if (voucherDisplay && voucherDisplay.value.trim()) {
    applyVoucher(voucherDisplay.value.trim());
  }
});
