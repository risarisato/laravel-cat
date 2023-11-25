<?php

use App\Http\Controllers\ContactController;
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

// トップページのルーティング
Route::get('/', function () {
    return view('index');
});

// お問い合わせページのルーティング
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// お問い合わせ内容バリデーション処理
Route::post('/contact', [ContactController::class, 'sendMail']);

// お問い合わせ内容確認
Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');

use App\Http\Controllers\Admin\AdminBlogController; // 追加
// ブログ一覧ページのルーティング
Route::get('/admin/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
// リダイレクトを設定したため、/admin/blogsにアクセスすると、/admin/blogs/indexにリダイレクトされる
Route::get('/admin/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
// リダイレクトを設定したため、/admin/blogs/createにアクセスすると、/admin/blogs/createにリダイレクトされる
Route::post('/admin/blogs', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
// リダイレクトを設定したため、/admin/blogsにアクセスすると、/admin/blogsにリダイレクトされる

// ブログ編集ページのルーティング
Route::get('/admin/blogs/{blog}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');

// ブログ更新処理のルーティング[put]
Route::put('/admin/blogs/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');

// ブログ削除処理のルーティング[delete]
Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');



// ユーザー登録ページのルーティング
Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');

// ユーザー登録処理のルーティング
Route::post('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');