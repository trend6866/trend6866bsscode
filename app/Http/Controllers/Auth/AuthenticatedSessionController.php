<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AppSetting;
use App\Models\MainCategory;
use App\Models\Page;
use App\Models\SubCategory;
use App\Models\Utility;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Store;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use App\Models\ActivityLog;
use Illuminate\Validation\Rule;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
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

        if(\Request::route()->getName() != 'logout')
        {
            // $this->middleware('auth');
            // $this->middleware(function ($request, $next)
            // {
                // $this->user = Auth::user();
                // $this->store = Store::where('id', $this->user->current_store)->first();
                // $user = User::where('type','superadmin')->first();
                // $store = Store::where('created_by',$user->id)->first();
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
        if($uri == '{slug}/login')
        {
            $theme_json = $homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $has_subcategory = $this->has_subcategory;
            $search_products = $this->products;
            $featured_products = $this->featured_products;

            return view('Auth.login', compact('slug','homepage_json','pages','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products'));
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request ,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $email = $request->email;
        $user = User::where('email',$email)->where('store_id',$store->id)->first();

        if(!empty($user)){
            $user->last_active = date('Y-m-d');
            $user->save();

            // last login activity log
            $ActivityLog = new ActivityLog();
            $ActivityLog->user_id = $user->id;
            $ActivityLog->log_type = 'last login';
            $ActivityLog->remark = json_encode(
                ['date' => date('Y-m-d')]
            );
            $ActivityLog->theme_id = $user->theme_id;
            $ActivityLog->store_id = $user->store_id;
            $ActivityLog->save();

        }

        if(!empty($user->status) == 0){
            $request->authenticate();

            $request->session()->regenerate();

            $uri = \Request::route()->uri();

            if(!empty($user))
            {

                if(Auth::user()->register_type != 'email') {
                    Auth::logout();
                    return redirect()->back()->withErrors(['msg' => __('Customer not able to login.')]);
                }
                // if($uri == 'admin/login' && Auth::user()->type == 'customer') {
                //     Auth::logout();
                //     return redirect()->back()->withErrors(['msg' => __('Customer not able to login.')]);
                // }
                // elseif($uri == 'admin/login' && $user->type == 'superadmin') {
                //     return redirect('admin/dashboard');
                // }
                // elseif($uri == 'admin/login' && $user->type == 'admin') {
                //     return redirect('admin/dashboard');
                // }

                elseif($uri == 'login' && Auth::user()->type != 'customer') {
                    Auth::logout();
                    return redirect()->back()->withErrors(['msg' => __('Only customer can login here.')]);
                }

                elseif($uri == '{slug}/login' && Auth::user()->type == 'customer') {
                    $user_id = Auth::user()->id;
                    Cart::cookie_to_cart($user_id,$store->id);
                    return redirect('/'.$slug);
                }
                else {
                    Auth::logout();
                    return redirect()->back()->withErrors(['msg' => __('Whoops! Something went wrong.')]);
                }
            }else{
                Auth::logout();
                return redirect()->back()->withErrors(['msg' => __('Whoops! Something went wrong.')]);
            }
        }
        else{
            return redirect()->back()->with('error', __('Your Account is deactivated please contact to your store owner.'));
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }


}
