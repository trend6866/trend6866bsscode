<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\MainCategory;
use App\Models\UserCoupon;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CouponExport;
use App\Models\shopifyconection;
use App\Models\woocommerceconection;

class CouponController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next)
        {
            $this->user = Auth::user();
            $this->store = Store::where('id', $this->user->current_store)->first();
            $this->APP_THEME = $this->store->theme_id;

        return $next($request);
        });
    }

    public function index()
    {
        if (\Auth::user()->can('Manage Product Coupon'))
        {
            $coupons = Coupon::where('theme_id', APP_THEME())->where('store_id',getCurrentStore())->get();
            return view('coupon.index', compact('coupons'));
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
        $product = Product::where('theme_id',APP_THEME())->where('store_id',getCurrentStore())->pluck('name','id')->toArray();
        $category = MainCategory::where('theme_id',APP_THEME())->where('store_id',getCurrentStore())->pluck('name','id')->toArray();
        // dd($product ,$category);
        return view('coupon.create' ,compact('product','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Product Coupon'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'coupon_name' => 'required',
                    'coupon_type' => 'required',
                    'discount_amount' => 'required',
                    'coupon_limit' => 'required',
                    'coupon_expiry_date' => 'required',
                    'coupon_code' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $coupon                       = new Coupon();
            $coupon->coupon_name          = $request->coupon_name;
            $coupon->coupon_type          = $request->coupon_type;
            if($request->coupon_type == 'fixed product discount'){
                $coupon->applied_product = implode(',', !empty($coupon->applied_product) ? (array)$coupon->applied_product : []);
                $coupon->exclude_product = implode(',', !empty($coupon->exclude_product) ? (array)$coupon->exclude_product : []);
                $coupon->applied_categories   = implode(',' ,!empty($coupon->applied_categories) ? (array)$coupon->applied_categories : []);
                $coupon->exclude_categories   = implode(',' ,!empty($coupon->exclude_categories) ? (array)$coupon->exclude_categories : []);
            }
            $coupon->minimum_spend        = $request->minimum_spend;
            $coupon->maximum_spend        = $request->maximum_spend;
            $coupon->discount_amount      = $request->discount_amount;
            $coupon->coupon_limit         = $request->coupon_limit;
            $coupon->coupon_limit_user    = $request->coupon_limit_user;
            $coupon->coupon_limit_x_item  = $request->coupon_limit_x_item;
            $coupon->coupon_expiry_date   = $request->coupon_expiry_date;
            $coupon->coupon_code          = trim($request->coupon_code);
            $coupon->status               = $request->status;
            $coupon->sale_items           = $request->sale_items;
            $coupon->free_shipping_coupon = $request->free_shipping_coupon;
            $coupon->theme_id             = APP_THEME();
            $coupon->store_id             = getCurrentStore();
            $coupon->save();

            return redirect()->back()->with('success', __('Coupon successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        if (\Auth::user()->can('Show Product Coupon'))
        {
            $UserCoupons = UserCoupon::where('coupon_id', $coupon->id)->get();
            return view('coupon.show', compact('UserCoupons'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $product = Product::where('theme_id',APP_THEME())->where('store_id',getCurrentStore())->pluck('name','id')->toArray();
        $category = MainCategory::where('theme_id',APP_THEME())->where('store_id',getCurrentStore())->pluck('name','id')->toArray();
        $applied_product = explode(',',$coupon->applied_product);
        $exclude_product = explode(',',$coupon->exclude_product);
        $applied_categories = explode(',',$coupon->applied_categories);
        $exclude_categories = explode(',',$coupon->exclude_categories);

        return view('coupon.edit', compact('coupon','product','category','applied_product','exclude_product','applied_categories','exclude_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        if (\Auth::user()->can('Edit Product Coupon'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'coupon_name' => 'required',
                    'coupon_type' => 'required',
                    'discount_amount' => 'required',
                    'coupon_limit' => 'required',
                    'coupon_expiry_date' => 'required',
                    'coupon_code' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $coupon->coupon_name          = $request->coupon_name;
            $coupon->coupon_type          = $request->coupon_type;
            if($request->coupon_type == 'fixed product discount'){
                $coupon->applied_product = implode(',', !empty($request->applied_product) ? (array)$request->applied_product : []);
                $coupon->exclude_product = implode(',', !empty($request->exclude_product) ? (array)$request->exclude_product : []);

                $coupon->applied_categories   = implode(',' ,!empty($request->applied_categories) ? (array)$request->applied_categories : []);
                $coupon->exclude_categories   = implode(',' ,!empty($request->exclude_categories) ? (array)$request->exclude_categories : []);
            }
            $coupon->minimum_spend        = $request->minimum_spend;
            $coupon->maximum_spend        = $request->maximum_spend;
            $coupon->discount_amount      = $request->discount_amount;
            $coupon->coupon_limit         = $request->coupon_limit;
            $coupon->coupon_expiry_date   = $request->coupon_expiry_date;
            $coupon->coupon_limit_user    = $request->coupon_limit_user;
            $coupon->coupon_limit_x_item  = $request->coupon_limit_x_item;
            $coupon->coupon_code          = trim($request->coupon_code);
            $coupon->status               = $request->status;
            $coupon->sale_items           = $request->sale_items;
            $coupon->free_shipping_coupon = $request->free_shipping_coupon;
            $coupon->save();

            return redirect()->back()->with('success', __('Coupon successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if (\Auth::user()->can('Delete Product Coupon'))
        {

            woocommerceconection::where('original_id', $coupon->id)->delete();

            shopifyconection::where('original_id', $coupon->id)->delete();

            $coupon->delete();
            return redirect()->back()->with('success', __('Coupon delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fileExport()
    {
        $fileName = 'Coupon.xlsx';
        return Excel::download(new CouponExport, $fileName);
    }

}
