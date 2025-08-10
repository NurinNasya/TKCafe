function updateDropdownColor(dropdown) {
  dropdown.classList.remove('confirmed', 'cancelled');

  if (dropdown.value === 'Confirmed') {
    dropdown.classList.add('confirmed');
  } else if (dropdown.value === 'Cancelled') {
    dropdown.classList.add('cancelled');
  }
}
document.addEventListener('DOMContentLoaded', function () {

  const popup = document.getElementById('successPopup');
  if (popup) {
    setTimeout(() => {
      const url = new URL(window.location.href);
      url.searchParams.delete('success');
      window.history.replaceState({}, document.title, url.pathname + url.search);
    }, 100);
  }
  //  FIX: Force-hide the edit modal in case it's visible after hard refresh
  document.getElementById('editModal').style.display = 'none';
  document.body.style.overflow = 'auto';

  // ====== STATUS DROPDOWN COLORING ======
  const dropdowns = document.querySelectorAll('.status-dropdown');
  dropdowns.forEach(function (dropdown) {
    updateDropdownColor(dropdown);
    dropdown.addEventListener('change', function () {
      updateDropdownColor(dropdown);
    });
  });

  // ====== EDIT BOOKING MODAL ======
  document.querySelectorAll('.edit-booking-btn').forEach(button => {
    button.addEventListener('click', function () {
      console.log('Edit button clicked'); //  Debug

      // Get booking data
      const id = this.dataset.id;
      const name = this.dataset.name;
      const phone = this.dataset.phone;
      const date = this.dataset.date;
      const time = this.dataset.time;
      const guests = this.dataset.guests;
      const table = this.dataset.table;

      // Set form values
      document.getElementById('edit-booking-id').value = id;
      document.getElementById('edit-name').value = name;
      document.getElementById('edit-phone').value = phone;
      document.getElementById('edit-date').value = date;
      document.getElementById('edit-time').value = time;
      document.getElementById('edit-guests').value = guests;
      document.getElementById('edit-table').value = table;

      // Show modal
      document.getElementById('editModal').style.display = 'block';
      document.body.style.overflow = 'hidden';
    });
  });

  // Close edit modal
  document.querySelector('#editModal .close-button').addEventListener('click', function () {
    document.getElementById('editModal').style.display = 'none';
    document.body.style.overflow = 'auto';
  });

  // ====== ADD BOOKING MODAL ======
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

  // ====== CLICK OUTSIDE TO CLOSE MODAL ======
  const editModal = document.getElementById("editModal");
  window.addEventListener('click', function (event) {
    if (event.target === bookingModal) {
      bookingModal.style.display = 'none';
    }
    if (event.target === editModal) {
      editModal.style.display = 'none';
    }
  });
});


