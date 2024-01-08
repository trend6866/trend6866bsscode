<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\UserStore;
use App\Models\Plan;
use App\Models\Page;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\Utility;
use App\Models\Setting;
use App\Models\AppSetting;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Review;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        if( $enable_domain || $enable_subdomain ) {


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
        elseif(!$subdomain && !$domain && request()->segments() && request()->segment(1) != 'admin')
        {
            $slug = request()->segment(1);
            $this->store = Store::where('slug', $slug)->first();
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

            // config(['app.theme' => $this->APP_THEME]);
        }

    }

    public function Home()
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
                }
            }
        }
        else{
            $settings = Utility::Seting();
            if($settings['display_landing'] == 'on')
            {
                return view('landingpage::layouts.landingpage');
            }else{
                return redirect()->route('admin.login');
            }
        }
        // return view('layouts.landingpage');
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

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(env('RECAPTCHA_MODULE') == 'yes')
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }
        else
        {
            $validation = [];
        }
        $this->validate($request, $validation);

        $email = $request->email;

        $user = Admin::where('email',$email)->first();

        if (! Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            // RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // dd(Auth::guard('admin')->user());

        $request->session()->regenerate();

        $uri = \Request::route()->uri();

        if(Auth::guard('admin')->user()->register_type != 'email') {
            Auth::logout();
            return redirect()->back()->withErrors(['msg' => __('Customer not able to login.')]);
        }

        if($uri == 'admin/login' && Auth::guard('admin')->user()->type == 'customer') {
            Auth::logout();
            return redirect()->back()->withErrors(['msg' => __('Customer not able to login.')]);
        }
        elseif($uri == 'admin/login' && $user->type == 'superadmin') {
            return redirect('admin/dashboard');
        }
        elseif($uri == 'admin/login' && $user->type == 'admin') {
            $user = Admin::where('id', $user->id)->first();
            $datetime1 = new \DateTime($user->plan_expire_date);
            $datetime2 = new \DateTime(date('Y-m-d'));

            $interval = $datetime2->diff($datetime1);
            $days     = $interval->format('%r%a');
            // $plano = Plan::find(\Auth::user()->plan);
            $uri = \Request::route()->uri();
            // if($days <= 0 && $plano->name != "Renew" && $plano->name != "Free Plan" || $days <= 0 && $uri !=  "admin/plan" && $plano->name != "Free Plan")
            // {
            //     $plan = Plan::where('name','Renew')->first();
            //     $user->assignPlan($plan->id,$user->id);
            //     return redirect()->route('admin.plan.index')->with('error', __('Your Plan is expired.'));
            // }

            return redirect('admin/dashboard');
        }

        else {
            Auth::logout();
            return redirect()->back()->withErrors(['msg' => __('Whoops! Something went wrong.')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Admin $admin)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {
        $settings = \App\Models\Utility::Seting();
        if($settings['email_verification'] == "on")
        {
            if(env('RECAPTCHA_MODULE') == 'yes')
            {
                $validation['g-recaptcha-response'] = 'required|captcha';
            }
            else
            {
                $validation = [];
            }
            $this->validate($request, $validation);

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'store_name' => ['required', 'string', 'max:255'],
            ]);
            $admin_lang = Admin::where('type','superadmin')->first();
            $objUser = Admin::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => 'admin',
                    'register_type' => 'email',
                    'mobile' => !empty($request->mobile) ? $request->mobile :'',
                    // 'email_verified_at' => date("Y-m-d H:i:s"),
                    'password' => Hash::make($request->password),
                    'theme_id' => 'grocery',
                    'created_by' => 1,
                    'plan' => Plan::where('id','3')->first(),
                    'default_language' => $admin_lang['default_language'],
                    ]
                );

            $slug = Admin::slugs($request->store_name);

            $objStore = Store::create(
                [
                    'name' => $request->store_name,
                    'email' => $request->email,
                    'theme_id' => $objUser->theme_id,
                    'slug' => $slug,
                    'created_by' => $objUser->id,
                    'default_language' => $admin_lang['default_language'],
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

            $objUser->current_store = $objStore->id;

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
            Utility::WhatsappMeassage($objUser->id);
            Utility::orderRefundSetting($objUser->id);

            $data = [
                ['name'=>'enable_storelink', 'value'=> 'on', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_domain', 'value'=> 'off', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'domains', 'value'=> '', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_subdomain', 'value'=> 'off', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'subdomain', 'value'=> '', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()]
            ];
            DB::table('settings')->insert($data);

            // $OrderRefund = [
            //     ['name'=>'Manage Stock','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            //     ['name'=>'Attachment','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            //     ['name'=>'Shipment amount deduct during','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            // ];
            // DB::table('order_refund_settings')->insert($OrderRefund);

            if (! Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                // RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

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

                event(new Registered($objUser));
                Auth::login($objUser);

            } catch (\Exception $e) {
                $objUser->delete();

                return redirect('/admin/register')->with('status', __('Email SMTP settings does not configure so please contact to your site admin.'));
            }
            return redirect()->route('admin.verify-email');
        }
        else
        {
            if(env('RECAPTCHA_MODULE') == 'yes')
            {
                $validation['g-recaptcha-response'] = 'required|captcha';
            }
            else
            {
                $validation = [];
            }
            $this->validate($request, $validation);

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'store_name' => ['required', 'string', 'max:255'],
            ]);

            $admin_lang = Admin::where('type','superadmin')->first();
            $objUser = Admin::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => 'admin',
                    'register_type' => 'email',
                    'mobile' => !empty($request->mobile) ? $request->mobile :'',
                    'email_verified_at' => date("Y-m-d H:i:s"),
                    'password' => Hash::make($request->password),
                    'theme_id' => 'grocery',
                    'created_by' => 1,
                    'plan' => Plan::where('id','3')->first(),
                    'default_language' => $admin_lang['default_language'],
                    ]
                );

            $slug = Admin::slugs($request->store_name);

            $objStore = Store::create(
                [
                    'name' => $request->store_name,
                    'email' => $request->email,
                    'theme_id' => $objUser->theme_id,
                    'slug' => $slug,
                    'created_by' => $objUser->id,
                    'default_language' => $admin_lang['default_language'],
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

            $objUser->current_store = $objStore->id;

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
            Utility::WhatsappMeassage($objUser->id);
            Utility::orderRefundSetting($objUser->id);


            $data = [
                ['name'=>'enable_storelink', 'value'=> 'on', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_domain', 'value'=> 'off', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'domains', 'value'=> '', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_subdomain', 'value'=> 'off', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'subdomain', 'value'=> '', 'theme_id'=> $objUser->theme_id, 'store_id'=> $objStore->id, 'created_by'=> $objUser->id, 'created_at'=> now(), 'updated_at'=> now()]
            ];
            DB::table('settings')->insert($data);

            // $OrderRefund = [
            //     ['name'=>'Manage Stock','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            //     ['name'=>'Attachment','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            //     ['name'=>'Shipment amount deduct during','user_id'=>$objUser->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $objStore->id, 'created_at'=> now(), 'updated_at'=> now()],
            // ];
            // DB::table('order_refund_settings')->insert($OrderRefund);

            if (! Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                // RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
            return redirect(RouteServiceProvider::HOME);
        }

        // return redirect()->route('admin.dashboard');

    }

    public function verify_email()
    {
        return view('auth.verify-email');
    }

}
