<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/user/themes/kirikiri/blueprints.yaml',
    'modified' => 1766862039,
    'size' => 548,
    'data' => [
        'name' => 'Kirikiri',
        'version' => '1.0.0',
        'description' => 'Custom theme for Kirikiri online magazine, migrated from Astro.',
        'icon' => 'text-width',
        'author' => [
            'name' => 'Antigravity',
            'email' => 'antigravity@ai.com'
        ],
        'homepage' => 'https://github.com/getgrav/grav-theme-kirikiri',
        'keywords' => 'kirikiri, astro, migration, magazine',
        'license' => 'MIT',
        'form' => [
            'validation' => 'loose',
            'fields' => [
                'dropdown.enabled' => [
                    'type' => 'toggle',
                    'label' => 'Dropdown in Menu',
                    'highlight' => 1,
                    'default' => 1,
                    'options' => [
                        1 => 'Enabled',
                        0 => 'Disabled'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ]
            ]
        ]
    ]
];
