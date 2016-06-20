<?php

/**
 * Description of Atracao
 *
 * @author BRUNO
 */
class Atracao extends AppModel{
    //put your code here
    
    public $useTable = 'atracoes';
    
    public $name = 'Atracao';
    
    public $primaryKey = 'id';
    
    public $validate = array(
        'descricao' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            )
        ),
    );
    
}
