document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('salesChart')?.getContext('2d');
    if (!ctx) return;

    const labels = window.chartLabels || [];
    const data = window.chartValues || [];

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales (RM)',
                data: data,
                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                borderColor: '#4CAF50',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return 'RM ' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });
});
