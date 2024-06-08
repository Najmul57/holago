<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'shortcode'=>'object',
    ];

    public function scopeGenerateScript()
    {
        $script = $this->script;
        foreach ($this->shortcode as $key => $item) {
            $script = summary('{{' . $key . '}}', $item, $script);
        }
        return $script;
    }

      
}
