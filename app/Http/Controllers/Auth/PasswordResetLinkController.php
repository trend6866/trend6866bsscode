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
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Api\ApiController;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
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

    public function create($slug='')
    {
        $store = Store::where('slug',$slug)->first();
        if(!empty($store))
        {
            $theme_id = $store->theme_id;
        }

        $uri = \Request::route()->uri(); 
        if($uri == '{slug}/forgot-password') {
            $theme_json = $homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $has_subcategory = $this->has_subcategory;
            $search_products = $this->products;
            $featured_products = $this->featured_products;
            
            return view('Auth.forgot-password', compact('slug','homepage_json','pages','MainCategoryList','SubCategoryList','has_subcategory','search_products','featured_products')); 
        } else {
            return view('auth.forgot-password');
        }
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request,$slug='')
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
        
        if($request->type != 'admin')
        {
            $store = Store::where('slug',$slug)->first();
            $theme_id = $store->theme_id;
            $settings = Setting::where('theme_id', $theme_id)->where('store_id',$store->id)->pluck('value', 'name')->toArray();
        }else{
            $settings = Setting::where('created_by', '=', 1)->pluck('value', 'name')->toArray();
        }

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.        
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
            
            if($request->type != 'admin')
            {
                $status = Password::sendResetLink(
                    $request->only('email', 'type')
                );
            }
            else
            {
                 $status = Password::broker('admins')->sendResetLink($request->only('email'));
            }
            

            return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
      
        } catch (\Throwable $th) {
            return back()->withInput($request->only('email'))->withErrors(['email' => __('E-Mail has been not sent due to SMTP configuration')]);
        }
        
    }
}
