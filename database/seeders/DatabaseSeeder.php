<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('module:migrate LandingPage');
        Artisan::call('module:seed LandingPage');
        if(\Request::route()->getName()!='LaravelUpdater::database')
        {
            $this->call(UsersTableSeeder::class);
            $this->call(PlansTableSeeder::class);
    
            $this->call(AiTemplateSeeder::class);
        }
        
    }
}
