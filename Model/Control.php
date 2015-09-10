<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Control
 *
 * @author bruno.blauzius
 */
class Control extends AppModel {
    //put your code here
    
    public $useTable = 'controllers';
    
    public $name = 'Control';
    
    public $primaryKey = 'id';
    
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'existsController' => array(
                'rule' => array('existsController'),
                'mensagem' => 'Controller já foi cadastrada!'
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
    );
    
    public function existsController( $valor ){
       $registro = $this->find('first', array('nome' => $valor), NULL, array(0,1));
       return ( count($registro) > 0 );
    }
    
    public function findName( $id ){
        $sql = " SELECT nome FROM {$this->useTable} WHERE id = {$id}; ";
        $retorno = $this->query($sql);
        return $retorno[0]['nome'];
    }
    
    
    public function findControllerMethods(){
        $sql = "SELECT 
                Metodos.id,
                Metodos.nome,
                Metodos.controllers_id,
                Controller.nome as  controllers_nome 
                FROM controllers AS Controller
                INNER JOIN methods AS Metodos ON Metodos.controllers_id = Controller.id
                ORDER BY Controller.nome ASC;";
        $retorno = $this->query($sql);
        $lista = array();
        if( !empty($retorno) ){
            foreach ($retorno as $registo) {
                $lista[] = new ControlMethodsEntity($registo['controllers_id'], $registo['controllers_nome'], $registo['id'], $registo['nome']);
            }
        }
            return $lista;
    }
    
}
