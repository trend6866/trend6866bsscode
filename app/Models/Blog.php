<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{ 
    use HasFactory;
    protected $fillable = [
        'title', 'short_description', 'content', 'maincategory_id', 'subcategory_id','cover_image_url', 'cover_image_path' ,'theme_id'
    ];

    protected $appends = ["cover_image_path_full_url"];

    public function MainCategory()
    {
        return $this->hasOne(MainCategory::class, 'id', 'maincategory_id');
    }

    public function SubCategory()
    {
        return $this->hasOne(SubCategory::class, 'id', 'subcategory_id');
    }

    public static function getSubId($id){
        $data = SubCategory::where('id',$id)->first();
        if($data){
            $id = $data->name;
            return $id;
        }else{
            return '';
        }
    }

    public static function HomePageBlog($slug='',$no = 2)
    {
        $landing_blogs = Blog::where('theme_id', APP_THEME())->where('store_id',getCurrentStore())->inRandomOrder()->limit($no)->get();

        return view('homepage_blog', compact('slug','landing_blogs'))->render();
    }

    public function getCoverImagePathFullUrlAttribute() {
        return get_file($this->cover_image_path, $this->theme_id);
    }

    public static function ArticlePageBlog($slug=''){
        $MainCategory = MainCategory::where('theme_id', APP_THEME())->where('store_id',getCurrentStore())->get()->pluck('name','id');
        $MainCategory->prepend('All','0');
        $blogs = Blog::where('theme_id', APP_THEME())->get();
        return view('homepage_article', compact('MainCategory','blogs'))->render();
    }

}
