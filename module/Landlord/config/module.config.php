<?php return [
    'navigation' => [
        'landlord' => [   
            'landlord' => [
                'label' => 'Manage Tenants',
                'route' => 'tenant',
                'order' => -95
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'landlord' => __DIR__ . '/../view'
        ]
    ],
    'controllers' => [
    ],
    'router' => [
        'routes' => [
            'tenant' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/tenant',
                    'defaults' => [
                        'controller' => 'Landlord/TenantController',
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
                                'controller' => 'Landlord/WriteController',
                                'action' => 'add'  
                            ] 
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'Landlord/WriteController',
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
                                'controller' => 'Landlord/DeleteController',
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