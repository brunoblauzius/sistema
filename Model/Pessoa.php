<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pessoa
 *
 * @author blauzius
 */
class Pessoa extends AppModel{
    //put your code here
    
    public $useTable = 'pessoas';
    
    public $name     = 'Pessoa';
    
    public $primaryKey = 'id';
    
    public $validate = array(
        'termo' => array(
          'isTrue' => array(
              'rule' => array('isTrue'),
              'mensagem' => Enum::VERIFICA_TERMO
          )  
        ),
        'nome' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'email' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'email' => array(
              'rule' => array('email'),
              'mensagem' => Enum::EMAIL_INVALIDO,
          ),
          'verificaEmail' => array(
              'rule' => array('verificaEmail'),
              'mensagem' => Enum::USUARIO_CADASTRADO,
          )
        ),
        'tipo_pessoa' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'login' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'cpf' => array(
            
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'verificaCpfCnpj' => array(
              'rule' => array('verificaCpfCnpj'),
              'mensagem' => Enum::VERIFICA_CPF_CNPJ,
          ),
          'isValidCPF' => array(
              'rule' => array('isValidCPF'),
              'mensagem' => 'CPF está inválido',
          ),
        ),
        'senha' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'minLenght' => array(
              'rule' => array('minLenght', 6),
              'mensagem' => 'Este campo deve conter no minimo 6 digitos',
          ),
          'equalsPassword' => array(
              'rule' => array('equalsPassword'),
              'mensagem' => Enum::SENHA_NAO_CONFERE
          ),
        ),
        'confirm_senha' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ), 
          'minLenght' => array(
              'rule' => array('minLenght', 6),
              'mensagem' => 'Este campo deve conter no minimo 6 digitos',
          )
        ),
    );
    
    public $validate_site = array(
        'termo' => array(
          'isTrue' => array(
              'rule' => array('isTrue'),
              'mensagem' => Enum::VERIFICA_TERMO
          )  
        ),
        'nome' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'login' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'ddd' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'telefone' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'email' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'email' => array(
              'rule' => array('email'),
              'mensagem' => Enum::EMAIL_INVALIDO,
          ),
        ),
        'senha' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'minLenght' => array(
              'rule' => array('minLenght', 6),
              'mensagem' => 'Este campo deve conter no minimo 6 digitos',
          ),
          'equalsPassword' => array(
              'rule' => array('equalsPassword'),
              'mensagem' => Enum::SENHA_NAO_CONFERE
          ),
        ),
        'confirm_senha' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ), 
          'minLenght' => array(
              'rule' => array('minLenght', 6),
              'mensagem' => 'Este campo deve conter no minimo 6 digitos',
          )
        ),
    );
        
    public $validate_fisica = array(
        'termo' => array(
          'isTrue' => array(
              'rule' => array('isTrue'),
              'mensagem' => Enum::VERIFICA_TERMO
          )  
        ),
        'nome' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'razao' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'fantasia' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'ie' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'email' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'email' => array(
              'rule' => array('email'),
              'mensagem' => Enum::EMAIL_INVALIDO,
          ),
          'verificaEmail' => array(
              'rule' => array('verificaEmail'),
              'mensagem' => Enum::USUARIO_CADASTRADO,
          )
        ),
        'tipo_pessoa' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
        ),
        'cnpj' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'verificaCpfCnpj' => array(
              'rule' => array('verificaCpfCnpj'),
              'mensagem' => Enum::VERIFICA_CPF_CNPJ,
          ),
           'isValidCNPJ' => array(
              'rule' => array('isValidCNPJ'),
              'mensagem' => 'CNPJ está inválido',
          ),
        ),
        'senha' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'minLenght' => array(
              'rule' => array('minLenght', 6),
              'mensagem' => 'Este campo deve conter no minimo 6 digitos',
          ),
          'equalsPassword' => array(
              'rule' => array('equalsPassword'),
              'mensagem' => Enum::SENHA_NAO_CONFERE
          ),
        ),
        'confirm_senha' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ), 
          'minLenght' => array(
              'rule' => array('minLenght', 6),
              'mensagem' => 'Este campo deve conter no minimo 6 digitos',
          )
        ),
    );
    
    
    
    public function isTrue( $valor ){
        return ($valor != true);
    }
    
        
    public function recuperaChave( $cpfCnpj ){
        try{
            $sql = "SELECT chave FROM vw_empresa_full WHERE cpf = {$cpfCnpj} OR cnpj = {$cpfCnpj};";
            $retorno = $this->query($sql);
            return $retorno[0]['chave'];
        } catch (Exception $ex) {

        }
    }
    
    public function proprietarioEmpresas(){
        try {
            $sql = "SELECT 
                            Pessoa.created,
                        Fisica.nome,
                        Fisica.cpf,
                        Fisica.rg,
                        Fisica.pessoas_id,
                        Usuario.email,
                        Usuario.login,
                        Usuario.status
                    FROM
                        reservas.pessoas AS Pessoa
                            INNER JOIN
                        reservas.pessoaFisica AS Fisica ON Fisica.pessoas_id = Pessoa.id
                            INNER JOIN
                        reservas.usuarios AS Usuario ON Usuario.pessoas_id = Pessoa.id
                    WHERE
                        roles_id = 4;";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
