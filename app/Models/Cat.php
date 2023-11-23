<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    // 多対多のリレーションでblogs()を追加
    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }
}
