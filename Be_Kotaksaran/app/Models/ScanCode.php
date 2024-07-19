<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanCode extends Model
{
    protected $table = 'qrcode';

    protected $fillable = [
        'kategori_id', 'penempatan_id', 'qr_code_value', 'qr_code_image',
    ];

    // Define relationships if needed
}