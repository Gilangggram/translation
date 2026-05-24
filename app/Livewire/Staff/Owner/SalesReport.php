<?php

namespace App\Livewire\Staff\Owner;

use App\Exports\SalesReport as ExportsSalesReport;
use App\Services\OrderService;
use App\Services\RevenueService;
use App\Services\SalesService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Layout('staff.owner.layout')]
class SalesReport extends Component
{
    public string $timeframe                = 'today';
    public int $totalRevenue                = 0;
    public int $totalCompletedOrders        = 0;
    public int $totalItemsSold              = 0;
    public float $averageOrderValue         = 0;
    public array $stallsRevenueProportion   = [];
    public array $revenueTrend              = [];
    public array $orderTypeStats            = [];
    public array $stallsRevenue             = [];
    public array $menuSales                 = []; 

    public array $timeframes = [
        'today' => 'Hari Ini',
        '7d'    => '7 Hari',
        '30d'   => '30 Hari',
        '12m'   => '12 Bulan',
    ];

    public function mount(): void
    {
        $this->fetchAllData();
    }

    public function setTimeframe(string $value): void
    {
        $this->timeframe = $value;
        $this->fetchAllData();
    }

    private function fetchAllData(): void
    {
        $revenue = app(RevenueService::class);
        $order   = app(OrderService::class);
        $sales   = app(SalesService::class);

        // Summary
        $this->totalRevenue                 = $revenue->getCafeRevenue($this->timeframe);
        $this->totalCompletedOrders         = $order->getCompletedOrdersCount($this->timeframe);
        $this->totalItemsSold               = $sales->getTotalItemsSold($this->timeframe);
        $this->averageOrderValue            = $this->totalCompletedOrders ? $this->totalRevenue / $this->totalCompletedOrders : 0;
        
        // Chart
        $this->orderTypeStats               = $order->getOrderTypeStats($this->timeframe);
        $this->orderTypeStats['timeframe']  = $this->timeframe;

        $this->stallsRevenue                = $revenue->getStallsRevenue($this->timeframe);
        $this->stallsRevenue['timeframe']   = $this->timeframe;

        $this->menuSales                    = $sales->getMenuSales($this->timeframe);
        $this->menuSales['timeframe']       = $this->timeframe;        

        if($this->timeframe !== 'today') {
            $this->revenueTrend                 = $revenue->getCafeRevenueTrend($this->timeframe);
            $this->revenueTrend['timeframe']    = $this->timeframe;
        } else {
            $this->revenueTrend = [];
        }
    }

    public function exportExcel(): BinaryFileResponse
    {
        $label    = $this->timeframes[$this->timeframe];
        $filename = 'laporan-' . str()->slug($label) . '-' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new ExportsSalesReport($this->timeframe), $filename);
    }   
    
    public function render()
    {
        return view('staff.owner.sales-report');
    }
}
