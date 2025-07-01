// tables.js - Handles popup edit form for tables
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', async function () {
      const id = this.dataset.id;
      const overlay = document.getElementById('overlay');
      const popup = document.getElementById('popup');

      try {
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';

        const response = await fetch(`/TKCafe/Views/edit_table_partial.php?id=${id}`);
        popup.innerHTML = await response.text();
        popup.style.display = 'block';

        // Add listener to close popup
        overlay.addEventListener('click', function closePopup() {
          overlay.style.display = 'none';
          popup.style.display = 'none';
          popup.innerHTML = ''; // clear popup
          document.body.style.overflow = 'auto';
          overlay.removeEventListener('click', closePopup);
        });
      } catch (err) {
        console.error('Failed to load edit form:', err);
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
      }
    });
  });
});
