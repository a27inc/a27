<?php

return [
    'navigation' => [
        'account' => [
            'financial' => [
                'label' => 'View Financials',
                'route' => 'financial',
                'order' => -95
            ],
	        'expense' => [
                'label' => 'Manage Expenses',
                'route' => 'financial/expense',
                'order' => -85
            ],
            'income' => [
                'label' => 'Manage Incomes',
                'route' => 'financial/income',
                'order' => -80
            ],
            'category' => [
                'label' => 'Manage Financial Categories',
                'route' => 'financial/category',
                'order' => -75
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'financial' => __DIR__ . '/../view',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Financial\FinancialController' => 'Financial\Controller\FinancialController',
            'Financial\WriteController' => 'Financial\Controller\WriteController',
            'Financial\DeleteController' => 'Financial\Controller\DeleteController'
        ],
    ],
    'router' => [
        'routes' => [
            'financial' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/financial',
                    'defaults' => [
                        'controller' => 'Financial\FinancialController',
                        'action'     => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'report' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/report',
                             'defaults' => [
                                'controller' => 'Financial\FinancialController',
                                'action' => 'report'
                            ]
                        ]
                    ],
                    'expense' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/expense',
                             'defaults' => [
                                'controller' => 'Financial\FinancialController',
                                'action' => 'expense'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/add',
                                     'defaults' => [
                                        'controller' => 'Financial\WriteController',
                                        'action' => 'add-expense'
                                    ]
                                ]
                            ],
                            'edit' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/edit/[:id]',
                                     'defaults' => [
                                        'controller' => 'Financial\WriteController',
                                        'action' => 'edit-expense'
                                    ],
                                    'constraints' => [
                                        'id' => '[1-9]\d*'
                                    ]  
                                ]
                            ],
                            'delete' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/delete/[:id]',
                                     'defaults' => [
                                        'controller' => 'Financial\DeleteController',
                                        'action' => 'delete-expense'
                                    ],
                                    'constraints' => [
                                        'id' => '[1-9]\d*'
                                    ]  
                                ]
                            ]
                        ]
                    ],
                    'income' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/income',
                             'defaults' => [
                                'controller' => 'Financial\FinancialController',
                                'action' => 'income'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/add',
                                     'defaults' => [
                                        'controller' => 'Financial\WriteController',
                                        'action' => 'add-income'
                                    ]
                                ]
                            ],
                            'edit' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/edit/[:id]',
                                     'defaults' => [
                                        'controller' => 'Financial\WriteController',
                                        'action' => 'edit-income'
                                    ],
                                    'constraints' => [
                                        'id' => '[1-9]\d*'
                                    ]  
                                ]
                            ],
                            'delete' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/delete/[:id]',
                                     'defaults' => [
                                        'controller' => 'Financial\DeleteController',
                                        'action' => 'delete-income'
                                    ],
                                    'constraints' => [
                                        'id' => '[1-9]\d*'
                                    ]  
                                ]
                            ]
                        ]
                    ],
                    'category' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/category',
                             'defaults' => [
                                'controller' => 'Financial\FinancialController',
                                'action' => 'category'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/add',
                                     'defaults' => [
                                        'controller' => 'Financial\WriteController',
                                        'action' => 'add-category'
                                    ]
                                ]
                            ],
                            'edit' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/edit/[:id]',
                                     'defaults' => [
                                        'controller' => 'Financial\WriteController',
                                        'action' => 'edit-category'
                                    ],
                                    'constraints' => [
                                        'id' => '[1-9]\d*'
                                    ]  
                                ]
                            ],
                            'delete' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/delete/[:id]',
                                     'defaults' => [
                                        'controller' => 'Financial\DeleteController',
                                        'action' => 'delete-category'
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