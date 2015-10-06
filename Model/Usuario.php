<?php

/**
 * Description of UsersController
 *
 */
class Usuario extends AppModel {

    public $useTable = 'usuarios';
    public $primaryKey = 'id';
    public $name = 'Usuario';
    public $data = null;
    public $validate = array(
        'role' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => 'Digite um e-mail válido'
            ),
        ),
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        ),
        'cpf' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'verificaCpf' => array(
                'rule' => array('verificaCpf'),
                'mensagem' => 'Já possui usuário cadastrado com esse CPF ou DMV'
            ),
        ),
        'dataNascimento' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'checkDate' => array(
                'rule' => array('checkDate'),
                'mensagem' => 'Data no formato temporal invalido! revise o dia (01 a 31) ou o mês (01 a 12)'
            ),
        ),
        'senha' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'minLenght' => array(
                'rule' => array('minLenght', 6),
                'mensagem' => 'Este campo deve conter no minimo 6 digitos'
            ),
            'equalsPassword' => array(
                'rule' => array('equalsPassword'),
                'mensagem' => 'Senha e confirmação de senha não conferem!'
            ),
        ),
        'confirm_senha' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'minLenght' => array(
                'rule' => array('minLenght', 6),
                'mensagem' => 'Este campo deve conter no minimo 6 digitos'
            ),
        ),
        'code' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'validaCaptcha' => array(
                'rule' => array('validaCaptcha'),
                'mensagem' => 'captcha está incorreto!'
            ),
        ),
    );
    public $validate_login = array(
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
        //'email' => array(
        //    'rule' => array('email'),
        //    'mensagem' => 'Digite um e-mail válido'
        // ),
        ),
        'senha' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'minLenght' => array(
                'rule' => array('minLenght', 6),
                'mensagem' => 'Este campo deve conter no minimo 6 digitos'
            ),
        ),
    );
    public $validate_alteraSenha = array(
        'confirm_senha' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'minLenght' => array(
                'rule' => array('minLenght', 6),
                'mensagem' => 'Este campo deve conter no minimo 6 digitos'
            ),
        ),
        'senha' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'minLenght' => array(
                'rule' => array('minLenght', 6),
                'mensagem' => 'Este campo deve conter no minimo 6 digitos'
            ),
            'equalsPassword' => array(
                'rule' => array('equalsPassword'),
                'mensagem' => 'Senha e Confirmação de senha não conferem'
            ),
        ),
    );
    public $validate_request = array(
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => 'Este campo é requirido'
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => 'Digite um e-mail válido'
            ),
        ),
    );

    public function verificaEmail($email) {
        try {
            $verificaMail = $this->find('all', array('email' => $email));
            $verificaMail = array_shift($verificaMail);
            if (count($verificaMail) > 0) {
                throw new Exception(json_encode(array('email' => 'Este e-mail já foi cadastrado em nosso sistema')));
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function verificaCpf($cpf) {
        $verificaCPF = $this->find('all', array('cpf' => $cpf));
        $verificaCPF = array_shift($verificaCPF);
        return ( count($verificaCPF) > 0 );
    }

    public function ativaConta($chave) {
        try {

            $sql = "update $this->useTable set status = 1 where chave = '{$chave}';";
            $retorno = $this->query($sql);
            return $retorno;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function logar($login, $senha) {
        try {

            /**
             * recupero meu usuario 
             */
            $sql = "SELECT 
                        Usuario.roles_id,
                        Usuario.id AS usuarios_id,
                        Fisica.pessoas_id,
                        Fisica.id AS fisicas_id,
                        Usuario.status,
                        Usuario.perfil_teste,
                        Usuario.created,
                        Usuario.email,
                        Pessoa.tipo_pessoa,
                        upper(Fisica.nome) as nome,
                        Fisica.cpf,
                        Fisica.rg,
                        Fisica.data_nascimento,
                        Usuario.chave,
                        Usuario.login,
                        upper(Role.nome) as nivel_usuario,
                        Usuario.imagem_perfil
                    FROM
                        reservas.usuarios AS Usuario
                            INNER JOIN
                        reservas.pessoaFisica AS Fisica ON Usuario.pessoas_id = Fisica.pessoas_id
                            INNER JOIN
                        reservas.pessoas AS Pessoa ON Usuario.pessoas_id = Pessoa.id
                            INNER JOIN
                        reservas.roles as Role ON Usuario.roles_id = Role.id
                    WHERE
                        login = '{$login}' AND senha = '{$senha}';";
            $retorno = $this->query($sql);
            
            if( empty($retorno) ){
                throw new Exception('Usuário e senha não conferem!', 002);
            }
             else if (!$retorno[0]['status']) {
                throw new Exception('Usuário se encontra inativo no momento, caso não tenha recebido o e-mail para ativar sua conta, envie um e-mail para o suporte!', 002);
            }

            return $retorno[0];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function verificaContaTeste($email, $senha) {
        try {
            #15 é a quantidade de dias que o perfil teste fica valido
            $sql = " call sp_verifica_cadatro_teste( '$email', '{$senha}', 15 ); ";
            $retorno = $this->call($sql);
            return $retorno['vRetorno'];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function usuariosEmpresa($empresaId, $pessoaId = null) {
        try {
            $condicao = null;
            if (!is_null($pessoaId)) {
                $condicao = " AND Pessoa.id = {$pessoaId} ";
            }

            $sql = "SELECT 
                            Pessoa.id, UPPER(Fisica.nome) as nome, Usuario.roles_id
                    FROM
                            usuarios AS Usuario
                                    INNER JOIN
                            pessoas AS Pessoa ON Pessoa.id = Usuario.pessoas_id
                                INNER JOIN
                            pessoaFisica AS Fisica ON Fisica.pessoas_id = Usuario.pessoas_id
                                    LEFT JOIN
                            empresas AS Empresa ON Empresa.pessoas_id = Pessoa.id
                                    LEFT JOIN
                            funcionarios AS Funcionario ON Funcionario.pessoas_id = Pessoa.id
                    WHERE
                            ( Empresa.id = {$empresaId} OR Funcionario.empresas_id = {$empresaId} ) " . $condicao .
                    " ORDER BY Fisica.nome ASC";

            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function alteraHashSenha($email, $hash) {
        try {
            $sql = "UPDATE 
                        {$this->useTable}
                    SET
                        chave = '{$hash}'
                    WHERE
                        email = '{$email}'";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function alterarSenha($senha, $hash) {
        try {
            $sql = "UPDATE 
                        {$this->useTable}
                    SET
                        senha = '{$senha}'
                    WHERE
                        chave = '{$hash}'";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function verificaHash($hash) {
        try {
            $sql = "SELECT 
                        count(*) as count
                    FROM	
                            {$this->useTable}
                    WHERE 
                        chave = '{$hash}'";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public final function gravaFoto($nome, $empresas_id) {
        try {
            $sql = "UPDATE 
                    empresas SET
                        logo = '{$nome}'
                    WHERE 
                        id = {$empresas_id};";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public final function gravaFotoUsuario($nome, $pessoaId) {
        try {
            $sql = "UPDATE reservas.usuarios 
                    SET
                        imagem_perfil = '{$nome}'
                    WHERE 
                        pessoas_id = {$pessoaId};";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
