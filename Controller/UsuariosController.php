<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 */
class UsuariosController extends AppController {

    
    public $ClasseAllow = array('logout', 'login');
    
    public $User = null;
    public $Pessoa = null;
    public $Endereco = null;
    public $Email = null;
    public $Grupo = null;
    public $Reserva = null;
    public $Fisica = null;
    public $Juridica = null;
    public $Contato = null;
    public $Utils = null;

    public function __construct() {
        parent::__construct();
                
        $this->css = array_merge($this->css, array(
            'js/morris-chart/morris',
        ));
        
        $this->js = array_merge($this->js, array(
            'js/fullcalendar2.0/lib/moment.min',
            'js/fullcalendar2.0/fullcalendar',
            'js/fullcalendar2.0/lang-all',
            'js/datatimepicker2.0/bootstrap-datetimepicker.min',
            'js/morris-chart/morris',
            'js/morris-chart/raphael-min',
        ));
        
        $this->User = new Usuario();
        $this->Pessoa = new Pessoa();
        $this->Endereco = new Endereco();
        $this->Email = new Email();
        $this->Reserva = new Reserva();
        $this->Grupo = new Grupo();
        $this->Fisica = new Fisica();
        $this->Juridica = new Juridica();
        $this->Contato = new Contato();
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que renderiza a pagina inicial para a view
     *
     * 
     * */
    public function index() {
        try {
            $this->layout = 'painel';
            $this->set('title_layout', 'Painel de usuarios no sistema');
            $usuarios = $this->User->find('all', NULL, null, NULL, array('id ASC'));
            $this->set('usuarios', $usuarios);
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que renderiza a pagina de suporte para o usuario
     *
     * 
     * */
    public function suporte() {
        try {
            if ($this->is('post')) {
                $_POST[$this->User->name]['nome'] = Session::read('Usuario.nome');
                $_POST[$this->User->name]['email'] = Session::read('Usuario.email');


                $email = new Email();
                $email->useTable = 'emails_sistema';
                
                $registro = $email->find('first', array('tag' => 'suporte'));

                #faço a troca de siglas para personalizar o email

                $array = array(
                    '__NOME_REMETENTE__' => $_POST[$this->User->name]['nome'],
                    '__DATE__' => date('d/m/Y h:i:s'),
                    '__MSG__' => $_POST[$this->User->name]['mensagem'],
                    '__ASSUNTO__' => $_POST[$this->User->name]['assunto'],
                );



                #envio o email de confirmação para o meu cliente cadastrado

                $objeto = new MailPHPMailer();

                $objeto->setAssunto($_POST[$this->User->name]['assunto']);

                $objeto->setRemetente();

                /**
                 *   TROCAR PARA EMAIL DO SUPORTE
                 */
                $objeto->setDestinatario( $objeto->emailRemetente, 'Suporte: Agentus' );

                /**
                 *   TROCAR PARA EMAIL DO usuario
                 */
                $objeto->setBody(str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']));

                $email = $objeto->sendMail();

                echo json_encode(array(
                    'funcao' => "sucessoForm( 'E-mail enviado com sucesso!', '#UsuarioSuporteForm' );",
                ));
            } else {
                $this->layout = 'painel';
                $this->set('title_layout', 'Suporte: sistema de suporte ao usuário');
                $this->render();
            }
        } catch (Exception $ex) {

            if ($this->is('post')) {
                echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#UsuarioSuporteForm' );",
                ));
            } else {
                echo $ex->getMessage();
            }
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que renderiza a pagina de configurações de usuario para a view
     *
     * 
     * */
    public final function configuracoes() {
        try {
            $this->layout = 'painel';
            
            $this->css = array_merge($this->css, array(
                'css/bootstrap-switch',
            ));

            $this->js = array_merge($this->js, array(
                'js/bootstrap-switch',
                'js/toggle-init',
            ));
            
            
            
            $this->checaEmpresa();
            
            $modelEmpresa  = new Empresa();
            $modelEndereco = new Endereco();
            
            $empresa  = $modelEmpresa->findEmpresa( $this->empresas_id );
            $contatos = $modelEmpresa->contatosEmpresa( $this->empresas_id );
            $endereco = $modelEndereco->findEnderecosEmpresa( $this->empresas_id );
                        
            
            $_SESSION['Form']['enderecos_id'] = $endereco[0]['enderecos_id'];
            
            $this->set('title_layout', 'Painel de configurações do sistema');
            $this->set('empresa', array_shift($empresa));
            $this->set('endereco', array_shift($endereco));
            $this->set('contatos', $contatos);
            $this->render();
        } catch (Exception $ex) {
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que renderiza a pagina do painel para a view
     *
     * 
     * */
    public function painel() {
        try {
            $clientes     = 0;
            $funcionarios = 0;
            
            $this->addJs(array(
                'js/chart-js/Chart',
                'js/chartjs.init',
            ));
            
            $this->layout = 'painel';
            $this->Utils = new Utils();
            $endereco = null;
            if( Session::check('Empresa')){
                $modelCliente = new Cliente();
                $modelFuncionario = new Funcionario();
                
                $clientes = $modelCliente->clientesProprietario($this->pessoas_id, session::read('Usuario.roles_id'));
                $clientes = count($clientes);
                
                $funcionarios = $modelFuncionario->find('all', array('empresas_id' => $this->empresas_id));
                $funcionarios = count($funcionarios);
                $endereco = $this->Endereco->findEnderecosEmpresa( $this->empresas_id );
                $endereco = $endereco[0];
            }
            
            $this->set('title_layout', 'Painel Administrativo');
            $this->set('endereco', $endereco);
            $this->set('clientes', $clientes);
            $this->set('funcionarios', $funcionarios);

            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que renderiza a pagina de edição para a view
     *
     * 
     * */
    public function editar() {
        try {
            
            $pessoa = array();
            
            if (!isset($_GET['param'])) {
                $_SESSION['UserEditForm']['id'] = (int) $this->pessoas_id;
            } else {
                $_SESSION['UserEditForm']['id'] = (int) $_GET['param'];
            }

            if (in_array(Session::read('Usuario.roles_id'), array(3, 2))) {
                $nivelAdmin = $this->Grupo->find('all');
            } else {
                $nivelAdmin = $this->Grupo->find('all', array('id' => Session::read('Usuario.roles_id')));
            }

            /**
             * Recuperar os dados do endereço
             */
            $endereco = $this->Endereco->findEnderecosPessoa( $this->pessoas_id );
            if (!empty($endereco)) {
                $_SESSION['Form']['enderecos_id'] = (int) $endereco[0]['id'];
            }
            
            /**
             * contatos relacionados a pessoa
             */
            $contatos = $this->Contato->findPessoaContatos($this->pessoas_id);
            
            /**
             * recupero o email do usuario na tabela de emails
             */
            $email = $this->Email->emailPessoa($this->pessoas_id);
            
            /**
             * Recuperar os dados do usuario
             */
            $usuario = $this->User->find('first', array('pessoas_id' => (int) $_SESSION['UserEditForm']['id']));

            $this->layout = 'painel';
            $this->set('title_layout', 'Edição de usuarios no sistema');
            $this->set('endereco', $endereco);
            $this->set('contatos', $contatos);
            $this->set('email', $email[0]);
            $this->set('niveis', $nivelAdmin);
            $this->set('usuario', array_shift($usuario));

            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que renderiza a pagina de cadastro para a view
     *
     * 
     * */
    public function cadastro() {
        try {
            $this->layout = 'painel';
            $this->set('title_layout', 'Cadastro de usuarios');
            $nivelAdmin = $this->Grupo->find('all');
            $this->set('niveis', $nivelAdmin);
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza a adiciona e persistencia de dados do usuario no banco de dados
     *
     * 
     * */
    public function add() {
        try {
            $_POST = Utils::sanitazeArray($_POST);
            
            $created = date('Y-m-d h:i:s');
            $_POST[$this->Fisica->name]['cpf'] = Utils::returnNumeric($_POST[$this->Fisica->name]['cpf']);           
            $this->User->data = $_POST[$this->User->name];
            
//            Utils::pre($_POST);            
//            exit();
            
            if ($this->User->validates()) {
                //verifica se o cpf ja foi cadastrado
                
                /**
                 * CADASTRO A PESSOA 
                 */
                $this->Pessoa->useTable = 'pessoas';
                $pessoaId = $this->Pessoa->genericInsert( array( 
                        'created'     => $created,
                        'tipo_pessoa' => 1,
                    ));
                
                /**
                 * CADASTRO A PESSOA FISICA
                 */
                $_POST['Fisica']['pessoas_id']          = $pessoaId;
                $fisicaId = $this->Fisica->genericInsert( $_POST['Fisica'] );
                
                
                /**
                 * CADASTRO O USUARIO
                 */
                unset($_POST[$this->User->name]['confirm_senha']);
                
                
                $this->User->genericInsert(array(
                    'pessoas_id'      => $pessoaId,
                    'roles_id'        => $_POST[$this->User->name]['roles_id'],
                    'perfil_teste'    => 0,
                    'status'          => 1,
                    'email'           => $_POST['Email']['email'],
                    'login'           => $_POST[$this->User->name]['login'],
                    'senha'           => Authentication::password($_POST[$this->User->name]['senha']),
                    'chave'           => Authentication::uuid(),
                    'created'         => $created,
                ));
                
                /**
                 * INSERIR EMAIL
                 */
                $this->Email->inserirEmailPessoa($pessoaId, $_POST['Email']['email']);
                
                
                /**
                 * AVISO DE SUCESSO
                 */
                
                $url = Router::url('Usuarios/index');
                echo json_encode(array(
                    'funcao' => "sucessoForm( 'Usuario cadastrado com sucesso!', '#UsuarioAddForm' );"
                    . "redirect('{$url}', '" . '#UsuarioAddForm' . "')",
                ));
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->User->validateErros),
                    'form' => 'UsuarioAddForm',
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erros' => array($ex->getMessage()),
                'form' => 'UsuarioAddForm',
            ));
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza a edicao e persistencia de dados do usuario no banco de dados
     *
     * 
     * */
    public function edit() {
        try {

            $telefones = $_POST['Contato'];
            
            foreach ($telefones['telefone'] as $tel) {
                $fone[] = Utils::returnNumeric($tel);
            }
            $telefones['telefone'] = $fone;
            
            $senha = null;
            $_POST[$this->Juridica->name]['id']         = Session::read('Usuario.juridicas_id');
            $_POST[$this->Fisica->name]['id']           = Session::read('Usuario.fisicas_id');
            

            if (isset($_SESSION['UserEditForm'])) {
                $_POST[$this->User->name]['id'] = (int) $_SESSION['UserEditForm']['id'];
                unset($_SESSION['UserEditForm']);
            }



            if (isset( $_SESSION['Form']['enderecos_id'] )) {
                $_POST[$this->Endereco->name]['id'] = $_SESSION['Form']['enderecos_id'];
            }

            
            //Utils::pre($_SESSION); exit();

            $this->Pessoa->data = $_POST[$this->Pessoa->name];
            $this->Endereco->data = $_POST[$this->Endereco->name];
            $this->Juridica->data = $_POST[$this->Juridica->name];
            $this->Fisica->data = $_POST[$this->Fisica->name];
            $this->Contato->data = $_POST[$this->Contato->name];

            //print_r($this->Contato->data );exit;

            if ($this->User->validates()) {


                $_POST = Utils::sanitazeArray($_POST);


                if (isset($_POST[$this->User->name]['senha'])) {
                    unset($_POST[$this->User->name]['confirm_senha']);
                    $_POST[$this->User->name]['senha'] = $senha;
                }

                /**
                 * CONTATO
                 */
                $this->Contato->AlterarContatosPessoa( $this->pessoas_id, $telefones );

                /**
                 * FISICA
                 */
                $this->Fisica->genericUpdate($this->Fisica->data);
                
                /**
                 * Emails editar
                 */
                
                $this->Email->alterarEmailPessoas( $this->pessoas_id, $_POST['Email']['email'] );
                
                
                if (isset($this->Endereco->data['id'])) {
                    $this->Endereco->genericUpdate($this->Endereco->data);
                } else {
                    $this->Endereco->genericInsert($this->Endereco->data);
                }

                $_SESSION['Usuario']['nome'] = $_POST['Fisica']['nome'];
                $_SESSION['Usuario']['email'] = $_POST['Email']['email'];


                echo json_encode(array(
                    'funcao' => "sucessoForm( 'Usuario editado com sucesso!', '#UsuarioEditForm' );"
                    . "window.location.reload();",
                ));
            } else {
                echo json_encode(array(
                    'erros' => $this->User->validateErros,
                    'form' => 'UsuarioEditForm',
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erros' => array($ex->getMessage()),
                'form' => 'UsuarioEditForm',
            ));
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza o login do usuario no sistema
     *
     * 
     * */
    public function login() {
        try {
            
            $this->User->validate = $this->User->validate_login;
            $_POST = Utils::sanitazeArray($_POST);
            $this->User->data = $_POST[$this->User->name];
            $_SESSION = NULL;
            
            if ($this->User->validates()) {

                $this->User->data['senha'] = Authentication::password($this->User->data['senha']);

                /**
                 * toda a minha validação de status da conta, usuario ou empresa está na procedure.
                 * referencia MODEL/USUARIOS.PHP
                 * metodo LOGAR
                 */
                $usuario[$this->User->name] = $this->User->logar($this->User->data['email'], $this->User->data['senha']);

                /**
                 * recuperar a empresa do funcionario
                 */
                

                Session::initAuth();
                Session::createSession($usuario);

                /**
                 * Usuario operador logar com a empresa já na session
                 */
                if (in_array($usuario[$this->User->name]['roles_id'], array(2,6))) {
                    $modelFuncionario = new Funcionario();
                    $modelEmpresa     = new Empresa();
                    $funcionario      = $modelFuncionario->find('first', array('pessoas_id' => $usuario[$this->User->name]['pessoas_id']) );
                    
                    /**
                     * 
                     */
                    if( count($funcionario) > 0 ){
                        $_SESSION[$modelFuncionario->name] = $funcionario[0][$modelFuncionario->name];
                    }

                    $empresa      =  $modelEmpresa->findEmpresa($funcionario[0][$modelFuncionario->name]['empresas_id']);
                    

                    if( count($empresa) > 0 ){
                        /**
                         * recuperando a conta empresa e guardando na sessao
                         */
                        $contaEmpresa = $modelEmpresa->contaEmpresa(md5($funcionario[0][$modelFuncionario->name]['empresas_id']));
                        $_SESSION[$modelEmpresa->name] = $empresa[0];
                        $_SESSION['ContaEmpresa'] = $contaEmpresa[0];
                        
                    }
                } 
                else if( $usuario[$this->User->name]['roles_id'] == 3 ) {
                    
                    /**
                     * VERIFICO SE EXISTE APENAS UMA EMPRESA VINCULADA
                     */
                    
                    $modelEmpresa     = new Empresa();
                    $empresas = $modelEmpresa->empresasRelacionadas(md5($usuario[$this->User->name]['pessoas_id']), $usuario[$this->User->name]['roles_id']); 
                    
                    if ( count($empresas) == 1 ) {
                        
                        $_SESSION[$modelEmpresa->name] = $empresas[0];
                        /**
                         * recuperando a conta empresa e guardando na sessao
                         */
                        $contaEmpresa = $modelEmpresa->contaEmpresa(md5($_SESSION[$modelEmpresa->name]['empresas_id']));
                                                
                        $_SESSION['ContaEmpresa'] = $contaEmpresa[0];
                    }
                    
                }



                $url = Router::url(array('Usuarios', 'painel'));
                echo json_encode(array(
                    'funcao' => "sucessoForm( 'login efetuado com sucesso!', '#UsuarioLoginForm' ); redirect('{$url}');",
                ));
                
                        
            } else {
                echo json_encode(array(
                    'erros' => $this->User->validateErros,
                    'form' => 'UsuarioLoginForm',
                ));
            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            echo json_encode(array(
                'funcao' => "infoErro('{$msg}', '#UsuarioLoginForm');",
            ));
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que desloga o usuario no sistema
     *
     * 
     * */
    public function logout() {
        try {
            if (Session::logout()) {
                header('Location: ' . Router::url(array('Pages', 'login')));
            }
        } catch (Exception $ex) {
            
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza a exclusao dos dados do usuario no banco de dados
     *
     * 
     * */
    public function deletar() {
        try {
            $id = (int) $_GET['param'];

            if (!empty($id)) {
                $this->User->genericDelete($id, $this->User->primaryKey);
                $url = $this->urlRoot() . 'Usuarios/index';
                echo json_encode(array(
                    'funcao' => "alertaSucesso();"
                    . "redirect('{$url}', '" . '#PagesLoginForm' . "')",
                ));
            }
        } catch (Exception $ex) {
            
        }
    }

    public function painelAdmin() {
        try {
            $this->layout = 'client-admin';
            $this->set('title_layout', 'Painel Administrativo usuário');
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function mudarSenha() {
        try {

            $this->layout = 'painel';
            $this->set('title_layout', 'Alterar senha');
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza a alteração e persistencia de senha do usuario no banco de dados
     *
     * 
     * */
    public function alterarSenha() {
        try {
            $senha = null;
            $view = null;
            
            $senha = Authentication::password($_POST[$this->User->name]['senha']);
            $_POST[$this->User->name]['id'] = Session::read('Usuario.usuarios_id');
            $_POST = Utils::sanitazeArray($_POST);
            
            if (isset($_POST[$this->User->name]['view'])) {
                $view = $_POST[$this->User->name]['view'];
                unset($_POST[$this->User->name]['view']);
            }

            $this->User->data = $_POST[$this->User->name];

            $this->User->validate = $this->User->validate_alteraSenha;

            if ($this->User->validates()) {

                
                if (isset($_POST[$this->User->name]['senha'])) {
                    $emailSenha = $_POST[$this->User->name]['confirm_senha'];
                    unset($_POST[$this->User->name]['confirm_senha']);
                    $_POST[$this->User->name]['senha'] = $senha;
                }

                if ($this->User->genericUpdate($_POST[$this->User->name])) {

                    if (Session::read('Usuario.email')) {
                        $email           = new Email();
                        $email->useTable = 'emails_sistema';
                        $registro        = $email->find('first', array('tag' => 'senha_recuperada'));
                        #faço a troca de siglas para personalizar o email
                        $array = array(
                            '__SENHA__' => $emailSenha,
                            '__DATE__' => date('d/m/Y h:i:s'),
                            '__URL__' => Router::url(array('Pages', 'login')),
                        );

                        #envio o email de confirmação para o meu cliente cadastrado
                        $objeto = new MailPHPMailer();
                        $objeto->setAssunto('Senha Alterada com sucesso!');
                        $objeto->setRemetente();
                        $objeto->setDestinatario(Session::read('Usuario.email'), Session::read('Usuario.nome'));
                        $objeto->setBody(str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']));
                        $objeto->sendMail();
                    }
                    Session::logout();

                    $url = Router::url();
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Alteração de senha foi efetuada com sucesso, por favor logar-se novamente!', '#UsuarioEditForm' ); redirect('{$url}');",
                    ));
                }
            } else {
                echo json_encode(array(
                    'erros' => $this->User->validateErros,
                    'form' => 'UsuarioEditForm',
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erros' => array($ex->getMessage()),
                'form' => 'UsuarioEditForm',
            ));
        }
    }

    public function alterarDados() {
        try {

            if ($this->is('Post') || $this->is('Put')) {
                $_POST[$this->User->name]['id'] = $_SESSION['Usuario']['id'];
                $this->User->data = $_POST[$this->User->name];

                if ($this->User->validates()) {

                    $_POST = Utils::sanitazeArray($_POST);

                    if ($this->User->genericUpdate($_POST[$this->User->name])) {
                        $_SESSION['Usuario']['nome'] = $_POST[$this->User->name]['nome'];
                        $url = $this->urlRoot() . 'Usuarios/mudarDados';
                        echo json_encode(array(
                            'msg' => 'Alteração efetuada com sucesso',
                            'funcao' => "redirect('{$url}', '" . '#PagesLoginForm' . "')",
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'erros' => $this->User->validateErros,
                        'form' => 'UsuarioAddForm',
                    ));
                }
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erros' => array($ex->getMessage()),
                'form' => 'UsuarioEditForm',
            ));
        }
    }

    public function requestSenha() {
        try {
            if ($this->is('Post') || $this->is('Put')) {

                $this->User->validate = $this->User->validate_request;

                $this->User->data = $_POST[$this->User->name];

                if ($this->User->validates()) {
                    $_POST = Utils::sanitazeArray($_POST);
                    $usuario = $this->User->find('first', array('email' => $_POST[$this->User->name]['email']));
                    $usuario = array_shift($usuario);

                    if (count($usuario) > 0) {

                        $email = new Email($usuario[$this->User->name]);
                        $email->assunto = utf8_decode('Recuperação de senha');
                        $email->layout = 'recuperaSenha';
                        $email->setVars('usuario', $usuario[$this->User->name]);
                        $email->setVars('url', $this->urlRoot());
                        if ($email->SendMail()) {
//                            echo json_encode(array(
//                                'msg' => '',
//                                'funcao' => "redirect('{$this->urlRoot()}', '".'#PagesLoginForm'."')",
//                            ));
                            echo json_encode(array(
                                'funcao' => "sucessoForm( 'Seu pedido de recuperação de senha foi efetuado com sucesso, verifique seu e-mail!', '#UsuarioAlterarDadosForm' );
                                limparForm( '#UsuarioAlterarDadosForm' );",
                            ));
                        }
                    } else {
                        echo json_encode(array(
                            'erros' => array('email' => 'E-mail informado não consta em nossos cadastros'),
                            'form' => 'UsuarioAlterarDadosForm',
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'erros' => $this->User->validateErros,
                        'form' => 'UsuarioAlterarDadosForm',
                    ));
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza a recuperação de senha do usuario no banco de dados
     *
     * 
     * */
    public function recuperaSenha() {
        try {

            if (isset($_POST['email'])) {

                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    
                    $hash = Authentication::uuid();
                    
                    if ($this->User->alteraHashSenha($_POST['email'], $hash)) {
                        
                        $email = new Email();
                        $email->useTable = 'emails_sistema';
                        $registro = $email->find('first', array('tag' => 'recuperar_senha'));
                        #faço a troca de siglas para personalizar o email
                        $array = array(
                            '__EMAIL_REMETENTE__' => $_POST['email'],
                            '__DATE__' => date('d/m/Y h:i:s'),
                            '__URL__' => Router::url(array('Usuarios', 'resetarSenha', $hash)),
                        );

                        #envio o email de confirmação para o meu cliente cadastrado
                        $objeto = new MailPHPMailer();
                        $objeto->setAssunto('Reserva - Recuperar Senha!');
                        $objeto->setRemetente();
                        $objeto->setDestinatario($_POST['email'], 'Recuperar Senha');
                        $objeto->setBody(str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']));
                        $objeto->sendMail();
                        $this->set('mensagem', 'Para alterar a senha clique no link enviado ao seu email');
                    } else {
                        $this->set('mensagem', 'Ocorreu algum erro no processo, tente novamente.');
                    }
                } else {
                    $this->set('mensagem', 'Email inválido');
                }
            }

            $this->set('title_layout', 'Esqueci minha senha');
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que reseta a senha do usuario no banco de dados
     *
     * 
     * */
    public function resetarSenha() {
        try {
            $verificacao = $this->User->verificaHash($_GET['param']);
            if (isset($_GET['param']) && $verificacao[0]['count'] > 0) {

                if (isset($_POST['senha']) && isset($_POST['confSenha'])) {

                    if ($_POST['senha'] === $_POST['confSenha']) {
                        $this->User->alterarSenha(Authentication::password($_POST['senha']), $_GET['param']);
                        header('Location: ' . Router::url('Pages/login'));
                    } else {
                        $this->set('mensagem', 'As senhas não conferem!');
                    }
                }
            } else {
                header('Location: ' . Router::url('Pages/login'));
            }
            $this->render();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza a edicao e persistencia de dados do usuario no banco de dados
     *
     * 
     * */
    public function enviarFoto() {

        try {
            if ($this->is('post')) {
                require_once("Library/wideimage/WideImage.php");

                echo $nomeArquivo = md5(pathinfo($_FILES['foto']['name'], PATHINFO_FILENAME)) . Session::read('Empresa.empresas_id') . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

                // WideImage::load($_FILES['foto']['tmp_name'])->saveToFile( PATH_SERVER . '/View/webroot/img/logos/' . $nomeArquivo);
                WideImage::load($_FILES['foto']['tmp_name'])->resize(200, 100)->saveToFile('View/webroot/img/logos/' . $nomeArquivo);

                ##CADASTRAR NO BANCO DE DADOS A IMAGEM SOLICITADA PARA A EMPRESA.
                if ($this->User->gravaFoto($nomeArquivo, Session::read('Empresa.empresas_id'))) {

                    $_SESSION['Empresa']['logo'] = $nomeArquivo;

                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Foto foi registrada com sucesso!', '#FotoAddForm' );"
                        . "window.location.reload();",
                    ));
                }
            }
        } catch (Exception $ex) {
            if ($this->is('post')) {
                echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#FotoAddForm' );",
                ));
            } else {
                echo $ex->getMessage();
            }
        }
    }

    /**
     * @author bruno blauzius schuindt
     * @version 1.0
     * @todo metodo que realiza a edicao e persistencia de dados do usuario no banco de dados
     *
     * 
     * */
    public function enviarFotoUsuario() {

        try {
            if ($this->is('post')) {
                require_once("Library/wideimage/WideImage.php");

                $nomeArquivo = md5(pathinfo($_FILES['foto']['name'], PATHINFO_FILENAME)) . Session::read('Empresa.empresas_id') . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);


                WideImage::load($_FILES['foto']['tmp_name'])->resize(300, 200)->saveToFile('View/webroot/img/thumb/' . $nomeArquivo);

                ##CADASTRAR NO BANCO DE DADOS A IMAGEM SOLICITADA PARA A EMPRESA.
                if ($this->User->gravaFotoUsuario($nomeArquivo, $this->pessoas_id)) {

                    $_SESSION['Usuario']['imagem_perfil'] = $nomeArquivo;

                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Sua imagem foi registrada com sucesso!', '#FotoAddForm' );"
                        . "window.location.reload();",
                    ));
                }
            }
        } catch (Exception $ex) {
            if ($this->is('post')) {
                echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#FotoAddForm' );",
                ));
            } else {
                echo $ex->getMessage();
            }
        }
    }

}
