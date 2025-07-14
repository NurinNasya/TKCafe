
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

      // Show modal
      document.getElementById("editMenuModal").style.display = "block";
    });
  });
});

// Close modal
function closeEditForm() {
  document.getElementById("editMenuModal").style.display = "none";
}
