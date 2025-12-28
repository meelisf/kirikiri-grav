<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledMarkdownFile',
    'filename' => '/var/www/html/user/pages/01.home/home.md',
    'modified' => 1766930909,
    'size' => 137,
    'data' => [
        'header' => [
            'title' => 'Esileht',
            'content' => [
                'items' => [
                    '@page.children' => '/blog'
                ],
                'order' => [
                    'by' => 'date',
                    'dir' => 'desc'
                ],
                'limit' => 6
            ]
        ],
        'frontmatter' => 'title: Esileht
content:
    items: 
        \'@page.children\': \'/blog\'
    order:
        by: date
        dir: desc
    limit: 6',
        'markdown' => ''
    ]
];
