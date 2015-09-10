<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grupo
 *
 * @author bruno.blauzius
 */
class Grupo extends AppModel{
    //put your code here
    
    public $useTable = 'roles';
    
    public $name = 'Grupo';
    
    public $primaryKey = 'id';
    
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'existsNome' => array(
                'rule' => array('existsNome'),
                'mensagem' => 'Este nome já foi cadastrado!'
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
    
    public function existsNome( $valor ){
       $registro = $this->find('first', array('nome' => $valor), NULL, array(0,1));
       return ( count($registro) > 0 );
    }
    
    
    public function findAll(){
        $lista = NULL;
        $grupos = $this->find('all', array('status' => true));
        foreach ($grupos as $grupo) {
            $lista[] = new GrupoEntity($grupo[$this->name]['id'], $grupo[$this->name]['nome'], $grupo[$this->name]['status']);
        }
        return $lista;
    }
    
    /**
     * @todo retorno uma lista de arrays com os ids que eu deseja que seja selecionado;
     * @param array $ids que eu não desejo que venha na lista de retorno
     * @return type array
     * @throws Exception
     * @example path tabela ids 1,2,3,4,5 não desejo $ids (1,2,3) retorno (4,5);
     * 
     */
    public function findGrupolistFuncionario( array $ids = NULL ){
        try{
            $sql = "SELECT id, nome FROM {$this->useTable} WHERE {$this->primaryKey} NOT IN ( ".join(',', $ids)." ) AND status = 1";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
