<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_name', 'tax_type', 'tax_amount', 'status', 'theme_id'
    ];

    protected $appends = ["demo_field", "tax_string"];

    public function getDemoFieldAttribute()
    {
        return 'demo_field';
    }

    public function getTaxStringAttribute()
    {
        $type_percentage = ($this->tax_type == 'percentage') ? '%' : '';
        $type_flat = ($this->tax_type == 'flat') ? '-' : '';        
        return $this->tax_name.' ('.$type_flat.$this->tax_amount.$type_percentage.')';
    }

    public static function TaxCount($data = [])
    {
        $store_id = !empty($data['store_id']) ? $data['store_id'] : 1;
        $theme_id = !empty($data['theme_id']) ? $data['theme_id'] : env('theme_id');
        $sub_total = !empty($data['sub_total']) ? $data['sub_total'] : 0;

        $Tax = Tax::select('tax_name', 'tax_type', 'tax_amount', 'id')->where('theme_id', $theme_id)->where('store_id',$store_id)->get();
        $tax_price = 0;
        $tax_name = 0;
        $original_price = $sub_total;
        $cart_array = [];
        $cart_array['original_price'] = SetNumber(floatval($original_price));
        $cart_array['tax_info'] = [];
        foreach ($Tax as $key1 => $value1) {
            $amount = $value1->tax_amount;
            $name = $value1->tax_name;
            if ($value1->tax_type == 'percentage') {
                $amount = $amount * $original_price / 100;
            }

            $cart_array['tax_info'][$key1]["tax_name"] = $value1->tax_name;
            $cart_array['tax_info'][$key1]["tax_type"] = $value1->tax_type;
            $cart_array['tax_info'][$key1]["tax_amount"] = $value1->tax_amount;
            $cart_array['tax_info'][$key1]["id"] = $value1->id;
            $cart_array['tax_info'][$key1]["tax_string"] = $value1->tax_string;
            $cart_array['tax_info'][$key1]["tax_price"] = SetNumber($amount);
            $tax_price += $amount;
            $tax_name = $name;
        }

        $CURRENCY_NAME = Utility::GetValueByName('CURRENCY_NAME',$theme_id);
        $CURRENCY= Utility::GetValueByName('CURRENCY',$theme_id);
        $cart_array['total_tax_price'] = SetNumber($tax_price);
        $total = $tax_price + $sub_total;
        $cart_array['final_price'] = SetNumber($total);
        $cart_array['currency_name'] = $CURRENCY_NAME;
        $cart_array['currency'] = $CURRENCY;
        $cart_array['tax_name'] = $tax_name;
        // $CURRENCY = Utility::GetValueByName('CURRENCY',$theme_id);
        // dd($cart_array);
        return $cart_array;
        
        
    }
}