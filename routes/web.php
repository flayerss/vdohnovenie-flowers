<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderExportController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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
Route::get('/corsina', [BasketController::class, 'getBasket'])->name('corsina');
Route::get('/product/{id}', [ProductController::class, 'getTypeProducts'])->name('getType');
Route::get('/comment', [CommentController::class, 'getComments'])->name('comment');
Route::post('/comment', [CommentController::class, 'addComment'])->name('comment');
Route::post('/order', [OrderController::class, 'addOrder'])->name('adorder');
Route::get('/corsina/delete/{id?}', [BasketController::class, 'delProduct'])->name('delProduct');
Route::get('/card/{id?}', [ProductController::class, 'getCard'])->name('card');
Route::get('/dostavka', function () {
    $types = Type::all();
    return view('dostavka', compact('types'));
})->name('dostavka');
Route::get('/corsina/add/{id}', [BasketController::class, 'addProduct'])->name('corsinad');
Route::post('/corsina/update/{id}', [BasketController::class, 'updateQuantity'])->name('updateQuantity');

// Админка — требует авторизации
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'getAdmin'])->name('admin');
    Route::get('/admin/otziv', [AdminController::class, 'getComment'])->name('otziv');
    Route::post('/otziv/{id?}', [AdminController::class, 'setcomment'])->name('setotziv');
    Route::post('/status/{id?}', [AdminController::class, 'setStatus'])->name('setstatus');
    Route::post('/admin/sort', [AdminController::class, 'handleSort'])->name('sort');
    Route::post('/admin/comment/sort', [AdminController::class, 'sortComment'])->name('sort_comment');
    Route::get('/orders/export', [OrderExportController::class, 'export'])->name('export');

    Route::get('/admin/products', [ProductAdminController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/create', [ProductAdminController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductAdminController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductAdminController::class, 'edit'])->name('admin.products.edit');
    Route::post('/admin/products/{id}', [ProductAdminController::class, 'update'])->name('admin.products.update');
    Route::post('/admin/products/{id}/delete', [ProductAdminController::class, 'destroy'])->name('admin.products.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
