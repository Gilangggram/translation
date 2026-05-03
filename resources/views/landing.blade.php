<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="De Pallet Cafe - Modern cafe dengan sistem pemesanan digital. Pesan makanan, reservasi tempat, hingga pembayaran langsung dari genggamanmu.">
    <title>De Pallet Cafe - Modern Cafe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-manrope bg-landing-bg text-dark overflow-x-hidden">
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white/80 backdrop-blur-md shadow-[0_8px_32px_rgba(26,28,28,0.04)] h-[72px]" id="top-navigation">
        <div class="max-w-[1536px] mx-auto flex items-center justify-between px-8 py-4 h-[72px]">
            <div class="font-noto-serif font-black text-2xl leading-8 tracking-[-0.6px] text-dark whitespace-nowrap">De'Pallet Cafe</div>
            <div class="hidden md:flex items-center gap-0">
                <a href="{{ route('landing') }}" class="font-manrope {{ request()->routeIs('landing') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300" id="nav-home">Home</a>
                <a href="{{ route('delivery') }}" class="font-manrope {{ request()->routeIs('delivery') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300" id="nav-delivery">Delivery</a>
                <a href="{{ route('reservation') }}" class="font-manrope {{ request()->routeIs('reservation') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300" id="nav-reservation">Reservation</a>
                <a href="{{ route('dinein') }}" class="font-manrope {{ request()->routeIs('dinein') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5 transition-colors duration-300" id="nav-dinein">Dine-In</a>
            </div>
            <div class="hidden md:flex items-center">
                <div class="flex items-center gap-3 px-4 py-2 bg-secondary/5 rounded-full border border-secondary/10">
                    <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white">
                        <i class="bi bi-person"></i>
                    </div>
                    <span class="font-manrope font-bold text-sm text-secondary">Guest</span>
                </div>
            </div>
            <button class="md:hidden bg-transparent border-none text-2xl text-dark cursor-pointer" id="nav-mobile-toggle" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>
        </div>
        <div class="hidden flex-col bg-white/95 backdrop-blur-md px-8 py-4 pb-6 gap-3 shadow-md absolute w-full top-[72px]" id="nav-mobile-menu">
            <a href="{{ route('landing') }}" class="font-manrope {{ request()->routeIs('landing') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Home</a>
            <a href="{{ route('delivery') }}" class="font-manrope {{ request()->routeIs('delivery') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Delivery</a>
            <a href="{{ route('reservation') }}" class="font-manrope {{ request()->routeIs('reservation') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Reservation</a>
            <a href="{{ route('dinein') }}" class="font-manrope {{ request()->routeIs('dinein') ? 'font-bold text-secondary border-b-2 border-secondary pb-0' : 'font-medium text-neutral hover:text-secondary' }} text-base leading-6 tracking-[-0.4px] px-5">Dine-In</a>
            <div class="flex items-center gap-3 px-5 py-2 mt-2 bg-secondary/5 rounded-full border border-secondary/10 mx-5">
                <div class="w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-white">
                    <i class="bi bi-person"></i>
                </div>
                <span class="font-manrope font-bold text-sm text-secondary">Guest</span>
            </div>
        </div>
    </nav>

    <section class="w-full max-w-[1536px] mx-auto min-h-[800px] pt-[72px] px-8 flex flex-col lg:flex-row items-center relative gap-8" id="hero-section">
        <div class="flex-1 flex flex-col gap-8 max-w-[608px] pt-20">
            <div class="flex items-center px-4 py-1.5 bg-landing-surface rounded-xl w-fit gap-2">
                <span class="w-2 h-2 bg-secondary rounded-full shrink-0"></span>
                <span class="font-manrope font-bold text-xs leading-4 tracking-[1.2px] uppercase text-secondary">TRUSTED BY 500+ OUTLETS</span>
            </div>
            <div class="flex flex-col">
                <h1 class="flex flex-col">
                    <span class="font-noto-serif font-black text-[72px] leading-[72px] tracking-[-1.8px] text-dark">De Pallet Cafe</span>
                    <span class="font-noto-serif font-black text-[72px] leading-[72px] tracking-[-1.8px] text-secondary">Modern Cafe</span>
                </h1>
            </div>
            <p class="font-manrope font-normal text-xl leading-7 text-neutral max-w-[576px]">Berbagai hidangan enak akan kami sajikan untuk pelanggan kami tercinta</p>
            <div class="flex gap-4 pt-4 flex-wrap">
                <a href="#" class="font-manrope font-bold text-lg leading-7 text-white px-8 py-[17px] bg-gradient-to-r from-secondary to-primary rounded-md shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)] transition-all duration-300 text-center inline-flex items-center justify-center hover:-translate-y-0.5 hover:shadow-[0_36px_70px_-12px_rgba(26,28,28,0.16)]" id="btn-pesan-sekarang">Pesan Sekarang</a>
                <a href="#solution-section" class="font-manrope font-bold text-lg leading-7 text-secondary px-8 py-4 border-b-2 border-[rgba(83,46,28,0.2)] rounded-md transition-all duration-300 text-center inline-flex items-center justify-center hover:border-secondary hover:bg-[rgba(83,46,28,0.05)]" id="btn-lihat-lainnya">Lihat Lainnya</a>
            </div>
        </div>
        <div class="flex-1 max-w-[608px] relative mt-16 lg:mt-0">
            <div class="w-full lg:h-[720px] h-[400px] rounded-lg overflow-hidden shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)]">
                <img src="{{ asset('images/cafe-interior.png') }}" alt="Modern cafe interior" class="w-full h-full object-cover" loading="eager">
            </div>
            <div class="absolute -left-8 -bottom-8 bg-landing-bg rounded-lg p-6 flex flex-col gap-3 max-w-[170px] shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)] animate-[floatBadge_3s_ease-in-out_infinite]">
                <div class="w-[22.5px] h-[22.5px] text-secondary text-[20px] flex items-center">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div class="flex flex-col gap-0">
                    <span class="font-noto-serif font-bold text-base leading-6 text-dark">Fast</span>
                    <span class="font-manrope font-medium text-xs leading-4 text-neutral">Pesan jadi lebih cepat</span>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full max-w-[1536px] mx-auto px-8 pb-5 lg:pt-20 pt-32" id="solution-section">
        <div class="flex flex-col lg:flex-row gap-12 min-h-[580px]">
            <div class="flex-1 flex gap-6 max-w-[568px]">
                <div class="flex-1 flex flex-col gap-6 pt-12">
                    <div class="rounded-lg overflow-hidden shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)] solution-img-card">
                        <img src="{{ asset('images/cafe-customer.png') }}" alt="Cafe Customer" class="w-full h-[272px] object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                    </div>
                    <div class="rounded-lg p-8 flex flex-col gap-4 bg-landing-surface solution-info-card">
                        <i class="bi bi-credit-card-2-front text-[28px] text-secondary"></i>
                        <h4 class="font-noto-serif font-bold text-lg leading-7 text-dark">Pembayaran Instan</h4>
                    </div>
                </div>
                <div class="flex-1 flex flex-col gap-6">
                    <div class="rounded-lg p-8 flex flex-col gap-4 bg-secondary solution-info-card">
                        <i class="bi bi-qr-code-scan text-[28px] text-white"></i>
                        <h4 class="font-noto-serif font-bold text-lg leading-7 text-white">QR Order</h4>
                    </div>
                    <div class="rounded-lg overflow-hidden shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)] solution-img-card">
                        <img src="{{ asset('images/barista-working.png') }}" alt="Barista working" class="w-full h-[408px] object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="flex-1 flex flex-col gap-12 max-w-[568px] pt-12">
                <div>
                    <h2 class="font-noto-serif font-black text-4xl leading-10 text-dark mb-6">Nikmati Pengalaman Pesan Makanan Tanpa Ribet</h2>
                    <p class="font-manrope font-medium text-base leading-relaxed text-neutral">Pesan makanan, reservasi tempat, hingga pembayaran semua bisa kamu lakukan langsung dari genggamanmu, cepat dan praktis tanpa harus antre.</p>
                </div>
                <div class="flex flex-col gap-8">
                    <div class="flex gap-6 items-start feature-item">
                        <div class="w-10 h-10 min-w-[40px] bg-primary rounded-xl flex items-center justify-center font-manrope font-bold text-base text-secondary">1</div>
                        <div>
                            <h4 class="font-manrope font-bold text-xl leading-7 text-dark mb-1">QR Order & Reservasi</h4>
                            <p class="font-manrope font-normal text-sm leading-5 text-neutral">Cukup scan QR di meja, pilih menu favoritmu, dan pesanan langsung diproses tanpa perlu ke kasir.</p>
                        </div>
                    </div>
                    <div class="flex gap-6 items-start feature-item">
                        <div class="w-10 h-10 min-w-[40px] bg-primary rounded-xl flex items-center justify-center font-manrope font-bold text-base text-secondary">2</div>
                        <div>
                            <h4 class="font-manrope font-bold text-xl leading-7 text-dark mb-1">Payment Upload & Validation</h4>
                            <p class="font-manrope font-normal text-sm leading-5 text-neutral">Lakukan pembayaran dengan transfer, upload bukti, dan pesananmu akan langsung diverifikasi.</p>
                        </div>
                    </div>
                    <div class="flex gap-6 items-start feature-item">
                        <div class="w-10 h-10 min-w-[40px] bg-primary rounded-xl flex items-center justify-center font-manrope font-bold text-base text-secondary">3</div>
                        <div>
                            <h4 class="font-manrope font-bold text-xl leading-7 text-dark mb-1">Auto Routing</h4>
                            <p class="font-manrope font-normal text-sm leading-5 text-neutral">Pesananmu otomatis dikirim ke dapur dan diantar ke meja atau lokasi kamu tanpa ribet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full max-w-[1536px] mx-auto px-8 lg:mt-20 mt-10" id="features-section">
        <div class="flex flex-col md:flex-row gap-6 min-h-[316px] relative">
            <div class="rounded-lg relative overflow-hidden bg-primary p-8 flex flex-col gap-3 md:w-1/3 feature-card">
                <div class="absolute inset-0 bg-[rgba(255,255,255,0.002)] shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)] rounded-lg pointer-events-none"></div>
                <i class="bi bi-box-seam text-[25px] text-secondary"></i>
                <h3 class="font-noto-serif font-bold text-xl leading-7 text-secondary pt-3">Menu & Stock Mgmt</h3>
                <p class="font-manrope font-medium text-sm leading-[23px] text-secondary">Menu yang kamu lihat selalu up-to-date, jadi kamu nggak akan pesan makanan yang ternyata sudah habis.</p>
            </div>

            <div class="rounded-lg relative overflow-hidden bg-landing-bg shadow-[0_4px_4px_rgba(0,0,0,0.25)] p-8 flex flex-col md:flex-row items-center gap-8 flex-1 feature-card">
                <div class="absolute inset-0 bg-[rgba(255,255,255,0.002)] shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)] rounded-lg pointer-events-none"></div>
                <div class="flex-1">
                    <h3 class="font-noto-serif font-bold text-2xl leading-8 text-dark mb-3">Pantau Performa Cafe dengan Mudah</h3>
                    <p class="font-manrope font-normal text-sm leading-5 text-neutral">Setiap pesananmu ditangani oleh tim yang tepat mulai dari kasir, dapur, hingga pelayan—agar semuanya berjalan lancar tanpa kesalahan.</p>
                </div>
                <div class="w-[256px] h-[134px] min-w-[200px] bg-landing-surface rounded flex items-center justify-center">
                    <i class="bi bi-people text-[50px] text-[rgba(83,46,28,0.3)]"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="w-[calc(100%-64px)] max-w-[1472px] mx-auto my-20 bg-landing-surface rounded-lg lg:p-20 py-16 px-8 relative overflow-hidden flex items-center justify-center cta-content" id="cta-section">
        <div class="absolute w-[128px] h-[128px] left-0 top-0 bg-[rgba(83,46,28,0.05)] rounded-br-xl"></div>
        <div class="absolute w-[256px] h-[256px] right-0 bottom-0 bg-[rgba(159,173,199,0.1)] rounded-tl-xl"></div>
        <div class="relative z-10 flex flex-col items-center gap-8 max-w-[768px] text-center">
            <h2 class="font-noto-serif font-black md:text-[60px] text-[40px] md:leading-[60px] leading-[48px] text-dark">Tingkatkan Pengalaman Ngopi & Makanmu Hari Ini</h2>
            <p class="font-manrope font-medium text-lg leading-7 text-neutral">Nikmati cara baru pesan makanan yang lebih cepat, praktis, dan tanpa ribet.</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <a href="#" class="font-manrope font-bold text-lg leading-7 text-white px-8 py-[17px] bg-gradient-to-r from-secondary to-primary rounded-md shadow-[0_32px_64px_-12px_rgba(26,28,28,0.08)] transition-all duration-300 text-center inline-flex items-center justify-center hover:-translate-y-0.5 hover:shadow-[0_36px_70px_-12px_rgba(26,28,28,0.16)]" id="btn-get-started">Get Started Now</a>
                <a href="#" class="font-manrope font-bold text-lg leading-7 text-secondary px-10 py-4 bg-landing-bg rounded-md transition-all duration-300 text-center inline-flex items-center justify-center hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]" id="btn-contact-sales">Contact Sales</a>
            </div>
        </div>
    </section>

    <footer class="w-full bg-dark py-16 px-8" id="footer-section">
        <div class="max-w-[1536px] mx-auto flex flex-col items-center gap-10">
            <div class="font-noto-serif font-black text-[30px] leading-9 tracking-[-1.5px] text-landing-bg">De Pallet Cafe</div>
            <div class="flex gap-8 opacity-60 flex-wrap justify-center">
                <a href="#" class="font-manrope font-normal text-xs leading-4 tracking-[1.2px] uppercase text-landing-bg transition-opacity duration-300 hover:opacity-80">PRIVACY POLICY</a>
                <a href="#" class="font-manrope font-normal text-xs leading-4 tracking-[1.2px] uppercase text-landing-bg transition-opacity duration-300 hover:opacity-80">TERMS OF SERVICE</a>
                <a href="#" class="font-manrope font-normal text-xs leading-4 tracking-[1.2px] uppercase text-landing-bg transition-opacity duration-300 hover:opacity-80">COOKIES</a>
                <a href="#" class="font-manrope font-normal text-xs leading-4 tracking-[1.2px] uppercase text-landing-bg transition-opacity duration-300 hover:opacity-80">CONTACT SUPPORT</a>
            </div>
            <div class="font-manrope font-medium text-[10px] text-landing-bg uppercase tracking-[1.2px] opacity-40">
                &copy; 2026 ARTISAN CAFE SYSTEM. CRAFTED FOR EXCELLENCE.
            </div>
        </div>
    </footer>

    <script>
        const toggle = document.getElementById('nav-mobile-toggle');
        const mobileMenu = document.getElementById('nav-mobile-menu');
        if (toggle && mobileMenu) {
            toggle.addEventListener('click', () => {
                if(mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('flex');
                } else {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                }
                toggle.querySelector('i').classList.toggle('bi-list');
                toggle.querySelector('i').classList.toggle('bi-x-lg');
            });
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-item, .feature-card, .solution-img-card, .solution-info-card, .cta-content').forEach(el => {
            el.classList.add('animate-target');
            observer.observe(el);
        });
    </script>
</body>

</html>