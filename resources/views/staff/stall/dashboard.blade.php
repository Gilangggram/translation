@extends('staff.stall.layout')

@section('title', "De' Pallet — Panel Stall")

@section('content')
<div class="text-[#2C1A0E] font-manrope selection:bg-[#532E1C]/10 selection:text-[#532E1C] flex flex-col p-[1.5rem] gap-[1.5rem]">

    {{-- ═══ SECTION 1 — KPI Cards ═══ --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[16px]">

        {{-- Card 1 — Total Pesanan --}}
        <div class="bg-white rounded-none border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#80756A] tracking-[0.1em] uppercase">TOTAL PESANAN</span>
                <span class="text-[32px] font-extrabold text-[#2C1A0E] tracking-tight leading-none mt-2">{{ number_format($totalOrders) }}</span>
            </div>
            
            <div class="mt-[16px] pt-[12px] border-t border-[#F5EDE4] flex items-center justify-between">
                <span class="text-[12px] text-[#80756A] font-medium">
                    @if($kpiDays === 7)
                        7 Hari Terakhir
                    @elseif($kpiDays === 30)
                        30 Hari Terakhir
                    @else
                        12 Bulan Terakhir
                    @endif
                </span>
                <div class="relative inline-flex items-center">
                    <select onchange="filterKPI(this.value)" class="appearance-none bg-[#FAF8F5] border border-[#D8CFC7] rounded-none text-[10px] text-[#2C1A0E] pl-2 pr-5 py-0.5 font-bold cursor-pointer focus:outline-none focus:border-[#532E1C] transition-colors select-none">
                        <option value="7" {{ $kpiDays === 7 ? 'selected' : '' }}>7 Hari</option>
                        <option value="30" {{ $kpiDays === 30 ? 'selected' : '' }}>30 Hari</option>
                        <option value="365" {{ $kpiDays === 365 ? 'selected' : '' }}>12 Bulan</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-1.5 pointer-events-none text-[#80756A] text-[8px]">
                        <i class="ti ti-chevron-down"></i>
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 2 — Total Pendapatan --}}
        <div class="bg-white rounded-none border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25px_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#80756A] tracking-[0.1em] uppercase">TOTAL PENDAPATAN</span>
                <span class="text-[26px] font-extrabold text-[#2C1A0E] tracking-tight leading-none mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
            
            <div class="mt-[16px] pt-[12px] border-t border-[#F5EDE4] flex items-center justify-between">
                <span class="text-[12px] text-[#80756A] font-medium">
                    @if($kpiDays === 7)
                        7 Hari Terakhir
                    @elseif($kpiDays === 30)
                        30 Hari Terakhir
                    @else
                        12 Bulan Terakhir
                    @endif
                </span>
                <div class="relative inline-flex items-center">
                    <select onchange="filterKPI(this.value)" class="appearance-none bg-[#FAF8F5] border border-[#D8CFC7] rounded-none text-[10px] text-[#2C1A0E] pl-2 pr-5 py-0.5 font-bold cursor-pointer focus:outline-none focus:border-[#532E1C] transition-colors select-none">
                        <option value="7" {{ $kpiDays === 7 ? 'selected' : '' }}>7 Hari</option>
                        <option value="30" {{ $kpiDays === 30 ? 'selected' : '' }}>30 Hari</option>
                        <option value="365" {{ $kpiDays === 365 ? 'selected' : '' }}>12 Bulan</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-1.5 pointer-events-none text-[#80756A] text-[8px]">
                        <i class="ti ti-chevron-down"></i>
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 3 — Pesanan Masuk --}}
        <a href="{{ route('stall.pesananmasuk') }}" class="bg-white rounded-none border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25px_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#80756A] tracking-[0.1em] uppercase">PESANAN MASUK</span>
                <span class="text-[32px] font-extrabold text-[#2C1A0E] tracking-tight leading-none mt-2">{{ sprintf('%02d', $incomingOrdersCount) }}</span>
            </div>
            
            <div class="mt-[16px] pt-[12px] border-t border-[#F5EDE4] flex items-center justify-between">
                <span class="text-[12px] text-[#80756A] font-medium">Antrian aktif</span>
                @if($incomingOrdersCount > 0)
                <span class="inline-flex items-center gap-[4px] px-[8px] py-[2.5px] rounded-full bg-[#EBF7EE] text-[#2E7D32] text-[11px] font-bold animate-pulse">
                    <i class="ti ti-bolt text-[11px]"></i>
                    Segera Proses
                </span>
                @else
                <span class="inline-flex items-center gap-[4px] px-[8px] py-[2.5px] rounded-full bg-[#FAF7F4] text-[#80756A] text-[11px] font-bold border border-[#E0D8CF]">
                    <i class="ti ti-circle-check text-[12px]"></i>
                    Semua Beres
                </span>
                @endif
            </div>
        </a>

        {{-- Card 4 — Menu Tersedia --}}
        <div class="bg-white rounded-none border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25px_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#80756A] tracking-[0.1em] uppercase">MENU TERSEDIA</span>
                <span class="text-[32px] font-extrabold text-[#2C1A0E] tracking-tight leading-none mt-2">
                    {{ $availableMenus }}<span class="text-[18px] text-[#80756A] font-semibold">/{{ $totalMenus }}</span>
                </span>
            </div>
            
            <div class="mt-[16px] pt-[12px] border-t border-[#F5EDE4] flex items-center justify-between">
                <span class="text-[12px] text-[#80756A] font-medium">Kelola ketersediaan</span>
                @if($totalMenus > $availableMenus)
                <span class="inline-flex items-center gap-[4px] px-[8px] py-[2.5px] rounded-full bg-[#FCE8E6] text-[#C62828] text-[11px] font-bold">
                    <i class="ti ti-alert-circle text-[12px] animate-pulse"></i>
                    {{ $totalMenus - $availableMenus }} Habis
                </span>
                @else
                <span class="inline-flex items-center gap-[4px] px-[8px] py-[2.5px] rounded-full bg-[#EBF7EE] text-[#2E7D32] text-[11px] font-bold">
                    <i class="ti ti-circle-check text-[12px]"></i>
                    Semua Ready
                </span>
                @endif
            </div>
        </div>

    </section>

    {{-- ═══ SECTION 2 — Charts ═══ --}}
    <section class="grid grid-cols-1 lg:grid-cols-10 gap-[16px]">

        {{-- Left: Tren Pendapatan (60%) --}}
        <div class="lg:col-span-6 bg-white rounded-none border border-[#E5DCCE] p-[1.25rem] flex flex-col shadow-[0_4px_20px_-4px_rgba(44,26,14,0.06)]">
            <div class="flex justify-between items-center mb-[14px]">
                <div class="flex items-center gap-2">
                    <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                    <span class="text-[15px] font-bold text-[#2C1A0E]">Tren Pendapatan</span>
                </div>
                
                {{-- Timeframe Button Group Filter --}}
                <div role="group" class="flex gap-0.5 w-fit bg-[#F5F2F0] border border-[#2C180F] rounded-none p-1 no-print">
                    <button type="button" onclick="filterTrendDays(7)" 
                        class="font-manrope text-[11px] px-2 py-0.5 rounded-none transition-all {{ $trendDays === 7 ? 'text-white bg-[#532E1C]' : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                        7 Hari
                    </button>
                    <button type="button" onclick="filterTrendDays(30)" 
                        class="font-manrope text-[11px] px-2 py-0.5 rounded-none transition-all {{ $trendDays === 30 ? 'text-white bg-[#532E1C]' : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                        30 Hari
                    </button>
                    <button type="button" onclick="filterTrendDays(365)" 
                        class="font-manrope text-[11px] px-2 py-0.5 rounded-none transition-all {{ $trendDays === 365 ? 'text-white bg-[#532E1C]' : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                        12 Bulan
                    </button>
                </div>
            </div>

            {{-- Chart.js Line Chart --}}
            <div class="w-full h-[170px] relative mt-2" id="revenue-chart-wrapper">
                @php
                    $hasData = collect($points)->sum('amount') > 0;
                @endphp

                @if(!$hasData || count($points) === 0)
                {{-- Empty State --}}
                <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-[#80756A]">
                    <i class="ti ti-chart-line text-[32px] opacity-30"></i>
                    <span class="text-[12px] font-semibold opacity-60">Belum ada data pendapatan minggu ini</span>
                </div>
                @else
                <canvas id="revenue-chart" style="height: 170px;"></canvas>
                @endif
            </div>
        </div>

        {{-- Right: Menu Terlaris Donut (40%) --}}
        <div class="lg:col-span-4 bg-white rounded-none border border-[#E5DCCE] p-[1.25rem] flex flex-col shadow-[0_4px_20px_-4px_rgba(44,26,14,0.06)] font-manrope">
            <div class="flex justify-between items-center mb-[8px]">
                <div class="flex items-center gap-2">
                    <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                    <span class="text-[15px] font-bold text-[#2C1A0E]">Menu Terlaris</span>
                </div>

                {{-- Timeframe Button Group Filter --}}
                <div role="group" class="flex gap-0.5 w-fit bg-[#F5F2F0] border border-[#2C180F] rounded-none p-1 no-print">
                    <button type="button" onclick="filterDonutDays(7)" 
                        class="font-manrope text-[11px] px-2 py-0.5 rounded-none transition-all {{ $donutDays === 7 ? 'text-white bg-[#532E1C]' : 'text-[#2C1A0E] hover:bg-[#D2C2BC] cursor-pointer' }}">
                        7 Hari
                    </button>
                    <button type="button" onclick="filterDonutDays(30)" 
                        class="font-manrope text-[11px] px-2 py-0.5 rounded-none transition-all {{ $donutDays === 30 ? 'text-white bg-[#532E1C]' : 'text-[#2C1A0E] hover:bg-[#D2C2BC] cursor-pointer' }}">
                        30 Hari
                    </button>
                    <button type="button" onclick="filterDonutDays(365)" 
                        class="font-manrope text-[11px] px-2 py-0.5 rounded-none transition-all {{ $donutDays === 365 ? 'text-white bg-[#532E1C]' : 'text-[#2C1A0E] hover:bg-[#D2C2BC] cursor-pointer' }}">
                        12 Bulan
                    </button>
                </div>
            </div>

            @if(empty($menuData))
            <div class="flex-1 flex flex-col items-center justify-center gap-2 text-[#80756A] py-8">
                <i class="ti ti-bowl text-[32px] opacity-30"></i>
                <span class="text-[12px] font-semibold opacity-60 text-center">Belum ada data penjualan</span>
            </div>
            @else
            {{-- Chart.js Donut Chart --}}
            <div class="relative w-full flex justify-center items-center py-[10px] h-[136px]">
                <canvas id="best-sellers-chart" style="height: 136px; width: 136px;"></canvas>

                {{-- Center label --}}
                <div class="absolute flex flex-col items-center justify-center text-center pointer-events-none">
                    <span class="text-[24px] font-extrabold text-[#2C1A0E] leading-none tracking-tight">{{ $menuData[0]['percentage'] ?? 0 }}%</span>
                    <span class="text-[9px] text-[#80756A] font-bold mt-[3px] uppercase tracking-wider">Top Menu</span>
                </div>
            </div>

            {{-- Legend --}}
            @php $colors = ['#532E1C', '#C5A880', '#E5DCCE']; @endphp
            <div class="flex flex-col gap-[6px] mt-[8px] pt-[10px] border-t border-[#F8F5F2]">
                @foreach($menuData as $idx => $item)
                <div class="flex justify-between items-center text-[13px] px-1 hover:bg-[#FAF8F5] rounded-none py-[5px] transition-colors duration-200">
                    <div class="flex items-center gap-[8px]">
                        <span class="w-[8px] h-[8px] rounded-full flex-shrink-0" style="background-color: {{ $colors[$idx] ?? '#CCC' }}"></span>
                        <span class="text-[#80756A] font-semibold truncate max-w-[130px]" title="{{ $item['name'] }}">{{ $item['name'] }}</span>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <span class="font-bold text-[#2C1A0E]">{{ $item['percentage'] }}%</span>
                        @if(isset($item['qty']))
                        <span class="text-[10px] text-[#B5A898]">({{ $item['qty'] }}x)</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </section>

    {{-- ═══ SECTION 3 — Riwayat Pesanan Selesai ═══ --}}
    <section class="mb-[1rem]">
        <div class="bg-white rounded-none border border-[#E5DCCE] p-[1.25rem] shadow-[0_4px_20px_-4px_rgba(44,26,14,0.06)]">
            <div class="flex justify-between items-center mb-[14px]">
                <div class="flex items-center gap-2">
                    <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                    <span class="text-[15px] font-bold text-[#2C1A0E]">Riwayat Pesanan Selesai <span class="text-[#80756A] font-normal">(Terbaru)</span></span>
                </div>
                <a href="{{ route('stall.pesananmasuk') }}" class="text-[12px] text-[#80756A] font-bold hover:text-[#532E1C] underline transition-colors">
                    Lihat Antrian →
                </a>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse table-fixed min-w-[640px]">
                    <thead>
                        <tr class="border-b border-[#E5DCCE]">
                            <th class="w-[14%] pb-[10px] text-[11px] font-bold text-[#80756A] uppercase tracking-[0.08em]">ORDER #</th>
                            <th class="w-[34%] pb-[10px] text-[11px] font-bold text-[#80756A] uppercase tracking-[0.08em]">MENU</th>
                            <th class="w-[12%] pb-[10px] text-[11px] font-bold text-[#80756A] uppercase tracking-[0.08em] text-center">WAKTU</th>
                            <th class="w-[12%] pb-[10px] text-[11px] font-bold text-[#80756A] uppercase tracking-[0.08em] text-center">MEJA</th>
                            <th class="w-[16%] pb-[10px] text-[11px] font-bold text-[#80756A] uppercase tracking-[0.08em] text-right">TOTAL STALL</th>
                            <th class="w-[12%] pb-[10px] text-[11px] font-bold text-[#80756A] uppercase tracking-[0.08em] text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8E0D8]/60">
                        @forelse($completedOrders as $order)
                        @php
                            $stallTotal  = $order->orderItems->sum('total_price');
                            $itemSummary = $order->orderItems->map(function($item) {
                                $name = $item->menu->name ?? 'Menu';
                                return "{$item->quantity}× {$name}";
                            })->join(', ');
                        @endphp
                        <tr class="hover:bg-[#FAF8F5]/70 transition-colors duration-200 cursor-pointer" onclick="showOrderDetail(this, event)" data-order="{{ json_encode($order) }}">
                            <td class="py-[11px] text-[13px] font-bold text-[#2C1A0E] truncate" title="{{ $order->order_number }}">
                                {{ $order->order_number }}
                            </td>
                            <td class="py-[11px] text-[13px] text-[#80756A]">
                                <span class="block truncate" title="{{ $itemSummary }}">{{ $itemSummary ?: '—' }}</span>
                            </td>
                            <td class="py-[11px] text-[13px] text-[#2C1A0E] text-center">
                                {{ $order->created_at->format('H:i') }}
                            </td>
                            <td class="py-[11px] text-[13px] text-[#2C1A0E] text-center">
                                {{ $order->table ? 'Meja ' . sprintf('%02d', $order->table->table_number) : 'Takeaway' }}
                            </td>
                            <td class="py-[11px] text-[13px] font-bold text-[#2C1A0E] text-right">
                                Rp {{ number_format($stallTotal, 0, ',', '.') }}
                            </td>
                            <td class="py-[11px] text-center">
                                <span class="inline-block px-[10px] py-[3px] bg-[#E8F8EA] text-[#1B5E20] text-[11px] font-bold rounded-full border border-[#1B5E20]/10 tracking-wider">
                                    SELESAI
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-[36px] text-center">
                                <div class="flex flex-col items-center gap-2 text-[#80756A]">
                                    <i class="ti ti-clipboard-off text-[30px] opacity-30"></i>
                                    <span class="text-[13px] italic opacity-70">Belum ada riwayat pesanan selesai untuk hari ini.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
function filterKPI(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('kpi_days', val);
    window.location.href = url.toString();
}

function filterTrendDays(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('trend_days', val);
    window.location.href = url.toString();
}

function filterDonutDays(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('donut_days', val);
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', function () {
    // ── 1. Line Chart: Tren Pendapatan ──
    const trendCanvas = document.getElementById('revenue-chart');
    if (trendCanvas) {
        const points = @js($points);
        const labels = points.map(pt => pt.day);
        const values = points.map(pt => pt.amount);

        const COLOR      = '#2C180F';
        const COLOR_BG   = 'rgba(83,46,28,0.10)';
        const COLOR_GRID = 'rgba(83,46,28,0.08)';

        new Chart(trendCanvas, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Pendapatan",
                    data: values,
                    borderColor: COLOR,
                    backgroundColor: COLOR_BG,
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
                        backgroundColor: '#2C180F',
                        titleColor: '#fff',
                        bodyColor: 'rgba(255,255,255,0.8)',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: (context) => {
                                return ` Pendapatan: Rp ${context.parsed.y.toLocaleString('id-ID')}`;
                            }
                        }
                    } 
                },
                animation: {
                    duration: 600,
                    easing: 'easeInOutQuart',
                },
                scales: {
                    x: { grid: { color: COLOR_GRID }, border: { display: false }, ticks: { maxRotation: 0 } },
                    y: { min: 0, grid: { color: COLOR_GRID }, border: { display: false } },
                }
            }
        });
    }

    // ── 2. Donut Chart: Menu Terlaris ──
    const sellersCanvas = document.getElementById('best-sellers-chart');
    if (sellersCanvas) {
        const menuData = @js($menuData);
        const labels = menuData.map(item => item.name);
        const values = menuData.map(item => item.qty);

        new Chart(sellersCanvas, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: ['#532E1C', '#C5A880', '#E5DCCE'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 6,
                }]
            },
            options: {
                cutout: '75%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#2C180F',
                        titleColor: '#fff',
                        bodyColor: 'rgba(255,255,255,0.8)',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: (context) => {
                                const label = context.label;
                                return ` ${label}: ${context.parsed} porsi`;
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
});
</script>
@endpush
