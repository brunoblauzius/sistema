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
    
    
    public function getBusinessMessage(){
        
    }
    
    public function getBusinessCode(){
        
    }
    
    public function getNotPermission(){       
    }
    
}
