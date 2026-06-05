@extends('staff.stall.layout')

@section('title', "De' Pallet — Panel Stall")

@section('content')
<div class="text-[#2C1A0E] font-manrope selection:bg-[#532E1C]/10 selection:text-[#532E1C] flex flex-col p-[1.5rem] gap-[1.5rem]">

    {{-- ═══ SECTION 1 — KPI Cards ═══ --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[16px]">

        {{-- Card 1 — Total Pesanan --}}
        <div class="bg-white rounded-[16px] border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#80756A] tracking-[0.1em] uppercase">TOTAL PESANAN</span>
                <span class="text-[32px] font-extrabold text-[#2C1A0E] tracking-tight leading-none mt-2">{{ number_format($totalOrders) }}</span>
            </div>
            
            <div class="mt-[16px] pt-[12px] border-t border-[#F5EDE4] flex items-center justify-between">
                <span class="text-[12px] text-[#80756A] font-medium">Semua transaksi</span>
                <span class="inline-flex items-center gap-[4px] px-[8px] py-[2.5px] rounded-full bg-[#EBF7EE] text-[#2E7D32] text-[11px] font-bold">
                    <i class="ti ti-circle-check text-[12px]"></i>
                    Aktif
                </span>
            </div>
        </div>

        {{-- Card 2 — Total Pendapatan --}}
        <div class="bg-white rounded-[16px] border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25px_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#80756A] tracking-[0.1em] uppercase">TOTAL PENDAPATAN</span>
                <span class="text-[26px] font-extrabold text-[#2C1A0E] tracking-tight leading-none mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
            
            <div class="mt-[16px] pt-[12px] border-t border-[#F5EDE4] flex items-center justify-between">
                <span class="text-[12px] text-[#80756A] font-medium">Pendapatan kotor</span>
                <span class="inline-flex items-center gap-[4px] px-[8px] py-[2.5px] rounded-full bg-[#EBF7EE] text-[#2E7D32] text-[11px] font-bold">
                    <i class="ti ti-trending-up text-[12px]"></i>
                    Terbayar
                </span>
            </div>
        </div>

        {{-- Card 3 — Pesanan Masuk --}}
        <a href="{{ route('stall.pesananmasuk') }}" class="bg-white rounded-[16px] border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25px_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
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
        <div class="bg-white rounded-[16px] border border-[#E5DCCE] p-[1.5rem] flex flex-col justify-between shadow-[0_4px_25px_rgba(44,26,14,0.04)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.08)] transition-all duration-300 relative overflow-hidden group">
            
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
        <div class="lg:col-span-6 bg-white rounded-[16px] border border-[#E5DCCE] p-[1.25rem] flex flex-col shadow-[0_4px_20px_-4px_rgba(44,26,14,0.06)]">
            <div class="flex justify-between items-center mb-[14px]">
                <div class="flex items-center gap-2">
                    <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                    <span class="text-[15px] font-bold text-[#2C1A0E]">Tren Pendapatan</span>
                </div>
                
                {{-- Dropdown Filter --}}
                <div class="relative w-[135px] shrink-0">
                    <select onchange="filterTrendDays(this.value)" class="w-full appearance-none bg-[#FAF7F4] border border-[#E0D8CF] rounded-[8px] text-[11px] text-[#80756A] font-bold px-[10px] py-[4.5px] pr-[24px] focus:outline-none focus:border-[#532E1C] cursor-pointer">
                        <option value="7" {{ $trendDays === 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30" {{ $trendDays === 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-[8px] pointer-events-none text-[#80756A]">
                        <i class="ti ti-chevron-down text-[10px]"></i>
                    </span>
                </div>
            </div>

            {{-- SVG Chart --}}
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
                <svg id="revenue-svg" viewBox="0 0 500 155" class="w-full h-full overflow-visible" style="overflow: visible;">
                    <defs>
                        <linearGradient id="revenueGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%"   stop-color="#532E1C" stop-opacity="0.20"/>
                            <stop offset="100%" stop-color="#532E1C" stop-opacity="0.00"/>
                        </linearGradient>
                    </defs>

                    {{-- Grid lines --}}
                    @for($gl = 0; $gl <= 4; $gl++)
                    @php $gy = 20 + $gl * 25; @endphp
                    <line x1="30" y1="{{ $gy }}" x2="450" y2="{{ $gy }}" stroke="#F0EAE1" stroke-width="1" stroke-dasharray="4,4"/>
                    @endfor

                    {{-- Axis --}}
                    <line x1="30" y1="120" x2="450" y2="120" stroke="#E5DCCE" stroke-width="1.5" stroke-linecap="round"/>

                    {{-- Tick marks --}}
                    @foreach($points as $pt)
                    <line x1="{{ $pt['x'] }}" y1="120" x2="{{ $pt['x'] }}" y2="125" stroke="#D3C7B5" stroke-width="1.5"/>
                    @endforeach

                    {{-- Area fill --}}
                    @if($areaPath)
                    <path d="{{ $areaPath }}" fill="url(#revenueGradient)"/>
                    @endif

                    {{-- Line --}}
                    @if($linePath)
                    <path d="{{ $linePath }}" fill="none" stroke="#532E1C" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    @endif

                    {{-- Dots --}}
                    @foreach($points as $idx => $pt)
                        @if($idx === $highestIdx && $pt['amount'] > 0)
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="9" fill="#532E1C" fill-opacity="0.12" class="animate-pulse"/>
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="4.5" fill="#532E1C" stroke="#FFFFFF" stroke-width="2"
                            class="chart-dot cursor-pointer"
                            data-day="{{ $pt['day'] }}" data-amount="{{ number_format($pt['amount'], 0, ',', '.') }}"/>
                        @elseif($pt['amount'] > 0)
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="3.5" fill="#C5A880" stroke="#FFFFFF" stroke-width="1.5"
                            class="chart-dot cursor-pointer"
                            data-day="{{ $pt['day'] }}" data-amount="{{ number_format($pt['amount'], 0, ',', '.') }}"/>
                        @else
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="2.5" fill="#D3C7B5" stroke="#FFFFFF" stroke-width="1"
                            class="chart-dot cursor-pointer"
                            data-day="{{ $pt['day'] }}" data-amount="0"/>
                        @endif
                    @endforeach

                    {{-- X-axis labels (hanya tampil jika label tidak kosong) --}}
                    @foreach($points as $pt)
                    @if($pt['day'] !== '')
                    <text x="{{ $pt['x'] }}" y="142" text-anchor="middle" fill="#80756A" font-size="11" font-weight="bold" font-family="Manrope, sans-serif">{{ $pt['day'] }}</text>
                    @endif
                    @endforeach

                    {{-- Y-axis label: max value --}}
                    @php $maxAmt = collect($points)->max('amount'); @endphp
                    @if($maxAmt > 0)
                    <text x="25" y="23" text-anchor="end" fill="#B5A898" font-size="9" font-family="Manrope, sans-serif">{{ number_format($maxAmt/1000, 0) }}k</text>
                    @endif
                </svg>

                {{-- Tooltip --}}
                <div id="chart-tooltip"
                    class="absolute z-50 bg-[#532E1C] text-white text-[11px] font-bold px-[10px] py-[6px] rounded-[8px] shadow-lg pointer-events-none opacity-0 transition-opacity duration-150 whitespace-nowrap"
                    style="transform: translate(-50%, -100%) translateY(-10px);">
                    <span id="tooltip-day"></span>: <span class="text-[#C5A880]">Rp</span> <span id="tooltip-amount"></span>
                </div>
                @endif
            </div>
        </div>

        {{-- Right: Menu Terlaris Donut (40%) --}}
        <div class="lg:col-span-4 bg-white rounded-[16px] border border-[#E5DCCE] p-[1.25rem] flex flex-col shadow-[0_4px_20px_-4px_rgba(44,26,14,0.06)]">
            <div class="flex items-center gap-2 mb-[8px]">
                <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                <span class="text-[15px] font-bold text-[#2C1A0E]">Menu Terlaris</span>
            </div>

            @php
                $c          = 245.04;
                $gap        = 3;
                $numSegs    = count($menuData);
                $usableCirc = $c - ($numSegs * $gap);

                $dash  = [];
                $off   = [];
                $cumul = 0;
                foreach ($menuData as $i => $item) {
                    $d       = ($item['percentage'] / 100) * $usableCirc;
                    $dash[]  = $d;
                    $off[]   = -$cumul;
                    $cumul  += $d + $gap;
                }
            @endphp

            @if(empty($menuData))
            <div class="flex-1 flex flex-col items-center justify-center gap-2 text-[#80756A] py-8">
                <i class="ti ti-bowl text-[32px] opacity-30"></i>
                <span class="text-[12px] font-semibold opacity-60 text-center">Belum ada data penjualan</span>
            </div>
            @else
            {{-- Donut Chart --}}
            <div class="relative w-full flex justify-center items-center py-[10px]">
                <svg width="136" height="136" viewBox="0 0 100 100" class="transform -rotate-90 drop-shadow-sm">
                    {{-- Background --}}
                    <circle cx="50" cy="50" r="39" fill="transparent" stroke="#F8F5F2" stroke-width="13"/>

                    @php $colors = ['#532E1C', '#C5A880', '#E5DCCE']; @endphp

                    {{-- Segments (render in reverse so segment 1 is on top) --}}
                    @for($si = count($menuData) - 1; $si >= 0; $si--)
                    @if(isset($dash[$si]) && $dash[$si] > 0)
                    <circle cx="50" cy="50" r="39"
                        fill="transparent"
                        stroke="{{ $colors[$si] ?? '#CCC' }}"
                        stroke-width="13"
                        stroke-dasharray="{{ $dash[$si] }} {{ $c - $dash[$si] }}"
                        stroke-dashoffset="{{ $off[$si] }}"
                        stroke-linecap="butt"/>
                    @endif
                    @endfor
                </svg>

                {{-- Center label --}}
                <div class="absolute flex flex-col items-center justify-center text-center">
                    <span class="text-[24px] font-extrabold text-[#2C1A0E] leading-none tracking-tight">{{ $menuData[0]['percentage'] ?? 0 }}%</span>
                    <span class="text-[9px] text-[#80756A] font-bold mt-[3px] uppercase tracking-wider">Top Menu</span>
                </div>
            </div>

            {{-- Legend --}}
            <div class="flex flex-col gap-[6px] mt-[8px] pt-[10px] border-t border-[#F8F5F2]">
                @foreach($menuData as $idx => $item)
                <div class="flex justify-between items-center text-[13px] px-1 hover:bg-[#FAF8F5] rounded-lg py-[5px] transition-colors duration-200">
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
        <div class="bg-white rounded-[16px] border border-[#E5DCCE] p-[1.25rem] shadow-[0_4px_20px_-4px_rgba(44,26,14,0.06)]">
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
function filterTrendDays(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('trend_days', val);
    window.location.href = url.toString();
}

(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var wrapper = document.getElementById('revenue-chart-wrapper');
        var tooltip = document.getElementById('chart-tooltip');
        var tipDay  = document.getElementById('tooltip-day');
        var tipAmt  = document.getElementById('tooltip-amount');

        if (!wrapper || !tooltip) return;

        var dots = wrapper.querySelectorAll('.chart-dot');
        dots.forEach(function (dot) {
            dot.addEventListener('mouseenter', function () {
                tipDay.textContent = dot.dataset.day;
                tipAmt.textContent = dot.dataset.amount;

                var rect    = wrapper.getBoundingClientRect();
                var dotRect = dot.getBoundingClientRect();
                var leftPx  = dotRect.left - rect.left + dotRect.width / 2;
                var topPx   = dotRect.top  - rect.top;

                tooltip.style.left    = leftPx + 'px';
                tooltip.style.top     = topPx  + 'px';
                tooltip.style.opacity = '1';
            });
            dot.addEventListener('mouseleave', function () {
                tooltip.style.opacity = '0';
            });
        });
    });
})();
</script>
@endpush
