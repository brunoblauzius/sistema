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
    
    private $nome = null;
    private $cidade = null;
    private $lat = null;
    private $long = null;
    
    public $useTable = 'empresas';
    public $name = 'Empresa';
    public $primaryKey = 'id';
    
    public function getNome() {
        return $this->nome;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getLat() {
        return $this->lat;
    }

    public function getLong() {
        return $this->long;
    }

    public function setNome($nome) {
        if( !empty($nome) ){
            $this->nome = " AND nome_fantasia like '%{$nome}%' ";
        }
        return $this;
    }

    public function setCidade($cidade) {
         
        if( !empty($cidade) ){
            $this->cidade = " AND cidade = '{$cidade}' ";
        }
        return $this;
    }

    public function setLat($lat) {
        if( !empty($lat) ){
            $this->cidade = NULL;
            $this->nome = NULL;
            $this->lat = " AND lat = {$lat} ";
        }
        return $this;
    }

    public function setLong($long) {
        if( !empty($long) ){
                $this->cidade = NULL;
                $this->nome = NULL;
                $this->long = " AND  long = {$long}";
            }
        return $this;
    }

    
        
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
    
    public $validate_site = array(
        'cep' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'logradouro' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'bairro' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'cidade' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'uf' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'numero' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'nome_fantasia' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
    );
    
    public $validate_primeiras_config = array(

        'quantidade' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
            'numerico' => array(
                'rule' => array('numerico'),
                'mensagem' => 'Digite apenas números',
            ),
            'maiorQue' => array(
                'rule' => array('maiorQue', 50),
                'mensagem' => 'Limite de mesas permitido é 50!',
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

    
    public function alterarContaEmpresa( $empresaId, $tiposPagamentosId, $situacaoContasId, $contasEmpresasTiposId ){
        try {
            
            $sql = "UPDATE reservas.contas_empresas SET 
                            situacao_contas_id = $situacaoContasId,
                            tipos_pagamentos_id = $tiposPagamentosId,
                            contas_empresas_tipos_id = $contasEmpresasTiposId
                        WHERE empresas_id = $empresaId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function alterarSituacaoEmpresa( $empresaId,  $situacaoEmpresaId ){
        try {
            
            $sql = "UPDATE reservas.empresas SET 
                            situacao_empresas_id = $situacaoEmpresaId
                        WHERE id = $empresaId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    
    public function contaEmpresa( $hash ){
        try {
            
            $sql = "SELECT 
                    Conta.*,
                    SituacaoConta.nome as situacao_conta,
                    SituacaoConta.id as situacao_contas_id,
                    TipoPagamento.nome as tipo_pagamento,
                    TipoPagamento.id as tipos_pagamentos_id,
                    TipoConta.nome as tipo_conta,
                    TipoConta.id as contas_empresas_tipos_id,
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
                        SituacaoEmpresa.nome as situacao_empresas,
                        Empresa.status,
                        Empresa.logo,
                        Empresa.envio_outlook,
                        Empresa.envio_sistema,
                        Empresa.created
                    FROM
                        reservas.pessoaJuridica AS Juridica
                            INNER JOIN
                        reservas.empresas AS Empresa ON Empresa.pessoaJuridica_id = Juridica.id
                            INNER JOIN
                        reservas.situacao_empresas AS SituacaoEmpresa ON Empresa.situacao_empresas_id = SituacaoEmpresa.id
                    WHERE
                        Empresa.id = $empresasId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function contatosEmpresa($empresasId ){
        try {
            
            $sql = "SELECT 
                        id,
                        telefone,
                        tipo
                    FROM
                        contatos AS Contato
                            INNER JOIN
                        empresas_has_contatos AS EmpresaContato ON EmpresaContato.contatos_id = Contato.id
                    WHERE
                        EmpresaContato.empresas_id = $empresasId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function listEmpresas(){
        try {
            
            $telefone = new Contato();
            
            $registros = $this->query('SELECT * FROM vw_empresas_sistema WHERE status = 1 '. $this->cidade . $this->nome . $this->lat . $this->long);
            
             $i = 0;
            foreach ($registros as $registro) {
                $registros[$i] = array_merge($registro, array('telefones' => $telefone->findEmpresasContatos($registro['id'])));
                $i++;
            }
            
            return $registros;
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
