<?php 

return [
    'navigation' => [
        'admin' => [   
            /*'manage_investor' => [
                'label' => 'Manage Investors',
                'route' => 'investor',
                'order' => -90
            ],*/
            'manage_allocation' => [
                'label' => 'Manage Investor Allocations',
                'route' => 'investor/allocation',
                'order' => -90
            ],
            'manage_allocation_category' => [
                'label' => 'Manage Allocation Categories',
                'route' => 'investor/allocation/category',
                'order' => -90
            ]
        ],
        'investor' => [
            /*'view_profile' => [
                'label' => 'My Profile',
                'route' => 'investor/profile',
                'order' => -90
            ],*/
            'view_investment' => [
                'label' => 'My Investment',
                'route' => 'investor/investment',
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
            'WriteController' => 'Investor\Controller\WriteController',
            'DeleteController' => 'Investor\Controller\DeleteController'
        ]
    ],
    'router' => [
        'routes' => [
            'investor' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/investor',
                    'defaults' => [
                        'controller' => 'Investor/ViewController',
                        'action'     => 'viewInvestor'
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
                                'action' => 'addInvestor'  
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'WriteController',
                                'action' => 'editInvestor'  
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
                                'action' => 'deleteInvestor'  
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]  
                        ]
                    ],
                    'allocation' => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/allocation',
                            'defaults' => [
                                'controller' => 'Investor/ViewController',
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
                                        'controller' => 'Investor/ViewController',
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
                    ],
                    'investment' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => '/investment',
                            'defaults' => [
                                'controller' => 'Investor/ViewController',
                                'action'     => 'viewInvestment'
                            ]
                        ],
                    ],
                    'profile' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => '/profile',
                            'defaults' => [
                                'controller' => 'Investor/ViewController',
                                'action' => 'viewProfile'  
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'settings' => [
                                'type' => 'literal',
                                'options' => [
                                    'route'    => '/settings',
                                    'defaults' => [
                                        'controller' => 'WriteController',
                                        'action' => 'editSettings'  
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