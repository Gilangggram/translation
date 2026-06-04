const DAYS   = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Fri', 'Sab'];
const MONTHS  = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

export function initRealTimeClock() {

    const clockElement = document.getElementById('clock');
    if (!clockElement) return;

    function updateClock() {
        const now     = new Date();
        
        const day     = DAYS[now.getDay()];
        const date    = now.getDate();
        const month   = MONTHS[now.getMonth()];
        
        const hours   = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        clockElement.textContent = 
            `${day}, ${date} ${month} - ${hours}:${minutes}:${seconds}`;
    }

    updateClock();
    setInterval(updateClock, 1000);
}

