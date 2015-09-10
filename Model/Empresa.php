<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author bruno.blauzius
 */
class Empresa extends AppModel {

    //put your code here

    public $useTable = 'empresas';
    public $name = 'Empresa';
    public $primaryKey = 'id';
    public $validate = array(
        'razao' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'cnpj' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
            'isValidCNPJ' => array(
                'rule' => array('isValidCNPJ'),
                'mensagem' => 'CNPJ está inválido',
            ),
            'verificaCpfCnpj' => array(
                'rule' => array('verificaCpfCnpj'),
                'mensagem' => Enum::VERIFICA_CPF_CNPJ,
            ),
        ),
        'nome_fantasia' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => 'Favor inserir um email válido',
            ),
        ),
    );

    public function dadosMinhaConta($empresasId) {
        try {

            $sql = "SELECT 
                        SCont.nome as situacao_conta,
                        ContaEmpresa.situacao_contas_id,
                        TipoPG.nome as tipos_pagamento, 
                        CETipos.nome as contas_empresas_tipo, 
                        ContaEmpresa.created
                    FROM
                        reservas.contas_empresas AS ContaEmpresa
                            INNER JOIN
                        reservas.situacao_contas AS SCont ON SCont.id = ContaEmpresa.situacao_contas_id
                            INNER JOIN
                        reservas.tipos_pagamentos AS TipoPG ON TipoPG.id = ContaEmpresa.tipos_pagamentos_id
                            INNER JOIN
                        reservas.contas_empresas_tipos AS CETipos ON CETipos.id = ContaEmpresa.contas_empresas_tipos_id
                    WHERE
                        ContaEmpresa.empresas_id = $empresasId;";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function verificaPeriodoTempoConta() {
        
    }

    public function contaEmpresa( $hash ){
        try {
            
            $sql = "SELECT 
                    Conta.id,
                    Conta.empresas_id,
                    Conta.created,
                    SituacaoConta.nome as situacao_conta,
                    TipoPagamento.nome as tipo_pagamento,
                    TipoConta.nome as tipo_conta,
                    TipoConta.valor,
                    TipoConta.duracao_contrato
                FROM
                    reservas.contas_empresas AS Conta
                        INNER JOIN
                    reservas.situacao_contas AS SituacaoConta ON SituacaoConta.id = Conta.situacao_contas_id
                        INNER JOIN
                    reservas.tipos_pagamentos AS TipoPagamento ON TipoPagamento.id = Conta.tipos_pagamentos_id
                        INNER JOIN
                    reservas.contas_empresas_tipos AS TipoConta ON TipoConta.id = Conta.contas_empresas_tipos_id
                WHERE
                    md5(Conta.empresas_id) = '{$hash}';";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function empresasAtivas() {
        try {

            $sql = "SELECT 
                            PagP.id,
                            ContEmp.empresas_id,
                            ContEmp.expirar,
                            PagStat.nome as status_pagamento,
                            PagTip.nome as tipo_pagamento,
                            PagIdent.nome as modo_pagamento,
                            PagP.created,
                            PagP.modified,
                            PagP.codigo,
                            PagP.reference,
                            PagP.grossamount
                    FROM
                            reservas.pagseguro_conta_empresas AS PagCE
                                    INNER JOIN
                            reservas.contas_empresas AS ContEmp ON ContEmp.id = PagCE.contas_empresas_id
                                    INNER JOIN
                            reservas.pagseguro_pagamentos AS PagP ON PagP.id = PagCE.pagseguro_pagamentos_id
                                    LEFT JOIN
                            reservas.pagseguro_status_transacao AS PagStat ON PagStat.id = PagP.pagseguro_status_transacao_id
                                    LEFT JOIN
                            reservas.pagseguro_tipo_transacao AS PagTip ON PagTip.id = PagP.pagseguro_tipo_transacao_id
                                    LEFT JOIN
                            reservas.pagseguro_identificador_meio_pagamento AS PagIdent ON PagIdent.id = PagP.pagseguro_identificador_meio_pagamento_id
                    WHERE 
                            PagStat.id in ( 3 )
                            AND MONTH(ContEmp.expirar) = MONTH(current_date()) 
                            GROUP BY ContEmp.empresas_id
                    ORDER BY created DESC;";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function empresasTeste() {
        try {
            $sql = "SELECT 
                        *
                    FROM
                        reservas.contas_empresas
                    WHERE
                        contas_empresas_tipos_id in(1,2) 
                        AND tipos_pagamentos_id = 1;";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function bloquearEmpresa($empresaId) {
        try {

            $sql = "UPDATE reservas.contas_empresas SET 
                     situacao_contas_id = 6,
                     tipos_pagamentos_id = 9 
                     WHERE empresas_id = {$empresaId};";

            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    public function empresasProprietario( $hash ){
        try {
            
            $sql = "SELECT 
                            Empresa.id AS empresas_id,
                            Empresa.pessoas_id,
                            Juridica.id AS juridica_id,
                            Empresa.created,
                            SitEmp.nome as status,
                            Juridica.cnpj,
                            Juridica.razao,
                            Empresa.logo,
                            Juridica.nome_fantasia
                        FROM
                            reservas.empresas AS Empresa
                                INNER JOIN
                            reservas.pessoaJuridica AS Juridica ON Juridica.id = Empresa.pessoaJuridica_id
                                INNER JOIN
                            reservas.situacao_empresas AS SitEmp ON SitEmp.id = Empresa.situacao_empresas_id
                        WHERE
                            MD5(Empresa.pessoas_id) = '{$hash}';";
                            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function proprietario( $hash ){
        try {
            $sql = "SELECT 
                        Empresa.pessoas_id
                    FROM
                        reservas.pessoas AS Pessoa
                            INNER JOIN
                        reservas.funcionarios AS Funcionario ON Pessoa.id = Funcionario.pessoas_id
                            INNER JOIN
                        reservas.empresas AS Empresa ON Empresa.id = Funcionario.empresas_id
                    WHERE
                        MD5(Pessoa.id) = '{$hash}';";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function empresasRelacionadas($hash, $rolesId ) {
        try {
            
            if( $rolesId == 4 ){                
            
                return $this->empresasProprietario($hash);
                            
            } else {
                $gerenteId = $this->proprietario($hash);
                return $this->empresasProprietario( md5($gerenteId[0]['pessoas_id']) );
            }

            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function findEmpresa( $empresasId ){
        try {
            
            $sql = "SELECT 
                        Juridica.pessoas_id,
                        Juridica.id as juridicas_id,
                        Empresa.id as empresas_id,
                        Juridica.cnpj,
                        Juridica.razao,
                        Juridica.nome_fantasia,
                        Juridica.ie,
                        Juridica.data_fundacao,
                        Empresa.situacao_empresas_id,
                        Empresa.status,
                        Empresa.logo,
                        Empresa.created
                    FROM
                        reservas.pessoaJuridica AS Juridica
                            INNER JOIN
                        reservas.empresas AS Empresa ON Empresa.pessoaJuridica_id = Juridica.id
                    WHERE
                        Empresa.id = $empresasId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    
    
}
