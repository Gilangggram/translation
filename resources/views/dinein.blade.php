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
            <div class="hidden md:flex items-center">
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
    <main
        class="w-full max-w-[1440px] mx-auto flex-1 flex flex-col lg:flex-row gap-8 pt-[128px] px-8 xl:px-16 pb-16 relative">

        <!-- Menu Section (Left Column) -->
        <div class="flex-1 flex flex-col gap-8 w-full max-w-[800px]">

            <!-- Header & Categories -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="flex flex-col gap-2">
                    <h1
                        class="font-noto-serif font-semibold text-4xl md:text-5xl leading-tight tracking-[-0.96px] text-[#1E1B18]">
                        Pesan Menu<br>anda</h1>
                </div>
                <div class="flex items-center gap-3 overflow-x-auto scrollbar-hide pb-2 md:pb-0">
                    <button data-filter="all"
                        class="category-btn px-6 py-2 bg-[#725B38] rounded-full font-manrope font-semibold text-xs tracking-[1.2px] uppercase text-white whitespace-nowrap transition hover:opacity-90 active-category">ALL</button>
                    <button data-filter="makanan"
                        class="category-btn px-6 py-2 bg-[#EEE7E2] rounded-full font-manrope font-semibold text-xs tracking-[1.2px] uppercase text-[#4D463C] whitespace-nowrap transition hover:bg-[#725B38] hover:text-white">MAKANAN</button>
                    <button data-filter="minuman"
                        class="category-btn px-6 py-2 bg-[#EEE7E2] rounded-full font-manrope font-semibold text-xs tracking-[1.2px] uppercase text-[#4D463C] whitespace-nowrap transition hover:bg-[#725B38] hover:text-white">MINUMAN</button>
                    <button data-filter="snacks"
                        class="category-btn px-6 py-2 bg-[#EEE7E2] rounded-full font-manrope font-semibold text-xs tracking-[1.2px] uppercase text-[#4D463C] whitespace-nowrap transition hover:bg-[#725B38] hover:text-white">SNACKS</button>
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

                <!-- Menu Item 1 -->
                <div data-category="makanan"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&q=80&w=300"
                            alt="Nasi Goreng Kampung" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">RECOMMENDED</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Nasi
                                Goreng Kampung</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Resep
                                tradisional dengan bumbu rempah otentik, disajikan hangat.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 45.000</span>
                        </div>
                        <button data-name="Nasi Goreng Kampung" data-price="45000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 2 -->
                <div data-category="makanan"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&q=80&w=300"
                            alt="Sate Ayam Madura" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">BEST
                                SELLER</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Sate Ayam
                                Madura</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Sate
                                ayam pilihan dengan bumbu kacang khas Madura yang gurih.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 35.000</span>
                        </div>
                        <button data-name="Sate Ayam Madura" data-price="35000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 3 -->
                <div data-category="makanan"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1564834744159-ff0ea41ba4b9?auto=format&fit=crop&q=80&w=300"
                            alt="Rendang Daging" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">SIGNATURE</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Rendang
                                Daging</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Daging
                                sapi empuk dimasak perlahan dengan rempah Padang asli.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 50.000</span>
                        </div>
                        <button data-name="Rendang Daging" data-price="50000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 4 -->
                <div data-category="makanan"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1548842428-150fa9ea2a5b?auto=format&fit=crop&q=80&w=300"
                            alt="Gado Gado Betawi" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">HEALTHY</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Gado Gado
                                Betawi</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">
                                Sayuran segar dengan saus kacang kental khas Betawi.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 30.000</span>
                        </div>
                        <button data-name="Gado Gado Betawi" data-price="30000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 5 -->
                <div data-category="minuman"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&q=80&w=300"
                            alt="Es Cendol Durian" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">DESSERT</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Es Cendol
                                Durian</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Es
                                cendol segar disajikan dengan daging durian asli.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 28.000</span>
                        </div>
                        <button data-name="Es Cendol Durian" data-price="28000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 6 -->
                <div data-category="makanan"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&q=80&w=300"
                            alt="Bakso Urat" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">POPULAR</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Bakso
                                Urat</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Bakso
                                sapi urat kenyal dengan kuah kaldu sapi asli yang gurih.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 32.000</span>
                        </div>
                        <button data-name="Bakso Urat" data-price="32000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 7 -->
                <div data-category="makanan"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1598514982205-f36b96d1e8d4?auto=format&fit=crop&q=80&w=300"
                            alt="Ayam Bakar Taliwang" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">SPICY</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Ayam
                                Bakar Taliwang</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Ayam
                                bakar bumbu Taliwang pedas dengan sambal plecing.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 42.000</span>
                        </div>
                        <button data-name="Ayam Bakar Taliwang" data-price="42000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 8 -->
                <div data-category="minuman"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1563227812-0ea4c22e6cc8?auto=format&fit=crop&q=80&w=300"
                            alt="Es Teler" class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3 bg-[#80543F] rounded-full px-3 py-1 z-10 shadow-sm">
                            <span
                                class="font-manrope font-bold text-[10px] tracking-[1px] uppercase text-white leading-tight">REFRESHING</span>
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Es Teler
                            </h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">
                                Minuman es dengan nangka, alpukat, kelapa muda dan susu kental.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 25.000</span>
                        </div>
                        <button data-name="Es Teler" data-price="25000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 9 (New: Snacks) -->
                <div data-category="snacks"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1606755962773-d323305167c0?auto=format&fit=crop&q=80&w=300"
                            alt="Tempe Mendoan" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Tempe
                                Mendoan</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Tempe
                                goreng tepung lebar khas Banyumas disajikan dengan sambal kecap.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 15.000</span>
                        </div>
                        <button data-name="Tempe Mendoan" data-price="15000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 10 (New: Minuman) -->
                <div data-category="minuman"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544145945-f904253d0c71?auto=format&fit=crop&q=80&w=300"
                            alt="Kopi Susu Aren" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Kopi Susu
                                Aren</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">
                                Espresso dengan susu segar dan pemanis gula aren asli.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 22.000</span>
                        </div>
                        <button data-name="Kopi Susu Aren" data-price="22000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 11 (New: Makanan) -->
                <div data-category="makanan"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=300"
                            alt="Soto Ayam" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Soto Ayam
                            </h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Soto
                                ayam kuning gurih dengan suwiran ayam, telur, dan koya.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 28.000</span>
                        </div>
                        <button data-name="Soto Ayam" data-price="28000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

                <!-- Menu Item 12 (New: Snacks) -->
                <div data-category="snacks"
                    class="menu-item bg-[#F2F2F2] border border-[#D1C5B8] rounded-lg shadow-[0_4px_20px_rgba(83,46,28,0.08)] overflow-hidden flex flex-col relative group transition-transform hover:-translate-y-1">
                    <div class="w-full h-[192px] relative bg-gray-300 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?auto=format&fit=crop&q=80&w=300"
                            alt="Pisang Goreng Keju" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors z-0"></div>
                    </div>
                    <div class="p-5 flex flex-col gap-2 flex-1">
                        <div class="flex flex-col flex-1">
                            <h3 class="font-noto-serif font-normal text-lg leading-[22px] text-[#1E1B18] mb-1">Pisang
                                Goreng Keju</h3>
                            <p class="font-manrope font-normal text-[11px] leading-4 text-[#4D463C] line-clamp-2">Pisang
                                goreng krispi dengan topping parutan keju melimpah.</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="font-manrope font-bold text-base text-[#725B38]">Rp 20.000</span>
                        </div>
                        <button data-name="Pisang Goreng Keju" data-price="20000"
                            class="add-to-cart w-full mt-2 py-2.5 bg-[#725B38] rounded font-manrope font-normal text-[10px] tracking-[1px] uppercase text-white transition hover:bg-[#532E1C]">TAMBAH
                            PESANAN</button>
                    </div>
                </div>

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
                    <div class="w-16 h-16 bg-[#EEE7E2] rounded-full flex items-center justify-center text-[#725B38]">
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
                                <span id="subtotal-val" class="font-manrope font-medium text-sm text-[#1E1B18]">Rp
                                    0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-manrope font-normal text-sm text-[#4D463C]">Pajak (11%)</span>
                                <span id="tax-val" class="font-manrope font-medium text-sm text-[#1E1B18]">Rp 0</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-[#D1C5B8]">
                            <span class="font-noto-serif font-normal text-lg text-[#1E1B18]">Total</span>
                            <span id="total-val" class="font-noto-serif font-normal text-2xl text-[#725B38]">Rp 0</span>
                        </div>

                        <button
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

    </main>

    <script>
        // Mobile Menu Toggle
        document.getElementById('nav-mobile-toggle').addEventListener('click', function () {
            const menu = document.getElementById('nav-mobile-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('flex');
        });

        // Category Filtering Logic
        const filterBtns = document.querySelectorAll('.category-btn');
        const menuItems = document.querySelectorAll('.menu-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter');

                // Update active button state
                filterBtns.forEach(b => {
                    b.classList.remove('bg-[#725B38]', 'text-white', 'active-category');
                    b.classList.add('bg-[#EEE7E2]', 'text-[#4D463C]');
                });
                btn.classList.add('bg-[#725B38]', 'text-white', 'active-category');
                btn.classList.remove('bg-[#EEE7E2]', 'text-[#4D463C]');

                // Filter menu items
                menuItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.classList.remove('hidden');
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(10px)';
                        setTimeout(() => {
                            item.classList.add('hidden');
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
            const taxEl = document.getElementById('tax-val');
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

            const tax = subtotal * 0.11;
            const total = subtotal + tax;

            subtotalEl.innerText = formatPrice(subtotal);
            taxEl.innerText = formatPrice(tax);
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
    </script>
</body>

</html>