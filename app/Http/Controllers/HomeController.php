<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\AppSetting;
use App\Models\Contact;
use App\Models\Home;
use App\Models\Page;
use App\Models\Faq;
use App\Models\MainCategory;
use App\Models\Blog;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Setting;
use App\Models\Utility;
use App\Models\Cart;
use App\Models\country;
use App\Models\state;
use App\Models\City;
use App\Models\Shipping;
use App\Models\Review;
use App\Models\Order;
use App\Models\Productquestion;
use App\Models\User;
use App\Models\PlanOrder;
use App\Models\DeliveryAddress;
use App\Models\ProductStock;
use App\Models\Plan;
use App\Models\Admin;
use App\Models\PixelFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use App\Models\Coupon;
use App\Models\FlashSale;
use App\Models\OrderBillingDetail;
use App\Models\OrderRefund;
use App\Models\PlanCoupon;
use App\Models\PlanRequest;
use Codexshaper\WooCommerce\Facades\Customer;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Theme;
use DB;

class HomeController extends Controller
{
    public function __construct(Request $request)
    {

        if(!file_exists(storage_path() . "/installed"))
        {
            header('location:install');
            die;
        }

            $uri = url()->full();
            $segments = explode('/', str_replace(''.url('').'', '', $uri));
            $segments = $segments[1] ?? null;

            $local = parse_url(config('app.url'))['host'];
            // Get the request host
            $remote = request()->getHost();
            // Get the remote domain
            // remove WWW
            $remote = str_replace('www.', '', $remote);
            $subdomain = Setting::where('name','subdomain')->where('value',$remote)->first();
            $domain = Setting::where('name','domains')->where('value',$remote)->first();

            $enable_subdomain = "";
            $enable_domain = "";

            if($subdomain || $domain ){
                if($subdomain){
                    $enable_subdomain = Setting::where('name','enable_subdomain')->where('value','on')->where('store_id',$subdomain->store_id)->first();
                }

                if($domain){
                    $enable_domain = Setting::where('name','enable_domain')->where('value','on')->where('store_id',$domain->store_id)->first();
                }
            }
            if( $enable_domain || $enable_subdomain) {

                $admin_user = "";
                if($subdomain){
                    $enable_subdomain = Setting::where('name','enable_subdomain')->where('value','on')->where('store_id',$subdomain->store_id)->first();
                    if($enable_subdomain){
                        $admin_user = Admin::find($enable_subdomain->created_by);
                    }
                }


                if($domain){
                    $enable_domain = Setting::where('name','enable_domain')->where('value','on')->where('store_id',$domain->store_id)->first();
                    if($enable_domain){
                        $admin_user = Admin::find($enable_domain->created_by);
                    }
                }



                if($admin_user != ""){

                    $this->store = Store::find($admin_user->current_store);
                    $this->APP_THEME = $this->store->theme_id;
                    $path = base_path('themes/'.$this->APP_THEME.'/theme_json/web/homepage.json');
                    $this->homepage_json = json_decode(file_get_contents($path), true);
                    $homepage_json_Data = AppSetting::where('theme_id', $this->APP_THEME)->where('page_name', 'home_page_web')->where('store_id',$this->store->id)->first();
                    if(!empty($homepage_json_Data)) {
                        $this->homepage_json = json_decode($homepage_json_Data->theme_json, true);
                    }

                    $this->pages = Page::where('theme_id', $this->APP_THEME)->where('status','1')->where('store_id',$this->store->id)->get();
                    $this->MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',$this->store->id)->get();

                    $this->SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',$this->store->id)->get();
                    $this->has_subcategory = Utility::ThemeSubcategory($this->APP_THEME);

                    $this->products = Product::where('theme_id',$this->APP_THEME)->where('store_id',$this->store->id)->get()->pluck('name','id');
                    $request->merge(['theme_id' => $this->APP_THEME]);
                    $ApiController = new ApiController();

                    $featured_products_data = $ApiController->featured_products($request, $this->store->slug);
                    $this->featured_products = $featured_products_data->getData();

                }

            }
            elseif($subdomain== "" && $domain=="" && request()->segments() && request()->segment(1) != 'admin')
            {
                $slug = request()->segment(1);
                $this->store = Store::where('slug', $slug)->first();
                if($this->store){
                    $this->APP_THEME = $this->store->theme_id;
                    $path = base_path('themes/'.$this->APP_THEME.'/theme_json/web/homepage.json');
                    $this->homepage_json = json_decode(file_get_contents($path), true);
                    $homepage_json_Data = AppSetting::where('theme_id', $this->APP_THEME)->where('page_name', 'home_page_web')->where('store_id',getCurrentStore())->first();
                    if(!empty($homepage_json_Data)) {
                        $this->homepage_json = json_decode($homepage_json_Data->theme_json, true);
                    }

                    $this->pages = Page::where('theme_id', $this->APP_THEME)->where('status','1')->where('store_id',getCurrentStore())->get();
                    $this->MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

                    $this->SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
                    $this->has_subcategory = Utility::ThemeSubcategory($this->APP_THEME);

                    $this->products = Product::where('theme_id',$this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');
                    $request->merge(['theme_id' => $this->APP_THEME]);
                    $ApiController = new ApiController();
                    $featured_products_data = $ApiController->featured_products($request);
                    $this->featured_products = $featured_products_data->getData();
                }
            }else
            {
                $this->middleware('auth');
                $this->middleware(function ($request, $next)
                {
                    $this->user = Auth::user();
                    if($this->user->type != 'superadmin')
                    {
                        $this->store = Store::where('id', $this->user->current_store)->first();
                        $this->APP_THEME = $this->store->theme_id;

                        $path = base_path('themes/'.$this->APP_THEME.'/theme_json/web/homepage.json');
                        $this->homepage_json = json_decode(file_get_contents($path), true);
                        $homepage_json_Data = AppSetting::where('theme_id', $this->APP_THEME)->where('page_name', 'home_page_web')->where('store_id',getCurrentStore())->first();
                        if(!empty($homepage_json_Data)) {
                            $this->homepage_json = json_decode($homepage_json_Data->theme_json, true);
                        }

                        $this->pages = Page::where('theme_id', $this->APP_THEME)->where('status','1')->where('store_id',getCurrentStore())->get();
                        $this->MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
                        $this->SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
                        $this->has_subcategory = Utility::ThemeSubcategory($this->APP_THEME);

                        $this->products = Product::where('theme_id',$this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');

                        $request->merge(['theme_id' => $this->APP_THEME]);
                        $ApiController = new ApiController();
                        $featured_products_data = $ApiController->featured_products($request);
                        $this->featured_products = $featured_products_data->getData();
                    }

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
        if (\Auth::check()){
            if (\Auth::guard('admin')->user()->type == 'superadmin'){
                $user = \Auth::guard('admin')->user();
                $user['total_user'] = $user->countCompany();
                $user['total_orders'] = PlanOrder::total_orders();
                $user['total_plan'] = Plan::total_plan();
                $chartData = $this->getOrderChart(['duration' => 'week']);
                $topAdmins = Admin::select([
                    'admins.*',
                    DB::raw('(SELECT COUNT(*) FROM user_stores WHERE user_stores.user_id = admins.id) AS store_count')
                ])
                ->where('admins.type', '=', 'admin')
                ->where('admins.created_by', \Auth::guard('admin')->user()->creatorId())
                ->orderBy('store_count', 'desc')
                ->limit(5)
                ->get();
                $vistor = DB::table('shetabit_visits')->pluck('store_id','id')->toarray();
                $visitors = array_count_values($vistor);

                $plan_order = Plan::most_purchese_plan();
                $coupons = PlanCoupon::get();
                $maxValue = 0; // Initialize with a minimum value
                $couponName = '';
                foreach ($coupons as $coupon) {
                    $max = $coupon->used_coupon();
                    if ($max > $maxValue) {
                        $maxValue = $max;
                        $couponName = $coupon->name;
                    }
                }

                $topAdmins = Admin::select([
                    'admins.*',
                    DB::raw('(SELECT COUNT(*) FROM user_stores WHERE user_stores.user_id = admins.id) AS store_count')
                ])
                ->where('admins.type', '=', 'admin')
                ->where('admins.created_by', \Auth::guard('admin')->user()->creatorId())
                ->orderBy('store_count', 'desc')
                ->limit(5)
                ->get();
                $vistor = DB::table('shetabit_visits')->pluck('store_id','id')->toarray();
                $visitors = array_count_values($vistor);

                $plan_order = Plan::most_purchese_plan();
                $coupons = PlanCoupon::get();
                $maxValue = 0; // Initialize with a minimum value
                $couponName = '';
                foreach ($coupons as $coupon) {
                    $max = $coupon->used_coupon();
                    if ($max > $maxValue) {
                        $maxValue = $max;
                        $couponName = $coupon->name;
                    }
                }

                $allStores = Order::select('store_id', \DB::raw('SUM(final_price) as total_amount'))
                            ->groupBy('store_id')
                            ->orderByDesc('total_amount')
                            ->limit(5)
                            ->get();
                $plan_requests = PlanRequest::all()->count();

                return view('admin/dashboard',compact('user','chartData','couponName','plan_order','plan_requests','topAdmins','visitors','allStores'));

            }
            else
            {
                if(\Auth::user()->can('Manage Dashboard'))
                {
                    $totalproduct = Product::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->count();

                    $totle_order = Order::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->count();
                    $totle_sales = User::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->count();
                    $totle_cancel_order = Order::where('theme_id', $this->APP_THEME)->where('delivered_status',2)->where('store_id',getCurrentStore())->count();

                    $total_refund_requests = OrderRefund::where('theme_id', $this->APP_THEME)->where('refund_status','Refunded')->where('store_id', getCurrentStore())->count();

                    $total_revenues = Order::where('theme_id', $this->APP_THEME)
                        ->where('store_id', getCurrentStore())
                        ->where(function ($query) {
                        $query->where(function ($subquery) {
                            $subquery->where('delivered_status', '!=', 2)
                                    ->where('delivered_status', '!=', 3);
                        })->orWhere('return_status', '!=', 2);
                        })
                        ->sum('final_price');
                    $topSellingProductIds = Order::where('theme_id', $this->APP_THEME)
                        ->where('store_id', getCurrentStore())
                        ->get()
                        ->pluck('product_id')
                        ->flatMap(function ($productIds) {
                            return explode(',', $productIds);
                        })
                        ->map(function ($productId) {
                            return (int)$productId;
                        })
                        ->groupBy(function ($productId) {
                            return $productId;
                        })
                        ->map(function ($group) {
                            return $group->count();
                        })
                        ->sortDesc()
                        ->take(5)
                        ->keys();

                    $topSellingProducts = Product::whereIn('id', $topSellingProductIds)->get();
                    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
                    $out_of_stock_threshold =\App\Models\Utility::GetValueByName('out_of_stock_threshold',$theme_name);
                    $latests   = Product::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->limit(5)->get();
                    $new_orders = Order::orderBy('id', 'DESC')->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->limit(5)->get();
                    $chartData = $this->getOrderChart(['duration' => 'week']);

                    $topSellingProductIds = Order::where('theme_id', $this->APP_THEME)
                        ->where('store_id', getCurrentStore())
                        ->get()
                        ->pluck('product_id')
                        ->flatMap(function ($productIds) {
                            return explode(',', $productIds);
                        })
                        ->map(function ($productId) {
                            return (int)$productId;
                        })
                        ->groupBy(function ($productId) {
                            return $productId;
                        })
                        ->map(function ($group) {
                            return $group->count();
                        })
                        ->sortDesc()
                        ->take(5)
                        ->keys();

                    $topSellingProducts = Product::whereIn('id', $topSellingProductIds)->get();


                    $store = Store::where('id',getCurrentStore())->first();
                    $slug = $store->slug;

                    //for storage
                    $users = Admin::find(\Auth::user()->creatorId());
                    $plan = Plan::find($users->plan);
                    if($plan->storage_limit > 0)
                    {
                        $storage_limit = ($users->storage_limit / $plan->storage_limit) * 100;
                    }
                    else{
                        $storage_limit = 0;
                    }
                    $theme_url = route('landing_page',$slug);
                    return view('dashboard',compact('totalproduct','totle_order','totle_sales','latests','new_orders','chartData','theme_url','store','users','plan','storage_limit','topSellingProducts','total_revenues','total_refund_requests','totle_cancel_order','out_of_stock_threshold','theme_name'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }

            }
        }else{
            return redirect()->back()->with('error', __('Please login.'));
        }
    }

    public function getOrderChart($arrParam)
    {
        $user = \Auth::guard('admin')->user();
        $store = Store::where('id',$user->current_store)->first();

        // $userstore = $this->APP_THEME;

        $userstore = $store->theme_id;
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ($arrParam['duration'] == 'week') {
                $previous_week = strtotime("-1 week +1 day");

                for ($i = 0; $i < 7; $i++) {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }
        $arrTask = [];
        $arrTask['label'] = [];
        $arrTask['data'] = [];
        foreach ($arrDuration as $date => $label) {
            if (Auth::guard('admin')->user()->type == 'admin') {
                $data = Order::select(\DB::raw('count(*) as total'))->where('theme_id', $userstore)->where('store_id',getCurrentStore())->whereDate('created_at', '=', $date)->first();
                $registerTotal = User::select(\DB::raw('count(*) as total'))->where('theme_id', $userstore)->where('store_id',getCurrentStore())->where('regiester_date', '!=', NULL)->whereDate('regiester_date', '=', $date)->first();
                $newguestTotal = User::select(\DB::raw('count(*) as total'))->where('theme_id', $userstore)->where('store_id',getCurrentStore())->where('regiester_date', '=', NULL)->whereDate('last_active', '=', $date)->first();
            } else {
                $data = PlanOrder::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            }

            $arrTask['label'][] = $label;
            $arrTask['data'][] = $data->total;
            if(\Auth::user()->can('Manage Dashboard'))
            {
                $arrTask['registerTotal'][] = $registerTotal->total;
                $arrTask['newguestTotal'][] = $newguestTotal->total;

            }
        }

        return $arrTask;
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
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        //
    }

    public function profile()
    {
        $userDetail = \Auth::guard('admin')->user();

        return view('profile', compact('userDetail'));
    }

    public function editprofile(Request $request)
    {
        // dd($request->All());
        $userDetail = \Auth::guard('admin')->user();
        $dir        = 'themes/'.APP_THEME().'/uploads';
        $rule['name'] = 'required';
        $rule['email'] = 'required';

        $validator = \Validator::make($request->all(), $rule);
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        if ($request->hasFile('profile_image')) {
            $fileName = rand(10,100).'_'.time() . "_" . $request->profile_image->getClientOriginalName();
            $path = Utility::upload_file($request,'profile_image',$fileName,$dir,[]);
            // dd($path);

        }

        $user_id = Auth::guard('admin')->user()->id;
        $user               = Admin::Where('id', $user_id)->first();
        if (!empty($request->profile_image)) {
            $user['profile_image'] = $path['url'];
        }
        $user->name   = $request->name;
        $user->email        = $request->email;

        $user->save();

        return redirect()->back()->with('success', __('Personal info successfully updated.'));
    }


    public function landing_page(Request $request , $slug)
    {
        $uri = url()->full();
        $segments = explode('/', str_replace(''.url('').'', '', $uri));
        $segments = $segments[1] ?? null;

        $local = parse_url(config('app.url'))['host'];
        // Get the request host
        $remote = request()->getHost();
        // Get the remote domain
        // remove WWW
        $remote = str_replace('www.', '', $remote);
        $subdomain = Setting::where('name','subdomain')->where('value',$remote)->first();
        $domain = Setting::where('name','domains')->where('value',$remote)->first();

        $enable_subdomain = "";
        $enable_domain = "";

        if($subdomain || $domain ){
            if($subdomain){
                $enable_subdomain = Setting::where('name','enable_subdomain')->where('value','on')->where('store_id',$subdomain->store_id)->first();
            }

            if($domain){
                $enable_domain = Setting::where('name','enable_domain')->where('value','on')->where('store_id',$domain->store_id)->first();
            }
        }
        if( $enable_domain || $enable_subdomain) {


            if($subdomain){
                $enable_subdomain = Setting::where('name','enable_subdomain')->where('value','on')->where('store_id',$subdomain->store_id)->first();
                if($enable_subdomain){
                    $admin = Admin::find($enable_subdomain->created_by);
                    if($enable_subdomain->value == 'on' &&  $enable_subdomain->store_id == $admin->current_store){
                        $store = Store::find($admin->current_store);
                        if($store){
                            return $this->storeSlug($store->slug);
                        }
                    }
                    else{
                        return $this->storeSlug($segments);
                    }
                }
            }


            if($domain){
                $enable_domain = Setting::where('name','enable_domain')->where('value','on')->where('store_id',$domain->store_id)->first();
                if($enable_domain){
                    $admin = Admin::find($enable_domain->created_by);
                    if($enable_domain->value == 'on' &&  $enable_domain->store_id == $admin->current_store){
                        $store = Store::find($admin->current_store);
                        if($store){
                            return $this->storeSlug($store->slug);
                        }
                    }
                    else{
                        return $this->storeSlug($segments);
                    }
                }
            }
        }
        else{
            return $this->storeSlug($segments);
        }

    }

    public function storeSlug($slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;
        visitor()->visit();

        $theme_json = $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $has_subcategory = $this->has_subcategory;
        $search_products = $this->products;
        $featured_products = $this->featured_products;
        //dd($search_products);
        //latest product
        $products = Product::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->inRandomOrder()->limit(12)->get();
        $currency = Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = Utility::GetValueByName('CURRENCY');

        //allproduct
        $all_products = Product::where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->inRandomOrder()->limit(20)->get();

        // bestseller
        $per_page = '12';
        $destination = 'web';
        $bestSeller_fun = Product::bestseller_guest($this->APP_THEME, $per_page, $destination);
        $bestSeller = [];
        if($bestSeller_fun['status'] == "success") {
            $bestSeller = $bestSeller_fun['bestseller_array'];
        }
        //modern product
        $modern_products = Product::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->limit(6)->get();
        $home_products = Product::orderBy('created_at', 'asc')->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->limit(4)->get();
        $homepage_products = Product::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->limit(2)->get();

        //categoriwiseproduct
        $MainCategory = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->get()->pluck('name','id');
        $MainCategory->prepend('All Products','0');
        $homeproducts = Product::where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->get();

        //discount product
        $discount_products = Product::orderBy('discount_amount','Desc')->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->limit(12)->get();

        //trending category
        $trending_categories = MainCategory::where('trending', 1)->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->limit(4)->get();

        //latestone product
        $latest_product = Product::where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->latest()->first();

        $reviews = Review::where('status',1)->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->get();

        $product_review = Review::where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->get();
        $random_review = Review::where('status',1)->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->inRandomOrder()->get();

        $landing_product = Product::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->first();
        $random_product = Product::where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->inRandomOrder()->first();

        $compact = [
            'slug',
            'homepage_json',
            'pages',
            'MainCategoryList',
            'SubCategoryList',
            'products',
            'currency',
            'currency_icon',
            'bestSeller' ,
            'all_products' ,
            'modern_products' ,
            'home_products' ,
            'MainCategory' ,
            'homeproducts' ,
            'discount_products' ,
            'trending_categories' ,
            'latest_product' ,
            'has_subcategory' ,
            'reviews' ,
            'search_products' ,
            'featured_products' ,
            'homepage_products' ,
            'product_review' ,
            'random_review',
            'landing_product',
            'random_product'

        ];

        return view('landing_page', compact($compact));
    }

    public function show_pages(Request $request ,$slug,$name)
    {
        $store = Store::where('slug',$slug)->first();
        if($store)
        {
            $theme_id = $store->theme_id;

            $homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $has_subcategory = $this->has_subcategory;
            $search_products = $this->products;
            $featured_products = $this->featured_products;

            $p = Page::where('page_slug', $name)->get();
            if($p->isEmpty()){
                return  redirect()->route('landing_page',$slug);
                // return view('errors/404');
            }

            if($name == 'about'){
                $pages_data = Page::where('theme_id', $this->APP_THEME)->where('name','About')->where('store_id',getCurrentStore())->get();
                return view('about', compact('slug','homepage_json','pages_data','pages','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
            }
            elseif($name == 'privacy-policy'){
                $pages_data = Page::where('theme_id', $this->APP_THEME)->where('name','Privacy Policy')->where('store_id',getCurrentStore())->get();
                return view('privacy-policys', compact('slug','homepage_json','pages','pages_data','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
            }
            elseif($name == 'contactus'){
                $pages_data = Page::where('theme_id', $this->APP_THEME)->where('name','Contactus')->where('store_id',getCurrentStore())->get();
                return view('contact-us', compact('slug','homepage_json','pages','pages_data','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
            }
            elseif($name == 'terms-and-conditions'){
                $pages_data = Page::where('theme_id', $this->APP_THEME)->where('name','Terms and conditions')->where('store_id',getCurrentStore())->get();
                return view('about', compact('slug','homepage_json','pages','pages_data','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
            }
            elseif($name == 'refund-policy'){
                $pages_data = Page::where('theme_id', $this->APP_THEME)->where('name','Refund Policy')->where('store_id',getCurrentStore())->get();
                return view('about', compact('slug','homepage_json','pages','pages_data','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
            }
            else{
                $pages_data = Page::where('theme_id', $this->APP_THEME)->where('page_slug',$name)->where('store_id',getCurrentStore())->get();
                return view('about', compact('slug','homepage_json','pages_data','pages','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
            }
        }
        else
        {
            if(Auth::guard('admin'))
            {
                return redirect('admin/dashboard');
            }
            else
            {
                return redirect('admin/login');
            }
        }

    }

    public function faqs_page(Request $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $has_subcategory = $this->has_subcategory;
        $search_products = $this->products;
        $featured_products = $this->featured_products;

        $faqs = Faq::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

        return view('faqs', compact('slug','homepage_json','faqs','pages','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
    }

    public function blog_page(Request $request , $slug)
    {
        $store = Store::where('slug',$slug)->first();
        if(empty($store))
        {
            return redirect()->back();
        }else{
            $theme_id = $store->theme_id;
        }

        $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $has_subcategory = $this->has_subcategory;
        $search_products = $this->products;
        $featured_products = $this->featured_products;

        $MainCategory = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');
        $MainCategory->prepend('All','0');

        $blogs = Blog::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

        return view('blog', compact('slug','homepage_json','MainCategory','blogs','pages','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
    }

    public function article_page(Request $request,$slug,$id)
    {
        $store = Store::where('slug',$slug)->first();
        if(empty($store))
        {
            return redirect()->back();
        }else{
            $theme_id = $store->theme_id;
        }

        $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $has_subcategory = $this->has_subcategory;
        $search_products = $this->products;
        $featured_products = $this->featured_products;

        $b = hashidsdecode($id);
        $blogs = Blog::where('id' ,$b)->where('store_id',getCurrentStore())->get();

        if($blogs->isEmpty()){
            // return  abort(404, 'Page not found.');
            return view('/');
        }

        $datas = Blog::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->inRandomOrder()
                ->limit(3)
                ->get();

        $l_articles = Blog::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->inRandomOrder()
                ->limit(5)
                ->get();

        $MainCategory = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');
        $MainCategory->prepend('All Products','0');
        $homeproducts = Product::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

        $blog1 = Blog::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

        return view('article', compact('slug','homepage_json','pages','MainCategoryList','SubCategoryList','blogs','datas','l_articles','has_subcategory','search_products','featured_products','MainCategory','homeproducts','blog1'));

    }

    public function product_page(Request $request ,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $filter_product = $request->filter_product;
        $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $filter_tag = $this->SubCategoryList;
        $has_subcategory = $this->has_subcategory;
        $search_products = $this->products;
        $featured_products = $this->featured_products;

        if (!$has_subcategory) {
            $filter_tag = $MainCategoryList;
        }
        $sub_category_select = [];
        $main_category = $request->main_category;
        $sub_category = $request->sub_category;
        if(!empty($main_category)) {
            if (!$has_subcategory) {
                $sub_category_select = MainCategory::where('id', $main_category)->pluck('id')->toArray();
            } else {
                $sub_category_select = SubCategory::where('maincategory_id', $main_category)->pluck('id')->toArray();
            }
        }

        if(!empty($sub_category)) {
            $sub_category_select = [];
            $sub_category_select[] = $sub_category;
        }

        // bestseller
        $per_page = '12';
        $destination = 'web';
        $bestSeller_fun = Product::bestseller_guest($this->APP_THEME, $per_page, $destination);
        $bestSeller = [];
        if($bestSeller_fun['status'] == "success") {
            $bestSeller = $bestSeller_fun['bestseller_array'];
        }

        $products_query = Product::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore());
        if(!empty($main_category)) {
            $products_query->where('category_id', $main_category);
        }
        if(!empty($sub_category)) {
            $products_query->where('subcategory_id', $sub_category);
        }
        $product_count = $products_query->count();

        /* For Filter */
        $min_price = 0;
        $max_price = Product::where('variant_product', 0)->orderBy('price', 'DESC')->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->first();
        $max_price = !empty($max_price->price) ? $max_price->price : '0';

        $theme_json = $homepage_json;
        $currency = Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = Utility::GetValueByName('CURRENCY');

        $MainCategory = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');
        $MainCategory->prepend('All Products','0');
        $homeproducts = Product::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

        $product_list = Product::orderBy('created_at', 'asc')->where('theme_id', $this->APP_THEME)->where('store_id',$store->id)->limit(4)->get();

        $compact = ['slug','homepage_json','pages','MainCategoryList','SubCategoryList','bestSeller','theme_json', 'currency', 'currency_icon', 'min_price', 'max_price','product_count','has_subcategory','filter_tag','search_products','sub_category_select','featured_products','filter_product','MainCategory','homeproducts','product_list'];

        return view('product-list', compact($compact));
    }

    public function product_page_filter(Request $request , $slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;


        $has_subcategory = $this->has_subcategory;
        $theme_id = $this->APP_THEME;
        if($request->ajax()) {
            $page = $request->page;
            $filter_value = $request->filter_product;
            $product_tag = $request->product_tag;
            $min_price = $request->min_price;
            $max_price = $request->max_price;
            $rating = $request->rating;

        } else {
            $page = $request->query('page', 1);
            $filter_value = $request->query('filter_product');
            $product_tag = $request->query('product_tag');
            $min_price = $request->query('min_price');
            $max_price = $request->query('max_price');
            $rating = $request->query('rating');
            // $queryParams = $request->query();
            // $page = 1;
        }
        $filter_value = $request->filter_product;
        $product_tag = $request->product_tag;
        $min_price   = $request->min_price;
        $max_price   = $request->max_price;
        $rating      = $request->rating;


        if(!empty($product_tag))
        {
            $tag = $product_tag;
            $product_tag = explode(",", $tag);
        }

        $products_query = Product::where('theme_id', $theme_id)->where('store_id',getCurrentStore());
        if(!empty($product_tag)) {
            if (!$has_subcategory) {
                $products_query->whereIn('category_id',$product_tag);
            } else {
                $products_query->whereIn('subcategory_id',$product_tag);
            }
        }
        if(!empty($max_price)) {
            $products_query->whereBetween('price',[$min_price,$max_price]);
        }
        if(!empty($rating)) {
            $products_query->where('average_rating',$rating);
        }
        if(!empty($filter_value)) {
            if($filter_value == 'best-selling') {
                $products_query->where('tag_api','best seller');
            }
            if($filter_value == 'trending') {
                $products_query->where('trending','1');
            }
            if($filter_value == 'title-ascending') {
                $products_query->orderBy('name', 'asc');
            }
            if($filter_value == 'title-descending') {
                $products_query->orderBy('name', 'Desc');
            }
            if($filter_value == 'price-ascending') {
                $products_query->orderBy('price', 'asc');
            }
            if($filter_value == 'price-descending') {
                $products_query->orderBy('price', 'Desc');
            }
            if($filter_value == 'created-ascending') {
                $products_query->orderBy('created_at', 'asc');
            }
            if($filter_value == 'created-descending') {
                $products_query->orderBy('created_at', 'Desc');
            }
        }
        $products = $products_query->paginate(12);
        $flashsales = FlashSale::where('theme_id', $theme_id)->where('store_id',getCurrentStore())->orderBy('created_at', 'Desc')->get();

        $currency = Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = Utility::GetValueByName('CURRENCY');

        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = date('Y-m-d H:i:s A');


        return view('product-list-filter', compact('slug','products', 'currency', 'page','currency_icon','flashsales','currentDateTime'))->render();
    }

    public function contact_page(Request $request , $slug)
    {
        $store = Store::where('slug',$slug)->first();
        if(!empty($store))
        {
            $theme_id = $store->theme_id;

            $homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $search_products = $this->products;
            $has_subcategory = $this->has_subcategory;
            $featured_products = $this->featured_products;

            $pages_data = Page::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->where('name','Contactus')->get();
            return view('contact-us', compact('slug','homepage_json','pages_data','pages','MainCategoryList','SubCategoryList','search_products','has_subcategory','featured_products'));
        }
        else
        {
            return redirect()->back();
        }
    }

    public function privacy_page(Request $request , $slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $search_products = $this->products;
        $has_subcategory = $this->has_subcategory;
        $featured_products = $this->featured_products;

        $pages_data = Page::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->where('name','Privacy Policy')->get();
        return view('privacy-policys', compact('slug','homepage_json','pages_data','pages','MainCategoryList','SubCategoryList','search_products','has_subcategory','featured_products'));
    }


    public function product_detail(Request $request,$slug,$id)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $theme_json = $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $has_subcategory = $this->has_subcategory;
        $search_products = $this->products;
        $featured_products = $this->featured_products;

        $p = hashidsdecode($id);

        $Stocks = ProductStock::where('product_id', $p)->first();
        if ($Stocks) {
            $minPrice = ProductStock::where('product_id', $p)->min('price');
            $maxPrice = ProductStock::where('product_id', $p)->max('price');

            $min_vprice = ProductStock::where('product_id', $p)->min('variation_price');
            $max_vprice = ProductStock::where('product_id', $p)->max('variation_price');

            $mi_price = !empty($minPrice) ? $minPrice : $min_vprice;
            $ma_price = !empty($maxPrice) ? $maxPrice : $max_vprice;
        }
        else
        {
            $mi_price = 0;
            $ma_price = 0;
        }

        $currency = Utility::GetValueByName('CURRENCY_NAME');
        $currency_icon = Utility::GetValueByName('CURRENCY');

        $per_page = '12';
        $destination = 'web';
        $bestSeller_fun = Product::bestseller_guest($this->APP_THEME, $per_page, $destination);
        $bestSeller = [];
        if($bestSeller_fun['status'] == "success") {
            $bestSeller = $bestSeller_fun['bestseller_array'];
        }

        $products = product::whereIn('id', $p)->get();
        $product_review = Review::where('product_id',$p)->get();
        // dd($product_review);
        if($products->isEmpty())
        {
            return redirect()->route('page.product-list',$slug)->with('error', __('Product not found.'));
        }

        $wishlist = Wishlist::where('product_id',$p)->get();
        $latest_product = Product::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->latest()->first();

        $MainCategory = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');
        $MainCategory->prepend('All Products','0');
        $homeproducts = Product::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
        $M_products = product::whereIn('id', $p)->first();
        $product_stocks = ProductStock::where('product_id',$p)->where('theme_id', $this->APP_THEME)->limit(3)->get();
        $main_pro = Product::where('category_id',$M_products->category_id)->where('theme_id',$this->APP_THEME)->where('store_id',getCurrentStore())->inRandomOrder()->limit(3)->get();

        $random_review = Review::where('status',1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->inRandomOrder()->get();
        $reviews = Review::where('status',1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

        $lat_product = Product::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->inRandomOrder()->limit(2)->get();

        $question = Productquestion::where('theme_id',$this->APP_THEME)->where('product_id', $p)->where('store_id',getCurrentStore())->get();

        $flashsales = FlashSale::where('theme_id', $theme_id)->where('store_id',getCurrentStore())->orderBy('created_at', 'Desc')->get();

        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = date('Y-m-d H:i:s A');

        return view('product', compact('slug','homepage_json','products','MainCategoryList','SubCategoryList','pages','currency','currency_icon','theme_json','bestSeller','product_review','wishlist','has_subcategory','latest_product','search_products','featured_products','MainCategory','homeproducts','M_products','product_stocks','main_pro','lat_product','random_review','reviews','question','mi_price','ma_price','flashsales','currentDateTime'));

    }

    public function cart_page(Request $request ,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        if($store)
        {
            $theme_id = $store->theme_id;

            $theme_json =$homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $has_subcategory = $this->has_subcategory;
            $search_products = $this->products;
            $featured_products = $this->featured_products;

            $homepage_products = Product::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->get();


            $per_page = '12';
            $destination = 'web';
            $bestSeller_fun = Product::bestseller_guest($this->APP_THEME, $per_page, $destination);
            $bestSeller = [];
            if($bestSeller_fun['status'] == "success") {
                $bestSeller = $bestSeller_fun['bestseller_array'];
            }

            $MainCategory = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');
            $MainCategory->prepend('All Products','0');
            $homeproducts = Product::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();


            return view('cart', compact('slug','homepage_json', 'theme_json','MainCategoryList','homepage_products','SubCategoryList','pages', 'bestSeller','has_subcategory','search_products','featured_products','MainCategory','homeproducts'));
        }
        else
        {
            return redirect()->back()->with('error',__('Permission Denied.'));
        }

    }

    public function checkout(Request $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $theme_json = $homepage_json = $this->homepage_json;
        $pages = $this->pages;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $has_subcategory = $this->has_subcategory;
        $search_products = $this->products;
        $featured_products = $this->featured_products;

        $param = [
            'theme_id' => $this->APP_THEME,
            'user_id' => !empty(Auth::user()) ? Auth::user()->id : 0
        ];
        $request->merge($param);
        $api = new ApiController();

        $address_list_data = $api->address_list($request);
        $address_list = $address_list_data->getData();


        $country_option = country::pluck('name', 'id')->prepend('Select country', ' ');
        $settings = Setting::where('theme_id',$theme_id)->where('store_id',getCurrentStore())->pluck('value', 'name')->toArray();

        return view('checkout',compact('slug','homepage_json','theme_json','MainCategoryList','SubCategoryList','pages','has_subcategory','address_list','country_option','search_products','featured_products','settings'));
    }

    public function Theme()
    {
        $user = \Auth::guard('admin')->user();
        if($user->can('Manage Themes'))
        {
            $plan = Plan::find($user->plan);
            if(!empty($plan->themes))
            {
              $themes =  explode(',',$plan->themes);
            }
            return view('theme.front_theme',compact('themes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function themeChange($themeid)
    {
        $user = \Auth::guard('admin')->user();
        if($user->can('Edit Themes'))
        {
            $store = Store::where('id', $user->current_store)->first();

            $store->theme_id = $themeid;
            $store->save();

            Utility::WhatsappMeassage($user->id ,$store->id, $store->theme_id);
            Utility::orderRefundSetting($user->id ,$store->id, $store->theme_id);

            return response()->json(
                [
                    'is_success' => true,
                    'success' => __('Theme successfully updated!'),
                ], 200
            );
        }
        else
        {
            return response()->json(
                [
                    'is_error' => true,
                    'error' => __('Permission denied!'),
                ], 200
            );
        }

    }

    public function search_products(Request $request ,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $search_pro = $request->product;

        $products = product::where('name', 'LIKE', '%' . $search_pro . '%')->where('store_id',getCurrentStore())->get();
        // Check if any matching products were found
        if (!$products->isEmpty()) {
            // Create an array of product URLs
            $productData = [];

            // Populate the array with product names and URLs
            foreach ($products as $product) {
                $id = hashidsencode($product->id);
                $url = route('page.product', [$slug, $id]);

                $productData[] = [
                    'name' => $product->name,
                    'url' => $url,
                ];
            }

            return response()->json($productData);
        } else {
            // Handle the case where no matching products were found
            return response()->json([]);
        }
    }



    public function applycoupon(Request $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $coupon = Coupon::where('coupon_code',$request->coupon_code)->where('theme_id',$request->theme_id)->where('store_id',$store->id)->first();
        $theme_id = $store->theme_id;

        $param = [
            'theme_id' => $this->APP_THEME,
            'slug' => $slug,
            'store_id' => $store->id,
            'coupon'    => $coupon,
        ];

        $request->merge($param);
        $api = new ApiController();

        $apply_coupon = $api->apply_coupon($request);
        $coupon = $apply_coupon->getData();
        return response()->json($coupon);
    }

    public function paymentlist(Request $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $param = [
            'theme_id' => $this->APP_THEME,
            'user_id' => !empty(Auth::user()) ? Auth::user()->id : 0,
            'slug' => $slug,
            'store_id' => $store->id,
        ];
        $request->merge($param);
        $api = new ApiController();

        $payment_list_data = $api->payment_list($request);
        $payment_list = $payment_list_data->getData();
        $return['html_data'] = view('payment_list', compact('slug','payment_list'))->render();
        return response()->json($return);
    }

    public function additionalnote(Request $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $return['html_data'] = view('additional_note', compact('slug'))->render();
        return response()->json($return);
    }


    public function deliverylist(Request $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;


        $param = [
            'theme_id' => $this->APP_THEME,
            'user_id' => !empty(Auth::user()) ? Auth::user()->id : 0,
            'slug' => $slug,
            'store_id' => $store->id
        ];
        $request->merge($param);
        $api = new ApiController();

        $shipping_data = $api->shipping($request);
        $shipping_list = $shipping_data->getData();
        $return['html_data'] = view('shipping_list', compact('shipping_list'))->render();
        return response()->json($return);
    }

    public function order_summary(Request $request,$slug)
    {

        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $theme_json = $homepage_json = $this->homepage_json;
        $has_subcategory = $this->has_subcategory;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $pages = $this->pages;
        $search_products = $this->products;
        $featured_products = $this->featured_products;

        if(session('data'))
        {
            $order_id =  session('data');
            $orders_data = Order::where('product_order_id',$order_id)->where('store_id',$store->id)->where('theme_id',$theme_id)->first();
            return view('order-summary',compact('slug','homepage_json','theme_json','has_subcategory','MainCategoryList','SubCategoryList','pages','search_products','order_id','featured_products','orders_data'));

        }
        elseif(!empty($request['data']['order_id']) || ($request->responce['data']['order_id']))
        {
            if(!empty($request['data']['order_id']))
            {
                $order = $request['data']['order_id'];
            }else{
                $order = $request->responce['data']['order_id'];
            }
            $order_data = Order::find($order);
            return view('order-summary',compact('slug','homepage_json','theme_json','has_subcategory','MainCategoryList','SubCategoryList','pages','search_products','order_data','featured_products'));
        }else{
            return redirect()->route('landing_page',$slug);
        }

    }

    public function orderdetails($slug , $order_id)
    {
        try {
            $theme_json = $homepage_json = $this->homepage_json;

            $id = Crypt::decrypt($order_id);
            $order = Order::order_detail($id);
            $store = Store::where('id' ,getCurrentStore())->first();
            $order_data =  Order::where('id' ,$id)->where('store_id',$store->id)->first();

            $theme_name = $this->APP_THEME;

            if(!empty($order['message'])) {
                return redirect()->back()->with('error', __('Order Not Found.'));
            }
            return view('order_detail', compact('order','store','theme_name','order_data','homepage_json'));

        } catch (DecryptException $e) {
            return redirect()->back()->with('error', __('Something was wrong.'));
        }
    }
    public function order_track(Request $request,$slug)
    {

        $theme_json = $homepage_json = $this->homepage_json;
        $has_subcategory = $this->has_subcategory;
        $MainCategoryList = $this->MainCategoryList;
        $SubCategoryList = $this->SubCategoryList;
        $pages = $this->pages;
        $search_products = $this->products;
        $featured_products = $this->featured_products;
        $store = Store::where('slug',$slug)->pluck('id')->first();
        $store_data = Store::find($store);
        $user = User::where('email',$request->email)->first();

        if(!empty($request->order_number) ||  !empty($request->email)){

            $product_order_id = Order::where('store_id',$store)->get();
            $order_id =[];
            foreach($product_order_id as $order){
                $order_id[] = $order['product_order_id'];

            }
            $order_email = OrderBillingDetail::whereIn('product_order_id' ,$order_id)->pluck('email','email')->toArray();
            $order_number = Order::where('store_id',$store)->pluck('product_order_id','product_order_id')->toArray();
            if(in_array($request->email,$order_email) &&  in_array($request->order_number,$order_number)){
                $order_d = OrderBillingDetail::where('email',$request->email)->where('product_order_id' ,$request->order_number)->first();
                $order = Order::where('id' ,$order_d->order_id)->where('store_id',$store)->first();
                $order_status = Order::where('product_order_id' ,$request->order_number)->where('store_id',$store)->where('theme_id',$store_data->theme_id)->first();
            }
            elseif ( in_array($request->email,$order_email)){
                $order_d = OrderBillingDetail::where('email',$request->email)->first();
                $order = Order::where('id' ,$order_d->order_id)->where('store_id',$store)->first();
                $order_status = Order::where('id' ,$order_d->order_id)->where('store_id',$store)->where('theme_id',$store_data->theme_id)->first();

            }
            elseif(in_array($request->order_number,$order_number)){
                $order = Order::where('product_order_id' ,$request->order_number)->where('store_id',$store)->first();
                $order_status = Order::where('product_order_id' ,$request->order_number)->where('store_id',$store)->where('theme_id',$store_data->theme_id)->first();

            }else{
                return view('order-track',compact('slug','homepage_json','search_products','MainCategoryList','has_subcategory','pages'));

            }

            $order_detail = Order::order_detail($order->id);

            if(!empty($order))
            {
                $customer = User::where('email' ,$order->email)->first();
            } else {
                return redirect()->back()->with('error',__('Order not found.'));
            }

            return view('order-track',compact('order','order_status','order_detail','customer','slug','homepage_json','search_products','MainCategoryList','has_subcategory','pages'));
        }

    }

}
