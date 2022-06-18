<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model {
    use HasFactory;

    protected $fillable = array(
        'carrier_id',
        'name',
        'phone',
        'address',
        'gender',
    );
}
