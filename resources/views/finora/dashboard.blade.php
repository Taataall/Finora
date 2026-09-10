<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finora Diary 📖✨</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Patrick+Hand&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #FCE4EC;
            background-image: 
                linear-gradient(90deg, rgba(240, 98, 146, 0.15) 50%, transparent 50%),
                linear-gradient(rgba(240, 98, 146, 0.15) 50%, transparent 50%);
            background-size: 30px 30px;
        }
        .font-title { font-family: 'Fredoka', cursive; }
        .font-diary { font-family: 'Patrick Hand', cursive; }
        .ripped-paper {
            background-color: #FFFFFF;
            position: relative;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.06);
            clip-path: polygon(
                0% 12px, 2% 0px, 5% 10px, 8% 2px, 11% 12px, 14% 3px, 17% 11px, 20% 1px,
                24% 12px, 28% 2px, 32% 10px, 36% 1px, 40% 12px, 44% 3px, 48% 11px, 52% 0px,
                56% 12px, 60% 2px, 64% 10px, 68% 1px, 72% 12px, 76% 3px, 80% 11px, 84% 0px,
                88% 12px, 92% 2px, 96% 10px, 100% 1px,
                100% calc(100% - 10px), 98% 100%, 95% calc(100% - 12px), 91% 100%, 87% calc(100% - 9px),
                83% 100%, 79% calc(100% - 11px), 75% 100%, 71% calc(100% - 8px), 67% 100%,
                63% calc(100% - 12px), 59% 100%, 55% calc(100% - 10px), 51% 100%, 47% calc(100% - 11px),
                43% 100%, 39% calc(100% - 8px), 35% 100%, 31% calc(100% - 12px), 27% 100%,
                23% calc(100% - 9px), 19% 100%, 15% calc(100% - 11px), 11% 100%, 7% calc(100% - 8px),
                3% 100%, 0% calc(100% - 10px)
            );
        }
        .washi-tape {
            position: absolute;
            height: 28px;
            width: 110px;
            background: rgba(255, 182, 193, 0.75);
            border-left: 2px dashed rgba(255,255,255,0.6);
            border-right: 2px dashed rgba(255,255,255,0.6);
            pointer-events: none;
            z-index: 20;
        }
        .memo-card {
            background: #FFFFFF;
            border: 2px solid #F8BBD0;
            box-shadow: 5px 6px 0px #F48FB1;
        }
        .paperclip {
            position: absolute;
            top: -14px;
            left: 20px;
            width: 16px;
            height: 38px;
            border: 3px solid #78909C;
            border-radius: 10px;
            background: transparent;
            z-index: 30;
        }
    </style>
</head>
<body class="p-3 md:p-8 min-h-screen">

    <div class="max-w-5xl mx-auto space-y-8 my-4">

        <!-- HEADER & NAVIGASI -->
        <div class="ripped-paper p-6 bg-[#2D5A27] text-white rounded-xl relative">
            <div class="washi-tape -top-2 left-10 -rotate-6 bg-[#FFB74D]/80"></div>
            <div class="flex flex-wrap justify-between items-center gap-4 relative z-10">
                <div class="bg-white/90 text-[#2D5A27] px-4 py-1.5 rounded-full font-bold text-sm shadow-sm">
                    👋 Halo, <span class="font-title text-lg text-[#C2185B]">{{ Auth::user()->name }}</span>!
                    @if(Auth::user()->role === 'admin')
                        <span class="bg-purple-600 text-white text-xs px-2 py-0.5 rounded-full uppercase ml-1">Admin</span>
                    @endif
                </div>

                <div class="flex gap-2 bg-white/20 p-1.5 rounded-full backdrop-blur-sm">
                    <a href="{{ route('dashboard') }}" class="px-4 py-1.5 bg-white text-[#2D5A27] font-title font-bold rounded-full shadow-sm text-sm">🏠 Dashboard</a>
                    <a href="{{ route('transactions.create') }}" class="px-4 py-1.5 text-white hover:bg-white/20 font-title font-bold rounded-full text-sm">✍️ Catat</a>
                    <a href="{{ route('transactions.history') }}" class="px-4 py-1.5 text-white hover:bg-white/20 font-title font-bold rounded-full text-sm">📜 Riwayat</a>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-[#FF8A80] hover:bg-[#FF5252] text-white font-bold px-4 py-1.5 rounded-full text-xs transition-all shadow-md">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="memo-card p-3 rounded-2xl text-center text-[#2D5A27] font-title text-lg bg-[#E8F5E9] -rotate-1 font-semibold">
                ✨ {{ session('success') }}
            </div>
        @endif

        <!-- RINGKASAN SALDO -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="memo-card p-5 rounded-2xl -rotate-2 bg-[#F1F8E9] border-[#AED581] relative">
                <div class="paperclip border-[#558B2F]"></div>
                <span class="font-diary text-xl text-[#33691E] block font-bold">🌿 Total Pemasukan</span>
                <span class="font-title text-3xl font-bold text-[#2E7D32] block mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
            </div>

            <div class="memo-card p-5 rounded-2xl rotate-2 bg-[#FCE4EC] border-[#F48FB1] relative">
                <div class="paperclip border-[#C2185B]"></div>
                <span class="font-diary text-xl text-[#880E4F] block font-bold">🎀 Total Pengeluaran</span>
                <span class="font-title text-3xl font-bold text-[#C2185B] block mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
            </div>

            <div class="memo-card p-5 rounded-2xl -rotate-1 bg-[#FFF8E1] border-[#FFE082] relative">
                <div class="paperclip border-[#F57F17]"></div>
                <span class="font-diary text-xl text-[#F57F17] block font-bold">👛 Sisa Saldo</span>
                <span class="font-title text-3xl font-bold text-[#4E342E] block mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- KALENDER INTERAKTIF -->
        <div class="ripped-paper p-6 md:p-8 rounded-xl relative">
            <div class="washi-tape -top-3 left-12 bg-[#81D4FA]/80 -rotate-3"></div>

            <div class="flex flex-wrap justify-between items-center mb-6 border-b-2 border-dashed border-gray-200 pb-4 gap-3">
                <h2 class="font-title text-2xl md:text-3xl font-bold text-[#2D5A27]">🗓️ Kalender Finora</h2>
                
                <!-- Navigasi Bulan & Tahun -->
                <div class="flex items-center gap-2">
                    <button onclick="prevMonth()" class="px-3 py-1 bg-pink-100 hover:bg-pink-200 text-[#C2185B] font-bold rounded-full text-sm">◀ Prev</button>
                    <span id="calendarMonthYear" class="font-title text-lg font-bold text-[#C2185B] min-w-[140px] text-center"></span>
                    <button onclick="nextMonth()" class="px-3 py-1 bg-pink-100 hover:bg-pink-200 text-[#C2185B] font-bold rounded-full text-sm">Next ▶</button>
                </div>
            </div>

            <!-- Grid Kalender -->
            <div class="grid grid-cols-7 gap-1 text-center font-title text-sm text-gray-500 mb-2">
                <div class="text-red-500">Min</div>
                <div>Sen</div>
                <div>Sel</div>
                <div>Rab</div>
                <div>Kam</div>
                <div>Jum</div>
                <div class="text-pink-500">Sab</div>
            </div>

            <div id="calendarDays" class="grid grid-cols-7 gap-2"></div>
        </div>

        <!-- TRANSAKSI TERAKHIR -->
        <div class="ripped-paper p-6 md:p-8 rounded-xl relative">
            <div class="washi-tape -top-3 right-12 bg-[#FFD54F]/80 rotate-2"></div>
            <div class="flex justify-between items-center mb-4 border-b-2 border-dashed border-gray-200 pb-2">
                <h2 class="font-title text-2xl md:text-3xl font-bold text-[#2D5A27]">📌 Catatan Terbaru</h2>
                <a href="{{ route('transactions.history') }}" class="font-title text-sm text-[#C2185B] hover:underline font-bold">Lihat Semua →</a>
            </div>

            <div class="space-y-3">
                @forelse($transactions as $t)
                    <div class="flex justify-between items-center p-3.5 rounded-2xl border-l-8 memo-card {{ $t->jenis == 'pemasukan' ? 'bg-[#F1F8E9] border-l-[#2E7D32]' : 'bg-[#FCE4EC] border-l-[#C2185B]' }}">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-800 font-title">{{ $t->kategori }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase text-white {{ $t->jenis == 'pemasukan' ? 'bg-[#2E7D32]' : 'bg-[#C2185B]' }}">{{ $t->jenis }}</span>
                            </div>
                            <span class="text-xs text-gray-600 font-diary font-bold block mt-1">
                                {{ $t->catatan ?? 'Tanpa catatan' }} • {{ date('d M Y', strtotime($t->tanggal)) }}
                                @if(Auth::user()->role === 'admin' && $t->user) • <span class="text-purple-700">Oleh: {{ $t->user->name }}</span> @endif
                            </span>
                        </div>
                        <span class="font-title text-xl font-bold {{ $t->jenis == 'pemasukan' ? 'text-[#2E7D32]' : 'text-[#C2185B]' }}">
                            {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-center font-diary text-gray-400 py-6 text-xl">Belum ada catatan transaksi terbaru... 🍃</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- MODAL POPUP TRANSAKSI TANGGAL -->
    <div id="modalDetail" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="memo-card bg-white p-6 rounded-2xl max-w-md w-full relative -rotate-1">
            <button onclick="closeModal()" class="absolute top-3 right-4 font-title text-xl font-bold text-gray-400 hover:text-red-500">✕</button>
            <h3 id="modalDateTitle" class="font-title text-2xl font-bold text-[#2D5A27] mb-4 border-b-2 border-dashed border-gray-200 pb-2">Detail Transaksi</h3>
            <div id="modalContent" class="space-y-3 max-h-60 overflow-y-auto pr-1"></div>
            <button onclick="closeModal()" class="w-full mt-5 bg-[#F48FB1] text-white font-title font-bold py-2 rounded-xl">Tutup 🌸</button>
        </div>
    </div>

    <!-- SCRIPT KALENDER -->
    <script>
        const events = @json($events);
        let currentDate = new Date();

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            document.getElementById('calendarMonthYear').innerText = `${monthNames[month]} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            const daysContainer = document.getElementById('calendarDays');
            daysContainer.innerHTML = '';

            // Slot kosong awal bulan
            for (let i = 0; i < firstDay; i++) {
                daysContainer.innerHTML += `<div class="p-2"></div>`;
            }

            // Tanggal
            for (let day = 1; day <= daysInMonth; day++) {
                const formattedDay = String(day).padStart(2, '0');
                const formattedMonth = String(month + 1).padStart(2, '0');
                const dateKey = `${year}-${formattedMonth}-${formattedDay}`;

                const hasEvent = events[dateKey] ? true : false;
                const eventBadge = hasEvent ? `<span class="block w-2 h-2 bg-[#C2185B] rounded-full mx-auto mt-1"></span>` : '';

                daysContainer.innerHTML += `
                    <button onclick="showDateDetail('${dateKey}')" 
                        class="p-2 min-h-[45px] rounded-xl font-bold text-sm transition-all ${hasEvent ? 'bg-pink-100 hover:bg-pink-200 text-[#C2185B] border border-pink-300' : 'bg-gray-50 hover:bg-gray-100 text-gray-700'}">
                        ${day}
                        ${eventBadge}
                    </button>
                `;
            }
        }

        function prevMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        function showDateDetail(dateKey) {
            const list = events[dateKey];
            const modal = document.getElementById('modalDetail');
            const modalTitle = document.getElementById('modalDateTitle');
            const modalContent = document.getElementById('modalContent');

            const [y, m, d] = dateKey.split('-');
            modalTitle.innerText = `📅 ${d}/${m}/${y}`;

            if (list && list.length > 0) {
                let html = '';
                list.forEach(item => {
                    const isPemasukan = item.jenis === 'pemasukan';
                    html += `
                        <div class="p-3 rounded-xl border-l-4 ${isPemasukan ? 'bg-green-50 border-green-600' : 'bg-pink-50 border-pink-600'}">
                            <div class="flex justify-between font-title font-bold text-sm">
                                <span>${item.kategori}</span>
                                <span class="${isPemasukan ? 'text-green-700' : 'text-pink-700'}">${isPemasukan ? '+' : '-'} Rp ${item.jumlah}</span>
                            </div>
                            <p class="text-xs font-diary font-bold text-gray-600 mt-1">${item.catatan}</p>
                        </div>
                    `;
                });
                modalContent.innerHTML = html;
            } else {
                modalContent.innerHTML = `<p class="text-center font-diary text-gray-400 py-4 text-lg">Tidak ada catatan transaksi di tanggal ini 🍃</p>`;
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        renderCalendar();
    </script>

</body>
</html>