<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImaage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'image_url',
        'theme_id'
    ];

    protected $appends = ["image_path", "demo_field"];
    protected $hidden = ["image_url"];

    public function getImagePathAttribute()
    {
        
        return url($this->attributes['image_path']);
    }
    
    public function getDemoFieldAttribute()
    {
        return 'demo field';
    }
}
