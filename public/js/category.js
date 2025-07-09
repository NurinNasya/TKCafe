document.querySelectorAll('.category').forEach(button => {
  button.addEventListener('click', () => {
    const category = button.getAttribute('data-category');
    
    document.querySelectorAll('.category').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');

    document.querySelectorAll('.menu-item').forEach(item => {
      if (category === 'all' || item.dataset.category === category) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  });
});
