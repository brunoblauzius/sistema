<?php

class Despesas{

	private $id = null;
	private $nome = null;
	private $empresaId = null;
	private $dataVencimento = null;
	private $diaDeVencimento = null;
	private $valor = null;
	private $fixa = null;
	private $created = null;
	private $observacao = null;
	private $status = null;
	
	public function __construct($id = null,$nome = null,$dataVencimento = null, $diaDeVencimento = null, 
	$valor = null, $fixa = null, $created = null, $observacao = null, $status = null){
		$this->id = $id;
		$this->nome = $nome;
		$this->empresaId = $empresaId;
		$this->dataVencimento = $dataVencimento;
		$this->diaDeVencimento = $diaDeVencimento;
		$this->valor = $valor;
		$this->fixa = $fixa;
		$this->created = $created;
		$this->observacao = $observacao;
		$this->status = $status;
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
	
	public function setEmpresaId( $string ){
		$this->empresaId = $string;
	}
	
	public function getEmpresaId(){
		return $this->empresaId;
	}
	
	public function setValor( $string ){
		$this->valor = $string;
	}
	
	public function getValor(){
		return $this->valor;
	}
	
	public function setFixa( $string ){
		$this->fixa = $string;
	}
	
	public function getFixa(){
		return $this->fixa;
	}

	public function setCreated( $string ){
		$this->created = $string;
	}
	
	public function getCreated(){
		return $this->created;
	}
	
	public function setObservacao( $string ){
		$this->observacao = $string;
	}
	
	public function getObservacao(){
		return $this->observacao;
	}
	
	public function setDataVencimento( $string ){
		$this->dataVencimento = $string;
	}
	
	public function getDataVencimento(){
		return $this->dataVencimento;
	}
	
	public function setDiaDeVencimento( $string ){
		$this->diaDeVencimento = $string;
	}
	
	public function getDiaDeVencimento(){
		return $this->diaDeVencimento;
	}
	
	
}