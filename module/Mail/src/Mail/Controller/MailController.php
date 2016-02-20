<?php
namespace Mail\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class MailController extends AbstractActionController{
	public function indexAction(){
        $transport = new SmtpTransport();
        $config = $this->getServiceLocator()->get('config');
        //var_dump($config['smtp']);
        $options = new SmtpOptions($config['smtp']);
        $transport->setOptions($options);

        var_dump($transport);

        return new ViewModel(array());
	}
}