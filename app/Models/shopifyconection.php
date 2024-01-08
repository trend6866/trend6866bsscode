<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopifyconection extends Model
{
    use HasFactory;
    protected $table    = 'shopify_conections';
    protected $fillable = [
        'store_id',
        'theme_id',
        'module',
        'shopify_id',
        'original_id'
    ];
}
