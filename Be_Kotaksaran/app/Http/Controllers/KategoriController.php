<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriController extends Controller
{

    public function index()
    {
        $show = DB::select("SELECT * FROM kategori");
        if ($show) {
            return response()->json([
                'success' => true,
                'data' => $show
            ], 200);
        } else {
            return response()->json([
                'success' => false, 
                'message' => 'gagal',
            ], 400);
        }
    }


public function store(Request $request)
{
    $this->validate($request, [
        'nama_kategori' => 'required|string',
    ]);

    $nama = $request->input('nama_kategori');
    $now = Carbon::now('Asia/Jakarta');

    try {
        $existingCategory = DB::table('kategori')->where('nama_kategori', $nama)->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori dengan nama ini sudah ada'
            ], 400);
        }

        DB::insert('INSERT INTO kategori(nama_kategori, created_at)values(?,?)',[$nama,$now]);

        $newCategory =  DB::select('SELECT * FROM kategori WHERE id = :id', ['id' => DB::getPdo()->lastInsertId()]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah data',
            'data' => $newCategory,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
