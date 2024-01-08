<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdditionalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'password_otp', 'password_otp_datetime', 'company_name', 'country_id', 'state_id', 'city', 'theme_id'
    ];
}
