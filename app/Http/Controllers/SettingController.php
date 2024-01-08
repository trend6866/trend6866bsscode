<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Mail\TestMail;
use App\Models\Setting;
use App\Models\Utility;
use App\Models\Theme;
use App\Models\Admin;
use App\Models\Plan;
use App\Models\PixelFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\country;
use App\Models\state;
use App\Models\City;
use App\Models\WhatsappMessage;
use App\Models\Webhook;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            $this->store = Store::where('id', $this->user->current_store)->first();
            $this->APP_THEME = $this->store->theme_id;

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : $this->APP_THEME;
        $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();
        $slug = $this->store->slug;
        if (empty($settings)) {
            $settings = Utility::Seting();
        }
        $themes = Theme::all();

        $user = \Auth::guard('admin')->user();

        if ($user->type == 'superadmin') {
            $countries = country::get();
            $country_id = !empty($request->country) ? $request->country : 1;
            $states = state::where('country_id', $country_id)->get();

            $state_id = !empty($request->state_id) ? $request->state_id : 1;
            $cities = City::where('state_id', $state_id)->get();
            if (!empty($request->state_id) || !empty($request->country)) {
                $filter_data = 'filtered';
            } else {
                $filter_data = null;
            }
        } else {
            $plan = Plan::find($user->plan);
            if (!empty($plan->themes)) {
                $themes = explode(',', $plan->themes);
            }
            $PixelFields = PixelFields::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();
            $store_settings = Store::where('id', getCurrentStore())->first();
            $webhooks = Webhook::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();
            try {
                $pwa_data = \File::get(storage_path('uploads/customer_app/store_' . $store_settings->id . '/manifest.json'));
                $pwa_data = json_decode($pwa_data);
            } catch (\Throwable $th) {
                $pwa_data = '';
            }

            return view('setting.index', compact('slug', 'settings', 'themes', 'themes', 'user', 'PixelFields', 'pwa_data', 'plan', 'store_settings', 'webhooks'));
        }

        return view('setting.index', compact('slug', 'settings', 'themes', 'themes', 'user', 'countries', 'country_id', 'states', 'state_id', 'cities', 'filter_data'));
    }

    public function SiteSetting(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'date_format' => 'required'
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : $this->APP_THEME;
        $post['date_format'] = $request->date_format;

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard('admin')->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }


        return redirect()->back()->with('success', __('Setting successfully updated.'));
    }

    public function PaymentSetting(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';
        $validator = \Validator::make(
            $request->all(),
            [
                'CURRENCY_NAME' => 'required',
                'CURRENCY' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        /* **********************
        CURRENCY
        ********************** */
        $post['CURRENCY'] = $request->CURRENCY;
        $post['CURRENCY_NAME'] = $request->CURRENCY_NAME;



        /* ****************
        COD
        ***************** */
        if ($request->is_cod_enabled == 'on' && !empty($request->cod_image)) {
            $theme_image = $request->cod_image;
            $image = upload_theme_image($theme_id, $theme_image);
            if ($image['status'] == false) {
                return redirect()->back()->with('error', $image['message']);
            } else {
                $where = ['name' => 'cod_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(base_path($Setting->value))) {
                        File::delete(base_path($Setting->value));
                    }
                }

                $post['cod_image'] = $image['image_path'];
            }
        }

        if ($request->is_cod_enabled == 'off') {
            $request->cod_info = '';
        }

        $post['cod_info'] = $request->cod_info;
        $post['is_cod_enabled'] = $request->is_cod_enabled;


        /* ****************
        Bank Transfer
        ***************** */


        $post['is_bank_transfer_enabled'] = $request->is_bank_transfer_enabled;

        if ($request->is_bank_transfer_enabled == 'on' && !empty($request->bank_transfer_image)) {
            $bank_transfer_image1 = $request->bank_transfer_image;
            $bank_transfer_image = upload_theme_image($theme_id, $bank_transfer_image1);
            if ($bank_transfer_image['status'] == false) {
                return redirect()->back()->with('error', $bank_transfer_image['message']);
            } else {
                $where = ['name' => 'bank_transfer_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(base_path($Setting->value))) {
                        File::delete(base_path($Setting->value));
                    }
                }

                $post['bank_transfer_image'] = $bank_transfer_image['image_path'];
            }
        }
        if ($request->is_bank_transfer_enabled == 'off') {
            $request->bank_transfer = '';
        }
        $post['bank_transfer'] = $request->bank_transfer;


        /* ****************
        Stripe
        ***************** */

        $post['is_stripe_enabled'] = $request->is_stripe_enabled;


        if ($request->is_stripe_enabled == 'on' && !empty($request->stripe_image)) {
            $stripe_image1 = $request->stripe_image;
            $stripe_image = upload_theme_image($theme_id, $stripe_image1);
            if ($stripe_image['status'] == false) {
                return redirect()->back()->with('error', $stripe_image['message']);
            } else {
                $where = ['name' => 'stripe_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['stripe_image'] = $stripe_image['image_path'];
            }
        }


        $post['publishable_key'] = !empty($request->publishable_key) ? $request->publishable_key : '';
        $post['stripe_secret'] = !empty($request->stripe_secret) ? $request->stripe_secret : '';
        $post['stripe_unfo'] = !empty($request->stripe_unfo) ? $request->stripe_unfo : '';
        if ($request->is_stripe_enabled == 'off') {
            $post['publishable_key'] = '';
            $post['stripe_secret'] = '';
            $post['stripe_unfo'] = '';
        }

        /* ****************
        paystack
        ***************** */
        $post['is_paystack_enabled'] = $request->is_paystack_enabled;

        if ($request->is_paystack_enabled == 'on' && !empty($request->paystack_image)) {
            $paystack_image1 = $request->paystack_image;
            $paystack_image = upload_theme_image($theme_id, $paystack_image1);
            if ($paystack_image['status'] == false) {
                return redirect()->back()->with('error', $paystack_image['message']);
            } else {
                $where = ['name' => 'paystack_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['paystack_image'] = $paystack_image['image_path'];
            }
        }

        $post['paystack_public_key'] = !empty($request->paystack_public_key) ? $request->paystack_public_key : '';
        $post['paystack_secret'] = !empty($request->paystack_secret) ? $request->paystack_secret : '';
        $post['paystack_unfo'] = !empty($request->paystack_unfo) ? $request->paystack_unfo : '';
        if ($request->is_paystack_enabled == 'off') {
            $post['paystack_public_key'] = '';
            $post['paystack_secret'] = '';
            $post['paystack_unfo'] = '';
        }

        /* ****************
        Razorpay
        ***************** */
        $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;

        if ($request->is_razorpay_enabled == 'on' && !empty($request->razorpay_image)) {
            $razorpay_image1 = $request->razorpay_image;
            $razorpay_image = upload_theme_image($theme_id, $razorpay_image1);
            if ($razorpay_image['status'] == false) {
                return redirect()->back()->with('error', $razorpay_image['message']);
            } else {
                $where = ['name' => 'razorpay_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['razorpay_image'] = $razorpay_image['image_path'];
            }
        }

        $post['razorpay_public_key'] = !empty($request->razorpay_public_key) ? $request->razorpay_public_key : '';
        $post['razorpay_secret_key'] = !empty($request->razorpay_secret_key) ? $request->razorpay_secret_key : '';
        $post['razorpay_unfo'] = !empty($request->razorpay_unfo) ? $request->razorpay_unfo : '';
        if ($request->is_razorpay_enabled == 'off') {
            $post['razorpay_public_key'] = '';
            $post['razorpay_secret_key'] = '';
            $post['razorpay_unfo'] = '';
        }

        /* ****************
        Mercado Pago
        ***************** */
        $post['is_mercado_enabled'] = $request->is_mercado_enabled;

        if ($request->is_mercado_enabled == 'on' && !empty($request->mercado_image)) {
            $mercado_image1 = $request->mercado_image;
            $mercado_image = upload_theme_image($theme_id, $mercado_image1);
            if ($mercado_image['status'] == false) {
                return redirect()->back()->with('error', $mercado_image['message']);
            } else {
                $where = ['name' => 'mercado_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['mercado_image'] = $mercado_image['image_path'];
            }
        }
        $post['mercado_mode'] = !empty($request->mercado_mode) ? $request->mercado_mode : '';
        $post['mercado_access_token'] = !empty($request->mercado_access_token) ? $request->mercado_access_token : '';
        $post['mercado_unfo'] = !empty($request->mercado_unfo) ? $request->mercado_unfo : '';
        if ($request->is_mercado_enabled == 'off') {
            $post['mercado_mode'] = '';
            $post['mercado_access_token'] = '';
            $post['mercado_unfo'] = '';
        }

        /* ****************
        Skrill
        ***************** */
        $post['is_skrill_enabled'] = $request->is_skrill_enabled;

        if ($request->is_skrill_enabled == 'on' && !empty($request->skrill_image)) {
            $skrill_image1 = $request->skrill_image;
            $skrill_image = upload_theme_image($theme_id, $skrill_image1);
            if ($skrill_image['status'] == false) {
                return redirect()->back()->with('error', $skrill_image['message']);
            } else {
                $where = ['name' => 'skrill_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['skrill_image'] = $skrill_image['image_path'];
            }
        }
        $post['skrill_mode'] = !empty($request->skrill_mode) ? $request->skrill_mode : '';
        $post['skrill_email'] = !empty($request->skrill_email) ? $request->skrill_email : '';
        $post['skrill_unfo'] = !empty($request->skrill_unfo) ? $request->skrill_unfo : '';
        if ($request->is_skrill_enabled == 'off') {
            $post['skrill_mode'] = '';
            $post['skrill_email'] = '';
            $post['skrill_unfo'] = '';
        }

        /* ****************
        PaymentWall
        ***************** */
        $post['is_paymentwall_enabled'] = $request->is_paymentwall_enabled;

        if ($request->is_paymentwall_enabled == 'on' && !empty($request->paymentwall_image)) {
            $paymentwall_image1 = $request->paymentwall_image;
            $paymentwall_image = upload_theme_image($theme_id, $paymentwall_image1);
            if ($paymentwall_image['status'] == false) {
                return redirect()->back()->with('error', $paymentwall_image['message']);
            } else {
                $where = ['name' => 'paymentwall_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['paymentwall_image'] = $paymentwall_image['image_path'];
            }
        }
        $post['paymentwall_public_key'] = !empty($request->paymentwall_public_key) ? $request->paymentwall_public_key : '';
        $post['paymentwall_private_key'] = !empty($request->paymentwall_private_key) ? $request->paymentwall_private_key : '';
        $post['paymentwall_unfo'] = !empty($request->paymentwall_unfo) ? $request->paymentwall_unfo : '';
        if ($request->is_paymentwall_enabled == 'off') {
            $post['paymentwall_public_key'] = '';
            $post['paymentwall_private_key'] = '';
            $post['paymentwall_unfo'] = '';
        }

        /* ****************
        Paypal
        ***************** */

        $post['is_paypal_enabled'] = $request->is_paypal_enabled;

        if ($request->is_paypal_enabled == 'on' && !empty($request->paypal_image)) {
            $stripe_image1 = $request->paypal_image;
            $paypal_image = upload_theme_image($theme_id, $stripe_image1);
            if ($paypal_image['status'] == false) {
                return redirect()->back()->with('error', $paypal_image['message']);
            } else {
                $where = ['name' => 'paypal_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }

                $post['paypal_image'] = $paypal_image['image_path'];
            }
        }
        $post['paypal_client_id'] = !empty($request->paypal_client_id) ? $request->paypal_client_id : '';
        $post['paypal_secret'] = !empty($request->paypal_secret) ? $request->paypal_secret : '';
        $post['paypal_mode'] = !empty($request->paypal_mode) ? $request->paypal_mode : '';
        $post['paypal_unfo'] = !empty($request->paypal_unfo) ? $request->paypal_unfo : '';


        if ($request->is_paypal_enabled == 'off') {
            $post['paypal_client_id'] = '';
            $post['paypal_secret'] = '';
            $post['paypal_mode'] = '';
            $post['paypal_unfo'] = '';
        }

        /* ****************
        Flutterwave
        ***************** */
        $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;


        if ($request->is_flutterwave_enabled == 'on' && !empty($request->flutterwave_image)) {
            $flutterwave_image1 = $request->flutterwave_image;
            $flutterwave_image = upload_theme_image($theme_id, $flutterwave_image1);
            if ($flutterwave_image['status'] == false) {
                return redirect()->back()->with('error', $flutterwave_image['message']);
            } else {
                $where = ['name' => 'flutterwave_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['flutterwave_image'] = $flutterwave_image['image_path'];
            }
        }
        $post['public_key'] = !empty($request->public_key) ? $request->public_key : '';
        $post['flutterwave_secret'] = !empty($request->flutterwave_secret) ? $request->flutterwave_secret : '';
        $post['flutterwave_unfo'] = !empty($request->flutterwave_unfo) ? $request->flutterwave_unfo : '';

        if ($request->is_flutterwave_enabled == 'off') {
            $post['public_key'] = '';
            $post['flutterwave_secret'] = '';
            $post['flutterwave_unfo'] = '';
        }

        /* ****************
        Paytm
        ***************** */
        $post['is_paytm_enabled'] = $request->is_paytm_enabled;

        if ($request->is_paytm_enabled == 'on' && !empty($request->paytm_image)) {
            $paytm_image1 = $request->paytm_image;
            $paytm_image = upload_theme_image($theme_id, $paytm_image1);
            if ($paytm_image['status'] == false) {
                return redirect()->back()->with('error', $paytm_image['message']);
            } else {
                $where = ['name' => 'paytm_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['paytm_image'] = $paytm_image['image_path'];
            }
        }
        $post['paytm_merchant_id'] = !empty($request->paytm_merchant_id) ? $request->paytm_merchant_id : '';
        $post['paytm_merchant_key'] = !empty($request->paytm_merchant_key) ? $request->paytm_merchant_key : '';
        $post['paytm_industry_type'] = !empty($request->paytm_industry_type) ? $request->paytm_industry_type : '';
        $post['paytm_mode'] = !empty($request->paytm_mode) ? $request->paytm_mode : '';
        $post['paytm_unfo'] = !empty($request->paytm_unfo) ? $request->paytm_unfo : '';

        if ($request->is_paytm_enabled == 'off') {
            $post['paytm_merchant_id'] = '';
            $post['paytm_merchant_key'] = '';
            $post['paytm_industry_type'] = '';
            $post['paytm_mode'] = '';
            $post['paytm_unfo'] = '';
        }

        /*****************
        mollie
         ******************/
        $post['is_mollie_enabled'] = $request->is_mollie_enabled;


        if ($request->is_mollie_enabled == 'on' && !empty($request->mollie_image)) {
            $mollie_image1 = $request->mollie_image;
            $mollie_image = upload_theme_image($theme_id, $mollie_image1);
            if ($mollie_image['status'] == false) {
                return redirect()->back()->with('error', $mollie_image['message']);
            } else {
                $where = ['name' => 'mollie_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['mollie_image'] = $mollie_image['image_path'];
            }
        }
        $post['mollie_api_key'] = !empty($request->mollie_api_key) ? $request->mollie_api_key : '';
        $post['mollie_profile_id'] = !empty($request->mollie_profile_id) ? $request->mollie_profile_id : '';
        $post['mollie_partner_id'] = !empty($request->mollie_partner_id) ? $request->mollie_partner_id : '';
        $post['mollie_unfo'] = !empty($request->mollie_unfo) ? $request->mollie_unfo : '';

        if ($request->is_mollie_enabled == 'off') {
            $post['mollie_api_key'] = '';
            $post['mollie_profile_id'] = '';
            $post['mollie_partner_id'] = '';
            $post['mollie_unfo'] = '';
        }

        /*****************
        coingate
         ******************/
        $post['is_coingate_enabled'] = $request->is_coingate_enabled;


        if ($request->is_coingate_enabled == 'on' && !empty($request->coingate_image)) {
            $coingate_image1 = $request->coingate_image;
            $coingate_image = upload_theme_image($theme_id, $coingate_image1);
            if ($coingate_image['status'] == false) {
                return redirect()->back()->with('error', $coingate_image['message']);
            } else {
                $where = ['name' => 'coingate_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['coingate_image'] = $coingate_image['image_path'];
            }
        }
        $post['coingate_mode'] = !empty($request->coingate_mode) ? $request->coingate_mode : '';
        $post['coingate_auth_token'] = !empty($request->coingate_auth_token) ? $request->coingate_auth_token : '';
        $post['coingate_unfo'] = !empty($request->coingate_unfo) ? $request->coingate_unfo : '';

        if ($request->is_coingate_enabled == 'off') {
            $post['coingate_mode'] = '';
            $post['coingate_auth_token'] = '';
            $post['coingate_unfo'] = '';
        }

        /*****************
            sspay
         ******************/
        $post['is_sspay_enabled'] = $request->is_sspay_enabled;

        if ($request->is_sspay_enabled == 'on' && !empty($request->sspay_image)) {
            $sspay_image1 = $request->sspay_image;
            $sspay_image = upload_theme_image($theme_id, $sspay_image1);
            if ($sspay_image['status'] == false) {
                return redirect()->back()->with('error', $sspay_image['message']);
            } else {
                $where = ['name' => 'sspay_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['sspay_image'] = $sspay_image['image_path'];
            }
        }
        $post['sspay_category_code'] = !empty($request->sspay_category_code) ? $request->sspay_category_code : '';
        $post['sspay_secret_key'] = !empty($request->sspay_secret_key) ? $request->sspay_secret_key : '';
        $post['sspay_unfo'] = !empty($request->sspay_unfo) ? $request->sspay_unfo : '';

        if ($request->is_sspay_enabled == 'off') {
            $post['sspay_category_code'] = '';
            $post['sspay_secret_key'] = '';
            $post['sspay_unfo'] = '';
        }

        /*****************
            Toyyibpay
         ******************/
        $post['is_toyyibpay_enabled'] = $request->is_toyyibpay_enabled;

        if ($request->is_toyyibpay_enabled == 'on' && !empty($request->toyyibpay_image)) {
            $toyyibpay_image1 = $request->toyyibpay_image;
            $toyyibpay_image = upload_theme_image($theme_id, $toyyibpay_image1);
            if ($toyyibpay_image['status'] == false) {
                return redirect()->back()->with('error', $toyyibpay_image['message']);
            } else {
                $where = ['name' => 'toyyibpay_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['toyyibpay_image'] = $toyyibpay_image['image_path'];
            }
        }
        $post['toyyibpay_category_code'] = !empty($request->toyyibpay_category_code) ? $request->toyyibpay_category_code : '';
        $post['toyyibpay_secret_key'] = !empty($request->toyyibpay_secret_key) ? $request->toyyibpay_secret_key : '';
        $post['toyyibpay_unfo'] = !empty($request->toyyibpay_unfo) ? $request->toyyibpay_unfo : '';

        if ($request->is_toyyibpay_enabled == 'off') {
            $post['toyyibpay_category_code'] = '';
            $post['toyyibpay_secret_key'] = '';
            $post['toyyibpay_unfo'] = '';
        }

        /*****************
            paytabs
         ******************/
        $post['is_paytabs_enabled'] = $request->is_paytabs_enabled;

        if ($request->is_paytabs_enabled == 'on' && !empty($request->paytabs_image)) {
            $paytabs_image1 = $request->paytabs_image;
            $paytabs_image = upload_theme_image($theme_id, $paytabs_image1);
            if ($paytabs_image['status'] == false) {
                return redirect()->back()->with('error', $paytabs_image['message']);
            } else {
                $where = ['name' => 'paytabs_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['paytabs_image'] = $paytabs_image['image_path'];
            }
        }
        $post['paytabs_profile_id'] = !empty($request->paytabs_profile_id) ? $request->paytabs_profile_id : '';
        $post['paytabs_server_key'] = !empty($request->paytabs_server_key) ? $request->paytabs_server_key : '';
        $post['paytabs_region'] = !empty($request->paytabs_region) ? $request->paytabs_region : '';
        $post['paytabs_unfo'] = !empty($request->paytabs_unfo) ? $request->paytabs_unfo : '';

        if ($request->is_paytabs_enabled == 'off') {
            $post['paytabs_profile_id'] = '';
            $post['paytabs_server_key'] = '';
            $post['paytabs_region'] = '';
            $post['paytabs_unfo'] = '';
        }

        /* ****************
            Iyzipay
        ***************** */
        $post['is_iyzipay_enabled'] = $request->is_iyzipay_enabled;

        if ($request->is_iyzipay_enabled == 'on' && !empty($request->iyzipay_image)) {
            $iyzipay_image1 = $request->iyzipay_image;
            $iyzipay_image = upload_theme_image($theme_id, $iyzipay_image1);
            if ($iyzipay_image['status'] == false) {
                return redirect()->back()->with('error', $iyzipay_image['message']);
            } else {
                $where = ['name' => 'iyzipay_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['iyzipay_image'] = $iyzipay_image['image_path'];
            }
        }
        $post['iyzipay_mode'] = !empty($request->iyzipay_mode) ? $request->iyzipay_mode : '';
        $post['iyzipay_private_key'] = !empty($request->iyzipay_private_key) ? $request->iyzipay_private_key : '';
        $post['iyzipay_secret_key'] = !empty($request->iyzipay_secret_key) ? $request->iyzipay_secret_key : '';
        $post['iyzipay_unfo'] = !empty($request->iyzipay_unfo) ? $request->iyzipay_unfo : '';
        if ($request->is_iyzipay_enabled == 'off') {
            $post['iyzipay_mode'] = '';
            $post['iyzipay_private_key'] = '';
            $post['iyzipay_secret_key'] = '';
            $post['iyzipay_unfo'] = '';
        }

        /* ****************
            PayFast
        ***************** */
        $post['is_payfast_enabled'] = $request->is_payfast_enabled;

        if ($request->is_payfast_enabled == 'on' && !empty($request->payfast_image)) {
            $payfast_image1 = $request->payfast_image;
            $payfast_image = upload_theme_image($theme_id, $payfast_image1);
            if ($payfast_image['status'] == false) {
                return redirect()->back()->with('error', $payfast_image['message']);
            } else {
                $where = ['name' => 'payfast_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['payfast_image'] = $payfast_image['image_path'];
            }
        }
        $post['payfast_mode'] = !empty($request->payfast_mode) ? $request->payfast_mode : '';
        $post['payfast_merchant_id'] = !empty($request->payfast_merchant_id) ? $request->payfast_merchant_id : '';
        $post['payfast_salt_passphrase'] = !empty($request->payfast_salt_passphrase) ? $request->payfast_salt_passphrase : '';
        $post['payfast_merchant_key'] = !empty($request->payfast_merchant_key) ? $request->payfast_merchant_key : '';
        $post['payfast_unfo'] = !empty($request->payfast_unfo) ? $request->payfast_unfo : '';
        if ($request->is_payfast_enabled == 'off') {
            $post['payfast_mode'] = '';
            $post['payfast_merchant_id'] = '';
            $post['payfast_salt_passphrase'] = '';
            $post['payfast_merchant_key'] = '';
            $post['payfast_unfo'] = '';
        }

        /* ****************
            Benefit
        ***************** */
        $post['is_benefit_enabled'] = $request->is_benefit_enabled;

        if ($request->is_benefit_enabled == 'on' && !empty($request->benefit_image)) {
            $benefit_image1 = $request->benefit_image;
            $benefit_image = upload_theme_image($theme_id, $benefit_image1);
            if ($benefit_image['status'] == false) {
                return redirect()->back()->with('error', $benefit_image['message']);
            } else {
                $where = ['name' => 'benefit_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }


                $post['benefit_image'] = $benefit_image['image_path'];
            }
        }

        $post['benefit_secret_key'] = !empty($request->benefit_secret_key) ? $request->benefit_secret_key : '';
        $post['benefit_private_key'] = !empty($request->benefit_private_key) ? $request->benefit_private_key : '';
        $post['benefit_unfo'] = !empty($request->benefit_unfo) ? $request->benefit_unfo : '';
        if ($request->is_benefit_enabled == 'off') {
            $post['benefit_mode'] = '';
            $post['benefit_secret_key'] = '';
            $post['benefit_private_key'] = '';
            $post['benefit_unfo'] = '';
        }

        /* ****************
            Cashfree
        ***************** */
        $post['is_cashfree_enabled'] = $request->is_cashfree_enabled;

        if ($request->is_cashfree_enabled == 'on' && !empty($request->cashfree_image)) {
            $cashfree_image1 = $request->cashfree_image;
            $cashfree_image = upload_theme_image($theme_id, $cashfree_image1);
            if ($cashfree_image['status'] == false) {
                return redirect()->back()->with('error', $cashfree_image['message']);
            } else {
                $where = ['name' => 'cashfree_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['cashfree_image'] = $cashfree_image['image_path'];
            }
        }

        $post['cashfree_secret_key'] = !empty($request->cashfree_secret_key) ? $request->cashfree_secret_key : '';
        $post['cashfree_key'] = !empty($request->cashfree_key) ? $request->cashfree_key : '';
        $post['cashfree_unfo'] = !empty($request->cashfree_unfo) ? $request->cashfree_unfo : '';
        if ($request->is_cashfree_enabled == 'off') {
            $post['benefit_mode'] = '';
            $post['cashfree_secret_key'] = '';
            $post['cashfree_key'] = '';
            $post['cashfree_unfo'] = '';
        }

        /* ****************
            Aamarpay
        ***************** */
        $post['is_aamarpay_enabled'] = $request->is_aamarpay_enabled;

        if ($request->is_aamarpay_enabled == 'on' && !empty($request->aamarpay_image)) {
            $aamarpay_image1 = $request->aamarpay_image;
            $aamarpay_image = upload_theme_image($theme_id, $aamarpay_image1);
            if ($aamarpay_image['status'] == false) {
                return redirect()->back()->with('error', $aamarpay_image['message']);
            } else {
                $where = ['name' => 'aamarpay_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['aamarpay_image'] = $aamarpay_image['image_path'];
            }
        }

        $post['aamarpay_signature_key'] = !empty($request->aamarpay_signature_key) ? $request->aamarpay_signature_key : '';
        $post['aamarpay_description'] = !empty($request->aamarpay_description) ? $request->aamarpay_description : '';
        $post['aamarpay_store_id'] = !empty($request->aamarpay_store_id) ? $request->aamarpay_store_id : '';
        $post['aamarpay_unfo'] = !empty($request->aamarpay_unfo) ? $request->aamarpay_unfo : '';
        if ($request->is_aamarpay_enabled == 'off') {
            $post['benefit_mode'] = '';
            $post['aamarpay_signature_key'] = '';
            $post['aamarpay_description'] = '';
            $post['aamarpay_store_id'] = '';
            $post['aamarpay_unfo'] = '';
        }

        /*****************
            Telegram
         ******************/
        if (\Auth::guard('admin')->user()->type == 'admin') {
            $post['is_telegram_enabled'] = $request->is_telegram_enabled;

            if ($request->is_telegram_enabled == 'on' && !empty($request->telegram_image)) {
                $telegram_image1 = $request->telegram_image;
                $telegram_image = upload_theme_image($theme_id, $telegram_image1);
                if ($telegram_image['status'] == false) {
                    return redirect()->back()->with('error', $telegram_image['message']);
                } else {
                    $where = ['name' => 'telegram_image', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(storage_path($Setting->value))) {
                            File::delete(storage_path($Setting->value));
                        }
                    }
                    $post['telegram_image'] = $telegram_image['image_path'];
                }
            }
            $post['telegram_access_token'] = !empty($request->telegram_access_token) ? $request->telegram_access_token : '';
            $post['telegram_chat_id'] = !empty($request->telegram_chat_id) ? $request->telegram_chat_id : '';
            $post['telegram_unfo'] = !empty($request->telegram_unfo) ? $request->telegram_unfo : '';
        }

        /*****************
            Whatsapp
         ******************/
        if (\Auth::guard('admin')->user()->type == 'admin') {
            $post['is_whatsapp_enabled'] = $request->is_whatsapp_enabled;
            if (!empty($request->whatsapp_number)) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'whatsapp_number' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],

                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
            }
            if ($request->is_whatsapp_enabled == 'on' && !empty($request->whatsapp_image)) {
                $whatsapp_image1 = $request->whatsapp_image;
                $whatsapp_image = upload_theme_image($theme_id, $whatsapp_image1);
                if ($whatsapp_image['status'] == false) {
                    return redirect()->back()->with('error', $whatsapp_image['message']);
                } else {
                    $where = ['name' => 'whatsapp_image', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(storage_path($Setting->value))) {
                            File::delete(storage_path($Setting->value));
                        }
                    }
                    $post['whatsapp_image'] = $whatsapp_image['image_path'];
                }
            }
            $post['whatsapp_number'] = !empty($request->whatsapp_number) ? $request->whatsapp_number : '';
            $post['whatsapp_unfo'] = !empty($request->whatsapp_unfo) ? $request->whatsapp_unfo : '';
        }

        /* ****************
            Pay TR
        ***************** */
        $post['is_paytr_enabled'] = $request->is_paytr_enabled;

        if ($request->is_paytr_enabled == 'on' && !empty($request->paytr_image)) {
            $paytr_image1 = $request->paytr_image;
            $paytr_image = upload_theme_image($theme_id, $paytr_image1);
            if ($paytr_image['status'] == false) {
                return redirect()->back()->with('error', $paytr_image['message']);
            } else {
                $where = ['name' => 'paytr_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['paytr_image'] = $paytr_image['image_path'];
            }
        }

        $post['paytr_merchant_id'] = !empty($request->paytr_merchant_id) ? $request->paytr_merchant_id : '';
        $post['paytr_salt_key'] = !empty($request->paytr_salt_key) ? $request->paytr_salt_key : '';
        $post['paytr_merchant_key'] = !empty($request->paytr_merchant_key) ? $request->paytr_merchant_key : '';
        $post['paytr_unfo'] = !empty($request->paytr_unfo) ? $request->paytr_unfo : '';
        if ($request->is_paytr_enabled == 'off') {
            $post['paytr_merchant_id'] = '';
            $post['paytr_salt_key'] = '';
            $post['paytr_merchant_key'] = '';
            $post['paytr_unfo'] = '';
        }

        /* ****************
            Yookassa
        ***************** */
        $post['is_yookassa_enabled'] = $request->is_yookassa_enabled;

        if ($request->is_yookassa_enabled == 'on' && !empty($request->yookassa_image)) {
            $yookassa_image1 = $request->yookassa_image;
            $yookassa_image = upload_theme_image($theme_id, $yookassa_image1);
            if ($yookassa_image['status'] == false) {
                return redirect()->back()->with('error', $yookassa_image['message']);
            } else {
                $where = ['name' => 'yookassa_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['yookassa_image'] = $yookassa_image['image_path'];
            }
        }

        $post['yookassa_shop_id_key'] = !empty($request->yookassa_shop_id_key) ? $request->yookassa_shop_id_key : '';
        $post['yookassa_secret_key'] = !empty($request->yookassa_secret_key) ? $request->yookassa_secret_key : '';
        $post['yookassa_unfo'] = !empty($request->yookassa_unfo) ? $request->yookassa_unfo : '';
        if ($request->is_yookassa_enabled == 'off') {
            $post['benefit_mode'] = '';
            $post['yookassa_shop_id_key'] = '';
            $post['yookassa_secret_key'] = '';
            $post['yookassa_unfo'] = '';
        }

        /* ****************
            Xendit
        ***************** */
        $post['is_Xendit_enabled'] = $request->is_Xendit_enabled;

        if ($request->is_Xendit_enabled == 'on' && !empty($request->Xendit_image)) {
            $Xendit_image1 = $request->Xendit_image;
            $Xendit_image = upload_theme_image($theme_id, $Xendit_image1);
            if ($Xendit_image['status'] == false) {
                return redirect()->back()->with('error', $Xendit_image['message']);
            } else {
                $where = ['name' => 'Xendit_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['Xendit_image'] = $Xendit_image['image_path'];
            }
        }

        $post['Xendit_api_key'] = !empty($request->Xendit_api_key) ? $request->Xendit_api_key : '';
        $post['Xendit_token_key'] = !empty($request->Xendit_token_key) ? $request->Xendit_token_key : '';
        $post['Xendit_unfo'] = !empty($request->Xendit_unfo) ? $request->Xendit_unfo : '';
        if ($request->is_Xendit_enabled == 'off') {
            $post['benefit_mode'] = '';
            $post['Xendit_api_key'] = '';
            $post['Xendit_token_key'] = '';
            $post['Xendit_unfo'] = '';
        }

        /* ****************
            Midtrans
        ***************** */
        $post['is_midtrans_enabled'] = $request->is_midtrans_enabled;

        if ($request->is_midtrans_enabled == 'on' && !empty($request->midtrans_image)) {
            $midtrans_image1 = $request->midtrans_image;
            $midtrans_image = upload_theme_image($theme_id, $midtrans_image1);
            if ($midtrans_image['status'] == false) {
                return redirect()->back()->with('error', $midtrans_image['message']);
            } else {
                $where = ['name' => 'midtrans_image', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(storage_path($Setting->value))) {
                        File::delete(storage_path($Setting->value));
                    }
                }
                $post['midtrans_image'] = $midtrans_image['image_path'];
            }
        }

        $post['midtrans_secret_key'] = !empty($request->midtrans_secret_key) ? $request->midtrans_secret_key : '';
        $post['midtrans_unfo'] = !empty($request->midtrans_unfo) ? $request->midtrans_unfo : '';
        if ($request->is_midtrans_enabled == 'off') {
            $post['midtrans_secret_key'] = '';
            $post['midtrans_unfo'] = '';
        }
        
        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard('admin')->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', __('Setting successfully updated.'));
    }

    public function saveEmailSettings(Request $request)
    {

        $validator = \Validator::make(
            $request->all(),
            [
                'mail_driver' => 'required|string|max:50',
                'mail_host' => 'required|string|max:50',
                'mail_port' => 'required|string|max:50',
                'mail_username' => 'required|string|max:50',
                'mail_password' => 'required|string|max:50',
                'mail_encryption' => 'required|string|max:50',
                'mail_from_address' => 'required|string|max:50',
                'mail_from_name' => 'required|string|max:50',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }


        $post['MAIL_DRIVER'] = $request->mail_driver;
        $post['MAIL_HOST'] = $request->mail_host;
        $post['MAIL_PORT'] = $request->mail_port;
        $post['MAIL_USERNAME'] = $request->mail_username;
        $post['MAIL_PASSWORD'] = $request->mail_password;
        $post['MAIL_ENCRYPTION'] = $request->mail_encryption;
        $post['MAIL_FROM_NAME'] = $request->mail_from_name;
        $post['MAIL_FROM_ADDRESS'] = $request->mail_from_address;

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard('admin')->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }


        return redirect()->back()->with('success', __('Setting successfully updated.'));
    }

    public function TestMail(Request $request)
    {
        $email_setting = $request->all();
        $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();

        $user = \Auth::user();

        $data = [];
        $data['mail_driver'] = $request->mail_driver;
        $data['mail_host'] = $request->mail_host;
        $data['mail_port'] = $request->mail_port;
        $data['mail_username'] = $request->mail_username;
        $data['mail_password'] = $request->mail_password;
        $data['mail_encryption'] = $request->mail_encryption;
        $data['mail_from_address'] = $request->mail_from_address;
        $data['mail_from_name'] = $request->mail_from_name;

        return view('setting.test_mail', compact('email_setting', 'settings', 'data'));
    }

    public function testSendMail(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'mail_driver' => 'required',
                'mail_host' => 'required',
                'mail_port' => 'required',
                'mail_username' => 'required',
                'mail_password' => 'required',
                'mail_from_address' => 'required',
                'mail_from_name' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json(
                [
                    'is_success' => false,
                    'message' => $messages->first(),
                ]
            );
        }

        try {
            config(
                [
                    'mail.driver' => $request->mail_driver,
                    'mail.host' => $request->mail_host,
                    'mail.port' => $request->mail_port,
                    'mail.encryption' => $request->mail_encryption,
                    'mail.username' => $request->mail_username,
                    'mail.password' => $request->mail_password,
                    'mail.from.address' => $request->mail_from_address,
                    'mail.from.name' => $request->mail_from_name,
                ]
            );

            Mail::to($request->email)->send(new TestMail($request));
        } catch (\Exception $e) {
            return response()->json(
                [
                    'is_success' => false,
                    'message' => $e->getMessage(),
                ]
            );
        }
        return response()->json(
            [
                'is_success' => true,
                'message' => __('Email send Successfully'),
            ]
        );
    }

    public function LoyalityProgramSettings(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : $this->APP_THEME;

        $loyality_program_enabled = !empty($request->loyality_program_enabled) ? $request->loyality_program_enabled : 'off';
        $reward_point = !empty($request->reward_point) ? $request->reward_point : 0;

        $post['loyality_program_enabled'] = $loyality_program_enabled;
        $post['reward_point'] = $reward_point;

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard('admin')->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', __('Setting successfully updated.'));
    }

    public function FirebaseSettings(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : $this->APP_THEME;

        $firebase_enabled = !empty($request->firebase_enabled) ? $request->firebase_enabled : 'off';
        $fcm_Key = !empty($request->fcm_Key) ? $request->fcm_Key : '';

        $post['firebase_enabled'] = $firebase_enabled;
        $post['fcm_Key'] = $fcm_Key;

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard('admin')->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }


        return redirect()->back()->with('success', __('Setting successfully updated.'));
    }

    public function BusinessSettings(Request $request)
    {
        $user = \Auth::guard()->user();
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';
        $dir = 'themes/' . APP_THEME() . '/uploads';
        $post = $request->all();

        if (\Auth::guard()->user()->type == 'superadmin') {
            if ($request->logo_dark) {
                $theme_image = $request->logo_dark;
                $fileName = rand(10, 100) . '_' . time() . "_" . $request->logo_dark->getClientOriginalName();
                $path = Utility::upload_file($request, 'logo_dark', $fileName, $dir, []);

                if ($path['flag'] == '0') {
                    return redirect()->back()->with('error', $path['msg']);
                } else {
                    $where = ['name' => 'logo_dark', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(base_path($Setting->value))) {
                            File::delete(base_path($Setting->value));
                        }
                    }
                    $post['logo_dark'] = $path['url'];
                }
            }
            if ($request->logo_light) {
                $theme_image = $request->logo_light;
                $fileName = rand(10, 100) . '_' . time() . "_" . $request->logo_light->getClientOriginalName();
                $path = Utility::upload_file($request, 'logo_light', $fileName, $dir, []);

                if ($path['flag'] == '0') {
                    return redirect()->back()->with('error', $path['msg']);
                } else {
                    $where = ['name' => 'logo_light', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(base_path($Setting->value))) {
                            File::delete(base_path($Setting->value));
                        }
                    }
                    $post['logo_light'] = $path['url'];
                }
            }

            if ($request->favicon) {
                $theme_image = $request->favicon;
                $fileName = rand(10, 100) . '_' . time() . "_" . $request->favicon->getClientOriginalName();
                $path = Utility::upload_file($request, 'favicon', $fileName, $dir, []);

                if ($path['flag'] == '0') {
                    return redirect()->back()->with('error', $path['msg']);
                } else {
                    $where = ['name' => 'favicon', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(base_path($Setting->value))) {
                            File::delete(base_path($Setting->value));
                        }
                    }
                    $post['favicon'] = $path['url'];
                }
            }
        } else {
            if ($request->logo_dark) {
                $theme_image = $request->logo_dark;
                $fileName = rand(10, 100) . '_' . time() . "_" . $request->logo_dark->getClientOriginalName();
                $path = Utility::upload_file($request, 'logo_dark', $fileName, $dir, []);

                if ($path['flag'] == '0') {
                    return redirect()->back()->with('error', $path['msg']);
                } else {
                    $where = ['name' => 'logo_dark', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(base_path($Setting->value))) {
                            File::delete(base_path($Setting->value));
                        }
                    }
                    $post['logo_dark'] = $path['url'];
                }
            }
            if ($request->logo_light) {
                $theme_image = $request->logo_light;
                $fileName = rand(10, 100) . '_' . time() . "_" . $request->logo_light->getClientOriginalName();
                $path = Utility::upload_file($request, 'logo_light', $fileName, $dir, []);

                if ($path['flag'] == '0') {
                    return redirect()->back()->with('error', $path['msg']);
                } else {
                    $where = ['name' => 'logo_light', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(base_path($Setting->value))) {
                            File::delete(base_path($Setting->value));
                        }
                    }
                    $post['logo_light'] = $path['url'];
                }
            }

            if ($request->favicon) {
                $theme_image = $request->favicon;
                $fileName = rand(10, 100) . '_' . time() . "_" . $request->favicon->getClientOriginalName();
                $path = Utility::upload_file($request, 'favicon', $fileName, $dir, []);

                if ($path['flag'] == '0') {
                    return redirect()->back()->with('error', $path['msg']);
                } else {
                    $where = ['name' => 'favicon', 'theme_id' => $theme_id];
                    $Setting = Setting::where($where)->first();

                    if (!empty($Setting)) {
                        if (File::exists(base_path($Setting->value))) {
                            File::delete(base_path($Setting->value));
                        }
                    }
                    $post['favicon'] = $path['url'];
                }
            }
        }

        $default_language = $request->has('default_language') ? $request->default_language : 'en';
        if (\Auth::user()->type == 'superadmin') {
            $user = Auth::user();
            $user->default_language = $default_language;
            $user->save();

            $store = Store::where('id', $user->current_store)->first();
            $store->default_language = $default_language;
            $store->save();
        } else {
            $user = Auth::user();
            $user->default_language = $default_language;
            $user->save();

            $store = Store::where('id', $user->current_store)->first();
            $store->default_language = $default_language;
            $store->save();
        }

        if (!empty($request->title_text) || !empty($request->footer_text) || !empty($request->site_date_format) || !empty($request->site_time_format) || !empty($request->color) || !empty($request->email_verification)) {
            $SITE_RTL = $request->has('SITE_RTL') ? $request->SITE_RTL : 'off';
            $post['SITE_RTL'] = $SITE_RTL;

            $SIGNUP = $request->has('SIGNUP') ? $request->SIGNUP : 'off';
            $post['SIGNUP'] = $SIGNUP;

            $display_landing = $request->has('display_landing') ? $request->display_landing : 'off';
            $post['display_landing'] = $display_landing;


            $email_verification = $request->has('email_verification') ? $request->email_verification : 'off';
            $post['email_verification'] = $email_verification;

            if (!isset($request->cust_theme_bg)) {
                $post['cust_theme_bg'] = 'off';
            }
            if (!isset($request->cust_darklayout)) {
                $post['cust_darklayout'] = 'off';
            }
            unset($post['default_language']);

            foreach ($post as $key => $data) {
                $arr = [
                    $data,
                    $key,
                    $this->APP_THEME,
                    getCurrentStore(),
                    \Auth::guard()->user()->id,
                ];
                if ($data != '') {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        $arr
                    );
                }
            }
        }
        return redirect()->back()->with('success', __('Brand setting successfully updated.'));
    }

    public function ThemeSettings(Request $request)
    {
        $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();
        if ($request->enable_domain == 'enable_domain') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'domains' => 'required',
                ]
            );
        }
        if ($request->enable_domain == 'enable_subdomain') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'subdomain' => 'required',
                ]
            );
        }

        $user = \Auth::guard()->user();
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';
        $post = $request->all();
        $dir = 'themes/' . APP_THEME() . '/uploads';

        if ($request->theme_logo) {
            $theme_image = $request->theme_logo;
            $fileName = rand(10, 100) . '_' . time() . "_" . $request->theme_logo->getClientOriginalName();
            $path = Utility::upload_file($request, 'theme_logo', $fileName, $dir, []);

            if ($path['flag'] == '0') {
                return redirect()->back()->with('error', $path['msg']);
            } else {
                $where = ['name' => 'theme_logo', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(base_path($Setting->value))) {
                        File::delete(base_path($Setting->value));
                    }
                }

                $post['theme_logo'] = $path['url'];
                \DB::insert(
                    'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $path['url'],
                        'theme_logo',
                        $this->APP_THEME,
                        getCurrentStore(),
                        \Auth::guard()->user()->id,
                    ]
                );
            }
        }
        if ($request->invoice_logo) {
            $theme_image = $request->invoice_logo;
            $fileName = rand(10, 100) . '_' . time() . "_" . $request->invoice_logo->getClientOriginalName();
            $path = Utility::upload_file($request, 'invoice_logo', $fileName, $dir, []);

            if ($path['flag'] == '0') {
                return redirect()->back()->with('error', $path['msg']);
            } else {
                $where = ['name' => 'invoice_logo', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(base_path($Setting->value))) {
                        File::delete(base_path($Setting->value));
                    }
                }

                $post['invoice_logo'] = $path['url'];
                \DB::insert(
                    'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $path['url'],
                        'invoice_logo',
                        $this->APP_THEME,
                        getCurrentStore(),
                        \Auth::guard()->user()->id,
                    ]
                );
            }
        }
        if ($request->theme_favicon) {
            $theme_image = $request->theme_favicon;
            $fileName = rand(10, 100) . '_' . time() . "_" . $request->theme_favicon->getClientOriginalName();
            $path = Utility::upload_file($request, 'theme_favicon', $fileName, $dir, []);


            if ($path['flag'] == '0') {
                return redirect()->back()->with('error', $path['msg']);
            } else {
                $where = ['name' => 'theme_favicon', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(base_path($Setting->value))) {
                        File::delete(base_path($Setting->value));
                    }
                }
                $post['theme_favicon'] = $path['url'];
                \DB::insert(
                    'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $path['url'],
                        'theme_favicon',
                        $this->APP_THEME,
                        getCurrentStore(),
                        \Auth::guard()->user()->id,
                    ]
                );
            }
        }

        if ($request->metaimage) {
            $theme_image = $request->metaimage;
            $fileName = rand(10, 100) . '_' . time() . "_" . $request->metaimage->getClientOriginalName();
            $path = Utility::upload_file($request, 'metaimage', $fileName, $dir, []);

            if ($path['flag'] == '0') {
                return redirect()->back()->with('error', $path['msg']);
            } else {
                $where = ['name' => 'metaimage', 'theme_id' => $theme_id];
                $Setting = Setting::where($where)->first();

                if (!empty($Setting)) {
                    if (File::exists(base_path($Setting->value))) {
                        File::delete(base_path($Setting->value));
                    }
                }

                $post['metaimage'] = $path['url'];
                \DB::insert(
                    'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $path['url'],
                        'metaimage',
                        $this->APP_THEME,
                        getCurrentStore(),
                        \Auth::guard()->user()->id,
                    ]
                );
            }
        }

        if ($request->enable_domain == 'enable_domain') {
            // Remove the http://, www., and slash(/) from the URL
            $input = $request->domains;
            // If URI is like, eg. www.way2tutorial.com/
            $input = trim($input, '/');
            // If not have http:// or https:// then prepend it
            if (!preg_match('#^http(s)?://#', $input)) {
                $input = 'http://' . $input;
            }

            $urlParts = parse_url($input);
            // Remove www.
            $post['domains'] = preg_replace('/^www\./', '', $urlParts['host']);
            // Output way2tutorial.com
        }
        if ($request->enable_domain == 'enable_subdomain') {
            // Remove the http://, www., and slash(/) from the URL
            $input = env('APP_URL');

            // If URI is like, eg. www.way2tutorial.com/
            $input = trim($input, '/');
            // If not have http:// or https:// then prepend it
            if (!preg_match('#^http(s)?://#', $input)) {
                $input = 'http://' . $input;
            }

            $urlParts = parse_url($input);

            // Remove www.
            $subdomain_name = preg_replace('/^www\./', '', $urlParts['host']);
            // Output way2tutorial.com
            $post['subdomain'] = $request->subdomain . '.' . $subdomain_name;
        }

        if($request->enable_storelink != null  ||$request->enable_domain != null || $request->enable_subdomain != null){
            $settings['enable_storelink'] = ($request->enable_domain == 'enable_storelink' || empty($request->enable_domain)) ? 'on' : 'off';
            $settings['enable_domain'] = ($request->enable_domain == 'enable_domain') ? 'on' : 'off';
            $settings['enable_subdomain'] = ($request->enable_domain == 'enable_subdomain') ? 'on' : 'off';
           }

        $post['enable_storelink'] = $settings['enable_storelink'];
        $post['enable_domain'] = $settings['enable_domain'];
        $post['enable_subdomain'] = $settings['enable_subdomain'];

        $additional_notes = $request->has('additional_notes') ? $request->additional_notes : 'off';
        $post['additional_notes'] = $additional_notes;

        $is_checkout_login_required = $request->has('is_checkout_login_required') ? $request->is_checkout_login_required : 'off';
        $post['is_checkout_login_required'] = $is_checkout_login_required;

        $post['store_address'] = $request->store_address;
        $post['store_city'] = $request->store_city;
        $post['store_state'] = $request->store_state;
        $post['store_zipcode'] = $request->store_zipcode;
        $post['store_country'] = $request->store_country;

        if (!empty($request->theme_name) || !empty($request->email) || !empty($request->google_analytic) || !empty($request->fbpixel_code) || !empty($request->storejs) || !empty($request->metakeyword) || !empty($request->metadesc) || !empty($request->storecss)) {

            if (!isset($request->google_analytic)) {
                $post['google_analytic'] = !empty($request->google_analytic) ? $request->google_analytic : '';
            }
            if (!isset($request->fbpixel_code)) {
                $post['fbpixel_code'] = !empty($request->fbpixel_code) ? $request->fbpixel_code : '';
            }
            if (!isset($request->storejs)) {
                $post['storejs'] = !empty($request->storejs) ? $request->storejs : '';
            }
            if (!isset($request->storecss)) {
                $post['storecss'] = !empty($request->storecss) ? $request->storecss : '';
            }
            if (!isset($request->metakeyword)) {
                $post['metakeyword'] = !empty($request->metakeyword) ? $request->metakeyword : '';
            }
            if (!isset($request->metadesc)) {
                $post['metadesc'] = !empty($request->metadesc) ? $request->metadesc : '';
            }
        }

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', __('Settings successfully updated.'));
    }

    public function StorageSettings(Request $request)
    {

        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';

        if (isset($request->storage_setting) && $request->storage_setting == 'local') {

            $request->validate(
                [

                    'local_storage_validation' => 'required',
                    'local_storage_max_upload_size' => 'required',
                ]
            );

            $post['storage_setting'] = $request->storage_setting;
            $local_storage_validation = implode(',', $request->local_storage_validation);
            $post['local_storage_validation'] = $local_storage_validation;
            $post['local_storage_max_upload_size'] = $request->local_storage_max_upload_size;
        }

        if (isset($request->storage_setting) && $request->storage_setting == 's3') {
            $request->validate(
                [
                    's3_key' => 'required',
                    's3_secret' => 'required',
                    's3_region' => 'required',
                    's3_bucket' => 'required',
                    's3_url' => 'required',
                    's3_endpoint' => 'required',
                    's3_max_upload_size' => 'required',
                    's3_storage_validation' => 'required',
                ]
            );

            $post['storage_setting'] = $request->storage_setting;
            $post['s3_key'] = $request->s3_key;
            $post['s3_secret'] = $request->s3_secret;
            $post['s3_region'] = $request->s3_region;
            $post['s3_bucket'] = $request->s3_bucket;
            $post['s3_url'] = $request->s3_url;
            $post['s3_endpoint'] = $request->s3_endpoint;
            $post['s3_max_upload_size'] = $request->s3_max_upload_size;
            $s3_storage_validation = implode(',', $request->s3_storage_validation);
            $post['s3_storage_validation'] = $s3_storage_validation;
        }

        if (isset($request->storage_setting) && $request->storage_setting == 'wasabi') {
            $request->validate(
                [
                    'wasabi_key' => 'required',
                    'wasabi_secret' => 'required',
                    'wasabi_region' => 'required',
                    'wasabi_bucket' => 'required',
                    'wasabi_url' => 'required',
                    'wasabi_root' => 'required',
                    'wasabi_max_upload_size' => 'required',
                    'wasabi_storage_validation' => 'required',
                ]
            );
            $post['storage_setting'] = $request->storage_setting;
            $post['wasabi_key'] = $request->wasabi_key;
            $post['wasabi_secret'] = $request->wasabi_secret;
            $post['wasabi_region'] = $request->wasabi_region;
            $post['wasabi_bucket'] = $request->wasabi_bucket;
            $post['wasabi_url'] = $request->wasabi_url;
            $post['wasabi_root'] = $request->wasabi_root;
            $post['wasabi_max_upload_size'] = $request->wasabi_max_upload_size;
            $wasabi_storage_validation = implode(',', $request->wasabi_storage_validation);
            $post['wasabi_storage_validation'] = $wasabi_storage_validation;
        }

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }

        return redirect()->back()->with('success', 'Storage setting successfully updated.');
    }

    public function CookieConsent(Request $request)
    {
        $settings = Utility::Seting();

        if ($settings['enable_cookie'] == "on" && $settings['cookie_logging'] == "on") {
            $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            // Generate new CSV line
            $browser_name = $whichbrowser->browser->name ?? null;
            $os_name = $whichbrowser->os->name ?? null;
            $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $device_type = Utility::get_device_type($_SERVER['HTTP_USER_AGENT']);

            $ip = $_SERVER['REMOTE_ADDR'];
            // $ip = '49.36.83.154';
            $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));


            $date = (new \DateTime())->format('Y-m-d');
            $time = (new \DateTime())->format('H:i:s') . ' UTC';


            $new_line = implode(',', [
                $ip,
                $date,
                $time,
                json_encode($request['cookie']),
                $device_type,
                $browser_language,
                $browser_name,
                $os_name,
                isset($query) ? $query['country'] : '', isset($query) ? $query['region'] : '', isset($query) ? $query['regionName'] : '', isset($query) ? $query['city'] : '', isset($query) ? $query['zip'] : '', isset($query) ? $query['lat'] : '', isset($query) ? $query['lon'] : ''
            ]);

            if (!file_exists(storage_path() . '/uploads/sample/cookie_data.csv')) {
                $first_line = 'IP,Date,Time,Accepted cookies,Device type,Browser language,Browser name,OS Name,Country,Region,RegionName,City,Zipcode,Lat,Lon';
                file_put_contents(storage_path() . '/uploads/sample/cookie_data.csv', $first_line . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            file_put_contents(storage_path() . '/uploads/sample/cookie_data.csv', $new_line . PHP_EOL, FILE_APPEND | LOCK_EX);

            return response()->json('success');
        }
        return response()->json('error');
    }

    public function saveCookieSettings(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';

        $validator = \Validator::make(
            $request->all(),
            [
                'cookie_title' => 'required',
                'cookie_description' => 'required',
                'strictly_cookie_title' => 'required',
                'strictly_cookie_description' => 'required',
                'more_information_title' => 'required',
                'contactus_url' => 'required',
            ]
        );

        $post = $request->all();

        unset($post['_token']);

        if ($request->enable_cookie) {
            $post['enable_cookie'] = 'on';
        } else {
            $post['enable_cookie'] = 'off';
        }
        if ($request->cookie_logging) {
            $post['cookie_logging'] = 'on';
        } else {

            $post['cookie_logging'] = 'off';
        }

        if ($post['enable_cookie'] == 'on') {
            $post['cookie_title'] = $request->cookie_title;
            $post['cookie_description'] = $request->cookie_description;
            $post['strictly_cookie_title'] = $request->strictly_cookie_title;
            $post['strictly_cookie_description'] = $request->strictly_cookie_description;
            $post['more_information_title'] = $request->more_information_title;
            $post['contactus_url'] = $request->contactus_url;
        }
        $settings = Utility::cookies();

        foreach ($post as $key => $data) {
            if (in_array($key, array_keys($settings))) {
                $arr = [
                    $data,
                    $key,
                    $this->APP_THEME,
                    getCurrentStore(),
                    \Auth::guard()->user()->id,
                ];

                \DB::insert(
                    'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    $arr
                );
            }
        }
        return redirect()->back()->with('success', 'Cookie setting successfully saved.');
    }

    public function savechatgptSettings(Request $request)
    {
        if (\Auth::user()->type == 'superadmin') {
            $user = \Auth::user();
            if (!empty($request->chatgpt_key)) {
                $post = $request->all();
                $post['chatgpt_key'] = $request->chatgpt_key;

                unset($post['_token']);

                \DB::insert(
                    'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $request->chatgpt_key,
                        'chatgpt_key',
                        $this->APP_THEME,
                        getCurrentStore(),
                        \Auth::guard()->user()->id,
                    ]
                );
            }
            return redirect()->back()->with('success', __('Chatgpykey successfully saved.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function recaptchaSettingStore(Request $request)
    {
        if (\Auth::user()->type == 'superadmin') {
            $user = Auth::user();
            $rules = [];
            $recaptcha_module = 'yes';
            if (!isset($request->recaptcha_module)) {
                $recaptcha_module = 'no';
            }
            if ($recaptcha_module == 'yes') {
                $rules['google_recaptcha_key'] = 'required|string|max:50';
                $rules['google_recaptcha_secret'] = 'required|string|max:50';
            }
            $validator = \Validator::make(
                $request->all(),
                $rules
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $arrEnv = [
                'RECAPTCHA_MODULE' => $recaptcha_module ?? 'no',
                'NOCAPTCHA_SITEKEY' => $request->google_recaptcha_key,
                'NOCAPTCHA_SECRET' => $request->google_recaptcha_secret,
            ];
            if (Utility::setEnvironmentValue($arrEnv)) {
                return redirect()->back()->with('success', __('Recaptcha Settings updated successfully'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function WoocommerceSettings(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';

        $post['woocommerce_setting_enabled'] = $request->woocommerce_setting_enabled;
        if (isset($request->woocommerce_setting_enabled) && $request->woocommerce_setting_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'woocommerce_store_url' => 'required|string',
                    'woocommerce_consumer_key' => 'required|string',
                    'woocommerce_consumer_secret' => 'required|string',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
        }


        $post['woocommerce_store_url'] = $request->woocommerce_store_url;
        $post['woocommerce_consumer_key'] = $request->woocommerce_consumer_key;
        $post['woocommerce_consumer_secret'] = $request->woocommerce_consumer_secret;

        if ($request->woocommerce_setting_enabled == 'off') {
            $post['woocommerce_store_url'] = '';
            $post['woocommerce_consumer_key'] = '';
            $post['woocommerce_consumer_secret'] = '';
        }


        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }
        return redirect()->back()->with('success', 'Woocommerce setting successfully updated.');
    }
    public function shopifySettings(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';

        $post['shopify_setting_enabled'] = $request->shopify_setting_enabled;
        if (isset($request->shopify_setting_enabled) && $request->shopify_setting_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'shopify_store_url' => 'required|string',
                    'shopify_access_token' => 'required|string',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
        }


        $post['shopify_store_url'] = $request->shopify_store_url;
        $post['shopify_access_token'] = $request->shopify_access_token;

        if ($request->shopify_setting_enabled == 'off') {
            $post['shopify_store_url'] = '';
            $post['shopify_access_token'] = '';
        }

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }
        return redirect()->back()->with('success', 'Woocommerce setting successfully updated.');
    }
    public function WhatsappSettings(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';

        $post['whatsapp_setting_enabled'] = $request->whatsapp_setting_enabled;
        if (isset($request->whatsapp_setting_enabled) && $request->whatsapp_setting_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'whatsapp_contact_number' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'],
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
        }


        $post['whatsapp_contact_number'] = $request->whatsapp_contact_number;

        if ($request->whatsapp_setting_enabled == 'off') {
            $post['whatsapp_contact_number'] = '';
        }


        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }
        return redirect()->back()->with('success', 'Whatsapp setting successfully updated.');
    }

    public function TwilioSettings(Request $request)
    {
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';
        $post['twilio_setting_enabled'] = $request->twilio_setting_enabled;
        if (isset($request->twilio_setting_enabled) && $request->twilio_setting_enabled == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'twilio_sid' => 'required|string',
                    'twilio_token' => 'required|string',
                    'twilio_from' => 'required|numeric',
                    'twilio_notification_number' => 'required|numeric',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
        }


        $post['twilio_sid'] = $request->twilio_sid;
        $post['twilio_token'] = $request->twilio_token;
        $post['twilio_from'] = $request->twilio_from;
        $post['twilio_notification_number'] = $request->twilio_notification_number;

        if ($request->twilio_setting_enabled == 'off') {
            $post['twilio_sid'] = '';
            $post['twilio_token'] = '';
            $post['twilio_from'] = '';
            $post['twilio_notification_number'] = '';
        }


        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }
        return redirect()->back()->with('success', 'Twilio setting successfully updated.');
    }



    public function CustomizeSetting(Request $request)
    {
        $post = $request->all();

        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }
        return redirect()->back()->with('success', 'Customize Css successfully updated.');
    }

    public function whatsapp_notification(Request $request)
    {
        $usr = \Auth::user();

        if ($usr->type == 'super admin' || $usr->type == 'admin') {
            $WhatsappMessage  = WhatsappMessage::where('user_id', $usr->id)->where('id', $request->notification_id)->first();
            $WhatsappMessage->is_active = $request->status;
            $WhatsappMessage->save();

            return response()->json(['success' => 'WhatsappNotification change successfully.']);
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function whatsapp_notification_setting(Request $request)
    {

        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';

        $validator = \Validator::make(
            $request->all(),
            [
                'whatsapp_phone_number_id' => 'required|string',
                'whatsapp_access_token' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $post['whatsapp_phone_number_id'] = $request->whatsapp_phone_number_id;
        $post['whatsapp_access_token'] = $request->whatsapp_access_token;
        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                $arr
            );
        }
        return redirect()->back()->with('success', 'Whatsapp Business API setting successfully updated.');
    }



    public function Testwhatsappmassage(Request $request)
    {
        $email_setting = $request->all();
        $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();

        $user = \Auth::user();

        $data = [];
        $data['whatsapp_phone_number_id'] = $request->whatsapp_phone_number_id;
        $data['whatsapp_access_token'] = $request->whatsapp_access_token;


        return view('setting.test_whatsappmessage', compact('email_setting', 'settings', 'data'));
    }




    public function testSendwhatsappmassage(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'mobile' => 'required',
                'whatsapp_phone_number_id' => 'required',
                'whatsapp_access_token' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        try {

            $url = 'https://graph.facebook.com/v17.0/' . $request->whatsapp_phone_number_id . '/messages';

            $data = array(
                'messaging_product' => 'whatsapp',
                'to' => $request->mobile,
                'type' => 'template',
                'template' => array(
                    'name' => 'hello_world',
                    'language' => array(
                        'code' => 'en_US'
                    )
                )
            );

            $headers = array(
                'Authorization: Bearer ' . $request->whatsapp_access_token,
                'Content-Type: application/json'
            );

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);

            $responseData = json_decode($response);

            curl_close($ch);

            if (isset($responseData->error)) {

                return redirect()->back()->with('error', $responseData->error->message);
            } else {
                return redirect()->back()->with('successs', 'Massage send Successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stockSettings(Request $request)
    {
        $user = \Auth::guard()->user();
        $theme_id = !empty($this->APP_THEME) ? $this->APP_THEME : '';
        $dir = 'themes/' . APP_THEME() . '/uploads';
        $post = $request->all();


        $stock_management = $request->has('stock_management') ? $request->stock_management : 'off';
        $post['stock_management'] = $stock_management;

        $post['notification'] = json_encode($request->input('notification'));
        $post['low_stock_threshold'] = $request->low_stock_threshold;
        $post['out_of_stock_threshold'] = $request->out_of_stock_threshold;


        foreach ($post as $key => $data) {
            $arr = [
                $data,
                $key,
                $this->APP_THEME,
                getCurrentStore(),
                \Auth::guard()->user()->id,
            ];
            if ($data != '') {
                \DB::insert(
                    'insert into settings (`value`, `name`,`theme_id`,`store_id`,`created_by`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    $arr
                );
            }
        }
        return redirect()->back()->with('success', __('Stock setting successfully updated.'));
    }
}
