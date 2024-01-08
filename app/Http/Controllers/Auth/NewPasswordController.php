<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\MainCategory;
use App\Models\Page;
use App\Models\SubCategory;
use App\Models\Utility;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Api\ApiController;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Returns the password broker for admins
     * 
     * @return broker
     */
    protected function broker()
    {
        return Password::broker('admins');
    }

    public function __construct(Request $request)
    {
        // dd('1');
        // $this->middleware('auth');
        // $this->middleware(function ($request, $next) 
        // {
        //     $this->user = Auth::user();
        //     $this->store = Store::where('id', $this->user->current_store)->first();
        //     $this->APP_THEME = $this->store->theme_id;
            
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

    public function create(Request $request ,$slug='')
    {
        $store = Store::where('slug',$slug)->first();
        if(!empty($store))
        {
            $theme_id = $store->theme_id;
        }
        
        $type = !empty($request->type) ? $request->type : '';
        $uri = \Request::route()->uri();

        if($type == 'admin') {
            return view('auth.reset-password', ['request' => $request]);
        } else {
            $theme_json = $homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $has_subcategory = $this->has_subcategory;
            $search_products = $this->products;
            $featured_products = $this->featured_products;

            
            return view('Auth.reset-password', compact('slug','homepage_json','pages','MainCategoryList','SubCategoryList', 'request','has_subcategory','search_products','featured_products'));
        }
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request ,$slug)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        // dd(!empty($request->type) && $request->type == "customer" , $request->all());
        if(!empty($request->login_type) && $request->login_type == "customer")
        {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(60),
                        ])->save();
                    event(new PasswordReset($user));
                }
            );
        }
        else{
            $status = Password::broker('admins')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(60),
                        ])->save();
                    $user->save();
    
                    event(new PasswordReset($user)); 
                }
            );
        }

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.

        if(!empty($request->type) && $request->type == "admin") {
            return $status == Password::PASSWORD_RESET
                ? redirect()->route('admin.login')->with('status', __($status))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
                        
        } else {
            return $status == Password::PASSWORD_RESET
                        ? redirect()->route('login',$slug)->with('status', __($status))
                        : back()->withInput($request->only('email'))
                                ->withErrors(['email' => __($status)]);      
        }

    }
}
