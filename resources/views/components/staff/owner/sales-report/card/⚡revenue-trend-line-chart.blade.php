<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component {

    #[Reactive] public array $chartData;

    public string $title;
    public string $subTitle;

    public function mount(
        string $title,
        string $subTitle,
    ): void {
        $this->title           = $title;
        $this->subTitle        = $subTitle;
    }

    public function updatedChartData(): void
    {
        if(!empty($this->chartData)) {
            $this->dispatch('revenueTrendChartUpdate', data: $this->chartData);
        }
    }
};

?>

<div class="relative bg-white rounded-lg w-full p-4 border border-[#E0D2BB]">
    
    <div class="flex flex-col">  
        <h3 class="font-manrope text-sm font-medium text-[#532E1C]">{{ $title }}</h3>
        <p class="font-manrope text-xs text-[#80543F]">{{ $subTitle }}</p>
    </div>
    
    <div class="mt-4">
        <div class="relative h-60">
            @if(empty($chartData))
                <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                    <i class="bi bi-graph-up-arrow text-3xl text-[#C5A880]"></i>
                    <p class="font-manrope text-sm text-[#80543F]">Ubah filter untuk melihat tren pendapatan</p>
                </div>
            @else
                <canvas id="chart-{{ $this->getId() }}" style="height: 250px;"></canvas>
            @endif
        </div>
    </div>

    @script
        <script>
            let chart   = null;

            const COLOR      = '#532E1C';
            const COLOR_BG   = 'rgba(83,46,28,0.10)';
            const COLOR_GRID = 'rgba(83,46,28,0.08)';

            function formatData(data) {
                return {
                    labels: data.dates.map(window.utils.shortenName),
                    values: data.cafe_revenue
                }
            }

            function buildChart(data) {
                if (chart) chart.destroy();

                const chartCanvas   = document.getElementById('chart-{{ $this->getId() }}');
                if (!chartCanvas) {
                    return;
                }
                
                const formattedData = formatData(data);

                chart = new Chart(chartCanvas, {
                    type: "line",
                    data: {
                        labels: formattedData.labels,
                        datasets: [{
                            label: @js($title),
                            data: formattedData.values,
                            borderColor: COLOR,
                            backgroundColor: COLOR_BG,
                            borderRadius: 8,
                            pointBackgroundColor: COLOR,
                            pointRadius: 3,
                            fill: true,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false }, 
                            tooltip: {
                                backgroundColor:'#2C180F',
                                titleColor:'#fff',
                                bodyColor:'rgba(255,255,255,0.8)',
                                padding:10,
                                cornerRadius:8,
                                callbacks: {
                                    label: (context) => {
                                        return ` ${context.dataset.label}: Rp ${context.parsed.y}`;
                                    }
                                }
                            } 
                        },
                        animation: {
                            duration: 600,
                            easing: 'easeInOutQuart',
                        },
                        animations: {
                            x: { duration: 0 },
                            y: {
                                from: (context) => {
                                    if (context.type === 'data' && context.mode === 'default') {
                                        return context.chart.scales.y.getPixelForValue(0);
                                    }
                                },
                                duration: 600,
                                easing: 'easeInOutQuart',
                            },
                        },
                        scales: {
                            x: { grid: { color: COLOR_GRID }, border: { display: false }, ticks: { maxRotation: 0 } },
                            y: { min: 0, grid: { color: COLOR_GRID }, border: { display: false } },
                        }
                    }
                });
            }

            buildChart(@js($chartData));

            $wire.on('revenueTrendChartUpdate', ({ data }) => buildChart(data));
        </script>
    @endscript
</div>