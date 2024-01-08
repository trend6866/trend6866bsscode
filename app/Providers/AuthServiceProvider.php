<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        ResetPassword::createUrlUsing(function ($user, string $token) 
        {   
            if($user->type == 'customer')
            {
                if(request()->segments())
                {
                    $slug =request()->segments()[0];
                }
                $resetpassword_url = route('password.reset',[$slug, $token]);
            }
            else
            {
                $resetpassword_url = route('admin.password.reset', $token);
            }
            $resetpassword_url = $resetpassword_url.'?email='.$user->email.'&type='.$user->type;            
            return $resetpassword_url;
        });
    }
}

