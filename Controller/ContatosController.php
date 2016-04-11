<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContatosController
 *
 */
class ContatosController extends AppController{
    //put your code here
    
    public $ClasseAllow = array('addEmpresa');
    
    public $Contato = null;
    
    public function __construct() {
        parent::__construct();
        $this->Contato = new Contato();
    }
    
    
    public function index(){
       
       $this->layout = 'painel';
       $this->set('title_layout', 'Contatos do site');
       $emails = $this->Contato->find('all', array('ativo' => TRUE));
       $this->set('emails', $emails);
       $this->render();
       
    }
    
    public function deletar(){
        try{
            $id = (int) $_GET['param'];
            
            if( !empty($id) ){
                $this->Contato->genericDelete($id, $this->Contato->primaryKey );
                $url = $this->urlRoot().'Contatos/index';
                echo json_encode(array(
                    'msg' => 'Exclusão efetuada com sucesso efetuada com sucesso',
                    'funcao' => "redirect('{$url}', '".'#PagesLoginForm'."')",
                ));
            }
            
        } catch (Exception $ex) {

        }
    }
    
    public function inativar(){
        try{
            $id = (int) $_GET['param'];
            
            if( !empty($id) ){
                
                $this->Contato->data['ativo'] = 0;
                $this->Contato->data['id']    = $id;
                        
                $this->Contato->genericUpdate( $this->Contato->data );
                $url = $this->urlRoot().'Contatos/index';
                echo json_encode(array(
                    'msg' => 'Exclusão efetuada com sucesso efetuada com sucesso',
                    'funcao' => "redirect('{$url}', '".'#PagesLoginForm'."')",
                ));
            }
            
        } catch (Exception $ex) {

        }
    }
    
    
    public function edit() {
        try {
                        
            foreach ($_POST['Contato']['telefone'] as $key => $value) {
                $_POST['Contato']['telefone'][$key] = Utils::returnNumeric($value);
            }
            
            $this->Contato->AlterarContatosEmpresa($this->empresas_id, $_POST['Contato']);
            
            $json = json_encode(array(
                    'style' => 'success',
                    'icon'  => 'check',
                    'title' => 'Atenção',
                    'message' => 'Alteração efetuada com sucesso',
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'sm',
                ));
            
            
            $sql = "SELECT 
                        id,
                        telefone,
                        tipo
                    FROM
                        contatos AS Contato
                            INNER JOIN
                        empresas_has_contatos AS EmpresaContato ON EmpresaContato.contatos_id = Contato.id
                    WHERE
                        EmpresaContato.empresas_id = $this->empresas_id;";
            
            $_SESSION['Contato'] = $this->Contato->query($sql);
                        
            echo json_encode(array(
                'funcao' => "bootsAlert({$json})",
            ));
                
        } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro('".utf8_encode($ex->getMessage())."', '#ContatoEditForm');",
            ));
        }
    }
    
    
    public function addEmpresa(){
        try {
            
            $this->Contato->data = $_POST['Contato'];
            
            if( $this->Contato->validates() ){
                
                $contatoId = $this->Contato->genericInsert($this->Contato->data);
                
                $this->Contato->inserirContatoEmpresa($this->empresas_id, $contatoId);
                
                $json = json_encode(array(
                    'message' => 'Registro inserido com sucesso!',
                    "style" =>'success',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => "window.location.reload();",
                    'before' => "$('#loading').fadeOut(500);",
                    'icon'   => 'check',
                    'title'  => 'Atenção!'
                ));
                
            } else {
                
                $json = json_encode(array(
                    'message' => $this->Contato->refactoryError(),
                    "style" =>'warning',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => NULL,
                    'before' => "$('#loading').fadeOut(500);",
                    'icon'   => 'check',
                    'title'  => 'Atenção!'
                ));
            }
            
            echo json_encode(array(
                'funcao' => "bootsAlert( $json );",
            ));
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                    'message' => $ex->getMessage(),
                    "style" =>'danger',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => NULL,
                    'before' => "$('#loading').fadeOut(500);",
                    'icon'   => 'check',
                    'title'  => 'Atenção!'
                ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json );",
            ));
        }
    }
    
}
