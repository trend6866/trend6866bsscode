<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\AppSetting;
use App\Models\Setting;
use App\Models\Theme;
use App\Models\Plan;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class AppSettingController extends Controller
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
            $this->user = Auth::guard('admin')->user();
            if($this->user->type != 'superadmin')
            {
                $this->store = Store::where('id', $this->user->current_store)->first();
                if($this->store)
                {
                    $this->APP_THEME = $this->store->theme_id;
                }
                else
                {
                    return redirect()->back()->with('error',__('Permission Denied.'));
                }
            }

        return $next($request);
        });
    }

    public function index()
    {
        if(\Auth::user()->can('Manage Store Setting'))
        {
            $user           = Auth::user();
            if($user->type != 'superadmin')
            {
                // $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('value', 'name')->toArray();
                $settings = \App\Models\Utility::Seting();
                $slug = $this->store->slug;

                if($settings)
                {
                    if($settings['domains'])
                    {
                        $serverIp   = $_SERVER['SERVER_ADDR'];
                        $domain = $settings['domains'];
                        if (isset($domain) && !empty($domain)) {
                            $domainip = gethostbyname($domain);
                        }
                        if ($serverIp == $domainip) {
                            $domainPointing = 1;
                        } else {
                            $domainPointing = 0;
                        }
                    }
                    else{
                        $serverIp   = $_SERVER['SERVER_ADDR'];
                        $domain = $serverIp;
                        $domainip = gethostbyname($domain);
                        $domainPointing = 0;
                    }
                    $serverName = str_replace(
                        [
                            'http://',
                            'https://',
                        ],
                        '',
                        env('APP_URL')
                    );
                    $serverIp   = gethostbyname($serverName);

                    if ($serverIp == $_SERVER['SERVER_ADDR']) {
                        $serverIp;
                    } else {
                        $serverIp = request()->server('SERVER_ADDR');
                    }

                    $plan                        = Plan::where('id', $user->plan)->first();
                    $app_url                     = trim(env('APP_URL'), '/');

                    $store_settings['store_url'] = $app_url . '/' . $slug;
                    // Remove the http://, www., and slash(/) from the URL
                    $input = env('APP_URL');

                    // If URI is like, eg. www.way2tutorial.com/
                    $input = trim($input, '/');
                    // If not have http:// or https:// then prepend it
                    if (!preg_match('#^http(s)?://#', $input)) {
                        $input = 'http://' . $input;
                    }
                    $urlParts = parse_url($input);

                    $serverIp   = $_SERVER['SERVER_ADDR'];

                    if (!empty($settings['subdomain']) || !empty($urlParts['host'])) {
                        $subdomain_Ip   = gethostbyname($urlParts['host']);
                        if ($serverIp == $subdomain_Ip) {
                            $subdomainPointing = 1;
                        } else {
                            $subdomainPointing = 0;
                        }
                        // Remove www.
                        $subdomain_name = preg_replace('/^www\./', '', $urlParts['host']);
                    } else {
                        $subdomain_Ip = $urlParts['host'];
                        $subdomainPointing = 0;
                        $subdomain_name = str_replace(
                            [
                                'http://',
                                'https://',
                            ],
                            '',
                            env('APP_URL')
                        );
                    }
                }

                // ie: /var/www/laravel/app/storage/json/filename.json
                $theme_id = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : $this->APP_THEME;
                // Main page
                $path = base_path('themes/'.$theme_id.'/theme_json/homepage.json');
                $json = json_decode(file_get_contents($path), true);

                $setting_json = AppSetting::select('theme_json')
                                    ->where('theme_id', $theme_id)
                                    ->where('page_name', 'main')
                                    ->where('store_id', getCurrentStore())
                                    ->first();
                if(!empty($setting_json)) {
                    $json = json_decode($setting_json->theme_json, true);
                }

                // Product Banner page
                $product_banner_json_path = base_path('themes/'.$theme_id.'/theme_json/product-banner.json');
                $product_banner_json = json_decode(file_get_contents($product_banner_json_path), true);

                $setting_product_banner_json = AppSetting::select('theme_json')
                                        ->where('theme_id', $theme_id)
                                        ->where('page_name', 'product_banner')
                                        ->where('store_id', getCurrentStore())
                                        ->first();
                if(!empty($setting_product_banner_json)) {
                    $product_banner_json = json_decode($setting_product_banner_json->theme_json, true);
                }

                // Order Complete page
                $order_complete_json_path = base_path('themes/'.$theme_id.'/theme_json/order-complete.json');
                $order_complete_json = json_decode(file_get_contents($order_complete_json_path), true);

                $setting_order_complete_json = AppSetting::select('theme_json')
                                        ->where('theme_id', $theme_id)
                                        ->where('page_name', 'order_complete')
                                        ->where('store_id', getCurrentStore())
                                        ->first();
                if(!empty($setting_order_complete_json)) {
                    $order_complete_json = json_decode($setting_order_complete_json->theme_json, true);
                }

                // Home pagw (WEBSITE)
                $homepage_web_json = [];
                $homepage_web_json_path = base_path('themes/'.$theme_id.'/theme_json/web/homepage.json');
                if(file_exists($homepage_web_json_path)) {
                    $homepage_web_json = json_decode(file_get_contents($homepage_web_json_path), true);
                }

                $homepage_web_complete_json = AppSetting::select('theme_json')
                                        ->where('theme_id', $theme_id)
                                        ->where('page_name', 'home_page_web')
                                        ->where('store_id', getCurrentStore())
                                        ->first();
                if(!empty($homepage_web_complete_json)) {
                    $homepage_web_json = json_decode($homepage_web_complete_json->theme_json, true);
                }

                // loyality program json
                $loyality_program_json = Utility::loyality_program_json($theme_id);
                $compact = ['json', 'product_banner_json', 'order_complete_json', 'homepage_web_json', 'loyality_program_json','settings','slug','serverIp','subdomain_name','subdomain_Ip','subdomainPointing','domainip','domainPointing','plan'];
                return view('AppSetting.index', compact($compact));
            }
            else{
                return redirect()->route('admin.dashboard')->with('error', __('Permission Denied'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function MobileScreenContent()
    {
        // ie: /var/www/laravel/app/storage/json/filename.json
        $theme_id = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : $this->APP_THEME;
        // Main page
        $path = base_path('themes/'.$theme_id.'/theme_json/homepage.json');
        $json = json_decode(file_get_contents($path), true);

        $setting_json = AppSetting::select('theme_json')
                            ->where('theme_id', $theme_id)
                            ->where('page_name', 'main')
                            ->where('store_id', getCurrentStore())
                            ->first();
        if(!empty($setting_json)) {
            $json = json_decode($setting_json->theme_json, true);
        }

        // Product Banner page
        $product_banner_json_path = base_path('themes/'.$theme_id.'/theme_json/product-banner.json');
        $product_banner_json = json_decode(file_get_contents($product_banner_json_path), true);

        $setting_product_banner_json = AppSetting::select('theme_json')
                                ->where('theme_id', $theme_id)
                                ->where('page_name', 'product_banner')
                                ->where('store_id', getCurrentStore())
                                ->first();
        if(!empty($setting_product_banner_json)) {
            $product_banner_json = json_decode($setting_product_banner_json->theme_json, true);
        }

        // Order Complete page
        $order_complete_json_path = base_path('themes/'.$theme_id.'/theme_json/order-complete.json');
        $order_complete_json = json_decode(file_get_contents($order_complete_json_path), true);

        $setting_order_complete_json = AppSetting::select('theme_json')
                                ->where('theme_id', $theme_id)
                                ->where('page_name', 'order_complete')
                                ->where('store_id', getCurrentStore())
                                ->first();
        if(!empty($setting_order_complete_json)) {
            $order_complete_json = json_decode($setting_order_complete_json->theme_json, true);
        }

        // Home pagw (WEBSITE)
        $homepage_web_json = [];
        $homepage_web_json_path = base_path('themes/'.$theme_id.'/theme_json/web/homepage.json');
        if(file_exists($homepage_web_json_path)) {
            $homepage_web_json = json_decode(file_get_contents($homepage_web_json_path), true);
        }

        $homepage_web_complete_json = AppSetting::select('theme_json')
                                ->where('theme_id', $theme_id)
                                ->where('page_name', 'home_page_web')
                                ->where('store_id', getCurrentStore())
                                ->first();
        if(!empty($homepage_web_complete_json)) {
            $homepage_web_json = json_decode($homepage_web_complete_json->theme_json, true);
        }


        // loyality program json
        $loyality_program_json = Utility::loyality_program_json($theme_id,getCurrentStore());

        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : $this->APP_THEME;
        $settings = Setting::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('value', 'name')->toArray();
        $slug = $this->store->slug;
        if(empty($settings))
        {
            $settings = Utility::Seting();
        }
        $themes = Theme::all();

        $user = \Auth::guard('admin')->user();
        if($user->type == 'admin')
        {
            $plan = Plan::find($user->plan);
            if(!empty($plan->themes))
            {
              $themes =  explode(',',$plan->themes);
            }
        }

        $compact = ['json', 'product_banner_json', 'order_complete_json', 'homepage_web_json', 'loyality_program_json','slug','settings','themes','user'];
        return view('AppSetting.mobile_content', compact($compact));
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

    public function store(Request $request)
    {
		$theme_id = $this->APP_THEME;
        $json = $request->array;
        $array = $request->array;
        $dir        = 'themes/'.APP_THEME().'/uploads';
        $new_array = [];
        foreach ($array as $key => $jsn) {
            foreach ($jsn['inner-list'] as $IN_key => $js) {
                $new_array[$jsn['section_slug']][$js['field_slug']] = $js['field_default_text'];
                if($js['field_type'] == 'multi file upload') {
                    if(!empty($js['multi_image'])) {
                        foreach ($js['multi_image'] as $key_file => $file) {
                            $theme_name = $theme_id;
                            $theme_image = $file;
                            // $upload = upload_theme_image($theme_name, $theme_image, $key_file);

                            $fileName = rand(10,100).'_'.time() . "_" . $theme_image->getClientOriginalName();
                            $upload = Utility::upload_file($request,$theme_image,$fileName,$dir,[], $theme_image);

                            $img_path = '';
                            if( !empty($upload['flag']) && $upload['flag'] == 1)
                            {
                                $img_path = $upload['image_path'];
                            }
                            $array[$key]["inner-list"][$IN_key]['image_path'][] = $img_path;
                            $array[$key][$js['field_slug']][$key_file]['image'] = $img_path;
                            $array[$key][$js['field_slug']][$key_file]['field_prev_text'] = $img_path;
                        }

                        $next_key_p_image = !empty($key_file) ? $key_file : 0;
                        if(!empty($jsn['prev_image'])) {
                            foreach ($jsn['prev_image'] as $p_key => $p_value) {
                                $next_key_p_image = $next_key_p_image + 1;
                                $array[$key][$js['field_slug']][$next_key_p_image]['image'] = $p_value;
                                $array[$key][$js['field_slug']][$next_key_p_image]['field_prev_text'] = $p_value;
                            }
                        }
                    } else {
                        if(!empty($jsn['prev_image'])) {
                            foreach ($jsn['prev_image'] as $p_key => $p_value) {
                                $array[$key][$js['field_slug']][$p_key]['image'] = $p_value;
                                $array[$key][$js['field_slug']][$p_key]['field_prev_text'] = $p_value;
                            }
                        }
                    }
                }
                if($js['field_type'] == 'photo upload')
                {
                    if ($jsn['array_type'] == 'multi-inner-list')
                    {
                        $k = 0;
                        $img_path_multi = [];
                        for ($i = 0; $i < $jsn['loop_number']; $i++) {
                            $img_path_multi[$i] = '';
                            if(empty($array[$key][$js['field_slug']][$i]['field_prev_text'])) {
                                $array[$key][$js['field_slug']][$i]['field_prev_text'] = $js['field_default_text'];
                                $img_path_multi[$i] = $js['field_default_text'];
                            }else{
                                $img_path_multi[$i] = $array[$key][$js['field_slug']][$i]['field_prev_text'];
                            }
                            if (!empty($array[$key][$js['field_slug']][$i]['image']) && gettype($array[$key][$js['field_slug']][$i]['image']) == 'object')
                            {
                                $theme_name = $theme_id;
                                $theme_image = $array[$key][$js['field_slug']][$i]['image'];
                                // $upload = upload_theme_image($theme_name, $theme_image, $i);

                                $fileName = rand(10,100).'_'.time() . "_" . $theme_image->getClientOriginalName();
                                $upload = Utility::upload_file($request,$theme_image,$fileName,$dir,[], $theme_image);

                                $img_path = '';
                                if( !empty($upload['flag']) && $upload['flag'] == 1)
                                {
                                    $img_path = $upload['image_path'];
                                }
                                $array[$key][$js['field_slug']][$i]['image'] = $img_path;
                                $array[$key][$js['field_slug']][$i]['field_prev_text'] = $img_path;
                                $img_path_multi[$i] = $img_path;
                            }
                        }
                        $new_array[$jsn['section_slug']][$js['field_slug']] = $img_path_multi;
                    }
                    else
                    {
                        if (gettype($js['field_default_text']) == 'object') {
                            $theme_name = $theme_id;
                            $theme_image = $js['field_default_text'];
                            // $upload = upload_theme_image($theme_name, $theme_image);


                            $fileName = rand(10,100).'_'.time() . "_" . $theme_image->getClientOriginalName();
                            $upload = Utility::upload_file($request,$theme_image,$fileName,$dir,[], $theme_image);

                            $img_path = '';
                            if( !empty($upload['flag']) && $upload['flag'] == 1)
                            {
                                $img_path = $upload['image_path'];
                            }
                            $array[$key]['inner-list'][$IN_key]['field_default_text'] = $img_path;
                            $new_array[$jsn['section_slug']][$js['field_slug']] = $img_path;
                        }
                    }
                }
            }
        }
        AppSetting::updateOrInsert(
            ['theme_id' => $theme_id, 'page_name' => 'main', 'store_id' => getCurrentStore()], // Where condition
            ['theme_id' => $theme_id, 'page_name' => 'main','store_id' => getCurrentStore(), 'theme_json' => json_encode($array), 'theme_json_api' => json_encode($new_array)]   // Update or Insert
        );

        return redirect()->back()->with('success', __('App setting set successfully.'));
    }

    public function show(AppSetting $appSetting)
    {
        //
    }

    public function edit(AppSetting $appSetting)
    {
        //
    }

    public function update(Request $request, AppSetting $appSetting)
    {
        //
    }

    public function destroy(AppSetting $appSetting)
    {
        //
    }


    public function product_page_setting(Request $request)
    {
        $theme_id = $this->APP_THEME;
        $page_name = $request->page_name;
        $dir        = 'themes/'.APP_THEME().'/uploads';
        if(empty($page_name)) {
            return redirect()->back()->with('error', __('Page name not found.'));
        }

        $array = $request->array;
        if($page_name == 'home_page_web') {
            $array = $request->array;
        }

        $new_array = [];
        foreach ($array as $key => $jsn) {
            foreach ($jsn['inner-list'] as $IN_key => $js) {
                $new_array[$jsn['section_slug']][$js['field_slug']] = $js['field_default_text'];
                if($js['field_type'] == 'multi file upload') {
                    if(!empty($js['multi_image'])) {
                        foreach ($js['multi_image'] as $key_file => $file) {
                            $theme_name = $theme_id;
                            $theme_image = $file;
                            // $upload = upload_theme_image($theme_name, $theme_image, $key_file);

                            $fileName = rand(10,100).'_'.time() . "_" . $theme_image->getClientOriginalName();
                            $upload = Utility::upload_file($request,$theme_image,$fileName,$dir,[], $theme_image);

                            $img_path = '';
                            if( !empty($upload['flag']) && $upload['flag'] == 1)
                            {
                                $img_path = $upload['image_path'];
                            }
                            $array[$key][$js['field_slug']][$key_file]['image'] = $img_path;
                            $array[$key][$js['field_slug']][$key_file]['field_prev_text'] = $img_path;
                        }

                        $next_key_p_image = !empty($key_file) ? $key_file : 0;
                        if(!empty($jsn['prev_image'])) {
                            foreach ($jsn['prev_image'] as $p_key => $p_value) {
                                $next_key_p_image = $next_key_p_image + 1;
                                $array[$key][$js['field_slug']][$next_key_p_image]['image'] = $p_value;
                                $array[$key][$js['field_slug']][$next_key_p_image]['field_prev_text'] = $p_value;
                            }
                        }
                    } else {
                        if(!empty($jsn['prev_image'])) {
                            foreach ($jsn['prev_image'] as $p_key => $p_value) {
                                $array[$key][$js['field_slug']][$p_key]['image'] = $p_value;
                                $array[$key][$js['field_slug']][$p_key]['field_prev_text'] = $p_value;
                            }
                        }
                    }
                }
                if($js['field_type'] == 'photo upload')
                {
                    if ($jsn['array_type'] == 'multi-inner-list')
                    {
                        $k = 0;
                        $img_path_multi = [];
                        for ($i = 0; $i < $jsn['loop_number']; $i++) {
                            $img_path_multi[$i] = '';
                            if(empty($array[$key][$js['field_slug']][$i]['field_prev_text'])) {
                                $array[$key][$js['field_slug']][$i]['field_prev_text'] = $js['field_default_text'];
                                $img_path_multi[$i] = $js['field_default_text'];
                            }
                            if (!empty($array[$key][$js['field_slug']][$i]['image']) && gettype($array[$key][$js['field_slug']][$i]['image']) == 'object')
                            {
                                $theme_name = $theme_id;
                                $theme_image = $array[$key][$js['field_slug']][$i]['image'];

                                $image_size = File::size($theme_image);
                                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                                if ($result == 1)
                                {
                                    $fileName = rand(10,100).'_'.time() . "_" . $theme_image->getClientOriginalName();
                                    $upload = Utility::upload_file($request,$theme_image,$fileName,$dir,[], $theme_image);
                                    $img_path = '';
                                    if( !empty($upload['flag']) && $upload['flag'] == 1)
                                    {
                                        $img_path = $upload['image_path'];
                                    }
                                }
                                else{
                                    return redirect()->back()->with('error', $result);
                                }

                                // $upload = upload_theme_image($theme_name, $theme_image, $i);
                                $array[$key][$js['field_slug']][$i]['image'] = $img_path;
                                $array[$key][$js['field_slug']][$i]['field_prev_text'] = $img_path;
                                $img_path_multi[$i] = $img_path;
                            }
                        }
                        $new_array[$jsn['section_slug']][$js['field_slug']] = $img_path_multi;
                    }
                    else
                    {
                        if (gettype($js['field_default_text']) == 'object') {
                            $theme_name = $theme_id;
                            $theme_image = $js['field_default_text'];

                            $image_size = File::size($theme_image);
                            $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                            if ($result == 1)
                            {
                                $fileName = rand(10,100).'_'.time() . "_" . $theme_image->getClientOriginalName();
                                $upload = Utility::upload_file($request,$theme_image,$fileName,$dir,[], $theme_image);
                                // $upload = upload_theme_image($theme_name, $theme_image);
                                $img_path = '';
                                if( !empty($upload['flag']) && $upload['flag'] == 1)
                                {
                                    $img_path = $upload['image_path'];
                                }
                            }
                            else{
                                return redirect()->back()->with('error', $result);
                            }

                            $array[$key]['inner-list'][$IN_key]['field_default_text'] = $img_path;
                            $new_array[$jsn['section_slug']][$js['field_slug']] = $img_path;
                        }
                    }
                }
            }
        }

        AppSetting::updateOrInsert(
            ['theme_id' => $theme_id, 'page_name' => $page_name, 'store_id' => getCurrentStore() ], // Where condition
            ['theme_id' => $theme_id, 'page_name' => $page_name,'store_id' => getCurrentStore(), 'theme_json' => json_encode($array), 'theme_json_api' => json_encode($new_array)]   // Update or Insert
        );

        return redirect()->back()->with('success', __('App setting set successfully.'));
    }

    public function image_delete(Request $request)
    {
        if (File::exists(base_path($request->image))) {
            File::delete(base_path($request->image));
        }

        $return['status'] = 'success';
        return response()->json($return);

    }

}
