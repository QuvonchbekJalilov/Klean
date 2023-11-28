<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::get('/', [PageController::class , 'main'])->name('main');
Route::get('about', [PageController::class, 'about']);
Route::get('service', [PageController::class, 'service']);
Route::get('project', [PageController::class, 'project']);
Route::get('contact', [PageController::class, 'contact']);

/*Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts/create', [PostController::class, 'store'])->name('posts.store');
Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('posts/{post}/edit', [PostController::class, 'update'])->name('posts.update');
Route::delete('posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.delete');*/

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register',[AuthController::class, 'register_store'])->name('register.store');

Route::get('language/{locale}', [LanguageController::class, 'change_locale'])->name('locale.change');


Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);
















//Route::get('/test', function(){
//    return view('test_view');
//});

//Route::get('/test/{id?}', function($id = null){
//    return $id;
//});


