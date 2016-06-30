<?php

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'terms-of-service' => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => 'terms-of-service',
                             'defaults' => [
                                'controller' => 'Application\Controller\TermsOfService',
                                'action'     => 'index'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'admin_nav' => 'Application\Navigation\Factory\AdminNavigationFactory',
            'account_nav' => 'Application\Navigation\Factory\AccountNavigationFactory',
            'investor_nav' => 'Application\Navigation\Factory\InvestorNavigationFactory',
            'landlord_nav' => 'Application\Navigation\Factory\LandlordNavigationFactory',
            //'demo_nav' => 'Application\Navigation\Factory\DemoNavigationFactory'
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\TermsOfService' => 'Application\Controller\TermsOfServiceController'
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            'application' => __DIR__ . '/../view',
        ],
    ],

    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],
];