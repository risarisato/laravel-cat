## laravel実践練習
35メール送信機能を作る

## バリデーション作成
- 今回は、コントローラーにバリデーションを記述する＞良くない
- $validated = $request->validate([`name` => 'required', 'string', 'max:255'],[]... ]);
- リダイレクトさせる：return to_route('contact.complete');
- view側で、@if ($errors->any())から@foreach ($errors->all() as $error)で、エラーがある場合に表示される
- 名前ならばif ($errors->has('name'))を使うと、エラーがある場合に表示される
- {{ $errors->first('name') }}のfirstは、最初のエラーを表示する

- 入力内容の再取得
- <input id="name" type="text" name="name" value="{{ old('name') }}">で、入力内容を再取得できる

- バリデーションのカスタマイズ：コントローラーにバリデーションを記述すると、肥大化する
- ./vendor/bin/sail artisan make:request ContactRequest で、バリデーションだけをフォームリクエストに分割する
- バリデーションのルールを、ContactRequestに移動する
- フォームリクエストには認可「authorize」：権限フォームに入れるか、ルール「rule」がある

#### 日本語化したバリデーションにさせる
- https://github.com/Laravel-Lang/lang
- ブランチTagsのlaravelバージョンの最新ものを選択して「code」から「Download ZIP」でDLする
- lang-10.6.5zipを解凍して、localesの「jp」をLaravelプロジェクトの/lang/jaに入れる
- 設定は、config/app.phpの「locale」を「ja」にする
- lang\ja\validation.phpに属性を追加する:'attributes' => ['name' => '名前','' => ''] とする

## コントローラー作成
- `./vendor/bin/sail artisan make:controller ContactController`

### github
- `git init` ：初期化
- `git remote add origin git@github.com:XXXXXXXX.git` ：リモート追加
- `git remote -v` ：リモート確認
- `git config core.autocrlf false` ：改行コード
- `git branch -m master main` ：mainブランチ設定

### laravel
- cd /mnt/c/Users/XXXXXX/Desktop/ ：置きたいところのパス
- `curl -s "https://laravel.build/XXXXXXX?with=mysql,mailpit" | bash` ：召喚
- WSLのパスワードを求められる
- `./vendor/bin/sail up -d` ：立ち上げ
- `./vendor/bin/sail down` ：停止

