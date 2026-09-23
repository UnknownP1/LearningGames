<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| MENU UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');


/*
|--------------------------------------------------------------------------
| BELAJAR WARNA
|--------------------------------------------------------------------------
*/

Route::get('/warna', function () {
    return Inertia::render('Learn');
})->name('colors.learn');


/*
|--------------------------------------------------------------------------
| QUIZ WARNA
|--------------------------------------------------------------------------
*/

Route::get('/warna/quiz', function () {
    return Inertia::render('Quiz');
})->name('colors.quiz');

/*
|--------------------------------------------------------------------------
| PENGENALAN HEWAN
|--------------------------------------------------------------------------
*/

Route::get('/hewan', function () {
    return Inertia::render('Animals');
})->name('animals.learn');

/*
|--------------------------------------------------------------------------
| QUIZ HEWAN
|--------------------------------------------------------------------------
*/

Route::get('/hewan/quiz', function () {
    return Inertia::render('AnimalQuiz');
})->name('animals.quiz');

/*
|--------------------------------------------------------------------------
| PENGENALAN BANGUNAN
|--------------------------------------------------------------------------
*/

Route::get('/bangunan', function () {
    return Inertia::render('Building');
})->name('building.learn');

/*
|--------------------------------------------------------------------------
| QUIZ BANGUNAN
|--------------------------------------------------------------------------
*/

Route::get('/bangunan/quiz', function () {
    return Inertia::render('BuildingQuiz');
})->name('building.quiz');

/*
|--------------------------------------------------------------------------
| PENGENALAN BENTUK
|--------------------------------------------------------------------------
*/

Route::get('/bentuk', function () {
    return Inertia::render('Shapes');
})->name('Shapes.learn');

/*
|--------------------------------------------------------------------------
| QUIZ BENTUK
|--------------------------------------------------------------------------
*/

Route::get('/bentuk/quiz', function () {
    return Inertia::render('ShapesQuiz');
})->name('Shapes.quiz');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});





Route::get('/alphabet', fn () => Inertia::render('Alphabet'))->name('alphabet.learn');
Route::get('/alphabet/quiz', fn () => Inertia::render('AlphabetQuiz'))->name('alphabet.quiz');

Route::get('/angka', fn () => Inertia::render('Numbers'))->name('numbers.learn');
Route::get('/angka/quiz', fn () => Inertia::render('NumbersQuiz'))->name('numbers.quiz');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';