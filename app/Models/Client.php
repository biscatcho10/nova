<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        "full_name",
        "first_name",
        "last_name",
        "client_type",
        "phone",
        "mobile_phone",
        "account_id",
    ];

    /** Start Relationships **/
    public function account()
    {
        return $this->hasOne(Client::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    /** Start Relationships **/
}
