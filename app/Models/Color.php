<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'weight'
    ];

    public static function fromArray($arr)
    {
        return array_map(function ($color) {
            return new Color($color);
        }, $arr);
    }
}
