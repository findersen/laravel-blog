<?php

use App\Http\Controllers\Blog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

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

Route::get('/', [App\Http\Controllers\SiteController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('blog')->group(function() {
    Route::match(['get','post'], '/', [Blog::class, 'index'])->name('blog.index');
    Route::match(['get','post'], '/category/{key}', [Blog::class, 'category'])->name('blog.category');
    Route::get('/{keyword}', [Blog::class, 'post'])->name('blog.post');
});

require __DIR__.'/auth.php';
