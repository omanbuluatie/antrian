<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Loket;

class OperatorController extends Controller
{
    public function index()
    {
        // Ambil semua loket dan antrian
        $lokets = Loket::all();
        $antrians = Antrian::orderBy('created_at', 'asc')->get();
        // Ambil nomor terakhir yang terpanggil
        $lastAntrian = Antrian::where('status', 'called')->orderBy('created_at', 'desc')->first();
        return view('operator', compact('lokets', 'antrians', 'lastAntrian'));
    }

    public function callNext(Request $request)
    {
        $request->validate([
            'loket_id' => 'required|exists:lokets,id'
        ]);

        // Mengambil nomor terakhir secara global dengan casting ke integer
        $lastNum = Antrian::selectRaw("MAX(CAST(nomor AS UNSIGNED)) as max_nomor")
            ->value('max_nomor');
        $nextNum = $lastNum ? ((int) $lastNum + 1) : 1;

        // Insert data antrian baru dengan nomor global berikutnya dan loket yang dipilih
        $antrian = new Antrian();
        $antrian->nomor = $nextNum;
        $antrian->loket_id = $request->loket_id;
        $antrian->status = 'called';
        $antrian->save();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Nomor antrian ' . $nextNum . ' berhasil dipanggil.']);
        }

        return redirect()->back()->with('success', 'Nomor antrian ' . $nextNum . ' berhasil dipanggil.');
    }




    public function callAgain(Request $request)
    {
        $request->validate([
            'loket_id' => 'required|exists:lokets,id'
        ]);

        // Cari antrian terakhir yang terpanggil untuk loket tersebut berdasarkan id
        $antrian = Antrian::where('loket_id', $request->loket_id)
            ->where('status', 'called')
            ->orderBy('id', 'desc')
            ->first();

        if ($antrian) {
            // Memperbarui kolom updated_at agar trigger ulang pengumuman di display
            $antrian->touch();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Nomor antrian ' . $antrian->nomor . ' berhasil dipanggil ulang.']);
            }

            return redirect()->back()->with('success', 'Nomor antrian ' . $antrian->nomor . ' berhasil dipanggil ulang.');
        }

        if ($request->wantsJson()) {
            return response()->json(['error' => 'Tidak ada antrian yang terpanggil untuk loket ini.'], 400);
        }

        return redirect()->back()->with('error', 'Tidak ada antrian yang terpanggil untuk loket ini.');
    }

}
