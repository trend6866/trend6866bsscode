@php
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
    $profile = asset(Storage::url('uploads/logo/'));

    $date_format = \App\Models\Utility::GetValueByName('date_format', $theme_name);
    $EmailTemplates = App\Models\EmailTemplate::all();
    $WhatsappNotification = App\Models\WhatsappMessage::where('theme_id', $theme_name)
        ->where('store_id', getCurrentStore())
        ->get();
    /* loyality program */
    $reward_point = \App\Models\Utility::GetValueByName('reward_point', $theme_name);
    $loyality_program_enabled = \App\Models\Utility::GetValueByName('loyality_program_enabled', $theme_name);
    $loyality_program_enabled = empty($loyality_program_enabled) || $loyality_program_enabled == 'on' ? 1 : 0;

    /* Firbase setting */
    $fcm_Key = \App\Models\Utility::GetValueByName('fcm_Key', $theme_name);
    $firebase_enabled = \App\Models\Utility::GetValueByName('firebase_enabled', $theme_name);
    $firebase_enabled = empty($firebase_enabled) || $firebase_enabled == 'on' ? 1 : 0;

    /* payment setting */
    $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_name);
    $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_name);

    $is_cod_enabled = \App\Models\Utility::GetValueByName('is_cod_enabled', $theme_name);
    $is_cod_enabled = $is_cod_enabled == 'on' ? 1 : 0;
    $cod_info = \App\Models\Utility::GetValueByName('cod_info', $theme_name);
    $cod_image = \App\Models\Utility::GetValueByName('cod_image', $theme_name);

    $is_bank_transfer_enabled = \App\Models\Utility::GetValueByName('is_bank_transfer_enabled', $theme_name);
    $is_bank_transfer_enabled = $is_bank_transfer_enabled == 'on' ? 1 : 0;
    $bank_transfer_image = \App\Models\Utility::GetValueByName('bank_transfer_image', $theme_name);
    $bank_transfer_info = \App\Models\Utility::GetValueByName('bank_transfer', $theme_name);

    $is_Stripe_enabled = \App\Models\Utility::GetValueByName('is_stripe_enabled', $theme_name);
    $is_Stripe_enabled = $is_Stripe_enabled == 'on' ? 1 : 0;
    $stripe_unfo = \App\Models\Utility::GetValueByName('stripe_unfo', $theme_name);

    $publishable_key = \App\Models\Utility::GetValueByName('publishable_key', $theme_name);
    $stripe_secret = \App\Models\Utility::GetValueByName('stripe_secret', $theme_name);
    $Stripe_image = \App\Models\Utility::GetValueByName('stripe_image', $theme_name);

    // Paystack
    $is_paystack_enabled = \App\Models\Utility::GetValueByName('is_paystack_enabled', $theme_name);
    $is_paystack_enabled = $is_paystack_enabled == 'on' ? 1 : 0;
    $paystack_unfo = \App\Models\Utility::GetValueByName('paystack_unfo', $theme_name);

    $paystack_public_key = \App\Models\Utility::GetValueByName('paystack_public_key', $theme_name);
    $paystack_secret = \App\Models\Utility::GetValueByName('paystack_secret', $theme_name);
    $paystack_image = \App\Models\Utility::GetValueByName('paystack_image', $theme_name);

    // Razorpay
    $is_razorpay_enabled = \App\Models\Utility::GetValueByName('is_razorpay_enabled', $theme_name);
    $is_razorpay_enabled = $is_razorpay_enabled == 'on' ? 1 : 0;
    $razorpay_unfo = \App\Models\Utility::GetValueByName('razorpay_unfo', $theme_name);

    $razorpay_public_key = \App\Models\Utility::GetValueByName('razorpay_public_key', $theme_name);
    $razorpay_secret_key = \App\Models\Utility::GetValueByName('razorpay_secret_key', $theme_name);
    $razorpay_image = \App\Models\Utility::GetValueByName('razorpay_image', $theme_name);

    // Mercado Page
    $is_mercado_enabled = \App\Models\Utility::GetValueByName('is_mercado_enabled', $theme_name);
    $is_mercado_enabled = $is_mercado_enabled == 'on' ? 1 : 0;
    $mercado_unfo = \App\Models\Utility::GetValueByName('mercado_unfo', $theme_name);

    $mercado_mode = \App\Models\Utility::GetValueByName('mercado_mode', $theme_name);
    $mercado_access_token = \App\Models\Utility::GetValueByName('mercado_access_token', $theme_name);
    $mercado_image = \App\Models\Utility::GetValueByName('mercado_image', $theme_name);

    // Skrill
    $is_skrill_enabled = \App\Models\Utility::GetValueByName('is_skrill_enabled', $theme_name);
    $is_skrill_enabled = $is_skrill_enabled == 'on' ? 1 : 0;
    $skrill_unfo = \App\Models\Utility::GetValueByName('skrill_unfo', $theme_name);

    $skrill_email = \App\Models\Utility::GetValueByName('skrill_email', $theme_name);
    $skrill_image = \App\Models\Utility::GetValueByName('skrill_image', $theme_name);

    // PaymentWall
    $is_paymentwall_enabled = \App\Models\Utility::GetValueByName('is_paymentwall_enabled', $theme_name);
    $is_paymentwall_enabled = $is_paymentwall_enabled == 'on' ? 1 : 0;
    $paymentwall_unfo = \App\Models\Utility::GetValueByName('paymentwall_unfo', $theme_name);

    $paymentwall_public_key = \App\Models\Utility::GetValueByName('paymentwall_public_key', $theme_name);
    $paymentwall_private_key = \App\Models\Utility::GetValueByName('paymentwall_private_key', $theme_name);
    $paymentwall_image = \App\Models\Utility::GetValueByName('paymentwall_image', $theme_name);

    //paypal
    $is_Paypal_enabled = \App\Models\Utility::GetValueByName('is_paypal_enabled', $theme_name);
    $is_Paypal_enabled = $is_Paypal_enabled == 'on' ? 1 : 0;
    $paypal_unfo = \App\Models\Utility::GetValueByName('paypal_unfo', $theme_name);
    $paypal_client_id = \App\Models\Utility::GetValueByName('paypal_client_id', $theme_name);
    $paypal_secret = \App\Models\Utility::GetValueByName('paypal_secret', $theme_name);
    $paypal_image = \App\Models\Utility::GetValueByName('paypal_image', $theme_name);
    $paypal_mode = \App\Models\Utility::GetValueByName('paypal_mode', $theme_name);
    //flutterwave
    $is_flutterwave_enabled = \App\Models\Utility::GetValueByName('is_flutterwave_enabled', $theme_name);
    $is_flutterwave_enabled = $is_flutterwave_enabled == 'on' ? 1 : 0;
    $flutterwave_unfo = \App\Models\Utility::GetValueByName('flutterwave_unfo', $theme_name);
    $public_key = \App\Models\Utility::GetValueByName('public_key', $theme_name);
    $flutterwave_secret = \App\Models\Utility::GetValueByName('flutterwave_secret', $theme_name);
    $flutterwave_image = \App\Models\Utility::GetValueByName('flutterwave_image', $theme_name);
    //paytm
    $is_paytm_enabled = \App\Models\Utility::GetValueByName('is_paytm_enabled', $theme_name);
    $is_paytm_enabled = $is_paytm_enabled == 'on' ? 1 : 0;
    $paytm_unfo = \App\Models\Utility::GetValueByName('paytm_unfo', $theme_name);
    $paytm_merchant_id = \App\Models\Utility::GetValueByName('paytm_merchant_id', $theme_name);
    $paytm_industry_type = \App\Models\Utility::GetValueByName('paytm_industry_type', $theme_name);
    $paytm_merchant_key = \App\Models\Utility::GetValueByName('paytm_merchant_key', $theme_name);
    $paytm_image = \App\Models\Utility::GetValueByName('paytm_image', $theme_name);
    $paypm_mode = \App\Models\Utility::GetValueByName('paypm_mode', $theme_name);
    //mollie
    $is_mollie_enabled = \App\Models\Utility::GetValueByName('is_mollie_enabled', $theme_name);
    $is_mollie_enabled = $is_mollie_enabled == 'on' ? 1 : 0;
    $mollie_unfo = \App\Models\Utility::GetValueByName('mollie_unfo', $theme_name);
    $mollie_api_key = \App\Models\Utility::GetValueByName('mollie_api_key', $theme_name);
    $mollie_profile_id = \App\Models\Utility::GetValueByName('mollie_profile_id', $theme_name);
    $mollie_partner_id = \App\Models\Utility::GetValueByName('mollie_partner_id', $theme_name);
    $mollie_image = \App\Models\Utility::GetValueByName('mollie_image', $theme_name);
    //coingate
    $is_coingate_enabled = \App\Models\Utility::GetValueByName('is_coingate_enabled', $theme_name);
    $is_coingate_enabled = $is_coingate_enabled == 'on' ? 1 : 0;
    $coingate_unfo = \App\Models\Utility::GetValueByName('coingate_unfo', $theme_name);
    $coingate_auth_token = \App\Models\Utility::GetValueByName('coingate_auth_token', $theme_name);
    $coingate_image = \App\Models\Utility::GetValueByName('coingate_image', $theme_name);
    $coingate_mode = \App\Models\Utility::GetValueByName('coingate_mode', $theme_name);

    //sspay
    $is_sspay_enabled = \App\Models\Utility::GetValueByName('is_sspay_enabled', $theme_name);
    $is_sspay_enabled = $is_sspay_enabled == 'on' ? 1 : 0;
    $sspay_unfo = \App\Models\Utility::GetValueByName('sspay_unfo', $theme_name);
    $sspay_category_code = \App\Models\Utility::GetValueByName('sspay_category_code', $theme_name);
    $sspay_secret_key = \App\Models\Utility::GetValueByName('sspay_secret_key', $theme_name);
    $sspay_image = \App\Models\Utility::GetValueByName('sspay_image', $theme_name);
    $sspay_mode = \App\Models\Utility::GetValueByName('sspay_mode', $theme_name);

    //toyyibpay
    $is_toyyibpay_enabled = \App\Models\Utility::GetValueByName('is_toyyibpay_enabled', $theme_name);
    $is_toyyibpay_enabled = $is_toyyibpay_enabled == 'on' ? 1 : 0;
    $toyyibpay_unfo = \App\Models\Utility::GetValueByName('toyyibpay_unfo', $theme_name);
    $toyyibpay_category_code = \App\Models\Utility::GetValueByName('toyyibpay_category_code', $theme_name);
    $toyyibpay_secret_key = \App\Models\Utility::GetValueByName('toyyibpay_secret_key', $theme_name);
    $toyyibpay_image = \App\Models\Utility::GetValueByName('toyyibpay_image', $theme_name);
    $toyyibpay_mode = \App\Models\Utility::GetValueByName('toyyibpay_mode', $theme_name);

    //paytabs
    $is_paytabs_enabled = \App\Models\Utility::GetValueByName('is_paytabs_enabled', $theme_name);
    $is_paytabs_enabled = $is_paytabs_enabled == 'on' ? 1 : 0;
    $paytabs_profile_id = \App\Models\Utility::GetValueByName('paytabs_profile_id', $theme_name);
    $paytabs_image = \App\Models\Utility::GetValueByName('paytabs_image', $theme_name);
    $paytabs_server_key = \App\Models\Utility::GetValueByName('paytabs_server_key', $theme_name);
    $paytabs_region = \App\Models\Utility::GetValueByName('paytabs_region', $theme_name);
    $paytabs_unfo = \App\Models\Utility::GetValueByName('paytabs_unfo', $theme_name);

    // Iyzipay
    $is_iyzipay_enabled = \App\Models\Utility::GetValueByName('is_iyzipay_enabled', $theme_name);
    $is_iyzipay_enabled = $is_iyzipay_enabled == 'on' ? 1 : 0;
    $iyzipay_unfo = \App\Models\Utility::GetValueByName('iyzipay_unfo', $theme_name);

    $iyzipay_mode = \App\Models\Utility::GetValueByName('iyzipay_mode', $theme_name);
    $iyzipay_secret_key = \App\Models\Utility::GetValueByName('iyzipay_secret_key', $theme_name);
    $iyzipay_private_key = \App\Models\Utility::GetValueByName('iyzipay_private_key', $theme_name);
    $iyzipay_image = \App\Models\Utility::GetValueByName('iyzipay_image', $theme_name);
    //PayFast
    $is_payfast_enabled = \App\Models\Utility::GetValueByName('is_payfast_enabled', $theme_name);
    $is_payfast_enabled = $is_payfast_enabled == 'on' ? 1 : 0;
    $payfast_unfo = \App\Models\Utility::GetValueByName('payfast_unfo', $theme_name);
    $payfast_merchant_id = \App\Models\Utility::GetValueByName('payfast_merchant_id', $theme_name);
    $payfast_salt_passphrase = \App\Models\Utility::GetValueByName('payfast_salt_passphrase', $theme_name);
    $payfast_merchant_key = \App\Models\Utility::GetValueByName('payfast_merchant_key', $theme_name);
    $payfast_image = \App\Models\Utility::GetValueByName('payfast_image', $theme_name);
    $payfast_mode = \App\Models\Utility::GetValueByName('payfast_mode', $theme_name);

    // Benefit
    $is_benefit_enabled = \App\Models\Utility::GetValueByName('is_benefit_enabled', $theme_name);
    $is_benefit_enabled = $is_benefit_enabled == 'on' ? 1 : 0;
    $benefit_unfo = \App\Models\Utility::GetValueByName('benefit_unfo', $theme_name);

    $benefit_secret_key = \App\Models\Utility::GetValueByName('benefit_secret_key', $theme_name);
    $benefit_private_key = \App\Models\Utility::GetValueByName('benefit_private_key', $theme_name);
    $benefit_image = \App\Models\Utility::GetValueByName('benefit_image', $theme_name);

    // Cashfree
    $is_cashfree_enabled = \App\Models\Utility::GetValueByName('is_cashfree_enabled', $theme_name);
    $is_cashfree_enabled = $is_cashfree_enabled == 'on' ? 1 : 0;
    $cashfree_unfo = \App\Models\Utility::GetValueByName('cashfree_unfo', $theme_name);

    $cashfree_secret_key = \App\Models\Utility::GetValueByName('cashfree_secret_key', $theme_name);
    $cashfree_key = \App\Models\Utility::GetValueByName('cashfree_key', $theme_name);
    $cashfree_image = \App\Models\Utility::GetValueByName('cashfree_image', $theme_name);

    // Aamarpay
    $is_aamarpay_enabled = \App\Models\Utility::GetValueByName('is_aamarpay_enabled', $theme_name);
    $is_aamarpay_enabled = $is_aamarpay_enabled == 'on' ? 1 : 0;
    $aamarpay_unfo = \App\Models\Utility::GetValueByName('aamarpay_unfo', $theme_name);

    $aamarpay_signature_key = \App\Models\Utility::GetValueByName('aamarpay_signature_key', $theme_name);
    $aamarpay_description = \App\Models\Utility::GetValueByName('aamarpay_description', $theme_name);
    $aamarpay_store_id = \App\Models\Utility::GetValueByName('aamarpay_store_id', $theme_name);
    $aamarpay_image = \App\Models\Utility::GetValueByName('aamarpay_image', $theme_name);

    // Telegram
    $is_telegram_enabled = \App\Models\Utility::GetValueByName('is_telegram_enabled', $theme_name);
    $is_telegram_enabled = $is_telegram_enabled == 'on' ? 1 : 0;
    $telegram_unfo = \App\Models\Utility::GetValueByName('telegram_unfo', $theme_name);

    $telegram_access_token = \App\Models\Utility::GetValueByName('telegram_access_token', $theme_name);
    $telegram_chat_id = \App\Models\Utility::GetValueByName('telegram_chat_id', $theme_name);
    $telegram_image = \App\Models\Utility::GetValueByName('telegram_image', $theme_name);

    // Whatsapp
    $is_whatsapp_enabled = \App\Models\Utility::GetValueByName('is_whatsapp_enabled', $theme_name);
    $is_whatsapp_enabled = $is_whatsapp_enabled == 'on' ? 1 : 0;
    $whatsapp_unfo = \App\Models\Utility::GetValueByName('whatsapp_unfo', $theme_name);

    $whatsapp_number = \App\Models\Utility::GetValueByName('whatsapp_number', $theme_name);
    $whatsapp_image = \App\Models\Utility::GetValueByName('whatsapp_image', $theme_name);
    // Pay TR
    $is_paytr_enabled = \App\Models\Utility::GetValueByName('is_paytr_enabled', $theme_name);
    $is_paytr_enabled = $is_paytr_enabled == 'on' ? 1 : 0;
    $paytr_unfo = \App\Models\Utility::GetValueByName('paytr_unfo', $theme_name);

    $paytr_merchant_id = \App\Models\Utility::GetValueByName('paytr_merchant_id', $theme_name);
    $paytr_merchant_key = \App\Models\Utility::GetValueByName('paytr_merchant_key', $theme_name);
    $paytr_salt_key = \App\Models\Utility::GetValueByName('paytr_salt_key', $theme_name);
    $paytr_image = \App\Models\Utility::GetValueByName('paytr_image', $theme_name);

    // Yookassa
    $is_yookassa_enabled = \App\Models\Utility::GetValueByName('is_yookassa_enabled', $theme_name);
    $is_yookassa_enabled = $is_yookassa_enabled == 'on' ? 1 : 0;
    $yookassa_unfo = \App\Models\Utility::GetValueByName('yookassa_unfo', $theme_name);

    $yookassa_shop_id_key = \App\Models\Utility::GetValueByName('yookassa_shop_id_key', $theme_name);
    $yookassa_secret_key = \App\Models\Utility::GetValueByName('yookassa_secret_key', $theme_name);
    $yookassa_image = \App\Models\Utility::GetValueByName('yookassa_image', $theme_name);

    // Midtrans
    $is_midtrans_enabled = \App\Models\Utility::GetValueByName('is_midtrans_enabled', $theme_name);
    $is_midtrans_enabled = $is_midtrans_enabled == 'on' ? 1 : 0;
    $midtrans_unfo = \App\Models\Utility::GetValueByName('midtrans_unfo', $theme_name);

    // $midtrans_shop_id_key = \App\Models\Utility::GetValueByName('midtrans_shop_id_key', $theme_name);
    $midtrans_secret_key = \App\Models\Utility::GetValueByName('midtrans_secret_key', $theme_name);
    $midtrans_image = \App\Models\Utility::GetValueByName('midtrans_image', $theme_name);
    // Xendit
    $is_Xendit_enabled = \App\Models\Utility::GetValueByName('is_Xendit_enabled', $theme_name);
    $is_Xendit_enabled = $is_Xendit_enabled == 'on' ? 1 : 0;
    $Xendit_unfo = \App\Models\Utility::GetValueByName('Xendit_unfo', $theme_name);

    $Xendit_api_key = \App\Models\Utility::GetValueByName('Xendit_api_key', $theme_name);
    $Xendit_token_key = \App\Models\Utility::GetValueByName('Xendit_token_key', $theme_name);
    $Xendit_image = \App\Models\Utility::GetValueByName('Xendit_image', $theme_name);

    // Brand setting
    $logo_dark = \App\Models\Utility::GetValueByName('logo_dark', $theme_name);
    $logo_dark = get_file($logo_dark, APP_THEME());

    $logo_light = \App\Models\Utility::GetValueByName('logo_light', $theme_name);
    $logo_light = get_file($logo_light, APP_THEME());

    $favicon = \App\Models\Utility::GetValueByName('favicon', $theme_name);
    $favicon = get_file($favicon, APP_THEME());

    $theme_logo = \App\Models\Utility::GetValueByName('theme_logo', $theme_name);
    $theme_logo = get_file($theme_logo, APP_THEME());

    $invoice_logo = \App\Models\Utility::GetValueByName('invoice_logo', $theme_name);
    $invoice_logo = get_file($invoice_logo, APP_THEME());

    $theme_favicon = \App\Models\Utility::GetValueByName('theme_favicon', $theme_name);
    $theme_favicon = get_file($theme_favicon, APP_THEME());

    $SITE_RTL = \App\Models\Utility::GetValueByName('SITE_RTL', $theme_name);
    $color = \App\Models\Utility::GetValueByName('color', $theme_name);
    $cust_theme_bg = \App\Models\Utility::GetValueByName('cust_theme_bg', $theme_name);
    $cust_darklayout = \App\Models\Utility::GetValueByName('cust_darklayout', $theme_name);

    $storage_setting = \App\Models\Utility::GetValueByName('storage_setting', $theme_name);
    $local_storage_validation = \App\Models\Utility::GetValueByName('local_storage_validation', $theme_name);
    $local_storage_validations = explode(',', $local_storage_validation);

    $local_storage_max_upload_size = \App\Models\Utility::GetValueByName('local_storage_max_upload_size', $theme_name);
    $s3_max_upload_size = \App\Models\Utility::GetValueByName('s3_max_upload_size', $theme_name);
    $wasabi_max_upload_size = \App\Models\Utility::GetValueByName('wasabi_max_upload_size', $theme_name);

    $s3_storage_validation = \App\Models\Utility::GetValueByName('s3_storage_validation', $theme_name);
    $s3_storage_validations = explode(',', $s3_storage_validation);

    $wasabi_storage_validation = \App\Models\Utility::GetValueByName('wasabi_storage_validation', $theme_name);
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);

    $file_type = config('files_types');

    $superadmin = \App\Models\Admin::where('type', 'superadmin')->first();
    $superadmin_setting = \App\Models\Setting::where('store_id', $superadmin->current_store)
        ->where('theme_id', $superadmin->theme_id)
        ->pluck('value', 'name')
        ->toArray();

    $woocommerce_setting_enabled = \App\Models\Utility::GetValueByName('woocommerce_setting_enabled', $theme_name);
    $woocommerce_setting_enabled = !empty($woocommerce_setting_enabled) && $woocommerce_setting_enabled == 'on' ? 1 : 0;
    $woocommerce_store_url = \App\Models\Utility::GetValueByName('woocommerce_store_url', $theme_name);
    $woocommerce_consumer_key = \App\Models\Utility::GetValueByName('woocommerce_consumer_key', $theme_name);
    $woocommerce_consumer_secret = \App\Models\Utility::GetValueByName('woocommerce_consumer_secret', $theme_name);

    //whatsapp notification
    $whatsapp_phone_number_id = \App\Models\Utility::GetValueByName('whatsapp_phone_number_id', $theme_name);
    $whatsapp_access_token = \App\Models\Utility::GetValueByName('whatsapp_access_token', $theme_name);

    $shopify_setting_enabled = \App\Models\Utility::GetValueByName('shopify_setting_enabled', $theme_name);
    $shopify_setting_enabled = !empty($shopify_setting_enabled) && $shopify_setting_enabled == 'on' ? 1 : 0;
    $shopify_store_url = \App\Models\Utility::GetValueByName('shopify_store_url', $theme_name);
    $shopify_access_token = \App\Models\Utility::GetValueByName('shopify_access_token', $theme_name);

    $whatsapp_setting_enabled = \App\Models\Utility::GetValueByName('whatsapp_setting_enabled', $theme_name);
    $whatsapp_setting_enabled = !empty($whatsapp_setting_enabled) && $whatsapp_setting_enabled == 'on' ? 1 : 0;
    $whatsapp_contact_number = \App\Models\Utility::GetValueByName('whatsapp_contact_number', $theme_name);

    $twilio_setting_enabled = \App\Models\Utility::GetValueByName('twilio_setting_enabled', $theme_name);
    $twilio_setting_enabled = !empty($twilio_setting_enabled) && $twilio_setting_enabled == 'on' ? 1 : 0;
    $twilio_sid = \App\Models\Utility::GetValueByName('twilio_sid', $theme_name);
    $twilio_token = \App\Models\Utility::GetValueByName('twilio_token', $theme_name);
    $twilio_from = \App\Models\Utility::GetValueByName('twilio_from', $theme_name);
    $twilio_notification_number = \App\Models\Utility::GetValueByName('twilio_notification_number', $theme_name);

    if (\Auth::guard('admin')->user()->type == 'admin') {
        $notification = \App\Models\Utility::GetValueByName('notification', $theme_name);
        $notifications = !empty(json_decode($notification)) ? json_decode($notification) : [];
    }
@endphp

@extends('layouts.app')

@section('page-title', __('Settings'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Settings') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3">
            <div class="card sticky-top" style="top:30px">
                <div class="list-group list-group-flush" id="useradd-sidenav">
                    <a href="#Brand_Setting" class="list-group-item list-group-item-action border-0">
                        {{ __('Brand Settings') }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </a>
                    <a href="#email-settings" class="list-group-item list-group-item-action border-0">
                        {{ __('Email Settings') }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </a>
                    <a href="#Payment_Setting" class="list-group-item list-group-item-action border-0">
                        {{ __('Payment Settings') }}
                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                    </a>



                    @if (\Auth::guard('admin')->user()->type == 'superadmin')
                        <a href="#Storage_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Storage Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#Cookie_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Cookie Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#chatgpt_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Chat GPT Key Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#ReCaptcha_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('ReCaptcha Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#Cache_Settings" class="list-group-item list-group-item-action border-0">
                            {{ __('Cache Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#style_customize" class="list-group-item list-group-item-action border-0">
                            {{ __('Style Customize') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#location-list" class="list-group-item list-group-item-action border-0"
                            id="contry-city-state">{{ __('Country/ State/ City Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                    @else
                        <a href="#Stock_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Stock Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#Refund_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Refund Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#Loyality_program" class="list-group-item list-group-item-action border-0">
                            {{ __('Loyality program') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#Pixel_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Pixel Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        @if ($plan->pwa_store == 'on')
                            <a href="#Pwa_Setting" class="list-group-item list-group-item-action border-0">
                                {{ __('PWA Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        @endif
                        <a href="#Woocommerce_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Woocommerce Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#shopify_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Shopify Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#whatsapp_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Whatsapp Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#whatsapp_message_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Whatsapp Message Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#twilio_setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Twilio Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#email-notification-settings"
                            class="list-group-item list-group-item-action border-0">{{ __('Email Notification Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#whatsapp-notification-settings"
                            class="list-group-item list-group-item-action border-0">{{ __('WhatsApp Business API') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                        <a href="#Webhook_Setting" class="list-group-item list-group-item-action border-0">
                            {{ __('Webhook Settings') }}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div id="Brand_Setting">
                <div class="card">
                    <div class="card-header">
                        <h5 class=""> {{ __('Brand Settings') }} </h5>
                    </div>
                    <div class="card-body p-4">
                        {{-- {{ Form::open(['route' => 'business.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }} --}}
                        {{ Form::model($settings, ['route' => 'admin.business.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <div class="row">

                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Logo dark') }}</h5>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="setting-card">
                                            <div class="logo-content mt-4">
                                                <a href="#" target="_blank">
                                                    <img src="{{ !empty($logo_dark) ? $logo_dark . '?timestamp=' . time() : $profile . '/logo-dark.png' . '?timestamp=' . time() }}"
                                                        class="img_setting" id="before">
                                                </a>
                                            </div>
                                            <div class="choose-files mt-5">
                                                <label for="company_logo">
                                                    <div class=" bg-primary company_logo_update">
                                                        <i class="ti ti-upload "></i>{{ __('Choose file here') }}
                                                    </div>
                                                    <input type="file" id="company_logo"
                                                        data-filename="company_logo_update" name="logo_dark"
                                                        class="form-control file"
                                                        onchange=" document.getElementById('before').src = window.URL.createObjectURL(this.files[0])">
                                                </label>

                                            </div>
                                            @error('company_logo')
                                                <div class="row">
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Logo Light') }}</h5>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class=" setting-card">
                                            <div class="logo-content mt-4">
                                                <a href="#" target="_blank">
                                                    <img src="{{ !empty($logo_light) ? $logo_light . '?timestamp=' . time() : $profile . '/logo-light.png' . '?timestamp=' . time() }}"
                                                        class=" img_setting" id="logo-light">
                                                </a>
                                            </div>
                                            <div class="choose-files mt-5">
                                                <label for="company_logo_light">
                                                    <div class=" bg-primary dark_logo_update">
                                                        <i class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                    </div>
                                                    <input type="file" class="form-control file" name="logo_light"
                                                        id="company_logo_light" data-filename="dark_logo_update"
                                                        onchange=" document.getElementById('logo-light').src = window.URL.createObjectURL(this.files[0])">
                                                </label>
                                            </div>
                                            @error('company_logo_light')
                                                <div class="row">
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Favicon') }}</h5>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class=" setting-card">
                                            <div class="logo-content mt-4">
                                                <a href="#" target="_blank">
                                                    <img src="{{ !empty($favicon) ? $favicon . '?timestamp=' . time() : $profile . '/logo-sm.svg' . '?timestamp=' . time() }}"
                                                        width="60px" height="40px" class=" img_setting favicon"
                                                        id="faviCon">
                                                </a>

                                            </div>
                                            <div class="choose-files mt-5">
                                                <label for="company_favicon">
                                                    <div class=" bg-primary company_favicon_update">
                                                        <i class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                    </div>
                                                    <input type="file" class="form-control file" id="company_favicon"
                                                        name="favicon" data-filename="company_favicon_update"
                                                        onchange=" document.getElementById('faviCon').src = window.URL.createObjectURL(this.files[0])">
                                                </label>
                                            </div>
                                            @error('logo')
                                                <div class="row">
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                {{ Form::label('title_text', __('Title Text'), ['class' => 'form-label']) }}
                                {{ Form::text('title_text', null, ['class' => 'form-control', 'placeholder' => __('Title Text')]) }}
                                @error('title_text')
                                    <span class="invalid-title_text" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                {{ Form::label('footer_text', __('Footer Text'), ['class' => 'form-label']) }}
                                {{ Form::text('footer_text', null, ['class' => 'form-control', 'placeholder' => __('Footer Text')]) }}
                                @error('footer_text')
                                    <span class="invalid-footer_text" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="site_date_format" class="form-label">{{ __('Date Format') }}</label>
                                <select type="text" name="site_date_format" class="form-control" data-toggle="select"
                                    id="site_date_format">
                                    <option value="M j, Y" @if (@$settings['site_date_format'] == 'M j, Y') selected="selected" @endif>
                                        Jan 1,2015</option>
                                    <option value="d-m-Y" @if (@$settings['site_date_format'] == 'd-m-Y') selected="selected" @endif>
                                        DD-MM-YYYY</option>
                                    <option value="m-d-Y" @if (@$settings['site_date_format'] == 'm-d-Y') selected="selected" @endif>
                                        MM-DD-YYYY</option>
                                    <option value="Y-m-d" @if (@$settings['site_date_format'] == 'Y-m-d') selected="selected" @endif>
                                        YYYY-MM-DD</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="site_time_format" class="form-label">{{ __('Time Format') }}</label>
                                <select type="text" name="site_time_format" class="form-control" data-toggle="select"
                                    id="site_time_format">
                                    <option value="g:i A" @if (@$settings['site_time_format'] == 'g:i A') selected="selected" @endif>
                                        10:30 PM</option>
                                    <option value="g:i a" @if (@$settings['site_time_format'] == 'g:i a') selected="selected" @endif>
                                        10:30 pm</option>
                                    <option value="H:i" @if (@$settings['site_time_format'] == 'H:i') selected="selected" @endif>
                                        22:30</option>
                                </select>
                            </div>

                            <div class="form-group col-6 col-md-3">
                                <div class="custom-control form-switch p-0">
                                    <label class="form-check-label form-label"
                                        for="SITE_RTL">{{ __('Enable RTL') }}</label><br>
                                    <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                        data-onstyle="primary" name="SITE_RTL" id="SITE_RTL"
                                        {{ $SITE_RTL == 'on' ? 'checked="checked"' : '' }}>
                                </div>
                            </div>

                            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                                <div class="form-group col-6 col-md-3">
                                    <div class="custom-control form-switch p-0">
                                        <label class="form-check-label form-label"
                                            for="display_landing">{{ __('Enable Landing Page') }}</label><br>
                                        <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                            data-onstyle="primary" name="display_landing" id="display_landing"
                                            {{ isset($settings['display_landing']) && $settings['display_landing'] == 'on' ? 'checked="checked"' : '' }}>
                                    </div>
                                </div>
                                <div class="form-group col-6 col-md-3">
                                    <div class="custom-control form-switch p-0">
                                        <label class="form-check-label form-label"
                                            for="SIGNUP">{{ __('Enable Sign-Up Page') }}</label><br>
                                        <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                            data-onstyle="primary" name="SIGNUP" id="SIGNUP"
                                            {{ isset($settings['SIGNUP']) && $settings['SIGNUP'] == 'on' ? 'checked="checked"' : '' }}>
                                    </div>
                                </div>
                            @endif

                            {{-- @if (\Auth::guard('admin')->user()->type == 'admin')
                                <div class="form-group col-6 col-md-3">
                                    <div class="custom-control form-switch p-0">
                                        <label class="form-check-label form-label"
                                            for="stock_management">{{ __(' Enable Stock Management') }}</label><br>
                                        <input type="checkbox" class="form-check-input" data-toggle="switchbutton"
                                            data-onstyle="primary" name="stock_management" id="stock_management"
                                            {{ isset($settings['stock_management']) && $settings['stock_management'] == 'on' ? 'checked="checked"' : '' }}>
                                    </div>
                                </div>
                            @endif --}}

                            <div class="form-group col-md-3">
                                {{ Form::label('default_language', __('Default Language'), ['class' => 'form-label']) }}
                                <div class="changeLanguage">
                                    <select name="default_language" id="default_language" class="form-control"
                                        data-toggle="select">
                                        @foreach (\App\Models\Utility::languages() as $code => $language)
                                            <option @if (\Auth::user()['default_language'] == $code) selected @endif
                                                value="{{ $code }}">
                                                {{ ucFirst($language) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                                <div class="form-group col-6 col-md-3">
                                    <div class="custom-control form-switch p-0">
                                        <label class="form-check-label form-label"
                                            for="email_verification">{{ __('Enable Email Verification') }}</label><br>
                                        <input type="checkbox" name="email_verification" class="form-check-input"
                                            id="email_verification" data-toggle="switchbutton"
                                            {{ isset($settings['email_verification']) && $settings['email_verification'] == 'on' ? 'checked="checked"' : '' }}
                                            data-onstyle="primary">
                                    </div>
                                </div>
                            @endif

                            {{-- @if (\Auth::guard('admin')->user()->type == 'admin')
                                <div class="form-group col-md-3">
                                    {{ Form::label('notifications', __('Notifications'), ['class' => 'form-label']) }}
                                    <div class="form-group row">
                                        <div class="col-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="enable_low_stock" id="low_stock" name="notification[]"
                                                    {{ in_array('enable_low_stock', $notifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="low_stock">
                                                    {{ __('Low stock notifications') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="enable_out_of_stock" id="out_of_stock"
                                                    name="notification[]"
                                                    {{ in_array('enable_out_of_stock', $notifications) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="out_of_stock">
                                                    {{ __('Out of stock notifications') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    {{ Form::label('low_stock_threshold', __('Low Stock Threshold'), ['class' => 'form-label']) }}
                                    {{ Form::number('low_stock_threshold', null, ['class' => 'form-control']) }}
                                </div>
                                <div class="form-group col-md-3">
                                    {{ Form::label('out_of_stock_threshold', __('Out of Stock Threshold'), ['class' => 'form-label']) }}
                                    {{ Form::number('out_of_stock_threshold', null, ['class' => 'form-control']) }}
                                </div>
                            @endif --}}


                            <div class="setting-card setting-logo-box p-3">
                                <div class="row">
                                    {{-- <h5>{{ __('Theme Customizer') }}</h5> --}}
                                    <div class="col-4 my-auto">
                                        <div class="inner-div">
                                            <h6 class="mt-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                    viewBox="0 0 17 17" fill="none">
                                                    <path
                                                        d="M8.5 17C3.79231 17 0 13.2077 0 8.5C0 3.79231 3.79231 0 8.5 0C13.2077 0 17 3.79231 17 8.5C17 10.3308 15.7577 13.0769 12.4231 13.0769C11.8346 13.0769 10.7231 13.3385 10.3962 13.9923C10.2 14.3192 10.2654 14.5808 10.3308 14.7115C10.3962 14.9077 10.5923 15.0385 10.7231 15.1038L10.7885 15.1692C11.2462 15.4962 11.3115 15.8885 11.1808 16.15C11.05 16.7385 10.3308 17 8.5 17ZM8.5 1.30769C4.51154 1.30769 1.30769 4.51154 1.30769 8.5C1.30769 12.4885 4.51154 15.6923 8.5 15.6923H9.41538C9.35 15.5615 9.28462 15.4962 9.21923 15.3654C9.02308 14.9731 8.82692 14.3192 9.21923 13.4692C9.87308 12.1615 11.5731 11.7692 12.4231 11.7692C15.6269 11.7692 15.6923 8.63077 15.6923 8.5C15.6923 4.51154 12.4885 1.30769 8.5 1.30769Z"
                                                        fill="#6FD943" />
                                                    <path
                                                        d="M3.26904 6.86358C3.26904 7.38666 3.72674 7.84435 4.24981 7.84435C4.77289 7.84435 5.23058 7.38666 5.23058 6.86358C5.23058 6.3405 4.77289 5.88281 4.24981 5.88281C3.72674 5.88281 3.26904 6.3405 3.26904 6.86358Z"
                                                        fill="#013D29" />
                                                    <path
                                                        d="M13.7306 6.86358C13.7306 7.38666 13.2729 7.84435 12.7498 7.84435C12.2267 7.84435 11.769 7.38666 11.769 6.86358C11.769 6.3405 12.2267 5.88281 12.7498 5.88281C13.2729 5.88281 13.7306 6.3405 13.7306 6.86358Z"
                                                        fill="#013D29" />
                                                    <path
                                                        d="M5.88452 4.2503C5.88452 4.77338 6.34221 5.23107 6.86529 5.23107C7.38837 5.23107 7.84606 4.77338 7.84606 4.2503C7.84606 3.72722 7.38837 3.26953 6.86529 3.26953C6.34221 3.26953 5.88452 3.72722 5.88452 4.2503Z"
                                                        fill="#013D29" />
                                                    <path
                                                        d="M11.1153 4.2503C11.1153 4.77338 10.6577 5.23107 10.1346 5.23107C9.6115 5.23107 9.15381 4.77338 9.15381 4.2503C9.15381 3.72722 9.6115 3.26953 10.1346 3.26953C10.6577 3.26953 11.1153 3.72722 11.1153 4.2503Z"
                                                        fill="#013D29" />
                                                </svg>
                                                {{ __('Primary Color Settings') }}
                                            </h6>
                                            <hr class="my-2" />
                                            <div class="theme-color themes-color">
                                                <a href="#!" class="{{ $color == 'theme-1' ? 'active_color' : '' }}"
                                                    data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-1"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-2' ? 'active_color' : '' }}"
                                                    data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-2"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-3' ? 'active_color' : '' }}"
                                                    data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-3"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-4' ? 'active_color' : '' }}"
                                                    data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-4"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-5' ? 'active_color' : '' }}"
                                                    data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-5"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-6' ? 'active_color' : '' }}"
                                                    data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-6"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-7' ? 'active_color' : '' }}"
                                                    data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-7"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-8' ? 'active_color' : '' }}"
                                                    data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-8"
                                                    style="display: none;">

                                                <a href="#!" class="{{ $color == 'theme-9' ? 'active_color' : '' }}"
                                                    data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                <input type="radio" class="theme_color" name="color" value="theme-9"
                                                    style="display: none;">

                                                <a href="#!"
                                                    class="{{ $color == 'theme-10' ? 'active_color' : '' }}"
                                                    data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                <input type="radio" class="theme_color" name="color"
                                                    value="theme-10" style="display: none;">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 my-auto mt-2">
                                        <div class="inner-div">
                                            <h6 class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                    viewBox="0 0 17 17" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M1.96154 1.30769C1.60043 1.30769 1.30769 1.60043 1.30769 1.96154V15.0385C1.30769 15.3996 1.60043 15.6923 1.96154 15.6923H15.0385C15.3996 15.6923 15.6923 15.3996 15.6923 15.0385V1.96154C15.6923 1.60043 15.3996 1.30769 15.0385 1.30769H1.96154ZM0 1.96154C0 0.878211 0.878211 0 1.96154 0H15.0385C16.1218 0 17 0.878211 17 1.96154V15.0385C17 16.1218 16.1218 17 15.0385 17H1.96154C0.878211 17 0 16.1218 0 15.0385V1.96154Z"
                                                        fill="#6FD943" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.01273 0C5.37384 0 5.66658 0.29274 5.66658 0.653846V16.3462C5.66658 16.7073 5.37384 17 5.01273 17C4.65163 17 4.35889 16.7073 4.35889 16.3462V0.653846C4.35889 0.29274 4.65163 0 5.01273 0Z"
                                                        fill="#013D29" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.05139 16.3453C3.05139 15.9842 3.34413 15.6914 3.70524 15.6914H6.32062C6.68173 15.6914 6.97447 15.9842 6.97447 16.3453C6.97447 16.7063 6.68173 16.9991 6.32062 16.9991H3.70524C3.34413 16.9991 3.05139 16.7063 3.05139 16.3453Z"
                                                        fill="#013D29" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.05139 0.653846C3.05139 0.29274 3.34413 0 3.70524 0H6.32062C6.68173 0 6.97447 0.29274 6.97447 0.653846C6.97447 1.01495 6.68173 1.30769 6.32062 1.30769H3.70524C3.34413 1.30769 3.05139 1.01495 3.05139 0.653846Z"
                                                        fill="#013D29" />
                                                </svg>
                                                {{ __('Sidebar Settings') }}
                                            </h6>
                                            <hr class="my-2" />
                                            <div class="form-switch">
                                                <input type="checkbox" class="form-check-input" id="cust_theme_bg"
                                                    name="cust_theme_bg"
                                                    {{ $cust_theme_bg == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="form-check-label f-w-600 pl-1"
                                                    for="cust_theme_bg">{{ __('Transparent layout') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 my-auto mt-2">
                                        <div class="inner-div">
                                            <h6 class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                                    viewBox="0 0 16 15" fill="none">
                                                    <path
                                                        d="M4.95833 12.0417C3.6433 12.0417 2.38213 11.5193 1.45226 10.5895C0.522394 9.65959 0 8.39842 0 7.08338C0 5.76835 0.522394 4.50718 1.45226 3.57731C2.38213 2.64744 3.6433 2.12505 4.95833 2.12505C5.67582 2.12179 6.38495 2.27911 7.03375 2.58547L8.40792 3.23713L7.02667 3.86755C6.41232 4.15102 5.89202 4.60454 5.52734 5.17444C5.16266 5.74435 4.96885 6.40679 4.96885 7.08338C4.96885 7.75998 5.16266 8.42242 5.52734 8.99232C5.89202 9.56222 6.41232 10.0157 7.02667 10.2992L8.40792 10.9296L7.03375 11.5813C6.38495 11.8877 5.67582 12.045 4.95833 12.0417ZM4.95833 3.54172C4.49324 3.54637 4.03361 3.64258 3.60569 3.82486C3.17778 4.00715 2.78996 4.27193 2.46437 4.60409C1.80682 5.27492 1.44269 6.17949 1.45208 7.1188C1.46148 8.05811 1.84362 8.95521 2.51446 9.61276C3.18529 10.2703 4.08986 10.6344 5.02917 10.625C4.55799 10.1634 4.18366 9.61235 3.92812 9.0042C3.67257 8.39606 3.54094 7.74304 3.54094 7.08338C3.54094 6.42373 3.67257 5.77071 3.92812 5.16256C4.18366 4.55442 4.55799 4.00338 5.02917 3.54172H4.95833Z"
                                                        fill="#013D29" />
                                                    <path
                                                        d="M8.49997 12.0426C7.78248 12.0459 7.07335 11.8885 6.42455 11.5822C5.3972 11.1097 4.56222 10.3002 4.0581 9.28797C3.55397 8.27576 3.41097 7.12164 3.65283 6.017C3.89468 4.91236 4.50685 3.92357 5.38782 3.21462C6.26879 2.50567 7.36562 2.11914 8.49643 2.11914C9.62723 2.11914 10.7241 2.50567 11.605 3.21462C12.486 3.92357 13.0982 4.91236 13.34 6.017C13.5819 7.12164 13.4389 8.27576 12.9348 9.28797C12.4306 10.3002 11.5957 11.1097 10.5683 11.5822C9.9212 11.8862 9.21491 12.0434 8.49997 12.0426ZM8.49997 3.5426C7.99353 3.53785 7.49248 3.64677 7.03372 3.86135C6.29797 4.19695 5.69923 4.77423 5.337 5.49724C4.97478 6.22025 4.87089 7.04545 5.04261 7.83568C5.21432 8.62591 5.6513 9.33358 6.28091 9.84107C6.91052 10.3486 7.69484 10.6253 8.50351 10.6253C9.31218 10.6253 10.0965 10.3486 10.7261 9.84107C11.3557 9.33358 11.7927 8.62591 11.9644 7.83568C12.1361 7.04545 12.0322 6.22025 11.67 5.49724C11.3078 4.77423 10.709 4.19695 9.9733 3.86135C9.51286 3.64433 9.00894 3.53531 8.49997 3.5426Z"
                                                        fill="#6FD943" />
                                                    <path
                                                        d="M14.875 6.375H13.4583C13.0671 6.375 12.75 6.69213 12.75 7.08333C12.75 7.47453 13.0671 7.79167 13.4583 7.79167H14.875C15.2662 7.79167 15.5833 7.47453 15.5833 7.08333C15.5833 6.69213 15.2662 6.375 14.875 6.375Z"
                                                        fill="#6FD943" />
                                                    <path
                                                        d="M12.0404 1.83529L11.0387 2.83702C10.7621 3.11364 10.7621 3.56214 11.0387 3.83876C11.3153 4.11538 11.7638 4.11538 12.0404 3.83876L13.0422 2.83702C13.3188 2.5604 13.3188 2.11191 13.0422 1.83529C12.7656 1.55867 12.3171 1.55867 12.0404 1.83529Z"
                                                        fill="#6FD943" />
                                                    <path
                                                        d="M9.20829 0.708333C9.20829 0.317132 8.89116 0 8.49996 0C8.10876 0 7.79163 0.317132 7.79163 0.708333V2.125C7.79163 2.5162 8.10876 2.83333 8.49996 2.83333C8.89116 2.83333 9.20829 2.5162 9.20829 2.125V0.708333Z"
                                                        fill="#6FD943" />
                                                    <path
                                                        d="M9.20829 12.0423C9.20829 11.6511 8.89116 11.334 8.49996 11.334C8.10876 11.334 7.79163 11.6511 7.79163 12.0423V13.459C7.79163 13.8502 8.10876 14.1673 8.49996 14.1673C8.89116 14.1673 9.20829 13.8502 9.20829 13.459V12.0423Z"
                                                        fill="#6FD943" />
                                                    <path
                                                        d="M12.0362 10.3312C11.7595 10.0545 11.3111 10.0545 11.0344 10.3312C10.7578 10.6078 10.7578 11.0563 11.0344 11.3329L12.0362 12.3346C12.3128 12.6113 12.7613 12.6113 13.0379 12.3346C13.3145 12.058 13.3145 11.6095 13.0379 11.3329L12.0362 10.3312Z"
                                                        fill="#6FD943" />
                                                </svg>
                                                {{ __('Layout Settings') }}
                                            </h6>
                                            <hr class="my-2" />
                                            <div class="form-check form-switch mt-2">
                                                <input type="checkbox" class="form-check-input" id="cust-darklayout"
                                                    name="cust_darklayout"
                                                    {{ $cust_darklayout == 'on' ? 'checked="checked"' : '' }} />
                                                <label class="form-check-label f-w-600 pl-1"
                                                    for="cust-darklayout">{{ __('Dark Layout') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-end">
                                    <input type="submit" value="{{ __('Save Changes') }}"
                                        class="btn-submit btn btn-primary">
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div id="email-settings">
                <div class="card">
                    <div class="card-header">
                        <h5 class=""> {{ __('Email settings') }} </h5>
                    </div>
                    <div class="card-body p-4">
                        {{ Form::open(['route' => 'admin.email.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail Driver'), ['class' => 'form-label']) !!}
                                {!! Form::text('mail_driver', !empty($settings['MAIL_DRIVER']) ? $settings['MAIL_DRIVER'] : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mail Driver',
                                ]) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail Host'), ['class' => 'form-label']) !!}
                                {!! Form::text('mail_host', !empty($settings['MAIL_HOST']) ? $settings['MAIL_HOST'] : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mail Driver',
                                ]) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail Port'), ['class' => 'form-label']) !!}
                                {!! Form::text('mail_port', !empty($settings['MAIL_PORT']) ? $settings['MAIL_PORT'] : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mail Port',
                                ]) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail Username'), ['class' => 'form-label']) !!}
                                {!! Form::text('mail_username', !empty($settings['MAIL_USERNAME']) ? $settings['MAIL_USERNAME'] : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mail Username',
                                ]) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail Password'), ['class' => 'form-label']) !!}
                                {!! Form::text('mail_password', !empty($settings['MAIL_PASSWORD']) ? $settings['MAIL_PASSWORD'] : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mail Password',
                                ]) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail Encryption'), ['class' => 'form-label']) !!}
                                {!! Form::text('mail_encryption', !empty($settings['MAIL_ENCRYPTION']) ? $settings['MAIL_ENCRYPTION'] : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mail Encryption',
                                ]) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail From'), ['class' => 'form-label']) !!}
                                {!! Form::text(
                                    'mail_from_address',
                                    !empty($settings['MAIL_FROM_ADDRESS']) ? $settings['MAIL_FROM_ADDRESS'] : '',
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Mail From Address',
                                    ],
                                ) !!}
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                {!! Form::label('', __('Mail From Name'), ['class' => 'form-label']) !!}
                                {!! Form::text('mail_from_name', !empty($settings['MAIL_FROM_NAME']) ? $settings['MAIL_FROM_NAME'] : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Mail Encryption',
                                ]) !!}
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center gap-4 justify-content-between">
                                <div class="text-start ">
                                    <a href="#" data-ajax-popup1="true" data-size="md"
                                        data-title="{{ __('Send Test Mail') }}"
                                        data-url="{{ route('admin.email.test') }}" data-toggle="tooltip"
                                        title="{{ __('Send Test Mail') }}" class="btn  btn-warning send_email">
                                        {{ __('Send Test Mail') }}
                                    </a>
                                </div>
                                <div class="text-end">
                                    <input type="submit" value="{{ __('Save Changes') }}"
                                        class="btn-submit btn btn-primary">
                                </div>

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div id="Payment_Setting">
                <div class="card">
                    <div class="card-header">
                        <div class="float-end">
                            <div class="badge bg-success p-2 px-3 rounded"></div>
                        </div>
                        <h5>{{ __('Payment Settings') }}</h5>
                    </div>
                    <div class="card-body">
                        {{ Form::open(['route' => 'admin.payment.setting', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for="currency" class="form-label">{{ __('Currency') }} *</label>
                                {!! Form::text('CURRENCY_NAME', $CURRENCY_NAME, [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'placeholder' => 'Enter Currency',
                                ]) !!}
                                <small>
                                    {{ __('Note') }}:
                                    {{ __('Add currency code as per three-letter ISO code.') }}
                                    <br>
                                    <a href="https://stripe.com/docs/currencies"
                                        target="_blank">{{ __('you can find out here') }}..</a>
                                </small> <br>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="currency_symbol" class="form-label">{{ __('Currency Symbol') }}
                                    *</label>
                                {!! Form::text('CURRENCY', $CURRENCY, [
                                    'class' => 'form-control',
                                    'required' => true,
                                    'placeholder' => __('Enter Currency Symbol'),
                                ]) !!}
                            </div>
                        </div>

                        <div class="faq" id="accordionExample">
                            <div class="row">
                                <div class="col-12">
                                    <div class="accordion accordion-flush" id="payment-gateways">
                                        <div id="" class="">
                                            <!-- COD -->
                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="COD">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseone_COD"
                                                            aria-expanded="false" aria-controls="collapseone_COD">
                                                            <span class="d-flex align-items-center">
                                                                <i class="ti ti-credit-card me-2"></i>{{ __('COD') }}
                                                            </span>
                                                        </button>
                                                    </h2>

                                                    <div id="collapseone_COD" class="accordion-collapse collapse"
                                                        aria-labelledby="COD" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row mt-2">
                                                                <div class="col-12 d-flex justify-content-between">
                                                                    <small class="">
                                                                        {{ __('Note') }}:
                                                                        {{ __('This detail will use for make checkout of product') }}.
                                                                    </small>
                                                                    {!! Form::hidden('is_cod_enabled', 'off') !!}
                                                                    <div class="form-check form-switch d-inline-block">
                                                                        {!! Form::checkbox('is_cod_enabled', 'on', $is_cod_enabled, [
                                                                            'class' => 'form-check-input',
                                                                            'id' => 'is_cod_enabled',
                                                                        ]) !!}
                                                                        <label
                                                                            class="custom-control-label form-control-label"
                                                                            for="is_cod_enabled"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <label for="Bank_transfer_info"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('cod_info', empty($cod_info) ? 'Cash on Delivery' : $cod_info, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                        <label for="upload_image"
                                                                            class="image-upload bg-primary pointer">
                                                                            <i class="ti ti-upload px-1"></i>
                                                                            {{ __('Choose file here') }}
                                                                        </label>
                                                                        <input type="file" name="cod_image"
                                                                            id="upload_image" class="d-none">
                                                                        <img alt="Image placeholder"
                                                                            src="{{ empty($cod_image) ? asset(Storage::url('uploads/cod.png')) : asset($cod_image) }}"
                                                                            class="img-center img-fluid"
                                                                            style="max-height: 100px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Bank Transfer -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="Bank_transfer">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseone_Bank_transfer" aria-expanded="false"
                                                        aria-controls="collapseone_Bank_transfer">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Bank Transfer') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_Bank_transfer" class="accordion-collapse collapse"
                                                    aria-labelledby="Bank_transfer" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_bank_transfer_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_bank_transfer_enabled', 'on', $is_bank_transfer_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_bank_transfer_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_bank_transfer_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="Bank_transfer_info"
                                                                        class="form-label">{{ __('Description') }}</label>
                                                                    {!! Form::textarea(
                                                                        'bank_transfer',
                                                                        empty($bank_transfer_info) ? 'Bank Transfer add bank details here' : $bank_transfer_info,
                                                                        [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'Bank_transfer_info',
                                                                        ],
                                                                    ) !!}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="bank_transfer_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="bank_transfer_image"
                                                                        id="bank_transfer_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ empty($bank_transfer_image) ? asset(Storage::url('uploads/bank.png')) : asset($bank_transfer_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stripe -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="Stripe">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_Stripe"
                                                        aria-expanded="false" aria-controls="collapseone_Stripe">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Stripe') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_Stripe" class="accordion-collapse collapse"
                                                    aria-labelledby="Stripe" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_stripe_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_stripe_enabled', 'on', $is_Stripe_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_stripe_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_stripe_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="stripe_key"
                                                                        class="form-label">{{ __('Publishable Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Publishable Key"
                                                                        name="publishable_key" type="text"
                                                                        value="{{ $publishable_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="stripe_secret"
                                                                        class="form-label">{{ __('Stripe Secret') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Stripe Secret" name="stripe_secret"
                                                                        type="text" value="{{ $stripe_secret }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="Stripe_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="stripe_image"
                                                                        id="Stripe_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($Stripe_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>


                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="stripe_unfo"
                                                                        class="form-label">{{ __('Description') }}</label>
                                                                    {!! Form::textarea('stripe_unfo', $stripe_unfo, [
                                                                        'class' => 'autogrow form-control',
                                                                        'rows' => '5',
                                                                        'id' => 'stripe_unfo',
                                                                    ]) !!}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paystack -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paystack">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_paystack"
                                                        aria-expanded="false" aria-controls="collapseone_paystack">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Paystack') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_paystack" class="accordion-collapse collapse"
                                                    aria-labelledby="paystack" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_paystack_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_paystack_enabled', 'on', $is_paystack_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paystack_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paystack_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paystack_public_key"
                                                                        class="form-label">{{ __('Public Key') }}</label>
                                                                    <input class="form-control" placeholder="Public Key"
                                                                        name="paystack_public_key" type="text"
                                                                        value="{{ $paystack_public_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="paystack_secret"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="paystack Secret"
                                                                        name="paystack_secret" type="text"
                                                                        value="{{ $paystack_secret }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="paystack_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="paystack_image"
                                                                        id="paystack_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($paystack_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="paystack_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('paystack_unfo', $paystack_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'paystack_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Razorpay -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="razorpay">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_razorpay"
                                                        aria-expanded="false" aria-controls="collapseone_razorpay">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Razorpay') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_razorpay" class="accordion-collapse collapse"
                                                    aria-labelledby="razorpay" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_razorpay_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_razorpay_enabled', 'on', $is_razorpay_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_razorpay_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_razorpay_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="razorpay_public_key"
                                                                        class="form-label">{{ __('Public Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Razorpay Public Key"
                                                                        name="razorpay_public_key" type="text"
                                                                        value="{{ $razorpay_public_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="razorpay_secret_key"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Razorpay Secret Key"
                                                                        name="razorpay_secret_key" type="text"
                                                                        value="{{ $razorpay_secret_key }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="razorpay_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="razorpay_image"
                                                                        id="razorpay_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($razorpay_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="razorpay_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('razorpay_unfo', $razorpay_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'razorpay_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mercado  -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="mercado">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_mercado"
                                                        aria-expanded="false" aria-controls="collapseone_mercado">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Mercado Pago') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_mercado" class="accordion-collapse collapse"
                                                    aria-labelledby="mercado" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_mercado_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_mercado_enabled', 'on', $is_mercado_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_mercado_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_mercado_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 pb-4">
                                                                <label class="col-form-label"
                                                                    for="mercado_mode">{{ __('Mercado Mode') }}</label>
                                                                <br>
                                                                <div class="d-flex flex-wrap">
                                                                    <div class="mr-2" style="margin-right: 15px;">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio"
                                                                                        name="mercado_mode"
                                                                                        value="sandbox"
                                                                                        class="form-check-input"
                                                                                        {{ (isset($mercado_mode) && $mercado_mode == '') || (isset($mercado_mode) && $mercado_mode == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Sandbox') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio"
                                                                                        name="mercado_mode" value="live"
                                                                                        class="form-check-input"
                                                                                        {{ isset($mercado_mode) && $mercado_mode == 'live' ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Live') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="mercado_access_token"
                                                                        class="col-form-label pt-0">{{ __('Access Token') }}</label>
                                                                    <input type="text" name="mercado_access_token"
                                                                        id="mercado_access_token" class="form-control"
                                                                        value="{{ $mercado_access_token }}"
                                                                        placeholder="{{ __('Access Token') }}" />
                                                                    @if ($errors->has('mercado_secret_key'))
                                                                        <span class="invalid-feedback d-block">
                                                                            {{ $errors->first('mercado_access_token') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="mercado_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="mercado_image"
                                                                        id="mercado_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($mercado_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="mercado_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('mercado_unfo', $mercado_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'mercado_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Skrill  -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="skrill">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_skrill"
                                                        aria-expanded="false" aria-controls="collapseone_skrill">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Skrill') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_skrill" class="accordion-collapse collapse"
                                                    aria-labelledby="skrill" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_skrill_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_skrill_enabled', 'on', $is_skrill_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_skrill_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_skrill_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="skrill_email"
                                                                        class="col-form-label pt-0">{{ __('Skrill Email') }}</label>
                                                                    <input type="text" name="skrill_email"
                                                                        id="skrill_email" class="form-control"
                                                                        value="{{ $skrill_email }}"
                                                                        placeholder="{{ __('Access Token') }}" />
                                                                    @if ($errors->has('skrill_secret_key'))
                                                                        <span class="invalid-feedback d-block">
                                                                            {{ $errors->first('skrill_email') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="skrill_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="skrill_image"
                                                                        id="skrill_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($skrill_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="skrill_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('skrill_unfo', $skrill_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'skrill_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PaymentWall -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paymentwall">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseone_paymentwall" aria-expanded="false"
                                                        aria-controls="collapseone_paymentwall">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('PaymentWall') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_paymentwall" class="accordion-collapse collapse"
                                                    aria-labelledby="paymentwall" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_paymentwall_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_paymentwall_enabled', 'on', $is_paymentwall_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paymentwall_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paymentwall_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paymentwall_public_key"
                                                                        class="form-label">{{ __('Public Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="paymentwall Public Key"
                                                                        name="paymentwall_public_key" type="text"
                                                                        value="{{ $paymentwall_public_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="paymentwall_private_key"
                                                                        class="form-label">{{ __('Private Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="paymentwall Private Key"
                                                                        name="paymentwall_private_key" type="text"
                                                                        value="{{ $paymentwall_private_key }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="paymentwall_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="paymentwall_image"
                                                                        id="paymentwall_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($paymentwall_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="paymentwall_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('paymentwall_unfo', $paymentwall_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'paymentwall_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paypal -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="Paypal">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_Paypal"
                                                        aria-expanded="false" aria-controls="collapseone_Paypal">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Paypal') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_Paypal" class="accordion-collapse collapse"
                                                    aria-labelledby="Paypal" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <small class="">
                                                                {{ __('Note') }}:
                                                                {{ __('This detail will use for make checkout of product') }}.
                                                            </small>
                                                            <div class="col-md-6">
                                                                <div class="col-lg-12">
                                                                    <label class="paypal-label col-form-label"
                                                                        for="paypal_mode">{{ __('Paypal Mode') }}</label>
                                                                    <br>
                                                                    <div class="d-flex flex-wrap">
                                                                        <div class="mr-2" style="margin-right: 15px;">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="paypal_mode"
                                                                                            value="sandbox"
                                                                                            class="form-check-input"
                                                                                            {{ !isset($paypal_mode) || $paypal_mode == '' || $paypal_mode == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Sandbox') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mr-2">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="paypal_mode"
                                                                                            value="live"
                                                                                            class="form-check-input"
                                                                                            {{ isset($paypal_mode) && $paypal_mode == 'live' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Live') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_paypal_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_paypal_enabled', 'on', $is_Paypal_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paypal_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paypal_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paypal_client_id"
                                                                        class="form-label">{{ __('Publishable Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Publishable Key"
                                                                        name="paypal_client_id" type="text"
                                                                        value="{{ $paypal_client_id }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="paypal_secret"
                                                                        class="form-label">{{ __('Paypal Secret') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Paypal Secret" name="paypal_secret"
                                                                        type="text" value="{{ $paypal_secret }}">
                                                                </div>

                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="paypal_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="paypal_image"
                                                                        id="paypal_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($paypal_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="paypal_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('paypal_unfo', $paypal_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'paypal_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- flutterwave -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="flutterwave">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseone_flutterwave" aria-expanded="false"
                                                        aria-controls="collapseone_flutterwave">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Flutterwave') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_flutterwave" class="accordion-collapse collapse"
                                                    aria-labelledby="Paypal" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_flutterwave_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_flutterwave_enabled', 'on', $is_flutterwave_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_flutterwave_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_flutterwave_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="public_key"
                                                                        class="form-label">{{ __('Public Key') }}</label>
                                                                    <input class="form-control" placeholder="Public Key"
                                                                        name="public_key" type="text"
                                                                        value="{{ $public_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="flutterwave_secret"
                                                                        class="form-label">{{ __('Flutterwave Secret') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Flutterwave Secret"
                                                                        name="flutterwave_secret" type="text"
                                                                        value="{{ $flutterwave_secret }}">
                                                                </div>

                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="flutterwave_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="flutterwave_image"
                                                                        id="flutterwave_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($flutterwave_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="flutterwave_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('flutterwave_unfo', $flutterwave_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'flutterwave_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paytm -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paytm">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_paytm"
                                                        aria-expanded="false" aria-controls="collapseone_paytm">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Paytm') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_paytm" class="accordion-collapse collapse"
                                                    aria-labelledby="paytm" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                                <div class="col-lg-12">
                                                                    <label class="paypal-label col-form-label"
                                                                        for="paytm_mode">{{ __('Paytm Mode') }}</label>
                                                                    <br>
                                                                    <div class="d-flex flex-wrap">
                                                                        <div class="mr-2" style="margin-right: 15px;">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="paytm_mode"
                                                                                            value="local"
                                                                                            class="form-check-input"
                                                                                            {{ !isset($paytm_mode) || $paytm_mode == '' || $paytm_mode == 'local' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Local') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mr-2">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="paytm_mode"
                                                                                            value="production"
                                                                                            class="form-check-input"
                                                                                            {{ isset($paytm_mode) && $paytm_mode == 'production' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Production') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_paytm_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_paytm_enabled', 'on', $is_paytm_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paytm_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paytm_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paytm_public_key"
                                                                        class="col-form-label">{{ __('Merchant ID') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Merchant ID"
                                                                        name="paytm_merchant_id" type="text"
                                                                        value="{{ $paytm_merchant_id }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paytm_secret_key"
                                                                        class="col-form-label">{{ __('Merchant Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Merchant Key"
                                                                        name="paytm_merchant_key" type="text"
                                                                        value="{{ $paytm_merchant_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="paytm_industry_type"
                                                                        class="col-form-label">{{ __('Industry Type') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Industry Type"
                                                                        name="paytm_industry_type" type="text"
                                                                        value="{{ $paytm_industry_type }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="paytm_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="paytm_image"
                                                                        id="paytm_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($paytm_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="paytm_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('paytm_unfo', $paytm_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'paytm_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- mollie -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="mollie">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_mollie"
                                                        aria-expanded="false" aria-controls="collapseone_mollie">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Mollie') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_mollie" class="accordion-collapse collapse"
                                                    aria-labelledby="mollie" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_mollie_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_mollie_enabled', 'on', $is_mollie_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_mollie_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_mollie_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="mollie_api_key"
                                                                        class="form-label">{{ __('Mollie Api Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Mollie Api Key"
                                                                        name="mollie_api_key" type="text"
                                                                        value="{{ $mollie_api_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="mollie_profile_id"
                                                                        class="form-label">{{ __('Mollie Profile Id') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Mollie Profile Secret"
                                                                        name="mollie_profile_id" type="text"
                                                                        value="{{ $mollie_profile_id }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="mollie_partner_id"
                                                                        class="form-label">{{ __('Mollie Partner Id') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Mollie Partner Secret"
                                                                        name="mollie_partner_id" type="text"
                                                                        value="{{ $mollie_partner_id }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="mollie_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="mollie_image"
                                                                        id="mollie_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($mollie_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="mollie_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('mollie_unfo', $mollie_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'mollie_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- coingate -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="coingate">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_coingate"
                                                        aria-expanded="false" aria-controls="collapseone_coingate">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Coingate') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_coingate" class="accordion-collapse collapse"
                                                    aria-labelledby="coingate" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                                <div class="col-lg-12">
                                                                    <label class="paypal-label col-form-label"
                                                                        for="coingate_mode">{{ __('Coingate Mode') }}</label>
                                                                    <br>
                                                                    <div class="d-flex flex-wrap">
                                                                        <div class="mr-2" style="margin-right: 15px;">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="coingate_mode"
                                                                                            value="sandbox"
                                                                                            class="form-check-input"
                                                                                            {{ !isset($coingate_mode) || $coingate_mode == '' || $coingate_mode == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Sandbox') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mr-2">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="coingate_mode"
                                                                                            value="live"
                                                                                            class="form-check-input"
                                                                                            {{ isset($coingate_mode) && $coingate_mode == 'live' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Live') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_coingate_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_coingate_enabled', 'on', $is_coingate_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_coingate_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_coingate_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="coingate_auth_token"
                                                                        class="form-label">{{ __('CoinGate Auth Token') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="CoinGate Auth Token"
                                                                        name="coingate_auth_token" type="text"
                                                                        value="{{ $coingate_auth_token }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="coingate_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="coingate_image"
                                                                        id="coingate_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($coingate_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="coingate_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('coingate_unfo', $coingate_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'coingate_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- sspay -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="sspay">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_sspay"
                                                        aria-expanded="false" aria-controls="collapseone_sspay">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Sspay') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_sspay" class="accordion-collapse collapse"
                                                    aria-labelledby="sspay" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_sspay_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_sspay_enabled', 'on', $is_sspay_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_sspay_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_sspay_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="sspay_secret_key"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('sspay secret key') }}"
                                                                        name="sspay_secret_key" type="text"
                                                                        value="{{ $sspay_secret_key }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="sspay_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="sspay_image"
                                                                        id="sspay_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($sspay_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="sspay_category_code"
                                                                        class="form-label">{{ __('Category Code') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('category code') }}"
                                                                        name="sspay_category_code" type="text"
                                                                        value="{{ $sspay_category_code }}">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="sspay_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('sspay_unfo', $sspay_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'sspay_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Toyyibpay -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="toyyibpay">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseone_toyyibpay" aria-expanded="false"
                                                        aria-controls="collapseone_toyyibpay">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('toyyibpay') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_toyyibpay" class="accordion-collapse collapse"
                                                    aria-labelledby="toyyibpay" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_toyyibpay_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_toyyibpay_enabled', 'on', $is_toyyibpay_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_toyyibpay_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_toyyibpay_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="toyyibpay_secret_key"
                                                                        class="form-label">{{ __('Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('toyyibpay secret key') }}"
                                                                        name="toyyibpay_secret_key" type="text"
                                                                        value="{{ $toyyibpay_secret_key }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="toyyibpay_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="toyyibpay_image"
                                                                        id="toyyibpay_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($toyyibpay_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="toyyibpay_category_code"
                                                                        class="form-label">{{ __('Category Code') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('category code') }}"
                                                                        name="toyyibpay_category_code" type="text"
                                                                        value="{{ $toyyibpay_category_code }}">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="toyyibpay_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('toyyibpay_unfo', $toyyibpay_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'toyyibpay_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- paytab -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paytabs">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_paytabs"
                                                        aria-expanded="false" aria-controls="collapseone_paytabs">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Paytab') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_paytabs" class="accordion-collapse collapse"
                                                    aria-labelledby="paytabs" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_paytabs_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_paytabs_enabled', 'on', $is_paytabs_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paytabs_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paytabs_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paytabs_profile_id"
                                                                        class="form-label">{{ __('Profile Id') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('paytab Profile Id') }}"
                                                                        name="paytabs_profile_id" type="text"
                                                                        value="{{ $paytabs_profile_id }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="paytabs_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="paytabs_image"
                                                                        id="paytabs_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($paytabs_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paytabs_server_key"
                                                                        class="form-label">{{ __('Paytabs Server Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('Paytabs Server Key') }}"
                                                                        name="paytabs_server_key" type="text"
                                                                        value="{{ $paytabs_server_key }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paytabs_region"
                                                                        class="form-label">{{ __('Paytabs Region') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('Paytabs Region') }}"
                                                                        name="paytabs_region" type="text"
                                                                        value="{{ $paytabs_region }}">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="paytabs_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('paytabs_unfo', $paytabs_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'paytabs_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- IyziPay -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="iyzipay">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_iyzipay"
                                                        aria-expanded="false" aria-controls="collapseone_iyzipay">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('IyziPay') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_iyzipay" class="accordion-collapse collapse"
                                                    aria-labelledby="iyzipay" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_iyzipay_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_iyzipay_enabled', 'on', $is_iyzipay_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_iyzipay_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_iyzipay_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 pb-4">
                                                                <label class="col-form-label"
                                                                    for="iyzipay_mode">{{ __('IyziPay Mode') }}</label>
                                                                <br>
                                                                <div class="d-flex flex-wrap">
                                                                    <div class="mr-2" style="margin-right: 15px;">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio"
                                                                                        name="iyzipay_mode"
                                                                                        value="sandbox"
                                                                                        class="form-check-input"
                                                                                        {{ (isset($iyzipay_mode) && $iyzipay_mode == '') || (isset($iyzipay_mode) && $iyzipay_mode == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Sandbox') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="border card p-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-labe text-dark">
                                                                                    <input type="radio"
                                                                                        name="iyzipay_mode"
                                                                                        value="live"
                                                                                        class="form-check-input"
                                                                                        {{ isset($iyzipay_mode) && $iyzipay_mode == 'live' ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Live') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="iyzipay_private_key"
                                                                        class="col-form-label">{{ __('Private Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Private Key"
                                                                        name="iyzipay_private_key" type="text"
                                                                        value="{{ $iyzipay_private_key }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="iyzipay_secret_key"
                                                                        class="col-form-label">{{ __('Secret Key') }}</label>
                                                                    <input class="form-control" placeholder="Secret Key"
                                                                        name="iyzipay_secret_key" type="text"
                                                                        value="{{ $iyzipay_secret_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="iyzipay_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="iyzipay_image"
                                                                        id="iyzipay_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($iyzipay_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="iyzipay_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('iyzipay_unfo', $iyzipay_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'iyzipay_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PayFast -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="payfast">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_payfast"
                                                        aria-expanded="false" aria-controls="collapseone_payfast">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('PayFast') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_payfast" class="accordion-collapse collapse"
                                                    aria-labelledby="payfast" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                                <div class="col-lg-12">
                                                                    <label class="paypal-label col-form-label"
                                                                        for="payfast_mode">{{ __('PayFast Mode') }}</label>
                                                                    <br>
                                                                    <div class="d-flex flex-wrap">
                                                                        <div class="mr-2" style="margin-right: 15px;">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="payfast_mode"
                                                                                            value="sandbox"
                                                                                            class="form-check-input"
                                                                                            {{ !isset($payfast_mode) || $payfast_mode == '' || $payfast_mode == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Sandbox') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mr-2">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark">
                                                                                        <input type="radio"
                                                                                            name="payfast_mode"
                                                                                            value="live"
                                                                                            class="form-check-input"
                                                                                            {{ isset($payfast_mode) && $payfast_mode == 'live' ? 'checked="checked"' : '' }}>
                                                                                        {{ __('Live') }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_payfast_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_payfast_enabled', 'on', $is_payfast_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_payfast_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_payfast_enabled"></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="payfast_public_key"
                                                                        class="col-form-label">{{ __('Merchant ID') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Merchant ID"
                                                                        name="payfast_merchant_id" type="text"
                                                                        value="{{ $payfast_merchant_id }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="payfast_secret_key"
                                                                        class="col-form-label">{{ __('Merchant Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Merchant Key"
                                                                        name="payfast_merchant_key" type="text"
                                                                        value="{{ $payfast_merchant_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="payfast_salt_passphrase"
                                                                        class="col-form-label">{{ __('Salt Passphrase') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Salt Passphrase"
                                                                        name="payfast_salt_passphrase" type="text"
                                                                        value="{{ $payfast_salt_passphrase }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="payfast_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="payfast_image"
                                                                        id="payfast_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($payfast_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>

                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="payfast_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('payfast_unfo', $payfast_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'payfast_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Benefit -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="benefit">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_benefit"
                                                        aria-expanded="false" aria-controls="collapseone_benefit">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Benefit') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_benefit" class="accordion-collapse collapse"
                                                    aria-labelledby="benefit" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_benefit_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_benefit_enabled', 'on', $is_benefit_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_benefit_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_benefit_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="benefit_private_key"
                                                                        class="col-form-label">{{ __('Benefit Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Benefit Key"
                                                                        name="benefit_private_key" type="text"
                                                                        value="{{ $benefit_private_key }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="benefit_secret_key"
                                                                        class="col-form-label">{{ __('Benefit Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="En ter Benefit Secret Key"
                                                                        name="benefit_secret_key" type="text"
                                                                        value="{{ $benefit_secret_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="benefit_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="benefit_image"
                                                                        id="benefit_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($benefit_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="benefit_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('benefit_unfo', $benefit_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'benefit_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cashfree -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="cashfree">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_cashfree"
                                                        aria-expanded="false" aria-controls="collapseone_cashfree">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Cashfree') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_cashfree" class="accordion-collapse collapse"
                                                    aria-labelledby="cashfree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_cashfree_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_cashfree_enabled', 'on', $is_cashfree_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_cashfree_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_cashfree_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="cashfree_private_key"
                                                                        class="col-form-label">{{ __('Cashfree Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Cashfree Key"
                                                                        name="cashfree_key" type="text"
                                                                        value="{{ $cashfree_key }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cashfree_secret_key"
                                                                        class="col-form-label">{{ __('Cashfree Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Secret Key"
                                                                        name="cashfree_secret_key" type="text"
                                                                        value="{{ $cashfree_secret_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="cashfree_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="cashfree_image"
                                                                        id="cashfree_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($cashfree_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="cashfree_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('cashfree_unfo', $cashfree_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'cashfree_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Aamarpay -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="aamarpay">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_aamarpay"
                                                        aria-expanded="false" aria-controls="collapseone_aamarpay">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Aamarpay') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_aamarpay" class="accordion-collapse collapse"
                                                    aria-labelledby="aamarpay" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_aamarpay_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_aamarpay_enabled', 'on', $is_aamarpay_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_aamarpay_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_aamarpay_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="aamarpay_store_id"
                                                                        class="col-form-label">{{ __('Store Id') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Store Id"
                                                                        name="aamarpay_store_id" type="text"
                                                                        value="{{ $aamarpay_store_id }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="aamarpay_signature_key"
                                                                        class="col-form-label">{{ __('Signature Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Signature Key"
                                                                        name="aamarpay_signature_key" type="text"
                                                                        value="{{ $aamarpay_signature_key }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="aamarpay_description"
                                                                        class="col-form-label">{{ __('Aamarpay Description') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Aamarpay Description"
                                                                        name="aamarpay_description" type="text"
                                                                        value="{{ $aamarpay_description }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="aamarpay_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="aamarpay_image"
                                                                        id="aamarpay_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($aamarpay_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="aamarpay_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('aamarpay_unfo', $aamarpay_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'aamarpay_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Telegram -->
                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="telegram">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseone_telegram" aria-expanded="false"
                                                            aria-controls="collapseone_telegram">
                                                            <span class="d-flex align-items-center">
                                                                <i class="ti ti-credit-card me-2"></i>
                                                                {{ __('Telegram') }}</span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseone_telegram" class="accordion-collapse collapse"
                                                        aria-labelledby="telegram" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row mt-2">
                                                                <div class="col-md-6">
                                                                    <small class="">
                                                                        {{ __('Note') }}:
                                                                        {{ __('This detail will use for make checkout of product') }}.
                                                                    </small>
                                                                </div>
                                                                <div class="col-md-6 text-end">
                                                                    {!! Form::hidden('is_telegram_enabled', 'off') !!}
                                                                    <div class="form-check form-switch d-inline-block">
                                                                        {!! Form::checkbox('is_telegram_enabled', 'on', $is_telegram_enabled, [
                                                                            'class' => 'form-check-input',
                                                                            'id' => 'is_telegram_enabled',
                                                                        ]) !!}
                                                                        <label
                                                                            class="custom-control-label form-control-label"
                                                                            for="is_telegram_enabled"></label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <label for="telegram_access_token"
                                                                            class="form-label">{{ __('Telegram Access Token') }}</label>
                                                                        <input class="form-control"
                                                                            placeholder="1234567890:AAbbbbccccddddxvGENZCi8Hd4B15M8xHV0"
                                                                            name="telegram_access_token" type="text"
                                                                            value="{{ $telegram_access_token }}">
                                                                        <p>{{ __('Get Chat ID') }} :
                                                                            https://api.telegram.org/bot-TOKEN-/getUpdates
                                                                        </p>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="telegram_chat_id"
                                                                            class="form-label">{{ __('Telegram Chat Id') }}</label>
                                                                        <input class="form-control"
                                                                            placeholder="123456789"
                                                                            name="telegram_chat_id" type="text"
                                                                            value="{{ $telegram_chat_id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                        <label for="telegram_image"
                                                                            class="image-upload bg-primary pointer">
                                                                            <i class="ti ti-upload px-1"></i>
                                                                            {{ __('Choose file here') }}
                                                                        </label>
                                                                        <input type="file" name="telegram_image"
                                                                            id="telegram_image" class="d-none">

                                                                        <img alt="Image placeholder"
                                                                            src="{{ asset($telegram_image) }}"
                                                                            class="img-center img-fluid"
                                                                            style="max-height: 100px;">
                                                                    </div>
                                                                </div>
                                                                @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="telegram_unfo"
                                                                                class="form-label">{{ __('Description') }}</label>
                                                                            {!! Form::textarea('telegram_unfo', $telegram_unfo, [
                                                                                'class' => 'autogrow form-control',
                                                                                'rows' => '5',
                                                                                'id' => 'telegram_unfo',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Whatsapp -->
                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="whatsapp">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseone_whatsapp" aria-expanded="false"
                                                            aria-controls="collapseone_whatsapp">
                                                            <span class="d-flex align-items-center">
                                                                <i class="ti ti-credit-card me-2"></i>
                                                                {{ __('Whatsapp') }}</span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseone_whatsapp" class="accordion-collapse collapse"
                                                        aria-labelledby="whatsapp" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row mt-2">
                                                                <div class="col-md-6">
                                                                    <small class="">
                                                                        {{ __('Note') }}:
                                                                        {{ __('This detail will use for make checkout of product') }}.
                                                                    </small>
                                                                </div>
                                                                <div class="col-md-6 text-end">
                                                                    {!! Form::hidden('is_whatsapp_enabled', 'off') !!}
                                                                    <div class="form-check form-switch d-inline-block">
                                                                        {!! Form::checkbox('is_whatsapp_enabled', 'on', $is_whatsapp_enabled, [
                                                                            'class' => 'form-check-input',
                                                                            'id' => 'is_whatsapp_enabled',
                                                                        ]) !!}
                                                                        <label
                                                                            class="custom-control-label form-control-label"
                                                                            for="is_whatsapp_enabled"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <input type="text" name="whatsapp_number"
                                                                            id="whatsapp_number"
                                                                            class="form-control input-mask"
                                                                            data-mask="+00 00000000000"
                                                                            value="{{ $whatsapp_number }}"
                                                                            placeholder="+00 00000000000" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                        <label for="whatsapp_image"
                                                                            class="image-upload bg-primary pointer">
                                                                            <i class="ti ti-upload px-1"></i>
                                                                            {{ __('Choose file here') }}
                                                                        </label>
                                                                        <input type="file" name="whatsapp_image"
                                                                            id="whatsapp_image" class="d-none">

                                                                        <img alt="Image placeholder"
                                                                            src="{{ asset($whatsapp_image) }}"
                                                                            class="img-center img-fluid"
                                                                            style="max-height: 100px;">
                                                                    </div>
                                                                </div>
                                                                @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="whatsapp_unfo"
                                                                                class="form-label">{{ __('Description') }}</label>
                                                                            {!! Form::textarea('whatsapp_unfo', $whatsapp_unfo, [
                                                                                'class' => 'autogrow form-control',
                                                                                'rows' => '5',
                                                                                'id' => 'whatsapp_unfo',
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- PayTR -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="paytr">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_paytr"
                                                        aria-expanded="false" aria-controls="collapseone_paytr">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Pay TR') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_paytr" class="accordion-collapse collapse"
                                                    aria-labelledby="paytr" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_paytr_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_paytr_enabled', 'on', $is_paytr_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_paytr_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paytr_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="paytr_merchant_id"
                                                                        class="col-form-label">{{ __('Merchant Id') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Merchant Id"
                                                                        name="paytr_merchant_id" type="text"
                                                                        value="{{ $paytr_merchant_id }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="paytr_merchant_key"
                                                                        class="col-form-label">{{ __('Merchant Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Merchant Key"
                                                                        name="paytr_merchant_key" type="text"
                                                                        value="{{ $paytr_merchant_key }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="paytr_salt_key"
                                                                        class="col-form-label">{{ __('Salt Passphrase') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Salt Passphrase"
                                                                        name="paytr_salt_key" type="text"
                                                                        value="{{ $paytr_salt_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="paytr_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="paytr_image"
                                                                        id="paytr_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($paytr_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="paytr_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('paytr_unfo', $paytr_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'paytr_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Yookassa -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="yookassa">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_yookassa"
                                                        aria-expanded="false" aria-controls="collapseone_yookassa">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('yookassa') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_yookassa" class="accordion-collapse collapse"
                                                    aria-labelledby="yookassa" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_yookassa_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_yookassa_enabled', 'on', $is_yookassa_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_yookassa_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_yookassa_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="yookassa_shop_id_key"
                                                                        class="col-form-label">{{ __('Shop Id Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Shop Id Key"
                                                                        name="yookassa_shop_id_key" type="text"
                                                                        value="{{ $yookassa_shop_id_key }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="yookassa_secret_key"
                                                                        class="col-form-label">{{ __('Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter secret Key"
                                                                        name="yookassa_secret_key" type="text"
                                                                        value="{{ $yookassa_secret_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="yookassa_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="yookassa_image"
                                                                        id="yookassa_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($yookassa_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="yookassa_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('yookassa_unfo', $yookassa_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'yookassa_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Xendit -->
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="Xendit">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_Xendit"
                                                        aria-expanded="false" aria-controls="collapseone_Xendit">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Xendit') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_Xendit" class="accordion-collapse collapse"
                                                    aria-labelledby="Xendit" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_Xendit_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_Xendit_enabled', 'on', $is_Xendit_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_Xendit_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_Xendit_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="Xendit_api_key"
                                                                        class="col-form-label">{{ __('Xendit Api key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Api Key"
                                                                        name="Xendit_api_key" type="text"
                                                                        value="{{ $Xendit_api_key }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Xendit_secret_key"
                                                                        class="col-form-label">{{ __('Token') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter Token Key"
                                                                        name="Xendit_token_key" type="text"
                                                                        value="{{ $Xendit_token_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="Xendit_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="Xendit_image"
                                                                        id="Xendit_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($Xendit_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="Xendit_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('Xendit_unfo', $Xendit_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'Xendit_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Midtrans --}}
                                            <div class="accordion-item card">
                                                <h2 class="accordion-header" id="midtrans">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseone_midtrans"
                                                        aria-expanded="false" aria-controls="collapseone_midtrans">
                                                        <span class="d-flex align-items-center">
                                                            <i class="ti ti-credit-card me-2"></i>
                                                            {{ __('Midtrans') }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapseone_midtrans" class="accordion-collapse collapse"
                                                    aria-labelledby="midtrans" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <small class="">
                                                                    {{ __('Note') }}:
                                                                    {{ __('This detail will use for make checkout of product') }}.
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                {!! Form::hidden('is_midtrans_enabled', 'off') !!}
                                                                <div class="form-check form-switch d-inline-block">
                                                                    {!! Form::checkbox('is_midtrans_enabled', 'on', $is_midtrans_enabled, [
                                                                        'class' => 'form-check-input',
                                                                        'id' => 'is_midtrans_enabled',
                                                                    ]) !!}
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_midtrans_enabled"></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="midtrans_secret_key"
                                                                        class="col-form-label">{{ __('Secret Key') }}</label>
                                                                    <input class="form-control"
                                                                        placeholder="Enter secret Key"
                                                                        name="midtrans_secret_key" type="text"
                                                                        value="{{ $midtrans_secret_key }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    {!! Form::label('', __('Image'), ['class' => 'form-label']) !!}
                                                                    <label for="midtrans_image"
                                                                        class="image-upload bg-primary pointer">
                                                                        <i class="ti ti-upload px-1"></i>
                                                                        {{ __('Choose file here') }}
                                                                    </label>
                                                                    <input type="file" name="midtrans_image"
                                                                        id="midtrans_image" class="d-none">

                                                                    <img alt="Image placeholder"
                                                                        src="{{ asset($midtrans_image) }}"
                                                                        class="img-center img-fluid"
                                                                        style="max-height: 100px;">
                                                                </div>
                                                            </div>
                                                            @if (\Auth::guard('admin')->user()->type == 'admin')
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="midtrans_unfo"
                                                                            class="form-label">{{ __('Description') }}</label>
                                                                        {!! Form::textarea('midtrans_unfo', $midtrans_unfo, [
                                                                            'class' => 'autogrow form-control',
                                                                            'rows' => '5',
                                                                            'id' => 'midtrans_unfo',
                                                                        ]) !!}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <input type="submit" value="{{ __('Save Changes') }}"
                                    class="btn-submit btn btn-primary">
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>



            @if (\Auth::guard('admin')->user()->type == 'superadmin')
                <div id="Storage_Setting">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=""> {{ __('Storage Settings') }} </h5>
                        </div>
                        <div class="card-body p-4">
                            {{ Form::model($settings, ['route' => 'admin.storage.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="d-flex">
                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting"
                                        id="local-outlined" autocomplete="off"
                                        {{ $storage_setting == 'local' ? 'checked' : '' }} value="local" checked>
                                    <label class="btn btn-outline-primary"
                                        for="local-outlined">{{ __('Local') }}</label>
                                </div>

                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="s3-outlined"
                                        autocomplete="off" {{ $storage_setting == 's3' ? 'checked' : '' }}
                                        value="s3">
                                    <label class="btn btn-outline-primary" for="s3-outlined">
                                        {{ __('AWS S3') }}</label>
                                </div>

                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting"
                                        id="wasabi-outlined" autocomplete="off"
                                        {{ $storage_setting == 'wasabi' ? 'checked' : '' }} value="wasabi">
                                    <label class="btn btn-outline-primary"
                                        for="wasabi-outlined">{{ __('Wasabi') }}</label>
                                </div>
                            </div>

                            <div class="mt-2">
                                {{-- local setting --}}
                                <div class="local-setting row {{ $storage_setting == 'local' ? ' ' : 'd-none' }}">
                                    <div class="form-group col-8 switch-width">
                                        {{ Form::label('local_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                        <select name="local_storage_validation[]" class="select2"
                                            data-role="tagsinput" id="local_storage_validation" multiple>
                                            @foreach ($file_type as $f)
                                                <option @if (in_array($f, $local_storage_validations)) selected @endif>
                                                    {{ $f }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="local_storage_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                            <input type="number" name="local_storage_max_upload_size"
                                                class="form-control"
                                                value="{{ !isset($local_storage_max_upload_size) || is_null($local_storage_max_upload_size) ? '' : $local_storage_max_upload_size }}"
                                                placeholder="{{ __('Max upload size') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- S3 setting --}}

                                <div class="s3-setting row {{ $storage_setting == 's3' ? ' ' : 'd-none' }}">
                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_key">{{ __('S3 Key') }}</label>
                                                <input type="text" name="s3_key" class="form-control"
                                                    value="{{ !isset($settings['s3_key']) || is_null($settings['s3_key']) ? '' : $settings['s3_key'] }}"
                                                    placeholder="{{ __('S3 Key') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_secret">{{ __('S3 Secret') }}</label>
                                                <input type="text" name="s3_secret" class="form-control"
                                                    value="{{ !isset($settings['s3_secret']) || is_null($settings['s3_secret']) ? '' : $settings['s3_secret'] }}"
                                                    placeholder="{{ __('S3 Secret') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_region">{{ __('S3 Region') }}</label>
                                                <input type="text" name="s3_region" class="form-control"
                                                    value="{{ !isset($settings['s3_region']) || is_null($settings['s3_region']) ? '' : $settings['s3_region'] }}"
                                                    placeholder="{{ __('S3 Region') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_bucket">{{ __('S3 Bucket') }}</label>
                                                <input type="text" name="s3_bucket" class="form-control"
                                                    value="{{ !isset($settings['s3_bucket']) || is_null($settings['s3_bucket']) ? '' : $settings['s3_bucket'] }}"
                                                    placeholder="{{ __('S3 Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_url">{{ __('S3 URL') }}</label>
                                                <input type="text" name="s3_url" class="form-control"
                                                    value="{{ !isset($settings['s3_url']) || is_null($settings['s3_url']) ? '' : $settings['s3_url'] }}"
                                                    placeholder="{{ __('S3 URL') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_endpoint">{{ __('S3 Endpoint') }}</label>
                                                <input type="text" name="s3_endpoint" class="form-control"
                                                    value="{{ !isset($settings['s3_endpoint']) || is_null($settings['s3_endpoint']) ? '' : $settings['s3_endpoint'] }}"
                                                    placeholder="{{ __('S3 Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            {{ Form::label('s3_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                            <select name="s3_storage_validation[]" class="select2"
                                                data-role="tagsinput" id="s3_storage_validation" multiple>
                                                @foreach ($file_type as $f)
                                                    <option @if (in_array($f, $s3_storage_validations)) selected @endif>
                                                        {{ $f }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                                <input type="number" name="s3_max_upload_size" class="form-control"
                                                    value="{{ !isset($s3_max_upload_size) || is_null($s3_max_upload_size) ? '' : $s3_max_upload_size }}"
                                                    placeholder="{{ __('Max upload size') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- wasabi setting --}}

                                <div class="wasabi-setting row {{ $storage_setting == 'wasabi' ? ' ' : 'd-none' }}">
                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_key">{{ __('Wasabi Key') }}</label>
                                                <input type="text" name="wasabi_key" class="form-control"
                                                    value="{{ !isset($settings['wasabi_key']) || is_null($settings['wasabi_key']) ? '' : $settings['wasabi_key'] }}"
                                                    placeholder="{{ __('Wasabi Key') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_secret">{{ __('Wasabi Secret') }}</label>
                                                <input type="text" name="wasabi_secret" class="form-control"
                                                    value="{{ !isset($settings['wasabi_secret']) || is_null($settings['wasabi_secret']) ? '' : $settings['wasabi_secret'] }}"
                                                    placeholder="{{ __('Wasabi Secret') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_region">{{ __('Wasabi Region') }}</label>
                                                <input type="text" name="wasabi_region" class="form-control"
                                                    value="{{ !isset($settings['wasabi_region']) || is_null($settings['wasabi_region']) ? '' : $settings['wasabi_region'] }}"
                                                    placeholder="{{ __('Wasabi Region') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_bucket">{{ __('Wasabi Bucket') }}</label>
                                                <input type="text" name="wasabi_bucket" class="form-control"
                                                    value="{{ !isset($settings['wasabi_bucket']) || is_null($settings['wasabi_bucket']) ? '' : $settings['wasabi_bucket'] }}"
                                                    placeholder="{{ __('Wasabi Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_url">{{ __('Wasabi URL') }}</label>
                                                <input type="text" name="wasabi_url" class="form-control"
                                                    value="{{ !isset($settings['wasabi_url']) || is_null($settings['wasabi_url']) ? '' : $settings['wasabi_url'] }}"
                                                    placeholder="{{ __('Wasabi URL') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root">{{ __('Wasabi Root') }}</label>
                                                <input type="text" name="wasabi_root" class="form-control"
                                                    value="{{ !isset($settings['wasabi_root']) || is_null($settings['wasabi_root']) ? '' : $settings['wasabi_root'] }}"
                                                    placeholder="{{ __('Wasabi Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            {{ Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => 'form-label']) }}

                                            <select name="wasabi_storage_validation[]" class="select2"
                                                data-role="tagsinput" id="wasabi_storage_validation" multiple>
                                                @foreach ($file_type as $f)
                                                    <option @if (in_array($f, $wasabi_storage_validations)) selected @endif>
                                                        {{ $f }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root">{{ __('Max upload size ( In KB)') }}</label>
                                                <input type="number" name="wasabi_max_upload_size"
                                                    class="form-control"
                                                    value="{{ !isset($wasabi_max_upload_size) || is_null($wasabi_max_upload_size) ? '' : $wasabi_max_upload_size }}"
                                                    placeholder="{{ __('Max upload size') }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12 text-end">
                                <input type="submit" value="{{ __('Save Changes') }}"
                                    class="btn-submit btn btn-primary">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="card" id="Cookie_Setting">
                    {{ Form::model($settings, ['route' => 'admin.cookie.setting', 'method' => 'post']) }}
                    <div
                        class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                        <h5>{{ __('Cookie Settings') }}</h5>

                        <div class="d-flex align-items-center gap-5">
                            @if (!empty($superadmin_setting['chatgpt_key']))
                                <div class="d-flex justify-content-end">
                                    <a href="javascript:void(0)" class="btn btn-primary me-2" data-size="lg"
                                        data-ajax-popup-over="true"
                                        data-url="{{ route('admin.generate', ['cookie']) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ __('Generate') }}"
                                        data-title="{{ __('Generate Content With AI') }}">
                                        <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
                                    </a>
                                </div>
                            @endif

                            <div class="d-flex align-items-center">
                                {{ Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3']) }}
                                <div class="custom-control custom-switch" onclick="enablecookie()">
                                    <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                        name="enable_cookie" class="form-check-input input-primary "
                                        id="enable_cookie" {{ $settings['enable_cookie'] == 'on' ? ' checked ' : '' }}>
                                    <label class="custom-control-label mb-1" for="enable_cookie"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body cookieDiv {{ $settings['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class=" form-switch custom-switch-v1" id="cookie_log">
                                    <input type="checkbox" name="cookie_logging"
                                        class="form-check-input input-primary cookie_setting" id="cookie_logging"
                                        {{ $settings['cookie_logging'] == 'on' ? ' checked ' : '' }}>
                                    <label class="form-check-label"
                                        for="cookie_logging">{{ __('Enable logging') }}</label>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                                <div class="form-group ">
                                    {{ Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label']) }}
                                    {!! Form::textarea('cookie_description', null, ['class' => 'form-control cookie_setting', 'rows' => '3']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" form-switch custom-switch-v1 ">
                                    <input type="checkbox" name="necessary_cookies"
                                        class="form-check-input input-primary" id="necessary_cookies" checked
                                        onclick="return false">
                                    <label class="form-check-label"
                                        for="necessary_cookies">{{ __('Strictly necessary cookies') }}</label>
                                </div>
                                <div class="form-group ">
                                    {{ Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('strictly_cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                                <div class="form-group ">
                                    {{ Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label']) }}
                                    {!! Form::textarea('strictly_cookie_description', null, [
                                        'class' => 'form-control cookie_setting ',
                                        'rows' => '3',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-12">
                                <h5>{{ __('More Information') }}</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    {{ Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('more_information_description', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    {{ Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label']) }}
                                    {{ Form::text('contactus_url', null, ['class' => 'form-control cookie_setting']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="card-footer d-flex align-items-center gap-2 flex-sm-column flex-lg-row justify-content-between">
                        <div>
                            @if (isset($settings['cookie_logging']) && $settings['cookie_logging'] == 'on')
                                @if (Storage::exists('uploads/sample/cookie_data.csv'))
                                    <label for="file"
                                        class="form-label">{{ __('Download cookie accepted data') }}</label>
                                    <a href="{{ asset(Storage::url('uploads/sample/cookie_data.csv')) }}"
                                        class="btn btn-primary mr-2 ">
                                        <i class="ti ti-download"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                        <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                    </div>
                    {{ Form::close() }}
                </div>

                <div id="chatgpt_Setting">
                    <div class="card">
                        {{ Form::model($settings, ['route' => 'admin.chatgpt.setting', 'method' => 'post']) }}
                        <div class="card-header">
                            <div class="row g-0">
                                <div class="col-6">
                                    <h5> {{ __('Chat GPT Key Settings') }} </h5>
                                    <small>{{ __('Edit your key details') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row g-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        {{ Form::text('chatgpt_key', null, ['class' => 'form-control', 'placeholder' => __('Enter Chatgpt Key Here')]) }}
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <input type="submit" value="{{ __('Save Changes') }}"
                                            class="btn-submit btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="col-md-12" id="ReCaptcha_Setting">
                    <form method="POST" action="{{ route('admin.recaptcha.settings.store') }}"
                        accept-charset="UTF-8">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <div class="row gy-2">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <h5 class="">{{ __('ReCaptcha Settings') }}</h5><small
                                            class="text-secondary font-weight-bold"><a
                                                href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                                target="_blank" class="text-blue">
                                                <small>({{ __('How to Get Google reCaptcha Site and Secret key') }})</small>
                                            </a></small>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 text-sm-end">
                                        <div class="col switch-width">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-toggle="switchbutton"
                                                    data-onstyle="primary" class="" value="yes"
                                                    name="recaptcha_module" id="recaptcha_module"
                                                    {{ !empty(env('RECAPTCHA_MODULE')) && env('RECAPTCHA_MODULE') == 'yes' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label px-2"
                                                    for="recaptcha_module "></label><br>
                                                <a href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                                    target="_blank" class="text-blue">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                        <label for="google_recaptcha_key"
                                            class="form-label">{{ __('Google Recaptcha Key') }}</label>
                                        <input class="form-control"
                                            placeholder="{{ __('Enter Google Recaptcha Key') }}"
                                            name="google_recaptcha_key" type="text"
                                            value="{{ env('NOCAPTCHA_SITEKEY') }}" id="google_recaptcha_key">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                        <label for="google_recaptcha_secret"
                                            class="form-label">{{ __('Google Recaptcha Secret') }}</label>
                                        <input class="form-control "
                                            placeholder="{{ __('Enter Google Recaptcha Secret') }}"
                                            name="google_recaptcha_secret" type="text"
                                            value="{{ env('NOCAPTCHA_SECRET') }}" id="google_recaptcha_secret">
                                    </div>
                                </div>
                                <div class="card-footer p-0">
                                    <div class="col-sm-12 mt-3 px-2">
                                        <div class="text-end">
                                            {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="Cache_Settings">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="h6 md-0">{{ __('Cache Settings') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p>{{ __('This is a page meant for more advanced users, simply ignore it if you do not
                                                                                                                                                                                                                                                                                                                                                    understand what cache is.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="input-group search-form">
                                        <input type="text" value="{{ \App\Models\Utility::GetCacheSize() }}"
                                            class="form-control" disabled>
                                        <span class="input-group-text bg-transparent">{{ __('MB') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url('admin/config-cache') }}"
                                class="btn btn-m btn-primary m-r-10 ">{{ __('Clear Cache') }}</a>
                        </div>
                    </div>
                </div>

                <div id="style_customize">
                    <div class="card mb-3">
                        <form method="POST" action="{{ route('admin.customize.settings') }}"
                            accept-charset="UTF-8">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="h6 md-0">{{ __('Style Customize') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        {{ Form::label('storecss', __('Style Customize'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('storecss', isset($superadmin_setting['storecss']) ? $superadmin_setting['storecss'] : '', ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Custom CSS')]) }}
                                        @error('storecss')
                                            <span class="invalid-about" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                            </div>
                    </div>
                </div>

                <div id="location-list" class="card shadow-none rounded-0">
                    <div class="col-md-12 border-bottom">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="mt-2">{{ __('Country Settings') }}</h5>
                                    </div>

                                    <div class="col-6 text-end ">
                                        <div class="">
                                            <a class="btn btn-sm btn-icon  btn-primary me-2 text-white"
                                                data-url="{{ route('admin.country.create') }}"
                                                data-title="{{ __('Add Country') }}" data-ajax-popup="true"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Add Country') }}">
                                                <i data-feather="plus"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-3 g-0">
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table mb-0 dataTable-5 ">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Name') }}</th>

                                                    <th class="text-end">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($countries as $country)
                                                    <tr>
                                                        <td>{{ $country->name }}</td>
                                                        <td class="text-end">
                                                            <button class="btn btn-sm btn-primary me-2"
                                                                data-url="{{ route('admin.country.edit', $country->id) }}"
                                                                data-size="md" data-ajax-popup="true"
                                                                data-title="{{ __('Edit Country') }}">
                                                                <i class="ti ti-pencil py-1" data-bs-toggle="tooltip"
                                                                    title="edit"></i>
                                                            </button>

                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['admin.country.destroy', $country->id],
                                                                'class' => 'd-inline',
                                                            ]) !!}
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger show_confirm">
                                                                <i class="ti ti-trash text-white py-1"
                                                                    data-bs-toggle="tooltip" title="Delete"></i>
                                                            </button>
                                                            {!! Form::close() !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 border-bottom card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="mt-2">{{ __('State Settings') }}</h5>
                                </div>

                                <div class="col-6 text-end row">
                                    <form method="GET" action="{{ route('admin.setting.index') }}"
                                        accept-charset="UTF-8" id="customer_submit"> @csrf
                                        @csrf
                                        <div class=" d-flex align-items-center justify-content-end">

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 me-2">
                                                <div class="btn-box">

                                                    {{ Form::label('country', __('Country: '), ['class' => 'col-form-label mr-2']) }}
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                                <div class="btn-box">
                                                    <select class="form-control" id="country" name="country">
                                                        <option value="" disabled selected>
                                                            {{ __('Select Country') }}</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                                <a class="btn btn-sm btn-icon  btn-primary me-2 text-white"
                                                    data-url="{{ route('admin.state.create') }}"
                                                    data-title="{{ __('Add State') }}" data-ajax-popup="true"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Add State') }}">
                                                    <i data-feather="plus"></i>
                                                </a>

                                            </div>

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table mb-0  dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('country') }}</th>


                                            <th class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-style">
                                        @foreach ($states as $stat)
                                            <tr>
                                                <td>{{ ucwords($stat['name']) }}</td>
                                                <td>{{ $stat->country->name }}</td>

                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-primary me-2"
                                                        data-url="{{ route('admin.state.edit', $stat['id']) }}"
                                                        data-size="md" data-ajax-popup="true"
                                                        data-title="{{ __('Edit State') }}">
                                                        <i class="ti ti-pencil py-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="edit"></i>
                                                    </button>

                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['admin.state.destroy', $stat['id']],
                                                        'class' => 'd-inline',
                                                    ]) !!}
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                        <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip"
                                                            title="Delete"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 border-bottom card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="mt-2">{{ __('City Settings') }}</h5>
                                </div>

                                <div class="col-6 text-end row">

                                    <form method="GET" action="{{ route('admin.setting.index') }}"
                                        accept-charset="UTF-8" id="state_filter_submit"> @csrf
                                        <div class=" d-flex align-items-center justify-content-end">

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 me-2">
                                                <div class="btn-box">

                                                    {{ Form::label('city', __('State: '), ['class' => 'col-form-label mr-2']) }}
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                                <div class="btn-box">
                                                    <select class="form-control" id="state_filter" name="state_id">
                                                        <option value="" disabled selected>
                                                            {{ __('Select State') }}</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">

                                                <a href="#location-list" class="btn btn-sm btn-primary"
                                                    data-ajax-popup="true" data-size="md"
                                                    data-title="{{ __('Add City') }}"
                                                    data-url="{{ route('admin.city.create') }}" data-toggle="tooltip"
                                                    title="{{ __('Create') }}"
                                                    data-bs-original-title="{{ __('Create New City') }}"
                                                    data-bs-placement="top" data-bs-toggle="tooltip">
                                                    <span>{{ __('Add') }} </span><i class="ti ti-plus "></i>
                                                </a>
                                            </div>

                                        </div>
                                    </form>


                                </div>

                            </div>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table dataTable-6">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('state') }}</th>
                                            <th class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-style">
                                        @foreach ($cities as $cit)
                                            <tr>
                                                <td>{{ $cit->name }}</td>
                                                <td>{{ $cit->state->name }}</td>


                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-primary me-2"
                                                        data-url="{{ route('admin.city.edit', $cit['id']) }}"
                                                        data-size="md" data-ajax-popup="true"
                                                        data-title="{{ __('Edit City') }}">
                                                        <i class="ti ti-pencil py-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="edit"></i>
                                                    </button>

                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['admin.city.destroy', $cit['id']],
                                                        'class' => 'd-inline',
                                                    ]) !!}
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                        <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip"
                                                            title="Delete"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div id="Stock_Setting">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="">
                                    {{ __('Stock Settings') }}
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                {{ Form::model($settings, ['route' => 'admin.stock.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        {{ Form::label('low_stock_threshold', __('Low Stock Threshold'), ['class' => 'form-label']) }}
                                        {{ Form::number('low_stock_threshold', null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{ Form::label('out_of_stock_threshold', __('Out of Stock Threshold'), ['class' => 'form-label']) }}
                                        {{ Form::number('out_of_stock_threshold', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="row">
                                    @if (\Auth::guard('admin')->user()->type == 'admin')
                                        <div class="form-group col-md-6">
                                            <div class="custom-control form-switch p-0">
                                                <label class="form-check-label form-label"
                                                    for="stock_management">{{ __(' Enable Stock Management') }}</label><br>
                                                <input type="checkbox" class="form-check-input"
                                                    data-toggle="switchbutton" data-onstyle="primary"
                                                    name="stock_management" id="stock_management"
                                                    {{ isset($settings['stock_management']) && $settings['stock_management'] == 'on' ? 'checked="checked"' : '' }}>
                                            </div>
                                        </div>
                                    @endif
                                    @if (\Auth::guard('admin')->user()->type == 'admin')
                                        <div class="form-group col-md-6">
                                            {{ Form::label('notifications', __('Notifications'), ['class' => 'form-label']) }}
                                            <div class="form-group row">
                                                <div class="col-9">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="enable_low_stock" id="low_stock"
                                                            name="notification[]"
                                                            {{ in_array('enable_low_stock', $notifications) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="low_stock">
                                                            {{ __('Low stock notifications') }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="enable_out_of_stock" id="out_of_stock"
                                                            name="notification[]"
                                                            {{ in_array('enable_out_of_stock', $notifications) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="out_of_stock">
                                                            {{ __('Out of stock notifications') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
            @endif
            <div class="col-lg-12">
                <div class="text-end">
                    <div class="card-footer">
                        <div class="col-sm-12 px-2">
                            <div class="d-flex justify-content-end">
                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    </div>
    </div>
    <div id="Refund_Setting">
        <div class="card">
            {{ Form::open(['route' => 'admin.refund.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="card-header d-flex justify-content-between">
                <h5>{{ __('Refund Settings') }} </h5>
            </div>
            @php
                $order_refunds = App\Models\OrderRefundSetting::where('theme_id', $theme_name)
                    ->where('store_id', getCurrentStore())
                    ->get();
            @endphp
            <div class="card-body p-4">
                <div class="row">
                    @foreach ($order_refunds as $order_refund)
                        <div class="col-lg-4 col-md-6 col-sm-6 form-group">
                            <div class="list-group">
                                <div class="list-group-item form-switch form-switch-right">
                                    <label class="form-label"
                                        style="margin-left:5%;">{{ $order_refund->name }}</label>
                                    <input type="hidden" name="{{ $order_refund->id }}" value="0">
                                    <!-- Add this hidden field -->
                                    <input type="checkbox" class="form-check-input" id="{{ $order_refund->name }}"
                                        name="{{ $order_refund->id }}"
                                        @if ($order_refund->is_active == 1) checked="checked" @endif type="checkbox"
                                        value="1"
                                        data-url="{{ route('admin.refund.settings', [$order_refund->id]) }}" />
                                    <label class="form-check-label f-w-600 pl-1"
                                        for="{{ $order_refund->name }}"></label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-12 text-end">
                    <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit btn btn-primary">
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div id="Loyality_program">
        <div class="card">
            {{ Form::open(['route' => 'admin.loyality.program.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="card-header d-flex justify-content-between ">
                <h5 class=""> {{ __('Loyality Program') }} </h5>
                {!! Form::hidden('loyality_program_enabled', 'off') !!}
                <div class="form-check form-switch d-inline-block">
                    {!! Form::checkbox('loyality_program_enabled', 'on', $loyality_program_enabled, [
                        'class' => 'form-check-input',
                        'id' => 'loyality_program_enabled',
                    ]) !!}
                    <label class="custom-control-label form-control-label" for="loyality_program_enabled"></label>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-4 form-group">
                        {!! Form::label('', __('Reward points on orders of ' . $CURRENCY . '1000'), ['class' => 'form-label']) !!}
                        {!! Form::number('reward_point', $reward_point, [
                            'class' => 'form-control',
                            'placeholder' => 'Enter Point',
                            'step' => 0.01,
                        ]) !!}
                    </div>
                    <div class="col-lg-12 text-end">
                        <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit btn btn-primary">
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div id="Pixel_Setting">
        <div class="card">
            <div class="card-header">
                <div class="row g-0">
                    <div class="col-6">
                        <h5> {{ __('Pixel Fields Settings') }} </h5>
                        <small>{{ __('Enter Your Pixel Fields Settings') }}</small>
                    </div>
                    <div class="col-6 text-end">
                        <a href="javascript:;" class="btn btn-sm btn-icon btn-primary me-2" data-ajax-popup="true"
                            data-url="{{ route('admin.pixel-setting.create') }}" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="{{ __('Create') }}"
                            data-title="{{ __('Create New Pixel') }}">
                            <i data-feather="plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row g-0">
                    <div class="card-body table-border-style">
                        <div class="datatable-container">
                            <div class="table-responsive custom-field-table">
                                <table class="table dataTable-table" id="pc-dt-simple" data-repeater-list="fields">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ __('Platform') }}</th>
                                            <th>{{ __('Pixel Id') }}</th>
                                            <th class="text-right" style="width: 200px;">
                                                {{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($PixelFields as $PixelField)
                                            <tr>
                                                <td class="text-capitalize">
                                                    {{ $PixelField->platform }}
                                                </td>
                                                <td>
                                                    {{ $PixelField->pixel_id }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['admin.pixel-setting.destroy', $PixelField->id],
                                                            'class' => 'd-inline',
                                                        ]) !!}
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger show_confirm">
                                                            <i class="ti ti-trash text-white py-1"
                                                                data-bs-toggle="tooltip" title="Delete"></i>
                                                        </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($plan->pwa_store == 'on')
        <div id="Pwa_Setting">
            <div class="card">
                {{ Form::model($store_settings, ['route' => ['admin.setting.pwa', $store_settings['id']], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                <div class="card-header">
                    <div class="row ">
                        <div class="col-6">
                            <h5>{{ __('PWA Settings') }}</h5>
                            <small></small>
                        </div>
                        <div class="col-6 text-end">
                            <div class="custom-control form-switch ps-0">
                                <input type="checkbox" class="form-check-input enable_pwa_store" name="pwa_store"
                                    id="pwa_store"
                                    {{ $store_settings['enable_pwa_store'] == 'on' ? 'checked=checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-6 pwa_is_enable">
                            {{ Form::label('pwa_app_title', __('App Title'), ['class' => 'form-label']) }}
                            {{ Form::text('pwa_app_title', !empty($pwa_data->name) ? $pwa_data->name : '', ['class' => 'form-control', 'placeholder' => __('App Title')]) }}
                        </div>

                        <div class="form-group col-md-6 pwa_is_enable">
                            {{ Form::label('pwa_app_name', __('App Name'), ['class' => 'form-label']) }}
                            {{ Form::text('pwa_app_name', !empty($pwa_data->short_name) ? $pwa_data->short_name : '', ['class' => 'form-control', 'placeholder' => __('App Name')]) }}
                        </div>

                        <div class="form-group col-md-6 pwa_is_enable">
                            {{ Form::label('pwa_app_background_color', __('App Background Color'), ['class' => 'form-label']) }}
                            {{ Form::color('pwa_app_background_color', !empty($pwa_data->background_color) ? $pwa_data->background_color : '', ['class' => 'form-control color-picker', 'placeholder' => __('18761234567')]) }}
                        </div>

                        <div class="form-group col-md-6 pwa_is_enable">
                            {{ Form::label('pwa_app_theme_color', __('App Theme Color'), ['class' => 'form-label']) }}
                            {{ Form::color('pwa_app_theme_color', !empty($pwa_data->theme_color) ? $pwa_data->theme_color : '', ['class' => 'form-control color-picker', 'placeholder' => __('18761234567')]) }}
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    @endif

    <div id="Woocommerce_Setting">
        <div class="card">
            {{ Form::open(['route' => 'admin.woocommerce.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="card-header d-flex justify-content-between ">
                <h5 class=""> {{ __('Woocommerce Settings') }} </h5>
                {!! Form::hidden('woocommerce_setting_enabled', 'off') !!}
                <div class="form-check form-switch d-inline-block">
                    {!! Form::checkbox('woocommerce_setting_enabled', 'on', $woocommerce_setting_enabled, [
                        'class' => 'form-check-input',
                        'id' => 'woocommerce_setting_enabled',
                    ]) !!}
                    <label class="custom-control-label form-control-label" for="woocommerce_setting_enabled"></label>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-12 form-group">
                        {!! Form::label('woocommerce_store_url', __('Store Url'), ['class' => 'form-label']) !!}
                        {!! Form::text('woocommerce_store_url', !empty($woocommerce_store_url) ? $woocommerce_store_url : '', [
                            'class' => 'form-control',
                            'placeholder' => 'Woocommerce store url',
                        ]) !!}
                    </div>
                    <div class="col-lg-12 form-group">
                        {!! Form::label('woocommerce_consumer_key', __('Consumer Key'), ['class' => 'form-label']) !!}
                        {!! Form::text('woocommerce_consumer_key', !empty($woocommerce_consumer_key) ? $woocommerce_consumer_key : '', [
                            'class' => 'form-control',
                            'placeholder' => 'Woocommerce consumer key',
                        ]) !!}
                    </div>
                    <div class="col-lg-12 form-group">
                        {!! Form::label('woocommerce_consumer_secret', __('Consumer Secret'), ['class' => 'form-label']) !!}
                        {!! Form::text(
                            'woocommerce_consumer_secret',
                            !empty($woocommerce_consumer_secret) ? $woocommerce_consumer_secret : '',
                            ['class' => 'form-control', 'placeholder' => 'Woocommerce consumer secret'],
                        ) !!}
                    </div>

                    <div class="col-lg-12 text-end">
                        <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit btn btn-primary">
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div id="shopify_Setting">
        <div class="card">
            {{ Form::open(['route' => 'admin.shopify.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="card-header d-flex justify-content-between ">
                <h5 class=""> {{ __('Shopify Settings') }} </h5>
                {!! Form::hidden('shopify_setting_enabled', 'off') !!}
                <div class="form-check form-switch d-inline-block">
                    {!! Form::checkbox('shopify_setting_enabled', 'on', $shopify_setting_enabled, [
                        'class' => 'form-check-input',
                        'id' => 'shopify_setting_enabled',
                    ]) !!}
                    <label class="custom-control-label form-control-label" for="shopify_setting_enabled"></label>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="form-group col-md-12">
                        {{ Form::label('shopify_store_url', __('Shopify store url'), ['class' => 'form-label']) }}
                        <div class="input-group">
                            {{ Form::text('shopify_store_url', !empty($shopify_store_url) ? $shopify_store_url : '', ['class' => 'form-control', 'placeholder' => __('Shopify store url')]) }}
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">{{ __('.myshopify.com') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group">
                        {!! Form::label('shopify_access_token', __('Shopify access token'), ['class' => 'form-label']) !!}
                        {!! Form::text('shopify_access_token', !empty($shopify_access_token) ? $shopify_access_token : '', [
                            'class' => 'form-control',
                            'placeholder' => 'Shopify Access Token',
                        ]) !!}
                    </div>
                    <div class="col-lg-12 text-end">
                        <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit btn btn-primary">
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div id="whatsapp_Setting">
        <div class="card">
            {{ Form::open(['route' => 'admin.whatsapp.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="card-header d-flex justify-content-between ">
                <div class="Whatsapp-title-div">
                    <h5 class=""> {{ __('Whatsapp Settings') }} </h5>
                    <small>{{ __('WhatsApp live support setting for customers') }}</small>
                </div>
                {!! Form::hidden('whatsapp_setting_enabled', 'off') !!}
                <div class="form-check form-switch d-inline-block">
                    {!! Form::checkbox('whatsapp_setting_enabled', 'on', $whatsapp_setting_enabled, [
                        'class' => 'form-check-input',
                        'id' => 'whatsapp_setting_enabled',
                    ]) !!}
                    <label class="custom-control-label form-control-label" for="whatsapp_setting_enabled"></label>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-12 form-group">
                        {!! Form::label('whatsapp_contact_number', __('Contact Number'), ['class' => 'form-label']) !!}
                        {!! Form::text('whatsapp_contact_number', !empty($whatsapp_contact_number) ? $whatsapp_contact_number : '', [
                            'class' => 'form-control',
                            'placeholder' => 'XXXXXXXXXX',
                        ]) !!}
                    </div>

                    <div class="col-lg-12 text-end">
                        <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit btn btn-primary">
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div id="whatsapp_message_Setting">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="">
                        {{ __('Whatsapp Message Settings') }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    {{ Form::model($store_settings, ['route' => ['admin.customMassage', $store_settings->slug], 'method' => 'POST']) }}
                    <div class="row">
                        <h6 class="font-weight-bold">{{ __('Order Variable') }}</h6>
                        <div class="form-group col-md-6">
                            <p class="mb-1">{{ __('Store Name') }} : <span
                                    class="pull-right text-primary">{store_name}</span></p>
                            <p class="mb-1">{{ __('Order No') }} : <span
                                    class="pull-right text-primary">{order_no}</span></p>
                            <p class="mb-1">{{ __('Customer Name') }} : <span
                                    class="pull-right text-primary">{customer_name}</span></p>
                            <p class="mb-1">{{ __('Billing Address') }} : <span
                                    class="pull-right text-primary">{billing_address}</span></p>
                            <p class="mb-1">{{ __('Billing Country') }} : <span
                                    class="pull-right text-primary">{billing_country}</span></p>
                            <p class="mb-1">{{ __('Billing City') }} : <span
                                    class="pull-right text-primary">{billing_city}</span></p>
                            <p class="mb-1">{{ __('Billing Postalcode') }} : <span
                                    class="pull-right text-primary">{billing_postalcode}</span></p>
                            <p class="mb-1">{{ __('Shipping Address') }} : <span
                                    class="pull-right text-primary">{shipping_address}</span></p>
                            <p class="mb-1">{{ __('Shipping Country') }} : <span
                                    class="pull-right text-primary">{shipping_country}</span></p>

                            <p class="mb-1">{{ __('Shipping City') }} : <span
                                    class="pull-right text-primary">{shipping_city}</span></p>
                            <p class="mb-1">{{ __('Shipping Postalcode') }} : <span
                                    class="pull-right text-primary">{shipping_postalcode}</span></p>
                            <p class="mb-1">{{ __('Item Variable') }} : <span
                                    class="pull-right text-primary">{item_variable}</span></p>
                            <p class="mb-1">{{ __('Qty Total') }} : <span
                                    class="pull-right text-primary">{qty_total}</span></p>
                            <p class="mb-1">{{ __('Sub Total') }} : <span
                                    class="pull-right text-primary">{sub_total}</span></p>
                            <p class="mb-1">{{ __('Discount Amount') }} : <span
                                    class="pull-right text-primary">{discount_amount}</span></p>
                            <p class="mb-1">{{ __('Shipping Amount') }} : <span
                                    class="pull-right text-primary">{shipping_amount}</span></p>
                            <p class="mb-1">{{ __('Total Tax') }} : <span
                                    class="pull-right text-primary">{total_tax}</span></p>
                            <p class="mb-1">{{ __('Final Total') }} : <span
                                    class="pull-right text-primary">{final_total}</span></p>
                        </div>
                        <div class="form-group col-md-6">
                            <h6 class="font-weight-bold">{{ __('Item Variable') }}</h6>
                            <p class="mb-1">{{ __('Sku') }} : <span class="pull-right text-primary">{sku}</span>
                            </p>
                            <p class="mb-1">{{ __('Quantity') }} : <span
                                    class="pull-right text-primary">{quantity}</span></p>
                            <p class="mb-1">{{ __('Product Name') }} : <span
                                    class="pull-right text-primary">{product_name}</span></p>
                            <p class="mb-1">{{ __('Variant Name') }} : <span
                                    class="pull-right text-primary">{variant_name}</span></p>
                            <p class="mb-1">{{ __('Item Tax') }} : <span
                                    class="pull-right text-primary">{item_tax}</span></p>
                            <p class="mb-1">{{ __('Item total') }} : <span
                                    class="pull-right text-primary">{item_total}</span></p>
                            <div class="form-group">
                                <label for="storejs" class="col-form-label">{item_variable}</label>
                                {{ Form::text('item_variable', null, ['class' => 'form-control', 'placeholder' => '{quantity} x {product_name} - {variant_name} + {item_tax} = {item_total}']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('content', __('Whatsapp Message'), ['class' => 'col-form-label']) }}
                                {{ Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-end">
                        <div class="card-footer">
                            <div class="col-sm-12 px-2">
                                <div class="d-flex justify-content-end">
                                    {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="twilio_setting">
        <div class="card">
            {{ Form::open(['route' => 'admin.twilio.settings', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
            <div class="card-header d-flex justify-content-between ">
                <h5> {{ __('Twilio Settings') }} </h5>
                {!! Form::hidden('twilio_setting_enabled', 'off') !!}
                <div class="form-check form-switch d-inline-block">
                    {!! Form::checkbox('twilio_setting_enabled', 'on', $twilio_setting_enabled, [
                        'class' => 'form-check-input',
                        'id' => 'twilio_setting_enabled',
                    ]) !!}
                    <label class="custom-control-label form-control-label" for="twilio_setting_enabled"></label>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('twilio_sid', __('Twilio SID'), ['class' => 'form-label']) !!}
                        {!! Form::text('twilio_sid', !empty($twilio_sid) ? $twilio_sid : '', [
                            'class' => 'form-control',
                            'placeholder' => 'Twilio SID',
                        ]) !!}
                    </div>
                    <div class="col-lg-6 form-group">
                        {!! Form::label('twilio_token', __('Twilio Token'), ['class' => 'form-label']) !!}
                        {!! Form::text('twilio_token', !empty($twilio_token) ? $twilio_token : '', [
                            'class' => 'form-control',
                            'placeholder' => 'Twilio Token',
                        ]) !!}
                    </div>
                    <div class="col-lg-6 form-group">
                        {!! Form::label('twilio_from', __('Twilio From'), ['class' => 'form-label']) !!}
                        {!! Form::text('twilio_from', !empty($twilio_from) ? $twilio_from : '', [
                            'class' => 'form-control',
                            'placeholder' => 'twilio consumer secret',
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        {!! Form::label('twilio_notification_number', __('Notification Number'), ['class' => 'form-label']) !!}
                        {!! Form::text(
                            'twilio_notification_number',
                            !empty($twilio_notification_number) ? $twilio_notification_number : '',
                            ['class' => 'form-control', 'placeholder' => 'twilio consumer secret'],
                        ) !!}
                        <small>* {{ __('Use country code with your number') }} *</small>
                    </div>

                    <div class="col-lg-12 text-end">
                        <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit btn btn-primary">
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <!--Email Notification Setting-->
    <div id="email-notification-settings" class="card">
        {{ Form::model($settings, ['route' => ['admin.status.email.language'], 'method' => 'post']) }}
        @csrf
        <div class="col-md-12">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h5>{{ __('Email Notification Settings') }}</h5>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    @foreach ($EmailTemplates as $EmailTemplate)
                        <div class="col-lg-4 col-md-6 col-sm-6 form-group">
                            <div class="list-group">
                                <div class="list-group-item form-switch form-switch-right">
                                    <label class="form-label"
                                        style="margin-left:5%;">{{ $EmailTemplate->name }}</label>

                                    <input class="form-check-input" name='{{ $EmailTemplate->id }}'
                                        id="email_tempalte_{{ $EmailTemplate->template->id }}" type="checkbox"
                                        @if ($EmailTemplate->template->is_active == 1) checked="checked" @endif type="checkbox"
                                        value="1"
                                        data-url="{{ route('admin.status.email.language', [$EmailTemplate->template->id]) }}" />
                                    <label class="form-check-label"
                                        for="email_tempalte_{{ $EmailTemplate->template->id }}"></label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer p-0">
                    <div class="col-sm-12 mt-3 px-2">
                        <div class="text-end">
                            <input class="btn btn-print-invoice  btn-primary " type="submit"
                                value="{{ __('Save Changes') }}">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

    <!--whatsapp Notification Setting-->
    <div id="whatsapp-notification-settings" class="card">
        {{ Form::model($settings, ['route' => ['admin.whatsapp-notification'], 'method' => 'post']) }}
        @csrf
        <div class="col-md-12">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h5>{{ __('WhatsApp Business API') }}</h5>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {!! Form::label('whatsapp_phone_number_id', __('WhatsApp Phone number ID'), ['class' => 'form-label']) !!}
                        {!! Form::text('whatsapp_phone_number_id', !empty($whatsapp_phone_number_id) ? $whatsapp_phone_number_id : '', [
                            'class' => 'form-control',
                            'placeholder' => 'WhatsApp Phone number ID',
                            'id' => 'whatsapp_phone_number_id',
                        ]) !!}
                    </div>
                    <div class="col-lg-6 form-group">
                        {!! Form::label('whatsapp_access_token', __('WhatsApp Access Token'), ['class' => 'form-label']) !!}
                        {!! Form::text('whatsapp_access_token', !empty($whatsapp_access_token) ? $whatsapp_access_token : '', [
                            'class' => 'form-control',
                            'placeholder' => 'WhatsApp Access Token',
                            'id' => 'whatsapp_access_token',
                        ]) !!}
                    </div>

                    @foreach ($WhatsappNotification as $notification)
                        <div class="col-lg-4 col-md-6 col-sm-6 form-group">
                            <div class="list-group">
                                <div class="list-group-item form-switch form-switch-right">
                                    <label class="form-label"
                                        style="margin-left:5%;">{{ $notification->name }}</label>

                                    <input class="form-check-input whatsapp-notification"
                                        name='{{ $notification->id }}' id="{{ $notification->id }}"
                                        type="checkbox" @if ($notification->is_active == 1) checked="checked" @endif
                                        type="checkbox" value="1" />
                                    <label class="form-check-label" for="{{ $notification->id }}"></label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="text-start col-6">
                            <a href="#" data-ajax-popup1="true" data-size="md"
                                data-title="{{ __('Send Test whatsapp massage') }}"
                                data-url="{{ route('admin.whatsappmassage.test') }}" data-toggle="tooltip"
                                title="{{ __('Test WhatsApp Massage') }}"
                                class="btn  btn-primary test-whatsapp-massage">
                                {{ __('Send Test Message') }}
                            </a>
                        </div>
                        <div class="text-end col-6">
                            <input type="submit" value="{{ __('Save Changes') }}"
                                class="btn-submit btn btn-primary">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

    <div id="Webhook_Setting">
        <div class="card">
            <div class="card-header">
                <div class="row g-0">
                    <div class="col-6">
                        <h5> {{ __('Webhook Settings') }} </h5>
                        <small>{{ __('Edit your Webhook Settings') }}</small>
                    </div>
                    <div class="col-6 text-end">
                        <a href="javascript:;" class="btn btn-sm btn-icon btn-primary me-2" data-ajax-popup="true"
                            data-url="{{ route('admin.webhook.create') }}" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="{{ __('Create') }}"
                            data-title="{{ __('Create New Webhook') }}">
                            <i data-feather="plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row g-0">
                    <div class="card-body table-border-style">
                        <div class="datatable-container">
                            <div class="table-responsive custom-field-table">
                                <table class="table dataTable-table" id="pc-dt-simple" data-repeater-list="fields">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ __('module') }}</th>

                                            <th>{{ __('url') }}</th>
                                            <th>{{ __('method') }}</th>
                                            <th style="width: 200px;">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    @foreach ($webhooks as $webhook)
                                        <tbody>
                                            <td>{{ $webhook->module }}</td>
                                            <td>{{ $webhook->url }}</td>
                                            <td>{{ $webhook->method }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-sm btn-primary me-2"
                                                        data-url="{{ route('admin.webhook.edit', $webhook->id) }}"
                                                        data-size="md" data-ajax-popup="true"
                                                        data-title="{{ __('Edit webhook') }}">
                                                        <i class="ti ti-pencil py-1" data-bs-toggle="tooltip"
                                                            title="edit"></i>
                                                    </button>

                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['admin.webhook.destroy', $webhook->id],
                                                        'class' => 'd-inline',
                                                    ]) !!}
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                        <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip"
                                                            title="Delete"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    </div>
    </div>
    </div>
@endsection

@push('custom-script')

    @if (\Auth::guard('admin')->user()->type == 'superadmin')
        <script>
            $(document).ready(function() {

                $.ajax({
                    url: "{{ route('admin.get.country') }}",
                    type: "GET",
                    success: function(result) {
                        $.each(result.data, function(key, value) {

                            setTimeout(function() {
                                if (value.id == '{{ $country_id }}') {
                                    $("#country").append('<option value="' + value.id +
                                        '" selected class="counties_list">' + value
                                        .name + '</option>');
                                } else {
                                    $("#country").append('<option value="' + value.id +
                                        '" class="counties_list">' + value.name +
                                        '</option>');
                                }
                            }, 1000);

                        });

                    },
                });


            })
            $.ajax({

                url: "{{ route('admin.get.all.state') }}",
                type: "GET",
                success: function(result) {
                    setTimeout(function() {
                        $.each(result, function(key, value) {
                            if (value.id == '{{ $state_id }}') {

                                $("#state_filter").append('<option value="' + value.id +
                                    '" selected>' + value.name + "</option>");
                            } else {
                                $("#state_filter").append('<option value="' + value.id + '">' +
                                    value.name + "</option>");
                            }
                        });
                    }, 1000);

                },
            });


            $(document).on("click", 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]',
                function() {

                    $.ajax({
                        url: "{{ route('admin.get.country') }}",
                        type: "GET",
                        success: function(result) {

                            $.each(result.data, function(key, value) {
                                setTimeout(function() {
                                    $("#state_country").append('<option value="' + value.id +
                                        '" >' + value.name + '</option>');
                                }, 1000);

                            });


                        },
                    });



                });

            $(document).on("change", '#city_country', function() {

                var country_id = this.value;
                $("#city_state").html("");
                $.ajax({
                    url: "{{ route('admin.get.state') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function(result) {
                        setTimeout(function() {
                            $.each(result.data, function(key, value) {
                                $("#city_state").append('<option value="' + value.id +
                                    '">' +
                                    value.name + "</option>");
                            });
                            $("#city").html('<option value="">Select State First</option>');
                        }, 1000);
                    },
                });
            });

            $('#country').on('change', function() {
                $('#customer_submit').trigger('submit');
                return false;
            })
            $('#state_filter').on('change', function() {
                $('#state_filter_submit').trigger('submit');
                return false;
            })

            @if ($filter_data == 'filtered')
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#location-list").offset().top
                }, 2000);
            @endif
        </script>
    @endif

    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })

        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', "{{ __('Link copied') }}", 'success');
        }

        function AppFunction() {
            var copyText = document.getElementById("AppInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', "{{ __('Link copied') }}", 'success');
        }

        $(document).on("click", '.send_email', function(e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');
            $("#commanModel .modal-title").html(title);
            $("#commanModel .modal-dialog").addClass('modal-' + size);
            $("#commanModel").modal('show');

            if (typeof url != 'undefined') {
                var data = {
                    mail_driver: $("input[name='mail_driver']").val(),
                    mail_host: $("input[name='mail_host']").val(),
                    mail_port: $("input[name='mail_port']").val(),
                    mail_username: $("input[name='mail_username']").val(),
                    mail_password: $("input[name='mail_password']").val(),
                    mail_encryption: $("input[name='mail_encryption']").val(),
                    mail_from_address: $("input[name='mail_from_address']").val(),
                    mail_from_name: $("input[name='mail_from_name']").val(),
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    context: this,
                    success: function(response) {
                        $('#commanModel .modal-body').html(response);
                    }
                });
            }
        });

        $(document).on("click", '.test-whatsapp-massage', function(e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');
            $("#commanModel .modal-title").html(title);
            $("#commanModel .modal-dialog").addClass('modal-' + size);
            $("#commanModel").modal('show');

            if (typeof url != 'undefined') {
                var data = {
                    whatsapp_phone_number_id: $("#whatsapp_phone_number_id").val(),
                    whatsapp_access_token: $("#whatsapp_access_token").val(),
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    context: this,
                    success: function(response) {
                        $('#commanModel .modal-body').html(response);
                    }
                });
            }
        });


        $(document).on('change', '[name=storage_setting]', function() {
            if ($(this).val() == 's3') {
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            } else if ($(this).val() == 'wasabi') {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            } else {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            if ($('.enable_pwa_store').is(':checked')) {

                $('.pwa_is_enable').removeClass('disabledPWA');
            } else {

                $('.pwa_is_enable').addClass('disabledPWA');
            }

            $('#pwa_store').on('change', function() {
                if ($('.enable_pwa_store').is(':checked')) {

                    $('.pwa_is_enable').removeClass('disabledPWA');
                } else {

                    $('.pwa_is_enable').addClass('disabledPWA');
                }
            });
        });

        $(document).on('submit', '#test_email', function(e) {
            e.preventDefault();
            $("#email_sending").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                beforeSend: function() {
                    $('#test_email .btn-create').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.is_success) {
                        show_toastr('Success', data.message, 'success');
                    } else {
                        show_toastr('Error', data.message, 'error');
                    }
                    $("#email_sending").hide();
                    $('#commanModel').modal('hide');
                },
                complete: function() {
                    $('#test_email .btn-create').removeAttr('disabled');
                },
            });
        });




        $(document).ready(function() {
            $(document).on('change', '.whatsapp-notification', function() {

                var status = $(this).prop('checked') == true ? 1 : 0;
                var notification_id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ route('admin.update.whatsapp.notification') }}",
                    data: {
                        'status': status,
                        'notification_id': notification_id
                    },
                    success: function(data) {
                        if (data.success) {
                            show_toastr('Success', data.success, 'success');
                        } else {
                            show_toastr('Error', "{{ __('Something went wrong') }}", 'error');
                        }
                    },
                });
            })
        })
    </script>
    <script>
        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
@endpush
