<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'name', 'type', 'theme_id'
    ];

    public static $form_type   = [        
        'dropdown'=>'Dropdown',
        'collection_horizontal'=>'Collection Horizontal'
    ];
}