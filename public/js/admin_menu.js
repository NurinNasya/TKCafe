
function openAddForm() {
    document.getElementById('addMenuModal').style.display = 'flex';
}

function closeAddForm() {
    document.getElementById('addMenuModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('addMenuModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

//add edit fuction

document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(".btn-primary.edit-menu");

  editButtons.forEach(button => {
    button.addEventListener("click", function () {
      const menu = JSON.parse(this.dataset.menu);

      // Fill form fields
      document.getElementById("edit-id").value = menu.id;
      document.getElementById("edit-name").value = menu.name;
      document.getElementById("edit-description").value = menu.description;
      document.getElementById("edit-price").value = menu.price;
      document.getElementById("edit-category").value = menu.category;
      document.getElementById("edit-preview-image").src = "/TKCafe/uploads/" + menu.image;
  
            // Set bestseller toggle state
            const bestSellerToggle = document.getElementById('bestSellerToggle');
            if (bestSellerToggle) {
                bestSellerToggle.checked = menu.best_seller == 1;
                toggleBestSeller(); // Update the form state
            }

      // Show modal
      document.getElementById("editMenuModal").style.display = "block";
    });
  });
});

// Close modal
function closeEditForm() {
  document.getElementById("editMenuModal").style.display = "none";
}


document.addEventListener('DOMContentLoaded', function () {
  const imageModal = document.getElementById('imageModal');
  const popupImage = document.getElementById('popupImage');

  document.querySelectorAll('.popup-image').forEach(img => {
    img.addEventListener('click', function () {
      const imageUrl = this.getAttribute('data-image');
      popupImage.src = imageUrl;
      imageModal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    });
  });

  window.closeImageModal = function () {
    imageModal.style.display = 'none';
    document.body.style.overflow = 'auto';
  }

  imageModal.addEventListener('click', function (e) {
    if (e.target === imageModal) {
      closeImageModal();
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('menuSearchInput');
  const rows = document.querySelectorAll('table tbody tr');

  searchInput.addEventListener('input', function () {
    const query = this.value.toLowerCase();

    rows.forEach(row => {
      const name = row.cells[1]?.textContent.toLowerCase() || '';
      const description = row.cells[2]?.textContent.toLowerCase() || '';
      const category = row.cells[5]?.textContent.toLowerCase() || '';

      const matches = name.includes(query) || description.includes(query) || category.includes(query);
      row.style.display = matches ? '' : 'none';
    });
  });
});

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.category-toggle-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const category = this.dataset.category;
      const hide = this.checked ? 1 : 0;

      fetch('../Controller/menuController.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=toggle_category&category=${encodeURIComponent(category)}&hide=${hide}`
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (!data.success) {
          // Revert the checkbox if the operation failed
          this.checked = !this.checked;
          alert('Failed to update category visibility');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        this.checked = !this.checked;
        alert('An error occurred while updating category visibility');
      });
    });
  });
});

function toggleBestSeller() {
    const isBestSeller = document.getElementById('bestSellerToggle').checked;
    const categorySelect = document.querySelector('select[name="category"]') || 
                         document.getElementById('edit-category');
    
    if (isBestSeller) {
        if (categorySelect.tagName === 'SELECT') {
            categorySelect.value = 'best-seller';
        } else {
            categorySelect.value = 'best-seller';
        }
    }
    
    // Add hidden field to ensure best_seller status is submitted
    let bestSellerInput = document.querySelector('input[name="best_seller"]');
    if (!bestSellerInput) {
        bestSellerInput = document.createElement('input');
        bestSellerInput.type = 'hidden';
        bestSellerInput.name = 'best_seller';
        document.querySelector('form').appendChild(bestSellerInput);
    }
    bestSellerInput.value = isBestSeller ? '1' : '0';
}

// function toggleBestSeller() {
//     const isBestSeller = document.getElementById('bestSellerToggle').checked;
//     const categorySelect = document.getElementById('categorySelect');
    
//     if (isBestSeller) {
//         categorySelect.value = 'best-seller';
//     } else {
//         categorySelect.value = ''; // Or set to default
//     }
// }
// function setBestSeller() {
//     // Set the category dropdown to "Best Seller"
//     document.getElementById('categorySelect').value = 'best-seller';
    
//     // Optional: Add visual feedback
//     const btn = document.querySelector('.btn-remark');
//     btn.classList.add('active');
//     setTimeout(() => btn.classList.remove('active'), 1000);
// }
// document.querySelectorAll('.category-toggle-checkbox').forEach(checkbox => {
//   checkbox.addEventListener('change', function () {
//     const category = this.dataset.category;
//     const hide = this.checked ? 1 : 0;

//     fetch('../controllers/menuController.php', {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/x-www-form-urlencoded'
//       },
//       body: `action=toggle_category&category=${encodeURIComponent(category)}&hide=${hide}`
//     })
//     .then(response => response.json())
//     .then(data => {
//       if (!data.success) {
//         alert('Failed to update category visibility.');
//       }
//     });
//   });
// });
