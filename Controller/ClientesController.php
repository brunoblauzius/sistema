<?php

class ClientesController extends AppController {
    
    public $Cliente = null;
    
    public function __construct() {
        parent::__construct();
        $this->layout  = 'painel';
        $this->Cliente = new Cliente(); 
    }
    
    public function index() {
        try{
            
            $this->checaEmpresa();
                        
            $registro = $this->Cliente->clientesProprietario($this->pessoas_id, Session::read('Usuario.roles_id'));
            
            $this->set('title_layout', 'Clientes: listar clientes da empresa');
            $this->set('registros', $registro);
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
            
            $registro = $this->Cliente->find('all', array('id' => $_GET['param'] ));
            
            $_SESSION['Form']['clientes_id'] = $registro[0]['Cliente']['id'];
            
            $this->set('title_layout', 'Clientes: listar Clientes da empresa');
            $this->set('registro', array_shift($registro[0]));
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
            
            $_POST[$this->Cliente->name]['id'] = $_SESSION['Form']['clientes_id'];
            $_POST[$this->Cliente->name]['telefone']      = Utils::returnNumeric($_POST[$this->Cliente->name]['telefone']);
            $_POST[$this->Cliente->name]['dt_nascimento'] = Utils::convertDataSemHora($_POST[$this->Cliente->name]['dt_nascimento']);
            $this->Cliente->data = $_POST[$this->Cliente->name];
                        
            if( $this->Cliente->validates() ){
                
                if( $this->Cliente->genericUpdate( $this->Cliente->data ) ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Alteração efetuada com sucesso!', '#ClienteAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Cliente->validateErros),
                    'form'  => $this->Cliente->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public function add(){
        try {
            
            $_POST[$this->Cliente->name]['empresas_id'] = $this->empresas_id;
            $_POST[$this->Cliente->name]['telefone']      = Utils::returnNumeric($_POST[$this->Cliente->name]['telefone']);
            $_POST[$this->Cliente->name]['dt_nascimento'] = Utils::convertDataSemHora($_POST[$this->Cliente->name]['dt_nascimento']);
            $this->Cliente->data = $_POST[$this->Cliente->name];
                        
            if( $this->Cliente->validates() ){
                
                $clientesId = $this->Cliente->genericInsert( $this->Cliente->data );
                
                $this->Cliente->clientesEmpresas($clientesId, $this->empresas_id);
                
                if( $clientesId ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Cadastro efetuado com sucesso!', '#ClienteAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Cliente->validateErros),
                    'form'  => $this->Cliente->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function alterarStatus() {
        try {
            
            $registro = $this->Cliente->find('first', array('md5(id)' => $_POST['id'], 'empresas_id' => $this->empresas_id ) );
            
            $this->Cliente->data['id']     = $registro[0][$this->Cliente->name]['id'];
            $this->Cliente->data['status'] = $_POST['status'];
                
            if( $this->Cliente->genericUpdate( $this->Cliente->data ) ){
                echo json_encode(array(
                                    'funcao' => "window.location.reload();",
                                ));
            }
                
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public function procurarCliente(){
        try {
            $this->layout = 'null';
            $cliente = array();
            
            if( $this->is('POST') ){
                $busca = $_POST['busca'];
                $valor = trim($_POST['valor']);
                $cliente = $this->Cliente->buscarCliente($busca , $valor , $this->pessoas_id, Session::read('Usuario.roles_id'));
            } else if( $this->is('GET') ){
                $cliente = $this->Cliente->find('first' , array( 'md5(id)' => $_GET['param']) );
                $cliente = array_shift($cliente[0]);
                $array[0] = $cliente;
                $cliente = $array;
            }
                       
            $this->set('cliente', $cliente);
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    
    public function addReserva(){
        try {
            
            $_POST[$this->Cliente->name]['empresas_id'] = $this->empresas_id;
            $_POST[$this->Cliente->name]['dt_nascimento'] = Utils::convertDataSemHora($_POST[$this->Cliente->name]['dt_nascimento']);
            $_POST[$this->Cliente->name]['telefone'] = Utils::returnNumeric($_POST[$this->Cliente->name]['telefone']);
            $_POST[$this->Cliente->name]['rg'] = Utils::returnNumeric($_POST[$this->Cliente->name]['rg']);
            $this->Cliente->data = $_POST[$this->Cliente->name];

            if( $this->Cliente->validates() ){

                $clientesId = $this->Cliente->genericInsert( $this->Cliente->data );

                $this->Cliente->clientesEmpresas($clientesId, $this->empresas_id);


                if( $clientesId ){

                    $_POST[$this->Cliente->name]['id'] = md5($clientesId);
                    $json = json_encode($_POST[$this->Cliente->name]);

                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Cadastro efetuado com sucesso!', '#ClienteAddForm' );"
                                                  . " cadastroClienteHtml( {$json} ) ",
                                    ));
                }

            } else {
                echo json_encode(array(
                    'erros' => ($this->Cliente->validateErros),
                    'form'  => $this->Cliente->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
        
}
