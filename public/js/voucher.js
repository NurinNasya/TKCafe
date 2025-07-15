document.querySelectorAll('.edit-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-code').value = btn.dataset.code;
    document.getElementById('edit-description').value = btn.dataset.description;
    document.getElementById('edit-discount').value = btn.dataset.discount;
    document.getElementById('edit-min').value = btn.dataset.min;
    document.getElementById('edit-valid').value = btn.dataset.valid;

    document.getElementById('editModal').style.display = 'flex';
  });
});

document.querySelector('#editModal .close').addEventListener('click', () => {
  document.getElementById('editModal').style.display = 'none';
});

window.addEventListener('click', (e) => {
  if (e.target === document.getElementById('editModal')) {
    document.getElementById('editModal').style.display = 'none';
  }
});

// Add Voucher Modal logic
const addModal = document.getElementById('addModal');
const openAddBtn = document.getElementById('openAddModal');
const closeAddBtn = document.getElementById('closeAddModal');

openAddBtn.addEventListener('click', () => {
  addModal.style.display = 'flex';
});

closeAddBtn.addEventListener('click', () => {
  addModal.style.display = 'none';
});

window.addEventListener('click', (e) => {
  if (e.target === addModal) {
    addModal.style.display = 'none';
  }
});
