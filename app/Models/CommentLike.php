<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    // Khai báo các trường cho phép fill (bạn cần 3 trường)
    protected $fillable = ['user_id', 'comment_id', 'is_like'];

    // Quan hệ: mỗi like/dislike thuộc về một user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ: mỗi like/dislike thuộc về một comment
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}

