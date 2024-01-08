<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'other_description',
        'other_description_api',
        'tag',
        'tag_api',
        'category_id',
        'subcategory_id',
        'cover_image_path',
        'cover_image_url',
        'preview_type',
        'preview_content',
        'price',
        'discount_type',
        'discount_amount',
        'product_stock',
        'variant_product',
        'variant_id',
        'variant_attribute',
        'default_variant_id',
        'trending',
        'average_rating',
        'slug',
        'product_option',
        'product_option_api',
        'shipping_id',
        'theme_id',
        'status',
        'store_id'
    ];

    protected $appends = ["demo_field", "category_name", "maincategory_id", "other_description_array", "in_cart", "in_whishlist", "default_variant_price", "default_variant_name",  "original_price", "discount_price", "final_price", "is_review", "retuen_text", "cover_image_path_full_url", "product_option_array"];
    public $hidden_feild = ["cover_image_url"];

    /* ********************************
            Field Append Start
    ******************************** */
    public function getDemoFieldAttribute()
    {
        return 'demo_field';
    }

    public function getCategoryNameAttribute()
    {
        return !empty($this->ProductData()) ? $this->ProductData()->name : '';
    }

    public function getMaincategoryIdAttribute()
    {
        $return = $this->attributes['category_id'];
        return $return;
    }

    public function getOtherDescriptionArrayAttribute()
    {
        $other_description_api = $this->attributes['other_description_api'];
        $i = 0;
        $description_array = [];
        if (!empty($other_description_api)) {
            $other_description_array = json_decode($other_description_api, true);
            if (!empty($other_description_array['product-other-description'])) {
                foreach ($other_description_array['product-other-description'] as $key => $value) {
                    if ($value['field_type'] != "photo upload") {
                        $description_array[$i]['title'] = $value['name'];
                        $description_array[$i]['description'] = $value['value'];
                        $i++;
                    }
                }
            }
        }
        return $description_array;
    }

    public function getProductOptionArrayAttribute()
    {
        $product_option_api = $this->attributes['product_option_api'];
        $i = 0;
        $option_array = [];
        if (!empty($product_option_api)) {
            $product_option_array = json_decode($product_option_api, true);
            if (!empty($product_option_array['product-option'])) {
                foreach ($product_option_array['product-option'] as $key => $value) {
                    if ($value['field_type'] != "photo upload") {
                        $option_array[$i]['title'] = $value['name'];
                        $option_array[$i]['description'] = $value['value'];
                        $i++;
                    }
                }
            }
        }
        return $option_array;
    }

    public function getCategoryIdAttribute()
    {
        $return = $this->attributes['category_id'];
        if (!empty($this->attributes['subcategory_id']) && $this->attributes['subcategory_id'] != 0) {
            $return = $this->subcategory_id;
        }
        return $return;
    }

    public function getDefaultVariantIdAttribute()
    {
        $id = 0;
        if ($this->variant_product == 1) {
            $ProductStock = ProductStock::find($this->attributes['default_variant_id']);
            if (!empty($ProductStock) && $ProductStock->stock > 0) {
                $id = !empty($ProductStock) ? $ProductStock->id : 0;
            } else {
                $ProductStock = ProductStock::where('product_id', $this->id)->where('stock', '!=', '0')->first();
                $id = !empty($ProductStock) ? $ProductStock->id : 0;
            }
        }
        return $id;
    }

    public function getDefaultVariantPriceAttribute()
    {
        $price = 0;
        if ($this->variant_product == 1) {
            $ProductStock = ProductStock::where('product_id', $this->id)->first();
            $price = !empty($ProductStock) ? $ProductStock->price : 0;
        }
        return SetNumber($price);
    }

    public function getDefaultVariantNameAttribute()
    {
        $name = '';
        if ($this->variant_product == 1) {
            $ProductStock = ProductStock::where('product_id', $this->id)->first();
            $price = !empty($ProductStock) ? $ProductStock->name : 0;
        }
        return $name;
    }

    public function getOriginalPriceAttribute()
    {
        $variantId = $this->getAttribute('variantId');
        $variantName = $this->getAttribute('variantName');
        $variant_data = ProductStock::where('variant', $variantName)->where('product_id', $this->id)->first();

        $variant_id = !empty($variantId) ? $variantId : ($variant_data ? $variant_data->id : null);
        $price = $this->price;
        if ($this->variant_product == 1) {
            $ProductStock = ProductStock::find($variant_id);
            $price = 0;
            if (!empty($ProductStock)) {
                if ($ProductStock->price == 0 && $ProductStock->variation_price == 0) {
                    $price = $this->price;
                } else {
                    $price = $ProductStock->variation_price;
                }
            }
        }
        return SetNumber($price);
    }

    public function getDiscountPriceAttribute()
    {
        $price =  $this->price;
        $discount_type =  $this->discount_type;
        $discount_amount =  $this->discount_amount;
        if ($this->variant_product == 1) {
            $ProductStock = ProductStock::where('product_id', $this->id)->first();
            $price =  !empty($ProductStock->price) ? $ProductStock->price : '0';
        }

        if ($discount_type == 'percentage') {
            $discount_amount =  $price * $discount_amount / 100;
        }
        return SetNumber($discount_amount);
    }

    public function getFinalPriceAttribute()
    {
        $variantId = $this->getAttribute('variantId');
        $variantName = $this->getAttribute('variantName');
        $variant_data = ProductStock::where('variant', $variantName)->where('product_id', $this->id)->first();

        $variant_id = !empty($variantId) ? $variantId : ($variant_data ? $variant_data->id : null);
        $price = $this->price;
        $discount_type = $this->discount_type;
        $discount_amount = $this->discount_amount;
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = \Carbon\Carbon::now()->toDateTimeString();
        $sale_product = \App\Models\FlashSale::where('theme_id', APP_THEME())
            ->where('store_id', getCurrentStore())
            ->get();
        $latestSales = [];
        foreach ($sale_product as $flashsale) {
            if($flashsale->is_active == 1)
            {
                $saleEnableArray = json_decode($flashsale->sale_product, true);
                $startDate = \Carbon\Carbon::parse($flashsale['start_date'] . ' ' . $flashsale['start_time']);
                $endDate = \Carbon\Carbon::parse($flashsale['end_date'] . ' ' . $flashsale['end_time']);

                if ($endDate < $startDate) {
                    $endDate->addDay();
                }

                if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {
                    if (is_array($saleEnableArray) && in_array($this->id, $saleEnableArray)) {
                        $latestSales[$this->id] = [
                            'discount_type' => $flashsale->discount_type,
                            'discount_amount' => $flashsale->discount_amount,
                        ];
                    }
                }
            }
        }
        if ($latestSales == null) {
            $latestSales[$this->id] = [
                'discount_type' => $this->discount_type,
                'discount_amount' => $this->discount_amount,
            ];
        }
        foreach ($latestSales as $productId => $saleData) {

            if ($this->variant_product == 0) {
                if ($saleData['discount_type'] == 'flat') {
                    $price = $this->price - $saleData['discount_amount'];
                }
                if ($saleData['discount_type'] == 'percentage') {
                    $discount_price =  $this->price * $saleData['discount_amount'] / 100;
                    $price = $this->price - $discount_price;
                }
            } else {
                $product_variant_data = ProductStock::where('product_id', $this->id)->where('id',$variant_id)->first();
                if ($product_variant_data) {
                    if ($saleData['discount_type'] == 'flat') {
                        $price = $product_variant_data->price - $saleData['discount_amount'];
                    } elseif ($saleData['discount_type'] == 'percentage') {
                        $discount_price = $product_variant_data->price * $saleData['discount_amount'] / 100;
                        $price = $product_variant_data->price - $discount_price;
                    }
                }
            }
        }
        return SetNumber($price);
    }

    public function getInWhishlistAttribute()
    {
        $id = !empty(auth()->user()) ? auth()->user()->id : 0;
        return Wishlist::where('product_id', $this->id)->where('user_id', $id)->exists();
    }

    public function getInCartAttribute()
    {
        $id = !empty(auth()->user()) ? auth()->user()->id : 0;
        return Cart::where('product_id', $this->id)->where('user_id', $id)->exists();
    }

    public function getRetuenTextAttribute()
    {
        return __('Return the product within 14 days for a full refund') . '.';
    }

    public function getIsReviewAttribute()
    {
        // 1 => hide , 0 => show
        $is_review = 0;
        $user_id = !empty(auth()->user()) ? auth()->user()->id : 0;
        $product_id = !empty($this->attributes['id']) ? $this->attributes['id'] : 0;
        $where_like = '%"product_id":' . $product_id . ',%';
        $Order = Order::where('user_id', $user_id)->where('product_json', 'LIKE', $where_like)
            ->exists();
        if ($Order) {
            $is_Review = Review::where('user_id', $user_id)->where('product_id', $product_id)->exists();
            if ($is_Review) {
                $is_review = 1;
            }
        } else {
            $is_review = 1;
        }
        return $is_review;
    }

    public function getCoverImagePathFullUrlAttribute()
    {
        return get_file($this->cover_image_path, $this->theme_id);
    }

    /* ********************************
    Field Append End
    ******************************** */
    public function ProductData()
    {
        return $this->hasOne(MainCategory::class, 'id', 'MaincategoryId')->first();
    }

    public function SubCategoryctData()
    {
        return $this->hasOne(SubCategory::class, 'id', 'subcategory_id');
    }

    public function DefaultVariantData()
    {
        return $this->hasOne(ProductStock::class, 'id', 'default_variant_id');
    }

    public static function VariantAttribute($id = 0)
    {
        $return = '';
        if ($id) {
            $ProductVariant = ProductVariant::find($id);
            if (!empty($ProductVariant)) {
                $return = $ProductVariant;
            }
        }
        return $return;
    }

    public function ProductVariant($sku_name = '')
    {
        $ProductStock = ProductStock::where('product_id', $this->id)->where('variant', $sku_name)->first();
        return $ProductStock;
    }

    public static function bestseller_guest($theme_id = '', $per_page = '6', $destination = 'app')
    {
        $bestseller_array_query = Product::where('theme_id', $theme_id)->where('tag_api', 'best seller')->where('store_id', getCurrentStore());
        if (!empty($destination) && $destination == 'web') {
            if ($per_page != 'all') {
                $bestseller_array_query->limit($per_page);
            }
            $bestseller_array = $bestseller_array_query->inRandomOrder()->get();
        } else {
            $bestseller_array = $bestseller_array_query->paginate($per_page);
        }
        // $bestseller_array = Product::where('theme_id', $theme_id)->where('tag_api', 'best seller')->paginate(6);
        $cart = 0;

        $return['status'] = 'success';
        $return['bestseller_array'] = $bestseller_array;
        $return['cart'] = $cart;
        return $return;
    }

    public static function Sub_image($product_id = 0)
    {
        $return['status'] = false;
        $return['data'] = [];
        $ProductImage = ProductImage::where('product_id', $product_id)->get();
        if (!empty($ProductImage)) {
            $return['status'] = true;
            $return['data'] = $ProductImage;
        }
        return $return;
    }

    public static function instruction_array($theme_id = '', $store_id = '')
    {
        $return = [];
        if (!empty($theme_id)) {
            $path = base_path('themes/' . $theme_id . '/theme_json/homepage.json');
            $json = json_decode(file_get_contents($path), true);
            $setting_json = AppSetting::select('theme_json')
                ->where('theme_id', $theme_id)
                ->where('page_name', 'main')
                ->where('store_id', $store_id)
                ->first();
            if (!empty($setting_json)) {
                $json = json_decode($setting_json->theme_json, true);
            }
            foreach ($json as $key => $value) {
                if ($value['unique_section_slug'] == 'homepage-plant-instruction') {
                    if ($value['array_type'] == 'multi-inner-list') {
                        for ($i = 0; $i < $value['loop_number']; $i++) {
                            foreach ($value['inner-list'] as $key1 => $value1) {
                                // $img_path = '';
                                // $description = '';
                                if ($value1['field_slug'] == 'homepage-plant-instruction-image') {
                                    $img_path = $value1['field_default_text'];
                                    if (!empty($json[$key][$value1['field_slug']])) {
                                        if (!empty($json[$key][$value1['field_slug']][$i]['image'])) {
                                            $img_path = $json[$key][$value1['field_slug']][$i]['image'];
                                        }
                                    }
                                }
                                if ($value1['field_slug'] == 'homepage-plant-instruction-description') {
                                    $description = $value1['field_default_text'];
                                    $return[$i]['description'] = $value1['field_default_text'];
                                    if (!empty($json[$key][$value1['field_slug']])) {
                                    }
                                }
                            }
                            $return[$i]['img_path'] = $img_path;
                            $return[$i]['description'] = $description;
                        }
                    }
                }
            }
        }
        return $return;
    }


    public static function GetLatestProduct($slug = '', $no = 2)
    {
        $lat_products = Product::orderBy('created_at', 'Desc')->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->limit($no)->get();
        return view('homepage_latest_product', compact('slug', 'lat_products'))->render();
    }

    public static function GetLatProduct($slug = '', $no = 1)
    {
        $latest_pro = Product::orderBy('created_at', 'Desc')->where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->limit($no)->first();
        return view('home_latest_product', compact('slug', 'latest_pro'))->render();
    }

    public static function ProductPageBestseller($slug = '')
    {
        $MainCategory = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->get()->pluck('name', 'id');
        $MainCategory->prepend('All Products', '0');
        $homeproducts = Product::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->get();
        return view('bestseller_product', compact('homeproducts', 'MainCategory', 'slug'))->render();
    }
}
