<?php

use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProgresController;
use App\Http\Controllers\ProgramLatihanController;
use App\Http\Controllers\ResepMakanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;


//LANDING PAGES
Route::get('/', [LandingpageController::class, 'home'])->name('landing');
Route::prefix('landing')->controller(LandingpageController::class)->group(function (){
    Route::get('/about', 'about')->name('about');
    Route::get('/fitur', 'fitur')->name('fitur');
});

// NOTIFIKASI UNTUK TRAINEE
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
Route::patch('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');

// NOTIFIKASI UNTUK TRAINER (tambah + edit + hapus)
Route::get('/notifikasi/trainer', [NotifikasiController::class, 'indextrainer'])->name('notifikasi.trainer');
Route::post('/notifikasi', [NotifikasiController::class, 'store'])->name('notifikasi.store');
Route::put('/notifikasi/{id}', [NotifikasiController::class, 'update'])->name('notifikasi.update');
Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');



// PROGRES
Route::prefix('/progres')->controller(ProgresController::class)->group(function(){
    Route::get('/trainee', 'progres')->name('progres');
    Route::get('/trainer', 'progres_trainer')->name('progres-trainer');
});






// PROGRAM LATIHAN

Route::middleware(['auth'])->prefix('/programlatihan')->controller(ProgramLatihanController::class)->group(function () {

    // 📌 Tampilan untuk trainee (hanya lihat miliknya)
    Route::get('/trainee', 'programlatihan')->name('latihan');

    // 📌 Tampilan untuk trainer (lihat semua + form tambah)
    Route::get('/trainer', 'programlatihan_trainer')->name('latihan-trainer');

    // 📌 Default redirect
    Route::get('/', function () {
        return redirect()->route('latihan');
    })->name('program.index');

    // 📌 CRUD
    Route::post('/store', 'store')->name('program.store');
    Route::post('/update/{id}', 'update')->name('program.update');
    Route::get('/delete/{id}', 'destroy')->name('program.delete');
});





//RESEP MAKAN
Route::middleware(['auth'])->prefix('/resepmakan')->controller(ResepMakanController::class)->group(function () {

    // Role-based access
    Route::get('/trainee', 'index')->name('resep.trainee');
    Route::get('/trainer', 'indexTrainer')->name('resep.trainer');

    // Redirect default
    Route::get('/', function () {
        return redirect()->route('resep.trainee');
    })->name('resep.index');

    // CRUD
    Route::post('/store', 'store')->name('resep.store');
    Route::post('/update/{id}', 'update')->name('resep.update');
    Route::get('/delete/{id}', 'destroy')->name('resep.delete');
});


//AUTENTIKASI
Route::prefix("/")->controller(AuthController::class)->group(function(){
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginProcess')->name('login.process');

    Route::get('/daftar', 'daftar')->name('register');
    Route::post('/daftar', 'registerProcess')->name('register.process');

    Route::post('/logout', 'logout')->name('logout');
});

// BERANDA  

// Redirect ke halaman sesuai role (tetap jaga route lama)
Route::middleware(['auth'])->get('/beranda', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'trainer' => redirect()->route('beranda-trainer'),
        'trainee' => redirect()->route('beranda-trainee'),
        default => abort(403, 'Role tidak dikenali.'),
    };
})->name('beranda');

// Group beranda untuk role khusus
Route::prefix('/beranda')->middleware('auth')->controller(BerandaController::class)->group(function () {
    Route::get('/trainer', 'beranda_trainer')->name('beranda-trainer');
    Route::get('/trainee', 'beranda_trainee')->name('beranda-trainee');
});

// Middleware untuk role admin (biarkan tetap)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('pages.beranda');
    });
});


// FEEDBACK
Route::middleware(['auth'])->group(function () {
    Route::post('/programlatihan/feedback/{id}', [ProgramLatihanController::class, 'submitFeedback'])->name('programlatihan.feedback');
    Route::post('/resepmakan/feedback/{id}', [ResepMakanController::class, 'submitFeedback'])->name('resepmakan.feedback');
});

//UBAH PROFILE
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');