@props(['data','labels', 'backgroundColors', 'borderColors'])

<div
    class="w-full h-85 text-center shadow rounded bg-white dark:bg-zinc-800 border  border-neutral-300 dark:border-neutral-700">
    <h3 class="font-medium my-3">Corsi</h3>
    <div class="w-full h-65 px-5  overflow-hidden">
        <canvas id="myChartCourses"></canvas>
    </div>
</div>
{{--
@script
<script>
    const ctx = document.getElementById('myChartCourses');
    
    const labels = @json($labels);
    const data = @json($data);
    const backgroundColors = @json($backgroundColors);
    const borderColors = @json($borderColors);

      // Funzione per tradurre gli status in italiano
    const traduciStatus = (status) => {
        const traduzioni = {
            'active': 'Attivo',
            'suspended': 'Sospeso',
            'cancelled': 'Annullato',
            'canceled': 'Cancellato',
            'completed': 'Completato',
            'pending': 'In attesa',
            'started': 'Avviato',
        };
        return traduzioni[status.toLowerCase()] || status;
    };
 
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Numero Corsi',
                data: data,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Numero di Corsi'
                    }
                },
                x: {
                    title: {
                        display: false,
                        text: 'Status Corso'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false,
                    text: 'Distribuzione Corsi per Status'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y + ' corsi';
                        }
                    }
                }
            }
        }
    });
</script>
@endscript --}}

@script
<script>
    const ctx = document.getElementById('myChartCourses');
    
    const labels = @json($labels);
    const data = @json($data);
    const backgroundColors = @json($backgroundColors);
    const borderColors = @json($borderColors);

    // Funzione per verificare se il tema è dark
    function isDarkMode() {
       return document.documentElement.classList.contains('dark');
    }
    
    // Colori adattivi per il testo e le griglie
    function getChartColors() {
        if (isDarkMode()) {
            return {
                gridColor: 'rgba(255, 255, 255, 0.1)',
                textColor: '#e5e7eb'  
            };
        } else {
            return {
                gridColor: 'rgba(0, 0, 0, 0.1)',
                textColor: '#374151'  
            };
        }
    }
    
    const colors = getChartColors();

    // Funzione per tradurre gli status in italiano
    const traduciStatus = (status) => {
        const traduzioni = {
            'active': 'Attivo',
            'suspended': 'Sospeso',
            'cancelled': 'Annullato',
            'canceled': 'Cancellato',
            'completed': 'Completato',
            'pending': 'In attesa',
            'started': 'Avviato',
        };
        return traduzioni[status.toLowerCase()] || status;
    };
 
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Numero Corsi',
                data: data,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: colors.textColor
                    },
                    title: {
                        display: true,
                        text: 'Numero di Corsi',
                        color: colors.textColor
                    },
                    grid: {
                        color: colors.gridColor
                    }
                },
                x: {
                    title: {
                        display: false,
                        text: 'Status Corso'
                    },
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
                    display: false,
                    labels: {
                        color: colors.textColor
                    }
                },
                title: {
                    display: false,
                    text: 'Distribuzione Corsi per Status',
                    color: colors.textColor
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y + ' corsi';
                        }
                    }
                }
            }
        }
    });
</script>
@endscript