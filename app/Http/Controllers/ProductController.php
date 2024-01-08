<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductStock;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use App\Models\Tax;
use App\Models\Theme;
use App\Models\User;
use App\Models\Utility;
use App\Models\Wishlist;
use App\Models\Admin;
use App\Models\Plan;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\Setting;
use App\Models\Shipping;
use App\Models\shopifyconection;
use App\Models\woocommerceconection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Cookie;

class ProductController extends Controller
{
    public function __construct()
    {
        if (request()->segment(1) != 'admin') {
            $slug = request()->segment(1);
            $this->store = Store::where('slug', $slug)->first();
            $this->APP_THEME = $this->store->theme_id;
        } else {

            $this->middleware('auth');
            $this->middleware(function ($request, $next) {
                $this->user = Auth::user();
                $this->store = Store::where('id', $this->user->current_store)->first();
                if ($this->store) {
                    $this->APP_THEME = $this->store->theme_id;
                } else {
                    return redirect()->back()->with('error', __('Permission Denied.'));
                }

                return $next($request);
            });
        }
    }

    public function index()
    {
        // $user = \Auth::guard('admin')->user();
        if (\Auth::user()->can('Manage Products')) {
            $store_id = Store::where('id', getCurrentStore())->first();

            $ThemeSubcategory = Utility::ThemeSubcategory();
            $products = Product::where('theme_id', $store_id->theme_id)->where('store_id', getCurrentStore())->orderBy('id', 'desc')->get();
            $settings = Setting::where('theme_id',$store_id->theme_id)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();
            return view('product.index', compact('products', 'ThemeSubcategory','settings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('Create Products')) {
            $user = \Auth::guard('admin')->user();
            $store_id = Store::where('id', $user->current_store)->first();
            $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();

            $ThemeSubcategory = Utility::addThemeSubcategory();

            $preview_type = [
                'Video File' => 'Video File',
                'Video Url' => 'Video Url',
                'iFrame' => 'iFrame'
            ];

            // ie: /var/www/laravel/app/storage/json/filename.json
            // product dateil json
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

            // product tag json
            $product_tag_path = base_path('themes/' . APP_THEME() . '/theme_json/' . 'product-tag.json');
            $product_tag_json_HTML = '';
            if (file_exists($product_tag_path)) {
                $product_tag_json = json_decode(file_get_contents($product_tag_path), true);
                $product_tag_json_HTML = view('product.tag_json', compact('product_tag_json'))->render();
            }

            $MainCategory = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
            $ProductVariants = ProductVariant::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id');
            $Shipping = Shipping::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Shipping', '');

            $ProductAttribute = ProductAttribute::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->pluck('name', 'id');

            return view('product.create', compact('MainCategory', 'ProductVariants', 'description_json_HTML', 'product_tag_json_HTML', 'ThemeSubcategory', 'option_json_HTML', 'preview_type', 'Shipping','ProductAttribute','settings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Products')) {
            $store_id = Store::where('id', getCurrentStore())->first();

            $ThemeSubcategory = Utility::addThemeSubcategory();

            $rules = [
                'name' => 'required',
                'category_id' => 'required',
                'cover_image' => 'required',
                'product_image' => 'required',
                // 'discount_type' => 'required',
                // 'discount_amount' => 'required',
                'status' => 'required',
                'variant_product' => 'required',
                // 'discount_amount' => 'required',
                // 'product_stock' => 'required',
                // 'price' => 'required',
            ];

            if ($ThemeSubcategory == 1) {
                $rules['subcategory_id'] = 'required';
            }
            $dir        = 'themes/' . APP_THEME() . '/uploads';
            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            // description array
            $array = !empty($request->array) ? $request->array : [];
            $array_api = [];
            foreach ($array as $array_key => $slug) {
                foreach ($slug['inner-list'] as $slug_key => $value) {

                    $array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                    $array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                    $array_api[$slug['section_slug']][$slug_key]['value'] = !empty($value['value']) ? $value['value'] : '';

                    if ($value['field_type'] == 'photo upload') {

                        $theme_name = $this->APP_THEME;
                        $theme_image = !empty($value['value']) ? $value['value'] : '';
                        $upload_image_path = !empty($value['value']) ? $value['value'] : '';
                        if (gettype($theme_image) == 'object') {

                            $image_size = File::size($theme_image);
                            $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                            if ($result == 1) {
                                $fileName = rand(10, 100) . '_' . time() . "_" . $theme_image->getClientOriginalName();
                                $upload = Utility::jsonUpload_file($theme_image, $fileName, $dir, []);
                                if ($upload['flag'] == true) {
                                    $upload_image_path = $upload['image_path'];
                                }
                            } else {
                                return redirect()->back()->with('error', $result);
                            }
                        }

                        $array[$array_key]['inner-list'][$slug_key]['image_path'] = $upload_image_path;
                        $array[$array_key]['inner-list'][$slug_key]['value'] = $upload_image_path;

                        $array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                        $array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                        $array_api[$slug['section_slug']][$slug_key]['value'] = $upload_image_path;
                    }
                }
            }

            // option array
            $option_array = !empty($request->arrays) ? $request->arrays : [];
            $option_array_api = [];
            foreach ($option_array as $array_key => $slug) {
                foreach ($slug['inner-list'] as $slug_key => $value) {
                    $option_array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                    $option_array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                    $option_array_api[$slug['section_slug']][$slug_key]['value'] = !empty($value['value']) ? $value['value'] : '';
                }
            }

            // Tag Array
            $tag_array = !empty($request->tag) ? $request->tag : [];
            $tag_array_api = '';
            if (!empty($request->tag)) {
                foreach ($request->tag as $array_key => $slug) {
                    $tag_array_api = $slug['value'];
                }
            }

            $user = \Auth::guard('admin')->user();
            $creator = Admin::find($user->creatorId());
            $total_products = $user->countProducts();
            $plan = Plan::find($creator->plan);

            if ($request->variant_product == 0) {
                if ($total_products < $plan->max_products || $plan->max_products == -1) {

                    $theme_name = APP_THEME();
                    if ($request->cover_image) {

                        $image_size = $request->file('cover_image')->getSize();
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                        if ($result == 1) {
                            $fileName = rand(10, 100) . '_' . time() . "_" . $request->cover_image->getClientOriginalName();
                            $path = Utility::upload_file($request, 'cover_image', $fileName, $dir, []);
                        } else {
                            return redirect()->back()->with('error', $result);
                        }
                    }

                    $input = $request->all();
                    $input['attribute_options'] = [];
                    if ($request->has('attribute_no')) {
                        foreach ($request->attribute_no as $key => $no) {
                            $str = 'attribute_options_' . $no;
                            $enable_option = $input['visible_attribute_' . $no];
                            $variation_option = $input['for_variation_' . $no];

                            $item['attribute_id'] = $no;
                            $item['values'] = explode(',', implode('|', $request[$str]));

                            $item['visible_attribute_' . $no] = $enable_option;
                            $item['for_variation_' . $no] = $variation_option;
                            array_push($input['attribute_options'], $item);
                        }
                    }

                    if (!empty($request->attribute_no)) {
                        $input['product_attributes'] = json_encode($request->attribute_no);
                    } else {
                        $input['product_attributes'] = json_encode([]);
                    }
                    $input['attribute_options'] = json_encode($input['attribute_options']);

                    $Product = new Product();
                    $Product->name = $request->name;
                    $Product->description = $request->description;
                    $Product->other_description = !empty($array) ? json_encode($array) : '';
                    $Product->other_description_api = !empty($array_api) ? json_encode($array_api) : '';

                    $Product->tag = !empty($tag_array) ? json_encode($tag_array) : '';
                    $Product->tag_api = $tag_array_api;

                    $Product->category_id = $request->category_id;
                    if ($ThemeSubcategory == 1) {
                        $Product->subcategory_id = $request->subcategory_id;
                    }
                    $Product->cover_image_path = $path['url'];
                    $Product->cover_image_url = $path['full_url'];

                    $Product->preview_type = $request->preview_type;
                    if (!empty($request->video_url)) {
                        $Product->preview_content = $request->video_url;
                    }
                    if (!empty($request->preview_video)) {
                        $ext = $request->file('preview_video')->getClientOriginalExtension();
                        $fileName = 'video_' . time() . rand() . '.' . $ext;

                        $dir_video = 'themes/' . APP_THEME() . '/uploads/preview_image';

                        $image_size = $request->file('preview_video')->getSize();
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                        if ($result == 1) {
                            $path_video = Utility::upload_file($request, 'preview_video', $fileName, $dir_video, []);
                            if ($path_video['flag'] == 1) {
                                $url = $path_video['url'];
                            } else {
                                return redirect()->back()->with('error', __($path_video['msg']));
                            }
                        } else {
                            return redirect()->back()->with('error', $result);
                        }
                        $Product->preview_content = $path_video['url'];
                    }
                    if (!empty($request->preview_iframe)) {
                        $Product->preview_content = $request->preview_iframe;
                    }

                    if (!empty($request->downloadable_product)) {

                        $image_size = $request->file('downloadable_product')->getSize();
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

                        if ($result == 1) {
                            $fileName = rand(10, 100) . '_' . time() . "_" . $request->downloadable_product->getClientOriginalName();
                            $path = Utility::upload_file($request, 'downloadable_product', $fileName, $dir, []);

                        } else {
                            return redirect()->back()->with('error', $result);
                        }
                        $Product->downloadable_product = $path['url'];

                    }

                    $Product->price = $request->price;
                    $Product->discount_type = !empty($request->discount_type) ? $request->discount_type : '';
                    $Product->discount_amount = !empty($request->discount_amount) ? $request->discount_amount : '0';
                    $Product->product_stock = !empty($request->product_stock) ? $request->product_stock : 0;
                    $Product->variant_product = $request->variant_product;
                    $Product->trending = $request->trending;
                    $Product->stock_status = $request->stock_status;
                    $Product->product_weight = $request->product_weight;

                    if ($request->track_stock == 1) {
                        $Product->track_stock = $request->track_stock;
                        $Product->stock_order_status = $request->stock_order_status;
                        $Product->low_stock_threshold = !empty($request->low_stock_threshold) ? $request->low_stock_threshold :  '';
                    } else {

                        $Product->track_stock = !empty($request->track_stock)? $request->track_stock : '';
                        $Product->stock_order_status = '';
                        $Product->low_stock_threshold = !empty($request->low_stock_threshold) ? $request->low_stock_threshold :  '';
                    }

                    $Product->slug = str_replace(' ', '_', strtolower($request->name));
                    $Product->theme_id = $store_id->theme_id;
                    $Product->status = $request->status;
                    $Product->attribute_id = $input['product_attributes'];
                    $Product->product_attribute = $input['attribute_options'];
                    $Product->product_option = !empty($option_array) ? json_encode($option_array) : '';
                    $Product->product_option_api = !empty($option_array_api) ? json_encode($option_array_api) : '';
                    $Product->shipping_id = $request->shipping_id;
                    $Product->store_id     = getCurrentStore();
                    $Product->created_by   = \Auth::guard('admin')->user()->id;
                    if ($request->custom_field_status == '1') {
                        $Product->custom_field_status = '1';
                        $Product->custom_field = json_encode($request->custom_field_repeater_basic);
                    }

                    $Product->save();

                    if (!empty($Product))
                    {
                        //webhook
                        $module = 'New Product';
                        $webhook =  Utility::webhook($module, $store_id->id);
                        if ($webhook) {
                            $parameter = json_encode($Product);
                            // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                            $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);

                            if ($status != true) {
                                $msgs  = 'Webhook call failed.';
                            }

                            $msg['flag'] = 'success';
                            $msg['msg']  = __('Product Successfully Created') . ((isset($msgs)) ? '<br> <span class="text-danger">' . $msgs . '</span>' : '');
                            // $msg['msg']  = __('Product Successfully Created');
                        }
                    }

                    foreach ($request->product_image as $key => $image) {

                        $theme_image = $image;
                        $theme_name = APP_THEME();

                        $image_size = File::size($theme_image);
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                        if ($result == 1) {
                            $fileName = rand(10, 100) . '_' . time() . "_" . $image->getClientOriginalName();
                            $pathss = Utility::keyWiseUpload_file($request, 'product_image', $fileName, $dir, $key, []);
                        } else {
                            return redirect()->back()->with('error', $result);
                        }

                        $ProductImage = new ProductImage();
                        $ProductImage->product_id = $Product->id;
                        if ($ThemeSubcategory == 1) {
                            $Product->subcategory_id = $Product->subcategory_id;
                        }
                        $ProductImage->image_path = $pathss['url'];
                        $ProductImage->image_url  = $pathss['full_url'];
                        $ProductImage->theme_id   = $store_id->theme_id;
                        $ProductImage->store_id   = getCurrentStore();
                        $ProductImage->save();

                    }
                } else {
                    return redirect()->back()->with('error', __('Your Product limit is over, Please upgrade plan'));
                }
            } else {

                $input = $request->all();

                $input['choice_options'] = [];
                $input['attribute_options'] = [];
                if ($request->has('choice_no')) {
                    foreach ($request->choice_no as $key => $no) {
                        $str = 'choice_options_' . $no;

                        $item['attribute_id'] = $no;
                        $item['values'] = explode(',', implode('|', $request[$str]));
                        array_push($input['choice_options'], $item);
                    }
                }

                if (!empty($request->choice_no)) {
                    $input['attributes'] = json_encode($request->choice_no);
                } else {
                    $input['attributes'] = json_encode([]);
                }

                $input['choice_options'] = json_encode($input['choice_options']);
                $input['slug'] = $input['name'];

                if ($request->has('attribute_no')) {
                    foreach ($request->attribute_no as $key => $no) {
                        $str = 'attribute_options_' . $no;
                        $enable_option = $input['visible_attribute_' . $no];
                        $variation_option = $input['for_variation_' . $no];

                        $item['attribute_id'] = $no;
                        $item['values'] = explode(',', implode('|', $request[$str]));
                        $item['visible_attribute_' . $no] = $enable_option;
                        $item['for_variation_' . $no] = $variation_option;
                        // dd($item);
                        array_push($input['attribute_options'], $item);
                    }
                }
                if (!empty($request->attribute_no)) {
                    $input['product_attributes'] = json_encode($request->attribute_no);
                } else {
                    $input['product_attributes'] = json_encode([]);
                }

                $input['attribute_options'] = json_encode($input['attribute_options']);

                $theme_name = APP_THEME();
                if ($request->cover_image) {

                    $image_size = $request->file('cover_image')->getSize();
                    $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                    if ($result == 1) {
                        $fileName = rand(10, 100) . '_' . time() . "_" . $request->cover_image->getClientOriginalName();
                        $path = Utility::upload_file($request, 'cover_image', $fileName, $dir, []);
                    } else {
                        return redirect()->back()->with('error', $result);
                    }
                }

                if ($total_products < $plan->max_products || $plan->max_products == -1) {


                    $product = new Product();
                    $product->name = $request->name;
                    $product->description = $request->description;

                    $product->other_description = json_encode($array);
                    $product->other_description_api = json_encode($array_api);

                    $product->tag = !empty($tag_array) ? json_encode($tag_array) : '';
                    $product->tag_api = $tag_array_api;

                    $product->category_id = $request->category_id;
                    if ($ThemeSubcategory == 1) {
                        $product->subcategory_id = $request->subcategory_id;
                    }
                    $product->cover_image_path = $path['url'];
                    $product->cover_image_url = $path['full_url'];

                    $product->preview_type = $request->preview_type;
                    if (!empty($request->video_url)) {
                        $product->preview_content = $request->video_url;
                    }
                    if (!empty($request->preview_video)) {
                        $ext = $request->file('preview_video')->getClientOriginalExtension();
                        $fileName = 'video_' . time() . rand() . '.' . $ext;

                        $dir_video = 'themes/' . APP_THEME() . '/uploads/preview_image';

                        $image_size = $request->file('preview_video')->getSize();
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

                        if ($result == 1) {
                            $path_video = Utility::upload_file($request, 'preview_video', $fileName, $dir_video, []);
                            if ($path_video['flag'] == 1) {
                                $url = $path_video['url'];
                            } else {
                                return redirect()->back()->with('error', __($path_video['msg']));
                            }
                        } else {
                            return redirect()->back()->with('error', $result);
                        }
                        $product->preview_content = $path_video['url'];
                    }
                    if (!empty($request->preview_iframe)) {
                        $product->preview_content = $request->preview_iframe;
                    }
                    if (!empty($request->downloadable_product)) {

                        $image_size = $request->file('downloadable_product')->getSize();
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

                        if ($result == 1) {
                            $fileName = rand(10, 100) . '_' . time() . "_" . $request->downloadable_product->getClientOriginalName();
                            $path = Utility::upload_file($request, 'downloadable_product', $fileName, $dir, []);

                        } else {
                            return redirect()->back()->with('error', $result);
                        }
                        $product->downloadable_product = $path['url'];
                    }

                    $product->price = 0;
                    $product->discount_type = !empty($request->discount_type) ? $request->discount_type : '';
                    $product->discount_amount = !empty($request->discount_amount) ? $request->discount_amount : '0';
                    $product->product_stock = !empty($request->product_stock) ? $request->product_stock : 0;
                    $product->variant_product = $request->variant_product;
                    $product->trending = $request->trending;
                    if ($request->track_stock == 1) {
                        $product->track_stock = $request->track_stock;
                        $product->stock_order_status = $request->stock_order_status;
                        $product->low_stock_threshold = !empty($request->low_stock_threshold) ? $request->low_stock_threshold : 0;
                    } else {
                        $product->track_stock = $request->track_stock;
                        $product->stock_order_status = '';
                        $product->low_stock_threshold = !empty($request->low_stock_threshold) ? $request->low_stock_threshold : 0;
                    }

                    $product->variant_id = $input['attributes'];
                    $product->variant_attribute = $input['choice_options'];
                    $product->attribute_id = $input['product_attributes'];
                    $product->product_attribute = $input['attribute_options'];

                    $product->slug = str_replace(' ', '_', strtolower($request->name));
                    $product->product_option = json_encode($option_array);
                    $product->product_option_api = json_encode($option_array_api);
                    $product->shipping_id = $request->shipping_id;
                    $product->theme_id = $store_id->theme_id;
                    $product->status = $request->status;
                    $product->store_id = getCurrentStore();
                    $product->created_by = \Auth::guard('admin')->user()->id;
                    if ($request->custom_field_status == '1') {
                        $product->custom_field_status = '1';
                        $product->custom_field = json_encode($request->custom_field_repeater_basic);
                    }
                    $product->save();

                    if (!empty($product))
                    {
                        //webhook
                        $module = 'New Product';
                        $webhook =  Utility::webhook($module, $store_id->id);
                        if ($webhook) {
                        $parameter = json_encode($product);
                        // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                        $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);

                        if ($status != true) {
                            $msgs  = 'Webhook call failed.';
                        }

                        $msg['flag'] = 'success';
                                // $msg['msg']  = __('Product Successfully Created') . ((isset($msgs)) ? '<br> <span class="text-danger">' . $msgs . '</span>' : '');
                                $msg['msg']  = __('Product Successfully Created');
                        }
                    } else {
                        $msg['flag'] = 'error';
                        $msg['msg']  = __('Product Created Failed');

                        return redirect()->back()->with($msg['flag'], $msg['msg']);
                    }

                    foreach ($request->product_image as $key => $image) {
                        $theme_image = $image;

                        $image_size = File::size($theme_image);
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                        if ($result == 1) {
                            $fileName = rand(10, 100) . '_' . time() . "_" . $image->getClientOriginalName();
                            $pathss = Utility::keyWiseUpload_file($request, 'product_image', $fileName, $dir, $key, []);
                        } else {
                            return redirect()->back()->with('error', $result);
                        }

                        $ProductImage = new ProductImage();
                        $ProductImage->product_id = $product->id;
                        $ProductImage->image_path = $pathss['url'];
                        $ProductImage->image_url  = $pathss['full_url'];
                        $ProductImage->theme_id   = $store_id->theme_id;
                        $ProductImage->store_id   = getCurrentStore();
                        $ProductImage->save();
                    }

                    $options = [];
                    $a_option = [];
                    if ($request->has('choice_no')) {
                        foreach ($request->choice_no as $key => $no) {
                            $name = 'choice_options_' . $no;
                            $my_str = implode('|', $request[$name]);
                            array_push($options, explode(',', $my_str));
                        }
                    }

                    $combinations = $this->combinations($options);
                    foreach ($request->attribute_no as $key => $no) {
                        $forVariationName = 'for_variation_' . $no;
                        if ($request->has($forVariationName) && $request->input($forVariationName) == 1) {
                            $name = 'attribute_options_' . $no;
                            $options = 'options';
                            $for_variation = isset($request->{'for_variation_' . $no}) ? $request->{'for_variation_' . $no} : 0;
                            if ($for_variation == 1) {
                                if ($request->has($options) && is_array($request[$options])) {
                                    $my_str = $request[$options];
                                    $optionValues = [];

                                    foreach ($request[$options] as $term) {
                                        $optionValues[] = $term;
                                    }
                                    array_push($a_option, $my_str);
                                }
                            }
                        }
                    }

                    $default_variant_id = 0;
                    // if (count($combinations[0]) > 0) {
                    //     $product->variant_product = 1;
                    //     $is_in_stock = false;
                    //     foreach ($combinations as $key => $combination) {
                    //         $str = '';
                    //         foreach ($combination as $key => $item) {
                    //             if ($key > 0) {
                    //                 $str .= '-' . str_replace(' ', '', $item);
                    //             } else {
                    //                 $str .= str_replace(' ', '', $item);
                    //             }
                    //         }

                    //         $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                    //         if ($product_stock == null) {
                    //             $product_stock = new ProductStock;
                    //             $product_stock->product_id = $product->id;
                    //         }
                    //         $sku = str_replace(' ', '_', $request->name) . $request['sku_' . str_replace('.', '_', $str)];

                    //         $product_stock->variant = $str;
                    //         $product_stock->price = $request['price_' . str_replace('.', '_', $str)];
                    //         $product_stock->sku = $sku;
                    //         $product_stock->stock = $request['stock_' . str_replace('.', '_', $str)];
                    //         $product_stock->theme_id = APP_THEME();
                    //         $product_stock->store_id = getCurrentStore();
                    //         $product_stock->save();

                    //         if ($request->default_variant ==  '-' . $str) {
                    //             $product_update = Product::find($product->id);
                    //             $product_update->default_variant_id = $product_stock->id;
                    //             $product_update->save();
                    //         }

                    //         if ($product_stock->stock == 'in_stock') {
                    //             $is_in_stock = true;
                    //         }
                    //     }
                    //     if (!$is_in_stock) {
                    //         $product->stock = 'out_of_stock';
                    //     }
                    // } else {
                    //     $product->variant_product = 0;
                    // }

                    if (count($a_option[0]) > 0) {
                        $product->variant_product = 1;
                        $is_in_stock = false;
                        foreach ($a_option as $key => $com) {
                            $str = '';
                            foreach ($com as $key => $item) {

                                $str = $item;

                                $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                                if ($product_stock == null) {
                                    $product_stock = new ProductStock;
                                    $product_stock->product_id = $product->id;
                                }

                                $theme_name = APP_THEME();
                                if ($request['downloadable_product_' . str_replace('.', '_', $str)]) {
                                    $fileName = rand(10, 100) . '_' . time() . "_" . $request->file('downloadable_product_' . $str)->getClientOriginalName();

                                    $path1 = Utility::upload_file($request, 'downloadable_product_' . $str, $fileName, $dir, []);
                                    $product_stock->downloadable_product = $path1['url'];
                                }


                                $var_option = "";
                                $variation_option = !empty($request['variation_option_' . str_replace('.', '_', $str)]) ? $request['variation_option_' . str_replace('.', '_', $str)] : '';

                                if (is_array($variation_option)) {
                                    foreach ($variation_option as $option) {
                                        $var_option .= $option . ",";
                                    }
                                }

                                $sku = str_replace(' ', '_', $request->name) . $request['product_sku_' . str_replace('.', '_', $str)];


                                $product_stock->variant = $str;

                                $product_stock->variation_option = $var_option;

                                $product_stock->price = !empty($request['product_sale_price_' . str_replace('.', '_', $str)]) ? $request['product_sale_price_' . str_replace('.', '_', $str)] : 0;

                                $product_stock->variation_price = !empty($request['product_variation_price_' . str_replace('.', '_', $str)]) ? $request['product_variation_price_' . str_replace('.', '_', $str)] : 0;
                                $product_stock->sku = $sku;


                                $product_stock->stock_status = !empty($request['stock_status_' . str_replace('.', '_', $str)]) ? $request['stock_status_' . str_replace('.', '_', $str)] : '';

                                // dd($variation_option);
                                if ($variation_option) {
                                    if (in_array('manage_stock', $variation_option)) {
                                        $product_stock->stock_order_status = !empty($request['stock_order_status_' . str_replace('.', '_', $str)]) ? $request['stock_order_status_' . str_replace('.', '_', $str)] : 0;

                                        $product_stock->stock = !empty($request['product_stock_' . str_replace('.', '_', $str)]) ? $request['product_stock_' . str_replace('.', '_', $str)] : 0;

                                        $product_stock->low_stock_threshold = !empty($request['low_stock_threshold_' . str_replace('.', '_', $str)]) ? $request['low_stock_threshold_' . str_replace('.', '_', $str)] : 0;
                                    } else {

                                        $product_stock->stock = 0;
                                        $product_stock->stock_order_status = '';
                                        $product_stock->low_stock_threshold = !empty($request['low_stock_threshold_' . str_replace('.', '_', $str)]) ? $request['low_stock_threshold_' . str_replace('.', '_', $str)] : 0;
                                    }
                                }

                                $product_stock->weight = !empty($request['product_weight_' . str_replace('.', '_', $str)]) ? $request['product_weight_' . str_replace('.', '_', $str)] : 0;

                                $product_stock->description = !empty($request['product_description_' . str_replace('.', '_', $str)]) ? $request['product_description_' . str_replace('.', '_', $str)] : '';

                                $product_stock->shipping = !empty($request['shipping_id_' . str_replace('.', '_', $str)]) ? $request['shipping_id_' . str_replace('.', '_', $str)] : 'same_as_parent';

                                $product_stock->theme_id = APP_THEME();
                                $product_stock->store_id = getCurrentStore();
                                $product_stock->save();

                                if ($request->default_variant ==  '-' . $str) {
                                    $product_update = Product::find($product->id);
                                    $product_update->default_variant_id = $product_stock->id;
                                    $product_update->save();
                                }

                                if ($product_stock->stock == 'in_stock') {
                                    $is_in_stock = true;
                                }
                            }
                        }
                        if (!$is_in_stock) {
                            $product->stock = 'out_of_stock';
                        }
                    } else {
                        $product->variant_product = 0;
                    }
                } else {
                    return redirect()->back()->with('error', __('Your Product limit is over, Please upgrade plan'));
                }
            }

            return redirect()->back()->with('success', __('Product saved successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Product $product)
    {
    }

    public function edit(Product $product)
    {
        if (\Auth::user()->can('Edit Products')) {

            $ThemeSubcategory = Utility::addThemeSubcategory();
            $MainCategory = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
            $ProductVariants = ProductVariant::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id');
            $product->variants_id = json_decode($product->variant_id);


            $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();
            $ProductAttribute = ProductAttribute::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id');
            $product->attribute_id = json_decode($product->attribute_id);

            $preview_type = [
                'Video File' => 'Video File',
                'Video Url' => 'Video Url',
                'iFrame' => 'iFrame'
            ];

            // ie: /var/www/laravel/app/storage/json/filename.json
            // product dateil json
            $path = base_path('themes/' . $this->APP_THEME . '/theme_json/' . 'product-detail.json');
            $json = json_decode(file_get_contents($path), true);
            if (!empty($product->other_description)) {
                $json = json_decode($product->other_description, true);
            }
            $description_json_HTML = view('product.description_json', compact('json'))->render();

            // product option json
            $path = base_path('themes/' . $this->APP_THEME . '/theme_json/' . 'product-option.json');
            $option_json = json_decode(file_get_contents($path), true);
            if (!empty($product->product_option)) {
                $option_json = json_decode($product->product_option, true);
            }
            $option_json_HTML = view('product.option_json', compact('option_json'))->render();

            // product tag json
            $product_tag_path = base_path('themes/' . $this->APP_THEME . '/theme_json/' . 'product-tag.json');
            $product_tag_json = json_decode(file_get_contents($product_tag_path), true);
            $product_tag_json_HTML = '';
            if (!empty($product->tag)) {
                $product_tag_json = json_decode($product->tag, true);
                $product_tag_json_HTML = view('product.tag_json', compact('product_tag_json'))->render();
            } else {
                if (file_exists($product_tag_path)) {
                    $product_tag_json = json_decode(file_get_contents($product_tag_path), true);
                    $product_tag_json_HTML = view('product.tag_json', compact('product_tag_json'))->render();
                }
            }
            $attributeIds = $ProductAttribute->keys();
            $Shipping = Shipping::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Select Shipping', '');

            $compact = ['MainCategory', 'ProductVariants', 'product', 'description_json_HTML', 'product_tag_json_HTML', 'ThemeSubcategory', 'option_json_HTML', 'preview_type', 'Shipping', 'attributeIds', 'ProductAttribute', 'settings'];
            return view('product.edit', compact($compact));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Product $product)
    {
        if (\Auth::user()->can('Edit Products')) {
            $ThemeSubcategory = Utility::ThemeSubcategory();

            $dir        = 'themes/' . APP_THEME() . '/uploads';

            $rules = [
                'name' => 'required',
                'category_id' => 'required',
                // 'discount_type' => 'required',
                // 'discount_amount' => 'required',
                'status' => 'required',
                'variant_product' => 'required'
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            // description array
            $old_data = '';
            if (!empty($product->other_description_api)) {
                $old_data = json_decode($product->other_description_api, true);
            }

            $array = $request->array;
            $array_api = [];
            foreach ($array as $array_key => $slug) {
                foreach ($slug['inner-list'] as $slug_key => $value) {

                    $array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                    $array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                    $array_api[$slug['section_slug']][$slug_key]['value'] = !empty($value['value']) ? $value['value'] : '';

                    if ($value['field_type'] == 'photo upload') {

                        $theme_name = $this->APP_THEME;
                        $theme_image = !empty($value['value']) ? $value['value'] : '';
                        $upload_image_path = !empty($value['value']) ? $value['value'] : '';

                        if (gettype($theme_image) == 'object') {
                            $image_path = (!empty($old_data[$slug['section_slug']][$slug_key]['value'])) ? $old_data[$slug['section_slug']][$slug_key]['value'] : '';
                            $file_path = $image_path;
                            $image_size = File::size($theme_image);
                            $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                            if ($result == 1) {
                                Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);

                                if (File::exists(base_path($image_path))) {
                                    File::delete(base_path($image_path));
                                }
                            } else {
                                return redirect()->back()->with('error', $result);
                            }

                            // $upload = upload_theme_image($theme_name, $theme_image, $slug_key);

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
                        $array_api[$slug['section_slug']][$slug_key]['value'] = $upload_image_path;
                    }
                }
            }

            // option array
            if (!empty($request->arrays)) {
                $old_data = '';
                if (!empty($product->product_option_api)) {
                    $old_data = json_decode($product->product_option_api, true);
                }

                $option_array = $request->arrays;
                $option_array_api = [];
                foreach ($option_array as $array_key => $slug) {
                    foreach ($slug['inner-list'] as $slug_key => $value) {

                        $option_array_api[$slug['section_slug']][$slug_key]['field_type'] = $value['field_type'];
                        $option_array_api[$slug['section_slug']][$slug_key]['name'] = $value['field_name'];
                        $option_array_api[$slug['section_slug']][$slug_key]['value'] = !empty($value['value']) ? $value['value'] : '';
                    }
                }
            }

            // Tag Array
            $tag_array = !empty($request->tag) ? $request->tag : [];
            $tag_array_api = '';
            if (!empty($request->tag)) {
                foreach ($request->tag as $array_key => $slug) {
                    $tag_array_api = $slug['value'];
                }
            }


            $product->name = $request->name;
            $product->description = $request->description;

            $product->other_description = json_encode($array);
            $product->other_description_api = json_encode($array_api);
            $product->tag = !empty($tag_array) ? json_encode($tag_array) : '';
            $product->tag_api = $tag_array_api;
            $product->stock_status = $request->stock_status;
            $product->product_weight = $request->product_weight;

            $product->category_id = $request->category_id;
            if ($ThemeSubcategory == 1) {
                $product->subcategory_id = $request->subcategory_id;
            }

            $product->preview_type = $request->preview_type;
            if (!empty($request->video_url)) {
                $product->preview_content = $request->video_url;
                // $product->save();
            }
            if (!empty($request->preview_video)) {
                $ext = $request->file('preview_video')->getClientOriginalExtension();
                $fileName = 'video_' . time() . rand() . '.' . $ext;

                $dir_video = 'themes/' . APP_THEME() . '/uploads/preview_image';

                $file_paths = $product->preview_video;
                $image_size = $request->file('preview_video')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if ($result == 1) {
                    Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_paths);
                    $path_video = Utility::upload_file($request, 'preview_video', $fileName, $dir_video, []);
                    if ($path_video['flag'] == 1) {
                        $url = $path_video['url'];
                    } else {
                        return redirect()->back()->with('error', __($path_video['msg']));
                    }
                } else {
                    return redirect()->back()->with('error', $result);
                }



                $product->preview_content = $path_video['url'];
                // $product->save();
            }
            if (!empty($request->preview_iframe)) {
                $product->preview_content = $request->preview_iframe;
                // $product->save();
            }



            $product->discount_type = !empty($request->discount_type) ? $request->discount_type : '';
            $product->discount_amount = !empty($request->discount_amount) ? $request->discount_amount : '0';
            $product->variant_product = $request->variant_product;
            $product->slug = $request->name;
            if (!empty($request->arrays)) {

                $product->product_option = json_encode($option_array);
                $product->product_option_api = json_encode($option_array_api);
            }
            $product->shipping_id = $request->shipping_id;
            $product->status = $request->status;
            $product->trending = $request->trending;
            if ($request->track_stock == 1) {

                $product->track_stock = $request->track_stock;
                $product->stock_order_status = $request->stock_order_status;
                $product->low_stock_threshold = !empty($request->low_stock_threshold) ? $request->low_stock_threshold :  '';
            } else {
                $product->track_stock = $request->track_stock;
                $product->stock_order_status = '';
                $product->low_stock_threshold = !empty($request->low_stock_threshold) ? $request->low_stock_threshold :  '';
            }

            if ($request->custom_field_status == '1') {
                $product->custom_field_status = '1';
                $product->custom_field = json_encode($request->custom_field_repeater_basic);
            } else {
                $product->custom_field = NULL;
            }

            if (!empty($request->downloadable_product))
            {
                $image_size = $request->file('downloadable_product')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                $file_paths = $product->downloadable_product;

                if ($result == 1) {
                    Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_paths);

                    $fileName = rand(10, 100) . '_' . time() . "_" . $request->downloadable_product->getClientOriginalName();
                    $path = Utility::upload_file($request, 'downloadable_product', $fileName, $dir, []);

                } else {
                    return redirect()->back()->with('error', $result);
                }
                $product->downloadable_product = $path['url'];
            }

            if ($request->variant_product == 0) {
                $product->price = $request->price;

                if ($request->track_stock == 0) {
                    $product->product_stock = 0;
                } else {
                    $product->product_stock = $request->product_stock;
                }
                $product->variant_id = NULL;
                $product->variant_attribute = NULL;

                $input = $request->all();

                $input['attribute_options'] = [];
                if ($request->has('attribute_no')) {
                    foreach ($request->attribute_no as $key => $no) {
                        $str = 'attribute_options_' . $no;
                        $enable_option = $input['visible_attribute_' . $no];
                        $variation_option = $input['for_variation_' . $no];

                        $item['attribute_id'] = $no;

                        $optionValues = [];
                        if (isset($request[$str])) {
                        foreach ($request[$str] as $fValue) {

                            $id = ProductAttributeOption::where('terms', $fValue)->first()->toArray();
                            $optionValues[] = $id['id'];
                        }
                    }    
                        $item['values'] = explode(',', implode('|', $optionValues));
                        $item['visible_attribute_' . $no] = $enable_option;
                        $item['for_variation_' . $no] = $variation_option;
                        array_push($input['attribute_options'], $item);
                    }
                }

                if (!empty($request->attribute_no)) {
                    $input['product_attributes'] = json_encode($request->attribute_no);
                } else {
                    $input['product_attributes'] = json_encode([]);
                }
                $input['attribute_options'] = json_encode($input['attribute_options']);
                $product->attribute_id = $input['product_attributes'];
                $product->product_attribute = $input['attribute_options'];

                Cart::where('product_id', $product->id)->where('theme_id', $product->theme_id)->where('store_id', $product->store_id)->delete();
                $product->save();

                // ProductStock::where('product_id', $product->id)->where('theme_id', APP_THEME())->delete();
            } else {
                $input = $request->all();
                $input['choice_options'] = [];
                $input['attribute_options'] = [];
                if ($request->has('choice_no')) {
                    foreach ($request->choice_no as $key => $no) {
                        $str = 'choice_options_' . $no;

                        $item['attribute_id'] = $no;
                        $item['values'] = explode(',', implode('|', $request[$str]));
                        array_push($input['choice_options'], $item);
                    }
                }

                if (!empty($request->choice_no)) {
                    $input['attributes'] = json_encode($request->choice_no);
                } else {
                    $input['attributes'] = json_encode([]);
                }

                $input['choice_options'] = json_encode($input['choice_options']);
                $input['slug'] = $input['name'];

                if ($request->has('attribute_no')) {
                    foreach ($request->attribute_no as $key => $no) {
                        $str = 'attribute_options_' . $no;
                        $enable_option = $input['visible_attribute_' . $no];
                        $variation_option = $input['for_variation_' . $no];

                        $item['attribute_id'] = $no;
                        $optionValues = [];
                        if (isset($request[$str])) {
                        foreach ($request[$str] as $fValue) {

                            $id = ProductAttributeOption::where('terms', $fValue)->first()->toArray();
                            $optionValues[] = $id['id'];
                        }
                    }
                        $item['values'] = explode(',', implode('|', $optionValues));
                        $item['visible_attribute_' . $no] = $enable_option;
                        $item['for_variation_' . $no] = $variation_option;
                        array_push($input['attribute_options'], $item);
                    }
                }

                if (!empty($request->attribute_no)) {
                    $input['product_attributes'] = json_encode($request->attribute_no);
                } else {
                    $input['product_attributes'] = json_encode([]);
                }
                $input['attribute_options'] = json_encode($input['attribute_options']);

                $product->price = 0;
                $product->product_stock = 0;
                $product->variant_id = $input['attributes'];
                $product->variant_attribute = $input['choice_options'];
                $product->attribute_id = $input['product_attributes'];

                $product->product_attribute = $input['attribute_options'];

                $product->preview_type = $request->preview_type;
                if (!empty($request->video_url)) {
                    $product->preview_content = $request->video_url;
                    // $product->save();
                }
                if (!empty($request->preview_video)) {
                    $ext = $request->file('preview_video')->getClientOriginalExtension();
                    $fileName = 'video_' . time() . rand() . '.' . $ext;

                    $dir_video = 'themes/' . APP_THEME() . '/uploads/preview_image';
                    $file_paths = $product->preview_video;
                    $image_size = $request->file('preview_video')->getSize();
                    $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                    if ($result == 1) {
                        $path_video = Utility::upload_file($request, 'preview_video', $fileName, $dir_video, []);
                        if ($path_video['flag'] == 1) {
                            $url = $path_video['url'];
                        } else {
                            return redirect()->back()->with('error', __($path_video['msg']));
                        }
                    } else {
                        return redirect()->back()->with('error', $result);
                    }
                    $product->preview_content = $path_video['url'];
                    // $product->save();
                }
                if (!empty($request->preview_iframe)) {
                    $product->preview_content = $request->preview_iframe;
                    // $product->save();
                }
                $product->shipping_id = $request->shipping_id;
                if ($request->custom_field_status == '1') {
                    $product->custom_field = json_encode($request->custom_field_repeater_basic);
                } else {
                    $product->custom_field = NULL;
                }
                $product->save();

                $options = [];
                if ($request->has('choice_no')) {
                    foreach ($request->choice_no as $key => $no) {
                        $name = 'choice_options_' . $no;
                        $my_str = implode('|', $request[$name]);
                        array_push($options, explode(',', $my_str));
                    }
                }

                $sku_array = [];
                $total_stock = 0;
                $combinations = $this->combinations($options);
                if (count($combinations[0]) > 0) {
                    $product->variant_product = 1;
                    foreach ($combinations as $key => $combination) {
                        $str = '';
                        foreach ($combination as $key => $item) {
                            if ($key > 0) {
                                $str .= '-' . str_replace(' ', '', $item);
                            } else {
                                $str .= str_replace(' ', '', $item);
                            }
                        }

                        $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                        if ($product_stock == null) {
                            $product_stock = new ProductStock;
                            $product_stock->product_id = $product->id;
                        }
                        array_push($sku_array, $str);

                        $sku = str_replace(' ', '_', $request->name) . $request['sku_' . str_replace('.', '_', $str)];
                        $total_stock += $request['stock_' . str_replace('.', '_', $str)];
                        $product_stock->variant = $str;
                        $product_stock->price = $request['price_' . str_replace('.', '_', $str)];
                        $product_stock->sku = $sku;
                        $product_stock->stock = $request['stock_' . str_replace('.', '_', $str)];
                        $product_stock->theme_id = APP_THEME();


                        $product_stock->save();


                        if ($request->default_variant == '-' . $str) {
                            $product_update = Product::find($product->id);
                            $product_update->default_variant_id = $product_stock->id;
                            $product_update->save();
                        }
                    }
                    ProductStock::where('product_id', $product->id)->where('theme_id', APP_THEME())->whereNotIn('variant', $sku_array)->delete();

                    $product->product_stock = $total_stock;
                    $product->save();
                } else {
                    $product->variant_product = 0;
                }

                $attribute_option = [];
                // if ($request->has('attribute_no')) {
                //     foreach ($request->attribute_no as $key => $no) {
                //         $name = 'attribute_options_' . $no;
                //         $my_str =  $request[$name];
                //         array_push($option,$my_str);
                //     }
                // }
                if ($request->attribute_no) {
                    foreach ($request->attribute_no as $key => $no) {
                        $forVariationName = 'for_variation_' . $no;
                        if ($request->has($forVariationName) && $request->input($forVariationName) == 1) {
                            $name = 'attribute_options_' . $no;
                            $options_data = 'options_datas';
                            $for_variation = isset($request->{'for_variation_' . $no}) ? $request->{'for_variation_' . $no} : 0;
                            if ($for_variation == 1) {
                                if ($request->has($options_data) && is_array($request[$options_data])) {
                                    $my_str = $request[$options_data];
                                    $optionValues = [];

                                    foreach ($request[$options_data] as $term) {

                                        $optionValues[] = $term;
                                    }

                                    array_push($attribute_option, $my_str);
                                }
                            }
                        }
                    }
                }
                // $a_combinations = $this->combination($a_option);
                if ($attribute_option) {
                    if (count($attribute_option[0]) > 0) {
                        $product->variant_product = 1;
                        $is_in_stock = false;
                        foreach ($attribute_option as $key => $com) {
                            $str = '';
                            foreach ($com as $key => $item) {
                                $str = $item;

                                $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
                                if ($product_stock == null) {
                                    $product_stock = new ProductStock;
                                    $product_stock->product_id = $product->id;
                                }

                                $theme_name = APP_THEME();
                                if ($request['downloadable_product_' . str_replace('.', '_', $str)]) {
                                    $fileName = rand(10, 100) . '_' . time() . "_" . $request->file('downloadable_product_' . $str)->getClientOriginalName();

                                    $path1 = Utility::upload_file($request, 'downloadable_product_' . $str, $fileName, $dir, []);
                                    $product_stock->downloadable_product = $path1['url'];
                                }


                                $var_option = "";
                                $variation_option = !empty($request['variation_option_' . str_replace('.', '_', $str)]) ? $request['variation_option_' . str_replace('.', '_', $str)] : '';

                                if (is_array($variation_option)) {
                                    foreach ($variation_option as $option) {
                                        $var_option .= $option . ",";
                                    }
                                }

                                $sku = str_replace(' ', '_', $request->name) . $request['product_sku_' . str_replace('.', '_', $str)];
                                $product_stock->variant = $str;

                                if ($product->track_stock == 1) {
                                    $product_stock->stock_status = '';
                                } else {

                                    $product_stock->stock_status = !empty($request['stock_status_' . str_replace('.', '_', $str)]) ? $request['stock_status_' . str_replace('.', '_', $str)] : '';
                                }

                                $product_stock->variation_option = $var_option;

                                $product_stock->price = !empty($request['product_sale_price_' . str_replace('.', '_', $str)]) ? $request['product_sale_price_' . str_replace('.', '_', $str)] : 0;

                                $product_stock->variation_price = !empty($request['product_variation_price_' . str_replace('.', '_', $str)]) ? $request['product_variation_price_' . str_replace('.', '_', $str)] : 0;
                                $product_stock->sku = $sku;

                                $product_stock->stock = !empty($request['product_stock_' . str_replace('.', '_', $str)]) ? $request['product_stock_' . str_replace('.', '_', $str)] : 0;

                                $product_stock->low_stock_threshold = !empty($request['low_stock_threshold_' . str_replace('.', '_', $str)]) ? $request['low_stock_threshold_' . str_replace('.', '_', $str)] : 0;

                                $product_stock->weight = !empty($request['product_weight_' . str_replace('.', '_', $str)]) ? $request['product_weight_' . str_replace('.', '_', $str)] : 0;

                                $product_stock->stock_order_status = !empty($request['stock_order_status_' . str_replace('.', '_', $str)]) ? $request['stock_order_status_' . str_replace('.', '_', $str)] : 0;

                                $product_stock->description = !empty($request['product_description_' . str_replace('.', '_', $str)]) ? $request['product_description_' . str_replace('.', '_', $str)] : '';

                                $product_stock->shipping = !empty($request['shipping_id_' . str_replace('.', '_', $str)]) ? $request['shipping_id_' . str_replace('.', '_', $str)] : 'same_as_parent';

                                $product_stock->theme_id = APP_THEME();
                                $product_stock->store_id = getCurrentStore();
                                $product_stock->save();

                                if ($request->default_variant ==  '-' . $str) {
                                    $product_update = Product::find($product->id);
                                    $product_update->default_variant_id = $product_stock->id;
                                    $product_update->save();
                                }

                                if ($product_stock->stock == 'in_stock') {
                                    $is_in_stock = true;
                                }
                            }
                            ProductStock::where('product_id', $product->id)
                                ->whereNotIn('variant', $com)
                                ->delete();
                        }
                        if (!$is_in_stock) {
                            $product->stock = 'out_of_stock';
                        }
                    } else {
                        $product->variant_product = 0;
                    }
                }
            }

            $Carts = Cookie::get('cart');
            $Carts = json_decode($Carts, true);

            // Iterate through the cart items and remove items with matching product ID
            if (is_array($Carts)) {
                foreach ($Carts as $cartId => $cartItem) {
                    if ($cartItem['product_id'] == $product->id) {
                        unset($Carts[$cartId]);
                    }
                }
            }
            $cart_json = json_encode($Carts);
            Cookie::queue('cart', $cart_json, 60);


            Cart::where('product_id', $product->id)->where('theme_id', $product->theme_id)->where('store_id', $product->store_id)->delete();

            $firebase_enabled = Utility::GetValueByName('firebase_enabled');
            if (!empty($firebase_enabled) && $firebase_enabled == 'on') {
                $fcm_Key = Utility::GetValueByName('fcm_Key');
                if (!empty($fcm_Key)) {
                    $NotifyUsers = DB::table('NotifyUser')->where('product_id', $request->id)->get();
                    if (!empty($NotifyUsers)) {
                        foreach ($NotifyUsers as $key => $value) {
                            $User_data = User::find($value->user_id);
                            if (!empty($User_data->firebase_token)) {
                                $device_id = $User_data->firebase_token;
                                $message = 'now ' . $request->name . ' is available in stock';
                                Utility::sendFCM($device_id, $fcm_Key, $message);
                                DB::table('NotifyUser')->where('product_id', $request->id)->where('user_id', $User_data->id)->delete();
                            }
                        }
                    }
                }
            }


            return redirect()->back()->with('success', __('Product update successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Product $product)
    {
        if (\Auth::user()->can('Delete Products')) {
            $ProductImages = ProductImage::where('product_id', $product->id)->get();

            $Product = Product::find($product->id);
            $file_path1 = [];
            $file_path3 = [];
            foreach ($ProductImages as $key => $ProductImage) {
                $file_path1[] =  $ProductImage->image_path;
            }

            $description_json = $Product->other_description_api;
            if (!empty($description_json)) {

                $description_json = json_decode($Product->other_description_api, true);
                foreach ($description_json['product-other-description'] as $key => $value) {
                    if ($value['field_type'] == 'photo upload') {
                        $file_path3[] =  $value['value'];
                    }
                }
            }

            $file_paths2[] = $Product->cover_image_path;
            $file_path = array_merge($file_path1, $file_path3, $file_paths2);
            Utility::changeproductStorageLimit(\Auth::user()->creatorId(), $file_path, $file_path1);
            if (!empty($ProductImages)) {
                // image remove from product variant image
                foreach ($ProductImages as $key => $ProductImage) {
                    if (File::exists(base_path($ProductImage->image_path))) {
                        File::delete(base_path($ProductImage->image_path));
                    }
                }
            }

            // if (!empty($ProductImages)) {
            //     // image remove from product variant image
            //     foreach ($ProductImages as $key => $ProductImage) {
            //         if (File::exists(base_path($ProductImage->image_path))) {
            //             File::delete(base_path($ProductImage->image_path));
            //         }
            //     }
            // }

            ProductImage::where('product_id', $product->id)->delete();

            ProductStock::where('product_id', $product->id)->delete();

            woocommerceconection::where('original_id', $product->id)->delete();

            shopifyconection::where('original_id', $product->id)->delete();

            $Product = Product::find($product->id);
            if (!empty($Product)) {
                // image remove from description json
                $description_json = $Product->other_description_api;
                if (!empty($description_json)) {
                    $description_json = json_decode($Product->other_description_api, true);
                    foreach ($description_json['product-other-description'] as $key => $value) {
                        if ($value['field_type'] == 'photo upload') {
                            if (File::exists(base_path($value['value']))) {
                                File::delete(base_path($value['value']));
                            }
                        }
                    }
                }

                // image remove from cover image
                if (File::exists(base_path($Product->cover_image_path))) {
                    File::delete(base_path($Product->cover_image_path));
                }

                Cart::where('product_id', $product->id)->delete();
                Wishlist::where('product_id', $product->id)->delete();

                Product::where('id', $product->id)->delete();
            }
            return redirect()->back()->with('success', __('Product delete successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function get_category(Request $request)
    {
        $MainCategory = MainCategory::where('theme_id', $request->theme_id)->get();
        $option = '<option value="">' . __('Select Category') . '</option>';
        foreach ($MainCategory as $key => $Category) {
            $option .= '<option value="' . $Category->id . '">' . $Category->name . '</option>';
        }
        $return['status'] = true;
        $return['html'] = $option;
        return response()->json($return);
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        $unit_price = !empty($request->price) ? $request->price : 0;
        $product_name = !empty($request->sku) ? $request->sku : '';
        $stock = !empty($request->product_stock) ? $request->product_stock : 0;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        $combinations = $this->combinations($options);
        return view('product.sku_combinations', compact('combinations', 'unit_price', 'product_name', 'stock'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::find($request->id);

        $options = array();
        $product_name = !empty($request->sku) ? $request->sku : '';
        $unit_price = !empty($request->price) ? $request->price : 0;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        $combinations = $this->combinations($options);
        return view('product.sku_combinations_edit', compact('combinations', 'unit_price', 'product_name', 'product'));
    }

    public function combinations($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    public function product_image_form(Request $request, $id)
    {
        $product = Product::find($id);
        $ProductImages = ProductImage::where('product_id', $id)->get();
        return view('product.product_image', compact('ProductImages', 'product'));
    }

    public function product_image_remove(Request $request)
    {
        $id = $request->id;
        $ProductImage = ProductImage::find($id);
        if (!empty($ProductImage)) {
            $file_path = $ProductImage->image_path;
            Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);

            if (File::exists(base_path($ProductImage->image_path))) {
                File::delete(base_path($ProductImage->image_path));
            }
            $ProductImage->delete();
        }
    }

    public function product_image_update(Request $request, $id)
    {
        $cover_image = '';
        $cover_image_status = 0;
        $cover_image_path = '';
        $dir        = 'themes/' . APP_THEME() . '/uploads';

        if (!empty($request->product_cover_image_update)) {
            $product = Product::find($id);

            $file_path =  $product->cover_image_path;
            $image_size = $request->file('product_cover_image_update')->getSize();
            $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
            if ($result == 1) {
                Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
                $fileName = rand(10, 100) . '_' . time() . "_" . $request->product_cover_image_update->getClientOriginalName();
                $path = Utility::upload_file($request, 'product_cover_image_update', $fileName, $dir, []);
            } else {
                return redirect()->back()->with('error', $result);
            }


            // $cover_image = upload_theme_image(APP_THEME(), $request->file('product_cover_image_update'));
            if ($path['flag'] == '0') {
                $return['flag'] = false;
                $return['msg'] = 'error';
                $return['url'] = $path['url'];
                return response()->json($return);
            }

            $product->cover_image_path = $path['url'];
            $product->cover_image_url = $path['full_url'];
            $product->save();

            $cover_image_path = $path['full_url'];
            $cover_image = '
            <div class="col-4 mb-4">
                <section class="position-relative remove_image_section">
                    <img src="' . $cover_image_path . '" alt="dsa" class="img-fluid">
                </section>
            </div>
            ';
            $cover_image_status = 1;
        }
        $error_message = '';
        $error_message_status = 0;
        $html = '';

        $dd = [];
        if ($request->product_image_update) {
            $rules = [
                'product_image_update' => 'max:2480'
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                $return['response'] = false;
                $return['status'] = 'success';
                $return['message'] = $messages->first();
                return response()->json($return);
            }

            $ProductImage = ProductImage::where('product_id', $id)->get();
            $html = '';
            foreach ($ProductImage as $key => $image) {
                $html .= '
                <div class="col-4 mb-4">
                    <section class="position-relative remove_image_section">
                        <img src="' . $image->image_url . '" alt="" class="img-fluid">
                        <button class="btn btn-sm btn-danger m-2 remove_image" data-id="' . $image->id . '">
                            <i class="ti ti-circle-x py-1" data-bs-toggle="tooltip" title="Remove Image"></i>
                        </button>
                    </section>
                </div>';
            }

            foreach ($request->product_image_update as $key => $image) {
                $theme_name = APP_THEME();
                $theme_image = $image;
                $image_size = File::size($theme_image);
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if ($result == 1) {
                    Utility::changeproductStorageLimit(\Auth::user()->creatorId(), $file_path);
                    $fileName = rand(10, 100) . '_' . time() . "_" . $image->getClientOriginalName();
                    $pathss = Utility::keyWiseUpload_file($request, 'product_image_update', $fileName, $dir, $key, []);
                } else {
                    return redirect()->back()->with('error', $result);
                }

                // $product_image = upload_theme_image($theme_name, $theme_image, $key);
                // $dd[$key] = $product_image['image_path'];

                if ($pathss['flag'] == 0) {
                    if ($error_message_status == 0) {
                        $error_message_status = 1;
                        $error_message = '<span class="text-danger">' . $pathss['msg'] . '</span>';
                    }
                } else {
                    $ProductImage = new ProductImage();
                    $ProductImage->product_id = $id;
                    $ProductImage->image_path = $pathss['url'];
                    $ProductImage->image_url  = $pathss['full_url'];
                    $ProductImage->theme_id   = APP_THEME();
                    $ProductImage->store_id   = getCurrentStore();
                    $ProductImage->save();

                    $html .=
                        '<div class="col-4 mb-4">
                        <section class="position-relative remove_image_section">
                            <img src="' . $pathss['full_url'] . '" alt="" class="img-fluid">
                            <button class="btn btn-sm btn-danger m-2 remove_image" data-id="' . $ProductImage->id . '">
                                <i class="ti ti-circle-x py-1" data-bs-toggle="tooltip" title="Remove Image"></i>
                            </button>
                        </section>
                    </div>';
                }
            }
        }

        $return['response'] = true;
        $return['status'] = 'success';
        $return['message'] = __('Product Image update successfully.') . $error_message;
        $return['html'] = $html;
        $return['cover_image_status'] = $cover_image_status;
        $return['cover_image'] = $cover_image;
        $return['cover_image_path'] = $cover_image_path;
        $return['product_id'] = $id;

        return response()->json($return);
    }

    public function get_subcategory(Request $request)
    {
        $maincategory = $request->maincategory;
        $subcategory_id = $request->subcategory;
        $SubCategorys = SubCategory::where('maincategory_id', $maincategory)->pluck('name', 'id');
        $option = '<option value="">' . __('Select Option') . '</option>';
        if (!empty($SubCategorys)) {
            foreach ($SubCategorys as $key => $category) {
                $select = ($subcategory_id == $key) ? 'selected' : '';
                $option .= '<option value="' . $key . '" ' . $select . '>' . $category . '</option>';
            }
        }
        $return['status'] = true;
        $return['html'] = $option;
        return response()->json($return);
    }

    public function product_price(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;
        $settings = Setting::where('theme_id', $theme_id)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();

        $varint = $request->varint;
        $qty = $request->qty;
        $product_id = $request->product_id;
        $return['qty'] = $qty;
        $return['variant_id'] = 0;

        $product = Product::find($product_id);
        $return['variant_product'] = $product->variant_product;
        if (!empty($product)) {
            if ($product->variant_product == 0) {
                // no varint
                if ($product->product_stock < $settings['out_of_stock_threshold'] && $product->stock_order_status == 'not_allow') {
                    $return['status'] = 'error';
                    $return['message'] = __('Product has been reached max quantity.');
                } else {
                    $product_original_price = $product->original_price * $qty;
                    $product_final_price = $product->final_price * $qty;

                    $data['theme_id'] = $this->APP_THEME;
                    $data['store_id'] = $store->id;
                    $data['sub_total'] = $product_final_price;
                    $data['product_original_price'] = $product_original_price;
                    $cart_array  = Tax::TaxCount($data);

                    $return['sub_total'] = $product_final_price;
                    $return['product_original_price'] = $product_original_price;
                    $return['variant_id'] = 0;
                    $return['original_price'] = $cart_array['original_price'];
                    $return['final_price'] = $cart_array['final_price'];
                    $return['currency_name'] = $cart_array['currency_name'];
                    $return['total_tax_price'] = $cart_array['total_tax_price'];
                    return response()->json($return);
                }
            } elseif ($product->variant_product == 1) {
                // has varint
                $variant_name = implode('-', $varint);
                $product->setAttribute('variantName', $variant_name);
                $ProductStock = ProductStock::where('product_id', $product_id)
                    ->where('variant', $variant_name)
                    ->first();
                    if ($ProductStock)
                    {
                        $stock = !empty($ProductStock->stock) ? $ProductStock->stock : $product->product_stock;
                        $variationOptions = explode(',', $ProductStock->variation_option);
                        $option = in_array('manage_stock', $variationOptions);

                        if ($option == true) {
                            $stock_status = $ProductStock->stock_order_status;
                        } else {
                            $stock_status = $product->stock_order_status;
                        }

                        if ($stock < $qty && $stock_status == 'not_allow') {
                            $return['status'] = 'error';
                            $return['variant_id'] = $ProductStock->id;
                            $return['message'] = __('Product has been reached max quantity.');
                        } else {
                            $sale_price = !empty($ProductStock->price) ? $ProductStock->price : $ProductStock->variation_price;

                            $variation_price = !empty($ProductStock->variation_price) ? $ProductStock->variation_price : $ProductStock->price;

                            $var_price = !empty($sale_price) ? $sale_price : 0;

                            $product_original_price = $product->original_price * $qty;
                            $product_final_price = $product->final_price * $qty;

                            // $product_original_price = $variation_price * $qty;
                            // $product_final_price = $var_price * $qty;
                            if ($option == true) {
                                $variat_stock = !empty($ProductStock->stock) ? $ProductStock->stock : 0;
                            }else{
                                $variat_stock = !empty($ProductStock->stock) ? $ProductStock->stock : $product->product_stock;
                            }
                            $data['theme_id'] = $this->APP_THEME;
                            $data['store_id'] = $store->id;
                            $data['sub_total'] = $product_final_price;
                            $data['product_original_price'] = $product_original_price;
                            $cart_array  = Tax::TaxCount($data);

                            $return['sub_total'] = $product_final_price;
                            $return['product_original_price'] = $product_original_price;
                            $return['variant_id'] = $ProductStock->id;
                            $return['original_price'] = $cart_array['original_price'];
                            $return['final_price'] = $cart_array['final_price'];
                            $return['currency_name'] = $cart_array['currency_name'];
                            $return['currency'] = $cart_array['currency'];
                            $return['total_tax_price'] = $cart_array['total_tax_price'];
                            $return['enable_option_data'] = !empty($option) ? $option : '';
                            $return['stock'] = !empty($variat_stock) ? $variat_stock : 0;
                            $return['stock_status'] = !empty($ProductStock->stock_status) ? $ProductStock->stock_status : '';
                            $return['description'] = !empty($ProductStock->description) ? $ProductStock->description : $product->descripion;
                            $return['variant_name'] = !empty($variant_name) ? $variant_name : '';
                            return response()->json($return);
                        }
                    }


            } else {
            }
        } else {
            $return['status'] = 'error';
            $return['message'] = __('Whoops! Something went wrong.');
        }
        return response()->json($return);
    }

    public function searchProducts(Request $request)
    {
        $lastsegment = $request->session_key;
        $store_id = Store::where('id', getCurrentStore())->first();
        if ($request->ajax() && isset($lastsegment) && !empty($lastsegment)) {
            $output = "";
            if ($request->cat_id !== '' && $request->search == '') {
                if ($request->cat_id == '0') {
                    $products = Product::where('store_id', getCurrentStore())->where('theme_id', $store_id->theme_id)->where('variant_product', '0')->get();
                } else {
                    $products = Product::where('category_id', $request->cat_id)->where('variant_product', '0')->where('store_id', getCurrentStore())->where('theme_id', $store_id->theme_id)->get();
                }
            } else {
                if ($request->cat_id == '0') {
                    $products = Product::where('name', 'LIKE', "%{$request->search}%")->where('store_id', getCurrentStore())->where('theme_id', $store_id->theme_id)->where('variant_product', '0')->get();
                } else {
                    $products = Product::where('name', 'LIKE', "%{$request->search}%")->where('store_id', getCurrentStore())->where('theme_id', $store_id->theme_id)->where('variant_product', '0')->Where('product_categorie', $request->cat_id)->get();
                }
            }
            if (count($products) > 0) {
                foreach ($products as $key => $product) {
                    $quantity = $product->product_stock;
                    if (!empty($product->cover_image_path)) {
                        $image_url = get_file($product->cover_image_path, APP_THEME());
                    } else {
                        $image_url = ('uploads/cover_image_path') . '/default.jpg';
                    }
                    if ($request->session_key == 'purchases') {
                        $productprice = $product->price != 0 ? $product->price : 0;
                    } else if ($request->session_key == 'pos') {
                        $productprice = $product->price != 0 ? $product->price : 0;
                    } else {
                        $productprice = $product->price != 0 ? $product->price : $product->price;
                    }


                    $output .= '
                            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 col-12">
                                <div class="tab-pane fade show active toacart w-100" data-url="' . url('admin/addToCart/' . $product->id . '/' . $lastsegment) . '">
                                    <div class="position-relative card">
                                        <img alt="Image placeholder" src="' . asset($image_url) . '" class="card-image avatar hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                        <div class="p-0 custom-card-body card-body d-flex ">
                                            <div class="card-body my-2 p-2 text-left card-bottom-content">
                                                <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                <small class="badge badge-primary mb-0">' . SetNumberFormat($productprice) . '</small>

                                                <small class="top-badge badge badge-danger mb-0">' . $quantity . ' QTY' . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    ';
                }

                return Response($output);
            } else {
                $output = '<div class="card card-body col-12 text-center">
                    <h5>' . __("No Product Available") . '</h5>
                    </div>';
                return Response($output);
            }
        }
    }

    public function addToCart(Request $request, $id, $session_key)
    {
        $store_id = Store::where('id', getCurrentStore())->first();
        $product = Product::find($id);
        $settings = Utility::Seting();

        if ($product) {
            $productquantity = $product->product_stock;
        }
        if (!$product || ($session_key == 'pos' && $productquantity == 0 ) &&  $product->product_stock < $settings['out_of_stock_threshold'] && $product->stock_order_status == 'not_allow')
        {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }

        $productname = $product->name;
        if ($session_key == 'pos') {

            $productprice = $product->price != 0 ? $product->price : 0;
        }

        $originalquantity = (int)$productquantity;

        $Tax = Tax::select('tax_name', 'tax_type', 'tax_amount', 'id')->where('store_id', $store_id->id)->where('theme_id', $store_id->theme_id)->get();
        $tax_price = 0;
        $product_tax = '';
        foreach ($Tax as $key1 => $value1) {
            $amount = $value1->tax_amount;
            if ($value1->tax_type == 'percentage') {
                $amount = $amount * $productprice / 100;
            }
            $cart_array['tax_info'][$key1]["tax_name"] = $value1->tax_name;
            $cart_array['tax_info'][$key1]["tax_type"] = $value1->tax_type;
            $cart_array['tax_info'][$key1]["tax_amount"] = $value1->tax_amount;
            $product_tax .= !empty($value1) ? "<span class='badge bg-primary'>" . $value1->tax_name . ' (' . $value1->tax_amount . '%)' . "</span><br>" : '';
            $cart_array['tax_info'][$key1]["id"] = $value1->id;
            $cart_array['tax_info'][$key1]["tax_string"] = $value1->tax_string;
            $cart_array['tax_info'][$key1]["tax_price"] = SetNumber($amount);
            $tax_price += $amount;
        }
        $subtotal = $productprice + $tax_price;


        $cart            = session()->get($session_key);
        if (!empty($product->cover_image_path)) {
            $image_url = get_file($product->cover_image_path, APP_THEME());
        } else {
            $image_url = ('uploads/is_cover_image') . '/default.jpg';
        }


        $model_delete_id = 'delete-form-' . $id;

        $carthtml = '';

        $carthtml .= '<tr data-product-id="' . $id . '" id="product-id-' . $id . '">
                        <td class="cart-images">
                            <img alt="Image placeholder" src="' . ($image_url) . '" class="card-image avatar shadow hover-shadow-lg">
                        </td>

                        <td class="name">' . $productname . '</td>

                        <td class="">
                                <span class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('admin/update-cart/') . '" data-id="' . $id . '">
                                        <input type="button" value="+" class="plus">
                                </span>
                        </td>


                        <td class="tax">' . $product_tax . '</td>

                        <td class="price">' .  SetNumberFormat($productprice) . '</td>

                        <td class="total_orignal_price">' . SetNumberFormat($subtotal) . '</td>

                        <td class="">
                                <form method="post" class="mb-0" action="' . route('admin.remove-from-cart') . '"  accept-charset="UTF-8" id="' . $model_delete_id . '">
                                <button type="button" class="show_confirm btn btn-sm btn-danger p-2">
                                <span class=""><i class="ti ti-trash"></i></span>
                                </button>
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="' . csrf_token() . '">
                                    <input type="hidden" name="session_key" value="' . $session_key . '">
                                    <input type="hidden" name="id" value="' . $id . '">
                                </form>

                        </td>
                    </td>';
        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $id => [
                    "product_id" => $product->id,
                    "name" => $productname,
                    "image" => $product->cover_image_path,
                    "quantity" => 1,
                    "orignal_price" => $productprice,
                    "per_product_discount_price" => $product->discount_amount,
                    "discount_price" => $product->discount_amount,
                    "final_price" => $subtotal,
                    "id" => $id,
                    "tax" => $tax_price,
                    "total_orignal_price" => $subtotal,
                    "originalquantity" => $originalquantity,
                    'variant_id' => 0,
                    "variant_name" => $product->variant_attribute,
                    "return" => 0,
                ],
            ];

            // dd($cart , $product);
            if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos' && $product->stock_order_status == 'not_allow')
            {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carthtml' => $carthtml,
                ]
            );
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {


            $cart[$id]['quantity']++;
            $cart[$id]['id'] = $id;

            $subtotal = $cart[$id]["orignal_price"] * $cart[$id]["quantity"];
            $tax = 0;
            $taxes            = !empty($cart[$id]["tax"]) ? $cart[$id]["tax"] : '';


            $Tax = Tax::select('tax_name', 'tax_type', 'tax_amount', 'id')->where('store_id', $store_id->id)->where('theme_id', $store_id->theme_id)->get();
            $tax_price = 0;
            $product_tax = '';
            $price = $cart[$id]["orignal_price"] * $cart[$id]["quantity"];
            foreach ($Tax as $key1 => $value1) {
                $amount = $value1->tax_amount;
                if ($value1->tax_type == 'percentage') {
                    $amount = $amount * $subtotal / 100;
                }
                $cart_array['tax_info'][$key1]["tax_name"] = $value1->tax_name;
                $cart_array['tax_info'][$key1]["tax_type"] = $value1->tax_type;
                $cart_array['tax_info'][$key1]["tax_amount"] = $value1->tax_amount;
                $product_tax .= !empty($value1) ? "<span class='badge bg-primary'>" . $value1->tax_name . ' (' . $value1->tax_amount . '%)' . "</span><br>" : '';
                $cart_array['tax_info'][$key1]["id"] = $value1->id;
                $cart_array['tax_info'][$key1]["tax_string"] = $value1->tax_string;
                $cart_array['tax_info'][$key1]["tax_price"] = SetNumber($amount);
                $tax_price += $amount;
            }

            if (!empty($taxes)) {
                $productprice          = $cart[$id]["orignal_price"] *  (float)$cart[$id]["quantity"];
                $subtotal = $productprice +  $tax_price;
            } else {

                $productprice          = $cart[$id]["orignal_price"];
                $subtotal = $productprice  *  (float)$cart[$id]["quantity"];
            }
            $cart[$id]["total_orignal_price"] = $subtotal;

            $cart[$id]["total_orignal_price"]         = $subtotal + $tax;
            $cart[$id]["originalquantity"] = $originalquantity;
            $cart[$id]["tax"]      = $tax_price;
            if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carttotal' => $cart,
                ]
            );
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "product_id" => $product->id,
            "name" => $productname,
            "image" => $product->cover_image_path,
            "quantity" => 1,
            "orignal_price" => $productprice,
            "per_product_discount_price" => $product->discount_amount,
            "discount_price" => $product->discount_amount,
            "final_price" => $subtotal,
            "id" => $id,
            "tax" => $tax_price,
            "total_orignal_price" => $subtotal,
            "originalquantity" => $originalquantity,
            'variant_id' => 0,
            "variant_name" => $product->variant_attribute,
            "return" => 0,
        ];

        if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This product is out of stock!'),
                ],
                404
            );
        }

        session()->put($session_key, $cart);
        return response()->json(
            [
                'code' => 200,
                'status' => 'Success',
                'success' => $productname . __(' added to cart successfully!'),
                'product' => $cart[$id],
                'carthtml' => $carthtml,
                'carttotal' => $cart,
            ]
        );
    }

    public function updateCart(Request $request)
    {
        $id          = $request->id;
        $quantity    = $request->quantity;
        $discount    = $request->discount;
        $session_key = $request->session_key;
        $store_id = Store::where('id', getCurrentStore())->first();

        if ($request->ajax() && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);

            if (isset($cart[$id]) && $quantity == 0) {
                unset($cart[$id]);
            }

            if ($quantity) {

                $cart[$id]["quantity"] = $quantity;
                $taxes            = !empty($cart[$id]["tax"]) ? $cart[$id]["tax"] : '';

                $price = $cart[$id]["orignal_price"] * $quantity;

                $Tax = Tax::select('tax_name', 'tax_type', 'tax_amount', 'id')->where('store_id', $store_id->id)->where('theme_id', $store_id->theme_id)->get();
                $tax_price = 0;
                $product_tax = '';
                foreach ($Tax as $key1 => $value1) {
                    $amount = $value1->tax_amount;
                    if ($value1->tax_type == 'percentage') {
                        $amount = $amount * $price / 100;
                    }
                    $cart_array['tax_info'][$key1]["tax_name"] = $value1->tax_name;
                    $cart_array['tax_info'][$key1]["tax_type"] = $value1->tax_type;
                    $cart_array['tax_info'][$key1]["tax_amount"] = $value1->tax_amount;
                    $product_tax .= !empty($value1) ? "<span class='badge bg-primary'>" . $value1->tax_name . ' (' . $value1->tax_amount . '%)' . "</span><br>" : '';
                    $cart_array['tax_info'][$key1]["id"] = $value1->id;
                    $cart_array['tax_info'][$key1]["tax_string"] = $value1->tax_string;
                    $cart_array['tax_info'][$key1]["tax_price"] = SetNumber($amount);
                    $tax_price += $amount;
                }
                $subtotal = $price + $tax_price;
                $producttax = 0;
                if (!empty($taxes)) {
                    $productprice          = $cart[$id]["orignal_price"] *  (float)$quantity;
                    $subtotal = $productprice +  $tax_price;
                } else {

                    $productprice          = $cart[$id]["orignal_price"];
                    $subtotal = $productprice  *  (float)$quantity;
                }

                $cart[$id]["total_orignal_price"] = $subtotal;
            }

            if (isset($cart[$id]) && isset($cart[$id]["originalquantity"]) < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            $subtotal = array_sum(array_column($cart, 'total_orignal_price'));
            $discount = $request->discount;
            $total = $subtotal - (float)$discount;
            $totalDiscount = SetNumberFormat($total);
            $discount = $totalDiscount;


            session()->put($session_key, $cart);
            return response()->json(
                [
                    'code' => 200,
                    'success' => __('Cart updated successfully!'),
                    'product' => $cart,
                    'discount' => $discount,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }

    public function removeFromCart(Request $request)
    {
        $id          = $request->id;
        $session_key = $request->session_key;
        if (isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put($session_key, $cart);
            }
            return redirect()->back()->with('success', __('Product removed from cart!'));
        } else {
            return redirect()->back()->with('error', __('This Product is not found!'));
        }
    }

    public function emptyCart(Request $request)
    {
        $session_key = $request->session_key;

        if (isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0) {
                session()->forget($session_key);
            }

            return redirect()->back()->with('error', __('Cart is empty!'));
        } else {
            return redirect()->back()->with('error', __('Cart cannot be empty!.'));
        }
    }

    public function attribute_option(Request $request)
    {
        // foreach ($request->attribute_id as $no) {
        // $name = 'choice_options_' . $no;
        $Attribute_option = ProductAttributeOption::where('attribute_id', $request->attribute_id)->where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())
            ->get()->pluck('terms', 'id')->toArray();


        // }
        return response()->json($Attribute_option);
    }

    public function attribute_combination(Request $request)
    {
        $options = array();
        $unit_price = !empty($request->price) ? $request->price : 0;
        $product_name = !empty($request->sku) ? $request->sku : '';
        $stock = !empty($request->product_stock) ? $request->product_stock : 0;
        $input = $request->all();

        foreach ($request->attribute_no as $key => $no) {
            $forVariationName = 'for_variation_' . $no;
            $for_variation = isset($request->{'for_variation_' . $no}) ? $request->{'for_variation_' . $no} : 0;

            if ($request->has($forVariationName) && $request->input($forVariationName) == 1) {
                $name = 'attribute_options_' . $no;
                $value = 'options_' . $no;
                if ($for_variation == 1) {
                    if ($request->has($name) && is_array($request[$name])) {
                        $my_str = $request[$name];
                        $optionValues = [];

                        foreach ($request[$name] as $id) {
                            $option = ProductAttributeOption::where('id', $id)->first();

                            if ($option) {
                                $optionValues[] = $option->terms;
                            }
                        }

                        array_push($options, $optionValues);
                    }
                }
            }
        }

        $combinations = $this->combination($options);

        $Shipping = Shipping::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Same as Parent', '');

        return view('product.attribute_combinations', compact('combinations', 'input', 'unit_price', 'product_name', 'stock', 'Shipping'));
    }

    public function attribute_combination_edit(Request $request)
    {
        $product = Product::find($request->id);
        $options = array();
        $product_name = !empty($request->sku) ? $request->sku : '';
        $unit_price = !empty($request->price) ? $request->price : 0;

        foreach ($request->attribute_no as $key => $no) {
            $forVariationName = 'for_variation_' . $no;
            $for_variation = isset($request->{'for_variation_' . $no}) ? $request->{'for_variation_' . $no} : 0;
            if ($for_variation == 1) {
                if ($request->has($forVariationName) && $request->input($forVariationName) == 1) {
                    $name = 'attribute_options_' . $no;

                    if ($request->has($name) && is_array($request[$name])) {
                        $my_str = $request[$name];
                        $optionValues = [];
                        array_push($options, $my_str);
                    }
                }
            }
        }

        $combinations = $this->combination($options);
        $Shipping = Shipping::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Same as parent', '');
        return view('product.attribute_combinations_edit', compact('combinations', 'unit_price', 'product_name', 'product', 'Shipping'));
    }

    public function combination($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    public function product_attribute_delete($id)
    {
        $attribute = ProductStock::findOrFail($id);
        $attribute->delete();

        return "true";
    }
    public function attribute_combination_data(Request $request)
    {
        $product_stock = ProductStock::where('product_id', $request->id)->where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())
            ->get();
        $Shipping = Shipping::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Same as parent', '');
        return view('product.attribute_combinations_data', compact('product_stock', 'Shipping'));
    }
}
