<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/user/config/site.yaml',
    'modified' => 1766862414,
    'size' => 398,
    'data' => [
        'title' => 'Kirikiri',
        'author' => [
            'name' => 'Meelis Friedenthal',
            'email' => 'meelis@example.com'
        ],
        'metadata' => [
            'description' => 'Märkmed, artiklid ja muud kirjatükid.'
        ],
        'taxonomies' => [
            0 => 'category',
            1 => 'tag'
        ],
        'pages' => [
            'theme' => 'kirikiri',
            'order' => [
                'by' => 'default',
                'dir' => 'asc'
            ],
            'process' => [
                'markdown' => true,
                'twig' => true
            ],
            'dateformat' => [
                'default' => 'd.m.Y H:i',
                'short' => 'd.m.Y',
                'long' => 'd. F, Y'
            ]
        ]
    ]
];
