<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';

    protected $fillable = [
        'name', 'slug', 'terms', 'store_id', 'theme_id'
    ];

    public function attributeOptions()
    {
        return $this->hasMany(ProductAttributeOption::class, 'attribute_id')->orderBy('order','asc');
    }

    public function options() {
        return $this->hasMany(ProductAttributeOption::class);
    }
}
