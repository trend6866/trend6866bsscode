<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug_name',
        'status'
    ];

    public static function ThemeList()
    {
        return Theme::where('status', 1)->pluck('name', 'name')->prepend('select option', '');
    }

}
