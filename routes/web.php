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
Route::prefix('/programlatihan')->controller(ProgramLatihanController::class)->group(function () {
    Route::get('/trainee', 'programlatihan')->name('latihan');
    Route::get('/trainer', 'programlatihan_trainer')->name('latihan-trainer');

    // CRUD
    Route::post('/', 'store')->name('program.store');

        // CRUD
    Route::post('/update/{id}', 'update')->name('program.update');
    Route::get('/delete/{id}', 'destroy')->name('program.delete');
});




//RESEP MAKAN
Route::prefix('/resepmakan')->controller(ResepMakanController::class)->group(function(){
    // Route::get('/', 'index')->name('resep');
    Route::get('/trainee', 'indexTrainee')->name('resep-trainee');
// Hapus POST trainee karena trainee tidak bisa tambah data

   

    // TRAINER
    Route::get('/', 'index')->name('resep');
    Route::get('/trainer', 'indexTrainer')->name('resep-trainer');
    Route::post('/trainer', 'store')->name('resep-trainer');

    // CRUD
    Route::put('{id}', 'update');
    Route::delete('/{id}', 'destroy')->name('resep.destroy');
});


//AUTENTIKASI
Route::prefix("/")->controller(AuthController::class)->group(function(){
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginProcess')->name('login.process');

    Route::get('/daftar', 'daftar')->name('register');
    Route::post('/daftar', 'registerProcess')->name('register.process');

    Route::post('/logout', 'logout')->name('logout');
});


//BERANDA  
Route::prefix('/beranda')->middleware('auth')->controller(BerandaController::class)->group(function(){
    Route::get('/', 'beranda')->name('beranda');
    Route::post('/', 'beranda')->name('beranda');
    Route::get('/trainer', 'beranda_trainer')->name('beranda-trainer');
});

// Middleware untuk role
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('pages.beranda');
    });
});


// FEEDBACK
Route::middleware(['auth'])->group(function () {
    Route::post('/programlatihan/feedback/{id}', [ProgramLatihanController::class, 'submitFeedback'])->name('programlatihan.feedback');

    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
});
