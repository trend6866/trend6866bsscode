<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasedProducts extends Model
{
    protected $table = 'purchased_products';

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'theme_id',
        'store_id',
    ];
}
