document.addEventListener('DOMContentLoaded', () => {
    // Initialize icons
    lucide.createIcons();
    
    // Non-persistent animations and progress bar fills
    const initializeProgressBars = () => {
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const targetWidth = bar.getAttribute('data-width');
            setTimeout(() => {
                bar.style.width = targetWidth;
            }, 100);
        });
    };

    // Initialize activity bars (one-time animation)
    const initializeActivityBars = () => {
        document.querySelectorAll('.activity-bar').forEach(bar => {
            const targetHeight = bar.style.height;
            bar.style.setProperty('--height', targetHeight);
            bar.style.height = 0;
        });
    };

    // Initialize progress circle (one-time animation)
    const initializeProgressCircle = () => {
        const progressCircle = document.querySelector('.progress-circle');
        if (progressCircle) {
            const dashOffset = progressCircle.getAttribute('data-offset') || '13.6';
            progressCircle.style.setProperty('--dash-value', dashOffset);
        }
    };
    
    // Initialize charts with better styling
    const initializeCharts = () => {
        // Common chart options for better styling
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        boxWidth: 12,
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 11,
                            family: 'Inter',
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.8)',
                    titleFont: { size: 13, family: 'Inter', weight: '600' },
                    bodyFont: { size: 12, family: 'Inter' },
                    padding: 12,
                    cornerRadius: 8,
                    caretSize: 6,
                    displayColors: false
                }
            },
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            }
        };

        // Heart Rate Chart
        if (document.getElementById('heartRateChart')) {
            const heartRateCtx = document.getElementById('heartRateChart').getContext('2d');
            
            // Create gradient for heart rate
            const heartRateGradient = heartRateCtx.createLinearGradient(0, 0, 0, 150);
            heartRateGradient.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
            heartRateGradient.addColorStop(1, 'rgba(239, 68, 68, 0.05)');
            
            const heartRateChart = new Chart(heartRateCtx, {
                type: 'line',
                data: {
                    labels: ['6AM', '9AM', '12PM', '3PM', '6PM', '9PM', 'Now'],
                    datasets: [{
                        label: 'Heart Rate',
                        data: [45, 42, 48, 53, 47, 42, 42],
                        borderColor: '#ef4444',
                        borderWidth: 2.5,
                        backgroundColor: heartRateGradient,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#ef4444',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#ef4444',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 30,
                            max: 80,
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'Inter'
                                },
                                color: '#64748b'
                            },
                            grid: {
                                drawBorder: false,
                                color: 'rgba(226, 232, 240, 0.6)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'Inter'
                                },
                                color: '#64748b'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }
        
        // Battery Chart
        if (document.getElementById('batteryChart')) {
            const batteryCtx = document.getElementById('batteryChart').getContext('2d');
            
            // Create gradient for battery
            const batteryGradient = batteryCtx.createLinearGradient(0, 0, 0, 150);
            batteryGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
            batteryGradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');
            
            const batteryChart = new Chart(batteryCtx, {
                type: 'line',
                data: {
                    labels: ['12AM', '3AM', '6AM', '9AM', '12PM', '3PM', '6PM', '9PM', 'Now'],
                    datasets: [{
                        label: 'Body Battery',
                        data: [50, 25, 10, 30, 60, 80, 95, 97, 96],
                        borderColor: '#3b82f6',
                        borderWidth: 2.5,
                        backgroundColor: batteryGradient,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#3b82f6',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'Inter'
                                },
                                color: '#64748b'
                            },
                            grid: {
                                drawBorder: false,
                                color: 'rgba(226, 232, 240, 0.6)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'Inter'
                                },
                                color: '#64748b'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // Calories Chart
        if (document.getElementById('caloriesChart')) {
            const caloriesCtx = document.getElementById('caloriesChart').getContext('2d');
            const caloriesChart = new Chart(caloriesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Resting'],
                    datasets: [{
                        data: [9, 677],
                        backgroundColor: [
                            '#f97316',
                            '#fdba74'
                        ],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    ...commonOptions,
                    cutout: '75%',
                    plugins: {
                        ...commonOptions.plugins,
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: {
                                    size: 11,
                                    family: 'Inter',
                                    weight: '500'
                                }
                            }
                        }
                    }
                }
            });
        }
    };

    // Initialize UI components
    const initializeUI = () => {
        // Add CSS classes for one-time animations
        document.querySelectorAll('.animate-text').forEach(el => {
            el.classList.remove('animate-text');
            el.classList.add('text-appear');
        });
        
        document.querySelectorAll('.animate-card').forEach(el => {
            el.classList.remove('animate-card');
            el.classList.add('card-appear');
        });
        
        document.querySelectorAll('.animate-chart').forEach(el => {
            el.classList.remove('animate-chart');
            el.classList.add('chart-appear');
        });
        
        document.querySelectorAll('.animate-bar').forEach(el => {
            el.classList.remove('animate-bar');
            el.classList.add('activity-bar');
        });
        
        document.querySelectorAll('.logo-spin').forEach(el => {
            el.classList.remove('logo-spin');
            el.classList.add('logo-appear');
        });
        
        document.querySelectorAll('.animate-progress-circle').forEach(el => {
            el.classList.remove('animate-progress-circle');
            el.classList.add('progress-circle');
        });
        
        // Remove permanent animations
        document.querySelectorAll('.animate-spin-slow').forEach(el => {
            el.classList.remove('animate-spin-slow');
        });
        
        document.querySelectorAll('.animate-pulse').forEach(el => {
            el.classList.remove('animate-pulse');
            el.classList.add('pulse-once');
        });
    };
    
    // Run initializations
    initializeUI();
    initializeProgressBars();
    initializeActivityBars();
    initializeProgressCircle();
    initializeCharts();
    
    // Handle sidebar interactions
    document.querySelectorAll('.sidebar-icon').forEach(icon => {
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.sidebar-icon').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });
});