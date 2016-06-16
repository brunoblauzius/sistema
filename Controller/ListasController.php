<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListasController
 *
 * @author BRUNO
 */
class ListasController extends AppController{
    //put your code here
    public $ClasseAllow = array('index', 'add', 'montarTabelaLista', 'editar', 'copiarListaEvento', 'edit', 'alterarStatus', 'carregarListaPromoters', 'copiarListaPromoter');
    
    public $Lista;
    
    public $layout = 'painel';
    
    public function __construct() {
        parent::__construct();
        $this->Lista = new Lista();
    }
    
    public function carregarListaPromoters(){
        $this->layout = 'null';
        
        $funcionariosModel = new Funcionario();
        $funcionarios = array();
        $funcionarios = $funcionariosModel->funcionariosEmpresa( $this->empresas_id );
        
        $records = $this->Lista->find('all', array( 'empresas_id' => $this->empresas_id), NULL, NULL, array('title ASC'));
        $listaCadastro = $this->Lista->listarCadastrosListaPromoters($_GET['pessoas_id'], $_GET['eventos_id']);
        $totalNaLista = $this->Lista->totalNalistaEvento($_GET['eventos_id']);
        echo Router::element('Listas/carregarListaPromoters', 
                array(
                    'registros' => $records, 
                    'pessoas_id' => $_GET['pessoas_id'], 
                    'eventos_id' => $_GET['eventos_id'], 
                    'listaCadastro' => $listaCadastro,
                    'totalNaLista' => $totalNaLista,
                    'funcionarios' => $funcionarios,
                ));
    }
    
    public function index(){
        
        $this->addJs(array(
            'js/eventos.listas.init'
        ));
        
        $this->render();
        
    }
    
    public function editar(){
        try {
            
            $records = $this->Lista->find('first', array('md5(id)' => $_GET['param']));
            echo json_encode(array_shift($records[0]));
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function add(){
        try {
            
            $_POST[$this->Lista->name]['empresas_id'] = $this->empresas_id;
            
            if(count($_POST[$this->Lista->name]['sexo']) == 2 ){
                $_POST[$this->Lista->name]['sexo'] = 2;
            } else {
                $_POST[$this->Lista->name]['sexo'] = $_POST[$this->Lista->name]['sexo'][0];
            } 
            
            $this->Lista->data = $_POST[$this->Lista->name];
            
            
            
            if( $this->Lista->validates() ){
                
                if( $this->Lista->genericInsert( $this->Lista->data )){
                        $json = json_encode(array(
                                'message' => 'Cadastro realizado com sucesso',
                                "style" => 'success',
                                'time' => 5000,
                                'size' => 'md',
                                'callback' => "$('#ModalFormulario').modal('hide');carregarTableLista();limparForm();",
                                'before' => "$('#loading').fadeOut(500);",
                                'icon' => 'check',
                                'title' => 'Success!'
                            ));
                        } else {
                            $json = json_encode(array(
                                'message' => 'Não foi possivel realizar o cadastro',
                                "style" => 'warning',
                                'time' => 5000,
                                'size' => 'md',
                                'callback' => NULL,
                                'before' => "$('#loading').fadeOut(500);",
                                'icon' => 'check',
                                'title' => 'Warning!'
                            ));
                        }

                    } else {
                        $json = json_encode(array(
                                'message' => $this->Evento->refactoryError(),
                                "style" => 'warning',
                                'time' => 5000,
                                'size' => 'md',
                                'callback' => NULL,
                                'before' => "$('#loading').fadeOut(500);",
                                'icon' => 'check',
                                'title' => 'Warning!'
                            ));
                    }

                    echo json_encode(array(
                        'funcao' => "bootsAlert( $json )",
                    ));
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" => 'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => NULL,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Danger!'
            ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
        }
    }
    
    /**
     * 
     */
    public function edit(){
        try {
            
            $_POST[$this->Lista->name]['empresas_id'] = $this->empresas_id;
            
            if( count($_POST[$this->Lista->name]['sexo']) == 2 ){
                $_POST[$this->Lista->name]['sexo'] = 2;
            } else {
                $_POST[$this->Lista->name]['sexo'] = $_POST[$this->Lista->name]['sexo'][0];
            } 
            
            $this->Lista->data = $_POST[$this->Lista->name];
          
            
            if( $this->Lista->validates() ){
                
                if( $this->Lista->genericUpdate( $this->Lista->data )){
                        $json = json_encode(array(
                                'message' => 'Alteração realizada com sucesso',
                                "style" => 'success',
                                'time' => 5000,
                                'size' => 'md',
                                'callback' => "carregarTableLista();limparForm();",
                                'before' => "$('#loading').fadeOut(500);",
                                'icon' => 'check',
                                'title' => 'Success!'
                            ));
                        } else {
                            $json = json_encode(array(
                                'message' => 'Não foi possivel realizar a Alteração',
                                "style" => 'warning',
                                'time' => 5000,
                                'size' => 'md',
                                'callback' => NULL,
                                'before' => "$('#loading').fadeOut(500);",
                                'icon' => 'check',
                                'title' => 'Warning!'
                            ));
                        }

                    } else {
                        $json = json_encode(array(
                                'message' => $this->Evento->refactoryError(),
                                "style" => 'warning',
                                'time' => 5000,
                                'size' => 'md',
                                'callback' => NULL,
                                'before' => "$('#loading').fadeOut(500);",
                                'icon' => 'check',
                                'title' => 'Warning!'
                            ));
                    }

                    echo json_encode(array(
                        'funcao' => "bootsAlert( $json )",
                    ));
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" => 'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => NULL,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Danger!'
            ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
        }
    }
    
    
    public function montarTabelaLista(){
        
        $this->layout = 'null';
        
        $records = $this->Lista->find('all', array( 'empresas_id' => $this->empresas_id), NULL, NULL, array('title ASC'));
        echo Router::element('Listas/listaParaPromoters', array('registros' => $records ));
        
    }
    
    public function alterarStatus(){
        try {
            
            $records = $this->Lista->find('first', array('md5(id)' => $_GET['param']));
            
            if( $records[0]['Lista']['status'] == 0 ){
                $this->Lista->data['status'] = 1;
            } else {
                $this->Lista->data['status'] = 0;
            }
            
            $this->Lista->data['id'] = (int) $records[0]['Lista']['id'];
            
            
            if( $this->Lista->genericUpdate( $this->Lista->data ) ){
                $json = json_encode(array(
                                'message' => 'Alteração realizada com sucesso',
                                "style" => 'success',
                                'time' => 5000,
                                'size' => 'md',
                                'callback' => "carregarTableLista();",
                                'before' => "$('#loading').fadeOut(500);",
                                'icon' => 'check',
                                'title' => 'Success!'
                            ));
            } else {
                $json = json_encode(array(
                    'message' => 'Não foi possivel realizar a Alteração',
                    "style" => 'warning',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => NULL,
                    'before' => "$('#loading').fadeOut(500);",
                    'icon' => 'check',
                    'title' => 'Warning!'
                ));
            }
            
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" => 'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => NULL,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Danger!'
            ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
        }
    }
    
    
    public function copiarListaPromoter(){
        try {
            
            $this->Lista->copyListaPromoter($_POST['pessoas_idcopy'], $_POST['pessoas_id'], $_POST['eventos_id']);
            
            $json = json_encode(array(
                'message' => 'Lista Copiada com sucesso',
                "style" => 'success',
                'time' => 5000,
                'size' => 'md',
                'callback' => "carregarListaFuncionarios('{$_POST['pessoas_id']}', '{$_POST['eventos_id']}');",
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Success!'
            ));
            
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" => 'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => NULL,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Danger!'
            ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
        }
    }
    
    
    public function copiarListaEvento(){
        try {
            
            $this->Lista->copyListaPromoterEventos($_POST['eventos_idcopy'], $_POST['eventos_id'], $this->empresas_id);
            
            $json = json_encode(array(
                'message' => 'Lista Copiada com sucesso',
                "style" => 'success',
                'time' => 5000,
                'size' => 'md',
                'callback' => NULL,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Success!'
            ));
            
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" => 'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => NULL,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Danger!'
            ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
        }
    }
    
}
