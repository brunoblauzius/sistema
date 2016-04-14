<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemplateRegisterApp
 *
 * @author BRUNO
 */
abstract class TemplateRegisterApp extends AppModel {
    //put your code here
    
    private $facebookId = null;
    private $nome = null;
    private $email = null;
    private $phone = null;
    private $pass = null;
    
    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
        return $this;
    }

        public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function getFacebookId() {
        return $this->facebookId;
    }

    function setFacebookId($facebookId) {
        $this->facebookId = $facebookId;
        return $this;
    }

    public function facebookIdNull() {
        if (is_null($this->facebookId)) {
            throw new Exception('usuario do facebook não encontrado', 001);
        }
        return $this;
    }
    
    
    
    abstract public function cadastro( $created );
    abstract public function update( $created, $registro );
    abstract public function sqlAutentication();
    
    public function authentiction(){
        try {
            
            $fecth = $this->query( $this->sqlAutentication() );

            if (empty($fecth)) {
                throw new Exception('Usuario não foi encontrado no sistema!', 002);
            }
            
            return $fecth;
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function register(){
        try {

             $created = date('Y-m-d H:i:s');
             /**
              * VERIFICAR SE EXISTE UMA NOVA PESSOA
              */
             $modelCliente = new Cliente();
                          
             $registro = $modelCliente->recuperaCliente($this->getNome(), $this->getPhone());
             
             if( empty($registro) ){                 
                 $registro = $this->cadastro($created);
             } else {
                 $registro = $this->update($created, $registro);
             }
                
            return $registro;
        } 
        catch (PDOException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    
}
