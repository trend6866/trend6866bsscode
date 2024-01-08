<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description', 'image_path', 'image_url', 'charges_type', 'return_order_dutation', 'amount', 'status', 'theme_id'
    ];
    
    protected $hidden = ["image_url"];
    protected $appends = ["expeted_delivery","image_path_full_url"];
    
    public function getExpetedDeliveryAttribute()
    {
        $return_date1 = $this->return_order_dutation;
        $return_date = date('Y-m-d H:i:s', strtotime($this->delivery_date. ' + '.$return_date1.' days'));
        return $return_date;
    }

    public function getImagePathFullUrlAttribute() {
        return get_file($this->image_path, $this->theme_id);
    }
}
