<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Akun Admin Awal (Seeder)
    |--------------------------------------------------------------------------
    |
    | Kredensial akun administrator pertama yang dibuat oleh seeder.
    | Nilai diambil dari file .env agar tidak di-hardcode di repository.
    | Hanya satu akun admin yang di-seed; user & role lain dikelola dari
    | Panel Admin > Manajemen Akses.
    |
    */

    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL', 'rztechdevidn@gmail.com'),
        'password' => env('ADMIN_PASSWORD', '12345678'),
    ],

];
