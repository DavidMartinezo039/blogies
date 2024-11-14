<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('contacto', 'contact')->name('contact');
Route::get('blog/user', [PostController::class, 'user'])->name('posts.user');
Route::get('blog/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/user-posts', [PostController::class, 'user'])->name('posts.user');



Route::resource('blog', PostController::class)
    ->names('posts')
    ->parameters(['blog' => 'post']);
Route::view('nosotros', 'about')->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
