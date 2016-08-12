<?php 

return [
    'navigation' => [
        'admin' => [   
            'manage_user' => [
                'label' => 'Manage Users',
                'route' => 'site-user',
                'permission' => 'view_user',
                'order' => -90
            ],
            'manage_role' => [
                'label' => 'Manage Roles',
                'route' => 'role',
                'order' => -89
            ],
            'manage_permission' => [
                'label' => 'Manage Permissions',
                'route' => 'permission',
                'order' => -88
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'zfcuser' => __DIR__ . '/../view',
            'site-user' => __DIR__ . '/../view'
        ]
    ],
    'controllers' => [
        'invokables' => [
            'UserWriteController' => 'SiteUser\Controller\UserWriteController',
            'UserDeleteController' => 'SiteUser\Controller\UserDeleteController',
            'RoleController' => 'SiteUser\Controller\RoleController',
            'RoleWriteController' => 'SiteUser\Controller\RoleWriteController',
            'RoleDeleteController' => 'SiteUser\Controller\RoleDeleteController'
        ]
    ],
    'router' => [
        'routes' => [
            'site-user' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/site-user',
                    'defaults' => [
                        'controller' => 'SiteUser/UserController',
                        'action'     => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'UserWriteController',
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
                                'controller' => 'UserDeleteController',
                                'action' => 'delete'  
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]  
                        ]
                    ],
                    'profile' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/profile',
                            'defaults' => [
                                'controller' => 'SiteUser/UserController',
                                'action'    => 'profile'
                            ]
                        ]
                    ]
                ]
            ],
            'role' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/role',
                    'defaults' => [
                        'controller' => 'RoleController',
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
                                'controller' => 'RoleWriteController',
                                'action' => 'addRole'  
                            ] 
                        ]
                    ],
                    'view' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/view/[:id]',
                            'defaults' => [
                                'controller' => 'RoleController',
                                'action' => 'viewRole'
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'RoleWriteController',
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
                                'controller' => 'RoleDeleteController',
                                'action' => 'delete'  
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*'
                            ]  
                        ]
                    ]
                ]
            ],
            'permission' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/permission',
                    'defaults' => [
                        'controller' => 'RoleController',
                        'action'     => 'viewPermission'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'add' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => 'RoleWriteController',
                                'action' => 'addPermission'  
                            ] 
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '/edit/[:id]',
                            'defaults' => [
                                'controller' => 'RoleWriteController',
                                'action' => 'editPermission'  
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
                                'controller' => 'RoleDeleteController',
                                'action' => 'deletePermission'  
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