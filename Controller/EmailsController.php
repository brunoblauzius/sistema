<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailsController
 *
 * @author bruno.blauzius
 */
class EmailsController extends AppController {
    //put your code here
    
    public $Email = null;
    
    
    public function __construct() {
        parent::__construct();
        $this->layout = 'painel';
        
        $this->Email =  new Email();
        $this->Email->useTable = 'emails_sistema';
    }
    
    
    public function index(){
        
        $registros = $this->Email->find('all');
        
        
        
        $obejct    = array();
        foreach ($registros as $registro) {
            $obejct[] = new EmailEntity(
                    $registro[$this->Email->name]['id'], 
                    $registro[$this->Email->name]['tag'], 
                    Utils::htmlEntityDecode($registro[$this->Email->name]['corpo_mail']), 
                    $registro[$this->Email->name]['ativo']
                    );
        }
        
        $this->set('obejct', $obejct);
        $this->set('title_layout', 'Emails do sistema');
        $this->render();
    }
    
    public function cadastro(){
        try{
            
            $this->set('title_layout', 'Cadastro de e-mails do sistema');
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    
    
    public function add(){
        try{
		
            $_POST[$this->Email->name]['corpo_mail'] = Utils::htmlEntityEncode(str_replace(array('\\'), null, $_POST[$this->Email->name]['corpo_mail']));
            
            $this->Email->data =  $_POST[$this->Email->name] ;
            
            if ( $this->Email->validates() ) {
                if( $this->Email->genericInsert( $this->Email->data ) ) {
                    $url = $this->urlRoot() . 'Emails/index';
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Cadastro foi efetuado com sucesso!', '#EmailAddForm' );"
                                  . "redirect('{$url}')",
                    ));
                } 
            } else {
                echo json_encode(array(
                    'erros' => ($this->Email->validateErros),
                    'form'  => 'EmailAddForm',
                ));
            }

        } catch (Exception $ex) {
            echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#EmailAddForm' );",
                ));
        }
    }
    
    public function editar(){
        try{
            
            if(isset($_SESSION['EmailsForm'])) {
                unset($_SESSION['EmailsForm']);
            }
            
            $id = intval($_GET['param']);
            
            $registro = $this->Email->find('all', array('id' => $id ) );
            $registro = array_shift($registro);
            
            $objeto = new EmailEntity(
                    $registro[$this->Email->name]['id'], 
                    $registro[$this->Email->name]['tag'], 
                    Utils::htmlEntityDecode($registro[$this->Email->name]['corpo_mail']), 
                    $registro[$this->Email->name]['ativo']
                    );
            
            if( is_object($objeto) && !empty($objeto) ){
                $_SESSION['EmailsForm']['id'] = $objeto->getId();
            }
            
            $this->set('objeto', $objeto);
            $this->set('title_layout', 'Emails: (Editar)');
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function edit(){
        try{
            if( isset($_SESSION['EmailsForm'])){
               $_POST[$this->Email->name]['id'] = $_SESSION['EmailsForm']['id'];
            }
			
            $_POST[$this->Email->name]['corpo_mail'] = Utils::htmlEntityEncode(str_replace(array('\\'), null, $_POST[$this->Email->name]['corpo_mail']));
			
			
            $this->Email->data =  $_POST[$this->Email->name] ;
            
            //$this->Email->validate = $this->MetEmailodo->validate_edit;
            
            if ( $this->Email->validates() ) {
                if( $this->Email->genericUpdate( $this->Email->data ) ) {
                    $url = $this->urlRoot() . 'Emails/index';
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Alteração foi efetuada com sucesso!', '#EmailEditForm' );"
                                  . "redirect('{$url}')",
                    ));               
                } 
            } else {
                echo json_encode(array(
                    'erros' => ($this->Email->validateErros),
                    'form'  => 'EmailEditForm',
                ));
            }
            
            
       } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro( '{$ex->getMessage()}', '#EmailEditForm' );",
            ));
       }
    }
    
    /**
     * @todo metodo que executa a ação de excluir um cadastro
     */
    public function deletar(){
        try{
            $id = (int) $_GET['param'];
            
            if(!is_null($id)) {
                if( $this->Email->genericDelete($id, 'id') ) {
                    $url = $this->urlRoot() . 'Emails/index';
                    echo json_encode(array(
                        'funcao' => "alertaSucesso();"
                                  . "redirect('{$url}');",
                    ));
                }
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesControladoraAddForm' );",
            ));
        }
    }
    
    
    public function form() {
        $this->set('title_layout', 'Página de teste para envio no sistema');
        $this->render();
    }
    
    public function send(){
        
       try{
           
            $objeto = new MailPHPMailer();
            $objeto->setAssunto($_POST['Email']['assunto']);
            $objeto->setRemetente();
            $objeto->setDestinatario($_POST['Email']['email'], $_POST['Email']['nome'] );
            $objeto->setBody('<b>'.$_POST['Email']['mensagem'].'</b>');
            $objeto->sendMail();
            
       } catch (Exception $ex) {
           echo $ex->getMessage();
       }
    }

    /**
     * @todo metodo que renderiza a pagina para o usuario empresa editar os parametros dos emails de envio para confirmacao de reserva
     * 
     */
    final public function parametrosEmail(){
        try {
            
            $this->checaEmpresa();
            
            $email_confirmacao = $this->Email->find('first', array('tag' => 'email_confirmacao'));
            //$email_confirmacao = $this->Email->find('first', array('tag' => 'cadastro_reserva'));
            
            $this->Email->useTable = 'empresas_email_parametros';
            $email_parametros  = $this->Email->find('first', array(
                //'emails_sistema_id' => $email_confirmacao[0][$this->Email->name]['id'],
                'emails_sistema_id' => 5,
                'empresas_id'       => $this->empresas_id,
            ));
            
            $corpoEmailConfirmacao = $this->Email->ajusteEmailConfirmacao( 
                    $email_confirmacao[0][$this->Email->name]['corpo_mail'], 
                    $email_parametros[0][$this->Email->name]
                    );
            
            $this->set('title_layout', 'Parâmetros de e-mail: Empresa');
            $this->set('emailConfirmacao', $corpoEmailConfirmacao);
            $this->set('emailParametros', $email_parametros[0][$this->Email->name]);
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
    
    
    final public function cadastraCorpoErodape(){
        
        
        $colunaDaTabela = $_POST[$this->Email->name]['coluna'];
        
        if( $colunaDaTabela == 'corpo_email'){
            $htmlDoEmail    = $_POST[$this->Email->name]['corpo_email'];
        } else {
            $htmlDoEmail    = $_POST[$this->Email->name]['rodape_email'];
        }
                
        $this->Email->data[$colunaDaTabela]        =  $htmlDoEmail;
        $this->Email->data['empresas_id']           = $this->empresas_id; 
        $this->Email->data['emails_sistema_id']    = 5; 
        
        try {
            
            if( $this->Email->cadastraCorpoErodape( $this->Email->data ) ){
                
                $json = json_encode(array(
                    'style' => 'success',
                    'title' => 'Sucesso',
                    "time" => 5000,
                    'size' => 'md',
                    'callback' => NULL,
                    'before' => 'window.location.reload();',
                    'icon'   => 'ok'
                ));
                
            }
            
            echo json_encode(array(
                    'funcao' => "bootsAlert( $json );"
                )); 
            
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
}
