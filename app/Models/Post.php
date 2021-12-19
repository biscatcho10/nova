<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = ['title', 'slug', 'content', 'user_id'];

    // insert relationship user_id to post table
    public static function boot()
    {
        parent::boot();
        static::creating(function ($user_id) {
            $user_id->user_id = auth()->user()->id;
        });
    }

}
