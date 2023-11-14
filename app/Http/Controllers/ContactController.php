<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest; // バリデーション処理をContactRequestから呼び出すことで肥大化を防ぐ
use App\Mail\ContactAdminMail; // メール送信処理をContactAdminMailから呼び出す
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // ログ出力を行うために追加
use Illuminate\Support\Facades\Mail; // メール送信を行うために追加


class ContactController extends Controller
{
    // お問い合わせページの表示
    public function index()
    {
        return view('contact.index');
    }

    // お問い合わせ内容のバリデーション処理
    //function sendMail(Request $request) {

    // バリデーション処理をContactRequestから呼び出すことで肥大化を防ぐ
    function sendMail(ContactRequest $request) {
        //$validated = $request->validate([]);
        $validated = $request->validated(); //validated()メソッドで取得できる
    
        // これ以降の行は入力エラーがなかった場合のみ実行されます
        // use Illuminate\Support\Facades\Log; を追加しておくと、ログ出力ができます
        //Log::debug($validated['name']. 'さんよりお問い合わせがありました');

        // メール送信処理
        Mail::to('admin@example.com')->send(new ContactAdminMail($validated));
        return to_route('contact.complete');
    }

    // お問い合わせ内容の確認
    public function complete()
    {
        return view('contact.complete');
    }
}
