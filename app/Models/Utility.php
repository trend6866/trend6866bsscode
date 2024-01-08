<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Mail\CommonEmailTemplate;
use App\Models\EmailTemplateLang;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Twilio\Rest\Client;

class Utility extends Model
{
    use HasFactory;

    public static function Seting()
    {
        if (\Auth::check()) {
            if (!empty(\Auth::guard('admin')->user()) && (\Auth::guard('admin')->user()->type == 'admin' || \Auth::guard('admin')->user()->type == 'superadmin')) {
                $data = Setting::where('created_by', '=', \Auth::guard('admin')->user()->id)->where('store_id', getCurrentStore())->where('theme_id', APP_THEME())->get();
            } elseif (\Auth::user()->type != 'admin' && \Auth::user()->type != 'superadmin') {
                $data = Setting::where('created_by', '=', \Auth::user()->creatorId())->where('store_id', getCurrentStore())->get();

                if (count($data) == 0) {
                    $data = DB::table('settings')->where('created_by', '=', 1)->get();
                }
            }
            else
            {
                $data = Setting::where('created_by', '=', \Auth::user()->id)->where('store_id', getCurrentStore())->get();
            }
        } else {
            $data = Setting::where('created_by', '=', 1)->where('store_id', 1)->where('theme_id', 'grocery')->get();
        }

        $array['date_format'] = 'Y-m-d';
        $array['is_cod_enabled'] = 'on';
        $array['is_bank_transfer_enabled'] = 'on';
        $array['CURRENCY_NAME'] = 'USD';
        $array['CURRENCY'] = '$';
        $array['title_text'] = 'EcommerceGo';
        $array['footer_text'] = 'EcommerceGo';
        $array['SITE_RTL'] = 'off';
        $array['cust_theme_bg'] = 'on';
        $array['cust_darklayout'] = 'off';
        $array['color'] = 'theme-3';
        $array['site_date_format'] = 'M j, Y';
        $array['site_time_format'] = 'g:i A';
        $array['logo_light'] = 'storage/uploads/logo/logo-light.png';
        $array['logo_dark'] = 'storage/uploads/logo/logo-dark.png';
        $array['favicon'] = 'storage/uploads/logo/favicon.png';
        $array['theme_logo'] = 'storage/uploads/logo/logo.png';
        $array['invoice_logo'] = 'storage/uploads/logo/logo.png';
        $array['theme_favicon'] = 'storage/uploads/logo/Favicon.png';
        $array['metakeyword'] = '';
        $array['metadesc'] = '';
        $array['google_analytic'] = '';
        $array['fbpixel_code'] = '';
        $array['storejs'] = '';
        $array['storecss'] = '';
        $array['storage_setting'] = 'local';
        $array['local_storage_validation'] = 'jpg,jpeg,png,csv,svg,pdf';
        $array['local_storage_max_upload_size'] = '2048000';
        $array['s3_key'] = '';
        $array['s3_secret'] = '';
        $array['s3_region'] = '';
        $array['s3_bucket'] = '';
        $array['s3_url'] = '';
        $array['s3_endpoint'] = '';
        $array['s3_max_upload_size'] = '';
        $array['s3_storage_validation'] = '';
        $array['wasabi_key'] = '';
        $array['wasabi_secret'] = '';
        $array['wasabi_region'] = '';
        $array['wasabi_bucket'] = '';
        $array['wasabi_url'] = '';
        $array['wasabi_root'] = '';
        $array['wasabi_max_upload_size'] = '';
        $array['wasabi_storage_validation'] = '';
        $array['MAIL_DRIVER'] = '';
        $array['MAIL_HOST'] = '';
        $array['MAIL_PORT'] = '';
        $array['MAIL_USERNAME'] = '';
        $array['MAIL_PASSWORD'] = '';
        $array['MAIL_ENCRYPTION'] = '';
        $array['MAIL_FROM_NAME'] = '';
        $array['MAIL_FROM_ADDRESS'] = '';
        $array['enable_storelink'] = 'on';
        $array['enable_domain'] = 'off';
        $array['domains'] = '';
        $array['enable_subdomain'] = 'off';
        $array['subdomain'] = '';
        $array['metaimage'] = 'themes/grocery/theme_img/img_1.png';
        $array['enable_cookie'] = 'on';
        $array['necessary_cookies'] = 'on';
        $array['cookie_logging'] = 'on';
        $array['cookie_title'] = 'We use cookies!';
        $array['cookie_description'] = 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it.';
        $array['strictly_cookie_title'] = 'Strictly necessary cookies';
        $array['strictly_cookie_description'] = 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly';
        $array['more_information_description'] = 'For any queries in relation to our policy on cookies and your choices, please';
        $array['more_information_title'] = '';
        $array['contactus_url'] = '#';
        $array['chatgpt_key'] = '';
        $array['disable_lang'] = '';
        $array['display_landing'] = 'on';
        $array['SIGNUP'] = 'on';
        $array['additional_notes'] = 'off';
        $array['is_checkout_login_required'] = 'off';
        $array['notification'] = '[]';
        $array['stock_management'] = 'on';
        $array['low_stock_threshold'] = '2';
        $array['out_of_stock_threshold'] = '0';
        $array['email_verification'] = 'off';
        $array['store_address'] = '';
        $array['store_city'] = '';
        $array['store_state'] = '';
        $array['store_zipcode'] = '';
        $array['store_country'] = '';
        $array['whatsapp_phone_number_id'] = '';
        $array['whatsapp_access_token'] = '';


        foreach ($data as $row) {
            $array[$row->name] = $row->value;
        }

        return $array;
    }

    public static function GetValueByName($name = '', $theme_id = '', $store_id = '')
    {
        $theme_id = !empty($theme_id) ? $theme_id : APP_THEME();
        $store_id = !empty($store_id) ? $store_id : getCurrentStore();
        $return = '';
        if (!empty($name)) {
            $settings = Setting::where('name', $name)->where('theme_id', $theme_id)->where('store_id', $store_id)->pluck('value', 'name')->toArray();
            if (!empty($settings)) {
                $return = $settings[$name];
            } else {
                $utility_seting = Self::Seting();
                if (!empty($utility_seting[$name])) {
                    $return = $utility_seting[$name];
                }
            }
        }

        return $return;
    }

    public static function GetValByName($name = '', $theme_id = '', $store_id = '')
    {
        $theme_id = !empty($theme_id) ? $theme_id : APP_THEME();
        $return = '';
        if (!empty($name)) {
            $settings = Setting::where('name', $name)->where('theme_id', $theme_id)->where('store_id', $store_id)->pluck('value', 'name')->toArray();

            // $utility_seting = Self::Seting();

            if (!empty($settings)) {
                $return = $settings[$name];
            }
            else
            {
                $utility_seting = Self::Seting();
                if(!empty($utility_seting[$name]))
                {
                    $return = $utility_seting[$name];
                }
            }
        }
        return $return;
    }

    public static function generateNumericOTP($n)
    {
        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        return $result;
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }

    public static function ThemeSubcategory($theme_id = null)
    {
        if (empty($theme_id)) {
            $theme_id = APP_THEME();
        }
        $return = 0;
        $path =  base_path('themes/' . $theme_id . '/theme_json/' . 'subcategory.json');
        if ($path) {
            $res =  file_get_contents($path);
            if (!empty($res) && $res == 'on') {
                $return = 1;
            }
        }
        return $return;
    }

    public static function addThemeSubcategory()
    {
        $theme_id = APP_THEME();
        $return = 0;
        $path =  base_path('themes/' . $theme_id . '/theme_json/' . 'subcategory.json');
        if ($path) {
            $res =  file_get_contents($path);
            if (!empty($res) && $res == 'on') {
                $return = 1;
            }
        }
        return $return;
    }



    public static function payment_data($payment = '', $theme_id = '', $store_id = '')
    {
        if (empty($theme_id)) {
            $theme_id = APP_THEME();
        }
        if (empty($store_id)) {
            $store_id = getCurrentStore();
        }

        $Setting_array['status'] = 'off';
        $Setting_array['name'] = 'Other Payment';
        $Setting_array['image'] = '';
        $Setting_array['detail'] = '';

        // COD
        if ($payment == 'cod') {
            $is_cod_enabled = Utility::GetValueByName('is_cod_enabled', $theme_id, $store_id);
            $cod_info = Utility::GetValueByName('cod_info', $theme_id, $store_id);
            $cod_image = Utility::GetValueByName('cod_image', $theme_id, $store_id);
            $Setting_array['status'] = (!empty($is_cod_enabled) && $is_cod_enabled == 'on') ? 'on' : 'off';
            $Setting_array['name'] = 'COD';
            $Setting_array['image'] = $cod_image;
            $Setting_array['detail'] = $cod_info;
        }

        // Bank Transfer
        if ($payment == 'bank_transfer') {
            $bank_transfer_info = Utility::GetValueByName('bank_transfer', $theme_id, $store_id);
            $is_bank_transfer_enabled = Utility::GetValueByName('is_bank_transfer_enabled', $theme_id, $store_id);
            $bank_transfer_image = Utility::GetValueByName('bank_transfer_image', $theme_id, $store_id);
            $Setting_array['status'] = (!empty($is_bank_transfer_enabled) && $is_bank_transfer_enabled == 'on') ? 'on' : 'off';
            $Setting_array['name'] = 'Bank Transfer';
            $Setting_array['image'] = $bank_transfer_image;
            $Setting_array['detail'] = !empty($bank_transfer_info) ? $bank_transfer_info : '';
        }

        // Stripe (Creadit card)
        if ($payment == 'stripe') {
            $is_Stripe_enabled = \App\Models\Utility::GetValueByName('is_stripe_enabled', $theme_id, $store_id);
            $publishable_key = \App\Models\Utility::GetValueByName('publishable_key', $theme_id, $store_id);
            $stripe_secret = \App\Models\Utility::GetValueByName('stripe_secret', $theme_id, $store_id);
            $Stripe_image = \App\Models\Utility::GetValueByName('stripe_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_Stripe_enabled;
            $Setting_array['name'] = 'Stripe';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $Stripe_image;
            $Setting_array['stripe_publishable_key'] = $publishable_key;
            $Setting_array['stripe_secret_key'] = $stripe_secret;
        }

        // Paystack
        if ($payment == 'paystack') {
            $is_paystack_enabled = \App\Models\Utility::GetValueByName('is_paystack_enabled', $theme_id, $store_id);
            $paystack_public_key = \App\Models\Utility::GetValueByName('paystack_public_key', $theme_id, $store_id);
            $paystack_secret = \App\Models\Utility::GetValueByName('paystack_secret', $theme_id, $store_id);
            $paystack_image = \App\Models\Utility::GetValueByName('paystack_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_paystack_enabled;
            $Setting_array['name'] = 'Paystack';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $paystack_image;
            $Setting_array['paystack_public_key'] = $paystack_public_key;
            $Setting_array['paystack_secret'] = $paystack_secret;
        }

        // Skrill
        if ($payment == 'skrill') {
            $is_skrill_enabled = \App\Models\Utility::GetValueByName('is_skrill_enabled', $theme_id, $store_id);
            $skrill_email = \App\Models\Utility::GetValueByName('skrill_email', $theme_id, $store_id);
            $skrill_image = \App\Models\Utility::GetValueByName('skrill_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_skrill_enabled;
            $Setting_array['name'] = 'Mercado Pago';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $skrill_image;
            $Setting_array['skrill_email'] = $skrill_email;
        }

        // Mercado
        if ($payment == 'Mercado') {
            $is_mercado_enabled = \App\Models\Utility::GetValueByName('is_mercado_enabled', $theme_id, $store_id);
            $mercado_mode = \App\Models\Utility::GetValueByName('mercado_mode', $theme_id, $store_id);
            $mercado_access_token = \App\Models\Utility::GetValueByName('mercado_access_token', $theme_id, $store_id);
            $mercado_image = \App\Models\Utility::GetValueByName('mercado_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_mercado_enabled;
            $Setting_array['name'] = 'Mercado Pago';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $mercado_image;
            $Setting_array['mercado_mode'] = $mercado_mode;
            $Setting_array['mercado_access_token'] = $mercado_access_token;
        }

        // PaymentWall
        if ($payment == 'paymentwall') {
            $is_paymentwall_enabled = \App\Models\Utility::GetValueByName('is_paymentwall_enabled', $theme_id, $store_id);
            $paymentwall_public_key = \App\Models\Utility::GetValueByName('paymentwall_public_key', $theme_id, $store_id);
            $paymentwall_private_key = \App\Models\Utility::GetValueByName('paymentwall_private_key', $theme_id, $store_id);
            $paymentwall_image = \App\Models\Utility::GetValueByName('paymentwall_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_paymentwall_enabled;
            $Setting_array['name'] = 'PaymentWall';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $paymentwall_image;
            $Setting_array['paymentwall_public_key'] = $paymentwall_public_key;
            $Setting_array['paymentwall_private_key'] = $paymentwall_private_key;
        }

        // Razorpay
        if ($payment == 'Razorpay') {
            $is_razorpay_enabled = \App\Models\Utility::GetValueByName('is_razorpay_enabled', $theme_id, $store_id);
            $razorpay_public_key = \App\Models\Utility::GetValueByName('razorpay_public_key', $theme_id, $store_id);
            $razorpay_secret_key = \App\Models\Utility::GetValueByName('razorpay_secret_key', $theme_id, $store_id);
            $razorpay_image = \App\Models\Utility::GetValueByName('razorpay_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_razorpay_enabled;
            $Setting_array['name'] = 'Razorpay';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $razorpay_image;
            $Setting_array['razorpay_public_key'] = $razorpay_public_key;
            $Setting_array['razorpay_secret_key'] = $razorpay_secret_key;
        }
        //paypal
        if ($payment == 'paypal') {
            $is_paypal_enabled = \App\Models\Utility::GetValueByName('is_paypal_enabled', $theme_id, $store_id);
            $paypal_client_id = \App\Models\Utility::GetValueByName('paypal_client_id', $theme_id, $store_id);
            $paypal_secret = \App\Models\Utility::GetValueByName('paypal_secret', $theme_id, $store_id);
            $paypal_mode = \App\Models\Utility::GetValueByName('paypal_mode', $theme_id, $store_id);
            $paypal_image = \App\Models\Utility::GetValueByName('paypal_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_paypal_enabled;
            $Setting_array['name'] = 'Paypal';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $paypal_image;
            $Setting_array['paypal_client_id'] = $paypal_client_id;
            $Setting_array['paypal_secret'] = $paypal_secret;
            $Setting_array['paypal_mode'] = $paypal_mode;
        }

        //flutterwave
        if ($payment == 'flutterwave') {
            $is_flutterwave_enabled = \App\Models\Utility::GetValueByName('is_flutterwave_enabled', $theme_id, $store_id);
            $public_key = \App\Models\Utility::GetValueByName('public_key', $theme_id, $store_id);
            $flutterwave_secret = \App\Models\Utility::GetValueByName('flutterwave_secret', $theme_id, $store_id);
            $flutterwave_image = \App\Models\Utility::GetValueByName('flutterwave_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_flutterwave_enabled;
            $Setting_array['name'] = 'Flutterwave';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $flutterwave_image;
            $Setting_array['public_key'] = $public_key;
            $Setting_array['flutterwave_secret'] = $flutterwave_secret;
        }
        //paytm
        if ($payment == 'paytm') {
            $is_paytm_enabled = \App\Models\Utility::GetValueByName('is_paytm_enabled', $theme_id, $store_id);
            $paytm_merchant_id = \App\Models\Utility::GetValueByName('paytm_merchant_id', $theme_id, $store_id);
            $paytm_industry_type = \App\Models\Utility::GetValueByName('paytm_industry_type', $theme_id, $store_id);
            $paytm_merchant_key = \App\Models\Utility::GetValueByName('paytm_merchant_key', $theme_id, $store_id);
            $paytm_image = \App\Models\Utility::GetValueByName('paytm_image', $theme_id, $store_id);
            $paypm_mode = \App\Models\Utility::GetValueByName('paypm_mode', $theme_id, $store_id);


            $Setting_array['status'] = $is_paytm_enabled;
            $Setting_array['name'] = 'Paytm';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $paytm_image;
            $Setting_array['paytm_merchant_id'] = $paytm_merchant_id;
            $Setting_array['paytm_industry_type'] = $paytm_industry_type;
            $Setting_array['paytm_merchant_key'] = $paytm_merchant_key;
            $Setting_array['paypm_mode'] = $paypm_mode;
        }
        //mollie
        if ($payment == 'mollie') {
            $is_mollie_enabled = \App\Models\Utility::GetValueByName('is_mollie_enabled', $theme_id, $store_id);
            $mollie_api_key = \App\Models\Utility::GetValueByName('mollie_api_key', $theme_id, $store_id);
            $mollie_profile_id = \App\Models\Utility::GetValueByName('mollie_profile_id', $theme_id, $store_id);
            $mollie_partner_id = \App\Models\Utility::GetValueByName('mollie_partner_id', $theme_id, $store_id);
            $mollie_image = \App\Models\Utility::GetValueByName('mollie_image', $theme_id, $store_id);
            $mollie_unfo = \App\Models\Utility::GetValueByName('mollie_unfo', $theme_id, $store_id);


            $Setting_array['status'] = $is_mollie_enabled;
            $Setting_array['name'] = 'Mollie';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $mollie_image;
            $Setting_array['mollie_api_key'] = $mollie_api_key;
            $Setting_array['mollie_profile_id'] = $mollie_profile_id;
            $Setting_array['mollie_partner_id'] = $mollie_partner_id;
            $Setting_array['mollie_unfo'] = $mollie_unfo;
        }
        //coingate
        if ($payment == 'coingate') {
            $is_coingate_enabled = \App\Models\Utility::GetValueByName('is_coingate_enabled', $theme_id, $store_id);
            $coingate_mode = \App\Models\Utility::GetValueByName('coingate_mode', $theme_id, $store_id);
            $coingate_auth_token = \App\Models\Utility::GetValueByName('coingate_auth_token', $theme_id, $store_id);
            $coingate_image = \App\Models\Utility::GetValueByName('coingate_image', $theme_id, $store_id);
            $coingate_unfo = \App\Models\Utility::GetValueByName('coingate_unfo', $theme_id, $store_id);


            $Setting_array['status'] = $is_coingate_enabled;
            $Setting_array['name'] = 'coingate';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $coingate_image;
            $Setting_array['coingate_mode'] = $coingate_mode;
            $Setting_array['coingate_auth_token'] = $coingate_auth_token;
            $Setting_array['coingate_image'] = $coingate_image;
        }
        // toyyibpay
        if ($payment == 'toyyibpay') {
            $is_toyyibpay_enabled = \App\Models\Utility::GetValueByName('is_toyyibpay_enabled', $theme_id, $store_id);
            $toyyibpay_category_code = \App\Models\Utility::GetValueByName('toyyibpay_category_code', $theme_id, $store_id);
            $toyyibpay_secret_key = \App\Models\Utility::GetValueByName('toyyibpay_secret_key', $theme_id, $store_id);
            $toyyibpay_image = \App\Models\Utility::GetValueByName('toyyibpay_image', $theme_id, $store_id);
            $toyyibpay_unfo = \App\Models\Utility::GetValueByName('toyyibpay_unfo', $theme_id, $store_id);


            $Setting_array['status'] = $is_toyyibpay_enabled;
            $Setting_array['name'] = 'toyyibpay';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $toyyibpay_image;
            $Setting_array['toyyibpay_category_code'] = $toyyibpay_category_code;
            $Setting_array['toyyibpay_secret_key'] = $toyyibpay_secret_key;
            $Setting_array['toyyibpay_image'] = $toyyibpay_image;
        }
        // sspay
        if ($payment == 'sspay') {
            $is_sspay_enabled = \App\Models\Utility::GetValueByName('is_sspay_enabled', $theme_id, $store_id);
            $sspay_category_code = \App\Models\Utility::GetValueByName('sspay_category_code', $theme_id, $store_id);
            $sspay_secret_key = \App\Models\Utility::GetValueByName('sspay_secret_key', $theme_id, $store_id);
            $sspay_image = \App\Models\Utility::GetValueByName('sspay_image', $theme_id, $store_id);
            $sspay_unfo = \App\Models\Utility::GetValueByName('sspay_unfo', $theme_id, $store_id);


            $Setting_array['status'] = $is_sspay_enabled;
            $Setting_array['name'] = 'sspay';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $sspay_image;
            $Setting_array['sspay_category_code'] = $sspay_category_code;
            $Setting_array['sspay_secret_key'] = $sspay_secret_key;
            $Setting_array['sspay_image'] = $sspay_image;
        }
        // paytabs
        if ($payment == 'Paytabs') {
            $is_paytabs_enabled = \App\Models\Utility::GetValueByName('is_paytabs_enabled', $theme_id, $store_id);
            $paytabs_profile_id = \App\Models\Utility::GetValueByName('paytabs_profile_id', $theme_id, $store_id);
            $paytabs_server_key = \App\Models\Utility::GetValueByName('paytabs_server_key', $theme_id, $store_id);
            $paytabs_region = \App\Models\Utility::GetValueByName('paytabs_region', $theme_id, $store_id);
            $paytabs_image = \App\Models\Utility::GetValueByName('paytabs_image', $theme_id, $store_id);
            $paytabs_unfo = \App\Models\Utility::GetValueByName('paytabs_unfo', $theme_id, $store_id);


            $Setting_array['status'] = $is_paytabs_enabled;
            $Setting_array['name'] = 'Paytabs';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $paytabs_image;
            $Setting_array['paytabs_profile_id'] = $paytabs_profile_id;
            $Setting_array['paytabs_server_key'] = $paytabs_server_key;
            $Setting_array['paytabs_region'] = $paytabs_region;
            $Setting_array['paytabs_image'] = $paytabs_image;
        }
        //iyzipay
        if ($payment == 'iyzipay') {
            $is_iyzipay_enabled = \App\Models\Utility::GetValueByName('is_iyzipay_enabled', $theme_id, $store_id);
            $iyzipay_unfo = \App\Models\Utility::GetValueByName('iyzipay_unfo', $theme_id, $store_id);
            $iyzipay_secret_key = \App\Models\Utility::GetValueByName('iyzipay_secret_key', $theme_id, $store_id);
            $iyzipay_private_key = \App\Models\Utility::GetValueByName('iyzipay_private_key', $theme_id, $store_id);
            $iyzipay_image = \App\Models\Utility::GetValueByName('iyzipay_image', $theme_id, $store_id);
            $iyzipay_mode = \App\Models\Utility::GetValueByName('iyzipay_mode', $theme_id, $store_id);

            $Setting_array['status'] = $is_iyzipay_enabled;
            $Setting_array['name'] = 'IyziPay';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $iyzipay_image;
            $Setting_array['iyzipay_mode'] = $iyzipay_mode;
            $Setting_array['iyzipay_private_key'] = $iyzipay_private_key;
            $Setting_array['iyzipay_secret_key'] = $iyzipay_secret_key;
            $Setting_array['iyzipay_image'] = $iyzipay_image;
        }
        //PayFast
        if ($payment == 'payfast') {
            $is_payfast_enabled = \App\Models\Utility::GetValueByName('is_payfast_enabled', $theme_id, $store_id);
            $payfast_unfo = \App\Models\Utility::GetValueByName('payfast_unfo', $theme_id, $store_id);
            $payfast_merchant_id = \App\Models\Utility::GetValueByName('payfast_merchant_id', $theme_id, $store_id);
            $payfast_salt_passphrase = \App\Models\Utility::GetValueByName('payfast_salt_passphrase', $theme_id, $store_id);
            $payfast_merchant_key = \App\Models\Utility::GetValueByName('payfast_merchant_key', $theme_id, $store_id);
            $payfast_image = \App\Models\Utility::GetValueByName('payfast_image', $theme_id, $store_id);
            $payfast_mode = \App\Models\Utility::GetValueByName('payfast_mode', $theme_id, $store_id);

            $Setting_array['status'] = $is_payfast_enabled;
            $Setting_array['name'] = 'payfast';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $payfast_image;
            $Setting_array['payfast_mode'] = $payfast_mode;
            $Setting_array['payfast_merchant_key'] = $payfast_merchant_key;
            $Setting_array['payfast_salt_passphrase'] = $payfast_salt_passphrase;
            $Setting_array['payfast_merchant_id'] = $payfast_merchant_id;
            $Setting_array['payfast_image'] = $payfast_image;
        }
        //Benefit
        if ($payment == 'benefit') {
            $is_benefit_enabled = \App\Models\Utility::GetValueByName('is_benefit_enabled', $theme_id, $store_id);
            $benefit_unfo = \App\Models\Utility::GetValueByName('benefit_unfo', $theme_id, $store_id);
            $benefit_secret_key = \App\Models\Utility::GetValueByName('benefit_secret_key', $theme_id, $store_id);
            $benefit_private_key = \App\Models\Utility::GetValueByName('benefit_private_key', $theme_id, $store_id);
            $benefit_image = \App\Models\Utility::GetValueByName('benefit_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_benefit_enabled;
            $Setting_array['name'] = 'Benefit';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $benefit_image;
            $Setting_array['benefit_private_key'] = $benefit_private_key;
            $Setting_array['benefit_secret_key'] = $benefit_secret_key;
            $Setting_array['benefit_image'] = $benefit_image;
        }

        //Cashfree
        if ($payment == 'cashfree') {
            $is_cashfree_enabled = \App\Models\Utility::GetValueByName('is_cashfree_enabled', $theme_id, $store_id);
            $cashfree_unfo = \App\Models\Utility::GetValueByName('cashfree_unfo', $theme_id, $store_id);
            $cashfree_secret_key = \App\Models\Utility::GetValueByName('cashfree_secret_key', $theme_id, $store_id);
            $cashfree_key = \App\Models\Utility::GetValueByName('cashfree_key', $theme_id, $store_id);
            $cashfree_image = \App\Models\Utility::GetValueByName('cashfree_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_cashfree_enabled;
            $Setting_array['name'] = 'Cashfree';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $cashfree_image;
            $Setting_array['cashfree_key'] = $cashfree_key;
            $Setting_array['cashfree_secret_key'] = $cashfree_secret_key;
            $Setting_array['cashfree_image'] = $cashfree_image;
        }

        //Aamarpay
        if ($payment == 'aamarpay') {
            $is_aamarpay_enabled = \App\Models\Utility::GetValueByName('is_aamarpay_enabled', $theme_id, $store_id);
            $aamarpay_unfo = \App\Models\Utility::GetValueByName('aamarpay_unfo', $theme_id, $store_id);
            $aamarpay_signature_key = \App\Models\Utility::GetValueByName('aamarpay_signature_key', $theme_id, $store_id);
            $aamarpay_description = \App\Models\Utility::GetValueByName('aamarpay_description', $theme_id, $store_id);
            $aamarpay_store_id = \App\Models\Utility::GetValueByName('aamarpay_store_id', $theme_id, $store_id);
            $aamarpay_image = \App\Models\Utility::GetValueByName('aamarpay_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_aamarpay_enabled;
            $Setting_array['name'] = 'Aamarpay';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $aamarpay_image;
            $Setting_array['aamarpay_store_id'] = $aamarpay_store_id;
            $Setting_array['aamarpay_description'] = $aamarpay_description;
            $Setting_array['aamarpay_signature_key'] = $aamarpay_signature_key;
            $Setting_array['aamarpay_image'] = $aamarpay_image;
        }

        //Telegram
        if ($payment == 'telegram') {
            $is_telegram_enabled = \App\Models\Utility::GetValueByName('is_telegram_enabled', $theme_id, $store_id);
            $telegram_unfo = \App\Models\Utility::GetValueByName('telegram_unfo', $theme_id, $store_id);
            $telegram_access_token = \App\Models\Utility::GetValueByName('telegram_access_token', $theme_id, $store_id);
            $telegram_chat_id = \App\Models\Utility::GetValueByName('telegram_chat_id', $theme_id, $store_id);
            $telegram_image = \App\Models\Utility::GetValueByName('telegram_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_telegram_enabled;
            $Setting_array['name'] = 'Telegram';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $telegram_image;
            $Setting_array['telegram_chat_id'] = $telegram_chat_id;
            $Setting_array['telegram_access_token'] = $telegram_access_token;
            $Setting_array['telegram_image'] = $telegram_image;
        }

        //Whatsapp
        if ($payment == 'whatsapp') {
            $is_whatsapp_enabled = \App\Models\Utility::GetValueByName('is_whatsapp_enabled', $theme_id, $store_id);
            $whatsapp_unfo = \App\Models\Utility::GetValueByName('whatsapp_unfo', $theme_id, $store_id);
            $whatsapp_number = \App\Models\Utility::GetValueByName('whatsapp_number', $theme_id, $store_id);
            $whatsapp_image = \App\Models\Utility::GetValueByName('whatsapp_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_whatsapp_enabled;
            $Setting_array['name'] = 'Whatsapp';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $whatsapp_image;
            $Setting_array['whatsapp_number'] = $whatsapp_number;
            $Setting_array['whatsapp_image'] = $whatsapp_image;
        }

        //PayTR
        if ($payment == 'paytr') {
            $is_paytr_enabled = \App\Models\Utility::GetValueByName('is_paytr_enabled', $theme_id, $store_id);
            $paytr_unfo = \App\Models\Utility::GetValueByName('paytr_unfo', $theme_id, $store_id);
            $paytr_merchant_id = \App\Models\Utility::GetValueByName('paytr_merchant_id', $theme_id, $store_id);
            $paytr_merchant_key = \App\Models\Utility::GetValueByName('paytr_merchant_key', $theme_id, $store_id);
            $paytr_salt_key = \App\Models\Utility::GetValueByName('paytr_salt_key', $theme_id, $store_id);
            $paytr_image = \App\Models\Utility::GetValueByName('paytr_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_paytr_enabled;
            $Setting_array['name'] = 'PayTR';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $paytr_image;
            $Setting_array['paytr_salt_key'] = $paytr_salt_key;
            $Setting_array['paytr_merchant_key'] = $paytr_merchant_key;
            $Setting_array['paytr_merchant_id'] = $paytr_merchant_id;
            $Setting_array['paytr_image'] = $paytr_image;
        }

        //Yookassa
        if ($payment == 'yookassa') {
            $is_yookassa_enabled = \App\Models\Utility::GetValueByName('is_yookassa_enabled', $theme_id, $store_id);
            $yookassa_unfo = \App\Models\Utility::GetValueByName('yookassa_unfo', $theme_id, $store_id);
            $yookassa_shop_id_key = \App\Models\Utility::GetValueByName('yookassa_shop_id_key', $theme_id, $store_id);
            $yookassa_secret_key = \App\Models\Utility::GetValueByName('yookassa_secret_key', $theme_id, $store_id);
            $yookassa_image = \App\Models\Utility::GetValueByName('yookassa_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_yookassa_enabled;
            $Setting_array['name'] = 'Yookassa';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $yookassa_image;
            $Setting_array['yookassa_secret_key'] = $yookassa_secret_key;
            $Setting_array['yookassa_shop_id_key'] = $yookassa_shop_id_key;
            $Setting_array['yookassa_image'] = $yookassa_image;
        }
        //Xendit
        if ($payment == 'Xendit') {
            $is_Xendit_enabled = \App\Models\Utility::GetValueByName('is_Xendit_enabled', $theme_id, $store_id);
            $Xendit_unfo = \App\Models\Utility::GetValueByName('Xendit_unfo', $theme_id, $store_id);
            $Xendit_api_key = \App\Models\Utility::GetValueByName('Xendit_api_key', $theme_id, $store_id);
            $Xendit_token_key = \App\Models\Utility::GetValueByName('Xendit_token_key', $theme_id, $store_id);
            $Xendit_image = \App\Models\Utility::GetValueByName('Xendit_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_Xendit_enabled;
            $Setting_array['name'] = 'Xendit';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $Xendit_image;
            $Setting_array['Xendit_token_key'] = $Xendit_token_key;
            $Setting_array['Xendit_api_key'] = $Xendit_api_key;
            $Setting_array['Xendit_image'] = $Xendit_image;
        }

        //Midtrans
        if ($payment == 'midtrans') {
            $is_midtrans_enabled = \App\Models\Utility::GetValueByName('is_midtrans_enabled', $theme_id, $store_id);
            $midtrans_unfo = \App\Models\Utility::GetValueByName('midtrans_unfo', $theme_id, $store_id);
            $midtrans_secret_key = \App\Models\Utility::GetValueByName('midtrans_secret_key', $theme_id, $store_id);
            $midtrans_image = \App\Models\Utility::GetValueByName('midtrans_image', $theme_id, $store_id);

            $Setting_array['status'] = $is_midtrans_enabled;
            $Setting_array['name'] = 'Midtrans';
            $Setting_array['detail'] = '';
            $Setting_array['image'] = $midtrans_image;
            $Setting_array['midtrans_secret_key'] = $midtrans_secret_key;
            $Setting_array['midtrans_image'] = $midtrans_image;
        }
        
        //POS
        if ($payment == 'POS') {
            $Setting_array['name'] = 'POS';
        }

        return $Setting_array;
    }


    public static function loyality_program_json($theme_id = '', $store_id = '')
    {
        $theme_id = !empty($theme_id) ? $theme_id : APP_THEME();
        $loyality_program_json = [];
        $loyality_program_json_path = base_path('themes/' . $theme_id . '/theme_json/loyality_program.json');
        if (file_exists($loyality_program_json_path)) {
            $loyality_program_json = json_decode(file_get_contents($loyality_program_json_path), true);
        }

        $loyality_program_complete_json = AppSetting::select('theme_json')
            ->where('theme_id', $theme_id)
            ->where('page_name', 'loyality_program')
            ->where('store_id', $store_id)
            ->first();
        if (!empty($loyality_program_complete_json)) {
            $loyality_program_json = json_decode($loyality_program_complete_json->theme_json, true);
        }

        return $loyality_program_json;
    }

    public static function reward_point_count($price = 0, $theme_id = '')
    {
        $reward_point = Utility::GetValueByName('reward_point', $theme_id);
        $reward_point = !empty($reward_point) ? $reward_point : 0;
        $point = $price * $reward_point / 1000;
        return $point;
    }

    public static function sendFCM($device_id = '', $fcm_Key = '', $message = '')
    {
        if (empty($device_id) || empty($fcm_Key)) {
            return false;
        }

        // FCM API Url
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Put your Server Key here
        $apiKey = $fcm_Key;

        // Compile headers in one variable
        $headers = array(
            'Authorization:key=' . $apiKey,
            'Content-Type:application/json'
        );

        // Add notification content to a variable for easy reference
        $title = "Fashion App";
        $notifData = [
            'title' => $title,
            'body' => $message,
            //  "image": "url-to-image",//Optional
            'click_action' => "activities.NotifHandlerActivity" //Action/Activity - Optional
        ];

        $dataPayload = [
            'to' => 'My Name',
            'points' => 80,
            'other_data' => 'This is extra payload'
        ];

        $to = $device_id;

        // Create the api body
        $apiBody = [
            'notification' => $notifData,
            'data' => $dataPayload, //Optional
            'time_to_live' => 600, // optional - In Seconds
            //'to' => '/topics/mytargettopic'
            //'registration_ids' = ID ARRAY
            'to' => $to
        ];

        // Initialize curl with the prepared headers and body
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

        // Execute call and save result
        $result = curl_exec($ch);
        print($result);
        // Close curl after call
        curl_close($ch);

        return $result;
    }

    public static function ios_send_push_notification($device_token, $message, $badge)
    {
        if ($device_token == null || $device_token == "no_token_get" || $device_token == "") {
            return true; //run if device token is not get but run below code//
        }
        $ch = curl_init("https://fcm.googleapis.com/fcm/send");
        //The device token.
        $token = $device_token; //token here

        //Title of the Notification.
        $title = "Fashion App";

        //Body of the Notification.
        $body = $message;

        $total_badge = intval(@$badge);
        $sound = 'default';

        //Creating the notification array.
        $notification = array(
            'title' => $title,
            'body' => $body,
            'message' => array('message' => $message),
            'alert' => array('title' => 'Seek Into Bible App', 'body' => $message),
            'badge' => $total_badge,
            'sound' => $sound,
            'content-available' => 1
        );

        //This array contains, the token and the notification. The 'to' attribute stores the token.
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');

        //Generating JSON encoded string form the above array.
        $json = json_encode($arrayToSend);

        // $FCM_KEY = "AAAAMSxdxQY:APA91bEaydaMRlXvpw9AwlhTDRYyk2Bmn9imZeYHeQoTLccavIMhonCctDYXBznzNOlFJR1JSlJybGN4VxLVY7iUl43P_3ixfO7_xfRNY0AmWsQ4Csy9J5LYWZSBfwrrqzMBL8bTKZuq";
        $FCM_KEY = "AAAAiD5hpRA:APA91bHauBWNwWXgKBdMIE2ulp_3lvoClGzVzpk7BMn_t2pfyS_TZyNHWylam9JuThNSDrrg2YdGu6BrUDkSQUTOPlpbop3paP7pjXlwZDaOw9kh4eo-snra32COS4Mj5Xl5N0cqIxEl";

        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $FCM_KEY; // key here

        //Setup curl, add headers and post parameters.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //Send the request
        $response = curl_exec($ch);
        //Close request
        curl_close($ch);
        if (!$response) {
            //return 'Message not delivered' . PHP_EOL;
            return false;
        } else {
            return true;
        }
    }


    public static function VariantAttribute($p_variant)
    {
        $variant = json_decode($p_variant);
        $p_variant = ProductVariant::find($variant);
        return $p_variant;
    }

    public static function HomePageProduct($slug, $no = 2)
    {
        $currency = Utility::GetValueByName('CURRENCY_NAME');
        $landing_products = Product::where('theme_id', APP_THEME())->where('store_id', getCurrentStore())->latest()->inRandomOrder()->limit($no)->get();



        return view('homepage_products', compact('slug', 'landing_products', 'currency'))->render();
    }

    public static function GetLogo($app_theme = null)
    {
        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : ((empty($app_theme)) ?  APP_THEME() : $app_theme);
        $settings = Setting::where('theme_id', $theme_name)->where('store_id', getCurrentStore())->pluck('value', 'name')->toArray();

        // if(\Auth::user()){
        if (isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == "on") {
            return Utility::GetValueByName('logo_light', $theme_name);
        } else {
            return Utility::GetValueByName('logo_dark', $theme_name);
        }
        // }
        if (!isset($settings['logo_light'])) {
            $settings = Utility::Seting();
            //  dd($settings);
        }
    }

    public static function dateFormat($date)
    {

        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
        $settings = Utility::GetValueByName('site_date_format', $theme_name);

        return date($settings, strtotime($date));
    }

    public static function success($data = [], $message = "successfull", int $code = 200, $count_data = '')
    {
        $res_array = [
            'status' => 1,
            'message' => $message,
            'data' => $data
        ];

        if ($count_data != '') {
            $count_data_ARRAY['count'] = $count_data;
            $res_array = array_merge($count_data_ARRAY, $res_array);
        }
        // return response()->json($res_array, $code);
        return $res_array;
    }

    public static function error($data = [], $message = 'fail', int $code = 200, $status = 0, $count_data = '')
    {
        $res_array = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        if ($count_data != '') {
            $count_data_ARRAY['count'] = $count_data;
            $res_array = array_merge($count_data_ARRAY, $res_array);
        }
        // return response()->json($res_array, $code);
        return $res_array;
    }

    public static function upload_file($request, $key_name, $name, $path, $custom_validation = [], $image = '')
    {
        try {
            $settings = Setting::where('theme_id', 'grocery')->where('store_id', 1)->pluck('value', 'name')->toArray();
            if (!isset($settings['storage_setting'])) {
                $settings = Utility::Seting();
            }

            if (!empty($settings['storage_setting'])) {
                if ($settings['storage_setting'] == 'wasabi') {
                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = !empty($image) ? $image : $request->$key_name;
                // $file = $request->$key_name;

                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];
                }

                if (empty($image)) {
                    $validator = \Validator::make($request->all(), [
                        $key_name => $validation
                    ]);
                }


                if (empty($image) && $validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {
                        $path = $path . '/';
                        $image = !empty($image) ? $image : $request->file($key_name);
                        \Storage::disk('theme')->putFileAs(
                            $path,
                            $image,
                            $name
                        );
                        $path = $path . $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {
                        $image = !empty($image) ? $image : $request->file($key_name);
                        $path = \Storage::disk('wasabi')->putFileAs($path, $image, $name);
                    } else if ($settings['storage_setting'] == 's3') {
                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $file,
                            $name
                        );
                    }

                    $image_url = '';
                    if ($settings['storage_setting'] == 'local') {
                        $image_url = url($path);
                    } else if ($settings['storage_setting'] == 'wasabi') {
                        $image_url = \Storage::disk('wasabi')->url($path);
                    } else if ($settings['storage_setting'] == 's3') {
                        $image_url = \Storage::disk('s3')->url($path);
                    }

                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path,
                        'image_path'  => $path,
                        'full_url'  => $image_url
                    ];

                    return $res;
                }
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];


                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function keyWiseUpload_file($request, $key_name, $name, $path, $data_key, $custom_validation = [])
    {

        $multifile = [
            $key_name => $request->file($key_name)[$data_key],
        ];

        try {
            $settings = Setting::where('theme_id', 'grocery')->where('store_id', 1)->pluck('value', 'name')->toArray();

            if (!isset($settings['storage_setting'])) {
                $settings = Utility::Seting();
            }

            if (!empty($settings['storage_setting'])) {

                if ($settings['storage_setting'] == 'wasabi') {

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $file = $request->$key_name;


                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];
                }

                $validator = \Validator::make($multifile, [
                    $key_name => $validation
                ]);


                if ($validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {

                    $name = $name;

                    if ($settings['storage_setting'] == 'local') {
                        $path = $path . '/';
                        \Storage::disk('theme')->putFileAs(
                            $path,
                            $request->file($key_name)[$data_key],
                            $name
                        );


                        $path = $path . $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $request->file($key_name)[$data_key],
                            $name
                        );

                        // $path = $path.$name;

                    } else if ($settings['storage_setting'] == 's3') {

                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $request->file($key_name)[$data_key],
                            $name
                        );
                    }

                    $image_url = '';
                    if ($settings['storage_setting'] == 'local') {
                        $image_url = url($path);
                    } else if ($settings['storage_setting'] == 'wasabi') {
                        $image_url = \Storage::disk('wasabi')->url($path);
                    } else if ($settings['storage_setting'] == 's3') {
                        $image_url = \Storage::disk('s3')->url($path);
                    }


                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path,
                        'full_url'  => $image_url
                    ];
                    return $res;
                }
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function jsonUpload_file($image, $name, $path, $custom_validation = [])
    {
        try {
            // $settings = Setting::where('theme_id', APP_THEME())->pluck('value', 'name')->toArray();
            $settings = Setting::where('theme_id', 'grocery')->where('store_id', 1)->pluck('value', 'name')->toArray();
            if (!isset($settings['storage_setting'])) {
                $settings = Utility::Seting();
            }

            if (!empty($settings['storage_setting'])) {
                if ($settings['storage_setting'] == 'wasabi') {
                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }



                if (count($custom_validation) > 0) {
                    $validation = $custom_validation;
                } else {

                    $validation = [
                        'mimes:' . $mimes,
                        'max:' . $max_size,
                    ];
                }

                if (empty($image)) {
                    $validator = \Validator::make($request->all(), [
                        $key_name => $validation
                    ]);
                }


                if (empty($image) && $validator->fails()) {
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {
                    if ($settings['storage_setting'] == 'local') {
                        $path = $path . '/';
                        \Storage::disk('theme')->putFileAs(
                            $path,
                            $image,
                            $name
                        );
                        $path = $path . $name;
                    } else if ($settings['storage_setting'] == 'wasabi') {

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $image,
                            $name
                        );
                    } else if ($settings['storage_setting'] == 's3') {
                        $path = \Storage::disk('s3')->putFileAs(
                            $path,
                            $image,
                            $name
                        );
                    }

                    $image_url = '';
                    if ($settings['storage_setting'] == 'local') {
                        $image_url = url($path);
                    } else if ($settings['storage_setting'] == 'wasabi') {
                        $image_url = \Storage::disk('wasabi')->url($path);
                    } else if ($settings['storage_setting'] == 's3') {
                        $image_url = \Storage::disk('s3')->url($path);
                    }

                    $res = [
                        'flag' => 1,
                        'msg'  => 'success',
                        'url'  => $path,
                        'image_path'  => $path,
                        'full_url'  => $image_url
                    ];

                    return $res;
                }
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];


                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }


    public static function city_insert()
    {
        City::truncate();
        $csvData = fopen(base_path('country/cities.csv'), 'r');
        $ca = [];
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            City::create([
                'name' => $data[1],
                'state_id' => $data[2],
                'country_id' => $data[3]
            ]);

            if (empty($ca[$data[2]])) {
                $ca[$data[2]] = 1;
            } else {
                $ca[$data[2]] = $ca[$data[2]] + 1;
            }
        }
        fclose($csvData);
    }

    public static function state_insert()
    {
        state::truncate();
        $csvData = fopen(base_path('country/states.csv'), 'r');
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            state::create([
                'name' => $data[1],
                'country_id' => $data[2]
            ]);
        }
        fclose($csvData);
    }

    public static function country_insert()
    {
        country::truncate();
        $csvData = fopen(base_path('country/countries.csv'), 'r');
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            country::create([
                'name' => $data[1],
            ]);
        }
        fclose($csvData);
    }

    public static function page_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/pages.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $page = new Page();
                    $page['name'] = $data[1];
                    $page['page_slug'] = $data[2];
                    $page['short_description'] = $data[3];
                    $page['content'] = $data[4];
                    $page['other_info'] = $data[5];
                    $page['status'] = 1;
                    $page['page_status'] = $data[7];
                    $page['theme_id'] = $value;
                    $page['store_id'] = $store->id;
                    $page->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/pages.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $page = new Page();
                    $page['name'] = $data[1];
                    $page['page_slug'] = $data[2];
                    $page['short_description'] = $data[3];
                    $page['content'] = $data[4];
                    $page['other_info'] = $data[5];
                    $page['status'] = 1;
                    $page['page_status'] = $data[7];
                    $page['theme_id'] = $theme_id;
                    $page['store_id'] = $store->id;
                    $page->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function blog_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/blogs.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $blog = new Blog();
                    $blog['title'] = $data[1];
                    $blog['short_description'] = $data[2];
                    $blog['content'] = $data[3];
                    $blog['maincategory_id'] = $data[4];
                    $blog['subcategory_id'] = $data[5];
                    $blog['cover_image_url'] = $data[6];
                    $blog['cover_image_path'] = $data[7];
                    $blog['theme_id'] = $value;
                    $blog['store_id'] = $store->id;
                    $blog->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/blogs.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $blog = new Blog();
                    $blog['title'] = $data[1];
                    $blog['short_description'] = $data[2];
                    $blog['content'] = $data[3];
                    $blog['maincategory_id'] = $data[4];
                    $blog['subcategory_id'] = $data[5];
                    $blog['cover_image_url'] = $data[6];
                    $blog['cover_image_path'] = $data[7];
                    $blog['theme_id'] = $theme_id;
                    $blog['store_id'] = $store->id;
                    $blog->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function faqs_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/faqs.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $faq = new Faq();
                    $faq['topic'] = $data[1];
                    $faq['description'] = $data[2];
                    $faq['theme_id'] = $value;
                    $faq['store_id'] = $store->id;
                    $faq->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/faqs.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $faq = new Faq();
                    $faq['topic'] = $data[1];
                    $faq['description'] = $data[2];
                    $faq['theme_id'] = $theme_id;
                    $faq['store_id'] = $store->id;
                    $faq->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function coupon_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/coupons.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $coupon = new Coupon();
                    $coupon['coupon_name'] = $data[1];
                    $coupon['coupon_code'] = $data[2];
                    $coupon['coupon_type'] = $data[3];
                    $coupon['coupon_limit'] = $data[4];
                    $coupon['coupon_expiry_date'] = $data[5];
                    $coupon['discount_amount'] = $data[6];
                    $coupon['status'] = $data[7];
                    $coupon['theme_id'] = $value;
                    $coupon['store_id'] = $store->id;
                    $coupon->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/coupons.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $coupon = new Coupon();
                    $coupon['coupon_name'] = $data[1];
                    $coupon['coupon_code'] = $data[2];
                    $coupon['coupon_type'] = $data[3];
                    $coupon['coupon_limit'] = $data[4];
                    $coupon['coupon_expiry_date'] = $data[5];
                    $coupon['discount_amount'] = $data[6];
                    $coupon['status'] = $data[7];
                    $coupon['theme_id'] = $theme_id;
                    $coupon['store_id'] = $store->id;
                    $coupon->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function taxes_insert($company_id, $store_id = '', $theme_id = '')

    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/taxes.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $tax = new Tax();
                    $tax['tax_name'] = $data[1];
                    $tax['tax_type'] = $data[2];
                    $tax['tax_amount'] = $data[3];
                    $tax['status'] = $data[4];
                    $tax['theme_id'] = $value;
                    $tax['store_id'] = $store->id;
                    $tax->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/taxes.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $tax = new Tax();
                    $tax['tax_name'] = $data[1];
                    $tax['tax_type'] = $data[2];
                    $tax['tax_amount'] = $data[3];
                    $tax['status'] = $data[4];
                    $tax['theme_id'] = $theme_id;
                    $tax['store_id'] = $store->id;
                    $tax->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function maincategory_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/main_categories.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $MainCategory = new MainCategory();
                    // $MainCategory['id'] = $data[0];
                    $MainCategory['name'] = $data[1];
                    $MainCategory['image_url'] = $data[2];
                    $MainCategory['image_path'] = $data[3];
                    $MainCategory['icon_path'] = $data[4];
                    $MainCategory['trending'] = $data[5];
                    $MainCategory['status'] = $data[6];
                    $MainCategory['theme_id'] = $value;
                    $MainCategory['store_id'] = $store->id;
                    $MainCategory->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/main_categories.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $MainCategory = new MainCategory();
                    // $MainCategory['id'] = $data[0];
                    $MainCategory['name'] = $data[1];
                    $MainCategory['image_url'] = $data[2];
                    $MainCategory['image_path'] = $data[3];
                    $MainCategory['icon_path'] = $data[4];
                    $MainCategory['trending'] = $data[5];
                    $MainCategory['status'] = $data[6];
                    $MainCategory['theme_id'] = $theme_id;
                    $MainCategory['store_id'] = $store->id;
                    $MainCategory->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function subcategory_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/sub_categories.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $SubCategory = new SubCategory();
                    // $SubCategory['id'] = $data[0];
                    $SubCategory['name'] = $data[1];
                    $SubCategory['image_url'] = $data[2];
                    $SubCategory['image_path'] = $data[3];
                    $SubCategory['icon_path'] = $data[4];
                    $SubCategory['status'] = $data[5];
                    $SubCategory['maincategory_id'] = $data[6];
                    $SubCategory['theme_id'] = $value;
                    $SubCategory['store_id'] = $store->id;
                    $SubCategory->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/sub_categories.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $SubCategory = new SubCategory();
                    // $SubCategory['id'] = $data[0];
                    $SubCategory['name'] = $data[1];
                    $SubCategory['image_url'] = $data[2];
                    $SubCategory['image_path'] = $data[3];
                    $SubCategory['icon_path'] = $data[4];
                    $SubCategory['status'] = $data[5];
                    $SubCategory['maincategory_id'] = $data[6];
                    $SubCategory['theme_id'] = $theme_id;
                    $SubCategory['store_id'] = $store->id;
                    $SubCategory->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function product_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/products.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $product = new Product();
                    // $product['id'] = $data[0];
                    $product['name'] = $data[1];
                    $product['description'] = $data[2];
                    $product['other_description'] = $data[3];
                    $product['other_description_api'] = $data[4];
                    $product['tag'] = $data[5];
                    $product['tag_api'] = $data[6];
                    $product['category_id'] = $data[7];
                    $product['subcategory_id'] = $data[8];
                    $product['cover_image_path'] = $data[9];
                    $product['cover_image_url'] = $data[10];
                    $product['price'] = $data[11];
                    $product['discount_type'] = $data[12];
                    $product['discount_amount'] = $data[13];
                    $product['product_stock'] = $data[14];
                    $product['variant_product'] = $data[15];
                    $product['variant_id'] = $data[16];
                    $product['variant_attribute'] = $data[17];
                    $product['default_variant_id'] = $data[18];
                    $product['trending'] = $data[19];
                    $product['average_rating'] = $data[20];
                    $product['slug'] = $data[21];
                    $product['theme_id'] = $value;
                    $product['status'] = $data[23];
                    $product['product_option'] = $data[24];
                    $product['product_option_api'] = $data[25];
                    $product['store_id'] = $store->id;
                    $product['created_by'] = $user->id;
                    $product['is_active'] = '1';
                    $product->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/products.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $product = new Product();
                    // $product['id'] = $data[0];
                    $product['name'] = $data[1];
                    $product['description'] = $data[2];
                    $product['other_description'] = $data[3];
                    $product['other_description_api'] = $data[4];
                    $product['tag'] = $data[5];
                    $product['tag_api'] = $data[6];
                    $product['category_id'] = $data[7];
                    $product['subcategory_id'] = $data[8];
                    $product['cover_image_path'] = $data[9];
                    $product['cover_image_url'] = $data[10];
                    $product['price'] = $data[11];
                    $product['discount_type'] = $data[12];
                    $product['discount_amount'] = $data[13];
                    $product['product_stock'] = $data[14];
                    $product['variant_product'] = $data[15];
                    $product['variant_id'] = $data[16];
                    $product['variant_attribute'] = $data[17];
                    $product['default_variant_id'] = $data[18];
                    $product['trending'] = $data[19];
                    $product['average_rating'] = $data[20];
                    $product['slug'] = $data[21];
                    $product['theme_id'] = $theme_id;
                    $product['status'] = $data[23];
                    $product['product_option'] = $data[24];
                    $product['product_option_api'] = $data[25];
                    $product['store_id'] = $store->id;
                    $product['created_by'] = $user->id;
                    $product['is_active'] = '1';
                    $product->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function productimage_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/product_images.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $ProductImage = new ProductImage();
                    // $ProductImage['id'] = $data[0];
                    $ProductImage['product_id'] = $data[1];
                    $ProductImage['image_path'] = $data[2];
                    $ProductImage['image_url'] = $data[3];
                    $ProductImage['theme_id'] = $value;
                    $ProductImage['store_id'] = $store->id;
                    $ProductImage->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/product_images.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $ProductImage = new ProductImage();
                    // $ProductImage['id'] = $data[0];
                    $ProductImage['product_id'] = $data[1];
                    $ProductImage['image_path'] = $data[2];
                    $ProductImage['image_url'] = $data[3];
                    $ProductImage['theme_id'] = $theme_id;
                    $ProductImage['store_id'] = $store->id;
                    $ProductImage->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function productstock_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/product_stocks.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $ProductStock = new ProductStock();
                    // $ProductStock['id'] = $data[0];
                    $ProductStock['product_id'] = $data[1];
                    $ProductStock['variant'] = $data[2];
                    $ProductStock['sku'] = $data[3];
                    $ProductStock['price'] = $data[4];
                    $ProductStock['stock'] = $data[5];
                    $ProductStock['theme_id'] = $value;
                    $ProductStock['store_id'] = $store->id;
                    $ProductStock->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/product_stocks.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $ProductStock = new ProductStock();
                    // $ProductStock['id'] = $data[0];
                    $ProductStock['product_id'] = $data[1];
                    $ProductStock['variant'] = $data[2];
                    $ProductStock['sku'] = $data[3];
                    $ProductStock['price'] = $data[4];
                    $ProductStock['stock'] = $data[5];
                    $ProductStock['theme_id'] = $theme_id;
                    $ProductStock['store_id'] = $store->id;
                    $ProductStock->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function productvariant_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/product_variants.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $ProductVariant = new ProductVariant();
                    // $ProductVariant['id'] = $data[0];
                    $ProductVariant['name'] = $data[1];
                    $ProductVariant['type'] = $data[2];
                    $ProductVariant['theme_id'] = $value;
                    $ProductVariant['store_id'] = $store->id;
                    $ProductVariant->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/product_variants.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $ProductVariant = new ProductVariant();
                    // $ProductVariant['id'] = $data[0];
                    $ProductVariant['name'] = $data[1];
                    $ProductVariant['type'] = $data[2];
                    $ProductVariant['theme_id'] = $theme_id;
                    $ProductVariant['store_id'] = $store->id;
                    $ProductVariant->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function shipping_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/shippings.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $shipping = new Shipping();
                    $shipping['name'] = $data[1];
                    $shipping['slug'] = $data[2];
                    $shipping['description'] = $data[3];
                    $shipping['theme_id'] = $value;
                    $shipping['store_id'] = $store->id;
                    $shipping->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/shippings.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $shipping = new Shipping();
                    $shipping['name'] = $data[1];
                    $shipping['slug'] = $data[2];
                    $shipping['description'] = $data[3];
                    $shipping['theme_id'] = $theme_id;
                    $shipping['store_id'] = $store->id;
                    $shipping->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function shipping_methods($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/shipping_methods.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $shipping = new ShippingMethod();
                    $shipping['method_name'] = $data[1];
                    $shipping['zone_id'] = $data[2];
                    $shipping['cost'] = $data[3];
                    $shipping['product_cost'] = $data[4];
                    $shipping['calculation_type'] = $data[5];
                    $shipping['shipping_requires'] = $data[6];
                    $shipping['theme_id'] = $value;
                    $shipping['store_id'] = $store->id;
                    $shipping->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/shipping_methods.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $shipping = new ShippingMethod();
                    $shipping['method_name'] = $data[1];
                    $shipping['zone_id'] = $data[2];
                    $shipping['cost'] = $data[3];
                    $shipping['product_cost'] = $data[4];
                    $shipping['calculation_type'] = $data[5];
                    $shipping['shipping_requires'] = $data[6];
                    $shipping['theme_id'] = $theme_id;
                    $shipping['store_id'] = $store->id;
                    $shipping->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function shipping_zones($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/shipping_zones.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $shipping = new ShippingZone();
                    $shipping['zone_name'] = $data[1];
                    $shipping['country_id'] = $data[2];
                    $shipping['state_id'] = $data[3];
                    $shipping['shipping_method'] = $data[4];
                    $shipping['theme_id'] = $value;
                    $shipping['store_id'] = $store->id;
                    $shipping->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/shipping_zones.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $shipping = new ShippingZone();
                    $shipping['zone_name'] = $data[1];
                    $shipping['country_id'] = $data[2];
                    $shipping['state_id'] = $data[3];
                    $shipping['shipping_method'] = $data[4];
                    $shipping['theme_id'] = $theme_id;
                    $shipping['store_id'] = $store->id;
                    $shipping->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function review_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/reviews.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $review = new Review();
                    // $review['id'] = $data[0];
                    $review['user_id'] = $data[1];
                    $review['category_id'] = $data[2];
                    $review['product_id'] = $data[3];
                    $review['rating_no'] = $data[4];
                    $review['title'] = $data[5];
                    $review['description'] = $data[6];
                    $review['status'] = $data[7];
                    $review['theme_id'] = $value;
                    $review['store_id'] = $store->id;
                    $review->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/reviews.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {

                    $review = new Review();
                    // $review['id'] = $data[0];
                    $review['user_id'] = $data[1];
                    $review['category_id'] = $data[2];
                    $review['product_id'] = $data[3];
                    $review['rating_no'] = $data[4];
                    $review['title'] = $data[5];
                    $review['description'] = $data[6];
                    $review['status'] = $data[7];
                    $review['theme_id'] = $theme_id;
                    $review['store_id'] = $store->id;
                    $review->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function app_setting_insert($company_id, $store_id = '', $theme_id = '')
    {
        if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
            $user = Admin::find($company_id);
            $store = Store::where('id', $user->current_store)->first();
            $theme = Admin::$defalut_theme;

            foreach ($theme as $key => $value) {
                $csvData = fopen(base_path('themes/' . $value . '/DB/app_settings.csv'), 'r');

                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $appsetting = new AppSetting();
                    // $appsetting['id'] = $data[0];
                    $appsetting['theme_id'] = $value;
                    $appsetting['page_name'] = $data[2];
                    $appsetting['theme_json'] = $data[3];
                    $appsetting['theme_json_api'] = $data[4];
                    $appsetting['store_id'] = $store->id;
                    $appsetting->save();
                }
                fclose($csvData);
            }
        } else {
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);

                $csvData = fopen(base_path('themes/' . $theme_id . '/DB/app_settings.csv'), 'r');
                while (($data = fgetcsv($csvData, 555, ',')) !== false) {
                    $appsetting = new AppSetting();
                    // $appsetting['id'] = $data[0];
                    $appsetting['theme_id'] = $theme_id;
                    $appsetting['page_name'] = $data[2];
                    $appsetting['theme_json'] = $data[3];
                    $appsetting['theme_json_api'] = $data[4];
                    $appsetting['store_id'] = $store->id;
                    $appsetting->save();
                }
                fclose($csvData);
            }
        }
    }

    public static function getAdminPaymentSetting()
    {
        $data = DB::table('settings');
        $settings = [];
        if (\Auth::check()) {
            $user_id = 1;
            $data = $data->where('created_by', '=', $user_id);
        }
        $data = $data->get();
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }
    public static function themeOne()
    {
        $arr = [];
        $folder = array_filter(glob('themes/*'), 'is_dir');
        $folders = str_replace("themes/", "", $folder);

        foreach ($folders as $key => $value) {
            $arr[$value] = [
                'img_path' => asset('themes/' . $value . '/theme_img/img_1.png'),
                'theme_name' => $value
            ];
        }
        return $arr;
    }

    public static function BuyMoreTheme()
    {
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'http://192.168.29.94/workdo-site/api/themedata',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'GET',
        // ));
        // $response = curl_exec($curl);
        // curl_close($curl);
        // // echo $response;

        // return json_decode($response);

        // $theme = array (
        //     array("style",'https://apps.rajodiya.com/ecommerce/theme/style','https://workdo.io/services/images/package_ecommerce/style/style-desktop-preview.png','https://workdo.io/packages/e-commerce/style'),
        //     array("steps",'https://apps.rajodiya.com/ecommerce/theme/steps','https://workdo.io/services/images/package_ecommerce/steps/steps-desktop-preview.png','https://workdo.io/packages/e-commerce/steps'),
        //     array("babycare",'https://apps.rajodiya.com/ecommerce/theme/babycare','https://workdo.io/services/images/package_ecommerce/babycare/babycare-desktop-preview.png','https://workdo.io/packages/e-commerce/babycare'),
        //     array("eyewear",'https://apps.rajodiya.com/ecommerce/theme/eyewear','https://workdo.io/services/images/package_ecommerce/eyewear/eyewear-desktop-preview.png','https://workdo.io/packages/e-commerce/eyewear'),
        //     array("scent",'https://apps.rajodiya.com/ecommerce/theme/scent','https://workdo.io/services/images/package_ecommerce/scent/scent-desktop-preview.png','https://workdo.io/packages/e-commerce/scent'),
        //     array("diamond",'https://apps.rajodiya.com/ecommerce/theme/diamond','https://workdo.io/services/images/package_ecommerce/diamond/diamond-desktop-preview.png','https://workdo.io/packages/e-commerce/diamond'),
        //     array("menswear",'https://apps.rajodiya.com/ecommerce/theme/menswear','https://workdo.io/services/images/package_ecommerce/menswear/menswear-desktop-preview.png','https://workdo.io/packages/e-commerce/menswear'),
        //     array("chocolate",'https://apps.rajodiya.com/ecommerce/theme/chocolate','https://workdo.io/services/images/package_ecommerce/chocolate/chocolate-desktop-preview.png','https://workdo.io/packages/e-commerce/chocolate'),
        //     array("garden",'https://apps.rajodiya.com/ecommerce/theme/garden','https://workdo.io/services/images/package_ecommerce/garden/garden-desktop-preview.png','https://workdo.io/packages/e-commerce/garden'),
        //     array("gifts",'https://apps.rajodiya.com/ecommerce/theme/gifts','https://workdo.io/services/images/package_ecommerce/gifts/gifts-desktop-preview.png','https://workdo.io/packages/e-commerce/gifts'),
        //     array("grocery",'https://apps.rajodiya.com/ecommerce/theme/grocery','https://workdo.io/services/images/package_ecommerce/grocery/grocery-desktop-preview.png','https://workdo.io/packages/e-commerce/grocery'),

        //   );
        //   return $theme;
        $json = json_decode(file_get_contents('https://apps.rajodiya.com/cronjob/addon.json'), true);
        if (!empty($json)) {
            return $json;
        }
    }

    public static function pixel_plateforms()
    {
        $plateforms = [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'linkedin' => 'Linkedin',
            'pinterest' => 'Pinterest',
            'quora' => 'Quora',
            'bing' => 'Bing',
            'google-adwords' => 'Google Adwords',
            'google-analytics' => 'Google Analytics',
            'snapchat' => 'Snapchat',
            'tiktok' => 'Tiktok',
        ];

        return $plateforms;
    }

    public static function languages()
    {
        $dir = base_path() . '/resources/lang/';
        $glob = glob($dir . "*", GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir) {
                return str_replace($dir, '', $value);
            },
            $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir) {
                return preg_replace('/[0-9]+/', '', $value);
            },
            $arrLang
        );
        $arrLang = array_filter($arrLang);

        $test = base_path('resources/lang/language.json');
        $arrLang = json_decode(file_get_contents($test), true);

        return $arrLang;
    }

    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public static function cookies()
    {
        $data = DB::table('settings');
        if (\Auth::check()) {
            $userId = \Auth::user()->creatorId();
            $data = $data->where('created_by', '=', $userId);
        } else {
            $data = $data->where('created_by', '=', 1);
        }
        $data = $data->get();
        $cookies = [
            'enable_cookie' => 'on',
            'necessary_cookies' => 'on',
            'cookie_logging' => 'on',
            'cookie_title' => 'We use cookies!',
            'cookie_description' => 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title' => 'Strictly necessary cookies',
            'strictly_cookie_description' => 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description' => 'For any queries in relation to our policy on cookies and your choices, please ',
            "more_information_title" => "",
            'contactus_url' => '#',
        ];
        foreach ($data as $key => $row) {
            if (in_array($row->name, $cookies)) {
                $cookies[$row->name] = $row->value;
            }
        }
        return $cookies;
    }

    public static function get_device_type($user_agent)
    {
        $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';
        if (preg_match_all($mobile_regex, $user_agent)) {
            return 'mobile';
        } else {
            if (preg_match_all($tablet_regex, $user_agent)) {
                return 'tablet';
            } else {
                return 'desktop';
            }
        }
    }

    public static function flagOfCountry()
    {
        $arr = [
            'ar' => '🇦🇪 ar',
            'da' => '🇩🇰 ad',
            'de' => '🇩🇪 de',
            'es' => '🇪🇸 es',
            'fr' => '🇫🇷 fr',
            'it'    =>  '🇮🇹 it',
            'ja' => '🇯🇵 ja',
            'nl' => '🇳🇱 nl',
            'pl' => '🇵🇱 pl',
            'ru' => '🇷🇺 ru',
            'pt' => '🇵🇹 pt',
            'en' => '🇮🇳 en',
            'tr' => '🇹🇷 tr',
            'pt-br' => '🇧🇷 pt-br',
        ];
        return $arr;
    }

    public static function taxRate($taxRate, $price, $quantity)
    {
        return ($taxRate / 100) * ($price * $quantity);
    }

    public static function GetCacheSize()
    {
        $file_size = 0;
        foreach (\File::allFiles(storage_path('/framework')) as $file) {
            $file_size += $file->getSize();
        }
        $file_size = number_format($file_size / 1000000, 4);
        return $file_size;
    }

    //woocommerce
    public static function upload_woo_file($request, $name, $path)
    {
        try {
            $settings = Setting::where('theme_id', 'grocery')->where('store_id', 1)->pluck('value', 'name')->toArray();
        // dd($request, $name, $path);

            if (!isset($settings['storage_setting'])) {
                $settings = Utility::Seting();
            }

            if (!empty($settings['storage_setting'])) {
                if ($settings['storage_setting'] == 'wasabi') {
                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['wasabi_storage_validation']) ? $settings['wasabi_storage_validation'] : '';
                } else if ($settings['storage_setting'] == 's3') {
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : '2048';
                    $mimes =  !empty($settings['s3_storage_validation']) ? $settings['s3_storage_validation'] : '';
                } else {
                    $max_size = !empty($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : '2048';

                    $mimes =  !empty($settings['local_storage_validation']) ? $settings['local_storage_validation'] : '';
                }


                $request = str_replace("\0", '', $request);
                $file = file_get_contents($request);
                if ($settings['storage_setting'] == 'local') {
        // dd($file);
                    $save = Storage::disk('theme')->put($path . '/' . $name, $file);
                    // dd($save , $request ,$file , $path , $name);

                } else {
                    $save = Storage::disk($settings['storage_setting'])->put($path . '/' . $name, $file);
                }
                $image_url = '';
                if ($settings['storage_setting'] == 'wasabi') {
                    $url = $path . $name;
                    $image_url = \Storage::disk('wasabi')->url($url);
                } elseif ($settings['storage_setting'] == 's3') {
                    $url = $path . $name;
                    $image_url = \Storage::disk('s3')->url($url);
                } else {

                    $url = $path . $name;
                    $image_url = url($path  . $name);
                }

                $res = [
                    'flag' => 1,
                    'msg'  => 'success',
                    'url'  => $url,
                    'image_path'  => $url,
                    'full_url'    => $image_url
                ];
                return $res;
            } else {
                $res = [
                    'flag' => 0,
                    'msg' => 'not set configurations',
                ];
                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    // used for replace email variable (parameter 'template_name','id(get particular record by id for data)')


    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{store_name}',
            '{order_no}',
            '{customer_name}',
            '{billing_address}',
            '{billing_country}',
            '{billing_city}',
            '{billing_postalcode}',
            '{shipping_address}',
            '{shipping_country}',
            '{shipping_city}',
            '{shipping_postalcode}',
            '{item_variable}',
            '{qty_total}',
            '{sub_total}',
            '{discount_amount}',
            '{shipping_amount}',
            '{total_tax}',
            '{final_total}',
            '{sku}',
            '{quantity}',
            '{product_name}',
            '{product_id}',
            '{variant_name}',
            '{item_tax}',
            '{item_total}',
            '{app_name}',
            '{cart_table}',
            '{wish-list_table}',
        ];
        $arrValue = [
            'store_name' => '',
            'order_no' => '',
            'customer_name' => '',
            'billing_address' => '',
            'billing_country' => '',
            'billing_city' => '',
            'billing_postalcode' => '',
            'shipping_address' => '',
            'shipping_country' => '',
            'shipping_city' => '',
            'shipping_postalcode' => '',
            'item_variable' => '',
            'qty_total' => '',
            'sub_total' => '',
            'discount_amount' => '',
            'shipping_amount' => '',
            'total_tax' => '',
            'final_total' => '',
            'sku' => '',
            'quantity' => '',
            'product_name' => '',
            'product_id' => '',
            'variant_name' => '',
            'item_tax' => '',
            'item_total' => '',
            'app_name' => '',
            'cart_table' => '',
            'wishlist_table' => '',
        ];

        foreach ($obj as $key => $val) {
            $arrValue[$key] = $val;
        }

        $arrValue['app_name'] = env('APP_NAME');
        $arrValue['app_url'] = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        return str_replace($arrVariable, array_values($arrValue), $content);
    }    
    
    //for storage limit start
    public static function updateStorageLimit($company_id, $image_size)
    {
        $image_size = number_format($image_size / 1048576, 2);
        $user   = Admin::find($company_id);
        $plan   = Plan::find($user->plan);
        $total_storage = $user->storage_limit + $image_size;
        if ($plan->storage_limit <= $total_storage && $plan->storage_limit != -1) {
            $error = __('Plan storage limit is over so please upgrade the plan.');
            return $error;
        } else {
            $user->storage_limit = $total_storage;
        }

        $user->save();

        return 1;
    }

    public static function  changeStorageLimit($company_id, $file_path)
    {
        $files =  \File::glob(base_path($file_path));
        $fileSize = 0;
        foreach ($files as $file) {
            $fileSize += \File::size($file);
        }

        $image_size = number_format($fileSize / 1048576, 2);
        $user   = Admin::find($company_id);
        $plan   = Plan::find($user->plan);
        $total_storage = $user->storage_limit - $image_size;
        $user->storage_limit = $total_storage;
        $user->save();
        $status = false;
        foreach ($files as $key => $file) {
            if (\File::exists($file)) {
                $status = \File::delete($file);
            }
        }

        return true;
    }

    public static function  changeproductStorageLimit($company_id, $file_path)
    {
        $files = [];
        foreach ($file_path as $key => $file_p) {
            $pattern = base_path($file_p);
            $files1 = \File::glob($pattern);
            if (!empty($files1)) {
                $files = array_merge($files, $files1);
            }
        }
        $fileSize = 0;
        foreach ($files as $file) {
            $fileSize += \File::size($file);
        }
        $image_size = number_format($fileSize / 1048576, 2);

        $user   = Admin::find($company_id);
        $plan   = Plan::find($user->plan);
        $total_storage = $user->storage_limit - $image_size;

        $user->storage_limit = $total_storage;
        $user->save();

        $status = false;
        foreach ($files as $key => $file) {
            if (\File::exists($file)) {
                $status = \File::delete($file);
            }
        }

        return true;
    }
    //for storage limit end

    // Email Template Modules Function start
    public static function userDefaultData()
    {
        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();
        foreach ($allEmail as $email) {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => 2,
                    'is_active' => 0,
                ]
            );
        }
    }

    public static function replaceVariables($content, $obj, $store, $order,$user_id = 0)
    {
        // dd($content, $obj, $store, $order);

        $arrVariable = [
            '{app_name}',
            '{order_id}',
            '{order_status}',
            '{app_url}',
            '{order_url}',
            // '{order_id}',
            '{owner_name}',
            '{order_date}',
            '{cart_table}',
            '{wishlist_table}',
        ];
        $arrValue = [
            'app_name' => '-',
            'order_id' => '-',
            'order_status' => '-',
            'app_url' => '-',
            'order_url' => '-',
            // 'order_id' => '-',
            'owner_name' => '-',
            'order_date' => '-',
            'cart_table' => '-',
            'wishlist_table' => '-',


        ];

        foreach ($obj as $key => $val) {
            $arrValue[$key] = $val;
        }
        $arrValue['app_name'] = $store->name;
        $arrValue['app_url'] = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';
        $arrValue['order_url'] = '<a href="' . env('APP_URL') . '/' . $store->slug . '/order/' . $order . '" target="_blank">' . env('APP_URL') . '/' . $store->slug . '/order/' . $order . '</a>';

        $ownername = Admin::where('id', $store->created_by)->first();
        $id = Crypt::decrypt($order);

        $order = Order::where('id', $id)->first();
        $arrValue['owner_name'] = $ownername->name;
        $arrValue['order_id'] = isset($order->product_order_id) ? $order->product_order_id : 0;
        $arrValue['order_date'] = isset($order->product_order_id) ? self::dateFormat($order->created_at) : 0;

        // Abandon Cart
        $cart = Cart::where('user_id', $user_id)->where('theme_id', APP_THEME())->get();
        if(!$cart->isEmpty())
        {
            $listItems = '    <table style="width:100%">';
            $listItems .= '    <tr>';
            $listItems .= '    <th style="">Image</th>';
            $listItems .= '    <th>Name </th>';
            $listItems .= '    <th>Quantity</th>';
            $listItems .= '    <th>Price</th>';
            $listItems .= '    </tr>';


            foreach ($obj as $item) {
                $product = Product::where('id', $item->product_id)->first();
                $listItems .= '<tr>';

                // $listItems .= '<td>';
                $listItems .= '<td>'.'<img src="' . get_file($product->cover_image_path, APP_THEME()) . '" height="60" width="80" ">'.'</td>';
                $listItems .= '<td>' . $product->name . '</td>';
                $listItems .= '<td>' . $item->qty . '</td>';
                $listItems .= '<td>' . $item->price . '</td>';
                $listItems .= '</td>';
                $listItems .= '</tr>';
            }
            $listItems .= '</table>';

            $arrValue['cart_table'] = $listItems;
        }

        $Wishlist = Wishlist::where('user_id', $user_id)->where('theme_id', APP_THEME())->get();
        if(!$Wishlist->isEmpty())
        {
            // Abandon  Wishlist
            $wishItems = '    <table style="width:50%">';
            $wishItems .= '    <tr>';
            $wishItems .= '    <th style="">Image</th>';
            $wishItems .= '    <th>Name </th>';
            $wishItems .= '    </tr>';


            foreach ($obj as $item) {
                $product = Product::where('id', $item->product_id)->first();
                $wishItems .= '<tr>';

                // $wishItems .= '<td>';
                $wishItems .= '<td>'.'<img src="' . get_file($product->cover_image_path, APP_THEME()) . '" height="60" width="80" ">'.'</td>';
                $wishItems .= '<td>' . $product->name . '</td>';
                $wishItems .= '</td>';
                $wishItems .= '</tr>';
            }
            $wishItems .= '</table>';

            $arrValue['wishlist_table'] = $wishItems;
        }
        return str_replace($arrVariable, array_values($arrValue), $content);
    }
    // used for replace email variable (parameter 'template_name','id(get particular record by id for data)')


    // Common Function That used to send mail with check all cases
    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj, $owner, $store, $order)
    {
        // find template is exist or not in our record
        $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();

        $theme_id = $store->theme_id;
        if (isset($template) && !empty($template)) {

            // check template is active or not by company
            $is_actives = UserEmailTemplate::where('template_id', '=', $template->id)->first();
            $settings = Setting::where('theme_id', $theme_id)->where('store_id', $store->id)->pluck('value', 'name')->toArray();

            if ($is_actives->is_active == 1) {

                // get email content language base
                $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $owner->lang)->first();

                // $user_lang = Admin::where('id', $usr->currant_workspace)->first();
                $content->from = $template->from;

                if (!empty($content->content) && $order != null) {
                    $content->content = self::replaceVariables($content->content, $obj, $store, $order);
                    // dd($content,$owner->lang);
                    // send email

                    try {
                        config(
                            [
                                'mail.driver' => $settings['MAIL_DRIVER'],
                                'mail.host' => $settings['MAIL_HOST'],
                                'mail.port' => $settings['MAIL_PORT'],
                                'mail.encryption' => $settings['MAIL_ENCRYPTION'],
                                'mail.username' => $settings['MAIL_USERNAME'],
                                'mail.password' => $settings['MAIL_PASSWORD'],
                                'mail.from.address' => $settings['MAIL_FROM_ADDRESS'],
                                'mail.from.name' => $settings['MAIL_FROM_NAME'],
                            ]
                        );

                        $orders = Order::find(Crypt::decrypt($order));
                        $product = Product::find(Crypt::decrypt($order));

                        $ownername = Admin::where('id', $store->created_by)->first();
                        if ($mailTo == $ownername->email) {

                            Mail::to(
                                [
                                    $store['email'],
                                ]
                            )->send(new CommonEmailTemplate($content, $settings, $store));
                        } else {
                            Mail::to(
                                [
                                    $mailTo,
                                ]
                            )->send(new CommonEmailTemplate($content, $settings, $store));
                        }
                    } catch (\Exception $e) {
                        $error = __('E-Mail has been not sent due to SMTP configuration');
                    }
                    if (isset($error)) {
                        $arReturn = [
                            'is_success' => false,
                            'error' => $error,
                        ];
                    } else {
                        $arReturn = [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                } else if ($order == null) {

                    $content->content = self::replaceVariable($content->content, $obj);

                    // send email
                    try {
                        config(
                            [
                                'mail.driver' => $settings['MAIL_DRIVER'],
                                'mail.host' => $settings['MAIL_HOST'],
                                'mail.port' => $settings['MAIL_PORT'],
                                'mail.encryption' => $settings['MAIL_ENCRYPTION'],
                                'mail.username' => $settings['MAIL_USERNAME'],
                                'mail.password' => $settings['MAIL_PASSWORD'],
                                'mail.from.address' => $settings['MAIL_FROM_ADDRESS'],
                                'mail.from.name' => $settings['MAIL_FROM_NAME'],
                            ]
                        );

                        $ownername = Admin::where('id', $store->created_by)->first();

                        if ($mailTo != null) {

                            Mail::to(
                                [
                                    $mailTo,
                                ]
                            )->send(new CommonEmailTemplate($content, $settings, $store));
                        }
                    } catch (\Exception $e) {
                        $error = __('E-Mail has been not sent due to SMTP configuration');
                    }
                    if (isset($error)) {
                        $arReturn = [
                            'is_success' => false,
                            'error' => $error,
                        ];
                    } else {
                        $arReturn = [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                } else {
                    $arReturn = [
                        'is_success' => false,
                        'error' => __('Mail not send, email is empty'),
                    ];
                }
                return $arReturn;
            } else {
                return [
                    'is_success' => true,
                    'error' => false,
                ];
            }
        } else {
            return [
                'is_success' => false,
                'error' => __('Mail not send, email not found'),
            ];
        }
        //        }
    }

    // Make Entry in email_tempalte_lang table when create new language
    public static function makeEmailLang($lang)
    {
        $template = EmailTemplate::all();
        foreach ($template as $t) {
            $default_lang = EmailTemplateLang::where('parent_id', '=', $t->id)->where('lang', 'LIKE', 'en')->first();
            $emailTemplateLang = new EmailTemplateLang();
            $emailTemplateLang->parent_id = $t->id;
            $emailTemplateLang->lang = $lang;
            $emailTemplateLang->subject = $default_lang->subject;
            $emailTemplateLang->content = $default_lang->content;
            $emailTemplateLang->save();
        }
    }

    // For Email template Module
    public static function defaultEmail()
    {
        // Email Template
        $emailTemplate = [
            'Order Created',
            'Status Change',
            'Order Created For Owner',
            'Stock Status',
            'Abandon Cart',
            'Abandon Wishlist',
        ];

        foreach ($emailTemplate as $eTemp)
        {
            $emailTemp = EmailTemplate::where('name',$eTemp)->count();
            if($emailTemp == 0)
            {
                EmailTemplate::create(
                    [
                        'name' => $eTemp,
                        'from' => env('APP_NAME'),
                        'created_by' => 1,
                    ]
                );
            }
        }

        $defaultTemplate = [
            'Order Created' => [
                'subject' => 'Order Complete',
                'lang' => [
                    'ar' => '<p>مرحبا ،</p><p>مرحبا بك في {app_name}.</p><p>مرحبا ، {order_id} ، شكرا للتسوق</p><p>لقد تلقينا طلب الشراء الخاص بك ، سنكون على اتصال بعد وقت قصير !</p><p>شكرا ،</p><p>{app_name}</p><p>{order_url}</p>',
                    'da' => '<p>Hej, &nbsp;</p><p>Velkommen til {app_name}.</p><p>Hej, {order_id}, Tak for din indkøbsanmodning</p><p>Vi har modtaget din købsanmodning.</p><p>Tak,</p><p>{app_name}</p><p>{order_url}</p>',
                    'de' => '<p>Hallo, &nbsp;</p><p>Willkommen bei {app_name}.</p><p>Hi, {order_id}, Vielen Dank für Shopping</p><p>Wir haben Ihre Kaufanforderung erhalten, wir werden in Kürze in Kontakt sein!</p><p>Danke,</p><p>{app_name}</p><p>{order_url}</p>',
                    'en' => '<p>Hello,&nbsp;</p><p>Welcome to {app_name}.</p><p>Hi, {order_id}, Thank you for Shopping</p><p>We received your purchase request, we\'ll be in touch shortly!</p><p>Thanks,</p><p>{app_name}</p><p>{order_url}</p>',
                    'es' => '<p>Hola, &nbsp;</p><p>Bienvenido a {app_name}.</p><p>Hi, {order_id}, Thank you for Shopping</p><p>Recibimos su solicitud de compra, ¡estaremos en contacto en breve!</p><p>Gracias,</p><p>{app_name}</p><p>{order_url}</p>',
                    'fr' => '<p>Bonjour, &nbsp;</p><p>Bienvenue dans {app_name}.</p><p>Hi, {order_id}, Thank you for Shopping</p><p>We reçus your purchase request, we \'ll be in touch incess!</p><p>Thanks,</p><p>{app_name}</p><p>{order_url}</p>',
                    'it' => '<p>Ciao, &nbsp;</p><p>Benvenuti in {app_name}.</p><p>Ciao, {order_id}, Grazie per Shopping</p><p>Abbiamo ricevuto la tua richiesta di acquisto, noi \ saremo in contatto a breve!</p><p>Grazie,</p><p>{app_name}</p><p>{order_url}</p>',
                    'ja' => '<p>こんにちは &nbsp;</p><p>{app_name}にようこそ。</p><p>こんにちは、 {order_id}、ショッピング</p>ありがとうございます。</p><p>購入要求を受け取りました。すぐに連絡を取ります。</p><p>ありがとうございます。</p><p>{app_name}</p><p>{order_url}</p>',
                    'nl' => '<p>Hallo, &nbsp;</p><p>Welkom bij {app_name}.</p><p>Hallo, {order_id}, Dank u voor Winkelen</p><p>We hebben uw aankoopaanvraag ontvangen, we zijn binnenkort in contact!</p><p>Bedankt,</p><p>{app_name}</p><p>{order_url}</p>',
                    'pl' => '<p>Witaj, &nbsp;</p><p>Witamy w aplikacji {app_name}.</p><p>Hi, {order_id}, Dziękujemy za zakupy</p><p>Otrzymamy Twój wniosek o zakup, wkrótce skontaktujemy się z Tobą!</p><p>Dzięki,</p><p>{app_name}</p><p>{order_url}</p>',
                    'ru' => '<p>Hello, &nbsp;</p><p>Добро пожаловать в {app_name}.</p><p>Hi, {order_id}, Thank you for Shopping</p><p>Мы получили ваш запрос на покупку, мы \ скоро свяжемся!</p><p>Thanks,</p><p>{app_name}</p><p>{order_url}</p>',
                    'pt' => '<p>Olá, &nbsp;</p><p>Bem-vindo a {app_name}.</p><p>Oi, {order_id}, Obrigado por Shopping</p><p>Recebemos o seu pedido de compra, nós \ estaremos em contato em breve!</p><p>Obrigado,</p><p>{app_name}</p><p>{order_url}</p>',
                    'zh' => '<p>您好，</p><p>欢迎访问 {app_name}。</p><p>您好， {order_id}，感谢购物</p><p>我们收到您的购买请求，我们很快就会联系到 !</p><p>谢谢，</p><p>{app_name}</p><p>{order_url}</p>',
                    'he' => '<p>שלום, &nbsp;</p><p>ברוכים הבאים אל {app_name}.</p><p>היי, {order_id}, תודה על Shopping</p><p>קיבלנו את בקשת הרכש שלכם, נהיה בקשר בקרוב!</p><p>תודה,</p><p>{app_name}</p><p>{order_url}</p>',
                    'tr' => '<p>Merhaba, &nbsp;</p><p>{app_name} olanağına hoş geldiniz.</p><p>Merhaba, {order_id}, Alışveriş için teşekkür ederiz</p><p>Satın alma talebinizi aldık, kısa süre içinde olacağız!</p><p>Teşekkürler,</p><p>{app_name}</p><p>{order_url}</p>',
                    'pt-br' => '<p>Olá, &nbsp;</p><p>Bem-vindo a {app_name}.</p><p>Oi, {order_id}, Obrigado por Shopping</p><p>Recebemos o seu pedido de compra, nós \ estaremos em contato em breve!</p><p>Obrigado,</p><p>{app_name}</p><p>{order_url}</p>',

                ],
            ],
            'Status Change' => [
                'subject' => 'Order Status',
                'lang' => [
                    'ar' => '<p>مرحبا ،</p><p>مرحبا بك في {app_name}.</p><p>الأمر الخاص بك هو {order_status} !</p><p>مرحبا {order_id} ، شكرا للتسوق</p><p>شكرا ،</p><p>{app_name}</p><p>{order_url}</p>',
                    'da' => '<p>Hej, &nbsp;</p><p>Velkommen til {app_name}.</p><p>Din ordre er {order_status}!</p><p>Hej {order_id}, Tak for at Shopping</p><p>Tak,</p><p>{app_name}</p><p>{order_url}</p>',
                    'de' => '<p>Hello, &nbsp;</p><p>Willkommen bei {app_name}.</p><p>Ihre Bestellung lautet {order_status}!</p><p>Hi {order_id}, Danke für Shopping</p><p>Danke,</p><p>{app_name}</p><p>{order_url}</p>',
                    'en' => '<p>Hello,&nbsp;</p><p>Welcome to {app_name}.</p><p>Your Order is {order_status}!</p><p>Hi {order_id}, Thank you for Shopping</p><p>Thanks,</p><p>{app_name}</p><p>{order_url}</p>',
                    'es' => '<p>Hola, &nbsp;</p><p>Bienvenido a {app_name}.</p><p>Your Order is {order_status}!</p><p>Hi {order_id}, Thank you for Shopping</p><p>Thanks,</p><p>{app_name}</p><p>{order_url}</p>',
                    'fr' => '<p>Bonjour, &nbsp;</p><p>Bienvenue dans {app_name}.</p><p>Votre commande est {order_status} !</p><p>Hi {order_id}, Thank you for Shopping</p><p>Thanks,</p><p>{app_name}</p><p>{order_url}</p>',
                    'it' => '<p>Ciao, &nbsp;</p><p>Benvenuti in {app_name}.</p><p>Il tuo ordine è {order_status}!</p><p>Ciao {order_id}, Grazie per Shopping</p><p>Grazie,</p><p>{app_name}</p><p>{order_url}</p>',
                    'ja' => '<p>こんにちは &nbsp;</p><p>{app_name}へようこそ</p><p>注文は {order_status}です。</p><p>ハイ・ {order_id}、<p>{app_name}</p><p><p>{order_url}</p></p><p>{app_name}</p>に感謝しています。</p>',
                    'nl' => '<p>Hallo, &nbsp;</p><p>Welkom bij {app_name}.</p><p>Uw bestelling is {order_status}!</p><p>Hi {order_id}, Dank u voor Winkelen</p><p>Bedankt,</p><p>{app_name}</p><p>{order_url}</p>',
                    'pl' => '<p>Hello, &nbsp;</p><p>Witamy w aplikacji {app_name}.</p><p>Twoje zamówienie to {order_status}!</p><p>Hi {order_id}, Dziękujemy za zakupy</p><p>Thanks,</p><p>{app_name}</p><p>{order_url }</p>',
                    'ru' => '<p>Здравствуйте, &nbsp;</p><p>Вас приветствует {app_name}.</p><p>Ваш заказ-{order_status}!</p><p>Hi {order_id}, Thank you for Shopping</p><p>Thanks,</p><p>{app_name}</p><p>{order_url}</p>',
                    'pt' => '<p>Olá, &nbsp;</p><p>Bem-vindo a {app_name}.</p><p>Sua Ordem é {order_status}!</p><p>Hi {order_id}, Obrigado por Shopping</p><p>Obrigado,</p><p>{app_name}</p><p>{order_url}</p>',
                    'zh' => '<p>您好，</p><p>欢迎访问 {app_name}。</p><p>您的订单为 {order_status}!</p><p>Hi {order_id}，感谢购物</p><p>谢谢，</p><p>{app_name}</p><p>{order_url}</p>',
                    'he' => '<p>שלום, &nbsp;</p><p>ברוכים הבאים אל {app_name}.</p><p>ההזמנה שלכם היא {order_status}!</p><p>היי {order_id}, תודה על Shopping</p><p>תודה,</p><p>{app_name}</p><p>{order_url}</p>',
                    'tr' => '<p>Merhaba, &nbsp;</p><p>{app_name} olanağına hoş geldiniz.</p><p>Siparişiniz {order_status}!</p><p>Merhaba {order_id}, Alışveriş için teşekkür ederiz</p><p>Teşekkürler,</p><p>{app_name}</p><p>{order_url}</p>',
                    'pt-br' => '<p>Olá, &nbsp;</p><p>Bem-vindo a {app_name}.</p><p>Sua Ordem é {order_status}!</p><p>Hi {order_id}, Obrigado por Shopping</p><p>Obrigado,</p><p>{app_name}</p><p>{order_url}</p>',
                ],
            ],

            'Order Created For Owner' => [
                'subject' => 'Order Detail',
                'lang' => [
                    'ar' => '<p> مرحبًا ، </ p> <p> عزيزي {owner_name}. </p> <p> هذا أمر تأكيد {order_id} ضعه على <span style = \"font-size: 1rem؛\"> {order_date}. </span> </p> <p> شكرًا ، </ p> <p> {order_url} </p>',
                    'da' => '<p>Hej </p><p>Kære {owner_name}.</p><p>Dette er ordrebekræftelse {order_id} sted på <span style=\"font-size: 1rem;\">{order_date}. </span></p><p>Tak,</p><p>{order_url}</p>',
                    'de' => '<p>Hallo, </p><p>Sehr geehrter {owner_name}.</p><p>Dies ist die Auftragsbestätigung {order_id}, die am <span style=\"font-size: 1rem;\">{order_date} aufgegeben wurde. </span></p><p>Danke,</p><p>{order_url}</p>',
                    'en' => '<p>Hello,&nbsp;</p><p>Dear {owner_name}.</p><p>This is Confirmation Order {order_id} place on&nbsp;<span style=\"font-size: 1rem;\">{order_date}.</span></p><p>Thanks,</p><p>{order_url}</p>',
                    'es' => '<p> Hola, </p> <p> Estimado {owner_name}. </p> <p> Este es el lugar de la orden de confirmación {order_id} en <span style = \"font-size: 1rem;\"> {order_date}. </span> </p> <p> Gracias, </p> <p> {order_url} </p>',
                    'fr' => '<p>Bonjour, </p><p>Cher {owner_name}.</p><p>Ceci est la commande de confirmation {order_id} passée le <span style=\"font-size: 1rem;\">{order_date}. </span></p><p>Merci,</p><p>{order_url}</p>',
                    'it' => '<p>Ciao, </p><p>Gentile {owner_name}.</p><p>Questo è l\'ordine di conferma {order_id} effettuato su <span style=\"font-size: 1rem;\">{order_date}. </span></p><p>Grazie,</p><p>{order_url}</p>',
                    'ja' => '<p>こんにちは、</ p> <p>親愛なる{owner_name}。</ p> <p>これは、<span style = \"font-size：1rem;\"> {order_date}の確認注文{order_id}の場所です。 </ span> </ p> <p>ありがとうございます</ p> <p> {order_url} </ p>',
                    'nl' => '<p>Hallo, </p><p>Beste {owner_name}.</p><p>Dit is de bevestigingsopdracht {order_id} die is geplaatst op <span style=\"font-size: 1rem;\">{order_date}. </span></p><p>Bedankt,</p><p>{order_url}</p>',
                    'pl' => '<p>Witaj, </p><p>Drogi {owner_name}.</p><p>To jest potwierdzenie zamówienia {order_id} złożone na <span style=\"font-size: 1rem;\">{order_date}. </span></p><p>Dzięki,</p><p>{order_url}</p>',
                    'ru' => '<p> Здравствуйте, </p> <p> Уважаемый {owner_name}. </p> <p> Это подтверждение заказа {order_id} на <span style = \"font-size: 1rem;\"> {order_date}. </span> </p> <p> Спасибо, </p> <p> {order_url} </p>',
                    'pt' => '<p> Térica-Dicas de Cadeia Pública de Тутутугальский (owner_name}). </p> <p> Тугальстугальстугальский (order_id} ний <span style = \" font-size: 1rem; \ "> {order_date}. </span> </p> <p> nome_do_chave de vida, </p> <p> {order_url} </p> <p> {order_url}',
                    'zh' => '<p>您好，</p><p>尊敬的 {owner_name}。</p><p>这是 " font-size: 1rem;\">{order_date}上的 " 确认订单 " {order_id} 场所。</span></p><p>谢谢，</p><p>{order_url}</p>"',
                    'he' => '<p>שלום, &nbsp;</p><p>היקר {owner_name}.</p><p>זוהי הזמנת אישור {order_id} מקום ב &nbsp; <span style= \" fontsize: 1rem;\"> {order_date}.</span></p><p>תודה,</p><p>{order_url}</p>',
                    'tr' => '<p>Merhaba, &nbsp;</p><p>Sayın {owner_name}.</p><p>Bu, &nbsp; <span style= \" font-size: 1rem; \ "> { order_date }.</span></p><p>Teşekkürler,</p><p>{order_url}</p>üzerinde bulunan Doğrulama Siparişi {order_id } yer',
                    'pt-br' => '<p> Térica-Dicas de Cadeia Pública de Тутутугальский (owner_name}). </p> <p> Тугальстугальстугальский (order_id} ний <span style = \" font-size: 1rem; \ "> {order_date}. </span> </p> <p> nome_do_chave de vida, </p> <p> {order_url} </p> <p> {order_url}',
                ],
            ],

            'Stock Status' => [
                'subject' => 'Stock Detail',
                'lang' => [
                    'ar' => '<p>مرحبا ،</p><p>عزيزي {customer_name}.</p><p>نحن متحمسون لاعلامك بأن المنتج الذي كنت تنتظره الآن قد عاد الى المخزن. لا تفوت هذه الفرصة للحصول على المعلومات الخاصة بك !</p><b>معلومات المنتج :</b><br><p>اسم المنتج : {product_name}</p><br><p>كود المنتج : {product_id}</p><p>شكرا ،</p><p>{app_name}</p>',
                    'da' => '<p>Hej, &nbsp;</p><p>Kære {customer_name}.</p><p>Vi glæder os til at informere dig om, at det produkt, du har ventet på, nu er tilbage på lager. Gå ikke glip af denne mulighed for at få dine hænder på det!</p><b>Produktoplysninger:</b><br><p>Produktnavn: {product_name}</p><br><p>Produkt-id: {product_id}</p><p>Tak,</p><p>{app_name}</p>',
                    'de' => '<p>Hallo, &nbsp;</p><p>Liebe {customer_name}.</p><p>Wir freuen uns darauf, Ihnen mitzuteilen, dass das Produkt, auf das Sie gewartet haben, jetzt wieder auf Lager ist. Verpassen Sie nicht diese Gelegenheit, um Ihre Hände dazu zu erhalten!</p><b>Produktinformationen:</b><br><p>Produktname: {product_name}</p><br><p>Produkt-ID: {product_id}</p><p>Danke,</p><p>{app_name}</p>',
                    'en' => '<p>Hello,&nbsp;</p><p>Dear {customer_name}.</p><p>We are excited to inform you that the product you have been waiting for is now back in stock. Do not miss this opportunity to get your hands on it!</p><b>Product Information:</b><br><p>Product Name: {product_name}</p><br><p>Product Id:  {product_id}</p><p>Thanks,</p><p>{app_name}</p>',
                    'es' => '<p>Hola, &nbsp;</p><p>Estimado {customer_name}.</p><p>Estamos entusiasmados de informarle de que el producto que ha estado esperando está ahora de nuevo en stock. No se pierda esta oportunidad de obtener las manos en él!</p><b>Información del producto:</b><br><p>Nombre del producto: {product_name}</p><br><p>Product Id: {product_id}</p><p>Thanks,</p><p>{app_name}</p>',
                    'fr' => '<p>Bonjour, &nbsp;</p><p>Cher {customer_name}.</p><p>Nous sommes ravis de vous informer que le produit que vous attendez est maintenant de nouveau en stock. Ne manquez pas cette occasion de vous en procurer les mains !</p><b>Informations sur le produit:</b><br><p>Nom du produit: {product_name}</p><br><p>ID produit: {product_id}</p><p>Merci,</p><p>{app_name}</p>',
                    'it' => '<p>Ciao, &nbsp;</p><p>Caro {customer_name}.</p><p>Siamo entusiici di informarti che il prodotto che hai atteso è ora tornato in stock. Non perderti questa opportunità di mettere le mani su!</p><b>Informazioni sul prodotto:</b><br><p>Nome prodotto: {product_name}</p><br><p>Id prodotto: {product_id}</p><p>Grazie,</p><p>{app_name}</p>',
                    'ja' => '<p>Hello,&nbsp;</p><p>Dear {customer_name}.</p><p>お客様が待っていた製品が現在在庫に戻っていることをお知らせすることができます。 この機会を逃してはいけません。</p><b>製品情報:</b><br><p>製品名: {product_name}</p><br><p>製品 ID: {product_id}</p><p>ありがとうございます。</p><p>{app_name}</p>',
                    'nl' => '<p>Hallo, &nbsp;</p><p>Beste {customer_name}.</p><p>We zijn enthousiast om u te informeren dat het product dat u hebt gewacht, nu weer op voorraad is. Mis deze kans niet om uw handen erop te krijgen!</p><b>Productinformatie:</b><br><p>Productnaam: {product_name}</p><br><p>Product-ID: {product_id}</p><p>Bedankt,</p><p>{app_name}</p>',
                    'pl' => '<p>Hello, &nbsp;</p><p>Szanowny {customer_name}.</p><p>Jesteśmy podekscytowani informując, że produkt, na który czekałeś, jest teraz ponownie dostępny na magazynie. Nie przegap tej okazji, aby uzyskać na niej ręce!</p><b>Informacje o produkcie:</b><br><p>Nazwa produktu: {product_name}</p><br><p>Identyfikator produktu: {product_id}</p><p>Dzięki,</p><p>{app_name}</p>',
                    'ru' => '<p>Здравствуйте, &nbsp;</p><p>Уважаемый пользователь {customer_name}.</p><p>Мы рады сообщить вам о том, что продукт, которого вы ждали, сейчас находится на складе. Не упустите эту возможность, чтобы получить от вас руки!</p><b>Информация о продукте:</b><br><p>Имя продукта: {product_name}</p><br><p>Product Id: {product_id}</p><p>Thanks,</p><p>{app_name}</p>',
                    'pt' => '<p>Olá, &nbsp;</p><p>Dear {customer_name}.</p><p>Estamos entusiasmados em informar que o produto que você estava esperando está agora de volta em estoque. Não perca esta oportunidade de ficar com as mãos nele!</p><b>Informações do Produto:</b><br><p>Nome do Produto: {product_name}</p><br><p>Id do produto: {product_id}</p><p>Obrigado,</p><p>{app_name}</p>',

                    'zh' => '<p>您好，</p><p>尊敬的 {customer_name}。</p><p>我们很高兴地通知您，您所等待的产品现在已恢复库存。 请不要错过此商机 !</p><b>产品信息:</b><br><p>产品名称: {product_name}</p><br><p>产品标识: {product_id}</p><p>谢谢，</p><p>{app_name}</p>',
                    'tr' => '<p>Merhaba, &nbsp;</p><p>Sayın {customer_name}.</p><p>Beklediğiniz ürünün şu anda stokta geri dönmekte olduğunu size bildirmekten heyecan duyuyoruz. ellerinizi ona almak için bu fırsatı kaçırmayın!</p><b>ürün bilgileri:</b><br><p>ürün adı: {product_name}</p><br><p>Ürün Tanıtıcısı: {product_id}</p><p>Teşekkürler,</p><p>{app_name}</p>',

                    'pt-br' => '<p>Olá, &nbsp;</p><p>Dear {customer_name}.</p><p>Estamos entusiasmados em informar que o produto que você estava esperando está agora de volta em estoque. Não perca esta oportunidade de ficar com as mãos nele!</p><b>Informações do Produto:</b><br><p>Nome do Produto: {product_name}</p><br><p>Id do produto: {product_id}</p><p>Obrigado,</p><p>{app_name}</p>',
                ],
            ],
            'Abandon Cart' => [
                'subject' => 'Abandon Cart',
                'lang' => [
                    'ar' => '<p>مرحبا&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">مرحبا بك في { app_name }.</span></p><p>لاحظنا أنك قمت مؤخرا بزيارة موقع { app_name } وقمت باضافة بعض البنود الرائعة الى عربة التسوق الخاصة بك. نحن مبتهجون بأنك وجدت منتجات تحبها ومع ذلك ، يبدو أنك لم تنهي عملية الشراء الخاصة بك والانتهاء من طلبك في أقرب وقت ممكن</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">معلومات منتج عربة الرسم :</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ cart_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">شكرا</span></p><p>{ app_name }</p><p><br></p>',
                    'da' => '<p>Hallo?&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Velkommen til { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Vi har bemærket, at du for nylig besøgte vores websted og tilføjede nogle fantastiske varer til indkøbsvognen. Vi er henrykte over, at du fandt produkter, du elsker! Men det ser ud til, at du ikke er færdig med dit køb.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Oplysninger om Cart-produkter:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ cart_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Tak.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name }</span></p><p><br></p>',
                    'de' => '<p>Hallo,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Willkommen bei {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Wir haben bemerkt, dass Sie kürzlich unsere Website {app_name} besucht und einige fantastische Artikel in Ihren Warenkorb gelegt haben. Wir sind begeistert, dass Sie Produkte gefunden haben, die Sie lieben! Allerdings scheint es, als würden Sie Ihre Einkäufe nicht beenden. Sie beenden Ihren Bestellprozess so schnell wie möglich</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Warenkorb Produktinformation:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Danke,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{Anwendungsname}</span></p><p><br></p>',
                    'en' => '<p></p><p></p><p></p><p>Hello,&nbsp;</p><p>Welcome to {app_name}.</p><p><span style="text-align: var(--bs-body-text-align);">We noticed that you recently visited our&nbsp;</span>{app_name}&nbsp;<span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">site and added some fantastic items to your shopping cart. We are thrilled that you found products you love! However, it seems like you did not finish your purchase.</span><span style="text-align: var(--bs-body-text-align);">You finish your order process as soon as possible</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);"><br></span></p><span style="font-weight: 600;">Cart Product Information:</span><p></p><p><span style="font-weight: 600;"><br></span></p><p></p><p></p><p></p><p></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);"><br></span></p><div><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Thanks,</span></p></div><p>{app_name}</p><p><br></p><p></p><p></p><p></p>',
                    'es' => '<p>Hola,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bienvenido a {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Hemos notado que recientemente ha visitado nuestro sitio {app_name} y ha añadido algunos artículos fantásticos a su carrito de la compra. ¡Estamos encantados de que encontraste productos que amas! Sin embargo, parece que usted no terminó su compra. Usted termina su proceso de pedido tan pronto como sea posible</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Información del producto del carro:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Gracias,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',
                    'fr' => '<p>Bonjour,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bienvenue dans { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Nous avons remarqué que vous avez récemment visité notre site { app_name } et ajouté des articles fantastiques à votre panier. Nous sommes ravis que vous avez trouvé des produits que vous aimez ! Cependant, il semble que vous navez pas fini votre achat. Vous terminez votre commande dès que possible</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Cart Renseignements sur le produit:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ Table_cart_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Merci,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ nom_app }</span></p><p><br></p>',
                    'it' => '<p>Ciao,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Benvenuti in {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Abbiamo notato che recentemente hai visitato il nostro sito {app_name} e aggiunto alcuni articoli fantastici al tuo carrello. Siamo entusiasti di aver trovato dei prodotti che ami! Tuttavia, sembra che tu non abbia finito il tuo acquisto, finisci il tuo processo di ordine il prima possibile</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Informazioni sul prodotto del carrello:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Grazie,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',

                    'ja' => '<p>こんにちは。&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}へようこそ。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">最近、弊社の {app_name} サイトを訪問し、お客様のショッピング・カートに素晴らしいアイテムをいくつか追加しました。 あなたが愛する製品を見つけたと私たちはワクワクしている ! しかし、購入を完了していないようですが、できるだけ早く注文処理を完了します。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">カート製品情報:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">ありがとう。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',

                    'nl' => '<p>Hallo,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Welkom bij { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">We hebben gemerkt dat u onlangs onze site { app_name } hebt bezocht en enkele fantastische items aan uw winkelwagen heeft toegevoegd. We zijn blij dat je gevonden producten van je houdt! Echter, het lijkt alsof je niet klaar bent met uw aankoop. U klaar bent met uw bestelling proces zo snel mogelijk</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Productinformatie winkelwagen:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ order_tabel }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bedankt.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name }</span></p><p><br></p>',

                    'pl' => '<p>Witaj,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Witamy w aplikacji {app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Zauważyliśmy, że niedawno odwiedziliście naszą stronę {app_name } i dodaliśmy kilka fantastycznych pozycji do koszyka. Jesteśmy zachwyceni, że znalazłeś produkty, które kochasz! Jednak wydaje się, że nie skończyłaś swój zakup. Zakończ proces zamówienia tak szybko, jak to możliwe</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Informacje o produkcie koszyka:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Dziękuję,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name }</span></p><p><br></p>',

                    'ru' => '<p>Привет.&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Вас приветствует { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Мы заметили, что вы недавно посетили наш сайт { app_name } и добавили несколько фантастических предметов в вашу корзину. Мы в восторге от того, что вы нашли продукты, которые вы любите! Однако, похоже, вы не закончили свою покупку. Вы закончите процесс заказа как можно скорее</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Информация о продукте корзины:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ cart_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Спасибо.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ имя_программы }</span></p><p><br></p>',

                    'pt' => '<p>Olá,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bem-vindo a {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Notamos que você visitou recentemente o nosso site {app_name} e adicionou alguns itens fantásticos ao seu carrinho de compras. Estamos emocionados por você ter encontrado produtos que você ama! No entanto, parece que você não terminou a sua compra, termina o seu processo de encomenda o mais rápido possível</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Informações do Produto do carrinho:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Obrigado,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p>',

                    'zh' => '<p>你好， </p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">欢迎使用 {app_name}。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">我们注意到您最近访问了我们的 {app_name} 站点，并将一些精彩项目添加到购物车。 我们很高兴你找到了爱的产品 但是，你好像没有完成你的购买，你尽快完成你的订单流程</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">购物车产品信息:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">谢谢，</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name}</span></p><div><br></div>',

                    'tr' => '<p>Merhaba.&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name } için hoş geldiniz.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Kısa bir süre önce { app_name } sitemizi ziyaret ettiniz ve alışveriş sepetinize bazı fantastik öğeler eklediğinizi fark ettik. Sevdiğiniz ürünleri bulmanıza sevindik! Ancak, satın alma işleminizi tamamlamamış gibi görünmektedir.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Alışveriş Sepeti Ürün Bilgileri:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ cart_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Teşekkürler.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ uyg_adı }</span></p><p><br></p>',

                    'he' => '<p>שלום,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">ברוכים הבאים אל {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">שמנו לב שלאחרונה ביקרת באתר שלנו ב - {app_name} והוספת כמה פריטים נפלאים לעגלת הקניות שלך. אנחנו שמחים שמצאת מוצרים שאתה אוהב! עם זאת, זה נראה כאילו לא סיימת את הרכישה שלך.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">פרטי מוצר של עגלה:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">תודה,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',

                    'pt-br' => '<p>Olá,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bem-vindo a {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Notamos que você visitou recentemente o nosso site {app_name} e adicionou alguns itens fantásticos ao seu carrinho de compras. Estamos emocionados por você ter encontrado produtos que você ama! No entanto, parece que você não terminou a sua compra, termina o seu processo de encomenda o mais rápido possível</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Informações do Produto do carrinho:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{cart_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Obrigado,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',
                ],
            ],
            'Abandon Wishlist' => [
                'subject' => 'Abandon Wishlist',
                'lang' => [
                    'ar' => '<p>مرحبا&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">مرحبا بك في { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">لاحظنا أنك كنت تقوم بتصفح الموقع الخاص بنا وقمت باضافة بعض البنود المذهلة الى كشف wishlist الخاص بك. بسرعة ، بعض من هذه الأشياء ستباع بسرعة مع المخزون المحدود والطلب العالي ، الآن هو الوقت المثالي لجعل مشتريات حلمك.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">معلومات منتج كشف wishlist :</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ wislist_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">شكرا</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name }</span></p><p><br></p><p><br></p>',
                    'da' => '<p>Hallo?&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Velkommen til { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Vi har lagt mærke til, at du har gennemset vores hjemmeside og har tilføjet nogle fantastiske ting til din ønskeliste. Skynd dig, nogle af disse ting sælger hurtigt, og vi ville hade for dig at gå glip af dem. Med begrænset lager og høj efterspørgsel, er det nu det perfekte tidspunkt til at gøre dine drømme indkøb.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Oplysninger om ønskelisteoplysninger:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ wishlist_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Tak.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name }</span></p><p><br></p><p><br></p>',
                    'de' => '<p>Hallo,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Willkommen bei {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Wir haben bemerkt, dass Sie unsere Website durchstöbern und einige fantastische Artikel zu Ihrer Wunschliste hinzugefügt haben. Beeilen Sie sich, einige dieser Artikel verkaufen sich schnell, und wir würden es hassen, dass Sie sie vermissen. Mit begrenztem Bestand und hoher Nachfrage ist jetzt die perfekte Zeit, um Ihre Traumkäufe zu tätigen.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Wishlist Produktinformation:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_tabelle}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Danke,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{Anwendungsname}</span></p><p><br></p><p><br></p>',

                    'en' => '<p>Hello,&nbsp;</p><p>Welcome to {app_name}.</p><p>We noticed that you have been browsing our site and have added some fantastic items to your wishlist. Hurry, some of these items are selling out fast. With limited stock and high demand, now is the perfect time to make your dream purchases.</p><p></p><p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; font-size: 14px; color: rgb(0, 0, 0); font-family: " open="" sans",="" sans-serif;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" text-decoration-thickness:="" initial;="" text-decoration-style:="" text-decoration-color:="" initial;"=""></p><p></p><p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem;" open="" sans",="" sans-serif;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" text-decoration-thickness:="" initial;="" text-decoration-style:="" text-decoration-color:="" initial;"=""><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);"><b>Wishlist</b></span><span style="font-family: var(--bs-body-font-family); text-align: var(--bs-body-text-align); font-weight: 600;">&nbsp;Product Information:</span></p><p open="" sans",="" sans-serif;="" font-style:="" normal;="" font-variant-ligatures:="" font-variant-caps:="" font-weight:="" 400;="" letter-spacing:="" orphans:="" 2;="" text-align:="" start;="" text-indent:="" 0px;="" text-transform:="" none;="" white-space:="" widows:="" word-spacing:="" -webkit-text-stroke-width:="" text-decoration-thickness:="" initial;="" text-decoration-style:="" text-decoration-color:="" initial;"=""><span style="text-align: var(--bs-body-text-align);">{wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Thanks,</span></p><p>{app_name}</p><p><br></p>',
                    'es' => '<p>Hola,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bienvenido a {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Nos dimos cuenta de que has estado navegando por nuestro sitio y hemos añadido algunos artículos fantásticos a tu lista de deseos. Date prisa, algunos de estos artículos se están vendiendo rápido, y nos gustaría que te pierdas de ellos. Con un stock limitado y una alta demanda, ahora es el momento perfecto para hacer sus compras de ensueño.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Información del producto de lista de deseos:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Gracias,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p><p><br></p>',
                    'fr' => '<p>Bonjour,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bienvenue dans { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Nous avons remarqué que vous naviguez sur notre site et que vous avez ajouté des objets fantastiques à votre liste de cadeaux. Dépêchez, certains de ces objets se vendent vite, et nous vous haïrions de les manquer. Avec un stock limité et une forte demande, cest le moment idéal pour faire vos achats de rêve.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Wishlist Renseignements sur le produit:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ table_wishliste_wishs }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Merci,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ nom_app }</span></p><p><br></p><p><br></p><p><br></p>',

                    'it' => '<p>Ciao,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Benvenuti in {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Abbiamo notato che hai sfogliato il nostro sito e che hai aggiunto alcuni articoli fantastici alla tua wishlist. Svelto, alcuni di questi articoli si vendono in fretta, e odieremmo per farvi mancare su di loro. Con stock limitati e ad alta richiesta, ora è il momento perfetto per fare i tuoi acquisti da sogno.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist Informazioni sul prodotto:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Grazie,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p><p><br></p><p><br></p>',

                    'ja' => '<p>こんにちは。&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}へようこそ。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">私たちは、あなたが私たちのサイトを閲覧していることに気付き、あなたの wishlistに素晴らしいアイテムを追加している 急いでこれらのアイテムの一部は売り切れですし、あなたが彼らを見逃すのを嫌っています 株式と需要が限られていることから、今は理想的な夢の購入に最適です。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist 製品情報:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">ありがとう。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p><p><br></p><p><br></p>',

                    'nl' => '<p>Hallo,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Welkom bij { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">We hebben gemerkt dat u surfen op onze site en hebben enkele fantastische items toegevoegd aan uw wishlist. Snel, sommige van deze items verkopen snel. Met beperkte voorraad en hoge vraag, is nu de perfecte tijd om uw droom aankopen te maken.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist Productinformatie:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ wishlist_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bedankt.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name }</span></p><p><br></p><p><br></p>',

                    'pl' => '<p>Witaj,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Witamy w aplikacji {app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Zauważyliśmy, że przeglądałeś naszą stronę i dodaliśmy kilka fantastycznych przedmiotów do Twojej wiszliwi. Pospiesz się, niektóre z tych rzeczy sprzedają się szybko. Dzięki ograniczonym zapasom i wysokim popytem, teraz jest idealny czas na to, aby Twoje marzenie zakupów.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist Informacje o produkcie:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Dziękuję,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name }</span></p><p><br></p><p><br></p>',

                    'ru' => '<p>Привет.&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Вас приветствует { app_name }.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Мы заметили, что вы просматриваете наш сайт и добавили в ваш список некоторые фантастические предметы. Поторопись, некоторые из этих предметов быстро продаются. С ограниченным западом и высоким спросом, сейчас идеальное время для того, чтобы совершить покупку мечты.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Информация о продукте wishlist:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ wishlist_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Спасибо.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ имя_программы }</span></p><p><br></p>',

                    'pt' => '<p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Olá, </span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bem-vindo a {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Notamos que você tem navegado no nosso site e adicionamos alguns itens fantásticos à sua wishlist. Com pressa, alguns desses itens estão vendendo rápido. Com estoque limitado e alta demanda, agora é o momento perfeito para fazer as suas compras de sonho.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist Produto Informações:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Obrigado,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',

                    'zh' => '<p>你好，&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">欢迎使用 {app_name}。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">我们注意到您一直在浏览我们的站点，并已将一些精彩项目添加到您的 wishlist中。 快点这些物品有些卖得很快 拥有有限的股票和高需求，现在是实现梦想购买的完美时机。</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist 产品信息:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">谢谢，</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name}</span></p><p><br></p><div><br></div>',

                    'tr' => '<p>Merhaba. </p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ app_name } için hoş geldiniz.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">sitemize göz attığınız ve wishlist e bazı fantastik öğeler eklediğinizi fark ettik. Acele edin, bu maddelerden bazıları hızlı satıyorlar. sınırlı hisse senedi ve yüksek talep ile artık hayalinizdeki satın alımlarınızı yapmak için mükemmel bir zaman.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist Ürün Bilgileri:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ wishlist_table }</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Teşekkürler.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{ uyg_adı }</span></p><p><br></p>',

                    'he' => '<p>שלום,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">ברוכים הבאים אל {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">שמנו לב כי אתה כבר עיון באתר שלנו ויש הוסיף כמה פריטים נפלאים לרשימת המשאלות שלך. מהר, חלק מהפריטים האלה נמכרים מהר. עם מלאי מוגבל וביקוש גבוה, עכשיו זה הזמן המושלם לעשות רכישות החלום שלך.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">פרטי מוצר ברשימת wishlist:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">תודה,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',

                    'pt-br' => '<p>Olá,&nbsp;</p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Bem-vindo a {app_name}.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Notamos que você tem navegado no nosso site e adicionamos alguns itens fantásticos à sua wishlist. Com pressa, alguns desses itens estão vendendo rápido. Com estoque limitado e alta demanda, agora é o momento perfeito para fazer as suas compras de sonho.</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">wishlist Produto Informações:</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{wishlist_table}</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">Obrigado,</span></p><p><span style="font-family: var(--bs-body-font-family); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">{app_name}</span></p><p><br></p>',
                ],
            ],
        ];

        $email = EmailTemplate::all();

        foreach ($email as $e) {
            foreach ($defaultTemplate[$e->name]['lang'] as $lang => $content)
            {
                $emailNoti = EmailTemplateLang::where('parent_id', $e->id)->where('lang', $lang)->count();
                if($emailNoti==0)
                {
                    EmailTemplateLang::create(
                        [
                            'parent_id' => $e->id,
                            'lang' => $lang,
                            'subject' => $defaultTemplate[$e->name]['subject'],
                            'content' => $content,
                        ]
                    );
                }
            }
        }
    }

    //For whatsapp notification meassage
    public static function WhatsappMeassage($company_id, $store_id = '', $theme_id = '' )
    {
        $whatsappMessage = [
            'Order Created',
            'Status Change',
            'Stock Status',
            'Abandon Cart',
            'Abandon Wishlist',
        ];

        foreach ($whatsappMessage as $wMess)
        {
            if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
                $user = Admin::find($company_id);
                $store = Store::where('id', $user->current_store)->first();
                $theme = Admin::$defalut_theme;
                foreach ($theme as $key => $value) {
                    WhatsappMessage::create(
                    [
                        'name' => $wMess,
                        'from' => env('APP_NAME'),
                        'user_id' => $company_id,
                        'is_active' => 0,
                        'theme_id' => $value,
                        'store_id' => $store->id,
                        'created_by' => $company_id,
                    ]
                );
            }
            }else{
            if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                $user = Admin::find($company_id);
                $store = Store::find($store_id);
                $data = WhatsappMessage::where('user_id',$company_id)->where('theme_id',$theme_id)->where('store_id',$store_id)->get();
                // dd(count($data));
                if(count($data) < 5)
                {
                    WhatsappMessage::create(
                        [
                            'name' => $wMess,
                            'from' => env('APP_NAME'),
                            'user_id' => $company_id,
                            'is_active' => 0,
                            'theme_id' => $theme_id,
                            'store_id' => $store_id,
                            'created_by' => $company_id,
                        ]
                    );
                }

            }
        }
     }

    }


    public static function ProductAttribute($p_variant)
    {
        $variant = json_decode($p_variant);
        $p_variant = ProductAttribute::find($variant);
        return $p_variant;
    }

    public static function send_twilio_msg($to, $msg, $settings)
    {
        try {
            $account_sid = $settings['twilio_sid'];

            $auth_token = $settings['twilio_token'];

            $twilio_number = $settings['twilio_from'];
            $client = new Client($account_sid, $auth_token);

            $client->messages->create($to, [
                'from' => $twilio_number,
                'body' => $msg
            ]);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public static function low_stock_threshold($product, $theme_id, $settings)
    {
        $products = Product::find($product->product_id);
        $product = !empty($product) ? $product : $products;
        try {
            $msg = __("Hello,") . "\n\n" .
                __("Dear") . ",\n" .
                __("Low Stock Alert: The stock of ") . $product->name . __(" is below the specified threshold. Current Stock: ") . $product->product_stock . __(', Low Stock Threshold: ') . $product->low_stock_threshold . ".\n\n" .
                __("Thanks,");
            Utility::send_twilio_msg($settings['twilio_notification_number'], $msg, $settings);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public static function variant_low_stock_threshold($product, $ProductStock, $theme_id, $settings)
    {
        $products = Product::find($product->product_id);
        $product = !empty($product) ? $product : $products;
        try {
            $msg = __("Hello,") . "\n\n" .
                __("Dear") . ",\n" .
                __("Low Stock Alert: The stock of ") . $product->name . "(" . $ProductStock->variant . ")" . __(" is below the specified threshold. Current Stock: ") . $ProductStock->stock . __(', Low Stock Threshold: ') . $ProductStock->low_stock_threshold . ".\n\n" .
                __("Thanks,");

            Utility::send_twilio_msg($settings['twilio_notification_number'], $msg, $settings);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public static function out_of_stock($product, $theme_id, $settings)
    {
        $products = Product::find($product->product_id);
        $product = !empty($product) ? $product : $products;
        try {
            $msg = __("Hello,") . "\n\n" .
                __("Dear") . ",\n" .
                __("Out of Stock Alert: The stock of ") . $product->name . __(" is below the specified stock. Current Stock: ") . $product->product_stock . ".\n\n" .
                __("Thanks,");

            Utility::send_twilio_msg($settings['twilio_notification_number'], $msg, $settings);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public static function variant_out_of_stock($product, $ProductStock, $theme_id, $settings)
    {
        $products = Product::find($product->product_id);
        $product = !empty($product) ? $product : $products;
        try {
            $msg = __("Hello,") . "\n\n" .
                __("Dear") . ",\n" .
                __("Out of Stock Alert: The stock of ") . $product->name . "(" . $ProductStock->variant . ")" . __(" is below the specified stock. Current Stock: ") . $ProductStock->stock . ".\n\n" .
                __("Thanks,");

            Utility::send_twilio_msg($settings['twilio_notification_number'], $msg, $settings);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public static function addNewData()
    {
        \Artisan::call('cache:forget spatie.permission.cache');
        \Artisan::call('cache:clear');
        $usr = \Auth::user();

        $arrPermissions = [
            'Manage Order Reports',
            'Manage Stock Reports',
            'Abandon Wishlist',
            'Abandon Cart',
            'Manage Cart',
            'Show Cart',
            'Delete Cart',
            'Manage Shopify Category',
            'Create Shopify Category',
            'Edit Shopify Category',
            'Manage Shopify Product',
            'Create Shopify Product',
            'Edit Shopify Product',
            'Manage Shopify Customer',
            'Create Shopify Customer',
            'Edit Shopify Customer',
            'Manage Shopify Coupon',
            'Create Shopify Coupon',
            'Edit Shopify Coupon',
            'Manage Refund Request',
            'Manage Flashsale',
            'Create Flashsale',
            'Delete Flashsale',
            'Edit Flashsale',
            'Manage Order Note',
            'Create Order Note',
            'Delete Order Note',
            'Manage DeliveryBoy',
            'Create DeliveryBoy',
            'Edit DeliveryBoy',
            'Delete DeliveryBoy',
            

        ];
        foreach ($arrPermissions as $ap) {
            // check if permission is not created then create it.
            $permission = Permission::where('name', 'LIKE', $ap)->first();
            if (empty($permission)) {
                Permission::create(['name' => $ap, 'guard_name' => 'web']);
            }
        }
        $companyRole = Role::where('name', 'LIKE', 'admin')->first();

        $companyPermissions   = $companyRole->getPermissionNames()->toArray();
        $companyNewPermission = [
            'Manage Order Reports',
            'Manage Stock Reports',
            'Abandon Wishlist',
            'Abandon Cart',
            'Manage Cart',
            'Show Cart',
            'Delete Cart',
            'Manage Shopify Category',
            'Create Shopify Category',
            'Edit Shopify Category',
            'Manage Shopify Product',
            'Create Shopify Product',
            'Edit Shopify Product',
            'Manage Shopify Customer',
            'Create Shopify Customer',
            'Edit Shopify Customer',
            'Manage Shopify Coupon',
            'Create Shopify Coupon',
            'Edit Shopify Coupon',
            'Manage Refund Request',
            'Manage Flashsale',
            'Create Flashsale',
            'Delete Flashsale',
            'Edit Flashsale',
            'Manage Order Note',
            'Create Order Note',
            'Delete Order Note',
            'Manage DeliveryBoy',
            'Create DeliveryBoy',
            'Edit DeliveryBoy',
            'Delete DeliveryBoy',
        ];
        foreach ($companyNewPermission as $op) {
            // check if permission is not assign to owner then assign.
            if (!in_array($op, $companyPermissions)) {
                $permission = Permission::findByName($op, 'web');
                $companyRole->givePermissionTo($permission);
            }
        }
    }

    public static function orderRefundSetting($company_id, $store_id = '', $theme_id = '')
    {
        $OrderRefund = [
            'Manage Stock',
            'Attachment',
            'Shipment amount deduct during',
        ];
        foreach ($OrderRefund as $Refund) {
            if (!empty($company_id) && ($store_id == '' || $theme_id == '')) {
                $user = Admin::find($company_id);
                $store = Store::where('id', $user->current_store)->first();
                $theme = Admin::$defalut_theme;
                foreach ($theme as $key => $value) {
                    OrderRefundSetting::create(
                        [
                            'name' => $Refund,
                            'user_id' => $company_id,
                            'is_active' => 0,
                            'theme_id' => $value,
                            'store_id' => $store->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            } else {
                if (!empty($company_id) && !empty($store_id) && !empty($theme_id)) {
                    $user = Admin::find($company_id);
                    $store = Store::find($store_id);
                    OrderRefundSetting::create(
                        [
                            'name' => $Refund,
                            'user_id' => $company_id,
                            'is_active' => 0,
                            'theme_id' => $theme_id,
                            'store_id' => $store_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }


     // send whatsapp message
    public static function SendMsgs($template ,$mobile_no , $msg = '')
    {
        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();

        $whatstemplate = WhatsappMessage::where('name', 'LIKE', $template)->where('theme_id',$theme_name)->where('store_id',getCurrentStore())->first();
        $whatsapp_phone_number_id =\App\Models\Utility::GetValueByName('whatsapp_phone_number_id',$theme_name);
        $whatsapp_access_token =\App\Models\Utility::GetValueByName('whatsapp_access_token',$theme_name);
        if ((!empty($whatsapp_phone_number_id)) && (!empty($whatsapp_access_token)) && ($whatstemplate->is_active == 1))
        {

            try
            {

                $url = 'https://graph.facebook.com/v17.0/'.$whatsapp_phone_number_id.'/messages';

                $data = array(
                    'messaging_product' => 'whatsapp',
                    // 'recipient_type' => 'individual',
                    'to' => $mobile_no,
                    'type' => 'text',
                    'text' => array(
                        'preview_url' => false,
                        'body' => $msg
                    )
                );
                $headers = array(
                    'Authorization: Bearer '.$whatsapp_access_token,
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

            }
            catch(\Exception $e)
            {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    public static function webhook($module, $store_id)
    {
        // dd($module, $store_id);
        $webhook = Webhook::where('module',$module)->where('store_id', '=', $store_id)->first();
        if(!empty($webhook)){
            $url = $webhook->url;
            $method = $webhook->method;
            $reference_url  = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $data['method'] = $method;
            $data['reference_url'] = $reference_url;
            $data['url'] = $url;

            return $data;
        }
        return false;

    }

    public static function WebhookCall($url = null,$parameter = null , $method = '')
    {
        if(!empty($url) && !empty($parameter))
        {
            try {
                $curlHandle = curl_init($url);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $parameter);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, $method);
                $curlResponse = curl_exec($curlHandle);
                curl_close($curlHandle);
                if(empty($curlResponse))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            catch (\Throwable $th)
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public static function paymentWebhook($order)
    {
        $module = 'New Order';
        $store = Store::find(getCurrentStore());
        $webhook =  Utility::webhook($module, $store->id);
        if ($webhook) {
            $parameter = json_encode($order);

            // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
            $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
            if ($status != true) {
                $msg  = 'Webhook call failed.';

            }
        }
    }
}
