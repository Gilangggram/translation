<div class="py-3 px-5 bg-white border-b border-b-[#E0D2BB]">
    <div class="flex justify-between items-center">
    
        <div class="lg:hidden">
            <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" type="button"
                class="flex items-center justify-center w-8 h-8 rounded-sm border border-[#E0D2BB] text-[#532E1C]">
                    <i class="bi bi-list text-lg"></i>
            </button>
        </div>
        
        <div>
            <h2 class="font-noto-serif text-[#2C180F] text-base md:text-sm font-semibold">@yield('title')</h2>
            <p class="hidden lg:flex font-manrope text-[#532E1C] text-xs">Selamat datang kembali</p>
        </div>

        <div class="flex gap-3 items-center">
            <div class="hidden lg:flex flex-col justify-center px-2 py-1 h-fit border border-[#E0D2BB] rounded-sm">
                <span id="clock" class="font-manrope text-sm text-[#532E1C]"></span>
            </div>

            <div class="relative">
                <button type="button" class="flex items-center justify-center bg-[#F5F2F0] w-8 h-8 border border-[#2C180F] rounded-sm text-[#532E1C] cursor-pointer">
                    <i class="bi bi-bell text-md"></i>
                </button>

                {{-- notification indicator --}}
                <div class="hidden absolute right-2 top-2 w-2 h-2 bg-red-500 rounded-full text-[10px] border border-[#F5F2F0]"></div>
            </div>
        </div>
    </div>
</div>

