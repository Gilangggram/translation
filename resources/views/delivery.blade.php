<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="De'Pallet Cafe Delivery - Pesan makanan Nusantara favorit langsung ke depan pintu Anda.">
    <title>De'Pallet Cafe - Delivery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Noto+Serif:wght@700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Leaflet Map CSS & JS CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #delivery-map {
            z-index: 10;
        }
        .leaflet-container {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>

<body class="font-manrope bg-delivery-bg text-dark overflow-x-hidden">
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
            <div
                class="flex items-center gap-3 px-5 py-2 mt-2 bg-secondary/5 rounded-full border border-secondary/10 mx-5">
                <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white">
                    <i class="bi bi-person"></i>
                </div>
                <span class="font-manrope font-bold text-sm text-secondary">Guest</span>
            </div>
        </div>
    </nav>

    <div class="flex flex-col lg:flex-row max-w-[1440px] mx-auto pt-[104px] lg:pt-[88px] px-6 lg:px-10 pb-10 gap-8">
        <div class="flex-1 min-w-0">
            <div class="mb-7" id="delivery-header">
                <h1 class="font-noto-serif font-black text-4xl leading-[44px] text-dark mb-3">Hantaran Nusantara</h1>
                <p class="font-manrope font-normal text-[15px] leading-6 text-neutral max-w-[520px]">Cita rasa warisan
                    dari dapur kami langsung ke depan pintu Anda.
                    Nikmati kelezatan masakan tradisional yang diolah dengan rempah pilihan.</p>
            </div>

            <div class="flex gap-2.5 mb-7 overflow-x-auto pb-1 scrollbar-hide" id="delivery-categories">
                <button
                    class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-secondary border-secondary text-white"
                    data-category="all">Semua Menu</button>
                <button
                    class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary"
                    data-category="nasi">Nasi Nusantara</button>
                <button
                    class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary"
                    data-category="sate">Sate & Bakaran</button>
                <button
                    class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary"
                    data-category="lauk">Lauk Pauk</button>
                <button
                    class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary"
                    data-category="minuman">Minuman</button>
            </div>

            <div class="grid grid-cols-[repeat(auto-fill,minmax(220px,1fr))] lg:grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-5 mb-8"
                id="menu-grid">

                @foreach($menus as $menu)
                    @if($loop->first)
                        <!-- Featured Item -->
                        <div class="md:col-span-2 lg:col-span-2 bg-delivery-card rounded-2xl overflow-hidden flex flex-col sm:flex-row items-center transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_16px_48px_rgba(83,46,28,0.12)] group animate-fade-up mc-feat h-fit"
                            data-menu-id="{{ $menu->menu_id }}" data-category="{{ $menu->category }}">
                            <div
                                class="h-[200px] sm:h-[240px] md:h-[280px] w-full sm:w-[240px] md:w-[280px] lg:w-[55%] overflow-hidden rounded-xl m-3 shrink-0">
                                <img src="{{ $menu->image_path ?? 'https://via.placeholder.com/600x400' }}"
                                    alt="{{ $menu->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="eager">
                            </div>
                            <div
                                class="p-5 pt-2 sm:py-5 sm:pr-6 sm:pl-2 lg:p-8 lg:pl-4 flex-1 flex flex-col justify-center w-full">
                                <div
                                    class="font-manrope font-bold text-[10px] tracking-[1.2px] uppercase text-secondary mb-1.5">
                                    {{ $menu->stall->name }}
                                </div>
                                <div
                                    class="font-noto-serif font-extrabold text-2xl sm:text-[28px] leading-tight text-dark mb-2">
                                    {{ $menu->name }}</div>
                                <div class="flex items-baseline gap-1 mb-4">
                                    <span class="font-semibold text-sm text-secondary">Rp</span>
                                    <span
                                        class="font-noto-serif font-extrabold text-2xl text-secondary">{{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                                <button
                                    class="btn-tambah font-manrope font-bold text-xs tracking-[1px] uppercase py-3 px-7 bg-secondary text-white border-none rounded-lg cursor-pointer w-full sm:w-fit transition-all duration-300 hover:bg-[#3d2214] hover:-translate-y-[1px]"
                                    data-menu-id="{{ $menu->menu_id }}" data-name="{{ $menu->name }}"
                                    data-price="{{ (int) $menu->price }}">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Regular Item -->
                        <div class="bg-white rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_36px_rgba(83,46,28,0.10)] group animate-fade-up mc"
                            style="animation-delay: {{ 0.05 * $loop->index }}s" data-menu-id="{{ $menu->menu_id }}"
                            data-category="{{ $menu->category }}">
                            <div class="w-[calc(100%-20px)] h-[160px] overflow-hidden rounded-xl mt-2.5 mx-2.5 shrink-0">
                                <img src="{{ $menu->image_path ?? 'https://via.placeholder.com/300' }}" alt="{{ $menu->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy">
                            </div>
                            <div class="px-4 pt-[14px] pb-4 flex-1 flex flex-col">
                                <div class="font-bold text-[15px] leading-5 text-dark mb-0.5">{{ $menu->name }}</div>
                                <div class="flex items-baseline gap-1 mb-2">
                                    <span class="font-semibold text-xs text-secondary">Rp</span>
                                    <span
                                        class="font-bold text-base text-secondary">{{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-xs leading-[18px] text-neutral mb-3.5 flex-1 line-clamp-3">
                                    {{ $menu->description }}</p>
                                <button
                                    class="btn-pilih font-manrope font-bold text-xs tracking-[0.8px] uppercase py-2.5 bg-transparent text-dark border-[1.5px] border-delivery-border rounded-lg cursor-pointer w-full text-center transition-all duration-300 hover:border-secondary hover:bg-secondary hover:text-white"
                                    data-menu-id="{{ $menu->menu_id }}" data-name="{{ $menu->name }}"
                                    data-price="{{ (int) $menu->price }}">
                                    Pilih
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>

        <aside
            class="w-full lg:w-[340px] shrink-0 static lg:sticky lg:top-[88px] self-start lg:max-h-[calc(100vh-112px)] overflow-y-auto flex flex-col gap-6"
            id="delivery-sidebar">
            <!-- Location Picker Map Card -->
            <div class="bg-white rounded-2xl py-7 px-6 shadow-[0_4px_24px_rgba(0,0,0,0.04)] animate-slide-right flex flex-col gap-4"
                id="delivery-location-picker">
                <div class="flex items-center gap-2 border-b border-delivery-border pb-3">
                    <i class="bi bi-geo-alt-fill text-secondary text-lg"></i>
                    <h2 class="font-noto-serif font-extrabold text-lg text-dark">Lokasi Pengiriman</h2>
                </div>
                <p class="font-manrope text-xs text-neutral leading-relaxed">
                    Pilih lokasi pengiriman Anda menggunakan peta, pencarian alamat, atau GPS device Anda (maksimal 1.8 Km radius bulat dari Cafe).
                </p>

                <!-- Option 1: Search Address Input -->
                <div class="flex flex-col gap-1.5 mt-1">
                    <label class="font-manrope font-bold text-[10px] tracking-[0.5px] uppercase text-[#7F766A]">Cari Alamat Pengiriman</label>
                    <div class="flex gap-2">
                        <input type="text" id="search-address-input" placeholder="Masukkan nama jalan, perumahan, atau gedung..." 
                            class="flex-1 border border-delivery-border rounded-xl px-3 py-2.5 font-manrope text-xs bg-gray-50/50 focus:outline-none focus:border-secondary focus:bg-white transition-all">
                        <button type="button" id="btn-search-address" class="px-4 bg-[#725B38] text-white rounded-xl hover:bg-[#532E1C] transition text-sm flex items-center justify-center shadow-sm">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Option 2: Get Location via GPS Button -->
                <button type="button" id="btn-gps-location" class="w-full py-2.5 bg-[#725B38]/10 hover:bg-[#725B38]/20 text-[#725B38] font-manrope font-bold text-[10px] tracking-[0.5px] uppercase rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="bi bi-crosshair"></i>
                    <span>Gunakan Lokasi GPS Saya</span>
                </button>

                <!-- Map Container -->
                <div id="delivery-map" class="w-full h-[220px] rounded-xl border border-delivery-border overflow-hidden relative"></div>
                
                <!-- Distance Status Badge -->
                <div id="distance-badge" class="py-2.5 px-4 rounded-xl bg-gray-50 border border-gray-200 text-[11px] font-bold text-center text-gray-500 transition-all duration-300 flex items-center justify-center gap-1.5">
                    <i class="bi bi-geo-alt"></i>
                    <span>Ketuk pada peta untuk memilih lokasi</span>
                </div>

                <!-- Address Detail Area -->
                <textarea id="delivery-address" placeholder="Tulis rincian alamat pengiriman Anda (cth: Nomor rumah, nama jalan, patokan, dll)..." 
                    class="w-full border border-delivery-border rounded-xl p-3.5 font-manrope text-xs bg-gray-50/50 focus:outline-none focus:border-secondary focus:bg-white transition-all h-[70px] resize-none"></textarea>
            </div>

            <div class="bg-white rounded-2xl py-7 px-6 shadow-[0_4px_24px_rgba(0,0,0,0.04)] animate-slide-right"
                id="order-summary">
                <h2 class="font-noto-serif font-extrabold text-xl text-dark mb-6">Ringkasan Pesanan</h2>
                <div class="flex flex-col gap-4 mb-6 pb-6 border-b border-delivery-border" id="cart-items">
                    <!-- Item akan ditambahkan di sini melalui JavaScript -->
                </div>

                <div class="flex flex-col gap-2.5 mb-6" id="order-totals">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral">Subtotal</span>
                        <span class="font-semibold text-sm text-dark" id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral">Biaya Kirim</span>
                        <span class="font-semibold text-sm text-dark" id="shipping-cost">Rp 2.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-3.5 border-t border-delivery-border mt-1">
                        <span class="font-bold text-base text-dark">Total</span>
                        <span class="font-extrabold text-xl text-secondary" id="order-total">Rp 2.000</span>
                    </div>
                </div>

                <button
                    class="w-full p-4 bg-gradient-to-r from-secondary to-primary text-white font-manrope font-bold text-sm tracking-[1px] uppercase border-none rounded-xl cursor-pointer transition-all duration-300 mb-4 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(83,46,28,0.25)]"
                    id="btn-checkout">
                    Lanjut ke Pembayaran
                </button>
                <div class="flex items-center gap-3.5 p-4 border-[1.5px] border-delivery-border rounded-xl">
                    <div class="w-10 h-10 flex items-center justify-center text-[22px] text-secondary">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-[10px] tracking-[0.8px] uppercase text-neutral mb-0.5">Estimasi
                            Kedatangan</div>
                        <div class="font-extrabold text-base text-dark">30 - 45 Menit</div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('del-mobile-toggle');
            const mobileMenu = document.getElementById('del-mobile-menu');
            if (toggle && mobileMenu) {
                toggle.addEventListener('click', () => {
                    if (mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.remove('hidden');
                        mobileMenu.classList.add('flex');
                    } else {
                        mobileMenu.classList.add('hidden');
                        mobileMenu.classList.remove('flex');
                    }
                    const icon = toggle.querySelector('i');
                    icon.classList.toggle('bi-list');
                    icon.classList.toggle('bi-x-lg');
                });
            }

            const categoryBtns = document.querySelectorAll('.cat-btn');
            const menuItems = document.querySelectorAll('.mc, .mc-feat');

            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    categoryBtns.forEach(b => {
                        b.classList.remove('bg-secondary', 'border-secondary', 'text-white');
                        b.classList.add('bg-transparent', 'border-delivery-border', 'text-neutral');
                    });
                    this.classList.remove('bg-transparent', 'border-delivery-border', 'text-neutral');
                    this.classList.add('bg-secondary', 'border-secondary', 'text-white');

                    const category = this.dataset.category;
                    menuItems.forEach(item => {
                        if (category === 'all' || item.dataset.category === category) {
                            item.style.display = '';
                            item.style.animation = 'none';
                            item.offsetHeight;
                            item.style.animation = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });

            document.querySelectorAll('.btn-tambah, .btn-pilih').forEach(btn => {
                btn.addEventListener('click', function () {
                    const name = this.dataset.name;
                    const price = parseInt(this.dataset.price);
                    const menuId = this.dataset.menuId;
                    const card = this.closest('.mc, .mc-feat');
                    const imgSrc = card.querySelector('img').src;

                    this.textContent = '✓ Ditambahkan';
                    this.style.background = '#2d7a4f';
                    this.style.color = 'white';
                    setTimeout(() => {
                        this.textContent = this.classList.contains('btn-tambah') ? 'Tambah' : 'Pilih';
                        this.style.background = '';
                        this.style.color = '';
                    }, 1200);

                    addToCart(menuId, name, price, imgSrc);
                });
            });

            function formatRupiah(num) {
                return 'Rp ' + num.toLocaleString('id-ID');
            }

            function updateCartTotals() {
                const items = document.querySelectorAll('.ci');
                let subtotal = 0;

                items.forEach(item => {
                    const priceText = item.querySelector('.ci-price').textContent;
                    const price = parseInt(priceText.replace(/[^\d]/g, ''));
                    const qty = parseInt(item.querySelector('.qty-val').textContent);
                    subtotal += price * qty;
                });

                const shipping = 2000;
                const total = subtotal + shipping;

                document.getElementById('subtotal').textContent = formatRupiah(subtotal);
                document.getElementById('shipping-cost').textContent = formatRupiah(shipping);
                document.getElementById('order-total').textContent = formatRupiah(total);
                updateCartBadge();
            }

            function updateCartBadge() {
                const items = document.querySelectorAll('.ci');
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.textContent = items.length;
                    if (items.length > 0) {
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            }

            function addToCart(menuId, name, price, imgSrc) {
                let existingItem = document.querySelector(`.ci[data-cart-id="${menuId}"]`);
                if (existingItem) {
                    let qtyEl = existingItem.querySelector('.qty-val');
                    qtyEl.textContent = parseInt(qtyEl.textContent) + 1;
                } else {
                    const cartItems = document.getElementById('cart-items');
                    const itemHtml = `
                        <div class="flex gap-3 items-start animate-fade-up-fast ci" data-cart-id="${menuId}">
                            <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0">
                                <img src="${imgSrc}" alt="${name}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-sm text-dark mb-1.5 truncate" title="${name}">${name}</div>
                                <div class="flex items-center gap-2">
                                    <button class="w-7 h-7 rounded-md border-[1.5px] border-delivery-border bg-transparent flex items-center justify-center cursor-pointer text-sm font-semibold text-dark transition-all duration-200 hover:bg-delivery-bg hover:border-secondary qty-minus" aria-label="Kurangi">−</button>
                                    <span class="font-bold text-sm text-dark min-w-[16px] text-center qty-val">1</span>
                                    <button class="w-7 h-7 rounded-md border-[1.5px] border-delivery-border bg-transparent flex items-center justify-center cursor-pointer text-sm font-semibold text-dark transition-all duration-200 hover:bg-delivery-bg hover:border-secondary qty-plus" aria-label="Tambah">+</button>
                                    <button class="font-manrope font-semibold text-[11px] tracking-[0.5px] uppercase text-neutral cursor-pointer bg-transparent border-none ml-2 transition-colors duration-200 hover:text-[#c0392b] ci-remove">Hapus</button>
                                </div>
                            </div>
                            <div class="font-bold text-sm text-dark whitespace-nowrap shrink-0 pt-0.5 ci-price">${formatRupiah(price)}</div>
                        </div>
                    `;
                    cartItems.insertAdjacentHTML('beforeend', itemHtml);

                    const newItem = document.querySelector(`.ci[data-cart-id="${menuId}"]`);
                    newItem.querySelector('.qty-minus').addEventListener('click', function () {
                        const valEl = this.nextElementSibling;
                        let val = parseInt(valEl.textContent);
                        if (val > 1) {
                            valEl.textContent = val - 1;
                            updateCartTotals();
                        }
                    });
                    newItem.querySelector('.qty-plus').addEventListener('click', function () {
                        const valEl = this.previousElementSibling;
                        let val = parseInt(valEl.textContent);
                        valEl.textContent = val + 1;
                        updateCartTotals();
                    });
                    newItem.querySelector('.ci-remove').addEventListener('click', function () {
                        const cartItem = this.closest('.ci');
                        cartItem.style.opacity = '0';
                        cartItem.style.transform = 'translateX(20px)';
                        cartItem.style.transition = 'all 0.3s ease';
                        setTimeout(() => {
                            cartItem.remove();
                            updateCartTotals();
                        }, 300);
                    });
                }
                updateCartTotals();
            }

            // Leaflet Map Integration & Variables
            const cafeCoords = [1.0563324880302494, 104.03512575174723];
            let map;
            let userMarker = null;
            window.selectedCoords = null;
            window.isInsideRadius = false;

            // Wait a small moment to ensure map container has size in DOM
            setTimeout(() => {
                // Disable Leaflet's default prefix to remove Ukrainian flag and Leaflet logo in attribution
                map = L.map('delivery-map', { attributionControl: false }).setView(cafeCoords, 14);
                
                // Use CartoDB Voyager tiles for modern premium aesthetics and clean localized labels
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    maxZoom: 20
                }).addTo(map);

                // Add custom attribution in Indonesian featuring the Indonesian flag
                L.control.attribution({ 
                    prefix: '<a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; 🇮🇩' 
                }).addAttribution('© OpenStreetMap Kontributor &copy; CARTO').addTo(map);

                // Custom DivIcon for Cafe Location
                const cafeIcon = L.divIcon({
                    html: '<div class="w-8 h-8 rounded-full bg-[#725B38] border-2 border-white flex items-center justify-center text-white shadow-lg"><i class="bi bi-shop text-sm"></i></div>',
                    className: 'custom-cafe-icon',
                    iconSize: [32, 32],
                    iconAnchor: [16, 16]
                });

                L.marker(cafeCoords, { icon: cafeIcon }).addTo(map)
                    .bindPopup('<b class="font-noto-serif">De\'Pallet Cafe</b><br><span class="text-xs">Lokasi Pusat</span>')
                    .openPopup();

                // 1.8km circular zone radius
                L.circle(cafeCoords, {
                    color: '#725B38',
                    fillColor: '#725B38',
                    fillOpacity: 0.12,
                    weight: 2,
                    radius: 1800 // 1.8km in meters
                }).addTo(map);

                // Haversine formula to compute distance in km
                function calculateDistance(lat1, lon1, lat2, lon2) {
                    const R = 6371; // Earth radius in km
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLon = (lon2 - lon1) * Math.PI / 180;
                    const a = 
                        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    return R * c;
                }

                function updateDistanceStatus(lat, lng) {
                    window.selectedCoords = [lat, lng];
                    const dist = calculateDistance(cafeCoords[0], cafeCoords[1], lat, lng);
                    const badge = document.getElementById('distance-badge');
                    
                    if (dist <= 1.8) {
                        window.isInsideRadius = true;
                        badge.className = "py-2.5 px-4 rounded-xl bg-green-50 border border-green-200 text-[11px] font-bold text-center text-green-700 transition-all duration-300 flex items-center justify-center gap-1.5";
                        badge.innerHTML = `<i class="bi bi-patch-check-fill text-green-600"></i> <span>Lokasi Terjangkau (${dist.toFixed(2)} km dari Cafe)</span>`;
                    } else {
                        window.isInsideRadius = false;
                        badge.className = "py-2.5 px-4 rounded-xl bg-red-50 border border-red-200 text-[11px] font-bold text-center text-red-600 transition-all duration-300 flex items-center justify-center gap-1.5";
                        badge.innerHTML = `<i class="bi bi-exclamation-triangle-fill text-red-500"></i> <span>Di Luar Jangkauan (${dist.toFixed(2)} km dari Cafe)</span>`;
                    }
                }

                // Listen for map clicks
                map.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;

                    if (userMarker) {
                        userMarker.setLatLng(e.latlng);
                    } else {
                        userMarker = L.marker(e.latlng, { draggable: true }).addTo(map);
                        userMarker.on('dragend', function(event) {
                            const marker = event.target;
                            const position = marker.getLatLng();
                            updateDistanceStatus(position.lat, position.lng);
                        });
                    }

                    updateDistanceStatus(lat, lng);
                });

                // Address Search using OpenStreetMap Nominatim
                async function searchAddress() {
                    const query = document.getElementById('search-address-input').value.trim();
                    if (!query) {
                        alert('Silakan masukkan kata kunci alamat terlebih dahulu.');
                        return;
                    }
                    
                    const btn = document.getElementById('btn-search-address');
                    const originalHtml = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i>';

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&accept-language=id&q=${encodeURIComponent(query)}&limit=1`);
                        const results = await response.json();
                        
                        if (results && results.length > 0) {
                            const lat = parseFloat(results[0].lat);
                            const lon = parseFloat(results[0].lon);
                            const displayName = results[0].display_name;

                            // Move map
                            map.setView([lat, lon], 16);

                            // Update marker
                            if (userMarker) {
                                userMarker.setLatLng([lat, lon]);
                            } else {
                                userMarker = L.marker([lat, lon], { draggable: true }).addTo(map);
                                userMarker.on('dragend', function(event) {
                                    const marker = event.target;
                                    const position = marker.getLatLng();
                                    updateDistanceStatus(position.lat, position.lng);
                                });
                            }

                            // Update address details textarea
                            document.getElementById('delivery-address').value = displayName;

                            // Update status & distance
                            updateDistanceStatus(lat, lon);
                        } else {
                            alert('Alamat tidak ditemukan. Silakan masukkan kata kunci alamat lainnya yang lebih spesifik.');
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Gagal mencari alamat. Silakan coba lagi.');
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    }
                }

                document.getElementById('btn-search-address').addEventListener('click', searchAddress);
                document.getElementById('search-address-input').addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchAddress();
                    }
                });

                // Get Current Location using GPS device
                document.getElementById('btn-gps-location').addEventListener('click', function() {
                    const btn = this;
                    const originalHtml = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin text-sm"></i> <span>Mengakses GPS Perangkat...</span>';

                    if (!navigator.geolocation) {
                        alert('Browser atau perangkat Anda tidak mendukung GPS otomatis.');
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lon = position.coords.longitude;

                            // Move map & focus
                            map.setView([lat, lon], 16);

                            // Update marker
                            if (userMarker) {
                                userMarker.setLatLng([lat, lon]);
                            } else {
                                userMarker = L.marker([lat, lon], { draggable: true }).addTo(map);
                                userMarker.on('dragend', function(event) {
                                    const marker = event.target;
                                    const position = marker.getLatLng();
                                    updateDistanceStatus(position.lat, position.lng);
                                });
                            }

                            // Get human-readable address reverse geocode
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&accept-language=id&lat=${lat}&lon=${lon}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (data && data.display_name) {
                                        document.getElementById('delivery-address').value = data.display_name;
                                    }
                                })
                                .catch(console.error);

                            updateDistanceStatus(lat, lon);
                            btn.disabled = false;
                            btn.innerHTML = originalHtml;
                        },
                        function(error) {
                            console.error(error);
                            let errMsg = 'Gagal mengakses GPS Anda.';
                            if (error.code === error.PERMISSION_DENIED) {
                                errMsg = 'Akses lokasi ditolak. Silakan aktifkan izin lokasi pada browser Anda.';
                            } else if (error.code === error.POSITION_UNAVAILABLE) {
                                errMsg = 'Sinyal/lokasi GPS perangkat Anda tidak tersedia.';
                            } else if (error.code === error.TIMEOUT) {
                                errMsg = 'Waktu permintaan lokasi GPS habis.';
                            }
                            alert(errMsg);
                            btn.disabled = false;
                            btn.innerHTML = originalHtml;
                        },
                        { enableHighAccuracy: true, timeout: 8000 }
                    );
                });
            }, 300);

            document.getElementById('btn-checkout')?.addEventListener('click', function () {
                const items = document.querySelectorAll('.ci');
                if (items.length === 0) {
                    alert('Keranjang belanja Anda kosong, silakan pilih menu terlebih dahulu.');
                    return;
                }
                if (!window.selectedCoords) {
                    alert('Silakan pilih lokasi pengiriman Anda pada peta terlebih dahulu.');
                    return;
                }
                if (!window.isInsideRadius) {
                    alert('Maaf, lokasi pengiriman berada di luar jangkauan radius 1.8 Km dari Cafe.');
                    return;
                }
                const addressDetails = document.getElementById('delivery-address').value.trim();
                if (!addressDetails) {
                    alert('Silakan tulis rincian alamat lengkap pengiriman Anda.');
                    return;
                }

                // Success
                alert('Pesanan hantaran Anda berhasil dikirim! Silakan siapkan pembayaran Anda.');
                
                // Clear Cart UI & form
                document.getElementById('cart-items').innerHTML = '';
                document.getElementById('delivery-address').value = '';
                if (userMarker) {
                    map.removeLayer(userMarker);
                    userMarker = null;
                }
                window.selectedCoords = null;
                window.isInsideRadius = false;
                
                const badge = document.getElementById('distance-badge');
                badge.className = "py-2.5 px-4 rounded-xl bg-gray-50 border border-gray-200 text-[11px] font-bold text-center text-gray-500 transition-all duration-300 flex items-center justify-center gap-1.5";
                badge.innerHTML = `<i class="bi bi-geo-alt"></i> <span>Ketuk pada peta untuk memilih lokasi</span>`;
                
                updateCartTotals();
            });

            // Initialize cart totals on page load
            updateCartTotals();
        });
    </script>
</body>

</html>