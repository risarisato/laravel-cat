<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreUserRequest; // 追加
use Illuminate\Support\Facades\Hash; // 追加

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // ユーザー登録ページのコントローラー
    public function create()
    {
        return view('admin.users.create');
    }

    // ユーザー登録処理のstoreメソッドの引数に、StoreUserRequestを追加
    // StoreUserRequestは、フォームリクエストを使ってバリデーションのルールをクラスにまとめたもの
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = $request->file('image')->store('users', 'public');
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        // リダイレクト先を変更
        //return back()->with('success', 'ユーザー登録が完了しました');
        return redirect()->route('admin.users.create')->with('success', 'ユーザー登録が完了しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}