<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FuncionarioEntity
 *
 * @author blauzius
 */
class Funcionarios {
    //put your code here
    
    private $id= null, $pessoasId= null, $empresaId= null, $created = null, $salario = null, $comissao = null, $especialidades = array();

    public function __construct( $id= null, $pessoasId= null, $empresaId= null, $created = null, $salario = null, $comissao = null, $especialidades = null ) {
        
        $this->id = $id;
        $this->pessoasId = $pessoasId;
        $this->empresaId = $empresaId;
        $this->created = $created;
        $this->salario = $salario;
        $this->comissao = $comissao;
        $this->especialidades = $especialidades;
        
    }
    

    /*GETTERS*/
    public function getId(){
        return $this->id;
    }
    
    public function getPessoaId(){
        return $this->pessoasId;
    }
    
    public function getEmpresaId(){
        return $this->empresaId;
    }
    
    public function getCreated(){
        return $this->created;
    }
    
    public function getSalario(){
        return $this->salario;
    }
    
    public function getComissao(){
        return $this->comissao;
    }
    
    public function getEspecialidade(){
        return $this->especialidades;
    }
	
	
    /*SETTERS*/
    public function setId($valor){
        $this->id = $valor;
    }

    public function setPessoaId($valor){
        $this->pessoasId = $valor;
    }
    
    public function setEmpresaId($valor){
        $this->empresaId = $valor;
    }
    
    public function setSalario($valor){
        $this->salario = $valor;
    }
    
    public function setCreated($valor){
        $this->created = $valor ;
    }
    
    public function setComissao($valor){
        $this->comissao = $valor;
    }
    
    public function setEspecialidades( $valor){
        $this->especialidades = $valor;
    }
    
}
