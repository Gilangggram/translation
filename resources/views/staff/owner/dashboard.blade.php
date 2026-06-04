@section('title', 'Owner Dashboard')

<div class="w-full min-h-screen bg-[#F0E7D8] p-4">
    <div class="flex flex-col gap-2">
        
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-2">

            @livewire('staff.owner.dashboard.card.dashboard-stats', [
                'title'           => 'Total Pendapatan',
                'currency'        => 'Rp',
                'withDropdown'    => true,
                'serviceClass'    => \App\Services\Read\RevenueService::class,
                'serviceFunction' => 'getCafeRevenue',
            ])

            @livewire('staff.owner.dashboard.card.dashboard-stats', [
                'title'           => 'Total Pesanan Terselesaikan',
                'withDropdown'    => true,
                'serviceClass'    => \App\Services\Read\OrderService::class,
                'serviceFunction' => 'getCompletedOrdersCount',
            ])

            @livewire('staff.owner.dashboard.card.dashboard-stats', [
                'title'           => 'Jumlah Stall Aktif',
                'serviceClass'    => \App\Services\Read\StallService::class,
                'serviceFunction' => 'getStallsCount',
            ])

            @livewire('staff.owner.dashboard.card.dashboard-stats', [
                'title'           => 'Jumlah Menu Aktif',
                'serviceClass'    => \App\Services\Read\MenuService::class,
                'serviceFunction' => 'getMenusCount',
            ])

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">

            @livewire('staff.owner.dashboard.card.revenue-trend-line-chart', [
                'title'            => 'Tren Pendapatan',
                'subTitle'         => 'Pendapatan dari waktu ke waktu',
                'defaultTimeframe' => '7d',
            ])

            @livewire('staff.owner.dashboard.card.order-type-donut-chart', [
                'title'            => 'Tipe Pesanan',
                'subTitle'         => 'Distribusi order berdasarkan tipe',
                'defaultTimeframe' => '7d',
            ])

        </div>

        <div>

            @livewire('staff.owner.dashboard.card.recent-order-table', [
                'title'          => 'Pesanan Terbaru',
                'subTitle'       => '5 transaksi terakhir masuk',
                'maxDataFetched' => 5,
            ])

        </div>

    </div>
</div>