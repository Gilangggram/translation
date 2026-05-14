@section('title', 'Owner Dashboard')

<div class="w-full min-h-screen flex flex-col bg-[#F0E7D8] p-4">
    <div class="flex flex-col gap-2">
        
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-2">

            <livewire:staff.owner.dashboard.sum-card
                title="TOTAL PENDAPATAN"
                currency="Rp"
                :with-dropdown="true"
                service-class="\App\Services\RevenueService"
                service-function="getCafeRevenueSum"
            />

            <livewire:staff.owner.dashboard.sum-card
                title="TOTAL PESANAN TERSELESAIKAN"
                :with-dropdown="true"
                service-class="\App\Services\OrderService"
                service-function="getCompletedOrdersSum"
            />

            <livewire:staff.owner.dashboard.sum-card
                title="JUMLAH STALL AKTIF"
                service-class="\App\Services\StallService"
                service-function="getActiveStallsSum"
            />

            <livewire:staff.owner.dashboard.sum-card
                title="JUMLAH MENU AKTIF"
                service-class="\App\Services\MenuService"
                service-function="getAllMenusSum"
            />
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">

            <livewire:staff.owner.dashboard.chart-card
                title="Tren Pendapatan"
                sub-title="Akumulasi per periode"
                chart-axis="x"
                default-timeframe="7d"
                chart-type="line"
                service-class="\App\Services\RevenueChartService"
                service-function="getCafeRevenueTrend"
            />

            <livewire:staff.owner.dashboard.chart-card
                title="Performa Stall"
                sub-title="Akumulasi pendapatan per stall"
                chart-axis="y"
                default-timeframe="7d"
                chart-type="bar"
                service-class="\App\Services\RevenueChartService"
                service-function="getEachStallRevenue"
            />
            
        </div>

        <div>
            <livewire:staff.owner.dashboard.order-table-card
                title="Pesanan Terbaru"
                sub-title="5 transaksi terakhir masuk"
                max-data-fetched="5"
            />
        </div>

    </div>        
</div>