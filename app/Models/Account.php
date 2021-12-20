<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        "code_number",
        "invoice_method",
        "email",
        "notes",
        "lang",
        "currency_id",
        "category_id",
    ];

    /** Start Relationships **/
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /** Start Relationships **/
}
