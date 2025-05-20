<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Thêm quan hệ này để đếm số bài viết
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
