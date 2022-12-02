<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BelajarLaravelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TodoController;
use GuzzleHttp\Middleware;

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
Route::middleware('isGuest')->group(function(){
    Route::get('/', [LoginController::class, 'index']);
    Route::get('/register', [LoginController::class, 'register'])->name('register.page');
    Route::post('/register/input', [LoginController::class, 'registerAccount'])->name('register.input');
    Route::post('/login/auth', [LoginController::class, 'auth'])->name('login.auth');
});


// Route::post('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware('isLogin')->group(function(){
    Route::prefix('/todo')->name('todo.')->group(function(){
        Route::get('/', [TodoController::class, 'home'])->name('index');
        //method untuk fitur create
        Route::get('/create', [TodoController::class, 'create'])->name('create');
        //method untuk fitur logout
        Route::get('/logout', [TodoController::class, 'logout'])->name('logout');
        Route::post('/storetodo', [TodoController::class, 'store'])->name('store');
        //method untuk mengedit data todos
        Route::get('/edit/{id}', [TodoController::class, 'edit'])->name('edit');
        //method untuk mengupdate di database
        Route::patch('/update/{id}', [TodoController::class, 'update'])->name('update');
        //method untuk menghapus data yang ada di dashboard
        Route::delete('/destroy/{id}', [TodoController::class, 'destroy'])->name('destroy');
        //method untuk fitur complated
        Route::patch('/complated/{id}', [TodoController::class, 'updateComplated'])->name('updateComplated');
    });
    Route::resource('dashboard', DashboardController::class);
});



// fitur edit, dan mengupdate di database