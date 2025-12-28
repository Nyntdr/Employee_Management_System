document.addEventListener('DOMContentLoaded', function() {
    const overviewData = {
        labels: ['Users', 'Employees', 'Departments', 'Notices', 'Assets', 'Events'],
        datasets: [{
            label: 'Count',
            data: [
                window.dashboardData.totalUsers,
                window.dashboardData.totalEmployees,
                window.dashboardData.totalDepartments,
                window.dashboardData.totalNotices,
                window.dashboardData.totalAssets,
                window.dashboardData.totalEvents
            ],
            backgroundColor: [
                'rgba(25, 25, 112, 0.7)',
                'rgba(77, 121, 255, 0.7)',
                'rgba(26, 26, 46, 0.7)',
                'rgba(12, 12, 46, 0.7)',
                'rgba(21, 21, 100, 0.7)',
                'rgba(176, 176, 255, 0.7)'
            ],
            borderColor: [
                'rgb(25, 25, 112)',
                'rgb(77, 121, 255)',
                'rgb(26, 26, 46)',
                'rgb(12, 12, 46)',
                'rgb(21, 21, 100)',
                'rgb(176, 176, 255)'
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
                            callback: function(value) {
                                return value;
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

    const distributionData = {
        labels: ['Users', 'Employees', 'Departments', 'Notices', 'Assets', 'Events'],
        datasets: [{
            data: [
                window.dashboardData.totalUsers,
                window.dashboardData.totalEmployees,
                window.dashboardData.totalDepartments,
                window.dashboardData.totalNotices,
                window.dashboardData.totalAssets,
                window.dashboardData.totalEvents
            ],
            backgroundColor: [
                'rgba(25, 25, 112, 0.8)',
                'rgba(77, 121, 255, 0.8)',
                'rgba(26, 26, 46, 0.8)',
                'rgba(12, 12, 46, 0.8)',
                'rgba(21, 21, 100, 0.8)',
                'rgba(176, 176, 255, 0.8)'
            ],
            borderColor: [
                'rgb(25, 25, 112)',
                'rgb(77, 121, 255)',
                'rgb(26, 26, 46)',
                'rgb(12, 12, 46)',
                'rgb(21, 21, 100)',
                'rgb(176, 176, 255)'
            ],
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
                            padding: 20,
                            font: {
                                size: 12
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
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
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
});
