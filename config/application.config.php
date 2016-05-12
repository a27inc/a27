<?php global $env; 
if(!$env) $env = getenv('APPLICATION_ENV'); 
if(!$env) $env = 'production';
$cache = $env == 'production'; 
$configPaths = 'config/autoload/{,*.}{{,*.}global-'.$env.',{,*.}local-'.$env.',{,*.}global,{,*.}local}.php';

return array(
    'modules' => array(
        'ZendDeveloperTools',
        'ZFTool',
        'ZfcBase',
        'ZfcUser',
        'ZfcUserDoctrineORM',
        'ZfcRbac',
        'DoctrineModule',
        'DoctrineORMModule',
        'Auth',
        'Application',
        'TwbBundle',
    	'Financial',
        'Investor',
        'Landlord',
        'Demo',
        'Property',
        'SiteUser',
        'Mail',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => array($configPaths),

        // Whether or not to enable a configuration cache.
        // If enabled, the merged configuration will be cached and used in
        // subsequent requests.
        'config_cache_enabled' => $cache,

        // The key used to create the configuration cache file name.
        //'config_cache_key' => $stringKey,

        // Whether or not to enable a module class map cache.
        // If enabled, creates a module class map cache which will be used
        // by in future requests, to reduce the autoloading process.
        'module_map_cache_enabled' => $cache,

        // The key used to create the class map cache file name.
        //'module_map_cache_key' => $stringKey,

        // The path in which to cache merged configuration.
        'cache_dir' => 'data/cache/',

        // Whether or not to enable modules dependency checking.
        // Enabled by default, prevents usage of modules that depend on other modules
        // that weren't loaded.
        // 'check_dependencies' => true,
    ),

    // Used to create an own service manager. May contain one or more child arrays.
    //'service_listener_options' => array(
    //     array(
    //         'service_manager' => $stringServiceManagerName,
    //         'config_key'      => $stringConfigKey,
    //         'interface'       => $stringOptionalInterface,
    //         'method'          => $stringRequiredMethodName,
    //     ),
    // )

   // Initial configuration with which to seed the ServiceManager.
   // Should be compatible with Zend\ServiceManager\Config.
   //'service_manager' => array()
);
