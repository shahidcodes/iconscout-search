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

    public function formats()
    {
        return $this->hasMany(Format::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function contributor()
    {
        return $this->belongsTo(Contributor::class);
    }
}
