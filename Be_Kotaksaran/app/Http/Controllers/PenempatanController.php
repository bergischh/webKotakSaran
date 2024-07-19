<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenempatanController extends Controller
{

    public function index()
    {
        $show = DB::select("SELECT * FROM penempatan");
        if ($show) {
            return response()->json([
                'success' => true,
                'data' => $show,
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
        'nama_penempatan' => 'required|string',
    ]);

    $nama = $request->input('nama_penempatan');
        $now = Carbon::now('Asia/Jakarta');

        try {
            $existingCategory = DB::table('penempatan')->where('nama_penempatan', $nama)->first();
    
            if ($existingCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'penempatan dengan nama ini sudah ada'
                ], 400);
            }
    
            DB::insert('INSERT INTO penempatan(nama_penempatan, created_at)values(?,?)',[$nama,$now]);
    
            $newCategory =  DB::select('SELECT * FROM penempatan WHERE id = :id', ['id' => DB::getPdo()->lastInsertId()]);
    
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
