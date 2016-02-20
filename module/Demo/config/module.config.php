<?php return [
    'navigation' => [
        'demo' => [   
            'demo' => [
                'label' => 'Manage Persons',
                'route' => 'person',
                'order' => -95
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'demo' => __DIR__ . '/../view'
        ]
    ],
    'controllers' => [
        'invokables' => [
            'Demo\PersonController' => 'Demo\Controller\PersonController',
            'Demo\WriteController' => 'Demo\Controller\WriteController',
            'Demo\DeleteController' => 'Demo\Controller\DeleteController'
        ]
    ],
    'router' => [
        'routes' => [
            'person' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/person',
                    'defaults' => [
                        'controller' => 'Demo\PersonController',
                        'action'     => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'add' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => 'Demo\WriteController',
                                'action' => 'add'  
                            ] 
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'Demo\WriteController',
                                'action' => 'edit'  
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]  
                        ]
                    ],
                    'delete' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/delete/[:id]',
                            'defaults' => [
                                'controller' => 'Demo\DeleteController',
                                'action' => 'delete'  
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]  
                        ]
                    ]
                ]
            ]
        ]
     ]
];