<div class="bg-[#532E1C] h-full flex flex-col select-none justify-between">
    <div>
        <div class="px-6 py-6 shrink-0 flex flex-col justify-between">
            <h1 class="text-sm text-[#C5A880] font-noto-serif">Sistem Stall</h1>
            <p class="text-lg text-white font-thin font-abril-fatface">De' <span>Pallet</span> Cafe</p>
        </div>

        <div class="h-0.5 bg-white/10 w-full"></div>

        <div class="py-5 flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <h2 class="px-4 font-noto-serif text-xs text-[#A68C68] uppercase font-medium">Menu Utama</h2>
        
                <nav class="mx-4 flex flex-col gap-1">
                    <!-- 1. Dashboard -->
                    <a href="{{ route('stall.dashboard') }}" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all
                        {{ request()->routeIs('stall.dashboard') ? 'text-white font-medium bg-white/10' : 'text-white/60 hover:text-[#F5F2F0] hover:bg-white/5' }}">
                        <i class="bi bi-grid text-sm"></i> Dashboard
                    </a>

                    <!-- 2. Pesanan Masuk -->
                    <a href="{{ route('stall.pesananmasuk') }}" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all
                        {{ request()->routeIs('stall.pesananmasuk') ? 'text-white font-medium bg-white/10' : 'text-white/60 hover:text-[#F5F2F0] hover:bg-white/5' }}">
                        <i class="bi bi-clipboard text-sm"></i> Pesanan Masuk
                    </a>

                    <!-- 3. Daftar Menu -->
                    <a href="#" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all text-white/60 hover:text-[#F5F2F0] hover:bg-white/5">
                        <i class="bi bi-card-text text-sm"></i> Daftar Menu
                    </a>

                    <!-- 4. Laporan Penjualan -->
                    <a href="#" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all text-white/60 hover:text-[#F5F2F0] hover:bg-white/5">
                        <i class="bi bi-bar-chart-line text-sm"></i> Laporan Penjualan
                    </a>
                </nav>
            </div>
            
            <div class="flex flex-col gap-2">
                <h2 class="px-4 font-noto-serif text-xs text-[#A68C68] uppercase font-medium">Akun</h2>
                <nav class="mx-4 flex flex-col gap-1">
                    <a href="#" class="px-2 py-2 flex items-center gap-3 font-manrope text-sm rounded-sm transition-all text-white/60 hover:text-[#F5F2F0] hover:bg-white/5">
                        <i class="bi bi-person text-sm"></i> Profil
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="py-5 border-t border-white/10">
        <nav class="mx-4 flex flex-col">
            <!-- Keluar -->
            <form id="logout-form" action="{{ route('stall.logout') }}" method="POST" class="w-full">
                @csrf
                <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-2 py-2 rounded-sm text-red-300/80 hover:text-red-200 hover:bg-white/5 text-sm font-semibold transition-all duration-200 cursor-pointer bg-transparent border-0 text-left">
                    <i class="bi bi-box-arrow-right text-sm"></i> Keluar
                </button>
            </form>
        </nav>
    </div>
</div>
