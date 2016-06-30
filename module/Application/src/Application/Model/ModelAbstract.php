<?php namespace Application\Model;

use Application\Hydrator\StandardHydrator;
use \stdClass;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Hydrator\HydratorInterface;


abstract class ModelAbstract implements AdapterAwareInterface{
	/**
	 * @var bool
	 */
	protected $debugMode;
	
	/**
     * @var Adapter
     */
    private $dbAdapter;

	/**
	 * @var HydratorInterface
	 */
	private $hydrator;

	/**
	 * @var Select
	 */
	private $openSelect;

    /**
     * @var string
     */
    private $entityClass;

	/**
	 * The mode this model is in will determine if it is a list or individual item
	 * @var int|null
	 */
	protected $_mode;
	/**
	 * Stores the data
	 *
	 * @var Array|null
	 */
	protected $_data;	
	/**
	 * Name of the database table
	 * @var string|null
	 */
	protected $_tableName;
	/**
	 * The primary key field
	 * @var mixed|null
	 */
	protected $_pk;
	/**
	 * Array of table columns by table
	 * @var array|null
	 */
	protected $tableColumns;
	/**
	 * All fields of this model from both primary table and join
	 * @var array
	 */
	protected $_fields = array();
	/**
	 * The last field that we added, so that we have context for any follow up calls to act on that field
	 * @var null
	 */
	protected $_lastField;
	/**
	 * The information for tables that will be joined
	 * @var array
	 */
	protected $_joinTables = array();
	/**
	 * The last join that we added, so that we have context for any follow up calls to act on that join table
	 * @var null
	 */
	protected $_lastJoin;
	/**
	 * The column prefix for the last join we added
	 * @var null
	 */
	protected $_lastJoinPrefix;
	/**
	 * Current default settings that we'll apply to new fields or join tables that we add
	 * @var array|null
	 */
	protected $_defaults;
	/**
	 * Generic type that will apply to no modes
	 */
	const MODE_NONE 			= 0;
	/**
	 * We are opening an existing item from database
	 */
	const MODE_EXISTING_ITEM 	= 10;
	/**
	 * We are creating a new item yet to be inserted into the database
	 */
	const MODE_NEW_ITEM 		= 20;
	/**
	 * Unique key, but not autoincrement
	 */
	const MODE_REPLACE_INTO		= 29;
	/**
	 * Generic single item type
	 */
	const MODE_ITEM 			= 30;
	/**
	 * We are fetching a list of items
	 */
	const MODE_LIST_QUERY		= 60;
	/**
	 * We are defining an item implicitly, but it is not actually in the database and will not be fetched or saved
	 */
	const MODE_ITEM_ADHOC		= 61;
	/**
	 * Generic type that will apply to any mode
	 */
	const MODE_ALL 				= 100;

	function __construct(){
		// Any top level initialization
		$this->_defaults = array(
			'visibility' => static::MODE_ALL
		);
	}

	public function debug($debug = true) {
		$this->debugMode = $debug;
		return $this;
	}
	
	/**
     * Set db adapter
     *
     * @param Adapter $adapter
     * @return AdapterAwareInterface
     */
    public function setDbAdapter(Adapter $adapter) {
    	$this->dbAdapter = $adapter;
	}

    private function getHydrator() {
        if (!$this->hydrator) {
            $hydratorClass = '\\'.str_replace('\\Model\\', '\\Hydrator\\', get_called_class()).'Hydrator';
            if (class_exists($hydratorClass)) {
                $this->hydrator = new $hydratorClass();
            }
            else {
                $this->hydrator = new StandardHydrator($this->getEntity(true));
            }
        }
        return $this->hydrator;
    }
    
    private function getEntity($returnString = false) {
        if (!$this->entityClass) {
			$this->entityClass = '\\'.str_replace('\\Model\\', '\\Entity\\', get_called_class());
			if (!class_exists($this->entityClass)) {
				throw new \Exception('Class not found in ModelAbstract: '.$this->entityClass);
			}
		}
		if ($returnString) {
			return $this->entityClass;
		}
        return new $this->entityClass();
    }

	private function getResultArray(ResultInterface $result) {
		if ($result->isQueryResult()) {
			if ($result->count() > 1) {
				$data = array();
				foreach ($result as $row) {
					$data[] = $row;
				}
			}
			else {
				$data = $result->current();
			}
			return $data;
		}
		return null;
	}

	private function _getTableColumns($table=null) {
        if (empty($this->tableColumns[$table])) {
			if ($table == $this->_tableName)
				$table = null;
			else if ($table && !array_key_exists($table, $this->_joinTables)) {
				throw new \Exception('Table not found: ' . $table);
			}

			$columns = array();
			foreach ($this->_fields as $alias => $field) {
				if ($table == $field->joinTable && $field->visibility >= $this->_mode) {
					if ($alias != $field->databaseField) {
						$columns[$alias] = $field->databaseField;
					} else {
						$columns[] = $field->databaseField;
					}
				}
			}
			$this->tableColumns[$table ? $table : $this->_tableName] = $columns ? $columns : array();
		}
		return $this->tableColumns[$table ? $table : $this->_tableName];
	}

	private static function _getJoinCondition($join) {
		if (empty($join->condition)) {
			$fromAlias = empty($join->fromTable) ? 't' : $join->fromTable;
			$join->condition = $fromAlias . '.' . $join->fromField . ' = ' . 
				$join->asTable . '.' . $join->toField;
		}
		return $join->condition;
	}

	/**
	 * Build the sql to select an item
	 *
	 * @param mixed $a primary key value or key to open by
	 * @param mixed $b value to open by if $a is a key
     * @param int $limit
	 * @return Select
	 */
	private function getOpenSelect($a = null, $b = null, $limit = 1) {
		$value = ($b) ? $b : $a;
		$key = ($b) ? $a : $this->_pk;

		if (!$select = $this->openSelect) {
			$this->_init();
			
			if (!$key) {
				$key = $this->_pk;
			}

			$select = new Select(array('t' => $this->_tableName));
			$select->columns($this->_getTableColumns());
			foreach ($this->_joinTables as $alias => $join) {
				if ($join->visibility >= $this->_mode) {
					$table = $alias != $join->tableName
						? array($alias => $join->tableName) : $join->tableName;
					$select->join($table, static::_getJoinCondition($join), $this->_getTableColumns($alias), $join->joinType);
				}
			}
			$this->openSelect = $select;
		}
		
        if ($key && $value) {
            return $select->where(
                    array('t.' . $this->_fields[$key]->databaseField . ' = ?' => $value))
                ->limit($limit);
        }

        return $select;
	}

	protected function execute($select) {
		$sql = new Sql($this->dbAdapter);
		$statement = $sql->prepareStatementForSqlObject($select);
		//die(var_dump($sql->buildSqlString($select)));
		try {
			$result = $statement->execute();
		}
		catch (\Exception $e) {
			throw new \Exception($e->getMessage().' SQL statement: '.$sql->buildSqlString($select));
		}
		return $result;
	}
    
    /**
	 * Open an existing item
	 *
	 * This can be over-loaded. In its simplest form you just pass the id of the primary key as the first argument
	 * and that's it. If you pass at least two variables it will be field and value, so that you can open by
	 * a field that is not the primary key.
	 *
	 * @param mixed $a primary key value or key to open by
	 * @param mixed $b value to open by if $a is a key
     * @param int $limit
	 *
	 * @throws \Exception if query has errors
	 * @return ModelAbstract
	 */
	public function open($a, $b=null, $limit=1) {
		// Instantiate the model
		$this->_mode = static::MODE_EXISTING_ITEM;
		$this->_beforeOpen();

		$select = $this->getOpenSelect($a, $b, $limit);
		$result = $this->execute($select);
		if ($this->_data = $this->getResultArray($result)) {
			//die(var_dump($this->_data));
			$this->_afterOpen();
		}
		else {
			return null;
		}
        //die(var_dump($this->getHydrator()->hydrate($this->_data, $this->getEntity())));
		return $this->getHydrator()->hydrate($this->_data, $this->getEntity());
	}

    /**
     * Get a list of existing items
     *
     * @param mixed $where 
     *
     * @throws \Exception if query has errors
     * @return ModelAbstract
     */
    public function listQuery($where = false) {
		// Instantiate the model
        $this->_mode = static::MODE_LIST_QUERY;
        $this->_beforeListQuery();


        $select = $this->getOpenSelect();
        if ($where) {
            $select->where($where);
        }
        $select->limit(1000);
        
        $result = $this->execute($select);
       	if ($data = $this->getResultArray($result)) {
			//die(var_dump($data));
			$this->_afterListQuery();
        }
		else {
			return array();
		}
		if ($this->debugMode) {
			die(var_dump($this->getHydrator(), $this->getEntity()));
		}
		$list = $this->getHydrator()->hydrate($data, $this->getEntity());
		return is_array($list) ? $list : array($list);
    }

    public function save($entity) {
        $this->_beforeSave();
        $data = $this->getHydrator()->extract($entity);
        die(var_dump($data, 'ModelAbstract save'));
        $this->_afterSave();
    }

	/**
	 * Set the name of the table or get the name of the table (over-loaded)
	 *
	 * @param string|null $name
	 * @return $this|string
	 */
	protected function tableName($name=null) {
		if ($name) {
			$this->_tableName = $name;
			return $this;
		}
		else {
			return $this->_tableName;
		}
	}

	/**
	 * Set the primary key
	 *
	 * @param string|null $friendlyName
	 * @return $this
	 */
	protected function primaryKey($friendlyName=null) {
		// If it was not passed in, then use the last field we added
		if (!$friendlyName) {
			$friendlyName = $this->_lastField;
		}
		$this->_pk = $friendlyName;
		$this->_fields[$friendlyName]->pk = true;
		$this->_fields[$friendlyName]->unique = true;
		return $this;
	}

	/**
	 * Add a column name prefix to join table columns
	 *
	 * @param string|null $prefix
	 * @return $this
	 */
	protected function prefix($prefix=null) {
		// If it was not passed in, then use the last join table name
		$this->_lastJoinPrefix = $prefix ? $prefix : $this->_lastJoin.'_';
		return $this;
	}

	/**
	 * Add a join table
	 *
	 * @param string $tableName
	 * @param string|null $asTable
	 * @param string $joinType Default is LEFT OUTER
	 * @return $this
	 */
	protected function join($tableName, $asTable=null, $joinType='left') {
		
		$this->resetVisibility();
		
		// If no asTable was specified, use the tableName
		if (!$asTable) {
			$asTable = $tableName;
		}
		// Join object
		$joinTable = new stdClass();
		$joinTable->tableName = $tableName;
		$joinTable->asTable = $asTable;
		$joinTable->visibility = $this->_defaults['visibility'];
		$joinTable->joinType = $joinType;
		$this->_joinTables[$asTable] = $joinTable;
		$this->_lastJoin = $asTable;
		$this->_lastField = null;
		$this->_lastJoinPrefix = null;
		return $this;
	}

	/**
	 * Adds the on clause for the last join table added
	 *
	 * @return $this
	 */
	protected function on() {
		$fromTable = null;
		$fromField = null;
		$toField = null;
		// If we're in the context of a join
		if ($this->_lastJoin) {
			// Handle overloading
			$args = func_get_args();
			if (count($args) == 2) {
				$fromField = $args[0];
				$toField = $args[1];
			}
			else if (count($args) > 2) {
				$fromTable = $args[0];
				$fromField = $args[1];
				$toField = $args[2];
			}
			else if (count($args) == 1) {
				$fromField = $args[0];
				$toField = 'id';
			}
			// Set these fields
			if ($fromField && $toField) {
				$this->_joinTables[$this->_lastJoin]->fromField = $fromField;
				$this->_joinTables[$this->_lastJoin]->toField = $toField;
				$this->_joinTables[$this->_lastJoin]->fromTable = $fromTable;
			}
		}
		return $this;
	}

	/**
	 * Add a string field
	 *
	 * @param string $databaseField
	 * @param string|null $friendlyName
	 * @return $this
	 */
	protected function string($databaseField, $friendlyName=null) {
		return $this->field('string', $databaseField, $friendlyName);
	}

	/**
	 * Add a json field
	 *
	 * @param string $databaseField
	 * @param string|null $friendlyName
	 * @return $this
	 */
	protected function json($databaseField, $friendlyName=null) {
		return $this->field('json', $databaseField, $friendlyName);
	}

	/**
	 * Add a numeric field
	 *
	 * @param string|$databaseField
	 * @param string|null $friendlyName
	 * @return $this
	 */
	protected function number($databaseField, $friendlyName=null) {
		return $this->field('number', $databaseField, $friendlyName);
	}

	/**
	 * Add a boolean field
	 *
	 * @param string $databaseField
	 * @param string|null $friendlyName
	 * @return $this
	 */
	protected function boolean($databaseField, $friendlyName=null) {
		return $this->field('boolean', $databaseField, $friendlyName);
	}

	/**
	 * Add a field and specify the type
	 *
	 * @param $type
	 * @param $databaseField
	 * @param null $friendlyName
	 * @return $this
	 */
	private function field($type, $databaseField, $friendlyName=null) {
		// If no friendly name provided, just convert databaseField to camelcase
		$friendlyName = $this->_lastJoinPrefix.($friendlyName ? $friendlyName : $databaseField);

		$field = new stdClass;
		$field->friendlyName = $this->underscoreToCamelcase($friendlyName);
		$field->databaseField = $databaseField;
		$field->type = $type;
		$field->visibility = $this->_defaults['visibility'];
		$field->joinTable = $this->_lastJoin;
		$this->_fields[$field->friendlyName] = $field;
		$this->_lastField = $field->friendlyName;
		return $this;
	}

	/**
	 * Set the visibility of the last join or field
	 * 
	 * @param $visibility
	 * @return $this
     */
	protected function visibility($visibility) {
		if ($this->_lastField) {
			$this->_fields[$this->_lastField]->visibility = $visibility;	
		}
		else if ($this->_lastJoin) {
			$this->_joinTables[$this->_lastJoin]->visibility = $visibility;	
		}
		return $this;
	}

	/**
	 * Sets the default visibility for following fields
	 * 
	 * @param $visibility
	 * @return $this
     */
	protected function setVisibility($visibility) {
		$this->_defaults['visibility'] = $visibility;
		return $this;
	}

	/**
	 * Resets the default visibility
	 *
	 * @return $this
	 */
	protected function resetVisibility() {
		$this->_defaults['visibility'] = static::MODE_ALL;
		return $this;
	}

	/**
	 * Take a field name that has underscores in it and make it into camel-case
	 *
	 * @param string $str
	 * @return string
	 */
	protected function underscoreToCamelcase($str) {
		if (is_string($str)) {
			$str = str_replace('_', ' ', $str);
			$str = ucwords($str);
			$str = strtolower(substr($str, 0, 1)) . substr($str, 1);
			$str = preg_replace_callback('/([A-Z])([A-Z]+)/', function($m){
					return $m[1] . strtolower($m[2]);
				}, $str);
			return str_replace(' ', '', $str);
		} else {
			return '';
		}
	}

	/**
	 * Initialize model, where the table structure will be added and other rules
	 */
	protected function _init() {}
	/**
	 * Called after item is opened
	 */
	protected function _afterOpen() {}
	/**
	 * Called after item is opened
	 */
	protected function _beforeOpen() {}
	/**
	 * Called after item is created
	 */
	protected function _afterCreate() {}
	/**
	 * Called before item is created
	 */
	protected function _beforeCreate() {}
	/**
	 * Called after list is fetched
	 */
	protected function _afterListQuery() {}
	/**
	 * Called before list is fetched
	 */
	protected function _beforeListQuery() {}
	/**
	 * Called after any fetch
	 */
	protected function _afterFetch() {}
	/**
	 * Called right before it is being fetched
	 */
	protected function _onFetch() {}
	/**
	 * Called before any fetch
	 */
	protected function _beforeFetch() {}
	/**
	 * Called after any item (existing or new) is saved
	 */
	protected function _afterSave() {}
	/**
	 * Called before any item (existing or new) is saved
	 */
	protected function _beforeSave() {}
	/**
	 * Called after any property is set
	 */
	protected function _afterSet() {}
	/**
	 * Called before any property is set
	 */
	protected function _beforeSet() {}
	/**
	 * Called after any property is retrieved
	 */
	protected function _afterGet() {}
	/**
	 * Called before any property is retrieved
	 */
	protected function _beforeGet() {}
}