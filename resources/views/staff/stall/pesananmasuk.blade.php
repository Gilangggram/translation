@extends('staff.stall.layout')

@section('title', "De' Pallet — Panel Stall")

@section('content')
<div class="text-[#2C1A0E] font-manrope selection:bg-[#3B1F0F]/10 selection:text-[#3B1F0F] flex flex-col p-[1.5rem] gap-[1.5rem]">



    <!-- FILTER & SYNC BAR -->
    <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full pb-1 border-b border-[#E9E1D8]/40">
        <!-- Segmented Pill Buttons -->
        <div class="flex items-center gap-2 flex-wrap">
            <!-- 1. Semua Pesanan -->
            <a href="{{ route('stall.pesananmasuk', ['filter' => 'semua', 'search' => $search]) }}" class="flex items-center gap-1.5 px-4 py-2 rounded-full {{ $filter === 'semua' ? 'bg-[#3B1F0F] text-white shadow-sm hover:opacity-90' : 'bg-white text-[#2C1A0E] hover:bg-[#FAF8F5] hover:text-[#3B1F0F] border border-[#E9E1D8] shadow-2xs' }} text-[13px] font-bold transition-all duration-300 cursor-pointer">
                <span>Semua Pesanan</span>
                <span class="inline-flex items-center justify-center {{ $filter === 'semua' ? 'bg-white/20 text-white' : 'bg-[#F5F0EB] text-[#2C1A0E]' }} rounded-full text-[10px] font-extrabold px-2 py-0.5">{{ $semuaCount }}</span>
            </a>

            <!-- 2. Menunggu -->
            <a href="{{ route('stall.pesananmasuk', ['filter' => 'menunggu', 'search' => $search]) }}" class="flex items-center gap-1.5 px-4 py-2 rounded-full {{ $filter === 'menunggu' ? 'bg-[#3B1F0F] text-white shadow-sm hover:opacity-90' : 'bg-white text-[#2C1A0E] hover:bg-[#FAF8F5] hover:text-[#3B1F0F] border border-[#E9E1D8] shadow-2xs' }} text-[13px] font-bold transition-all duration-300 cursor-pointer">
                <span>Menunggu</span>
                <span class="inline-flex items-center justify-center {{ $filter === 'menunggu' ? 'bg-white/20 text-white' : 'bg-[#F5F0EB] text-[#2C1A0E]' }} rounded-full text-[10px] font-extrabold px-2 py-0.5">{{ $menungguCount }}</span>
            </a>

            <!-- 3. Dimasak -->
            <a href="{{ route('stall.pesananmasuk', ['filter' => 'dimasak', 'search' => $search]) }}" class="flex items-center gap-1.5 px-4 py-2 rounded-full {{ $filter === 'dimasak' ? 'bg-[#3B1F0F] text-white shadow-sm hover:opacity-90' : 'bg-white text-[#2C1A0E] hover:bg-[#FAF8F5] hover:text-[#3B1F0F] border border-[#E9E1D8] shadow-2xs' }} text-[13px] font-bold transition-all duration-300 cursor-pointer">
                <span>Dimasak</span>
                <span class="inline-flex items-center justify-center {{ $filter === 'dimasak' ? 'bg-white/20 text-white' : 'bg-[#F5F0EB] text-[#2C1A0E]' }} rounded-full text-[10px] font-extrabold px-2 py-0.5">{{ $dimasakCount }}</span>
            </a>

            <!-- 4. Selesai -->
            <a href="{{ route('stall.pesananmasuk', ['filter' => 'selesai', 'search' => $search]) }}" class="flex items-center gap-1.5 px-4 py-2 rounded-full {{ $filter === 'selesai' ? 'bg-[#3B1F0F] text-white shadow-sm hover:opacity-90' : 'bg-white text-[#2C1A0E] hover:bg-[#FAF8F5] hover:text-[#3B1F0F] border border-[#E9E1D8] shadow-2xs' }} text-[13px] font-bold transition-all duration-300 cursor-pointer">
                <span>Selesai</span>
                <span class="inline-flex items-center justify-center {{ $filter === 'selesai' ? 'bg-white/20 text-white' : 'bg-[#F5F0EB] text-[#2C1A0E]' }} rounded-full text-[10px] font-extrabold px-2 py-0.5">{{ $selesaiCount }}</span>
            </a>
        </div>

        <!-- Right Side: Search and Live Sync -->
        <div class="flex items-center gap-3 w-full md:w-auto flex-wrap">
            <!-- Real-time Sync Indicator -->
            <div class="hidden sm:flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full border border-emerald-100 text-[11px] font-bold">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span>Tersinkronisasi</span>
            </div>

            <!-- Search Input Form -->
            <form action="{{ route('stall.pesananmasuk') }}" method="GET" class="relative w-full sm:w-[220px]">
                <input type="hidden" name="filter" value="{{ $filter }}">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ti ti-search text-[#80756A] text-[15px]"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari ID Pesanan..." class="w-full pl-9 pr-4 py-2 bg-white border border-[#D8CFC7] rounded-full text-[13px] placeholder-[#80756A] focus:outline-none focus:border-[#3B1F0F] focus:ring-1 focus:ring-[#3B1F0F]/15 transition-all shadow-2xs">
            </form>
        </div>
    </section>

    <!-- ORDER CARD GRID (Responsive Grid) -->
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        
        @forelse($orders as $order)
        <div class="bg-white border-[0.5px] border-[#E0D8CF] rounded-none p-[1rem_1.25rem] flex flex-col justify-between shadow-[0_4px_20px_-4px_rgba(44,26,14,0.03)] hover:-translate-y-1 hover:shadow-[0_8px_25px_-5px_rgba(44,26,14,0.08)] transition-all duration-300 cursor-pointer" onclick="showOrderDetail(this, event)" data-order="{{ json_encode($order) }}">
            <!-- ROW 1 — Card Header -->
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-[8px]">
                    @if($order->stall_status === 'MENUNGGU')
                    <span class="inline-flex items-center justify-center bg-[#FDECEA] text-[#C0392B] text-[11px] font-semibold px-[10px] py-[3px] rounded-[99px] select-none">
                        MENUNGGU
                    </span>
                    @elseif($order->stall_status === 'DIMASAK')
                    <span class="inline-flex items-center justify-center bg-[#FFF9E6] text-[#B8966A] text-[11px] font-semibold px-[10px] py-[3px] rounded-[99px] select-none">
                        DIMASAK
                    </span>
                    @else
                    <span class="inline-flex items-center justify-center bg-[#EBF7EE] text-[#2E7D32] text-[11px] font-semibold px-[10px] py-[3px] rounded-[99px] select-none">
                        SELESAI
                    </span>
                    @endif
                    <span class="text-[13px] font-bold text-[#2C1A0E]">{{ str_starts_with($order->order_number, '#') ? $order->order_number : '#' . $order->order_number }}</span>
                </div>
                <div class="flex items-center gap-[4px] text-[12px] text-[#9E9E9E]">
                    <i class="ti ti-clock text-[14px] text-[#9E9E9E]"></i>
                    <span>{{ $order->created_at->format('h:i A') }}</span>
                </div>
            </div>

            <!-- ROW 2 — Table / Location Label -->
            <div class="flex items-center gap-[6px] mt-[14px]">
                @if($order->table)
                <i class="ti ti-armchair text-[16px] text-[#3B1F0F]"></i>
                <span class="text-[15px] font-bold text-[#2C1A0E]">Meja {{ sprintf('%02d', $order->table->table_number) }}</span>
                @else
                <i class="ti ti-shopping-bag text-[16px] text-[#3B1F0F]"></i>
                <span class="text-[15px] font-bold text-[#2C1A0E]">Take Away</span>
                @endif
            </div>

            <!-- ROW 3 — Two-Column Layout -->
            <div class="grid grid-cols-[1fr_auto] gap-[16px] items-start mt-[12px]">
                <!-- LEFT COLUMN — Order item list -->
                <div class="flex flex-col gap-[6px]">
                    @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-start gap-[12px]">
                        <div class="flex flex-col">
                            <span class="text-[13px] text-[#6B6B6B] leading-tight font-medium">{{ $item->quantity }}x {{ $item->menu->name ?? 'Menu' }}</span>
                            @if($item->notes)
                            <span class="text-[13px] text-[#80756A] leading-tight">({{ $item->notes }})</span>
                            @endif
                        </div>
                        <div class="flex items-baseline shrink-0">
                            <span class="text-[12px] text-[#6B6B6B] mr-[2px]">Rp</span>
                            <span class="text-[13px] font-bold text-[#2C1A0E]">{{ number_format($item->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- RIGHT COLUMN — Status Pesanan dropdown -->
                <div class="flex flex-col gap-[6px] shrink-0 select-none">
                    <span class="text-[10px] font-bold text-[#9E9E9E] tracking-[0.05em] uppercase">STATUS PESANAN</span>
                    <div class="relative w-[120px]">
                        <select onchange="handleStatusChange(this, '{{ $order->order_id }}')" class="w-full appearance-none bg-white border-[0.5px] border-[#D8CFC7] rounded-[8px] text-[13px] text-[#2C1A0E] px-[10px] py-[6px] pr-[28px] focus:outline-none focus:border-[#532E1C] font-semibold cursor-pointer">
                            <option value="Menunggu" {{ $order->stall_status === 'MENUNGGU' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Dimasak" {{ $order->stall_status === 'DIMASAK' ? 'selected' : '' }}>Dimasak</option>
                            <option value="Selesai" {{ $order->stall_status === 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-[10px] pointer-events-none text-[#9E9E9E]">
                            <i class="ti ti-chevron-down text-[12px]"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- ROW 4 — Divider -->
            <div class="border-t-[0.5px] border-[#E8E0D8] my-[12px]"></div>

            <!-- ROW 5 — Total + Action Button -->
            <div class="flex justify-between items-end">
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-[#9E9E9E] uppercase tracking-wider leading-none">TOTAL</span>
                    <span class="text-[10px] font-bold text-[#9E9E9E] uppercase tracking-wider leading-none mt-[2px]">PESANAN</span>
                    <div class="flex items-baseline text-[#3B1F0F] mt-[6px]">
                        <span class="text-[12px] font-bold mr-[2px]">Rp</span>
                        <span class="text-[16px] font-bold text-[#3B1F0F]">{{ number_format($order->stall_total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Action Button forms -->
                @if($order->stall_status === 'MENUNGGU')
                <form id="form-proses-{{ $order->order_id }}" action="{{ route('stall.order.proses', $order->order_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-[140px] h-[42px] px-[20px] py-[10px] bg-[#532E1C] text-white flex items-center justify-center gap-[8px] rounded-[8px] text-[14px] font-medium transition-all duration-200 border-0 cursor-pointer hover:bg-[#C5A880] hover:text-[#532E1C] hover:scale-[1.02] hover:shadow-xs">
                        <i class="ti ti-chef-hat text-[16px] text-white"></i>
                        <span>Proses</span>
                    </button>
                </form>
                <form id="form-siap-sajikan-{{ $order->order_id }}" action="{{ route('stall.order.siap-sajikan', $order->order_id) }}" method="POST" class="hidden">
                    @csrf
                </form>
                @elseif($order->stall_status === 'DIMASAK')
                <form id="form-proses-{{ $order->order_id }}" action="{{ route('stall.order.proses', $order->order_id) }}" method="POST" class="hidden">
                    @csrf
                </form>
                <form id="form-siap-sajikan-{{ $order->order_id }}" action="{{ route('stall.order.siap-sajikan', $order->order_id) }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmSiapSajikan('{{ $order->order_id }}')" class="w-[140px] h-[42px] px-[10px] py-[10px] bg-[#1D7A44] text-white flex items-center justify-center gap-[6px] rounded-[8px] text-[13px] font-medium transition-all duration-200 border-0 cursor-pointer hover:bg-[#155A32] hover:scale-[1.02] hover:shadow-xs">
                        <i class="ti ti-circle-check text-[16px] text-white"></i>
                        <span>Siap Sajikan</span>
                    </button>
                </form>
                @else
                <div class="inline-flex items-center gap-[4px] px-[12px] py-[8px] rounded-lg bg-[#EBF7EE] text-[#2E7D32] text-[13px] font-bold">
                    <i class="ti ti-circle-check text-[14px]"></i>
                    Selesai Disajikan
                </div>
                @endif
            </div>
        </div>
        @empty
        <!-- Premium Empty State -->
        <div class="col-span-full flex flex-col items-center justify-center py-16 px-4 text-center bg-white border border-[#E0D8CF] rounded-none shadow-[0_4px_20px_-4px_rgba(44,26,14,0.03)]">
            <div class="w-16 h-16 rounded-full bg-[#FAF8F5] flex items-center justify-center text-[#80756A] mb-4">
                <i class="ti ti-clipboard-x text-3xl"></i>
            </div>
            <h3 class="text-base font-bold text-[#2C1A0E] mb-1">Tidak Ada Pesanan Masuk</h3>
            <p class="text-xs text-[#80756A] max-w-[280px]">Saat ini belum ada pesanan baru yang masuk ke stall Anda.</p>
        </div>
        @endforelse

    </section>

</div>
@endsection

@push('scripts')
<script>
function confirmSiapSajikan(orderId, cancelCallback) {
    window.showConfirmModal({
        title: 'Konfirmasi Pesanan Selesai',
        message: 'Apakah pesanan siap disajikan?',
        confirmText: 'Siap Disajikan',
        cancelText: 'Belum',
        type: 'success',
        onConfirm: () => {
            const formSiapSajikan = document.getElementById('form-siap-sajikan-' + orderId);
            if (formSiapSajikan) formSiapSajikan.submit();
        },
        onCancel: () => {
            if (typeof cancelCallback === 'function') {
                cancelCallback();
            }
        }
    });
}

function handleStatusChange(selectEl, orderId) {
    const val = selectEl.value;
    if (val === 'Dimasak') {
        const formProses = document.getElementById('form-proses-' + orderId);
        if (formProses) formProses.submit();
    } else if (val === 'Selesai') {
        confirmSiapSajikan(orderId, () => {
            selectEl.value = 'Dimasak';
        });
    } else if (val === 'Menunggu') {
        location.reload();
    }
}
</script>
@endpush
