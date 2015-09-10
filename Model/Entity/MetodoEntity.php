<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MetodoEntity
 *
 * @author bruno.blauzius
 */
class MetodoEntity {
    
    private $id = NULL, $nome = NULL, $ativo = NULL, $descricao = NULL, $controller = NULL, $isPage = NULL, $menuPrimario = NULL, $menuSecundario = NULL, $nomeLink = NULL;
    
    public function __construct( $id = NULL, $nome = NULL, $ativo = NULL, $descricao = NULL, $controller = NULL, $isPage = NULL, $menuPrimario = NULL, $menuSecundario = NULL, $nomeLink = NULL) {    
        $this->id = $id;
        $this->nome = $nome; 
        $this->ativo = $ativo;
        $this->descricao = $descricao;
        $this->controller = $controller;
        $this->isPage     = $isPage;
        $this->menuPrimario = $menuPrimario;
        $this->menuSecundario = $menuSecundario;
        $this->nomeLink       = $nomeLink;
    }
    
    
    
    public function getId(){
        return $this->id;
    }
    
    public function getAtivo(){
        return $this->ativo;
    }
    
    public function getIsPage(){
        return $this->isPage;
    }
    
    public function getMenuPrimario(){
        return $this->menuPrimario;
    }
    
    public function getMenuSecundario(){
        return $this->menuSecundario;
    }
    
    public function getDescricao(){
        return $this->descricao;
    }
    
    public function getController(){
        return $this->controller;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getNomeLink(){
        return $this->nomeLink;
    }
    
}
