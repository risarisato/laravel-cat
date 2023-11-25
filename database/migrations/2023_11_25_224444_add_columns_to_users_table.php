<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //ユーザー登録のテーブルの作成
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->after('name')->comment('画像');
            $table->string('introduction')->after('image')->comment('自己紹介文');
        });
    }

    //ユーザー登録テーブルの削除
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['image', 'introduction']);
        });
    }
};
