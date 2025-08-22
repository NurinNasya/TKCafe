
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
  
            // // Set bestseller toggle state
            // const bestSellerToggle = document.getElementById('bestSellerToggle');
            // if (bestSellerToggle) {
            //     bestSellerToggle.checked = menu.best_seller == 1;
            //     toggleBestSeller(); // Update the form state
            // }

             // ✅ Set Best Seller toggle correctly
      const bestSellerToggle = document.getElementById('editBestSellerToggle');
      bestSellerToggle.checked = menu.best_seller == 1;
      //toggleBestSeller(bestSellerToggle); // ensure hidden input matches checkbox

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

document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('categorySelect');
    const newCategoryInput = document.getElementById('newCategoryInput');

    categorySelect.addEventListener('change', function () {
        if (this.value === '__other__') {
            newCategoryInput.style.display = 'block';
            newCategoryInput.setAttribute('required', 'required');
        } else {
            newCategoryInput.style.display = 'none';
            newCategoryInput.removeAttribute('required');
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("toggleCategoryBtn");
  const hiddenCats = document.querySelectorAll(".hidden-category");

  if (btn) {
    btn.addEventListener("click", function () {
      const isShowing = btn.textContent === "Show Less";

      hiddenCats.forEach(cat => {
        cat.style.display = isShowing ? "none" : "block";
      });

      btn.textContent = isShowing ? "Show More" : "Show Less";
    });
  }
});
