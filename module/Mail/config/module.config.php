<?php
return [
	'router' => [
        'routes' => [
            'mail' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/mail',
                    'defaults' => [
                        'controller' => 'Mail\Controller\Mail',
                        'action'     => 'index',
                    ],
                ],
            ],
         ],
     ],
    'controllers' => [
        'invokables' => [
            'Mail\Controller\Mail' => 'Mail\Controller\MailController',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'mail' => __DIR__ . '/../view',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],
];