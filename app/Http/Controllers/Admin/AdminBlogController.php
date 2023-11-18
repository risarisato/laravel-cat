<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;



class AdminBlogController extends Controller
{
    // ブログ一覧
    public function index()
    {
        $blogs = Blog::all();
        //dd($blogs); // DBから取得できるかデバッグ用
        return view('admin.blogs.index', ['blogs' => $blogs]);
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
    public function edit(string $id)
    {
        //$blog = Blog::find($id);
        $blog = Blog::findOrFail($id); // データがない場合は404エラーを返す
        return view('admin.blogs.edit', ['blog' => $blog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
