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

// tables.js
// Keep this outside of DOMContentLoaded to make it global
function openAddForm() {
  const overlay = document.getElementById('overlay');
  const popup = document.getElementById('popup');

  popup.innerHTML = `
    <h3>Add New Table</h3>
    <form class="form-inline" action="/TKCafe/Controller/tablesController.php" method="POST">
      <input type="text" name="table_name" placeholder="Table name" required class="input-field">
      <input type="number" name="seats" placeholder="Seats" required class="input-field" min="1">
      <select name="status" class="input-field">
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
      </select>
      <div style="margin-top: 10px;">
        <button type="submit" name="add_table" class="btn btn-primary">Add Table</button>
        <button type="button" class="btn btn-secondary" onclick="closeAddForm()">Cancel</button>
      </div>
    </form>
  `;

  overlay.style.display = 'block';
  popup.style.display = 'block';
  document.body.style.overflow = 'hidden';

  overlay.onclick = closeAddForm;
}

function closeAddForm() {
  const overlay = document.getElementById('overlay');
  const popup = document.getElementById('popup');
  overlay.style.display = 'none';
  popup.style.display = 'none';
  popup.innerHTML = '';
  document.body.style.overflow = 'auto';
}
