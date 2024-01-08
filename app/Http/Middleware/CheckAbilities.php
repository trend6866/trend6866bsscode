<?php

namespace Laravel\Sanctum\Http\Middleware;

use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;

class CheckAbilities
{
    use ApiResponser;
    
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$abilities
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\AuthenticationException|\Laravel\Sanctum\Exceptions\MissingAbilityException
     */
    public function handle($request, $next, ...$abilities)
    {

        
        if (! $request->user() || ! $request->user()->currentAccessToken()) {
            // throw new AuthenticationException;
            if ($request->is('api/*')) {
                return $this->error(['message' => 'Current Access Token expired.'], 'fail', 401);
            }
        }

        foreach ($abilities as $ability) {
            if (! $request->user()->tokenCan($ability)) {
                throw new MissingAbilityException($ability);
            }
        }

        return $next($request);
    }
}
