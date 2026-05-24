<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component
{

    #[Reactive] public array $chartData;

    public string $title;
    public string $subTitle;

    public array $types = [
        ['key' => 'dine_in',     'label' => 'Dine In',   'color' => '#C8A876'],
        ['key' => 'delivery',    'label' => 'Delivery',  'color' => '#A0522D'],
        ['key' => 'reservation', 'label' => 'Reservasi', 'color' => '#532E1C'],
    ];

    public function mount(
        string $title,
        string $subTitle,
    ): void {
        $this->title           = $title;
        $this->subTitle        = $subTitle;
    }

    public function getTotalCount(): int
    {
        $keys = array_column($this->types, 'key');
        return array_sum(
            array_map(fn($key) => (int) ($this->chartData[$key] ?? 0), $keys)
        );
    }
 
    public function getPercentage(string $key): float
    {
        $total = $this->getTotalCount();
        $count = (int) ($this->chartData[$key] ?? 0);
        return $total > 0 ? round(($count / $total) * 100, 1) : 0;
    }

    public function updatedChartData(): void
    {
        $this->dispatch('orderTypeChartUpdate', data: array_map('intval', $this->chartData));
    }

    public function getOrderTypeClasses(string $type): string
    {
        return match ($type) {
            'dine_in'     => 'bg-[#E8D5A3] text-[#4A3510]',
            'delivery'    => 'bg-[#DEB99A] text-[#5C2E0E]',
            'reservation' => 'bg-[#C9A882] text-[#2C180F]',
        };
    }

};
?>

<div class="flex flex-col relative  bg-white rounded-lg w-full p-4 border border-[#E0D2BB]">

    <div class="flex flex-col"> 
        <h3 class="font-manrope text-sm font-medium text-[#532E1C]">{{ $title }}</h3>
        <p class="font-manrope text-xs text-[#80543F]">{{ $subTitle }}</p>
    </div>

    <div class="h-full w-full mt-4 flex flex-col items-center gap-4">
 
        <div class="relative h-30">

            <canvas id="chart-{{ $this->getId() }}" class="relative z-10"></canvas>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <span class="font-noto-serif text-xl font-bold text-[#532E1C]">
                    {{ $this->getTotalCount() }}
                </span>
                <span class="font-manrope text-xs text-[#80543F]">Total Order</span>
            </div>
        </div>
 
        <div class="flex flex-col gap-3 flex-1 w-full">

            @foreach($types as $type)
                @php
                    $count = $this->chartData[$type['key']] ?? 0;
                    $percentage   = $this->getPercentage($type['key']);
                @endphp
 
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full"
                                style="background: {{ $type['color'] }}"></span>
                            <span class="font-manrope text-xs text-[#2C180F]">{{ $type['label'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-manrope text-xs font-bold text-[#532E1C]">{{ $count }}</span>
                            <span class="font-manrope text-[10px] px-1.5 py-0.5 rounded-full font-semibold 
                                {{ $this->getOrderTypeClasses($type['key']) }}">
                                {{ $percentage }}%
                            </span>
                        </div>
                    </div>
 
                    <div class="w-full bg-[#F0E8DC] rounded-full h-1">
                        <div class="rounded-full transition-all duration-500 h-1"
                            style="width: {{ $percentage }}%; background: {{ $type['color'] }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @script
        <script>
            const chartCanvas  = document.getElementById('chart-{{ $this->getId() }}');
            let chart = null;

            const typeKeys  = @js(array_column($types, 'key'));
            const colors    = @js(array_column($types, 'color'));
            
            function buildChart(data) {      
                const counts = typeKeys.map(key => data[key] ?? 0);

                if (chart) {
                    chart.data.datasets[0].data = counts;
                    chart.update();
                    return;
                }
        
                chart = new Chart(chartCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: @js(array_column($types, 'label')),
                        datasets: [{
                            data: counts,
                            backgroundColor: colors,
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            hoverOffset: 6,
                        }]
                    },
                    options: {
                        cutout: '75%',
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend:  { display: false },
                            tooltip: {
                                callbacks: {
                                    label: (context) => {
                                        const label = context.chart.data.labels[context.dataIndex];
                                        return `${label}: ${context.parsed} order`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 600,
                            easing: 'easeInOutQuart',
                        },
                    }
                });
            }
        
            buildChart(@js($chartData));
            $wire.on('orderTypeChartUpdate', ({ data }) => buildChart(data));
        </script>
    @endscript
</div>