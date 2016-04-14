<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facebook
 *
 * @author BRUNO
 */
class Facebook extends AppModel {

    //put your code here


    private $facebookId = null;
    private $nome = null;
    private $email = null;
    private $phone = null;

    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'facebook_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'phone' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => Enum::EMAIL_INVALIDO
            ),
        ),
    );
    
    
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

    public function idNull() {
        if (is_null($this->facebookId)) {
            throw new Exception('usuario do facebook não encontrado', 001);
        }
        return $this;
    }
    
    public function authentictionFacebook() {
        try {

            $sql = "SELECT * FROM usuarios WHERE facebook_id = $this->facebookId ";
            $fecth = $this->query($sql);

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
             $registro = $modelCliente->recuperaCliente($this->nome, $this->phone);
             
             $this->data = array(
                 'nome'  => $this->nome,
                 'phone' => $this->phone,
                 'email' => $this->email,
                 'facebook_id' => $this->facebookId,
             );
             

               /**
                * criar uma pessoa
                */
                 $modelPessoa = new Pessoa();
                 $pessoasId = $modelPessoa->genericInsert(array(
                     'tipo_pessoa' => 1,
                     'created'     => $created,
                 ));
                /**
                 * criar uma pessoa fisica
                 */
                 $ModelPF = new Fisica();
                 $ModelP->genericInsert(array(
                     'pessoas_id' => $pessoasId,
                     'cpf'  => '00000000000',
                     'nome' => $this->nome,
                 ));
                /**
                 * criar um contato
                 */
                $modelContato = new Contato();
                $contatoId = $modelContato->genericInsert(array(
                    'telefone' => $this->phone,
                    'tipo'     => 1,
                ));
                $modelContato->inserirContato($pessoasId, $contatoId);
                /**
                 * criar um email
                 */
                $modelEmail = new Email();
                $modelEmail->inserirEmailPessoa($pessoasId, $this->email);
                
                /**
                 * criar um usuario
                 */
                 $modelUsuario = new Usuario();
                 $usuarioId = $modelUsuario->genericInsert(array(
                    'roles_id' => 1,
                    'pessoas_id' => $pessoaId,
                    'status' => 1,
                    'perfil_teste' => 0,
                    'created' => $created,
                    'email' => $this->email,
                    'login' => $this->email,
                    'senha' => Authentication::password($this->Pessoa->data['senha']),
                    'chave' => Authentication::uuid()
                ));
                
                $registro = $modelCliente->recuperaCliente($this->nome, $this->phone);
                
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
