<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemplatePainel
 *
 * @author BRUNO
 */
abstract class TemplatePainel {
    
    public function imprimirPainel( AppController $class ){
        $this->parametros( $class );
        $this->renderFile($class);
    }
    
    
    abstract protected function parametros( AppController $class );
    abstract protected function renderFile( AppController $class );
}
