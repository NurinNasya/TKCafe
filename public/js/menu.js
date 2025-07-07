// menu.js - Handles ONLY menu/popup functionality
document.addEventListener('DOMContentLoaded', function() {
  // Category filtering
  const categories = document.querySelectorAll('.category');
  const items = document.querySelectorAll('.menu-item');

  categories.forEach(button => {
    button.addEventListener('click', function() {
      categories.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      const selectedCategory = this.getAttribute('data-category');

      items.forEach(item => {
        item.style.display = 
          (selectedCategory === 'all' || item.getAttribute('data-category') === selectedCategory) 
          ? 'flex' : 'none';
      });
    });
  });

  // Default to 'all' category
  document.querySelector('[data-category="all"]')?.click();

  // Popup handling
document.querySelectorAll('.select-btn').forEach(button => {
  button.addEventListener('click', async (e) => {
    e.preventDefault();
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');
    
    try {
      // Show overlay and disable scrolling
      overlay.style.display = 'block';
      document.body.style.overflow = 'hidden';
      
      const response = await fetch(`/TKCafe/Controller/menuController.php?id=${button.dataset.id}`);
      popup.innerHTML = await response.text();
      popup.style.display = 'block';

      // Bind close button inside loaded popup
    const closeBtn = popup.querySelector('.close-popup-btn');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        popup.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
      });
    }
          
      // Close popup when clicking overlay
      overlay.addEventListener('click', function closePopup() {
        popup.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
        overlay.removeEventListener('click', closePopup);
      });
      
      // Notify other scripts that popup loaded
      document.dispatchEvent(new CustomEvent('popupContentLoaded'));
    } catch (err) {
      console.error('Popup loading failed:', err);
      alert('Failed to load details');
      overlay.style.display = 'none';
      document.body.style.overflow = 'auto';
    }
  });
});

// Example for your back button in menu_popup.php
document.querySelector('.back-button')?.addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('popup').style.display = 'none';
  document.getElementById('overlay').style.display = 'none';
  document.body.style.overflow = 'auto';
});


});
