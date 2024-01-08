@extends('layouts.app')

@section('page-title', __('Order Summary'))

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">{{ __('Plan') }}</a></li>
    <li class="breadcrumb-item">{{ __('Order Summary') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="sticky-top" style="top:30px">
                        <div class="card ">
                            <div class="list-group list-group-flush" id="useradd-sidenav">
                                @if (isset($admin_payments_details['is_stripe_enabled']) && $admin_payments_details['is_stripe_enabled'] == 'on')
                                    <a href="#stripe_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Stripe') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_paystack_enabled']) && $admin_payments_details['is_paystack_enabled'] == 'on')
                                    <a href="#paystack_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paystack') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled'] == 'on')
                                    <a href="#razorpay_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Razorpay') }} <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_mercado_enabled']) && $admin_payments_details['is_mercado_enabled'] == 'on')
                                    <a href="#mercado_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Mercado Pago') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_skrill_enabled']) && $admin_payments_details['is_skrill_enabled'] == 'on')
                                    <a href="#skrill_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Skrill') }} <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_paymentwall_enabled']) &&
                                        $admin_payments_details['is_paymentwall_enabled'] == 'on')
                                    <a href="#paymentwall_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paymentwall') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_paypal_enabled']) && $admin_payments_details['is_paypal_enabled'] == 'on')
                                    <a href="#paypal_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paypal') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_flutterwave_enabled']) &&
                                        $admin_payments_details['is_flutterwave_enabled'] == 'on')
                                    <a href="#flutterwave_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Flutterwave') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_paytm_enabled']) && $admin_payments_details['is_paytm_enabled'] == 'on')
                                    <a href="#paytm_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paytm') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_mollie_enabled']) && $admin_payments_details['is_mollie_enabled'] == 'on')
                                    <a href="#mollie_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Mollie') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_coingate_enabled']) && $admin_payments_details['is_coingate_enabled'] == 'on')
                                    <a href="#coingate_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Coingate') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_sspay_enabled']) && $admin_payments_details['is_sspay_enabled'] == 'on')
                                    <a href="#sspay_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Sspay') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_toyyibpay_enabled']) && $admin_payments_details['is_toyyibpay_enabled'] == 'on')
                                    <a href="#toyyibpay_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Toyyibpay') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_bank_transfer_enabled']) &&
                                        $admin_payments_details['is_bank_transfer_enabled'] == 'on')
                                    <a href="#bank_transfer_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Bank Transfer') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif
                                @if (isset($admin_payments_details['is_paytabs_enabled']) && $admin_payments_details['is_paytabs_enabled'] == 'on')
                                    <a href="#paytabs_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Paytabs') }}
                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                @endif

                                @if (isset($admin_payments_details['is_iyzipay_enabled']) && $admin_payments_details['is_iyzipay_enabled'] == 'on')
                                    <a href="#iyzipay_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Iyzipay') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_payfast_enabled']) && $admin_payments_details['is_payfast_enabled'] == 'on')
                                    <a href="#payfast_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('PayFast') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_benefit_enabled']) && $admin_payments_details['is_benefit_enabled'] == 'on')
                                    <a href="#benefit_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Benefit') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_cashfree_enabled']) && $admin_payments_details['is_cashfree_enabled'] == 'on')
                                    <a href="#cashfree_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Cashfree') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_aamarpay_enabled']) && $admin_payments_details['is_aamarpay_enabled'] == 'on')
                                    <a href="#aamarpay_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Aamarpay') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_paytr_enabled']) && $admin_payments_details['is_paytr_enabled'] == 'on')
                                    <a href="#paytr_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Pay TR') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_yookassa_enabled']) && $admin_payments_details['is_yookassa_enabled'] == 'on')
                                    <a href="#yookassa_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Yookassa') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif
                                @if (isset($admin_payments_details['is_Xendit_enabled']) && $admin_payments_details['is_Xendit_enabled'] == 'on')
                                    <a href="#Xendit_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Xendit') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                                @if (isset($admin_payments_details['is_midtrans_enabled']) && $admin_payments_details['is_midtrans_enabled'] == 'on')
                                    <a href="#midtrans_payment"
                                        class="list-group-item list-group-item-action border-0">{{ __('Midtrans') }}<div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                @endif

                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                                style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                <div class="card-body">
                                    <span class="price-badge bg-primary">{{ $plan->name }}</span>
                                    @if (\Auth::guard('admin')->user()->type == 'admin' && \Auth::guard('admin')->user()->plan == $plan->id)
                                        <div class="d-flex flex-row-reverse m-0 p-0 ">
                                            <span class="d-flex align-items-center ">
                                                <i class="f-10 lh-1 fas fa-circle text-primary"></i>
                                                <span class="ms-2">{{ __('Active') }}</span>
                                            </span>
                                        </div>
                                    @endif

                                    {{-- <div class="text-end">
                                        <div class="">
                                            @if (\Auth::guard('admin')->user()->type == 'super admin')
                                                <a title="Edit Plan" data-size="lg" href="#" class="action-item"
                                                    data-url="{{ route('plans.edit', $plan->id) }}"
                                                    data-ajax-popup="true" data-title="{{ __('Edit Plan') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit Plan') }}"><i class="fas fa-edit"></i></a>
                                            @endif
                                        </div>
                                    </div> --}}
                                    <h3 class="mb-4 f-w-600  ">
                                        {{ !empty($admin_payments_details['CURRENCY']) ? $admin_payments_details['CURRENCY'] : '$' }}{{ $plan->price . ' / ' . __(\App\Models\Plan::$arrDuration[$plan->duration]) }}</small>
                                        </h1>
                                        {{-- <p class="mb-0">
                                            {{ __('Trial : ') . $plan->trial_days . __(' Days') }}<br />
                                        </p> --}}
                                        @if ($plan->description)
                                            <p class="mb-0">
                                                {{ $plan->description }}<br />
                                            </p>
                                        @endif
                                        <ul class="list-unstyled d-inline-block my-5">
                                            @if ($plan->enable_domain == 'on')
                                                <li class="d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-primary ti ti-circle-plus"></i></span>{{ __('Custom Domain') }}
                                                </li>
                                            @else
                                                <li class="text-danger d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-danger ti ti-circle-plus"></i></span>{{ __('Custom Domain') }}
                                                </li>
                                            @endif
                                            @if ($plan->enable_subdomain == 'on')
                                                <li class="d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-primary ti ti-circle-plus"></i></span>{{ __('Sub Domain') }}
                                                </li>
                                            @else
                                                <li class="text-danger d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-danger ti ti-circle-plus"></i></span>{{ __('Sub Domain') }}
                                                </li>
                                            @endif
                                            @if ($plan->enable_chatgpt == 'on')
                                                <li class="d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-primary ti ti-circle-plus"></i></span>{{ __('Chatgpt') }}
                                                </li>
                                            @else
                                                <li class="text-danger d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-danger ti ti-circle-plus"></i></span>{{ __('Chatgpt') }}
                                                </li>
                                            @endif

                                            @if ($plan->pwa_store == 'on')
                                                <li class="d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                                    {{ __('Progressive Web App (PWA)') }}
                                                </li>
                                            @else
                                                <li class="text-danger d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-danger ti ti-circle-plus"></i></span>{{ __('Progressive Web App (PWA)') }}
                                                </li>
                                            @endif
                                            @if ($plan->shipping_method == 'on')
                                                <li class="d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                                    {{ __('Shipping Method') }}
                                                </li>
                                            @else
                                                <li class="text-danger d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-danger ti ti-circle-plus"></i></span>{{ __('Shipping Method') }}
                                                </li>
                                            @endif
                                            @if ($plan->storage_limit != '0.00')
                                                <li class="d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                                    {{ $plan->storage_limit }}{{ __('MB Storage') }}
                                                </li>
                                            @else
                                                <li class="text-danger d-flex align-items-center">
                                                    <span class="theme-avtar">
                                                        <i
                                                            class="text-danger ti ti-circle-plus"></i></span>{{ __('0 MB Storage') }}
                                                </li>
                                            @endif
                                        </ul>

                                        <div class="row mb-3">
                                            <div class="col-4 text-center">
                                                @if ($plan->max_products == '-1')
                                                    <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                                @else
                                                    <span class="h5 mb-0">{{ $plan->max_products }}</span>
                                                @endif
                                                <span class="d-block text-sm">{{ __('Products') }}</span>
                                            </div>
                                            <div class="col-4 text-center">
                                                <span class="h5 mb-0">
                                                    @if ($plan->max_stores == '-1')
                                                        <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                                    @else
                                                        <span class="h5 mb-0">{{ $plan->max_stores }}</span>
                                                    @endif
                                                </span>
                                                <span class="d-block text-sm">{{ __('Store') }}</span>
                                            </div>
                                            <div class="col-4 text-center">
                                                <span class="h5 mb-0">
                                                    @if ($plan->max_users == '-1')
                                                        <span class="h5 mb-0">{{ __('Unlimited') }}</span>
                                                    @else
                                                        <span class="h5 mb-0">{{ $plan->max_users }}</span>
                                                    @endif
                                                </span>
                                                <span class="d-block text-sm">{{ __('Users') }}</span>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    {{-- stripe payment --}}
                    @if (isset($admin_payments_details['is_stripe_enabled']) && $admin_payments_details['is_stripe_enabled'] == 'on')
                        <div id="stripe_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Stripe') }}</h5>
                            </div>
                            {{-- <div class="card-body"> --}}

                            @if (
                                $admin_payments_details['is_stripe_enabled'] == 'on' &&
                                    !empty($admin_payments_details['publishable_key']) &&
                                    !empty($admin_payments_details['stripe_secret']))
                                <div class="tab-pane {{ ($admin_payments_details['is_stripe_enabled'] == 'on' && !empty($admin_payments_details['publishable_key']) && !empty($admin_payments_details['stripe_secret'])) == 'on' ? 'active' : '' }}"
                                    id="stripe_payment">
                                    <form role="form" action="{{ route('admin.stripe.payment') }}" method="post"
                                        class="require-validation" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 rounded stripe-payment-div">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="custom-radio">
                                                        <label
                                                            class="font-16 font-weight-bold">{{ __('Credit / Debit Card') }}</label>
                                                    </div>
                                                    <p class="mb-0 pt-1 text-sm">
                                                        {{ __('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.') }}
                                                    </p>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="card-name-on"
                                                            class="form-label text-dark">{{ __('Name on card') }}</label>
                                                        <input type="text" name="name" id="card-name-on"
                                                            class="form-control required"
                                                            placeholder="{{ \Auth::guard('admin')->user()->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div id="card-element">
                                                        <!-- A Stripe Element will be inserted here. -->
                                                    </div>
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                                <div class="col-md-12 mt-4 row">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group w-100">
                                                            <label for="paypal_coupon"
                                                                class="form-label">{{ __('Coupon') }}</label>
                                                            <input type="text" id="stripe_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group ms-3 mt-4">
                                                            <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                                data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                    class="fas fa-save"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            {{ __('Please correct the errors and try again.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="submit" value="{{ __('Pay Now') }}"
                                                    class="btn btn-xs btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                    @endif
                    {{-- stripr payment end --}}

                    <!-- Paystack -->
                    @if (isset($admin_payments_details['is_paystack_enabled']) && $admin_payments_details['is_paystack_enabled'] == 'on')
                        <div id="paystack_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paystack') }}</h5>

                            </div>
                            <form role="form" action="{{ route('admin.plan.pay.with.paystack', []) }}" method="post"
                                class="require-validation" id="paystack-payment-form">
                                @csrf
                                <input type="hidden" name="plan_id"
                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                <div id="paystack-payment" class="tabs-card">
                                    <div class="">
                                        <div class="border p-3 mb-3 rounded payment-box">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="paystack_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="paystack_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paymentwall-coupon-tr" style="display: none">
                                                <b>{{ __('Coupon Discount') }}</b> : <b
                                                    class="paymentwall-coupon-price"></b>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="button" id="pay_with_paystack" value="{{ __('Pay Now') }}"
                                                    class="btn btn-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    <!-- Paystack end -->

                    {{-- Razorpay --}}
                    @if (isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled'] == 'on')
                        <div id="razorpay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Razorpay') }} </h5>

                            </div>
                            @if (isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled'] == 'on')
                                <form role="form" action="{{ route('admin.plan.pay.with.razorpay') }}" method="post"
                                    class="require-validation" id="razorpay-payment-form">
                                    @csrf
                                    <div class="tab-pane " id="razorpay_payment">
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 mb-3 rounded payment-box">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="razorpay_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="razorpay_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="button" id="pay_with_razorpay" value="{{ __('Pay Now') }}"
                                                    class="btn btn-primary">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endif
                    {{-- Razorpay end --}}

                    {{-- Mercado Pago --}}
                    @if (isset($admin_payments_details['is_mercado_enabled']) && $admin_payments_details['is_mercado_enabled'] == 'on')
                        <div id="mercado_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Mercado Pago') }}</h5>

                            </div>
                            @if (isset($admin_payments_details['is_mercado_enabled']) && $admin_payments_details['is_mercado_enabled'] == 'on')
                                <div class="tab-pane " id="mercado_payment">

                                    <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                        id="payment-form" action="{{ route('admin.plan.pay.with.mercado') }}">
                                        @csrf
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 mb-3 rounded payment-box">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="mercado_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="mercado_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="submit" id="pay_with_mercado" value="{{ __('Pay Now') }}"
                                                    class="btn btn-primary">

                                            </div>
                                        </div>
                                    </form>

                                </div>
                            @endif
                        </div>
                    @endif
                    {{-- Mercado Pago end --}}

                    {{-- skrill Pago --}}
                    @if (isset($admin_payments_details['is_skrill_enabled']) && $admin_payments_details['is_skrill_enabled'] == 'on')
                        <div id="skrill_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Skrill') }}</h5>

                            </div>
                            @if (isset($admin_payments_details['is_skrill_enabled']) && $admin_payments_details['is_skrill_enabled'] == 'on')
                                <div class="tab-pane " id="skrill_payment">

                                    <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                        id="payment-form" action="{{ route('admin.plan.pay.with.skrill') }}">
                                        @csrf
                                        <input type="hidden" name="plan_id"
                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 mb-3 rounded payment-box">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="skrill_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="skrill_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="submit" id="pay_with_skrill" value="{{ __('Pay Now') }}"
                                                    class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            @endif
                        </div>
                    @endif
                    {{-- skrill Pago end --}}


                    {{-- Paymentwall --}}
                    @if (isset($admin_payments_details['is_paymentwall_enabled']) &&
                            $admin_payments_details['is_paymentwall_enabled'] == 'on')
                        <div id="paymentwall_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paymentwall') }}</h5>

                            </div>
                            <div class="tab-pane " id="paymentwall_payment">

                                <form role="form" action="{{ route('admin.plan.paymentwallpayment') }}"
                                    method="post" id="paymentwall-payment-form"
                                    class="w3-container w3-display-middle w3-card-4">
                                    @csrf
                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="col-md-12 mt-4 row">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group w-100">
                                                    <label for="paymentwall_coupon"
                                                        class="form-label">{{ __('Coupon') }}</label>
                                                    <input type="text" id="paymentwall_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                                <div class="form-group ms-3 mt-4">
                                                    <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                        data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                            class="fas fa-save"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <button class="btn btn-primary" type="submit" id="pay_with_paymentwall">
                                                {{ __('Pay Now') }}
                                            </button>

                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    @endif
                    {{-- Paymentwall end --}}

                    {{-- paypal payment --}}
                    @if (isset($admin_payments_details['is_paypal_enabled']) && $admin_payments_details['is_paypal_enabled'] == 'on')
                        <div id="stripe_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paypal') }}</h5>
                            </div>
                            {{-- <div class="card-body"> --}}

                            @if (
                                $admin_payments_details['is_paypal_enabled'] == 'on' &&
                                    !empty($admin_payments_details['paypal_client_id']) &&
                                    !empty($admin_payments_details['paypal_secret']))
                                <div class="tab-pane {{ ($admin_payments_details['is_paypal_enabled'] == 'on' && !empty($admin_payments_details['paypal_client_id']) && !empty($admin_payments_details['paypal_secret'])) == 'on' ? 'active' : '' }}"
                                    id="stripe_payment">
                                    <form role="form" action="{{ route('admin.paypal.payment') }}" method="post"
                                        class="require-validation" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 rounded stripe-payment-div">
                                            <div class="row">
                                                <div class="col-md-12 mt-4 row">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group w-100">
                                                            <label for="paypal_coupon"
                                                                class="form-label">{{ __('Coupon') }}</label>
                                                            <input type="text" id="paypal_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group ms-3 mt-4">
                                                            <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                                data-toggle="tooltip"
                                                                data-title="{{ __('Apply') }}"><i
                                                                    class="fas fa-save"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            {{ __('Please correct the errors and try again.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="submit" value="{{ __('Pay Now') }}"
                                                    class="btn btn-xs btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                    @endif
                    {{-- paypal payment end --}}

                    {{-- flutterwave payment start --}}
                    @if (isset($admin_payments_details['is_flutterwave_enabled']) &&
                            $admin_payments_details['is_flutterwave_enabled'] == 'on')
                        <div id="flutterwave_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Flutterwave') }}</h5>

                            </div>
                            {{-- <div class="card-body"> --}}
                            <form role="form" action="{{ route('admin.flutterwave.payment') }}" method="post"
                                class="require-validation" id="flaterwave-payment-form">
                                @csrf

                                <div class="tab-pane " id="flutterwave_payment">

                                    {{-- <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}"> --}}

                                    <div class="border p-3 mb-3 rounded payment-box">
                                        <div class="form-group mt-3"><label
                                                for="flutterwave_coupon">{{ __('Coupon') }}</label></div>
                                        <div class="row align-items-center">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <input type="text" id="flutterwave_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12 text-right stripe-coupon-tr" style="display: none">
                                                <b>{{ __('Coupon Discount') }}</b> : <b class="stripe-coupon-price"></b>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                            <input type="button" id="pay_with_flaterwave" value="{{ __('Pay Now') }}"
                                                class="btn btn-primary">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    @endif
                    {{-- flutterwave payment end --}}

                    {{-- paytm payment start --}}
                    @if (isset($admin_payments_details['is_paytm_enabled']) && $admin_payments_details['is_paytm_enabled'] == 'on')
                        <div id="paytm_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Paytm') }}</h5>
                            </div>
                            {{-- <div class="card-body"> --}}

                            @if (
                                $admin_payments_details['is_paytm_enabled'] == 'on' &&
                                    !empty($admin_payments_details['paytm_merchant_id']) &&
                                    !empty($admin_payments_details['paytm_industry_type']) &&
                                    !empty($admin_payments_details['paytm_merchant_key']))
                                <div class="tab-pane {{ ($admin_payments_details['is_paytm_enabled'] == 'on' && !empty($admin_payments_details['paytm_merchant_id']) && !empty($admin_payments_details['paytm_merchant_key']) && !empty($admin_payments_details['paytm_industry_type'])) == 'on' ? 'active' : '' }}"
                                    id="stripe_payment">
                                    <form role="form" action="{{ route('admin.plan.pay.with.paytm') }}"
                                        method="post" class="require-validation" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 rounded stripe-payment-div">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="mobile_number">{{ __('Mobile Number') }}</label>
                                                        <input type="text" id="mobile_number" name="mobile_number"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Mobile Number') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-4 row">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group w-100">
                                                            <label for="paytm_coupon"
                                                                class="form-label">{{ __('Coupon') }}</label>
                                                            <input type="text" id="paytm_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group ms-3 mt-4">
                                                            <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                                data-toggle="tooltip"
                                                                data-title="{{ __('Apply') }}"><i
                                                                    class="fas fa-save"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            {{ __('Please correct the errors and try again.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="submit" value="{{ __('Pay Now') }}"
                                                    class="btn btn-xs btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                    @endif
                    {{-- paytm payment end --}}

                    {{-- mollie payment start --}}
                    @if (isset($admin_payments_details['is_mollie_enabled']) && $admin_payments_details['is_mollie_enabled'] == 'on')
                        <div id="mollie_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Mollie') }}</h5>
                            </div>
                            {{-- <div class="card-body"> --}}

                            @if (
                                $admin_payments_details['is_mollie_enabled'] == 'on' &&
                                    !empty($admin_payments_details['mollie_api_key']) &&
                                    !empty($admin_payments_details['mollie_profile_id']) &&
                                    !empty($admin_payments_details['mollie_partner_id']))
                                <div class="tab-pane {{ ($admin_payments_details['is_mollie_enabled'] == 'on' && !empty($admin_payments_details['mollie_api_key']) && !empty($admin_payments_details['mollie_profile_id']) && !empty($admin_payments_details['mollie_partner_id'])) == 'on' ? 'active' : '' }}"
                                    id="mollie_payment">
                                    <form role="form" action="{{ route('admin.plan.pay.with.mollie') }}"
                                        method="post" class="require-validation" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 rounded stripe-payment-div">

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div id="card-element">
                                                        <!-- A Stripe Element will be inserted here. -->
                                                    </div>
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                                <div class="col-md-12 mt-4 row">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group w-100">
                                                            <label for="mollie_coupon_coupon"
                                                                class="form-label">{{ __('Coupon') }}</label>
                                                            <input type="text" id="mollie_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group ms-3 mt-4">
                                                            <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                                data-toggle="tooltip"
                                                                data-title="{{ __('Apply') }}"><i
                                                                    class="fas fa-save"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            {{ __('Please correct the errors and try again.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="submit" value="{{ __('Pay Now') }}"
                                                    class="btn btn-xs btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                    @endif
                    {{-- mollie payment end --}}

                    {{-- coingate payment start --}}
                    @if (isset($admin_payments_details['is_coingate_enabled']) && $admin_payments_details['is_coingate_enabled'] == 'on')
                        <div id="coingate_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Coingate') }}</h5>
                            </div>
                            {{-- <div class="card-body"> --}}

                            @if (
                                $admin_payments_details['is_coingate_enabled'] == 'on' &&
                                    !empty($admin_payments_details['coingate_mode']) &&
                                    !empty($admin_payments_details['coingate_auth_token']))
                                <div class="tab-pane {{ ($admin_payments_details['is_coingate_enabled'] == 'on' && !empty($admin_payments_details['coingate_mode']) && !empty($admin_payments_details['coingate_auth_token'])) == 'on' ? 'active' : '' }}"
                                    id="coingate_payment">
                                    <form role="form" action="{{ route('admin.coingate.prepare.plan') }}"
                                        method="post" class="require-validation" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                            class="form-control final-price">
                                        <div class="border p-3 rounded stripe-payment-div">

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div id="card-element">
                                                        <!-- A Stripe Element will be inserted here. -->
                                                    </div>
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                                <div class="col-md-12 mt-4 row">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group w-100">
                                                            <label for="coingate_coupon_coupon"
                                                                class="form-label">{{ __('Coupon') }}</label>
                                                            <input type="text" id="coingate_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group ms-3 mt-4">
                                                            <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                                data-toggle="tooltip"
                                                                data-title="{{ __('Apply') }}"><i
                                                                    class="fas fa-save"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            {{ __('Please correct the errors and try again.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="hidden" name="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="submit" value="{{ __('Pay Now') }}"
                                                    class="btn btn-xs btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            {{-- </div> --}}
                        </div>
                    @endif
                    {{-- coingate payment end --}}

                    {{-- sspay payment start --}}
                    @if (isset($admin_payments_details['is_sspay_enabled']) && $admin_payments_details['is_sspay_enabled'] == 'on')
                        <div id="sspay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Sspay') }}</h5>
                            </div>
                            <div id="sspay_payment" class="">
                                <form role="form" action="{{ route('admin.sspay.prepare.plan') }}" method="post"
                                    id="sspay-payment-form" class="w3-container w3-display-middle w3-card-4">
                                    @csrf
                                    <div class="border p-3 mb-3 rounded payment-box row">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="sspay_coupan" class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="sspay_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                    data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                        class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                                class="form-control final-price">
                                            <button class="btn btn-xs btn-primary" type="submit" id="pay_with_sspay">
                                                {{ __('Pay Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- sspay payment end --}}

                    {{-- toyyibpay payment start --}}
                    @if (isset($admin_payments_details['is_toyyibpay_enabled']) && $admin_payments_details['is_toyyibpay_enabled'] == 'on')
                        <div id="toyyibpay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Toyyibpay') }}</h5>
                            </div>
                            <div id="Toyyibpay_payment" class="">
                                <form role="form" action="{{ route('admin.toyyibpay.prepare.plan') }}"
                                    method="post" id="toyyibpay-payment-form"
                                    class="w3-container w3-display-middle w3-card-4">
                                    @csrf
                                    <div class="border p-3 mb-3 rounded payment-box row">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="toyyibpay_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="toyyibpay_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                    data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                        class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                                class="form-control final-price">
                                            <button class="btn btn-xs btn-primary" type="submit"
                                                id="pay_with_toyyibpay">
                                                {{ __('Pay Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- toyyibpay payment end --}}

                    {{-- Bank Transfer payment --}}
                    @if (isset($admin_payments_details['is_bank_transfer_enabled']) &&
                            $admin_payments_details['is_bank_transfer_enabled'] == 'on')
                        <div id="bank_transfer_payment" class="card">
                            <form class="" method="POST" action="{{ route('admin.plan.pay.with.bank') }}"
                                enctype='multipart/form-data'>
                                @csrf
                                <div class="card-header">
                                    <h5 class=" h6 mb-0">{{ __('Bank Transfer') }}</h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label"><b>{{ __('Bank Details:') }}</b></label>
                                                <div class="form-group">
                                                    @if (isset($admin_payments_details['bank_transfer']) && !empty($admin_payments_details['bank_transfer']))
                                                        {!! $admin_payments_details['bank_transfer'] !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label"> {{ __('Payment Receipt') }}</label>
                                                <div class="form-group">
                                                    <input type="file" name="payment_receipt"
                                                        class="form-control mb-3" required>
                                                </div>
                                            </div>
                                        </div>
                                        <form>
                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="bank_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="bank_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 coupon-apply-btn mt-4">
                                                    <div class="form-group apply-bank-btn-coupon">
                                                        <a href="#"
                                                            class="btn btn-primary align-items-center apply-coupon"
                                                            data-from="bank">{{ __('Apply') }}</a>
                                                    </div>
                                                </div>

                                                <div class="col-6 text-right">
                                                    <b>{{ __('Plan Price') }}</b> :
                                                    {{ $admin_payments_details['CURRENCY'] }}{{ $plan->price }}<b
                                                        class="bank-coupon-price"></b>
                                                </div>
                                                <div class="col-6 text-right ">
                                                    <b>{{ __('Net Amount') }}</b> :
                                                    {{ $admin_payments_details['CURRENCY'] }}<span
                                                        class="bank-final-price">
                                                        {{ $plan->price }} </span></br>
                                                    <small>(After coupon apply)</small>
                                                </div>

                                                <div class="col-sm-12 my-2 px-2">
                                                    <div class="text-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                        <input type="hidden" name="total_price"
                                                            value="{{ $plan->price }}"
                                                            class="form-control final-price">
                                                        <button class="btn btn-xs btn-primary" type="submit">
                                                            {{ __('Pay Now') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            {{ __('Please correct the errors and try again.') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </form>
                                </div>
                            </form>
                        </div>
                    @endif
                    {{-- Bank Transfer payment end --}}

                    {{-- paytabs payment start --}}
                    @if (isset($admin_payments_details['is_paytabs_enabled']) && $admin_payments_details['is_paytabs_enabled'] == 'on')
                        <div id="paytabs_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('paytabs') }}</h5>
                            </div>
                            <div id="paytabs_payment" class="">
                                <form role="form" action="{{ route('admin.paytabs.prepare.plan') }}" method="post"
                                    id="paytabs-payment-form" class="w3-container w3-display-middle w3-card-4">
                                    @csrf
                                    <div class="border p-3 mb-3 rounded payment-box row">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group w-100">
                                                <label for="paytabs_coupan"
                                                    class="form-label">{{ __('Coupon') }}</label>
                                                <input type="text" id="paytabs_coupan" name="coupon"
                                                    class="form-control coupon"
                                                    placeholder="{{ __('Enter Coupon Code') }}">
                                            </div>

                                            <div class="form-group ms-3 mt-4">
                                                <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                    data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                        class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <input type="hidden" name="total_price" value="{{ $plan->price }}"
                                                class="form-control final-price">
                                            <button class="btn btn-xs btn-primary" type="submit" id="pay_with_paytabs">
                                                {{ __('Pay Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- paytabs payment end --}}

                    {{-- IyziPay --}}
                    @if (
                        $admin_payments_details['is_iyzipay_enabled'] == 'on' &&
                            !empty($admin_payments_details['iyzipay_private_key']) &&
                            !empty($admin_payments_details['iyzipay_secret_key']))
                        <div id="iyzipay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('IyziPay') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_iyzipay_enabled'] != 'on' && $admin_payments_details['is_iyzipay_enabled'] == 'on' && !empty($admin_payments_details['iyzipay_private_key']) && !empty($admin_payments_details['iyzipay_secret_key'])) == 'on' ? 'active' : '' }}"
                                id="iyzipay_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('admin.iyzipay.payment.init') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="iyzipay_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="iyzipay_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- IyziPay end --}}

                    {{-- PayFast --}}
                    @if (isset($admin_payments_details['is_payfast_enabled']) && $admin_payments_details['is_payfast_enabled'] == 'on')
                        <div id="payfast_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Payfast') }}</h5>
                            </div>
                            @if (
                                $admin_payments_details['is_payfast_enabled'] == 'on' &&
                                    !empty($admin_payments_details['payfast_merchant_id']) &&
                                    !empty($admin_payments_details['payfast_merchant_key']) &&
                                    !empty($admin_payments_details['payfast_salt_passphrase']) &&
                                    !empty($admin_payments_details['payfast_mode']))
                                <div
                                    class="tab-pane {{ ($admin_payments_details['is_payfast_enabled'] == 'on' && !empty($admin_payments_details['payfast_merchant_id']) && !empty($admin_payments_details['payfast_merchant_key'])) == 'on' ? 'active' : '' }}">
                                    @php
                                        $pfHost = $admin_payments_details['payfast_mode'] == 'sandbox' ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
                                    @endphp
                                    <form role="form" action={{ 'https://' . $pfHost . '/eng/process' }}
                                        method="post" class="require-validation" id="payfast-form">
                                        @csrf
                                        <div class="border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-md-12 mt-4 row">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group w-100">
                                                            <label for="payfast_coupon"
                                                                class="form-label">{{ __('Coupon') }}</label>
                                                            <input type="text" id="payfast_coupon" name="coupon"
                                                                class="form-control coupon"
                                                                placeholder="{{ __('Enter Coupon Code') }}">
                                                        </div>
                                                        <div class="form-group ms-3 mt-4">
                                                            <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                                data-toggle="tooltip"
                                                                data-title="{{ __('Apply') }}"><i
                                                                    class="fas fa-save"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="get-payfast-inputs"></div>
                                        <div class="col-sm-12 my-2 px-2">
                                            <div class="text-end">
                                                <input type="hidden" name="plan_id" id="plan_id"
                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                                <input type="submit" value="{{ __('Pay Now') }}"
                                                    id="payfast-get-status"
                                                    class="btn btn-xs btn-primary payfast_payment">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif

                        </div>
                    @endif
                    {{-- PayFast End --}}

                    {{-- Benefit --}}
                    @if (
                        $admin_payments_details['is_benefit_enabled'] == 'on' &&
                            !empty($admin_payments_details['benefit_secret_key']) &&
                            !empty($admin_payments_details['benefit_private_key']))
                        <div id="benefit_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Benefit') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_benefit_enabled'] != 'on' && $admin_payments_details['is_benefit_enabled'] == 'on' && !empty($admin_payments_details['benefit_secret_key']) && !empty($admin_payments_details['benefit_private_key'])) == 'on' ? 'active' : '' }}"
                                id="benefit_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('admin.benefit.initiate') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="benefit_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="benefit_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Benefit end --}}

                    {{-- Cashfree --}}
                    @if (
                        $admin_payments_details['is_cashfree_enabled'] == 'on' &&
                            !empty($admin_payments_details['cashfree_secret_key']) &&
                            !empty($admin_payments_details['cashfree_key']))
                        <div id="cashfree_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Cashfree') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_cashfree_enabled'] != 'on' && $admin_payments_details['is_cashfree_enabled'] == 'on' && !empty($admin_payments_details['cashfree_secret_key']) && !empty($admin_payments_details['cashfree_key'])) == 'on' ? 'active' : '' }}"
                                id="cashfree_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('admin.cashfree.payment') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="cashfree_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="cashfree_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Cashfree end --}}

                    {{-- Aamarpay --}}
                    @if (
                        $admin_payments_details['is_aamarpay_enabled'] == 'on' &&
                            !empty($admin_payments_details['aamarpay_signature_key']) &&
                            !empty($admin_payments_details['aamarpay_store_id']) &&
                            !empty($admin_payments_details['aamarpay_description']))
                        <div id="aamarpay_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Aamarpay') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_aamarpay_enabled'] != 'on' && $admin_payments_details['is_aamarpay_enabled'] == 'on' && !empty($admin_payments_details['aamarpay_signature_key']) && !empty($admin_payments_details['aamarpay_store_id']) && !empty($admin_payments_details['aamarpay_description'])) == 'on' ? 'active' : '' }}"
                                id="aamarpay_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form"
                                    action="{{ route('admin.pay.aamarpay.payment') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="aamarpay_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="aamarpay_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}"
                                                class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Aamarpay end --}}

                    {{-- Pay TR --}}
                    @if (
                        $admin_payments_details['is_paytr_enabled'] == 'on' &&
                            !empty($admin_payments_details['paytr_merchant_id']) &&
                            !empty($admin_payments_details['paytr_salt_key']) &&
                            !empty($admin_payments_details['paytr_merchant_key']))
                        <div id="paytr_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Pay TR') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_paytr_enabled'] != 'on' && $admin_payments_details['is_paytr_enabled'] == 'on' && !empty($admin_payments_details['paytr_merchant_id']) && !empty($admin_payments_details['paytr_salt_key']) && !empty($admin_payments_details['paytr_merchant_key'])) == 'on' ? 'active' : '' }}"
                                id="paytr_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                    id="paytr-payment-form" action="{{ route('admin.plan.pay.with.paytr') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="paytr_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="paytr_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}"
                                                class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Pay TR end --}}

                    {{-- Yookassa --}}
                    @if (
                        $admin_payments_details['is_yookassa_enabled'] == 'on' &&
                            !empty($admin_payments_details['yookassa_shop_id_key']) &&
                            !empty($admin_payments_details['yookassa_secret_key']))
                        <div id="yookassa_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Yookassa') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_yookassa_enabled'] != 'on' && $admin_payments_details['is_yookassa_enabled'] == 'on' && !empty($admin_payments_details['yookassa_shop_id_key']) && !empty($admin_payments_details['yookassa_secret_key'])) == 'on' ? 'active' : '' }}"
                                id="yookassa_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                    id="payment-form" action="{{ route('admin.pay.yookassa.payment') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="yookassa_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="yookassa_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}"
                                                class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Yookassa end --}}

                    {{-- Xendit --}}
                    @if (
                        $admin_payments_details['is_Xendit_enabled'] == 'on' &&
                            !empty($admin_payments_details['Xendit_api_key']) &&
                            !empty($admin_payments_details['Xendit_token_key']))
                        <div id="Xendit_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Xendit') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_Xendit_enabled'] != 'on' && $admin_payments_details['is_Xendit_enabled'] == 'on' && !empty($admin_payments_details['Xendit_api_key']) && !empty($admin_payments_details['Xendit_token_key'])) == 'on' ? 'active' : '' }}"
                                id="Xendit_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="GET"
                                    id="payment-form" action="{{ route('admin.pay.Xendit.payment') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="Xendit_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="Xendit_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}"
                                                class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Xendit end --}}

                    {{-- Midtrans --}}
                    @if ($admin_payments_details['is_midtrans_enabled'] == 'on' && !empty($admin_payments_details['midtrans_secret_key']))
                        <div id="midtrans_payment" class="card">
                            <div class="card-header">
                                <h5>{{ __('Midtrans') }}</h5>
                            </div>
                            <div class="tab-pane {{ ($admin_payments_details['is_midtrans_enabled'] != 'on' && $admin_payments_details['is_midtrans_enabled'] == 'on' && !empty($admin_payments_details['midtrans_secret_key'])) == 'on' ? 'active' : '' }}"
                                id="midtrans_payment">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                    id="payment-form" action="{{ route('admin.pay.midtrans.payment') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-4 row">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-group w-100">
                                                        <label for="midtrans_coupon"
                                                            class="form-label">{{ __('Coupon') }}</label>
                                                        <input type="text" id="midtrans_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="{{ __('Enter Coupon Code') }}">
                                                    </div>
                                                    <div class="form-group ms-3 mt-4">
                                                        <a href="javascript:void(0)" class="text-muted apply-coupon"
                                                            data-toggle="tooltip" data-title="{{ __('Apply') }}"><i
                                                                class="fas fa-save"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <input type="submit" value="{{ __('Pay Now') }}"
                                                class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    {{-- Midtrans end --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script>
        var type = window.location.hash.substr(1);
        $('.list-group-item').removeClass('active');
        $('.list-group-item').removeClass('text-primary');
        if (type != '') {
            $('a[href="#' + type + '"]').addClass('active').removeClass('text-primary');
        } else {
            $('.list-group-item:eq(0)').addClass('active').removeClass('text-primary');
        }

        $(document).on('click', '.list-group-item', function() {
            $('.list-group-item').removeClass('active');
            $('.list-group-item').removeClass('text-primary');
            setTimeout(() => {
                $(this).addClass('active').removeClass('text-primary');
            }, 10);
        });

        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })

        $(document).ready(function() {
            $(document).on('click', '.apply-coupon', function() {
                var ele = $(this);
                var coupon = ele.closest('.row').find('.coupon').val();
                // console.log(coupon);
                $.ajax({
                    url: '{{ route('admin.apply.coupon') }}',
                    datType: 'json',
                    data: {
                        plan_id: '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}',
                        coupon: coupon
                    },
                    success: function(data) {
                        $('.final-price').val(data.price);
                        $('#final_price_pay').val(data.price);
                        $('#stripe_coupon', '#mollie_coupon', 'paytm_coupon', '#paypal_coupon',
                            '#flutterwave_coupon', '#coingate_coupon').val(coupon);
                        if (data.is_success == true) {
                            show_toastr('Success', data.message, 'success');
                        } else if (data.is_success == false) {
                            show_toastr('Error', data.message, 'error');
                        } else {
                            show_toastr('Error', 'Coupon code is required', 'error');
                        }
                    }
                })
            });
        });
    </script>

    <script type="text/javascript">
        @if (
            $plan->price > 0.0 &&
                isset($admin_payments_details['is_stripe_enabled']) &&
                $admin_payments_details['is_stripe_enabled'] == 'on')

            var stripe = Stripe('<?php echo $admin_payments_details['publishable_key']; ?>');

            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '14px',
                    color: '#32325d',
                },
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style
            });
            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        $("#card-errors").html(result.error.message);
                        show_toastr('Error', result.error.message, 'error');
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        @endif
        function preparePayment(ele, payment) {
            var coupon = $(ele).closest('.row').find('.coupon').val();
            var amount = 0;
            $.ajax({
                url: '{{ route('admin.plan.prepare.amount') }}',
                datType: 'json',
                data: {
                    plan_id: '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}',
                    coupon: coupon
                },
                success: function(data) {

                    if (data.is_success == true) {
                        amount = data.price;
                        $('#coupon_use_id').val(data.coupon_id);
                    } else {
                        show_toastr('Error', 'Paymenent request failed', 'error');
                    }

                }
            })
        }
    </script>

    <script type="text/javascript">
        @if (isset($admin_payments_details['is_paystack_enabled']) && $admin_payments_details['is_paystack_enabled'] == 'on')

            $("#pay_with_paystack").click(function() {
                $(document).ready(function() {
                    $('#paystack-payment-form').ajaxForm(function(res) {
                        if (res.flag == 1) {
                            var paystack_callback = "{{ url('/admin/plan/paystack') }}";
                            var order_id = '{{ time() }}';
                            var coupon_id = res.coupon;
                            var handler = PaystackPop.setup({
                                key: '{{ $admin_payments_details['paystack_public_key'] }}',
                                email: res.email,
                                amount: res.total_price * 100,
                                currency: res.currency,
                                ref: 'pay_ref_id' + Math.floor((Math.random() *
                                        1000000000) +
                                    1
                                ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                metadata: {
                                    custom_fields: [{
                                        display_name: "Email",
                                        variable_name: "email",
                                        value: res.email,
                                    }]
                                },

                                callback: function(response) {
                                    window.location.href = paystack_callback + '/' +
                                        response
                                        .reference + '/' +
                                        '{{ encrypt($plan->id) }}' +
                                        '?coupon_id=' + coupon_id
                                },
                                onClose: function() {
                                    alert('window closed');
                                }
                            });
                            handler.openIframe();
                        } else if (res.flag == 2) {}
                    }).submit();
                });
            });
        @endif

        @if (isset($admin_payments_details['is_razorpay_enabled']) && $admin_payments_details['is_razorpay_enabled'] == 'on')
            // Razorpay Payment
            @php
                $logo = asset(Storage::url('uploads/logo/'));
                $company_logo = \App\Models\Utility::getValByName('company_logo');
            @endphp
            $(document).on("click", "#pay_with_razorpay", function() {
                $('#razorpay-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {
                        var razorPay_callback = '{{ url('/admin/plan/razorpay') }}';
                        var totalAmount = res.total_price * 100;
                        var coupon_id = res.coupon;
                        var currency = res.currency;
                        var options = {
                            "key": "{{ $admin_payments_details['razorpay_public_key'] }}", // your Razorpay Key Id
                            "amount": totalAmount,
                            "name": 'Plan',
                            "currency": currency,
                            "description": "",
                            "image": "{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}",
                            "handler": function(response) {
                                window.location.href = razorPay_callback + '/' + response
                                    .razorpay_payment_id + '/' +
                                    '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}?coupon_id=' +
                                    coupon_id;
                            },
                            "theme": {
                                "color": "#528FF0"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    } else if (res.flag == 2) {

                    } else {
                        show_toastr('error', 'This coupon code is invalid or has expired.');
                    }

                }).submit();
            });
        @endif

        @if (
            $admin_payments_details['is_payfast_enabled'] == 'on' &&
                !empty($admin_payments_details['payfast_merchant_id']) &&
                !empty($admin_payments_details['payfast_merchant_key']))
            $(document).ready(function() {
                get_payfast_status(amount = 0, coupon = null);
            })

            function get_payfast_status(amount, coupon) {
                var plan_id = $('#plan_id').val();


                $.ajax({
                    url: '{{ route('admin.payfast.payment') }}',
                    method: 'POST',
                    data: {
                        'plan_id': plan_id,
                        'coupon_amount': amount,
                        'coupon_code': coupon
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {

                        if (data.success == true) {
                            $('#get-payfast-inputs').append(data.inputs);

                        } else {
                            show_toastr('Error', data.inputs, 'error')
                        }
                    }
                });
            }
        @endif
    </script>

    @if (
        !empty($admin_payments_details['is_flutterwave_enabled']) &&
            isset($admin_payments_details['is_flutterwave_enabled']) &&
            $admin_payments_details['is_flutterwave_enabled'] == 'on')
        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
        <script src="{{ asset('public/js/jquery.form.js') }}"></script>
        <script>
            // is_flutterwave_enabled Payment

            $(document).on("click", "#pay_with_flaterwave", function() {
                $('#flaterwave-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {
                        var coupon_id = res.coupon;

                        var API_publicKey = '{{ $admin_payments_details['public_key'] }}';
                        var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                        var flutter_callback = "{{ url('admin/plan/flaterwave') }}";
                        var x = getpaidSetup({
                            PBFPubKey: API_publicKey,
                            customer_email: '{{ Auth::user()->email }}',
                            amount: res.total_price,
                            currency: res.currency,
                            txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) +
                                'fluttpay_online-' +
                                {{ date('Y-m-d') }},
                            meta: [{
                                metaname: "payment_id",
                                metavalue: "id"
                            }],
                            onclose: function() {},
                            callback: function(response) {
                                var txref = response.tx.txRef;
                                if (
                                    response.tx.chargeResponseCode == "00" ||
                                    response.tx.chargeResponseCode == "0"
                                ) {
                                    window.location.href = flutter_callback + '/' + txref +
                                        '/' +
                                        '{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}?coupon_id=' +
                                        coupon_id + '&payment_frequency=' + res
                                        .payment_frequency;
                                } else {
                                    // redirect to a failure page.
                                }
                                x
                                    .close(); // use this to close the modal immediately after payment.
                            }
                        });
                    } else if (res.flag == 2) {

                    } else {
                        show_toastr('Error', data.message, 'msg');
                    }

                }).submit();
            });
        </script>
    @endif


@endpush
