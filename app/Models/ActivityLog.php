<?php

namespace App\Models;

use AWS\CRT\HTTP\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ActivityLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'log_type',
        'remark',
        'theme_id',
        'store_id',
    ];

    public static function order_entry($data= [])
    {
        // order create activity log
        $ActivityLog = new ActivityLog();
        $ActivityLog->user_id = $data['user_id'];
        $ActivityLog->log_type = 'place order';
        $ActivityLog->remark = json_encode(
            [
                'order_id' => $data['order_id'],
                'order_date' => $data['order_date'],
                'product' => $data['products'],
                'price' => $data['final_price'],
                'payment_type' => $data['payment_type'],
            ]
        );
        $ActivityLog->theme_id = $data['theme_id'];
        $ActivityLog->store_id = $data['store_id'];
        $ActivityLog->save();
    }

    public function userinfo()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function products($id = '')
    {
        $productIdArray = explode(',', $id);
        $products = Product::whereIn('id', $productIdArray)->get();
        $productNames = [];
        foreach ($products as $product) {
            $productNames[] = $product->name;
        }
        return implode(', ', $productNames);

    }

    public static function variants($id = '')
    {
        $variant = ProductStock::find($id)->first();
        return $variant->variant;
    }

    public static function totalspend($userId = null)
    {
        $totalSpend = 0;
        $totalOrders = 0;

        if($userId)
        {
            $results = Order::where('user_id', $userId)
                    ->select(\DB::raw('SUM(final_price) as total_price ,COUNT(*) as order_count'))
                    ->first();
            
            if ($results) {
                $totalSpend = !empty($results->total_price) ? $results->total_price : '0';
                $totalOrders = $results->order_count;
            }
        }
        return ['total_spend' => $totalSpend, 'total_orders' => $totalOrders];
         
    }    


}
