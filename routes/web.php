<?php

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\SalesController;

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::group(['middleware' => 'auth'], function () {
Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

	Route::group(['prefix' => 'sales'], function () {
		Route::get('/', [SalesController::class, 'index'])->name('sales');
		Route::get('/create', [SalesController::class, 'create'])->name('sales.create');
		Route::post('/store', [SalesController::class, 'store'])->name('sales.store');
		Route::get('/edit/{id}', [SalesController::class, 'edit'])->name('sales.edit');
		Route::put('/update/{id}', [SalesController::class, 'update'])->name('sales.update');
		Route::delete('/delete/{id}', [SalesController::class, 'delete'])->name('sales.delete');
	});

	Route::group(['prefix' => 'pengeluaran'], function () {
		Route::get('/', [PengeluaranController::class, 'index'])->name('pengeluaran');
		Route::get('/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
		Route::post('/store', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
		Route::get('/edit/{id}', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
		Route::put('/update/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
		Route::delete('/destroy/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.delete');
	});

	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
