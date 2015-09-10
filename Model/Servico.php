<?php

class Servico extends AppModel{
	
	public $useTable = 'servicos';
	
	public $name   = 'Servico';
	
	public $primaryKey = 'id';
	
	
	public $validate = array(
		'nome' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'mensagem' => 'Este campo é requirido',
			),
		),
	);
	

}