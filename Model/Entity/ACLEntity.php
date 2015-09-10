<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ACLEntity
 *
 * @author bruno.blauzius
 */
class ACLEntity {
    //put your code here
    
    public $id = null, $grupoId = null, $metodoId = null, $controllerId = null, $metodoNome = null, $controllerNome = null, $ativo = null;
    
    
    public function __construct($id = null, $grupoId = null, $metodoId = null, $controllerId = null, $metodoNome = null, $controllerNome = null, $ativo = 0) {
        $this->id = $id;
        $this->grupoId = $grupoId;
        $this->metodoId = $metodoId;
        $this->controllerId = $controllerId;
        $this->metodoNome = $this->metodoNome;
        $this->controllerNome = $controllerNome;
        $this->ativo = $ativo;
    }
    
    
    public function getId(){
        return $this->id;
    }
    
    public function getGrupoId(){
        return $this->grupoId;
    }
    
    public function getMetodoId(){
        return $this->metodoId;
    }
    
    public function getControllerId(){
        return $this->controllerId;
    }
    
    public function getMetodoNome(){
        return $this->metodoNome;
    }
    
    public function getControllerNome(){
        return $this->controllerNome;
    }
    
    public function getAtivo(){
        return $this->ativo;
    }
}
