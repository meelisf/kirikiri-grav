<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledMarkdownFile',
    'filename' => '/var/www/html/user/pages/02.blog/blog.md',
    'modified' => 1766862372,
    'size' => 202,
    'data' => [
        'header' => [
            'title' => 'Artiklid',
            'menu' => 'Artiklid',
            'content' => [
                'items' => '@self.children',
                'order' => [
                    'by' => 'date',
                    'dir' => 'desc'
                ],
                'limit' => 10,
                'pagination' => true
            ]
        ],
        'frontmatter' => 'title: Artiklid
menu: Artiklid
content:
    items: \'@self.children\'
    order:
        by: date
        dir: desc
    limit: 10
    pagination: true',
        'markdown' => 'Siit leiad kõik meie artiklid ja märkmed.
'
    ]
];
