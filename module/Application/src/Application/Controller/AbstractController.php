<?php namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

abstract class AbstractController extends AbstractActionController{
    protected $serviceLocator;
    protected $defaultService;
    protected $defaultForm;
    protected $formManager;
    protected $services = array();
    protected $forms = array();
    protected $view;

    public function __construct(ServiceLocatorInterface $sl){
        $this->serviceLocator = $sl;
        $this->view    = new ViewModel();
    }

    /**
     * @param string $service
     * @return mixed
     */
    protected function getService($service = null){
        if (is_null($service)) {
            $service = $this->defaultService;
        }
        if (!isset($this->services[$service])) {
            $this->services[$service] = $this->serviceLocator->has($service)
                ? $this->serviceLocator->get($service) : false;
        }
        return $this->services[$service];
    }

    /**
     * @param string $form
     * @return mixed
     */
    protected function getForm($form = null){
        if (is_null($form)) {
            $form = $this->defaultForm;
        }
        if (!isset($this->forms[$form])) {
            $this->forms[$form] = $this->getFormManager()->has($form)
                ? $this->getFormManager()->get($form) : false;
        }
        return $this->forms[$form];
    }

    private function getFormManager() {
        if (is_null($this->formManager)) {
            $this->formManager = $this->serviceLocator->get('FormElementManager');
        }
        return $this->formManager;
    }
}