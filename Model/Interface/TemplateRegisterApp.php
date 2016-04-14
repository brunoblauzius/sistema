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
    
    public function authentictionFacebook() {
        try {

            $sql = "SELECT * FROM vw_clientes WHERE facebook_id = $this->facebookId ";
            $fecth = $this->query($sql);

            if (empty($fecth)) {
                throw new Exception('Usuario não foi encontrado no sistema!', 002);
            }
            return $fecth;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    abstract public function register();
    
}
