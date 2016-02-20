<?php namespace Investor\Service;

interface InvestorServiceAwareInterface{
    public function setInvestorService(InvestorService $s);
}