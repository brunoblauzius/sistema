<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Salao
 *
 * @author bruno.blauzius
 */
class Salao extends AppModel{
    //put your code here
    
    public $useTable = 'saloes';
    
    public $primaryKey = 'id';
    
    public $name = 'Salao';
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
    );
    
}
