<?php

class Endereco extends AppModel {

    public $useTable = 'enderecos';
    public $name = 'Endereco';
    public $primaryKey = 'id';
    public $validate = array(
        'cep' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'logradouro' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'cidade' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'bairro' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'uf' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'numero' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
    );

    public function findEndereco($idPessoa) {

        try {
            $objeto = NULL;
            $sql = "SELECT 
                        Endereco.id,
                        Endereco.cep,
                        Endereco.logradouro,
                        Endereco.bairro,
                        Endereco.cidade,
                        Endereco.uf,
                        Endereco.numero
                        FROM enderecos as Endereco
                    WHERE Endereco.pessoas_id = {$idPessoa};";

            $registro = $this->query($sql);

            foreach ($registro as $valor) {
                $objeto[] = new Enderecos($valor['id'], $valor['pessoas_id'], $valor['cep'], $valor['logradouro'], $valor['bairro'], $valor['cidade'], $valor['uf'], $valor['numero']);
            }

            if (count($objeto) == 1) {
                $objeto = $objeto[0];
            }
            if (count($objeto) == 0) {
                $objeto = new Enderecos();
            }
            return $objeto;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function inserirEnderecosEmpresa($empresaId, array $enderecos) {
        try {
            
            $enderecosId = null;

            if (!empty($empresaId)) {

                $enderecosId = $this->genericInsert($enderecos);

                $this->useTable = 'enderecos_has_empresas';
                $this->genericInsert(array(
                    'enderecos_id' => $enderecosId,
                    'empresas_id' => $empresaId,
                ));
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function inserirEnderecosPessoa($pessoaId, array $enderecos) {
        $enderecosId = null;

        if (!empty($pessoaId)) {

            $enderecosId = $this->genericInsert($enderecos);

            $this->useTable = 'enderecos_has_pessoas';

            $this->genericInsert(array(
                'enderecos_id' => $enderecosId,
                'pessoas_id' => $pessoaId,
            ));
        }
    }

    public function findEnderecosEmpresa($empresaId) {
        try {

            $retorno = array();

            if (!empty($empresaId)) {
                $sql = "SELECT 
                        EndEmp.enderecos_id,
                        Endereco.cep,
                        Endereco.logradouro,
                        Endereco.bairro,
                        Endereco.cidade,
                        Endereco.uf,
                        Endereco.numero
                    FROM
                        reservas.enderecos AS Endereco
                            INNER JOIN
                        reservas.enderecos_has_empresas AS EndEmp ON EndEmp.enderecos_id = Endereco.id
                            INNER JOIN
                        reservas.empresas AS Empresa ON EndEmp.empresas_id = Empresa.id
                        where Empresa.id = $empresaId;";

                $retorno = $this->query($sql);
            }
            return $retorno;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function findEnderecosPessoa($pessoasId) {
        try {

            $retorno = array();

            if (!empty($pessoasId)) {
                $sql = "SELECT 
                        Endereco.id,
                        Endereco.cep,
                        Endereco.logradouro,
                        Endereco.bairro,
                        Endereco.cidade,
                        Endereco.uf,
                        Endereco.numero
                    FROM
                        reservas.enderecos_has_pessoas AS PessoaEndereco
                            INNER JOIN
                        reservas.enderecos AS Endereco ON Endereco.id = PessoaEndereco.enderecos_id
                    WHERE
                        (PessoaEndereco.pessoas_id) = $pessoasId;";
                $retorno = $this->query($sql);
            }
            return $retorno;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
