<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading', 'image', 'button_text', 'status', 'theme_id'
    ];

    public function theme()
    {
        return $this->hasOne('App\Models\Theme', 'id', 'theme_id');
    }
}
