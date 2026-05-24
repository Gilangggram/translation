<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Computed;


new class extends Component
{
    #[Reactive] public array $tableData;

    public string $title;
    public string $subTitle;
    public array $selectedRow = [];

    public array $columns = [
        ['key' => 'menu_name', 'label' => 'Nama Menu',],
        ['key' => 'menu_sales', 'label' => 'Jumlah Terjual'],
    ];

    public function mount(
        string $title,
        string $subTitle,
    ): void {
        $this->title           = $title;
        $this->subTitle        = $subTitle;
    }
    

    #[Computed]
    public function sortedTableData(): array
    {
        return collect($this->tableData)
            ->filter(fn($row) => is_array($row))
            ->sortByDesc(fn($row) => (float) $row['menu_sales'])
            ->toArray();
    }
};
?>

<div class="relative bg-white rounded-lg w-full p-4 border border-[#E0D2BB]">
    
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
                        <th class="w-1/2 font-manrope text-center text-xs tracking-wide text-white font-semibold px-4 py-3">
                            {{ $col['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>

        </table>
            
        <div class="overflow-y-auto max-h-60 
            [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-[#C5A880]">
            <table class="w-full border-collapse table-fixed">

                <tbody>
                    @forelse($this->sortedTableData as $row)
                        <tr class="border-b border-[#E0D2BB] hover:bg-[#F9F5F0] transition-colors">

                            @foreach($columns as $col)
                                <td class="px-4 py-3 text-sm text-[#2C180F] text-center">

                                    @switch($col['key'])
                                        
                                        @case('menu_name')
                                            {{ $row['menu_name'] }}
                                        @break

                                        @case('menu_sales')
                                            {{ number_format($row['menu_sales'], 0, ',', '.') }} Porsi
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
    </div>

    {{-- width lg > --}}
    <div class="lg:hidden flex flex-col divide-y divide-[#E0D2BB] border border-[#E0D2BB] rounded-sm overflow-hidden overflow-y-auto max-h-120
    [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-[#C5A880]">

    @forelse($this->sortedTableData as $row)
        <div class="p-4 hover:bg-[#F9F5F0] transition-colors">

            @foreach($columns as $col)
                <div class="flex justify-between items-center py-1">
                    <span class="font-manrope text-xs text-[#2C180F]">{{ $col['label'] }}</span>
                    
                    <span class="font-manrope text-sm text-[#2C180F]">
                        @switch($col['key'])

                        @case('menu_name')
                            {{ $row['menu_name'] }}
                        @break

                        @case('menu_sales')
                            {{ number_format($row['menu_sales'], 0, ',', '.') }} Porsi
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