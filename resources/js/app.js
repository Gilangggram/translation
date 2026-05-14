import 'flowbite';
import Chart from 'chart.js/auto';

import { shortenName } from './utils/shorten-name';

import { initPasswordToggle } from './modules/password-toggle';
import { initRealTimeClock  } from './modules/real-time-clock';

window.Chart = Chart;

window.utils = { 
    shortenName
}

document.addEventListener('DOMContentLoaded', () => {
    initPasswordToggle();
    initRealTimeClock();
});