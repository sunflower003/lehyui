<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
 use HasFactory;

    protected $fillable = ['content', 'post_id', 'user_id', 'parent_id']; // <--- sửa tại đây

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class)->where('is_like', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(CommentLike::class)->where('is_like', 0);
    }

    public function myLike()
    {
        return $this->hasOne(CommentLike::class)->where('user_id', auth()->id());
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies() 
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }   

}

