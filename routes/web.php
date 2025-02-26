<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\OTPController;





// Route::match(['get', 'post'], '/otp', [OTPController::class, 'index'])->name('otp');
Route::get('/otp', [OTPController::class, 'showForm'])->name('otp.form');
Route::post('/send-otp', [OTPController::class, 'sendOTP'])->name('otp.send');
Route::post('/verify-otp', [OTPController::class, 'verifyOTP'])->name('otp.verify');




Route::get('/display', [DisplayController::class, 'index'])->name('display');

// Route untuk polling data antrian secara real-time
Route::get('/api/antrian-terkini', [DisplayController::class, 'getLatestQueue'])->name('api.antrian-terkini');

// Route untuk tampilan operator (tambahkan middleware auth jika diperlukan)
Route::get('/operator', [OperatorController::class, 'index'])->name('operator');
Route::post('/operator/call-next', [OperatorController::class, 'callNext'])->name('operator.callNext');
Route::post('/operator/call-again', [OperatorController::class, 'callAgain'])->name('operator.callAgain');

Route::get('/api/antrian-all', function () {
    $antrians = \App\Models\Antrian::with('loket')->orderBy('created_at', 'asc')->get();
    $lastAntrian = \App\Models\Antrian::where('status', 'called')->orderBy('id', 'desc')->with('loket')->first();
    return response()->json([
        'antrians' => $antrians,
        'lastAntrian' => $lastAntrian,
    ]);
})->name('api.antrian-all');



Route::prefix('admin')->group(function () {
    Route::get('/panel', [AdminController::class, 'index'])->name('admin.panel');
    Route::post('/reset-queue', [AdminController::class, 'resetQueue'])->name('admin.resetQueue');
    Route::post('/update-loket', [AdminController::class, 'updateLoket'])->name('admin.updateLoket');
});



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
