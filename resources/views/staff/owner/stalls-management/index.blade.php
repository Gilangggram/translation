@section('title', 'Pengelolaan Stall')

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
                        Stall Aktif
                    </button>
                    <button
                        onclick="window.switchTab('archive')"
                        wire:loading.attr="disabled" 
                        wire:target="selectedNav"
                        {{ $selectedNav === 'archive' ? 'disabled' : '' }}
                        class="px-4 py-2 text-xs font-manrope font-medium border-b-2 transition-colors
                            {{ $selectedNav === 'archive' ? 'border-[#532E1C] text-[#532E1C]' : 'border-transparent text-[#80543F] hover:text-[#532E1C] cursor-pointer' }}">
                        Arsip Stall
                    </button>
                </div>
        
                <div class="w-full flex items-center gap-4">
        
                    {{-- Search --}}
                    <div class="w-full relative">
                        <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i class="bi bi-search text-[#C5A880] text-xs"></i>
                        </span>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Cari nama stall, pemilik, atau nomor hp..."
                            class="w-full pl-8 pr-4 py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none
                                   placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition"
                        />
                    </div>
        
                    {{-- add --}}
                    <div class="shrink-0">
                        <a href="{{ route('owner.stalls-management.create') }}" class="inline-flex py-2 px-3 bg-[#532E1C] rounded-sm font-manrope text-xs text-white font-medium cursor-pointer">
                            Tambah Stall <i class="bi bi-plus text-xs ms-1"></i>
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
                                    <th class="w-1/3 font-manrope text-xs tracking-wide text-white font-semibold px-4 py-3
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
                                    <tr class="border-b border-[#E0D2BB] hover:bg-[#F5F2F0]">
                                       
                                        @foreach($columns as $col)
                                            <td class="px-4 py-3 text-sm text-[#2C180F]
                                                {{ $col['key'] === 'action' ? 'text-center' : 'text-left' }}">
                                                    @switch($col['key'])
            
                                                        @case('stall_name')
                                                            <div class="flex flex-col">
                                                                <span class="font-bold">{{ $row['stall_name'] }}</span>
                                                                <span class="text-xs text-[#532E1C]">ID: {{ $row['stall_code'] }}</span>
                                                            </div>
                                                        @break
            
                                                        @case('owner_name')
                                                            {{ $row['owner_name'] }}
                                                        @break
            
                                                        @case('owner_number')
                                                            {{ $row['owner_number'] }}
                                                        @break
            
                                                        @case('is_open')
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                                                                {{ $this->getStallStatusClasses($row['is_open']) }}">
                                                                <span class="w-1 h-1 rounded-full bg-current mt-px"></span>
                                                                {{ $row['is_open'] ? 'Buka' : 'Tutup' }}
                                                            </span>
                                                        @break
            
                                                        @case('menu_count')
                                                            {{ $row['menu_count'] }} Menu
                                                        @break
            
                                                        @case('action')
                                                            <div class="flex items-center justify-center gap-4">

                                                                {{-- Detail --}}
                                                                <a href="{{ route('owner.stalls-management.detail', $row['stall_id']) }}"
                                                                    title="Detail"
                                                                    class="bg-[#532E1C] w-6 h-6 text-[#F5F2F0] rounded-sm cursor-pointer flex items-center justify-center">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </a>

                                                                {{-- Edit --}}
                                                                <a href="{{ route('owner.stalls-management.update', $row['stall_id']) }}"
                                                                    title="Edit"
                                                                    class="bg-[#9FD6F1] w-6 h-6 text-[#054B6E] rounded-sm cursor-pointer flex items-center justify-center">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>

                                                                {{-- Archive & Restore --}}
                                                                @if($selectedNav === 'active')
                                                                
                                                                    <button
                                                                        wire:click="delete('{{ $row['stall_id'] }}')"
                                                                        wire:confirm="Yakin ingin mengarsipkan stall ini?"
                                                                        title="Hapus"
                                                                        class="bg-[#F9B1B1] w-6 h-6 text-[#AD1614] rounded-sm cursor-pointer">
                                                                        <i class="bi bi-archive"></i>
                                                                    </button>

                                                                @else

                                                                    <button
                                                                        wire:click="restore('{{ $row['stall_id'] }}')"
                                                                        wire:confirm="Yakin ingin mengembalikan stall ini?"
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
