<?php

namespace App\Http\Middleware;

use App\Models\Plan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user())
        {
            $user = Auth::user();

            if($user->type == 'admin')
            {
                // if($plan)
                // {
                    $datetime1 = new \DateTime($user->plan_expire_date);
                    $datetime2 = new \DateTime(date('Y-m-d'));
                    $interval = $datetime2->diff($datetime1);
                    $days     = $interval->format('%r%a');
                    $plano = Plan::find(\Auth::user()->plan);
                    $uri = \Request::route()->uri();
                    if($days <= 0 && $plano->name != "Renew" && $plano->name != "Free Plan" && $plano->id != "" ||(
                       preg_match("#^backend/admin/dashboard#", $uri)                  || preg_match("#^backend/admin/themeanalytic#", $uri)              || preg_match("#^backend/admin/themes#", $uri)
                    || preg_match("#^backend/admin/roles#", $uri)                      || preg_match("#^abackend/dmin/users#", $uri)                      || preg_match("#^backend/admin/app-setting#", $uri)
                    || preg_match("#^backend/admin/product#", $uri)                    || preg_match("#^backend/admin/product-attribute#", $uri)          || preg_match("#^backend/admin/review#", $uri)
                    || preg_match("#^backend/admin/tax#", $uri)                        || preg_match("#^backend/admin/product-question#", $uri)           || preg_match("#^backend/admin/main-category#", $uri)
                    || preg_match("#^backend/admin/shipping#", $uri)                   || preg_match("#^backend/admin/shippingZone#", $uri)               || preg_match("#^backend/admin/order#", $uri)
                    || preg_match("#^backend/admin/RefundRequest#", $uri)              || preg_match("#^backend/admin/customer#", $uri)                   || preg_match("#^backend/admin/reports#", $uri)
                    || preg_match("#^backend/admin/order-report#", $uri)               || preg_match("#^backend/admin/product-order-sale-reports#", $uri) || preg_match("#^backend/admin/category-order-sale-reports#", $uri)
                    || preg_match("#^backend/admin/order-downloadable-reports#", $uri) || preg_match("#^backend/admin/stock-reports#", $uri)              || preg_match("#^backend/admin/coupon#", $uri)
                    || preg_match("#^backend/admin/newsletter#", $uri)                 || preg_match("#^backend/admin/flash-sale#", $uri)                 || preg_match("#^backend/admin/wishlist#", $uri)
                    || preg_match("#^backend/admin/pos#", $uri)                        || preg_match("#^backend/admin/support_ticket#", $uri)             || preg_match("#^backend/admin/abandon-carts-handled#", $uri)
                    || preg_match("#^backend/admin/pages#", $uri)                      || preg_match("#^backend/admin/blogs#", $uri)                      || preg_match("#^backend/admin/faqs#", $uri)
                    || preg_match("#^backend/admin/setting#", $uri)                    || preg_match("#^backend/admin/contacts#", $uri)
                    )&&($days <= 0 && $plano->name != "Free Plan" ))
                    {
                        $plan = Plan::where('name','Renew')->first();
                        $user->assignPlan($plan->id,$user->id);
                        return redirect()->route('admin.plan.index')->with('error', __('Your Plan is expired.'));
                    }
                    if($days <= 0 && $plano->name != "Renew" && $plano->name != "Free Plan" && $plano->id == "" )
                    {
                        $plan = Plan::where('name','Free Plan')->first();
                        $user->assignPlan($plan->id,$user->id);
                        return redirect()->route('admin.plan.index');
                    }

                // }
            }
        }
        $lang = (session()->get('lang')) ? session()->get('lang') : 'en';

        if(Auth::check())
        {
            $lang=Auth::user()->lang;
        }else{
            $superadmin = \App\Models\Admin::where('type','superadmin')->first();
            $lang = !empty($lang) ? $lang : $superadmin->default_language;
        }

        App::setLocale($lang);

        return $next($request);
    }
}
