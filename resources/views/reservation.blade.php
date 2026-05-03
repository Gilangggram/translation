<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    id="nav-home">Home</a>
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
            <div class="hidden md:flex items-center">
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
                class="font-manrope {{ request()->routeIs('landing') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Home</a>
            <a href="{{ route('delivery') }}"
                class="font-manrope {{ request()->routeIs('delivery') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Delivery</a>
            <a href="{{ route('reservation') }}"
                class="font-manrope {{ request()->routeIs('reservation') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Reservation</a>
            <a href="{{ route('dinein') }}"
                class="font-manrope {{ request()->routeIs('dinein') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Dine-In</a>
            <div class="flex items-center gap-3 px-5 py-2 mt-2 bg-secondary/5 rounded-full border border-secondary/10 mx-5">
                <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white">
                    <i class="bi bi-person"></i>
                </div>
                <span class="font-manrope font-bold text-sm text-secondary">Guest</span>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="flex-1 w-full max-w-[1280px] mx-auto pt-[112px] pb-[128px] px-6 flex flex-col gap-16 relative">

        <!-- Hero Section -->
        <div class="flex flex-col gap-4">
            <h1
                class="font-noto-serif font-bold text-5xl md:text-[60px] leading-tight md:leading-[60px] tracking-[-1.5px] text-[#725B38]">
                Reservasi Meja</h1>
            <p class="font-manrope font-light text-lg leading-[28px] text-[#4D463C] max-w-[672px]">
                Pesan Meja Ternyaman Mu Sekarang Juga
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-12 w-full items-start relative">

            <!-- Left Column: Reservation Forms -->
            <div class="flex-1 flex flex-col w-full lg:w-[805px] max-w-[805px] gap-12 shrink-0">

                <!-- Section 1: Identitas -->
                <div class="bg-[#F4F3F3] rounded-lg p-8 flex flex-col gap-8 w-full">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-[#725B38]"></div>
                        <h2 class="font-noto-serif font-bold text-2xl text-[#1A1C1C]">Identitas Pemesan</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Nama Lengkap -->
                        <div class="flex flex-col gap-2">
                            <label
                                class="font-manrope font-normal text-sm tracking-[0.7px] uppercase text-[#7F766A]">Nama
                                Lengkap</label>
                            <input type="text" id="inputName" placeholder="Masukkan Nama Lengkap"
                                class="w-full bg-transparent border-b-2 border-x border-t border-[#D1C5B8]/30 py-2.5 px-3 font-manrope text-base text-[#1A1C1C] focus:outline-none focus:border-b-[#725B38] transition-colors">
                        </div>
                        <!-- Nomor HP -->
                        <div class="flex flex-col gap-2">
                            <label
                                class="font-manrope font-normal text-sm tracking-[0.7px] uppercase text-[#7F766A]">Nomor
                                HP</label>
                            <input type="text" id="inputPhone" placeholder="Masukkan Nomor HP"
                                class="w-full bg-transparent border-b-2 border-x border-t border-[#D1C5B8]/30 py-2.5 px-3 font-manrope text-base text-[#1A1C1C] focus:outline-none focus:border-b-[#725B38] transition-colors">
                        </div>
                        <!-- Email -->
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label
                                class="font-manrope font-normal text-sm tracking-[0.7px] uppercase text-[#7F766A]">Email</label>
                            <input type="email" id="inputEmail" placeholder="Masukkan Email Anda"
                                class="w-full bg-transparent border-b-2 border-x border-t border-[#D1C5B8]/30 py-2.5 px-3 font-manrope text-base text-[#1A1C1C] focus:outline-none focus:border-b-[#725B38] transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Waktu & Meja (Bento Layout) -->
                <div class="flex flex-col md:flex-row gap-6 w-full">

                    <!-- Waktu -->
                    <div class="flex-1 bg-[#F4F3F3] rounded-lg p-8 flex flex-col gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-[18px] h-[20px] bg-[#725B38]"></div>
                            <h2 class="font-noto-serif font-bold text-2xl text-[#1A1C1C]">Waktu</h2>
                        </div>
                        <!-- Date input -->
                        <div
                            class="w-full h-14 bg-white border border-[#D1C5B8]/20 rounded-lg flex items-center justify-between px-4 shadow-[0_0_0_1px_rgba(209,197,184,0.2)] relative">
                            <input type="date" id="inputDate"
                                class="font-manrope text-base text-[#1A1C1C] w-full bg-transparent border-none outline-none z-10"
                                required>
                            <i class="bi bi-calendar3 text-[#1A1C1C] absolute right-4 z-0 pointer-events-none"></i>
                        </div>
                        <!-- Time buttons -->
                        <div class="grid grid-cols-2 gap-4" id="timeSelection">
                            <button type="button" data-time="10:00 AM"
                                class="time-btn border border-[#D1C5B8] rounded-xl py-2 font-manrope text-sm text-[#1A1C1C] hover:bg-[#D1C5B8]/20 transition">10:00
                                AM</button>
                            <button type="button" data-time="12:00 PM"
                                class="time-btn border border-[#D1C5B8] rounded-xl py-2 font-manrope text-sm text-[#1A1C1C] hover:bg-[#D1C5B8]/20 transition">12:00
                                PM</button>
                            <button type="button" data-time="02:00 PM"
                                class="time-btn border border-[#D1C5B8] rounded-xl py-2 font-manrope text-sm text-[#1A1C1C] hover:bg-[#D1C5B8]/20 transition">02:00
                                PM</button>
                            <button type="button" data-time="04:00 PM"
                                class="time-btn border border-[#D1C5B8] rounded-xl py-2 font-manrope text-sm text-[#1A1C1C] hover:bg-[#D1C5B8]/20 transition">04:00
                                PM</button>
                        </div>
                    </div>

                    <!-- Meja -->
                    <div class="flex-1 bg-[#F4F3F3] rounded-lg p-8 flex flex-col gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-[22px] h-[18px] bg-[#725B38]"></div>
                            <h2 class="font-noto-serif font-bold text-2xl text-[#1A1C1C]">Pilih Meja</h2>
                        </div>
                        <!-- Table grid -->
                        <div class="grid grid-cols-3 gap-4 mx-auto" id="tableSelection">
                            <button type="button" data-table="01" data-available="true"
                                class="table-btn w-[69px] h-[69px] bg-[#E2E2E2] rounded-lg font-manrope font-bold text-base text-[#725B38] flex items-center justify-center hover:bg-[#D1C5B8] transition text-center">01</button>
                            <button type="button" data-table="02" data-available="true"
                                class="table-btn w-[69px] h-[69px] bg-[#E2E2E2] rounded-lg font-manrope font-bold text-base text-[#725B38] flex items-center justify-center hover:bg-[#D1C5B8] transition text-center">02</button>
                            <button type="button" data-table="03" data-available="true"
                                class="table-btn w-[69px] h-[69px] bg-[#E2E2E2] rounded-lg font-manrope font-bold text-base text-[#725B38] flex items-center justify-center hover:bg-[#D1C5B8] transition text-center">03</button>
                            <button type="button" data-table="04" data-available="true"
                                class="table-btn w-[69px] h-[69px] bg-[#E2E2E2] rounded-lg font-manrope font-bold text-base text-[#725B38] flex items-center justify-center hover:bg-[#D1C5B8] transition text-center">04</button>
                            <button type="button" data-table="05" data-available="false"
                                class="w-[69px] h-[69px] bg-[#E7E5E4] rounded-lg font-manrope font-bold text-base text-[#A8A29E] flex items-center justify-center cursor-not-allowed text-center">05</button>
                            <button type="button" data-table="06" data-available="true"
                                class="table-btn w-[69px] h-[69px] bg-[#E2E2E2] rounded-lg font-manrope font-bold text-base text-[#725B38] flex items-center justify-center hover:bg-[#D1C5B8] transition text-center">06</button>
                        </div>
                        <p class="font-manrope text-[10px] tracking-[1px] uppercase text-[#7F766A] text-center w-full">
                            PILIH MEJA TERSEDIA</p>
                    </div>

                </div>

                <!-- Section 3: Menu Pre-Order -->
                <div class="flex flex-col gap-8 w-full">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-[18px] h-[18px] bg-[#725B38]"></div>
                            <h2 class="font-noto-serif font-bold text-[30px] leading-[36px] text-[#1A1C1C]">Menu
                                Pre-Order</h2>
                        </div>
                        <div class="bg-[#FFC5AB]/30 rounded-xl px-3 py-1">
                            <span class="font-manrope font-medium text-sm text-[#80543F]">Optional</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Item 1 -->
                        <div class="bg-white rounded-lg shadow-[0_1px_2px_rgba(0,0,0,0.05)] flex h-[162px]">
                            <div class="w-[128px] h-full shrink-0 overflow-hidden rounded-l-lg bg-[#E2E2E2]">
                                <img src="https://placehold.co/200x300/E6DDD3/532E1C?text=Nasi+Goreng" alt="Nasi Goreng"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-1">
                                <div>
                                    <h3 class="font-noto-serif font-bold text-lg leading-7 text-[#1A1C1C]">Nasi Goreng
                                        Kampung</h3>
                                    <p class="font-manrope text-xs uppercase tracking-[-0.6px] text-[#7F766A] mt-1">
                                        PAWON DE'PALLET</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-manrope font-bold text-base text-[#725B38]">Rp 45.000</span>
                                    <button type="button" data-name="Nasi Goreng Kampung" data-price="45000"
                                        class="menu-btn w-6 h-6 bg-[#E2E2E2] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#D1C5B8] transition">
                                        <i class="bi bi-plus text-[#725B38] text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="bg-white rounded-lg shadow-[0_1px_2px_rgba(0,0,0,0.05)] flex h-[162px]">
                            <div class="w-[128px] h-full shrink-0 overflow-hidden rounded-l-lg bg-[#E2E2E2]">
                                <img src="https://placehold.co/200x300/E6DDD3/532E1C?text=Sate" alt="Sate Ayam Madura"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-1">
                                <div>
                                    <h3 class="font-noto-serif font-bold text-lg leading-7 text-[#1A1C1C]">Sate Ayam
                                        Madura</h3>
                                    <p class="font-manrope text-xs uppercase tracking-[-0.6px] text-[#7F766A] mt-1">
                                        WARUNG SATE MAS JOYO</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-manrope font-bold text-base text-[#725B38]">Rp 30.000</span>
                                    <button type="button" data-name="Sate Ayam Madura" data-price="30000"
                                        class="menu-btn w-6 h-6 bg-[#E2E2E2] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#D1C5B8] transition">
                                        <i class="bi bi-plus text-[#725B38] text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="bg-white rounded-lg shadow-[0_1px_2px_rgba(0,0,0,0.05)] flex h-[162px]">
                            <div class="w-[128px] h-full shrink-0 overflow-hidden rounded-l-lg bg-[#E2E2E2]">
                                <img src="https://placehold.co/200x300/E6DDD3/532E1C?text=Rendang" alt="Rendang Daging"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-1">
                                <div>
                                    <h3 class="font-noto-serif font-bold text-lg leading-7 text-[#1A1C1C]">Rendang
                                        Daging</h3>
                                    <p class="font-manrope text-xs uppercase tracking-[-0.6px] text-[#7F766A] mt-1">
                                        RUMAH GADANG CORNER</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-manrope font-bold text-base text-[#725B38]">Rp 40.000</span>
                                    <button type="button" data-name="Rendang Daging" data-price="40000"
                                        class="menu-btn w-6 h-6 bg-[#E2E2E2] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#D1C5B8] transition">
                                        <i class="bi bi-plus text-[#725B38] text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Item 4 -->
                        <div class="bg-white rounded-lg shadow-[0_1px_2px_rgba(0,0,0,0.05)] flex h-[162px]">
                            <div class="w-[128px] h-full shrink-0 overflow-hidden rounded-l-lg bg-[#E2E2E2]">
                                <img src="https://placehold.co/200x300/E6DDD3/532E1C?text=Cendol" alt="Es Cendol Durian"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 flex flex-col justify-between flex-1">
                                <div>
                                    <h3 class="font-noto-serif font-bold text-lg leading-7 text-[#1A1C1C]">Es Cendol
                                        Durian</h3>
                                    <p class="font-manrope text-xs uppercase tracking-[-0.6px] text-[#7F766A] mt-1">
                                        MANISAN SEGAR</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-manrope font-bold text-base text-[#725B38]">Rp 25.000</span>
                                    <button type="button" data-name="Es Cendol Durian" data-price="25000"
                                        class="menu-btn w-6 h-6 bg-[#E2E2E2] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#D1C5B8] transition">
                                        <i class="bi bi-plus text-[#725B38] text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Right Column: Reservation Summary (Sticky) -->
            <aside class="w-full lg:w-[380px] shrink-0 sticky top-[100px] mt-10 lg:mt-0">
                <div
                    class="bg-[#E2E2E2] rounded-lg shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] p-8 flex flex-col gap-8 relative z-10">

                    <!-- Heading -->
                    <div class="border-b border-[#D1C5B8]/20 pb-4">
                        <h2 class="font-noto-serif font-bold text-2xl text-[#1A1C1C]">Reservation Summary</h2>
                    </div>

                    <!-- Details -->
                    <div class="flex flex-col gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-[18px] h-[20px] bg-[#725B38] mt-1 shrink-0"></div>
                            <div class="flex flex-col">
                                <span class="font-manrope text-xs uppercase tracking-[0.6px] text-[#7F766A]">Date &
                                    Time</span>
                                <span id="summary-datetime"
                                    class="font-manrope font-bold text-base text-[#1A1C1C]">-</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-[20px] h-[20px] bg-[#725B38] mt-1 shrink-0"></div>
                            <div class="flex flex-col">
                                <span
                                    class="font-manrope text-xs uppercase tracking-[0.6px] text-[#7F766A]">Table</span>
                                <span id="summary-table"
                                    class="font-manrope font-bold text-base text-[#1A1C1C]">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Pemesanan Ticket (Dynamic) -->
                    <div id="summary-ticket"
                        class="hidden bg-white/60 border-2 border-dashed border-[#725B38]/30 rounded-lg p-6 flex-col items-center justify-center mt-2 relative overflow-hidden">
                        <span
                            class="font-manrope font-black text-[10px] tracking-[3px] uppercase text-[#725B38]/60 mb-1 z-10 text-center">Bukti
                            Pemesanan</span>
                        <div id="summary-ticket-no"
                            class="font-noto-serif font-black text-3xl tracking-[3.6px] text-[#725B38] text-center z-10">
                            TABLE 00</div>
                        <div class="absolute inset-0 bg-[#725B38]/5 opacity-0 hover:opacity-100 transition-opacity z-0">
                        </div>
                    </div>

                    <!-- Pre order list -->
                    <div class="flex flex-col gap-2 w-full mt-2">
                        <span class="font-manrope text-xs uppercase tracking-[0.6px] text-[#7F766A] mb-2">PRE-ORDER
                            MENU</span>
                        <div id="summary-preorder-list" class="flex flex-col gap-2">
                            <span class="font-manrope text-sm text-[#A8A29E] italic">-</span>
                        </div>
                    </div>

                    <div class="border-t border-[#D1C5B8]/30 pt-6 mt-2">
                        <div class="flex justify-between items-center mb-6">
                            <span class="font-manrope font-bold text-lg text-[#1A1C1C]">Total</span>
                            <span id="summary-total" class="font-manrope font-black text-2xl text-[#80543F]">Rp 0</span>
                        </div>

                        <button type="button" onclick="alert('Reservasi Dikonfirmasi!')"
                            class="w-full py-5 bg-gradient-to-r from-[#725B38] to-[#C5A880] rounded-lg shadow-[0_12px_24px_-8px_rgba(114,91,56,0.4)] font-manrope font-bold text-lg text-[#1A1C1C] hover:opacity-90 transition transform hover:-translate-y-0.5">
                            CONFIRM RESERVATION
                        </button>

                        <p class="font-manrope text-[10px] text-center text-[#7F766A] mt-6 tracking-[1px] uppercase">
                            PLEASE ARRIVE 10 MINUTES EARLY.
                        </p>
                    </div>

                    <!-- Subtle Decorative Image -->
                    <div class="w-full h-48 rounded-lg overflow-hidden opacity-40 mix-blend-saturation bg-white mt-2">
                        <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=600&auto=format&fit=crop"
                            class="w-full h-full object-cover">
                    </div>
                </div>
            </aside>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#1A1C1C] w-full py-12 mt-auto">
        <div class="max-w-[1280px] mx-auto flex flex-col items-center px-12">
            <h2 class="font-manrope font-extrabold text-2xl text-[#F9F9F9] mb-6">De'Pallet Cafe</h2>
            <div class="flex gap-12 mb-6">
                <a href="#"
                    class="font-manrope font-bold text-[10px] tracking-[2px] uppercase text-[#9CA3AF] hover:text-white transition">Menu</a>
                <a href="{{ route('delivery') }}"
                    class="font-manrope font-bold text-[10px] tracking-[2px] uppercase text-[#9CA3AF] hover:text-white transition">Delivery</a>
                <a href="#"
                    class="font-manrope font-bold text-[10px] tracking-[2px] uppercase text-[#9CA3AF] hover:text-white transition">Contact</a>
            </div>
            <p class="font-manrope font-normal text-[10px] tracking-[2.5px] uppercase text-[#C5A880]/60 text-center">
                &copy; 2026 ARTISAN CAFE SYSTEM. CRAFTED FOR EXCELLENCE.
            </p>
        </div>
    </footer>

    <!-- Interactive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timeBtns = document.querySelectorAll('.time-btn');
            const tableBtns = document.querySelectorAll('.table-btn');
            const menuBtns = document.querySelectorAll('.menu-btn');
            const dateInput = document.getElementById('inputDate');

            const summaryDateTime = document.getElementById('summary-datetime');
            const summaryTable = document.getElementById('summary-table');
            const summaryTicket = document.getElementById('summary-ticket');
            const summaryTicketNo = document.getElementById('summary-ticket-no');
            const summaryPreorderList = document.getElementById('summary-preorder-list');
            const summaryTotal = document.getElementById('summary-total');

            let selectedDate = '';
            let selectedTime = '';
            let selectedTable = '';
            let preorders = {};

            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount).replace('Rp', 'Rp ');
            }

            function updateSummary() {
                // Update Date & Time
                if (selectedDate || selectedTime) {
                    const dateObj = selectedDate ? new Date(selectedDate) : null;
                    const options = { month: 'short', day: 'numeric', year: 'numeric' };
                    let formattedDate = dateObj ? dateObj.toLocaleDateString('en-US', options) : '';

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

                // Update Table
                if (selectedTable) {
                    summaryTable.textContent = `Table ${selectedTable}`;
                    summaryTicket.style.display = 'flex';
                    summaryTicketNo.textContent = `TABLE ${selectedTable}`;
                } else {
                    summaryTable.textContent = '-';
                    summaryTicket.style.display = 'none';
                }

                // Update Preorder
                summaryPreorderList.innerHTML = '';
                let total = 0;
                const itemNames = Object.keys(preorders);

                if (itemNames.length === 0) {
                    summaryPreorderList.innerHTML = '<span class="font-manrope text-sm text-[#A8A29E] italic">-</span>';
                } else {
                    itemNames.forEach(name => {
                        const item = preorders[name];
                        total += item.price * item.qty;
                        const div = document.createElement('div');
                        div.className = 'flex justify-between items-center w-full';
                        div.innerHTML = `
                            <span class="font-manrope text-sm text-[#1A1C1C]">${name}</span>
                            <span class="font-manrope text-sm text-[#1A1C1C]">x${item.qty}</span>
                        `;
                        summaryPreorderList.appendChild(div);
                    });
                }

                // Update Total
                summaryTotal.textContent = formatCurrency(total);
            }

            // Event Listeners
            dateInput.addEventListener('change', (e) => {
                selectedDate = e.target.value;
                updateSummary();
            });

            timeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Reset all
                    timeBtns.forEach(b => {
                        b.className = 'time-btn border border-[#D1C5B8] rounded-xl py-2 font-manrope text-sm text-[#1A1C1C] hover:bg-[#D1C5B8]/20 transition';
                    });
                    // Set active
                    btn.className = 'time-btn bg-gradient-to-r from-[#725B38] to-[#C5A880] rounded-xl py-2 font-manrope font-bold text-sm text-white shadow-[0_4px_6px_-1px_rgba(0,0,0,0.1)] transition transform hover:-translate-y-0.5';
                    selectedTime = btn.dataset.time;
                    updateSummary();
                });
            });

            tableBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.dataset.available === 'false') return;

                    // Reset all
                    tableBtns.forEach(b => {
                        if (b.dataset.available !== 'false') {
                            b.className = 'table-btn w-[69px] h-[69px] bg-[#E2E2E2] rounded-lg font-manrope font-bold text-base text-[#725B38] flex items-center justify-center hover:bg-[#D1C5B8] transition text-center';
                        }
                    });
                    // Set active
                    btn.className = 'table-btn w-[69px] h-[69px] bg-[#725B38] shadow-[0_10px_15px_-3px_rgba(0,0,0,0.1)] rounded-lg font-manrope font-bold text-base text-white flex items-center justify-center text-center transform scale-105 transition';
                    selectedTable = btn.dataset.table;
                    updateSummary();
                });
            });

            menuBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const name = btn.dataset.name;
                    const price = parseInt(btn.dataset.price);

                    if (preorders[name]) {
                        // Remove item
                        delete preorders[name];
                        btn.innerHTML = '<i class="bi bi-plus text-[#725B38] text-[10px]"></i>';
                        btn.className = 'menu-btn w-6 h-6 bg-[#E2E2E2] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#D1C5B8] transition';
                    } else {
                        // Add item
                        preorders[name] = { price, qty: 1 };
                        btn.innerHTML = '<i class="bi bi-check text-white text-[12px]"></i>';
                        btn.className = 'menu-btn w-6 h-6 bg-gradient-to-br from-[#725B38] to-[#C5A880] shadow-[0_4px_6px_-1px_rgba(0,0,0,0.1)] rounded-full flex items-center justify-center cursor-pointer hover:opacity-90 transition';
                    }
                    updateSummary();
                });
            });

            // Initialize
            updateSummary();
        });
    </script>
</body>

</html>