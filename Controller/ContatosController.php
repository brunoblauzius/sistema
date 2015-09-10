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
    
}
