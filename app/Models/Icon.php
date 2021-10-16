<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image', 'price', 'style'
    ];

    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function format()
    {
        return $this->hasOne(Format::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function contributor()
    {
        return $this->hasOne(Contributor::class);
    }
}
