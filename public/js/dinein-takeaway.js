
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
   