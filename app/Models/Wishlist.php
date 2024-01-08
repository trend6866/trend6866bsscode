<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'product_id', 'status', 'theme_id'
    ];

    protected $appends = ["demo_field", 'product_name', 'product_image', 'variant_name', 'original_price', 'final_price'];

    public function getDemoFieldAttribute()
    {
        return 'demo_field';
    }

    public function getProductImageAttribute()
    {
        $cover_image_path = '';
        $product = Product::find($this->product_id);
        if(!empty($product)) {
            $cover_image_path = $product->cover_image_path;
        }
        return $cover_image_path;
    }

    public function getProductNameAttribute()
    {
        $name = '';
        $product = Product::find($this->product_id);
        if(!empty($product)) {
            $name = $product->name;
        }
        return $name;
    }

    public function getVariantIdAttribute()
    {
        $id = '';
        $product = Product::find($this->product_id);
        if(!empty($product)) {
            $id = $product->default_variant_id;
        }
        return $id;
    }

    public function getVariantNameAttribute()
    {
        $name = '';
        $product = Product::find($this->product_id);        
        if(!empty($product->default_variant_id)) {
            $ProductStock = ProductStock::find($product->default_variant_id);
            if(!empty($ProductStock)) {
                $name = $ProductStock->variant;
            }
        }
        return $name;
    }

    public function getOriginalPriceAttribute()
    {
        $price = 0;
        $product = Product::find($this->product_id);
        if(!empty($product))
        {
            $price = SetNumber($product->original_price);
        }
        return $price;
    }
    
    public function getFinalPriceAttribute()
    {
        $price = 0;
        $product = Product::find($this->product_id);
        if(!empty($product))
        {
            $price = SetNumber($product->final_price);
        }        
        return $price;
    }

    public function UserData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function CategoryData()
    {
        return $this->hasOne(MainCategory::class, 'id', 'category_id');
    }

    public function ProductData()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function GetVariant()
    {
        return $this->hasone(ProductStock::class,'id','variant_id');
    }

    public static function WishCount()
    {
        $return = 0;
        if (Auth::check()) {
            $return = Wishlist::where('user_id', Auth::user()->id)
            ->where('theme_id', APP_THEME())
            ->count();
        } 
        
        return $return;
    }

}