<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "phone",
        "mobile_phone",
        "status",
        "client_id",
    ];


    /** Start Relationships **/
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /** Start Relationships **/
}
