<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductStock;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\ApiController;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Utility;
use Illuminate\Support\Facades\Cookie;
use App\Models\Coupon;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;
use App\Models\Shipping;
use App\Models\DeliveryAddress;
use Illuminate\Support\Facades\Crypt;

use Session;

class CartController extends Controller
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
                $this->user = Auth::guard('admin')->user();
                $this->store = Store::where('id', $this->user->current_store)->first();
                $this->APP_THEME = $this->store->theme_id;

                return $next($request);
            });
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
        $cart->delete();
        return redirect()->back()->with('success', __('Product delete successfully into cart.'));
    }


    public function product_cartlist(Request $request, $slug)
    {

        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $product_id = $request->product_id;
        $variant_id = $request->variant_id;
        $qty = $request->qty;

        if (Auth::guest()) {
            $response =  Cart::addtocart_cookie($product_id, $variant_id, $qty);
            return response()->json($response);
        }

        $user_id = Auth::user()->id;

        $request->request->add(['variant_id' => $variant_id, 'user_id' => $user_id, 'qty' => $qty, 'store_id' => $store->id, 'slug' => $slug, 'theme_id' => $theme_id]);
        $api = new ApiController();
        $data = $api->addtocart($request);
        $response = $data->getData();

        return response()->json($response);
    }

    public function cart_list_sidebar(Request $request, $slug)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        if (Auth::guest()) {
            $response = Cart::cart_list_cookie($store->id);
            $response = json_decode(json_encode($response));
        } else {
            $request->merge(['user_id' => Auth::user()->id, 'store_id' => $store->id, 'slug' => $slug, 'theme_id' => $theme_id]);
            $api = new ApiController();
            $data = $api->cart_list($request);
            $response = $data->getData();
        }

        $return['status'] = $response->status;
        $return['message'] = $response->message;
        $return['sub_total'] = 0;
        if ($response->status == 1) {
            $currency = Utility::GetValueByName('CURRENCY', $this->APP_THEME);
            $currency_name = Utility::GetValueByName('CURRENCY_NAME', $this->APP_THEME);

            $return['cart_total_product'] = $response->data->cart_total_product;
            $return['html'] = view('cart-list-sidebar', compact('slug', 'response', 'currency', 'currency_name'))->render();
            $return['checkout_html'] = view('cart-list', compact('slug', 'response', 'currency', 'currency_name'))->render();
            $return['checkout_html_2'] = view('checkout-cart-list', compact('slug', 'response', 'currency', 'currency_name'))->render();
            $return['checkout_html_products'] = view('checkout-product-list', compact('response', 'currency', 'currency_name'))->render();
            $return['checkout_amounts'] = view('checkout-amount', compact('response', 'currency', 'currency_name'))->render();
            $return['sub_total'] = $response->data->sub_total;
        }

        return response()->json($return);
    }

    public function cart_remove(Request $request, $slug)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Store::where('slug', $slug)->first();
        // $theme_id = $store->theme_id;

        if (Auth::guest()) {
            $Carts = Cookie::get('cart');
            $Carts = json_decode($Carts, true);
            unset($Carts[$request->cart_id]);

            $cart_json = json_encode($Carts);
            Cookie::queue('cart', $cart_json, 1440);
        } else {
            $cart = Cart::find($request->cart_id)->first();

            // activity log
            $ActivityLog = new ActivityLog();
            $ActivityLog->user_id = $cart->user_id;
            $ActivityLog->log_type = 'remove to cart';
            $ActivityLog->remark = json_encode(
                [
                    'product' => $cart->product_id,
                    'variant' => $cart->variant_id,
                ]
            );
            $ActivityLog->theme_id = $cart->theme_id;
            $ActivityLog->store_id = $store->id;
            $ActivityLog->save();

            Cart::where('id', $request->cart_id)->delete();
        }
    }

    public function change_cart(Request $request, $slug)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $cart_id = $request->cart_id;
        $quantity_type = $request->quantity_type;

        if (Auth::guest()) {
            $Carts = Cookie::get('cart');
            $Carts_array = json_decode($Carts);
            $Carts_array->$cart_id;

            $param = [
                'product_id' => $Carts_array->$cart_id->product_id,
                'variant_id' => $Carts_array->$cart_id->variant_id,
                'quantity_type' => $quantity_type,
            ];

            $request->merge($param);

            $response = Cart::cart_qty_cookie($request);
            return response()->json($response);
        } else {
            $Cart = Cart::find($cart_id);

            $param = [
                'user_id' => $Cart->user_id,
                'product_id' => $Cart->product_id,
                'variant_id' => $Cart->variant_id,
                'quantity_type' => $quantity_type,
                'theme_id' => $theme_id,
                'slug' => $slug,

            ];

            $request->merge($param);

            $api = new ApiController();
            $data = $api->cart_qty($request);
            $response = $data->getData();

            return response()->json($response);
        }
    }

    public function get_shipping_data(Request $request, $slug)
    {
        $Products = $request['product_id'];
        $Product = Product::find($Products);

        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;
        $code = trim($request->coupon_code);
        $coupon = Coupon::where('coupon_code', $code)->where('theme_id', $theme_id)->where('store_id', $store->id)->first();

        if (\Auth::user()) {
            $request->merge(['user_id' => Auth::user()->id, 'store_id' => $store->id, 'slug' => $slug, 'theme_id' => $theme_id]);
            $api = new ApiController();
            $data = $api->cart_list($request);
            $response = $data->getData();
            $sub_total = $response->data->sub_total;

            $Delivery_Address = DeliveryAddress::where('user_id', \Auth::user()->id)->where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();

            if ($Delivery_Address == "") {
                $country = $request->countryId;
                $state_id = $request->stateId;

                $Shipping_zone = ShippingZone::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->where('country_id', $country)->where('state_id', $state_id)->first();
            } else {
                $User_address = $request['address_id'];
                $country = $request->countryId;
                $state_id = $request->stateId;

                $Address = DeliveryAddress::find($User_address);
                $Shipping_zone = ShippingZone::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->where('country_id', $country)->where('state_id', $state_id)->first();
            }

            $shipping_requires = ShippingMethod::Free_shipping();

            if (!empty($Shipping_zone)) {
                $methods = ShippingMethod::where('zone_id', $Shipping_zone->id)->where('theme_id', $theme_id)->where('store_id', $store->id)->get();
                $shippingMethods = [];
                $freeShippingMethod = null;
                foreach ($methods as $method) {
                    if ($method->shipping_requires == '1' || $method->shipping_requires == '3' || $method->shipping_requires == '4') {
                        if ($method->method_name == "Free shipping") {
                            if ($method->cost < $sub_total) {
                                $freeShippingMethod = $method;
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } elseif ($method->shipping_requires == '2' || $method->shipping_requires == '5') {
                        if ($method->method_name == "Free shipping") {
                            if (!empty($coupon)) {
                                if ($method->cost < $sub_total) {
                                    $freeShippingMethod = $method;
                                }
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } else {
                        $shippingMethods[] = $method;
                    }
                }
                if ($freeShippingMethod !== null) {
                    $shippingMethods = [$freeShippingMethod];
                }
            } else {

                $Shipping_zone = ShippingZone::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->where('country_id', '')->where('state_id', '')->first();
                $methods = ShippingMethod::where('zone_id', $Shipping_zone->id)->where('theme_id', $theme_id)->where('store_id', $store->id)->get();
                $shippingMethods = [];
                $freeShippingMethod = null;
                foreach ($methods as $method) {
                    if ($method->shipping_requires == '1' || $method->shipping_requires == '3' || $method->shipping_requires == '4') {
                        if ($method->method_name == "Free shipping") {
                            if ($method->cost < $sub_total) {
                                $freeShippingMethod = $method;
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } elseif ($method->shipping_requires == '2' || $method->shipping_requires == '5') {
                        if ($method->method_name == "Free shipping") {
                            if (!empty($coupon)) {
                                if ($method->cost < $sub_total) {
                                    $freeShippingMethod = $method;
                                }
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } else {
                        $shippingMethods[] = $method;
                    }
                }
                if ($freeShippingMethod !== null) {
                    $shippingMethods = [$freeShippingMethod];
                }
            }
        } else {
            $country = $request->countryId;
            $state_id = $request->stateId;

            $response = Cart::cart_list_cookie($store->id);
            $response = json_decode(json_encode($response));

            $Shipping_zone = ShippingZone::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->where('country_id', $country)->where('state_id', $state_id)->first();

            $shipping_requires = ShippingMethod::Free_shipping();

            $sub_total = $response->data->sub_total;

            if (!empty($Shipping_zone)) {
                $methods = ShippingMethod::where('zone_id', $Shipping_zone->id)->where('theme_id', $theme_id)->where('store_id', $store->id)->get();
                $shippingMethods = [];
                $freeShippingMethod = null;
                foreach ($methods as $method) {
                    if ($method->shipping_requires == '1' || $method->shipping_requires == '3' || $method->shipping_requires == '4') {
                        if ($method->method_name == "Free shipping") {
                            if ($method->cost < $sub_total) {
                                $freeShippingMethod = $method;
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } elseif ($method->shipping_requires == '2' || $method->shipping_requires == '5') {
                        if ($method->method_name == "Free shipping") {
                            if (!empty($coupon)) {
                                if ($method->cost < $sub_total) {
                                    $freeShippingMethod = $method;
                                }
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } else {
                        $shippingMethods[] = $method;
                    }
                }
                if ($freeShippingMethod !== null) {
                    $shippingMethods = [$freeShippingMethod];
                }
            } else {
                $Shipping_zone = ShippingZone::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->where('country_id', '')->where('state_id', '')->first();

                $methods = ShippingMethod::where('zone_id', $Shipping_zone->id)->where('theme_id', $theme_id)->where('store_id', $store->id)->get();

                $shippingMethods = [];
                $freeShippingMethod = null;
                foreach ($methods as $method) {
                    if ($method->shipping_requires == '1' || $method->shipping_requires == '3' || $method->shipping_requires == '4') {
                        if ($method->method_name == "Free shipping") {
                            if ($method->cost < $sub_total) {
                                $freeShippingMethod = $method;
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } elseif ($method->shipping_requires == '2' || $method->shipping_requires == '5') {
                        if ($method->method_name == "Free shipping") {
                            if (!empty($coupon)) {
                                if ($method->cost < $sub_total) {
                                    $freeShippingMethod = $method;
                                }
                            }
                        } else {
                            $shippingMethods[] = $method;
                        }
                    } else {
                        $shippingMethods[] = $method;
                    }
                }
                if ($freeShippingMethod !== null) {
                    $shippingMethods = [$freeShippingMethod];
                }
            }
        }
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id);

        Session::put('shipping_method', $shippingMethods);
        $return['CURRENCY'] = $CURRENCY;
        $return['shipping_method'] = $shippingMethods;
        return response()->json($return);
    }


    public function get_shipping_method(Request $request, $slug)
    {
        $shippingMethods = ShippingMethod::find($request->method_id);

        if (!empty($shippingMethods)) {
            $shipp_name = $shippingMethods->method_name;
            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;

            if ($shipp_name == 'Flat Rate') {
                if (Auth::guest()) {
                    if ($shippingMethods->calculation_type == 1) {

                        $cost_totle = 0;
                        $price = 0;

                        $response = Cart::cart_list_cookie($store->id);
                        $response = json_decode(json_encode($response));

                        $productList = $response->data->product_list;
                        foreach ($productList as $key => $Product) {
                            $productId = $Product->product_id;
                            $product_data = Product::find($productId);
                            if ($product_data->variant_product == 0) {
                                if ($shippingMethods['product_cost'] != null) {
                                    $shippingClass = Shipping::find($product_data->shipping_id);


                                    $value = $shippingMethods['product_cost'];
                                    $product_cost = json_decode($value, true);
                                    if ($shippingClass == null) {
                                        $price  += $product_cost['product_no_cost'];
                                    } else {
                                        foreach ($product_cost['product_cost'] as $key => $value) {
                                            if ($key == $shippingClass->id) {
                                                $price  += $value;
                                            } else {
                                                $price  += 0;
                                            }
                                        }
                                    }
                                } else {
                                    $cost_totle = $shippingMethods->cost;
                                }
                            } 
                            else {
                                if ($shippingMethods['product_cost'] != null) {
                                    $productVariants = [];

                                    foreach ($productList as $item) {
                                        $productId = $item->product_id;
                                        $variantId = $item->variant_id;

                                        if (!isset($productVariants[$productId])) {
                                            $productVariants[$productId] = [];
                                        }
                                        $productVariants[$productId][] = $variantId;
                                    }
                                    $uniqueVariantIds = [];
                                    foreach ($productVariants as $variants) {
                                        $uniqueVariantIds = array_merge($uniqueVariantIds, $variants);
                                    }

                                    $uniqueVariantIds = array_values(array_unique($uniqueVariantIds));
                                    $product_stock = ProductStock::whereIn('id', $uniqueVariantIds)->where('product_id', $Product->product_id)->get();
                                    $value = $shippingMethods['product_cost'];
                                    $product_cost = json_decode($value, true);

                                    foreach ($product_stock as $stock) {
                                        $shippingClass = Shipping::find($stock->shipping);

                                        if ($stock->shipping == 'same_as_parent') {
                                            $shipping = Shipping::find($product_data->shipping_id);
                                            if ($shipping == null) {
                                                $price  += $product_cost['product_no_cost'];
                                            }
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shipping) {
                                                    if ($key == $shipping->id) {
                                                        $price  += $value;
                                                    } else {
                                                        $price  += 0;
                                                    }
                                                }
                                            }
                                        } else {
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shippingClass) {
                                                    if ($key == $shippingClass->id) {
                                                        $price  += $value;
                                                    } else {
                                                        $price  += 0;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $cost_totle = $shippingMethods->cost;
                                }
                            }
                        }
                        $cost_totle = $shippingMethods->cost + $price;
                        // $coupon_amount = Session::get('coupon_price');
                        $coupon_amount = session()->get('coupon_prices');

                        Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);

                        $response_1 = Cart::cart_list_cookie($store->id);
                        $response_1 = json_decode(json_encode($response_1));

                        $sub_total = $response_1->data->sub_total;
                        $tax_price = $response_1->data->tax_price;
                        if ($coupon_amount == '') {

                            $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                        } else {

                            $final_sub_total = $sub_total - $coupon_amount;
                            $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;

                        }
                    } else {
                        $cost_totle = 0;
                        $price = 0;
                        $response = Cart::cart_list_cookie($store->id);
                        $response = json_decode(json_encode($response));

                        $productList = $response->data->product_list;
                        foreach ($productList as $key => $Product) {
                            $product_data = Product::find($Product->product_id);
                            if ($product_data->variant_product == 0) {
                                if ($shippingMethods['product_cost'] != null) {
                                    $value = $shippingMethods['product_cost'];
                                    $product_cost = json_decode($value, true);

                                    $shippingClass = Shipping::find($product_data->shipping_id);

                                    $currentPrice = 0;
                                    if ($shippingClass == null) {
                                        $currentPrice  += $product_cost['product_no_cost'];
                                    } else {
                                        foreach ($product_cost['product_cost'] as $key => $value) {
                                            if ($shippingClass) {
                                                if ($key == $shippingClass->id) {
                                                    $currentPrice += $value;
                                                } else {
                                                    $currentPrice += 0;
                                                }
                                            }
                                        }
                                    }
                                    if ($currentPrice > $price) {
                                        $price = $currentPrice;
                                    }
                                } else {
                                    $price = $shippingMethods->cost;
                                }
                            } else {
                                if ($shippingMethods['product_cost'] != null) {
                                    foreach ($productList as $item) {
                                        $productId = $item->product_id;
                                        $variantId = $item->variant_id;

                                        if (!isset($productVariants[$productId])) {
                                            $productVariants[$productId] = [];
                                        }
                                        $productVariants[$productId][] = $variantId;
                                    }
                                    $uniqueVariantIds = [];
                                    foreach ($productVariants as $variants) {
                                        $uniqueVariantIds = array_merge($uniqueVariantIds, $variants);
                                    }

                                    $uniqueVariantIds = array_values(array_unique($uniqueVariantIds));
                                    $product_stock = ProductStock::whereIn('id', $uniqueVariantIds)->where('product_id', $Product->product_id)->get();

                                    $value = $shippingMethods['product_cost'];
                                    $product_cost = json_decode($value, true);
                                    foreach ($product_stock  as $stock) {
                                        $shippingClass = Shipping::find($stock->shipping);
                                        $currentPrice = 0;
                                        if ($stock->shipping == 'same_as_parent') {
                                            $shipping = Shipping::find($product_data->shipping_id);
                                            if ($shipping == null) {
                                                $currentPrice  += $product_cost['product_no_cost'];
                                            }
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shipping) {
                                                    if ($key == $shipping->id) {
                                                        $currentPrice  += $value;
                                                    } else {
                                                        $currentPrice  += 0;
                                                    }
                                                }
                                            }
                                        } else {
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shippingClass) {
                                                    if ($key == $shippingClass->id) {
                                                        $currentPrice += $value;
                                                    } else {
                                                        $currentPrice += 0;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if ($currentPrice > $price) {
                                        $price = $currentPrice;
                                    }
                                } else {
                                    $cost_totle = $shippingMethods->cost;
                                }
                            }
                        }
                        $cost_totle = $shippingMethods->cost + $price;


                        // $coupon_amount = Session::get('coupon_price');
                        $coupon_amount = session()->get('coupon_prices');


                        Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);

                        $response = Cart::cart_list_cookie($store->id);
                        $response = json_decode(json_encode($response));

                        $sub_total = $response->data->sub_total;
                        $tax_price = $response->data->tax_price;
                        if ($coupon_amount == '') {
                            $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                        } else {
                            $final_sub_total = $sub_total - $coupon_amount;
                            $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;
                        }
                    }
                } else {
                    $request->merge(['user_id' => Auth::user()->id, 'store_id' => $store->id, 'slug' => $slug, 'theme_id' => $theme_id]);
                    $Products = Cart::where('user_id', $request->user_id)->where('theme_id', $theme_id)->where('store_id', $store->id)->orderBy('id', 'desc')->pluck('product_id')->toArray();
                    $product_data = Product::whereIn('id', $Products)->get();

                    if ($shippingMethods->calculation_type == 1) {
                        $cost_totle = 0;
                        $price = 0;
                        foreach ($product_data as $key => $Product) {
                            if ($Product->variant_product == 0) {
                                if ($shippingMethods['product_cost'] != null) {
                                    $shippingClass = Shipping::find($Product->shipping_id);

                                    $value = $shippingMethods['product_cost'];
                                    $product_cost = json_decode($value, true);
                                    if ($shippingClass == null) {
                                        $price  += $product_cost['product_no_cost'];
                                    } else {
                                        foreach ($product_cost['product_cost'] as $key => $value) {
                                            if ($key == $shippingClass->id) {
                                                $price  += $value;
                                            } else {
                                                $price  += 0;
                                            }
                                        }
                                    }
                                } else {
                                    $cost_totle = $shippingMethods->cost;
                                }
                            } else {

                                if ($shippingMethods['product_cost'] != null) {

                                    $cart_variant = Cart::where('user_id', $request->user_id)->where('theme_id', $theme_id)->where('store_id', $store->id)->where('product_id', $Product->id)->pluck('variant_id')->toArray();

                                    $product_stock = ProductStock::whereIn('id', $cart_variant)->get();
                                    $value = $shippingMethods['product_cost'];
                                    $product_cost = json_decode($value, true);

                                    foreach ($product_stock  as $stock) {
                                        $shippingClass = Shipping::find($stock->shipping);

                                        if ($stock->shipping == 'same_as_parent') {
                                            $shipping = Shipping::find($Product->shipping_id);
                                            if ($shipping == null) {
                                                $price  += $product_cost['product_no_cost'];
                                            }
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shipping) {
                                                    if ($key == $shipping->id) {
                                                        $price  += $value;
                                                    } else {
                                                        $price  += 0;
                                                    }
                                                }
                                            }
                                        } else {
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shippingClass) {
                                                    if ($key == $shippingClass->id) {
                                                        $price  += $value;
                                                    } else {
                                                        $price  += 0;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $cost_totle = $shippingMethods->cost;
                                    // $total_shipping_price = $sub_total += $tax_price;
                                }
                            }
                        }
                        $cost_totle = $shippingMethods->cost + $price;
                        // $coupon_amount = Session::get('coupon_price');
                        $coupon_amount = session()->get('coupon_prices');

                        Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);

                        $api = new ApiController();
                        $data = $api->cart_list($request);
                        $response = $data->getData();
                        $sub_total = $response->data->sub_total;
                        $tax_price = $response->data->tax_price;

                        if ($coupon_amount == '') {
                            $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                        } else {
                            $final_sub_total = $sub_total - $coupon_amount;
                            $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;
                        }
                    } else {
                        $cost_totle = 0;
                        $price = 0;
                        foreach ($product_data as $key => $Product) {

                            if ($Product->variant_product == 0) {
                                if ($shippingMethods['product_cost'] != null) {
                                    $value = $shippingMethods['product_cost'];
                                    $product_cost = json_decode($value, true);
                                    $shippingClass = Shipping::find($Product->shipping_id);

                                    $currentPrice = 0;
                                    if ($shippingClass == null) {
                                        $currentPrice  += $product_cost['product_no_cost'];
                                    } else {
                                        foreach ($product_cost['product_cost'] as $key => $value) {
                                            if ($shippingClass) {
                                                if ($key == $shippingClass->id) {
                                                    $currentPrice += $value;
                                                } else {
                                                    $currentPrice += 0;
                                                }
                                            }
                                        }
                                    }
                                    if ($currentPrice > $price) {
                                        $price = $currentPrice;
                                    }
                                } else {
                                    $price = $shippingMethods->cost;
                                }
                            } else {
                                if ($shippingMethods['product_cost'] != null) {
                                    $cart_variant = Cart::where('user_id', $request->user_id)->where('theme_id', $theme_id)->where('store_id', $store->id)->where('product_id', $Product->id)->pluck('variant_id')->toArray();
                                    $product_stock = ProductStock::whereIn('id', $cart_variant)->get();
                                    $value = $shippingMethods['product_cost'];

                                    $product_cost = json_decode($value, true);
                                    foreach ($product_stock  as $stock) {
                                        $shippingClass = Shipping::find($stock->shipping);
                                        $currentPrice = 0;
                                        if ($stock->shipping == 'same_as_parent') {
                                            $shipping = Shipping::find($Product->shipping_id);
                                            if ($shipping == null) {
                                                $currentPrice  += $product_cost['product_no_cost'];
                                            }
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shipping) {
                                                    if ($key == $shipping->id) {
                                                        $currentPrice  += $value;
                                                    } else {
                                                        $currentPrice  += 0;
                                                    }
                                                }
                                            }
                                        } else {
                                            foreach ($product_cost['product_cost'] as $key => $value) {
                                                if ($shippingClass) {
                                                    if ($key == $shippingClass->id) {
                                                        $currentPrice += $value;
                                                    } else {
                                                        $currentPrice += 0;
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if ($currentPrice > $price) {
                                        $price = $currentPrice;
                                    }
                                } else {
                                    $price = $shippingMethods->cost;
                                }
                            }
                        }

                        $cost_totle = $price + $shippingMethods->cost;
                        // $coupon_amount = Session::get('coupon_price');
                        $coupon_amount = session()->get('coupon_prices');

                        Session::forget('coupon_price');
                        Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);

                        $api = new ApiController();
                        $data = $api->cart_list($request);
                        $response = $data->getData();
                        $sub_total = $response->data->sub_total;
                        $tax_price = $response->data->tax_price;

                        if ($coupon_amount == '') {
                            $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                        } else {
                            $final_sub_total = $sub_total - $coupon_amount;
                            $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;
                        }
                    }
                }
            } elseif ($shipp_name == 'Local pickup') {
                if (Auth::guest()) {

                    $cost_totle = $shippingMethods->cost;
                    // $coupon_amount = Session::get('coupon_price');
                    $coupon_amount = session()->get('coupon_prices');


                    Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);

                    $response = Cart::cart_list_cookie($store->id);
                    $response = json_decode(json_encode($response));

                    $sub_total = $response->data->sub_total;
                    $tax_price = $response->data->tax_price;

                    if ($coupon_amount == '') {
                        $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                    } else {
                        $final_sub_total = $sub_total - $coupon_amount;
                        $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;
                    }
                } else {
                    $request->merge(['user_id' => Auth::user()->id, 'store_id' => $store->id, 'slug' => $slug, 'theme_id' => $theme_id]);
                    $Products = Cart::where('user_id', $request->user_id)->where('theme_id', $theme_id)->where('store_id', $store->id)->orderBy('id', 'desc')->pluck('product_id')->toArray();
                    $product_data = Product::whereIn('id', $Products)->get();

                    $cost_totle = $shippingMethods->cost;
                    // $coupon_amount = Session::get('coupon_price');
                    $coupon_amount = session()->get('coupon_prices');


                    Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);
                    $api = new ApiController();
                    $data = $api->cart_list($request);
                    $response = $data->getData();

                    $sub_total = $response->data->sub_total;
                    $tax_price = $response->data->tax_price;

                    if ($coupon_amount == '') {
                        $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                    } else {
                        $final_sub_total = $sub_total - $coupon_amount;
                        $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;
                    }
                }
            } else {
                if (Auth::guest()) {
                    $cost_totle = 0;

                    // $coupon_amount = Session::get('coupon_price');
                    $coupon_amount = session()->get('coupon_prices');


                    Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);

                    $response = Cart::cart_list_cookie($store->id);
                    $response = json_decode(json_encode($response));

                    $sub_total = $response->data->sub_total;
                    $tax_price = $response->data->tax_price;
                    if ($coupon_amount == '') {
                        $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                    } else {
                        $final_sub_total = $sub_total - $coupon_amount;
                        $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;
                    }
                } else {
                    $cost_totle = 0;

                    // $coupon_amount = Session::get('coupon_price');
                    $coupon_amount = session()->get('coupon_prices');

                    Session::put('request_data', $cost_totle, 'coupon_price', $coupon_amount);

                    $request->merge(['user_id' => Auth::user()->id, 'store_id' => $store->id, 'slug' => $slug, 'theme_id' => $theme_id]);
                    $api = new ApiController();
                    $data = $api->cart_list($request);
                    $response_1 = $data->getData();

                    $sub_total = $response_1->data->sub_total;
                    $tax_price = $response_1->data->tax_price;
                    
                    if ($coupon_amount == '') {
                        $total_shipping_price = $sub_total + $tax_price + $cost_totle;
                    } else {
                        $final_sub_total = $sub_total - $coupon_amount;
                        $total_shipping_price = $final_sub_total + $tax_price + $cost_totle;
                    }
                }
            }
            $price = $cost_totle;
            $total_price = $total_shipping_price;
            // dd($total_shipping_price);
            $return['shipping_final_price'] = $price;
            $return['shipping_total_price'] = $total_price;
            $return['final_tax_price'] = $tax_price;

            $return['message'] = 'Add Shipping success';
            return response()->json($return);
        }
    }

    public function abandon_carts_handled(Request $request)
    {
        if (\Auth::user()->can('Manage Cart')) {
            $abandon_cart = Cart::where('theme_id', $this->APP_THEME)->where('store_id', $this->store->id)->groupBy('user_id')->get();
            return view('cart.index', compact('abandon_cart'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function abandon_carts_show($cartId)
    {
        if (\Auth::user()->can('Show Cart')) {

            $cart = Cart::find($cartId);
            $user_id = $cart->user_id;
            $cart_product = Cart::where('user_id', $user_id)->where('theme_id', APP_THEME())->get();
            return view('cart.show', compact('cart_product'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function abandon_carts_destroy($cartId)
    {
        if (\Auth::user()->can('Delete Cart')) {
            $cart = Cart::find($cartId);
            $cart->delete();

            return redirect()->back()->with('error', __('Cart delete successfully'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function abandon_carts_emailsend(Request $request)
    {

        if (\Auth::user()->can('Abandon Cart')) {
            $cart  = Cart::find($request->cart_id);
            $user_id = $cart->user_id;
            $cart_product = Cart::where('user_id', $user_id)->where('theme_id', APP_THEME())->get();
            $email = $cart->UserData->email;

            $store = Store::where('id', getCurrentStore())->first();
            $owner = Admin::find($store->created_by);
            $product_id    = Crypt::encrypt($cart->product_id);


            try {
                $dArr = Cart::where('user_id', $user_id)->where('theme_id', APP_THEME())->get();

                $order_id = 1;
                $resp  = Utility::sendEmailTemplate('Abandon Cart', $email, $dArr, $owner, $store, $product_id,$user_id);



                // $return = 'Mail send successfully';
                if($resp['is_success'] == false)
                {
                    return response()->json(
                        [
                            'is_success' => false,
                            'message' => $resp['error'],
                        ]
                    );
                }
                else
                {
                    return response()->json(
                        [
                            'is_success' => true,
                            'message' => 'Mail send successfully',
                        ]
                    );
                }
            } catch (\Exception $e) {

                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                return response()->json(
                    [
                        'is_success' => false,
                        'message' => $smtp_error,
                    ]
                );
            }

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function abandon_carts_messsend(Request $request){
        $cart  = Cart::find($request->cart_id);
        $user_id = $cart->user_id;
        $mobile = $cart->UserData;
        if (\Auth::user()->can('Abandon Cart')) {

            try {
                $dArr = Cart::where('user_id', $user_id)->where('theme_id', APP_THEME())->pluck('product_id')->toArray();

                $product = [];
                foreach ($dArr as $item) {
                    $product[] = Product::where('id', $item)->pluck('name')->first();
                }
                $product_name = implode(',',$product);
                $store = Store::where('id', getCurrentStore())->first();
                $msg = __("We noticed that you recently visited our $store->name site and added some fantastic items to your shopping cart. We are thrilled that you found products you love! However, it seems like you did not finish your purchase.You finish your order process as soon as possible, Added Product name : $product_name");
                $resp  = Utility::SendMsgs('Abandon Cart', $mobile, $msg);


                // $return = 'Mail send successfully';
                if($resp  == false)
                {
                    return response()->json(
                        [
                            'is_success' => false,
                            'message' => "Invalid Auth access token - Cannot parse access token",
                        ]
                    );
                }
                else
                {
                    return response()->json(
                        [
                            'is_success' => true,
                            'message' => 'Message send successfully',
                        ]
                    );
                }
            } catch (\Exception $e) {

                $smtp_error = __('Invalid Auth access token - Cannot parse access token');
                return response()->json(
                    [
                        'is_success' => false,
                        'message' => $smtp_error,
                    ]
                );
            }

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
