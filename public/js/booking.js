function updateDropdownColor(dropdown) {
  dropdown.classList.remove('confirmed', 'cancelled');

  if (dropdown.value === 'Confirmed') {
    dropdown.classList.add('confirmed');
  } else if (dropdown.value === 'Cancelled') {
    dropdown.classList.add('cancelled');
  }
}

document.addEventListener('DOMContentLoaded', function () {
  // Update dropdown colors
  const dropdowns = document.querySelectorAll('.status-dropdown');
  dropdowns.forEach(function (dropdown) {
    updateDropdownColor(dropdown);

    dropdown.addEventListener('change', function () {
      updateDropdownColor(dropdown);
    });
  });

  // ===== Edit Booking Modal Logic =====
  const editModal = document.getElementById('editModal');
  const closeEditBtn = editModal?.querySelector('.close-button');

  if (editModal) editModal.style.display = 'none';

  document.querySelectorAll('.edit-booking-link').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      document.getElementById('edit-booking-id').value = this.dataset.id;
      document.getElementById('edit-name').value = this.dataset.name;
      document.getElementById('edit-phone').value = this.dataset.phone;
      document.getElementById('edit-date').value = this.dataset.date;
      document.getElementById('edit-time').value = this.dataset.time;
      document.getElementById('edit-guests').value = this.dataset.guests;
      document.getElementById('edit-table').value = this.dataset.table;

      editModal.style.display = 'flex';
    });
  });

  if (closeEditBtn) {
    closeEditBtn.addEventListener('click', () => {
      editModal.style.display = 'none';
    });
  }

  // ===== Add Booking Modal Logic =====
  const bookingModal = document.getElementById("bookingFormModal");
  const openBtn = document.getElementById("openBookingFormBtn");
  const closeBookingBtn = bookingModal?.querySelector('.close-button');

  if (bookingModal) bookingModal.style.display = 'none';

  if (openBtn) {
    openBtn.addEventListener('click', function () {
      bookingModal.style.display = 'flex';
    });
  }

  if (closeBookingBtn) {
    closeBookingBtn.addEventListener('click', function () {
      bookingModal.style.display = 'none';
    });
  }

  // Close either modal if clicking outside
  window.addEventListener('click', function (event) {
    if (event.target === bookingModal) {
      bookingModal.style.display = 'none';
    }
    if (event.target === editModal) {
      editModal.style.display = 'none';
    }
  });
});
