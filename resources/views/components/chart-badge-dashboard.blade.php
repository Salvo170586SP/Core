@props(['labels', 'data'])

<div
    class="w-full h-85 text-center shadow rounded bg-white dark:bg-zinc-800 border  border-zinc-300 dark:border-zinc-700">
    <h3 class="font-medium my-3">Tesseramenti Annui</h3>
    <div class="w-full h-65 px-5 overflow-hidden">
        <canvas id="myChart"></canvas>
    </div>
</div>

@script
<script>
    const ctx = document.getElementById('myChart');
    
    const labels = @json($labels);
    const data = @json($data);

    // Funzione per verificare se il tema è dark
     function isDarkMode() {
       return document.documentElement.classList.contains('dark');
    }

    // Colori adattivi in base al tema
    function getChartColors() {
        if (isDarkMode()) {
            return {
                borderColor: 'rgba(96, 165, 250, 1)',       
                backgroundColor: 'rgba(96, 165, 250, 0.2)',
                pointBackgroundColor: 'rgba(96, 165, 250, 1)',
                pointBorderColor: '#1f2937',               
                gridColor: 'rgba(255, 255, 255, 0.1)',
                textColor: '#e5e7eb'                        
            };
        } else {
            return {
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointBorderColor: '#fff',
                gridColor: 'rgba(0, 0, 0, 0.1)',
                textColor: '#374151'                        
            };
        }
    }
    const colors = getChartColors();
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
            label: 'Tesseramenti Attivi Progressivi',
                data: data,
                borderColor: colors.borderColor,
                backgroundColor: colors.backgroundColor,
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: colors.pointBackgroundColor,
                pointBorderColor: colors.pointBorderColor,
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
           scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        color: colors.textColor
                    },
                    title: {
                        display: true,
                        text: 'Numero Tesseramenti',
                        color: colors.textColor
                    },
                    grid: {
                        color: colors.gridColor
                    }
                },
                x: {
                    ticks: {
                        color: colors.textColor
                    },
                    grid: {
                        color: colors.gridColor
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Totale progressivo: ' + context.parsed.y + ' tesseramenti';
                        }
                    }
                }
            }
        }
    });
</script>
@endscript