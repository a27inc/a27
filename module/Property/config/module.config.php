<?php 

return [
    'navigation' => [
        'default' => [   
            'rent' => [
                'label' => 'For Rent',
                'route' => 'rent',
                'order' => -95
            ],
            'sale' => [
                'label' => 'For Sale',
                'route' => 'sell',
                'order' => -90
            ]
        ],
        'admin' => [   
            'property' => [
                'label' => 'Manage Properties',
                'route' => 'property',
                'order' => -95
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'sell' => __DIR__ . '/../view'
        ]
    ],
    'controllers' => [
        'invokables' => [
            'PropertySellController' => 'Property\Controller\SellController',
            'PropertyRentController' => 'Property\Controller\RentController',
            'PropertyWriteController' => 'Property\Controller\WriteController',
            'PropertyDeleteController' => 'Property\Controller\DeleteController',
            'PropertyController' => 'Property\Controller\PropertyController'
        ]
    ],
    'router' => [
        'routes' => [
            'property' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/property',
                    'defaults' => [
                        'controller' => 'PropertyController',
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
                                'controller' => 'PropertyWriteController',
                                'action' => 'add'  
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'PropertyWriteController',
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
                                'controller' => 'PropertyDeleteController',
                                'action' => 'delete'  
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]  
                        ]
                    ]
                ]
            ],
            'sell' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/for-sale',
                    'defaults' => [
                        'controller' => 'PropertySellController',
                        'action'     => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'details' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/[:address]/details_[:id]',
                            'defaults' => [
                                'action' => 'details'
                            ],
                            'constraints' => [
                                'address' => '(?!-|0)[-a-zA-Z0-9]+',
                                'id'     => '(?!0)[0-9]+'
                            ] 
                        ]
                    ]
                ]
            ],
            'rent' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/for-rent',
                    'defaults' => [
                        'controller' => 'PropertyRentController',
                        'action'     => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'details' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/[:address]/details_[:id]',
                            'defaults' => [
                                'action' => 'details'
                            ],
                            'constraints' => [
                                'address' => '(?!-|0)[-a-zA-Z0-9]+',
                                'id'     => '[1-9]\d*'
                            ] 
                        ]
                    ]
                ]
            ]
        ]
    ]
];