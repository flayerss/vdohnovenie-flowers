<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderExportController;
use App\Http\Controllers\ProductController;
use App\Models\ProductsInBasket;
use App\Models\Type;
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

Route::get('/', [ProductController::class, 'getAll'])->name('index');
Route::get('/admin/otziv', [AdminController::class, 'getComment'])->name('otziv');
Route::post('/otziv/{id?}', [AdminController::class, 'setcomment'])->name('setotziv');
Route::get('/corsina', [BasketController::class, 'getBasket'])->name('corsina');
Route::get('/product/{id}', [ProductController::class, 'getTypeProducts'])->name('getType');
Route::get('/comment', [CommentController::class, 'getComments'])->name('comment');
Route::post('/comment', [CommentController::class, 'addComment'])->name('comment');
Route::post('/order', [OrderController::class, 'addOrder'])->name('adorder');
Route::get('/corsina/delete/{id?}', [BasketController::class, 'delProduct'])->name('delProduct');
Route::get('/admin', [AdminController::class, 'getAdmin'])->name('admin');
Route::get('/card/{id?}', [ProductController::class, 'getCard'])->name('card');
Route::post('/status/{id?}', [AdminController::class, 'setStatus'])->name('setstatus');
Route::get('/dostavka', function(){
    $types = Type::all();
    return view('dostavka', compact('types'));})->name('dostavka');
    Route::get('/corsina/add/{id}', [BasketController::class, 'addProduct'])->name('corsinad');
    Route::post('/admin/sort', [AdminController::class, 'handleSort'])->name('sort');
Route::post('/admin/status', [AdminController::class, 'sortStatus'])->name('sort_status');
Route::post('/admin/comment/sort', [AdminController::class, 'sortComment'])->name('sort_comment');
Route::get('/orders/export', [OrderExportController::class, 'export'])->name('export');