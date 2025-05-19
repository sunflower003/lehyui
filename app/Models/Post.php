<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
    'title',
    'sub_title',
    'thumbnail',
    'body',
    'user_id',
    'category_id'
];


}