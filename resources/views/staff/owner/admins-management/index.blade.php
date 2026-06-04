@section('title', 'Pengelolaan Admin')

<div class="w-full min-h-screen bg-[#F0E7D8] p-4">
    <div class="grid grid-cols-1">

        <div>
            <div class="relative flex flex-col bg-white rounded-lg w-full p-4 border border-[#E0D2BB] gap-4">

                {{-- Nav --}}
                <div class="flex border-b border-[#E0D2BB]">
                    <button
                        onclick="window.switchTab('active')"
                        wire:loading.attr="disabled" 
                        wire:target="selectedNav"
                        {{ $selectedNav === 'active' ? 'disabled' : '' }}
                        class="px-4 py-2 text-xs font-manrope font-medium border-b-2 transition-colors
                            {{ $selectedNav === 'active' ? 'border-[#532E1C] text-[#532E1C]' : 'border-transparent text-[#80543F] hover:text-[#532E1C] cursor-pointer' }}">
                        Admin Aktif
                    </button>
                    <button
                        onclick="window.switchTab('archive')"
                        wire:loading.attr="disabled" 
                        wire:target="selectedNav"
                        {{ $selectedNav === 'archive' ? 'disabled' : '' }}
                        class="px-4 py-2 text-xs font-manrope font-medium border-b-2 transition-colors
                            {{ $selectedNav === 'archive' ? 'border-[#532E1C] text-[#532E1C]' : 'border-transparent text-[#80543F] hover:text-[#532E1C] cursor-pointer' }}">
                        Admin Stall
                    </button>
                </div>

                <div class="w-full flex items-center gap-4">

                    {{-- Search --}}
                    <div class="w-full relative">
                        <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i class="bi bi-search text-[#C5A880] text-xs m-0 p-0"></i>
                        </span>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Cari nama admin atau nomor hp admin..."
                            class="w-full pl-8 pr-4 py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none 
                                placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition"
                        />
                    </div>

                    {{-- Add --}}
                    <div class="shrink-0">
                        <a type="button" href="{{ route('owner.admins-management.create') }}" class="inline-flex py-2 px-3 bg-[#532E1C] rounded-sm font-manrope text-xs text-white font-medium cursor-pointer">
                            Tambah Admin <i class="bi bi-plus text-xs ms-1"></i>
                        </a>
                    </div>

                </div>
                
                {{-- Table lg < --}}
                <div class="hidden lg:block border border-[#E0D2BB] rounded-md overflow-hidden">
                    
                    {{-- Header --}}
                    <table class="w-full border-collapse table-fixed">
                        <thead>
                            <tr class="bg-[#532E1C]">
                                @foreach($columns as $col)
                                    <th class="w-1/3 font-manrope text-center text-xs tracking-wide text-white font-semibold px-4 py-3
                                        {{ $col['key'] === 'action' ? 'text-center' : 'text-left' }}">
                                            {{ $col['label'] }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>

                    {{-- Loading --}}
                    <div wire:loading.flex wire:target="selectedNav" class="py-12 w-full items-center justify-center">
                        <div class="animate-spin h-5 w-5 border-2 border-[#E0D2BB] border-t-[#532E1C] rounded-full"></div>
                    </div>

                    {{-- Data --}}
                    <div wire:loading.remove wire:target="selectedNav">
                        <table class="w-full border-collapse table-fixed">
                            <tbody>
                                @forelse($this->fetchData() as $row)
                                    <tr class="border-b border-[#E0D2BB] hover:bg-[#F9F5F0]">

                                        @foreach($columns as $col)
                                            <td class="px-4 py-3 text-sm text-[#2C180F] 
                                                {{ $col['key'] === 'action' ? 'text-center' : 'text-left' }}">
                                                    @switch($col['key'])
                                                        
                                                        @case('admin_name')
                                                            <span class="font-bold">
                                                                {{ $row['admin_name'] }}
                                                            </span>
                                                        @break

                                                        @case('admin_number')
                                                            {{ $row['admin_number'] }}
                                                        @break

                                                        @case('admin_role')
                                                            {{ $row['admin_role'] === 'cashier' ? 'Kasir' : 'Owner' }}
                                                        @break

                                                        @case('action')
                                                            <div class="flex items-center justify-center gap-4">

                                                                {{-- Edit --}}
                                                                <a href="{{ route('owner.admins-management.update', $row['admin_id']) }}"
                                                                    title="Edit"
                                                                    class="bg-[#9FD6F1] w-6 h-6 text-[#054B6E] rounded-sm cursor-pointer flex items-center justify-center">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                        
                                                                {{-- Archive & Retore --}}
                                                                @if($selectedNav === 'active')
                                                                    
                                                                    <button
                                                                        wire:click="delete('{{ $row['admin_id'] }}')"
                                                                        wire:confirm="Yakin ingin mengarsipkan Admin ini?"
                                                                        title="Hapus"
                                                                        class="bg-[#F9B1B1] w-6 h-6 text-[#AD1614] rounded-sm cursor-pointer">
                                                                        <i class="bi bi-archive"></i>
                                                                    </button>

                                                                @else 

                                                                    <button
                                                                        wire:click="restore('{{ $row['admin_id'] }}')"
                                                                        wire:confirm="Yakin ingin mengembalikan Admin ini?"
                                                                        title="Restore"
                                                                        class="bg-[#B1F9B1] w-6 h-6 text-[#246009] rounded-sm cursor-pointer">
                                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                                    </button>
                                                                
                                                                @endif
                        
                                                            </div>
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
            </div>
             
        </div>
    </div>

    @script
        <script>
            window.switchTab = function(tab) {
                $wire.set('selectedNav', tab);
            }
        </script>
    @endscript

</div>