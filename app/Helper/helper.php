<?php

use App\Http\Controllers\Api\ApiController;
use App\Models\Utility;
use App\Models\Setting;
use App\Models\User;
use App\Models\Store;
use App\Models\Admin;
use App\Models\FlashSale;
use App\Models\flashsale_condition;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Storage;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;



if (!function_exists('theme_img')) {
    function theme_img($img_path = '')
    {
        $url = asset('/') . $img_path;
        return $url;
    }
}

if (!function_exists('GetCurrency')) {
    function GetCurrency()
    {
        return Utility::GetValueByName('CURRENCY');
    }
}

if (!function_exists('SetNumber')) {
    function SetNumber($number = 0)
    {
        $number_output = number_format($number, 2);
        return str_replace(',', '', $number_output);
    }
}

if (!function_exists('SetNumberFormat')) {
    function SetNumberFormat($number = 0)
    {

        $currency = Utility::GetValueByName('CURRENCY');
        $number_output = number_format($number, 2);
        return $currency . str_replace(',', '', $number_output);
    }
}

if (!function_exists('SetDateFormat')) {
    function SetDateFormat($date = '')
    {
        $date_format = Utility::GetValueByName('date_format');
        if (empty($date_format)) {
            $date_format = 'Y-m-d';
        }
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        try {
            $date_new = date($date_format, strtotime($date));
        } catch (\Throwable $th) {
            $date_new = $date;
        }
        return $date_new;
    }
}

if (!function_exists('upload_theme_image')) {
    function upload_theme_image($theme_name, $theme_image, $key = 0)
    {
        $return['status'] = false;
        $return['image_url'] = '';
        $return['image_path'] = '';
        $return['message'] = __('Something went wrong.');

        if (!empty($theme_image)) {
            $theme_image       = $theme_image;
            $filenameWithExt   = $theme_image->getClientOriginalName();
            $filename          = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension         = $theme_image->getClientOriginalExtension();
            $filedownloadable1 = $key . rand(0, 100) . date('Ymd') . '_' . time() . '.' . $extension;
            $dir               = 'themes/' . $theme_name . '/uploads';
            $save = Storage::disk('theme')->putFileAs(
                $dir,  // upload path
                $theme_image, // image name
                $filedownloadable1  // image new name
            );
            $return['status'] = true;
            $return['image_url'] = url('themes/' . $save);
            $return['image_path'] = $save;
            $return['message'] = __('Image upload succcessfully.');
        }
        return $return;
    }
}

/* hashids encryption */
if (!function_exists('hashidsencode')) {
    function hashidsencode($data)
    {
        try {
            $hashids = new Hashids('', 11);
            $data = $hashids->encode($data);
            return $data;
        } catch (\Exception $e) {
            return $data;
        }
    }
}

/* hashids dencryption */
if (!function_exists('hashidsdecode')) {
    function hashidsdecode($data)
    {
        try {
            $hashids = new Hashids('', 11);
            $data = $hashids->decode($data);
            return $data;
        } catch (\Exception $e) {
            return $data;
        }
    }
}

if (!function_exists('APP_THEME')) {
    function APP_THEME()
    {
        $local = parse_url(config('app.url'))['host'];
        // Get the request host
        $remote = request()->getHost();
        // Get the remote domain
        // remove WWW
        $remote = str_replace('www.', '', $remote);
        $subdomain = Setting::where('name', 'subdomain')->where('value', $remote)->first();
        $domain = Setting::where('name', 'domains')->where('value', $remote)->first();

        $enable_subdomain = "";
        $enable_domain = "";

        if ($subdomain || $domain) {
            if ($subdomain) {
                $enable_subdomain = Setting::where('name', 'enable_subdomain')->where('value', 'on')->where('store_id', $subdomain->store_id)->first();
                if ($enable_subdomain) {
                    $admin = Admin::find($enable_subdomain->created_by);
                    if ($enable_subdomain->value == 'on' &&  $enable_subdomain->store_id == $admin->current_store) {
                        $store = Store::find($admin->current_store);
                        if ($store) {
                            return $store->theme_id;
                        }
                    } else {

                        $slug = !empty(request()->segments()[0]);
                        if (!empty($slug) && $slug == 'admin') {
                            if (Auth::check() && !empty(Auth::guard('admin')->user())) {
                                $store = Store::where('id', Auth::guard('admin')->user()->current_store)->first();
                                $APP_THEME = !empty($store) ?  $store->theme_id : 'grocery';

                                return $APP_THEME;
                            } else {
                                if (!empty(request()->segment(1)) && request()->segment(1) != 'admin') {
                                    $slug = request()->segment(1);
                                    $store = Store::where('slug', $slug)->first();
                                    return $store->theme_id;
                                } else {
                                    $user = Admin::where('type', 'superadmin')->first();
                                    $store = Store::where('created_by', $user->id)->first();
                                    return !empty($store) ? $store->theme_id : 'grocery';
                                }
                            }
                        } elseif (!empty($slug) &&  $slug != 'admin') {
                            $store = Store::where('slug', $slug)->first();
                            return !empty($store) ? $store->theme_id : 'grocery';
                        } else {
                            $user = Admin::where('type', 'superadmin')->first();
                            $store = Store::where('created_by', $user->id)->first();

                            return !empty($store) ? $store->theme_id : 'grocery';
                        }
                        // if(Auth::guard('admin')->user()->type != 'superadmin')
                        // {

                        // }
                        // else
                        // {
                        //         $user = User::where('type','superadmin')->first();
                        //         $store = Store::where('created_by',$user->id)->first();
                        //         $this->APP_THEME = !empty($store) ? $store->theme_id : 'grocery';

                        //     return 'grocery';
                        // }
                    }
                }
            }

            if ($domain) {
                $enable_domain = Setting::where('name', 'enable_domain')->where('value', 'on')->where('store_id', $domain->store_id)->first();
                if ($enable_domain) {
                    $admin = Admin::find($enable_domain->created_by);
                    if ($enable_domain->value == 'on' &&  $enable_domain->store_id == $admin->current_store) {
                        $store = Store::find($admin->current_store);
                        if ($store) {
                            return $store->theme_id;
                        }
                    } else {

                        $slug = !empty(request()->segments()[0]);
                        if (!empty($slug) && $slug == 'admin') {
                            if (Auth::check() && !empty(Auth::guard('admin')->user())) {
                                $store = Store::where('id', Auth::guard('admin')->user()->current_store)->first();
                                $APP_THEME = !empty($store) ?  $store->theme_id : 'grocery';

                                return $APP_THEME;
                            } else {
                                if (!empty(request()->segment(1)) && request()->segment(1) != 'admin') {
                                    $slug = request()->segment(1);
                                    $store = Store::where('slug', $slug)->first();
                                    return $store->theme_id;
                                } else {
                                    $user = Admin::where('type', 'superadmin')->first();
                                    $store = Store::where('created_by', $user->id)->first();
                                    return !empty($store) ? $store->theme_id : 'grocery';
                                }
                            }
                        } elseif (!empty($slug) &&  $slug != 'admin') {
                            $store = Store::where('slug', $slug)->first();
                            return !empty($store) ? $store->theme_id : 'grocery';
                        } else {
                            $user = Admin::where('type', 'superadmin')->first();
                            $store = Store::where('created_by', $user->id)->first();

                            return !empty($store) ? $store->theme_id : 'grocery';
                        }
                        // if(Auth::guard('admin')->user()->type != 'superadmin')
                        // {

                        // }
                        // else
                        // {
                        //         $user = User::where('type','superadmin')->first();
                        //         $store = Store::where('created_by',$user->id)->first();
                        //         $this->APP_THEME = !empty($store) ? $store->theme_id : 'grocery';

                        //     return 'grocery';
                        // }
                    }
                }
            }
        } else {
            $slug = !empty(request()->segments()[0]);
            if (!empty($slug) && $slug == 'admin') {
                if (Auth::check() && !empty(Auth::guard('admin')->user())) {
                    $store = Store::where('id', Auth::guard('admin')->user()->current_store)->first();
                    $APP_THEME = !empty($store) ?  $store->theme_id : 'grocery';

                    return $APP_THEME;
                } else {
                    if (!empty(request()->segment(1)) && request()->segment(1) != 'admin') {
                        $slug = request()->segment(1);
                        if($slug == 'api')
                        {
                            $admin = Auth::user();
                            $store = Store::where('id',$admin->current_store)->first();
                            return $store->theme_id;
                            
                        }
                        else
                        {
                            $store = Store::where('slug', $slug)->first();
                            return $store->theme_id;
                        }
                    } else {
                        $user = Admin::where('type', 'superadmin')->first();
                        $store = Store::where('created_by', $user->id)->first();
                        return !empty($store) ? $store->theme_id : 'grocery';
                    }
                }
            } elseif (!empty($slug) &&  $slug != 'admin') {
                $store = Store::where('slug', $slug)->first();
                return !empty($store) ? $store->theme_id : 'grocery';
            } else {
                $user = Admin::where('type', 'superadmin')->first();
                $store = Store::where('created_by', $user->id)->first();

                return !empty($store) ? $store->theme_id : 'grocery';
            }
            // if(Auth::guard('admin')->user()->type != 'superadmin')
            // {

            // }
            // else
            // {
            //         $user = User::where('type','superadmin')->first();
            //         $store = Store::where('created_by',$user->id)->first();
            //         $this->APP_THEME = !empty($store) ? $store->theme_id : 'grocery';

            //     return 'grocery';
            // }
        }
    }
}

if (!function_exists('upload_image')) {
    function upload_image($theme_image)
    {
        $return['status'] = false;
        $return['image_path'] = '';
        $return['message'] = __('Something went wrong.');

        if (!empty($theme_image)) {
            $imageName = rand(0, 99) . time() . '.' . $theme_image->extension();
            $theme_image->move(storage_path('uploads'), $imageName);
            $image_path = 'themes/' . $theme_name . 'uploads/' . $imageName;

            $return['status'] = true;
            $return['image_path'] = $image_path;
            $return['message'] = __('Image upload succcessfully.');
        }
        return $return;
    }
}

if (!function_exists('upload_setting_image')) {
    function upload_setting_image($theme_image)
    {
        $return['status'] = false;
        $return['image_path'] = '';
        $return['message'] = __('Something went wrong.');


        if (!empty($theme_image)) {
            $imageName = rand(0, 99) . time() . '.' . $theme_image->extension();
            $theme_image->move(storage_path('uploads/logo'), $imageName);
            $image_path = 'uploads/logo/' . $imageName;

            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $return['status'] = true;
            $return['image_path'] = $image_path;
            $return['message'] = __('Image upload succcessfully.');
        }
        return $return;
    }
}

if (!function_exists('get_file')) {
    function get_file($path, $theme_id = '')
    {

        $admin = Admin::where('type', 'superadmin')->first();

        $theme_id = 'grocery';
        $settings = Setting::where('theme_id', $theme_id)->where('store_id', $admin->current_store)->pluck('value', 'name')->toArray();


        if (!isset($settings['storage_setting'])) {
            $settings = Utility::Seting();
        }

        try {
            if ($settings['storage_setting'] == 'wasabi') {
                config(
                    [
                        'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                        'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                        'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                        'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                        'filesystems.disks.wasabi.endpoint' => 'https://s3.' . $settings['wasabi_region'] . '.wasabisys.com'
                    ]
                );
                return \Storage::disk($settings['storage_setting'])->url($path);
            } elseif ($settings['storage_setting'] == 's3') {
                config(
                    [
                        'filesystems.disks.s3.key' => $settings['s3_key'],
                        'filesystems.disks.s3.secret' => $settings['s3_secret'],
                        'filesystems.disks.s3.region' => $settings['s3_region'],
                        'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                        'filesystems.disks.s3.use_path_style_endpoint' => false,
                    ]
                );
                return \Storage::disk($settings['storage_setting'])->url($path);
            } else {
                $path = url($path);
                return $path;
            }
        } catch (\Throwable $th) {
            // dd($th);
            return '';
        }
    }
}

if (!function_exists('getCurrentStore')) {
    function getCurrentStore($user_id = null)
    {
        $local = parse_url(config('app.url'))['host'];
        // Get the request host
        $remote = request()->getHost();
        // Get the remote domain
        // remove WWW
        $remote = str_replace('www.', '', $remote);
        $subdomain = Setting::where('name', 'subdomain')->where('value', $remote)->first();
        $domain = Setting::where('name', 'domains')->where('value', $remote)->first();

        $enable_subdomain = "";
        $enable_domain = "";

        if ($subdomain || $domain) {
            if ($subdomain) {
                $enable_subdomain = Setting::where('name', 'enable_subdomain')->where('value', 'on')->where('store_id', $subdomain->store_id)->first();
                if ($enable_subdomain) {
                    $admin = Admin::find($enable_subdomain->created_by);
                    if ($enable_subdomain->value == 'on' &&  $enable_subdomain->store_id == $admin->current_store) {
                        $store = Store::find($admin->current_store);
                        if ($store) {
                            return $store->id;
                        }
                    } else {

                        if (!empty(request()->segments()) && request()->segments()[0] != 'admin' && request()->segments()[0] != 'api') {
                            $slug = request()->segments()[0];
                            $store = Store::where('slug', $slug)->first();
                            return $store->id;
                        } elseif (!empty(request()->segments()) && request()->segments()[0] != 'admin' && request()->segments()[0] == 'api') {
                            $slug = request()->segments()[1];
                            $store = Store::where('slug', $slug)->first();
                            return $store->id;
                        } else {
                            if (empty($user_id)) {
                                $user_id =  !empty(\Auth::guard('admin')->user()->id) ? \Auth::guard('admin')->user()->id : 1;
                            }
                            $user = Admin::find($user_id);
                            if ($user) {
                                if ($user->type  != 'admin' && $user->type  != 'superadmin') {
                                    $user = Admin::find($user->created_by);
                                }

                                if (!empty($user->current_store)) {
                                    return $user->current_store;
                                } else {
                                    if ($user->type == 'superadmin') {
                                        return 1;
                                    } else {
                                        $store = Store::where('created_by', $user->id)->first();
                                        return $store->id;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ($domain) {
                $enable_domain = Setting::where('name', 'enable_domain')->where('value', 'on')->where('store_id', $domain->store_id)->first();
                if ($enable_domain) {
                    $admin = Admin::find($enable_domain->created_by);
                    if ($enable_domain->value == 'on' &&  $enable_domain->store_id == $admin->current_store) {
                        $store = Store::find($admin->current_store);
                        if ($store) {
                            return $store->id;
                        }
                    } else {

                        if (!empty(request()->segments()) && request()->segments()[0] != 'admin' && request()->segments()[0] != 'api') {
                            $slug = request()->segments()[0];
                            $store = Store::where('slug', $slug)->first();
                            return $store->id;
                        } elseif (!empty(request()->segments()) && request()->segments()[0] != 'admin' && request()->segments()[0] == 'api') {
                            $slug = request()->segments()[1];
                            $store = Store::where('slug', $slug)->first();
                            return $store->id;
                        } else {
                            if (empty($user_id)) {
                                $user_id =  !empty(\Auth::guard('admin')->user()->id) ? \Auth::guard('admin')->user()->id : 1;
                            }
                            $user = Admin::find($user_id);
                            if ($user) {
                                if ($user->type  != 'admin' && $user->type  != 'superadmin') {
                                    $user = Admin::find($user->created_by);
                                }

                                if (!empty($user->current_store)) {
                                    return $user->current_store;
                                } else {
                                    if ($user->type == 'superadmin') {
                                        return 1;
                                    } else {
                                        $store = Store::where('created_by', $user->id)->first();
                                        return $store->id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {

            if (!empty(request()->segments()) && request()->segments()[0] != 'admin' && request()->segments()[0] != 'api') {
                $slug = request()->segments()[0];
                $store = Store::where('slug', $slug)->first();
                return $store->id;
            } elseif (!empty(request()->segments()) && request()->segments()[0] != 'admin' && request()->segments()[0] == 'api') {
                $slug = request()->segments()[1];
                if(request()->segments()[0] == 'api' && request()->segments()[1] == 'admin')
                {
                    $admin = Auth::user();
                    if($admin->type != 'deliveryboy')
                    {
                        $store = Store::where('id', $admin->current_store)->first();
                        return $store->id;
                    }
                    else{
                        $store = Store::where('id', $admin->store_id)->first();
                        return $store->id;
                    }
                    // $store = Store::where('id', $admin->current_store)->first();
                    // return $store->id;
                }
                else{
                    $store = Store::where('slug', $slug)->first();
                    return $store->id;
                }
            } else {
                if (empty($user_id)) {
                    $user_id =  !empty(\Auth::guard('admin')->user()->id) ? \Auth::guard('admin')->user()->id : 1;
                }
                $user = Admin::find($user_id);
                if ($user) {
                    if ($user->type  != 'admin' && $user->type  != 'superadmin') {
                        $user = Admin::find($user->created_by);
                    }

                    if (!empty($user->current_store)) {
                        return $user->current_store;
                    } else {
                        if ($user->type == 'superadmin') {
                            return 1;
                        } else {
                            $store = Store::where('created_by', $user->id)->first();
                            return $store->id;
                        }
                    }
                }
            }
        }
    }
}

function pixelSourceCode($platform, $pixelId)
{
    // Facebook Pixel script
    if ($platform === 'facebook') {
        $script = "
            <script>
                !function(f,b,e,v,n,t,s)
                {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '%s');
                fbq('track', 'PageView');
            </script>

            <noscript><img height='1' width='1' style='display:none' src='https://www.facebook.com/tr?id=%d&ev=PageView&noscript=1'/></noscript>
        ";

        return sprintf($script, $pixelId, $pixelId);
    }


    // Twitter Pixel script
    if ($platform === 'twitter') {
        $script = "
        <script>
        !function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
        },s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='https://static.ads-twitter.com/uwt.js',
        a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');
        twq('config','%s');
        </script>
        ";

        return sprintf($script, $pixelId);
    }


    // Linkedin Pixel script
    if ($platform === 'linkedin') {
        $script = "
            <script type='text/javascript'>
                _linkedin_data_partner_id = %d;
            </script>
            <script type='text/javascript'>
                (function () {
                    var s = document.getElementsByTagName('script')[0];
                    var b = document.createElement('script');
                    b.type = 'text/javascript';
                    b.async = true;
                    b.src = 'https://snap.licdn.com/li.lms-analytics/insight.min.js';
                    s.parentNode.insertBefore(b, s);
                })();
            </script>
            <noscript><img height='1' width='1' style='display:none;' alt='' src='https://dc.ads.linkedin.com/collect/?pid=%d&fmt=gif'/></noscript>
        ";

        return sprintf($script, $pixelId, $pixelId);
    }


    // Pinterest Pixel script
    if ($platform === 'pinterest') {
        $script = "
        <!-- Pinterest Tag -->
        <script>
        !function(e){if(!window.pintrk){window.pintrk = function () {
        window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var
          n=window.pintrk;n.queue=[],n.version='3.0';var
          t=document.createElement('script');t.async=!0,t.src=e;var
          r=document.getElementsByTagName('script')[0];
          r.parentNode.insertBefore(t,r)}}('https://s.pinimg.com/ct/core.js');
        pintrk('load', '%s');
        pintrk('page');
        </script>
        <noscript>
        <img height='1' width='1' style='display:none;' alt=''
          src='https://ct.pinterest.com/v3/?event=init&tid=2613174167631&pd[em]=<hashed_email_address>&noscript=1' />
        </noscript>
        <!-- end Pinterest Tag -->

        ";

        return sprintf($script, $pixelId, $pixelId);
    }


    // Quora Pixel script
    if ($platform === 'quora') {
        $script = "
           <script>
                !function (q, e, v, n, t, s) {
                    if (q.qp) return;
                    n = q.qp = function () {
                        n.qp ? n.qp.apply(n, arguments) : n.queue.push(arguments);
                    };
                    n.queue = [];
                    t = document.createElement(e);
                    t.async = !0;
                    t.src = v;
                    s = document.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t, s);
                }(window, 'script', 'https://a.quora.com/qevents.js');
                qp('init', %s);
                qp('track', 'ViewContent');
            </script>

            <noscript><img height='1' width='1' style='display:none' src='https://q.quora.com/_/ad/%d/pixel?tag=ViewContent&noscript=1'/></noscript>
        ";

        return sprintf($script, $pixelId, $pixelId);
    }



    // Bing Pixel script
    if ($platform === 'bing') {
        $script = '
            <script>
            (function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[] ,f=function(){var o={ti:"%d"}; o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")} ,n=d.createElement(t),n.src=r,n.async=1,n.onload=n .onreadystatechange=function() {var s=this.readyState;s &&s!=="loaded"&& s!=="complete"||(f(),n.onload=n. onreadystatechange=null)},i= d.getElementsByTagName(t)[0],i. parentNode.insertBefore(n,i)})(window,document,"script"," //bat.bing.com/bat.js","uetq");
            </script>
            <noscript><img src="//bat.bing.com/action/0?ti=%d&Ver=2" height="0" width="0" style="display:none; visibility: hidden;" /></noscript>
        ';

        return sprintf($script, $pixelId, $pixelId);
    }



    // Google adwords Pixel script
    if ($platform === 'google-adwords') {
        $script = "
            <script type='text/javascript'>

            var google_conversion_id = '%s';
            var google_custom_params = window.google_tag_params;
            var google_remarketing_only = true;

            </script>
            <script type='text/javascript' src='//www.googleadservices.com/pagead/conversion.js'>
            </script>
            <noscript>
            <div style='display:inline;'>
            <img height='1' width='1' style='border-style:none;' alt='' src='//googleads.g.doubleclick.net/pagead/viewthroughconversion/%s/?guid=ON&amp;script=0'/>
            </div>
            </noscript>
        ";

        return sprintf($script, $pixelId, $pixelId);
    }


    // Google tag manager Pixel script
    if ($platform === 'google-analytics') {
        $script = "
            <script async src='https://www.googletagmanager.com/gtag/js?id=%s'></script>
            <script>

              window.dataLayer = window.dataLayer || [];

              function gtag(){dataLayer.push(arguments);}

              gtag('js', new Date());

              gtag('config', '%s');

            </script>
        ";

        return sprintf($script, $pixelId, $pixelId);
    }

    //snapchat
    if ($platform === 'snapchat') {
        $script = " <script type='text/javascript'>
        (function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()
        {a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};
        a.queue=[];var s='script';r=t.createElement(s);r.async=!0;
        r.src=n;var u=t.getElementsByTagName(s)[0];
        u.parentNode.insertBefore(r,u);})(window,document,
        'https://sc-static.net/scevent.min.js');

        snaptr('init', '%s', {
        'user_email': '__INSERT_USER_EMAIL__'
        });

        snaptr('track', 'PAGE_VIEW');

        </script>";
        return sprintf($script, $pixelId, $pixelId);
    }

    //tiktok
    if ($platform === 'tiktok') {
        $script = " <script>
        !function (w, d, t) {
          w.TiktokAnalyticsObject=t;
          var ttq=w[t]=w[t]||[];
          ttq.methods=['page','track','identify','instances','debug','on','off','once','ready','alias','group','enableCookie','disableCookie'],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};
          for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;
         n++)ttq.setAndDefer(e,ttq.methods[n]);
         return e},ttq.load=function(e,n){var i='https://analytics.tiktok.com/i18n/pixel/events.js';
        ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};
        var o=document.createElement('script');
        o.type='text/javascript',o.async=!0,o.src=i+'?sdkid='+e+'&lib='+t;
        var a=document.getElementsByTagName('script')[0];
        a.parentNode.insertBefore(o,a)};

          ttq.load('%s');
          ttq.page();
        }(window, document, 'ttq');
        </script>";

        return sprintf($script, $pixelId, $pixelId);
    }
}

if (!function_exists('metaKeywordSetting')) {
    function metaKeywordSetting($metakeyword = '', $metadesc = '', $metaimage = '', $slug = '')
    {
        $url = route('landing_page', $slug);
        $script = "
        <meta name='title' content='$metakeyword'>
        <meta name='description' content='$metadesc'>

        <meta property='og:type' content='website'>
        <meta property='og:url' content='$url'>
        <meta property='og:title' content=' $metakeyword'>
        <meta property='og:description' content='$metadesc'>
        <meta property='og:image' content=' $metaimage'>

        <meta property='twitter:card' content='summary_large_image'>
        <meta property='twitter:url' content='$url'>
        <meta property='twitter:title' content=' $metakeyword'>
        <meta property='twitter:description' content=' $metadesc'>
        <meta property='twitter:image' content=' $metaimage'>
        ";

        return sprintf($script);
    }
}
