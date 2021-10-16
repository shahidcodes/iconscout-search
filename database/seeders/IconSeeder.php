<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\Contributor;
use App\Models\Format;
use App\Models\Icon;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class IconSeeder extends Seeder
{
    public function __construct()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->out = $out;
    }

    public function getContributorId($icon)
    {
        $contributor = Contributor::where("name", "=", $icon['contributor'])->first();
        if (!$contributor) {
            $contributor = Contributor::create([
                "name" => $icon['contributor']
            ]);
        }
        return $contributor->id;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->out->writeln("model truncated");
        $iconResponse = Http::get("https://s3.wasabisys.com/iconscout-dev/dist/icons.json");
        $contents = json_decode($iconResponse->getBody(), true);
        $this->out->writeln("http.get: done");
        foreach ($contents as $index => $iconObject) {
            $this->out->writeln("processing icon : $index");

            $contributorId = $this->getContributorId($iconObject);
            $iconData = [
                "name" => $iconObject["name"],
                "price" => $iconObject["price"],
                "style" => $iconObject["style"],
                "image" => $iconObject["image"],
                "contributor_id" => $contributorId
            ];
            $icon = Icon::create($iconData);
            // add colors
            $colors = $iconObject["colors"];
            if (count($colors) !== 0) {
                $colorsData = [];
                foreach ($colors as $colorCode => $w) {
                    $colorsData[] = new Color([
                        "code" => $colorCode,
                        "weight" => $w,
                        "icon_id" => $icon->id
                    ]);
                }
                $icon->colors()->saveMany($colorsData);
            }
            // add tags
            $tags = $iconObject["tags"];
            if (count($tags) !== 0) {
                $tagsData = [];
                foreach ($tags as $tagName => $w) {
                    $tagsData[] = new Tag([
                        "name" => $tagName,
                        "icon_id" => $icon->id
                    ]);
                }
                $icon->tags()->saveMany($tagsData);
            }
            // add categories
            $categories = $iconObject["categories"];
            if (count($categories) !== 0) {
                $categoriesData = [];
                foreach ($categories as $catName) {
                    $categoriesData[] = new Category([
                        "name" => $catName,
                        "icon_id" => $icon->id
                    ]);
                }
                $icon->categories()->saveMany($categoriesData);
            }
            // add formats
            $formats = $iconObject["formats"];
            if (count($formats) !== 0) {
                $formatsData = [];
                foreach ($formats as $formatName) {
                    $formatsData[] = new Format([
                        "name" => $formatName,
                        "icon_id" => $icon->id
                    ]);
                }
                $icon->formats()->saveMany($formatsData);
            }
            $this->out->writeln("processing icon : $index - done");
        }
        //
    }
}
