<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetCookie extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "set_cookies";
    protected $casts = [
        'data_values' => 'object'
    ];

    public static function scopeGetContent($data_keys)
    {
        return SetCookie::where('data_keys', $data_keys);
    }
}
