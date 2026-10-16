<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi PPDB Online</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background-color: #f4f6f9; }
        .card { background: white; padding: 40px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn { padding: 10px 20px; text-decoration: none; color: white; border-radius: 5px; margin: 5px; display: inline-block; }
        .btn-primary { background-color: #007bff; }
        .btn-success { background-color: #28a745; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Selamat Datang di PPDB Online</h1>
        <p>Sistem Penerimaan Peserta Didik Baru Terpadu dan Transparan[cite: 2]</p>
        <hr style="margin: 20px 0;">
        @auth
            <p>Halo, <strong>{{ auth()->user()->name }}</strong> (Role: {{ strtoupper(auth()->user()->role) }})</p>
            @if(auth()->user()->role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary">Masuk Dashboard Siswa</a>
            @else
                <a href="{{ route('verifikator.dashboard') }}" class="btn btn-primary">Masuk Dashboard Verifikator</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 15px;">
                @csrf
                <button type="submit" class="btn" style="background:#dc3545; border:none; cursor:pointer;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register.form') }}" class="btn btn-success">Daftar Akun Baru (NIK/NISN)</a>
        @endauth
    </div>
</body>
</html>