console.log("✅ orders.js loaded");

// // // File: /TKCafe/public/js/orders.js
// // document.addEventListener('DOMContentLoaded', function() {
// //     const modal = document.getElementById("orderModal");
// //     const closeBtn = document.querySelector(".close");
// //     const completeBtn = document.getElementById("completeBtn");
    
// //     // View button handlers
// //     document.addEventListener('click', function(e) {
// //         if (e.target.classList.contains('btn-outline')) {
// //             const orderCard = e.target.closest('.order-card');
// //             showOrderDetails(orderCard);
// //         }
// //     });

// //     function showOrderDetails(orderCard) {
// //         document.getElementById("modalOrderContent").innerHTML = `
// //             <p><strong>Order ID:</strong> ${orderCard.dataset.orderId}</p>
// //             ${orderCard.innerHTML.replace(/order-/g, 'modal-')}
// //         `;
// //         modal.style.display = "block";
// //     }

// //     closeBtn.onclick = () => modal.style.display = "none";
    
// //     completeBtn.onclick = async function() {
// //         const orderId = document.querySelector('#modalOrderContent [data-order-id]').dataset.orderId;
        
// //         try {
// //             const response = await fetch('/TKCafe/public/api/update_order.php', {
// //                 method: 'POST',
// //                 headers: { 'Content-Type': 'application/json' },
// //                 body: JSON.stringify({
// //                     order_id: orderId,
// //                     status: 'completed'
// //                 })
// //             });
            
// //             const data = await response.json();
// //             if (data.success) {
// //                 updateOrderStatus(orderId);
// //                 modal.style.display = "none";
// //             }
// //         } catch (error) {
// //             console.error('Error:', error);
// //         }
// //     };

// //     function updateOrderStatus(orderId) {
// //         const orderElement = document.querySelector(`[data-order-id="${orderId}"]`);
// //         if (orderElement) {
// //             orderElement.querySelector('.order-status').textContent = 'Completed';
// //             orderElement.querySelector('.order-status').className = 'order-status status-completed';
// //         }
// //     }
// // });

// // File: /TKCafe/public/js/orders.js
// document.addEventListener('DOMContentLoaded', function() {
//     // Modal elements
//     const modal = document.getElementById('orderModal');
//     const closeBtn = document.querySelector('.close');
//     const completeBtn = document.getElementById('completeBtn');
    
//     // View button click handler
//     document.addEventListener('click', function(e) {
//         if (e.target.classList.contains('view-btn')) {
//             const orderCard = e.target.closest('.order-card');
//             if (orderCard) {
//                 showOrderDetails(orderCard);
//             }
//         }
//     });

//     // Show order details in modal
//     function showOrderDetails(orderCard) {
//         // Get order data from the card
//         const orderId = orderCard.getAttribute('data-order-id');
//         const orderNumber = orderCard.querySelector('.order-id').textContent;
//         const orderStatus = orderCard.querySelector('.order-status').textContent;
//         const orderStatusClass = orderCard.querySelector('.order-status').className;
//         const orderDate = orderCard.querySelector('.order-details p').textContent.replace('Date: ', '');
//         const orderTotal = orderCard.querySelector('.order-total').textContent;
//         const orderItems = orderCard.querySelector('.order-items').innerHTML;
        
//         // Populate modal with order data
//         document.getElementById('modalOrderNumber').textContent = orderNumber.replace('#', '');
//         document.getElementById('modalOrderStatus').textContent = orderStatus;
//         document.getElementById('modalOrderStatus').className = orderStatusClass;
//         document.getElementById('modalOrderDate').textContent = orderDate;
//         document.getElementById('modalOrderTotal').textContent = orderTotal.replace('RM ', '');
//         document.getElementById('modalOrderItems').innerHTML = orderItems;
        
//         // Store order ID on complete button
//         completeBtn.setAttribute('data-order-id', orderId);
        
//         // Show modal
//         modal.style.display = 'block';
//     }
    
//     // Close modal handlers
//     closeBtn.addEventListener('click', closeModal);
//     window.addEventListener('click', function(event) {
//         if (event.target === modal) {
//             closeModal();
//         }
//     });
    
//     function closeModal() {
//         modal.style.display = 'none';
//     }
    
//     // Complete order handler
//     completeBtn.addEventListener('click', async function() {
//         const orderId = this.getAttribute('data-order-id');
        
//         if (!orderId) {
//             alert('Error: No order ID specified');
//             return;
//         }
        
//         if (confirm('Are you sure you want to mark this order as completed?')) {
//             try {
//                 const response = await fetch('/TKCafe/Controller/AdminOrderController.php', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json',
//                     },
//                     body: JSON.stringify({
//                         action: 'complete_order',
//                         order_id: orderId
//                     })
//                 });
                
//                 const data = await response.json();
                
//                 if (data.success) {
//                     // Update the order status in the UI
//                     const orderCard = document.querySelector(`.order-card[data-order-id="${orderId}"]`);
//                     if (orderCard) {
//                         const statusElement = orderCard.querySelector('.order-status');
//                         statusElement.textContent = 'completed';
//                         statusElement.className = 'order-status status-completed';
//                     }
                    
//                     // Close the modal
//                     closeModal();
                    
//                     // Show success message
//                     alert('Order marked as completed successfully!');
//                 } else {
//                     throw new Error(data.message || 'Failed to update order status');
//                 }
//             } catch (error) {
//                 console.error('Error:', error);
//                 alert('An error occurred: ' + error.message);
//             }
//         }
//     });
// });

// File: /TKCafe/public/js/orders.js
document.addEventListener('DOMContentLoaded', function() {
    // Main page view button handlers
    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            openOrderPopup(this.closest('.order-card').dataset.orderId);
        });
    });

    //     // Handle status change button in popup
    // document.addEventListener('click', function (e) {
    //     const btn = e.target.closest('#statusBtn');
    //     if (btn) {
    //         const orderId = btn.dataset.orderId;
    //         const nextStatus = btn.dataset.nextStatus;

    //         fetch('/TKCafe/Controller/adminorderController.php', {
    //             method: 'POST',
    //             headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    //             body: `action=update_status&order_id=${orderId}&status=${nextStatus}`
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 alert(`Order updated to ${nextStatus}`);
    //                 closePopup();
    //                 window.location.reload();
    //             } else {
    //                 alert('Update failed: ' + (data.error || 'Unknown error'));
    //             }
    //         })
    //         .catch(err => {
    //             console.error(err);
    //             alert('Network error while updating status');
    //         });
    //     }
    // });

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
