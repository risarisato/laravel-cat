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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;

// ユーザー登録
Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
//Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
//Route::post('/admin/login', [AuthController::class, 'login']);



// ルートグループを使って、admin以下のURLに対して、prefixでadminを付与する
Route::prefix('/admin')
    ->name('admin.')
    ->group(function () {
        // ログインしている場合のみアクセス可能
        Route::middleware('auth')
            ->group(function () {
        // ブログ一覧ページのルーティング
        Route::resource('/blogs', AdminBlogController::class)->except('show');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });
        // ログインしていない場合のみアクセス可能
        Route::middleware('guest')
            ->group(function () {
                // 承認
                Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
                Route::post('login', [AuthController::class, 'login']);
        });
    });


//// ブログ一覧ページのルーティング
//Route::get('/admin/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index')->middleware('auth');
//// リダイレクトを設定したため、/admin/blogsにアクセスすると、/admin/blogs/indexにリダイレクトされる
//Route::get('/admin/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create')->middleware('auth');
//// リダイレクトを設定したため、/admin/blogs/createにアクセスすると、/admin/blogs/createにリダイレクトされる
//Route::post('/admin/blogs', [AdminBlogController::class, 'store'])->name('admin.blogs.store')->middleware('auth');
//// リダイレクトを設定したため、/admin/blogsにアクセスすると、/admin/blogsにリダイレクトされる
//// ブログ編集ページのルーティング
//Route::get('/admin/blogs/{blog}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit')->middleware('auth');
//// ブログ更新処理のルーティング[put]
//Route::put('/admin/blogs/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogs.update')->middleware('auth');
//// ブログ削除処理のルーティング[delete]
//Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy')->middleware('auth');
//
//
//
//// ユーザー登録ページのルーティング
//use App\Http\Controllers\Admin\UserController; // 追加
//Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
//// ユーザー登録処理のルーティング
//Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
////　承認処理のルーティング
//use App\Http\Controllers\Admin\AuthController; // 追加
//Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
//Route::post('/admin/login', [AuthController::class, 'login']);
//// ログアウト処理のルーティング
//Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');