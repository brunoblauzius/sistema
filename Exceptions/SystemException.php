<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SistemException
 *
 * @author blauzius
 */
class SystemException extends Exception {
    //put your code here
    
    public function __construct( $code = 0 ) {
        
        $model = new Funcionario();
        $model->useTable = 'erros_sistema';
        $sql = "SELECT * FROM {$model->useTable} WHERE id = {$code};";
        $nome = $model->query($sql);
   
        parent::__construct( ($nome[0]['nome']), $code, NULL );
        
    }
    
	public function getErrorJson( $div ){
            return json_encode( array(
                    'funcao' => "infoErro('".utf8_encode($this->getMessage())."', '".$div."');",
            ));
	}
	
}
