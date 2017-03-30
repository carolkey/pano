<?php
return [
    'default' => [
        'module' => 'index',
        'controller' => 'index',
        'action' => 'index',
        'suffix' => '.html',
        'pathinfo' => false,
        'rule' => [
            ':id' => ['index/index/index'],
        ],
    ],
    'pano.com' => [
        'module' => 'admin',
        'controller' => 'index',
        'action' => 'index',
        'suffix' => '',
        'pathinfo' => false,
        'rule' => [],
    ],
];
