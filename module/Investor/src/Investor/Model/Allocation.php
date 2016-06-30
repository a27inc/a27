<?php namespace Investor\Model;

use Application\Model\ModelAbstract;

class Allocation extends ModelAbstract{

	protected function _init(){
		$this->tableName('investor_allocations')
			->number('id')->primaryKey()
			->number('allocation')
			->string('note');

		$this->join('user')
			->on('user_id')
			->prefix()
			->number('id')
			->string('displayName')
			->string('email');

		$this->join('allocation_categories')
			->on('category_id')
			->prefix()
			->number('id')
			->string('name')
			->string('display_name')
			->string('symbol')
			->string('description')
			->string('note');

		$this->join('properties')
			->on('property_id')
			->prefix()
			->number('id')
			->string('name');

	}
}