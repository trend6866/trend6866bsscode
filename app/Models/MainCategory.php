<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'image_path',
        'icon_path',
        'trending',
        'status',
        'theme_id',
        'store_id'
    ];

    protected $hidden = [
        'image_url'
    ];

    protected $appends = ["demo_field", "category_item", "maincategory_id","image_path_full_url","icon_path_full_url","total_product"];

    /* ********************************
            Field Append Start
    ******************************** */
    public function getDemoFieldAttribute()
    {
        return 'demo_field';
    }

    public function getMaincategoryIdAttribute() {
        return $this->id;
    }
    
    public function getCategoryItemAttribute() {
        $Subcategory = Utility::ThemeSubcategory($this->theme_id);
        $count = 0;
        if($Subcategory == 1) {            
            $count = SubCategory::where('maincategory_id', $this->id)->count();
        }
        return $count;
    }

    public function getTotalProductAttribute() {
        $count = 0;
        $count = Product::where('category_id', $this->id)->count();
        return $count;
    }
    /* ********************************
            Field Append End
    ******************************** */

    public function scopeReturnCount($query)
    {
        $query->select('users_mws.*')->join(
            'users',
            'users_mws.user_id',
            '=',
            'users.id'
        )
        ->where('users.status','<>','Dumped2')
        ->orderBy('users_mws.mws_name','asc');

        return $query;
    }

    public function getImagePathFullUrlAttribute() {
        return get_file($this->image_path, $this->theme_id);
    }

    public function getIconPathFullUrlAttribute() {
        return get_file($this->icon_path, $this->theme_id);
    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
    
    public static function HomePageCategory($slug , $no = 2)
    {
        $landing_categories = MainCategory::where('status', 1)->where('theme_id', APP_THEME())->where('store_id',getCurrentStore())->limit($no)->get();

        return view('homepage_category', compact('slug','landing_categories'))->render();
    }

    public static function HomePageBestCategory($slug , $no = 2)
    {
        $cat = Product::select('category_id')->where('tag_api','best seller')->where('theme_id', APP_THEME())->where('store_id',getCurrentStore())->groupBy('category_id')->pluck('category_id');        

        $best_seller_category = MainCategory::whereIn('id',$cat->toArray())->limit($no)->get();

        return view('homepage_category', compact('slug','best_seller_category'))->render();
    }

    

}