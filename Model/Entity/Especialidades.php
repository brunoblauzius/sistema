<?php

class Especialidades{

	private $id = null;
	private $status = null;
	private $nome = null;
	private $Servicos = null;
	
	
	public function __construct( $id = null, $nome = null, $status = null, $servicos = null ){
		$this->id 	= $id;
		$this->nome = $nome;
		$this->status = $status;
		$this->Servicos = $servicos;
	}
	
	public function setId( $string ){
		$this->id = $string;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setNome( $string ){
		$this->nome = $string;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function setStatus( $string ){
		$this->status = $string;
	}
	
	public function getStatus(){
		return $this->status;
	}

	public function setServicos( $string ){
		$this->Servicos = $string;
	}
	
	public function getServicos(){
		return $this->Servicos;
	}
	
}