<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Icon;
use Illuminate\Http\Request;

class IconController extends Controller
{
    //
    public function store(Request $request)
    {
        $payload = $request->validate([
            "name" => ["required"],
            "image" => ["required"],
            "price" => ["numeric"],
            "style" => ["required"],
            "colors" => ["required"]
        ]);

        $icon = Icon::create($payload);

        $icon->colors()->saveMany(Color::fromArray($payload['colors']));

        return $icon;
    }
}
