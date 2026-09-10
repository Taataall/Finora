<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Finora Diary 📖✨</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Indie+Flower&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F3EBE1; /* Background Luar Meja Belajar */
            background-image: radial-gradient(#D0C4B4 1.2px, transparent 1.2px);
            background-size: 20px 20px;
        }

        .font-handwriting {
            font-family: 'Caveat', cursive;
        }

        .font-diary {
            font-family: 'Indie Flower', cursive;
        }

        /* Kertas Buku Binder Utama */
        .binder-paper {
            background-color: #FDF8F2;
            border: 2px solid #E5D9CC;
            box-shadow: 8px 10px 0px rgba(180, 160, 140, 0.3);
            background-image: linear-gradient(to bottom, transparent 95%, rgba(215, 204, 200, 0.3) 100%);
            background-size: 100% 28px;
        }

        /* Lubang Ring Binder */
        .binder-hole {
            width: 14px;
            height: 14px;
            background-color: #8D6E63;
            border-radius: 50%;
            box-shadow: inset 2px 2px 3px rgba(0,0,0,0.4);
        }

        /* Washi Tape Hiasan */
        .washi-tape {
            position: absolute;
            height: 26px;
            width: 110px;
            background: rgba(255, 197, 170, 0.85);
            border-left: 2px dashed rgba(0,0,0,0.1);
            border-right: 2px dashed rgba(0,0,0,0.1);
            box-shadow: 1px 2px 4px rgba(0,0,0,0.06);
            pointer-events: none;
        }

        /* Scrapbook Box */
        .paper-scrap {
            background: #FFFFFF;
            border: 2px solid #E0D7C6;
            box-shadow: 4px 4px 0px #D7CCC8;
        }
    </style>
</head>
<body class="p-4 min-h-screen flex justify-center items-center">

    <div class="max-w-md w-full binder-paper rounded-3xl p-6 md:p-8 relative my-4">

        <div class="absolute left-3 top-8 bottom-8 flex flex-col justify-between items-center z-10 hidden sm:flex">
            <div class="binder-hole"></div>
            <div class="binder-hole"></div>
            <div class="binder-hole"></div>
            <div class="binder-hole"></div>
            <div class="binder-hole"></div>
            <div class="binder-hole"></div>
        </div>

        <div class="washi-tape -top-3 left-12 -rotate-6 z-10"></div>
        <div class="washi-tape -top-3 right-8 rotate-3 bg-[#BBF1D2]/80 z-10"></div>

        <div class="sm:pl-5">

            <div class="text-center mb-6">
                <h1 class="text-4xl font-bold text-[#4E342E] font-handwriting tracking-wide">
                    🔑 Masuk ke Diary 🌸
                </h1>
                <p class="font-diary text-gray-600 text-base mt-1 font-semibold">
                    Silakan masuk untuk melihat catatan keuanganmu
                </p>
            </div>

            @if ($errors->any())
                <div class="paper-scrap p-3 rounded-2xl text-left font-diary text-sm mb-5 bg-[#FF9D9D]/20 border-[#FF9D9D] text-[#C2185B]">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4 font-diary">
                @csrf

                <div>
                    <label for="email" class="text-sm font-bold text-[#4E342E] block">
                        ✉️ Alamat Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        placeholder="contoh@gmail.com" 
                        class="w-full mt-1 p-2.5 text-sm bg-[#FDF5E6] border-2 border-[#E0D7C6] rounded-xl focus:outline-none focus:border-[#FFC5AA] font-sans">
                </div>

                <div>
                    <label for="password" class="text-sm font-bold text-[#4E342E] block">
                        🔒 Kata Sandi
                    </label>
                    <input id="password" type="password" name="password" required 
                        placeholder="••••••••" 
                        class="w-full mt-1 p-2.5 text-sm bg-[#FDF5E6] border-2 border-[#E0D7C6] rounded-xl focus:outline-none focus:border-[#FFC5AA] font-sans">
                </div>

                <div class="flex items-center justify-between text-xs font-sans text-gray-600 pt-1">
                    <label class="flex items-center gap-1.5 cursor-pointer font-diary text-sm">
                        <input type="checkbox" name="remember" class="rounded border-[#E0D7C6] text-[#FFC5AA] focus:ring-0">
                        <span>Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-diary text-sm text-[#C2185B] hover:underline font-bold">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full mt-2 bg-[#FFC5AA] hover:bg-[#FF9D9D] text-[#4E342E] font-handwriting text-2xl font-bold py-2.5 rounded-xl transition-all shadow-sm border-2 border-[#8D6E63]/20">
                    Masuk Sekarang 💖
                </button>
            </form>

            <div class="mt-6 pt-4 border-t-2 border-dashed border-[#D7CCC8] text-center font-diary text-sm text-gray-600">
                Belum punya akun diary? 
                <a href="{{ route('register') }}" class="text-[#2E7D32] font-bold hover:underline">
                    Daftar di sini ✨
                </a>
            </div>

        </div>

    </div>

</body>
</html>