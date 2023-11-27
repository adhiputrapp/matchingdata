<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
 
Auth::routes();
Route::middleware('Role:admin')->group(
    function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/Dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
        Route::prefix('pemilih')->group(
            function () {
                Route::get('/', [App\Http\Controllers\DatapemilihController::class, 'index'])->name('pemilih');
                Route::post('/import', [App\Http\Controllers\DatapemilihController::class, 'import'])->name('import');
                Route::get('/filter', [App\Http\Controllers\DatapemilihController::class, 'filter'])->name('filter');
                Route::get('/filter/sumber/{sumber}', [App\Http\Controllers\DatapemilihController::class, 'sumber'])->name('filter.sumber');
                Route::get('/filter/korkab/{sumber}/{korkab}', [App\Http\Controllers\DatapemilihController::class, 'korkab'])->name('filter.korkab');
                Route::get('/filter/kecamatan/{sumber}/{kecamatan}', [App\Http\Controllers\DatapemilihController::class, 'kecamatan'])->name('filter.kecamatan');
            }
        );
        Route::prefix('matching')->group(
            function () {
                Route::get('/', [App\Http\Controllers\DatadptController::class, 'index'])->name('matching');
                Route::post('/import/{id}', [App\Http\Controllers\DatadptController::class, 'import'])->name('matching.import');
                Route::get('/filter', [App\Http\Controllers\DatadptController::class, 'filter'])->name('matching.filter');
                Route::get('/filter/sumber/{sumber}', [App\Http\Controllers\DatadptController::class, 'sumber'])->name('matching.filter.sumber');
                Route::get('/filter/kecamatan/{sumber}/{kecamatan}', [App\Http\Controllers\DatadptController::class, 'kecamatan'])->name('matching.filter.kecamatan');
            }
        );
    }
);
