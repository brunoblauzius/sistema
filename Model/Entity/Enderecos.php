<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EnderecoEntity
 *
 * @author blauzius
 */
class Enderecos {
    private $cep = null;
    private $logradouro = null;
    private $bairro = null;
    private $cidade = null;
    private $uf = null;
    private $numero = null;
    private $id = null;
    private $pessoasId = null;
    
    public function __construct( $id = NULL, $pessoasId = null, $cep = NULL, $logradouro=NULL, $bairro = NULL, $cidade = NULL, $uf = NULL, $numero = NULL) {
        $this->cep = $cep;
        $this->cidade= $cidade;
        $this->logradouro = $logradouro;
        $this->bairro = $bairro;
        $this->uf = $uf;
        $this->numero = $numero;
        $this->id = $id;
		$this->pessoasId = $pessoasId;
    }
    
    public function setCep($valor){
        $this->cep = $valor;
    }
    
    public function setCidade($valor){
        $this->cidade = $valor;
    }
    
    public function setLogradouro($valor){
        $this->logradouro = $valor;
    }
    
    public function setBairro($valor){
        $this->bairro = $valor;
    }
    
    public function setUf($valor){
        $this->uf = $valor;
    }
    
    public function setNumero($valor){
        $this->numero = $valor;
    }
    
    public function setId($valor){
        $this->id = $valor;
    }
    
    public function getId(){
        return $this->id;
    }
    
	public function setPessoaId($valor){
        $this->pessoasId = $valor;
    }
    
    public function getPessoaId(){
        return $this->pessoasId;
    }
	
    public function getCep(){
        return $this->cep;
    }
    
    public function getCidade(){
        return $this->cidade;
    }
    
    public function getLogradouro(){
        return $this->logradouro;
    }
    
    public function getBairro(){
        return $this->bairro;
    }
    
    public function getUf(){
        return $this->uf;
    }
    
    public function getNumero(){
        return $this->numero;
    }
    
}
