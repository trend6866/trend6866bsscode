<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\OrderRefund;
use App\Models\Setting;
use App\Models\Store;
use App\Models\UserStore;
use App\Models\Utility;
use DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrPermissions = [
            [
                "name" => "Manage Dashboard",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Store Analytics",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Super Dashboard",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage User",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create User",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit User",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete User",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Role",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Role",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Role",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Role",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Orders",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Orders",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Orders",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Products",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Products",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Products",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Products",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Variants",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Variants",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Variants",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Variants",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Product Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Product Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Product Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Product Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Product Sub Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Product Sub Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Product Sub Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Product Sub Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Product Tax",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Product Tax",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Product Tax",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Product Tax",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Faqs",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Faqs",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Faqs",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Faqs",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Ratting",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Ratting",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Ratting",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Ratting",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Product Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Product Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Product Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Product Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Product Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Subscriber",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Subscriber",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Shipping Class",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Shipping Class",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Shipping Class",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Shipping Class",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Plan",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Plan",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Plan",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name"=>"Manage Plan Request",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Upgrade Plan",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Shipping Zone",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Shipping Zone",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Shipping Zone",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Shipping Zone",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Shipping Zone",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Shipping Method",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Shipping Method",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name"=>"Manage Pos",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name"=>"Create Pos",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Support Ticket",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Support Ticket",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Replay Support Ticket",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Status Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Customer Reports",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Wishlist",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Wishlist",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Wishlist",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Contact Us",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Contact Us",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Contact Us",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Contact Us",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Product Question",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Replay Product Question",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Product Question",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Custom Page",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Custom Page",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Custom Page",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Custom Page",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Blog",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Blog",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Blog",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Blog",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Settings",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Language",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Language",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Language",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Store Setting",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Store Setting",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Store",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Store",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Store",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Store",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Reset Password",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Themes",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Themes",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Admin Store",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Change Admin Store",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Woocommerce Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Woocommerce Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Woocommerce Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Woocommerce Product",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Woocommerce Product",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Woocommerce Product",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Woocommerce Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Woocommerce Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Woocommerce Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Woocommerce Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Woocommerce Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Woocommerce Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            //
            [
                "name" => "Manage Shopify Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Shopify Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Shopify Category",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Shopify Product",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Shopify Product",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Shopify Product",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Shopify Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Shopify Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Shopify Customer",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Shopify Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Shopify Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Shopify Coupon",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],

            [
                "name" => "Manage Order Reports",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Stock Reports",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Refund Request",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Abandon Wishlist",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Abandon Cart",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Cart",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Show Cart",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Cart",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Flashsale",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Flashsale",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Flashsale",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit Flashsale",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage Order Note",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create Order Note",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete Order Note",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Manage DeliveryBoy",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Create DeliveryBoy",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Edit DeliveryBoy",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                "name" => "Delete DeliveryBoy",
                "guard_name" => "web",
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],

        ];

        Permission::insert($arrPermissions);

        // Super admin
        $superAdminRole        = Role::create(
            [
                'name' => 'super admin',
                'created_by' => 0,
            ]
        );

        $superAdminPermissions = [
            ["name" => "Manage Super Dashboard"],
            ["name" => "Manage Language"],
            ["name" => "Create Language"],
            ["name" => "Delete Language"],
            ["name" => "Manage Store"],
            ["name" => "Create Store"],
            ["name" => "Delete Store"],
            ["name" => "Edit Store"],
            ["name" => "Reset Password"],
            ["name" => "Manage Coupon"],
            ["name" => "Create Coupon"],
            ["name" => "Delete Coupon"],
            ["name" => "Edit Coupon"],
            ["name" => "Show Coupon"],
            ["name" => "Manage Settings"],
            ["name" => "Manage Plan"],
            ["name" => "Create Plan"],
            ["name" => "Edit Plan"],
            ["name" => "Upgrade Plan"],
            ["name" => "Manage Plan Request"],
        ];

        $superAdminRole->givePermissionTo($superAdminPermissions);

        $superAdmin = Admin::where('type','superadmin')->first();
        if(empty($superAdmin))
        {
            $superAdmin              = Admin::create(
                [
                    'name' => 'SuperAdmin',
                    'email' => 'superadmin@example.com',
                    'profile_image' => 'themes/grocery/uploads/avatar.png',
                    'type' => 'superadmin',
                    'email_verified_at' => null,
                    'password' => bcrypt('1234'),
                    'mobile' => 9999999999,
                    'register_type' => 'email',
                    'theme_id' => 'grocery',
                    'created_by' => 0,
                    'current_store' => 1,
                    'lang' => 'en',
                    'default_language' => 'en',
                ]
            );

            $superAdmin->assignRole($superAdminRole);
        }else{
            $superAdmin->assignRole($superAdminRole);
        }

         // Admin
         $adminRole        = Role::create(
            [
                'name' => 'Admin',
                'created_by' => $superAdmin->id,
            ]
        );

        $adminPermissions = [
            ["name" => "Manage Dashboard"],
            ["name" => "Manage Store Analytics"],
            ["name" => "Manage Role"],
            ["name" => "Create Role"],
            ["name" => "Delete Role"],
            ["name" => "Edit Role"],
            ["name" => "Manage User"],
            ["name" => "Create User"],
            ["name" => "Delete User"],
            ["name" => "Edit User"],
            ["name" => "Reset Password"],
            ["name" => "Manage Orders"],
            ["name" => "Show Orders"],
            ["name" => "Delete Orders"],
            ["name" => "Manage Products"],
            ["name" => "Create Products"],
            ["name" => "Delete Products"],
            ["name" => "Edit Products"],
            ["name" => "Manage Product Category"],
            ["name" => "Create Product Category"],
            ["name" => "Delete Product Category"],
            ["name" => "Edit Product Category"],
            ["name" => "Manage Product Sub Category"],
            ["name" => "Create Product Sub Category"],
            ["name" => "Delete Product Sub Category"],
            ["name" => "Edit Product Sub Category"],
            ["name" => "Manage Variants"],
            ["name" => "Create Variants"],
            ["name" => "Edit Variants"],
            ["name" => "Delete Variants"],
            ["name" => "Manage Product Tax"],
            ["name" => "Create Product Tax"],
            ["name" => "Delete Product Tax"],
            ["name" => "Edit Product Tax"],
            ["name" => "Manage Ratting"],
            ["name" => "Create Ratting"],
            ["name" => "Edit Ratting"],
            ["name" => "Delete Ratting"],
            ["name" => "Manage Product Coupon"],
            ["name" => "Create Product Coupon"],
            ["name" => "Show Product Coupon"],
            ["name" => "Delete Product Coupon"],
            ["name" => "Edit Product Coupon"],
            ["name" => "Manage Subscriber"],
            ["name" => "Delete Subscriber"],
            ["name" => "Manage Custom Page"],
            ["name" => "Create Custom Page"],
            ["name" => "Delete Custom Page"],
            ["name" => "Edit Custom Page"],
            ["name" => "Manage Blog"],
            ["name" => "Create Blog"],
            ["name" => "Delete Blog"],
            ["name" => "Edit Blog"],
            ["name" => "Manage Contact Us"],
            ["name" => "Create Contact Us"],
            ["name" => "Delete Contact Us"],
            ["name" => "Edit Contact Us"],
            ["name" => "Manage Faqs"],
            ["name" => "Create Faqs"],
            ["name" => "Delete Faqs"],
            ["name" => "Edit Faqs"],
            ["name" => "Manage Settings"],
            ["name" => "Manage Store Setting"],
            ["name" => "Edit Store Setting"],
            ["name" => "Manage Themes"],
            ["name" => "Edit Themes"],
            ["name" => "Manage Wishlist"],
            ["name" => "Delete Wishlist"],
            ["name" => "Show Wishlist"],
            ["name" => "Manage Shipping Class"],
            ["name" => "Create Shipping Class"],
            ["name" => "Delete Shipping Class"],
            ["name" => "Edit Shipping Class"],
            ["name" => "Manage Shipping Zone"],
            ["name" => "Create Shipping Zone"],
            ["name" => "Delete Shipping Zone"],
            ["name" => "Edit Shipping Zone"],
            ["name" => "Show Shipping Method"],
            ["name" => "Edit Shipping Method"],
            ["name" => "Manage Plan"],
            ["name" => "Manage Pos"],
            ["name" => "Create Pos"],
            ["name" => "Manage Support Ticket"],
            ["name" => "Delete Support Ticket"],
            ["name" => "Replay Support Ticket"],
            ["name" => "Manage Customer"],
            ["name" => "Show Customer"],
            ["name" => "Status Customer"],
            ["name" => "Manage Customer Reports"],
            ["name" => "Manage Product Question"],
            ["name" => "Replay Product Question"],
            ["name" => "Delete Product Question"],
            ["name" => "Create Admin Store"],
            ["name" => "Change Admin Store"],
            ["name" => "Manage Woocommerce Category"],
            ["name" => "Create Woocommerce Category"],
            ["name" => "Edit Woocommerce Category"],
            ["name" => "Manage Woocommerce Product"],
            ["name" => "Create Woocommerce Product"],
            ["name" => "Edit Woocommerce Product"],
            ["name" => "Manage Woocommerce Customer"],
            ["name" => "Create Woocommerce Customer"],
            ["name" => "Edit Woocommerce Customer"],
            ["name" => "Manage Woocommerce Coupon"],
            ["name" => "Create Woocommerce Coupon"],
            ["name" => "Edit Woocommerce Coupon"],
            ["name" => "Manage Shopify Category"],
            ["name" => "Create Shopify Category"],
            ["name" => "Edit Shopify Category"],
            ["name" => "Manage Shopify Product"],
            ["name" => "Create Shopify Product"],
            ["name" => "Edit Shopify Product"],
            ["name" => "Manage Shopify Customer"],
            ["name" => "Create Shopify Customer"],
            ["name" => "Edit Shopify Customer"],
            ["name" => "Manage Shopify Coupon"],
            ["name" => "Create Shopify Coupon"],
            ["name" => "Edit Shopify Coupon"],
            ["name" => "Manage Order Reports"],
            ["name" => "Manage Stock Reports"],
            ["name" => "Manage Refund Request"],
            ["name" => "Manage Cart"],
            ["name" => "Show Cart"],
            ["name" => "Delete Cart"],
            ["name" => "Abandon Cart"],
            ["name" => "Abandon Wishlist"],
            ["name" => "Manage Flashsale"],
            ["name" => "Create Flashsale"],
            ["name" => "Delete Flashsale"],
            ["name" => "Edit Flashsale"],
            ["name" => "Manage Order Note"],
            ["name" => "Create Order Note"],
            ["name" => "Delete Order Note"],
            ["name" => "Manage DeliveryBoy"],
            ["name" => "Create DeliveryBoy"],
            ["name" => "Edit DeliveryBoy"],
            ["name" => "Delete DeliveryBoy"],
        ];

        $adminRole->givePermissionTo($adminPermissions);

        $admin = Admin::where('type','admin')->first();
        if(empty($admin))
        {
            $admin              = Admin::create(
                [
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'profile_image' => 'themes/grocery/uploads/avatar.png',
                    'type' => 'admin',
                    'email_verified_at' => null,
                    'password' => bcrypt('1234'),
                    'mobile' => 9999999999,
                    'register_type' => 'email',
                    'theme_id' => 'grocery',
                    'created_by' => 1,
                    'current_store' => 2,
                    'lang' => 'en',
                    'default_language' => 'en',
                ]
            );
            $admin->assignRole($adminRole);
        }
        else{
            $admin->assignRole($adminRole);
        }

        $store = Store::get();
        if(count($store) <= 0)
        {
            $store1             = Store::create(
                [
                    'name' => 'Demo Store',
                    'email' => 'superadmin@example.com',
                    'theme_id' => 'grocery',
                    'slug' => 'demo-store',
                    'created_by' => 1,
                    'enable_pwa_store' => 'off',
                    'default_language' => 'en',
                    'content' => 'Hi,
                        *Welcome to* {store_name},
                        Your order is confirmed & your order no. is {order_no}
                        Your order detail is:
                        Name : {customer_name}
                        Address : {billing_address} {billing_city} , {shipping_address} {shipping_city}
                        ~~~~~~~~~~~~~~~~
                        {item_variable}
                        ~~~~~~~~~~~~~~~~
                        Qty Total : {qty_total}
                        Sub Total : {sub_total}
                        Discount Price : {discount_amount}
                        Shipping Price : {shipping_amount}
                        Tax : {total_tax}
                        Total : {final_total}
                        ~~~~~~~~~~~~~~~~~~
                        To collect the order you need to show the receipt at the counter.
                        Thanks {store_name}
                        ',
                    'item_variable' => '{quantity} x {product_name} - {variant_name} + {item_tax} = {item_total}',
                ]
            );
            $store2          = Store::create(
                [
                    'name' => 'My Store',
                    'email' => 'admin@example.com',
                    'theme_id' => 'grocery',
                    'slug' => 'my-store',
                    'created_by' => 2,
                    'enable_pwa_store' => 'off',
                    'default_language' => 'en',
                    'content' => 'Hi,
                        *Welcome to* {store_name},
                        Your order is confirmed & your order no. is {order_no}
                        Your order detail is:
                        Name : {customer_name}
                        Address : {billing_address} {billing_city} , {shipping_address} {shipping_city}
                        ~~~~~~~~~~~~~~~~
                        {item_variable}
                        ~~~~~~~~~~~~~~~~
                        Qty Total : {qty_total}
                        Sub Total : {sub_total}
                        Discount Price : {discount_amount}
                        Shipping Price : {shipping_amount}
                        Tax : {total_tax}
                        Total : {final_total}
                        ~~~~~~~~~~~~~~~~~~
                        To collect the order you need to show the receipt at the counter.
                        Thanks {store_name}
                        ',
                    'item_variable' => '{quantity} x {product_name} - {variant_name} + {item_tax} = {item_total}',
                ]
            );


            $storeuser1           = UserStore::create(
                [
                'user_id' => 1,
                'store_id' => 1,
                'permission' => 'admin',
                ]
            );
            $storeuser2           = UserStore::create(
                [
                    'user_id' => 2,
                    'store_id' => 2,
                    'permission' => 'admin',
                ]
            );
        }

        Utility::app_setting_insert($admin->id);
        Utility::page_insert($admin->id);
        Utility::WhatsappMeassage($admin->id);
        Utility::orderRefundSetting($admin->id);
        Utility::faqs_insert($admin->id);
        Utility::coupon_insert($admin->id);
        Utility::taxes_insert($admin->id);
        Utility::shipping_insert($admin->id);
        Utility::shipping_methods($admin->id);
        Utility::shipping_zones($admin->id);
        Utility::city_insert();
        Utility::state_insert();
        Utility::country_insert();

        $setting = Setting::get();
        if(count($setting) <= 0)
        {

            $data = [
                ['name'=>'title_text', 'value'=> 'EcommerceGo SaaS', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'footer_text', 'value'=> 'EcommerceGo SaaS', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'cust_theme_bg', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'SITE_RTL', 'value'=> 'off', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'cust_darklayout', 'value'=> 'off', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'logo_light', 'value'=> 'storage/uploads/logo/logo-light.png', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'logo_dark', 'value'=> 'storage/uploads/logo/logo-dark.png', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'favicon', 'value'=> 'storage/uploads/logo/favicon.png', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_cookie', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'cookie_logging', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'cookie_title', 'value'=> 'We use cookies!', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'cookie_description', 'value'=> 'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'necessary_cookies', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'strictly_cookie_title', 'value'=> 'Strictly necessary cookies', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'strictly_cookie_description', 'value'=> 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'more_information_description', 'value'=> 'Contact Us Description', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'contactus_url', 'value'=> '#', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'more_information_title', 'value'=> '#', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'display_landing', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'SIGNUP', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'storage_setting', 'value'=> 'local', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_storelink', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_domain', 'value'=> 'off', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'domains', 'value'=> '', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'enable_subdomain', 'value'=> 'off', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'subdomain', 'value'=> '', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'local_storage_validation', 'value'=> 'csv,jpeg,jpg,pdf,png,svg', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'local_storage_max_upload_size', 'value'=> '2048000', 'theme_id'=> 'grocery', 'store_id'=> 1, 'created_by'=> 1, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'stock_management', 'value'=> 'on', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'notification', 'value'=> '[]', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'low_stock_threshold', 'value'=> '2', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()],
                ['name'=>'out_of_stock_threshold', 'value'=> '0', 'theme_id'=> 'grocery', 'store_id'=> $store2->id, 'created_by'=> 2, 'created_at'=> now(), 'updated_at'=> now()]
            ];
            DB::table('settings')->insert($data);
        }

        $addon = [
            ['theme_id'=>'grocery', 'status'=> '1'],
            ['theme_id'=>'babycare', 'status'=> '1']
        ];
        $addons = Addon::get();
        if(count($addons) <= 0){
            DB::table('addons')->insert($addon);
        }

        Utility::defaultEmail();
        Utility::userDefaultData();

        // $OrderRefunds = OrderRefund::get();
        // if(count($OrderRefunds) <= 0)
        // {
        //     $OrderRefund = [
        //         ['name'=>'Manage Stock','user_id'=>$admin->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $store2->id, 'created_at'=> now(), 'updated_at'=> now()],
        //         ['name'=>'Attachment','user_id'=>$admin->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $store2->id, 'created_at'=> now(), 'updated_at'=> now()],
        //         ['name'=>'Shipment amount deduct during','user_id'=>$admin->id,'is_active'=>0,'theme_id'=>'grocery','store_id'=> $store2->id, 'created_at'=> now(), 'updated_at'=> now()],
        //     ];
        //     DB::table('order_refund_settings')->insert($OrderRefund);
        // }
    }
}
