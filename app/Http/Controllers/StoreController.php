<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\User;
use App\Models\UserStore;
use App\Models\Plan;
use App\Models\Admin;
use App\Models\PlanOrder;
use App\Models\Order;
use App\Models\Utility;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\MainCategory;
use App\Models\Newsletter;
use App\Models\AppSetting;
use App\Models\Setting;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Shipping;
use App\Models\SubCategory;
use App\Models\Page;
use App\Models\Tax;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use Lab404\Impersonate\Impersonate;

class StoreController extends Controller
{
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
            if($this->user->type != 'superadmin')
            {
            $this->store = Store::where('id', $this->user->current_store)->first();
            $this->APP_THEME = $this->store->theme_id;
        }
        return $next($request);
        });
    }

    public function index()
    {
        if(\Auth::user()->can('Manage Store'))
        {
            $users = Admin::select(
                [
                    'admins.*',
                ]
            )->join('stores', 'stores.created_by', '=', 'admins.id')->where('admins.created_by', \Auth::guard('admin')->user()->creatorId())->where('admins.type', '=', 'admin')->groupBy('admins.id')->get();


            $stores = Store::get();
            return view('store.index',compact('users','stores'));
        }
        else
        {
            return redirect()->back()->with('error', __('Something went wrong'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::guard('admin')->user();
        if(\Auth::user()->can('Create Admin Store'))
        {
            $plan = Plan::find($user->plan);
            if(!empty($plan->themes))
            {
              $themes =  explode(',',$plan->themes);

            }
            return view('store.create',compact('themes','plan'));
        }
        return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Admin Store'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'storename' => 'required',
                ]
            );
        }else{
            $validator = \Validator::make(
                $request->all(),
                [
                    'storename' => 'required',
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                ]
            );
        }

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }


        if(\Auth::guard('admin')->user()->type == 'superadmin'){
            $admin_lang = \Auth::user()['default_language'];

            $objUser = Admin::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => 'admin',
                    'email_verified_at' => date("Y-m-d H:i:s"),
                    'password' => Hash::make($request->password),
                    'theme_id' => 'grocery',
                    'created_by' => 1,
                    'register_type' => 'email',
                    'plan' => Plan::first()->id,
                    'default_language' => $admin_lang,
                    ]
                );

            $slug = Admin::slugs($request->storename);

            $objStore = Store::create(
                [
                    'name' => $request->storename,
                    'email' => $request->email,
                    'theme_id' => $objUser->theme_id,
                    'slug' => $slug,
                    'created_by' => $objUser->id,
                    'default_language' => $admin_lang,
                    'content' => 'Hi,
                        *Welcome to* {store_name},
                        Your order is confirmed & your order no. is {order_no}
                        Your order detail is:
                        Name : {customer_name}
                        Address : {billing_address} {billing_city} , {shipping_address} {shipping_city}
                        ~~~~~~~~~~~~~~~~
                        {item_variable}
                        ~~~~~~~~~~~~~~~~
                        Qty Total : {qty_total}
                        Sub Total : {sub_total}
                        Discount Price : {discount_amount}
                        Shipping Price : {shipping_amount}
                        Tax : {total_tax}
                        Total : {final_total}
                        ~~~~~~~~~~~~~~~~~~
                        To collect the order you need to show the receipt at the counter.
                        Thanks {store_name}
                        ',
                'item_variable' => '{quantity} x {product_name} - {variant_name} + {item_tax} = {item_total}',
                ]
            );
            // dd($objStore);
            $objUser->current_store = $objStore->id;
            $objUser->userDefaultDataRegister($objUser->id);

            $objStore->save();
            $objUser->save();

            UserStore::create(
                [
                    'user_id' => $objUser->id,
                    'store_id' => $objStore->id,
                    'permission' => 'admin',
                ]
            );
            $objUser->assignRole('admin');
            $objUser->userEmailTemplateData($objUser->id);
            $objUser->userDefaultDataRegister($objUser->id);
            $data = [
                ['name'=>'enable_storelink', 'value'=> 'on', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_domain', 'value'=> 'off', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'domains', 'value'=> '', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_subdomain', 'value'=> 'off', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'subdomain', 'value'=> '', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'stock_management', 'value'=> 'on', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'notification', 'value'=> '[]', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'low_stock_threshold', 'value'=> '2', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'out_of_stock_threshold', 'value'=> '0', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()]
            ];
            DB::table('settings')->insert($data);

            // $OrderRefund = [
            //     ['name'=>'Manage Stock','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            //     ['name'=>'Attachment','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            //     ['name'=>'Shipment amount deduct during','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            // ];
            // DB::table('order_refund_settings')->insert($OrderRefund);

            Utility::app_setting_insert($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::page_insert($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::WhatsappMeassage($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::orderRefundSetting($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::faqs_insert($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::coupon_insert($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::taxes_insert($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::shipping_insert($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::shipping_methods($objUser->id ,$objStore->id, $objUser->theme_id);
            Utility::shipping_zones($objUser->id ,$objStore->id, $objUser->theme_id);

        }else{
            if(\Auth::user()->can('Create Admin Store'))
            {
                $user = \Auth::guard('admin')->user();
                $total_store = $user->countStore();

                $creator = Admin::find($user->creatorId());
                $plan = Plan::find($creator->plan);

                $slug = Admin::slugs($request->storename);

                if ($total_store < $plan->max_stores || $plan->max_stores == -1)
                {
                    $objStore = Store::create(
                        [
                            'name' => $request->storename,
                            'email' => $user->email,
                            'theme_id' => $request->theme_id,
                            'slug' => $slug,
                            'created_by' => $user->type == 'admin' ? $user->id : $user->created_by,
                            'default_language' => $user->default_language,
                            'content' => 'Hi,
                                *Welcome to* {store_name},
                                Your order is confirmed & your order no. is {order_no}
                                Your order detail is:
                                Name : {customer_name}
                                Address : {billing_address} {billing_city} , {shipping_address} {shipping_city}
                                ~~~~~~~~~~~~~~~~
                                {item_variable}
                                ~~~~~~~~~~~~~~~~
                                Qty Total : {qty_total}
                                Sub Total : {sub_total}
                                Discount Price : {discount_amount}
                                Shipping Price : {shipping_amount}
                                Tax : {total_tax}
                                Total : {final_total}
                                ~~~~~~~~~~~~~~~~~~
                                To collect the order you need to show the receipt at the counter.
                                Thanks {store_name}
                                ',
                            'item_variable' => '{quantity} x {product_name} - {variant_name} + {item_tax} = {item_total}',

                        ]
                    );

                    $objStore->save();
                    $objUser = \Auth::user();
                    UserStore::create(
                        [
                            'user_id' => $objUser->type == 'admin' ? $objUser->id : $objUser->created_by,
                            'store_id' => $objStore->id,
                            'permission' => 'admin',
                        ]
                    );

                    $objUser1 = $objUser->is_assign;
                    $objUser_a = explode(',',$objUser1);
                    $objUser_a[] = $objStore->id;
                    $objUser->is_assign = implode(',', $objUser_a);

                    $objUser->update();

                    $data = [
                        ['name'=>'enable_storelink', 'value'=> 'on', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'enable_domain', 'value'=> 'off', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'domains', 'value'=> '', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'enable_subdomain', 'value'=> 'off', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'subdomain', 'value'=> '', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'stock_management', 'value'=> 'on', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'notification', 'value'=> '[]', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'low_stock_threshold', 'value'=> '2', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()],
                        ['name'=>'out_of_stock_threshold', 'value'=> '0', 'theme_id'=> $request->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $user->id, 'created_at'=> now(), 'updated_at'=> now()]
                    ];
                    DB::table('settings')->insert($data);

                    // $OrderRefund = [
                    //     ['name'=>'Manage Stock','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
                    //     ['name'=>'Attachment','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
                    //     ['name'=>'Shipment amount deduct during','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
                    // ];
                    // DB::table('order_refund_settings')->insert($OrderRefund);

                    Utility::app_setting_insert($user->id ,$objStore->id, $request->theme_id);
                    Utility::page_insert($user->id ,$objStore->id, $request->theme_id);
                    Utility::WhatsappMeassage($user->id ,$objStore->id, $request->theme_id);
                    Utility::orderRefundSetting($user->id ,$objStore->id, $request->theme_id);
                    Utility::faqs_insert($user->id ,$objStore->id, $request->theme_id);
                    Utility::coupon_insert($user->id ,$objStore->id, $request->theme_id);
                    Utility::taxes_insert($user->id ,$objStore->id, $request->theme_id);
                    Utility::shipping_insert($user->id ,$objStore->id, $request->theme_id);
                    Utility::shipping_methods($user->id ,$objStore->id, $request->theme_id);
                    Utility::shipping_zones($user->id ,$objStore->id, $request->theme_id);

                }
                else {
                    return redirect()->back()->with('error', __('Your Store limit is over, Please upgrade plan'));
                }
            }


        }
        return redirect()->back()->with('success', __('Store created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::guard('admin')->user()->type == 'superadmin') {
            $user = Admin::find($id);
            $user_store = UserStore::where('user_id', $id)->first();
            $store = Store::where('id', $user_store->store_id)->first();

            return view('store.edit', compact('store', 'user'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::guard('admin')->user()->type == 'superadmin') {
            $store = Store::find($id);
            $user_store = UserStore::where('store_id', $id)->first();
            $user = Admin::where('id', $user_store->user_id)->first();

            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'storename' => 'required|max:120',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $store['name'] = $request->storename;
            $store['email'] = $request->email;

            $store->update();

            $user['name'] = $request->name;
            $user['email'] = $request->email;
            $user->update();

            return redirect()->back()->with('success', __('Successfully Updated!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::guard('admin')->user()->type == 'superadmin') {
            if (isset($id)) {
                $user = Admin::find($id);
                $user_stores = UserStore::where('user_id', $id)->get();
                foreach ($user_stores as $user_store) {
                    $store_id = $user_store->store_id;
                    Store::where('id', $store_id)->delete();
                    UserStore::where('store_id', $store_id)->delete();
                    Page::where('store_id', $store_id)->delete();
                    Order::where('store_id', $store_id)->delete();
                    AppSetting::where('store_id', $store_id)->delete();
                    Blog::where('store_id', $store_id)->delete();
                    Contact::where('store_id', $store_id)->delete();
                    Coupon::where('store_id', $store_id)->delete();
                    MainCategory::where('store_id', $store_id)->delete();
                    Newsletter::where('store_id', $store_id)->delete();
                    PlanOrder::where('store_id', $store_id)->delete();
                    Review::where('store_id', $store_id)->delete();
                    Setting::where('store_id', $store_id)->delete();
                    Shipping::where('store_id', $store_id)->delete();
                    SubCategory::where('store_id', $store_id)->delete();
                    Tax::where('store_id', $store_id)->delete();
                    // Wishlist::where('store_id', $store_id)->delete();
                    ProductVariant::where('store_id', $store_id)->delete();
                    DB::table('shetabit_visits')->where('store_id',$store_id)->delete();
                    $products = Product::where('store_id', $store_id)->get();
                    $store = Store::find($store_id);
                    $pro_img = new ProductController();
                    foreach ($products as $pro) {
                        $pro_img->destroy($pro);
                    }
                    if ($store) {
                        $store->delete();
                    }
                    $user_store->delete();
                }
                $user->delete();
                // Product::where('store_id', $store->id)->delete();
                return redirect()->back()->with(
                    'success', __('Store Deleted!')
                );
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function changeCurrantStore($storeID)
    {
        $objStore = Store::find($storeID);
        if ($objStore->is_active) {
            $objUser = Auth::guard('admin')->user();
            $objUser->current_store = $storeID;
            $objUser->update();

            return redirect()->back()->with('success', __('Store Change Successfully!'));
        } else {
            return redirect()->back()->with('error', __('Store is locked'));
        }
    }

    public function upgradePlan($user_id)
    {
        if (Auth::guard('admin')->user()->type == 'superadmin')
        {
            $user = Admin::find($user_id);
            $plans = Plan::get();

            return view('store.plan', compact('user', 'plans'));
        }
    }

    public function activePlan($user_id, $plan_id)
    {

        if (Auth::guard('admin')->user()->type == 'superadmin') {

            $user = Admin::find($user_id);
            $assignPlan = $user->assignPlan($plan_id);
            $plan = Plan::find($plan_id);
            if ($assignPlan['is_success'] == true && !empty($plan)) {
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                PlanOrder::create(
                    [
                        'order_id' => $orderID,
                        'name' => null,
                        'card_number' => null,
                        'card_exp_month' => null,
                        'card_exp_year' => null,
                        'plan_name' => $plan->name,
                        'plan_id' => $plan->id,
                        'price' => $plan->price,
                        'price_currency' => Utility::GetValueByName('CURRENCY_NAME'),
                        'txn_id' => '',
                        'payment_type' => __('Manually'),
                        'payment_status' => 'succeeded',
                        'receipt' => null,
                        'user_id' => $user->id,
                        'store_id' => getCurrentStore(),
                    ]
                );

                return redirect()->back()->with('success', __('Plan successfully upgraded.'));
            } else {
                return redirect()->back()->with('error', __('Plan fail to upgrade.'));
            }
        }

    }

    public function employeePassword($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = Admin::find($eId);

        return view('store.reset', compact('user'));
    }

    public function employeePasswordReset(Request $request, $id)
    {

        $validator = \Validator::make(
            $request->all(), [
                'password' => 'required|confirmed|same:password_confirmation',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $user = Admin::where('id', $id)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return redirect()->back()->with(
            'success', 'User Password successfully updated.'
        );

    }

    public function ownerstoredestroy($id)
    {
        $user = \Auth::guard('admin')->user();
        $store = Store::find($id);
        $user_stores = UserStore::where('user_id', $user->id)->count();

        if ($user_stores > 1) {
            UserStore::where('store_id', $store->id)->delete();
            Page::where('store_id', $store->id)->delete();
            Order::where('store_id', $store->id)->delete();
            AppSetting::where('store_id', $store->id)->delete();
            Blog::where('store_id', $store->id)->delete();
            Contact::where('store_id', $store->id)->delete();
            Coupon::where('store_id', $store->id)->delete();
            MainCategory::where('store_id', $store->id)->delete();
            Newsletter::where('store_id', $store->id)->delete();
            PlanOrder::where('store_id', $store->id)->delete();
            Review::where('store_id', $store->id)->delete();
            Setting::where('store_id', $store->id)->delete();
            Shipping::where('store_id', $store->id)->delete();
            SubCategory::where('store_id', $store->id)->delete();
            Tax::where('store_id', $store->id)->delete();
            ProductVariant::where('store_id', $store->id)->delete();
            // Wishlist::where('store_id', $store->id)->delete();

            DB::table('shetabit_visits')->where('store_id', $store->id)->delete();
            
            $products = Product::where('store_id', $store->id)->get();
            $pro_img = new ProductController();
            foreach ($products as $pro) {
                $pro_img->destroy($pro);
            }
            // Product::where('store_id', $store->id)->delete();

            $store->delete();
            $userstore = UserStore::where('user_id', $user->id)->first();

            $user->current_store = $userstore->id;
            $user->save();

            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->with('error', __('You have only one store'));
        }
    }

    public function pwasetting(Request $request, $id)
    {
        $company_favicon = Utility::getValByName('company_favicon');
        $store = Store::find($id);
        $store['enable_pwa_store'] = $request->pwa_store ?? 'off';
        if ($request->pwa_store == 'on')
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'pwa_app_title' => 'required|max:100',
                    'pwa_app_name' => 'required|max:50',
                    'pwa_app_background_color' => 'required|max:15',
                    'pwa_app_theme_color' => 'required|max:15',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            // $logo1 = Utility::keyWiseUpload_file('uploads/logo/');
            // $logo1        = 'themes/'.APP_THEME().'/uploads';
            // $company_favicon = Utility::getValByName('company_favicon');

            $theme_name = !empty(APP_THEME()) ? APP_THEME() : '';
            $favicon = \App\Models\Utility::GetValueByName('favicon',$theme_name);
            $favicon = get_file($favicon , APP_THEME());

            if($store->enable_storelink == 'on'){
                $start_url = env('APP_URL');
            }else if($store->enable_domain == 'on'){
                $start_url = 'https://'.$store->domains;
            }else{
                // $start_url = 'https://'. $store->subdomain;
                $start_url = env('APP_URL');
            }

            $mainfest =
                '{
                    "lang": "' . $store['lang'] . '",
                    "name": "' . $request->pwa_app_title . '",
                    "short_name": "' . $request->pwa_app_name . '",
                    "start_url": "' . $start_url . $store['slug'] . '",
                    "display": "standalone",
                    "background_color": "' . $request->pwa_app_background_color . '",
                    "theme_color": "' . $request->pwa_app_theme_color . '",
                    "orientation": "portrait",
                    "categories": [
                        "shopping"
                    ],
                    "icons": [
                        {
                            "src": "' . $favicon . '",
                            "sizes": "128x128",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "144x144",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "152x152",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "192x192",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "256x256",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "512x512",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "1024x1024",
                            "type": "image/png",
                            "purpose": "any"
                        }
                    ]
                }';
                // dd($mainfest);
            if (!file_exists('storage/uploads/customer_app/store_' . $id)) {
                mkdir(storage_path('uploads/customer_app/store_' . $id), 0777, true);
            }

            if (!file_exists('storage/uploads/customer_app/store_' . $id . '/manifest.json')) {

                fopen('storage/uploads/customer_app/store_' . $id . "/manifest.json", "w");

            }

            \File::put('storage/uploads/customer_app/store_' . $id . '/manifest.json', $mainfest);
        }
        $store->update();
        return redirect()->back()->with('success', __('PWA setting successfully Update.'));
    }

    public function customMassage(Request $request, $slug)
    {
        $validator = \Validator::make(
            $request->all(), [
                'content' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $store = Store::where('slug', $slug)->first();
        $store->content = $request['content'];
        $store->item_variable = $request['item_variable'];
        $store->update();

        return redirect()->back()->with('success', __('Massage successfully updated.'));
    }

    public function LoginWithAdmin(Request $request, Admin $user,  $id)
    {
        $user = Admin::find($id);
        if ($user && auth()->check()) {
            Impersonate::take($request->user(), $user);
            return redirect('admin/dashboard');
        }
    }

    public function ExitAdmin(Request $request)
    {
        Auth::user()->leaveImpersonation($request->user());
        return redirect('admin/dashboard');
    }

    public function StoreLinks(Request $request,$id)
    {
        $user = Admin::find($id);
        $stores = Store::where('created_by',$user->id)->get();

        return view('store.view-storelinks',compact('stores'));
    }
}
