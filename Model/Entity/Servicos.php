<?php

class Servicos{

	private $id = null;
	private $status = null;
	private $nome = null;
	private $Especialidades = null;
	
	
	public function __construct( $id = null, $nome = null, $status = null, $Especialidades = null){
		$this->id 	= $id;
		$this->nome = $nome;
		$this->status = $status;
		$this->Especialidades = $Especialidades;
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
	
	public function setEspecialidades( $string ){
		$this->Especialidades = $string;
	}
	
	public function getEspecialidades(){
		return $this->Especialidades;
	}

}