<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\BlogController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => 'auth'], function() {

    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

    Route::group(['middleware' => 'checkRole:admin'], function() {
        Route::prefix('admin')->group(function () {
            Route::get('/', function(){
                return redirect()->route('admin.dashboard');
            });
            Route::inertia('/dashboard', 'AdminDashboard')->name('admin.dashboard');
            Route::resource('blogs',BlogController::class);
        });
    });
    Route::group(['middleware' => 'checkRole:user'], function() {
        Route::prefix('user')->group(function () {
            Route::inertia('/dashboard', 'UserDashboard')->name('user.dashboard');
        });
    });
    Route::group(['middleware' => 'checkRole:guest'], function() {
        Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    });
});

require __DIR__.'/auth.php';


