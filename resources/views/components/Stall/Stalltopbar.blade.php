<header class="sticky top-0 z-30 w-full h-[72px] bg-white/95 backdrop-blur-xs border-b border-[#FAF2E8] px-[1.5rem] py-[10px] flex justify-between items-center select-none shadow-[0_1px_3px_0_rgba(44,26,14,0.03)]">
    <!-- Left Side: Mobile hamburger + title -->
    <div class="flex items-center gap-3">
        <!-- Mobile Sidebar Toggle (hidden on desktop) -->
        <button data-sidebar-toggle
                class="lg:hidden flex items-center justify-center w-8 h-8 rounded-lg hover:bg-[#F0EAE1] text-[#2C1A0E] transition-colors duration-200">
            <i class="bi bi-list text-[20px]"></i>
        </button>

        @php
            $pageTitle = 'Dashboard';
            if (request()->routeIs('stall.pesananmasuk')) {
                $pageTitle = 'Pesanan Masuk';
            } elseif (request()->routeIs('stall.sales-report')) {
                $pageTitle = 'Laporan Penjualan';
            }
        @endphp
        <div class="flex flex-col justify-center">
            <h1 class="text-[16px] font-extrabold text-[#2C1A0E] tracking-tight leading-none flex items-center gap-2">
                <span>{{ $pageTitle }}</span>
                <span class="text-[#80756A] text-[11px] font-bold tracking-wide uppercase flex items-center gap-1.5 before:content-['|'] before:text-[#E5DCCE] before:font-light">
                    @if(isset($stall) && $stall)
                        {{ $stall->name }}
                    @else
                        Stall
                    @endif
                </span>
            </h1>
            <p class="text-[11px] font-normal text-[#80756A] leading-none mt-[6px]">Selamat datang kembali, Partner!</p>
        </div>
    </div>

    <!-- Right Side -->
    <div class="flex items-center gap-[20px]">
        <!-- Status Order Section -->
        <div class="flex items-center gap-[12px] border-r border-[#FAF2E8] pr-[20px] h-[28px]">
            <span class="hidden sm:block text-[10px] font-bold tracking-[0.08em] text-[#80756A] uppercase">STATUS STALL:</span>
            
            @if(isset($stall) && $stall)
            <form id="form-toggle-status" action="{{ route('stall.toggle-status') }}" method="POST" class="m-0 p-0 flex items-center">
                @csrf
                @php $isOpen = (bool)$stall->is_open; @endphp
                <!-- Interactive Toggle Switch -->
                <button type="button" id="btn-toggle-status"
                        class="flex items-center gap-[10px] cursor-pointer group bg-transparent border-0 p-0 focus:outline-none select-none">
                    <!-- Switch Track -->
                    <div id="switch-container"
                         class="relative w-[44px] h-[24px] {{ $isOpen ? 'bg-[#532E1C]' : 'bg-[#D8CFC7]' }} rounded-full p-[3px] transition-all duration-300 shadow-[inset_0_2px_4px_rgba(0,0,0,0.08)] group-hover:scale-105 transform">
                        <!-- Switch Dot -->
                        <div id="switch-dot"
                             class="absolute top-[3px] left-[3px] w-[18px] h-[18px] bg-white rounded-full transition-transform duration-300 shadow-[0_2px_5px_rgba(0,0,0,0.15)] {{ $isOpen ? 'translate-x-[20px]' : 'translate-x-0' }}"></div>
                    </div>
                    <!-- Switch Label -->
                    <span id="switch-label"
                          class="text-[11px] font-extrabold {{ $isOpen ? 'text-emerald-700 bg-emerald-50 border border-emerald-200/50' : 'text-[#80756A] bg-[#FAF7F4] border border-[#E0D8CF]/50' }} px-2 py-0.5 rounded-[6px] tracking-wide uppercase transition-all duration-200 group-hover:shadow-xs">
                        {{ $isOpen ? 'OPEN' : 'CLOSE' }}
                    </span>
                </button>
            </form>
            @else
            <span class="text-[12px] font-bold text-[#80756A]">—</span>
            @endif
        </div>

        <!-- Bell Notification Icon -->
        <div class="relative cursor-pointer w-9 h-9 bg-white border border-[#FAF2E8] hover:bg-[#FAF7F4] rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm group">
            <i class="bi bi-bell text-[16px] text-[#2C1A0E] group-hover:rotate-[12deg] transition-transform duration-300 block"></i>
            <!-- Notification Dot Badge -->
            <span class="absolute top-[3px] right-[3px] w-[8px] h-[8px] bg-red-500 rounded-full border-2 border-white shadow-sm animate-pulse"></span>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('btn-toggle-status');
        const form      = document.getElementById('form-toggle-status');
        const container = document.getElementById('switch-container');
        const dot       = document.getElementById('switch-dot');
        const label     = document.getElementById('switch-label');

        if (!toggleBtn || !form || !container || !dot || !label) return;

        let isPending = false;

        toggleBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            if (isPending) return;
            isPending = true;

            // Detect current visual state
            const wasOpen = container.classList.contains('bg-[#532E1C]');
            const nextOpen = !wasOpen;

            // 1. Optimistic UI — update immediately for snappy feel
            applyState(nextOpen);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    if (typeof window.showToast === 'function') {
                        window.showToast(result.message, 'success');
                    }
                } else {
                    throw new Error(result.message || 'Gagal mengubah status.');
                }
            } catch (err) {
                console.error('Toggle status error:', err);
                // Revert to previous state on failure
                applyState(wasOpen);
                if (typeof window.showToast === 'function') {
                    window.showToast(err.message || 'Terjadi kesalahan. Coba lagi.', 'error');
                }
            } finally {
                isPending = false;
            }
        });

        function applyState(isOpen) {
            if (isOpen) {
                container.classList.replace('bg-[#D8CFC7]', 'bg-[#532E1C]');
                dot.classList.replace('translate-x-0', 'translate-x-[20px]');
                label.className = "text-[11px] font-extrabold text-emerald-700 bg-emerald-50 border border-emerald-200/50 px-2 py-0.5 rounded-[6px] tracking-wide uppercase transition-all duration-200 group-hover:shadow-xs";
                label.textContent = 'OPEN';
            } else {
                container.classList.replace('bg-[#532E1C]', 'bg-[#D8CFC7]');
                dot.classList.replace('translate-x-[20px]', 'translate-x-0');
                label.className = "text-[11px] font-extrabold text-[#80756A] bg-[#FAF7F4] border border-[#E0D8CF]/50 px-2 py-0.5 rounded-[6px] tracking-wide uppercase transition-all duration-200 group-hover:shadow-xs";
                label.textContent = 'CLOSE';
            }
        }
    });
</script>
