import Chart from 'chart.js/auto';

// Configurazione globale
Chart.defaults.responsive = true;
Chart.defaults.maintainAspectRatio = false;

// Rendi Chart disponibile globalmente
window.Chart = Chart;

export default Chart;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
