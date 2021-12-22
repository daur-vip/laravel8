<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;

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

//Category Controller
Route::get('/category/all', [CategoryController::class, 'allCategory'])->name('all.category');

Route::post('/category/add', [CategoryController::class, 'addCategory'])->name('store.category');


Route::get('/category/edit/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');

Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory'])->name('update.category');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    // $users = User::all();
    $users = DB::table('users')->get();

    return view('dashboard', compact('users'));
})->name('dashboard');
