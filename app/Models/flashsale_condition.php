<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class flashsale_condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'flashsale_id',
        'condition',
        'theme_id',
        'store_id'
    ];
}
