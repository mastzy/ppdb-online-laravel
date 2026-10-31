<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - PPDB Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-teal-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-6 text-center border border-teal-200">
        <div class="flex items-center justify-center mb-4">
            <svg class="w-16 h-16 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m5 4H5a2 2 0 01-2-2V7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v9a2 2 0 01-2 2z"></path></svg>
        </div>
        <h1 class="text-2xl font-bold text-teal-800 mb-2">Anda sedang offline</h1>
        <p class="text-gray-600 mb-6">Data draf pendaftaran Anda aman tersimpan di HP.</p>
        <button onclick="window.location.reload()" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M4 20v-5h.582M20 4v5h-.581M12 12v6m0-6l-3 3m3-3l3 3"></path></svg>
            Coba Lagi
        </button>
    </div>
</body>
</html>

