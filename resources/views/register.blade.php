<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nama Lengkap" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="nik" maxlength="16" placeholder="NIK (16 Digit)" required>
    <input type="text" name="nisn" maxlength="10" placeholder="NISN (10 Digit)" required>
    <input type="password" name="password" placeholder="Password (Min 8 Karakter)" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
    <button type="submit">Daftar Akun</button>
</form>