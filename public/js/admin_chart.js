document.addEventListener('DOMContentLoaded', function() {
    const barChartCanvas = document.getElementById('overviewChart');
    if (barChartCanvas) {
        const barChartCtx = barChartCanvas.getContext('2d');
        const barChartData = {
            labels: window.dashboardData.assetTypeLabels,
            datasets: [{
                label: 'Number of Assets',
                data: window.dashboardData.assetsByType,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 205, 86, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 159, 64)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 205, 86)',
                    'rgb(153, 102, 255)'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        };
        const barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { font: { size: 12 } }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} assets`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Number of Assets' }
                },
                x: {
                    title: { display: true, text: 'Asset Types' }
                }
            }
        };
        new Chart(barChartCtx, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    }
    const pieChartCanvas = document.getElementById('distributionChart');

    if (pieChartCanvas) {
        const pieChartCtx = pieChartCanvas.getContext('2d');
        const departmentData = window.dashboardData.employeesByDepartment;

        const departmentNames = departmentData.map(dept => dept.name);
        const employeeCounts = departmentData.map(dept => dept.employees_count);

        const pieColors = [
            'rgba(25, 25, 112, 0.8)', 'rgba(77, 121, 255, 0.8)',
            'rgba(26, 26, 46, 0.8)',  'rgba(12, 12, 46, 0.8)',
            'rgba(21, 21, 100, 0.8)', 'rgba(176, 176, 255, 0.8)',
            'rgba(65, 105, 225, 0.8)', 'rgba(100, 149, 237, 0.8)',
            'rgba(30, 144, 255, 0.8)', 'rgba(0, 191, 255, 0.8)'
        ];

        const pieChartData = {
            labels: departmentNames,
            datasets: [{
                label: 'Number of Employees',
                data: employeeCounts,
                backgroundColor: pieColors.slice(0, departmentNames.length),
                borderWidth: 2
            }]
        };
        const pieChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: { size: 11 },
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label;
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} employees (${percentage}%)`;
                        }
                    }
                }
            }
        };
        new Chart(pieChartCtx, {
            type: 'pie',
            data: pieChartData,
            options: pieChartOptions
        });
    }
    function getColor(index) {
        const colors = [
            '#36a2eb', '#ff9f40', '#4bc0c0', '#ffcd56', '#9966ff',
            '#ff6384', '#c9cbcf', '#7ebf8f', '#f54e42', '#3d3d3d'
        ];
        return colors[index % colors.length];
    }
    function formatNumber(number) {
        return number.toLocaleString();
    }

    console.log('Dashboard Data Loaded:', window.dashboardData);
});
