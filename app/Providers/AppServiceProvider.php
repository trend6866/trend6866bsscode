<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // DB::whenQueryingForLongerThan(500, function (Connection $connection) {
        //     // Log::info($connection);
        // });

        // DB::listen(function ($query) {
        //     Log::info(' --------------------------------- Query data start --------------------------------- ');
        //     Log::info('sql : '. $query->sql);
        //     Log::info('sql data: '. json_encode($query->bindings));
        //     Log::info('sql execution time: '. $query->time);
        //     Log::info(' ---------------------------------  Query data end  --------------------------------- ');
        // });
    }
}
