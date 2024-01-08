<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '*/get-payment-paytabs/callback',
         'admin/paytabs-payment-plan',
         'admin/iyzipay/callback/plan/*',
         '*/iyzipay/callback/*',
         'admin/aamarpay/*',
         '*/aamarpay/callback?*'
     ];
}
