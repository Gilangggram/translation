import 'flowbite';
import Chart from 'chart.js/auto';

import { initPasswordToggle } from './modules/password-toggle';
window.Chart = Chart;

document.addEventListener('DOMContentLoaded', () => {
    initPasswordToggle();
});