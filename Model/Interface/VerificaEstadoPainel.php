<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VerificaEstadoPainel
 *
 * @author BRUNO
 */
class VerificaEstadoPainel {

    //put your code here

    private $estado;
    private $class;
    
    public function getClass() {
        return $this->class;
    }

    public function setClass(AppController $class) {
        $this->class = $class;
        return $this;
    }

    
    public function setEstado($estado) {
        $this->estado = $estado;
        return $this;
    }

    public function getEstado() {
        return $this->estado;
    }

}
