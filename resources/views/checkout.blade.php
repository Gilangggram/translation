<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - De'Pallet Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=Noto+Serif:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .bank-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bank-card.active {
            border-color: #725B38;
            background-color: #FAF2ED;
            box-shadow: 0 4px 12px rgba(114, 91, 56, 0.08);
        }
    </style>
</head>

<body class="font-manrope bg-[#FAF6F3] min-h-screen text-[#1E1B18] overflow-x-hidden flex flex-col">

    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white/80 backdrop-blur-md shadow-[0_8px_32px_rgba(26,28,28,0.04)] h-[72px]">
        <div class="max-w-[1536px] mx-auto flex items-center justify-between px-8 py-4 h-[72px]">
            <div class="font-noto-serif font-black text-2xl leading-8 tracking-[-0.6px] text-[#1E1B18] whitespace-nowrap">
                De'Pallet Cafe
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dinein') }}{{ $table ? '?table=' . $table->table_number : '' }}"
                    class="font-manrope font-semibold text-sm text-[#725B38] hover:text-[#532E1C] transition-colors flex items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Menu
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full max-w-[1280px] mx-auto flex-1 flex flex-col lg:flex-row gap-8 pt-[110px] px-4 md:px-8 pb-16 relative">
        
        <!-- Checkout Form Section (Left Column) -->
        <div class="flex-1 flex flex-col gap-6">
            <div class="bg-white border border-[#D1C5B8] rounded-xl p-6 md:p-8 shadow-sm flex flex-col gap-6">
                <div>
                    <span class="text-xs font-bold text-[#725B38] tracking-[1.5px] uppercase">PENGISIAN DATA</span>
                    <h1 class="font-noto-serif font-bold text-2xl md:text-3xl text-[#1E1B18] mt-1">Konfirmasi Pesanan</h1>
                </div>

                <form id="checkout-form" class="flex flex-col gap-6">
                    <!-- Name Input -->
                    <div class="flex flex-col gap-2">
                        <label for="name" class="font-manrope font-bold text-xs text-[#4D463C] uppercase tracking-[0.5px]">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap Anda"
                            value="{{ session('reservation.name', '') }}"
                            class="w-full border border-[#D1C5B8] rounded-lg p-3.5 font-manrope text-sm bg-[#FAF2ED]/10 focus:outline-none focus:border-[#725B38] focus:bg-white transition-all">
                    </div>

                    <!-- Phone Number Input -->
                    <div class="flex flex-col gap-2">
                        <label for="phone_number" class="font-manrope font-bold text-xs text-[#4D463C] uppercase tracking-[0.5px]">Nomor Telepon (WhatsApp) *</label>
                        <input type="tel" id="phone_number" name="phone_number" required placeholder="Contoh: 081234567890"
                            value="{{ session('reservation.phone_number', '') }}"
                            class="w-full border border-[#D1C5B8] rounded-lg p-3.5 font-manrope text-sm bg-[#FAF2ED]/10 focus:outline-none focus:border-[#725B38] focus:bg-white transition-all">
                    </div>

                    <!-- Email Input -->
                    <div class="flex flex-col gap-2">
                        <label for="email" class="font-manrope font-bold text-xs text-[#4D463C] uppercase tracking-[0.5px]">Email *</label>
                        <input type="email" id="email" name="email" required placeholder="Contoh: nama@email.com"
                            value="{{ session('reservation.email', '') }}"
                            class="w-full border border-[#D1C5B8] rounded-lg p-3.5 font-manrope text-sm bg-[#FAF2ED]/10 focus:outline-none focus:border-[#725B38] focus:bg-white transition-all">
                    </div>

                    <!-- Table Number (Automatic or Selectable) -->
                    <div class="flex flex-col gap-2">
                        <label class="font-manrope font-bold text-xs text-[#4D463C] uppercase tracking-[0.5px]">Nomor Meja *</label>
                        @if($table)
                            <div class="flex items-center gap-3 bg-[#FAF2ED] border border-[#725B38]/30 rounded-lg p-4">
                                <div class="w-10 h-10 rounded-full bg-[#725B38] text-white flex items-center justify-center text-lg shadow-sm">
                                    <i class="bi bi-qr-code-scan"></i>
                                </div>
                                <div>
                                    @if(session()->has('reservation'))
                                        <span class="font-manrope text-xs text-[#7B7672] block">Nomor Meja Anda (Reservasi)</span>
                                    @else
                                        <span class="font-manrope text-xs text-[#7B7672] block">Nomor Meja Anda (Scan QR)</span>
                                    @endif
                                    <strong class="font-noto-serif text-lg text-[#532E1C]">Meja {{ $table->table_number }}</strong>
                                </div>
                                <input type="hidden" id="table_number" name="table_number" value="{{ $table->table_number }}">
                            </div>
                        @else
                            <div class="relative">
                                <select id="table_number" name="table_number" required
                                    class="w-full border border-[#D1C5B8] rounded-lg p-3.5 font-manrope text-sm bg-[#FAF2ED]/10 appearance-none focus:outline-none focus:border-[#725B38] focus:bg-white transition-all">
                                    <option value="" disabled selected>Pilih Nomor Meja Anda</option>
                                    @foreach($tables as $t)
                                        <option value="{{ $t->table_number }}">Meja {{ $t->table_number }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-500">
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Bank Transfer Selection -->
                    <div class="flex flex-col gap-3">
                        <label class="font-manrope font-bold text-xs text-[#4D463C] uppercase tracking-[0.5px]">Metode Pembayaran (Transfer Bank) *</label>
                        <input type="hidden" id="payment_method" name="payment_method" value="BCA">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- BCA Card -->
                            <div onclick="selectBank('BCA')" id="bank-card-BCA"
                                class="bank-card active border border-[#D1C5B8] rounded-lg p-4 flex flex-col justify-between cursor-pointer hover:border-[#725B38] h-[100px]">
                                <div class="flex items-center justify-between">
                                    <span class="font-manrope font-extrabold text-[#1E1B18] tracking-wide text-lg">BCA</span>
                                    <i id="check-BCA" class="bi bi-check-circle-fill text-[#725B38] text-lg"></i>
                                </div>
                                <span class="text-[10px] text-[#7B7672] font-semibold tracking-[0.5px] uppercase">Transfer Manual</span>
                            </div>

                            <!-- Mandiri Card -->
                            <div onclick="selectBank('Mandiri')" id="bank-card-Mandiri"
                                class="bank-card border border-[#D1C5B8] rounded-lg p-4 flex flex-col justify-between cursor-pointer hover:border-[#725B38] h-[100px]">
                                <div class="flex items-center justify-between">
                                    <span class="font-manrope font-extrabold text-[#1E1B18] tracking-wide text-lg">Mandiri</span>
                                    <i id="check-Mandiri" class="bi bi-circle text-gray-300 text-lg"></i>
                                </div>
                                <span class="text-[10px] text-[#7B7672] font-semibold tracking-[0.5px] uppercase">Transfer Manual</span>
                            </div>

                            <!-- BRI Card -->
                            <div onclick="selectBank('BRI')" id="bank-card-BRI"
                                class="bank-card border border-[#D1C5B8] rounded-lg p-4 flex flex-col justify-between cursor-pointer hover:border-[#725B38] h-[100px]">
                                <div class="flex items-center justify-between">
                                    <span class="font-manrope font-extrabold text-[#1E1B18] tracking-wide text-lg">BRI</span>
                                    <i id="check-BRI" class="bi bi-circle text-gray-300 text-lg"></i>
                                </div>
                                <span class="text-[10px] text-[#7B7672] font-semibold tracking-[0.5px] uppercase">Transfer Manual</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary Column (Right Column) -->
        <div class="w-full lg:w-[400px] shrink-0 flex flex-col gap-6">
            <div class="bg-white border border-[#D1C5B8] rounded-xl shadow-md overflow-hidden flex flex-col sticky top-[100px]">
                <!-- Header -->
                <div class="p-6 border-b border-[#E8E1DC] bg-[#FAF6F3]">
                    <div class="flex items-center gap-3">
                        <div class="w-[18px] h-[20px] bg-[#80543F]"></div>
                        <h2 class="font-noto-serif font-bold text-xl text-[#1E1B18]">Ringkasan Pesanan</h2>
                    </div>
                </div>

                <!-- Items list -->
                <div id="checkout-items" class="p-6 flex flex-col gap-4 max-h-[320px] overflow-y-auto border-b border-[#E8E1DC]">
                    <!-- Injected dynamically by JS -->
                </div>

                <!-- Price Summary -->
                <div class="p-6 flex flex-col gap-4 bg-[#FAF6F3]/50">
                    <div class="flex flex-col gap-2.5 text-sm">
                        <div class="flex justify-between items-center text-[#4D463C]">
                            <span>Subtotal</span>
                            <span id="subtotal-val" class="font-medium text-[#1E1B18]">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-[#D1C5B8]">
                        <span class="font-noto-serif font-bold text-lg text-[#1E1B18]">Total Pembayaran</span>
                        <span id="total-val" class="font-noto-serif font-extrabold text-2xl text-[#725B38]">Rp 0</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="button" id="submit-order-btn" onclick="submitOrder()"
                        class="w-full py-4 mt-2 bg-[#725B38] hover:bg-[#532E1C] text-white font-manrope font-bold text-sm tracking-[1.2px] uppercase rounded transition-all shadow-[0_4px_12px_rgba(83,46,28,0.15)] flex items-center justify-center gap-2">
                        <span>CEKOT SEKARANG</span> <i class="bi bi-chevron-right"></i>
                    </button>
                    
                    <p class="font-manrope font-normal text-[10px] text-[#7B7672] text-center uppercase mt-1">
                        Selesaikan pembayaran setelah order dikirim
                    </p>
                </div>
            </div>
        </div>

    </main>

    <!-- Error Alert Toast -->
    <div id="toast" class="hidden fixed bottom-6 right-6 z-[1000] max-w-md bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl shadow-lg items-center gap-3">
        <i class="bi bi-exclamation-circle-fill text-xl"></i>
        <div id="toast-message" class="text-sm font-semibold">Terdapat kesalahan. Silakan coba lagi.</div>
    </div>

    <!-- Spinner Backdrop -->
    <div id="spinner" class="hidden fixed inset-0 bg-black/45 backdrop-blur-sm z-[9999] flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 flex flex-col items-center gap-4 shadow-2xl">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-[#725B38] border-t-transparent"></div>
            <span class="font-manrope font-bold text-sm text-[#1E1B18] uppercase tracking-[1px]">Memproses Pesanan Anda...</span>
        </div>
    </div>

    <script>
        let cart = [];

        // Check if cart is stored in sessionStorage
        window.addEventListener('load', () => {
            const storedCart = sessionStorage.getItem('depallet_cart');
            if (storedCart) {
                cart = JSON.parse(storedCart);
            }

            if (cart.length === 0) {
                // If cart is empty, redirect back to dinein menu
                alert('Keranjang belanja Anda kosong, silakan pilih menu terlebih dahulu.');
                window.location.href = "{{ route('dinein') }}{{ $table ? '?table=' . $table->table_number : '' }}";
                return;
            }

            renderCartSummary();
        });

        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);
        }

        function renderCartSummary() {
            const itemsContainer = document.getElementById('checkout-items');
            const subtotalEl = document.getElementById('subtotal-val');
            const totalEl = document.getElementById('total-val');

            itemsContainer.innerHTML = '';
            let subtotal = 0;

            cart.forEach(item => {
                subtotal += item.price * item.quantity;

                const itemEl = document.createElement('div');
                itemEl.className = 'flex justify-between items-start gap-4';
                itemEl.innerHTML = `
                    <div class="flex flex-col">
                        <strong class="font-manrope font-semibold text-sm text-[#1E1B18]">${item.name}</strong>
                        <span class="text-xs text-[#7B7672]">${item.quantity} x ${formatPrice(item.price)}</span>
                    </div>
                    <span class="font-manrope font-bold text-sm text-[#1E1B18]">${formatPrice(item.price * item.quantity)}</span>
                `;
                itemsContainer.appendChild(itemEl);
            });

            const total = subtotal;

            subtotalEl.innerText = formatPrice(subtotal);
            totalEl.innerText = formatPrice(total);
        }

        // Bank selection handler
        function selectBank(bankName) {
            document.getElementById('payment_method').value = bankName;

            // Remove active classes from all cards
            document.querySelectorAll('.bank-card').forEach(card => {
                card.classList.remove('active');
            });
            document.querySelectorAll('.bank-card i').forEach(icon => {
                icon.className = 'bi bi-circle text-gray-300 text-lg';
            });

            // Set active class to chosen bank card
            document.getElementById('bank-card-' + bankName).classList.add('active');
            document.getElementById('check-' + bankName).className = 'bi bi-check-circle-fill text-[#725B38] text-lg';
        }

        // Submit form via fetch
        async function submitOrder() {
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone_number').value.trim();
            const email = document.getElementById('email').value.trim();
            const tableNum = document.getElementById('table_number').value;
            const paymentMethod = document.getElementById('payment_method').value;

            if (!name || !phone || !email || !tableNum) {
                showToast('Silakan isi Nama Lengkap, Nomor Telepon, Email, dan Nomor Meja Anda.');
                return;
            }

            if (!email.includes('@')) {
                showToast('Silakan masukkan format email yang valid.');
                return;
            }

            // Show loading spinner
            document.getElementById('spinner').classList.remove('hidden');

            try {
                // Map cart items format to controller request structure
                const formattedCartItems = cart.map(item => ({
                    name: item.name,
                    quantity: item.quantity,
                    notes: item.notes || null
                }));

                const payload = {
                    name: name,
                    phone_number: phone,
                    email: email,
                    table_number: tableNum,
                    payment_method: paymentMethod,
                    cart_items: formattedCartItems
                };

                const response = await fetch("{{ route('dinein.checkout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Terjadi kesalahan saat memproses pesanan.');
                }

                // Success! Clear cart from sessionStorage and redirect
                sessionStorage.removeItem('depallet_cart');
                window.location.href = data.redirect_url;

            } catch (err) {
                document.getElementById('spinner').classList.add('hidden');
                showToast(err.message);
            }
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').innerText = message;
            toast.classList.remove('hidden');
            toast.classList.add('flex');

            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 5000);
        }
    </script>
</body>

</html>
