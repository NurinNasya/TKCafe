
        /*
        const optionCards = document.querySelectorAll('.option-card');
        const continueBtn = document.getElementById('continueBtn');
        let selectedOption = null;

        optionCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                optionCards.forEach(c => c.classList.remove('selected'));
                
                // Add selected class to clicked card
                this.classList.add('selected');
                
                // Check the radio input
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Enable continue button
                continueBtn.classList.add('active');
                
                // Store selected option
                selectedOption = radio.value;
            });
        });

        // For demonstration, prevent form submission
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (selectedOption) {
                alert(`You selected: ${selectedOption}\n\nForm would submit to your PHP processor`);
                // In your actual implementation, remove this alert and let the form submit
                // window.location.href = 'menu.php?type=' + selectedOption;
            }
        });

        */
   
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