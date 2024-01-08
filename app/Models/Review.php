<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'product_id', 'rating_no', 'title', 'description', 'status', 'theme_id'
    ];

    protected $appends = ["demo_field", "user_name" , "product_image_path"];

    public function getDemoFieldAttribute()
    {
        return 'demo_field';
    }


    public function getUserNameAttribute()
    {
        $User = User::find($this->user_id);        
        return $User->first_name. ' ' . $User->last_name;
    }

    public function getProductImagePathAttribute()
    {
        $product_data = Product::find($this->product_id);
        return $product_data->cover_image_path;
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

    public static function AvregeRating($product_id = 0)
    {
        $rating = Review::where('product_id', $product_id)->get();        
        if($rating) {
            $rating = array_column($rating->toArray(), 'rating_no');            
            $user = count($rating);
            if($user > 0) {
                $rating_sum = array_sum($rating);                
                $avg_rating = $rating_sum/$user;

                $Product = Product::find($product_id);                
                $Product->average_rating = number_format($avg_rating,0);
                $Product->save();
            }
        }
    }

    public static function ProductReview($no = 2, $id)
    {
        $product_review = Review::where('product_id',$id)->where('theme_id', APP_THEME())->first();
        return view('product_review', compact('product_review'))->render();
    } 
}
