<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class KotaksaranController extends Controller
{
    public function index()
    {
        $saran = DB::table('kotaksaran')->orderBy('created_at', 'ASC')->get();

        $penempatanData = DB::table('penempatan')->get();
        $kategoriData = DB::table('kategori')->get();

        $penempatanMap = $penempatanData->pluck('nama_penempatan', 'id')->all();
        $kategoriMap = $kategoriData->pluck('nama_kategori', 'id')->all();

        foreach ($saran as $entry) {
            $entry->nama_kategori = $kategoriMap[$entry->kategori_id];
            unset($entry->kategori_id);

            $entry->nama_penempatan = $penempatanMap[$entry->penempatan_id];
            unset($entry->penempatan_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil',
            'data' => $saran,
        ], 200);
    }

    public function chart()
    {
        $chart = DB::table('kotaksaran')->orderBy('created_at', 'ASC')->get();

        $penempatanData = DB::table('penempatan')->get();
        $penempatanMap = $penempatanData->pluck('nama_penempatan', 'id')->all();

        foreach ($chart as $entry) {
            $entry->nama_penempatan = $penempatanMap[$entry->penempatan_id];
            unset($entry->penempatan_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil',
            'data' => $chart,
        ], 200);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'penempatan_id' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'no_telepon' => 'required',
            'kategori_id' => 'required',
            'saran' => 'required|max:255',
            'foto.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Menggunakan 'foto.*' untuk mendapatkan multiple images
        ]);

        $penempatanId = $request->input('penempatan_id');
        $nama = $request->input('nama');
        $email = $request->input('email');
        $noTelp = $request->input('no_telepon');
        $kategoriId = $request->input('kategori_id');
        $saran = $request->input('saran');
        $fotos = $request->file('foto');

        $penempatan = DB::select('SELECT * FROM penempatan WHERE id = ?', [$penempatanId]);

        if (!$penempatan) {
            return response()->json([
                'success' => false,
                'message' => 'Penempatan tidak ditemukan',
            ], 404);
        }

        $kategori = DB::select('SELECT * FROM kategori WHERE id = ?', [$kategoriId]);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        $now = Carbon::now('Asia/Jakarta');

        $imageName = [];

        foreach ($fotos as $foto) {
            $fotoFileName = $now->timestamp . '-' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('kotaksaran_images'), $fotoFileName);
            $imageName[] = $fotoFileName;
        }

        $foto = implode(",", $imageName);

        $hasil = DB::insert("INSERT INTO kotaksaran (penempatan_id, nama, email, no_telepon, kategori_id, saran, foto, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", [$penempatanId, $nama, $email, $noTelp, $kategoriId, $saran, $foto, $now]);

        if ($hasil) {
            return response()->json([
                'success' => true,
                'message' => "Data Berhasil Ditambahkan",
                'data' => $hasil,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data kotak saran',
            ], 400);
        }
    }

    public function delete($id)
    {
        $saran = DB::table('kotaksaran')->where('id', $id)->first();

        if (!$saran) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        $fotoFileName = $saran->foto;

        if ($fotoFileName) {
            $imagePath = public_path('kotaksaran_images/' . $fotoFileName);

            if (file_exists($imagePath)) {
                // dd($imagePath);

                unlink($imagePath);
            } else {
                dd("File does not exist: $imagePath");
            }
        }

        DB::table('kotaksaran')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data and associated image deleted successfully',
        ], 200);
    }
}
