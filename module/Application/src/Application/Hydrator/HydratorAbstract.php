<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/9/2016
 * Time: 8:29 AM
 */

namespace Application\Hydrator;

use Zend\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;
use Zend\Hydrator\ObjectProperty;

abstract class HydratorAbstract extends ObjectProperty{

    protected $entity;
    protected $entityPrototype;
    protected $entityPK = 'id';
    protected $entitySetters = array();
    protected $entityTableMap = array();
    protected $entitySetterMap = array();
    protected $entityHydrators = array();

    protected $data = array();

    /**
     * Returns false if all values are empty
     *
     * @param array $data
     * @return mixed
     */
    private function getData($data) {
        if (is_array($data)) {
            $check = array_values(array_unique($data));
            foreach ($check as $value) {
                if (!empty($value)) {
                    return $data;
                }
            }
        }
        return false;
    }

    /**
     * Initializes Table entities data by row and their hydrators
     *
     * @param $data
     */
    private function setDataByTable($data) {
        $data = isset($data[0]) ? $data : array($data);
        $this->data['main'] = $data;
        foreach ($this->entityTableMap as $entity => $table) {

            // get the data keys specific to this table entity
            $entityKeys = preg_grep("/^$table/", array_keys($data[0]));

            // set this table entity hydrator to recognize join prefix
            $this->setTableHydrator($table, $entityKeys);

            $this->data[$table] = array();
            foreach ($data as $row => $rowData) {
                // add entity keys to its table data
                $this->data[$table][$row] = $this->getData(
                    array_intersect_key($rowData, array_flip($entityKeys)));
                // filter out these entity keys from the main table data
                $this->data['main'][$row] = array_diff_key($this->data['main'][$row], array_flip($entityKeys));
            }
        }
    }

    /**
     * Return a new instance of the main entity
     *
     * @param bool $force
     * @return mixed
     */
    private function getEntityInstance($force = false) {
        if (is_null($this->entity) || $force) {
            $this->entity = '\\'.substr(get_called_class(), 0, strripos(get_called_class(), 'hydrator'));
            $this->entity = str_replace('Hydrator', 'Entity', $this->entity);
        }
        return new $this->entity();
    }

    /**
     * Returns the method to hydrate the main entity with another
     *
     * @param string $entity the entity to be hydrated to the main entity
     * @return mixed
     */
    private function getEntitySetter($entity) {
        if (!isset($this->entitySetters[$entity])) {
            $parts = explode('\\', $entity);
            $name = $parts[count($parts) - 1];
            $prefix = isset($this->entitySetterMap[$name])
                ? $this->entitySetterMap[$name] : 'set';

            $this->entitySetters[$entity] = $prefix.$name;
        }
        return $this->entitySetters[$entity];
    }

    /**
     * Returns the method to hydrate the main entity with another
     *
     * @param string $table the entity table to be hydrated to the main entity
     * @return mixed
     */
    private function getEntitySetterFromTable($table) {
        return $this->getEntitySetter(array_search($table, $this->entityTableMap));
    }

    /**
     * Returns the entity associated to a table
     *
     * @param string $table
     * @return mixed
     */
    private function getEntityByTable($table) {
        if($class = array_search($table, $this->entityTableMap)) {
            return new $class();
        }
    }

    /**
     * Configures a table entity hydrator to recognize the fields it needs
     * This makes use of the table prefix set in the model
     *
     * @param $table
     * @param $entityKeys
     */
    private function setTableHydrator($table, $entityKeys) {
        if (!isset($this->entityHydrators[$table])) {
            $strategies = array();

            foreach ($entityKeys as $property) {
                $strategies[$property] = new MapNamingStrategy([$property => lcfirst(substr($property, strlen($table)))]);
            }

            $strategy = new CompositeNamingStrategy($strategies);
            $entityHydrator = new ObjectProperty();
            $entityHydrator->setNamingStrategy($strategy);

            $this->entityHydrators[$table] = $entityHydrator;
        }
    }

    /**
     * Returns the hydrator for a specific table
     *
     * @param $table
     * @return mixed
     */
    private function getTableHydrator($table) {
        return isset($this->entityHydrators[$table])
            ? $this->entityHydrators[$table] : false;
    }

    /**
     * Hydrates a table entity - a main entity sub entity
     *
     * @param $table
     * @param $data
     * @return null
     */
    private function hydrateByTable($table, $data) {
        if ($this->getTableHydrator($table)) {
            return $this->getTableHydrator($table)
                ->hydrate($data, $this->getEntityByTable($table));
        }
        return null;
    }

    /**
     * Place global hydrate code here
     */
    protected function _initHydrate() {
        $this->initHydrate();   
    }

    /**
     * Override this function
     */
    protected function initHydrate() {}
    
    public function hydrate(array $data, $object){
        $this->_initHydrate();
        $this->entityPrototype = $this->getEntityInstance();
        if ($object instanceof $this->entityPrototype) {
            //zf2 bug
            if (is_null($this->strategies)) {
                $this->strategies = array();
            }

            $entities = array();
            $this->setDataByTable($data);

            foreach ($this->data['main'] as $row => $mainData) {
                // instantiate and hydrate main entity if its not set
                $id = $mainData[$this->entityPK];
                if (!isset($entities[$id])) {
                    $entities[$id] = parent::hydrate($mainData, $this->getEntityInstance());
                }
                
                // hydrate in any sub entities
                foreach ($this->data as $table => $joinData) {
                    if ($table != 'main') {
                        $method = $this->getEntitySetterFromTable($table);
                        if (method_exists($entities[$id], $method) && $joinData[$row]) {
                            $entities[$id]->$method($this->hydrateByTable($table, $joinData[$row]));
                        }
                    }
                }
            }

            if (count($entities) == 1) {
                return array_shift($entities);
            }
            return $entities;
        }
        else {
            return parent::hydrate($data, $object);
        }
    }

    /**
     * Place global extract code here
     */
    protected function _initExtract() {
        $this->setNamingStrategy(new UnderscoreNamingStrategy());

        $this->initExtract();
    }

    /**
     * Override this function
     */
    protected function initExtract() {}

    public function extract($object){
        $this->_initExtract();

        return parent::extract($object);
    }
}