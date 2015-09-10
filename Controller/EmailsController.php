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
                    $registro[$this->Email->name]['corpo_mail'], 
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
                    $registro[$this->Email->name]['corpo_mail'], 
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

}
