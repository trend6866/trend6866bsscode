<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\MainCategory;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\ProductImage;
use App\Models\ProductStock;
use App\Models\shopifyconection;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ShopifyProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('Manage Shopify Product')) {
            try {
                $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
                $shopify_store_url = \App\Models\Utility::GetValueByName('shopify_store_url', $theme_name);
                $shopify_access_token = \App\Models\Utility::GetValueByName('shopify_access_token', $theme_name);
                // dd($shopify_store_url,$shopify_access_token);

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://$shopify_store_url.myshopify.com/admin/api/2023-07/products.json",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        "X-Shopify-Access-Token: $shopify_access_token"
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                if ($response == false) {
                    return redirect()->back()->with('error', 'Something went wrong.');
                } else {
                    $product = json_decode($response, true);

                    if (isset($product['errors'])) {

                        $errorMessage = $product['errors'];
                        return redirect()->back()->with('error', $errorMessage);
                    } else {
                        $upddata = shopifyconection::where('theme_id', $theme_name)->where('store_id', getCurrentStore())->where('module', '=', 'product')->pluck('shopify_id')->toArray();

                        return view('shopify.product', compact('product', 'upddata'));
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        } else {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::user()->can('Create Shopify Product')) 
        {
            try {
                $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
                $store_id = Store::where('id', getCurrentStore())->first();
                $shopify_store_url = \App\Models\Utility::GetValueByName('shopify_store_url', $theme_name);
                $shopify_access_token = \App\Models\Utility::GetValueByName('shopify_access_token', $theme_name);

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://$shopify_store_url.myshopify.com/admin/api/2023-07/products.json?ids=$id",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        "X-Shopify-Access-Token: $shopify_access_token"
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                if ($response == false) {
                    return redirect()->back()->with('error', 'Something went wrong.');
                } else {
                    $maincategory = MainCategory::where('theme_id',APP_THEME())->where('store_id', getCurrentStore())->first();
                    
                    $products = json_decode($response, true);

                    $upddata = shopifyconection::where('theme_id', $theme_name)->where('store_id', getCurrentStore())->where('module', '=', 'category')->where('shopify_id', $products['products'][0]['product_type'])->pluck('shopify_id')->first();
                    // if(empty($upddata)){
                    //    return redirect()->back()->with('error', __('Add Shopify Product Category'));
                    // }
                    if (isset($products['errors'])) {

                        $errorMessage = $products['errors'];
                        return redirect()->back()->with('error', $errorMessage);
                    } else {

                        if (isset($products) && !empty($products)) {
                            $path = base_path('themes/' . APP_THEME() . '/theme_json/' . 'product-detail.json');
                            $description_json_HTML = '';
                            if (file_exists($path)) {
                                $json = json_decode(file_get_contents($path), true);
                                $description_json_HTML = view('product.description_json', compact('json'))->render();
                            }

                            // product option json
                            $path = base_path('themes/' . APP_THEME() . '/theme_json/' . 'product-option.json');
                            $option_json_HTML = '';
                            if (file_exists($path)) {
                                $option_json = json_decode(file_get_contents($path), true);
                                $option_json_HTML = view('product.option_json', compact('option_json'))->render();
                            }
                            // description array
                            $array = !empty($json) ? $json : [];
                            $array_api = [];
                            foreach ($array as $array_key => $slug) {
                                foreach ($slug['inner-list'] as $slug_key => $value) {

                                    $array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                                    $array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                                    $array_api[$slug['section_slug']][$slug_key]['value'] = !empty($value['field_default_text']) ? $value['field_default_text'] : '';

                                    if ($value['field_type'] == 'photo upload') {

                                        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
                                        $theme_image = !empty($value['value']) ? $value['value'] : '';
                                        $upload_image_path = !empty($value['value']) ? $value['value'] : '';
                                        if (gettype($theme_image) == 'object') {

                                            $fileName = rand(10, 100) . '_' . time() . "_" . $theme_image->getClientOriginalName();
                                            $upload = Utility::jsonUpload_file($theme_image, $fileName, $dir, []);
                                            if ($upload['flag'] == true) {
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

                            if (!empty($products['products'][0]['image']['src'])) {
                                $ImageUrl = $products['products'][0]['image']['src'];
                                $url =  strtok($ImageUrl, '?');
                                $file_type = config('files_types');

                                foreach ($file_type as $f) {
                                    $name = basename($url, "." . $f);
                                }
                                $file2 = rand(10, 100) . '_' . time() . "_" . $name;
                                $path = 'themes/' . APP_THEME() . '/uploads/';
                                $uplaod = Utility::upload_woo_file($url, $file2, $path);
                            } else {

                                $url    = asset(Storage::url('uploads/woocommerce.png'));
                                $name   = 'woocommerce.png';
                                $file2  = rand(10, 100) . '_' . time() . "_" . $name;
                                $path   = 'themes/' . APP_THEME() . '/uploads/';
                                $uplaod = Utility::upload_woo_file($url, $file2, $path);
                            }
                            $product                          = new Product();
                            $product->name                    = $products['products'][0]['title'];
                            $product->description             = strip_tags($products['products'][0]['body_html']);
                            $product->other_description       = json_encode($array);
                            $product->other_description_api   = json_encode($array_api);
                            $product->cover_image_path      = $uplaod['url'];
                            $product->cover_image_url       = $uplaod['full_url'];
                            if ($products['products'][0]['variants'][0]['title'] == 'Default Title') {
                                $product->product_weight          = $products['products'][0]['variants'][0]['weight'];
                            }
                            $product->category_id             = $maincategory->id;

                            $product->discount_type = 'flat';
                            $discount_amount = $products['products'][0]['variants'][0]['compare_at_price'] - $products['products'][0]['variants'][0]['price'];
                            $product->discount_amount = $discount_amount;
                            if ($products['products'][0]['variants'][0]['title'] == 'Default Title') {
                                $product->variant_product = 0;
                            } else {
                                $product->variant_product = 1;
                                $product->variant_id =  json_encode([]);
                            }
                            $product->slug    = str_replace(' ', '_', strtolower($products['products'][0]['title']));
                            $product->status = 1;
                            if ($products['products'][0]['variants'][0]['title'] == 'Default Title') {
                                $product->track_stock = 1;
                                $product->stock_order_status = 'not_allow';
                                $product->price = $products['products'][0]['variants'][0]['price'];
                                $product->product_stock = $products['products'][0]['variants'][0]['inventory_quantity'];
                                $product->variant_id = NULL;
                                $product->variant_attribute = NULL;
                            }
                            $product->track_stock = 1;
                            $product->theme_id              = APP_THEME();
                            $product->store_id              = getCurrentStore();
                            $product->created_by            = \Auth::guard('admin')->user()->id;
                            $attribute_id = [];


                            $option_attribute_value = [];
                            foreach ($products['products'][0]['options'] as $option) {
                                $option_attribute_value[] = $option['values'];
                            }
                            $mergedArray = [];
                            foreach ($option_attribute_value as $array) {
                                $mergedArray = array_merge($mergedArray, $array);
                            }
                            $options_value_mergedArray = array_map(function ($element) {
                                return str_replace(' ', '', $element);
                            }, $mergedArray);


                            if ($products['products'][0]['variants'][0]['title'] != 'Default Title') {
                                foreach ($products['products'][0]['options'] as $option) {
                                    $product_Attrybute = ProductAttribute::where('name', $option['name'])->where('theme_id', $theme_name)->where('store_id', getCurrentStore())->first();
                                    $slug = Admin::slugs($option['name']);

                                    if (!empty($product_Attrybute->name) != $option['name']) {
                                        $attribute                      = new ProductAttribute();

                                        $attribute->name                = $option['name'];
                                        $attribute->slug                = $slug;
                                        $attribute->theme_id            = APP_THEME();
                                        $attribute->store_id            = getCurrentStore();
                                        $attribute->save();
                                    }

                                    foreach ($option['values'] as $ProductAttribute) {
                                        $title = str_replace(' ', '', $ProductAttribute);
                                        $product_AttributeOption = ProductAttributeOption::where('terms', $title)->where('theme_id', $theme_name)->where('store_id', getCurrentStore())->first();
                                        if (!empty($product_AttributeOption->terms) != $title) {
                                            $attribute_option                      = new ProductAttributeOption();
                                            $attribute_option->attribute_id        = !empty($attribute->id) ? $attribute->id : $product_Attrybute->id;
                                            $attribute_option->terms               = $title;
                                            $attribute_option->theme_id            = APP_THEME();
                                            $attribute_option->store_id            = getCurrentStore();
                                            $attribute_option->save();
                                        }
                                    }
                                    if (!empty($attribute)) {
                                        $attribute_id[] = $attribute->id;
                                    } else {
                                        $attribute_id[] = $product_Attrybute->id;
                                    }
                                }

                                $product->attribute_id = json_encode($attribute_id);
                                $attribute_options = [];
                                $options_value = array_map(function ($element) {
                                    return str_replace(' ', '', $element);
                                }, $option['values']);
                                $attribute_option_terms = ProductAttributeOption::whereIn('attribute_id', $attribute_id)->whereIn('terms', $options_value_mergedArray)->pluck('terms')->toArray();
                                // dd($attribute_option_terms);
                                foreach ($attribute_id as $key => $no) {


                                    $conditionMet = false;

                                    foreach ($options_value_mergedArray as $ProductAttribute) {
                                        if (in_array($ProductAttribute, $attribute_option_terms)) {
                                            $conditionMet = true;
                                            break;
                                        }
                                    }
                                    if ($conditionMet) {
                                        $attribute_option_id = ProductAttributeOption::where('attribute_id', $no)->whereIn('terms', $options_value_mergedArray)->pluck('id')->toArray();
                                    } else {
                                        $attribute_option_id = ProductAttributeOption::where('attribute_id', $no)->pluck('id')->toArray();
                                    }

                                    $enable_option = 1;
                                    $variation_option = 1;
                                    $item['attribute_id'] = $no;

                                    $item['values'] = explode(',', implode('|', $attribute_option_id));

                                    $item['visible_attribute_' . $no] = $enable_option;
                                    $item['for_variation_' . $no] = $variation_option;
                                    array_push($attribute_options, $item);
                                }
                                $attribute_options = json_encode($attribute_options);
                                $product->product_attribute = $attribute_options;
                            }


                            $product->save();

                            if ($products['products'][0]['variants'][0]['title'] != 'Default Title') {

                                foreach ($products['products'][0]['variants'] as $variants) {
                                    // $title_spase = str_replace(' ', '', $variants['title']);
                                    $title_spase = str_replace(' / ', '-', $variants['title']);
                                    $title = str_replace(' ', '', $title_spase);

                                    $sku = str_replace(' ', '_', $product->name . '-' . $title);
                                    $product_stock                 = new ProductStock;
                                    $product_stock->product_id     = $product->id;
                                    $product_stock->variant        = $title;
                                    $product_stock->sku            = $sku;
                                    $product_stock->stock          = $variants['inventory_quantity'];
                                    $product_stock->price          = $variants['price'];
                                    $product_stock->variation_price = $variants['price'];
                                    $product_stock->stock_order_status = 'not_allow';
                                    $product_stock->variation_option = 'manage_stock';
                                    $product_stock->variation_option = 'manage_stock';
                                    $product_stock->theme_id            = APP_THEME();
                                    $product_stock->store_id            = getCurrentStore();
                                    $product_stock->save();
                                }
                            }

                            if (empty($products['products'][0]['images'][0])) {
                                $url  = asset(Storage::url('uploads/woocommerce.png'));
                                $name = 'woocommerce.png';
                                $file2 = rand(10, 100) . '_' . time() . "_" . $name;
                                $path = 'themes/' . APP_THEME() . '/uploads/';
                                $ulpaod = Utility::upload_woo_file($url, $file2, $path);

                                $ProductImage = new ProductImage();
                                $ProductImage->product_id = $product->id;

                                $ProductImage->image_path = $ulpaod['url'];
                                $ProductImage->image_url  = $ulpaod['full_url'];
                                $ProductImage->theme_id   = $store_id->theme_id;
                                $ProductImage->store_id   = getCurrentStore();
                                $ProductImage->save();
                            } else {
                                for ($i = 1; $i < count($products['products'][0]['images']); $i++) {
                                    $image = $products['products'][0]['images'][$i];
                                    $id = $image['id'];
                                    $dateCreated = $image['created_at'];
                                    $src = $image['src'];

                                    $ImageUrl = $src;
                                    $url =  strtok($ImageUrl, '?');

                                    $file_type = config('files_types');

                                    foreach ($file_type as $f) {
                                        $name = basename($url, "." . $f);
                                    }
                                    $file2 = rand(10, 100) . '_' . time() . "_" . $name;
                                    $path = 'themes/' . APP_THEME() . '/uploads/';
                                    $subimg = Utility::upload_woo_file($url, $file2, $path);

                                    $ProductImage = new ProductImage();
                                    $ProductImage->product_id = $product->id;

                                    $ProductImage->image_path = $subimg['url'];
                                    $ProductImage->image_url  = $subimg['full_url'];
                                    $ProductImage->theme_id   = $store_id->theme_id;
                                    $ProductImage->store_id   = getCurrentStore();
                                    $ProductImage->save();
                                }
                            }

                            $products_connection                    = new shopifyconection();
                            $products_connection->store_id          = getCurrentStore();
                            $products_connection->theme_id          = APP_THEME();
                            $products_connection->module            = 'product';
                            $products_connection->shopify_id        = $products['products'][0]['id'];
                            $products_connection->original_id       = $product->id;
                            $products_connection->save();





                            return redirect()->back()->with('success', 'Product successfully add.');
                        }
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'This email already used.');
            }
        } else {
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
        if (\Auth::user()->can('Edit Shopify Product')) {
            try {
                $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
                $store_id = Store::where('id', getCurrentStore())->first();
                $shopify_store_url = \App\Models\Utility::GetValueByName('shopify_store_url', $theme_name);
                $shopify_access_token = \App\Models\Utility::GetValueByName('shopify_access_token', $theme_name);

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://$shopify_store_url.myshopify.com/admin/api/2023-07/products.json?ids=$id",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        "X-Shopify-Access-Token: $shopify_access_token"
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                if ($response == false) {
                    return redirect()->back()->with('error', 'Something went wrong.');
                } else {
                    $products = json_decode($response, true);
                    if (isset($products['errors'])) {

                        $errorMessage = $products['errors'];
                        return redirect()->back()->with('error', $errorMessage);
                    } else {
                        $maincategory = MainCategory::where('theme_id',APP_THEME())->where('store_id', getCurrentStore())->first();

                        if (isset($products) && !empty($products)) {

                            if (!empty($products['products'][0]['image']['src'])) {
                                $ImageUrl = $products['products'][0]['image']['src'];
                                $url =  strtok($ImageUrl, '?');
                                $file_type = config('files_types');

                                foreach ($file_type as $f) {
                                    $name = basename($url, "." . $f);
                                }
                                $file2 = rand(10, 100) . '_' . time() . "_" . $name;
                                $path = 'themes/' . APP_THEME() . '/uploads/';
                                $uplaod = Utility::upload_woo_file($url, $file2, $path);
                            } else {

                                $url    = asset(Storage::url('uploads/woocommerce.png'));
                                $name   = 'woocommerce.png';
                                $file2  = rand(10, 100) . '_' . time() . "_" . $name;
                                $path   = 'themes/' . APP_THEME() . '/uploads/';
                                $uplaod = Utility::upload_woo_file($url, $file2, $path);
                            }
                            $upddata = shopifyconection::where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->where('module', '=', 'product')->where('shopify_id', $id)->first();
                            $original_id = $upddata->original_id;

                            $product                          = Product::find($original_id);
                            $product->name                    = $products['products'][0]['title'];
                            $product->description             = strip_tags($products['products'][0]['body_html']);
                            $product->cover_image_path        = $uplaod['url'];
                            $product->cover_image_url         = $uplaod['full_url'];
                            if ($products['products'][0]['variants'][0]['title'] == 'Default Title') {
                                $product->product_weight          = $products['products'][0]['variants'][0]['weight'];
                            }
                            $product->category_id             = $maincategory->id;

                            $product->discount_type = 'flat';
                            $discount_amount = $products['products'][0]['variants'][0]['compare_at_price'] - $products['products'][0]['variants'][0]['price'];
                            $product->discount_amount = $discount_amount;
                            if ($products['products'][0]['variants'][0]['title'] == 'Default Title') {
                                $product->variant_product = 0;
                            } else {
                                $product->variant_product = 1;
                                $product->variant_id =  json_encode([]);
                            }
                            $product->slug    = str_replace(' ', '_', strtolower($products['products'][0]['title']));
                            $product->status = 1;
                            if ($products['products'][0]['variants'][0]['title'] == 'Default Title') {
                                $product->track_stock = 1;
                                $product->stock_order_status = 'not_allow';
                                $product->price = $products['products'][0]['variants'][0]['price'];
                                $product->product_stock = $products['products'][0]['variants'][0]['inventory_quantity'];
                                $product->variant_id = NULL;
                                $product->variant_attribute = NULL;
                            }
                            $product->track_stock = 1;
                            $attribute_id = [];


                            $option_attribute_value = [];
                            foreach ($products['products'][0]['options'] as $option) {
                                $option_attribute_value[] = $option['values'];
                            }
                            $mergedArray = [];
                            foreach ($option_attribute_value as $array) {
                                $mergedArray = array_merge($mergedArray, $array);
                            }
                            $options_value_mergedArray = array_map(function ($element) {
                                return str_replace(' ', '', $element);
                            }, $mergedArray);




                            if ($products['products'][0]['variants'][0]['title'] != 'Default Title') {
                                foreach ($products['products'][0]['options'] as $option) {
                                    $product_Attrybute = ProductAttribute::where('name', $option['name'])->where('theme_id', $theme_name)->where('store_id', getCurrentStore())->first();
                                    $slug = Admin::slugs($option['name']);

                                    if (!empty($product_Attrybute->name) != $option['name']) {
                                        $attribute                      = new ProductAttribute();

                                        $attribute->name                = $option['name'];
                                        $attribute->slug                = $slug;
                                        $attribute->theme_id            = APP_THEME();
                                        $attribute->store_id            = getCurrentStore();
                                        $attribute->save();
                                    }

                                    foreach ($option['values'] as $ProductAttribute) {
                                        $title = str_replace(' ', '', $ProductAttribute);
                                        $product_AttributeOption = ProductAttributeOption::where('terms', $title)->where('theme_id', $theme_name)->where('store_id', getCurrentStore())->first();
                                        if (!empty($product_AttributeOption->terms) != $title) {
                                            $attribute_option                      = new ProductAttributeOption();
                                            $attribute_option->attribute_id        = !empty($attribute->id) ? $attribute->id : $product_Attrybute->id;
                                            $attribute_option->terms               = $title;
                                            $attribute_option->theme_id            = APP_THEME();
                                            $attribute_option->store_id            = getCurrentStore();
                                            $attribute_option->save();
                                        }
                                    }
                                    if (!empty($attribute)) {
                                        $attribute_id[] = $attribute->id;
                                    } else {
                                        $attribute_id[] = $product_Attrybute->id;
                                    }
                                }

                                $product->attribute_id = json_encode($attribute_id);
                                $attribute_options = [];
                                $options_value = array_map(function ($element) {
                                    return str_replace(' ', '', $element);
                                }, $option['values']);
                                $attribute_option_terms = ProductAttributeOption::whereIn('attribute_id', $attribute_id)->whereIn('terms', $options_value_mergedArray)->pluck('terms')->toArray();
                                foreach ($attribute_id as $key => $no) {


                                    $conditionMet = false;

                                    foreach ($options_value_mergedArray as $ProductAttribute) {
                                        if (in_array($ProductAttribute, $attribute_option_terms)) {
                                            $conditionMet = true;
                                            break;
                                        }
                                    }
                                    if ($conditionMet) {
                                        $attribute_option_id = ProductAttributeOption::where('attribute_id', $no)->whereIn('terms', $options_value_mergedArray)->pluck('id')->toArray();
                                    } else {
                                        $attribute_option_id = ProductAttributeOption::where('attribute_id', $no)->pluck('id')->toArray();
                                    }

                                    $enable_option = 1;
                                    $variation_option = 1;
                                    $item['attribute_id'] = $no;

                                    $item['values'] = explode(',', implode('|', $attribute_option_id));

                                    $item['visible_attribute_' . $no] = $enable_option;
                                    $item['for_variation_' . $no] = $variation_option;
                                    array_push($attribute_options, $item);
                                }
                                $attribute_options = json_encode($attribute_options);
                                $product->product_attribute = $attribute_options;
                            }


                            $product->save();

                            if ($products['products'][0]['variants'][0]['title'] != 'Default Title') {
                                foreach ($products['products'][0]['variants'] as $variants) {
                                    $product_stock = ProductStock::where('product_id', $product->id)->get();
                                    $title_spase = str_replace(' / ', '-', $variants['title']);
                                    $title = str_replace(' ', '', $title_spase);

                                    $sku = str_replace(' ', '_', $product->name . '-' . $title);
                                    foreach ($product_stock as $stock) {
                                        if ($stock['variant'] != $title) {
                                            $stock->delete();
                                        }
                                    }
                                }
                                foreach ($products['products'][0]['variants'] as $variants) {
                                    $title_spase = str_replace(' / ', '-', $variants['title']);
                                    $title = str_replace(' ', '', $title_spase);
                                    $sku = str_replace(' ', '_', $product->name . '-' . $title);
                                    $product_stock = ProductStock::where('product_id', $product->id)->get();


                                    $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $title)->first();

                                    if ($product_stock != null) {
                                        $product_stock->variant        = $title;
                                        $product_stock->sku            = $sku;
                                        $product_stock->stock          = $variants['inventory_quantity'];
                                        $product_stock->price          = $variants['price'];
                                        $product_stock->variation_price = $variants['price'];
                                    }
                                    if ($product_stock == null) {
                                        $product_stock = new ProductStock;
                                        $product_stock->product_id = $product->id;
                                        $product_stock->product_id     = $product->id;
                                        $product_stock->variant        = $title;
                                        $product_stock->sku            = $sku;
                                        $product_stock->stock          = $variants['inventory_quantity'];
                                        $product_stock->price          = $variants['price'];
                                        $product_stock->variation_price = $variants['price'];
                                        $product_stock->stock_order_status = 'not_allow';
                                        $product_stock->variation_option = 'manage_stock';
                                        $product_stock->variation_option = 'manage_stock';
                                        $product_stock->theme_id            = APP_THEME();
                                        $product_stock->store_id            = getCurrentStore();
                                        $product_stock->save();
                                    }
                                }
                            }
                            $ProductImage = ProductImage::where('product_id', $product->id)->where('theme_id', $theme_name)->where('store_id', getCurrentStore())->first();
                            if (empty($products['products'][0]['images'][0])) {
                                $url  = asset(Storage::url('uploads/woocommerce.png'));
                                $name = 'woocommerce.png';
                                $file2 = rand(10, 100) . '_' . time() . "_" . $name;
                                $path = 'themes/' . APP_THEME() . '/uploads/';
                                $ulpaod = Utility::upload_woo_file($url, $file2, $path);

                                $ProductImage->product_id = $product->id;

                                $ProductImage->image_path = $ulpaod['url'];
                                $ProductImage->image_url  = $ulpaod['full_url'];
                                $ProductImage->theme_id   = $store_id->theme_id;
                                $ProductImage->store_id   = getCurrentStore();
                                $ProductImage->save();
                            } else {
                                for ($i = 1; $i < count($products['products'][0]['images']); $i++) {
                                    $image = $products['products'][0]['images'][$i];
                                    $id = $image['id'];
                                    $dateCreated = $image['created_at'];
                                    $src = $image['src'];

                                    $ImageUrl = $src;
                                    $url =  strtok($ImageUrl, '?');

                                    $file_type = config('files_types');

                                    foreach ($file_type as $f) {
                                        $name = basename($url, "." . $f);
                                    }
                                    $file2 = rand(10, 100) . '_' . time() . "_" . $name;
                                    $path = 'themes/' . APP_THEME() . '/uploads/';
                                    $subimg = Utility::upload_woo_file($url, $file2, $path);

                                    $ProductImage->product_id = $product->id;

                                    $ProductImage->image_path = $subimg['url'];
                                    $ProductImage->image_url  = $subimg['full_url'];
                                    $ProductImage->theme_id   = $store_id->theme_id;
                                    $ProductImage->store_id   = getCurrentStore();
                                    $ProductImage->save();
                                }
                            }

                            return redirect()->back()->with('success', 'Product successfully update.');
                        }
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'This email already used.');
            }
        } else {
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
