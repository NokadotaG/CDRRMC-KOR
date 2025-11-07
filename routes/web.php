<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvacuationController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function(){
    Route::get('/dashboard', [AuthController::class, "dashboard"])->name("dashboard");
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource("/users", UserController::class);
    Route::resource("/sensors", SensorController::class);
    Route::resource('/alerts', AlertController::class);
    Route::resource('/tasks',TaskController::class);
    Route::resource('/evacuation', EvacuationController::class);
});

Route::get('/', [AuthController::class, "login"])->name("login");
Route::post("/login",[AuthController::class,"loginPost"])->name('login.post');
Route::get('/register', [AuthController::class, "register"])->name("register");
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
