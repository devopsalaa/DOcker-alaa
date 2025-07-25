<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DockerController; // Make sure to include your DockerController
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

// Redirect the root URL to the login page
Route::get('/', function () {
    return redirect()->route('login'); // Assuming 'login' is the name of your login route
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DockerController::class, 'dashboard'])->name('dashboard');
    Route::get('/docker', [DockerController::class, 'index'])->name('docker.index');
    Route::post('/docker', [DockerController::class, 'store'])->name('docker.store');
    Route::post('/docker/{id}/start', [DockerController::class, 'start'])->name('docker.start');
    Route::post('/docker/{id}/stop', [DockerController::class, 'stop'])->name('docker.stop');
    Route::delete('/docker/{id}', [DockerController::class, 'destroy'])->name('docker.destroy');
    Route::post('/docker/build', [DockerController::class, 'build'])->name('docker.build');
    Route::get('/docker/images', [DockerController::class, 'images'])->name('docker.images');
    Route::get('/docker/{id}/metrics', [DockerController::class, 'metrics'])->name('docker.metrics');
    Route::get('/docker/{id}/logs', [DockerController::class, 'logs'])->name('docker.logs');
    Route::get('/docker/{id}/details', [DockerController::class, 'details'])->name('docker.details');
    Route::post('/docker/images/pull', [DockerController::class, 'pull'])->name('docker.pull');
    Route::post('/docker/{id}/backup', [DockerController::class, 'backup'])->name('docker.backup');
});

require __DIR__.'/auth.php';
