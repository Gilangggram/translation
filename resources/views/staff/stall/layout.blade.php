@extends('master')

@section('body')
    <div class="flex min-h-screen bg-[#F5F0EB]">

        <!-- Sidebar Section -->
        <aside id="sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full lg:translate-x-0 lg:sticky lg:shrink-0">
            @include('components.Stall.Stallsidebar')
        </aside> 
        
        <!-- Main Content Wrapper -->
        <div class="flex flex-col flex-1 min-w-0">
            
            <!-- Topbar Section -->
            @include('components.Stall.Stalltopbar')

            <!-- Page Slot Content -->
            <main class="flex-1 relative">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    window.showConfirmModal = function({
        title = 'Konfirmasi',
        message = 'Apakah Anda yakin?',
        confirmText = 'Ya',
        cancelText = 'Batal',
        type = 'info',
        onConfirm = () => {},
        onCancel = () => {}
    }) {
        const existing = document.getElementById('custom-confirm-modal');
        if (existing) existing.remove();

        let iconHTML = '';
        let btnColor = '';
        if (type === 'danger') {
            iconHTML = `<div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600 mb-4 mx-auto">
                <i class="ti ti-alert-triangle text-[24px]"></i>
            </div>`;
            btnColor = 'bg-red-600 hover:bg-red-700 text-white';
        } else if (type === 'success') {
            iconHTML = `<div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-[#1D7A44] mb-4 mx-auto">
                <i class="ti ti-circle-check text-[24px]"></i>
            </div>`;
            btnColor = 'bg-[#1D7A44] hover:bg-[#155A32] text-white';
        } else {
            iconHTML = `<div class="w-12 h-12 rounded-full bg-[#FAF8F5] flex items-center justify-center text-[#3B1F0F] mb-4 mx-auto border border-[#E8E0D8]">
                <i class="ti ti-question-mark text-[24px]"></i>
            </div>`;
            btnColor = 'bg-[#3B1F0F] hover:bg-[#2C1A0E] text-white';
        }

        const modalHTML = `
        <div id="custom-confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-opacity duration-300 opacity-0 select-none">
            <div class="bg-white rounded-[16px] max-w-[360px] w-full p-6 shadow-[0_20px_50px_rgba(44,26,14,0.15)] border border-[#E8E0D8] transform scale-95 transition-transform duration-300">
                ${iconHTML}
                <h3 class="text-[16px] font-bold text-[#2C1A0E] text-center mb-2 leading-snug">${title}</h3>
                <p class="text-[13px] text-[#80756A] text-center mb-6 leading-relaxed px-2">${message}</p>
                <div class="flex gap-3 justify-center">
                    <button id="modal-cancel-btn" type="button" class="flex-1 py-2.5 px-4 bg-[#FAF8F5] border border-[#D8CFC7] hover:bg-[#F5F0EB] text-[#2C1A0E] rounded-[8px] text-[13px] font-bold transition-all duration-200 cursor-pointer">
                        ${cancelText}
                    </button>
                    <button id="modal-confirm-btn" type="button" class="flex-1 py-2.5 px-4 ${btnColor} rounded-[8px] text-[13px] font-bold transition-all duration-200 cursor-pointer">
                        ${confirmText}
                    </button>
                </div>
            </div>
        </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        const modalEl = document.getElementById('custom-confirm-modal');
        const boxEl = modalEl.querySelector('div');

        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            boxEl.classList.remove('scale-95');
        }, 10);

        const closeModal = (callback) => {
            modalEl.classList.add('opacity-0');
            boxEl.classList.add('scale-95');
            setTimeout(() => {
                modalEl.remove();
                if (callback) callback();
            }, 300);
        };

        document.getElementById('modal-cancel-btn').addEventListener('click', () => {
            closeModal(onCancel);
        });

        document.getElementById('modal-confirm-btn').addEventListener('click', () => {
            closeModal(onConfirm);
        });

        modalEl.addEventListener('click', (e) => {
            if (e.target === modalEl) {
                closeModal(onCancel);
            }
        });
    };

    window.showOrderDetail = function(el, event) {
        if (event) {
            const target = event.target;
            if (target.closest('select') || target.closest('button') || target.closest('form') || target.closest('a')) {
                return;
            }
        }
        try {
            const orderData = JSON.parse(el.getAttribute('data-order'));
            window.openOrderDetailModal(orderData);
        } catch(e) {
            console.error('Error parsing order data:', e);
        }
    };

    window.openOrderDetailModal = function(order) {
        const existing = document.getElementById('order-detail-modal');
        if (existing) existing.remove();

        const dateObj = new Date(order.created_at);
        const timeStr = dateObj.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
        const dateStr = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

        let locationHTML = '';
        if (order.table) {
            locationHTML = `
            <div class="flex items-center gap-2 bg-[#FAF8F5] border border-[#E8E0D8] px-3 py-2 rounded-lg">
                <i class="ti ti-armchair text-[18px] text-[#3B1F0F]"></i>
                <span class="text-[13px] font-bold text-[#2C1A0E]">Meja ${String(order.table.table_number).padStart(2, '0')}</span>
            </div>`;
        } else {
            locationHTML = `
            <div class="flex items-center gap-2 bg-[#FAF8F5] border border-[#E8E0D8] px-3 py-2 rounded-lg">
                <i class="ti ti-shopping-bag text-[18px] text-[#3B1F0F]"></i>
                <span class="text-[13px] font-bold text-[#2C1A0E]">Take Away</span>
            </div>`;
        }

        let paymentBadge = '';
        const payStatus = (order.payment_status || 'unpaid').toLowerCase();
        if (payStatus === 'paid') {
            paymentBadge = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-[#1D7A44] border border-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-[#1D7A44]"></span> PAID
            </span>`;
        } else if (payStatus === 'cancelled') {
            paymentBadge = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> CANCELLED
            </span>`;
        } else {
            paymentBadge = `<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PENDING
            </span>`;
        }

        let itemsHTML = '';
        let subtotal = 0;
        const items = order.order_items || [];
        
        items.forEach(item => {
            const menuName = item.menu ? item.menu.name : 'Menu';
            const priceFormatted = new Intl.NumberFormat('id-ID').format(item.total_price);
            subtotal += Number(item.total_price);

            let notesHTML = '';
            if (item.notes) {
                notesHTML = `
                <div class="flex items-center gap-1 mt-1 text-[11px] text-[#80756A] italic bg-[#FAF8F5] p-1.5 rounded border-l-2 border-[#C9A87C]">
                    <i class="ti ti-note text-[12px]"></i>
                    <span>"${item.notes}"</span>
                </div>`;
            }

            itemsHTML += `
            <div class="py-3 border-b border-[#FAF6F0] last:border-0">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex flex-col">
                        <span class="text-[13px] font-bold text-[#2C1A0E]">${item.quantity}x ${menuName}</span>
                        ${notesHTML}
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-[13px] font-extrabold text-[#2C1A0E]">Rp ${priceFormatted}</span>
                    </div>
                </div>
            </div>`;
        });

        const subtotalFormatted = new Intl.NumberFormat('id-ID').format(subtotal);

        const modalHTML = `
        <div id="order-detail-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-opacity duration-300 opacity-0 select-none">
            <div class="bg-white rounded-[20px] max-w-[420px] w-full shadow-[0_24px_60px_rgba(44,26,14,0.18)] border border-[#E5DCCE] overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]">
                
                <div class="bg-[#3B1F0F] text-white p-5 flex justify-between items-center relative">
                    <div>
                        <h3 class="text-[11px] font-bold tracking-wide uppercase text-[#C9A87C]">Detail Pesanan</h3>
                        <h4 class="text-[18px] font-black text-white mt-0.5">${order.order_number.startsWith('#') ? order.order_number : '#' + order.order_number}</h4>
                    </div>
                    <button id="modal-close-x-btn" type="button" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center border-0 cursor-pointer transition-colors duration-200">
                        <i class="ti ti-x text-[16px]"></i>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <span class="text-[10px] font-bold text-[#9E9E9E] tracking-wider uppercase block">Waktu Pesan</span>
                            <span class="text-[13px] font-bold text-[#2C1A0E] mt-0.5 block">${timeStr}</span>
                            <span class="text-[11px] text-[#80756A] block">${dateStr}</span>
                        </div>
                        <div class="flex flex-col items-end justify-center">
                            <span class="text-[10px] font-bold text-[#9E9E9E] tracking-wider uppercase block mb-1">Status Bayar</span>
                            ${paymentBadge}
                        </div>
                    </div>

                    <div class="mb-6">
                        <span class="text-[10px] font-bold text-[#9E9E9E] tracking-wider uppercase block mb-1.5">Lokasi Sajian</span>
                        ${locationHTML}
                    </div>

                    <div class="border-t-[0.5px] border-[#E8E0D8] pt-4 mb-2">
                        <span class="text-[10px] font-bold text-[#9E9E9E] tracking-wider uppercase">Menu Pesanan (Stall Anda)</span>
                    </div>

                    <div class="max-h-[220px] overflow-y-auto mb-6 custom-scrollbar pr-1">
                        ${itemsHTML}
                    </div>

                    <div class="bg-[#FAF8F5] border border-[#E8E0D8] rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[13px] font-bold text-[#80756A]">Total Tagihan Stall</span>
                            <span class="text-[16px] font-black text-[#3B1F0F]">Rp ${subtotalFormatted}</span>
                        </div>
                    </div>

                </div>

                <div class="border-t border-[#E8E0D8] p-4 bg-[#FAF8F5] flex justify-end">
                    <button id="modal-close-btn" type="button" class="w-full sm:w-auto py-2.5 px-6 bg-[#3B1F0F] hover:bg-[#2C1A0E] text-white rounded-lg text-[13px] font-bold transition-all duration-200 cursor-pointer shadow-xs">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        const modalEl = document.getElementById('order-detail-modal');
        const boxEl = modalEl.querySelector('div');

        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            boxEl.classList.remove('scale-95');
        }, 10);

        const closeModal = () => {
            modalEl.classList.add('opacity-0');
            boxEl.classList.add('scale-95');
            setTimeout(() => {
                modalEl.remove();
            }, 300);
        };

        document.getElementById('modal-close-x-btn').addEventListener('click', closeModal);
        document.getElementById('modal-close-btn').addEventListener('click', closeModal);

        modalEl.addEventListener('click', (e) => {
            if (e.target === modalEl) {
                closeModal();
            }
        });
    };

    window.confirmLogout = function() {
        window.showConfirmModal({
            title: 'Konfirmasi Keluar',
            message: 'Apakah Anda yakin ingin keluar dari halaman stall?',
            confirmText: 'Keluar',
            cancelText: 'Batal',
            type: 'danger',
            onConfirm: () => {
                const logoutForm = document.getElementById('logout-form');
                if (logoutForm) logoutForm.submit();
            }
        });
    };
</script>
@endpush
