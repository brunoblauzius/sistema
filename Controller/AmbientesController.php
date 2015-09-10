<?php

/**
 * Description of AmbientesController
 *
 * @author bruno.blauzius
 */
class AmbientesController extends AppController {
    //put your code here
    
    public $Ambiente = null;
    public $Salao = null;
    
    public function __construct() {
        parent::__construct();
        $this->layout = "painel";
        $this->Ambiente = new Ambiente();
        $this->Salao = new Salao();
    }


    public function index() {
        try{
            
            $this->checaEmpresa();
            
            $registros = $this->Ambiente->findById( $this->empresas_id );
            $saloes    = $this->Salao->find('all', array('empresas_id' => $this->empresas_id, 'status' => true ));
            
            $this->set('title_layout', 'Ambientes: listar ambientes da empresa');
            $this->set('registros', $registros);
            $this->set('saloes', $saloes);
            $this->render();
            
        } catch (BusinessException $buEx) {
            $this->set( 'mensagem', $buEx->getMessage() );
            die( $this->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
        }
        catch (Exception $ex) {
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    public function cadastro() {
    }
    
    public function editar() {
        try{
            $this->layout = 'null';
            
            $ambientes = $this->Ambiente->find('all', array('empresas_id' => $this->empresas_id, 'id' => $_GET['param'] ));
            
            $saloes    = $this->Salao->find('all', array('empresas_id' => $this->empresas_id, 'status' => true ));
            
            $_SESSION['Form']['ambientes_id'] = $ambientes[0][$this->Ambiente->name]['id'];
            
            $this->set('title_layout', 'Ambientes: listar ambientes da empresa');
            $this->set('registro', array_shift($ambientes[0]));
            $this->set('saloes', $saloes);
            $this->render();
            
        } catch (BusinessException $buEx) {
            $this->set( 'mensagem', $buEx->getMessage() );
            die( $this->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
        }
        catch (Exception $ex) {
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    public function edit() {
        try {
            
            $_POST[$this->Ambiente->name]['id'] = $_SESSION['Form']['ambientes_id'];
            
            $this->Ambiente->data = $_POST[$this->Ambiente->name];
                        
            if( $this->Ambiente->validates() ){
                
                if( $this->Ambiente->genericUpdate( $this->Ambiente->data ) ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Alteração efetuada com sucesso!', '#AmbienteAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Ambiente->validateErros),
                    'form'  => $this->Ambiente->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function add(){
        try {
            
            $_POST[$this->Ambiente->name]['empresas_id'] = $this->empresas_id;
            $this->Ambiente->data = $_POST[$this->Ambiente->name];
                
                        
            if( $this->Ambiente->validates() ){
                
                if( $this->Ambiente->genericInsert( $this->Ambiente->data ) ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Cadastro efetuado com sucesso!', '#AmbienteAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Ambiente->validateErros),
                    'form'  => $this->Ambiente->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function alterarStatus() {
        try {
            
            $registro = $this->Ambiente->find('first', array('md5(id)' => $_POST['id'], 'empresas_id' => $this->empresas_id ) );
            
            $this->Ambiente->data['id']     = $registro[0][$this->Ambiente->name]['id'];
            $this->Ambiente->data['status'] = $_POST['status'];
                
            if( $this->Ambiente->genericUpdate( $this->Ambiente->data ) ){
                echo json_encode(array(
                                    'funcao' => "window.location.reload();",
                                ));
            }
                
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function saloesAmbientes(){
        $ambientes = $this->Ambiente->AmbientesSalao( (int) trim($_POST['id'] ), $this->empresas_id );
        echo json_encode($ambientes);
    }
}
