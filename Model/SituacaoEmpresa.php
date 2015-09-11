<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SituacaoEmpresa
 *
 * @author bruno.blauzius
 */
class SituacaoEmpresa extends AppModel {
    //put your code here
    
    public $useTable = 'situacao_empresas';
    
    public $primaryKey = 'id';
    
    public $name = 'SituacaoEmpresa';
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
    );
    
}
