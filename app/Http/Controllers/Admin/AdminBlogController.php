<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog; // 追加
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest; // 追加
use Illuminate\Support\Facades\Auth; // 追加
use Illuminate\Support\Facades\Storage; // 追加
use App\Models\Category; // 追加
use App\Models\Cat; // 追加




class AdminBlogController extends Controller
{
    // ブログ一覧
    public function index()
    {
        //$blogs = Blog::all(); // DBから全てのデータを取得する
        //dd($blogs); // DBから取得できるかデバッグ用

        // クエリビルダで10件を最新のものから取得する
        //$blogs = Blog::latest('updated_at')->limit(10)->get();

        // ページネーションを使って10件を最新のものから取得する
        $blogs = Blog::latest('updated_at')->paginate(7);
        $user = \Auth::user(); // 今、ログインしているユーザーを取得する
        return view('admin.blogs.index', ['blogs' => $blogs, 'user' => $user]);
    }

    // ブログ登録
    public function create()
    {
        return view('admin.blogs.create');
    }

    // ブログ登録処理
    public function store(StoreBlogRequest $request)
    {
        $savedImagePath = $request->file('image')->store('blog', 'public'); // 画像を保存
        $blog = new Blog($request->validated()); // バリデーション済みの値を取得
        $blog->image = $savedImagePath; // 画像のパスを保存
        $blog->save(); // 保存

        return to_route('admin.blogs.index')->with('success', 'ブログを登録しました'); // リダイレクト
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // ブログ編集
    public function edit(Blog $blog)
    {
        //$blog = Blog::find($id);

        //public function edit(Blog $Blog) をしているので、Blogモデルのインスタンスが渡される
        //$blog = Blog::findOrFail($id); // データがない場合は404エラーを返す
        $categories = \App\Models\Category::all(); // カテゴリーを全て取得する
        $cats = \App\Models\Cat::all(); // 猫を全て取得する
        return view('admin.blogs.edit', ['blog' => $blog, 'categories' => $categories, 'cats' => $cats]);
    }

    // ブログ更新処理
    public function update(UpdateBlogRequest $request, string $id)// バリデーションを追加
    {
        $blog = Blog::findOrFail($id); // データがない場合は404エラーを返す
        $updateData = $request->validated(); // バリデーション済みの値を取得

        // 画像を変更する場合
        if ($request->has('image')) {
            // 変更前の画像は削除する
            \Storage::disk('public')->delete($blog->image);
            // 変更後の画像をアップロード、保存パスを更新対象データにセットする
            $updateData['image'] = $request->file('image')->store('blog', 'public');
        }
        $blog->category()->associate($updateData['category_id']); // カテゴリーを更新
        $blog->cats()->sync($updateData['cats'] ?? []); // null合体演算子で猫のIDが送信されていない場合は空配列をセットする
        $blog->update($updateData); // 更新

        return to_route('admin.blogs.index')->with('success', 'ブログを更新しました'); // リダイレクト
    }

    // ブログ削除処理
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id); // データがない場合は404エラーを返す
        $blog->delete(); // 削除
        \Storage::disk('public')->delete($blog->image); // 画像を削除

        return to_route('admin.blogs.index')->with('success', 'ブログを削除しました！'); // リダイレクト
    }
}
