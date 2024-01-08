<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Http\Controllers\Api\ApiController;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Utility;
use App\Models\OrderBillingDetail;
use App\Models\OrderCouponDetail;
use App\Models\OrderTaxDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStock;
use App\Models\Setting;
use App\Models\UserAdditionalDetail;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Models\Admin;
use App\Models\Plan;
use Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
use App\Models\ActivityLog;
use App\Models\Coupon;
use App\Models\OrderNote;
use App\Models\DeliveryBoy;

class OrderController extends Controller
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
        if (\Auth::user()->can('Manage Orders')) {
            $id = Auth::user()->id;
            $orders = Order::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();
            return view('order.index', compact('orders'));
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
        // return view('order.create');
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order,$id)
    {
        //
        $id = Crypt::decrypt($id);
        $order = Order::order_detail($id);
        $orders = Order::find($id);
        return view('order.order_show',compact('order','orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if (\Auth::user()->can('Delete Orders')) {
            OrderTaxDetail::where('order_id', $order->id)->delete();
            OrderCouponDetail::where('order_id', $order->id)->delete();
            OrderBillingDetail::where('order_id', $order->id)->delete();
            Order::where('id', $order->id)->delete();
            return redirect()->back()->with('success', __('Order Delete succefully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function order_view(Request $request, $id)
    {
        if (\Auth::user()->can('Show Orders')) {
            try {
                $id = Crypt::decrypt($id);
                $order = Order::order_detail($id);
                $order_notes = OrderNote::where('order_id',$id)->where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();
                $store = Store::where('id' ,getCurrentStore())->first();
                $deliveryboys = DeliveryBoy::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('name', 'id')->prepend('Assign to deliveryboy',"");

                if (!empty($order['message'])) {
                    return redirect()->back()->with('error', __('Order Not Found.'));
                }
                return view('order.view', compact('order','store','order_notes','deliveryboys'));
            } catch (DecryptException $e) {
                return redirect()->back()->with('error', __('Something was wrong.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function order_status_change(Request $request)
    {
        $data['order_id'] = $request->id;
        $data['order_status'] = $request->delivered;

        $responce = Order::order_status_change($data);
        $order = Order::order_detail($data['order_id']);
        $d_order = Order::find($data['order_id']);
        $store = Store::where('id', $d_order->store_id)->first();
        $dArr  = [
            'order_id' => $data['order_id'],
            'order_status' => $data['order_status']
        ];
        $owner= Admin::find($store->created_by);
        try
        {
            $order_id = Crypt::encrypt($data['order_id']);
            $resp  = Utility::sendEmailTemplate('Status Change', $order['delivery_informations']['email'], $dArr,$owner, $store, $order_id);
        }
        catch(\Exception $e)
        {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        }
        OrderNote::order_note_data([
            'user_id' => $d_order->user_id,
            'order_id' => $request->id,
            'status' => 'Order status change',
            'changeble_status' => $request->delivered,
            'theme_id' => $store->theme_id,
            'store_id' => $d_order->store_id
        ]);
        try
        {
            $mobile_no =$order['delivery_informations']['phone'];
            $msg = __("Hello, Welcome to $store->name .Your Order is $request->delivered, !Hi $request->id, Thank you for Shopping");

            $resp  = Utility::SendMsgs('Status Change', $mobile_no, $msg);
        }
        catch(\Exception $e)
        {
            $smtp_error = __('Invalid OAuth access token - Cannot parse access token');
        }

        if ($responce['status'] == 'success') {
            $module = 'Status Change';
            $store = Store::find(getCurrentStore());
            $webhook =  Utility::webhook($module, $store->id);
            if ($webhook) {
                $order = Order::order_detail($request->id);
                $parameter = json_encode($order);

                // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                if ($status != true) {
                    $msgs  = 'Webhook call failed.';
                }
            }

            $return['status'] = 'success';
            $return['message'] = $responce['message']. ((isset($msgs)) ? '<br> <span class="text-danger">' . $msgs . '</span>' : '');
            return response()->json($return);
        } else {
            $return['status'] = 'error';
            $return['message'] = $responce['message'];
            return response()->json($return);
        }

    }

    public function order_return(Request $request)
    {
        $data['product_id'] = $request->product_id;
        $data['variant_id'] = $request->variant_id;
        $data['order_id']   = $request->order_id;

        $responce = Order::product_return($data);
        if ($responce['status'] == 'success') {
            $return['status'] = 'success';
            $return['message'] = $responce['message'];
            return response()->json($return);
        } else {
            $return['status'] = 'error';
            $return['message'] = $responce['message'];
            return response()->json($return);
        }
    }

    public function order_return_request(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $order = Order::find($id);
        if (!empty($order)) {
            if ($status == 2) {
                $product_json = json_decode($order->product_json, true);
                foreach ($product_json as $key => $product) {
                    $product_id = $product['product_id'];
                    $variant_id = $product['variant_id'];
                    if ($variant_id == 0 || empty($variant_id)) {
                        $product = Product::find($product_id);
                        if (!empty($product)) {
                            $product->product_stock += $product['qty'];
                            $product->save();
                        }
                    } else {
                        $ProductStock = ProductStock::where('product_id', $product_id)->where('id', $variant_id)->first();
                        if (!empty($ProductStock)) {
                            $ProductStock->stock += $product['qty'];
                            $ProductStock->save();
                        }
                    }
                }
            }
            $order->return_price = $order->final_price;
            $order->return_status = $status;
            $order->save();
        }

        $return['message'] = __('Return request approve successfully');
        if ($status == 3) {
            $return['message'] = __('Return request reject successfully');
        }
        return response()->json($return);
    }

    public function place_order(Request $request, $slug)
    {

        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $user = Admin::where('type', 'admin')->first();
        if ($user->type == 'admin') {
            $plan = Plan::find($user->plan);
        }

        $theme_id = $this->APP_THEME;
        $param['user_id'] = Auth::user()->id;
        $param['theme_id'] = $this->APP_THEME;
        $param['slug'] = $slug;
        $param['store_id'] = $store->id;

        $request->merge($param);

        $ApiController = new ApiController();
        $param['coupon_info'] = [];
        if (!empty($request->coupon_code)) {
            $ApiController = new ApiController();
            $apply_coupon_data = $ApiController->apply_coupon($request);

            $apply_coupon = $apply_coupon_data->getData();

            if ($apply_coupon->status == 1) {
                $param['coupon_info']['coupon_id'] = $apply_coupon->data->id;
                $param['coupon_info']['coupon_name'] = $apply_coupon->data->name;
                $param['coupon_info']['coupon_code'] = $apply_coupon->data->code;
                $param['coupon_info']['coupon_discount_type'] = $apply_coupon->data->coupon_discount_type;
                $param['coupon_info']['coupon_discount_number'] = $apply_coupon->data->coupon_discount_amount;
                $param['coupon_info']['coupon_discount_amount'] = $apply_coupon->data->amount;
                $param['coupon_info']['coupon_final_amount'] = $apply_coupon->data->final_price;

                $request->merge($param);
            }
        }

        if ($request->payment_type == 'stripe' || $request->payment_type == 'paystack' || $request->payment_type == 'mercado' || $request->payment_type == 'skrill' || $request->payment_type ==     'paymentwall' || $request->payment_type == 'Razorpay' || $request->payment_type == 'paypal' || $request->payment_type == 'flutterwave' || $request->payment_type == 'paytm' || $request->payment_type == 'mollie' || $request->payment_type == 'coingate' || $request->payment_type == 'toyyibpay' || $request->payment_type == 'Sspay' || $request->payment_type == 'Paytabs' || $request->payment_type == 'iyzipay' || $request->payment_type == 'payfast' || $request->payment_type == 'benefit' || $request->payment_type == 'cashfree' || $request->payment_type == 'aamarpay' || $request->payment_type == 'telegram' || $request->payment_type == 'whatsapp' || $request->payment_type == 'paytr' || $request->payment_type == 'yookassa' || $request->payment_type == 'Xendit' || $request->payment_type == 'midtrans') {

            $billing = $request->billing_info;

            if (empty($billing['firstname'])) {
                return redirect()->back()->with('error', __('Billing first name not found.'));
            }
            if (empty($billing['lastname'])) {
                return redirect()->back()->with('error', __('Billing last name not found.'));
            }
            if (empty($billing['email'])) {
                return redirect()->back()->with('error', __('Billing email not found.'));
            }
            if (empty($billing['billing_user_telephone'])) {
                return redirect()->back()->with('error', __('Billing telephone not found.'));
            }
            if (empty($billing['billing_address'])) {
                return redirect()->back()->with('error', __('Billing address not found.'));
            }
            if (empty($billing['billing_postecode'])) {
                return redirect()->back()->with('error', __('Billing postecode not found.'));
            }
            if (empty($billing['billing_country'])) {
                return redirect()->back()->with('error', __('Billing country not found.'));
            }
            if (empty($billing['billing_state'])) {
                return redirect()->back()->with('error', __('Billing state not found.'));
            }
            if (empty($billing['billing_city'])) {
                return redirect()->back()->with('error', __('Billing city not found.'));
            }
            if (empty($billing['delivery_address'])) {
                return redirect()->back()->with('error', __('Delivery address not found.'));
            }
            if (empty($billing['delivery_postcode'])) {
                return redirect()->back()->with('error', __('Delivery postcode not found.'));
            }
            if (empty($billing['delivery_country'])) {
                return redirect()->back()->with('error', __('Delivery country not found.'));
            }
            if (empty($billing['delivery_state'])) {
                return redirect()->back()->with('error', __('Delivery state not found.'));
            }
            if (empty($billing['delivery_city'])) {
                return redirect()->back()->with('error', __('Delivery city not found.'));
            }

            $cartlist_final_price = 0;
            $final_price = 0;


            if (Auth::guest()) {

                $response = Cart::cart_list_cookie($store->id);
                $response = json_decode(json_encode($response));
                $cartlist = (array)$response->data;

                if (empty($cartlist['product_list'])) {
                    return redirect()->back()->with('error', 'Cart is empty.');
                }

                $cartlist_final_price = !empty($cartlist['final_price']) ? $cartlist['final_price'] : 0;
                $final_sub_total_price = !empty($cartlist['total_sub_price']) ? $cartlist['total_sub_price'] : 0;
                // $final_price = $cartlist['final_price'] - $cartlist['tax_price'];
                $final_price = $response->data->total_final_price;
                // $billing = json_decode($request->billing_info, true);
                $billing = $request->billing_info;
                $taxes = $cartlist['tax_info'];
                $products = $cartlist['product_list'];
            } elseif (!empty($request->user_id)) {
                $cart_list['user_id']   = $request->user_id;
                $request->request->add($cart_list);

                $cart_lists = new ApiController();
                $cartlist_response = $cart_lists->cart_list($request);
                $cartlist = (array)$cartlist_response->getData()->data;
                if (empty($cartlist['product_list'])) {
                    return redirect()->back()->with('error', 'Cart is empty.');
                }
                $cartlist_final_price = !empty($cartlist['final_price']) ? $cartlist['final_price'] : 0;
                $final_sub_total_price = !empty($cartlist['total_sub_price']) ? $cartlist['total_sub_price'] : 0;
                // $final_price = $cartlist['final_price'] - $cartlist['tax_price'];
                $final_price = $cartlist['total_final_price'];
                // $billing = json_decode($request->billing_info, true);
                $billing = $request->billing_info;
                $taxes = $cartlist['tax_info'];
                $products = $cartlist['product_list'];
            } else {
                return redirect()->back()->with('error', 'User not found.');
            }


            $coupon_price = 0;
            // coupon api call
            if (!empty($request->coupon_info)) {
                // $coupon_data = json_decode($request->coupon_info, true);
                $coupon_data = $request->coupon_info;
                $apply_coupon = [
                    'coupon_code' => $coupon_data['coupon_code'],
                    'sub_total' => $cartlist_final_price
                ];
                $request->request->add($apply_coupon);
                $coupon_apply = new ApiController();
                $apply_coupon_response = $coupon_apply->apply_coupon($request);
                $apply_coupon = (array)$apply_coupon_response->getData()->data;


                $order_array['coupon']['message'] = $apply_coupon['message'];
                $order_array['coupon']['status'] = false;
                if (!empty($apply_coupon['final_price'])) {
                    $cartlist_final_price = $apply_coupon['final_price'];
                    $coupon_price = $apply_coupon['amount'];
                    $order_array['coupon']['status'] = true;
                }
            }


            // $delivery_price = 0;
            // // dilivery api call
            // if (!empty($request->delivery_id)) {
            //     $delivery_charge = [
            //         'price' => $cartlist_final_price,
            //         'shipping_id' => $request->delivery_id
            //     ];

            //     $request->request->add($delivery_charge);
            //     $delivery_charges = new ApiController();
            //     $delivery_charge_response = $delivery_charges->delivery_charge($request);
            //     $delivery_charge = (array)$delivery_charge_response->getData()->data;
            //     $cartlist_final_price = $delivery_charge['final_price'];
            //     $delivery_price = $delivery_charge['charge_price'];
            // } else {
            //     return redirect()->back()->with('error', 'Delivery type not found');
            // }

            // dilivery api call
            $delivery_price = 0;
            if ($plan->shipping_method == 'on') {
                if (!empty($request->method_id)) {
                    $del_charge = new CartController();
                    $delivery_charge = $del_charge->get_shipping_method($request, $slug);
                    $content = $delivery_charge->getContent();
                    $data = json_decode($content, true);
                    $delivery_price = $data['shipping_final_price'];
                    $tax_price = $data['final_tax_price'];
                } else {
                    return $this->error(['message' => 'Shipping Method not found']);
                }
            } else {
                $tax_price = 0;
                if (!empty($taxes)) {
                    foreach ($taxes as $key => $tax) {
                        $tax_price += $tax->tax_price;
                    }
                }
            }



            // $prodduct_id_array = [];
            // if (!empty($products)) {
            //     foreach ($products as $key => $product) {
            //         $prodduct_id_array[] = $product->product_id;

            //         $product_id = $product->product_id;
            //         $variant_id = $product->variant_id;
            //         $qtyy = !empty($product->qty) ? $product->qty : 0;

            //         $Product = Product::where('id', $product_id)->first();
            //         if (!empty($product_id) && !empty($variant_id) && $product_id != 0 && $variant_id != 0) {
            //             $ProductStock = ProductStock::where('id', $variant_id)->where('product_id', $product_id)->first();
            //             if (!empty($ProductStock)) {
            //                 $remain_stock = $ProductStock->stock - $qtyy;
            //                 $ProductStock->stock = $remain_stock;
            //                 $ProductStock->save();
            //             } else {
            //                 return redirect()->back()->with('error', 'Product not found .');
            //             }
            //         } elseif (!empty($product_id) && $product_id != 0) {
            //             if (!empty($Product)) {
            //                 $remain_stock = $Product->product_stock - $qtyy;
            //                 $Product->product_stock = $remain_stock;
            //                 $Product->save();
            //             } else {
            //                 return redirect()->back()->with('error', 'Product not found .');
            //             }
            //         } else {
            //             return redirect()->back()->with('error', 'Please fill proper product json field .');
            //         }

            //         // remove from cart
            //         // Cart::where('user_id', $request->user_id)->where('product_id', $product_id)->where('variant_id', $variant_id)->delete();
            //     }
            // }

            if (!empty($prodduct_id_array)) {
                $prodduct_id_array = $prodduct_id_array = array_unique($prodduct_id_array);
                $prodduct_id_array = implode(',', $prodduct_id_array);
            } else {
                $prodduct_id_array = '';
            }

            // $tax_price = 0;
            // if (!empty($taxes)) {
            //     foreach ($taxes as $key => $tax) {
            //         $tax_price += $tax->tax_price;
            //     }
            // }

            // $tax_price = $data['final_tax_price'];

            $new_array['cartlist_final_price'] = $cartlist_final_price;
            $new_array['cartlist'] = $cartlist;
            $request->merge($new_array);


            $product_reward_point = Utility::reward_point_count($cartlist_final_price, $theme_id);

            $new_array['billing_info'] = json_encode($request->billing_info);
            $request->merge($new_array);

            if ($request->payment_type == 'stripe') {
                $place_order_api = new StripePaymentController();
                $place_order_data = $place_order_api->stripePost($request);
                // dd($place_order_data->url);
                // dd($place_order_data->url);
                return new RedirectResponse($place_order_data->url);
            } elseif ($request->payment_type == 'paystack') {
                $place_order_api = new PaystackPaymentController();
                $place_order_data = $place_order_api->payWithPaystack($request);
                $data = $request;
                $store    = Store::where('slug', $request->slug)->first();
                $admin_payment_setting = Utility::getAdminPaymentSetting($store->id);

                return view('payment.paystack', compact('place_order_data', 'data', 'store', 'admin_payment_setting'));
            } elseif ($request->payment_type == 'mercado') {
                $place_order_api = new MercadoPaymentController();
                $place_order_data = $place_order_api->PayWithMercado($request);
                $url = json_decode($place_order_data->content(), true)['url'];

                return new RedirectResponse($url);
            } elseif ($request->payment_type == 'skrill') {
                $place_order_api = new SkrillPaymentController();
                $place_order_data = $place_order_api->payWithSkrill($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'paymentwall') {
                $place_order_api = new PaymentWallPaymentController();
                $place_order_data = $place_order_api->orderindex($request);
                $data = $request;

                return view('payment.paymentwall', compact('place_order_data', 'data'));
            } elseif ($request->payment_type == 'Razorpay') {
                $place_order_api = new RazorpayPaymentController();
                $place_order_data = $place_order_api->payWithRazorpay($request);
                $data = $request;

                return view('payment.razorpay', compact('place_order_data', 'data'));
            } elseif ($request->payment_type == 'paypal') {
                $place_order_api = new PaypalPaymentController();
                $place_order_data = $place_order_api->PayWithPaypal($request);

                return new RedirectResponse($place_order_data->getTargetUrl());
            } elseif ($request->payment_type == 'flutterwave') {
                $place_order_api = new flutterwaveController();
                $place_order_data = $place_order_api->flutterwavePost($request);

                return view('payment.flutterwave', compact('place_order_data'));
            } elseif ($request->payment_type == 'paytm') {
                $email = json_decode($request->request->get('billing_info'), true)['email'];
                $firstname = json_decode($request->request->get('billing_info'), true)['firstname'];
                $billing_user_telephone = json_decode($request->request->get('billing_info'), true)['billing_user_telephone'];
                $slug = !empty($request->slug) ? $request->slug : '';
                $store = Store::where('slug', $slug)->first();


                $theme_id = $request->theme_id;

                $paytm_mode = \App\Models\Utility::GetValueByName('paytm_mode', $theme_id);
                $paytm_merchant_id = \App\Models\Utility::GetValueByName('paytm_merchant_id', $theme_id);
                $paytm_merchant_key = \App\Models\Utility::GetValueByName('paytm_merchant_key', $theme_id);
                $paytm_industry_type = \App\Models\Utility::GetValueByName('paytm_industry_type', $theme_id);
                $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id);
                $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id);
                $cutomer  = User::where('type', 'customer')->where('store_id', $store->id)->where('theme_id', $theme_id)->get()->count();
                $user = $cutomer + 1;
                // $orderID = $request->user_id . date('YmdHis');
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                $cartlist_final_price = $request->cartlist_final_price;
                config(
                    [
                        'services.paytm-wallet.env' => isset($paytm_mode) ? $paytm_mode : '',
                        'services.paytm-wallet.merchant_id' => isset($paytm_merchant_id) ? $paytm_merchant_id : '',
                        'services.paytm-wallet.merchant_key' => isset($paytm_merchant_key) ? $paytm_merchant_key : '',
                        'services.paytm-wallet.merchant_website' => 'WEBSTAGING',
                        'services.paytm-wallet.channel' => 'WEB',
                        'services.paytm-wallet.industry_type' => isset($paytm_industry_type) ? $paytm_industry_type : '',
                    ]
                );

                try {

                    $payment = PaytmWallet::with('receive');
                    $payment->prepare(
                        [
                            'order' => date('Y-m-d') . '-' . strtotime(date('Y-m-d H:i:s')),
                            'user' => Auth::user()->id,
                            'mobile_number' => $billing_user_telephone,
                            'email' => $email,
                            'amount' => $cartlist_final_price,
                            'callback_url' => route('store.payment.paytm', $slug),

                        ]
                    );

                    Session::put('request_data', $request->all());
                    return $payment->receive();
                } catch (\Exception $e) {
                    return redirect()->route('checkout')->with('error', __($e->getMessage()));
                }
            } elseif ($request->payment_type == 'mollie') {
                $place_order_api = new MolliePaymentController();
                $place_order_data = $place_order_api->PayWithmollie($request);
                return new RedirectResponse($place_order_data->getTargetUrl());
            } elseif ($request->payment_type == 'coingate') {
                $place_order_api = new CoingateController();
                $place_order_data = $place_order_api->PayWithcoingate($request);

                if (!empty($place_order_data) && $place_order_data->status == 0) {
                    return redirect()->back()->with('error', $place_order_data['data']['message']);
                }
                return new RedirectResponse($place_order_data->payment_url);
            } elseif ($request->payment_type == 'Sspay') {
                $place_order_api = new SspayController();
                $place_order_data = $place_order_api->PayWithSspay($request);

                $response = $place_order_data;
                $location = $response->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'toyyibpay') {
                $place_order_api = new ToyyibpayController();
                $place_order_data = $place_order_api->PayWithtoyyibpay($request);

                $response = $place_order_data;
                $location = $response->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'Paytabs') {
                $place_order_api = new PaytabsController();
                $place_order_data = $place_order_api->PayWithPaytabs($request);
                return new RedirectResponse($place_order_data->getTargetUrl());
            } elseif ($request->payment_type == 'iyzipay') {
                $place_order_api = new IyziPayController();
                $place_order_data = $place_order_api->PayWithIyzipay($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'payfast') {
                $place_order_api = new PayFastController();
                $store = Store::where('slug', $slug)->first();
                $theme_id = $store->theme_id;
                $other_info = json_decode($request->billing_info);


                $payfast_merchant_id = \App\Models\Utility::GetValueByName('payfast_merchant_id', $theme_id);
                $payfast_salt_passphrase = \App\Models\Utility::GetValueByName('payfast_salt_passphrase', $theme_id);
                $payfast_merchant_key = \App\Models\Utility::GetValueByName('payfast_merchant_key', $theme_id);
                $payfast_mode = \App\Models\Utility::GetValueByName('payfast_mode', $theme_id);
                $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id);


                $order_id = $request['user_id'] . date('YmdHis');

                $cartlist_final_price = $request->cartlist_final_price;
                $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY_NAME, '', $cartlist_final_price)));
                // $billing = json_decode($requests_data['billing_info'], true);

                $product = $request->cartlist['product_list'];
                $name = $product[0]->name;

                if ($product) {
                    $order_id = time();
                    $success = Crypt::encrypt([
                        'order_id' => $order_id
                    ]);
                    $data = array(
                        // Merchant details
                        'merchant_id' => !empty($payfast_merchant_id) ? $payfast_merchant_id : '',
                        'merchant_key' => !empty($payfast_merchant_key) ? $payfast_merchant_key : '',
                        'return_url' => route('payfast.callback', [$slug, $success, 'request_data' => $request->all()]),
                        'cancel_url' => route('payfast.callback', [$slug, $success, 'request_data' => $request->all()]),
                        'notify_url' => route('payfast.callback', [$slug, $success, 'request_data' => $request->all()]),
                        // Buyer details
                        'name_first' => isset($other_info->firstname) ? $other_info->firstname : '',
                        'name_last' => isset($other_info->lastname) ? $other_info->lastname : '',
                        'email_address' => isset($other_info->email) ? $other_info->email : '',
                        // Transaction details
                        'm_payment_id' => $order_id, //Unique payment ID to pass through to notify_url
                        'amount' => $cartlist_final_price,
                        'item_name' => $name,
                    );
                    $passphrase = !empty($payfast_salt_passphrase) ? $payfast_salt_passphrase : '';
                    $signature = $this->generateSignature($data, $passphrase);
                    $data['signature'] = $signature;
                    $checkouthtml = '';
                    foreach ($data as $name => $value) {
                        $checkouthtml .= '<input name="' . $name . '" type="hidden" value=\'' . $value . '\' />';
                    }
                    return response()->json([
                        'success' => true,
                        'inputs' => $checkouthtml
                    ]);
                }
            } elseif ($request->payment_type == 'benefit') {
                $place_order_api = new BenefitPaymentController();
                $place_order_data = $place_order_api->PayWithBenefit($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'cashfree') {
                $place_order_api = new CashfreeController();
                $place_order_data = $place_order_api->PayWithCashfree($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'aamarpay') {
                $place_order_api = new AamarpayController();
                $place_order_data = $place_order_api->PayWithAamarpaypayment($request);
            } elseif ($request->payment_type == 'telegram') {
                $data = $request->all();
                Session::put('request_data', $request->all());
                return view('payment.telegram', compact('data'));
            } elseif ($request->payment_type == 'whatsapp') {
                $data = $request->all();
                Session::put('request_data', $request->all());
                return view('payment.whatsapp', compact('data'));
            } elseif ($request->payment_type == 'paytr') {
                try {
                    $place_order_api = new PaytrController();
                    $place_order_data = $place_order_api->PayWithPayTr($request);
                    $token = $place_order_data->getData()['token'];
                    $data = $request->all();

                    return view('payment.pay_tr', compact('token', 'data'));
                } catch (\Throwable $e) {
                    return redirect()->back()->with('error', 'USD para birimi icin tanimli uye isyeri hesabi yok (get-token)');
                }
            } elseif ($request->payment_type == 'yookassa') {
                $place_order_api = new YookassaController();
                $place_order_data = $place_order_api->OrderPayWithYookassa($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'Xendit') {
                $place_order_api = new XenditPaymentController();
                $place_order_data = $place_order_api->PaywithXendiPayment($request);
                $location = $place_order_data->getTargetUrl();

                return new RedirectResponse($location);
            }elseif ($request->payment_type == 'midtrans') {
                $place_order_api = new MidtransController();
                $slug = !empty($request->slug) ? $request->slug : '';
                $store = Store::where('slug',$slug)->first();

                $theme_id = $request->theme_id;

                $midtrans_secret_key = \App\Models\Utility::GetValueByName('midtrans_secret_key',$theme_id);
                $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME',$theme_id);
                $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY',$theme_id);

                $orderID = $request->user_id . date('YmdHis');
                $cartlist_final_price = $request->cartlist_final_price;
                $other_info = json_decode($request->billing_info);
                try {
                        // Set your Merchant Server Key
                    \Midtrans\Config::$serverKey = $midtrans_secret_key;
                    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                    \Midtrans\Config::$isProduction = false;
                    // Set sanitization on (default)
                    \Midtrans\Config::$isSanitized = true;
                    // Set 3DS transaction for credit card to true
                    \Midtrans\Config::$is3ds = true;

                    $params = array(
                        'transaction_details' => array(
                            'order_id' => $orderID,
                            'gross_amount' => ceil($cartlist_final_price),
                        ),
                        'customer_details' => array(
                            'first_name' =>  $other_info->firstname,
                            'last_name' => $other_info->lastname,
                            'email' => $other_info->email,
                            'phone' => '8787878787',
                        ),
                    );
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    Session::put('request_data', $request->all());

                    $data = [
                        'snap_token' => $snapToken,
                        'midtrans_secret' => $midtrans_secret_key,
                        'order_id'=>$orderID,
                        'slug'=>$slug,
                        'amount'=>$cartlist_final_price,
                        'fallback_url' => 'midtrans.callback',$slug
                    ];
                    return view('midtras.order_payment', compact('data'));
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', __($e));
                }

            }
        }

        $place_order_data = $ApiController->place_order($request);
        $place_order = $place_order_data->getData();



        if ($place_order->status == 1) {
            $responce = json_decode(json_encode($place_order), true);

            // dd($place_order->status , $responce);
            // return redirect()->back()->with('success', $responce['data']['complete_order']['order-complate']['order-complate-title']);
            // return redirect()->route('order.summary')->with('data', $responce['data']);

            return redirect()->route('order.summary', ['slug' => $slug, 'responce' => $responce]);
        } else {
            return redirect()->back()->with('error', $place_order->data->message);
        }
    }

    public function place_order_guest(Request $request, $slug)
    {
        $user = Admin::where('type', 'admin')->first();
        if ($user->type == 'admin') {
            $plan = Plan::find($user->plan);
        }

        $store = Store::where('slug', $slug)->first();
        // $theme_id = $store->theme_id;

        $theme_id = APP_THEME();

        if ($request->register == 'on') {
            $validator = \Validator::make(
                $request->billing_info,
                [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'billing_address' => 'required',
                    'billing_postecode' => 'required',
                    'billing_country' => 'required',
                    'billing_state' => 'required',
                    'billing_city' => 'required',
                    'billing_address' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('users')->where(function ($query)  use ($theme_id) {
                            return $query->where('theme_id', $theme_id);
                        })
                    ],

                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            // customer
            $insert_array['first_name'] = $request->billing_info['firstname'];
            $insert_array['last_name'] = $request->billing_info['lastname'];
            $insert_array['email'] = $request->billing_info['email'];
            $insert_array['register_type'] = 'email';
            $insert_array['type'] = 'customer';
            $insert_array['mobile'] = !empty($request->billing_info['billing_user_telephone']) ? $request->billing_info['billing_user_telephone'] : '';
            $insert_array['regiester_date'] = date('Y-m-d');
            $insert_array['last_active'] = date('Y-m-d');
            $insert_array['password'] = Hash::make('1234');
            // $insert_array['theme_id'] = !empty($this->APP_THEME) ? $this->APP_THEME : '';
            $insert_array['theme_id'] = !empty($store) ? $store->theme_id : '';
            $insert_array['store_id'] = !empty($store) ? $store->id : '';
            $insert_array['created_by'] = !empty($store) ? $store->created_by : '';

            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;
            $settings = Setting::where('theme_id', $theme_id)->where('store_id', $store->id)->pluck('value', 'name')->toArray();

            try {
                config(
                    [
                        'mail.driver' => $settings['MAIL_DRIVER'],
                        'mail.host' => $settings['MAIL_HOST'],
                        'mail.port' =>  $settings['MAIL_PORT'],
                        'mail.encryption' =>  $settings['MAIL_ENCRYPTION'],
                        'mail.username' =>  $settings['MAIL_USERNAME'],
                        'mail.password' =>  $settings['MAIL_PASSWORD'],
                        'mail.from.address' =>  $settings['MAIL_FROM_ADDRESS'],
                        'mail.from.name' =>  $settings['MAIL_FROM_NAME'],
                    ]
                );
                $email = $request->billing_info['email'];

                $status = Password::sendResetLink([
                    'email' => $email,
                ]);
            } catch (\Throwable $th) {
            }

            $user = User::create($insert_array);
            //activity log
            ActivityLog::create([
                'user_id' => $user->id,
                'log_type' => 'register',
                'store_id' => !empty($store) ? $store->id : '',
                'theme_id' => $theme_id,
            ]);

            UserAdditionalDetail::create([
                'user_id' => $user->id,
                'theme_id' => !empty($store) ? $store->theme_id : '',
            ]);
            $validator = \Validator::make(
                $request->billing_info,
                [
                    'firstname' => 'required',
                    'lastname' => 'required',

                    'email' => [
                        'required',
                        Rule::unique('users')->where(function ($query)  use ($theme_id) {
                            return $query->where('theme_id', $theme_id);
                        })
                    ],

                ]
            );

            $request->merge([
                'store_id' => $store->id,
                'slug' => $slug,
                'user_id' => $user->id,
                'default_address' => 1,
                'first_name' => $request->billing_info['firstname'],
                'address'    => $request->billing_info['billing_address'],
                'country'    => $request->billing_info['billing_country'],
                'state'    => $request->billing_info['billing_state'],
                'city'    => $request->billing_info['billing_city'],
                'postcode'    => $request->billing_info['billing_postecode'],
                'title' => strtolower($request->billing_info['firstname']),

            ]);

            $api = new ApiController();
            $data = $api->add_address($request);
            $response = $data->getData();



            Auth::login($user);
        } else {
            $user = User::where('email', $request->billing_info['email'])->where('regiester_date', null)->get();
            if ($user->count() == 0) {
                $insert_array['first_name'] = $request->billing_info['firstname'];
                $insert_array['last_name'] = $request->billing_info['lastname'];
                $insert_array['email'] = $request->billing_info['email'];
                $insert_array['register_type'] = 'email';
                $insert_array['type'] = 'customer';
                $insert_array['mobile'] = !empty($request->billing_info['billing_user_telephone']) ? $request->billing_info['billing_user_telephone'] : '';
                $insert_array['last_active'] = date('Y-m-d');
                $insert_array['theme_id'] = !empty($store) ? $store->theme_id : '';
                $insert_array['store_id'] = !empty($store) ? $store->id : '';
                $insert_array['created_by'] = !empty($store) ? $store->created_by : '';
                $user = User::create($insert_array);

                $request->merge([
                    'store_id' => $store->id,
                    'slug' => $slug,
                    'user_id' => $user->id,
                    'default_address' => 1,
                    'first_name' => $request->billing_info['firstname'],
                    'address'    => $request->billing_info['billing_address'],
                    'country'    => $request->billing_info['billing_country'],
                    'state'    => $request->billing_info['billing_state'],
                    'city'    => $request->billing_info['billing_city'],
                    'postcode'    => $request->billing_info['billing_postecode'],
                    'title' => strtolower($request->billing_info['firstname']),

                ]);

                $api = new ApiController();
                // dd($request);
                $data = $api->add_address($request);
                $response = $data->getData();
            } else {
                $user = User::where('email', $request->billing_info['email'])->where('regiester_date', null)->first();
                $user->last_active = date('Y-m-d');
                $user->save();
            }
        }

        $cart = Cookie::get('cart');
        $cart_array = json_decode($cart);
        $new_array = [];

        // Product array
        $i = 0;
        foreach ($cart_array as $key => $value) {
            $new_array['product'][$i]['product_id'] = $value->product_id;
            $new_array['product'][$i]['variant_id'] = $value->variant_id;
            $new_array['product'][$i]['qty'] = $value->qty;
            $i++;
        }
        $new_array['tax_info'] = [];

        // TAX array
        $param['theme_id'] = $this->APP_THEME;
        $param['slug'] = $slug;
        $param['store_id'] = $store->id;

        $request->merge($param);
        $ApiController = new ApiController();

        $new_array['coupon_info'] = [];
        if (!empty($request->coupon_code)) {
            $apply_coupon_data = $ApiController->apply_coupon($request);
            $apply_coupon = $apply_coupon_data->getData();

            if ($apply_coupon->status == 1) {
                $new_array['coupon_info']['coupon_id'] = $apply_coupon->data->id;
                $new_array['coupon_info']['coupon_name'] = $apply_coupon->data->name;
                $new_array['coupon_info']['coupon_code'] = $apply_coupon->data->code;
                $new_array['coupon_info']['coupon_discount_type'] = $apply_coupon->data->coupon_discount_type;
                $new_array['coupon_info']['coupon_discount_number'] = $apply_coupon->data->amount;
                $new_array['coupon_info']['coupon_discount_amount'] = $apply_coupon->data->coupon_discount_amount;
                $new_array['coupon_info']['coupon_final_amount'] = $apply_coupon->data->final_price;
            }
        }
        if (!empty($request->coupon_code)) {
            $cart_price = [
                'sub_total' => $apply_coupon->data->final_price
            ];
            $request->request->add($cart_price);
        }
        $tax_guest_data = $ApiController->tax_guest($request);
        $tax_guest = $tax_guest_data->getData();
        if ($tax_guest->status == 1) {
            foreach ($tax_guest->data->tax_info as $tax_key => $tax) {
                $new_array['tax_info'][$tax_key]['tax_name'] = $tax->tax_name;
                $new_array['tax_info'][$tax_key]['tax_type'] = $tax->tax_type;
                $new_array['tax_info'][$tax_key]['tax_amount'] = $tax->tax_amount;
                $new_array['tax_info'][$tax_key]['id'] = $tax->id;
                $new_array['tax_info'][$tax_key]['tax_string'] = $tax->tax_string;
                $new_array['tax_info'][$tax_key]['tax_price'] = $tax->tax_price;
            }
        }

        // coupon array

        if ($request->register == 'on') {
            $new_array['user_id'] = $user->id;
        } else {
            $new_array['user_id'] = 0;
        }

        // $new_array['user_id'] = 0;
        $new_array['shipping_id'] = $request->delivery_id;
        $new_array['slug'] = $slug;
        $new_array['store_id'] = $store->id;

        $request->merge($new_array);
        if ($request->payment_type == 'stripe' || $request->payment_type == 'paystack' || $request->payment_type == 'skrill' || $request->payment_type == 'mercado' || $request->payment_type ==     'paymentwall' || $request->payment_type == 'Razorpay' || $request->payment_type == 'paypal' || $request->payment_type == 'flutterwave' || $request->payment_type == 'paytm' || $request->payment_type == 'mollie' || $request->payment_type == 'coingate' || $request->payment_type == 'toyyibpay' || $request->payment_type == 'Sspay' || $request->payment_type == 'Paytabs' || $request->payment_type == 'iyzipay' || $request->payment_type == 'payfast' || $request->payment_type == 'benefit' || $request->payment_type == 'cashfree' || $request->payment_type == 'aamarpay' || $request->payment_type == 'telegram' || $request->payment_type == 'whatsapp' || $request->payment_type == 'paytr' || $request->payment_type == 'yookassa' || $request->payment_type == 'Xendit' || $request->payment_type == 'midtrans') {
            $billing = $request->billing_info;

            if (empty($billing['firstname'])) {
                return redirect()->back()->with('error', __('Billing first name not found.'));
            }
            if (empty($billing['lastname'])) {
                return redirect()->back()->with('error', __('Billing last name not found.'));
            }
            if (empty($billing['email'])) {
                return redirect()->back()->with('error', __('Billing email not found.'));
            }
            if (empty($billing['billing_user_telephone'])) {
                return redirect()->back()->with('error', __('Billing telephone not found.'));
            }
            if (empty($billing['billing_address'])) {
                return redirect()->back()->with('error', __('Billing address not found.'));
            }
            if (empty($billing['billing_postecode'])) {
                return redirect()->back()->with('error', __('Billing postecode not found.'));
            }
            if (empty($billing['billing_country'])) {
                return redirect()->back()->with('error', __('Billing country not found.'));
            }
            if (empty($billing['billing_state'])) {
                return redirect()->back()->with('error', __('Billing state not found.'));
            }
            if (empty($billing['billing_city'])) {
                return redirect()->back()->with('error', __('Billing city not found.'));
            }
            if (empty($billing['delivery_address'])) {
                return redirect()->back()->with('error', __('Delivery address not found.'));
            }
            if (empty($billing['delivery_postcode'])) {
                return redirect()->back()->with('error', __('Delivery postcode not found.'));
            }
            if (empty($billing['delivery_country'])) {
                return redirect()->back()->with('error', __('Delivery country not found.'));
            }
            if (empty($billing['delivery_state'])) {
                return redirect()->back()->with('error', __('Delivery state not found.'));
            }
            if (empty($billing['delivery_city'])) {
                return redirect()->back()->with('error', __('Delivery city not found.'));
            }

            $cartlist_final_price = 0;
            $final_price = 0;


            if (Auth::guest()) {
                $response = Cart::cart_list_cookie($store->id);
                $response = json_decode(json_encode($response));
                $cartlist = (array)$response->data;

                if (empty($cartlist['product_list'])) {
                    return redirect()->back()->with('error', 'Cart is empty.');
                }

                $cartlist_final_price = !empty($cartlist['final_price']) ? $cartlist['final_price'] : 0;
                $final_sub_total_price = !empty($cartlist['total_sub_price']) ? $cartlist['total_sub_price'] : 0;
                // $final_price = $cartlist['final_price'] - $cartlist['tax_price'];
                $final_price = $response->data->total_final_price;
                $taxes = $cartlist['tax_info'];
                // $billing = json_decode($request->billing_info, true);
                $billing = $request->billing_info;
                $taxes = $cartlist['tax_info'];
                $products = $cartlist['product_list'];
            } elseif (!empty($request->user_id)) {
                $cart_list['user_id']   = $request->user_id;
                $request->request->add($cart_list);

                if ($request->register == 'on') {
                    Cart::cookie_to_cart($user->id, $store->id);
                }

                $cart_lists = new ApiController();
                $cartlist_response = $cart_lists->cart_list($request);
                $cartlist = (array)$cartlist_response->getData()->data;

                if (empty($cartlist['product_list'])) {
                    return redirect()->back()->with('error', 'Cart is empty.');
                }
                $cartlist_final_price = !empty($cartlist['final_price']) ? $cartlist['final_price'] : 0;
                $final_sub_total_price = !empty($cartlist['total_sub_price']) ? $cartlist['total_sub_price'] : 0;
                // $final_price = $cartlist['final_price'] - $cartlist['tax_price'];
                $final_price = $cartlist['total_final_price'];
                $taxes = $cartlist['tax_info'];
                // $billing = json_decode($request->billing_info, true);
                $billing = $request->billing_info;
                $taxes = $cartlist['tax_info'];
                $products = $cartlist['product_list'];
            } else {
                return redirect()->back()->with('error', 'User not found.');
            }



            $coupon_price = 0;
            // coupon api call
            if (!empty($request->coupon_info)) {
                // $coupon_data = json_decode($request->coupon_info, true);
                $coupon_data = $request->coupon_info;
                $apply_coupon = [
                    'coupon_code' => $coupon_data['coupon_code'],
                    'sub_total' => $cartlist_final_price

                ];
                $request->request->add($apply_coupon);
                $coupon_apply = new ApiController();
                $apply_coupon_response = $coupon_apply->apply_coupon($request);
                $apply_coupon = (array)$apply_coupon_response->getData()->data;


                $order_array['coupon']['message'] = $apply_coupon['message'];
                $order_array['coupon']['status'] = false;
                if (!empty($apply_coupon['final_price'])) {
                    $cartlist_final_price = $apply_coupon['final_price'];
                    $coupon_price = $apply_coupon['amount'];
                    $order_array['coupon']['status'] = true;
                }
            }


            // $delivery_price = 0;
            // // dilivery api call
            // if (!empty($request->delivery_id)) {
            //     $delivery_charge = [
            //         'price' => $cartlist_final_price,
            //         'shipping_id' => $request->delivery_id
            //     ];

            //     $request->request->add($delivery_charge);
            //     $delivery_charges = new ApiController();
            //     $delivery_charge_response = $delivery_charges->delivery_charge($request);
            //     $delivery_charge = (array)$delivery_charge_response->getData()->data;
            //     $cartlist_final_price = $delivery_charge['final_price'];
            //     $delivery_price = $delivery_charge['charge_price'];
            // } else {
            //     return redirect()->back()->with('error', 'Delivery type not found');
            // }

            // dilivery api call
            $delivery_price = 0;
            if ($plan->shipping_method == 'on') {
                if (!empty($request->method_id)) {
                    $del_charge = new CartController();
                    $delivery_charge = $del_charge->get_shipping_method($request, $slug);
                    $content = $delivery_charge->getContent();
                    $data = json_decode($content, true);
                    $delivery_price = $data['shipping_final_price'];
                    $tax_price = $data['final_tax_price'];
                } else {
                    return $this->error(['message' => 'Shipping Method not found']);
                }
            } else {
                $tax_price = 0;
                if (!empty($taxes)) {
                    foreach ($taxes as $key => $tax) {
                        $tax_price += $tax->tax_price;
                    }
                }
            }
            // $prodduct_id_array = [];
            // if (!empty($products)) {
            //     foreach ($products as $key => $product) {
            //         $prodduct_id_array[] = $product->product_id;

            //         $product_id = $product->product_id;
            //         $variant_id = $product->variant_id;
            //         $qtyy = !empty($product->qty) ? $product->qty : 0;

            //         $Product = Product::where('id', $product_id)->first();
            //         if (!empty($product_id) && !empty($variant_id) && $product_id != 0 && $variant_id != 0) {
            //             $ProductStock = ProductStock::where('id', $variant_id)->where('product_id', $product_id)->first();
            //             if (!empty($ProductStock)) {
            //                 $remain_stock = $ProductStock->stock - $qtyy;
            //                 $ProductStock->stock = $remain_stock;
            //                 $ProductStock->save();
            //             } else {
            //                 return redirect()->back()->with('error', 'Product not found .');
            //             }
            //         } elseif (!empty($product_id) && $product_id != 0) {
            //             if (!empty($Product)) {
            //                 $remain_stock = $Product->product_stock - $qtyy;
            //                 $Product->product_stock = $remain_stock;
            //                 $Product->save();
            //             } else {
            //                 return redirect()->back()->with('error', 'Product not found .');
            //             }
            //         } else {
            //             return redirect()->back()->with('error', 'Please fill proper product json field .');
            //         }

            //         // remove from cart
            //         // Cart::where('user_id', $request->user_id)->where('product_id', $product_id)->where('variant_id', $variant_id)->delete();
            //     }
            // }

            if (!empty($prodduct_id_array)) {
                $prodduct_id_array = $prodduct_id_array = array_unique($prodduct_id_array);
                $prodduct_id_array = implode(',', $prodduct_id_array);
            } else {
                $prodduct_id_array = '';
            }

            //add tax
            // $tax_price = $data['final_tax_price'];
            // $tax_price = 0;
            // if (!empty($taxes)) {
            //     foreach ($taxes as $key => $tax) {
            //         $tax_price += $tax->tax_price;
            //     }
            // }

            $new_array['cartlist_final_price'] = $cartlist_final_price;
            $request->merge($new_array);


            $product_reward_point = Utility::reward_point_count($cartlist_final_price, $theme_id);

            $new_array['billing_info'] = json_encode($request->billing_info);
            $request->merge($new_array);

            if ($request->payment_type == 'stripe') {
                $place_order_api = new StripePaymentController();
                $place_order_data = $place_order_api->stripePost($request);
                if (!empty($place_order_data) && $place_order_data['status'] == 0) {
                    return redirect()->back()->with('error', $place_order_data['data']['message']);
                }
                return new RedirectResponse($place_order_data->url);
            } elseif ($request->payment_type == 'paystack') {
                $place_order_api = new PaystackPaymentController();
                $place_order_data = $place_order_api->payWithPaystack($request);
                $data = $request;
                $store    = Store::where('slug', $request->slug)->first();
                $admin_payment_setting = Utility::getAdminPaymentSetting($store->id);

                return view('payment.paystack', compact('place_order_data', 'data', 'store', 'admin_payment_setting'));
            } elseif ($request->payment_type == 'mercado') {
                $place_order_api = new MercadoPaymentController();
                $place_order_data = $place_order_api->PayWithMercado($request);
                $url = json_decode($place_order_data->content(), true)['url'];

                return new RedirectResponse($url);
            } elseif ($request->payment_type == 'skrill') {
                $place_order_api = new SkrillPaymentController();
                $place_order_data = $place_order_api->payWithSkrill($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'paymentwall') {
                $place_order_api = new PaymentWallPaymentController();
                $place_order_data = $place_order_api->orderindex($request);
                $data = $request;

                return view('payment.paymentwall', compact('place_order_data', 'data'));
            } elseif ($request->payment_type == 'Razorpay') {
                $place_order_api = new RazorpayPaymentController();
                $place_order_data = $place_order_api->payWithRazorpay($request);
                $data = $request;

                return view('payment.razorpay', compact('place_order_data', 'data'));
            } elseif ($request->payment_type == 'paypal') {
                $place_order_api = new PaypalPaymentController();
                $place_order_data = $place_order_api->PayWithPaypal($request);


                return new RedirectResponse($place_order_data->getTargetUrl());
            } elseif ($request->payment_type == 'flutterwave') {
                $place_order_api = new flutterwaveController();
                $place_order_data = $place_order_api->flutterwavePost($request);

                return view('payment.flutterwave', compact('place_order_data'));
            } elseif ($request->payment_type == 'paytm') {

                $email = json_decode($request->request->get('billing_info'), true)['email'];
                $firstname = json_decode($request->request->get('billing_info'), true)['firstname'];
                $billing_user_telephone = json_decode($request->request->get('billing_info'), true)['billing_user_telephone'];
                $slug = !empty($request->slug) ? $request->slug : '';
                $store = Store::where('slug', $slug)->first();
                // $theme_id = $store->theme_id;

                $theme_id = $request->theme_id;

                $paytm_mode = \App\Models\Utility::GetValueByName('paytm_mode', $theme_id);
                $paytm_merchant_id = \App\Models\Utility::GetValueByName('paytm_merchant_id', $theme_id);
                $paytm_merchant_key = \App\Models\Utility::GetValueByName('paytm_merchant_key', $theme_id);
                $paytm_industry_type = \App\Models\Utility::GetValueByName('paytm_industry_type', $theme_id);
                $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id);
                $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id);
                $cutomer  = User::where('type', 'customer')->where('store_id', $store->id)->where('theme_id', $theme_id)->get()->count();
                $user = $cutomer + 1;
                // $orderID = $request->user_id . date('YmdHis');
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                $cartlist_final_price = $request->cartlist_final_price;
                config(
                    [
                        'services.paytm-wallet.env' => isset($paytm_mode) ? $paytm_mode : '',
                        'services.paytm-wallet.merchant_id' => isset($paytm_merchant_id) ? $paytm_merchant_id : '',
                        'services.paytm-wallet.merchant_key' => isset($paytm_merchant_key) ? $paytm_merchant_key : '',
                        'services.paytm-wallet.merchant_website' => 'WEBSTAGING',
                        'services.paytm-wallet.channel' => 'WEB',
                        'services.paytm-wallet.industry_type' => isset($paytm_industry_type) ? $paytm_industry_type : '',
                    ]
                );

                try {

                    $payment = PaytmWallet::with('receive');
                    $payment->prepare(
                        [
                            'order' => date('Y-m-d') . '-' . strtotime(date('Y-m-d H:i:s')),
                            'user' => $user,
                            'mobile_number' => $billing_user_telephone,
                            'email' => $email,
                            'amount' => $cartlist_final_price,
                            'callback_url' => route('store.payment.paytm', $slug),

                        ]
                    );

                    Session::put('request_data', $request->all());
                    return $payment->receive();
                } catch (\Exception $e) {
                    return redirect()->route('checkout')->with('error', __($e->getMessage()));
                }
            } elseif ($request->payment_type == 'mollie') {
                $place_order_api = new MolliePaymentController();
                $place_order_data = $place_order_api->PayWithmollie($request);

                return new RedirectResponse($place_order_data->getTargetUrl());
            } elseif ($request->payment_type == 'coingate') {
                $place_order_api = new CoingateController();
                $place_order_data = $place_order_api->PayWithcoingate($request);

                if (!empty($place_order_data) && $place_order_data->status == 0) {
                    return redirect()->back()->with('error', $place_order_data['data']['message']);
                }
                return new RedirectResponse($place_order_data->payment_url);
            } elseif ($request->payment_type == 'Sspay') {
                $place_order_api = new SspayController();
                $place_order_data = $place_order_api->PayWithSspay($request);

                $response = $place_order_data;
                $location = $response->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'toyyibpay') {
                $place_order_api = new ToyyibpayController();
                $place_order_data = $place_order_api->PayWithtoyyibpay($request);

                $response = $place_order_data;
                $location = $response->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'Paytabs') {
                $place_order_api = new PaytabsController();
                $place_order_data = $place_order_api->PayWithPaytabs($request);
                return new RedirectResponse($place_order_data->getTargetUrl());
            } elseif ($request->payment_type == 'iyzipay') {
                $place_order_api = new IyziPayController();
                $place_order_data = $place_order_api->PayWithIyzipay($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'payfast') {
                $place_order_api = new PayFastController();
                $store = Store::where('slug', $slug)->first();
                $theme_id = $store->theme_id;
                $other_info = json_decode($request->billing_info);


                $payfast_merchant_id = \App\Models\Utility::GetValueByName('payfast_merchant_id', $theme_id);
                $payfast_salt_passphrase = \App\Models\Utility::GetValueByName('payfast_salt_passphrase', $theme_id);
                $payfast_merchant_key = \App\Models\Utility::GetValueByName('payfast_merchant_key', $theme_id);
                $payfast_mode = \App\Models\Utility::GetValueByName('payfast_mode', $theme_id);
                $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id);


                $order_id = $request['user_id'] . date('YmdHis');

                $cartlist_final_price = $request->cartlist_final_price;
                // dd($request->all());
                $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY_NAME, '', $cartlist_final_price)));
                // $billing = json_decode($requests_data['billing_info'], true);

                $product = $request->product;
                // $product_name = [];
                // $product_id = [];
                $pro = Product::find($product);
                foreach ($pro as $key => $products) {
                }

                if ($product) {
                    $order_id = time();
                    $success = Crypt::encrypt([
                        'product' => $products->id,
                        'order_id' => $order_id,
                        'product_amount' => $cartlist_final_price
                    ]);
                    $data = array(
                        // Merchant details
                        'merchant_id' => !empty($payfast_merchant_id) ? $payfast_merchant_id : '',
                        'merchant_key' => !empty($payfast_merchant_key) ? $payfast_merchant_key : '',
                        'return_url' => route('payfast.callback', [$slug, $success, 'request_data' => $request->all()]),
                        'cancel_url' => route('payfast.callback', [$slug, $success, 'request_data' => $request->all()]),
                        'notify_url' => route('payfast.callback', [$slug, $success, 'request_data' => $request->all()]),
                        // Buyer details
                        'name_first' => isset($other_info->firstname) ? $other_info->firstname : '',
                        'name_last' => isset($other_info->lastname) ? $other_info->lastname : '',
                        'email_address' => isset($other_info->email) ? $other_info->email : '',
                        // Transaction details
                        'm_payment_id' => $order_id, //Unique payment ID to pass through to notify_url
                        'amount' => $cartlist_final_price,
                        'item_name' => $products->name,
                    );
                    $passphrase = !empty($payfast_salt_passphrase) ? $payfast_salt_passphrase : '';
                    $signature = $this->generateSignature($data, $passphrase);
                    $data['signature'] = $signature;
                    $checkouthtml = '';
                    foreach ($data as $name => $value) {
                        $checkouthtml .= '<input name="' . $name . '" type="hidden" value=\'' . $value . '\' />';
                    }
                    return response()->json([
                        'success' => true,
                        'inputs' => $checkouthtml
                    ]);
                }
            } elseif ($request->payment_type == 'benefit') {
                $place_order_api = new BenefitPaymentController();
                $place_order_data = $place_order_api->PayWithBenefit($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'cashfree') {
                $place_order_api = new CashfreeController();
                $place_order_data = $place_order_api->PayWithCashfree($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            } elseif ($request->payment_type == 'aamarpay') {
                $place_order_api = new AamarpayController();
                $place_order_data = $place_order_api->PayWithAamarpaypayment($request);
            } elseif ($request->payment_type == 'telegram') {
                $data = $request->all();
                Session::put('request_data', $request->all());
                return view('payment.telegram', compact('data'));
            } elseif ($request->payment_type == 'whatsapp') {
                $data = $request->all();
                Session::put('request_data', $request->all());
                return view('payment.whatsapp', compact('data'));
            } elseif ($request->payment_type == 'paytr') {
                try {
                    $place_order_api = new PaytrController();
                    $place_order_data = $place_order_api->PayWithPayTr($request);
                    $token = $place_order_data->getData()['token'];
                    $data = $request->all();

                    return view('payment.pay_tr', compact('token', 'data'));
                } catch (\Throwable $e) {
                    return redirect()->back()->with('error', 'USD para birimi icin tanimli uye isyeri hesabi yok (get-token)');
                }
            } elseif ($request->payment_type == 'yookassa') {
                $place_order_api = new YookassaController();
                $place_order_data = $place_order_api->OrderPayWithYookassa($request);
                $location = $place_order_data->headers->get('location');

                return new RedirectResponse($location);
            }elseif ($request->payment_type == 'Xendit') {
                $place_order_api = new XenditPaymentController();
                $place_order_data = $place_order_api->PaywithXendiPayment($request);
                $location = $place_order_data->getTargetUrl();

                return new RedirectResponse($location);
            }elseif ($request->payment_type == 'midtrans') {
                $place_order_api = new MidtransController();
                $slug = !empty($request->slug) ? $request->slug : '';
                $store = Store::where('slug',$slug)->first();

                $theme_id = $request->theme_id;

                $midtrans_secret_key = \App\Models\Utility::GetValueByName('midtrans_secret_key',$theme_id);
                $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME',$theme_id);
                $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY',$theme_id);

                $orderID = $request->user_id . date('YmdHis');
                $cartlist_final_price = $request->cartlist_final_price;
                $other_info = json_decode($request->billing_info);
                try {
                        // Set your Merchant Server Key
                    \Midtrans\Config::$serverKey = $midtrans_secret_key;
                    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                    \Midtrans\Config::$isProduction = false;
                    // Set sanitization on (default)
                    \Midtrans\Config::$isSanitized = true;
                    // Set 3DS transaction for credit card to true
                    \Midtrans\Config::$is3ds = true;

                    $params = array(
                        'transaction_details' => array(
                            'order_id' => $orderID,
                            'gross_amount' => ceil($cartlist_final_price),
                        ),
                        'customer_details' => array(
                            'first_name' =>  $other_info->firstname,
                            'last_name' => $other_info->lastname,
                            'email' => $other_info->email,
                            'phone' => '8787878787',
                        ),
                    );
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    Session::put('request_data', $request->all());

                    $data = [
                        'snap_token' => $snapToken,
                        'midtrans_secret' => $midtrans_secret_key,
                        'order_id'=>$orderID,
                        'slug'=>$slug,
                        'amount'=>$cartlist_final_price,
                        'fallback_url' => 'midtrans.callback',$slug
                    ];
                    return view('midtras.order_payment', compact('data'));
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', __($e));
                }

            }
        }


        $place_order_guest_data = $ApiController->place_order_guest($request);
        $place_order_guest = $place_order_guest_data->getData();

        if ($place_order_guest->status == 1) {
            $cart_array = [];
            $cart_json = json_encode($cart_array);
            Cookie::queue('cart', $cart_json, 1440);

            $responce = json_decode(json_encode($place_order_guest), true);
            // return redirect()->back()->with('success', $responce['data']['complete_order']['order-complate']['order-complate-title']);
            // return redirect()->route('order.summary')->with('data', $responce['data']);
            return redirect()->route('order.summary', ['slug' => $slug, 'responce' => $responce]);
        } else {
            return redirect()->back()->with('error', $place_order_guest->data->message);
        }
    }

    public function generateSignature($data, $passPhrase = null)
    {

        $pfOutput = '';
        foreach ($data as $key => $val) {
            if ($val !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }

        $getString = substr($pfOutput, 0, -1);
        if ($passPhrase !== null) {
            $getString .= '&passphrase=' . urlencode(trim($passPhrase));
        }
        return md5($getString);
    }

    public function fileExport()
    {
        $fileName = 'Order.xlsx';
        return Excel::download(new OrderExport, $fileName);
    }

    public function shippinglabel(Request $request ,$id)
    {
        try{
            $id =crypt::decrypt($id);
            $order = Order::order_detail($id);
            $settings = Utility::Seting();
            $product = [];
            $products = [];
            foreach($order['product'] as $product_item){
                if($product_item['variant_id'] == '0')
                $product[] =Product::where('id' ,$product_item)->pluck('product_weight','id')->first();

                else{
                    $products[] =Productstock::where('id' ,$product_item['variant_id'])->pluck('weight' ,'id')->first();

                }
            }
            $newArray = [];

            foreach ($product as $key => $value) {
                $newArray[$key] = intval($value);
            }
            $product = array_merge($newArray ,$products);
            $product_sum =array_sum($product);



            if(!empty($order['message'])) {
                return redirect()->back()->with('error', __('Order Not Found.'));
            }

            return view('order.shippinglabel', compact('order','product_sum','settings'));

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', __('Something was wrong.'));
        }
    }

    public function order_receipt($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $order = Order::order_detail($id);

            if(!empty($order['message'])) {
                return redirect()->back()->with('error', __('Order Not Found.'));
            }
            return view('order.receipt', compact('order'));

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', __('Something was wrong.'));
        }
    }


    public function order_payment_status(Request $request){

        $order =Order::find($request->order_id);
        $order->payment_status =$request->payment_status;
        $order->save();
        $return['status'] = 'success';
        $return['message'] = 'Payment status has been changed.';
        return response()->json($return);

    }
    public function status_cancel(Request $request ,$slug){

        $data['order_id'] = $request->order_id;
        $data['order_status'] = $request->order_status;

        $responce = Order::order_status_change($data);
        $order_detail = Order::order_detail($request->order_id);

        foreach ($order_detail['product'] as $item){
            if($item['variant_id'] == 0){
                $product =Product::where('id' ,$item['product_id'])->first();
                $prdduct_stock =$product->product_stock + $item['qty'];
                $product->product_stock  = $prdduct_stock ;
                $product->save();
            }
            else{
                $product =ProductStock::where('id' ,$item['variant_id'])->first();
                $prdduct_stock =$product->stock + $item['qty'];
                $product->stock  = $prdduct_stock ;
                $product->save();
            }
        }
        if ($responce['status'] == 'success') {
            $return['status'] = 'success';
            $return['message'] = 'Order cancel successfully!';
            return response()->json($return);
        } else {
            $return['status'] = 'error';
            $return['message'] = $responce['message'];
            return response()->json($return);
        }

    }

    public function updateStatus(Request $request,$id)
    {
        $order = Order::find($id);
        if($order->delivered_status == 0)
        {
            $order->delivered_status = 1;
        }
        $order->save();

    }

    public function order_assign(Request $request)
    {
        $order =Order::find($request->order_id);
        $order->deliveryboy_id =$request->delivery_boy;
        $order->save();
        $return['status'] = 'success';
        $return['message'] = 'Order assigned successfully';
        return response()->json($return);

    }
}
