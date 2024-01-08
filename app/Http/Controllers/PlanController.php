<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanCoupon;
use App\Models\Utility;
use App\Models\PlanOrder;
use App\Models\Addon;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objUser = \Auth::guard('admin')->user();
        if (\Auth::user()->can('Manage Plan'))
        {
            if ($objUser->type == 'superadmin') {
                $orders = PlanOrder::select(
                    [
                        'plan_orders.*',
                        'admins.name as user_name',
                    ]
                )->join('admins', 'plan_orders.user_id', '=', 'admins.id')->orderBy('plan_orders.created_at', 'DESC')->get();
            } else {
                $orders = PlanOrder::select(
                    [
                        'plan_orders.*',
                        'admins.name as user_name',
                    ]
                )->join('admins', 'plan_orders.user_id', '=', 'admins.id')->orderBy('plan_orders.created_at', 'DESC')->where('admins.id', '=', $objUser->id)->get();
            }

            $plans = Plan::get();
            $setting = Utility::getAdminPaymentSetting();
            // $admin_payments_setting = Utility::getAdminPaymentSetting();
            return view('plans.index', compact('plans','setting','orders'));

        }
        else
        {
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
        if (\Auth::user()->can('Create Plan')) {
            $arrDuration = Plan::$arrDuration;
            $theme = Addon::where('status','1')->get();

            return view('plans.create', compact('arrDuration','theme'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Plan'))
        {
            if (\Auth::guard('admin')->user()->type == 'superadmin' || (isset($admin_payments_setting['is_stripe_enabled']) && $admin_payments_setting['is_stripe_enabled'] == 'on'))
            {
                $validation = [];
                $validation['name'] = 'required|unique:plans';
                $validation['price'] = 'required|numeric|min:0';
                $validation['duration'] = 'required';
                $validation['max_stores'] = 'required|numeric';
                $validation['max_products'] = 'required|numeric';
                $validation['max_users'] = 'required|numeric';
                $validation['storage_limit'] = 'required|numeric';

                $request->validate($validation);
                $post = $request->all();
                if($request->has('themes')){
                    $post['themes'] = implode(',',$request->themes);
                }

                if (Plan::create($post)) {
                    return redirect()->back()->with('success', __('Plan created Successfully!'));
                } else {
                    return redirect()->back()->with('error', __('Something is wrong'));
                }
            } else {
                return redirect()->back()->with('error', __('Please set atleast one payment api key & secret key for add new plan'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($plan_id)
    {
        if (\Auth::user()->can('Edit Plan'))
        {
            $arrDuration = Plan::$arrDuration;
            $plan = Plan::find($plan_id);
            $theme = Addon::where('status','1')->get();

            return view('plans.edit', compact('plan', 'arrDuration','theme'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $planID)
    {
        if (\Auth::user()->can('Edit Plan'))
        {
            if (\Auth::guard('admin')->user()->type == 'superadmin' || (isset($admin_payments_setting['is_stripe_enabled']) && $admin_payments_setting['is_stripe_enabled'] == 'on'))
            {
                $plan = Plan::find($planID);
                if ($plan) {
                    if ($plan->price > 0) {
                        $validator = \Validator::make(
                            $request->all(), [
                                'name' => 'required|unique:plans,name,' . $planID,
                                'price' => 'required|numeric|min:0',
                                'duration' => 'required',
                                'max_stores' => 'required|numeric',
                                'max_products' => 'required|numeric',
                                'max_users' => 'required|numeric',
                                'storage_limit' => 'required|numeric',
                            ]
                        );
                    } else {
                        $validator = \Validator::make(
                            $request->all(), [
                                'name' => 'required|unique:plans,name,' . $planID,
                                'duration' => 'required',
                                'max_stores' => 'required|numeric',
                                'max_products' => 'required|numeric',
                                'max_users' => 'required|numeric',
                                'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:20480',
                            ]
                        );
                    }
                    {

                    }
                    if ($validator->fails()) {
                        $messages = $validator->getMessageBag();

                        return redirect()->back()->with('error', $messages->first());
                    }

                    $post = $request->all();

                    if (!isset($request->enable_domain)) {
                        $post['enable_domain'] = 'off';
                    }
                    if (!isset($request->enable_subdomain)) {
                        $post['enable_subdomain'] = 'off';
                    }
                    if (!isset($request->enable_chatgpt)) {
                        $post['enable_chatgpt'] = 'off';
                    }
                    if (!isset($request->pwa_store)) {
                        $post['pwa_store'] = 'off';
                    }

                    if (!isset($request->shipping_method)) {
                        $post['shipping_method'] = 'off';
                    }

                    if($request->has('themes')){
                        $post['themes'] = implode(',',$request->themes);
                    }

                    if ($plan->update($post)) {
                        return redirect()->back()->with('success', __('Plan updated Successfully!'));
                    } else {
                        return redirect()->back()->with('error', __('Something is wrong'));
                    }
                } else {
                    return redirect()->back()->with('error', __('Plan not found'));
                }
            } else {
                return redirect()->back()->with('error', __('Please set atleast one payment api key & secret key for add new plan'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }

    public function planPrepareAmount(Request $request)
    {

        $plan = Plan::find(\Illuminate\Support\Facades\Crypt::decrypt($request->plan_id));

        if ($plan) {
            $original_price = number_format($plan->price);
            $coupons = PlanCoupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
            $coupon_id = null;
            if (!empty($coupons)) {
                $usedCoupun = $coupons->used_coupon();
                if ($coupons->limit == $usedCoupun) {
                } else {
                    $discount_value = ($plan->price / 100) * $coupons->discount;
                    $plan_price = $plan->price - $discount_value;
                    $price = $plan->price - $discount_value;
                    $discount_value = '-' . $discount_value;
                    $coupon_id = $coupons->id;
                    return response()->json(
                        [
                            'is_success' => true,
                            'discount_price' => $discount_value,
                            'final_price' => $price,
                            'price' => $plan_price,
                            'coupon_id' => $coupon_id,
                            'message' => __('Coupon code has applied successfully.'),
                        ]
                    );
                }
            } else {
                return response()->json(
                    [
                        'is_success' => true,
                        'final_price' => $original_price,
                        'coupon_id' => $coupon_id,
                        'price' => $plan->price,
                    ]
                );
            }
        }
    }
}
