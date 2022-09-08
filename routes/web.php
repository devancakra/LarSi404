<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
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
// Main Route
Auth::routes();

// General Route : Menu
Route::get('/', [GeneralController::class, 'index'])->name('index');
Route::get('/info-kegiatan', [GeneralController::class, 'infokegiatan'])->name('infokegiatan');
Route::get('/registrasi', [GeneralController::class, 'register'])->name('registrasi');
Route::get('/forgetUser', [GeneralController::class, 'forgetUser'])->name('forgetUser');

// Route : Action Login, Logout, CRUD ++
Route::post('/registrasiUser', [GeneralController::class, 'regUser'])->name('regUser');
Route::post('/updateprofile', [GeneralController::class, 'updprofile'])->name('updprofile');
Route::post('/resetUser', [GeneralController::class, 'resetUser'])->name('resetUser');
Route::post('/login', [GeneralController::class, 'login'])->name('login');
Route::get('/logout', [GeneralController::class, 'logout'])->name('logout');
Route::post('/data-pelatihan/add', [AdminController::class, 'create'])->name('create');
Route::post('/data-pelatihan/update/{id}', [AdminController::class, 'update'])->name('update');
Route::get('/data-pelatihan/delete/{id}', [AdminController::class, 'delete'])->name('delete');
Route::post('/data-siswa/add', [SiswaController::class, 'create'])->name('create');
Route::get('/dashboard', [GeneralController::class, 'dashboardaccount'])->name('dashboardaccount');

// Route Policies : All Access Rights
Route::group(['middleware' => ['AccessRights']], function () {
    Route::get('/dashboard', [GeneralController::class, 'dashboardaccount'])->name('dashboardaccount');
    Route::get('/home', [GeneralController::class, 'home'])->name('home');
    Route::get('/data-pelatihan', [AdminController::class, 'index'])->name('data-pelatihan');
    Route::get('/data-siswa', [SiswaController::class, 'index'])->name('data-siswa');
});