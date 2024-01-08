<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShippingZone extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'zone_name',
        'country_id',
        'state_id',
        'shipping_method',
        'theme_id',
        'store_id'
    ];

    public static function modules()
    {
        $shippingMethod = [
            'Flat Rate' => 'Flat Rate',
            'Free shipping' => 'Free shipping',
            'Local pickup' => 'Local pickup',
        ];
        return $shippingMethod;
    }

    public function getCountryNameAttribute()
    {
        return country::where('id',$this->country_id)->first();
    }

    public function getStateNameAttribute()
    {
        return state::where('id',$this->state_id)->first();
    }

    public function getShippingMethod()
    {
        return ShippingMethod::where('id',$this->shipping_method)->first();
    }
}
