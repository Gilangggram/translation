<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Computed;
use App\Models\Stall;

new class extends Component
{
    #[Reactive] public array $tableData;

    public string $title;
    public string $subTitle;
    public array $selectedRow = [];

    public array $columns = [
        ['key' => 'stall_name', 'label' => 'Nama Stall',],
        ['key' => 'stall_revenue', 'label' => 'Pendapatan'],
    ];

    public function mount(
        string $title,
        string $subTitle,
    ): void {
        $this->title           = $title;
        $this->subTitle        = $subTitle;
    }

    public function selectRow(string $stallId): void
    {
        $stall = Stall::find($stallId);
        $this->dispatch('stall-selected', 
            requestId: $stallId,
            stall: $stall->toArray()
        );
    }

    #[Computed]
    public function sortedTableData(): array
    {
        return collect($this->tableData)
            ->filter(fn($row) => is_array($row))
            ->sortByDesc(fn($row) => (float) $row['stall_revenue'])
            ->toArray();
    }
};
?>

<div>
    <div class="relative bg-white rounded-lg w-full p-4 border border-[#E0D2BB]">

        <div class="mb-4">
            <h3 class="font-manrope text-sm font-medium text-[#532E1C]">{{ $title }}</h3>
            <p class="font-manrope text-xs text-[#80543F]">{{ $subTitle }}</p>
        </div>

        <div class="hidden lg:block border border-[#E0D2BB] rounded-md overflow-hidden">
            <table class="w-full border-collapse table-fixed">
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

            <div class="overflow-y-auto max-h-60 light-brown-scrollbar">
                <table class="w-full border-collapse table-fixed">
                    <tbody>
                        @forelse($this->sortedTableData as $row)
                            <tr wire:click="selectRow('{{ $row['stall_id'] }}')"
                                onclick="window.openStallModal('{{ $row['stall_id'] }}')"
                                class="border-b border-[#E0D2BB] hover:bg-[#F5F2F0] cursor-pointer">

                                @foreach($columns as $col)
                                    <td class="px-4 py-3 text-sm text-[#2C180F] text-center">
                                        @switch($col['key'])
                                            
                                            @case('stall_name')
                                                {{ $row['stall_name'] }}
                                            @break

                                            @case('stall_revenue')
                                                Rp {{ number_format($row['stall_revenue'], 0, ',', '.') }}
                                            @break

                                        @endswitch
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) }}"
                                    class="px-4 py-12 text-center text-sm text-[#80543F] italic">
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
        light-brown-scrollbar">

            @forelse($this->sortedTableData as $row)
                <div class="p-4 hover:bg-[#F5F2F0]">

                    @foreach($columns as $col)
                        <div class="flex justify-between items-center py-1">
                            <span class="font-manrope text-xs text-[#2C180F]">{{ $col['label'] }}</span>
                            
                            <span class="font-manrope text-sm text-[#2C180F]">
                                @switch($col['key'])

                                    @case('stall_name')
                                        {{ $row['stall_name'] }}
                                    @break

                                    @case('stall_revenue')
                                        Rp {{ number_format($row['stall_revenue'], 0, ',', '.') }}
                                    @break

                                @endswitch
                            </span>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="p-12 text-center text-sm text-[#80543F] italic">
                    Tidak ada data tersedia
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal --}}
    <div wire:ignore>
        <div id="stall-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="p-4 min-h-24 flex flex-col gap-3">

                        <div id="stall-modal-loading" class="hidden justify-center items-center py-6">
                            <div class="animate-spin h-5 w-5 border-2 border-[#E0D2BB] border-t-[#532E1C] rounded-full"></div>
                        </div>

                        <div id="stall-modal-content" class="hidden flex-col gap-3">
                            <div class="flex justify-between text-sm border-b border-[#E0D2BB] pb-3">
                                <span class="text-[#80543F]">Nama Stall</span>
                                <span class="text-[#2C180F] font-medium" id="modal-stall-name"></span>
                            </div>
                            <div class="flex justify-between text-sm border-b border-[#E0D2BB] pb-3">
                                <span class="text-[#80543F]">Pemilik</span>
                                <span class="text-[#2C180F] font-medium" id="modal-owner-name"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#80543F]">Status</span>
                                <span class="text-[#2C180F] font-medium" id="modal-status"></span>
                            </div>
                        </div>

                        <button type="button"
                            onclick="window.stallModal.hide()"
                            class="text-white bg-[#532E1C] w-full py-2 rounded-md font-manrope text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        window.stallModal = new Modal(document.getElementById('stall-modal'));

        let currentRequestId = null;

        window.openStallModal = (stallId) => {
            currentRequestId = stallId;

            document.getElementById('stall-modal-content').classList.add('hidden');
            document.getElementById('stall-modal-content').classList.remove('flex');
            document.getElementById('stall-modal-loading').classList.remove('hidden');
            document.getElementById('stall-modal-loading').classList.add('flex');
            window.stallModal.show();
        };

        $wire.on('stall-selected', (data) => {
            if (data.requestId !== currentRequestId) return;

            // Isi value — tanpa nulis HTML
            document.getElementById('modal-stall-name').textContent = data.stall.name;
            document.getElementById('modal-owner-name').textContent = data.stall.owner_name;
            document.getElementById('modal-status').textContent     = data.stall.is_open ? 'Buka' : 'Tutup';

            // Tukar spinner dengan konten
            document.getElementById('stall-modal-loading').classList.add('hidden');
            document.getElementById('stall-modal-loading').classList.remove('flex');
            document.getElementById('stall-modal-content').classList.remove('hidden');
            document.getElementById('stall-modal-content').classList.add('flex');
        });
    </script>
    @endscript
</div>