<h2>Dashboard Verifikasi Panitia</h2>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nama</th>
            <th>NISN</th>
            <th>Jalur</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($registrations as $reg)
        <tr>
            <td>{{ $reg->user->name }}</td>
            <td>{{ $reg->user->nisn }}</td>
            <td>{{ strtoupper($reg->jalur) }}</td>
            <td>{{ strtoupper($reg->status) }}</td>
            <td>
                <form action="{{ route('verifikator.verify', $reg->id) }}" method="POST">
                    @csrf
                    <select name="status" required>
                        <option value="approved">Approved</option>
                        <option value="revision_needed">Revision Needed</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <input type="text" name="catatan_koreksi" placeholder="Catatan jika ditolak/revisi">
                    <button type="submit">Simpan Status</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>