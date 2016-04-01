<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmpresasController
 *
 * @author bruno.blauzius
 */
class EmpresasController extends AppController {

    //put your code here

    public $ClasseAllow = array('alterarDadosConta', 'cadastroEstabelecimento', 'cadastroPrimeirasConfiguracoes');
    public $Empresa = null;
    private $Juridica = null;
    private $ContaEmpresa = null;
    private $Contato = null;
    private $Endereco = null;
    private $Email = null;
    private $SituacaoEmpresa = null;
    private $SituacaoConta = null;
    private $TiposPagamento = null;
    private $TipoConta = null;

    public function __construct() {
        parent::__construct();
        $this->layout = 'painel';
        $this->Empresa = new Empresa();
        $this->Juridica = new Juridica();
        $this->Contato = new Contato();
        $this->Endereco = new Endereco();
        $this->Email = new Email();
        $this->ContaEmpresa = new ContaEmpresa();
        $this->SituacaoEmpresa = new SituacaoEmpresa();
        $this->SituacaoConta = new SituacaoConta();
        $this->TiposPagamento = new TiposPagamento();
        $this->TipoConta = new TipoConta();
    }

    public function index() {
        try {

            $this->layout = 'painel';
            /**
             * recuperar dados da empresa
             */
            $this->set('title_layout', 'Passo 2: Cadastro de Empresa');
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function empresasRelacionadas() {
        try {

            $this->layout = 'painel';
            /**
             * recuperar dados da empresa
             */
            $pessoa = new Fisica();
            $proprietario = $pessoa->find('first', array('md5(pessoas_id)' => $_GET['param']));
            $proprietario = array_shift($proprietario);

            $empresasRelacionadas = $this->Empresa->empresasRelacionadas($_GET['param'], 4);

            $this->set('title_layout', 'Empresas Relacionadas');
            $this->set('proprietario', $proprietario);
            $this->set('empresas', $empresasRelacionadas);

            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function cadastro() {
        try {

            $this->layout = 'painel';
            /**
             * recuperar dados da empresa
             */
            if ((isset($_GET['param']) && !is_null($_GET['param'])) && (!isset($_SESSION['cadastroEmpresa']['pessoas_id']))) {
                $pessoa = new Fisica();
                $proprietario = $pessoa->find('first', array('md5(pessoas_id)' => $_GET['param']));
                $_SESSION['cadastroEmpresa']['pessoas_id'] = $proprietario[0]['Fisica']['pessoas_id'];
            }

            $this->set('title_layout', 'Cadastro de Empresa');
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function add() {

        $pessoaJuridicaId = 0;
        $empresaId = 0;
        $created = date('Y-m-d H:i:s');
        $telefones = $_POST['Contato'];

        $_POST[$this->Juridica->name]['pessoas_id'] = $_SESSION['cadastroEmpresa']['pessoas_id'];
        $_POST[$this->Juridica->name]['cnpj'] = Utils::returnNumeric($_POST[$this->Juridica->name]['cnpj']);

        $_POST = Utils::sanitazeArray($_POST);


        try {


            $this->Empresa->data = array_merge($this->Empresa->data, $_POST['Juridica']);
            $this->Empresa->data = array_merge($this->Empresa->data, $_POST['Email']);
            $this->Empresa->data = array_merge($this->Empresa->data, $_POST['Endereco']);

            //Utils::pre( $this->Empresa->data );


            if ($this->Empresa->validates()) {
                //exit();
                /**
                 * CADASTRAR PESSOA JURIDICA
                 */
                $pessoaJuridicaId = $this->Juridica->genericInsert($_POST[$this->Juridica->name]);
                /**
                 * CADASTRAR EMPRESA
                 */
                $this->Empresa->useTable = 'empresas';
                $empresaId = $this->Empresa->genericInsert(array(
                    'pessoaJuridica_id' => $pessoaJuridicaId,
                    'pessoas_id' => $_POST[$this->Juridica->name]['pessoas_id'],
                    'created' => $created,
                    'status' => 1,
                    'situacao_empresas_id' => 1,
                ));

                /**
                 * CADASTRAR CONTAS EMPRESAS
                 */
                $this->ContaEmpresa->genericInsert(array(
                    'empresas_id' => $empresaId,
                    'situacao_contas_id' => 1,
                    'contas_empresas_tipos_id' => 1,
                    'tipos_pagamentos_id' => 1,
                    'created' => $created,
                    'expirar' => Utils::adicionaMes(1, $created),
                ));

                /**
                 * CADASTRAR ENDERECOS
                 */
                $this->Endereco->inserirEnderecosEmpresa($empresaId, $_POST[$this->Endereco->name]);

                /**
                 * CADASTRAR CONTATOS
                 */
                $this->Contato->inserirContatosEmpresa($empresaId, $telefones);

                /**
                 * CADASTRAR E-MAILS
                 */
                $this->Email->inserirEmailEmpresa($empresaId, $_POST['Email']['email']);


                $url = Router::url(array('Empresas', 'empresasRelacionadas', md5($_POST[$this->Juridica->name]['pessoas_id'])));

                echo json_encode(array(
                    'funcao' => "sucessoForm( 'Seu cadastro foi efetuado com sucesso', '#PessoaAddForm' );"
                    . "redirect('{$url}');",
                ));
            } else {
                echo json_encode(array(
                    'erros' => ($this->Empresa->validateErros),
                    'form' => $this->Empresa->name . 'AddForm',
                ));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function edit() {
        try {

            print_r($_SESSION);

            $_POST[$this->Empresa->name][$this->Empresa->primaryKey] = Session::read('Empresa.juridicas_id');

            if ($this->Juridica->genericUpdate($_POST[$this->Empresa->name])) {
                $url = Router::url(array('Usuarios', 'configuracoes'));
                echo json_encode(array(
                    'funcao' => "sucessoForm( 'Alteração efetuada com sucesso!', '#EmpresaAddForm' );"
                    . "redirect('{$url}', '" . '#EmpresaAddForm' . "')",
                ));
            }
        } catch (Exception $ex) {
            if ($this->is('post')) {
                echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#EmpresaAddForm' );",
                ));
            } else {
                echo $ex->getMessage();
            }
        }
    }

    public function recuperaEmpresa() {
        try {

            $empresasId = $_POST['empresas_id'];

            $empresa = $this->Empresa->findEmpresa($empresasId);
            $contatos = $this->Empresa->contatosEmpresa($empresasId);
            $contaEmpresa = $this->Empresa->contaEmpresa(md5($empresasId));


            if (count($empresa) > 0) {
                $_SESSION['Empresa'] = $empresa[0];
                $_SESSION['Contato'] = $contatos;
                $_SESSION['ContaEmpresa'] = $contaEmpresa[0];
                if (Session::check('Form')) {
                    $_SESSION['Form'] = NULL;
                    unset($_SESSION['Form']);
                }
            }

            echo json_encode(array('funcao' => "window.location.reload();"));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function contaEmpresa() {
        try {

            $this->css = array_merge($this->css, array(
                'css/bootstrap-switch',
            ));

            $this->js = array_merge($this->js, array(
                'js/bootstrap-switch',
                'js/toggle-init',
            ));

            $contaEmpresa = array();

            $this->layout = 'painel';

            $contaEmpresa = $this->Empresa->contaEmpresa($_GET['param']);

            $_SESSION['Form']['empresas_id'] = $contaEmpresa[0]['empresas_id'];
            $_SESSION['Form']['contas_empresas_id'] = $contaEmpresa[0]['id'];

            $empresa = $this->Empresa->findEmpresa($contaEmpresa[0]['empresas_id']);
            $situacaoEmpresas = $this->SituacaoEmpresa->find('all', array('status' => true));
            $situacaoContas = $this->SituacaoConta->find('all');
            $tiposPagamentos = $this->TiposPagamento->find('all');
            $TipoContas = $this->TipoConta->find('all');
            /**
             * recuperar dados da empresa
             */
            $this->set('title_layout', 'Empresa: situação conta');
            $this->set('contaEmpresa', array_shift($contaEmpresa));
            $this->set('empresa', array_shift($empresa));
            $this->set('situacaoEmpresas', $situacaoEmpresas);
            $this->set('situacaoContas', $situacaoContas);
            $this->set('tiposPagamentos', $tiposPagamentos);
            $this->set('TipoContas', $TipoContas);

            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function totalEmpresas() {
        $empresa = $this->Empresa->empresasRelacionadas(md5($this->pessoas_id), Session::read('Usuario.roles_id'));
        echo json_encode(array(
            'qtde' => count($empresa)
        ));
    }

    public function alterarConta() {
        try {


            if ($this->is('post') || $this->is('put')) {

                $this->Empresa->alterarContaEmpresa($_SESSION['Form']['empresas_id'], $_POST['TiposPagamento']['id'], $_POST['SituacaoConta']['id'], $_POST['TipoConta']['id']);
                $this->Empresa->alterarSituacaoEmpresa($_SESSION['Form']['empresas_id'], $_POST['SituacaoEmpresa']['id']);

                $json = json_encode(array(
                    'message' => 'Sua alteração foi efetuada com sucesso!',
                    "style" => 'success',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => "window.location.reload();",
                    'before' => "$('#loading').fadeOut(500);",
                    'icon' => '',
                    'title' => 'Sucesso!'
                ));

                echo json_encode(array(
                    'funcao' => "bootsAlert( $json );",
                ));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function configEnvioEmail() {
        try {

            $_POST['Empresa']['id'] = $this->empresas_id;

            if (isset($_POST['Empresa']['envio_outlook'])) {
                $_POST['Empresa']['envio_outlook'] = 1;
            } else {
                $_POST['Empresa']['envio_outlook'] = 0;
            }

            if (isset($_POST['Empresa']['envio_sistema'])) {
                $_POST['Empresa']['envio_sistema'] = 1;
            } else {
                $_POST['Empresa']['envio_sistema'] = 0;
            }



            if ($this->Empresa->genericUpdate($_POST['Empresa'])) {

                $empresa = $this->Empresa->findEmpresa($this->empresas_id);

                $_SESSION[$this->Empresa->name] = $empresa[0];

                $json = json_encode(array(
                    'message' => 'Sua alteração foi efetuada com sucesso!',
                    "style" => 'success',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => "window.location.reload();",
                    'before' => "$('#loading').fadeOut(500);",
                    'icon' => '',
                    'title' => 'Sucesso!'
                ));

                echo json_encode(array(
                    'funcao' => "bootsAlert( $json );",
                ));
            }
        } catch (Exception $ex) {

            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" => 'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => null,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => '',
                'title' => 'ERRO'
            ));

            echo json_encode(array(
                'funcao' => "bootsAlert( $json );",
            ));
        }
    }

    public function alterarDadosConta() {
        try {
            $_POST['Conta']['id'] = Session::read('Form.contas_empresas_id');

            if ($this->ContaEmpresa->genericUpdate($_POST['Conta'])) {
                $json = json_encode(array(
                    'message' => 'Sua alteração foi efetuada com sucesso!',
                    "style" => 'success',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => "window.location.reload();",
                    'before' => "$('#loading').fadeOut(500);",
                    'icon' => '',
                    'title' => 'Sucesso!'
                ));
            } else {
                $json = json_encode(array(
                    'message' => 'Houve um erro ao alterar os dados',
                    "style" => 'warning',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => "window.location.reload();",
                    'before' => "$('#loading').fadeOut(500);",
                    'icon' => '',
                    'title' => 'Sucesso!'
                ));
            }

            echo json_encode(array(
                'funcao' => "bootsAlert( $json );",
            ));
        } catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function cadastroEstabelecimento() {
        try {

            $_POST = Utils::sanitazeArray($_POST);
            
            
            $created = date('Y-m-d h:i:s');
            $token = Authentication::uuid();
            $empresaId = 0;
            $contaEmpresa = 0;
            $pessoaJuridica_id = 0;

            $this->Empresa->data = array_merge($this->Empresa->data, $_POST['Empresa']);
            $this->Empresa->data = array_merge($this->Empresa->data, $_POST['Endereco']);

            $this->Empresa->validate = $this->Empresa->validate_site;

            if ($this->Empresa->validates()) {

                $pessoaJuridica_id = $this->Juridica->genericInsert(array(
                    'pessoas_id' => $_SESSION['Pessoa']['pessoas_id'],
                    'cnpj' => str_pad('00', 14, '0', STR_PAD_RIGHT),
                    'razao' => $_POST[$this->Empresa->name]['nome_fantasia'],
                    'nome_fantasia' => $_POST[$this->Empresa->name]['nome_fantasia']
                ));

                /**
                 * Criar uma empresa
                 */
                $empresaId = $this->Empresa->genericInsert(array(
                    'pessoas_id' => $_SESSION['Pessoa']['pessoas_id'],
                    'pessoaJuridica_id' => $pessoaJuridica_id,
                    'situacao_empresas_id' => 1,
                    'created' => $created,
                ));

                /**
                 * criar uma conta para empresa
                 */
                
                $contaEmpresa = $this->ContaEmpresa->inserirContaEmpresa($empresaId);
                
                
                /**
                 * criar um endereco para a empresa
                 */
                $this->Endereco->inserirEnderecosEmpresa($empresaId, $_POST['Endereco']);

                $_SESSION['Empresa'] = $_POST['Empresa'];
                $_SESSION['Empresa']['pessoaJuridica_id'] = $pessoaJuridica_id;
                $_SESSION['Empresa']['empresas_id'] = $empresaId;
                $_SESSION['Endereco'] = $_POST['Endereco'];

                $url = Router::url(array('pages', 'primeiras-configuracoes'));

                echo json_encode(array(
                    'erro' => false,
                    'mensagem' => '',
                    'funcao' => "msg_sucesso( 'Cadastro realizado com sucesso, aguarde um momento!' , '#CadastroFrom');redirect('{$url}');"
                ));
            } else {
                echo json_encode(array(
                    'erro' => true,
                    'funcao' => "msg_erro( '{$this->Empresa->refactoryError()}' , '#CadastroFrom'); hideLoaderForm('#CadastroFrom');",
                ));
            }
        } catch (Exception $ex) {
            echo json_encode($ex->getMessage());
        }
    }

    public function cadastroPrimeirasConfiguracoes() {
        try {
            $salaoId = 0;
            $ambienteId = 0;
            $mesaId = 0;
            $_POST = Utils::sanitazeArray($_POST);

            $this->Empresa->data = array_merge($this->Empresa->data, $_POST['Mesa']);

            $this->Empresa->validate = $this->Empresa->validate_primeiras_config;

            if ($this->Empresa->validates()) {

                $SalaoModel = new Salao();
                $salaoId = $SalaoModel->genericInsert(array(
                    'empresas_id' => Session::read('Empresa.empresas_id'),
                    'nome' => 'Salão - (Teste)',
                    'status' => TRUE,
                ));

                $AmbienteModel = new Ambiente();
                $ambienteId = $AmbienteModel->genericInsert(array(
                    'saloes_id' => (int) $salaoId,
                    'empresas_id' => (int) Session::read('Empresa.empresas_id'),
                    'nome' => 'Ambiente - (Teste)',
                    'capacidade' => (int) $_POST['Mesa']['quantidade'] * 2,
                    'status' => TRUE,
                ));

                /**
                 * criar um metodo que gerer mesas apartir de um inteiro
                 */
                $MesaModel = new Mesa();
                $MesaModel->inserirMesasCadastroSite((int) Session::read('Empresa.empresas_id'), $_POST['Mesa']['quantidade'], (int) $ambienteId);
                
                $_SESSION = array_merge($_SESSION, $_POST);

                /**
                 * envio de email ao terminar
                 */
                
                $parameters = array(
                    'destinatario'      =>  $_SESSION['Pessoa']['email'],
                    'nome_destinatario' =>  $_SESSION['Pessoa']['nome'],
                    'assunto'           =>  'Cadastro de empresa - my night',
                    'layout'            =>  'email_cadastro',
                );
        
                $parameters = array_merge($parameters,$_SESSION['Pessoa'] );
                $parameters = array_merge($parameters,$_SESSION['Empresa'] );
                $parameters = array_merge($parameters,$_SESSION['Endereco'] );

                CurlStatic::send($parameters, 'json', Enum::URL_SERVIDOR_DE_EMAIL , 'POST');
                
                echo json_encode(array(
                    'erro' => false,
                    'mensagem' => 'Seu cadastro foi realizado com sucesso, enviamos um e-mail com os dados agora é só se logar e experimentar o software!',
                    'div' => '#PrimeiroCadastroForm',
                ));
                
            } else {

                echo json_encode(array(
                    'erro' => true,
                    'mensagem' => $this->Empresa->refactoryError($this->Empresa->validateErros),
                    'div' => '#PrimeiroCadastroForm',
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erro' => true,
                'mensagem' => $ex->getMessage(),
                'div' => '#PrimeiroCadastroForm',
            ));
        }
    }

}
