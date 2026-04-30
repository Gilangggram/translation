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
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-fade-up {
            animation: fadeUp 0.5s ease both;
        }
        .animate-slide-right {
            animation: slideRight 0.5s ease 0.2s both;
        }
        .animate-fade-up-fast {
            animation: fadeUp 0.3s ease both;
        }
    </style>
</head>

<body class="font-manrope bg-delivery-bg text-dark overflow-x-hidden">
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white h-16 shadow-[0_1px_3px_rgba(0,0,0,0.04)]" id="delivery-navigation">
        <div class="max-w-[1440px] mx-auto flex items-center justify-between px-6 lg:px-10 h-16">
            <div class="font-noto-serif font-black text-xl text-dark whitespace-nowrap">De'Pallet <span class="text-primary">Cafe</span></div>
            <div class="hidden md:flex items-center">
                <a href="{{ route('landing') }}" class="font-manrope font-medium text-[15px] text-neutral py-5 px-6 transition-colors relative hover:text-dark" id="nav-menu">Menu</a>
                <a href="{{ route('delivery') }}" class="font-manrope font-bold text-[15px] text-dark py-5 px-6 transition-colors relative after:absolute after:bottom-0 after:left-6 after:right-6 after:h-[2px] after:bg-dark" id="nav-delivery">Delivery</a>
                <a href="#" class="font-manrope font-medium text-[15px] text-neutral py-5 px-6 transition-colors relative hover:text-dark" id="nav-reservation">Reservation</a>
                <a href="#" class="font-manrope font-medium text-[15px] text-neutral py-5 px-6 transition-colors relative hover:text-dark" id="nav-dinein">Dine-in</a>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center rounded-lg text-dark text-xl cursor-pointer bg-transparent border-none transition-colors relative hover:bg-delivery-bg" id="btn-cart" aria-label="Cart">
                    <i class="bi bi-bag"></i>
                    <span class="absolute top-1 right-1 w-4 h-4 bg-secondary text-white text-[10px] font-bold rounded-full flex items-center justify-center" id="cart-badge">2</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-lg text-dark text-xl cursor-pointer bg-transparent border-none transition-colors relative hover:bg-delivery-bg" id="btn-notifications" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                </button>
            </div>
            <button class="md:hidden bg-transparent border-none text-2xl text-dark cursor-pointer" id="del-mobile-toggle" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <div class="hidden flex-col bg-white px-10 py-4 pb-6 gap-2 shadow-[0_4px_12px_rgba(0,0,0,0.08)]" id="del-mobile-menu">
            <a href="{{ route('landing') }}" class="font-manrope font-medium text-[15px] text-neutral py-2 transition-colors hover:text-dark">Menu</a>
            <a href="{{ route('delivery') }}" class="font-manrope font-bold text-[15px] text-dark py-2 transition-colors">Delivery</a>
            <a href="#" class="font-manrope font-medium text-[15px] text-neutral py-2 transition-colors hover:text-dark">Reservation</a>
            <a href="#" class="font-manrope font-medium text-[15px] text-neutral py-2 transition-colors hover:text-dark">Dine-in</a>
        </div>
    </nav>

    <div class="flex flex-col lg:flex-row max-w-[1440px] mx-auto pt-[104px] lg:pt-[88px] px-6 lg:px-10 pb-10 gap-8 min-h-screen">
        <div class="flex-1 min-w-0">
            <div class="mb-7" id="delivery-header">
                <h1 class="font-noto-serif font-black text-4xl leading-[44px] text-dark mb-3">Hantaran Nusantara</h1>
                <p class="font-manrope font-normal text-[15px] leading-6 text-neutral max-w-[520px]">Cita rasa warisan dari dapur kami langsung ke depan pintu Anda.
                    Nikmati kelezatan masakan tradisional yang diolah dengan rempah pilihan.</p>
            </div>

            <div class="flex gap-2.5 mb-7 overflow-x-auto pb-1 scrollbar-hide" id="delivery-categories">
                <button class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-secondary border-secondary text-white" data-category="all">Semua Menu</button>
                <button class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary" data-category="nasi">Nasi Nusantara</button>
                <button class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary" data-category="sate">Sate & Bakaran</button>
                <button class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary" data-category="lauk">Lauk Pauk</button>
                <button class="cat-btn font-manrope font-bold text-[11px] tracking-[0.8px] uppercase py-2.5 px-5 rounded-[24px] border-[1.5px] cursor-pointer whitespace-nowrap transition-all duration-300 bg-transparent border-delivery-border text-neutral hover:border-secondary hover:text-secondary" data-category="minuman">Minuman</button>
            </div>

            <div class="grid grid-cols-[repeat(auto-fill,minmax(220px,1fr))] lg:grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-5 mb-8" id="menu-grid">

                <div class="md:col-span-2 lg:col-span-2 md:row-span-1 lg:row-span-2 bg-delivery-card rounded-2xl overflow-hidden flex flex-col md:flex-row lg:flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_16px_48px_rgba(83,46,28,0.12)] group animate-fade-up mc-feat" data-menu-id="1" data-category="nasi">
                    <div class="h-auto md:min-h-[240px] lg:h-[320px] w-full md:w-[280px] lg:w-[calc(100%-24px)] overflow-hidden rounded-xl m-3 shrink-0">
                        <img src="{{ asset('images/nasi-goreng-wagyu.png') }}" alt="Nasi Goreng Wagyu" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="eager">
                    </div>
                    <div class="p-5 pt-0 md:py-5 md:pr-6 md:pl-0 lg:p-5 lg:px-6 lg:pb-6 flex-1 flex flex-col">
                        <div class="font-manrope font-bold text-[10px] tracking-[1.2px] uppercase text-secondary mb-1.5">Stall Nasi Nusantara</div>
                        <div class="font-noto-serif font-extrabold text-[28px] leading-[34px] text-dark mb-2">Nasi Goreng Wagyu</div>
                        <div class="flex items-baseline gap-1 mb-4">
                            <span class="font-semibold text-sm text-secondary">Rp</span>
                            <span class="font-noto-serif font-extrabold text-2xl text-secondary">75.000</span>
                        </div>
                        <button class="btn-tambah font-manrope font-bold text-xs tracking-[1px] uppercase py-3 px-7 bg-secondary text-white border-none rounded-lg cursor-pointer w-fit transition-all duration-300 hover:bg-[#3d2214] hover:-translate-y-[1px]" data-menu-id="1" data-name="Nasi Goreng Wagyu" data-price="75000">
                            Tambah
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_36px_rgba(83,46,28,0.10)] group animate-fade-up mc" style="animation-delay: 0.05s" data-menu-id="2" data-category="sate">
                    <div class="w-[calc(100%-20px)] h-[160px] overflow-hidden rounded-xl mt-2.5 mx-2.5 shrink-0">
                        <img src="{{ asset('images/sate-ayam-madura.png') }}" alt="Sate Ayam Madura" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    </div>
                    <div class="px-4 pt-[14px] pb-4 flex-1 flex flex-col">
                        <div class="font-bold text-[15px] leading-5 text-dark mb-0.5">Sate Ayam Madura</div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="font-semibold text-xs text-secondary">Rp</span>
                            <span class="font-bold text-base text-secondary">45.000</span>
                        </div>
                        <p class="text-xs leading-[18px] text-neutral mb-3.5 flex-1 line-clamp-3">10 tusuk sate ayam pilihan dengan bumbu kacang kental</p>
                        <button class="btn-pilih font-manrope font-bold text-xs tracking-[0.8px] uppercase py-2.5 bg-transparent text-dark border-[1.5px] border-delivery-border rounded-lg cursor-pointer w-full text-center transition-all duration-300 hover:border-secondary hover:bg-secondary hover:text-white" data-menu-id="2" data-name="Sate Ayam Madura" data-price="45000">
                            Pilih
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_36px_rgba(83,46,28,0.10)] group animate-fade-up mc" style="animation-delay: 0.1s" data-menu-id="3" data-category="lauk">
                    <div class="w-[calc(100%-20px)] h-[160px] overflow-hidden rounded-xl mt-2.5 mx-2.5 shrink-0">
                        <img src="{{ asset('images/rendang-minang.png') }}" alt="Rendang Minang" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    </div>
                    <div class="px-4 pt-[14px] pb-4 flex-1 flex flex-col">
                        <div class="font-bold text-[15px] leading-5 text-dark mb-0.5">Rendang Minang</div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="font-semibold text-xs text-secondary">Rp</span>
                            <span class="font-bold text-base text-secondary">65.000</span>
                        </div>
                        <p class="text-xs leading-[18px] text-neutral mb-3.5 flex-1 line-clamp-3">Daging sapi yang dimasak perlahan dengan santan dan rempah pilihan</p>
                        <button class="btn-pilih font-manrope font-bold text-xs tracking-[0.8px] uppercase py-2.5 bg-transparent text-dark border-[1.5px] border-delivery-border rounded-lg cursor-pointer w-full text-center transition-all duration-300 hover:border-secondary hover:bg-secondary hover:text-white" data-menu-id="3" data-name="Rendang Minang" data-price="65000">
                            Pilih
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_36px_rgba(83,46,28,0.10)] group animate-fade-up mc" style="animation-delay: 0.15s" data-menu-id="4" data-category="lauk">
                    <div class="w-[calc(100%-20px)] h-[160px] overflow-hidden rounded-xl mt-2.5 mx-2.5 shrink-0">
                        <img src="{{ asset('images/gado-gado-siram.png') }}" alt="Gado-Gado Siram" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    </div>
                    <div class="px-4 pt-[14px] pb-4 flex-1 flex flex-col">
                        <div class="font-bold text-[15px] leading-5 text-dark mb-0.5">Gado-Gado Siram</div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="font-semibold text-xs text-secondary">Rp</span>
                            <span class="font-bold text-base text-secondary">35.000</span>
                        </div>
                        <p class="text-xs leading-[18px] text-neutral mb-3.5 flex-1 line-clamp-3">Sayuran segar kukus dengan siraman bumbu kacang khas...</p>
                        <button class="btn-pilih font-manrope font-bold text-xs tracking-[0.8px] uppercase py-2.5 bg-transparent text-dark border-[1.5px] border-delivery-border rounded-lg cursor-pointer w-full text-center transition-all duration-300 hover:border-secondary hover:bg-secondary hover:text-white" data-menu-id="4" data-name="Gado-Gado Siram" data-price="35000">
                            Pilih
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_36px_rgba(83,46,28,0.10)] group animate-fade-up mc" style="animation-delay: 0.2s" data-menu-id="5" data-category="minuman">
                    <div class="w-[calc(100%-20px)] h-[160px] overflow-hidden rounded-xl mt-2.5 mx-2.5 shrink-0">
                        <img src="{{ asset('images/es-cendol-durian.png') }}" alt="Es Cendol Durian" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    </div>
                    <div class="px-4 pt-[14px] pb-4 flex-1 flex flex-col">
                        <div class="font-bold text-[15px] leading-5 text-dark mb-0.5">Es Cendol Durian</div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="font-semibold text-xs text-secondary">Rp</span>
                            <span class="font-bold text-base text-secondary">25.000</span>
                        </div>
                        <p class="text-xs leading-[18px] text-neutral mb-3.5 flex-1 line-clamp-3">Minuman segar pandan, santan, dan gula aren dengan durian</p>
                        <button class="btn-pilih font-manrope font-bold text-xs tracking-[0.8px] uppercase py-2.5 bg-transparent text-dark border-[1.5px] border-delivery-border rounded-lg cursor-pointer w-full text-center transition-all duration-300 hover:border-secondary hover:bg-secondary hover:text-white" data-menu-id="5" data-name="Es Cendol Durian" data-price="25000">
                            Pilih
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <aside class="w-full lg:w-[340px] shrink-0 static lg:sticky lg:top-[88px] self-start lg:max-h-[calc(100vh-112px)] overflow-y-auto" id="delivery-sidebar">
            <div class="bg-white rounded-2xl py-7 px-6 shadow-[0_4px_24px_rgba(0,0,0,0.04)] animate-slide-right" id="order-summary">
                <h2 class="font-noto-serif font-extrabold text-xl text-dark mb-6">Ringkasan Pesanan</h2>
                <div class="flex flex-col gap-4 mb-6 pb-6 border-b border-delivery-border" id="cart-items">
                    <div class="flex gap-3 items-start animate-fade-up-fast ci" data-cart-id="1">
                        <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0">
                            <img src="{{ asset('images/nasi-goreng-wagyu.png') }}" alt="Nasi Goreng Wagyu" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-dark mb-1.5">Nasi Goreng Wagyu</div>
                            <div class="flex items-center gap-2">
                                <button class="w-7 h-7 rounded-md border-[1.5px] border-delivery-border bg-transparent flex items-center justify-center cursor-pointer text-sm font-semibold text-dark transition-all duration-200 hover:bg-delivery-bg hover:border-secondary qty-minus" aria-label="Kurangi">−</button>
                                <span class="font-bold text-sm text-dark min-w-[16px] text-center qty-val">1</span>
                                <button class="w-7 h-7 rounded-md border-[1.5px] border-delivery-border bg-transparent flex items-center justify-center cursor-pointer text-sm font-semibold text-dark transition-all duration-200 hover:bg-delivery-bg hover:border-secondary qty-plus" aria-label="Tambah">+</button>
                                <button class="font-manrope font-semibold text-[11px] tracking-[0.5px] uppercase text-neutral cursor-pointer bg-transparent border-none ml-2 transition-colors duration-200 hover:text-[#c0392b] ci-remove">Hapus</button>
                            </div>
                        </div>
                        <div class="font-bold text-sm text-dark whitespace-nowrap shrink-0 pt-0.5 ci-price">Rp 75.000</div>
                    </div>

                    <div class="flex gap-3 items-start animate-fade-up-fast ci" data-cart-id="2">
                        <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0">
                            <img src="{{ asset('images/sate-ayam-madura.png') }}" alt="Sate Ayam Madura" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-dark mb-1.5">Sate Ayam Madura</div>
                            <div class="flex items-center gap-2">
                                <button class="w-7 h-7 rounded-md border-[1.5px] border-delivery-border bg-transparent flex items-center justify-center cursor-pointer text-sm font-semibold text-dark transition-all duration-200 hover:bg-delivery-bg hover:border-secondary qty-minus" aria-label="Kurangi">−</button>
                                <span class="font-bold text-sm text-dark min-w-[16px] text-center qty-val">1</span>
                                <button class="w-7 h-7 rounded-md border-[1.5px] border-delivery-border bg-transparent flex items-center justify-center cursor-pointer text-sm font-semibold text-dark transition-all duration-200 hover:bg-delivery-bg hover:border-secondary qty-plus" aria-label="Tambah">+</button>
                                <button class="font-manrope font-semibold text-[11px] tracking-[0.5px] uppercase text-neutral cursor-pointer bg-transparent border-none ml-2 transition-colors duration-200 hover:text-[#c0392b] ci-remove">Hapus</button>
                            </div>
                        </div>
                        <div class="font-bold text-sm text-dark whitespace-nowrap shrink-0 pt-0.5 ci-price">Rp 45.000</div>
                    </div>
                </div>

                <div class="flex flex-col gap-2.5 mb-6" id="order-totals">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral">Subtotal</span>
                        <span class="font-semibold text-sm text-dark" id="subtotal">Rp 120.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral">Biaya Kirim Spesial</span>
                        <span class="font-semibold text-sm text-dark" id="shipping-cost">Rp 15.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-3.5 border-t border-delivery-border mt-1">
                        <span class="font-bold text-base text-dark">Total</span>
                        <span class="font-extrabold text-xl text-secondary" id="order-total">Rp 135.000</span>
                    </div>
                </div>

                <button class="w-full p-4 bg-gradient-to-r from-secondary to-primary text-white font-manrope font-bold text-sm tracking-[1px] uppercase border-none rounded-xl cursor-pointer transition-all duration-300 mb-4 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(83,46,28,0.25)]" id="btn-checkout">
                    Lanjut ke Pembayaran
                </button>
                <div class="flex items-center gap-3.5 p-4 border-[1.5px] border-delivery-border rounded-xl">
                    <div class="w-10 h-10 flex items-center justify-center text-[22px] text-secondary">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-[10px] tracking-[0.8px] uppercase text-neutral mb-0.5">Estimasi Kedatangan</div>
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
                    if(mobileMenu.classList.contains('hidden')) {
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

            document.querySelectorAll('.qty-minus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const valEl = this.nextElementSibling;
                    let val = parseInt(valEl.textContent);
                    if (val > 1) {
                        valEl.textContent = val - 1;
                        updateCartTotals();
                    }
                });
            });

            document.querySelectorAll('.qty-plus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const valEl = this.previousElementSibling;
                    let val = parseInt(valEl.textContent);
                    valEl.textContent = val + 1;
                    updateCartTotals();
                });
            });

            document.querySelectorAll('.ci-remove').forEach(btn => {
                btn.addEventListener('click', function () {
                    const cartItem = this.closest('.ci');
                    cartItem.style.opacity = '0';
                    cartItem.style.transform = 'translateX(20px)';
                    cartItem.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        cartItem.remove();
                        updateCartTotals();
                        updateCartBadge();
                    }, 300);
                });
            });

            document.querySelectorAll('.btn-tambah, .btn-pilih').forEach(btn => {
                btn.addEventListener('click', function () {
                    const name = this.dataset.name;
                    const price = parseInt(this.dataset.price);
                    const menuId = this.dataset.menuId;

                    this.textContent = '✓ Ditambahkan';
                    this.style.background = '#2d7a4f';
                    this.style.color = 'white';
                    setTimeout(() => {
                        this.textContent = this.classList.contains('btn-tambah') ? 'Tambah' : 'Pilih';
                        this.style.background = '';
                        this.style.color = '';
                    }, 1200);

                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                        badge.textContent = parseInt(badge.textContent) + 1;
                        badge.style.display = 'flex';
                    }
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

                const shipping = items.length > 0 ? 15000 : 0;
                const total = subtotal + shipping;

                document.getElementById('subtotal').textContent = formatRupiah(subtotal);
                document.getElementById('shipping-cost').textContent = formatRupiah(shipping);
                document.getElementById('order-total').textContent = formatRupiah(total);
            }

            function updateCartBadge() {
                const items = document.querySelectorAll('.ci');
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.textContent = items.length;
                    badge.style.display = items.length > 0 ? 'flex' : 'none';
                }
            }

            document.getElementById('btn-checkout')?.addEventListener('click', function () {
                alert('Fitur pembayaran akan segera tersedia!');
            });
        });
    </script>
</body>

</html>