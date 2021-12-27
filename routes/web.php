<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;


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


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/', function () {
    return view('home');
});

Route::get('home', function () {
    return "Welcome Home!";
});


Route::get('about', function () {
    return view('about');
});

Route::get('our-contact', [ContactController::class, 'index'])->name('contact');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    return view('admin.index');
})->name('dashboard');


//Category
Route::get('/category/all', [CategoryController::class, 'all'])->name('all.category');

Route::post('/category/add', [CategoryController::class, 'add'])->name('store.category');

Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('edit.category');

Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('update.category');

Route::get('/category/soft-delete/{id}', [CategoryController::class, 'softDelete'])->name('soft_delete.category');

Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('delete.category');

Route::get('/category/restore/{id}', [CategoryController::class, 'restore'])->name('restore.category');

//Brand
Route::get('/brand/all', [BrandController::class, 'all'])->name('all.brand');

Route::post('/brand/add', [BrandController::class, 'add'])->name('store.brand');

Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('edit.brand');

Route::post('/brand/update/{id}', [BrandController::class, 'update'])->name('update.brand');

Route::get('/brand/delete/{id}', [BrandController::class, 'delete'])->name('delete.brand');

//Multipic
Route::get('/multipic/all', [BrandController::class, 'multipic'])->name('multipic');

Route::post('/multipic/add', [BrandController::class, 'addMultipic'])->name('store.multipic');


Route::get('user/logout', [BrandController::class, 'logout'])->name('user.logout');