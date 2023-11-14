<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // ログ出力を行うために追加

class ContactController extends Controller
{
    // お問い合わせページの表示
    public function index()
    {
        return view('contact.index');
    }

    // お問い合わせ内容のバリデーション処理
    function sendMail(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ロワンヴー]*$/u'],
            'phone' => ['nullable', 'regex:/^0(\d-?\d{4}|\d{2}-?\d{3}|\d{3}-?\d{2}|\d{4}-?\d|\d0-?\d{4})-?\d{4}$/'],
            'email' => ['required', 'email'],
            'body' => ['required', 'string', 'max:2000'],
        ]);
    
        // これ以降の行は入力エラーがなかった場合のみ実行されます
        // use Illuminate\Support\Facades\Log; を追加しておくと、ログ出力ができます
        Log::debug($validated['name']. 'さんよりお問い合わせがありました');
        return to_route('contact.complete');
    }

    // お問い合わせ内容の確認
    public function complete()
    {
        return view('contact.complete');
    }
}
