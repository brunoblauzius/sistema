<?php

/**
 * Paginas iniciais do sistema
 * @version 1.0
 */
class PagesController extends AppController{
    
    public $ClasseAllow = array('index', 'login', 'ativarConta', 'cadastroSucesso');
    
    public $User = null;
    
    public function __construct() {
        parent::__construct();
        $this->User = new Usuario();
    }
    
    public function index() {
        if( Session::check('Usuario')){
            header('Location: ' . Router::url(array('Usuarios', 'painel')));
            die();
        } else {
            $this->layout = 'default';       
            $this->set('title_layout', ' Logar no sistema' . $this->systemName );
            $this->render();
        }
    }
    
    
    public function login() {
        
        if( Session::check('Usuario')){
            header('Location: ' . Router::url(array('Usuarios', 'painel')));
            exit();
        } else {
            $this->layout = 'default';
            $this->set('title_layout', ' Logar no sistema' . $this->systemName);
            $this->render();
        }
    }
    
    
    /*public function addUsuario(){
        try{
            
            $this->User->data = null;
            $_POST[$this->User->name]['criado'] = date('Y-m-d h:i:s');
            $this->User->data = $_POST[$this->User->name];
            
            if( $this->is('Post') || $this->is('Put') ) {
               
               
                if( $this->User->validates() ) {
                    
                                     
                    $_POST[$this->User->name]['chave'] = md5( strrev($_POST[$this->User->name]['cpf'].$_POST[$this->User->name]['email']) );
                    $_POST[$this->User->name]['cpf'] = Utils::returnNumeric($_POST[$this->User->name]['cpf']);
                                        
                    $_POST = Utils::sanitazeArray( $_POST );
                    unset($_POST[$this->User->name]['confirm_senha']);
                    unset($_POST[$this->User->name]['code']);
                    $_POST[$this->User->name]['senha'] = Authentication::password($_POST[$this->User->name]['senha']);
                    
                    if( $this->User->genericInsert( $_POST[$this->User->name] )) {
                        
                        $this->User->data['chave']  = md5( $_POST[$this->User->name]['cpf'] );
                        
                        $email = new Email( $this->User->data );
                        $email->assunto = utf8_decode('Cadastro Usuário - JOPACS');
                        //$email->setDestinatario($this->User->data['email']);
                        $email->layout = 'cadastro_sucesso';
                        $email->setVars('usuario', $this->User->data );
                        $email->setVars('url', $this->urlRoot() );
                        
                        if( $email->SendMail() ) {
                            
                            $url = $this->urlRoot().'Pages/cadastroSucesso';
                            echo json_encode(array(
                                'msg' => 'Cadastro realizado com sucesso',
                                'funcao' => "redirect('{$url}', '".'#ContatoForm'."')",
                            ));
                        }
                    }
                    
                } else {
                    echo json_encode(array(
                        'erros' => ($this->User->validateErros),
                        'form'  => 'UsuarioAddForm',
                    ));
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public function recuperarSenha(){
        try{
            $key = $_GET['param'];
            $this->layout =  'client';
           
            if( !is_null($key) ) {
                $usuario = $this->User->find('all', array('chave' => $key));
                $usuario = array_shift($usuario);
                $_SESSION['Usuario']['id'] = $usuario[$this->User->name]['id'];
                $this->set('title_layout', 'Olá '.$usuario[$this->User->name]['nome']);
                $this->set('usuario', ($usuario) );
                $this->render();
            }
            
        } catch (Exception $ex) {

        }
    }
    
    public function sendContato(){
    	try{

            $_POST = Utils::sanitazeArray($_POST);
            $this->Contato->data = $_POST[$this->Contato->name];

            if( $this->Contato->validates() ) {
                
                unset($this->Contato->data['code']);
                
                
                $email = new Email( $this->Contato->data );
                $email->assunto = 'Contato do sistema - JOPACS';
                $email->setDestinatario('jopacs.vacinas@gmail.com');
                $email->layout = 'contato';
                $email->setVars('contato', $this->Contato->data );
                if( $email->SendMail() ) {
                    
                    $this->Contato->genericInsert( $this->Contato->data );
                    
                    echo json_encode(array(
                        'funcao' => 'limparForm("ContatoForm");
                                     sucessoForm( "E-mail enviado com sucesso!", "#ContatoForm" );',
                    ));
                }

            } else {
                echo json_encode(array(
                    'erros' => ($this->Contato->validateErros),
                    'form'  => 'ContatoForm',
                ));
            }
    		
    	} catch (Exception $ex) {
    		$ex->getMessage();
        }
    }*/

    public function ativarConta(){
        try{
            $this->layout = 'default';
            if( isset($_GET['param']) && !is_null($_GET['param'])){
                
                $this->User->ativaConta( trim($_GET['param']) );
                $this->set('title_layout', 'Conta Ativada!');
                $this->render();
                
            }
        } catch (Exception $ex) {

        }
    }
    
    public function cadastroSucesso(){
        try{
            
            $this->layout = 'default';
            $this->set('title_layout', 'Cadastro efetuado com sucesso');
            $this->render();
            
        } catch (Exception $ex) {
            
        }
    }
    
    public function vejaPlanos() {
        try{
            
            $this->layout = 'default';
            $this->set('title_layout', 'Veja os planos para sua empresa');
            $this->render();
            
        } catch (Exception $ex) {
            
        }
    }
    
}
