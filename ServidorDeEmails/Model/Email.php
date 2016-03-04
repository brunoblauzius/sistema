<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author BRUNO
 */
class Email extends AppModel{
    //put your code here
    
    public $name     = 'Email';
    public $useTable = null;
    public $primaryKey = null;
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'layout' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'assunto' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'destinatario' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'nome_destinatario' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'mensagem' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'empresa' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'cidade' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'uf' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'ddd' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
            'isNumeric' => array(
                'rule' => array('isNumeric'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'telefone' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
            'isNumeric' => array(
                'rule' => array('isNumeric'),
                'mensagem' => 'Digite apenas números.'
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => Enum::EMAIL_INVALIDO
            ),
        ),
    );
    
    public function gravar( array $post, $table = null ){
        unset($post['destinatario']);
        unset($post['assunto']);
        unset($post['nome_destinatario']);
        unset($post['layout']);
        
        /**
         * query de cadastro
         */
    }
    
}
