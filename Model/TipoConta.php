<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoConta
 *
 * @author bruno.blauzius
 */
class TipoConta extends AppModel {
    //put your code here
    
    public $useTable = 'contas_empresas_tipos';
    
    public $primaryKey = 'id';
    
    public $name = 'TipoConta';
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
    );
    
}