import Chart from 'chart.js/auto';

// Configurazione globale
Chart.defaults.responsive = true;
Chart.defaults.maintainAspectRatio = false;

// Rendi Chart disponibile globalmente
window.Chart = Chart;

export default Chart;