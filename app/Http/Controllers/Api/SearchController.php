<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ElasticHelpers;
use App\Http\Controllers\Controller;
use App\Models\Icon;
use Elasticsearch\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(Request $request)
    {
        try {
            $payload = $request->validate([
                "query" => "string|nullable",
                "price" => "in:free,premium",
                "formats" => "string",
                "styles" => "string",
                "page" => "number"
            ]);

            Log::debug(json_encode(ElasticHelpers::buildSearchQuery($payload)));

            $result = $this->client->search([
                "index" => "icons",
                "body" => ElasticHelpers::buildSearchQuery($payload)
            ]);

            $result = ElasticHelpers::makeResult($result);

            return $this->success([
                "items" => $result[0],
                "aggs" => $result[1]
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return $this->error($e->getMessage(), $e);
        }
    }
}
