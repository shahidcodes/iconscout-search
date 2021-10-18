<?php

namespace App\Helpers;

class ElasticIndexMapping
{
  public static function mapping()
  {
    return [
      '_source' => [
        'enabled' => true
      ],
      'properties' => [
        'categories' => [
          'type' => 'text',
          'fields' => [
            'keyword' => [
              'type' => 'keyword',
              'ignore_above' => 256,
            ],
          ],
        ],
        'colors' => [
          'properties' => [
            'code' => [
              'type' => 'keyword',
            ],
            'weight' => [
              'type' => 'long',
            ],
          ],
        ],
        'formats' => [
          'type' => 'text',
          'fields' => [
            'keyword' => [
              'type' => 'keyword',
              'ignore_above' => 256,
            ],
          ],
        ],
        'image' => [
          'type' => 'keyword',
        ],
        'name' => [
          'type' => 'text',
          'fields' => [
            'keyword' => [
              'type' => 'keyword',
              'ignore_above' => 256,
            ],
          ],
        ],
        'price' => [
          'type' => 'long',
        ],
        'style' => [
          'type' => 'keyword',
        ],
        'tags' => [
          'type' => 'text',
          'fields' => [
            'keyword' => [
              'type' => 'keyword',
              'ignore_above' => 256,
            ],
          ],
        ],
      ],
    ];
  }
}
