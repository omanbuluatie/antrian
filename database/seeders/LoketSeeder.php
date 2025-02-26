<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loket;

class LoketSeeder extends Seeder
{
    public function run()
    {
        // Optional: Bersihkan data lama (truncate) jika diperlukan
        Loket::truncate();

        // Membuat data dummy untuk loket
        Loket::create([
            'nama' => 'Loket 1',
            'keterangan' => 'Loket utama'
        ]);
        Loket::create([
            'nama' => 'Loket 2',
            'keterangan' => 'Loket pendukung'
        ]);
        Loket::create([
            'nama' => 'Loket 3',
            'keterangan' => 'Loket VIP'
        ]);
    }
}
