function updateDropdownColor(dropdown) {
  dropdown.classList.remove('confirmed', 'cancelled');

  if (dropdown.value === 'Confirmed') {
    dropdown.classList.add('confirmed');
  } else if (dropdown.value === 'Cancelled') {
    dropdown.classList.add('cancelled');
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const dropdowns = document.querySelectorAll('.status-dropdown');
  dropdowns.forEach(function (dropdown) {
    updateDropdownColor(dropdown);

    dropdown.addEventListener('change', function () {
      updateDropdownColor(dropdown);
    });
  });

  // Modal Logic
  const modal = document.getElementById('editModal');
  const closeBtn = document.querySelector('.close-button');

  // Ensure modal is hidden initially
  if (modal) {
    modal.style.display = 'none';
  }

  // Track user action
  document.querySelectorAll('.edit-booking-link').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      // Populate form
      document.getElementById('edit-booking-id').value = this.dataset.id;
      document.getElementById('edit-name').value = this.dataset.name;
      document.getElementById('edit-phone').value = this.dataset.phone;
      document.getElementById('edit-date').value = this.dataset.date;
      document.getElementById('edit-time').value = this.dataset.time;
      document.getElementById('edit-guests').value = this.dataset.guests;
      document.getElementById('edit-table').value = this.dataset.table;

      // Open modal manually
      modal.style.display = 'flex';
    });
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  }

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
});
