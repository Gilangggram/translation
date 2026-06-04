<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan - De'Pallet Cafe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=Noto+Serif:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="font-manrope bg-[#FAF6F3] min-h-screen text-[#1E1B18] overflow-x-hidden flex flex-col">

    <!-- Top Navigation -->
    <nav
        class="fixed top-0 left-0 right-0 z-[100] bg-white/80 backdrop-blur-md shadow-[0_8px_32px_rgba(26,28,28,0.04)] h-[72px]">
        <div class="max-w-[1536px] mx-auto flex items-center justify-between px-8 py-4 h-[72px]">
            <div
                class="font-noto-serif font-black text-2xl leading-8 tracking-[-0.6px] text-[#1E1B18] whitespace-nowrap">
                De'Pallet Cafe
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}"
                    class="font-manrope font-medium text-sm text-[#7B7672] hover:text-[#532E1C] transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full max-w-[800px] mx-auto flex-1 flex flex-col gap-8 pt-[110px] px-4 md:px-8 pb-16">

        <!-- Status Card -->
        <div class="bg-white border border-[#D1C5B8] rounded-xl p-6 md:p-8 shadow-sm flex flex-col gap-6">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#E8E1DC] pb-6">
                <div>
                    <span class="text-xs font-bold text-[#725B38] tracking-[1.5px] uppercase">STATUS PESANAN</span>
                    <h1 class="font-noto-serif font-bold text-2xl md:text-3xl text-[#1E1B18] mt-1">
                        {{ $order->order_number }}
                    </h1>
                </div>

                <div class="flex items-center">
                    @if($order->payment_status === 'paid')
                        <span
                            class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-bold text-sm flex items-center gap-2">
                            <i class="bi bi-patch-check-fill"></i> TERVALIDASI / DIPROSES
                        </span>
                    @elseif($order->payment_status === 'cancelled')
                        <span
                            class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold text-sm flex items-center gap-2">
                            <i class="bi bi-x-circle-fill"></i> DIBATALKAN
                        </span>
                    @elseif($order->payment_proof)
                        <span
                            class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-bold text-sm flex items-center gap-2">
                            <i class="bi bi-hourglass-split"></i> MENUNGGU VERIFIKASI
                        </span>
                    @else
                        <span
                            class="px-4 py-2 bg-[#725B38]/10 text-[#725B38] rounded-full font-bold text-sm flex items-center gap-2">
                            <i class="bi bi-wallet2"></i> MENUNGGU PEMBAYARAN
                        </span>
                    @endif
                </div>
            </div>

            <!-- Progress Tracker -->
            <div class="grid grid-cols-4 gap-2 relative mt-2">
                <!-- Line background -->
                <div class="absolute top-[18px] left-[12%] right-[12%] h-1 bg-gray-200 z-0"></div>
                <div class="absolute top-[18px] left-[12%] h-1 bg-[#725B38] z-0 transition-all duration-500"
                    style="width: @if($order->payment_status === 'paid') 76% @elseif($order->payment_proof) 50% @else 25% @endif">
                </div>

                <!-- Step 1: Created -->
                <div class="flex flex-col items-center text-center z-10">
                    <div
                        class="w-10 h-10 rounded-full bg-[#725B38] text-white flex items-center justify-center font-bold shadow-sm">
                        <i class="bi bi-file-earmark-plus"></i>
                    </div>
                    <span class="text-[10px] md:text-xs font-bold text-[#1E1B18] mt-2 uppercase">Dibuat</span>
                </div>
                <!-- Step 2: Pay -->
                <div class="flex flex-col items-center text-center z-10">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-sm transition-all duration-300
                         {{ $order->payment_proof || $order->payment_status === 'paid' ? 'bg-[#725B38] text-white' : 'bg-[#EEE7E2] text-[#7B7672]' }}">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold {{ $order->payment_proof || $order->payment_status === 'paid' ? 'text-[#1E1B18]' : 'text-[#7B7672]' }} mt-2 uppercase">Bayar</span>
                </div>
                <!-- Step 3: Verification -->
                <div class="flex flex-col items-center text-center z-10">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-sm transition-all duration-300
                         {{ $order->payment_proof || $order->payment_status === 'paid' ? 'bg-[#725B38] text-white' : 'bg-[#EEE7E2] text-[#7B7672]' }}">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold {{ $order->payment_proof || $order->payment_status === 'paid' ? 'text-[#1E1B18]' : 'text-[#7B7672]' }} mt-2 uppercase">Verifikasi</span>
                </div>
                <!-- Step 4: Preparing -->
                <div class="flex flex-col items-center text-center z-10">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-sm transition-all duration-300
                         {{ $order->payment_status === 'paid' ? 'bg-[#725B38] text-white' : 'bg-[#EEE7E2] text-[#7B7672]' }}">
                        <i class="bi bi-egg-fried"></i>
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold {{ $order->payment_status === 'paid' ? 'text-[#1E1B18]' : 'text-[#7B7672]' }} mt-2 uppercase">Diproses</span>
                </div>
            </div>

            <!-- Toast alert -->
            @if(session('success'))
                <div
                    class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-xl"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Left Side: Bank Transfer Instruction -->
            <div class="flex flex-col gap-6">
                <div class="bg-white border border-[#D1C5B8] rounded-xl p-6 shadow-sm flex flex-col gap-5">
                    <h3 class="font-noto-serif font-bold text-lg text-[#1E1B18] border-b border-[#E8E1DC] pb-3">
                        Informasi Rekening</h3>

                    <div class="flex flex-col gap-4">
                        <div class="bg-[#FAF2ED] p-4 border border-[#725B38]/20 rounded-lg flex flex-col gap-2">
                            <span class="text-[10px] font-bold text-[#725B38] tracking-[1.5px] uppercase">TRANSFER BANK
                                ({{ strtoupper($order->payment_method) }})</span>
                            <div class="flex justify-between items-center mt-1">
                                <span class="font-manrope font-bold text-lg text-[#1E1B18]">
                                    @if($order->payment_method === 'BCA')
                                        123-456-7890
                                    @elseif($order->payment_method === 'Mandiri')
                                        098-765-4321
                                    @elseif($order->payment_method === 'BRI')
                                        1122-3344-55
                                    @else
                                        123-456-7890
                                    @endif
                                </span>
                                <button
                                    onclick="navigator.clipboard.writeText('{{ $order->payment_method === 'BCA' ? '1234567890' : ($order->payment_method === 'Mandiri' ? '0987654321' : '1122334455') }}'); alert('Nomor rekening disalin!')"
                                    class="text-xs text-[#725B38] hover:text-[#532E1C] bg-white border border-[#D1C5B8] px-2 py-1 rounded transition flex items-center gap-1">
                                    <i class="bi bi-copy"></i> Salin
                                </button>
                            </div>
                            <span class="text-xs text-[#4D463C]">Atas Nama: <strong class="text-[#1E1B18]">De'Pallet
                                    Cafe</strong></span>
                        </div>

                        <div class="flex justify-between items-center border-t border-dashed border-[#D1C5B8] pt-4">
                            <span class="font-manrope text-sm text-[#4D463C]">Total Pembayaran</span>
                            <span class="font-noto-serif font-bold text-xl text-[#725B38]">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Proof of Payment Upload Form -->
                <div class="bg-white border border-[#D1C5B8] rounded-xl p-6 shadow-sm flex flex-col gap-5">
                    <h3 class="font-noto-serif font-bold text-lg text-[#1E1B18] border-b border-[#E8E1DC] pb-3">Bukti
                        Pembayaran</h3>

                    @if(!$order->payment_proof)
                        @if($order->payment_status !== 'cancelled')
                            <form action="{{ route('order.payment.upload', $order->order_number) }}" method="POST"
                                enctype="multipart/form-data" class="flex flex-col gap-4">
                                @csrf
                                <div class="flex flex-col gap-2">
                                    <label class="font-manrope text-xs text-[#4D463C]">Pilih file gambar bukti transfer (JPEG,
                                        PNG, JPG, maks. 2MB)</label>
                                    <input type="file" name="payment_proof" required accept="image/jpeg,image/png,image/jpg"
                                        class="w-full border border-[#D1C5B8] rounded p-2.5 font-manrope text-sm bg-[#FAF2ED]/30 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#725B38] file:text-white hover:file:bg-[#532E1C]">
                                    @error('payment_proof')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="w-full py-3 bg-[#725B38] hover:bg-[#532E1C] rounded text-white font-manrope font-bold text-xs tracking-[1px] uppercase transition shadow-sm">
                                    UNGGAH BUKTI
                                </button>
                            </form>
                        @else
                            <div class="text-center py-6 text-gray-400">
                                <i class="bi bi-x-circle text-4xl block mb-2"></i>
                                <span class="text-sm font-semibold">Order ini telah dibatalkan.</span>
                            </div>
                        @endif
                    @else
                        <div class="flex flex-col gap-3">
                            <span
                                class="text-xs text-green-700 font-semibold bg-green-50 p-3 border border-green-200 rounded flex items-center gap-2">
                                <i class="bi bi-check-circle-fill"></i> Bukti Pembayaran Telah Diunggah
                            </span>
                            <div class="border border-[#D1C5B8] rounded overflow-hidden max-h-[300px]">
                                <img src="{{ asset($order->payment_proof) }}" alt="Bukti Pembayaran"
                                    class="w-full h-full object-contain bg-gray-50">
                            </div>
                            <p class="text-[11px] text-[#7B7672] text-center italic">Unggah ulang tidak tersedia. Menunggu
                                verifikasi dari owner.</p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Side: Order Summary -->
            <div class="bg-white border border-[#D1C5B8] rounded-xl p-6 shadow-sm flex flex-col gap-5 h-fit">
                <h3 class="font-noto-serif font-bold text-lg text-[#1E1B18] border-b border-[#E8E1DC] pb-3">Rincian
                    Order</h3>

                <!-- Table / Customer Info -->
                <div class="grid grid-cols-2 gap-3 text-xs bg-[#FAF6F3] p-3 rounded">
                    <div>
                        <span class="text-[#7B7672] block">Nama Pelanggan</span>
                        <strong class="text-[#1E1B18]">{{ $order->customer->name }}</strong>
                    </div>
                    <div>
                        <span class="text-[#7B7672] block">Nomor Meja</span>
                        <strong class="text-[#1E1B18]">Meja {{ $order->table->table_number }}</strong>
                    </div>
                </div>

                <!-- Items list -->
                <div class="flex flex-col gap-4">
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex flex-col">
                                <span
                                    class="font-manrope font-semibold text-sm text-[#1E1B18]">{{ $item->menu->name }}</span>
                                <span class="font-manrope text-xs text-[#7B7672]">{{ $item->quantity }} x Rp
                                    {{ number_format($item->price_each_at_transaction, 0, ',', '.') }}</span>
                            </div>
                            <span class="font-manrope font-bold text-sm text-[#1E1B18]">Rp
                                {{ number_format($item->total_price, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="border-t border-[#E8E1DC] pt-4 flex flex-col gap-2 text-sm">
                    @php
                        $subtotal = $order->total_price;
                    @endphp
                    <div class="flex justify-between">
                        <span class="text-[#7B7672]">Subtotal</span>
                        <span class="text-[#1E1B18]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-[#E8E1DC] pt-2 font-bold text-[#725B38] text-base">
                        <span>Total Akhir</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-2 text-center">
                    <button onclick="window.location.reload();"
                        class="text-xs text-[#725B38] hover:text-[#532E1C] font-semibold bg-[#725B38]/5 border border-[#725B38]/10 w-full py-3 rounded transition flex items-center justify-center gap-2">
                        <i class="bi bi-arrow-clockwise"></i> Perbarui Status
                    </button>
                    <p class="text-[10px] text-[#7B7672] mt-2">Simpan URL halaman ini untuk memantau status pesanan
                        Anda.</p>
                </div>

            </div>

        </div>

    </main>

    @if(session('upload_success') || request()->query('success'))
        <!-- Success Modal Overlay -->
        <div id="success-modal" onclick="window.location.href = '{{ route('order.payment', $order->order_number) }}'"
            class="fixed inset-0 bg-black/60 backdrop-blur-md z-[9999] flex items-center justify-center p-4 cursor-pointer">
            <div onclick="event.stopPropagation()"
                class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl flex flex-col items-center text-center gap-6 border border-[#D1C5B8] animate-fade-in cursor-default">
                <!-- Golden Success Badge -->
                <div
                    class="w-20 h-20 bg-[#FAF2ED] rounded-full flex items-center justify-center text-[#725B38] border border-[#725B38]/30 shadow-inner">
                    <i class="bi bi-patch-check-fill text-5xl animate-bounce"></i>
                </div>

                <div>
                    <h2 class="font-noto-serif font-bold text-2xl text-[#1E1B18] tracking-tight">Pesanan Berhasil!</h2>
                    <p class="font-manrope text-sm text-[#4D463C] mt-3 leading-relaxed">
                        Terima kasih! Bukti pembayaran Anda telah diunggah dan sedang diverifikasi. Pesanan Anda akan segera
                        diproses di dapur kami.
                    </p>
                </div>

                <!-- Order Info Card -->
                <div
                    class="w-full bg-[#FAF6F3] border border-[#D1C5B8]/50 rounded-xl p-4 flex flex-col gap-2.5 text-xs text-[#1E1B18]">
                    <div class="flex justify-between items-center border-b border-gray-200/60 pb-2">
                        <span class="text-[#7B7672]">Nomor Pesanan</span>
                        <strong class="font-manrope font-semibold text-sm">{{ $order->order_number }}</strong>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200/60 pb-2">
                        <span class="text-[#7B7672]">Nomor Meja</span>
                        <strong class="font-semibold text-sm">Meja {{ $order->table->table_number }}</strong>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#7B7672]">Total Pembayaran</span>
                        <strong class="font-semibold text-sm text-[#725B38]">Rp
                            {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <!-- Close Button -->
                <button onclick="window.location.href = '{{ route('order.payment', $order->order_number) }}'"
                    class="w-full py-3.5 bg-[#725B38] hover:bg-[#532E1C] text-white font-manrope font-bold text-xs tracking-[1px] uppercase rounded-lg transition-all shadow-md">
                    Lihat Status Pesanan
                </button>
            </div>
        </div>
    @endif

</body>

</html>