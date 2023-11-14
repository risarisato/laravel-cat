## laravel実践練習
35メール送信機能を作る

## Mailableクラスの作成
- `./vendor/bin/sail artisan -V`で、バージョン確認
- `./vendor/bin/sail composer update`で、composerのアップデート
- `./vendor/bin/sail artisan make:mail ContactAdminMail`で、Mailableクラスを作成する
>>app/Mail/ContactAdminMail.phpが作成される
- envelopeはメールの差出人や件名を指定するメソッド
- contentはメールの本文を指定するメソッド
- attachmentsは添付ファイルを指定するメソッド

#### `http://localhost:8025`で、メールの確認ができる
- mailpitのコンテナが立ち上がっていることが前提

"""
docker-compose.yml
    mailpit:
        image: 'axllent/mailpit:latest'
        ports:
            - '${FORWARD_MAILPIT_PORT:-1025}:1025'
            - '${FORWARD_MAILPIT_DASHBOARD_PORT:-8025}:8025'
        networks:
            - sail
"""


## バリデーション作成
- コントローラーにバリデーション処理の記述は良くない
- リダイレクトさせる：`return to_route('contact.complete');`これが`web.php`の終わり
- view側で、`@if ($errors->any())`から`@foreach ($errors->all() as $error)`で、エラーがある場合に表示させる
- 名前ならば`@if ($errors->has('name'))`を使うと、エラーがある場合に表示される
- `{{ $errors->first('name') }}`の`first`は、最初のエラーを表示する

#### 入力内容の再取得
- `<input id="name" type="text" name="name" value="{{ old('name') }}">`で、入力内容を再取得できる
- バリデーションのカスタマイズ：コントローラーにバリデーションを記述すると、肥大化する
- `./vendor/bin/sail artisan make:request ContactRequest`で、バリデーションだけをフォームリクエストに分割する
- バリデーションのルールを、ContactRequestに記述する

##### 日本語化したバリデーションにさせる
- `https://github.com/Laravel-Lang/lang`
- ブランチ`Tags`のlaravelバージョンの最新ものを選択して`code`から`Download ZIP`でDLする
- lang-10.6.5zipを解凍して、localesの「jp」をLaravelプロジェクトの`/lang/ja`に入れる
- 設定は、`config/app.php`の「locale」を「ja」にする
- `lang\ja\validation.php`に属性を追加する`:例)'attributes' => ['name' => '名前','' => '']` とする

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

