<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'body']; // imageを追加

    // 1対多のリレーションでcategory_idを追加
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 多対多のリレーションでcats()を追加
    public function cats()
    {
        return $this->belongsToMany(Cat::class)->withTimestamps(); // withTimestamps()を追加で中間テーブルのcreated_at, updated_atを更新
    }
}
