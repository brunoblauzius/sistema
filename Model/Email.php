<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author bruno.blauzius
 */
class Email extends AppModel{
    //put your code here
    
    public $useTable = 'emails';
    
    public $name = 'Email';
    
    public $primaryKey = 'id';
    
    
    public $validate = array(
        'tag' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
        'corpo_mail' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
    );
    
    
    public function inserirEmailPessoa( $pessoaId, $email ){
        $emailId = null;
        
        if( !empty($pessoaId) ){
            
            $emailId = $this->genericInsert( array('email' => $email) );
            
            $this->useTable = 'emails_has_pessoas';
            
            $this->genericInsert(array(
                'emails_id'  => $emailId,
                'pessoas_id' => $pessoaId,
            ));
            
        }
    }
    
    public function inserirEmailEmpresa( $empresaId, $email ){
        $emailId = null;
        
        if( !empty($empresaId) ){
            
            $emailId = $this->genericInsert( array('email' => $email) );
            
            $this->useTable = 'emails_has_empresas';
            
            $this->genericInsert(array(
                'emails_id'   => $emailId,
                'empresas_id' => $empresaId,
            ));
            
        }
    }
    
    public function emailPessoa( $pessoaId ){
        try {
            
            $sql = "SELECT 
                        Email.id,
                        Email.email
                    FROM
                        reservas.emails_has_pessoas AS EmailPessoa
                            INNER JOIN
                        reservas.emails AS Email ON Email.id = EmailPessoa.emails_id
                    WHERE
                        EmailPessoa.pessoas_id = $pessoaId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function alterarEmailPessoas( $pessoaId, $email ){
          
        if( !empty($pessoaId) ){
            
            /**
             * recupero o id do meu email
             */
            $emailPessoa = $this->emailPessoa($pessoaId);
            
            return $this->genericUpdate( array(
                    'email' => $email, 
                    'id'    => $emailPessoa[0]['id']
                ) );
                        
        }
    }
    
}
