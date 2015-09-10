<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GruposController
 *
 * @author bruno.blauzius
 */
class GruposController extends AppController {
    //put your code here
    
    public $ClasseAllow  = false;
    
    public $Grupo = null;
    
    public function __construct() {
        parent::__construct();
        
        $this->Grupo = new Grupo();
        
        $this->layout = 'painel';
    }
    
    public function index() { 
        try{
            
            $list = array();
            $grupos = array();
            
            $grupos = $this->Grupo->find('all', NULL, null, NULL, array('nome ASC'));
            
            foreach ($grupos as $grupo) {
                $list[] = new GrupoEntity(
                        $grupo[$this->Grupo->name]['id'], 
                        $grupo[$this->Grupo->name]['nome'], 
                        $grupo[$this->Grupo->name]['status']);
            }      
            
            $this->set('grupos', $list);
            $this->set('title_layout', 'Permissões: Home');
            $this->render();

       } catch (Exception $ex) {

       }
    }
    
    public function editar() { 
        try{
            
            $registro = array();
            $id = (int) $_GET['param'];
            if( !is_null($id) ){
                
                if(isset($_SESSION['GrupoForm'])){
                    unset($_SESSION['GrupoForm']);
                }
                
                $registro = $this->Grupo->find('first',array( 'id' => $id ));
                $registro = array_shift($registro);
                
                $registro = new GrupoEntity($registro[$this->Grupo->name]['id'], $registro[$this->Grupo->name]['nome'], $registro[$this->Grupo->name]['status']);
                
                if( is_object($registro) && !empty($registro) ){
                    $_SESSION['GrupoForm']['id'] = (int) $registro->getId();
                }
            }
            
            $this->set('registro', $registro );
            $this->set('title_layout', 'Grupos: Edição');
            $this->render();
            
        } catch (Exception $ex) {

        }
    }
    
    public function cadastro() {
        try{
            $this->set('title_layout', 'Grupos: Home');
            $this->render();
        } catch (Exception $ex) {

        }
    }
    
    public function edit() {
        try{
            if( isset($_SESSION['GrupoForm'])){
               $_POST[$this->Grupo->name]['id'] = $_SESSION['GrupoForm']['id'];
            }
            
            $_POST = Utils::sanitazeArray( $_POST );
            $this->Grupo->data =  $_POST[$this->Grupo->name] ;
            
            $this->Grupo->validate = $this->Grupo->validate_edit;
            
            if ( $this->Grupo->validates() ) {
                if( $this->Grupo->genericUpdate( $this->Grupo->data ) ) {
                    $url = $this->urlRoot() . 'Grupos/index';
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Alteração foi efetuada com sucesso!', '#GrupoEditForm' );"
                                  . "redirect('{$url}')",
                    ));               
                } 
            } else {
                echo json_encode(array(
                    'erros' => ($this->Grupo->validateErros),
                    'form'  => 'GrupoEditForm',
                ));
            }
       } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro( '{$ex->getMessage()}', '#GrupoEditForm' );",
            ));
       }
    }
    
    public function add() { 
        try{
            $_POST = Utils::sanitazeArray( $_POST );
            $this->Grupo->data =  $_POST[$this->Grupo->name] ;
            
            
            if ( $this->Grupo->validates() ) {
                if( $this->Grupo->genericInsert( $this->Grupo->data ) ) {
                    $url = $this->urlRoot() . 'Grupos/index';
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Cadastro foi efetuado com sucesso!', '#GrupoAddForm' );"
                                  . "redirect('{$url}')",
                    ));
                } 
            } else {
                echo json_encode(array(
                    'erros' => ($this->Grupo->validateErros),
                    'form'  => 'GrupoAddForm',
                ));
            }

        } catch (Exception $ex) {
            echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#GrupoAddForm' );",
                ));
        }
    }
    
    public function deletar() {
        try{
            $id = (int) $_GET['param'];
            
            if(!is_null($id)) {
                if( $this->Grupo->genericDelete($id, 'id') ) {
                    $url = $this->urlRoot() . 'Grupos/index';
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
    
   
    
}
