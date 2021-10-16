<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Icon;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $icons = Icon::with("tags", "categories", "contributor")->paginate(8);
        return view('icons', [
            "icons" => $icons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Icon  $icon
     * @return \Illuminate\Http\Response
     */
    public function show(Icon $icon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Icon  $icon
     * @return \Illuminate\Http\Response
     */
    public function edit(Icon $icon)
    {
        return view('icons_edit', ["icon" => $icon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Icon  $icon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Icon $icon)
    {
        //
        $payload = $request->validate([
            "name" => "required",
            "price" => "numeric",
            "style" => "required",
            "tags" => "required",
            "categories" => "required"
        ]);

        $icon->fill($payload)->save();
        $tags = explode(', ', $request->tags);
        $tagsModel = [];
        $iconTags = $icon->tags->toArray();
        foreach ($tags as $tag) {
            $index = array_search($tag, $iconTags);
            if (false != $index) {
                $tagsModel[] = new Tag($iconTags[$index]);
            } else {
                $tagsModel[] = new Tag([
                    "name" => $tag
                ]);
            }
        }
        $icon->tags()->delete();
        $icon->tags()->saveMany($tagsModel);

        $categories = explode(', ', $request->categories);
        $categoriesModel = [];
        $iconcategories = $icon->categories->toArray();
        foreach ($categories as $tag) {
            $index = array_search($tag, $iconcategories);
            if (false != $index) {
                $categoriesModel[] = new Category($iconcategories[$index]);
            } else {
                $categoriesModel[] = new Category([
                    "name" => $tag
                ]);
            }
        }
        $icon->categories()->delete();
        $icon->categories()->saveMany($categoriesModel);
        return Redirect::back()->with("message", "Successfully updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Icon  $icon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Icon $icon)
    {
        //
        $icon->delete();
        return Redirect::back()->with("message", "Successfully deleted");
    }
}
