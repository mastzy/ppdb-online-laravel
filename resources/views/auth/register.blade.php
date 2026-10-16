<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun PPDB</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f4f6f9; }
        .form-card { background: white; padding: 30px; border-radius: 8px; width: 350px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2>Registrasi Calon Siswa</h2>
        
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>NIK (16 Digit)</label>
                <input type="text" name="nik" maxlength="16" value="{{ old('nik') }}" placeholder="3301xxxxxxxxxxxx" required>
            </div>
            <div class="form-group">
                <label>NISN (10 Digit)</label>
                <input type="text" name="nisn" maxlength="10" value="{{ old('nisn') }}" placeholder="001xxxxxxx" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn">Daftar Akun</button>
        </form>
        <p style="text-align: center; margin-top: 15px;">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>
</body>
</html>