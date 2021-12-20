<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        "address_line_1",
        "address_line_2",
        "city",
        "state",
        "country",
        "postal_code",
        "timezone",
        "client_id",
    ];

    /** Start Relationships **/
    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    /** Start Relationships **/
}
