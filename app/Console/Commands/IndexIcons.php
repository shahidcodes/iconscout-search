<?php

namespace App\Console\Commands;

use App\Helpers\ElasticIndexMapping;
use App\Models\Icon;
use Elasticsearch\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class IndexIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:index-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all icons after dropping the index';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private Client $client;
    private ConsoleOutput $out;

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
        $out = new ConsoleOutput();
        $this->out = $out;
    }

    public function makeColors($colors)
    {
        $newColors = [];
        foreach ($colors as $color) {
            $newColors[] = ["code" => $color['code'], "weight" => $color['weight']];
        }
        return $newColors;
    }

    public function makeArrayOfField($arr, $fieldName)
    {
        return array_map(fn ($vl) => $vl[$fieldName], $arr);
    }

    public function buildModel($icon)
    {
        return [
            "name" => $icon["name"],
            "image" => $icon["image"],
            "price" => $icon["price"],
            "style" => $icon["style"],
            "colors" => $this->makeColors($icon['colors']),
            "categories" => $this->makeArrayOfField($icon['categories'], 'name'),
            "tags" => $this->makeArrayOfField($icon['tags'], 'name'),
            "formats" => $this->makeArrayOfField($icon['formats'], 'name'),
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->client->indices()->delete([
                "index" => "icons"
            ]);
            $this->out->writeln("index dropped");
        } catch (\Throwable $th) {
            $this->out->writeln("index already dropped");
        }
        $this->client->indices()->create([
            "index" => "icons",
            "body" => [
                "mappings" => ElasticIndexMapping::mapping()
            ]
        ]);
        $this->out->writeln("index created");
        $icons = Icon::with("colors", "formats", "categories", "tags", "contributor")->get()->toArray();
        $ndJSON = [
            "body" => []
        ];
        foreach ($icons as $icon) {
            $this->out->writeln("processing {$icon['id']}");
            $elasticModel = $this->buildModel($icon);
            $ndJSON['body'][] = [
                "index" => [
                    "_index" => "icons",
                    "_id" => $icon['id']
                ]
            ];
            $ndJSON['body'][] = $elasticModel;
        }
        $responses = $this->client->bulk($ndJSON);
        $this->out->writeln("done");
        return Command::SUCCESS;
    }
}
