<?php return [
    'doctrine' => [
        'driver' => [
            'auth_annotation_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__.'/../src/Auth/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Auth\Entity' => 'auth_annotation_driver'
                ]
            ]
        ]
    ]
];