<?php

namespace App\Http\Controllers;

use App\Models\ScanCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeController extends Controller
{
    public function index()
    {

        $qrcode = DB::select('SELECT * FROM qrcode ORDER BY created_at ASC');
        $penempatanData = DB::select('SELECT * FROM penempatan');
        $kategoriData = DB::select('SELECT * FROM kategori');

        $penempatanMap = [];
        foreach ($penempatanData as $penempatan) {
            $penempatanMap[$penempatan->id] = $penempatan->nama_penempatan;
        }
        $kategoriMap = [];
        foreach ($kategoriData as $kategori) {
            $kategoriMap[$kategori->id] = $kategori->nama_kategori;
        }

        foreach ($qrcode as $entry) {
            $entry->nama_kategori = $kategoriMap[$entry->kategori_id];
            unset($entry->kategori_id);

            $entry->nama_penempatan = $penempatanMap[$entry->penempatan_id];
            unset($entry->penempatan_id);
        }

        if ($qrcode) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil',
                'data' => $qrcode,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal',
            ], 400);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kategori_id' => 'required|exists:kategori,id',
            'penempatan_id' => 'required|exists:penempatan,id',
        ]);

        $kategoriId = $request->input('kategori_id');
        $penempatanId = $request->input('penempatan_id');

        // Generate nilai QR code
        $qrCodeValue = DB::select(
            "SELECT CONCAT(k.id, '-', k.nama_kategori, '-', p.id, '-', p.nama_penempatan) AS qr_code_value 
                                FROM kategori k 
                                JOIN penempatan p 
                                WHERE k.id = :kategoriId AND p.id = :penempatanId",
            ['kategoriId' => $kategoriId, 'penempatanId' => $penempatanId]
        )[0]->qr_code_value;

        // Simpan data QR code ke database
        $qrCode = ScanCode::create([
            'kategori_id' => $kategoriId,
            'penempatan_id' => $penempatanId,
            'qr_code_value' => $qrCodeValue,
        ]);

        // Generate gambar QR code
        $qrCodeImage = QrCode::format('png')->size(200)->generate($qrCodeValue);

        // Simpan gambar QR code ke direktori public/qrcode_images
        $imageName = "qr_code_{$qrCode->id}.png";
        file_put_contents(public_path("qrcode_images/{$imageName}"), $qrCodeImage);

        // Update path gambar QR code ke dalam database
        $qrCode->update(['qr_code_image' => $imageName]);
        return response()->json([
            'message' => 'QR Code berhasil di-generate dan disimpan.',
            'data' => $qrCode,
        ]);
    }

    public function downloadQrCode() {
        $imageName = "qr_code.png";

        $header = array('Content-type' => ['png', 'svg', 'eps']);
        
        $qrCode = QrCode::format('png')->size(200)->generate();

        return response()->download('storage/'.$imageName, $imageName.'png', $header);
    }
} 
