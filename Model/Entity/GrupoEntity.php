<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrupoEntity
 *
 * @author bruno.blauzius
 */
class GrupoEntity {
    
    private $id, $nome, $ativo;
    
    public function __construct( $id = null, $nome = null , $ativo = null) {
        $this->id = $id;
        $this->ativo = $ativo;
        $this->nome = $nome;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function getAtivo() {
        return $this->ativo;
    }
    
}
