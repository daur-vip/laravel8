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

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function () {
    return "Welcome Home!";
});


Route::get('about', function () {
    return view('about');
});

Route::get('our-contact', [ContactController::class, 'index'])->name('contact');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    // $users = User::all();
    $users = DB::table('users')->get();

    return view('dashboard', compact('users'));
})->name('dashboard');


//Category Controller
Route::get('/category/all', [CategoryController::class, 'all'])->name('all.category');

Route::post('/category/add', [CategoryController::class, 'add'])->name('store.category');

Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('edit.category');

Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('update.category');

Route::get('/category/soft-delete/{id}', [CategoryController::class, 'softDelete'])->name('soft_delete.category');

Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('delete.category');

Route::get('/category/restore/{id}', [CategoryController::class, 'restore'])->name('restore.category');

//Brand Controller
Route::get('/brand/all', [BrandController::class, 'all'])->name('all.brand');

Route::post('/brand/add', [BrandController::class, 'add'])->name('store.brand');
