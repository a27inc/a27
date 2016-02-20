<?php namespace Financial\Controller;

use Financial\Service\FinancialServiceAwareInterface;
use Financial\Service\FinancialService;
use Financial\Form\ReportForm;
use Financial\Form\CategoryForm;
use Financial\Form\ExpenseForm;
use Financial\Form\IncomeForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FinancialController extends AbstractActionController implements FinancialServiceAwareInterface{
    protected $service;
    protected $view;

    public function __construct(){
        $this->view    = new ViewModel();
    }

    public function setFinancialService(FinancialService $fs){
        $this->service = $fs;
    }

	public function indexAction(){
        if(!$this->isGranted('financial_summary'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'summary' => $this->service->getFinancialSummary()
            //'expenses' => $this->service->getExpenses(),
            //'incomes' => $this->service->getIncomes()
        ));
	}

    public function categoryAction(){
        if(!$this->isGranted('view_financial_category'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'categories' => $this->service->getCategories(),
        ));
    }

    public function expenseAction(){
        if(!$this->isGranted('view_expense'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'expenses' => $this->service->getExpenses(),
        ));
    }

    public function incomeAction(){
        if(!$this->isGranted('view_income'))
            return $this->view->setTemplate('error/403');

        return new ViewModel(array(
            'incomes' => $this->service->getIncomes()
        ));
    }

    public function reportAction(){
        if(!$this->isGranted('financial_report'))
            return $this->view->setTemplate('error/403');

        $form = new ReportForm();

        $request = $this->getRequest();
        $return = array('incomes' => array(), 'expenses' => array());
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $data = $form->getData();
                $to = $data['report']['date_to'];
                $from = $data['report']['date_from'];
                $exp_where = 'e.date_filed BETWEEN ? AND ? OR ? BETWEEN e.date_from AND e.date_to OR ? BETWEEN e.date_from AND e.date_to';
                $inc_where = 'i.date_filed BETWEEN ? AND ? OR ? BETWEEN i.date_from AND i.date_to OR ? BETWEEN i.date_from AND i.date_to';
                $return = array(
                    'expenses' => $this->service->getExpenses(array(
                        $exp_where => array($from, $to, $from, $to))),
                    'incomes' => $this->service->getIncomes(array(
                        $inc_where => array($from, $to, $from, $to))),
                    'from' => $from,
                    'to' => $to
                );
            }
        } $return['form'] = $form;

        return new ViewModel($return);
    }
}
