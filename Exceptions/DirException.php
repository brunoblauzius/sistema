<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DirException
 *
 */
class DirException extends Exception {
    
    public function __construct($message, $code = 0, $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }
    
    public final function dirNotFound( $diretorio = null ) {
        switch ($this->getCode()) {
            case 001:
                return $this->getMessage();
                break;
            default:
                
                break;
        }
    }
}
