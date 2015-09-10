<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlMethodsEntity
 *
 * @author bruno.blauzius
 */
class ControlMethodsEntity {
    //put your code here
    
    private $id = null, $name = null, $idMetodo = null, $nameMetodo = null, $metodoAtivo;
    
    public function __construct( $id = null, $name = null, $idMetodo = null, $nameMetodo = null, $ativo = 0 ) {
        $this->id = $id;
        $this->name = $name;
        $this->idMetodo = $idMetodo;
        $this->nameMetodo = $nameMetodo;
        $this->metodoAtivo = $ativo;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getIdMetodo(){
        return $this->idMetodo;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getNameMetodo(){
        return $this->nameMetodo;
    }
    
    public function getMetodoAtivo(){
        return $this->metodoAtivo;
    }
    
}
