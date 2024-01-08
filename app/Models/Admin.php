<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Lab404\Impersonate\Models\Impersonate;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,Impersonate;

    protected $guard = 'admin';
    protected $guard_name = 'web';

    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $fillable = [
        'name',
        'email',
        'profile_image',
        'type',
        'email_verified_at',
        'password',
        'mobile',
        'register_type',
        'theme_id',
        'remember_token',
        'created_by',
        'default_language',
        'storage_limit',

    ];

    protected $hidden = [
      'password', 'remember_token',
    ];

    public static $defalut_theme = [
        'grocery',
        'babycare',
    ];

    public function stores()
    {
        return $this->belongsToMany('App\Models\Store', 'user_stores', 'user_id', 'store_id')->withPivot('permission');
    }

    public function countStore()
    {
        return Store::where('created_by', '=', $this->creatorId())->count();
    }

    public function countProducts()
    {
        return Product::where('created_by', '=', $this->creatorId())->count();
    }

    public function countCompany()
    {
        return Admin::where('type', '=', 'admin')->where('created_by', '=', $this->creatorId())->count();
    }

    public function currentPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan');
    }

    public function creatorId()
    {
        if($this->type == 'admin' || $this->type == 'superadmin')
        {
            return $this->id;
        }
        else
        {
            return $this->created_by;
        }
    }

    public static function slugs($data)
    {
        $slug = '';
        $slug = strtolower(str_replace(" ", "-",$data));
        $table        = with(new Store)->getTable();
        $allSlugs = User::getRelatedSlugs($table, $slug ,$id = 0);



        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;

            }
        }
        // dd($allSlugs , $table);
        // return $slug;
    }

    public function assignPlan($planID)
    {
        $plan = Plan::find($planID);
        if($plan)
        {
            $this->plan = $plan->id;
            if($plan->duration == 'Month')
            {
                $this->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            }
            elseif($plan->duration == 'Year')
            {
                $this->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            }
            else if($plan->duration == 'Unlimited')
            {
                $this->plan_expire_date = null;
            }
            // else
            // {
            //     $this->plan_expire_date=null;
            // }
            $this->save();

            $users    = Admin::where('created_by', '=', \Auth::guard('admin')->user()->creatorId())->where('type', '!=', 'superadmin')->get();
            $products = Product::where('created_by', '=', \Auth::guard('admin')->user()->creatorId())->get();
            $stores   = Store::where('created_by', '=', \Auth::guard('admin')->user()->creatorId())->get();

            if($plan->max_stores == -1)
            {
                foreach($stores as $store)
                {
                    $store->is_active = 1;
                    $store->save();
                }
            }
            else
            {
                $storeCount = 0;
                foreach($stores as $store)
                {
                    $storeCount++;
                    if($storeCount <= $plan->max_stores)
                    {
                        $store->is_active = 1;
                        $store->save();
                    }
                    else
                    {
                        $store->is_active = 0;
                        $store->save();
                    }
                }
            }

            if($plan->max_products == -1)
            {
                foreach($products as $product)
                {
                    $product->is_active = 1;
                    $product->save();
                }
            }
            else
            {
                $productCount = 0;
                foreach($products as $product)
                {
                    $productCount++;
                    if($productCount <= $plan->max_products)
                    {
                        $product->is_active = 1;
                        $product->save();
                    }
                    else
                    {
                        $product->is_active = 0;
                        $product->save();
                    }
                }
            }
            if($plan->max_users == -1)
            {
                foreach($users as $user)
                {
                    $user->is_active = 1;
                    $user->save();
                }
            }
            else
            {
                $userCount = 0;
                foreach($users as $user)
                {
                    $userCount++;
                    if($userCount <= $plan->max_users)
                    {
                        $user->is_active = 1;
                        $user->save();
                    }
                    else
                    {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }
            return ['is_success' => true];
        }
        else
        {
            return [
                'is_success' => false,
                'error' => 'Plan is deleted.',
            ];
        }
    }

    public function userEmailTemplateData($userID)
    {
         // Make Entry In User_Email_Template
         $allEmail = EmailTemplate::all();
         foreach ($allEmail as $email) {
             UserEmailTemplate::create(
                 [
                     'template_id' => $email->id,
                     'user_id' => $userID,
                     'is_active' => 0,
                 ]
             );
         }
    }

    public static function userDefaultDataRegister($user_id)
    {

        // Make Entry In User_Email_Template
        $allEmail = EmailTemplate::all();

        foreach($allEmail as $email)
        {
            UserEmailTemplate::create(
                [
                    'template_id' => $email->id,
                    'user_id' => $user_id,
                    'is_active' => 1,
                ]
            );
        }
    }
}






