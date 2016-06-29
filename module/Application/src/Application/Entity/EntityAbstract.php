<?php namespace Application\Entity;

//use Zend\Hydrator\Filter\FilterProviderInterface;
//use Zend\Hydrator\Filter\FilterComposite;
//use Zend\Hydrator\Filter\GetFilter;
//use Zend\Hydrator\Filter\NumberOfParameterFilter;
//use Zend\Hydrator\Filter\MethodMatchFilter;

abstract class EntityAbstract{ //implements FilterProviderInterface{
    
    //protected $filters;
    
    /*public function __construct() {
        $this->filters = array(
            'excludes' => $this->_getExcludeFilter()
        );
    }

    public function getFilter() {
        $filter = new FilterComposite();
        $filter->addFilter('get', new GetFilter());
        
        foreach ($this->filters as $name => $filter) {
            $filter->addFilter($name, $filter, FilterComposite::CONDITION_AND);
        }
        
        return $filter;
    }
    
    protected function _getExcludeFilter() {
        $exclude = new FilterComposite();
        $exclude->addFilter('parameter', new NumberOfParameterFilter(), FilterComposite::CONDITION_AND);
        return $exclude;  
    }
    
    protected function _addExcludeFilter($name, $filter) {
        if (isset($this->filters['excludes'])) {
            $this->filters['excludes']->addFilter($name, $filter, FilterComposite::CONDITION_AND);   
        }       
    }*/
}