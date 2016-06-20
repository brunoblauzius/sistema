<?php

require_once 'Interface/TemplateRegisterApp.php';
        
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
class Facebook extends TemplateRegisterApp {

    //put your code here
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
        'telefone' => array(
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
    
    public function sqlAutentication() {
        return "SELECT * FROM vw_clientes WHERE facebook_id = {$this->getFacebookId()} ";
    }
    
    public function cadastro( $created ) {
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
         $ModelPF->genericInsert(array(
             'pessoas_id' => $pessoasId,
             'cpf'  => '00000000000',
             'nome' => $this->getNome(),
         ));
        /**
         * criar um contato
         */
        $modelContato = new Contato();
        $contatoId = $modelContato->genericInsert(array(
            'telefone' => Utils::returnNumeric( $this->getPhone() ),
            'tipo'     => 1,
        ));
        $modelContato->inserirContato($pessoasId, $contatoId);
        /**
         * criar um email
         */
        $modelEmail = new Email();
        $modelEmail->inserirEmailPessoa($pessoasId, $this->getEmail());

        /**
         * criar um usuario
         */
         $modelUsuario = new Usuario();
         $usuarioId = $modelUsuario->genericInsert(array(
            'roles_id' => 1,
            'pessoas_id' => $pessoasId,
            'status' => 1,
            'perfil_teste' => 0,
            'created' => $created,
            'email' => $this->getEmail(),
            'login' => $this->getEmail(),
            'senha' => Authentication::password( $this->getPhone() ),
            'chave' => Authentication::uuid(),
            'facebook_id' => $this->getFacebookId(),
        ));

         
        $modelCliente = new Cliente();
        $modelCliente->genericInsert(array(
            'pessoas_id' => $pessoasId,
            'status' => 1,
            'sexo'   => 0,
        ));

        return  $modelCliente->recuperaCliente($this->getNome(), $this->getPhone());
    }
    
    public function update($created, $registro) {
        /**
        * criar um usuario
        */
        $modelUsuario = new Usuario();
        $modelUsuario->genericUpdate(array(
           'facebook_id' => $this->getFacebookId(),
           'id'   => $registro['usuarios_id']
       ));

       $registro['facebook_id'] = $this->getFacebookId();
       
       return $registro;
    }
    
}
