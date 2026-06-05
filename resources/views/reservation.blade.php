<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="De'Pallet Cafe Reservation - Pesan meja Anda sekarang.">
    <title>De'Pallet Cafe - Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=Noto+Serif:wght@400;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Hide default calendar icon for date input to match design */
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        /* Scrollbar custom for premium feel */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(209, 197, 184, 0.2);
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #725B38;
            border-radius: 4px;
        }
    </style>
</head>

<body class="font-manrope bg-landing-bg text-[#1A1C1C] overflow-x-hidden min-h-screen flex flex-col">

    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white/80 backdrop-blur-md shadow-[0_8px_32px_rgba(26,28,28,0.04)] h-[72px]"
        id="top-navigation">
        <div class="max-w-[1536px] mx-auto flex items-center justify-between px-8 py-4 h-[72px]">
            <div class="font-noto-serif font-black text-2xl leading-8 tracking-[-0.6px] text-dark whitespace-nowrap">
                De'Pallet Cafe</div>
            <div class="hidden md:flex items-center gap-0">
                <a href="{{ route('landing') }}"
                    class="font-manrope {{ request()->routeIs('landing') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-home">Beranda</a>
                <a href="{{ route('delivery') }}"
                    class="font-manrope {{ request()->routeIs('delivery') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-delivery">Delivery</a>
                <a href="{{ route('reservation') }}"
                    class="font-manrope {{ request()->routeIs('reservation') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-reservation">Reservation</a>
                <a href="{{ route('dinein') }}"
                    class="font-manrope {{ request()->routeIs('dinein') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-dinein">Dine-In</a>
            </div>
            <div class="hidden md:flex items-center gap-3">
                <div class="flex items-center gap-3 px-4 py-2 bg-secondary/5 rounded-full border border-secondary/10">
                    <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white">
                        <i class="bi bi-person"></i>
                    </div>
                    <span class="font-manrope font-bold text-sm text-secondary">Guest</span>
                </div>
            </div>
            <button class="md:hidden bg-transparent border-none text-2xl text-dark cursor-pointer"
                id="nav-mobile-toggle" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <div class="hidden flex-col bg-white/95 backdrop-blur-md px-8 py-4 pb-6 gap-3 shadow-md absolute w-full top-[72px]"
            id="nav-mobile-menu">
            <a href="{{ route('landing') }}"
                class="font-manrope {{ request()->routeIs('landing') ? 'font-bold text-secondary' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Beranda</a>
            <a href="{{ route('delivery') }}"
                class="font-manrope {{ request()->routeIs('delivery') ? 'font-bold text-secondary' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Delivery</a>
            <a href="{{ route('reservation') }}"
                class="font-manrope {{ request()->routeIs('reservation') ? 'font-bold text-secondary' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Reservation</a>
            <a href="{{ route('dinein') }}"
                class="font-manrope {{ request()->routeIs('dinein') ? 'font-bold text-secondary' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Dine-In</a>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="flex-1 w-full max-w-[1280px] mx-auto pt-[112px] pb-[128px] px-6 flex flex-col gap-10 relative">

        <!-- Hero Section -->
        <div class="flex flex-col gap-4 text-center md:text-left">
            <h1
                class="font-noto-serif font-bold text-4xl sm:text-5xl md:text-[60px] leading-tight md:leading-[60px] tracking-[-1.5px] text-[#725B38]">
                Reservasi Meja</h1>
            <p class="font-manrope font-light text-base sm:text-lg leading-relaxed text-[#4D463C] max-w-[672px] mx-auto md:mx-0">
                Lakukan reservasi meja ternyamanmu terlebih dahulu, kemudian pesan hidangan favoritmu.
            </p>
        </div>

        <!-- Toast Notification -->
        <div id="toast" class="fixed top-24 right-6 z-[200] hidden bg-red-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-[-20px] opacity-0 transition-all duration-300">
            <i class="bi bi-exclamation-triangle-fill text-xl"></i>
            <span id="toast-message" class="font-manrope font-semibold text-sm"></span>
        </div>

        <div class="flex flex-col lg:flex-row gap-12 w-full items-start relative">

            <!-- Left Column: Reservation Forms -->
            <div class="flex-1 flex flex-col w-full lg:w-[805px] max-w-[805px] gap-8 shrink-0">

                <!-- Section 1: Identitas -->
                <div class="bg-[#F4F3F3] rounded-2xl p-6 sm:p-8 flex flex-col gap-8 w-full shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-[#725B38]"></div>
                        <h2 class="font-noto-serif font-bold text-xl sm:text-2xl text-[#1A1C1C]">Identitas Pemesan</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Nama Lengkap -->
                        <div class="flex flex-col gap-2">
                            <label
                                class="font-manrope font-bold text-xs tracking-[0.7px] uppercase text-[#7F766A]">Nama Lengkap *</label>
                            <input type="text" id="inputName" placeholder="Masukkan Nama Lengkap" required
                                class="w-full bg-white border border-[#D1C5B8]/30 rounded-xl py-3 px-4 font-manrope text-base text-[#1A1C1C] focus:outline-none focus:border-[#725B38] transition-colors shadow-sm">
                        </div>
                        <!-- Nomor HP -->
                        <div class="flex flex-col gap-2">
                            <label
                                class="font-manrope font-bold text-xs tracking-[0.7px] uppercase text-[#7F766A]">Nomor HP *</label>
                            <input type="tel" id="inputPhone" placeholder="Contoh: 08123456789" required
                                class="w-full bg-white border border-[#D1C5B8]/30 rounded-xl py-3 px-4 font-manrope text-base text-[#1A1C1C] focus:outline-none focus:border-[#725B38] transition-colors shadow-sm">
                        </div>
                        <!-- Email -->
                        <div class="flex flex-col gap-2">
                            <label
                                class="font-manrope font-bold text-xs tracking-[0.7px] uppercase text-[#7F766A]">Email *</label>
                            <input type="email" id="inputEmail" placeholder="nama@email.com" required
                                class="w-full bg-white border border-[#D1C5B8]/30 rounded-xl py-3 px-4 font-manrope text-base text-[#1A1C1C] focus:outline-none focus:border-[#725B38] transition-colors shadow-sm">
                        </div>
                        <!-- Jumlah Orang -->
                        <div class="flex flex-col gap-2">
                            <label
                                class="font-manrope font-bold text-xs tracking-[0.7px] uppercase text-[#7F766A]">Jumlah Orang *</label>
                            <input type="number" id="inputPeople" min="1" max="20" placeholder="1" required
                                class="w-full bg-white border border-[#D1C5B8]/30 rounded-xl py-3 px-4 font-manrope text-base text-[#1A1C1C] focus:outline-none focus:border-[#725B38] transition-colors shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Waktu & Meja (Bento Layout) -->
                <div class="flex flex-col md:flex-row gap-6 w-full">

                    <!-- Waktu -->
                    <div class="flex-1 bg-[#F4F3F3] rounded-2xl p-6 sm:p-8 flex flex-col gap-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-[18px] h-[20px] bg-[#725B38]"></div>
                            <h2 class="font-noto-serif font-bold text-xl sm:text-2xl text-[#1A1C1C]">Pilih Tanggal & Waktu</h2>
                        </div>
                        <!-- Date input -->
                        <div class="flex flex-col gap-2">
                            <label class="font-manrope font-bold text-xs tracking-[0.7px] uppercase text-[#7F766A]">Tanggal Kunjungan *</label>
                            <div class="w-full h-12 bg-white border border-[#D1C5B8]/20 rounded-xl flex items-center justify-between px-4 shadow-sm relative">
                                <input type="date" id="inputDate" required
                                    class="font-manrope text-base text-[#1A1C1C] w-full bg-transparent border-none outline-none z-10">
                                <i class="bi bi-calendar3 text-[#725B38] absolute right-4 z-0 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Time buttons -->
                        <div class="flex flex-col gap-3">
                            <label class="font-manrope font-bold text-xs tracking-[0.7px] uppercase text-[#7F766A]">Jam Kunjungan *</label>
                            <div class="grid grid-cols-2 gap-3" id="timeSelection">
                                <button type="button" data-time="08:00"
                                    class="time-btn border border-[#D1C5B8]/40 bg-white rounded-xl py-2.5 font-manrope font-medium text-sm text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition">08:00</button>
                                <button type="button" data-time="08:30"
                                    class="time-btn border border-[#D1C5B8]/40 bg-white rounded-xl py-2.5 font-manrope font-medium text-sm text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition">08:30</button>
                                <button type="button" data-time="09:00"
                                    class="time-btn border border-[#D1C5B8]/40 bg-white rounded-xl py-2.5 font-manrope font-medium text-sm text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition">09:00</button>
                                <button type="button" data-time="09:30"
                                    class="time-btn border border-[#D1C5B8]/40 bg-white rounded-xl py-2.5 font-manrope font-medium text-sm text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition">09:30</button>
                                <button type="button" data-time="10:00"
                                    class="time-btn border border-[#D1C5B8]/40 bg-white rounded-xl py-2.5 font-manrope font-medium text-sm text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition">10:00</button>
                                <button type="button" id="btnMoreTimes" onclick="toggleTimeModal(true)"
                                    class="border border-[#725B38] border-dashed bg-transparent rounded-xl py-2.5 font-manrope font-bold text-sm text-[#725B38] hover:bg-[#725B38]/5 transition flex items-center justify-center gap-1">
                                    <i class="bi bi-clock-history"></i> Pilih Jam Lain
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Meja -->
                    <div class="flex-1 bg-[#F4F3F3] rounded-2xl p-6 sm:p-8 flex flex-col gap-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-[22px] h-[18px] bg-[#725B38]"></div>
                            <h2 class="font-noto-serif font-bold text-xl sm:text-2xl text-[#1A1C1C]">Pilih Nomor Meja</h2>
                        </div>
                        
                        <!-- Table grid -->
                        <div class="grid grid-cols-5 gap-2 max-h-[220px] overflow-y-auto custom-scrollbar pr-2" id="tableSelection">
                            @foreach($tables as $t)
                                <button type="button" data-table="{{ $t->table_number }}" data-available="{{ $t->is_available ? 'true' : 'false' }}"
                                    class="table-btn aspect-square bg-white border border-[#D1C5B8]/40 rounded-xl font-manrope font-bold text-sm text-[#725B38] flex items-center justify-center hover:border-[#725B38] hover:bg-[#725B38]/5 transition disabled:opacity-40 disabled:bg-[#E6DDD3]/50 disabled:text-[#A8A29E] disabled:cursor-not-allowed"
                                    {{ !$t->is_available ? 'disabled' : '' }}>
                                    {{ sprintf('%02d', $t->table_number) }}
                                </button>
                            @endforeach
                        </div>
                        
                        <p class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-[#7F766A] text-center w-full mt-2">
                            PILIH MEJA TERSEDIA (30 TOTAL MEJA)</p>
                    </div>

                </div>

            </div>

            <!-- Right Column: Reservation Summary (Sticky) -->
            <aside id="reservation-summary-sidebar" class="w-full lg:w-[380px] shrink-0 lg:sticky lg:top-[100px] mt-4 lg:mt-0">
                <div
                    class="bg-[#FAF2ED] rounded-2xl border border-[#D1C5B8]/40 shadow-xl p-6 sm:p-8 flex flex-col gap-6 relative z-10">

                    <!-- Heading -->
                    <div class="border-b border-[#D1C5B8]/20 pb-4">
                        <h2 class="font-noto-serif font-bold text-2xl text-[#532E1C]">Ringkasan Reservasi</h2>
                    </div>

                    <!-- Details -->
                    <div class="flex flex-col gap-5">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#725B38]/10 text-[#725B38] flex items-center justify-center shrink-0 mt-0.5">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-manrope text-[10px] font-bold uppercase tracking-[0.6px] text-[#7F766A]">Nama Pelanggan</span>
                                <span id="summary-name" class="font-manrope font-bold text-base text-[#1A1C1C]">-</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#725B38]/10 text-[#725B38] flex items-center justify-center shrink-0 mt-0.5">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-manrope text-[10px] font-bold uppercase tracking-[0.6px] text-[#7F766A]">Jumlah Tamu</span>
                                <span id="summary-people" class="font-manrope font-bold text-base text-[#1A1C1C]">-</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#725B38]/10 text-[#725B38] flex items-center justify-center shrink-0 mt-0.5">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-manrope text-[10px] font-bold uppercase tracking-[0.6px] text-[#7F766A]">Tanggal & Jam</span>
                                <span id="summary-datetime" class="font-manrope font-bold text-base text-[#1A1C1C]">-</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-[#725B38]/10 text-[#725B38] flex items-center justify-center shrink-0 mt-0.5">
                                <i class="bi bi-qr-code-scan"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-manrope text-[10px] font-bold uppercase tracking-[0.6px] text-[#7F766A]">Nomor Meja</span>
                                <span id="summary-table" class="font-manrope font-bold text-base text-[#1A1C1C]">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Steps Reminder Info -->
                    <div class="bg-[#FAF2ED] border border-[#725B38]/20 rounded-xl p-4 flex flex-col gap-2 mt-2">
                        <span class="font-manrope font-bold text-[10px] uppercase tracking-wider text-[#725B38] flex items-center gap-1.5">
                            <i class="bi bi-info-circle-fill"></i> Langkah Selanjutnya
                        </span>
                        <p class="font-manrope text-xs text-[#7B7672] leading-relaxed">
                            Setelah menekan tombol konfirmasi, data reservasi Anda akan disimpan dan Anda akan dialihkan ke menu stall makanan untuk melengkapi hidangan pre-order Anda.
                        </p>
                    </div>

                    <!-- Confirm button -->
                    <div class="border-t border-[#D1C5B8]/30 pt-6">
                        <button type="button" id="btnConfirmReservation"
                            class="w-full py-4.5 bg-[#725B38] rounded-xl font-manrope font-bold text-sm tracking-wider uppercase text-white hover:opacity-90 transition transform hover:-translate-y-0.5 active:scale-95 shadow-md flex items-center justify-center gap-2">
                            <span>Konfirmasi & Pilih Menu</span> <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </aside>

        </div>
    </main>

    <!-- Modal Pilih Jam Lain -->
    <div id="timeModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-[#1E1B18]/60 backdrop-blur-sm" onclick="toggleTimeModal(false)"></div>

        <!-- Modal Panel -->
        <div class="relative bg-[#FAF2ED] rounded-2xl shadow-2xl w-full max-w-md border border-[#D1C5B8]/30 flex flex-col" style="max-height: 90vh">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-[#D1C5B8]/30 flex items-center justify-between shrink-0">
                <h3 class="font-noto-serif font-bold text-xl text-[#532E1C] flex items-center gap-2" id="modal-title">
                    <i class="bi bi-clock-history text-[#725B38]"></i> Pilih Jam Kunjungan
                </h3>
                <button type="button" onclick="toggleTimeModal(false)" class="text-[#7F766A] hover:text-[#532E1C] transition text-2xl leading-none">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Scrollable Time Grid -->
            <div class="p-5 overflow-y-auto custom-scrollbar flex-1">
                <div class="grid grid-cols-4 gap-2.5" id="modalTimeGrid">
                    <!-- Populated dynamically via JavaScript -->
                </div>
            </div>

            <!-- Footer -->
            <div class="shrink-0 bg-[#E6DDD3]/50 px-6 py-4 flex justify-end gap-3 border-t border-[#D1C5B8]/30">
                <button type="button" onclick="toggleTimeModal(false)"
                    class="px-5 py-2.5 bg-white border border-[#D1C5B8] text-[#7F766A] rounded-xl font-manrope font-bold text-xs hover:bg-[#FAF2ED]/50 transition">Batal</button>
                <button type="button" id="btnSelectModalTime"
                    class="px-5 py-2.5 bg-[#725B38] text-white rounded-xl font-manrope font-bold text-xs hover:opacity-90 transition">Pilih</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#1A1C1C] w-full py-12 mt-auto">
        <div class="max-w-[1280px] mx-auto flex flex-col items-center px-12">
            <h2 class="font-manrope font-extrabold text-2xl text-[#F9F9F9] mb-6">De'Pallet Cafe</h2>
            <div class="flex gap-12 mb-6">
                <a href="{{ route('landing') }}"
                    class="font-manrope font-bold text-[10px] tracking-[2px] uppercase text-[#9CA3AF] hover:text-white transition">Beranda</a>
                <a href="{{ route('delivery') }}"
                    class="font-manrope font-bold text-[10px] tracking-[2px] uppercase text-[#9CA3AF] hover:text-white transition">Delivery</a>
                <a href="{{ route('reservation') }}"
                    class="font-manrope font-bold text-[10px] tracking-[2px] uppercase text-[#9CA3AF] hover:text-white transition">Reservation</a>
                <a href="{{ route('dinein') }}"
                    class="font-manrope font-bold text-[10px] tracking-[2px] uppercase text-[#9CA3AF] hover:text-white transition">Dine-In</a>
            </div>
            <p class="font-manrope font-normal text-[10px] tracking-[2.5px] uppercase text-[#C5A880]/60 text-center">
                &copy; 2026 DE'PALLET CAFE SYSTEM. CRAFTED FOR EXCELLENCE.
            </p>
        </div>
    </footer>

    <!-- Interactive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timeBtns = document.querySelectorAll('.time-btn');
            const tableBtns = document.querySelectorAll('.table-btn');
            const dateInput = document.getElementById('inputDate');
            const nameInput = document.getElementById('inputName');
            const phoneInput = document.getElementById('inputPhone');
            const emailInput = document.getElementById('inputEmail');
            const peopleInput = document.getElementById('inputPeople');

            const summaryName = document.getElementById('summary-name');
            const summaryPeople = document.getElementById('summary-people');
            const summaryDateTime = document.getElementById('summary-datetime');
            const summaryTable = document.getElementById('summary-table');
            const btnConfirmReservation = document.getElementById('btnConfirmReservation');
            const modalTimeGrid = document.getElementById('modalTimeGrid');

            // Set dynamic min date to today, max date to 1 month from now
            const today = new Date().toISOString().split('T')[0];
            const maxDateObj = new Date();
            maxDateObj.setMonth(maxDateObj.getMonth() + 1);
            const maxDate = maxDateObj.toISOString().split('T')[0];
            dateInput.min = today;
            dateInput.max = maxDate;
            dateInput.value = today;

            let selectedDate = today;
            let selectedTime = '';
            let selectedTable = '';
            let tempSelectedTime = ''; // For modal temporary selection

            // Generate time slots every 30 minutes from 08:00 to 22:00
            const times = [];
            let hour = 8;
            let minute = 0;
            while (hour < 22 || (hour === 22 && minute === 0)) {
                const formattedHour = String(hour).padStart(2, '0');
                const formattedMinute = String(minute).padStart(2, '0');
                times.push(`${formattedHour}:${formattedMinute}`);
                minute += 30;
                if (minute >= 60) {
                    minute = 0;
                    hour += 1;
                }
            }

            // Populate time slots modal grid
            times.forEach(t => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'modal-time-btn py-2.5 border border-[#D1C5B8]/40 bg-white rounded-xl font-manrope font-medium text-xs text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition';
                btn.textContent = t;
                btn.dataset.time = t;
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.modal-time-btn').forEach(b => {
                        b.className = 'modal-time-btn py-2.5 border border-[#D1C5B8]/40 bg-white rounded-xl font-manrope font-medium text-xs text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition';
                    });
                    btn.className = 'modal-time-btn py-2.5 bg-[#725B38] text-white rounded-xl font-manrope font-bold text-xs transition';
                    tempSelectedTime = t;
                });
                modalTimeGrid.appendChild(btn);
            });

            // Modal time selector save button
            document.getElementById('btnSelectModalTime').addEventListener('click', () => {
                if (!tempSelectedTime) {
                    showToast('Silakan pilih salah satu jadwal.');
                    return;
                }
                selectedTime = tempSelectedTime;
                
                // Clear active main time buttons
                timeBtns.forEach(b => {
                    b.className = 'time-btn border border-[#D1C5B8]/40 bg-white rounded-xl py-2.5 font-manrope font-medium text-sm text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition';
                });

                // Update "Pilih Jam Lain" button to show the selected custom time
                document.getElementById('btnMoreTimes').innerHTML = `<i class="bi bi-clock-fill"></i> Jam ${selectedTime}`;
                document.getElementById('btnMoreTimes').className = 'border border-[#725B38] bg-[#725B38]/10 rounded-xl py-2.5 font-manrope font-bold text-sm text-[#725B38] transition flex items-center justify-center gap-1';

                toggleTimeModal(false);
                updateSummary();
            });

            function showToast(message) {
                const toast = document.getElementById('toast');
                document.getElementById('toast-message').textContent = message;
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.remove('opacity-0', 'translate-y-[-20px]');
                    toast.classList.add('opacity-100', 'translate-y-0');
                }, 10);

                setTimeout(() => {
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    toast.classList.add('opacity-0', 'translate-y-[-20px]');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 300);
                }, 4000);
            }

            function updateSummary() {
                // Name
                summaryName.textContent = nameInput.value.trim() ? nameInput.value.trim() : '-';

                // People
                summaryPeople.textContent = peopleInput.value ? `${peopleInput.value} Orang` : '-';

                // Date & Time
                if (selectedDate || selectedTime) {
                    const dateObj = selectedDate ? new Date(selectedDate) : null;
                    const options = { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' };
                    let formattedDate = dateObj ? dateObj.toLocaleDateString('id-ID', options) : '';

                    if (formattedDate && selectedTime) {
                        summaryDateTime.textContent = `${formattedDate}, ${selectedTime}`;
                    } else if (formattedDate) {
                        summaryDateTime.textContent = formattedDate;
                    } else if (selectedTime) {
                        summaryDateTime.textContent = selectedTime;
                    }
                } else {
                    summaryDateTime.textContent = '-';
                }

                // Table
                if (selectedTable) {
                    summaryTable.textContent = `Meja ${selectedTable}`;
                } else {
                    summaryTable.textContent = '-';
                }
            }

            // Event Listeners for inputs
            nameInput.addEventListener('input', updateSummary);
            peopleInput.addEventListener('input', updateSummary);
            dateInput.addEventListener('change', (e) => {
                selectedDate = e.target.value;
                updateSummary();
            });

            timeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Reset custom "Pilih Jam Lain" button
                    document.getElementById('btnMoreTimes').innerHTML = '<i class="bi bi-clock-history"></i> Pilih Jam Lain';
                    document.getElementById('btnMoreTimes').className = 'border border-[#725B38] border-dashed bg-transparent rounded-xl py-2.5 font-manrope font-bold text-sm text-[#725B38] hover:bg-[#725B38]/5 transition flex items-center justify-center gap-1';

                    // Reset all
                    timeBtns.forEach(b => {
                        b.className = 'time-btn border border-[#D1C5B8]/40 bg-white rounded-xl py-2.5 font-manrope font-medium text-sm text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition';
                    });
                    // Set active
                    btn.className = 'time-btn bg-[#725B38] text-white rounded-xl py-2.5 font-manrope font-bold text-sm shadow-md transition transform hover:-translate-y-0.5';
                    selectedTime = btn.dataset.time;
                    tempSelectedTime = selectedTime;
                    updateSummary();
                });
            });

            tableBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.dataset.available === 'false') return;

                    // Reset all
                    tableBtns.forEach(b => {
                        if (b.dataset.available !== 'false') {
                            b.className = 'table-btn aspect-square bg-white border border-[#D1C5B8]/40 rounded-xl font-manrope font-bold text-sm text-[#725B38] flex items-center justify-center hover:border-[#725B38] hover:bg-[#725B38]/5 transition';
                        }
                    });
                    // Set active
                    btn.className = 'table-btn aspect-square bg-[#725B38] text-white rounded-xl font-manrope font-bold text-sm flex items-center justify-center shadow-md transform scale-105 transition';
                    selectedTable = btn.dataset.table;
                    updateSummary();
                });
            });

            // Submit Reservation details to store in Session
            btnConfirmReservation.addEventListener('click', async () => {
                // Validation
                if (!nameInput.value.trim()) {
                    showToast('Silakan isi Nama Lengkap Anda.');
                    return;
                }
                if (!phoneInput.value.trim()) {
                    showToast('Silakan isi Nomor HP Anda.');
                    return;
                }
                if (!emailInput.value.trim() || !emailInput.value.includes('@')) {
                    showToast('Silakan isi Email Anda dengan benar.');
                    return;
                }
                if (!peopleInput.value || parseInt(peopleInput.value) < 1) {
                    showToast('Silakan isi Jumlah Orang dengan benar.');
                    return;
                }
                if (!selectedDate) {
                    showToast('Silakan pilih Tanggal Kunjungan Anda.');
                    return;
                }
                if (!selectedTime) {
                    showToast('Silakan pilih Jam Kunjungan Anda.');
                    return;
                }
                if (!selectedTable) {
                    showToast('Silakan pilih Nomor Meja Anda.');
                    return;
                }

                // Send to server
                try {
                    btnConfirmReservation.disabled = true;
                    btnConfirmReservation.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i> Menyimpan...';
                    
                    const response = await fetch("{{ route('reservation.confirm') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: nameInput.value.trim(),
                            phone_number: phoneInput.value.trim(),
                            email: emailInput.value.trim(),
                            number_of_people: parseInt(peopleInput.value),
                            date: selectedDate,
                            time: selectedTime,
                            table_number: selectedTable
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        showToast(data.error || 'Terjadi kesalahan. Silakan coba lagi.');
                        btnConfirmReservation.disabled = false;
                        btnConfirmReservation.innerHTML = '<span>Konfirmasi & Pilih Menu</span> <i class="bi bi-arrow-right"></i>';
                    }
                } catch (e) {
                    console.error(e);
                    showToast('Gagal terhubung ke server.');
                    btnConfirmReservation.disabled = false;
                    btnConfirmReservation.innerHTML = '<span>Konfirmasi & Pilih Menu</span> <i class="bi bi-arrow-right"></i>';
                }
            });

            // Modal controller — toggle flex display for proper centering
            window.toggleTimeModal = function(show) {
                const modal = document.getElementById('timeModal');
                if (show) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    // Preselect modal buttons if time is already chosen
                    document.querySelectorAll('.modal-time-btn').forEach(btn => {
                        if (btn.dataset.time === selectedTime) {
                            btn.className = 'modal-time-btn py-2.5 bg-[#725B38] text-white rounded-xl font-manrope font-bold text-xs transition';
                            tempSelectedTime = selectedTime;
                        } else {
                            btn.className = 'modal-time-btn py-2.5 border border-[#D1C5B8]/40 bg-white rounded-xl font-manrope font-medium text-xs text-[#1A1C1C] hover:border-[#725B38] hover:bg-[#725B38]/5 transition';
                        }
                    });
                } else {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            }

            // Initialize UI
            updateSummary();
        });
    </script>
</body>

</html>