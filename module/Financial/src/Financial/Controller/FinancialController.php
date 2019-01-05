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
                $to = $form->get('reportfieldset')->get('dateTo')->getValue();
                $from = $form->get('reportfieldset')->get('dateFrom')->getValue();
                $taxYear = $form->get('reportfieldset')->get('taxYear')->getValue();
                if ($taxYear > 0) {
                    $where = [
                        't.tax_year = ?' => [
                            $taxYear
                        ]
                    ];
                }
                else {
                    $where = [
                        't.date_filed BETWEEN ? AND ? OR ? BETWEEN t.date_from AND t.date_to OR ? BETWEEN t.date_from AND t.date_to' => [
                            $from, $to, $from, $to
                        ]
                    ];
                }
                $return = array(
                    'expenses' => $this->service->getExpenses($where),
                    'incomes' => $this->service->getIncomes($where),
                    'from' => $from,
                    'to' => $to
                );
            }
        } $return['form'] = $form;

        return new ViewModel($return);
    }
}
