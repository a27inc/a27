<?php namespace Investor\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class CategoriesTable extends AbstractTableGateway{
    protected $table = 'allocation_categories';

    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Category());
        $this->initialize();
    }

    public function fetchAll(){
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getCategory($id){
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row)
            throw new \Exception("Could not find row $id");
        return $row;
    }

    public function getOptions(){
        $categories = $this->fetchAll();
        $options = array();
        foreach($categories as $cat){
            $options[$cat->id] = $cat->display_name;
        } return $options;
    }

    public function saveCategory(Category $category){
        $data = array(
            'name'          => $category->name,
            'display_name'  => $category->display_name,
            'symbol'        => $category->symbol,
            'description'   => $category->description,
            'note'          => $category->note,
        );

        $id = (int) $category->getId();
        if($id == 0)
            $this->insert($data);
        else{
            if($this->getCategory($id))
                $this->update($data, array('id' => $id));
            else throw new \Exception('Category id does not exist!');
        }
    }

    public function deleteCategory($id){
        $this->delete(array('id' => (int) $id));
    }
}