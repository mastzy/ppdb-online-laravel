<h2>Dashboard Calon Siswa</h2>

@if(session('success')) <p style="color:green;">{{ session('success') }}</p> @endif
@if(session('error')) <p style="color:red;">{{ session('error') }}</p> @endif

<!-- Form Simpan Draft / Finalisasi -->
<form action="{{ route('registration.draft') }}" method="POST">
    @csrf
    <select name="jalur">
        <option value="zonasi">Zonasi</option>
        <option value="prestasi">Prestasi</option>
        <option value="afirmasi">Afirmasi</option>
        <option value="perpindahan">Perpindahan Orang Tua</option>
    </select>
    <button type="submit">Simpan Draft</button>
</form>

<form action="{{ route('registration.finalize') }}" method="POST" style="margin-top:10px;">
    @csrf
    <button type="submit" onclick="return confirm('Kunci data secara permanen?')">Finalisasi Pendaftaran</button>
</form>

<hr>

<!-- Form Unggah Berkas -->
<h3>Unggah Berkas Persyaratan (PDF/JPG/PNG max 2MB)</h3>
<form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <select name="type">
        <option value="ijazah">Ijazah / SKL</option>
        <option value="kk">Kartu Keluarga</option>
        <option value="akta">Akta Kelahiran</option>
    </select>
    <input type="file" name="file" accept=".pdf,.jpg,.png" required>
    <button type="submit">Unggah</button>
</form>

<hr>

<!-- Cetak Kartu Pendaftaran PDF -->
<a href="{{ route('registration.card.pdf') }}">Unduh Kartu Pendaftaran (PDF & QR Code)</a>