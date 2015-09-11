<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SituacaoConta
 *
 * @author bruno.blauzius
 */
class SituacaoConta extends AppModel {
    //put your code here
    
    public $useTable = 'situacao_contas';
    
    public $primaryKey = 'id';
    
    public $name = 'SituacaoConta';
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
    );
    
}