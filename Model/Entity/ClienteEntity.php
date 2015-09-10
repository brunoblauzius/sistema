<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClienteEntity
 *
 * @author blauzius
 */
class ClienteEntity {
    //put your code here
    
    private $id = null;
    private $nome = null;
    private $rg = null;
    private $cpf = null;
    private $endereco = null;
    private $telefone = null;
    private $celular = null;
    private $email = null;
    private $empresa = null;
    private $created = null;
    
    public function __construct( $id = null, $nome = null, $rg = null, $cpf = null, $telefone= null, $celular= null, $email= null, $empresa= null, $created= null,
            $cep= null, $logradouro= null, $bairro= null, $cidade= null, $uf= null, $numero = null ) {
        $this->id       = $id;
        $this->nome     = $nome;
        $this->rg       = $rg;
        $this->cpf      = $cpf;
        $this->telefone = $telefone;
        $this->celular = $celular;
        $this->email   = $email;
        $this->empresa = $empresa;
        $this->created = $created;
        $this->endereco = new Enderecos(null, null, $cep, $logradouro, $bairro, $cidade, $uf, $numero);
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getRg(){
        return $this->rg;
    }
    
    public function getCpf(){
        return $this->cpf;
    }
    
    public function getTelefone(){
        return $this->telefone;
    }
    
    public function getCelular(){
        return $this->celular;
    }
    
    public function getCreated(){
        return $this->created;
    }
    
    public function getEmpresa(){
        return $this->empresa;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getEndereco(){
        return $this->endereco;
    }
    
    public function setEndereco(Enderecos $valor){
        $this->endereco = $valor;
    }
}
