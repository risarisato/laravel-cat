<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// アクション引数のContactRequestをコントローラーに渡す

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * authorize：権限フォームに入れるかどうか
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * app\Http\Controllers\ContactController.php
     * のコントローラーのバリデーション処理の内容をここに記述する
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ロワンヴー]*$/u'],
            'phone' => ['nullable', 'regex:/^0(\d-?\d{4}|\d{2}-?\d{3}|\d{3}-?\d{2}|\d{4}-?\d|\d0-?\d{4})-?\d{4}$/'],
            'email' => ['required', 'email'],
            'body' => ['required', 'string', 'max:2000'],
        ];
    }
    // バリデーションエラーメッセージのカスタマイズ
    public function attributes()
    {
        return [
            'body' => 'お問い合わせ内容'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => ':attributeを正しく入力してください'
        ];
    }
}
