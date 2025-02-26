<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OTP;
use Illuminate\Support\Facades\Http;

class OTPController extends Controller
{
    // Menampilkan form OTP
    public function showForm(Request $request)
    {
        return view('otp');
    }

    // Mengirim OTP
    public function sendOTP(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string',
        ]);

        $nomor = $request->input('nomor');

        // Hapus OTP lama jika ada
        OTP::where('nomor', $nomor)->delete();

        // Generate OTP 6 digit dan waktu sekarang
        $otp   = rand(100000, 999999);
        $waktu = time();

        OTP::create([
            'nomor' => $nomor,
            'otp'   => $otp,
            'waktu' => $waktu,
        ]);

        $data = [
            'target'  => $nomor,
            'message' => "Terimakasih telah menggunakan layanan kami.\n\nBerikut adalah kode OTP Anda: \n\n *" . $otp . "*. \n\nSilakan masukkan kode ini untuk melanjutkan proses selanjutnya. \nDemi Keamanan jangan bagikan kode ini kepada siapapun.",
        ];
        

        // Kirim request ke API Fonnte
        $response = Http::withHeaders([
            'Authorization' => '',
        ])->asForm()->post('https://api.fonnte.com/send', $data);

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Gagal mengirim OTP.');
        }

        // Simpan nomor di session agar form selanjutnya menampilkan field OTP saja
        return redirect()->back()->with('success', 'OTP telah dikirim!')->with('nomor', $nomor);
    }

    // Memverifikasi OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string',
            'otp'   => 'required|numeric',
        ]);

        $nomor = $request->input('nomor');
        $otp   = $request->input('otp');

        $record = OTP::where('nomor', $nomor)
                     ->where('otp', $otp)
                     ->first();

        if ($record) {
            if (time() - $record->waktu <= 300) {
                $record->delete();
                return redirect()->back()->with('success', 'OTP benar');
            } else {
                return redirect()->back()->with('error', 'OTP expired');
            }
        }

        return redirect()->back()->with('error', 'OTP salah');
    }
}
