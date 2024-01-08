<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\MainCategory;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserAdditionalDetail;
use App\Models\Utility;
use App\Models\Product;
use App\Models\Store;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Api\ApiController;
use App\Models\ActivityLog;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */

    public function __construct(Request $request)
    {
        if(!file_exists(storage_path() . "/installed"))
        {
            header('location:install');
            die;
        }

        // $this->middleware('auth');
        // $this->middleware(function ($request, $next)
        // {
        //     $this->user = Auth::user();
        //     $this->store = Store::where('id', $this->user->current_store)->first();

            $slug = request()->segments()[0];
            $store = Store::where('slug', $slug)->first();
            if(empty($store))
            {
                return false;
            }

            $this->APP_THEME = APP_THEME();
            $path = base_path('themes/'.$this->APP_THEME.'/theme_json/web/homepage.json');
            $this->homepage_json = json_decode(file_get_contents($path), true);
            $homepage_json_Data = AppSetting::where('theme_id', $this->APP_THEME)->where('page_name', 'home_page_web')->where('store_id',getCurrentStore())->first();
            if(!empty($homepage_json_Data)) {
                $this->homepage_json = json_decode($homepage_json_Data->theme_json, true);
            }

            $this->pages = Page::where('theme_id', $this->APP_THEME)->where('status','1')->get();
            $this->MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->get();
            $this->SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->get();
            $this->has_subcategory = Utility::ThemeSubcategory($this->APP_THEME);
            $this->products = Product::where('theme_id',$this->APP_THEME)->get()->pluck('name','id');

            $request->merge(['theme_id' => $this->APP_THEME]);
            $ApiController = new ApiController();
            $featured_products_data = $ApiController->featured_products($request);
            $this->featured_products = $featured_products_data->getData();

        // return $next($request);
        // });


    }

    public function create($slug)
    {
        $store = Store::where('slug',$slug)->first();
        if(empty($store))
        {
            return redirect()->back();
        }
        $theme_id = $store->theme_id;

        $uri = \Request::route()->uri();
        if($uri == '{slug}/register'){

            $theme_json = $homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $has_subcategory = $this->has_subcategory;
            $search_products = $this->products;
            $featured_products = $this->featured_products;

            return view('Auth.register', compact('slug','homepage_json','pages','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
        }else{
            return view('auth.register');
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request , $slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'mobile' => ['required', 'string', 'max:255'],
        ]);

        // customer
        $insert_array['first_name'] = $request->first_name;
        $insert_array['last_name'] = $request->last_name;
        $insert_array['email'] = $request->email;
        $insert_array['register_type'] = 'email';
        $insert_array['type'] = 'customer';
        $insert_array['mobile'] = !empty($request->mobile) ? $request->mobile :'';
        $insert_array['password'] = Hash::make($request->password);
        // $insert_array['theme_id'] = !empty($this->APP_THEME) ? $this->APP_THEME : '';
        $insert_array['theme_id'] = !empty($store) ? $store->theme_id : '';
        $insert_array['store_id'] = !empty($store) ? $store->id : '';
        $insert_array['created_by'] = !empty($store) ? $store->created_by : '';
        $insert_array['regiester_date'] = date('Y-m-d');
        $insert_array['last_active'] = date('Y-m-d');

        // if(!empty($request->first_name))
        // {
        //     $slug = User::slugs($request->first_name);
        //     $insert_array['slug'] = $slug;
        // }

        $user = User::create($insert_array);

        UserAdditionalDetail::create([
            'user_id' => $user->id,
            'theme_id' => !empty($store) ? $store->theme_id : '',
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'log_type' => 'register',
            'store_id' => !empty($store) ? $store->id : '',
            'theme_id' => $this->APP_THEME,
        ]);

        event(new Registered($user));
        if($request->subscribe == 'yes'){
            $newsletter             = new Newsletter();
            $newsletter->email      = $request->email;
            $newsletter->user_id    = $user->id;
            $newsletter->theme_id   = $this->APP_THEME;
            $newsletter->store_id   = !empty($store) ? $store->id : '';
            $newsletter->save();
        }

        Auth::login($user);

        return redirect()->route('landing_page',$slug);
        // return redirect(RouteServiceProvider::HOME);
    }
}
