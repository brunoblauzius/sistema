<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailEntity
 *
 * @author bruno.blauzius
 */
class EmailEntity {
    //put your code here
    
    private $id = null, $tag = null, $corpoEmail = null, $ativo = null;
    
    public function __construct($id = null, $tag = null, $corpoEmail = null, $ativo = null) {
        $this->id = $id;
        $this->tag = $tag;
        $this->corpoEmail = $corpoEmail;
        $this->ativo = $ativo;
    }
    
    
    public function getId(){
        return $this->id;
    }
        
    public function getTag(){
        return $this->tag;
    }
    
    public function getCorpoEmail(){
        return $this->corpoEmail;
    }
    
    public function getAtivo(){
        return $this->ativo;
    }
}
