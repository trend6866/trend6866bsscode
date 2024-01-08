<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\Store;
use App\Models\Utility;
use App\Models\woocommerceconection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Codexshaper\WooCommerce\Facades\Product;
// use Illuminate\Support\Facades\Http;

class WoocomProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('Manage Woocommerce Product'))
        {
            try{

                $store_id = Store::where('id', getCurrentStore())->first();
                $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
                $woocommerce_store_url =\App\Models\Utility::GetValueByName('woocommerce_store_url',$theme_name);
                $woocommerce_consumer_secret =\App\Models\Utility::GetValueByName('woocommerce_consumer_secret',$theme_name);
                $woocommerce_consumer_key =\App\Models\Utility::GetValueByName('woocommerce_consumer_key',$theme_name);

                config(['woocommerce.store_url' => $woocommerce_store_url]);
                config(['woocommerce.consumer_key' => $woocommerce_consumer_key]);
                config(['woocommerce.consumer_secret' => $woocommerce_consumer_secret]);

                $jsonData = Product::all(['per_page' => 100]);

                $woocommerce_store_url =\App\Models\Utility::GetValueByName('woocommerce_store_url',$theme_name);
                // $response = \Http::get($woocommerce_store_url . '/wp-json/wc/v3/products');
                // $jsonData = $response->json();

                $path = base_path('themes/' . APP_THEME() . '/theme_json/' . 'product-detail.json');
                $upddata = woocommerceconection::where('theme_id',$store_id->theme_id)->where('store_id',getCurrentStore())->where('module','=','product')->get()->pluck('woocomerce_id')->toArray();

                return view('woocom_product.index', compact('jsonData','upddata'));
            }

            catch(\Exception $e){
                return redirect()->back()->with('error' , 'Something went wrong.');
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
        $woocommerce_store_url =\App\Models\Utility::GetValueByName('woocommerce_store_url',$theme_name);
        $response = \Http::get($woocommerce_store_url . '/wp-json/wc/v3/products');
        $jsonData = $response->json();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(\Auth::user()->can('Create Woocommerce Product'))
        {
            $ThemeSubcategory = Utility::addThemeSubcategory();

            $path = base_path('themes/' . APP_THEME() . '/theme_json/' . 'product-detail.json');
            $description_json_HTML = '';
            if(file_exists($path)){
                $json = json_decode(file_get_contents($path), true);
                $description_json_HTML = view('product.description_json', compact('json'))->render();
            }

            // product option json
            $path = base_path('themes/' . APP_THEME() . '/theme_json/' . 'product-option.json');
            $option_json_HTML = '';
            if(file_exists($path)){
                $option_json = json_decode(file_get_contents($path), true);
                $option_json_HTML = view('product.option_json', compact('option_json'))->render();
            }


            $store_id = Store::where('id', getCurrentStore())->first();
            $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
            $woocommerce_store_url =\App\Models\Utility::GetValueByName('woocommerce_store_url',$theme_name);
            $woocommerce_consumer_secret =\App\Models\Utility::GetValueByName('woocommerce_consumer_secret',$theme_name);
            $woocommerce_consumer_key =\App\Models\Utility::GetValueByName('woocommerce_consumer_key',$theme_name);

            config(['woocommerce.store_url' => $woocommerce_store_url]);
            config(['woocommerce.consumer_key' => $woocommerce_consumer_key]);
            config(['woocommerce.consumer_secret' => $woocommerce_consumer_secret]);
            $jsonData = Product::find($id);
            // dd($jsonData['categories'][0]->id);

            $store_id = Store::where('id', getCurrentStore())->first();
            $upddata = woocommerceconection::where('theme_id',$store_id->theme_id)->where('store_id',getCurrentStore())->where('module','=','category')->where('woocomerce_id' , $jsonData['categories'][0]->id)->pluck('woocomerce_id')->first();

             if(empty($upddata)){
                return redirect()->back()->with('error', __('Add Woocommerce Product Category'));
             }

                // description array
                $array = !empty($json) ? $json : [];
                $array_api = [];
                foreach ($array as $array_key => $slug) {
                    foreach ($slug['inner-list'] as $slug_key => $value) {

                        $array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                        $array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                        $array_api[$slug['section_slug']][$slug_key]['value'] = !empty($value['field_default_text']) ? $value['field_default_text'] : '';

                        if($value['field_type'] == 'photo upload') {

                            $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
                            $theme_image = !empty($value['value']) ? $value['value'] : '';
                            $upload_image_path = !empty($value['value']) ? $value['value'] : '';
                            if(gettype($theme_image) == 'object')  {

                                $fileName = rand(10,100).'_'.time() . "_" . $theme_image->getClientOriginalName();
                                $upload = Utility::jsonUpload_file($theme_image,$fileName,$dir,[]);
                                if($upload['flag'] == true) {
                                    $upload_image_path = $upload['image_path'];
                                }
                            }

                            $array[$array_key]['inner-list'][$slug_key]['image_path'] = $upload_image_path;
                            $array[$array_key]['inner-list'][$slug_key]['value'] = $upload_image_path;

                            $array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                            $array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                            $array_api[$slug['section_slug']][$slug_key]['value'] = $value['field_default_text'];
                        }
                    }
                }
                // option array
                $option_array = !empty($option_json) ? $option_json : [];
                $option_array_api = [];
                foreach ($option_array as $array_key => $slug) {
                    foreach ($slug['inner-list'] as $slug_key => $value) {
                        $option_array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                        $option_array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                        $option_array_api[$slug['section_slug']][$slug_key]['value'] = !empty($value['value']) ? $value['value'] : '';

                    }
                }



            if(!empty($jsonData['regular_price']) && !empty($jsonData['sale_price']) ){
                $discount_amount =$jsonData['regular_price'] - $jsonData['sale_price'];
            }
            else{
                $discount_amount = 0;
            }

            if(!empty($jsonData['images'][0]->src)) {
                $url = $jsonData['images'][0]->src;

                $file_type = config('files_types');

                foreach($file_type as $f){
                    $name = basename($url, ".".$f);
                }
                $file2 = rand(10,100).'_'.time() . "_" . $name;
                $path = 'themes/'.APP_THEME().'/uploads/';
                $uplaod =Utility::upload_woo_file($url,$file2,$path);
            }
            else{

                $url    = asset(Storage::url('uploads/woocommerce.png'));
                $name   ='woocommerce.png';
                $file2  = rand(10,100).'_'.time() . "_" . $name;
                $path   ='themes/'.APP_THEME().'/uploads/';
                $uplaod =Utility::upload_woo_file($url,$file2,$path);

            }


            $upddata = woocommerceconection::where('theme_id',$store_id->theme_id)->where('store_id',getCurrentStore())->where('module','=','category')->where('woocomerce_id' , $jsonData['categories'][0]->id)->pluck('woocomerce_id')->first();

            if(empty($upddata)){
               return redirect()->back()->with('error', __('Add Woocommerce Product Category'));
            }
            $category = woocommerceconection::where('theme_id',$store_id->theme_id)->where('store_id',getCurrentStore())->where('module','=','category')->where('woocomerce_id' , $jsonData['categories'][0]->id)->pluck('original_id')->first();


            if (!empty($jsonData)) {
                $product                        = new \App\Models\Product();
                $product->name                  = $jsonData['name'];
                $product->description           = strip_tags($jsonData['description']);
                $product->other_description     = !empty($array) ? json_encode($array) : '';
                $product->other_description_api = !empty($array_api) ? json_encode($array_api) : '';
                $product->cover_image_path      = $uplaod['url'];
                $product->cover_image_url       = $uplaod['full_url'];
                $product->category_id           = $category;
                $product->discount_type         ='flat';
                $product->discount_amount       =$discount_amount;
                $product->variant_product       = 0;
                $product->product_stock         =!empty($jsonData['stock_quantity']) ? $jsonData['stock_quantity'] : 0;
                $product->slug                  =str_replace(' ','_', strtolower($jsonData['name']));
                $product->price                 = $jsonData['price'];
                $product->theme_id              = APP_THEME();
                $product->store_id              = getCurrentStore();
                $product->created_by            = \Auth::guard('admin')->user()->id;
                $product->save();

                $products                    = new woocommerceconection();
                $products->store_id          = getCurrentStore();
                $products->theme_id          = APP_THEME();
                $products->module            = 'product';
                $products->woocomerce_id     = $jsonData['id'];
                $products->original_id       =$product->id;
                $products->save();

                if(empty($jsonData['images'][1])){
                    $url  = asset(Storage::url('uploads/woocommerce.png'));
                    $name = 'woocommerce.png';
                    $file2 = rand(10,100).'_'.time() . "_" . $name;
                    $path = 'themes/'.APP_THEME().'/uploads/';
                    $ulpaod =Utility::upload_woo_file($url,$file2,$path);

                    $ProductImage = new ProductImage();
                    $ProductImage->product_id = $product->id;
                    if($ThemeSubcategory == 1) {
                        $products->subcategory_id = $products->subcategory_id;
                    }
                    $ProductImage->image_path = $ulpaod['url'];
                    $ProductImage->image_url  = $ulpaod['full_url'];
                    $ProductImage->theme_id   = $store_id->theme_id;
                    $ProductImage->store_id   = getCurrentStore();
                    $ProductImage->save();
                }else{
                    for ($i = 1; $i < count($jsonData['images']); $i++) {
                        $image = $jsonData['images'][$i];
                        $id = $image->id;
                        $dateCreated = $image->date_created;
                        $src = $image->src;

                        $url = $src;

                        $file_type = config('files_types');

                        foreach($file_type as $f){
                            $name = basename($url, ".".$f);
                        }
                        $file2 = rand(10,100).'_'.time() . "_" . $name;
                        $path = 'themes/'.APP_THEME().'/uploads/';
                        $subimg =Utility::upload_woo_file($url,$file2,$path);

                        $ProductImage = new ProductImage();
                        $ProductImage->product_id = $product->id;
                        if($ThemeSubcategory == 1) {
                            $products->subcategory_id = $products->subcategory_id;
                        }
                        $ProductImage->image_path = $subimg['url'];
                        $ProductImage->image_url  = $subimg['full_url'];
                        $ProductImage->theme_id   = $store_id->theme_id;
                        $ProductImage->store_id   = getCurrentStore();
                        $ProductImage->save();
                    }

                }
                return redirect()->back()->with('success', __('Product successfully Add.'));

            } else {
                return redirect()->back()->with('error', __('Product Not Found.'));
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->can('Edit Woocommerce Product'))
        {
            $store_id = Store::where('id', getCurrentStore())->first();
            $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
            $woocommerce_store_url =\App\Models\Utility::GetValueByName('woocommerce_store_url',$theme_name);
            $woocommerce_consumer_secret =\App\Models\Utility::GetValueByName('woocommerce_consumer_secret',$theme_name);
            $woocommerce_consumer_key =\App\Models\Utility::GetValueByName('woocommerce_consumer_key',$theme_name);

            config(['woocommerce.store_url' => $woocommerce_store_url]);
            config(['woocommerce.consumer_key' => $woocommerce_consumer_key]);
            config(['woocommerce.consumer_secret' => $woocommerce_consumer_secret]);
            $jsonData = Product::find($id);
            // dd($jsonData);
            $settings = Setting::where('theme_id', APP_THEME())->where('store_id',1)->pluck('value', 'name')->toArray();
            if(!isset($settings['storage_setting'])){
                $settings = Utility::Seting();

            }
            $store_id = Store::where('id', getCurrentStore())->first();
            $upddata = woocommerceconection::where('theme_id',$store_id->theme_id)->where('store_id',getCurrentStore())->where('module','=','product')->where('woocomerce_id' , $id)->first();
            if(!empty($jsonData['images'][0]->src)) {
                $url = $jsonData['images'][0]->src;
                $file_type = config('files_types');

                foreach($file_type as $f){
                    $name = basename($url, ".".$f);
                }
                $file2 = rand(10,100).'_'.time() . "_" . $name;
                $path = 'themes/'.APP_THEME().'/uploads/';
                $uplaod =Utility::upload_woo_file($url,$file2,$path);


            }

            $original_id = $upddata->original_id;
            $product = \App\Models\Product::find($original_id);
            $discount_amount = (!empty($jsonData['regular_price']) ? $jsonData['regular_price'] : 0) - (!empty($jsonData['sale_price']) ? $jsonData['sale_price'] : 0);

            $upddata = woocommerceconection::where('theme_id',$store_id->theme_id)->where('store_id',getCurrentStore())->where('module','=','category')->where('woocomerce_id' , $jsonData['categories'][0]->id)->pluck('woocomerce_id')->first();

            if(empty($upddata)){
               // dd('fkg');
               return redirect()->back()->with('error', __('Add Woocommerce Product Category'));
            }
            $category = woocommerceconection::where('theme_id',$store_id->theme_id)->where('store_id',getCurrentStore())->where('module','=','category')->where('woocomerce_id' , $jsonData['categories'][0]->id)->pluck('original_id')->first();

            if (!empty($jsonData)) {
                $product->name                  = $jsonData['name'];
                $product->description           = strip_tags($jsonData['description']);
                $product->cover_image_path      = $uplaod['url'];
                $product->cover_image_url       = $uplaod['full_url'];
                $product->category_id           = $category;
                $product->discount_type         ='flat';
                $product->discount_amount       =$discount_amount;
                $product->variant_product       = 0;
                $product->product_stock         =!empty($jsonData['stock_quantity']) ? $jsonData['stock_quantity'] : 0;
                $product->slug                  =str_replace(' ','_', strtolower($jsonData['name']));
                $product->price                 = $jsonData['price'];
                $product->theme_id              = APP_THEME();
                $product->store_id              = getCurrentStore();
                $product->save();
                return redirect()->back()->with('success', __('Product successfully Updated.'));
            }
            else{
                return redirect()->back()->with('error', __('Product Not Found.'));

            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
