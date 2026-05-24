<?php

use App\Models\Order;
use Livewire\Component;

new class extends Component {

    public string $title;
    public string $subTitle;
    public int $maxDataFetched;

    public array $columns = [
        ['key' => 'order_number', 'label' => 'No. Order',],
        ['key' => 'order_type', 'label' => 'Tipe'],
        ['key' => 'total_price', 'label' => 'Total'],
        ['key' => 'payment_status', 'label' => 'Pembayaran'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
    ];

    public function mount(
        string $title,
        string $subTitle,
        int $maxDataFetched     = 0,
    ): void {
        $this->title            = $title;
        $this->subTitle         = $subTitle;
        $this->maxDataFetched   = $maxDataFetched;
    }

    public function fetchData()
    {
        $query = Order::query()->orderBy('created_at', 'desc');

        return $this->maxDataFetched > 0
            ? $query->limit($this->maxDataFetched)->get()
            : $query->get();
    }

    public function getPaymentStatusClasses(string $status): string
    {
        return match ($status) {
            'pending'   => 'bg-[#FFF5C6] text-[#6B5B0D]',
            'paid'      => 'bg-[#B6DDA5] text-[#246009]',
            'cancelled' => 'bg-[#F9B1B1] text-[#AD1614]',
        };
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

<div class="bg-white rounded-lg w-full p-4 border border-[#E0D2BB]">

    <div class="mb-4">
        <h3 class="font-manrope text-sm font-medium text-[#532E1C]">{{ $title }}</h3>
        <p class="font-manrope text-xs text-[#80543F]">{{ $subTitle }}</p>
    </div>

    {{-- Width lg =< --}}
    <div class="hidden lg:block border border-[#E0D2BB] rounded-md overflow-hidden">
        <table class="w-full border-collapse">

            <thead>
                <tr class="bg-[#532E1C]">
                    @foreach($columns as $col)
                        <th class="font-manrope text-center text-xs tracking-wide text-white font-semibold px-4 py-3">
                            {{ $col['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            
            <tbody>
                @forelse($this->fetchData() as $row)
                    <tr class="border-b border-[#E0D2BB] hover:bg-[#F9F5F0] transition-colors">

                        @foreach($columns as $col)
                            <td class="px-4 py-3 text-sm text-[#2C180F] text-center">
                                
                                @switch($col['key'])

                                    @case('order_number')
                                        {{ $row->order_number }}
                                    @break

                                    @case('order_type')
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $this->getOrderTypeClasses($row->order_type) }}">
                                            {{ str_replace('_', ' ', ucfirst($row->order_type)) }}
                                        </span>
                                    @break

                                    @case('payment_status')
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $this->getPaymentStatusClasses($row->payment_status) }}">
                                            {{ ucfirst($row->payment_status) }}
                                        </span>
                                    @break

                                    @case('total_price')
                                        Rp {{ number_format($row->total_price, 0, ',', '.') }}
                                    @break

                                    @case('created_at')
                                        {{ $row->created_at->format('d M Y') }}
                                    @break

                                @endswitch
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) }}"
                            class="px-4 py-12 text-center text-sm text-[#C5A880] italic">
                            Tidak ada data tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- width lg > --}}
    <div class="lg:hidden flex flex-col divide-y divide-[#E0D2BB] border border-[#E0D2BB] rounded-sm overflow-hidden">

        @forelse($this->fetchData() as $row)
            <div class="p-4 hover:bg-[#F9F5F0] transition-colors">

                @foreach($columns as $col)
                    <div class="flex justify-between items-center py-1">
                        <span class="font-manrope text-xs text-[#2C180F]">{{ $col['label'] }}</span>
                        
                        <span class="font-manrope text-sm text-[#2C180F]">
                            @switch($col['key'])

                                @case('order_number')
                                        {{ $row->order_number }}
                                @break

                                @case('order_type')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $this->getOrderTypeClasses($row->order_type) }}">
                                        {{ str_replace('_', ' ', ucfirst($row->order_type)) }}
                                    </span>
                                @break

                                @case('payment_status')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $this->getPaymentStatusClasses($row->payment_status) }}">
                                        {{ ucfirst($row->payment_status) }}
                                    </span>
                                @break

                                @case('is_completed')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $this->getCompletedOrderStatusClasses($row->is_completed) }}">
                                        {{ $row->is_completed ? 'Selesai' : 'Proses' }}
                                    </span>
                                @break

                                @case('total_price')
                                    Rp {{ number_format($row->total_price, 0, ',', '.') }}
                                @break

                                @case('created_at')
                                    {{ $row->created_at->format('d M Y') }}
                                @break

                            @endswitch
                        </span>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="p-12 text-center text-sm text-[#C5A880] italic">
                Tidak ada data tersedia
            </div>
        @endforelse
    </div>
</div>