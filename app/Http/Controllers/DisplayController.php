<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Loket;

class DisplayController extends Controller
{
    public function index()
    {
        // Ambil data antrian yang statusnya 'called'
        $antrians = Antrian::where('status', 'called')->with('loket')->orderBy('updated_at', 'desc')->get();
        return view('display', compact('antrians'));
    }

    // Endpoint API untuk polling data antrian terbaru
    public function getLatestQueue()
    {
        $antrians = Antrian::where('status', 'called')->with('loket')->orderBy('updated_at', 'desc')->get();
        return response()->json($antrians);
    }
}
