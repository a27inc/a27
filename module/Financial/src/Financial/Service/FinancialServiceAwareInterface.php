<?php namespace Financial\Service;

interface FinancialServiceAwareInterface{
    public function setFinancialService(FinancialService $fs);
}