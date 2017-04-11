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
        'controller' => 'setting',
        'action' => 'index',
        'suffix' => '',
        'pathinfo' => false,
        'rule' => [
            'vtour/:uuid' => ['admin/vtour/index', 'uuid' => '/^[A-Za-z0-9]{16}$/'],
            'vtour/:xmluuid' => ['admin/vtour/xml', 'xmluuid' => '/^xml[A-Za-z0-9]{16}$/'],
        ],
    ],
];
