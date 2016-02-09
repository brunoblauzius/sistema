<?php

class ReservasController extends AppController {

    public $ClasseAllow = array('filtrarConvidados');
    
    private $Reserva = null;
    private $Funcionario = null;
    private $Usuario = null;
    private $Cliente = null;
    private $TiposPagamento = null;
    public  $Endereco = null;

    public function __construct() {
        parent::__construct();
        $this->layout = 'painel';

        $this->Funcionario = new Funcionario();
        $this->Endereco    = new Endereco();
        
        $this->css = array_merge($this->css, array(
                'js/fullcalendar2.0/fullcalendar',
                'js/fullcalendar2.0/bootstrap-fullcalendar',
                'js/datatimepicker2.0/bootstrap-datetimepicker.min',
//                'js/select2/select2',
                ));
        
        $this->js = array_merge($this->js, array(
                'js/fullcalendar2.0/lib/moment.min',
                'js/fullcalendar2.0/fullcalendar',
                'js/fullcalendar2.0/lang-all',
                'js/datatimepicker2.0/bootstrap-datetimepicker.min',
                'js/easypiechart/jquery.easypiechart',
//                'js/select2/select2',
//                'js/select-init',
                
                ));
        
        
        $this->Usuario = new Usuario();
        $this->Cliente = new Cliente();
        $this->Reserva = new Reserva();
    }

    public function index() {
        try {
            $this->checaEmpresa();
            //$this->verificaContaEmpresa();
            
            
            
            $usuariosEmpresa = array();
            $condicao = array();
            /**
             * 	SE O ROLE ID FOR Usuario ELE PEGA SOMENTE O Usuario SE N�O OS USUARIOS DA EMPRESA
             */
            if (!in_array(Session::read('Usuario.roles_id'), array(4,3))) {
                $usuariosEmpresa = $this->Usuario->usuariosEmpresa($this->empresas_id, $this->pessoas_id);
            } else {
                $usuariosEmpresa = $this->Usuario->usuariosEmpresa($this->empresas_id);
            }
            
            
            $clientes = $this->Cliente->find('all', array('empresas_id' => $this->empresas_id), array('id', 'nome'));

            

            $this->set('profissionais', $usuariosEmpresa);
            $this->set('clientes', $clientes);
            
            
            $this->set('title_layout', 'Reservas -  Cadastro');
            $this->render();
        } catch (BusinessException $buEx) {
            $this->set( 'mensagem', $buEx->getMessage() );
            die( $this->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
        } catch( Exception $ex ){
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }

    public function cadastro() {
        try {
            
            $this->checaEmpresa();
            $this->verificaCadastrosReservas();
            //$this->verificaContaEmpresa();
            
            /**
             *  verificar se tem alguem utilizando a data do cadastro pela empresa logada
             */
            
            $this->Reserva->verificaDisponibilidade($_POST['data'], $this->empresas_id);
            
            /**
             * gerar um cadastro stand para o novo registro e devolver o id da reserva 
             */
            
            
            $idReserva = $this->Reserva->cadastroBasico($this->empresas_id, $this->pessoas_id, $_POST['data']);
            $_SESSION['Form']['reservas_id'] = $idReserva;
            
            $this->layout= 'null';
            $this->render();
            
            
        } catch (BusinessException $buEx) {
            $buEx->getBusinessMessage( $this, 'null' );
        } catch( Exception $ex ){
            
            if( $ex->getCode() == 2015 ){
                
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
                
            } else if( $ex->getCode() == 2018 ){
                $this->layout = 'null';
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'cadastroBloqueado')) );
                
            }else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    
    public function deletaCadastroInicio(){
        try {
            
            $data = join('-', array_reverse(explode('/', $_POST['data_inicio'])));
            
            if( $this->Reserva->deletaCadastroInicio($this->empresas_id, $this->pessoas_id, $data) ) {
                echo json_encode(array(
                    'style' => 'success',
                    'icon'  => 'check',
                    'title' => 'Atenção',
                    'message' => 'Esta data está liberada para uma nova reserva!',
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'sm',
                ));
            } else {
                echo json_encode(array(
                    'erro'  => 1,
                    'style' => 'warning',
                    'icon'  => 'warning',
                    'title' => 'ALERTA',
                    'message' => 'Não foi possivel liberar esta data para uma nova reserva, favor alterar o cadastro iniciado!',
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'md',
                ));
            }
            
        } catch (Exception $ex) {
            if( $ex->getCode() != 123456){
                echo json_encode(array(
                    'erro'  => 1,
                    'style' => 'danger',
                    'icon'  => 'times',
                    'title' => 'ALERTA',
                    'message' => $ex->getMessage(),
                    'button' => 'Fechar',
                    'time' => 5000,
                    'size' => 'sm',
                ));
            } else {
                echo json_encode(array(
                    'erro'  => 0,
                    'style' => 'null',
                ));
            }
        }
    }
    
    
    public function listar(){
        try {
            
            $this->checaEmpresa();
            $this->verificaContaEmpresa();
            $Modelambientes = new Ambiente();
            
            
            $usuariosEmpresa = array();
            $condicao = array();
            
            /**
             * 	SE O ROLE ID FOR Usuario ELE PEGA SOMENTE O Usuario SE NãoO OS USUARIOS DA EMPRESA
             */
            $registros = $this->Reserva->filtrar($this->empresas_id, null, date('Y-m-d') );
            
            $ambientes = $Modelambientes->find('all', array('empresas_id' => $this->empresas_id) );
            $mesasRestantes = $this->Reserva->reservasMesasRestantes($this->empresas_id, date('Y-m-d') );
            
            
            $urlPDF = 'http://snappypdf.com.br/gerar.php?url=' . Router::url(array('Reservas', 'imprimir' ));
            
            
            /**
             * listar as mesas por registro
             */
            $newRegistros = array();
            foreach ($registros as $registro) {
                   
                /**
                * recupero as mesas
                */
               $mesaModel = new Mesa();
               $mesas = $mesaModel->mesasReservas($registro['id']);
               $mesas = ($mesaModel->mesasReservasList($mesas, 'id'));
               $mesas = $mesaModel->selectIn($mesas);
               $arrayMesas = array('mesas' => join(', ', $mesas));

               $newRegistros[] = array_merge($registro, $arrayMesas);
                     
            }
            
            $this->set('registros', $newRegistros);
            
            $this->set('ambientes', $ambientes);
            $this->set('mesasRestantes', $mesasRestantes);
            $this->set('urlPDF', $urlPDF);
            //$this->set('qtdeReservas', $this->Reserva->countReservasExcedido( $this->empresas_id ) );
            $this->set('title_layout', 'Reservas -  Página Inicial');
            $this->render();
            
        } 
        catch (BusinessException $buEx) {
            $buEx->getBusinessMessage($this);
        } 
        catch( Exception $ex ){
            
            if( $ex->getCode() == 2015 ){
                
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
                
            } else if( $ex->getCode() == 2018 ){
                $this->layout = 'null';
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'cadastroBloqueado')) );
                
            }else {
                echo $ex->getMessage();
            }
            
        }
    }
    

    public function add() {
            $idReserva 						      = null;
            $_POST[$this->Reserva->name]['id']     = $_SESSION['Form']['reservas_id'];
            
            
            /**
             * recupero o id do meu cliente
             */
            $cliente = $this->Cliente->find('first', array('md5(id)' => $_POST[$this->Reserva->name]['clientes_id']));
            $_POST[$this->Reserva->name]['clientes_id'] = $cliente[0]['Cliente']['id'];
            $_POST[$this->Reserva->name]['title']  = $cliente[0]['Cliente']['nome'];
            $_POST[$this->Reserva->name]['status'] = 1;
            $_POST[$this->Reserva->name]['token']  = Authentication::uuid();
            
            /**
             * trabalho com as datas para ficar no padrão do fullcalendar 
             */
            $dataCallendar = Utils::convertDataSemHora($_POST[$this->Reserva->name]['data']) . ' ' . $_POST[$this->Reserva->name]['hora'];
            $_POST[$this->Reserva->name]['start'] = $dataCallendar;
            $_POST[$this->Reserva->name]['end']   = Utils::adicionaHora( 1, $dataCallendar );
            
            
            /**
             * retiro as mesas do node central
             */
            $mesas = $_POST[$this->Reserva->name]['mesas_id'];
            unset( $_POST[$this->Reserva->name]['mesas_id'] );
            
            
            
            $_POST[$this->Reserva->name]['empresas_id'] = $this->empresas_id;
            $_POST[$this->Reserva->name]['pessoas_id'] = $this->pessoas_id;
            //unset($_POST['Reserva']);

            
            $this->Reserva->data = $_POST[$this->Reserva->name];

            unset($_POST[$this->Reserva->name]['data']);
            unset($_POST[$this->Reserva->name]['hora']);
        
                    
        try {          
            /**
             * validacoes do formulario
             */
            if ($this->Reserva->validates()) {

//               Utils::pre($this->Reserva->data);
//               exit();
                
               $this->Reserva->genericUpdate( $_POST[$this->Reserva->name] );
               $idReserva = $_SESSION['Form']['reservas_id'];
               unset($_SESSION['Form']['reservas_id']);
               
               /**
                * INSERIR UM CONVIDADO NESSE CASO É O PROPRIO CLIENTE QUE ESTA SENDO FEITO A RESERVA
                */
               $this->Reserva->inserirConvidado( $_POST[$this->Reserva->name]['clientes_id'], $idReserva );
               
               /**
                * gravar mesas
                */
               $this->Reserva->mesasReservas($mesas, $idReserva, $_POST[$this->Reserva->name]['start']);
               
               
                /**
                 * recupero o salão e ambiente da reserva
                 */
                $dadoEmailReserva = $this->Reserva->recuperaDadosReservaEmail($idReserva);
               
                
                /**
                 * VERIFICO SE O CLIENTE TEM EMAIL CADASTRADO
                 */
                
                if( !empty($dadoEmailReserva[0]['email']) && (Session::read('Empresa.envio_sistema') == 1) ){
                    /**
                     * envio o email para o cliente cadastrado para inserir na lista os dados das pessoas relacionadas
                     */
                     $email = new Email();
                     $email->useTable = 'emails_sistema';
                     $registro = $email->find('first', array('tag' => 'cadastro_reserva'));

                     /**
                      * recupero o endereço da empresa
                      */
                     $endereco = $this->Endereco->findEnderecosEmpresa( $this->empresas_id );
                     $enderecoEmpresa = $endereco[0]['logradouro'] .', '.$endereco[0]['numero'] .' | '. $endereco[0]['cidade'] . ' - ' . $endereco[0]['bairro'] . ' - ' . $endereco[0]['uf'];

                     /**
                      * recupero as mesas
                      */
                     $mesaModel = new Mesa();
                     $mesas = $mesaModel->selectIn($mesas);



                     /**
                      * #faço a troca de siglas para personalizar o email
                      */

                     $dataMail = explode(' ', Utils::convertData( $dataCallendar ) );
                
                     
                    $email->useTable = 'empresas_email_parametros';
                    $email_parametros  = $email->find('first', array(
                        'emails_sistema_id' => 5,
                        'empresas_id'       => $this->empresas_id,
                    ));

                    $corpoEmailConfirmacao = $email->ajusteEmailConfirmacao( 
                            $registro[0]['Email']['corpo_mail'], 
                            $email_parametros[0][$email->name]
                            );
                     
                     
                     $array = array(
                        '__CLIENTE__'          => $cliente[0]['Cliente']['nome'],
                        '__DATE__'             => date('d/m/Y h:i:s'),
                        '__NOME_FANTASIA__'    => Session::read('Empresa.nome_fantasia'),
                        '__CONVIDADOS__'       =>  $_POST[$this->Reserva->name]['qtde_pessoas'],
                        '__LUGARES__'          =>  $_POST[$this->Reserva->name]['assentos'],
                        '__ENDERECO_EMPRESA__' => $enderecoEmpresa,
                        '__MESAS__'            => join(' - ', array_values($mesas)),
                        '__DATA_INICIO__'      => $dataMail[0],
                        '__HORAS_INICIO__'     => $dataMail[1],
                        '__SALAO__'            => $dadoEmailReserva[0]['salao'],
                        '__AMBIENTE__'         => $dadoEmailReserva[0]['ambiente'],
                        '__CAPACIDADE__'       => $dadoEmailReserva[0]['capacidade'],
                        '__URL_ATIVAR__'       => Router::url(array('Reservas', 'confirmReservaEmail',  $_POST[$this->Reserva->name]['token'] ))
                     );
                     
                     
                     #envio o email de confirmação para o meu cliente cadastrado

                     $objeto = new MailPHPMailer();

                     $objeto->setAssunto( 'Reserva: ' . Session::read('Empresa.nome_fantasia') );

                     //$objeto->setRemetente();

                     /**
                      *   CORPO DO EMAIL
                      */
                    $corpoEmailConfirmacao = str_replace(array_keys($array), array_values($array), $corpoEmailConfirmacao);
                    
                     
                     $objeto->setBody( $corpoEmailConfirmacao );

                     /**
                      *   DESTINO PARA QUEM VAI O EMAIL - CLIENTE
                      */
                     $objeto->setDestinatario( $dadoEmailReserva[0]['email'], $dadoEmailReserva[0]['cliente'] );
                     $emailEnvio = $objeto->sendMail();
                     
                     
                     /*if( $emailEnvio ){
                    
                        $gravaEmail = array(
                                'reservas_id' => $idReserva,
                                'empresas_id' => $_POST[$this->Reserva->name]['empresas_id'],
                                'pessoas_id'  => $this->pessoas_id,
                                'clientes_id' => $_POST[$this->Reserva->name]['clientes_id'],
                                'created' => date('Y-m-d H:i:s'),
                                'status' => 1
                        );
                         
                        $this->Reserva->gravaEnvioEmail( $gravaEmail );

                    }*/
                     
                }
               
               
                echo json_encode(array(
                    'funcao' => "sucessoForm( 'Cadastro efetuado com sucesso!', '#ReservaAddForm' ); "
                    . "window.location.reload();",
                   ));

               
            } else {
                echo json_encode(array(
                    'erros' => $this->Reserva->validateErros,
                    'form' => 'ReservaAddForm',
                ));
            }
        } catch (SystemException $ex) {
            echo $ex->getErrorJson('#ReservaAddForm');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editar() {
        try {

            $modelSalao    = new Salao();
            $modelAmbiente = new Ambiente();
            $modelMesa     = new Mesa();
            $this->layout  = 'null';
			
            $usuariosEmpresa = array();
            $condicao = array();
            $id = (int) $_POST['id'];
			
            $_SESSION['Form']['reservas_id'] = (int) $_POST['id'];
	
            /**
             * recupero minha reserva
             */
            $lista = $this->Reserva->find('first', array('empresas_id' => $this->empresas_id, 'id' => $id));

            
            
            $data = explode(' ', $lista[0]['Reserva']['start']);
            $lista[0]['Reserva']['start'] = Utils::convertData($data[0]);
            $lista[0]['Reserva']['end']   = ($data[1]);
            
                        
            /**
             * recupero o cliente da reserva
             */
            $cliente = $this->Cliente->find( 'first', array('id' =>  $lista[0]['Reserva']['clientes_id']  ) );
            
            /**
             * recupero meu salão da empresa 
             */
            $salao = $modelSalao->find('all', array('empresas_id' => $this->empresas_id, 'status' => true));
            /**
             * 	recupero os ambientes de um determinado salao
             */
            $ambientes = $modelAmbiente->find('all', array('saloes_id' => $lista[0]['Reserva']['saloes_id'], 'status' => true ) );
            /**
             * recupero as mesas do ambiente cadastrado e recupero as mesas cadastrada para a reserva
             */
            
            $mesas = $modelMesa->mesasReservadasDisponiveis(  (int) $lista[0]['Reserva']['ambientes_id'], (int) $_POST['id'], $data[0] );
            $mesas = $this->montarArray( $mesas );
            $mesasReservadas = $modelMesa->mesasReservas( (int) $_POST['id'] );
            
            
            $this->set('mesasReservadas',$this->lista($mesasReservadas));
            $this->set('saloes', $salao);
            $this->set('mesas', $mesas);
            $this->set('ambientes', $ambientes);
            $this->set('cliente', $cliente);
            $this->set('lista', ($lista[0]) );
            
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function edit() {
            $idReserva 						      = null;
            $_POST[$this->Reserva->name]['id']     = $_SESSION['Form']['reservas_id'];
            
                    
            /**
             * recupero o id do meu cliente
             */
            $cliente = $this->Cliente->find('first', array('md5(id)' => $_POST[$this->Reserva->name]['clientes_id']));
            
                        
            $_POST[$this->Reserva->name]['clientes_id'] = $cliente[0]['Cliente']['id'];
            $_POST[$this->Reserva->name]['title']  = $cliente[0]['Cliente']['nome'];
            $_POST[$this->Reserva->name]['status'] = 1;
            $_POST[$this->Reserva->name]['token']  = Authentication::uuid();
            
            /**
             * trabalho com as datas para ficar no padrão do fullcalendar 
             */
            $dataCallendar = Utils::convertDataSemHora(trim($_POST[$this->Reserva->name]['data'])) . ' ' . $_POST[$this->Reserva->name]['hora'];
            $_POST[$this->Reserva->name]['start'] = $dataCallendar;
            $_POST[$this->Reserva->name]['end']   = Utils::adicionaHora( 1, $dataCallendar );
            
            
            /**
             * retiro as mesas do node central
             */
            $mesas = $_POST[$this->Reserva->name]['mesas_id'];
            unset( $_POST[$this->Reserva->name]['mesas_id'] );
            
            
            
            $_POST[$this->Reserva->name]['empresas_id'] = $this->empresas_id;
            $_POST[$this->Reserva->name]['pessoas_id'] = $this->pessoas_id;
            //unset($_POST['Reserva']);

            
            $this->Reserva->data = $_POST[$this->Reserva->name];

            unset($_POST[$this->Reserva->name]['data']);
            unset($_POST[$this->Reserva->name]['hora']);
        
            
            //Utils::pre($_POST); exit;
            
        try {          
            /**
             * validacoes do formulario
             */
            if ($this->Reserva->validates()) {

                
               $this->Reserva->genericUpdate( $_POST[$this->Reserva->name] );
               $idReserva = $_SESSION['Form']['reservas_id'];
               unset($_SESSION['Form']['reservas_id']);
               /**
                * gravar mesas
                * a regra na edição é deletar todas a mesas da reserva e depois inserir novamente
                */
               $this->Reserva->deletaMesas($idReserva);
               $this->Reserva->mesasReservas($mesas, $idReserva, $_POST[$this->Reserva->name]['start']);
                
               echo json_encode(array(
                   'funcao' => "sucessoForm( 'Sua alteração efetuada com sucesso!', '#ReservaAddForm' ); "
                   . "window.location.reload();",
                ));

               
            } else {
                echo json_encode(array(
                    'erros' => $this->Reserva->validateErros,
                    'form' => 'ReservaAddForm',
                ));
            }
        } catch (SystemException $ex) {
            echo $ex->getErrorJson('#ReservaAddForm');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function perfil() {
        try {
            
            $this->layout = 'null';
            $lista = $this->Reserva->perfil(md5(($_POST['id'])));
            $mesas = $this->Reserva->listarMesasReservas( $lista['id'] );
            
            $urlPDF = "http://snappypdf.com.br/gerar.php?url=" . Router::url(array('Reservas', 'imprimir', md5($lista['id']) ));
            
            
            $this->set('lista', $lista);
            $this->set('urlPDF', $urlPDF);
            $this->set('mesas', $this->montarArray($mesas));
            $this->render();
            
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function imprimir() {
        try {

            $this->layout = 'imprimir';
            $lista = $this->Reserva->perfil( ($_GET['param']));
            $mesas = $this->Reserva->listarMesasReservas( $lista['id'] );

            $this->set('lista', $lista);
            $this->set('mesas', $this->montarArray($mesas));
            
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function listAllEmpresas() {
        try {

//            if (in_array(Session::read('Usuario.roles_id'), array(3,4))) {
                $lista = $this->Reserva->listAllEmpresas($this->empresas_id);
//            } else {
//                $lista = $this->Reserva->listAllEmpresas($this->empresas_id, $this->pessoas_id);
//            }
            echo json_encode($lista);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function filtrar() {
        try {
            $this->layout = 'null';
            $dataFim = null;
            $dataInicio = null;

            if (!empty($_POST['data_inicio'])) {
                $dataInicio = Utils::revertDate($_POST['data_inicio']);
            }
            if (!empty($_POST['data_fim'])) {
                $dataFim = Utils::revertDate($_POST['data_fim']);
            }

            
            $urlPDF = 'http://snappypdf.com.br/gerar.php?url=' . Router::url(array('Reservas', 'imprimir' ));
            
            $registros = $this->Reserva->filtrar($this->empresas_id, $_POST['ambientes_id'], $dataInicio, $dataFim, NULL);
            
            
            $newRegistros = array();
            
            
            
            foreach ($registros as $registro) {
                   
                /**
                * recupero as mesas
                */
               $mesaModel = new Mesa();
               $mesas = $mesaModel->mesasReservas($registro['id']);
               $mesas = ($mesaModel->mesasReservasList($mesas, 'id'));
               $mesas = $mesaModel->selectIn($mesas);
               $arrayMesas = array('mesas' => join(', ', $mesas));

               $newRegistros[] = array_merge($registro, $arrayMesas);
                     
            }
            
            $this->set('registros', $newRegistros);
            $this->set('urlPDF', $urlPDF);
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function cancelarRegistro() {
        try {

            $token = $_POST['id'];
            
            if ( $this->Reserva->cancelarRegistro( $token ) ) {
                
                /**
                * recupero o id da reserva e libero as mesas para cadastro em outra reserva 
                */
                $reserva   = $this->Reserva->find('first', array('token' => $token ));
                $reservaId = $reserva[0][$this->Reserva->name]['id'];
               
                $this->Reserva->deletaMesas($reservaId);
                
                echo json_encode(array(
                        'message' => 'Registro cancelado com sucesso!',
                        "style" =>'success',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => 'window.location.reload();',
                        'before' => "$('#loading').fadeOut(500);",
                        'icon'   => 'check',
                        'title'  => 'Sucesso no envio!'
                    ));
                
            } else {
                echo json_encode(array(
                        'message' => 'Não foi possivel cancelar o registro, tente novamente mais tarde!',
                        "style" =>'warning',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => "window.location.reload();",
                        'before' => "$('#loading').fadeOut(500);",
                        'icon'   => 'warning',
                        'title'  => 'Sucesso no envio!'
                    ));
            }
        } catch (Exception $ex) {
           echo json_encode(array(
                        'message' => $ex->getMessage(),
                        "style" =>'danger',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => "window.location.reload();",
                        'before' => "$('#loading').fadeOut(500);",
                        'icon'   => 'times',
                        'title'  => 'Sucesso no envio!'
                    ));
        }
    }

   
    public function cadastroContinuacao(){
        try {
            $this->layout = 'null';
            $modelSalao = new Salao();
            $salao = $modelSalao->find('all', array('empresas_id' => $this->empresas_id, 'status' => true ));
            $this->set('saloes', $salao);
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function reservasMes(){
        $id = $_POST['empresas_id'];
        $reservas = $this->Reserva->find('all', array('empresas_id' => $id, "concat(year(start), '-', month(start))" => date('Y-n'), 'status' => true));
        echo json_encode(array(
            'qtde' => count($reservas),
        ));
    }
    
    
    public function graficoCasas(){
        $id = $_POST['empresas_id'];
        $reservas = $this->Reserva->graficoCasas( $this->pessoas_id, Session::read('Usuario.roles_id') );
        echo json_encode($reservas);
    }
    
    
    public function envioEmail(){
        try {
            
            $this->layout = 'null';
            
            $token = $_GET['param'];
        
            $reserva = $this->Reserva->find('first', array('token' => $token ));
            $reserva = array_shift($reserva);

            
            /**
            * recupero o salão e ambiente da reserva
            */
            $dadoEmailReserva = $this->Reserva->recuperaDadosReservaEmail($reserva['Reserva']['id']);
            $cliente = $this->Cliente->find('first', array('id' => $reserva['Reserva']['clientes_id']));
            

           /**
            * VERIFICO SE O CLIENTE TEM EMAIL CADASTRADO
            */

           if( !empty($dadoEmailReserva[0]['email']) && (Session::read('Empresa.envio_sistema') == 1) ){
               /**
                * envio o email para o cliente cadastrado para inserir na lista os dados das pessoas relacionadas
                */
                $email = new Email();
                $email->useTable = 'emails_sistema';
                if( in_array(Session::read('ContaEmpresa.contas_empresas_tipos_id'), array(1,3,5) ) ){
                    $registro = $email->find('first', array('tag' => 'email_confirmacao'));
                } else {
                    $registro = $email->find('first', array('tag' => 'email_confirmacao'));
                }
                /**
                 * recupero o endereço da empresa
                 */
                $endereco = $this->Endereco->findEnderecosEmpresa( $this->empresas_id );
                $enderecoEmpresa = $endereco[0]['logradouro'] .', '.$endereco[0]['numero'] .' | '. $endereco[0]['cidade'] . ' - ' . $endereco[0]['bairro'] . ' - ' . $endereco[0]['uf'];
                
                
                
                
                /**
                 * recupero as mesas
                 */
                $mesaModel = new Mesa();
                $mesas = $mesaModel->mesasReservas($reserva['Reserva']['id']);
                $mesas = ($mesaModel->mesasReservasList($mesas, 'id'));
                $mesas = $mesaModel->selectIn($mesas);

                
                /**
                 * #faço a troca de siglas para personalizar o email
                 */
                $dataMail = explode(' ', Utils::convertData( $reserva['Reserva']['start'] ) );
                
                
                $email->useTable = 'empresas_email_parametros';
                $email_parametros  = $email->find('first', array(
                    'emails_sistema_id' => 5,
                    'empresas_id'       => $this->empresas_id,
                ));

                $corpoEmailConfirmacao = $email->ajusteEmailConfirmacao( 
                        $registro[0]['Email']['corpo_mail'], 
                        $email_parametros[0][$email->name]
                        );
                
                
                
                $array = array(
                    '__CLIENTE__'          => $cliente[0]['Cliente']['nome'],
                    '__DATE__'             => date('d/m/Y h:i:s'),
                    '__NOME_FANTASIA__'    => Session::read('Empresa.nome_fantasia'),
                    '__CONVIDADOS__'       => $reserva['Reserva']['qtde_pessoas'],
                    '__LUGARES__'          => $reserva['Reserva']['assentos'],
                    '__ENDERECO_EMPRESA__' => $enderecoEmpresa,
                    '__MESAS__'            => join(' - ', array_values($mesas)),
                    '__DATA_INICIO__'      => $dataMail[0],
                    '__HORAS_INICIO__'     => $dataMail[1],
                    '__SALAO__'            => $dadoEmailReserva[0]['salao'],
                    '__AMBIENTE__'         => $dadoEmailReserva[0]['ambiente'],
                    '__CAPACIDADE__'       => $dadoEmailReserva[0]['capacidade'],
                    '__URL_ATIVAR__'       => Router::url(array('Reservas', 'confirmReservaEmail', $reserva['Reserva']['token'] ))
                );

                #envio o email de confirmação para o meu cliente cadastrado

                $objeto = new MailPHPMailer();

                $objeto->setAssunto( 'Confirmação : ' . Session::read('Empresa.nome_fantasia') );

                //$objeto->setRemetente();

                /**
                 *   CORPO DO EMAIL
                 */
                
                $corpoEmailConfirmacao = str_replace(array_keys($array), array_values($array), $corpoEmailConfirmacao);
                    
                
                
                $objeto->setBody( $corpoEmailConfirmacao );

                /**
                 *   DESTINO PARA QUEM VAI O EMAIL - CLIENTE
                 */
                $objeto->setDestinatario( $dadoEmailReserva[0]['email'], $dadoEmailReserva[0]['cliente'] );
                $emailEnvio = $objeto->sendMail();
                
                
                
                
                if( $emailEnvio ){
                    
                    $gravaEmail = array(
                            'reservas_id' => $reserva['Reserva']['id'],
                            'empresas_id' => $reserva['Reserva']['empresas_id'],
                            'pessoas_id'  => $this->pessoas_id,
                            'clientes_id' => $reserva['Reserva']['clientes_id'],
                            'created' => date('Y-m-d H:i:s'),
                            'status' => 1
                    );
                    
                    /**
                     * inserindo na tabela o envio do email
                     */
                    $this->Reserva->gravaEnvioEmail( $gravaEmail );
                    
                    echo json_encode(array(

                        'message' => 'Email enviado com sucesso!',
                        "style" =>'success',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => false,
                        'before' => "$('#loading').fadeOut(500);",
                        'icon'   => 'check',
                        'title'  => 'Sucesso no envio!'

                    ));
                } else {
                    $gravaEmail = array(
                            'reservas_id' => $reserva['Reserva']['id'],
                            'empresas_id' => $reserva['Reserva']['empresas_id'],
                            'pessoas_id'  => $this->pessoas_id,
                            'clientes_id' => $reserva['Reserva']['clientes_id'],
                            'created' => date('Y-m-d H:i:s'),
                            'status' => 0
                    );
                    
                    /**
                     * inserindo na tabela o envio do email
                     */
                    $this->Reserva->gravaEnvioEmail( $gravaEmail );
                    
                    echo json_encode(array(
                    
                        'message' => 'Problema no servidor de envio dos emails, contate o suporte.',
                        "style" =>'warning',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => false,
                        'before' => "$('#loading').fadeOut(500);",
                        'icon'   => 'times',
                        'title'  => 'Falha no envio!'

                    ));
                    
                }
                
           } else {
            
                echo json_encode(array(
                    
                    'message' => 'Não foi possivel reenviar seu email tente novamente mais tarde ou avise o suporte.',
                    "style" =>'danger',
                    'time' => 5000,
                    'size' => 'sm',
                    'callback' => false,
                    'before' => false,
                    'icon'   => 'times',
                    'title'  => 'Falha no envio!'
                                
                ));
                
           }
            
        } catch (Exception $ex) {
            echo json_encode(array(
                
                'message' => $ex->getMessage(),
                "style" =>'danger',
                'time' => 5000,
                'size' => 'sm',
                'callback' => false,
                'before' => false,
                'icon'   => 'times',
                'title'  => 'Falha no envio!'
                        
            ));
            
        }
    }
    
    
    
    protected function montarArray( $mesas, $node = NULL ){
        $newArray = array();
        $newMiddle = array();
        $interacao = 1;
        $interacaoTotal = 1;
        $totalNode = 5;
        foreach ( $mesas as $mesa ){
            
            if( is_null($node) ) {
                $newArray[$mesa['id']] = $mesa['nome']; 
            } else {
                $newArray[$mesa[$node]['id']] = $mesa[$node]['nome']; 
            }
            
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
    
    
    protected function lista( array $array, $node = NULL ){
        $newArray = array();
        foreach ($array as $lista ){
            if( $node != NULL ){
                $newArray[ $lista[$node]['id'] ] = $lista[$node]['nome'];
            } else {
                $newArray[ $lista['id'] ] = $lista['nome'];
            }
        }
        return $newArray;
    }
    
    final public function confirmReserva(){
        try {
            
            if( $this->is('post') ){
                $token = $_POST['token'];
            } else {
                $token = $_GET['param'];
            }
            
            
            if ( $this->Reserva->confirmReserva( $token ) ) {
                             
                echo json_encode(array(

                        'message' => 'Reserva foi confirmada pelo painel administrativo!',
                        "style" =>'success',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => false,
                        'before' => "$('#loading').fadeOut(1000);",
                        'icon'   => 'check',
                        'title'  => 'Sucesso!'

                    ));
                
                
            } else {
                
                echo json_encode(array(
                    
                    'message' => 'Não foi possivel cancelar o registro, tente novamente mais tarde!',
                    "style" =>'warning',
                    'time' => 5000,
                    'size' => 'sm',
                    'callback' => false,
                    'before' => "$('#loading').fadeOut(1000);",
                    'icon'   => 'warning',
                    'title'  => 'Falha!'
                                
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                    
                'message' => $ex->getMessage(),
                "style" =>'danger',
                'time' => 5000,
                'size' => 'sm',
                'callback' => false,
                'before' => "$('#loading').fadeOut(1000);",
                'icon'   => 'times',
                'title'  => 'Falha no servidor!'

            ));
        }
    }
    
    
    final public function confirmReservaEmail(){
        try {
            $token = $_GET['param'];
            
            
            /**
             * validação de tempo 
             */
            $this->Reserva->confirmReserva( $token );
            
            /**
             *  VERIFICAR SE O TEMPO DECORRIDO ESTÁ EM PRAZO PARA CADASTRO DE CONVIDADOS NA DATA CORRENTE
             */
            $reserva = $this->Reserva->find('all', array('token' => $token, 'status' => 1));
            $reserva = array_shift($reserva);
            
            
            $cliente      = $this->Cliente->find('first', array('id' => $reserva['Reserva']['clientes_id']));
            $empresa      = $this->Empresa->findEmpresa($reserva['Reserva']['empresas_id']);
            $contaEmpresa = $this->Empresa->contaEmpresa(md5($reserva['Reserva']['empresas_id']));
            
            /**
            * recupero as mesas
            */
           $mesaModel = new Mesa();
           $mesas = $mesaModel->mesasReservas($reserva['Reserva']['id']);
           $mesas = ($mesaModel->mesasReservasList($mesas, 'id'));
           $mesas = $mesaModel->selectIn($mesas);
            
           
           $dadoEmailReserva = $this->Reserva->recuperaDadosReservaEmail($reserva['Reserva']['id']);
           
           
           /**
            * recupero o endereço da empresa
            */
           $endereco = $this->Endereco->findEnderecosEmpresa( $reserva['Reserva']['empresas_id'] );
           $enderecoEmpresa = $endereco[0]['logradouro'] .', '.$endereco[0]['numero'] .' | '. $endereco[0]['cidade'] . ' - ' . $endereco[0]['bairro'] . ' - ' . $endereco[0]['uf'];

           
           
           
           if(in_array($contaEmpresa[0]['contas_empresas_tipos_id'], array(1,3,5))){  
                $convidados = $this->Reserva->convidados($reserva['Reserva']['id']);
                $this->set('convidados', $convidados);
           }
            
            
            $this->set('reserva', $reserva);
            $this->set('contaEmpresa', $contaEmpresa[0]);
            $this->set('cliente', array_shift($cliente));
            $this->set('empresa', array_shift($empresa));
            $this->set('mesas', join(', ',$mesas));
            $this->set('dadoEmailReserva', $dadoEmailReserva);
            $this->set('enderecoEmpresa', $enderecoEmpresa);
            
            
            $this->set('title_layout', 'Reservas -  Cliente');
            $this->render(array('controller' => 'Clientes','view' => 'minhaReserva'), 'cliente');
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    final public function disponibilidadeMesas(){
        try {
            $this->layout = 'null';
            
            $data = Utils::convertData($_POST['data']);
            
            $mesasRestantes = $this->Reserva->reservasMesasRestantes($this->empresas_id, $data );
            
            $this->set('mesasRestantes', $mesasRestantes);
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    final public function relatorio(){
        try {
            
            $Modelambientes = new Ambiente();
            $ModelJuridica  = new Juridica();
            $this->layout = 'imprimir';
            
            $parametros = explode('/', $_GET['param']);
            $dataFiltro = $parametros[0];
            $ambienteId = $parametros[1];
            $empresasId = $parametros[2];
            
            $usuariosEmpresa = array();
            $condicao = array();
            
            /**
             * 	SE O ROLE ID FOR Usuario ELE PEGA SOMENTE O Usuario SE NãoO OS USUARIOS DA EMPRESA
             */
            $empresasId = $this->Empresa->find('first', array('md5(id)' => $empresasId));
            
            $empresasId = array_shift(array_shift($empresasId));
            
            $registros         = $this->Reserva->filtrar($empresasId['id'], $ambienteId, $dataFiltro );
            
            $i = 0;
            foreach ($registros as $value) {
                $registros[$i]['lista_convidados'] = $this->Reserva->listaConvidados($value['token']);
                $i++;
            }
                        
            
            $empresaJuridica   = $ModelJuridica->find('first', array('id' => $empresasId['pessoaJuridica_id']));
            $empresaJuridica   = array_merge($empresaJuridica[0]['Juridica'], $empresasId);
            
            /**
             * listar as mesas por registro
             */
            $newRegistros = array();
            foreach ($registros as $registro) {
                   
                /**
                * recupero as mesas
                */
               $mesaModel = new Mesa();
               $mesas = $mesaModel->mesasReservas($registro['id']);
               $mesas = ($mesaModel->mesasReservasList($mesas, 'id'));
               $mesas = $mesaModel->selectIn($mesas);
               $arrayMesas = array('mesas' => join(', ', $mesas));

               $newRegistros[] = array_merge($registro, $arrayMesas);
                     
            }
            
            $this->set('registros', $newRegistros);
            $this->set('empresaJuridica', $empresaJuridica);
            $this->set('dataReserva', Utils::convertDataSemHora($parametros[0]));
            
            $this->set('title_layout', 'Reservas -  Página Inicial');
            $this->render();
            
        } catch( Exception $ex ){
            
            if( $ex->getCode() == 2015 ){
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
            } else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    public function adicionarConvidados( array $Convidado = NULL, $token = NULL ){
        try {
            
            if( $this->is('post') && empty($Convidado)){
                $cliente[$this->Cliente->name] = $_POST[$this->Cliente->name];
                $cliente[$this->Cliente->name]['telefone'] = Utils::returnNumeric($cliente[$this->Cliente->name]['telefone']);
                

                $reserva = $this->Reserva->find('first', array('token' => $_POST['Reserva']['token']));
                $reserva = array_shift($reserva);
                $reservaId = $reserva['Reserva']['id'];

                $cliente[$this->Cliente->name]['empresas_id'] = $reserva['Reserva']['empresas_id'];

                $this->Cliente->data = $cliente[$this->Cliente->name];

                            $this->Cliente->validate = $this->Cliente->validate_convidados;

                if( $this->Cliente->validates() ){
                    /**
                     * verificar a quantidade de vagas e se excedeu o limit
                     */
                    $this->Reserva->verificarLimiteDeConvidados($reservaId);
                    /**
                     * cadastro o meu cliente
                     */
                    $clienteId = $this->Cliente->cadastroDeClientes( $cliente[$this->Cliente->name] );
                    /**
                     * vincular o cliente a reserva
                     */
                    $this->Reserva->inserirConvidado($clienteId, $reservaId);


                    $alert = json_encode(array(

                                'message' => 'Seu convidado foi registrado com sucesso',
                                "style" =>'success',
                                'time' => 5000,
                                'size' => 'sm',
                                //'callback' => "window.location.reload();",
                                'callback' => "chamaListaDeConvidadosAdminEpdf( '".Router::url(array( 'Reservas', 'listarConvidados' , $_POST['Reserva']['token']))."' ); $('#body-lista-convidados').empty(); loadingElement('<br><b>Carregando a lista de Convidados</b>', '#body-lista-convidados');",
                                'before' => "$('#loading').fadeOut(1000);",
                                'icon'   => 'check',
                                'title'  => 'Sucesso!'
                            ));

                    echo json_encode(array(
                       'funcao' => "bootsAlert( " .$alert. " ); ",
                    ));


                } else {
                    echo json_encode(array(
                        'erros' => $this->Cliente->validateErros,
                        'form' => 'ClienteAddForm',
                    ));
                }
            } else {
                
                /**
                 * foi chamada a ação
                 */
                $this->Cliente->data = null;
                
                $cliente[$this->Cliente->name] = $Convidado;
                $cliente[$this->Cliente->name]['telefone'] = Utils::returnNumeric( trim($cliente[$this->Cliente->name]['celular']) );
                $cliente[$this->Cliente->name]['nome']     = utf8_encode(trim($cliente[$this->Cliente->name]['nome']));
                $cliente[$this->Cliente->name]['email']    = trim($cliente[$this->Cliente->name]['email']);
                $cliente[$this->Cliente->name]['dt_nascimento']    = utf8_encode(trim($cliente[$this->Cliente->name]['dt_nascimento']));
                
                unset($cliente[$this->Cliente->name]['celular']);
                
                $reserva = $this->Reserva->find('first', array('token' => $token));
                $reserva = array_shift($reserva);
                $reservaId = $reserva['Reserva']['id'];

                $cliente[$this->Cliente->name]['empresas_id'] = $reserva['Reserva']['empresas_id'];

                $this->Cliente->data = $cliente[$this->Cliente->name];
                
                
                try {
                    
                    /**
                     * cadastro o meu cliente
                     */
                    $clienteId = $this->Cliente->cadastroDeClientes( $cliente[$this->Cliente->name] );
                    /**
                     * vincular o cliente a reserva
                     */
                    $this->Reserva->inserirConvidado($clienteId, $reservaId);
                    
                    return $clienteId;
                    
                } catch (Exception $ex) {
                    throw $ex;
                } 
            }
            
        } catch (Exception $ex) {
            $alert = json_encode(array(
                    
                'message' => $ex->getMessage(),
                "style" =>'danger',
                'time' => 5000,
                'size' => 'sm',
                'callback' => false,
                'before' => "$('#loading').fadeOut(1000);",
                'icon'   => 'times',
                'title'  => 'Atenção!'

            ));
			
			echo json_encode(array(
                   'funcao' => "bootsAlert( " .$alert. " ); ",
                ));
			
        }
    }
    
    
    public function desvincularConvidado(){
        try {
            /**
             * hash
             */
            $token     = $_POST['token'];
            $clienteId = $_POST['clienteId'];
            
            /**
             * recupero a minha reserva
             */
            
            $reserva = $this->Reserva->find('first', array('token' => $token));
            $reserva = array_shift($reserva);
            /**
             * recupero meu cliente
             */
            $cliente = $this->Cliente->find('first', array('md5(id)' => $clienteId));
            $cliente = array_shift($cliente);
            
            if( !empty($cliente) && !empty($reserva)){
                
                /**
                 * desvincular o cliente da reserva.
                 */
                
                $this->Reserva->desvincularConvidado($cliente[$this->Cliente->name]['id'], $reserva[$this->Reserva->name]['id']);
                
                echo json_encode(array(

                            'message' => 'Seu convidado desvinculado com sucesso',
                            "style" =>'success',
                            'time' => 5000,
                            'size' => 'sm',
                            //'callback' => "window.location.reload();",
                            'callback' => "chamaListaDeConvidadosAdminEpdf( '".Router::url(array( 'Reservas', 'listarConvidados' , $token ))."' ); $('#body-lista-convidados').empty(); loadingElement('<br><b>Carregando a lista de Convidados</b>', '#body-lista-convidados');",
                            'before' => "$('#loading').fadeOut(1000);",
                            'icon'   => 'check',
                            'title'  => 'Sucesso!'

                        ));
            }
            
            
        } catch (Exception $ex) {
            echo json_encode(array(
                    
                'message' => $ex->getMessage(),
                "style" =>'danger',
                'time' => 5000,
                'size' => 'sm',
                'callback' => false,
                'before' => "$('#loading').fadeOut(1000);",
                'icon'   => 'times',
                'title'  => 'Atenção!'

            ));
        }
    }
 
    public function listarConvidados(){
        
        if( Session::check('Usuario')){
            $this->layout = 'null';
        } else {
            $this->layout = 'imprimir';
        }
        
        $token = $_GET['param'];
        
        $convidados = $this->Reserva->listaConvidados($token);
        
        $urlPDF = 'http://snappypdf.com.br/landscape.php?url=' . Router::url(array('Reservas', 'listarConvidados', $token )) . '&landscape=1';
        
        $this->set('convidados', $convidados);
        $this->set('token', $token);
        $this->set('urlPDF', $urlPDF);
        $this->render();
    }
    
    
    public function adicionarListaConvidados(){
        try {
            
            $name = $_FILES['arquivo']['name'];
            $token = $_POST['token'];
            
            if( empty($_FILES) ){
                throw new Exception('Por favor insira um arquivo válido!');
            }
            if( $_FILES['arquivo']['type'] !== 'application/vnd.ms-excel' ){
                throw new Exception('Apenas arquivos com o tipo .CSV são permitidos');
            }
            if( $_FILES['arquivo']['error'] > 0 ){
                throw new Exception('Houve algum erro inesperado no envio do arquivo para o servidor');
            }
            
            /**
             * caminho do servidor
             */
            $path = ROOT . '/View/webroot/arquivos';
            /**
             * crio a pasta da empresa
             */
            
            $pasta = 'empresa_' . $this->empresas_id;
            
            /**
             * caminho completo 
             */
            $path = $path . DS . $pasta;
            
            /**
             * crio a pasta em arquivos se ela não existir
             */
            if(!file_exists($path)){
                echo $path;
                mkdir($path, 0777);
            }
            
            if( move_uploaded_file($_FILES['arquivo']['tmp_name'], $path.DS.$name) ){ 
                $readFile = new File($name, $path);
                
                /**
                 * VERIFICAR A DISPONIBILIDADE DE VAGAS SE ELA EXCEDEU A QUANTIDADE E RETORNAR O QUANTO AINDA RESTA
                 */
                
                foreach ($readFile->getArquivo() as $convidado) {
                
                    $array[] = $this->adicionarConvidados($convidado, $token);
                    
                }
                
                
                $json = json_encode(array(
                    'message' => 'Parabéns sua lista de convidados foi inserida com sucesso!',
                    "style" =>'success',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => "chamaListaDeConvidadosAdminEpdf( '".Router::url(array( 'Reservas', 'listarConvidados' , $token))."' ); $('#body-lista-convidados').empty(); loadingElement('<br><b>Carregando a lista de Convidados</b>', '#body-lista-convidados');",
                    'before' => "$('#loading').fadeOut(1000);",
                    'icon'   => 'check',
                    'title'  => 'Sucesso no cadastro de convidados'
                ));
                echo json_encode(array(
                    'funcao' => "bootsAlert( $json );",
                ));
                
                
            }
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" =>'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => false,
                'before' => "$('#loading').fadeOut(1000);",
                'icon'   => 'times',
                'title'  => 'Atenção!'
            ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
        }
    }
    
    
    public function cadastraConvidado(){
        try {
            
            $this->layout = 'null';
            $this->set('token', $_POST['token']);
            $this->render();
            
        } catch (Exception $ex) {
            
        }
    }
    
    
    public function confirmPresencaConvite(){
        try {
            
            if( $this->Reserva->confirmPresencaConvite(intval($_POST['clientes_id']), intval($_POST['reservas_id'])) )
            {
                $json = json_encode(array(
                    'message' => 'Confirmação efetuada com sucesso',
                    "style" =>'success',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => NULL,
                    'before' => "$('#loading').fadeOut(1000);",
                    'icon'   => 'check',
                    'title'  => 'Sucesso no cadastro de convidados'
                ));
                echo json_encode(array(
                    'funcao' => "bootsAlert( $json );",
                ));
            } 
            else
            {
                $json = json_encode(array(
                    'message' => 'Houve algum erro no processo!',
                    "style" =>'warning',
                    'time' => 5000,
                    'size' => 'md',
                    'callback' => NULL,
                    'before' => "$('#loading').fadeOut(1000);",
                    'icon'   => 'check',
                    'title'  => 'Atenção!'
                ));
                echo json_encode(array(
                    'funcao' => "bootsAlert( $json );",
                ));
            }
            
        } catch (Exception $ex) {
            $json = json_encode(array(
                'message' => $ex->getMessage(),
                "style" =>'danger',
                'time' => 5000,
                'size' => 'md',
                'callback' => false,
                'before' => "$('#loading').fadeOut(1000);",
                'icon'   => 'times',
                'title'  => 'Atenção!'
            ));
            echo json_encode(array(
                'funcao' => "bootsAlert( $json )",
            ));
        }
        
    }
    
    
    public function reservasDoDia(){
        try {
            
            $this->checaEmpresa();
            $this->verificaContaEmpresa();
            
            $this->set('title_layout', 'Reservas -  Página Inicial');
            $this->render();
            
        } 
        catch (BusinessException $buEx) {
            $buEx->getBusinessMessage($this);
        } 
        catch( Exception $ex ){
            
            if( $ex->getCode() == 2015 ){
                
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
                
            } else if( $ex->getCode() == 2018 ){
                $this->layout = 'null';
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'cadastroBloqueado')) );
                
            }else {
                echo $ex->getMessage();
            }
            
        }
    }
    
    public function filtrarConvidados(){
        try {
         
            $this->layout = 'null';
            
            $nome = Utils::sanitazeString($_POST['nome']);
            
            $registros = $this->Reserva->buscaConvidadoHostess( $nome, date('Y-m-d'), $this->empresas_id );
                
            /**
             * listar as mesas por registro
             */
            
            $newRegistros = array();
            foreach ($registros as $registro) {
                   
                /**
                * recupero as mesas
                */
               $mesaModel = new Mesa();
               $mesas = $mesaModel->mesasReservas($registro['reservas_id']);
               $mesas = ($mesaModel->mesasReservasList($mesas, 'id'));
               $mesas = $mesaModel->selectIn($mesas);
               $arrayMesas = array('mesas' => join(', ', $mesas));

               $arrayMesas = array_merge($arrayMesas, $this->Reserva->confirmadosParaEvento( $registro['reservas_id'] ));
               $newRegistros[] = array_merge($registro, $arrayMesas);
            }
            
            
            $this->set('registros',$newRegistros);
            $this->render();
            
        } catch (Exception $ex) {
            print_r($ex->getTrace());
        }
    }
    
    
    public function listarConvidadosHostess(){
        try {
            
            if( $this->is('post'))
            {
                
                if( $this->Reserva->confirmPresencaConvite(intval($_POST['clientes_id']), intval($_POST['reservas_id'])))
                {
                    $json = json_encode(array(
                        'message' => 'Confirmação efetuada com sucesso',
                        "style" =>'success',
                        'time' => 5000,
                        'size' => 'md',
                        'callback' => NULL,
                        //'before' => "$('#loader-painel').empty();$('#tabela-dinamica').show();",
                        'before' => "window.location.reload();",
                        'icon'   => 'check',
                        'title'  => 'Sucesso no cadastro de convidados'
                    ));
                    echo json_encode(array(
                        'funcao' => "bootsAlert( $json );",
                    ));
                } 
                else
                {
                    $json = json_encode(array(
                        'message' => 'Houve algum erro no processo!',
                        "style" =>'warning',
                        'time' => 5000,
                        'size' => 'md',
                        'callback' => NULL,
                        'before' => "$('#loader-painel').empty();$('#tabela-dinamica').show();",
                        'icon'   => 'check',
                        'title'  => 'Atenção!'
                    ));
                    echo json_encode(array(
                        'funcao' => "bootsAlert( $json );",
                    ));
                }
                
            } 
            else
            { 
                $this->layout = 'null';

                $token = $_GET['param'];

                $listaDeConvidados = $this->Reserva->listarConvidadosHostess($token);

                $this->set('listaDeConvidados', $listaDeConvidados);
                $this->set('title_layout', 'Reservas -  Lista de Convidados');
                $this->render();
            }
            
        } 
        catch (BusinessException $buEx) 
        {
            $buEx->getBusinessMessage($this);
        } 
        catch( Exception $ex )
        {
            
            if( $ex->getCode() == 2015 ){
                
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'sessaoEmpresa')) );
                
            } else if( $ex->getCode() == 2018 ){
                $this->layout = 'null';
                $this->set( 'mensagem', $ex->getMessage() );
                die( $this->render(array('controller' => 'Erros', 'view' => 'cadastroBloqueado')) );
                
            }else {
                echo $ex->getMessage();
            }
            
        }
    }
    
}