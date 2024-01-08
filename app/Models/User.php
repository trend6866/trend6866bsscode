<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;
use Lab404\Impersonate\Models\Impersonate;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Impersonate;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'profile_image',
        'type',
        'email_verified_at',
        'password',
        'mobile',
        'date_of_birth',
        'firebase_token',
        'device_type',
        'register_type',
        'google_id',
        'facebook_id',
        'apple_id',
        'theme_id',
        'remember_token',
        'created_by',
        'regiester_date',
        'last_active',
        'status',
        // 'slug',
        'store_id'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // *********************************
    protected $appends = ["demo_field", "name", "address", "postcode"];

    public function getDemoFieldAttribute()
    {
        return 'demo_field';
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getAddressAttribute()
    {
        $address  = '';
        if(!empty(auth()->user())) {
            $DeliveryAddress = DeliveryAddress::where('user_id', auth()->user()->id)->where('default_address', 1)->first();
            if(!empty($DeliveryAddress)) {
                $address = $DeliveryAddress->address;
            } else {
                $DeliveryAddress = DeliveryAddress::where('user_id', auth()->user()->id)->where('title', 'main')->first();
                if(!empty($DeliveryAddress)) {
                    $address = $DeliveryAddress->address;
                }
            }
        }
        return $address;
    }

    public function getPostcodeAttribute()
    {
        $address = '';
        if(!empty(auth()->user())) {
            $DeliveryAddress = DeliveryAddress::where('user_id', auth()->user()->id)->where('default_address', 1)->first();
            $address  = '';
            if(!empty($DeliveryAddress)) {
                $address = $DeliveryAddress->postcode;
            } else {
                $DeliveryAddress = DeliveryAddress::where('user_id', auth()->user()->id)->where('title',
                'main')->first();
                if(!empty($DeliveryAddress)) {
                    $address = $DeliveryAddress->postcode;
                }
            }
        }
        return $address;
    }

    // *********************************

    public function UserAdditionalDetail()
    {
        return $this->hasOne(UserAdditionalDetail::class, 'user_id',
        'id');
    }

    public static function dateFormat($date)
    {
        $settings = Utility::GetValueByName();

        return date($settings['site_date_format'], strtotime($date));
    }



    protected static function getRelatedSlugs($table, $slug, $id = 0)
    {
        return DB::table($table)->select()->where('slug', 'like', $slug . '%')->where('id', '<>', $id)->get();
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

    public function Ordercount()
    {
        $users_id = Order::where('user_id', $this->id)->get();
        if($users_id->count() == 0){
            $orders_detail = OrderBillingDetail::where('email',$this->email)->get()->toArray();
            $order_id = [];
            foreach($orders_detail as $orders){
                $order_id[] = $orders['order_id'];

            }
            $orders = Order::whereIn('id', $order_id)->where('user_id', 0)->count();
        }
        else{
            $orders = Order::where('user_id', $this->id)->count();

        }
        return $orders;
    }

    public function getaddress()
    {
        return $this->hasOne(DeliveryAddress::class, 'user_id', 'id');
    }

    public function total_spend(){
        $users_id = Order::where('user_id', $this->id)->get();
        if($users_id->count() == 0){
            $orders_detail = OrderBillingDetail::where('email',$this->email)->get()->toArray();
            $order_id = [];
            foreach($orders_detail as $orders){
                $order_id[] = $orders['order_id'];

            }
                $orders = Order::whereIn('id',$order_id)->where('user_id', 0)->get();
                $total_spend = $orders->sum('final_price');

        }else{
            $orders = Order::where('user_id',$this->id)->get();
            $total_spend = $orders->sum('final_price');
        }
        return $total_spend;
    }

    public function getTotal()
    {

        $total = $this->last_active;

        return $total;
    }

    public static function customer_field()
    {
        $fields = [
            'Name' => 'Name',
            'Email' => 'Email',
            'Last active' => 'Last active',
            'AOV' => 'AOV',
            'No. of Orders' => 'No. of Orders',
            'Total Spend' => 'Total Spend',
        ];
        return $fields;
    }

    public static $fields_status = [
        'Includes',
        'Excludes',
    ];

    public static $fields_status1 = [
        'Before',
        'After',
        'Equal',
    ];

    public static $fields_status2 = [
        'Less Than',
        'More Than',
        'Equal',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
