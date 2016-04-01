<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PessoasController
 *
 * @author blauzius
 */
class PessoasController extends AppController {

    public $ClasseAllow = array('cadastroSite');
    private $Pessoa = null;
    private $Fisica = null;
    private $Usuario = null;
    private $Contato = null;
    private $Email = null;

    public function __construct() {

        parent::__construct();
        $this->Pessoa = new Pessoa();
        $this->Fisica = new Fisica();
        $this->Usuario = new Usuario();
        $this->Contato = new Contato();
        $this->Email = new Email();
    }

    public function index() {
        try {

            $this->layout = 'painel';
            /**
             * recuperar dados da empresa
             */
            $proprietarios = $this->Pessoa->proprietarioEmpresas();



            $this->set('title_layout', 'Proprietários de Empresas');
            $this->set('proprietarios', $proprietarios);
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function cadastro() {
        try {

            $this->layout = 'painel';
            $this->set('title_layout', 'Cadastro de Empresa');
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function add() {
        try {
            $pessoaId = 0;
            $telefones = $_POST['Contato'];
            $created = date('Y-m-d H:i:s');
            /**
             * RETIRADO CARACTERES INDESEJADOS
             */
            $_POST[$this->Fisica->name]['cpf'] = Utils::returnNumeric($_POST[$this->Fisica->name]['cpf']);

            /**
             * LIMPANDO OS CARACTERES HTML, PHP, CSS, JS
             */
            $_POST = Utils::sanitazeArray($_POST);

            /**
             * criar o metodo marge para fazer o merge dos arrays e a verificação de dados inconsistentes
             */
            $this->Pessoa->data = array_merge($this->Pessoa->data, $_POST[$this->Fisica->name]);
            $this->Pessoa->data = array_merge($this->Pessoa->data, $_POST['Email']);
            $this->Pessoa->data = array_merge($this->Pessoa->data, $_POST[$this->Usuario->name]);


            /**
             * validação dos meus campos para o formulário
             */
            if ($this->Pessoa->validates()) {

                /**
                 * INSERIR PESSOA 
                 */
                $this->Pessoa->useTable = 'pessoas';
                $pessoaId = $this->Pessoa->genericInsert(array(
                    'created' => $created,
                    'tipo_pessoa' => 1,
                ));
                /**
                 * INSERIR PESSOA FISICA
                 */
                $this->Fisica->genericInsert(array(
                    'pessoas_id' => $pessoaId,
                    'nome' => $_POST[$this->Fisica->name]['nome'],
                    'cpf' => $_POST[$this->Fisica->name]['cpf'],
                    'rg' => $_POST[$this->Fisica->name]['rg'],
                ));

                /**
                 * INSERIR USUARIO
                 */
                $userKey = Authentication::uuid();

                $this->Usuario->genericInsert(array(
                    'pessoas_id' => $pessoaId,
                    'roles_id' => 4,
                    'perfil_teste' => 0,
                    'status' => 1,
                    'email' => $_POST['Email']['email'],
                    'login' => $_POST[$this->Usuario->name]['login'],
                    'senha' => Authentication::password($_POST[$this->Usuario->name]['senha']),
                    'chave' => $userKey,
                    'created' => $created,
                ));

                /**
                 * INSERIR CONTATO
                 */
                $this->Contato->inserirContatosPessoa($pessoaId, $telefones);
                /**
                 * INSERIR EMAIL
                 */
                $this->Email->inserirEmailPessoa($pessoaId, $_POST['Email']['email']);


                if ($pessoaId > 0) {
                    //enviar email
                    //                        
//                        #recupero o corpo do meu email para ser cadastrado
//                        $email = new Email();
//                        $registro = $email->find('first', array('tag' => 'cadastro_sucesso'));
//                        #faço a troca de siglas para personalizar o email
//                        $array = array(
//                               '__NOME_REMETENTE__' => $_POST[$this->Fisica->name]['nome'],
//                               '__DATE__' => date('d/m/Y h:i:s'),
//                               '__URL__'  => Router::url(array('Pages', 'ativarConta', $chave)),
//                                );
//                        
//                        #envio o email de confirmação para o meu cliente cadastrado
//                        $objeto = new MailPHPMailer();
//                        $objeto->setAssunto('Cadastro realizado com sucesso!');
//                        $objeto->setRemetente();
//                        $objeto->setDestinatario( $_POST[$this->Pessoa->name]['email'] , $_POST[$this->Pessoa->name]['nome']);
//                        $objeto->setBody( str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']) );
//                        $objeto->sendMail();
//                        
//                        #saida para o usuario

                    $_SESSION['cadastroEmpresa']['pessoas_id'] = $pessoaId;

                    $url = Router::url(array('Empresas', 'cadastro'));
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Seu cadastro foi efetuado com sucesso', '#PessoaAddForm' );"
                        . "redirect('{$url}');",
                    ));
                } else {
                    #caso de erro fazer esse procedimento
                }
            } else {
                echo json_encode(array(
                    'erros' => ($this->Pessoa->validateErros),
                    'form' => $this->Pessoa->name . 'AddForm',
                ));
            }
        } catch (Exception $ex) {
            #em caso de erro fazer esse procedimento
            echo $ex->getMessage();
        }
    }

    public function cadastroSite() {
        try {
            $_POST = Utils::sanitazeArray($_POST);

            $created = date('Y-m-d h:i:s');
            $token = Authentication::uuid();
            $pessoaId = 0;
            $pessoaFidicaId = 0;
            $usuarioId = 0;

            $this->Pessoa->validate = $this->Pessoa->validate_site;

            $this->Pessoa->data = $_POST[$this->Pessoa->name];

            if ($this->Pessoa->validates()) {
                
                /**
                 * criar uma pessoa 
                 */
                $pessoaId = $this->Pessoa->genericInsert(array(
                    'created' => $created,
                    'tipo_pessoa' => 1
                ));
                $this->Pessoa->data['pessoas_id'] = $pessoaId;

                /**
                 * criar contato do usuario
                 */
                $contatoId = $this->Contato->genericInsert(array(
                    'telefone' => $this->Pessoa->data['ddd'] . $this->Pessoa->data['telefone'],
                    'tipo' => 1,
                ));
                /**
                 * Atrelando um contato a uma pessoa
                 */
                $this->Contato->inserirContato($pessoaId, $contatoId);

                /**
                 * inserindo um email a pessoa
                 */
                $this->Email->inserirEmailPessoa($pessoaId, $this->Pessoa->data['email']);

                /**
                 * criar uma Pessoa Fisica
                 */
                $pessoaFidicaId = $this->Fisica->genericInsert(array(
                    'pessoas_id' => $pessoaId,
                    'cpf' => str_pad('00', 11, '0', STR_PAD_RIGHT),
                    'nome' => $this->Pessoa->data['nome']
                ));
                $this->Pessoa->data['pessoaFisica_id'] = $pessoaFidicaId;

                /**
                 * cria um usuario
                 */
                $usuarioId = $this->Usuario->genericInsert(array(
                    'roles_id' => 4,
                    'pessoas_id' => $pessoaId,
                    'status' => 0,
                    'perfil_teste' => 1,
                    'created' => $created,
                    'email' => $this->Pessoa->data['email'],
                    'login' => $this->Pessoa->data['login'],
                    'senha' => Authentication::password($this->Pessoa->data['senha']),
                    'chave' => $token
                ));
                $this->Pessoa->data['usuarios_id'] = $usuarioId;
                $this->Pessoa->data['token']       = $token;

                $_SESSION[$this->Pessoa->name] = $this->Pessoa->data;

                $url = Router::url(array('pages', 'cadastro-estabelecimento'));

                echo json_encode(array(
                    'erro' => false,
                    'mensagem' => '',
                    'funcao' => "msg_sucesso( 'Cadastro realizado com sucesso, aguarde um momento!' , '#CadastroFrom');redirect('{$url}');"
                ));
                    
                    
            } 
            else 
            {
                echo json_encode(array(
                    'erro' => true,
                    'funcao' => "msg_erro( '{$this->Pessoa->refactoryError()}' , '#CadastroFrom');hideLoaderForm('#CadastroFrom');",
                ));
            }
        } catch (Exception $ex) {
            echo json_encode($ex->getTrace());
        }
    }

}
