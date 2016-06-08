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
//        'telefone' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                'mensagem' => Enum::VAZIO
//            ),
//            'verificaTelefone' => array(
//                'rule' => array('verificaTelefone'),
//                'mensagem' => 'Já cadastrado para esta empresa favor utilizar outro!'
//            ),
//        ),
//        'rg' => array(
//            'verificaRG' => array(
//                'rule' => array('verificaRG'),
//                'mensagem' => 'Já cadastrado para esta empresa favor utilizar outro!'
//            ),
//        ),
//        'email' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                'mensagem' => Enum::VAZIO
//            ),
//            'verificaEmail' => array(
//                'rule' => array('verificaEmail'),
//                'mensagem' => 'Já cadastrado para esta empresa favor utilizar outro!'
//            ),
//            'email' => array(
//                'rule' => array('email'),
//                'mensagem' => Enum::EMAIL_INVALIDO
//            ),
//        ),
    );
    
    public $validate_convidados = array(
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
        ),
        /*'rg' => array(
			'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
            //'verificaRG' => array(
            //    'rule' => array('verificaRG'),
            //    'mensagem' => 'Já cadastrado para esta empresa favor utilizar outro!'
            //),
        ),*/
//        'email' => array(
//            'notEmpty' => array(
//                'rule' => array('notEmpty'),
//                'mensagem' => Enum::VAZIO
//            ),
//            'email' => array(
//                'rule' => array('email'),
//                'mensagem' => Enum::EMAIL_INVALIDO
//            ),
//        ),
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
        
        if ( $roleId < 4 || $roleId == 6 ){
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
                    Cliente.clientes_id AS id,
                    Cliente.nome,
                    Cliente.sexo,
                    Cliente.status,
                    Cliente.email,
                    Cliente.telefone,
                    Cliente.rg,
                    Juridica.nome_fantasia,
                    Cliente.data_nascimento
                FROM
                    vw_clientes AS Cliente
                        INNER JOIN
                    clientes_empresas AS CliEmp ON CliEmp.clientes_id = Cliente.clientes_id
                        INNER JOIN
                    empresas AS Empresa ON CliEmp.empresas_id = Empresa.id
                        INNER JOIN
                    pessoaJuridica AS Juridica ON Juridica.id = Empresa.pessoaJuridica_id
                WHERE
                    Empresa.pessoas_id  = $proprietarioId 
                        AND ". $NOME . $TELEFONE . $RG . $EMAIL .";";
        
        return $this->query($sql);
    }
    
    
    public function clientesProprietario( $pessoasId, $roleId ){
        try {
            
            if ( in_array($roleId, array(2,3,6)) ){
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
    
    /**
     * @todo METODO QUE ASSOCIA O CLIENTE A EMPRESA
     * @author BRUNO BLAUZIUS
     * @param Bigint $clientesId
     * @param Bigint $empresasID
     * @return boolean
     * @throws Exception
     */
    public function clientesEmpresas( $clientesId, $empresasID ){
        try {
            
            $sql = "SELECT * FROM clientes_empresas WHERE clientes_id = {$clientesId} AND  empresas_id = {$empresasID} ";
            $registro = $this->query($sql);
            
            if( empty($registro))
            {
                $sql = "INSERT INTO clientes_empresas (clientes_id, empresas_id) VALUES ($clientesId, $empresasID);";
                return $this->query($sql);
            }
            
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    final public function cadastroDeClientes( array $cliente ){
        try {
            if(is_array($cliente)){
                
                /**
                 * verificar se o cliente ja esta cadastrado
                 */
                $sql = "SELECT 
                            *
                        FROM
                            clientes
                        WHERE
                            (email = '{$cliente['email']}')
                                AND (telefone = '{$cliente['telefone']}')
                                OR (rg = '{$cliente['rg']}' AND (rg != '' OR rg != NULL)) LIMIT 1;";
                                
                $totalRegistros = $this->query($sql);
                
                
                if( count($totalRegistros) <= 0 ){
                    /**
                     * CLIENTE NAO EXISTE CADASTRAR CLIENTE
                     */
                                        
                    $clienteId = $this->genericInsert( $cliente );
                    
                    $this->clientesEmpresas($clienteId, $cliente['empresas_id']);
                    
                    
                } else {
                    /**
                     * CLIENTE JA EXISTE ADICIONAR A UMA EMPRESA se ele Ja estiver relacionado retornar uma exception
                     */
                    
                    $clienteId = $totalRegistros[0]['id'];
                    
                    $sql = "select * from clientes_empresas where clientes_id = {$clienteId} and empresas_id = {$cliente['empresas_id']};";
                    
                    $total = $this->query($sql);
                    
                    
                    
                    if( count($total) <= 0 ){
                        $this->clientesEmpresas($clienteId, $cliente['empresas_id']);
                    } 
                }
                
                return $clienteId;
                
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function recuperaCliente( $nome, $telefone ){
        try {
            
            $NOME = null;
            $TELEFONE = null;
            
            if( !empty($telefone)){
                $TELEFONE =  "telefone = '{$telefone}'";
            }
            if( !empty($nome)){
                $NOME =  " AND lower(nome) = lower(CAST(_latin1'{$nome}' AS CHAR CHARACTER SET utf8))";
            }
            
            $sql = "SELECT * FROM vw_clientes WHERE $TELEFONE $NOME;";
            $registro = $this->query($sql);
            return array_shift($registro);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public final function updateClienteSp( ){
        try {
            $vEmpresasId = $this->data['empresas_id'];
            $vPessoasId = $this->data['pessoas_id'];
            $vClientesId = $this->data['id'];
            $vEmail = $this->data['email'];
            $vNome = $this->data['nome'];
            $vCpf = '0000000000';
            $vDt_Nascimento = $this->data['dt_nascimento'];
            $vTelefone = $this->data['telefone'];
            $vSexo = $this->data['sexo'];
            
             $sql = "CALL sp_update_clientes( $vEmpresasId,$vPessoasId,$vClientesId,'{$vEmail}','{$vNome}','{$vCpf}','{$vDt_Nascimento}','{$vTelefone}',{$vSexo});";
             return $this->call($sql);
             
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * @todo metodo que cadastra o cliente com o novo padrao em varias tabelas separadas
     * @author bruno blauizus
     * @param Integer $telefone
     * @param String $nome
     * @param String $mail
     * @param Bigint $empresaId
     * @param Date $dataNascimento
     * @throws Exception
     */
    public function novoCadastro($telefone, $nome, $email, $empresaId, $sexo, $dataNascimento = '0000-00-00', $clienteId = 0) {
        try {

            $sql = "CALL sp_cadastra_clientes({$empresaId}, {$clienteId}, '{$email}', '{$nome}', '{$dataNascimento}', {$telefone}, {$sexo} );";
            return $this->call($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
