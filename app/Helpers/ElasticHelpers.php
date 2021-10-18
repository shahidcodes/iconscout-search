<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ElasticHelpers
{

  public static function buildSearchQuery($payload)
  {
    $filterQuery = [];
    $mustNotQuery = [];

    if (isset($payload['query'])) {
      $filterQuery[] =  [
        "simple_query_string" => [
          "query" => $payload['query'],
          "fields" => [
            "name^30",
            "tags^2",
            "categories^1"
          ]
        ]
      ];
    }
    if (isset($payload['price'])) {
      $priceTermQuery = [
        "term" => [
          "price" => 0
        ]
      ];
      if ($payload['price'] === 'free') {
        $filterQuery[] = $priceTermQuery;
      } else {
        $mustNotQuery[] = $priceTermQuery;
      }
    }

    if (isset($payload['formats'])) {
      $filterQuery[] = [
        "terms_set" => [
          "formats" => [
            "terms" => explode(',', $payload["formats"]),
            "minimum_should_match_script" => [
              "source" => "return 1"
            ]
          ]
        ],
      ];
    }
    if (isset($payload['styles'])) {
      $filterQuery[] = [
        "terms_set" => [
          "style" => [
            "terms" => explode(',', $payload["styles"]),
            "minimum_should_match_script" => [
              "source" => "return 1"
            ]
          ]
        ],
      ];
    }
    $query = [
      "query" => [
        "bool" => [
          "filter" => $filterQuery,
        ]
      ],
      "aggs" => [
        "styles" => [
          "terms" => [
            "field" => "style"
          ]
        ]
      ]
    ];
    if (count($mustNotQuery) !== 0) {
      $query['query']['bool']['must_not'] = $mustNotQuery;
    }
    // dd(json_encode($query));
    return $query;
  }

  public static function makeResult($elasticResponse)
  {
    $hits = $elasticResponse['hits'];
    $searchResults = $hits['hits'];
    $aggs = [];
    if (isset($elasticResponse['aggregations'])) {
      $aggs = $elasticResponse['aggregations']['styles']['buckets'];
      $aggs = array_map(fn ($v) => $v['key'], $aggs);
    }
    $results = array_map(fn ($v) => $v['_source'], $searchResults);
    return [
      "items" => $results,
      "aggs" => $aggs,
      "total" => $hits["total"]["value"]
    ];
  }
}
