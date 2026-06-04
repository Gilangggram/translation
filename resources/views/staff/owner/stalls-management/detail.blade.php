@section('title', 'Detail Stall')

<div class="w-full min-h-screen bg-[#F0E7D8] p-4">

    <div class="flex flex-col gap-2">
        
        <a href="{{ route('owner.stalls-management.index') }}"
            class="w-fit py-1 ps-1 pe-2 text-sm bg-[#F5F2F0] border border-[#2C180F] rounded-lg text-[#532E1C] cursor-pointer">
                <i class="bi bi-chevron-left text-xs me-1"></i>Kembali
        </a>

        <div class="flex flex-col bg-white rounded-lg w-full p-4 border border-[#E0D2BB] gap-4">
            
            <div>
                <h3 class="font-manrope text-sm font-medium text-[#532E1C]">Informasi Stall</h3>
                <p class="font-manrope text-xs text-[#80543F]">Detail dan identitas stall</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                <div class="flex flex-col gap-1">
                    <span class="font-manrope text-xs text-[#2C180F]">ID Stall</span>
                    <span class="font-noto-serif text-sm font-bold text-[#532E1C]">{{ $stallData['stall_code'] }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-manrope text-xs text-[#2C180F]">Nama Stall</span>
                    <span class="font-noto-serif text-sm font-bold text-[#532E1C]">{{ $stallData['stall_name'] }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-manrope text-xs text-[#2C180F]">Nama Pemilik</span>
                    <span class="font-noto-serif text-sm font-bold text-[#532E1C]">{{ $stallData['owner_name'] }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-manrope text-xs text-[#2C180F]">Nomor Telepon</span>
                    <span class="font-noto-serif text-sm font-bold text-[#532E1C]">{{ $stallData['owner_number'] }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-manrope text-xs text-[#2C180F]">Status</span>
                    <span class="w-fit inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $this->getStallStatusClasses($stallData['is_open']) }}">
                        <span class="w-1 h-1 rounded-full bg-current mt-px"></span>
                        {{ $stallData['is_open'] ? 'Buka' : 'Tutup' }}
                    </span>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="font-manrope text-xs text-[#2C180F]">Terdaftar</span>
                    <span class="font-noto-serif text-sm font-bold text-[#532E1C]">{{ $stallData['created_at'] }}</span>
                </div>

            </div>
        
        </div>

        <div class="flex flex-col bg-white rounded-lg w-full p-4 border border-[#E0D2BB] gap-4">
            
            <div class="w-full relative flex flex-col gap-4">
            
                {{-- Nav --}}
                <div class="flex border-b border-[#E0D2BB]">
                    <button
                        onclick="window.switchTab('active')"
                        wire:loading.attr="disabled" 
                        wire:target="selectedNav"
                        {{ $selectedNav === 'active' ? 'disabled' : '' }}
                        class="px-4 py-2 text-xs font-manrope font-medium border-b-2 transition-colors
                            {{ $selectedNav === 'active' ? 'border-[#532E1C] text-[#532E1C]' : 'border-transparent text-[#80543F] hover:text-[#532E1C] cursor-pointer' }}">
                        Menu Aktif
                    </button>
                    <button
                        onclick="window.switchTab('archive')"
                        wire:loading.attr="disabled" 
                        wire:target="selectedNav"
                        {{ $selectedNav === 'archive' ? 'disabled' : '' }}
                        class="px-4 py-2 text-xs font-manrope font-medium border-b-2 transition-colors
                            {{ $selectedNav === 'archive' ? 'border-[#532E1C] text-[#532E1C]' : 'border-transparent text-[#80543F] hover:text-[#532E1C] cursor-pointer' }}">
                        Arsip Menu
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
                            Tambah Menu <i class="bi bi-plus text-xs ms-1"></i>
                        </a>
                    </div>
                </div>
        
                {{-- Desktop Table --}}
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
                                @forelse($this->fetchmenuData() as $row)
                                    <tr style="border-bottom: 1px solid #E0D2BB;" class="hover:bg-[#F5F2F0]">
                                        @foreach($columns as $col)
                                            <td class="px-4 py-3 text-sm text-[#2C180F]
                                                {{ $col['key'] === 'action' ? 'text-center' : 'text-left' }}">
                                                @switch($col['key'])
        
                                                    @case('menu_name')
                                                        <div class="flex flex-col">
                                                            <span class="font-bold">{{ $row['menu_name'] }}</span>
                                                        </div>
                                                    @break
        
                                                    @case('menu_desc')
                                                        {{ $row['menu_desc'] }}
                                                    @break
        
                                                    @case('menu_price')
                                                        Rp {{ number_format($row['menu_price'], 0, ',', '.') }}
                                                    @break
        
                                                    @case('is_menu_available')
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                                                            {{ $this->getMenuStatusClasses($row['is_menu_available']) }}">
                                                                <span class="w-1 h-1 rounded-full bg-current mt-px"></span>
                                                                {{ $row['is_menu_available'] ? 'Tersedia' : 'Habis' }}
                                                        </span>
                                                    @break

                                                    @case('action')
                                                        <div class="flex items-center justify-center gap-4">
                                                            <a href=""
                                                                title="Edit"
                                                                class="bg-[#9FD6F1] w-6 h-6 text-[#054B6E] rounded-sm cursor-pointer flex items-center justify-center">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <button
                                                                wire:click=""
                                                                wire:confirm="Yakin ingin menghapus stall ini?"
                                                                title="Hapus"
                                                                class="bg-[#F9B1B1] w-6 h-6 text-[#AD1614] rounded-sm cursor-pointer">
                                                                <i class="bi bi-archive"></i>
                                                            </button>
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
