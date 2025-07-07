console.log("✅ orders.js loaded");


// File: /TKCafe/public/js/orders.js
document.addEventListener('DOMContentLoaded', function() {
    // Main page view button handlers
    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            openOrderPopup(this.closest('.order-card').dataset.orderId);
        });
    });

    // Delegate events for dynamically loaded popup content
    document.addEventListener('click', function(e) {
        // Close popup handler
        if (e.target.classList.contains('close-popup')) {
            closePopup();
        }
        
        // Complete order handler
        if (e.target.id === 'completeBtn') {
            const orderId = e.target.dataset.orderId;
            if (confirm('Are you sure you want to mark this order as completed?')) {
                completeOrder(orderId);
            }
        }
    });
});

// Open popup with order details
async function openOrderPopup(orderId) {
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');
    
    try {
        // Show loading state
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
        popup.innerHTML = '<div class="loading">Loading order details...</div>';
        popup.style.display = 'block';

        // Load order details
        const response = await fetch(`/TKCafe/Controller/AdminOrderController.php?action=view&id=${orderId}`);
        popup.innerHTML = await response.text();
        
    } catch (err) {
        console.error('Popup loading failed:', err);
        popup.innerHTML = '<div class="error">Failed to load order details</div>';
    }
}

// Close popup
function closePopup() {
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');
    
    popup.style.display = 'none';
    overlay.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Complete order via AJAX
async function completeOrder(orderId) {
    try {
        const response = await fetch(`/TKCafe/Controller/AdminOrderController.php?action=complete&id=${orderId}`);
        const data = await response.json();
        
        if (data.success) {
            closePopup();
            window.location.reload(); // Refresh to show updated status
        } else {
            alert('Error: ' + (data.message || 'Failed to complete order'));
        }
    } catch (error) {
        console.error('Order completion error:', error);
        alert('Network error: Please try again');
    }
}

// ✅ Handle status change button in dynamically loaded popup
document.addEventListener('click', function (e) {
    const btn = e.target.closest('#statusBtn');
    if (btn) {
        console.log('Status button clicked');
        const orderId = btn.dataset.orderId;
        const nextStatus = btn.dataset.nextStatus;

        console.log(`Updating order ${orderId} to ${nextStatus}`); // Debug log

        fetch('/TKCafe/Controller/adminorderController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=update_status&order_id=${orderId}&status=${nextStatus}`
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert(`Order updated to ${nextStatus}`);
                closePopup();
                window.location.reload();
            } else {
                alert('Update failed: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Network error while updating status');
        });
    }
});
