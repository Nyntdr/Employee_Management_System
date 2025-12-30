document.addEventListener('DOMContentLoaded', function() {
    const overviewData = {
        labels: ['Users', 'Employees', 'Departments', 'Notices', 'Assets', 'Events', 'Leaves'],
        datasets: [{
            label: 'Count',
            data: [
                window.dashboardData.totalUsers,
                window.dashboardData.totalEmployees,
                window.dashboardData.totalDepartments,
                window.dashboardData.totalNotices,
                window.dashboardData.totalAssets,
                window.dashboardData.totalEvents,
                window.dashboardData.totalLeaves
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(201, 203, 207, 0.7)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)',
                'rgb(255, 159, 64)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    };

    const overviewCtx = document.getElementById('overviewChart')?.getContext('2d');

    if (overviewCtx) {
        const overviewChart = new Chart(overviewCtx, {
            type: 'bar',
            data: overviewData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 13,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            stepSize: 1,
                            callback: function(value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                }
            }
        });
    }
    const employeesByDept = window.dashboardData.employeesByDepartment;
    const departmentLabels = employeesByDept.map(dept => dept.name);
    const employeeCounts = employeesByDept.map(dept => dept.employees_count);
    const generateDepartmentColors = (count) => {
        const colors = [];
        const baseColors = [
            'rgba(25, 25, 112, 0.8)',    // Midnight Blue
            'rgba(77, 121, 255, 0.8)',   // Royal Blue
            'rgba(26, 26, 46, 0.8)',     // Dark Blue
            'rgba(12, 12, 46, 0.8)',     // Navy
            'rgba(21, 21, 100, 0.8)',    // Dark Slate Blue
            'rgba(176, 176, 255, 0.8)',  // Light Blue
            'rgba(65, 105, 225, 0.8)',   // Medium Blue
            'rgba(100, 149, 237, 0.8)',  // Cornflower Blue
            'rgba(30, 144, 255, 0.8)',   // Dodger Blue
            'rgba(0, 191, 255, 0.8)',    // Deep Sky Blue
            'rgba(135, 206, 235, 0.8)',  // Sky Blue
            'rgba(70, 130, 180, 0.8)'    // Steel Blue
        ];

        for (let i = 0; i < count; i++) {
            colors.push(baseColors[i % baseColors.length]);
        }

        return colors;
    };

    const distributionData = {
        labels: departmentLabels,
        datasets: [{
            label: 'Employees',
            data: employeeCounts,
            backgroundColor: generateDepartmentColors(departmentLabels.length),
            borderColor: 'rgba(255, 255, 255, 0.8)',
            borderWidth: 2,
            hoverOffset: 15
        }]
    };

    const distributionCtx = document.getElementById('distributionChart')?.getContext('2d');

    if (distributionCtx) {
        const distributionChart = new Chart(distributionCtx, {
            type: 'pie',
            data: distributionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 11
                            },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        const value = data.datasets[0].data[i];
                                        return {
                                            text: `${label}: ${value}`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 13,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} employees (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
});
