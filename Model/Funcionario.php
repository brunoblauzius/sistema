<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Funcionario extends AppModel{
    
    public $useTable = 'funcionarios';
    
    public $name = 'Funcionario';
    
    public $primaryKey = 'id';
    
    public $validate = array(
        'roles_id' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
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
          /*'verificaEmail' => array(
              'rule' => array('verificaEmail'),
              'mensagem' => Enum::USUARIO_CADASTRADO,
          )*/
        ),
        'cpf' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          ),
          'isValidCPF' => array(
              'rule' => array('isValidCPF'),
              'mensagem' => 'CPF inválido',
          ) 
        ),
        'login' => array(
          'notEmpty' => array(
              'rule' => array('notEmpty'),
              'mensagem' => Enum::VAZIO,
          )  
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
	
	
    
       
    
    public function findFuncionarios( $empresaId, $pessoaId = NULL ){
        try{
            $PESSOA = null;
            if( !is_null($pessoaId) ){
                $PESSOA = " AND md5(Pessoa.id) = '{$pessoaId}'; ";
            }
            
            $sql = "SELECT 
                        Pessoa.id as pessoas_id,
                        Pessoa.tipo_pessoa,
                        Pessoa.created,
                        Pessoa.modify,
                        Fisica.id as fisicas_id,
                        Fisica.nome,
                        Fisica.cpf,
                        Fisica.rg,
                        User.email,
                        Fisica.data_nascimento,
                        User.id as users_id,
                        User.roles_id,
                        User.perfil_teste,
                        User.status,
                        User.login,
                        User.chave,
                        if(Empresa.id is null, Funcionario.empresas_id, Empresa.id) as empresas_id,
                        Funcionario.id as funcionarios_id,
                        Funcionario.salario,
                        Funcionario.salario,
                        Funcionario.percentual_comissao
                    FROM
                        reservas.usuarios AS User
                            INNER JOIN
                        reservas.pessoas AS Pessoa ON Pessoa.id = User.pessoas_id
                            LEFT JOIN
                        reservas.pessoaFisica AS Fisica ON Fisica.pessoas_id = User.pessoas_id
                            LEFT JOIN
                        reservas.empresas AS Empresa ON Empresa.pessoas_id = Pessoa.id
                            LEFT JOIN
                        reservas.funcionarios AS Funcionario ON Funcionario.pessoas_id = Pessoa.id
                    WHERE
                        (Empresa.id = {$empresaId}
                            OR Funcionario.empresas_id = {$empresaId}) " . $PESSOA;
                            
            $retorno = $this->query($sql);
            return $retorno;
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
     
    
    public final function funcionariosEmpresa( $empresaId ){
        try{
            
            
            $sql = "SELECT 
                        Pessoa.id as pessoas_id,
                        Pessoa.tipo_pessoa,
                        Pessoa.created,
                        Pessoa.modify,
                        Fisica.nome,
                        Fisica.cpf,
                        User.email,
                        Fisica.data_nascimento,
                        User.id as users_id,
                        User.roles_id,
                        User.perfil_teste,
                        User.status,
                        User.login,
                        User.imagem_perfil,
                        User.chave,
                        Role.nome as nivel_usuario,
                        if(Empresa.id is null, Funcionario.empresas_id, Empresa.id) as empresas_id,
                        Funcionario.id as funcionarios_id,
                        Funcionario.salario,
                        Funcionario.percentual_comissao
                    FROM
                        reservas.usuarios AS User
                            INNER JOIN
                        reservas.pessoas AS Pessoa ON Pessoa.id = User.pessoas_id
                            INNER JOIN
                        reservas.pessoaFisica AS Fisica ON Fisica.pessoas_id = User.pessoas_id
                            LEFT JOIN
                        reservas.empresas AS Empresa ON Empresa.pessoas_id = Pessoa.id
                            LEFT JOIN
                        reservas.roles AS Role ON Role.id = User.roles_id
                            LEFT JOIN
                        reservas.funcionarios AS Funcionario ON Funcionario.pessoas_id = Pessoa.id
                    WHERE
                        (Empresa.id = {$empresaId}
                            OR Funcionario.empresas_id = {$empresaId}) ORDER BY Fisica.nome ASC"; 
                            
            $retorno = $this->query($sql);
            return $retorno;
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
        
    
}
