<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        "name",
        "code",
    ];

    /** Start Relationships **/
    public function account()
    {
        return $this->belongsToMany(Account::class);
    }

    /** Start Relationships **/
}
