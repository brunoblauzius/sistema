﻿<?php

class TiposPagamento extends AppModel{


	public $useTable = 'tipos_pagamentos';
	
	public $name     = 'TiposPagamento';
	
	public $primaryKey = 'id';

	
	public function seachIN( array $ids ){
		try{
			$sql = "SELECT 
						id, nome
					FROM
						{$this->useTable}
					WHERE
						id IN (".join(',', $ids ).");";
			return $this->query($sql);
		} catch (Exception $e){
			throw $e;
		}
	}
	
}