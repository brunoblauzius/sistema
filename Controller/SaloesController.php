<?php

/**
 * CakePHP SaloesController
 * @author BRUNO
 */
class SaloesController extends AppController {

    
    public $Salao = null;
    
    
    public function __construct() {
        parent::__construct();
        $this->layout = "painel";
        $this->Salao = new Salao();
    }


    public function index() {
        try{
            
            $this->checaEmpresa();
            
            $saloes = $this->Salao->find('all', array('empresas_id' => $this->empresas_id ));
            
            
            $this->set('title_layout', 'Salões: listar salões da empresa');
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
            
            $saloes = $this->Salao->find('all', array('empresas_id' => $this->empresas_id, 'id' => $_GET['param'] ));
            
            $_SESSION['Form']['salaoes_id'] = $saloes[0]['Salao']['id'];
            
            $this->set('title_layout', 'Salões: listar salões da empresa');
            $this->set('salao', array_shift($saloes[0]));
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
            
            $_POST[$this->Salao->name]['id'] = $_SESSION['Form']['salaoes_id'];
            $this->Salao->data = $_POST[$this->Salao->name];
                        
            if( $this->Salao->validates() ){
                
                if( $this->Salao->genericUpdate( $this->Salao->data ) ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Alteração efetuada com sucesso!', '#SalaoAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Salao->validateErros),
                    'form'  => $this->Salao->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public function add(){
        try {
            
            $_POST[$this->Salao->name]['empresas_id'] = $this->empresas_id;
            $this->Salao->data = $_POST[$this->Salao->name];
                        
            if( $this->Salao->validates() ){
                
                if( $this->Salao->genericInsert( $this->Salao->data ) ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Cadastro efetuado com sucesso!', '#SalaoAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Salao->validateErros),
                    'form'  => $this->Salao->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public function alterarStatus() {
        try {
            
            $salao = $this->Salao->find('first', array('md5(id)' => $_POST['id'], 'empresas_id' => $this->empresas_id ) );
            
            $this->Salao->data['id']     = $salao[0][$this->Salao->name]['id'];
            $this->Salao->data['status'] = $_POST['status'];
                
            if( $this->Salao->genericUpdate( $this->Salao->data ) ){
                echo json_encode(array(
                                    'funcao' => "window.location.reload();",
                                ));
            }
                
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
}
