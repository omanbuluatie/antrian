<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Loket;
use App\Events\NomorDipanggil;

class QueueController extends Controller
{
    // Tampilkan halaman operator dengan daftar loket
    public function index()
    {
        $lokets = Loket::all();
        return view('operator.index', compact('lokets'));
    }

    // Proses pemanggilan nomor antrian
    public function callNext(Request $request)
    {
        $request->validate([
            'loket_id' => 'required|exists:lokets,id',
        ]);

        // Ambil nomor antrian selanjutnya yang statusnya pending untuk loket terpilih
        $nextNumber = Antrian::where('loket_id', $request->loket_id)
            ->where('status', 'pending')
            ->orderBy('id', 'asc')
            ->first();

        if (!$nextNumber) {
            return redirect()->back()->with('error', 'Tidak ada antrian.');
        }

        // Update status menjadi dipanggil
        $nextNumber->update(['status' => 'dipanggil']);

        // Broadcast event ke channel antrian
        broadcast(new NomorDipanggil($nextNumber))->toOthers();

        return redirect()->back()->with('success', "Nomor {$nextNumber->nomor} telah dipanggil untuk loket ID: {$request->loket_id}");
    }
}
