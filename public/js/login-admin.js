document.addEventListener('DOMContentLoaded', () => {
  const openBtn = document.getElementById('openLoginModal');
  const modal = document.getElementById('loginModal');
  const closeBtn = modal.querySelector('.close');

  openBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
  });

  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
});
