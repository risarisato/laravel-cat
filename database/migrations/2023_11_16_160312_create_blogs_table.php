<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//./vendor/bin/sail artisan make:migration create_blogs_tableで作成されたファイル

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //upメソッドはマイグレーションを実行するときに呼び出される
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void //downメソッドはマイグレーションをロールバックするときに呼び出される
    {
        Schema::dropIfExists('blogs'); //blogsテーブルが存在する場合は削除する
    }
};
