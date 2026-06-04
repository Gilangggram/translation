import 'flowbite';
import Chart from 'chart.js/auto';

import { initPasswordToggle } from './modules/password-toggle';
import { initRealTimeClock  } from './modules/real-time-clock';
import { initGeneratePassword } from './modules/password-generate';

window.Chart = Chart;

document.addEventListener('DOMContentLoaded', () => {
    initPasswordToggle();
    initRealTimeClock();
    initGeneratePassword();
});