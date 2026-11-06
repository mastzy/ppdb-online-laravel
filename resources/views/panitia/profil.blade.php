<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil Panitia - PPDB Online</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    <!-- Header Navigation -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-200">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 text-sm sm:text-base leading-tight">Pengaturan Akun Panitia</h1>
                    <p class="text-xs text-slate-500">Kelola identitas akun dan keamanan kata sandi</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-line text-teal-600"></i>
                        <span>Dashboard</span>
                    </a>
                @elseif(auth()->user()->role === 'bendahara')
                    <a href="{{ route('bendahara.kasir') }}" class="px-3 py-1.5 rounded-lg border border-amber-200 bg-amber-50 text-xs font-bold text-amber-800 hover:bg-amber-100 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-cash-register"></i>
                        <span>Kasir</span>
                    </a>
                @else
                    <a href="{{ route('verifikator.dashboard') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Dashboard</span>
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Logout">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-6">

        <!-- Global Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm animate-fade-in">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                <div class="text-xs">
                    <h4 class="font-bold text-sm">Operasi Berhasil!</h4>
                    <p class="mt-0.5 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Card 1: Informasi Akun Panitia -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Informasi Akun Panitia</h2>
                            <p class="text-xs text-slate-500 font-medium">Perbarui nama lengkap dan alamat surel operasional</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('panitia.profil.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('name') border-rose-500 ring-1 ring-rose-500 @else border-slate-300 @enderror text-slate-900 text-sm font-semibold rounded-xl focus:ring-teal-500 focus:border-teal-500 transition">
                            </div>
                            @error('name')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('email') border-rose-500 ring-1 ring-rose-500 @else border-slate-300 @enderror text-slate-900 text-sm font-semibold rounded-xl focus:ring-teal-500 focus:border-teal-500 transition">
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role / Jabatan (Readonly badge) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Role / Hak Akses Sistem
                            </label>
                            <div class="flex items-center space-x-2 py-2 px-3.5 rounded-xl bg-slate-100 border border-slate-200">
                                <span class="px-2.5 py-0.5 rounded-lg text-xs font-black uppercase tracking-wider bg-teal-700 text-white">
                                    {{ $user->role }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">Username: <strong>{{ $user->username }}</strong></span>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-2.5 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-teal-700/20 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Profil</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card 2: Keamanan & Ganti Password -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900">Keamanan & Kata Sandi</h2>
                            <p class="text-xs text-slate-500 font-medium">Pastikan menggunakan kombinasi kata sandi yang aman</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('panitia.profil.password') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Password Saat Ini -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Password Saat Ini
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" name="current_password" required placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('current_password') border-rose-500 ring-1 ring-rose-500 @else border-slate-300 @enderror text-slate-900 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition">
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Password Baru (Min. 8 Karakter)
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('password') border-rose-500 ring-1 ring-rose-500 @else border-slate-300 @enderror text-slate-900 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition">
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                                    <i class="fa-solid fa-check-double"></i>
                                </span>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 text-slate-900 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-emerald-700/20 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-key"></i>
                                <span>Perbarui Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </main>

</body>
</html>
