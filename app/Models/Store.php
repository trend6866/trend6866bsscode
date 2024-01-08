<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'theme_id', 
        'slug', 
        'enable_pwa_store',
        'content',
        'item_variable',
        'created_by',
        'default_language',
    ];

    public static function pwa_store($slug)
    {
        $store = Store::where('slug', $slug)->first();
        try {

            $pwa_data = \File::get(storage_path('uploads/customer_app/store_' . $store->id . '/manifest.json'));

            $pwa_data = json_decode($pwa_data);
        } catch (\Throwable $th) {
            $pwa_data = [];
        }
        return $pwa_data;
    }

}

