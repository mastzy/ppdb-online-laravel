<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan (404) - PPDB Online</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="fixed inset-0 pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-md w-full text-center">
        <div class="w-20 h-20 rounded-3xl bg-emerald-950 border border-emerald-500/30 text-emerald-400 mx-auto flex items-center justify-center text-3xl font-black mb-6 shadow-2xl">
            404
        </div>

        <h1 class="text-2xl font-black text-white">Halaman Tidak Ditemukan</h1>
        <p class="text-xs text-slate-400 mt-2 leading-relaxed">
            Mohon maaf, halaman yang Anda tuju mungkin telah dipindahkan, berganti tautan, atau alamat URL yang dimasukkan kurang tepat.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs shadow-lg shadow-emerald-950 transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-house"></i>
                <span>Kembali ke Beranda Utama</span>
            </a>
            <a href="https://wa.me/6281234567890?text=Halo%20Panitia%20PPDB,%20saya%20mengalami%20kendala%20halaman%20tidak%20ditemukan."
               target="_blank" class="w-full sm:w-auto px-5 py-3 rounded-xl border border-slate-700 bg-slate-800 hover:bg-slate-700 text-emerald-400 font-bold text-xs transition flex items-center justify-center space-x-2">
                <i class="fa-brands fa-whatsapp"></i>
                <span>Hubungi CS Panitia</span>
            </a>
        </div>
    </div>

</body>
</html>

