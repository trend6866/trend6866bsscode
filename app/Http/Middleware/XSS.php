<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Utility;

class XSS
{
    use \RachidLaasri\LaravelInstaller\Helpers\MigrationsHelper;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            // if(\Request::segment(1) != 'admin' && ( Auth::user()->type == 'admin' || Auth::user()->type == 'superadmin')){
            //     return redirect()->route('admin.dashboard');
            // }
            // elseif(\Request::segment(1) == 'admin' && ( Auth::user()->type != 'admin' && Auth::user()->type != 'superadmin'))
            // {
            //     return redirect()->route('landing_page');
            // }

            if (\Auth::guard('admin')->user()->type == 'superadmin')
            {
                $migrations             = $this->getMigrations();
                $dbMigrations           = $this->getExecutedMigrations();
                $Modulemigrations = glob(base_path().'/Modules/LandingPage/Database'.DIRECTORY_SEPARATOR.'Migrations'.DIRECTORY_SEPARATOR.'*.php');
                $numberOfUpdatesPending = (count($migrations) + count($Modulemigrations)) - count($dbMigrations);

                // dd($migrations, $dbMigrations);

                if($numberOfUpdatesPending > 0)
                {
                    Utility::addNewData();
                    Utility::defaultEmail();
                    return redirect()->route('LaravelUpdater::welcome');
                }
            }

        }
        // $slug =request()->segments()[0];
        // $theme_id = User::where('slug',$slug)->first()->theme_id;
        // config(['app.theme' => $theme_id]);

        $input = $request->all();
        // array_walk_recursive(
        //     $input, function (&$input){
        //     $input = strip_tags($input);
        // }
        // );
        $request->merge($input);
        return $next($request);
    }
}
