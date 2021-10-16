<?php

namespace App\Helpers;


class ElasticHelpers
{

  public static function buildSearchQuery($payload)
  {
    $fullTextSearch = [];
    $filterQuery = [];
    $mustNotQuery = [];

    if (isset($payload['query'])) {
      $fullTextSearch =  [
        "query" => $payload['query'],
        "fields" => [
          "name^30",
          "tags^2",
          "categories^1"
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

    if (count($fullTextSearch) !== 0) {
      $query['query'] = [
        'simple_query_string' => $fullTextSearch
      ];
    }

    return $query;
  }

  public static function makeResult($elasticResponse)
  {
    $searchResults = $elasticResponse['hits']['hits'];
    $aggs = [];
    if (isset($elasticResponse['aggregations'])) {
      $aggs = $elasticResponse['aggregations']['styles']['buckets'];
      $aggs = array_map(fn ($v) => $v['key'], $aggs);
    }
    $results = array_map(fn ($v) => $v['_source'], $searchResults);
    return [$results, $aggs];
  }
}
