<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'post_id', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    // Thêm các quan hệ like/dislike:
    public function likes()
    {
        return $this->hasMany(CommentLike::class)->where('is_like', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(CommentLike::class)->where('is_like', 0);
    }

    // Lấy like/dislike của user hiện tại (nếu cần)
    public function myLike()
    {
        return $this->hasOne(CommentLike::class)->where('user_id', auth()->id());
    }
}

