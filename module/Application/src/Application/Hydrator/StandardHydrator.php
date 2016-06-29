<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/9/2016
 * Time: 8:29 AM
 */

namespace Application\Hydrator;

class StandardHydrator extends HydratorAbstract{

    /**
     * StandardHydrator constructor.
     * 
     * @optional string $entityClass fully qualified class used for hydrate
     */
    public function __construct() {
        parent::__construct();
        // look for a class 
        if (func_num_args()) {
            $class = func_get_arg(0);
            if ($class && is_string($class)) {
                $this->entity = $class;
            }
        }
    }
}