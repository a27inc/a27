<?php return [
    'zfc_rbac' => [
        /**
         * Key that is used to fetch the identity provider
         *
         * Please note that when an identity is found, it MUST implements the ZfcRbac\Identity\IdentityProviderInterface
         * interface, otherwise it will throw an exception.
         */
        // 'identity_provider' => 'ZfcRbac\Identity\AuthenticationIdentityProvider',

        'guest_role' => 'guest',

        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'property*' => ['agent', 'agent_admin'],
                'tenant*'   => ['landlord'],
                'financial*'    => ['account', 'investor'],
                'permission*'   => ['super_admin'],
                'role*'     => ['super_admin'],
                'site-user/profile'    => ['*'],
                'site-user*'    => ['super_admin']
            ],
            'ZfcRbac\Guard\RoutePermissionsGuard' => [
                //'tenant/*' => ['tenant_add', 'tenant_edit', 'tenant_delete'],
            ],
            'ZfcRbac\Guard\ControllerGuard' => [
                /*[
                    'controller' => 'DeleteController',
                    //'actions'    => ['read', 'edit'],
                    'roles'      => ['admin']
                ],*/
            ],
            'ZfcRbac\Guard\ControllerPermissionsGuard' => [
                /*[
                    'controller'  => 'MyController',
                    'permissions' => ['post.update', 'post.delete']
                ]*/
            ]
        ],
        'assertion_map' => [
            'edit_expense' => 'Auth\Assertion\OwnerOrAdmin',
            'delete_expense' => 'Auth\Assertion\OwnerOrAdmin',
            'edit_income' => 'Auth\Assertion\OwnerOrAdmin',
            'delete_income' => 'Auth\Assertion\OwnerOrAdmin',
            'edit_tenant' => 'Auth\Assertion\OwnerOrAdmin',
            'delete_tenant' => 'Auth\Assertion\OwnerOrAdmin'
        ],

        /**
         * As soon as one rule for either route or controller is specified, a guard will be automatically
         * created and will start to hook into the MVC loop.
         *
         * If the protection policy is set to DENY, then any route/controller will be denied by
         * default UNLESS it is explicitly added as a rule. On the other hand, if it is set to ALLOW, then
         * not specified route/controller will be implicitly approved.
         *
         * DENY is the most secure way, but it is more work for the developer
         */
        // 'protection_policy' => \ZfcRbac\Guard\GuardInterface::POLICY_ALLOW,

       'role_provider' => [
            'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
                'object_manager'     => 'doctrine.entitymanager.orm_default',
                'class_name'         => 'Auth\Entity\HierarchicalRole',
                'role_name_property' => 'name'
            ]
        ],
        'unauthorized_strategy' => [
            'template' => 'error/403'
        ],
        'redirect_strategy' => [
            'redirect_when_connected' => false,
            'redirect_to_route_connected' => 'zfcuser',
            'redirect_to_route_disconnected' => 'zfcuser/login',
            'append_previous_uri' => false,
            'previous_uri_query_key' => 'redirectTo'
        ],

        /**
         * Various plugin managers for guards and role providers. Each of them must follow a common
         * plugin manager config format, and can be used to create your custom objects
         */
        // 'guard_manager'               => [],
        // 'role_provider_manager'       => []
    ]
];
