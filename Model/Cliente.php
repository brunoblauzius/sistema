<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author blauzius
 */
class Cliente extends AppModel {
    //put your code here
    
    public $useTable = 'clientes';
    public $name     = 'Cliente';
    public $primaryKey = 'id';
    
    public $validate = array(
        'nome' => array(
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
            'verificaTelefone' => array(
                'rule' => array('verificaTelefone'),
                'mensagem' => 'Já cadastrado para esta empresa favor utilizar outro!'
            ),
        ),
        'rg' => array(
            'verificaRG' => array(
                'rule' => array('verificaRG'),
                'mensagem' => 'Já cadastrado para esta empresa favor utilizar outro!'
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
            'verificaEmail' => array(
                'rule' => array('verificaEmail'),
                'mensagem' => 'Já cadastrado para esta empresa favor utilizar outro!'
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => Enum::EMAIL_INVALIDO
            ),
        ),
    );
    
    
    public function verificaEmail($email) {
        $verificaMail = $this->find('first', array('email' => $email, 'empresas_id' => $this->data['empresas_id'] ));
        return ( count($verificaMail) > 0 );
    }
    
    public function verificaTelefone($telefone) {
        $verifica = $this->find('first', array('telefone' => $telefone, 'empresas_id' => $this->data['empresas_id'] ));
        return ( count($verifica) > 0 );
    }
    
    public function verificaRG($valor) {
        if( !empty($valor) ){
            $verifica = $this->find('first', array('rg' => $valor, 'empresas_id' => $this->data['empresas_id'] ));
            return ( count($verifica) > 0 );
        }
    }
    
    
    public function buscarCliente ( $busca, $valor, $pessoasId, $roleId ){
        $TELEFONE = NULL;
        $NOME = null;
        $RG = null;
        $EMAIL = null;
        
        if ( $roleId < 4 ){
            $modelEmpresa = new Empresa();
            $proprietarioId = $modelEmpresa->proprietario(md5($pessoasId));
            $proprietarioId = (int) $proprietarioId[0]['pessoas_id'];
        } else {
            $proprietarioId = ($pessoasId);
        }
        
        
        if( $busca == 'nome'){
            $NOME = " (Cliente.nome LIKE '%{$valor}%') ";
        }
        else if( $busca == 'telefone'){
            $valor = Utils::returnNumeric($valor);
            $TELEFONE = " (Cliente.telefone = '{$valor}') ";
        }
        else if( $busca == 'rg'){
            $RG = " (Cliente.rg = '{$valor}') ";
        }
        else if( $busca == 'email'){
            $EMAIL = " (Cliente.email = '{$valor}') ";
        }
        
        $sql = "SELECT 
                    Cliente.id,
                    Cliente.nome,
                    Cliente.sexo,
                    Cliente.status,
                    Cliente.email,
                    Cliente.telefone,
                    Cliente.rg,
                    Juridica.nome_fantasia,
                    Cliente.dt_nascimento
                FROM
                    clientes AS Cliente
                        INNER JOIN
                    empresas AS Empresa ON Cliente.empresas_id = Empresa.id
                        INNER JOIN
                    pessoaJuridica AS Juridica ON Juridica.id = Empresa.pessoaJuridica_id
                WHERE
                    Empresa.pessoas_id = $proprietarioId 
                                AND ". $NOME . $TELEFONE . $RG . $EMAIL .";";
        
        return $this->query($sql);
    }
    
    
    public function clientesProprietario( $pessoasId, $roleId ){
        try {
            
            if ( $roleId < 4 ){
                $modelEmpresa = new Empresa();
                $proprietarioId = $modelEmpresa->proprietario(md5($pessoasId));
                $proprietarioId = (int) $proprietarioId[0]['pessoas_id'];
            } else {
                $proprietarioId = ($pessoasId);
            }
            
            $sql = "SELECT 
                        Cliente.id, 
                        Cliente.nome,
                        Cliente.sexo,
                        Cliente.status,
                        Cliente.email,
                        Cliente.telefone,
                        Cliente.rg,
                        Juridica.nome_fantasia,
                        Cliente.dt_nascimento
                    FROM
                        clientes AS Cliente
                            INNER JOIN
                        empresas AS Empresa ON Cliente.empresas_id = Empresa.id
                            INNER JOIN
                        pessoaJuridica AS Juridica ON Juridica.id = Empresa.pessoaJuridica_id
                    WHERE
                        Empresa.pessoas_id = $proprietarioId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
