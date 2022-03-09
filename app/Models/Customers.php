<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    public $table = "customers";
    public $fillable =  [
        "first_name","last_name","email","postcode"
    ];
    public $timestamps = false;
}
