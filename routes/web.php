<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;


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

    //ROUTE PROJECTS\
    Route::get('project-user',[ProjectController::class, 'index'])->name('project-user');
    Route::get('project-create',[ProjectController::class, 'create'])->name('project-create');
    Route::post('project-store',[ProjectController::class, 'store'])->name('project-store');
    Route::delete('project-delete/{id}',[ProjectController::class, 'destroy'])->name('project-delete');
    Route::get('project-edit/{id}',[ProjectController::class, 'edit'])->name('project-edit');
    Route::patch('project-update/{id}',[ProjectController::class, 'update'])->name('project-update');
});

require __DIR__.'/auth.php';
