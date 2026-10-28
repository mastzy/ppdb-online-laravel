<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panitia & Kasir PPDB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            margin: 0;
            padding: 20px;
        }
        .form-card {
            background: white;
            padding: 35px;
            border-radius: 16px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }
        .form-card h2 {
            margin: 0 0 6px 0;
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }
        .form-card p {
            margin: 0 0 20px 0;
            font-size: 13px;
            color: #64748b;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
            font-size: 13px;
            color: #334155;
        }
        .form-group input {
            width: 100%;
            padding: 10px 14px;
            box-sizing: border-box;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #0284c7;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #0284c7;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
        }
        .btn:hover {
            background: #0369a1;
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="form-card">
        <h2>Login Panitia PPDB</h2>
        <p>Akses Administrator, Verifikator & Bendahara/Kasir</p>

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email / Akun Panitia</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@ppdb.test / bendahara@ppdb.test" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Masuk ke Sistem</button>
        </form>
    </div>
</body>
</html>
