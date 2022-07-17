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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/component/{user_id}', [App\Http\Controllers\HomeController::class, 'component_viewer'])->name('component_viewer');
Route::post('/post-status', [App\Http\Controllers\HomeController::class, 'post_status'])->name('post_status');
Route::get('/view-user/{user_id}', [App\Http\Controllers\HomeController::class, 'view_user'])->name('view_user');
Route::post('/approve-reject-post', [App\Http\Controllers\HomeController::class, 'approve_reject'])->name('approve_reject');
