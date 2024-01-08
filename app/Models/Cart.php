<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use PhpParser\Node\Expr\Cast\Object_;
use Session;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'variant_id', 'qty', 'price', 'theme_id'
    ];

    public function product_data()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function variant_data()
    {
        return $this->hasOne(ProductStock::class, 'id', 'variant_id');
    }

    public static function CartCount()
    {
        $return = 0;
        if (Auth::check()) {
            $return = Cart::where('user_id', Auth::user()->id)
                ->where('theme_id', APP_THEME())
                ->count();
        } else {
            $cart_Cookie = Cookie::get('cart');
            $theme_id = APP_THEME();
            $store_id = getCurrentStore();
            if (!empty($cart_Cookie)) {
                $cart_array = json_decode($cart_Cookie, true);
                if ($cart_array !== null) {
                    foreach ($cart_array as $key => $cart_value) {
                        if ($cart_value['theme_id'] != $theme_id || $cart_value['store_id'] != $store_id) {
                            unset($cart_array[$key]);
                        }
                    }
                    $return = count($cart_array);
                }
            }
        }
        return $return;
    }

    public static function addtocart_cookie($product_id = 0, $variant_id = 0, $qty = 0)
    {
        $theme_id = APP_THEME();
        $store_id = getCurrentStore();
        // $settings = Setting::where('theme_id', $theme_id)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();
        $settings = Utility::Seting();
        $final_price = 0;
        $cart_count = 0;
        $product = Product::find($product_id);
        if (!empty($variant_id) || $variant_id != 0) {
            $ProductStock = ProductStock::where('id', $variant_id)
                ->where('product_id', $product_id)
                ->first();
            $product->setAttribute('variantId', $variant_id);
            $variationOptions = explode(',', $ProductStock->variation_option);
            $option = in_array('manage_stock', $variationOptions);
            if ($option  == true) {
                $stock = !empty($ProductStock->stock) ? $ProductStock->stock : 0;
                if (empty($ProductStock)) {
                    return Utility::error(['message' => 'Product not found.']);
                } else {
                    if ($stock <= $settings['out_of_stock_threshold'] && $ProductStock->stock_order_status == 'not_allow') {
                        return Utility::error(['message' => 'Product has out of stock.']);
                    }
                }
            } else {
                $stock = !empty($ProductStock->stock) ? $ProductStock->stock : $product->product_stock;
                if (empty($ProductStock)) {
                    return Utility::error(['message' => 'Product not found.']);
                } else {
                    if ($stock <= $settings['out_of_stock_threshold'] && $product->stock_order_status == 'not_allow') {
                        return Utility::error(['message' => 'Product has out of stock.']);
                    }
                }
            }

            $final_price = $ProductStock->final_price * $qty;
        } else {
            if (!empty($product)) {
                if ($product->variant_product == 1) {
                    $product_stock_datas = ProductStock::find($variant_id);
                    $product->setAttribute('variantId', $variant_id);
                    $var_stock = !empty($product_stock_datas->stock) ? $product_stock_datas->stock : $product->product_stock;
                    if (empty($variant_id) || $variant_id == 0) {
                        return Utility::error(['message' => 'Please Select a variant in a product.']);
                    } else if ($var_stock <= $settings['out_of_stock_threshold'] && $product_stock_datas->stock_order_status == 'not_allow') {
                        return Utility::error(['message' => 'Please Select a diffrent variant in a product.']);
                    } else {
                        $product_stock_data = ProductStock::find($variant_id);
                        if ($product_stock_data->stock_status == 'out_of_stock') {
                            return Utility::error(['message' => 'Product has out of stock.']);
                        }
                    }
                } else {
                    if ($product->product_stock <= $settings['out_of_stock_threshold'] && $product->stock_order_status == 'not_allow') {
                        return Utility::error(['message' => 'Product has out of stock.']);
                    }
                }
                $final_price = floatval($product->final_price) * floatval($qty);
            } else {
                return Utility::error(['message' => 'Product not found.']);
            }
        }

        $qty = $qty;
        $key_name = $product_id . '_' . $variant_id;
        $cart[$key_name]['product_id'] = $product_id;
        $cart[$key_name]['variant_id'] = $variant_id;
        $cart[$key_name]['qty'] = $qty;
        $cart[$key_name]['created_at'] = now();
        $cart[$key_name]['theme_id'] = $theme_id;
        $cart[$key_name]['store_id'] = $store_id;


        $cart_Cookie = Cookie::get('cart');
        if (!empty($cart_Cookie)) {
            $cart_array = json_decode($cart_Cookie, true);
            if (!empty($cart_array[$key_name])) {
                $cart_count = count($cart_array);
                return Utility::error(['message' => $product->name . ' already in cart.', 'count' => $cart_count]);
            } else {
                $cart_array = array_merge($cart_array, $cart);
                $cart_count = count($cart_array);
                $cart_json = json_encode($cart_array);
                Cookie::queue('cart', $cart_json, 1440);
            }
        } else {
            $cart_json = json_encode($cart);
            Cookie::queue('cart', $cart_json, 1440);
            $cart_count = 1;
        }

        if (!empty($cart_count)) {
            return Utility::success(['message' => $product->name . ' add successfully.', 'count' => $cart_count]);
        } else {
            return Utility::error(['message' => 'Cart is empty.', 'count' => $cart_count]);
        }
    }

    public static function cart_list_cookie($storeid = '')
    {
        $theme_id = APP_THEME();
        $store_id = getCurrentStore();
        $Carts = $cart_Cookie = Cookie::get('cart');

        $shipping_price_1 = Session::get('request_data');
        $shipping_price = (int)$shipping_price_1;
        $coupon_amount = Session::get('coupon_price');
        Session::forget('coupon_price');

        if (empty($Carts)) {
            $na = [];
            $Carts = json_encode($na);
        }
        $Carts = json_decode($Carts);
        if (!empty($Carts)) {
            foreach ($Carts as $key => $cart_value) {
                if ($cart_value->theme_id != $theme_id || $cart_value->store_id != $store_id) {
                    unset($Carts->$key);
                }
            }
        }

        $cart_array = [];

        $original_price = 0;
        $discount_price = 0;
        $after_discount_final_price = 0;
        $cart_total_qty = 0;
        $cart_final_price = 0;
        $shipping_original_price = 0;
        $total_orignal_price = 0;
        $cart_array['product_list'] = [];
        if (!empty($Carts)) {
            foreach ($Carts as $key => $cart_value) {
                $variant_name = '';
                $cart_product_data = Product::find($cart_value->product_id);
                if (empty($cart_value->variant_id) && $cart_value->variant_id == 0) {

                    $per_product_discount_price = !empty($cart_product_data->discount_price) ? $cart_product_data->discount_price : 0;
                    $product_discount_price = $per_product_discount_price * $cart_value->qty;

                    $final_price = !empty($cart_product_data->final_price) ? $cart_product_data->final_price : 0;
                    $final_price = $final_price * $cart_value->qty;

                    $product_orignal_price = !empty($cart_product_data->original_price) ? $cart_product_data->original_price : 0;
                    $total_product_orignal_price = $product_orignal_price * $cart_value->qty;
                } else {
                    $ProductStock = ProductStock::find($cart_value->variant_id);
                    $variant_name = $ProductStock->variant;

                    $per_product_discount_price = !empty($ProductStock->discount_price) ? $ProductStock->discount_price : 0;
                    $product_discount_price = $ProductStock->discount_price * $cart_value->qty;

                    $final_price = !empty($ProductStock->final_price) ? $ProductStock->final_price : 0;
                    $final_price = $final_price * $cart_value->qty;

                    $product_orignal_price = !empty($ProductStock->original_price) ? $ProductStock->original_price : 0;
                    $total_product_orignal_price = $product_orignal_price * $cart_value->qty;
                }

                $cart_array['product_list'][$key]['cart_id'] = $key;
                $cart_array['product_list'][$key]['cart_created'] = $cart_value->created_at;
                $cart_array['product_list'][$key]['product_id'] = $cart_value->product_id;
                $cart_array['product_list'][$key]['image'] = !empty($cart_product_data->cover_image_path) ? $cart_product_data->cover_image_path : ' ';
                $cart_array['product_list'][$key]['name'] = !empty($cart_product_data->name) ? $cart_product_data->name : ' ';
                $cart_array['product_list'][$key]['orignal_price'] = SetNumber($product_orignal_price);
                $cart_array['product_list'][$key]['total_orignal_price'] = SetNumber($total_product_orignal_price);
                $cart_array['product_list'][$key]['per_product_discount_price'] = SetNumber($per_product_discount_price);
                $cart_array['product_list'][$key]['discount_price'] = SetNumber($product_discount_price);
                $cart_array['product_list'][$key]['final_price'] = SetNumber($final_price);
                $cart_array['product_list'][$key]['qty'] = $cart_value->qty;
                $cart_array['product_list'][$key]['variant_id'] = $cart_value->variant_id;
                $cart_array['product_list'][$key]['variant_name'] = $variant_name;
                $cart_array['product_list'][$key]['return'] = 0;
                $cart_array['product_list'][$key]['shipping_price'] = $shipping_price;

                $discount_price += $product_discount_price;
                $cart_total_qty += $cart_value->qty;
                $cart_final_price += $final_price;
                $original_price += $total_product_orignal_price;
                $shipping_original_price += $shipping_price;
            }
        }

        $after_discount_final_price = $cart_final_price;

        $product_discount_price = (float)number_format((float)$discount_price, 2);
        $cart_array['product_discount_price'] = $product_discount_price;
        $after_discount_final_price = (float)$after_discount_final_price;

        $cart_array['sub_total'] = $after_discount_final_price;

        $Tax = Tax::select('tax_name', 'tax_type', 'tax_amount', 'id')->where('theme_id', APP_THEME())->where('store_id', $storeid)->where('status', 1)->get();

        if ($coupon_amount == '') {
            $final_total = $cart_final_price + $shipping_price;
        } else {
            $final_price_1 = $cart_final_price - $coupon_amount;
            $final_total = $final_price_1 + $shipping_price;
        }

        $tax_price = 0;
        foreach ($Tax as $key1 => $value1) {
            $amount = $value1->tax_amount;
            if ($value1->tax_type == 'percentage') {
                $amount = $amount * $final_total / 100;
            }

            $cart_array['tax_info'][$key1]["tax_name"] = $value1->tax_name;
            $cart_array['tax_info'][$key1]["tax_type"] = $value1->tax_type;
            $cart_array['tax_info'][$key1]["tax_amount"] = $value1->tax_amount;
            $cart_array['tax_info'][$key1]["id"] = $value1->id;
            $cart_array['tax_info'][$key1]["tax_string"] = $value1->tax_string;
            $cart_array['tax_info'][$key1]["tax_price"] = SetNumber($amount);
            $tax_price += $amount;
        }

        $cart_array['tax_price'] = SetNumber($tax_price);
        $cart_array['cart_total_product'] = count((array)$Carts);
        $cart_array['cart_total_qty'] = $cart_total_qty;
        $cart_array['original_price'] = SetNumber($original_price);
        $final_price = $final_total + $tax_price;
        // $final_price = $after_discount_final_price + $tax_price;
        $cart_array['final_price'] = SetNumber($final_price);
        $cart_array['total_final_price'] = SetNumber($final_price);
        $cart_array['total_sub_price'] = SetNumber($cart_final_price);


        if (!empty($cart_array)) {
            return Utility::success($cart_array);
        } else {
            return Utility::error(['message' => 'Cart is empty.']);
        }
    }

    public static function cart_qty_cookie($request)
    {
        $rules = [
            'product_id' => 'required',
            'variant_id' => 'required',
            'quantity_type' => 'required|in:increase,decrease,remove',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return Utility::error([
                'message' => $messages->first()
            ]);
        }

        $final_price = 0;
        $cart_id = $request->cart_id;
        if (!empty($request->variant_id) || $request->variant_id != 0) {
            $ProductStock = ProductStock::find($request->variant_id);
            $final_price = $ProductStock->final_price;
        } else {
            $product = Product::find($request->product_id);
            if (!empty($product)) {
                if ($product->variant_product == 1) {
                    if (empty($request->variant_id) || $request->variant_id == 0) {
                        return Utility::error([
                            'message' => 'Please Select a variant in a product.'
                        ]);
                    }
                }
                $final_price = $product->final_price;
            }
        }

        $cart = Cookie::get('cart');
        $cart_array1 = json_decode($cart, true);
        $cart_count = count($cart_array1);

        $cart_array = json_decode($cart);

        if (empty($cart_array1[$cart_id])) {
            return Utility::error(['message' => 'Product not found.'], 'fail', 200, 0, $cart_count);
        } else {
            if ($request->quantity_type == 'increase') {
                if (!empty($request->variant_id) || $request->variant_id != 0) {
                    if ($cart_array->$cart_id->qty >= $ProductStock->stock) {
                        return Utility::error(['message' => 'can not increase product quantity.'], 'fail', 200, 0, $cart_count);
                    } else {
                        $cart_array->$cart_id->qty += 1;
                    }
                } else {
                    if($product->stock_status == 'in_stock' || $product->stock_status == 'on_backorder')
                    {
                        $cart_array->$cart_id->qty += 1;
                    }
                    elseif ($cart_array->$cart_id->qty >= $product->product_stock) {
                        return Utility::error(['message' => 'can not increase product quantity.'], 'fail', 200, 0, $cart_count);
                    } else {
                        $cart_array->$cart_id->qty += 1;
                    }
                }
            }
            if ($request->quantity_type == 'decrease') {
                if ($cart_array->$cart_id->qty == 1) {
                    return Utility::error(['message' => 'can not decrease product quantity.'], 'fail', 200, 0, $cart_count);
                }
                if ($cart_array->$cart_id->qty > 0) {
                    $cart_array->$cart_id->qty -= 1;
                }
            }

            if ($request->quantity_type == 'remove') {
                unset($cart_array->$cart_id);
            }
            $cart_json = json_encode($cart_array);
            Cookie::queue('cart', $cart_json, 1440);

            $cart_count = Cart::where('user_id', $request->user_id)->count();
            return Utility::success(['message' => 'Cart successfully updated.'], "successfull", 200, $cart_count);
        }
    }

    public static function cookie_to_cart($user_id = 0, $store_id = '')
    {
        if ($user_id != 0) {
            $cart_Cookie = Cookie::get('cart');
            if (!empty($cart_Cookie)) {
                $products = json_decode($cart_Cookie);
                foreach ($products as $key => $product) {
                    $cart = Cart::where('user_id', $user_id)->where('product_id', $product->product_id)->where('variant_id', $product->variant_id)->first();
                    if (!empty($cart)) {
                        $cart->qty = $cart->qty + $product->qty;
                        $cart->save();
                    } else {
                        $price = 0;

                        $cart = new Cart();
                        $cart->user_id = $user_id;
                        $cart->product_id = $product->product_id;
                        $cart->variant_id = $product->variant_id;
                        $cart->qty = $product->qty;

                        if ($product->variant_id == 0) {
                            $productss = Product::find($product->product_id);
                            $price = !empty($productss) ? $productss->final_price : 0;
                        } else {
                            $ProductStock = ProductStock::find($product->variant_id);
                            $price = !empty($ProductStock) ? $ProductStock->final_price : 0;
                        }
                        $cart->price = $price;
                        $cart->theme_id = APP_THEME();
                        $cart->store_id = $store_id;
                        $cart->save();
                    }
                }
                $empty_cart = [];
                $cart_json = json_encode($empty_cart);
                Cookie::queue('cart', $cart_json, 1440);
            }
        }
    }

    public static function CartPageBestseller($slug = '')
    {
        $MainCategory = MainCategory::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->get()->pluck('name', 'id');
        $MainCategory->prepend('All Products', '0');
        $homeproducts = Product::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->get();
        $currency_icon = Utility::GetValueByName('CURRENCY');

        return view('bestseller_cart', compact('slug', 'homeproducts', 'MainCategory','currency_icon'))->render();
    }

    public function UserData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
