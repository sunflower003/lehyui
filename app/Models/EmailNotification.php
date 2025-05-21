<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    protected $table = 'email_notifications';

    protected $fillable = [
        'user_id', 'type', 'title', 'body', 'post_id', 'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
