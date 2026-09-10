<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Finora Diary 📖✨</title>
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
    </style>
</head>
<body class="p-3 md:p-8 min-h-screen">

    <div class="max-w-4xl mx-auto space-y-6 my-4">

        <!-- NAVIGASI MINI -->
        <div class="flex justify-between items-center bg-white/80 p-3 rounded-full border border-pink-200 shadow-sm">
            <a href="{{ route('dashboard') }}" class="font-title text-sm text-[#2D5A27] font-bold px-3 py-1 rounded-full hover:bg-pink-100">← Kembali ke Dashboard</a>
            <div class="flex gap-2">
                <a href="{{ route('transactions.create') }}" class="px-3 py-1 text-gray-600 font-title text-xs font-bold rounded-full hover:bg-pink-100">✍️ Tambah</a>
                <a href="{{ route('transactions.history') }}" class="px-3 py-1 bg-[#F48FB1] text-white font-title text-xs font-bold rounded-full">📜 Riwayat</a>
            </div>
        </div>

        <!-- RIWAYAT CARD -->
        <div class="ripped-paper p-6 md:p-8 rounded-xl relative">
            <div class="washi-tape -top-3 right-12 bg-[#FFD54F]/80 rotate-2"></div>

            <h2 class="font-title text-3xl font-bold text-[#2D5A27] mb-6 border-b-2 border-dashed border-gray-200 pb-2">
                📜 Semua Riwayat Jurnal
            </h2>

            @if(session('success'))
                <div class="memo-card p-3 rounded-2xl text-center text-[#2D5A27] font-title text-lg bg-[#E8F5E9] mb-5 font-semibold">
                    ✨ {{ session('success') }}
                </div>
            @endif

            <div class="space-y-3 font-body">
                @forelse($transactions as $t)
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center p-3.5 rounded-2xl border-l-8 memo-card {{ $t->jenis == 'pemasukan' ? 'bg-[#F1F8E9] border-l-[#2E7D32]' : 'bg-[#FCE4EC] border-l-[#C2185B]' }}">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-800 text-lg font-title">{{ $t->kategori }}</span>
                                <span class="text-xs px-2.5 py-0.5 rounded-full font-bold uppercase text-white {{ $t->jenis == 'pemasukan' ? 'bg-[#2E7D32]' : 'bg-[#C2185B]' }}">
                                    {{ $t->jenis }}
                                </span>
                            </div>
                            <span class="text-sm text-gray-600 font-diary font-bold block mt-1 text-base">
                                {{ $t->catatan ?? 'Tanpa catatan' }} • {{ date('d M Y', strtotime($t->tanggal)) }}
                                @if(Auth::user()->role === 'admin' && $t->user)
                                    • <span class="text-purple-700">Oleh: {{ $t->user->name }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between gap-3 sm:flex-col sm:items-end">
                            <span class="font-title text-2xl font-bold {{ $t->jenis == 'pemasukan' ? 'text-[#2E7D32]' : 'text-[#C2185B]' }}">
                                {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('transactions.edit', $t) }}" class="px-3 py-1 bg-[#FFD54F] hover:bg-[#FFCA28] text-[#4E342E] font-title text-xs font-bold rounded-full shadow-sm">
                                ✏️ Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-center font-diary text-gray-400 py-8 text-2xl">Belum ada halaman catatan harian... 🍃</p>
                @endforelse
            </div>

            <!-- PAGINASI -->
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        </div>

    </div>

</body>
</html>
