<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FuncionariosController
 *
 * @author blauzius
 */
class FuncionariosController extends AppController{

    //put your code here
    
    private $Grupo;
    private $Pessoa;
    private $Funcionario;
    private $Endereco;
    private $Contato;
    private $Fisica;
    private $Usuario;
    private $Email;
    
    public function __construct() {
        parent::__construct();
        $this->layout = 'painel';
        $this->Grupo  = new Grupo();
        $this->Pessoa = new Pessoa();
        $this->Funcionario = new Funcionario();
        $this->Endereco = new Endereco();
        $this->Contato = new Contato();
        $this->Fisica = new Fisica();
        $this->Usuario = new Usuario();
        $this->Email = new Email();
    }
    
    public function index() {
        try{
            $this->checaEmpresa();
            //$this->verificaContaEmpresa();
            $objeto = array();
            $funcionarios = array();
            $funcionarios = $this->Funcionario->funcionariosEmpresa( $this->empresas_id );
            
            $this->set('usuarios', $funcionarios );
            $this->set('title_layout', 'Funcionários: Lista de Funcionários ' . Session::read('Empresa.nome_fantasia') );
            $this->render();
        
        } catch (BusinessException $buEx) {
            
            $this->set( 'mensagem', $buEx->getMessage() );
            die( $this->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
            
        } catch (Exception $ex) {
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    public function editar() {
        try{
            $this->checaEmpresa();
            //$this->verificaContaEmpresa();
            
            $listGrupo = NULL;
            $grupos = $this->Grupo->findGrupolistFuncionario(array(1,4,5));
            
            /**
             * verificar as informações do funcionario pelo id da pessoa
             */
            
            $pessoa = $this->Funcionario->findFuncionarios($this->empresas_id, $_GET['param']);
            
            /**
             * enderecos relacionado a pessoa
             */
            $endereco = $this->Endereco->findEnderecosPessoa($pessoa[0]['pessoas_id']);
            
            /**
             * contatos relacionados a pessoa
             */
            $contatos = $this->Contato->findPessoaContatos($pessoa[0]['pessoas_id']);
            
            //Utils::pre($endereco);
            foreach ($grupos as $grupo) {
                $listGrupo[] = new GrupoEntity($grupo['id'], $grupo['nome'], NULL);
            }
            
            $_SESSION['Form']['pessoas_id']   = $pessoa[0]['pessoas_id'];
            $_SESSION['Form']['users_id']     = $pessoa[0]['users_id'];
            $_SESSION['Form']['fisicas_id']   = $pessoa[0]['fisicas_id'];
            $_SESSION['Form']['enderecos_id'] = $endereco[0]['id'];
            
            
            
            
            $this->set('title_layout', 'Editar funcionário');
            $this->set('grupos', $listGrupo);
            $this->set('endereco', $endereco[0]);
            $this->set('funcionario', $pessoa[0]);
            $this->set('contatos', $contatos);
            
            $this->render();
            
        } catch (BusinessException $buEx) {
            
            $this->set( 'mensagem', $buEx->getMessage() );
            die( $this->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
            
        } catch( Exception $ex ){
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    public function cadastro() {
        try{
            $this->checaEmpresa();
            //$this->verificaContaEmpresa();
            
            $listGrupo = NULL;
            /**
             * verifico o nivel do usuario para que ele possa escolher quais os outros niveis de usuario ele possa cadastrar abaixo do dele
             */
            if( Session::read('Usuario.roles_id') == 4 ){
                $grupos = $this->Grupo->findGrupolistFuncionario(array(1,4,5));
            } else if( Session::read('Usuario.roles_id') == 3 ){
                $grupos = $this->Grupo->findGrupolistFuncionario(array(1,4,3,5));
            }
            
            foreach ($grupos as $grupo) {
                $listGrupo[] = new GrupoEntity($grupo['id'], $grupo['nome'], NULL);
            }
            
            $this->set('title_layout', 'Cadastro de Funcionário');
            $this->set('grupos', $listGrupo);
            $this->render();
        } catch (BusinessException $buEx) {
            
            $this->set( 'mensagem', $buEx->getMessage() );
            die( $this->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
            
        } catch( Exception $ex ){
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    public function add() {
        try{
            
            $pessoaId   = 0;
            $telefones  = $_POST['Contato'];
            $created    = date('Y-m-d H:i:s');
            
            $_POST[$this->Fisica->name]['cpf'] = Utils::returnNumeric($_POST[$this->Fisica->name]['cpf']);
            $_POST[$this->Endereco->name]['cep'] = Utils::returnNumeric($_POST[$this->Endereco->name]['cep']);
            
            
            $_POST = Utils::sanitazeArray($_POST);
            
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Endereco']);
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Fisica']);
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Usuario']);
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Email']);
            
            
//            Utils::pre($_POST);
            
            
            
	    if( $this->Funcionario->validates() ) {
                
                /**
                 * Pessoa
                 */
                $this->Pessoa->useTable = 'pessoas';
                $pessoaId = $this->Pessoa->genericInsert( array( 
                        'created'     => $created,
                        'tipo_pessoa' => 1,
                    ));
                
                /**
                 * INSERIR PESSOA FISICA
                 */
                $this->Fisica->genericInsert(array(
                    'pessoas_id' => $pessoaId,
                    'nome'       => $_POST[$this->Fisica->name]['nome'],
                    'cpf'        => $_POST[$this->Fisica->name]['cpf'],
                    'rg'         => $_POST[$this->Fisica->name]['rg'],
                ));
                
                
                /**
                 * Funcionario
                 */
                $this->Funcionario->useTable = 'funcionarios';
                $this->Funcionario->genericInsert(array(
                    'pessoas_id'      => $pessoaId,
                    'empresas_id'     => $this->empresas_id,
                ));
                
                
                 /**
                 * INSERIR USUARIO
                 */
                $userKey = Authentication::uuid();
                
                $this->Usuario->genericInsert(array(
                    'pessoas_id'      => $pessoaId,
                    'roles_id'        => $_POST[$this->Usuario->name]['roles_id'],
                    'perfil_teste'    => 0,
                    'status'          => 1,
                    'email'           => $_POST['Email']['email'],
                    'login'           => $_POST[$this->Usuario->name]['login'],
                    'senha'           => Authentication::password($_POST[$this->Usuario->name]['senha']),
                    'chave'           => $userKey,
                    'created'         => $created,
                ));
                
                /**
                 * Endereco
                 */
                $this->Endereco->inserirEnderecosPessoa($pessoaId, $_POST['Endereco']);
                /**
                 * INSERIR CONTATO
                 */
                $this->Contato->inserirContatosPessoa($pessoaId, $telefones);
                /**
                 * INSERIR EMAIL
                 */
                $this->Email->inserirEmailPessoa($pessoaId, $_POST['Email']['email']);
                
                if(  $pessoaId > 0 ) {
                                            
                    $url = Router::url(array('Funcionarios', 'index'));
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Seu cadastro foi efetuado com sucesso', '#FuncionarioAddForm' );"
                                  . "redirect('{$url}');",
                    ));
                        
                } else {
                    #caso de erro fazer esse procedimento
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Funcionario->validateErros),
                    'form'  => $this->Funcionario->name . 'AddForm',
                ));
            }
            
        } catch (SystemException $ex) {
            echo $ex->getErrorJson('#FuncionarioAddForm');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function edit() {
        try{
            
            $pessoaId   = 0;
            $telefones  = $_POST['Contato'];
            $created    = date('Y-m-d H:i:s');
            
            //Utils::pre($_SESSION); return;
            $_POST[$this->Fisica->name]['cpf'] = Utils::returnNumeric($_POST[$this->Fisica->name]['cpf']);
            $_POST[$this->Endereco->name]['cep'] = Utils::returnNumeric($_POST[$this->Endereco->name]['cep']);
            
            
            $_POST = Utils::sanitazeArray($_POST);
            
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Endereco']);
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Fisica']);
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Usuario']);
            $this->Funcionario->data = array_merge($this->Funcionario->data, $_POST['Email']);
            
            
                        
            if( $this->Funcionario->validates() ) {
		
                /**
                 * INSERIR PESSOA FISICA
                 */
                $this->Fisica->genericUpdate(array(
                    'id'         => $_SESSION['Form']['fisicas_id'],
                    'nome'       => $_POST[$this->Fisica->name]['nome'],
                    'cpf'        => $_POST[$this->Fisica->name]['cpf'],
                    'rg'         => $_POST[$this->Fisica->name]['rg'],
                ));
                
                /**
                 * UPDATE USUARIOS
                 */
                $this->Usuario->genericUpdate(array(
                    'roles_id'        => $_POST[$this->Usuario->name]['roles_id'],
                    'email'           => $_POST['Email']['email'],
                    'id'              => $_SESSION['Form']['users_id'],
                ));
                
                
                /**
                 * UPDATE ENDERECO
                 */
                if( empty($_SESSION['Form']['enderecos_id']) ) {
                    $this->Endereco->inserirEnderecosPessoa($_SESSION['Form']['pessoas_id'], $_POST['Endereco']);
                } else {
                    $_POST['Endereco']['id'] = $_SESSION['Form']['enderecos_id'];
                    $this->Endereco->genericUpdate($_POST['Endereco']);
                }
                
                /**
                 * CONTATO
                 */
                $this->Contato->AlterarContatosPessoa( $_SESSION['Form']['pessoas_id'], $telefones );
                
                
                /**
                 * Alterar email
                 */
                $this->Email->alterarEmailPessoas($_SESSION['Form']['pessoas_id'], $_POST['Email']['email']);
                
                
                $url = Router::url(array('Funcionarios', 'index'));
                echo json_encode(array(
                      'funcao' => "sucessoForm( 'Sua Alteração foi efetuada com sucesso', '#FuncionarioAddForm' );"
                                . "redirect('{$url}');",
                ));          
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Funcionario->validateErros),
                    'form'  => $this->Funcionario->name . 'AddForm',
                ));
            }
            
            
            
            
        } catch (SystemException $ex) {
            echo json_encode(array(
                'funcao' => "infoErro('". $ex->getMessage() ."', '#FuncionarioAddForm');",
            ));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
      
    
}