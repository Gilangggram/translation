<div class="w-[220px] h-screen bg-[#3B1F0F] text-[#F5F2F0] flex flex-col justify-between py-6 px-4 shrink-0 font-manrope select-none shadow-md">
    <!-- Brand / Top Section -->
    <div class="flex flex-col mb-8 px-2">
        <span class="font-abril-fatface text-2xl font-bold text-white leading-tight">De' Pallet</span>
        <span class="font-manrope text-[10px] text-[#C9A87C] tracking-[0.18em] uppercase font-bold mt-0.5">SISTEM KASIR</span>
    </div>

    <!-- Navigation Menu Items -->
    <nav class="flex-1 flex flex-col gap-1.5">
        <!-- 1. Dashboard -->
        <a href="{{ route('stall.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 {{ Route::is('stall.dashboard') ? 'bg-[#C9A87C] text-[#3B1F0F] shadow-sm' : 'text-[#F5F2F0]/70 hover:text-white hover:bg-white/5 font-semibold' }}">
            <i class="ti ti-layout-dashboard text-lg"></i>
            <span>Dashboard</span>
        </a>

        <!-- 2. Pesanan Masuk -->
        <a href="{{ route('stall.pesananmasuk') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 {{ Route::is('stall.pesananmasuk') ? 'bg-[#C9A87C] text-[#3B1F0F] shadow-sm' : 'text-[#F5F2F0]/70 hover:text-white hover:bg-white/5 font-semibold' }}">
            <i class="ti ti-clipboard-list text-lg"></i>
            <span>Pesanan Masuk</span>
        </a>

        <!-- 3. Daftar Menu -->
        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#F5F2F0]/70 hover:text-white hover:bg-white/5 text-xs font-semibold transition-all duration-200">
            <i class="ti ti-building-store text-lg"></i>
            <span>Daftar Menu</span>
        </a>

        <!-- 4. Laporan Penjualan -->
        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#F5F2F0]/70 hover:text-white hover:bg-white/5 text-xs font-semibold transition-all duration-200">
            <i class="ti ti-chart-bar text-lg"></i>
            <span>Laporan Penjualan</span>
        </a>
    </nav>

    <!-- Bottom Section -->
    <div class="flex flex-col gap-1 mt-auto pt-6 border-t border-white/5">
        <!-- Profil -->
        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#F5F2F0]/70 hover:text-white hover:bg-white/5 text-xs font-semibold transition-all duration-200">
            <i class="ti ti-user text-lg"></i>
            <span>Profil</span>
        </a>

        <!-- Keluar -->
        <form id="logout-form" action="{{ route('stall.logout') }}" method="POST" class="w-full">
            @csrf
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-300/80 hover:text-red-200 hover:bg-red-950/20 text-xs font-semibold transition-all duration-200 cursor-pointer bg-transparent border-0">
                <i class="ti ti-logout text-lg"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>
