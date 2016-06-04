<?php

/**
 * Description of EventosController
 *
 * @author bruno.blauzius
 */
class EventosController extends AppController {
    //put your code here
    
    public $ClasseAllow = array('cadastro', 'addAtracao', 'listAtracao', 'add', 'distribuicaoPromoters', 'addDistruibuicaoPromoters');
    public $Evento;
    public $Atracao;
    
    public function __construct() {
        parent::__construct();
        
        $this->Atracao = new Atracao();
        $this->Evento = new Evento();
        $this->layout = 'painel';
    }
    
    public function index(){
        try {
            /**
             * verifico se tem alguma empresa logada
             */
            $this->checaEmpresa();
            /**
             * VERIFICA SE A EMPRESA TEM PERMISSÃO PARA OS EVENTOS
             */
            $this->verificaPermissaoEventos();

            $this->addCss(array(
                'js/morris-chart/morris',
                'js/datatimepicker2.0/bootstrap-datetimepicker.min',
                
            ));
            
            $this->addJs(
                array(
                    'js/fullcalendar2.0/lib/moment.min',
                    'js/fullcalendar2.0/fullcalendar',
                    'js/fullcalendar2.0/lang-all',
                    'js/datatimepicker2.0/bootstrap-datetimepicker.min',
                    'js/morris-chart/morris',
                    'js/morris-chart/raphael-min',
                    'js/eventos.init',
                    'js/data-table-eventos',
                )
            );
            
            $record = $this->Evento->findAll( $this->empresas_id );
            
            $this->set('registros', $record);
            $this->render();
            
        } catch (BusinessException $ex) {
            $ex->getBusinessMessage($this);
        }
    }
    
    public function cadastro(){
        
        $this->layout = 'null';
        $atracoes = $this->Atracao->find('all', array('ativo' => true), array('id', 'descricao'), null, array('descricao ASC'));
        
        $this->set('atracoes', $atracoes);
        $this->render();
        
    }
    
    
    public function add(){
        try {
            
            $token = Authentication::uuid();
            
            $_POST['Evento']['token'] = $token;
            $_POST['Evento']['empresas_id'] = $this->empresas_id;
            $_POST['Evento']['pessoas_id'] = $this->pessoas_id;
            $_POST['Evento']['data'] = Utils::convertDataSemHora($_POST['Evento']['data']);
             
            $this->Evento->data = $_POST['Evento'];
            
            if( $this->Evento->validates() ){
                
                /**
                 * Envio o banner para o servidor
                 */
                $this->Evento->uploadBanner($_FILES, $this->Evento->data);
                
                if( $this->Evento->genericInsert($this->Evento->data)){
                    $json = json_encode(array(
                            'message' => 'Cadastro realizado com sucesso',
                            "style" => 'success',
                            'time' => 5000,
                            'size' => 'md',
                            'callback' => "$('#ModalFormulario').modal('hide');",
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
    
    
    public function addAtracao(){
        try {
            
            $this->Atracao->data = $_POST;
            
            if( $this->Atracao->validates() ){
                $id = $this->Atracao->genericInsert($this->Atracao->data);
                if( $id > 0 ){
                    $json = json_encode(array(
                        'message' => 'Cadastro realizado com sucesso',
                        "style" => 'success',
                        'time' => 5000,
                        'size' => 'md',
                        'callback' => "selectAtracoes();addAtracaoTable( $id, '".$this->Atracao->data['descricao']."' );",
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
                        'message' => $this->Atracao->refactoryError(),
                        "style" => 'warning',
                        'time' => 5000,
                        'size' => 'md',
                        'callback' => NULL,
                        'before' => "$('#loading').fadeOut(500);",
                        'icon' => 'check',
                        'title' => 'Warning!'
                    ));
            }
            
            echo $json;
            
        } catch (Exception $ex) {
             echo json_encode(array(
                'message' => $ex->getMessage(),
                "style" => 'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => NULL,
                'before' => "$('#loading').fadeOut(500);",
                'icon' => 'check',
                'title' => 'Danger!'
            ));
        }
    }
    
    /**
     * 
     */
    public function listAtracao(){
        $where  = array('ativo' => true);
        $fields = array('id', 'descricao');
        $order  = array('descricao ASC');
        $limit = null;
        $records = $this->Atracao->find('all', $where, $fields, $limit, $order);
        echo json_encode($records);
    }
    
    /**
     * 
     */
    public function distribuicaoPromoters(){
        $this->addJs(
                array(
                    'js/fullcalendar2.0/lib/moment.min',
                    'js/fullcalendar2.0/fullcalendar',
                    'js/fullcalendar2.0/lang-all',
                    'js/datatimepicker2.0/bootstrap-datetimepicker.min',
                    'js/morris-chart/morris',
                    'js/morris-chart/raphael-min',
                    'js/eventos.init',
                )
            );
        $funcionariosModel = new Funcionario();
        $evento = $this->Evento->find('first', array('md5(id)' => $_GET['param']));
        $funcionarios = array();
        $funcionarios = $funcionariosModel->funcionariosEmpresa( $this->empresas_id );
        
        $this->set('funcionarios', $funcionarios);
        $this->set('registro', array_shift($evento[0]));
        $this->render();
        
    }
    
    public function addDistruibuicaoPromoters(){
        $_POST['empresas_id'] = $this->empresas_id;
        try {
            
            $this->Evento->insertList($_POST);
            
            $json = json_encode(array(
                'message' => 'Operação realizada com sucesso',
                "style" => 'success',
                'time' => 5000,
                'size' => 'md',
                'callback' => "",
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
