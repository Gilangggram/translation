<header class="relative z-30 w-full h-[72px] bg-[#FAF7F4] border-b-[0.5px] border-[#E8E0D8] px-[1.5rem] py-[10px] flex justify-between items-center select-none shadow-xs">
    <!-- Left Side: Mobile hamburger + title -->
    <div class="flex items-center gap-3">
        <!-- Mobile Sidebar Toggle (hidden on desktop) -->
        <button data-sidebar-toggle
                class="lg:hidden flex items-center justify-center w-8 h-8 rounded-lg hover:bg-[#F0EAE1] text-[#2C1A0E] transition-colors duration-200">
            <i class="ti ti-menu-2 text-[20px]"></i>
        </button>

        <div class="flex flex-col justify-center">
            <h1 class="text-[17px] font-bold text-[#2C1A0E] tracking-tight leading-tight">
                De' Pallet
                @if(isset($stall) && $stall)
                    — {{ $stall->name }}
                @else
                    — Panel Stall
                @endif
            </h1>
            <p class="text-[12px] font-normal text-[#80756A] leading-none mt-[2.5px]">Selamat datang kembali, Partner!</p>
        </div>
    </div>

    <!-- Right Side -->
    <div class="flex items-center gap-[20px]">
        <!-- Status Order Section -->
        <div class="flex items-center gap-[10px] border-r border-[#E8E0D8] pr-[16px] h-[24px]">
            <span class="hidden sm:block text-[10px] font-bold tracking-[0.08em] text-[#80756A] uppercase">STATUS:</span>
            
            @if(isset($stall) && $stall)
            <form id="form-toggle-status" action="{{ route('stall.toggle-status') }}" method="POST" class="m-0 p-0 flex items-center">
                @csrf
                @php $isOpen = (bool)$stall->is_open; @endphp
                <!-- Interactive Toggle Switch -->
                <button type="button" id="btn-toggle-status"
                        class="flex items-center gap-[8px] cursor-pointer group bg-transparent border-0 p-0 focus:outline-none select-none">
                    <!-- Switch Track -->
                    <div id="switch-container"
                         class="relative w-[42px] h-[22px] {{ $isOpen ? 'bg-[#3B1F0F]' : 'bg-[#D8CFC7]' }} rounded-full p-[2.5px] transition-colors duration-300 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] group-hover:scale-105 transform">
                        <!-- Switch Dot -->
                        <div id="switch-dot"
                             class="absolute top-[2.5px] left-[2.5px] w-[17px] h-[17px] bg-white rounded-full transition-transform duration-300 shadow-md {{ $isOpen ? 'translate-x-[20px]' : 'translate-x-0' }}"></div>
                    </div>
                    <!-- Switch Label -->
                    <span id="switch-label"
                          class="text-[12px] font-bold {{ $isOpen ? 'text-[#2C1A0E]' : 'text-[#80756A]' }} tracking-wide uppercase transition-colors duration-200 group-hover:text-[#3B1F0F]">
                        {{ $isOpen ? 'OPEN' : 'CLOSE' }}
                    </span>
                </button>
            </form>
            @else
            <span class="text-[12px] font-bold text-[#80756A]">—</span>
            @endif
        </div>

        <!-- Bell Notification Icon -->
        <div class="relative cursor-pointer p-[6px] hover:bg-[#F5F0EB] rounded-full transition-colors duration-300 group">
            <i class="ti ti-bell text-[20px] text-[#2C1A0E] group-hover:rotate-[12deg] transition-transform duration-300 block"></i>
            <!-- Notification Dot Badge -->
            <span class="absolute top-[5px] right-[5px] w-[7px] h-[7px] bg-red-600 rounded-full border border-[#FAF7F4] shadow-md animate-pulse"></span>
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
            const wasOpen = container.classList.contains('bg-[#3B1F0F]');
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
                container.classList.replace('bg-[#D8CFC7]', 'bg-[#3B1F0F]');
                dot.classList.replace('translate-x-0', 'translate-x-[20px]');
                label.classList.replace('text-[#80756A]', 'text-[#2C1A0E]');
                label.textContent = 'OPEN';
            } else {
                container.classList.replace('bg-[#3B1F0F]', 'bg-[#D8CFC7]');
                dot.classList.replace('translate-x-[20px]', 'translate-x-0');
                label.classList.replace('text-[#2C1A0E]', 'text-[#80756A]');
                label.textContent = 'CLOSE';
            }
        }
    });
</script>
