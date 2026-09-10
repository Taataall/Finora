<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi - Finora Diary 📖✨</title>
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
        .memo-card {
            background: #FFFEE0;
            border: 2px solid #F8BBD0;
            box-shadow: 6px 8px 0px #F48FB1;
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

    <div class="max-w-2xl mx-auto space-y-6 my-4">

        <div class="flex justify-between items-center bg-white/80 p-3 rounded-full border border-pink-200 shadow-sm">
            <a href="{{ route('transactions.history') }}" class="font-title text-sm text-[#2D5A27] font-bold px-3 py-1 rounded-full hover:bg-pink-100">← Kembali ke Riwayat</a>
            <div class="flex gap-2">
                <a href="{{ route('transactions.create') }}" class="px-3 py-1 text-gray-600 font-title text-xs font-bold rounded-full hover:bg-pink-100">✍️ Tambah</a>
                <a href="{{ route('transactions.history') }}" class="px-3 py-1 bg-[#F48FB1] text-white font-title text-xs font-bold rounded-full">📜 Riwayat</a>
            </div>
        </div>

        <div class="memo-card p-6 md:p-8 rounded-2xl relative">
            <div class="paperclip border-[#78909C]"></div>

            <h2 class="font-title text-3xl font-bold text-[#4E342E] mb-4 border-b-2 border-dashed border-amber-300 pb-2">
                ✏️ Edit Transaksi
            </h2>

            @if ($errors->any())
                <div class="p-3 rounded-2xl text-left font-diary text-lg mb-5 bg-[#FF9D9D]/20 border-2 border-[#FF9D9D] text-[#C2185B]">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="space-y-4 font-body font-semibold">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Jenis Transaksi</label>
                    <select name="jenis" class="w-full mt-1 p-3 text-sm bg-white border-2 border-amber-200 rounded-xl focus:outline-none">
                        <option value="pemasukan" @selected(old('jenis', $transaction->jenis) === 'pemasukan')>🌿 Pemasukan</option>
                        <option value="pengeluaran" @selected(old('jenis', $transaction->jenis) === 'pengeluaran')>🎀 Pengeluaran</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', $transaction->jumlah) }}" placeholder="contoh: 25000" class="w-full mt-1 p-3 text-sm bg-white border-2 border-amber-200 rounded-xl focus:outline-none" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $transaction->kategori) }}" placeholder="Jajan 🍰" class="w-full mt-1 p-3 text-sm bg-white border-2 border-amber-200 rounded-xl focus:outline-none" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $transaction->tanggal) }}" class="w-full mt-1 p-3 text-sm bg-white border-2 border-amber-200 rounded-xl focus:outline-none" required>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Catatan Harian</label>
                    <input type="text" name="catatan" value="{{ old('catatan', $transaction->catatan) }}" placeholder="Beli matcha latte..." class="w-full mt-1 p-3 text-sm bg-white border-2 border-amber-200 rounded-xl focus:outline-none">
                </div>

                <button type="submit" class="w-full mt-3 bg-[#F48FB1] hover:bg-[#F06292] text-white font-title text-xl font-bold py-3 rounded-xl transition-all shadow-md">
                    Simpan Perubahan 💖
                </button>
            </form>
        </div>

    </div>

</body>
</html>
