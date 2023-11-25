## laravel実践練習

## 認証機能
- `./vendor/bin/sail artisan make:controller Admin/UserController -r --model=User`で、既に作成したモデルクラスを指定して、コントローラーを作成する
- `./vendor/bin/sail artisan make:migration add_columns_to_users_table`で管理者用のマイグレーションファイルの作成
- `./vendor/bin/sail artisan migrate`で、マイグレーションを実行する
- `./vendor/bin/sail artisan make:request Admin/StoreUserRequest`で、登録のバリデーションを作成する

## 49 リレーション
- 中間テーブルとは、多対多の関係を持つテーブル：双方の外部キーを持つテーブル
- `./vendor/bin/sail artisan make:model Category -m`で、マイグレーションファイルを作成する
- `./vendor/bin/sail artisan migrate`で、マイグレーションを実行する
- `./vendor/bin/sail artisan db:seed --class=CategorySeeder`で、シード作成：4件のデータを作成する
- `./vendor/bin/sail artisan make:migration add_category_id_column_to_blogs_table`で、blogsテーブルにcategory_idカラム追加するマイグレーションファイルを作成する
- マイグレーションをロールバックする：`./vendor/bin/sail artisan migrate:rollback`
- `./vendor/bin/sail artisan migrate:fresh`で、マイグレーションを全てロールバックする
- `constrained()`は、外部キー制約をつけるメソッド
- `./vendor/bin/sail artisan db:seed --class=BlogSeeder2`
- `./vendor/bin/sail artisan make:model Cat -m`で、マイグレーションファイルを作成する
- `./vendor/bin/sail artisan migrate`で、マイグレーションを実行する
- DBから読み込ませるviewで{{ $blog->category->name }} とすると、ブログのカテゴリー名の名前が表示される
- associate()は、中間テーブルにデータを追加するメソッド
- dissociate()は、中間テーブルからデータを削除するメソッド

- AdminBlogController.phpのedit(Blog $blog)メソッドでカテゴリーを取得するして、edit.blade.phpの<option value="{{ $category->id }}">{{ $category->name }}</option>プルリクエストでカテゴリーを表示させる

- UpdateBlogRequest.phpのrules()メソッドで、カテゴリーのバリデーションを追加する
- null合体演算子`??`は、左辺がnullの場合に右辺を返す演算子→`$blog->category->name ?? ''`で、カテゴリーがない場合にエラーにならないようにする


## 48 コレクション
- コレクションとは、配列を拡張したもの
- クエリビルダと同じ感覚で、検索やソート、順番変更、集計などができる

45 クエリビルダ
- `$blogs = Blog::all();`は、「すべて」のデータを取得する
- `$blogs = Blog::latest('updated_at')->limit(10)->get();`は、クエリビルダで、最新の10件を取得する
- クエリビルダは、コード内でSQLを直接書くことができる
- `./vendor/bin/sail artisan db:seed --class=BlogSeeder`で、テストデータを作成する(シード)

41 モデルクラスの作成<br>
42 データ取得resources\views\admin\blogs\index.blade.php
- blade.phpのインデントの@foreach($blogs as $blog)から@endforeachに注意
- findOrFail()は、IDがないページで、見つからない場合は404エラーを返す


## モデルクラスの作成
- 一括代入した場合`protected $fillable = ['title', 'body'];`で、代入可能なカラムを指定しないとエラーになる
- `./vendor/bin/sail artisan make:model Xxxx` モデルクラスの作成
- `./vendor/bin/sail artisan make:model Blog -cr` で、コントローラーとルーティングの同時作成
- `./vendor/bin/sail artisan make:Controller Admin/AdminBlogController` サブディレクトも一緒に作成


#### web.phpに追加する
- `./vendor/bin/sail artisan make:request Admin/StoreBlogReuest` リクエストクラスのバリデーションを作成
- `use App\Http\Controllers\Admin\XXXXController;` を忘れずに



## マイグレーションとは、データベース構造を変更するための仕組み
- `./vendor/bin/sail artisan migrate`で、マイグレーションを実行する
- `http://localhost:8888/`で、phpmyadminにアクセスする
~~~
docker-compose.yml
    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        depends_on:
            - mysql
        ports:
            - 8888:80
        environment:
            PMA_USER: '${DB_USERNAME}'
            PMA_PASSWORD: '${DB_PASSWORD}'
            PMA_HOST: mysql
        networks:
            - sail
~~~
- `./vendor/bin/sail artisan make:migration create_blogs_table`で、テーブルを作成する
- `./vendor/bin/sail artisan migrate`で、「create_blogs_table」のマイグレーションを実行する
- `./vendor/bin/sail artisan migrate:status`で、マイグレーションの状態を確認する
- `./vendor/bin/sail artisan migrate:rollback`で、Batch/Statusが大きいものロールバックする
- そのためXXXXYYMMHHMMSS_create_XXXX_table.phpの「UP」はテーブル追加、「donw」テーブル削除
- マイグレーションはスネークケースで、モデルクラスはパスカルケース(頭文字が大文字)で作成する決まりがある

## Mailableクラスの作成
- `./vendor/bin/sail artisan -V`で、バージョン確認
- `./vendor/bin/sail composer update`で、composerのアップデート
- `./vendor/bin/sail artisan make:mail XXXMail`で、Mailableクラスを作成する

#### app/Mail/XXXXMail.phpが作成される
- envelopeはメールの差出人や件名を指定するメソッド
- contentはメールの本文を指定するメソッド
- attachmentsは添付ファイルを指定するメソッド

#### localhost:8025 で、メールの確認ができる
- mailpitのコンテナが立ち上がっていることが前提

~~~
docker-compose.yml
    mailpit:
        image: 'axllent/mailpit:latest'
        ports:
            - '${FORWARD_MAILPIT_PORT:-1025}:1025'
            - '${FORWARD_MAILPIT_DASHBOARD_PORT:-8025}:8025'
        networks:
            - sail
~~~


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
- `localhost` ：ローカルホスト
