<?php

use Livewire\Component;
use Livewire\Attributes\Locked;

new class extends Component {

    #[Locked] public string $serviceClass;
    #[Locked] public string $serviceFunction;

    public string $title;
    public string $subTitle;
    public string $timeframe;
    public string $chartType;
    public string $chartAxis;
    public array  $chartData;

    public array $timeframes = [
        '7d'  => '7 Hari',
        '30d' => '30 Hari',
        '12m' => '12 Bulan',
    ];

    public function mount(
        string $title,
        string $subTitle,
        string $serviceClass,
        string $serviceFunction,
        string $chartAxis,
        string $defaultTimeframe,
        string $chartType,
    ): void {
        $this->title           = $title;
        $this->subTitle        = $subTitle;
        $this->chartAxis       = $chartAxis;
        $this->serviceClass    = $serviceClass;
        $this->serviceFunction = $serviceFunction;
        $this->timeframe       = $defaultTimeframe;
        $this->chartType       = $chartType;
        $this->fetchData();
    }

    public function setTimeframe(string $timeframe): void
    {
        $this->timeframe = $timeframe;
        $this->fetchData();
    }

    private function fetchData(): void
    {
        $service = app($this->serviceClass);
        $this->chartData = $service->{$this->serviceFunction}($this->timeframe);
        $this->dispatch('chartDataUpdated', data: $this->chartData, type: $this->chartType);
    }
};

?>

<div class="relative bg-white rounded-lg w-full p-4 border border-[#E0D2BB]">
    
    <div wire:loading class="absolute right-0 left-0 top-0 bottom-0 flex items-center justify-center rounded-md w-full h-full bg-[#E0D2BB]/20 z-20 cursor-wait"></div>

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
        <div>   
            <h3 class="font-manrope text-sm font-medium text-[#532E1C]">{{ $title }}</h3>
            <p class="font-manrope text-xs text-[#80543F]">{{ $subTitle }}</p>
        </div>
            
        <div role="group" class="flex gap-0.5 w-fit bg-[#F5F2F0] border border-[#2C180F] rounded-sm p-1" >
            @foreach($timeframes as $val => $lbl)
                <button
                    type="button"
                    wire:click="setTimeframe('{{ $val }}')"
                    @disabled($timeframe === $val)
                    class="font-manrope text-xs px-2 py-0.5 rounded-xs
                        {{ $timeframe === $val
                            ? 'text-white  bg-[#532E1C]'
                            : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                    {{ $lbl }}
                </button>
            @endforeach
        </div>
    </div>
    
    <div class="mt-4">
        <div class="relative" style="height: 250px;">
            <canvas id="chart-{{ $this->getId() }}"></canvas>
        </div>
    </div>

    @script
        <script>
            const chartCanvas   = document.getElementById('chart-{{ $this->getId() }}');
            let chart   = null;

            const COLOR      = '#532E1C';
            const COLOR_BG   = 'rgba(83,46,28,0.10)';
            const COLOR_GRID = 'rgba(83,46,28,0.08)';

            function formatData(data) {
                return {
                    labels: data.labels.map(window.utils.shortenName),
                    values: data.values
                }
            }

            function buildChart(data, type) {
                if (chart) chart.destroy();
                
                const formattedData = formatData(data);

                chart = new Chart(chartCanvas, {
                    type: type,
                    data: {
                        labels: formattedData.labels,
                        datasets: [{
                            label: @js($title),
                            data: formattedData.values,
                            borderColor: COLOR,
                            backgroundColor: type === 'line' ? COLOR_BG : COLOR,
                            borderRadius: 8,
                            pointBackgroundColor: COLOR,
                            pointRadius: 3,
                            fill: type === 'line',
                            tension: 0.4,
                        }]
                    },
                    options: {
                        indexAxis: @js($chartAxis),
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
                            } 
                        },
                        scales: {
                            x: { grid: { color: COLOR_GRID }, border: { display: false }, ticks: { maxTicksLimit: 8, maxRotation: 0 } },
                            y: { min: 0, grid: { color: COLOR_GRID }, border: { display: false } },
                        }
                    }
                });
            }

            buildChart(@js($chartData), @js($chartType));

            $wire.on('chartDataUpdated', ({ data, type }) => buildChart(data, type));
        </script>
    @endscript
</div>