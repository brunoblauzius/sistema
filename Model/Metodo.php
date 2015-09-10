<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Metodo
 *
 * @author bruno.blauzius
 */
class Metodo extends AppModel {
    //put your code here
    
    public $useTable = 'methods';
    
    public $name = 'Metodo';
    
    public $primaryKey = 'id';
    
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
//            'existsNome' => array(
//                'rule' => array('existsNome'),
//                'mensagem' => 'Este nome já foi cadastrado!'
//            ),
        ),
        'descricao' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
        'controllers_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
    );
    
    
    public $validate_edit = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
        'descricao' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
        'controllers_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
    );
    
    public function existsNome( $valor ){
       $registro = $this->find('first', array('nome' => $valor), NULL, array(0,1));
       return ( count($registro) > 0 );
    }
    
    public function findAll( $controllersId ){
        
        $sql = "SELECT nome FROM {$this->useTable} WHERE controllers_id = {$controllersId};";
        return $this->query($sql);
        
    }
    
}
