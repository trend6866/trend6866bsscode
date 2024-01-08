<?php

  namespace App\Exports;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use DB;

  use Maatwebsite\Excel\Concerns\FromCollection;

  use Maatwebsite\Excel\Concerns\WithHeadings;



class CouponExport implements FromCollection, WithHeadings {




   public function headings(): array {




    // according to users table




    return [

        "Number",

        "Coupon Name",

        "Coupon Code",

        "Coupon Type",

        "Coupon Limit",

        "Coupon Expiry Date	",

        "Discount Amount",

        "Status",

       ];

    }




   public function collection(){
    $store = Store::where('id', \Auth::user()->current_store)->first();
    $data = Coupon::where('store_id', $store->id)->where('theme_id',APP_THEME())->get();
     $i = 1;
    foreach($data as $k => $coupon){
        unset($coupon->theme_id,$coupon->store_id ,$coupon->created_at,$coupon->updated_at);
        $data[$k]["id"] = $i++ ;

    }
       return collect($data);

   }

}
