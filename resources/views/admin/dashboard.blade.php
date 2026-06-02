<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - De'Pallet Cafe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800;900&family=Noto+Serif:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- QRious Library for QR generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <style>
        .tab-btn.active {
            background-color: #725B38;
            color: white;
            border-color: #725B38;
        }
    </style>
</head>

<body class="font-manrope bg-[#FAF6F3] min-h-screen text-[#1E1B18] flex flex-col">

    @php
        $tab = $activeTab ?? 'orders';
    @endphp

    <!-- Top Header -->
    <header class="bg-white border-b border-[#D1C5B8] h-[72px] sticky top-0 z-50 shadow-sm">
        <div class="max-w-[1536px] mx-auto flex items-center justify-between px-8 py-4 h-[72px]">
            <div class="flex items-center gap-4">
                <div class="font-noto-serif font-black text-2xl tracking-[-0.6px] text-[#1E1B18]">
                    De'Pallet <span class="text-[#725B38] font-normal text-lg">Owner Panel</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-[#725B38]/5 rounded border border-[#725B38]/10 text-xs">
                    <i class="bi bi-person-fill-lock text-[#725B38]"></i>
                    <span class="font-bold text-[#725B38]">{{ Auth::guard('admin')->user()->name }}</span>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 px-3 py-1.5 rounded text-xs font-bold transition flex items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="max-w-[1536px] w-full mx-auto flex-1 flex flex-col md:flex-row gap-8 px-6 md:px-8 py-8">
        
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-[240px] shrink-0 flex flex-col gap-2">
            <button onclick="switchTab('orders')" id="tab-btn-orders" 
                class="tab-btn flex items-center gap-3 w-full text-left px-4 py-3 rounded-lg border border-[#D1C5B8] bg-white text-[#4D463C] font-bold text-sm transition hover:bg-[#FAF2ED] hover:text-[#725B38] {{ $tab === 'orders' ? 'active' : '' }}">
                <i class="bi bi-receipt text-lg"></i> Validasi Pesanan
            </button>
            <button onclick="switchTab('tables')" id="tab-btn-tables" 
                class="tab-btn flex items-center gap-3 w-full text-left px-4 py-3 rounded-lg border border-[#D1C5B8] bg-white text-[#4D463C] font-bold text-sm transition hover:bg-[#FAF2ED] hover:text-[#725B38] {{ $tab === 'tables' ? 'active' : '' }}">
                <i class="bi bi-qr-code text-lg"></i> Kelola Meja & QR
            </button>
        </aside>

        <!-- Main Panel Content -->
        <main class="flex-1 flex flex-col gap-6">
            
            <!-- Toast notification -->
            @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm flex items-center gap-3 shadow-sm">
                <i class="bi bi-check-circle-fill text-xl"></i>
                <div class="font-bold">{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm flex items-center gap-3 shadow-sm">
                <i class="bi bi-x-circle-fill text-xl"></i>
                <div class="font-bold">{{ session('error') }}</div>
            </div>
            @endif

            <!-- Tab 1: Orders -->
            <section id="tab-content-orders" class="tab-pane {{ $tab === 'orders' ? '' : 'hidden' }}">
                <div class="bg-white border border-[#D1C5B8] rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-[#E8E1DC] flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-[#FAF2ED]/50">
                        <div>
                            <h2 class="font-noto-serif font-bold text-xl text-[#1E1B18]">Daftar Pesanan Masuk (Dine-In & Reservasi)</h2>
                            <p class="text-xs text-[#7B7672] mt-0.5">Pantau status pembayaran dan validasi bukti transfer pelanggan.</p>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#FAF6F3] border-b border-[#E8E1DC] text-xs font-bold text-[#725B38] uppercase tracking-wider">
                                    <th class="p-4 pl-6">Order / Tanggal</th>
                                    <th class="p-4">Pelanggan / Meja</th>
                                    <th class="p-4">Menu Order</th>
                                    <th class="p-4">Metode & Total</th>
                                    <th class="p-4">Bukti Bayar</th>
                                    <th class="p-4 text-center">Status</th>
                                    <th class="p-4 pr-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-[#E8E1DC]">
                                @forelse($orders->whereIn('order_type', ['dine_in', 'reservation']) as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="p-4 pl-6">
                                        <div class="flex items-center gap-1.5 mb-0.5">
                                            @if($order->order_type === 'reservation')
                                                <span class="text-[9px] bg-[#725B38] text-white px-1.5 py-0.5 rounded font-black tracking-wider uppercase">RES</span>
                                            @else
                                                <span class="text-[9px] bg-blue-600 text-white px-1.5 py-0.5 rounded font-black tracking-wider uppercase">DINE</span>
                                            @endif
                                            <span class="font-bold text-[#1E1B18]">{{ $order->order_number }}</span>
                                        </div>
                                        <span class="text-[11px] text-[#7B7672] block mt-0.5">{{ $order->created_at->format('d M Y H:i') }}</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-semibold text-[#1E1B18] block">{{ $order->customer->name }}</span>
                                        <div class="flex flex-col gap-0.5 mt-1">
                                            <span class="text-xs text-[#725B38] font-bold block"><i class="bi bi-qr-code-scan"></i> Meja {{ $order->table->table_number ?? '-' }}</span>
                                            @if($order->order_type === 'reservation')
                                                <span class="text-[10px] bg-[#FAF2ED] text-[#725B38] px-1.5 py-0.5 border border-[#725B38]/20 rounded font-bold w-fit mt-0.5">
                                                    📅 {{ date('d M Y', strtotime($order->reservation_date)) }} ({{ $order->reservation_time }})
                                                </span>
                                                <span class="text-[10px] text-gray-500 font-medium">
                                                    👥 {{ $order->number_of_people }} Tamu
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 max-w-[200px]">
                                        <div class="flex flex-col gap-0.5 text-xs text-[#4D463C]">
                                            @foreach($order->orderItems as $item)
                                                <span>{{ $item->quantity }}x <strong>{{ $item->menu->name }}</strong></span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="text-xs font-bold bg-[#FAF2ED] text-[#725B38] px-2 py-0.5 border border-[#725B38]/20 rounded block w-fit mb-1">{{ $order->payment_method }}</span>
                                        <strong class="text-[#725B38] block">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                    </td>
                                    <td class="p-4">
                                        @if($order->payment_proof)
                                            <button onclick="zoomProof('{{ asset($order->payment_proof) }}')" class="relative w-12 h-12 rounded border border-[#D1C5B8] overflow-hidden group focus:outline-none">
                                                <img src="{{ asset($order->payment_proof) }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition duration-300">
                                                    <i class="bi bi-zoom-in"></i>
                                                </div>
                                            </button>
                                        @else
                                            <span class="text-xs text-[#7B7672] italic"><i class="bi bi-dash-circle"></i> Belum upload</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($order->payment_status === 'paid')
                                            <span class="px-2.5 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full font-bold text-xs">PAID</span>
                                        @elseif($order->payment_status === 'cancelled')
                                            <span class="px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full font-bold text-xs">CANCELLED</span>
                                        @elseif($order->payment_proof)
                                            <span class="px-2.5 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full font-bold text-xs">PENDING VERIF</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 border border-gray-200 rounded-full font-bold text-xs">UNPAID</span>
                                        @endif
                                    </td>
                                    <td class="p-4 pr-6 text-right">
                                        @if($order->payment_status === 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.orders.validate', $order->order_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#725B38] hover:bg-[#532E1C] text-white px-3 py-1.5 rounded text-xs font-bold transition flex items-center gap-1 shadow-sm">
                                                    <i class="bi bi-check-lg"></i> Validasi
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.orders.cancel', $order->order_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan order ini?')">
                                                @csrf
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 px-3 py-1.5 rounded text-xs font-bold transition flex items-center gap-1">
                                                    <i class="bi bi-x-circle"></i> Batal
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                            <span class="text-xs text-[#7B7672] italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-[#7B7672] italic bg-gray-50/50">
                                        <i class="bi bi-inbox text-4xl block mb-2 text-gray-300"></i>
                                        Belum ada pesanan Dine-In atau Reservasi yang masuk.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Tab 2: Tables -->
            <section id="tab-content-tables" class="tab-pane {{ $tab === 'tables' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    
                    <!-- Left: Tables List (Span 2) -->
                    <div class="xl:col-span-2 bg-white border border-[#D1C5B8] rounded-xl shadow-sm overflow-hidden h-fit">
                        <div class="p-6 border-b border-[#E8E1DC] bg-[#FAF2ED]/50">
                            <h2 class="font-noto-serif font-bold text-xl text-[#1E1B18]">Daftar Meja Cafe</h2>
                            <p class="text-xs text-[#7B7672] mt-0.5">Kelola meja aktif, unduh QR code meja untuk ditempel di meja fisik.</p>
                        </div>

                        <div class="divide-y divide-[#E8E1DC]">
                            @forelse($tables->sortBy('table_number') as $table)
                                <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-6 hover:bg-gray-50/50 transition-colors">
                                    <div class="flex items-center gap-5">
                                        <!-- QR Display Area -->
                                        <div class="bg-[#FAF2ED] border border-[#D1C5B8] p-2 rounded flex flex-col items-center gap-1 shadow-sm">
                                            <canvas id="qr-canvas-{{ $table->table_number }}" class="w-24 h-24 bg-white"></canvas>
                                            <!-- Hidden anchor to facilitate download -->
                                            <a id="qr-download-{{ $table->table_number }}" class="hidden"></a>
                                            <!-- Trigger QR render via script -->
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    const qr = new QRious({
                                                        element: document.getElementById('qr-canvas-{{ $table->table_number }}'),
                                                        value: "{{ url('/dinein?table=') . $table->table_number }}",
                                                        size: 250
                                                    });
                                                });
                                            </script>
                                        </div>

                                        <div class="flex flex-col gap-1">
                                            <h3 class="font-noto-serif font-bold text-lg text-[#1E1B18]">Meja Nomor {{ $table->table_number }}</h3>
                                            <p class="text-xs text-[#7B7672] max-w-[250px] overflow-hidden text-ellipsis whitespace-nowrap">
                                                Link: <a href="{{ url('/dinein?table=') . $table->table_number }}" target="_blank" class="text-[#725B38] underline hover:text-[#532E1C]">{{ url('/dinein?table=') . $table->table_number }}</a>
                                            </p>
                                            <div class="flex items-center gap-2 mt-2">
                                                @if($table->is_available)
                                                    <span class="px-2 py-0.5 bg-green-50 text-green-700 border border-green-200 text-[10px] font-bold rounded">TERSEDIA</span>
                                                @else
                                                    <span class="px-2 py-0.5 bg-red-50 text-red-700 border border-red-200 text-[10px] font-bold rounded">PENUH / TIDAK AKTIF</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <!-- Action buttons for QR -->
                                        <button onclick="downloadQR('{{ $table->table_number }}')" class="text-xs text-[#725B38] bg-white hover:bg-[#FAF2ED] border border-[#D1C5B8] px-3 py-2 rounded font-bold transition flex items-center gap-1 shadow-sm">
                                            <i class="bi bi-download"></i> Unduh QR
                                        </button>
                                        <button onclick="printQR('{{ $table->table_number }}')" class="text-xs text-[#725B38] bg-white hover:bg-[#FAF2ED] border border-[#D1C5B8] px-3 py-2 rounded font-bold transition flex items-center gap-1 shadow-sm">
                                            <i class="bi bi-printer"></i> Cetak QR
                                        </button>
                                        
                                        <!-- Actions on Table Status -->
                                        <form action="{{ route('admin.tables.toggle', $table->table_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold px-3 py-2 rounded border transition shadow-sm
                                                {{ $table->is_available ? 'bg-yellow-50 text-yellow-700 border-yellow-200 hover:bg-yellow-100' : 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' }}">
                                                {{ $table->is_available ? 'Set Penuh' : 'Set Tersedia' }}
                                            </button>
                                        </form>

                                        <!-- Delete Table -->
                                        <form action="{{ route('admin.tables.destroy', $table->table_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 p-2 rounded transition" title="Hapus Meja">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center text-[#7B7672] italic">
                                    <i class="bi bi-qr-code text-4xl block mb-2 text-gray-300"></i>
                                    Belum ada meja yang terdaftar.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Right: Add Table Form (Span 1) -->
                    <div class="bg-white border border-[#D1C5B8] rounded-xl shadow-sm overflow-hidden h-fit">
                        <div class="p-6 border-b border-[#E8E1DC] bg-[#FAF2ED]/50">
                            <h3 class="font-noto-serif font-bold text-lg text-[#1E1B18]">Tambah Meja Baru</h3>
                            <p class="text-xs text-[#7B7672] mt-0.5">Meja baru akan langsung dibuatkan QR code secara otomatis.</p>
                        </div>
                        
                        <form action="{{ route('admin.tables.store') }}" method="POST" class="p-6 flex flex-col gap-4">
                            @csrf
                            <div class="flex flex-col gap-2">
                                <label for="table_number_input" class="font-manrope font-bold text-xs text-[#532E1C] uppercase tracking-wider">Nomor / Identitas Meja</label>
                                <input type="text" id="table_number_input" name="table_number" required placeholder="Contoh: 1, 2, VIP-1"
                                    class="w-full border border-[#D1C5B8] rounded p-3 font-manrope text-sm outline-none focus:border-[#725B38] bg-[#FAF2ED]/30 focus:bg-white transition">
                                @error('table_number')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="w-full py-3 bg-[#725B38] hover:bg-[#532E1C] rounded text-white font-manrope font-bold text-xs tracking-[1px] uppercase transition shadow-sm">
                                <i class="bi bi-plus-circle-fill"></i> Tambah Meja
                            </button>
                        </form>
                    </div>

                </div>
            </section>

        </main>

    </div>

    <!-- Zoom Image Modal for Proof of Payment -->
    <div id="proof-modal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="relative bg-white border border-[#D1C5B8] rounded-xl shadow-2xl max-w-2xl w-full overflow-hidden flex flex-col max-h-[85vh]">
            <div class="p-4 border-b border-[#E8E1DC] flex justify-between items-center bg-[#FAF2ED]">
                <h3 class="font-noto-serif font-bold text-base text-[#1E1B18]">Bukti Pembayaran Pelanggan</h3>
                <button onclick="closeZoom()" class="text-gray-500 hover:text-gray-700 text-xl bg-transparent border-none cursor-pointer"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="p-4 flex-1 flex items-center justify-center bg-gray-50 overflow-auto">
                <img id="proof-zoom-img" src="" class="max-w-full max-h-[60vh] object-contain">
            </div>
            <div class="p-4 bg-gray-100 border-t border-[#E8E1DC] text-right">
                <button onclick="closeZoom()" class="px-4 py-2 bg-[#725B38] hover:bg-[#532E1C] text-white text-xs font-bold rounded transition shadow-sm">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        // Switch between tabs
        function switchTab(tabId) {
            document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

            document.getElementById('tab-content-' + tabId).classList.remove('hidden');
            document.getElementById('tab-btn-' + tabId).classList.add('active');

            // Update URL query parameter without reloading
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);
        }

        // Zoom modal functions
        function zoomProof(imgUrl) {
            const modal = document.getElementById('proof-modal');
            const img = document.getElementById('proof-zoom-img');
            img.src = imgUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeZoom() {
            const modal = document.getElementById('proof-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Print table QR Code
        function printQR(tableNum) {
            const canvas = document.getElementById('qr-canvas-' + tableNum);
            const win = window.open('', '_blank');
            win.document.write('<html><head><title>Cetak QR Meja ' + tableNum + '</title>');
            win.document.write('<style>body{font-family:sans-serif;text-align:center;padding:50px;} .container{border:3px solid #725B38;border-radius:15px;padding:30px;display:inline-block;} img{width:300px;height:300px;} h1{color:#1E1B18;margin-bottom:5px;} p{color:#725B38;font-size:20px;font-weight:bold;margin-top:10px;}</style>');
            win.document.write('</head><body>');
            win.document.write('<div class="container">');
            win.document.write('<h1>De\'Pallet Cafe</h1>');
            win.document.write('<p>SILAKAN SCAN UNTUK MEMESAN</p>');
            win.document.write('<img src="' + canvas.toDataURL() + '">');
            win.document.write('<p>MEJA NOMOR ' + tableNum + '</p>');
            win.document.write('</div>');
            win.document.write('<script>window.onload = function() { window.print(); window.close(); };<\/script>');
            win.document.write('</body></html>');
            win.document.close();
        }

        // Download table QR Code as image
        function downloadQR(tableNum) {
            const canvas = document.getElementById('qr-canvas-' + tableNum);
            const link = document.getElementById('qr-download-' + tableNum);
            link.href = canvas.toDataURL('image/png');
            link.download = 'meja_' + tableNum + '_qr.png';
            link.click();
        }

        // Close Zoom Modal on click outside
        document.getElementById('proof-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeZoom();
            }
        });
    </script>
</body>

</html>
