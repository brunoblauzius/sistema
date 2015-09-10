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
class FuncionariosFull {
    //put your code here
    
    private $id, $nome, $email, $dataNascimento, $tipoPessoa, $created, $empresaId, $cpf, $cnpj, $nomeFantasia, $razao, $ie, $flstatus, $role, $perfilTeste, $chave, $telefone, $celular, $rg, $login;
    private $endereco;
	private $Especialidades;
    private $obejto = null;
    
    public function __construct( $id = null, $nome = null, $email= null, $dataNascimento= null, $tipoPessoa= null, $created= null, $empresaId= null, $cpf= null, 
            $cnpj= null, $nomeFantasia= null, $razao= null, $ie= null, $flstatus= null, $role= null, $perfilTeste= null, $chave= null, $telefone= null, $celular = null, $rg = null, $login = NULL ) {
        
        $this->id = $id;#
        $this->nome = $nome;#
        $this->dataNascimento = $dataNascimento;
        $this->created = $created;#
        $this->empresaId= $empresaId;#
        
        #tipo pessoa
        $this->tipoPessoa = $tipoPessoa;
        
        #pessoa fisica
        $this->cpf = $cpf;#
        $this->rg = $rg;#
        
        #pessoa juridica
        $this->cnpj = $cnpj;#
        $this->nomeFantasia = $nomeFantasia;#
        $this->razao = $razao;#
        $this->ie = $ie;#
        
        #usuario
        $this->flstatus = $flstatus;#
        $this->role = $role;#
        $this->perfilTeste = $perfilTeste;#
        $this->chave = $chave;#
        $this->login = $login;
        
        #contato entiti
        $this->email = $email;#
        $this->telefone = $telefone;
        $this->celular = $celular;
    }
    
    /**
     * @todo metodo que eu adiciono meu obejto e retorno uma lista;
     * @param FuncionarioEntity $objeto
     * @return type
     */
    public function addFuncionario(FuncionarioEntity $objeto){
        $this->obejto[] = $objeto;
    }
    
    /**
     * @metodo que eu retorno minha lista
     * @return array $this->objeto
     */
    public function getFuncionario(){
        return $this->obejto;
    }
    
    public function getDataNascimento(){
        return $this->dataNascimento;
    }
    
    public function getTipoPessoa(){
        return $this->tipoPessoa;
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
    
    public function getCnpj(){
        return $this->cnpj;
    }
    
    public function getRazao(){
        return $this->razao;
    }
    
    public function getFantasia(){
        return $this->nomeFantasia;
    }
    
    public function getIe(){
        return $this->ie;
    }
    
    public function getStatus(){
        return $this->flstatus;
    }
    
    public function getRole(){
        return $this->role;
    }
    
    public function getPerfilTeste(){
        return $this->perfilTeste;
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
        return $this->empresaId;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getChave(){
        return $this->chave;
    }
    
    public function getEndereco(){
        return $this->endereco;
    }
    
    public function getLogin(){
        return $this->login;
    }
    
    public function setLogin($valor){
        $this->login = $valor;
    }
    
    public function setEndereco( Enderecos $valor){
        $this->endereco = $valor;
    }
	
	public function setEspecialidades( Especialidades $valor ){
        $this->Especialidades = $valor;
    }
	
	public function getEspecialidades(){
        return $this->Especialidades;
    }
    
    public function setDataNascimento($valor){
        $this->dataNascimento = $valor;
    }
    
    public function setTipoPessoa($valor){
        $this->tipoPessoa = $valor;
    }
    
    public function setId($valor){
        $this->id = $valor;
    }
    
    public function setNome($valor){
        $this->nome = $valor ;
    }
    
    public function setRg($valor){
        $this->rg = $valor;
    }
    
    public function setCpf($valor){
        $this->cpf = $valor;
    }
    
    public function setCnpj($valor){
        $this->cnpj = $valor;
    }
    
    public function setRazao($valor){
        $this->razao= $valor;
    }
    
    public function setFantasia($valor){
        $this->nomeFantasia= $valor;
    }
    
    public function setIe($valor){
        $this->ie =$valor;
    }
    
    public function setStatus($valor){
        $this->flstatus = $valor;
    }
    
    public function setRole($valor){
        $this->role = $valor;
    }
    
    public function setPerfilTeste($valor){
        $this->perfilTeste = $valor;
    }
    
    public function setTelefone($valor){
        $this->telefone = $valor ;
    }
    
    public function setCelular($valor){
        $this->celular = $valor;
    }
    
    public function setCreated($valor){
        $this->created = $valor;
    }
    
    public function setEmpresa( $valor ){
        $this->empresaId = $valor ;
    }
    
    public function setEmail( $valor ){
        $this->email = $valor;
    }
    
    public function setChave( $valor ){
        $this->chave = $valor;
    }

}
