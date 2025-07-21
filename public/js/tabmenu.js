document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const sections = document.querySelectorAll('.status-section');

    // Determine the active tab
    let savedStatus = localStorage.getItem('activeTab');

    // If no saved tab or referrer is from sidebar, default to Pending
    if (!savedStatus || !document.referrer.includes('orders.php')) {
        savedStatus = 'Pending';
    }

    // Activate saved/default tab
    const defaultButton = document.querySelector(`.tab-btn[data-status="${savedStatus}"]`);
    if (defaultButton) defaultButton.click();

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const status = this.dataset.status;
            localStorage.setItem('activeTab', status);

            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            sections.forEach(section => {
                section.style.display = section.dataset.status === status ? 'grid' : 'none';
            });
        });
    });
});
