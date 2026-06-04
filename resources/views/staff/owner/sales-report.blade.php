@section('title', 'Laporan Keuangan')

<div class="w-full min-h-screen bg-[#F0E7D8] p-4">
    <div class="flex flex-col gap-2">

        <div class="py-2 px-4 flex flex-col sm:flex-row items-center justify-between bg-white border border-[#E0D2BB] rounded-lg gap-2">

            <div class="flex flex-col sm:flex-row items-center gap-2">
                <p class="text-start font-manrope text-sm text-[#532E1C] font-medium">Periode:</p>
            
                <div role="group" class="w-fit relative flex gap-0.5 bg-[#F5F2F0] border border-[#2C180F] rounded-sm p-1" >
                    
                    <div wire:loading class="absolute inset-0 bg-[#F0E7D8]/50 z-10 rounded-sm cursor-wait"></div>
                    
                    @foreach($timeframes as $val => $label)
                        <button
                            type="button"
                            wire:click="setTimeframe('{{ $val }}')"
                            @disabled($timeframe === $val)
                            wire:loading.attr="disabled"
                            class="font-manrope text-xs px-2 py-0.5 rounded-xs
                                {{ $timeframe === $val
                                    ? 'text-white  bg-[#532E1C]'
                                    : 'text-[#2C180F] hover:bg-[#D2C2BC] cursor-pointer' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>
    
            <div class="relative">
    
                <div wire:loading class="absolute inset-0 bg-[#F0E7D8]/50 z-10 rounded-sm cursor-wait"></div>
    
                <button type="button"
                    wire:click="exportExcel" 
                    wire:loading.attr="disabled" 
                    class="py-2 px-3 bg-[#532E1C] rounded-sm font-manrope text-xs text-white font-medium cursor-pointer">
                        <i class="bi bi-box-arrow-up-right text-xs me-1"></i><span>Export Excel</span>
                </button>
            </div>
            
            
        </div>
        
        <div class="relative grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-2">
    
            <div wire:loading class="absolute inset-0 bg-[#F0E7D8]/50 z-10 rounded-md cursor-wait"></div>
    
            @livewire('staff.owner.sales-report.card.sales-report-stats', [
                'title'    => 'Total Pendapatan',
                'currency' => 'Rp',
                'value'    => number_format($totalRevenue, 0, ',', '.'),
            ])

            @livewire('staff.owner.sales-report.card.sales-report-stats', [
                'title' => 'Total Pesanan Terselesaikan',
                'value' => number_format($totalCompletedOrders, 0, ',', '.'),
            ])

            @livewire('staff.owner.sales-report.card.sales-report-stats', [
                'title' => 'Jumlah Item Terjual',
                'value' => number_format($totalItemsSold, 0, ',', '.'),
            ])

            @livewire('staff.owner.sales-report.card.sales-report-stats', [
                'title'    => 'Rata Rata Nilai Pesanan',
                'currency' => 'Rp',
                'value'    => number_format($averageOrderValue, 0, ',', '.'),
            ])
    
        </div>
    
        <div class="relative grid grid-cols-1 xl:grid-cols-[minmax(0,2fr)_minmax(0,1fr)] gap-2">
    
            <div wire:loading class="absolute inset-0 bg-[#F0E7D8]/50 z-10 rounded-md cursor-wait"></div>

            @livewire('staff.owner.sales-report.card.revenue-trend-line-chart', [
                'title'     => 'Tren Pendapatan',
                'subTitle'  => 'Pendapatan dari waktu ke waktu',
                'chartData' => $revenueTrend,
            ])

            @livewire('staff.owner.sales-report.card.order-type-donut-chart', [
                'title'      => 'Tipe Pesanan',
                'subTitle'   => 'Distribusi order berdasarkan tipe',
                'chartData'  => $orderTypeStats,
            ])
    
        </div>

        <div class="relative grid grid-cols-1 xl:grid-cols-2 gap-2">

            <div wire:loading class="absolute inset-0 bg-[#F0E7D8]/50 z-10 rounded-md cursor-wait"></div>

            @livewire('staff.owner.sales-report.card.stall-revenues-table', [
                'title'     => 'Performa Stall',
                'subTitle'  => 'Pendapatan Masing-masing stall',
                'tableData' => $stallsRevenue,
            ])

            @livewire('staff.owner.sales-report.card.menu-sales-table', [
                'title'     => 'Penjualan Menu',
                'subTitle'  => 'Jumlah penjualan untuk masing-masing menu',
                'tableData' => $menuSales,
            ])

        </div>

    </div>

</div>