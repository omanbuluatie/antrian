<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Antrian;

class AntrianSeeder extends Seeder
{
    public function run()
    {
        // Optional: Bersihkan data lama (truncate) jika diperlukan
        Antrian::truncate();

        // Data dummy untuk antrian dengan status 'waiting'
        Antrian::create([
            'nomor' => '1',
            'loket_id' => null,
            'status' => 'waiting'
        ]);
        Antrian::create([
            'nomor' => '2',
            'loket_id' => null,
            'status' => 'waiting'
        ]);

        // Data dummy untuk antrian yang sudah dipanggil (status 'called')
        // Pastikan loket_id sesuai dengan id yang ada di seeder loket
        Antrian::create([
            'nomor' => '3',
            'loket_id' => 1,
            'status' => 'called'
        ]);
        Antrian::create([
            'nomor' => '4',
            'loket_id' => 2,
            'status' => 'called'
        ]);
        Antrian::create([
            'nomor' => '5',
            'loket_id' => null,
            'status' => 'waiting'
        ]);
    }
}
