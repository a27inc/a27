<?php 

return [
    'navigation' => [
        'admin' => [   
            'manage_allocation' => [
                'label' => 'Manage Investor Allocation',
                'route' => 'allocation',
                'order' => -90
            ],
            'manage_allocation_category' => [
                'label' => 'Manage Allocation Categories',
                'route' => 'allocation/category',
                'order' => -90
            ]
        ],
        'investor' => [
            'view_my_investment' => [
                'label' => 'My Investment',
                'route' => 'investment',
                'order' => -90
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'investor' => __DIR__ . '/../view'
        ]
    ],
    'controllers' => [
        'invokables' => [
            'ViewController' => 'Investor\Controller\ViewController',
            'WriteController' => 'Investor\Controller\WriteController',
            'DeleteController' => 'Investor\Controller\DeleteController'
        ]
    ],
    'router' => [
        'routes' => [
            'investment' => [
                'type' => 'literal',
                 'options' => [
                    'route'    => '/investment',
                    'defaults' => [
                        'controller' => 'ViewController',
                        'action'     => 'viewInvestment'
                    ]
                ],
            ],
            'allocation' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/allocation',
                    'defaults' => [
                        'controller' => 'ViewController',
                        'action'     => 'viewAllocation'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'add' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => 'WriteController',
                                'action' => 'addAllocation'  
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'WriteController',
                                'action' => 'editAllocation'  
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
                                'controller' => 'DeleteController',
                                'action' => 'deleteAllocation'  
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]  
                        ]
                    ],
                    'category' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => '/category',
                            'defaults' => [
                                'controller' => 'ViewController',
                                'action' => 'viewCategory'  
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'add' => [
                                'type' => 'literal',
                                'options' => [
                                    'route'    => '/add',
                                    'defaults' => [
                                        'controller' => 'WriteController',
                                        'action' => 'addCategory'  
                                    ]
                                ]
                            ],
                            'edit' => [
                                'type' => 'segment',
                                'options' => [
                                    'route'    => '/edit/[:id]',
                                    'defaults' => [
                                        'controller' => 'WriteController',
                                        'action' => 'editCategory'  
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
                                        'controller' => 'DeleteController',
                                        'action' => 'deleteCategory'  
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
        ]
    ]
];