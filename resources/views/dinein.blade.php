<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dine-In - De'Pallet Cafe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=Noto+Serif:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Hide scrollbar for category menu */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-manrope bg-landing-bg min-h-screen text-[#1E1B18] overflow-x-hidden flex flex-col">

    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white/80 backdrop-blur-md shadow-[0_8px_32px_rgba(26,28,28,0.04)] h-[72px]"
        id="top-navigation">
        <div class="max-w-[1536px] mx-auto flex items-center justify-between px-8 py-4 h-[72px]">
            <div
                class="font-noto-serif font-black text-2xl leading-8 tracking-[-0.6px] text-[#1E1B18] whitespace-nowrap">
                De'Pallet Cafe</div>
            <div class="hidden md:flex items-center gap-0">
                <a href="{{ route('landing') }}"
                    class="font-manrope {{ request()->routeIs('landing') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-home">Home</a>
                <a href="{{ route('delivery') }}"
                    class="font-manrope {{ request()->routeIs('delivery') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-delivery">Delivery</a>
                <a href="{{ route('reservation') }}"
                    class="font-manrope {{ request()->routeIs('reservation') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-reservation">Reservation</a>
                <a href="{{ route('dinein') }}"
                    class="font-manrope {{ request()->routeIs('dinein') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300"
                    id="nav-dinein">Dine-In</a>
            </div>
            <div class="hidden md:flex items-center gap-3">
                @php
                    $navTable = $table ?? (session()->has('scanned_table') ? \App\Models\Table::where('table_number', session('scanned_table'))->first() : (session()->has('reservation') ? \App\Models\Table::where('table_number', session('reservation.table_number'))->first() : null));
                @endphp
                @if($navTable)
                    <div class="flex items-center gap-2 px-4 py-2 bg-[#725B38]/10 rounded-full border border-[#725B38]/30">
                        <i class="bi bi-qr-code-scan text-[#725B38]"></i>
                        <span class="font-manrope font-bold text-sm text-[#725B38]">Meja
                            {{ $navTable->table_number }}</span>
                    </div>
                @endif
                <div class="flex items-center gap-3 px-4 py-2 bg-[#532E1C]/5 rounded-full border border-[#532E1C]/10">
                    <div class="w-8 h-8 rounded-full bg-[#532E1C] flex items-center justify-center text-white">
                        <i class="bi bi-person"></i>
                    </div>
                    <span class="font-manrope font-bold text-sm text-[#532E1C]">Guest</span>
                </div>
            </div>
            <button class="md:hidden bg-transparent border-none text-2xl text-[#1E1B18] cursor-pointer"
                id="nav-mobile-toggle" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <div class="hidden flex-col bg-white/95 backdrop-blur-md px-8 py-4 pb-6 gap-3 shadow-md absolute w-full top-[72px]"
            id="nav-mobile-menu">
            <a href="{{ route('landing') }}"
                class="font-manrope {{ request()->routeIs('landing') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5">Home</a>
            <a href="{{ route('delivery') }}"
                class="font-manrope {{ request()->routeIs('delivery') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5">Delivery</a>
            <a href="{{ route('reservation') }}"
                class="font-manrope {{ request()->routeIs('reservation') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5">Reservation</a>
            <a href="{{ route('dinein') }}"
                class="font-manrope {{ request()->routeIs('dinein') ? 'font-bold text-[#532E1C] border-b-2 border-[#532E1C] pb-0' : 'font-medium text-[#7B7672] hover:text-[#532E1C]' }} text-base leading-6 tracking-[-0.4px] px-5">Dine-In</a>
            @if($navTable)
                <div
                    class="flex items-center gap-2 px-5 py-2 mt-2 bg-[#725B38]/10 rounded-full border border-[#725B38]/30 mx-5">
                    <i class="bi bi-qr-code-scan text-[#725B38]"></i>
                    <span class="font-manrope font-bold text-sm text-[#725B38]">Meja {{ $navTable->table_number }}</span>
                </div>
            @endif
            <div
                class="flex items-center gap-3 px-5 py-2 mt-2 bg-[#532E1C]/5 rounded-full border border-[#532E1C]/10 mx-5">
                <div class="w-8 h-8 rounded-full bg-[#532E1C] flex items-center justify-center text-white">
                    <i class="bi bi-person"></i>
                </div>
                <span class="font-manrope font-bold text-sm text-[#532E1C]">Guest</span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full max-w-[1440px] mx-auto flex-1 flex flex-col gap-8 pt-[128px] px-8 xl:px-16 pb-16 relative">

        @if(session()->has('reservation'))
            <div
                class="w-full bg-[#FAF2ED] border border-[#725B38]/30 rounded-2xl p-6 mb-4 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm animate-fade-in">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-[#725B38]/10 text-[#725B38] flex items-center justify-center text-xl shrink-0">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-noto-serif font-bold text-lg text-[#532E1C]">Reservasi Meja
                            {{ session('reservation.table_number') }} Aktif</h3>
                        <p class="font-manrope text-xs text-[#7B7672] mt-0.5">
                            Atas nama <strong>{{ session('reservation.name') }}</strong>
                            ({{ session('reservation.number_of_people') }} Tamu) untuk
                            <strong>{{ date('d M Y', strtotime(session('reservation.date'))) }}</strong> jam
                            <strong>{{ session('reservation.time') }}</strong>.
                            Silakan pilih menu makanan untuk menyelesaikan reservasi Anda.
                        </p>
                    </div>
                </div>
                <form action="{{ route('reservation.clear') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 rounded-xl font-manrope font-bold text-xs transition">
                        <i class="bi bi-trash"></i> Batalkan Reservasi
                    </button>
                </form>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8 w-full">
            <!-- Menu Section (Left Column) -->
            <div class="flex-1 flex flex-col gap-8 w-full max-w-[800px]">

                <!-- Header & Categories -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="flex flex-col gap-2">
                        <h1
                            class="font-noto-serif font-semibold text-4xl md:text-5xl leading-tight tracking-[-0.96px] text-[#1E1B18]">
                            Pesan Menu Anda</h1>
                    </div>
                    <div class="flex items-center gap-3 overflow-x-auto scrollbar-hide pb-2 md:pb-0">
                        <button data-stall="all"
                            class="stall-btn px-6 py-2 bg-[#725B38] rounded-full font-manrope font-semibold text-xs tracking-[1.2px] uppercase text-white whitespace-nowrap transition hover:opacity-90 active-stall">SEMUA</button>
                        @foreach($stalls as $stall)
                            <button data-stall="{{ Str::slug($stall->name) }}"
                                class="stall-btn px-6 py-2 bg-[#EEE7E2] rounded-full font-manrope font-semibold text-xs tracking-[1.2px] uppercase text-[#4D463C] whitespace-nowrap transition hover:bg-[#725B38] hover:text-white">{{ strtoupper($stall->name) }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- Menu Sections grouped by Stall with Recommendations -->
                <div id="stalls-container" class="flex flex-col gap-12 w-full">
                    @foreach($stalls as $stall)
                        <div class="stall-section transition-all duration-500 ease-out"
                            data-stall="{{ Str::slug($stall->name) }}">
                            <!-- Stall Title Header -->
                            <div class="flex items-center gap-4 mb-6 border-b border-[#D1C5B8] pb-3">
                                <div class="w-2.5 h-7 bg-[#725B38] rounded-full"></div>
                                <h2 class="font-noto-serif font-black text-2xl tracking-[-0.5px] text-[#532E1C]">
                                    {{ strtoupper($stall->name) }}
                                </h2>
                            </div>

                            <!-- 1. Pilihan Chef Section -->
                            @if($stall->chefRecommendations->isNotEmpty())
                                <div
                                    class="mb-8 bg-[#FAF2ED] p-6 rounded-xl border border-[#D4AF37]/30 shadow-[0_4px_24px_rgba(212,175,55,0.06)]">
                                    <h3
                                        class="font-manrope font-extrabold text-xs tracking-[1.5px] uppercase text-[#725B38] mb-5 flex items-center gap-2">
                                        <i class="bi bi-award-fill text-[#D4AF37] text-lg"></i> PILIHAN CHEF REKOMENDASI 👨‍🍳
                                    </h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                        @foreach($stall->chefRecommendations as $menu)
                                            <div
                                                class="menu-item bg-[#F2F2F2] border-2 border-[#D4AF37]/40 rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgba(114,91,56,0.15)]">
                                                <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                                                    <img src="{{ $menu->image_path ?? 'https://via.placeholder.com/300' }}"
                                                        alt="{{ $menu->name }}"
                                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                    <div
                                                        class="absolute top-3 left-3 bg-gradient-to-r from-[#D4AF37] to-[#AA7C11] rounded-full px-3 py-1.5 z-10 shadow-md border border-white/20 flex items-center gap-1.5">
                                                        <i class="bi bi-star-fill text-white text-[10px]"></i>
                                                        <span
                                                            class="font-manrope font-extrabold text-[9px] tracking-[1.2px] uppercase text-white leading-tight">PILIHAN
                                                            CHEF</span>
                                                    </div>
                                                    <div
                                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0">
                                                    </div>
                                                </div>
                                                <div class="p-5 flex flex-col gap-2 flex-1">
                                                    <div class="flex flex-col flex-1">
                                                        <h3
                                                            class="font-noto-serif font-bold text-lg leading-[22px] text-[#1E1B18] mb-1 group-hover:text-[#725B38] transition-colors">
                                                            {{ $menu->name }}</h3>
                                                        <p
                                                            class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">
                                                            {{ $menu->description }}</p>
                                                    </div>
                                                    <div class="flex items-center justify-between mt-2">
                                                        <span class="font-manrope font-bold text-base text-[#725B38]">Rp
                                                            {{ number_format($menu->price, 0, ',', '.') }}</span>
                                                    </div>
                                                    <button data-name="{{ $menu->name }}" data-price="{{ (int) $menu->price }}"
                                                        class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C] active:scale-[0.98]">TAMBAH
                                                        PESANAN</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- 2. Rekomendasi Terpopuler Minggu Ini -->
                            @if($stall->weeklyRecommendations->isNotEmpty())
                                <div
                                    class="mb-8 bg-[#FAF6F3] p-6 rounded-xl border border-red-500/20 shadow-[0_4px_24px_rgba(239,68,68,0.04)]">
                                    <h3
                                        class="font-manrope font-extrabold text-xs tracking-[1.5px] uppercase text-red-600 mb-5 flex items-center gap-2 animate-pulse">
                                        <i class="bi bi-fire text-lg text-red-500"></i> REKOMENDASI TERPOPULER MINGGU INI 🔥
                                    </h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                        @foreach($stall->weeklyRecommendations as $menu)
                                            <div
                                                class="menu-item bg-[#F2F2F2] border-2 border-red-500/30 rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgba(255,75,43,0.15)]">
                                                <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                                                    <img src="{{ $menu->image_path ?? 'https://via.placeholder.com/300' }}"
                                                        alt="{{ $menu->name }}"
                                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                    <div
                                                        class="absolute top-3 left-3 bg-gradient-to-r from-[#FF416C] to-[#FF4B2B] rounded-full px-3 py-1.5 z-10 shadow-md border border-white/20 flex items-center gap-1.5">
                                                        <i class="bi bi-fire text-white text-[10px]"></i>
                                                        <span
                                                            class="font-manrope font-extrabold text-[9px] tracking-[1.2px] uppercase text-white leading-tight">TERPOPULER</span>
                                                    </div>
                                                    <div
                                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0">
                                                    </div>
                                                </div>
                                                <div class="p-5 flex flex-col gap-2 flex-1">
                                                    <div class="flex flex-col flex-1">
                                                        <h3
                                                            class="font-noto-serif font-bold text-lg leading-[22px] text-[#1E1B18] mb-1 group-hover:text-[#725B38] transition-colors">
                                                            {{ $menu->name }}</h3>
                                                        <p
                                                            class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">
                                                            {{ $menu->description }}</p>
                                                    </div>
                                                    <div class="flex items-center justify-between mt-2">
                                                        <span class="font-manrope font-bold text-base text-[#725B38]">Rp
                                                            {{ number_format($menu->price, 0, ',', '.') }}</span>
                                                    </div>
                                                    <button data-name="{{ $menu->name }}" data-price="{{ (int) $menu->price }}"
                                                        class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C] active:scale-[0.98]">TAMBAH
                                                        PESANAN</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- 3. Menu Lainnya -->
                            @if($stall->regularMenus->isNotEmpty())
                                <div class="mb-4">
                                    <h3
                                        class="font-manrope font-extrabold text-xs tracking-[1.5px] uppercase text-[#4D463C] mb-4">
                                        MENU LAINNYA
                                    </h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                        @foreach($stall->regularMenus as $menu)
                                            <div
                                                class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgba(114,91,56,0.12)]">
                                                <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                                                    <img src="{{ $menu->image_path ?? 'https://via.placeholder.com/300' }}"
                                                        alt="{{ $menu->name }}"
                                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                    <div
                                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0">
                                                    </div>
                                                </div>
                                                <div class="p-5 flex flex-col gap-2 flex-1">
                                                    <div class="flex flex-col flex-1">
                                                        <h3
                                                            class="font-noto-serif font-bold text-lg leading-[22px] text-[#1E1B18] mb-1 group-hover:text-[#725B38] transition-colors">
                                                            {{ $menu->name }}</h3>
                                                        <p
                                                            class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">
                                                            {{ $menu->description }}</p>
                                                    </div>
                                                    <div class="flex items-center justify-between mt-2">
                                                        <span class="font-manrope font-bold text-base text-[#725B38]">Rp
                                                            {{ number_format($menu->price, 0, ',', '.') }}</span>
                                                    </div>
                                                    <button data-name="{{ $menu->name }}" data-price="{{ (int) $menu->price }}"
                                                        class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C] active:scale-[0.98]">TAMBAH
                                                        PESANAN</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Sidebar Order Summary (Right Column) -->
            <aside class="w-full lg:w-[360px] shrink-0 sticky top-[100px] flex flex-col h-fit">

                <!-- Order List Container -->
                <div
                    class="bg-white border border-[#D1C5B8] border-b-0 rounded-t-xl overflow-hidden flex flex-col shadow-[0_10px_15px_-3px_rgba(0,0,0,0.1)]">

                    <!-- Header -->
                    <div class="p-6 border-b border-[#E8E1DC]">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-[18px] h-[20px] bg-[#80543F]"></div>
                            <h2 class="font-noto-serif font-normal text-xl leading-7 text-[#1E1B18]">Order Anda</h2>
                        </div>
                        <p
                            class="font-manrope font-normal text-[10px] leading-tight tracking-[0.5px] uppercase text-[#4D463C]">
                            ESTIMASI TUNGGU: 12-15 MENIT</p>
                    </div>

                    <!-- Order Items & Summary -->
                    <div id="cart-empty-state" class="p-12 flex flex-col items-center justify-center text-center gap-4">
                        <div
                            class="w-16 h-16 bg-[#EEE7E2] rounded-full flex items-center justify-center text-[#725B38]">
                            <i class="bi bi-cart-x text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-noto-serif font-semibold text-lg text-[#1E1B18]">Pesanan Kosong</h4>
                            <p class="font-manrope font-normal text-xs text-[#4D463C] mt-1">Mulai pilih menu lezat kami
                                untuk memesan.</p>
                        </div>
                    </div>

                    <div id="cart-content" class="hidden flex flex-col flex-1">
                        <!-- Order Items List -->
                        <div id="cart-items" class="p-6 flex flex-col gap-6 max-h-[400px] overflow-y-auto">
                            <!-- Items will be injected here by JS -->
                        </div>

                        <!-- Promo Code -->
                        <div class="px-6 pb-6 pt-4 border-t border-dashed border-[#D1C5B8]">
                            <div class="flex gap-2">
                                <div class="flex-1 border border-[#7F766A] bg-[#FAF2ED] p-3 flex items-center">
                                    <input type="text" placeholder="KODE PROMO"
                                        class="bg-transparent outline-none w-full font-manrope text-[10px] uppercase text-[#6B7280]">
                                </div>
                                <button
                                    class="px-3 py-3 font-manrope font-bold text-[10px] text-[#725B38] uppercase hover:bg-[#FAF2ED] transition">APPLY</button>
                            </div>
                        </div>

                        <!-- Total Section -->
                        <div class="bg-white border-t border-[#D1C5B8] p-6 flex flex-col gap-4">
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-manrope font-normal text-sm text-[#4D463C]">Subtotal</span>
                                    <span id="subtotal-val" class="font-manrope font-medium text-sm text-[#1E1B18]">Rp 0</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-2 border-t border-[#D1C5B8]">
                                <span class="font-noto-serif font-normal text-lg text-[#1E1B18]">Total</span>
                                <span id="total-val" class="font-noto-serif font-normal text-2xl text-[#725B38]">Rp 0</span>
                            </div>

                            <button id="checkout-btn"
                                class="w-full py-4 mt-2 bg-[#725B38] rounded text-white font-manrope font-normal text-[12px] tracking-[1.2px] uppercase hover:bg-[#532E1C] transition shadow-[0_4px_6px_rgba(0,0,0,0.1)]">
                                PESAN SEKARANG
                            </button>

                            <p
                                class="font-manrope font-normal text-[10px] text-[#4D463C] text-center opacity-60 mt-1 uppercase">
                                Silakan siapkan pembayaran Anda.</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

    </main>

    <script>
        // Mobile Menu Toggle
        document.getElementById('nav-mobile-toggle').addEventListener('click', function () {
            const menu = document.getElementById('nav-mobile-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('flex');
        });

        // Stall Filtering Logic
        const stallBtns = document.querySelectorAll('.stall-btn');
        const stallSections = document.querySelectorAll('.stall-section');

        stallBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const stall = btn.getAttribute('data-stall');

                // Update active button state
                stallBtns.forEach(b => {
                    b.classList.remove('bg-[#725B38]', 'text-white', 'active-stall');
                    b.classList.add('bg-[#EEE7E2]', 'text-[#4D463C]');
                });
                btn.classList.add('bg-[#725B38]', 'text-white', 'active-stall');
                btn.classList.remove('bg-[#EEE7E2]', 'text-[#4D463C]');

                // Filter stall sections
                stallSections.forEach(section => {
                    if (stall === 'all' || section.getAttribute('data-stall') === stall) {
                        section.classList.remove('hidden');
                        setTimeout(() => {
                            section.style.opacity = '1';
                            section.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        section.style.opacity = '0';
                        section.style.transform = 'translateY(10px)';
                        setTimeout(() => {
                            section.classList.add('hidden');
                        }, 300);
                    }
                });
            });
        });

        // Cart Logic
        let cart = [];

        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);
        }

        function updateCart() {
            const cartItemsContainer = document.getElementById('cart-items');
            const cartEmptyState = document.getElementById('cart-empty-state');
            const cartContent = document.getElementById('cart-content');
            const subtotalEl = document.getElementById('subtotal-val');
            const totalEl = document.getElementById('total-val');

            if (cart.length === 0) {
                cartEmptyState.classList.remove('hidden');
                cartContent.classList.add('hidden');
                return;
            }

            cartEmptyState.classList.add('hidden');
            cartContent.classList.remove('hidden');

            cartItemsContainer.innerHTML = '';
            let subtotal = 0;

            cart.forEach((item, index) => {
                subtotal += item.price * item.quantity;
                const itemEl = document.createElement('div');
                itemEl.className = 'flex justify-between items-start gap-4';
                itemEl.innerHTML = `
                    <div class="flex flex-col gap-1 flex-1">
                        <h4 class="font-manrope font-semibold text-base leading-[22px] text-[#1E1B18]">${item.name}</h4>
                        <div class="flex items-center gap-4 mt-3">
                            <button onclick="changeQuantity(${index}, -1)" class="w-6 h-6 border border-[#7F766A] rounded flex items-center justify-center text-[#4D463C] hover:bg-gray-100"><i class="bi bi-dash"></i></button>
                            <span class="font-manrope font-bold text-sm text-[#1E1B18]">${item.quantity}</span>
                            <button onclick="changeQuantity(${index}, 1)" class="w-6 h-6 border border-[#7F766A] rounded flex items-center justify-center text-[#4D463C] hover:bg-gray-100"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>
                    <span class="font-manrope font-bold text-base leading-6 text-[#1E1B18]">${(item.price * item.quantity / 1000)}k</span>
                `;
                cartItemsContainer.appendChild(itemEl);
            });

            const total = subtotal;

            subtotalEl.innerText = formatPrice(subtotal);
            totalEl.innerText = formatPrice(total);
        }

        function changeQuantity(index, delta) {
            cart[index].quantity += delta;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            updateCart();
        }

        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', () => {
                const name = btn.getAttribute('data-name');
                const price = parseInt(btn.getAttribute('data-price'));

                const existingItem = cart.find(item => item.name === name);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({ name, price, quantity: 1 });
                }
                updateCart();
            });
        });

        // Initialize empty state
        updateCart();

        // Checkout: save cart to sessionStorage, redirect to /checkout page
        const checkoutBtn = document.getElementById('checkout-btn');

        checkoutBtn.addEventListener('click', () => {
            if (cart.length === 0) {
                alert('Keranjang belanja Anda kosong.');
                return;
            }
            sessionStorage.setItem('depallet_cart', JSON.stringify(cart));
            const tableNumber = '{{ $table ? $table->table_number : "" }}';
            const checkoutUrl = '{{ route("checkout") }}' + (tableNumber ? '?table=' + encodeURIComponent(tableNumber) : '');
            window.location.href = checkoutUrl;
        });
    </script>
</body>

</html>