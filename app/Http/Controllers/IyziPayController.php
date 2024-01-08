<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\Store;
use App\Models\UserCoupon;
use App\Models\Utility;
use App\Models\ProductStock;
use App\Models\PlanOrder;
use App\Models\PlanUserCoupon;
use App\Models\PlanCoupon;
use App\Models\Product;
use App\Models\City;
use App\Models\OrderBillingDetail;
use App\Models\OrderCouponDetail;
use App\Models\OrderTaxDetail;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\ActivityLog;
use App\Models\OrderNote;
use App\Models\Setting;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class IyziPayController extends Controller
{
    //


    public function initiatePayment(Request $request)
    {
        $planID    = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $authuser  = \Auth::user();
        $adminPaymentSettings = Utility::getAdminPaymentSetting();
        $iyzipay_private_key = $adminPaymentSettings['iyzipay_private_key'];
        $iyzipay_secret_key = $adminPaymentSettings['iyzipay_secret_key'];
        $iyzipay_mode = $adminPaymentSettings['iyzipay_mode'];
        $currency = $adminPaymentSettings['CURRENCY_NAME'];
        $plan = Plan::find($planID);
        $coupon_id = '0';
        $price = $plan->price;
        $coupon_code = null;
        $discount_value = null;
        $coupons = PlanCoupon::where('code', $request->coupon)->where('is_active', '1')->first();
        if ($coupons) {
            $coupon_code = $coupons->code;
            $usedCoupun     = $coupons->used_coupon();
            if ($coupons->limit == $usedCoupun) {
                $res_data['error'] = __('This coupon code has expired.');
            } else {
                $discount_value = ($plan->price / 100) * $coupons->discount;
                $price  = $price - $discount_value;
                if ($price < 0) {
                    $price = $plan->price;
                }
                $coupon_id = $coupons->id;
            }
        }
        $res_data['total_price'] = $price;
        $res_data['coupon']      = $coupon_id;
        // set your Iyzico API credentials
        try {
            // dd(route('iyzipay.payment.callback',[$plan->id,$price,$coupon_code]));
            $setBaseUrl = ($iyzipay_mode == 'sandbox') ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com';
            $options = new \Iyzipay\Options();
            $options->setApiKey($iyzipay_private_key);
            $options->setSecretKey($iyzipay_secret_key);
            $options->setBaseUrl($setBaseUrl); // or "https://api.iyzipay.com" for production
            $ipAddress = Http::get('https://ipinfo.io/?callback=')->json();
            $address = ($authuser->address) ? $authuser->address : 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1';
            // create a new payment request
            $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
            $request->setLocale('en');
            $request->setPrice($res_data['total_price']);
            $request->setPaidPrice($res_data['total_price']);
            $request->setCurrency($currency);
            $request->setCallbackUrl(route('admin.iyzipay.payment.callback',[$plan->id,$price,$coupon_code,'user_id='.\Auth::user()->id]));

            $request->setEnabledInstallments(array(1));
            $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
            $buyer = new \Iyzipay\Model\Buyer();
            $buyer->setId($authuser->id);
            $buyer->setName(explode(' ', $authuser->name)[0]);
            $buyer->setSurname(explode(' ', $authuser->name)[0]);
            $buyer->setGsmNumber("+" . $authuser->dial_code . $authuser->phone);
            $buyer->setEmail($authuser->email);
            $buyer->setIdentityNumber(rand(0, 999999));
            $buyer->setLastLoginDate("2023-03-05 12:43:35");
            $buyer->setRegistrationDate("2023-04-21 15:12:09");
            $buyer->setRegistrationAddress($address);
            $buyer->setIp($ipAddress['ip']);
            $buyer->setCity($ipAddress['city']);
            $buyer->setCountry($ipAddress['country']);
            $buyer->setZipCode($ipAddress['postal']);
            $request->setBuyer($buyer);
            $shippingAddress = new \Iyzipay\Model\Address();
            $shippingAddress->setContactName($authuser->name);
            $shippingAddress->setCity($ipAddress['city']);
            $shippingAddress->setCountry($ipAddress['country']);
            $shippingAddress->setAddress($address);
            $shippingAddress->setZipCode($ipAddress['postal']);
            $request->setShippingAddress($shippingAddress);
            $billingAddress = new \Iyzipay\Model\Address();
            $billingAddress->setContactName($authuser->name);
            $billingAddress->setCity($ipAddress['city']);
            $billingAddress->setCountry($ipAddress['country']);
            $billingAddress->setAddress($address);
            $billingAddress->setZipCode($ipAddress['postal']);
            $request->setBillingAddress($billingAddress);
            $basketItems = array();
            $firstBasketItem = new \Iyzipay\Model\BasketItem();
            $firstBasketItem->setId("BI101");
            $firstBasketItem->setName("Binocular");
            $firstBasketItem->setCategory1("Collectibles");
            $firstBasketItem->setCategory2("Accessories");
            $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $firstBasketItem->setPrice($res_data['total_price']);
            $basketItems[0] = $firstBasketItem;
            $request->setBasketItems($basketItems);
            $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);
            $payResponse = (array)$checkoutFormInitialize;
            foreach ($payResponse as $key => $response) {
                $response_decoded = json_decode($response);
                $data['token'] = $response_decoded->token;
                Session::put('token', $data);
                break;
                }
            if($checkoutFormInitialize->getpaymentPageUrl() != null)
            {
                return redirect()->to($checkoutFormInitialize->getpaymentPageUrl());
            }else{
                return redirect()->route('admin.plan.index')->with('error', 'Something went wrong, Please try again');
            }
            return redirect()->to($checkoutFormInitialize->getpaymentPageUrl());
        } catch (\Exception $e) {
            return redirect()->route('admin.plan.index')->with('error', $e->getMessage());
        }
    }

    public function iyzipayCallback(Request $request, $planID, $price, $coupanCode = null)
    {

        $options = new \Iyzipay\Options();
        $adminPaymentSettings = Utility::getAdminPaymentSetting();
        $iyzipay_private_key = $adminPaymentSettings['iyzipay_private_key'];
        $iyzipay_secret_key = $adminPaymentSettings['iyzipay_secret_key'];
        $options->setApiKey($iyzipay_private_key);
        $options->setSecretKey($iyzipay_secret_key);
        $iyzipay_mode = $adminPaymentSettings['iyzipay_mode'];
        $setBaseUrl = ($iyzipay_mode == 'sandbox') ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com';
        $options->setBaseUrl($setBaseUrl); // or "https://api.iyzipay.com" for production
        $token = Session::get('token');
        $requesto = new \Iyzipay\Request\RetrievePayWithIyzicoRequest();
        $requesto->setLocale(\Iyzipay\Model\Locale::TR);
        $requesto->setConversationId("123456789");
        $requesto->setToken($token["token"]);

        $status = \Iyzipay\Model\PayWithIyzico::retrieve($requesto, $options);
        $payResponse = (array)$status;

        foreach ($payResponse as $key => $response) {
            $response_decoded = json_decode($response);
            $statuss = $response_decoded->paymentStatus;
            break;
        }

        if ($statuss == 'SUCCESS') {
                $user = Admin::find($request->user_id);

        $plan = Plan::find($planID);
        // $user = $request->user_id;
        // dd($user , $request->all(), $request->user_id);
        $order = new PlanOrder();
        $order->order_id = time();
        $order->name = $user->name;
        $order->card_number = '';
        $order->card_exp_month = '';
        $order->card_exp_year = '';
        $order->plan_name = $plan->name;
        $order->plan_id = $plan->id;
        $order->price = $price;
        $order->price_currency = 'USD';
        $order->txn_id = time();
        $order->payment_type = __('Iyzipay');
        $order->payment_status = 'success';
        $order->txn_id = '';
        $order->receipt = '';
        $order->user_id = $user->id;
        $order->save();

        // dd($user);
        $coupons = PlanCoupon::where('code', $coupanCode)->where('is_active', '1')->first();
        if (!empty($coupons)) {
            $userCoupon         = new PlanUserCoupon();
            $userCoupon->user   = $user->id;
            $userCoupon->coupon = $coupons->id;
            $userCoupon->order  = $order->order_id;
            $userCoupon->save();
            $usedCoupun = $coupons->used_coupon();
            if ($coupons->limit <= $usedCoupun) {
                $coupons->is_active = 0;
                $coupons->save();
            }
        }
        $assignPlan = $user->assignPlan($plan->id);

        if ($assignPlan['is_success']) {
            return redirect()->route('admin.plan.index')->with('success', __('Plan activated Successfully.'));
        }
        } else {
            return redirect()->route('admin.plan.index')->with('error', __($statuss));
        }
    }

    public function PayWithIyzipay(Request $request)
    {
        $slug = !empty($request->slug) ? $request->slug : '';

        $store = Store::where('slug', $slug)->first();
        $theme_id = $request->theme_id;

        $iyzipay_mode = \App\Models\Utility::GetValueByName('iyzipay_mode',$theme_id);
        $iyzipay_secret_key = \App\Models\Utility::GetValueByName('iyzipay_secret_key',$theme_id);
        $iyzipay_private_key = \App\Models\Utility::GetValueByName('iyzipay_private_key',$theme_id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME',$theme_id);
        $adminPaymentSettings = Utility::getAdminPaymentSetting();
        $currency = $adminPaymentSettings['CURRENCY_NAME'];
        $cart_list=Cart::cart_list_cookie($store->id);
        $request_data = $request->all();
        session(['cart_list' => $cart_list, 'request_data' => $request_data]);
        $objUser = \Auth::user();
        $orderID = $request->user_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));

        $other_info = json_decode($request->billing_info);
        $address = !empty($other_info->billing_address) ? $other_info->billing_address : '' ;
        $setBaseUrl = ($iyzipay_mode == 'sandbox') ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com';
        $options = new \Iyzipay\Options();
        $options->setApiKey($iyzipay_private_key);
        $options->setSecretKey($iyzipay_secret_key);
        $options->setBaseUrl($setBaseUrl); // or "https://api.iyzipay.com" for production
        $ipAddress = Http::get('https://ipinfo.io/?callback=')->json();
        $address = ($address) ? $address : 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1';
        // create a new payment request
        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale('en');
        $request->setPrice($totalprice);
        $request->setPaidPrice($totalprice);
        $request->setCurrency($currency);
        $request->setCallbackUrl(route('iyzipay.callback',[$slug, $totalprice]));
        // dd($request);
        $request->setEnabledInstallments(array(1));
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId(!empty($objUser['id']) ? $objUser['id'] : '0');
        $buyer->setName(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $buyer->setSurname(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $buyer->setGsmNumber(!empty($objUser['mobile']) ? $objUser['mobile'] : '9999999999');
        $buyer->setEmail(!empty($objUser['email']) ? $objUser['email'] : 'test@gmail.com');
        $buyer->setIdentityNumber(rand(0, 999999));
        $buyer->setLastLoginDate("2023-03-05 12:43:35");
        $buyer->setRegistrationDate("2023-04-21 15:12:09");
        $buyer->setRegistrationAddress($address);
        $buyer->setIp($ipAddress['ip']);
        $buyer->setCity($ipAddress['city']);
        $buyer->setCountry($ipAddress['country']);
        $buyer->setZipCode($ipAddress['postal']);
        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $shippingAddress->setCity($ipAddress['city']);
        $shippingAddress->setCountry($ipAddress['country']);
        $shippingAddress->setAddress($address);
        $shippingAddress->setZipCode($ipAddress['postal']);
        $request->setShippingAddress($shippingAddress);
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $billingAddress->setCity($ipAddress['city']);
        $billingAddress->setCountry($ipAddress['country']);
        $billingAddress->setAddress($address);
        $billingAddress->setZipCode($ipAddress['postal']);
        $request->setBillingAddress($billingAddress);
        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($totalprice);
        $basketItems[0] = $firstBasketItem;
        $request->setBasketItems($basketItems);

        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);

        if($checkoutFormInitialize->getpaymentPageUrl() != null)
        {
            return redirect()->to($checkoutFormInitialize->getpaymentPageUrl());
        }else{
            return redirect()->route('checkout',$slug)->with('error', 'Something went wrong, Please try again');
        }
        return redirect()->to($checkoutFormInitialize->getpaymentPageUrl());

    }

    public function iyzipaypaymentCallback(Request $request ,$slug, $totalprice)
    {

        $cart_list = session('cart_list');
        Session::forget('cart_list');
        $request_data = session('request_data');
        Session::forget('request_data');


        $slug = !empty($request_data['slug']) ? $request_data['slug'] : '';
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;
        if (Auth::guest()) {
            if ($request->coupon_code != null) {
                $coupon = Coupon::where('id', $request->coupon_info['coupon_id'])->where('store_id', $store->id)->where('theme_id', $theme_id)->first();
                $coupon_email  = $coupon->PerUsesCouponCount();
                $i = 0;
                foreach ($coupon_email as $email) {
                    if ($email == $request->billing_info['email']) {
                        $i++;
                    }
                }

                if (!empty($coupon->coupon_limit_user)) {
                    if ($i  >= $coupon->coupon_limit_user) {
                        return $this->error(['message' => 'Coupon has been expiredd.']);
                    }
                }
            }
        }
        $user_id = $request_data['user_id'];
        if(!empty($requests_data['method_id'])){

            $request['method_id'] = $requests_data['method_id'];
        }

        $user = Admin::where('type','admin')->first();
        if ($user->type == 'admin') {
            $plan = Plan::find($user->plan);
        }

        if(Auth::guest()) {
            $rules = [
                'billing_info' => 'required',
                'payment_type' => 'required',
                'delivery_id' => 'required',
            ];
        } else {
            $rules = [
                'user_id' => 'required',
                'billing_info' => 'required',
                'payment_type' => 'required',
                'delivery_id' => 'required',
            ];
        }

        $validator = \Validator::make($request_data, $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            Utility::error([
                'message' => $messages->first()
            ]);
        }

        $cartlist_final_price = 0;
        $final_price = 0;

        // cart list api call
        if(Auth::guest()){
            $response = $cart_list;
            $response = json_decode(json_encode($response));
            $cartlist = (array)$response->data;

            if (empty($cartlist['product_list'])) {
                return Utility::error(['message' => 'Cart is empty.']);
            }

            $cartlist_final_price = !empty($cartlist['final_price']) ? $cartlist['final_price'] : 0;
            $final_sub_total_price = !empty($cartlist['total_sub_price']) ? $cartlist['total_sub_price'] : 0;
            // $final_price = $cartlist['final_price'] - $cartlist['tax_price'];
            $final_price = $response->data->total_final_price;
            $taxes = $cartlist['tax_info'];
            $billing = json_decode($request_data['billing_info'], true);

            $taxes = $request_data['tax_info'];
            $products = $cart_list['data']['product_list'];


        } elseif (!empty($user_id)) {
            $cart_list['user_id']   = $user_id;
            $request->merge($request_data);
            $cartt = new ApiController();
            $cartlist_response = $cartt->cart_list($request);
            $cartlist = (array)$cartlist_response->getData()->data;

            if (empty($cartlist['product_list'])) {
                return Utility::error(['message' => 'Cart is empty.']);
            }

            $cartlist_final_price = !empty($cartlist['final_price']) ? $cartlist['final_price'] : 0;
            $final_sub_total_price = !empty($cartlist['total_sub_price']) ? $cartlist['total_sub_price'] : 0;
            // $final_price = $cartlist['final_price'] - $cartlist['tax_price'];
            $final_price = $cartlist['total_final_price'];
        $taxes = $cartlist['tax_info'];
            $billing = json_decode($request->billing_info, true);

            $taxes = $cartlist['tax_info'];
            $products = $cartlist['product_list'];
        } else {
            return Utility::error(['message' => 'User not found.']);
        }
        $coupon_price = 0;
        // coupon api call
        if (!empty($request_data['coupon_info'])) {
            $coupon_data = $request_data['coupon_info'];
            $apply_coupon = [
                'coupon_code' => $coupon_data['coupon_code'],
                'sub_total' => $cartlist_final_price,
                'theme_id' => $request_data['theme_id'],
                'slug' => $request_data['slug']

            ];
            $request->merge($apply_coupon);
            $couponss = new ApiController();
            $apply_coupon_response = $couponss->apply_coupon($request);
            $apply_coupon = (array)$apply_coupon_response->getData()->data;

            $order_array['coupon']['message'] = $apply_coupon['message'];
            $order_array['coupon']['status'] = false;
            if (!empty($apply_coupon['final_price'])) {
                $cartlist_final_price = $apply_coupon['final_price'];
                $coupon_price = $apply_coupon['amount'];
                $order_array['coupon']['status'] = true;
            }
        }

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


        $settings = Setting::where('theme_id', $theme_id)->where('store_id', $store->id)->pluck('value', 'name')->toArray();
        // Order stock decrease start
        $prodduct_id_array = [];
        if(Auth::guest()){
            if (!empty($products)) {
                foreach ($products as $key => $product) {
                    $prodduct_id_array[] = $product['product_id'];

                    $product_id = $product['product_id'];
                    $variant_id = $product['variant_id'];
                    $qtyy = !empty($product['qty']) ? $product['qty'] : 0;

                    $Product = Product::where('id', $product_id)->first();
                    $datas = Product::find($product_id);
                    if($settings['stock_management'] == 'on')
                    {
                        if (!empty($product_id) && !empty($variant_id) && $product_id != 0 && $variant_id != 0) {
                            $ProductStock = ProductStock::where('id', $variant_id)->where('product_id', $product_id)->first();
                            $variationOptions = explode(',', $ProductStock->variation_option);
                            $option = in_array('manage_stock', $variationOptions);
                            if (!empty($ProductStock)) {
                                if($option == true)
                                {
                                    $remain_stock = $ProductStock->stock - $qtyy;
                                    $ProductStock->stock = $remain_stock;
                                    $ProductStock->save();

                                    if($ProductStock->stock <= $ProductStock->low_stock_threshold)
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                // dd('low');
                                                Utility::variant_low_stock_threshold($product,$ProductStock,$theme_id,$settings);
                                            }

                                        }
                                    }
                                    if($ProductStock->stock <= $settings['out_of_stock_threshold'])
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                Utility::variant_out_of_stock($product,$ProductStock,$theme_id,$settings);
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $remain_stock = $datas->product_stock - $qtyy;
                                    $datas->product_stock = $remain_stock;
                                    $datas->save();
                                    if($datas->product_stock <= $datas->low_stock_threshold)
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                Utility::variant_low_stock_threshold($product,$datas,$theme_id,$settings);
                                            }

                                        }
                                    }
                                    if($datas->product_stock <= $settings['out_of_stock_threshold'])
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                Utility::variant_out_of_stock($product,$datas,$theme_id,$settings);
                                            }
                                        }
                                    }
                                    if($datas->product_stock <= $settings['out_of_stock_threshold'] && $datas->stock_order_status == 'notify_customer')
                                    {
                                        //Stock Mail
                                        $order_email = $billing['email'];
                                        $owner=Admin::find($store->created_by);
                                        // $owner_email=$owner->email;
                                        $ProductId    = '';

                                        try
                                        {
                                            $dArr = [
                                                'item_variable' => $Product->id,
                                                'product_name' => $Product->name,
                                                'customer_name' => $billing['firstname'],
                                            ];

                                            // Send Email
                                            $resp = Utility::sendEmailTemplate('Stock Status', $order_email, $dArr, $owner,$store, $ProductId);
                                        }
                                        catch(\Exception $e)
                                        {
                                            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                                        }
                                        try
                                        {
                                            $mobile_no =$request['billing_info']['billing_user_telephone'];
                                            $customer_name =$request['billing_info']['firstname'];
                                            $msg =   __("Dear,$customer_name .Hi,We are excited to inform you that the product you have been waiting for is now back in stock.Product Name: :$Product->name. ");
                                            $resp  = Utility::SendMsgs('Stock Status', $mobile_no, $msg);
                                        }
                                        catch(\Exception $e)
                                        {
                                            $smtp_error = __('Invalid OAuth access token - Cannot parse access token');
                                        }
                                    }
                                }
                            } else {
                                return $this->error(['message' => 'Product not found .']);
                            }
                        } elseif (!empty($product_id) && $product_id != 0) {

                            if (!empty($Product)) {
                                $remain_stock = $Product->product_stock - $qtyy;
                                $Product->product_stock = $remain_stock;
                                $Product->save();
                                if($Product->product_stock <= $Product->low_stock_threshold)
                                {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock",json_decode($settings['notification'])))
                                    {
                                        if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                        {
                                            Utility::low_stock_threshold($Product,$theme_id,$settings);
                                        }
                                    }
                                }

                                if($Product->product_stock <= $settings['out_of_stock_threshold'])
                                {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock",json_decode($settings['notification'])))
                                    {
                                        if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                        {
                                            Utility::out_of_stock($Product,$theme_id,$settings);
                                        }
                                    }
                                }

                                if($Product->product_stock <= $settings['out_of_stock_threshold'] && $Product->stock_order_status == 'notify_customer')
                                {
                                    //Stock Mail
                                    $order_email = $billing['email'];
                                    $owner=Admin::find($store->created_by);
                                    // $owner_email=$owner->email;
                                    $ProductId    = '';

                                    try
                                    {
                                    $dArr = [
                                    'item_variable' => $Product->id,
                                    'product_name' => $Product->name,
                                    'customer_name' => $billing['firstname'],
                                    ];

                                    // Send Email
                                    $resp = Utility::sendEmailTemplate('Stock Status', $order_email, $dArr, $owner,$store, $ProductId);
                                    }
                                    catch(\Exception $e)
                                    {
                                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                                    }
                                    try
                                    {
                                        $mobile_no =$request['billing_info']['billing_user_telephone'];
                                        $customer_name =$request['billing_info']['firstname'];
                                        $msg =   __("Dear,$customer_name .Hi,We are excited to inform you that the product you have been waiting for is now back in stock.Product Name: :$Product->name. ");
                                        $resp  = Utility::SendMsgs('Stock Status', $mobile_no, $msg);
                                    }
                                    catch(\Exception $e)
                                    {
                                        $smtp_error = __('Invalid OAuth access token - Cannot parse access token');
                                    }
                                }

                            } else {
                                return $this->error(['message' => 'Product not found .']);
                            }
                        } else {
                            return $this->error(['message' => 'Please fill proper product json field .']);
                        }
                    }
                    // remove from cart
                    Cart::where('user_id', $user_id)->where('product_id', $product_id)->where('variant_id', $variant_id)->where('store_id',$store->id)->delete();
                }
            }
        }else{
            if (!empty($products)) {
                foreach ($products as $key => $product) {
                    $prodduct_id_array[] = $product->product_id;

                    $product_id = $product->product_id;
                    $variant_id = $product->variant_id;
                    $qtyy = !empty($product->qty) ? $product->qty : 0;

                    $Product = Product::where('id', $product_id)->first();
                    $datas = Product::find($product_id);
                    if($settings['stock_management'] == 'on')
                    {
                        if (!empty($product_id) && !empty($variant_id) && $product_id != 0 && $variant_id != 0) {
                            $ProductStock = ProductStock::where('id', $variant_id)->where('product_id', $product_id)->first();
                            $variationOptions = explode(',', $ProductStock->variation_option);
                            $option = in_array('manage_stock', $variationOptions);
                            if (!empty($ProductStock)) {
                                if($option == true)
                                {
                                    $remain_stock = $ProductStock->stock - $qtyy;
                                    $ProductStock->stock = $remain_stock;
                                    $ProductStock->save();

                                    if($ProductStock->stock <= $ProductStock->low_stock_threshold)
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                // dd('low');
                                                Utility::variant_low_stock_threshold($product,$ProductStock,$theme_id,$settings);
                                            }

                                        }
                                    }
                                    if($ProductStock->stock <= $settings['out_of_stock_threshold'])
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                Utility::variant_out_of_stock($product,$ProductStock,$theme_id,$settings);
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $remain_stock = $datas->product_stock - $qtyy;
                                    $datas->product_stock = $remain_stock;
                                    $datas->save();
                                    if($datas->product_stock <= $datas->low_stock_threshold)
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                Utility::variant_low_stock_threshold($product,$datas,$theme_id,$settings);
                                            }

                                        }
                                    }
                                    if($datas->product_stock <= $settings['out_of_stock_threshold'])
                                    {
                                        if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock",json_decode($settings['notification'])))
                                        {
                                            if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                            {
                                                Utility::variant_out_of_stock($product,$datas,$theme_id,$settings);
                                            }
                                        }
                                    }
                                    if($datas->product_stock <= $settings['out_of_stock_threshold'] && $datas->stock_order_status == 'notify_customer')
                                    {
                                        //Stock Mail
                                        $order_email = $billing['email'];
                                        $owner=Admin::find($store->created_by);
                                        // $owner_email=$owner->email;
                                        $ProductId    = '';

                                        try
                                        {
                                            $dArr = [
                                                'item_variable' => $Product->id,
                                                'product_name' => $Product->name,
                                                'customer_name' => $billing['firstname'],
                                            ];

                                            // Send Email
                                            $resp = Utility::sendEmailTemplate('Stock Status', $order_email, $dArr, $owner,$store, $ProductId);
                                        }
                                        catch(\Exception $e)
                                        {
                                            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                                        }
                                    }
                                }
                            } else {
                                return $this->error(['message' => 'Product not found .']);
                            }
                        } elseif (!empty($product_id) && $product_id != 0) {

                            if (!empty($Product)) {
                                $remain_stock = $Product->product_stock - $qtyy;
                                $Product->product_stock = $remain_stock;
                                $Product->save();
                                if($Product->product_stock <= $Product->low_stock_threshold)
                                {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock",json_decode($settings['notification'])))
                                    {
                                        if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                        {
                                            Utility::low_stock_threshold($Product,$theme_id,$settings);
                                        }
                                    }
                                }

                                if($Product->product_stock <= $settings['out_of_stock_threshold'])
                                {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock",json_decode($settings['notification'])))
                                    {
                                        if(isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] =="on")
                                        {
                                            Utility::out_of_stock($Product,$theme_id,$settings);
                                        }
                                    }
                                }

                                if($Product->product_stock <= $settings['out_of_stock_threshold'] && $Product->stock_order_status == 'notify_customer')
                                {
                                    //Stock Mail
                                    $order_email = $billing['email'];
                                    $owner=Admin::find($store->created_by);
                                    // $owner_email=$owner->email;
                                    $ProductId    = '';

                                    try
                                    {
                                    $dArr = [
                                    'item_variable' => $Product->id,
                                    'product_name' => $Product->name,
                                    'customer_name' => $billing['firstname'],
                                    ];

                                    // Send Email
                                    $resp = Utility::sendEmailTemplate('Stock Status', $order_email, $dArr, $owner,$store, $ProductId);
                                    }
                                    catch(\Exception $e)
                                    {
                                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                                    }
                                }

                            } else {
                                return $this->error(['message' => 'Product not found .']);
                            }
                        } else {
                            return $this->error(['message' => 'Please fill proper product json field .']);
                        }
                    }
                    // remove from cart
                    Cart::where('user_id', $user_id)->where('product_id', $product_id)->where('variant_id', $variant_id)->where('store_id',$store->id)->delete();
                }
            }
        }
        // Order stock decrease end

        if (!empty($prodduct_id_array)) {
            $prodduct_id_array = $prodduct_id_array = array_unique($prodduct_id_array);
            $prodduct_id_array = implode(',', $prodduct_id_array);
        } else {
            $prodduct_id_array = '';
        }

        // $tax_price = $data['final_tax_price'];

        // $tax_price = 0;
        // if(Auth::guest()){
        //     if (!empty($taxes)) {
        //         foreach ($taxes as $key => $tax) {
        //             $tax_price += $tax['tax_price'];
        //         }
        //     }
        // }
        // else{
        //     if (!empty($taxes)) {
        //         foreach ($taxes as $key => $tax) {
        //             $tax_price += $tax->tax_price;
        //         }
        //     }
        // }

        $product_reward_point = Utility::reward_point_count($cartlist_final_price, $theme_id);

        $product_order_id  = '0'. date('YmdHis');
        $is_guest = 1;

        if(Auth::check()) {
            $product_order_id  = $user_id . date('YmdHis');
            $is_guest = 0;
        }

        $f_price = $final_price + $tax_price + $delivery_price - $coupon_price;

        // add in  Order table  start
        $order = new Order();
        $order->product_order_id = $product_order_id;
        $order->order_date = date('Y-m-d H:i:s');
        $order->user_id = !empty($user_id) ? $user_id : 0;
        $order->is_guest = $is_guest;
        $order->product_id = $prodduct_id_array;
        $order->product_json = json_encode($products);
        // $order->product_price = $final_price;
        $order->product_price = $final_sub_total_price;
        $order->coupon_price = $coupon_price;
        $order->delivery_price = $delivery_price;
        $order->tax_price = $tax_price;
        // $order->final_price = $f_price;
        if($plan->shipping_method == "on")
        {
            $order->final_price = $data['shipping_total_price'];
        }
        else{
            $order->final_price = $final_price;
        }
        $order->payment_comment = !empty($request_data['payment_comment']) ? $request_data['payment_comment'] : '';
        $order->payment_type = $request_data['payment_type'];
        $order->payment_status = 'Paid';
        $order->delivery_id = $requests_data['method_id'] ?? 0;
        $order->delivery_comment = !empty($request_data['delivery_comment']) ? $request_data['delivery_comment'] : '';
        $order->delivered_status = 0;
        $order->reward_points = SetNumber($product_reward_point);
        $order->additional_note = $request->additional_note;
        $order->theme_id = $theme_id;
        $order->store_id = $store->id;
        $order->save();
        Utility::paymentWebhook($order);
        // add in  Order table end

        $billing_city_id = 0;
        if (!empty($billing['billing_city'])) {
            $cityy = City::where('name', $billing['billing_city'])->first();
            if (!empty($cityy)) {
                $billing_city_id = $cityy->id;
            } else {
                $new_billing_city = new City();
                $new_billing_city->name = $billing['billing_city'];
                $new_billing_city->state_id = $billing['billing_state'];
                $new_billing_city->country_id = $billing['billing_country'];
                $new_billing_city->save();
                $billing_city_id = $new_billing_city->id;
            }
        }

        $delivery_city_id = 0;
        if (!empty($billing['delivery_city'])) {
            $d_cityy = City::where('name', $billing['delivery_city'])->first();
            if (!empty($d_cityy)) {
                $delivery_city_id = $d_cityy->id;
            } else {
                $new_delivery_city = new City();
                $new_delivery_city->name = $billing['delivery_city'];
                $new_delivery_city->state_id = $billing['delivery_state'];
                $new_delivery_city->country_id = $billing['delivery_country'];
                $new_delivery_city->save();
                $delivery_city_id = $new_delivery_city->id;
            }
        }

        $OrderBillingDetail = new OrderBillingDetail();
        $OrderBillingDetail->order_id = $order->id;
        $OrderBillingDetail->product_order_id = $order->product_order_id;
        $OrderBillingDetail->first_name = !empty($billing['firstname']) ? $billing['firstname'] : '';
        $OrderBillingDetail->last_name = !empty($billing['lastname']) ? $billing['lastname'] : '';
        $OrderBillingDetail->email = !empty($billing['email']) ? $billing['email'] : '';
        $OrderBillingDetail->telephone = !empty($billing['billing_user_telephone']) ? $billing['billing_user_telephone'] : '';
        $OrderBillingDetail->address = !empty($billing['billing_address']) ? $billing['billing_address'] : '';
        $OrderBillingDetail->postcode = !empty($billing['billing_postecode']) ? $billing['billing_postecode'] : '';
        $OrderBillingDetail->country = !empty($billing['billing_country']) ? $billing['billing_country'] : '';
        $OrderBillingDetail->state = !empty($billing['billing_state']) ? $billing['billing_state'] : '';
        $OrderBillingDetail->city = $billing_city_id;
        $OrderBillingDetail->theme_id = $theme_id;
        $OrderBillingDetail->delivery_address = !empty($billing['delivery_address']) ? $billing['delivery_address'] : '';
        $OrderBillingDetail->delivery_city = $delivery_city_id;
        $OrderBillingDetail->delivery_postcode = !empty($billing['delivery_postcode']) ? $billing['delivery_postcode'] : '';
        $OrderBillingDetail->delivery_country = !empty($billing['delivery_country']) ? $billing['delivery_country'] : '';
        $OrderBillingDetail->delivery_state = !empty($billing['delivery_state']) ? $billing['delivery_state'] : '';
        $OrderBillingDetail->save();

        // add in Order Coupon Detail table start
        if (!empty($request_data['coupon_info'])) {
            // coupon stock decrease start
            $coupon_data = $request_data['coupon_info'];
            $Coupon = Coupon::find($coupon_data['coupon_id']);

        // coupon stock decrease end

            // Order Coupon history
            $OrderCouponDetail = new OrderCouponDetail();
            $OrderCouponDetail->order_id = $order->id;
            $OrderCouponDetail->product_order_id = $order->product_order_id;
            $OrderCouponDetail->coupon_id = $coupon_data['coupon_id'];
            $OrderCouponDetail->coupon_name = $coupon_data['coupon_name'];
            $OrderCouponDetail->coupon_code = $coupon_data['coupon_code'];
            $OrderCouponDetail->coupon_discount_type = $coupon_data['coupon_discount_type'];
            $OrderCouponDetail->coupon_discount_number = $coupon_data['coupon_discount_number'];
            $OrderCouponDetail->coupon_discount_amount = $coupon_data['coupon_discount_amount'];
            $OrderCouponDetail->coupon_final_amount = $coupon_data['coupon_final_amount'];
            $OrderCouponDetail->theme_id = $theme_id;
            $OrderCouponDetail->save();

            // Coupon history
            $UserCoupon = new UserCoupon();
            $UserCoupon->user_id = !empty($request_data['user_id']) ? $request_data['user_id'] : '0';
            $UserCoupon->coupon_id = $Coupon->id;
            $UserCoupon->amount = $coupon_data['coupon_discount_amount'];
            $UserCoupon->order_id = $order->id;
            $UserCoupon->date_used = now();
            $UserCoupon->theme_id = $theme_id;
            $UserCoupon->save();

            $discount_string = '-' . $coupon_data['coupon_discount_amount'];
            $CURRENCY = Utility::GetValueByName('CURRENCY');
            $CURRENCY_NAME = Utility::GetValueByName('CURRENCY_NAME');
            if ($coupon_data['coupon_discount_type'] == 'flat') {
                $discount_string .= $CURRENCY;
            } else {
                $discount_string .= '%';
            }

            $discount_string .= ' ' . __('for all products');
            $order_array['coupon']['code'] = $coupon_data['coupon_code'];
            $order_array['coupon']['discount_string'] = $discount_string;
            $order_array['coupon']['price'] = SetNumber($coupon_data['coupon_final_amount']);
        }
        // add in Order Coupon Detail table end


        // add in Order Tax Detail table start
        if(Auth::guest()){
            if (!empty($taxes)) {
                foreach ($taxes as $key => $tax) {
                    $OrderTaxDetail = new OrderTaxDetail();
                    $OrderTaxDetail->order_id = $order->id;
                    $OrderTaxDetail->product_order_id = $order->product_order_id;
                    $OrderTaxDetail->tax_id = $tax['id'];
                    $OrderTaxDetail->tax_name = $tax['tax_name'];
                    $OrderTaxDetail->tax_discount_type = $tax['tax_type'];
                    $OrderTaxDetail->tax_discount_amount = $tax['tax_amount'];
                    $OrderTaxDetail->tax_final_amount = $tax['tax_price'];
                    $OrderTaxDetail->theme_id = $theme_id;
                    $OrderTaxDetail->save();

                    $order_array['tax'][$key]['tax_string'] = $tax['tax_string'];
                    $order_array['tax'][$key]['tax_price'] = $tax['tax_price'];
                }
            }
        }
        else
        {
            if (!empty($taxes)) {
                foreach ($taxes as $key => $tax) {
                    $OrderTaxDetail = new OrderTaxDetail();
                    $OrderTaxDetail->order_id = $order->id;
                    $OrderTaxDetail->product_order_id = $order->product_order_id;
                    $OrderTaxDetail->tax_id = $tax->id;
                    $OrderTaxDetail->tax_name = $tax->tax_name;
                    $OrderTaxDetail->tax_discount_type = $tax->tax_type;
                    $OrderTaxDetail->tax_discount_amount = $tax->tax_amount;
                    $OrderTaxDetail->tax_final_amount = $tax->tax_price;
                    $OrderTaxDetail->theme_id = $theme_id;
                    $OrderTaxDetail->save();

                    $order_array['tax'][$key]['tax_string'] = $tax->tax_string;
                    $order_array['tax'][$key]['tax_price'] = $tax->tax_price;
                }
            }
        }

        //activity log
        ActivityLog::order_entry(['user_id'=>$order->user_id ,
        'order_id'=> $order->product_order_id ,
        'order_date' => $order->order_date ,
        'products' =>$order->product_id,
        'final_price' =>$order->final_price,
        'payment_type' =>$order->payment_type,
        'theme_id'=>$order->theme_id,
        'store_id'=>$order->store_id]);

        //Order Mail
        $order_email = $OrderBillingDetail->email;
        $owner=Admin::find($store->created_by);
        $owner_email=$owner->email;
        $order_id    = Crypt::encrypt($order->id);

        try
        {
            $dArr = [
            'order_id' => $order->product_order_id,
            ];


            // Send Email
            $resp = Utility::sendEmailTemplate('Order Created', $order_email, $dArr, $owner,$store, $order_id);
            $resp1=Utility::sendEmailTemplate('Order Created For Owner', $owner_email, $dArr,$owner, $store, $order_id);
        }
        catch(\Exception $e)
        {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        }
        try{
            $msg = __("Hello, Welcome to $store->name .Hi,your order id is $order->product_order_id, Thank you for Shopping We received your purchase request, we'll be in touch shortly!. ") ;
            $mess = Utility::SendMsgs('Order Created',$OrderBillingDetail->telephone, $msg);
        } catch(\Exception $e)
        {
            $smtp_error = __('Invalid OAuth access token - Cannot parse access token');
        }

        foreach ($products as $product) {
            $product_data = Product::find($product->product_id);

            if ($product_data) {
                if ($product_data->variant_product == 0) {
                    if ($product_data->track_stock == 1) {
                        OrderNote::order_note_data([
                            'user_id' => !empty($request->user_id) ? $request->user_id : '0',
                            'order_id' => $order->id,
                            'product_name' => !empty($product_data->name)?$product_data->name: '',
                            'variant_product' => $product_data->variant_product,
                            'product_stock' => !empty($product_data->product_stock) ? $product_data->product_stock : '',
                            'status' => 'Stock Manage',
                            'theme_id' => $order->theme_id,
                            'store_id' => $order->store_id,
                        ]);
                    }
                } else {

                    $variant_data = ProductStock::find($product->variant_id);
                    $variationOptions = explode(',', $variant_data->variation_option);
                    $option = in_array('manage_stock', $variationOptions);
                    if ($option == true) {
                        OrderNote::order_note_data([
                            'user_id' => !empty($request->user_id) ? $request->user_id : '0',
                            'order_id' => !empty($order->id) ? $order->id : '',
                            'product_name' => !empty($product_data->name)?$product_data->name: '',
                            'variant_product' => $product_data->variant_product,
                            'product_variant_name' => !empty($variant_data->variant) ? $variant_data->variant : '',
                            'product_stock' => !empty($variant_data->stock) ? $variant_data->stock : '',
                            'status' => 'Stock Manage',
                            'theme_id' => $order->theme_id,
                            'store_id' => $order->store_id,
                        ]);
                    }
                }
            }
        }

        OrderNote::order_note_data([
            'user_id' => !empty($request->user_id) ? $request->user_id : '0',
            'order_id' => $order->id,
            'product_order_id' => $order->product_order_id,
            'delivery_status' => 'Pending',
            'status' => 'Order Created',
            'theme_id' => $order->theme_id,
            'store_id' => $order->store_id
        ]);

        // add in Order Tax Detail table end

        if (!empty($order) && !empty($OrderBillingDetail) && !empty($OrderTaxDetail)) {


            $order_array['order_id'] = $order->id;

            // Order jason
            $order_complete_json_path = base_path('themes/' . $theme_id . '/theme_json/order-complete.json');
            $order_complete_json = json_decode(file_get_contents($order_complete_json_path), true);

            $order_complate_title = $order_complete_json[0]["inner-list"][0]['field_default_text'];
            $order_complate_description = $order_complete_json[0]["inner-list"][1]['field_default_text'];

            $setting_order_complete_json = AppSetting::where('theme_id', $theme_id)
                ->where('page_name', 'order_complete')
                ->first();
            if (!empty($setting_order_complete_json)) {
                $order_complete_json_array_data = json_decode($setting_order_complete_json->theme_json, true);

                $order_complate_title = $order_complete_json_array_data[0]["inner-list"][0]['value'];
                $order_complate_description = $order_complete_json_array_data[0]["inner-list"][1]['value'];
            }
            $order_complete_json_array["order-complate"]["order-complate-title"] = $order_complate_title . ' #' . $order->product_order_id;
            $order_complete_json_array["order-complate"]["order-complate-description"] = $order_complate_description;


            // return $this->success(['order_id' => $order->id, 'complete_order' => $order_complete_json_array]);
            $cart_array = [];
            $cart_json = json_encode($cart_array);
            Cookie::queue('cart', $cart_json, 1440);

            return redirect()->route('order.summary',$slug)->with('data',$order->product_order_id);

        } else {
            return $this->error(['message' => 'Somthing went wrong.']);
        }
    }
}
