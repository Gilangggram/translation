<div class="bg-[#532E1C] h-full flex flex-col">

    <div class="px-6 py-6 shrink-0 flex flex-col justify-between">
        <h1 class="text-sm text-[#C5A880] font-noto-serif">Sistem Owner</h1>
        <h1 class="text-lg text-white font-thin font-abril-fatface">De' <span>Pallet</span> Cafe</h1>
    </div>

    <div class="h-0.5 bg-white/10 w-full"></div>

    <div class="py-5 flex flex-col gap-4">
        <div class="flex flex-col gap-2">
            <h2 class="px-4 font-noto-serif text-xs text-[#A68C68] uppercase font-medium">Menu Utama</h2>
    
            <nav class="mx-4 flex flex-col gap-1">
                <a href="{{ route('owner.dashboard') }}" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all
                    {{ request()->routeIs('owner.dashboard') ? 'text-white font-medium bg-white/10' : 'text-white/60 hover:text-[#F5F2F0] hover:bg-white/5' }}">
                        <i class="bi bi-grid text-sm"></i> Dashboard
                </a>
    
                <a href="{{ route('owner.sales-report') }}" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all
                        {{ request()->routeIs('owner.sales-report') ? 'text-white font-medium border-l-amber-400 bg-white/10' : 'text-white/60 hover:text-[#F5F2F0] hover:bg-white/5' }}">
                            <i class="bi bi-bar-chart-line text-sm"></i> Laporan Penjualan
                </a>
    
                <a href="" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all
                        {{ request()->routeIs('cashier.reservasi') ? 'text-white font-medium border-l-amber-400 bg-white/10' : 'text-white/60 hover:text-[#F5F2F0] hover:bg-white/5' }}">
                            <i class="bi bi-shop text-sm"></i> Kelola Stall
                </a>
    
            </nav>
        </div>
        
        <div class="flex flex-col gap-2">
            <h2 class="px-4 font-noto-serif text-xs text-[#A68C68] uppercase font-medium">Akun</h2>
            <nav class="mx-4 flex flex-col">
                <a href="" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all text-white/60 hover:text-[#F5F2F0] hover:bg-white/5">
                    <i class="bi bi-person text-sm"></i> Profil
                </a>
            </nav>
        </div>
    </div>
    

</div>