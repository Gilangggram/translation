@extends('staff.stall.layout')

@section('title', "De' Pallet — Laporan Penjualan Stall")

@section('content')
<style>
    /* Styling khusus cetak laporan */
    @media print {
        /* Sembunyikan elemen navigasi, sidebar, topbar, dan filter */
        #sidebar, 
        aside, 
        nav, 
        header, 
        #topbar, 
        .no-print, 
        #filters-container, 
        #btn-print-report,
        .report-dot {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* Reset latar belakang halaman utama agar putih bersih (hemat tinta) */
        body, html, main, .print-wrapper, .min-h-screen, .bg-\[\#F0E7D8\] {
            background: #FFFFFF !important;
            background-color: #FFFFFF !important;
            color: #000000 !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            min-height: auto !important;
            display: block !important;
            box-shadow: none !important;
        }

        /* Container laporan cetak */
        .print-wrapper {
            padding: 10px !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Card laporan saat dicetak */
        .print-card {
            border: 1px solid #CCCCCC !important;
            box-shadow: none !important;
            border-radius: 6px !important;
            margin-bottom: 20px !important;
            background: #FFFFFF !important;
            page-break-inside: avoid !important;
            padding: 1rem !important;
        }

        /* Judul Cetak Laporan */
        .print-title {
            display: block !important;
            border-bottom: 2px solid #3B1F0F !important;
            padding-bottom: 8px !important;
            margin-bottom: 20px !important;
        }

        .print-title h1 {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #2C1A0E !important;
            text-align: left !important;
            margin: 0 !important;
        }

        .print-title h2 {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #532E1C !important;
            margin-top: 4px !important;
        }

        .print-title p {
            font-size: 10px !important;
            color: #666666 !important;
            margin-top: 4px !important;
        }

        /* Penyelarasan tata letak grafik & KPI */
        .grid, .flex-col, .lg:flex-row {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 16px !important;
        }

        /* Kartu KPI lebar penuh atau setengah lebar */
        .grid > div, section.grid > div {
            flex: 1 1 calc(50% - 16px) !important;
            max-width: calc(50% - 16px) !important;
        }

        /* Chart Canvas */
        #report-chart-wrapper, canvas {
            page-break-inside: avoid !important;
            max-width: 100% !important;
        }

        /* Penyesuaian Tabel Laporan agar kontras dan hemat tinta */
        .overflow-x-auto {
            border: none !important;
            overflow: visible !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            page-break-inside: auto !important;
        }

        tr {
            page-break-inside: avoid !important;
            page-break-after: auto !important;
        }

        th, td {
            padding: 6px 10px !important;
            font-size: 10px !important;
            color: #000000 !important;
            border-bottom: 1px solid #E5E5E5 !important;
            text-align: left !important;
        }

        th {
            background-color: #F5F2F0 !important;
            color: #3B1F0F !important;
            font-weight: bold !important;
            border-bottom: 2px solid #CCCCCC !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: right !important;
        }

        /* Progress Bar border agar kelihatan meski background-graphics mati */
        .bg-\[\#FAF6EE\] {
            border: 1px solid #CCCCCC !important;
            background: #FFFFFF !important;
        }

        .bg-\[\#532E1C\] {
            background: #000000 !important; /* Hitam agar kontras tinggi */
        }
    }

    .print-title {
        display: none;
    }
</style>

<div class="text-[#2C1A0E] font-manrope selection:bg-[#532E1C]/10 selection:text-[#532E1C] flex flex-col p-[1.5rem] gap-[1.5rem] print-wrapper">

    {{-- Header Laporan (Hanya tampil saat cetak) --}}
    <div class="print-title border-b border-[#532E1C] pb-4">
        <h1 class="text-2xl font-black uppercase text-[#3B1F0F]">Laporan Penjualan Stall</h1>
        <h2 class="text-lg font-bold text-[#532E1C] mt-1">Stall: {{ $stall->name }}</h2>
        <p class="text-xs text-[#80756A] mt-2">Periode Laporan: {{ $timeframeLabel }} | Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
    </div>

    <div class="py-2 px-4 flex flex-col sm:flex-row items-center justify-between bg-white border border-[#E0D2BB] rounded-none gap-2 no-print">
        
        <div class="flex flex-col sm:flex-row items-center gap-2">
            <p class="text-start font-manrope text-sm text-[#532E1C] font-medium">Periode:</p>
            
            <div role="group" class="w-fit relative flex gap-0.5 bg-[#F5F2F0] border border-[#2C180F] rounded-none p-1">
                <button type="button" onclick="changeTimeframe('today')"
                    class="font-manrope text-xs px-2 py-0.5 rounded-none transition-all {{ $timeframe === 'today' ? 'text-white bg-[#532E1C]' : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                    Hari Ini
                </button>
                <button type="button" onclick="changeTimeframe('7d')"
                    class="font-manrope text-xs px-2 py-0.5 rounded-none transition-all {{ $timeframe === '7d' ? 'text-white bg-[#532E1C]' : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                    7 Hari
                </button>
                <button type="button" onclick="changeTimeframe('30d')"
                    class="font-manrope text-xs px-2 py-0.5 rounded-none transition-all {{ $timeframe === '30d' ? 'text-white bg-[#532E1C]' : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                    30 Hari
                </button>
                <button type="button" onclick="changeTimeframe('12m')"
                    class="font-manrope text-xs px-2 py-0.5 rounded-none transition-all {{ $timeframe === '12m' ? 'text-white bg-[#532E1C]' : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                    12 Bulan
                </button>
            </div>
        </div>

        <div class="relative">
            <button onclick="window.print()" class="py-2 px-3 bg-[#532E1C] hover:bg-[#3B1F0F] rounded-none font-manrope text-xs text-white font-medium cursor-pointer flex items-center gap-1.5 shadow-xs select-none">
                <i class="bi bi-printer text-xs"></i><span>Cetak / PDF</span>
            </button>
        </div>
    </div>

    {{-- ═══ SECTION 1 — KPI Cards ═══ --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[16px]">

        {{-- Card 1 — Total Pendapatan --}}
        <div class="bg-white rounded-none border border-[#E0D2BB] p-4 flex flex-col gap-1 shadow-[0_4px_25px_rgba(44,26,14,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.07)] transition-all duration-300 print-card">
            <div class="w-1/5 max-w-15 h-1 bg-[#C5A880] mb-1 rounded-full"></div>
            <span class="font-manrope text-xs font-medium text-[#532E1C] tracking-wide uppercase">TOTAL PENDAPATAN</span>
            <div class="mt-1">
                <span class="font-noto-serif text-lg font-bold text-[#2C1A0E]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                <p class="text-[11px] text-[#80756A] font-medium mt-1">Selama periode {{ $timeframeLabel }}</p>
            </div>
        </div>

        {{-- Card 2 — Total Item Terjual --}}
        <div class="bg-white rounded-none border border-[#E0D2BB] p-4 flex flex-col gap-1 shadow-[0_4px_25px_rgba(44,26,14,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.07)] transition-all duration-300 print-card">
            <div class="w-1/5 max-w-15 h-1 bg-[#C5A880] mb-1 rounded-full"></div>
            <span class="font-manrope text-xs font-medium text-[#532E1C] tracking-wide uppercase">MAKANAN TERJUAL</span>
            <div class="mt-1">
                <span class="font-noto-serif text-lg font-bold text-[#2C1A0E]">{{ number_format($totalItemsSold) }} Porsi</span>
                <p class="text-[11px] text-[#80756A] font-medium mt-1">Total kuantitas menu terjual</p>
            </div>
        </div>

        {{-- Card 3 — Rata-rata Nilai Pesanan --}}
        <div class="bg-white rounded-none border border-[#E0D2BB] p-4 flex flex-col gap-1 shadow-[0_4px_25px_rgba(44,26,14,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.07)] transition-all duration-300 print-card">
            <div class="w-1/5 max-w-15 h-1 bg-[#C5A880] mb-1 rounded-full"></div>
            <span class="font-manrope text-xs font-medium text-[#532E1C] tracking-wide uppercase">RATA-RATA PESANAN</span>
            <div class="mt-1">
                <span class="font-noto-serif text-lg font-bold text-[#2C1A0E]">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</span>
                <p class="text-[11px] text-[#80756A] font-medium mt-1">Rata-rata belanja per transaksi</p>
            </div>
        </div>

        {{-- Card 4 — Total Transaksi --}}
        <div class="bg-white rounded-none border border-[#E0D2BB] p-4 flex flex-col gap-1 shadow-[0_4px_25px_rgba(44,26,14,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(44,26,14,0.07)] transition-all duration-300 print-card">
            <div class="w-1/5 max-w-15 h-1 bg-[#C5A880] mb-1 rounded-full"></div>
            <span class="font-manrope text-xs font-medium text-[#532E1C] tracking-wide uppercase">TOTAL TRANSAKSI</span>
            <div class="mt-1">
                <span class="font-noto-serif text-lg font-bold text-[#2C1A0E]">{{ number_format($totalTransactions) }} Transaksi</span>
                <p class="text-[11px] text-[#80756A] font-medium mt-1">Jumlah pesanan selesai terbayar</p>
            </div>
        </div>

    </section>

    {{-- ═══ SECTION 2 — Tren & Tipe Pesanan ═══ --}}
    <div class="flex flex-col lg:flex-row gap-[16px] items-stretch w-full">
        {{-- Left: Tren Pendapatan --}}
        <section class="flex-1 min-w-[300px] bg-white rounded-none border border-[#E0D2BB] p-[1.25rem] flex flex-col shadow-[0_4px_20px_-4px_rgba(44,26,14,0.05)] print-card">
            <div class="flex justify-between items-center mb-[14px]">
                <div class="flex items-center gap-2">
                    <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                    <span class="text-[15px] font-bold text-[#2C1A0E]">Tren Pendapatan ({{ $timeframeLabel }})</span>
                </div>
                <span class="text-[11px] text-[#80756A] font-medium no-print">Arahkan kursor pada grafik untuk detail</span>
            </div>

            {{-- Chart.js Line Chart --}}
            <div class="w-full h-[175px] relative mt-2" id="report-chart-wrapper">
                @php
                    $hasData = collect($points)->sum('amount') > 0;
                @endphp

                @if(!$hasData || count($points) === 0)
                {{-- Empty State --}}
                <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-[#80756A]">
                    <i class="ti ti-chart-line text-[36px] opacity-35"></i>
                    <span class="text-[13px] font-semibold opacity-60">Tidak ada data transaksi berstatus PAID pada periode ini</span>
                </div>
                @else
                <canvas id="trend-chart" style="height: 175px;"></canvas>
                @endif
            </div>
        </section>

        {{-- Right: Donut Chart Dine In / Takeaway --}}
        <section class="w-full lg:w-[280px] shrink-0 bg-white rounded-none border border-[#E0D2BB] p-[1.25rem] flex flex-col shadow-[0_4px_20px_-4px_rgba(44,26,14,0.05)] print-card">
            <div class="flex items-center gap-2 mb-[14px]">
                <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                <span class="text-[15px] font-bold text-[#2C1A0E]">Tipe Pesanan ({{ $timeframeLabel }})</span>
            </div>

            @if($dineInCount === 0 && $takeawayCount === 0)
            <div class="flex-1 flex flex-col items-center justify-center gap-2 text-[#80756A] py-8">
                <i class="ti ti-chart-donut text-[32px] opacity-35"></i>
                <span class="text-[12px] font-semibold opacity-60 text-center">Belum ada data tipe pesanan</span>
            </div>
            @else
            {{-- Chart.js Donut Chart --}}
            <div class="relative w-full flex justify-center items-center py-[5px] h-[120px]">
                <canvas id="type-chart" style="height: 120px; width: 120px;"></canvas>

                {{-- Center text --}}
                <div class="absolute flex flex-col items-center justify-center text-center pointer-events-none">
                    <span class="text-[16px] font-black text-[#2C1A0E] leading-none tracking-tight">{{ $dineInPercentage }}%</span>
                    <span class="text-[8px] text-[#80756A] font-bold mt-[2px] uppercase tracking-wider">Dine In</span>
                </div>
            </div>

            {{-- Legend --}}
            <div class="flex flex-col gap-[4px] mt-[8px] pt-[8px] border-t border-[#F8F5F2]">
                <div class="flex justify-between items-center text-[12px] px-1 hover:bg-[#FAF8F5] rounded-none py-[3px] transition-colors duration-200">
                    <div class="flex items-center gap-[6px]">
                        <span class="w-[7px] h-[7px] rounded-full bg-[#532E1C]"></span>
                        <span class="text-[#80756A] font-bold text-[11px]">Dine In</span>
                    </div>
                    <div class="flex items-center gap-[4px]">
                        <span class="font-extrabold text-[#2C1A0E] text-[11px]">{{ $dineInPercentage }}%</span>
                        <span class="text-[9px] text-[#B5A898]">({{ $dineInCount }})</span>
                    </div>
                </div>
                <div class="flex justify-between items-center text-[12px] px-1 hover:bg-[#FAF8F5] rounded-none py-[3px] transition-colors duration-200">
                    <div class="flex items-center gap-[6px]">
                        <span class="w-[7px] h-[7px] rounded-full bg-[#C5A880]"></span>
                        <span class="text-[#80756A] font-bold text-[11px]">Take Away</span>
                    </div>
                    <div class="flex items-center gap-[4px]">
                        <span class="font-extrabold text-[#2C1A0E] text-[11px]">{{ $takeawayPercentage }}%</span>
                        <span class="text-[9px] text-[#B5A898]">({{ $takeawayCount }})</span>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </div>

    {{-- ═══ SECTION 3 — Makanan yang Banyak Dibeli (Top Foods) ═══ --}}
    <section class="mb-[1rem]">
        <div class="bg-white rounded-none border border-[#E0D2BB] p-[1.25rem] shadow-[0_4px_20px_-4px_rgba(44,26,14,0.05)] print-card">
            <div class="flex items-center gap-2 mb-[18px]">
                <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                <span class="text-[15px] font-bold text-[#2C1A0E]">Makanan yang Banyak Dibeli (Top Seller)</span>
            </div>

            <div class="overflow-x-auto w-full border border-[#E0D2BB] rounded-none overflow-hidden">
                <table class="w-full border-collapse table-fixed min-w-[700px]">
                    <thead>
                        <tr class="bg-[#532E1C]">
                            <th class="w-[8%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-center">RANK</th>
                            <th class="w-[38%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-left">MENU</th>
                            <th class="w-[14%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-center">PORSI TERJUAL</th>
                            <th class="w-[18%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-right">TOTAL PENDAPATAN</th>
                            <th class="w-[22%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-left pl-[20px]">KONTRIBUSI PENJUALAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E0D2BB]">
                        @forelse($topMenus as $index => $item)
                        @php
                            $menu = $item->menu;
                            $porsi = (int) $item->total_qty;
                            $rev = (float) $item->total_rev;
                            // Persentase kontribusi terhadap total menu yang terjual
                            $percentage = $totalItemsSold > 0 ? round(($porsi / $totalItemsSold) * 100, 1) : 0;
                            
                            // Styling ranking badge dengan skema warna kafe (Gold, Silver, Bronze, Beige)
                            $rank = $index + 1;
                            if ($rank === 1) {
                                $badgeClass = 'bg-[#FAF0D9] text-[#8F6E23] border-[#EED7A1] font-black scale-105 shadow-xs';
                            } elseif ($rank === 2) {
                                $badgeClass = 'bg-[#F1F0ED] text-[#6B6864] border-[#E2E1DD] font-black';
                            } elseif ($rank === 3) {
                                $badgeClass = 'bg-[#F9ECE0] text-[#9C6E4E] border-[#ECCBB3] font-black';
                            } else {
                                $badgeClass = 'bg-[#FAF8F5] text-[#80756A] border-[#E0D2BB] font-bold';
                            }
                        @endphp
                        <tr class="border-b border-[#E0D2BB] hover:bg-[#F5F2F0] transition-colors duration-150">
                            {{-- Rank --}}
                            <td class="px-4 py-3 text-sm text-[#2C180F] text-center align-middle">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full border text-xs {{ $badgeClass }}">
                                    {{ $rank }}
                                </span>
                            </td>

                            {{-- Menu Info --}}
                            <td class="px-4 py-3 text-sm text-[#2C180F] align-middle">
                                <div class="flex items-center gap-[12px]">
                                    {{-- Menu Image --}}
                                    <div class="w-10 h-10 rounded-none overflow-hidden border border-[#E0D2BB] bg-[#FAF8F5] shrink-0 shadow-xs">
                                        @if($menu && $menu->image_path)
                                            <img src="{{ asset($menu->image_path) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[#B5A898] bg-[#FAF6EE]">
                                                <i class="ti ti-tools-kitchen-2 text-[18px]"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col truncate">
                                        <span class="font-bold truncate" title="{{ $menu ? $menu->name : 'Menu tidak aktif' }}">
                                            {{ $menu ? $menu->name : 'Menu tidak aktif' }}
                                        </span>
                                        <span class="text-xs text-[#532E1C] font-semibold mt-0.5">
                                            {{ $menu ? $menu->category : 'Umum' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Quantity --}}
                            <td class="px-4 py-3 text-sm text-[#2C180F] text-center align-middle font-bold">
                                {{ number_format($porsi) }}x
                            </td>

                            {{-- Revenue --}}
                            <td class="px-4 py-3 text-sm text-[#2C180F] text-right align-middle font-extrabold">
                                Rp {{ number_format($rev, 0, ',', '.') }}
                            </td>

                            {{-- Contribution Progress Bar --}}
                            <td class="px-4 py-3 text-sm text-[#2C180F] pl-[20px] align-middle">
                                <div class="flex items-center gap-[10px] pr-2">
                                    <div class="flex-1 bg-[#FAF6EE] rounded-full h-2 overflow-hidden border border-[#FAF0E6] shadow-inner">
                                        <div class="bg-[#532E1C] h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-[#532E1C] shrink-0 w-[40px] text-right">{{ $percentage }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-[#80543F] italic">
                                <div class="flex flex-col items-center gap-2 text-[#80756A]">
                                    <i class="ti ti-bowl-off text-[36px] opacity-35"></i>
                                    <span class="opacity-70">Belum ada data penjualan makanan untuk periode ini.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- ═══ SECTION 4 — Pesanan Selesai ═══ --}}
    <section class="mb-[1rem] print-card">
        <div class="bg-white rounded-none border border-[#E0D2BB] p-[1.25rem] shadow-[0_4px_20px_-4px_rgba(44,26,14,0.05)]">
            <div class="flex justify-between items-center mb-[18px]">
                <div class="flex items-center gap-2">
                    <span class="w-[3px] h-[15px] bg-[#532E1C] rounded-full"></span>
                    <span class="text-[15px] font-bold text-[#2C1A0E]">Pesanan Selesai ({{ $timeframeLabel }})</span>
                </div>
            </div>

            <div class="overflow-x-auto w-full border border-[#E0D2BB] rounded-none overflow-hidden">
                <table class="w-full border-collapse table-fixed min-w-[700px]">
                    <thead>
                        <tr class="bg-[#532E1C]">
                            <th class="w-[15%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-left">ORDER #</th>
                            <th class="w-[45%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-left">MENU</th>
                            <th class="w-[12%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-center">WAKTU</th>
                            <th class="w-[13%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-center">MEJA</th>
                            <th class="w-[15%] font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3 text-right">TOTAL STALL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E0D2BB]">
                        @forelse($completedOrders as $order)
                        @php
                            $stallTotal  = $order->orderItems->sum('total_price');
                            $itemSummary = $order->orderItems->map(function($item) {
                                $name = $item->menu->name ?? 'Menu';
                                return "{$item->quantity}× {$name}";
                            })->join(', ');
                        @endphp
                        <tr class="border-b border-[#E0D2BB] hover:bg-[#F5F2F0] transition-colors duration-150 cursor-pointer" onclick="showOrderDetail(this, event)" data-order="{{ json_encode($order) }}">
                            <td class="px-4 py-3 text-sm text-[#2C180F] font-bold truncate" title="{{ $order->order_number }}">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-4 py-3 text-sm text-[#2C180F] truncate" title="{{ $itemSummary }}">
                                {{ $itemSummary ?: '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-[#2C180F] text-center">
                                {{ $order->created_at->format('H:i') }}
                           </td>
                            <td class="px-4 py-3 text-sm text-[#2C180F] text-center">
                                {{ $order->table ? 'Meja ' . sprintf('%02d', $order->table->table_number) : 'Takeaway' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-[#2C180F] text-right font-bold">
                                Rp {{ number_format($stallTotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-[#80543F] italic">
                                <div class="flex flex-col items-center gap-2 text-[#80756A]">
                                    <i class="ti ti-clipboard-off text-[36px] opacity-35"></i>
                                    <span class="opacity-70">Belum ada pesanan selesai untuk periode ini.</span>
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
    // Redirect ke halaman dengan parameter timeframe terpilih
    function changeTimeframe(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('timeframe', val);
        window.location.href = url.toString();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // ── 1. Line Chart: Tren Pendapatan ──
        const trendCanvas = document.getElementById('trend-chart');
        if (trendCanvas) {
            const points = @js($points);
            const labels = points.map(pt => pt.label);
            const values = points.map(pt => pt.amount);
            const fullDates = points.map(pt => pt.full_date);

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
                                title: (context) => {
                                    return fullDates[context[0].dataIndex];
                                },
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

        // ── 2. Donut Chart: Tipe Pesanan ──
        const typeCanvas = document.getElementById('type-chart');
        if (typeCanvas) {
            const dineInCount = @js($dineInCount);
            const takeawayCount = @js($takeawayCount);

            new Chart(typeCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Dine In', 'Take Away'],
                    datasets: [{
                        data: [dineInCount, takeawayCount],
                        backgroundColor: ['#532E1C', '#C5A880'],
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
                                    return ` ${label}: ${context.parsed} order`;
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
