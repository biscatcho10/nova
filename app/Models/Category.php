<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "description",
    ];

    /** Start Relationships **/
    public function account()
    {
        return $this->belongsToMany(Account::class);
    }

    /** Start Relationships **/
}
