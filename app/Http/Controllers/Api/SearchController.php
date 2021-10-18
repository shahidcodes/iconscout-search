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
        "price" => "string|in:free,premium|nullable",
        "formats" => "string",
        "styles" => "string",
        "page" => "numeric",
        "perPage" => "numeric"
      ]);

      $perPage = 30;
      $page = 0;

      if (isset($payload['perPage'])) {
        $perPage = intval($payload['perPage']);
      }
      if (isset($payload['page'])) {
        $page = intval($payload['page']);
      }

      $result = $this->client->search([
        "index" => "icons",
        "size" => $perPage,
        "from" => $page,
        "body" => ElasticHelpers::buildSearchQuery($payload)
      ]);

      $result = ElasticHelpers::makeResult($result);

      return $this->success($result);
    } catch (\Exception $e) {
      //throw $th;
      return $this->error($e->getMessage(), $e);
    }
  }
}
