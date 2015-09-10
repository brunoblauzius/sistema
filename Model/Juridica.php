<?php 

class Juridica extends AppModel {


	public $useTable = 'pessoaJuridica';

	public $name = 'Juridica';

	public $primaryKey = 'id';


	public $validate = array(
            'nome' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'mensagem' => 'Este campo é requirido',
                ),
            ),
            'email' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'mensagem' => 'Este campo é requirido',
                ),
                'email' => array(
                    'rule' => array('email'),
                    'mensagem' => 'Favor inserir um email válido',
                ),
            ),
            'assunto' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'mensagem' => 'Este campo é requirido',
                ),
            ),
            'mensagem' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'mensagem' => 'Este campo é requirido',
                ),
            ),
            'code' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'mensagem' => 'Este campo é requirido'
                ),
                'validaCaptcha' => array(
                    'rule' => array('validaCaptcha'),
                    'mensagem' => 'captcha está incorreto!'
                ),
            ),
	);

}