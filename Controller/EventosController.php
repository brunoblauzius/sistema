<?php

/**
 * Description of EventosController
 *
 * @author bruno.blauzius
 */
class EventosController extends AppController {
    //put your code here
    
    public $ClasseAllow = array('cadastro','carregaListaPortaria', 'edit', 'resumo', 'carregaMinhaLista', 'liberarClientePortaria' ,'addAtracao', 'listAtracao', 'add', 'addListaVip', 'distribuicaoPromoters', 'addDistruibuicaoPromoters', 'editar', 'edit', 'portaria', 'minhaLista');
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
    
    /**
     * @todo pagina de cadastro
     */
    public function cadastro(){
        
        $this->layout = 'null';
        $atracoes = $this->Atracao->find('all', array('ativo' => true), array('id', 'descricao'), null, array('descricao ASC'));
        
        $this->set('atracoes', $atracoes);
        $this->render();
        
    }
    
    /**
     * @todo renderiza a pagina da portaria
     */
    public function portaria(){
        try {
            $token = null;
            
            $this->addJs(array(
                'js/portaria.init'
            ));
            
            if( isset($_GET['param']) ){
                $token = $_GET['param'];
            }
            
            $registro = $this->Evento->clientsInList($token);
            $this->set('registros', $registro);
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    /**
     * @todo renderiza a pagina da minha lista
     */
    public function minhaLista(){
        try {
            $this->addJs(array(
                'js/minhaLista.init'
            ));
            $token = null;
            
            $listaModel = new Lista();
            
            if( isset($_GET['param']) ){
                $token = $_GET['param'];
            }
            
            $record = $this->Evento->find('first', array('md5(id)' => $token));
            $record = array_shift($record);
            
            if( !empty($record) ){
                unset($_SESSION['Form']);
                $_SESSION['Form']['eventos_id'] = intval($record['Evento']['id']);
            }
            
            $lista = $listaModel->listaDisponivel($this->pessoas_id);
            
            $this->set('evento', $record );
            $this->set('lista', $lista);
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    private function validTokenEnterprises($token){
        try {
            
            
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    /**
     * @todo metodo que persiste os dados no banco e envia as imagens
     */
    public function add(){
        try {
            
            $token = Authentication::uuid();
            
            $_POST['Evento']['token'] = $token;
            $_POST['Evento']['empresas_id'] = $this->empresas_id;
            $_POST['Evento']['pessoas_id'] = $this->pessoas_id;
            $_POST['Evento']['data'] = Utils::convertDataSemHora($_POST['Evento']['data']);
            $_POST['Evento']['created'] = date('Y-m-d H:i:s');
            
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
    
    /**
     * @todo metodo que persiste os dados no banco e envia as imagens
     */
    public function edit(){
        try {
            
            $token = Authentication::uuid();
            
            $_POST['Evento']['token'] = $token;
            $_POST['Evento']['empresas_id'] = $this->empresas_id;
            $_POST['Evento']['pessoas_id'] = $this->pessoas_id;
            $_POST['Evento']['data'] = Utils::convertDataSemHora(trim($_POST['Evento']['data']));
            $_POST['Evento']['id'] = Session::read('Form.eventos_id');
             
            $this->Evento->data = $_POST['Evento'];
            
            
            if( $this->Evento->validates() ){
                
                /**
                 * Envio o banner para o servidor
                 */
                $this->Evento->uploadBanner($_FILES, $this->Evento->data);
                
                
                if( $this->Evento->genericUpdate($this->Evento->data)){
                    $url = Router::url('Eventos', 'index');
                    $json = json_encode(array(
                            'message' => 'Cadastro realizado com sucesso',
                            "style" => 'success',
                            'time' => 5000,
                            'size' => 'md',
                            'callback' => "$('#ModalFormulario').modal('hide');redirect('{$url}');",
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
    public function editar(){
        unset($_SESSION['Form']);
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
            )
        );
        
        
        $record = $this->Evento->find('first', array('md5(id)' => $_GET['param']));
        $_SESSION['Form']['eventos_id'] = $record[0]['Evento']['id'];
        $this->set('registro', array_shift($record[0]));
        $this->set('title_layout', 'Editar Evento');
        $this->render();
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
    
    public function addListaVip(){
        $json = NULL;
        try {
            $eventosId = Session::read('Form.eventos_id');
            $model = new Mobile();
            
            $newArr = $this->Evento->quebraLinha($_POST['nomes_listas']);
            
            if( empty($_POST['tipos_listas_id']) ){
                throw new Exception('O tipo da lista é um campo requirido!');
            }
            if( empty($newArr) ){
                throw new Exception('Você deve adicionar nomes a lista respeitando a formatação.');
            }
            
            foreach ( $newArr as $lista ){
                
                $model->data = $_POST;
                
                if ($model->validates()) {

                    /**
                     * verificar ou listar o cliente
                     */
                    $registro = $model->setNome( $lista['nome'] )
                                      ->setPhone( $lista['telefone'] )
                                      ->register();
                    
                    /**
                     * inserir na lista vip
                     */
                    $this->Evento->addClientVipList( $registro['pessoas_id'], $eventosId, $_POST['tipos_listas_id'], $this->pessoas_id );
                    
                    unset($_SESSION['Form']);
                    
                    $json = json_encode(array(
                        'message' => 'Operação realizada com sucesso',
                        "style" => 'success',
                        'time' => 5000,
                        'size' => 'md',
                        'callback' => "carregaMinhaLista();",
                        'before' => "$('#loading').fadeOut(500);",
                        'icon' => 'check',
                        'title' => 'Success!'
                    ));
                    
                    
                } else {
                    $json = json_encode(array(
                        'message' => $model->refactoryError(),
                        "style" => 'warning',
                        'time' => 5000,
                        'size' => 'md',
                        'callback' => NULL,
                        'before' => "$('#loading').fadeOut(500);",
                        'icon' => 'check',
                        'title' => 'Warning!'
                    ));
                }
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
    
    public function carregaListaPortaria(){
        $nome = Utils::sanitazeString($_POST['nome']);
        $registros = $this->Evento->clientsInListByNome($nome);
        echo Render::element('Eventos/lista-portaria', array('registros' => $registros));
    }
    
    public function liberarClientePortaria(){
        try {
            
            $pessoasId = $_POST['pessoas_id'];
            $eventosId = $_POST['eventos_id'];
            
            if( $this->Evento->liberarClientePortaria($pessoasId, $eventosId)){
             $json = json_encode(array(
                        'message' => 'Confirmada a presença com sucesso',
                        "style" => 'success',
                        'time' => 5000,
                        'size' => 'md',
                        'callback' => "carregaListaPortaria('');",
                        'before' => "$('#loading').fadeOut(500);",
                        'icon' => 'check',
                        'title' => 'Success!'
                    ));
                } else {
                    $json = json_encode(array(
                        'message' => 'Não foi possivel liberar',
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
    
    public function carregaMinhaLista(){
        $registros = $this->Evento->clientsMyList($this->pessoas_id, Session::read('Form.eventos_id'));
        echo Render::element('Eventos/minha-lista', array('registros' => $registros));
    }
    
    
    public function resumo(){
        $registros = $this->Evento->relatorioResumoFuncionario($this->pessoas_id, Session::read('Form.eventos_id'));
        echo Render::element('Eventos/resumo', array('registros' => array_shift($registros) ));
    }
    
}
