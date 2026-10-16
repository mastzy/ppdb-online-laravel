use App\Models\Document;
use Illuminate\Support\Facades\Storage;

public function preview(Document $document)
{
    // Memastikan file tersimpan di storage private
    if (!Storage::disk('private')->exists($document->hashed_path)) {
        abort(404, 'File dokumen tidak ditemukan.');
    }

    $file = Storage::disk('private')->get($document->hashed_path);
    $type = Storage::disk('private')->mimeType($document->hashed_path);

    return response($file, 200)->header('Content-Type', $type);
}