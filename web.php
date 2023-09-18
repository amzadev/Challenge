<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

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




// Route::get('/{vue_capture?}', function() {
//     return view('welcome');
// })->where('vue_capture', '[\/\w\.-]*');

Route::middleware(['web', 'track-visitor'])->group(function () {
    Route::get('/u/{slug}', [RedirectController::class, 'index']);
});

Route::get('/{any}', function(){
    return view('welcome');
})->where('any', '.*');