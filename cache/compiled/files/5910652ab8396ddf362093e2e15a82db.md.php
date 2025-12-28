<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledMarkdownFile',
    'filename' => '/var/www/html/user/plugins/error/pages/error.md',
    'modified' => 1763891688,
    'size' => 200,
    'data' => [
        'header' => [
            'title' => 'Page not Found',
            'robots' => 'noindex,nofollow',
            'template' => 'error',
            'routable' => false,
            'http_response_code' => 404,
            'twig_first' => true,
            'process' => [
                'twig' => true
            ],
            'expires' => 0
        ],
        'frontmatter' => 'title: Page not Found
robots: noindex,nofollow
template: error
routable: false
http_response_code: 404
twig_first: true
process:
  twig: true
expires: 0',
        'markdown' => '{{ \'PLUGIN_ERROR.ERROR_MESSAGE\'|t }}

'
    ]
];
