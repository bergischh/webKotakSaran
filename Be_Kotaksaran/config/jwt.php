<?php
return [
    /*
    |--------------------------------------------------------------------------
    | JWT TTL (Time To Live)
    |--------------------------------------------------------------------------
    |
    | This option controls the default TTL for tokens in seconds.
    |
    */
    'ttl' => env('JWT_TTL', 604800), // Satu minggu dalam detik (60 detik * 60 menit * 24 jam * 7 hari)
];
