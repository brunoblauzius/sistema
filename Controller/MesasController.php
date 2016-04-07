<?php


/**
 * CakePHP MesasController
 * @author BRUNO
 */
class MesasController extends AppController {

    public $Mesa = null;
    public $Ambiente = null;
    
    
    public function __construct() {
        parent::__construct();
        $this->layout = "painel";
        $this->Mesa = new Mesa();
        $this->Ambiente = new Ambiente();
    }


    public function index() {
        try{
            
            $this->checaEmpresa();
                        
            $registro = $this->Mesa->findById( $this->empresas_id );
            $ambientes = $this->Ambiente->find('all',array('empresas_id' => $this->empresas_id, 'status' => true ));
            
            $this->set('title_layout', 'Mesas: listar mesas da empresa');
            $this->set('registros', $registro);
            $this->set('ambientes', $ambientes);
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
            
            $registro = $this->Mesa->find('all', array('empresas_id' => $this->empresas_id, 'id' => $_GET['param'] ));
            $ambientes = $this->Ambiente->find('all', array('empresas_id' => $this->empresas_id, 'status' => true));
            
            
            $_SESSION['Form']['ambientes_id'] = $registro[0]['Mesa']['id'];
            
            $this->set('title_layout', 'Mesas: listar mesas da empresa');
            $this->set('registro', array_shift($registro[0]));
            $this->set('ambientes', $ambientes);
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
            
            $_POST[$this->Mesa->name]['id'] = $_SESSION['Form']['ambientes_id'];
            $this->Mesa->data = $_POST[$this->Mesa->name];
                        
            if( $this->Mesa->validates() ){
                
                if( $this->Mesa->genericUpdate( $this->Mesa->data ) ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Alteração efetuada com sucesso!', '#MesaAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Mesa->validateErros),
                    'form'  => $this->Mesa->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    public function add(){
        try {
            
            $_POST[$this->Mesa->name]['empresas_id'] = $this->empresas_id;
            $this->Mesa->data = $_POST[$this->Mesa->name];
                        
            if( $this->Mesa->validates() ){
                
                if( $this->Mesa->genericInsert( $this->Mesa->data ) ){
                    echo json_encode(array(
                                        'funcao' => "sucessoForm( 'Cadastro efetuado com sucesso!', '#MesaAddForm' );"
                                                  . "window.location.reload();",
                                    ));
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Mesa->validateErros),
                    'form'  => $this->Mesa->name . 'AddForm',
                ));
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function alterarStatus() {
        try {
            
            $registro = $this->Mesa->find('first', array('md5(id)' => $_POST['id'], 'empresas_id' => $this->empresas_id ) );
            
            $this->Mesa->data['id']     = $registro[0][$this->Mesa->name]['id'];
            $this->Mesa->data['status'] = $_POST['status'];
                
            if( $this->Mesa->genericUpdate( $this->Mesa->data ) ){
                echo json_encode(array(
                                    'funcao' => "window.location.reload();",
                                ));
            }
                
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    
    
    
    public function mesasAmbiente(){
        try {
                        
            $reservasId = null;
            
            if( isset($_SESSION['Form']['reservas_id']) ){
                $reservasId = intval($_SESSION['Form']['reservas_id']);
            }
            
            $this->layout = 'null';
            //$mesas = $this->Mesa->find('all', array('ambientes_id' => $_POST['id'], 'empresas_id' => $this->empresas_id));
            $mesas           = $this->Mesa->mesasAmbiente( $this->empresas_id, $_POST['id'], Utils::revertDate($_POST['data']), $reservasId );
            $mesasReservadas = $this->Mesa->mesasReservasPure($reservasId);
            
            $mesas = array_merge($mesas, $mesasReservadas);
                        
            $this->set('mesasReservadas',$this->lista($mesasReservadas));
            $this->set('mesas', $this->montarArray($mesas));
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    protected function montarArray( $mesas ){
        $newArray = array();
        $newMiddle = array();
        $interacao = 1;
        $interacaoTotal = 1;
        $totalNode = 5;
        foreach ( $mesas as $mesa ){
            
            $newArray[$mesa['id']] = $mesa['nome']; 
            
            if( $interacao == $totalNode ){
               $newMiddle[] = $newArray;
               $interacao = 0;
               $newArray = array();
            } 
            else if( count($mesas) == $interacaoTotal ) {
                $newMiddle[] = $newArray;
            }
            $interacaoTotal++;
            $interacao++;
        }
        return $newMiddle;
    }
    
    
}
