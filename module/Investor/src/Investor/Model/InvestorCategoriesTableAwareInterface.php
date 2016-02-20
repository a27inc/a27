<?php namespace Investor\Model;

interface InvestorCategoriesTableAwareInterface{
    public function setCategoriesTable(CategoriesTable $cs);
}