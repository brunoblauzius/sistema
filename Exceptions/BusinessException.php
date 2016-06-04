<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BusinessException
 *
 * @author bruno.blauzius
 */
class BusinessException extends Exception {
    //put your code here
    
    public function __construct($message, $code = 0, $previous = NULL) {
        parent::__construct($message, $code, $previous);        
    }
    
    
    public function getBusinessMessage( Render $class, $layout = NULL ){
        
        if( $layout == 'null'){
            $class->layout = $layout;
        }
        
        $class->set( 'mensagem', $this->getMessage() );
        if( $this->getCode() == 112){
            die( $class->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
        } else if( $this->getCode() == 113 ){
            die( $class->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
        } else if( $this->getCode() == 114 ){
            die( $class->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
        }
    }
    
    public function getBusinessCode(){
        
    }
    
    public function getNotPermission(){       
    }
    
    public function getNotLimitEmployees( $class ){
        $class->set( 'mensagem', $this->getMessage() );
        die( $class->render(array('controller' => 'Erros', 'view' => 'notLimitEmployee')) );
    }
    
}
