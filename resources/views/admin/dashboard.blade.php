<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Analitik & Statistik PPDB 2026 - Administrator</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-200">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 text-sm sm:text-base leading-tight">Executive Dashboard PPDB 2026</h1>
                    <p class="text-xs text-slate-500">Live Analytics, Kuota & Arus Kas Pendaftaran</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('admin.assessment.index') }}" class="px-3 py-1.5 rounded-lg bg-teal-50 text-teal-700 border border-teal-200 text-xs font-bold hover:bg-teal-100 transition">
                    <i class="fa-solid fa-clipboard-check mr-1"></i> Asesmen
                </a>
                <a href="{{ route('admin.settings.index') }}" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold hover:bg-slate-200 transition">
                    <i class="fa-solid fa-sliders mr-1"></i> Kuota
                </a>
                <a href="{{ route('verifikator.dashboard') }}" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold hover:bg-emerald-100 transition">
                    <i class="fa-solid fa-user-check mr-1"></i> Verifikator
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Logout">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-6">

        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- 1. Total Pendaftar -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pendaftar</span>
                    <span class="text-2xl font-black text-slate-900 mt-1 block font-mono">{{ $totalRegistrations }}</span>
                    <span class="text-[11px] font-semibold text-emerald-600 mt-1 inline-flex items-center">
                        <i class="fa-solid fa-arrow-trend-up mr-1"></i> Realtime Aktif
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <!-- 2. Terverifikasi / Lulus -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Lolos / Diterima</span>
                    <span class="text-2xl font-black text-emerald-700 mt-1 block font-mono">{{ $passedRegistrations }}</span>
                    <span class="text-[11px] text-slate-400 mt-1 block">Telah diverifikasi panitia</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </div>

            <!-- 3. Total Uang Masuk -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Kas PPDB</span>
                    <span class="text-2xl font-black text-slate-900 mt-1 block font-mono">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    <span class="text-[11px] text-emerald-600 mt-1 block font-semibold">Kasir & Transfer Bank</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-vault"></i>
                </div>
            </div>

            <!-- 4. Santri Mukim (Asrama) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Santri Asrama</span>
                    <span class="text-2xl font-black text-blue-700 mt-1 block font-mono">{{ $boardingCount }} / {{ $totalRegistrations }}</span>
                    <span class="text-[11px] text-slate-400 mt-1 block">Program Pesantren</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-hotel"></i>
                </div>
            </div>
        </div>

        <!-- Charts Grid (2 Kolom) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chart 1: Distribusi Klaster Kurikulum Merdeka -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                <div class="border-b border-slate-100 pb-3 mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm">Distribusi Peminatan Klaster</h3>
                        <p class="text-xs text-slate-400">Pilihan Kurikulum Merdeka Pendaftar</p>
                    </div>
                    <span class="text-xs font-bold text-teal-700 bg-teal-50 px-2 py-1 rounded-lg">Persentase Kursi</span>
                </div>
                <div class="relative h-64 flex items-center justify-center">
                    <canvas id="clusterChart"></canvas>
                </div>
            </div>

            <!-- Chart 2: Status Verifikasi Pendaftar -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                <div class="border-b border-slate-100 pb-3 mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm">Status Alur Berkas Registrasi</h3>
                        <p class="text-xs text-slate-400">Tahapan Pendaftar Berjalan</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg">Live Status</span>
                </div>
                <div class="relative h-64 flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Action & Recent Tables Link -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
            <div>
                <h3 class="text-base font-extrabold text-white">Ekspor & Integrasi Data Nasional</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-xl">Unduh berkas pendaftar berstatus lolos langsung dalam format skema resmi EMIS Kemenag & Dapodik Kemendikbudristek.</p>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('admin.export.emis') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition flex items-center space-x-1.5 shadow">
                    <i class="fa-solid fa-file-excel"></i>
                    <span>Ekspor EMIS 4.0</span>
                </a>
                <a href="{{ route('admin.export.dapodik') }}" class="px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs transition flex items-center space-x-1.5 shadow">
                    <i class="fa-solid fa-file-csv"></i>
                    <span>Ekspor Dapodik</span>
                </a>
            </div>
        </div>

    </main>

    <!-- Inisialisasi Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Cluster Chart (Doughnut)
            const ctxCluster = document.getElementById('clusterChart').getContext('2d');
            new Chart(ctxCluster, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($clusterLabels) !!},
                    datasets: [{
                        data: {!! json_encode($clusterCounts) !!},
                        backgroundColor: ['#0f766e', '#059669', '#0284c7', '#d97706', '#64748b'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', size: 11 } } }
                    }
                }
            });

            // 2. Status Chart (Bar)
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'bar',
                data: {
                    labels: ['Draft / Pending', 'Menunggu Bayar', 'Sudah Bayar', 'Perlu Revisi', 'Approved / Lulus'],
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: {!! json_encode($statusCounts) !!},
                        backgroundColor: ['#94a3b8', '#f59e0b', '#0284c7', '#f43f5e', '#10b981'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        });
    </script>

</body>
</html>

