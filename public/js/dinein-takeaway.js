
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('orderForm');
    const options = document.querySelectorAll('.option-card');

    options.forEach(option => {
        option.addEventListener('click', function(e) {
            // Prevent default label behavior
            e.preventDefault();
            
            // Remove active class from all options
            options.forEach(opt => {
                opt.classList.remove('selected', 'active');
                opt.querySelector('.checkmark').style.opacity = '0';
            });
            
            // Activate selected option
            this.classList.add('selected', 'active');
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            this.querySelector('.checkmark').style.opacity = '1';
            
            // Submit the form after slight delay for visual feedback
            setTimeout(() => {
                form.submit();
            }, 300);
        });
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        if (!document.querySelector('input[name="order_type"]:checked')) {
            e.preventDefault();
            alert('Please select an option before continuing.');
        }
    });
});