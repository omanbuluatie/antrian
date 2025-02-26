<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Loket;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Tampilkan panel admin dengan data jumlah loket saat ini
    public function index()
    {
        $currentLoketCount = Loket::count();
        return view('admin.index', compact('currentLoketCount'));
    }

    // Reset nomor urut dengan mengosongkan tabel antrian
    public function resetQueue(Request $request)
    {
        // Nonaktifkan pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Lakukan truncate pada tabel antrians
        DB::table('antrians')->truncate();

        // Aktifkan kembali pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect()->back()->with('success', 'Nomor antrian telah direset.');
    }




    // Update jumlah loket: misal, jika ada 4 loket, maka tabel loket akan diupdate menjadi loket 1, 2, 3, dan 4.
    public function updateLoket(Request $request)
    {
        $request->validate([
            'jumlah_loket' => 'required|integer|min:1|max:10'
        ]);

        $jumlah = $request->input('jumlah_loket');

        // Nonaktifkan pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate tabel lokets
        DB::table('lokets')->truncate();

        // Aktifkan kembali pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Buat ulang lokets berdasarkan jumlah yang diinput
        for ($i = 1; $i <= $jumlah; $i++) {
            Loket::create([
                'nama' => 'Loket ' . $i
            ]);
        }

        return redirect()->back()->with('success', 'Jumlah loket telah diperbarui menjadi ' . $jumlah);
    }

}
