<?php

class ReservasController extends AppController {

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
                ));
        
        $this->js = array_merge($this->js, array(
                'js/fullcalendar2.0/lib/moment.min',
                'js/fullcalendar2.0/fullcalendar',
                'js/fullcalendar2.0/lang-all',
                'js/datatimepicker2.0/bootstrap-datetimepicker.min',
                'js/easypiechart/jquery.easypiechart',
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
            $this->set( 'mensagem', $buEx->getMessage() );
            die( $this->render(array('controller' => 'Erros', 'view' => 'notPermisson')) );
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
    
    
    public function listar(){
        try {
            
            $this->checaEmpresa();
            $Modelambientes = new Ambiente();
            
            
            $usuariosEmpresa = array();
            $condicao = array();
            
            /**
             * 	SE O ROLE ID FOR Usuario ELE PEGA SOMENTE O Usuario SE NãoO OS USUARIOS DA EMPRESA
             */
            //$registros = $this->Reserva->filtrar($this->empresas_id);
            $ambientes = $Modelambientes->find('all', array('empresas_id' => $this->empresas_id) );
            $mesasRestantes = $this->Reserva->reservasMesasRestantes($this->empresas_id);
            
            $urlPDF = 'http://snappypdf.com.br/gerar.php?url=' . Router::url(array('Reservas', 'imprimir' ));
            
            //$this->set('registros', $registros);
            
            $this->set('ambientes', $ambientes);
            $this->set('mesasRestantes', $mesasRestantes);
            $this->set('urlPDF', $urlPDF);
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
                
                if( !empty($dadoEmailReserva[0]['email']) ){
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
                     $array = array(
                         '__CLIENTE__' => $cliente[0]['Cliente']['nome'],
                         '__DATE__' => date('d/m/Y h:i:s'),
                         '__NOME_FANTASIA__' => Session::read('Empresa.nome_fantasia'),
                         '__LUGARES__' => $_POST[$this->Reserva->name]['qtde_pessoas'],
                         '__ENDERECO_EMPRESA__' => $enderecoEmpresa,
                         '__MESAS__' => join(' - ', array_values($mesas)),
                         '__DATA_INICIO__' => Utils::convertData( $dataCallendar ),
                         '__SALAO__' => $dadoEmailReserva[0]['salao'],
                         '__AMBIENTE__' => $dadoEmailReserva[0]['ambiente'],
                     );

                     #envio o email de confirmação para o meu cliente cadastrado

                     $objeto = new MailPHPMailer();

                     $objeto->setAssunto( 'Reserva Camarote: ' . Session::read('Empresa.nome_fantasia') );

                     //$objeto->setRemetente();

                     /**
                      *   CORPO DO EMAIL
                      */
                     $objeto->setBody(str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']));

                     /**
                      *   DESTINO PARA QUEM VAI O EMAIL - CLIENTE
                      */
                     $objeto->setDestinatario( $dadoEmailReserva[0]['email'], $dadoEmailReserva[0]['cliente'] );
                     $email = $objeto->sendMail();
                }
               
               
                echo json_encode(array(
                    'funcao' => "sucessoForm( 'Sua alteração efetuada com sucesso!', '#ReservaEditForm' ); "
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
                   'funcao' => "sucessoForm( 'Sua alteração efetuada com sucesso!', '#ReservaEditForm' ); "
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

            $registros = $this->Reserva->filtrar($this->empresas_id, $_POST['ambientes_id'], $dataInicio, $dataFim, NULL);
            $this->set('registros', $registros);
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
                    'funcao' => "sucesso('Registro foi cancelado com sucesso!');"
                    . "window.location.reload();"
                ));
            } else {
                echo json_encode(array(
                    'funcao' => "sucesso('Não foi possivel cancelar o registro, tente novamente mais tarde!');"
                    . "window.location.reload();"
                ));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
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
            
            

           /**
            * VERIFICO SE O CLIENTE TEM EMAIL CADASTRADO
            */

           if( !empty($dadoEmailReserva[0]['email']) ){
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
                $mesas = $mesaModel->mesasReservas($reserva['Reserva']['id']);
                $mesas = ($mesaModel->mesasReservasList($mesas, 'id'));
                $mesas = $mesaModel->selectIn($mesas);

                
                /**
                 * #faço a troca de siglas para personalizar o email
                 */
                $array = array(
                    '__CLIENTE__' => $cliente[0]['Cliente']['nome'],
                    '__DATE__' => date('d/m/Y h:i:s'),
                    '__NOME_FANTASIA__' => Session::read('Empresa.nome_fantasia'),
                    '__LUGARES__' => $reserva['Reserva']['qtde_pessoas'],
                    '__ENDERECO_EMPRESA__' => $enderecoEmpresa,
                    '__MESAS__' => join(' - ', array_values($mesas)),
                    '__DATA_INICIO__' => Utils::convertData( $dataCallendar ),
                    '__SALAO__' => $dadoEmailReserva[0]['salao'],
                    '__AMBIENTE__' => $dadoEmailReserva[0]['ambiente'],
                );

                #envio o email de confirmação para o meu cliente cadastrado

                $objeto = new MailPHPMailer();

                $objeto->setAssunto( 'Reserva Camarote: ' . Session::read('Empresa.nome_fantasia') );

                //$objeto->setRemetente();

                /**
                 *   CORPO DO EMAIL
                 */
                $objeto->setBody(str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']));

                /**
                 *   DESTINO PARA QUEM VAI O EMAIL - CLIENTE
                 */
                $objeto->setDestinatario( $dadoEmailReserva[0]['email'], $dadoEmailReserva[0]['cliente'] );
                $emailEnvio = $objeto->sendMail();
                
                /**
                 * renomeando o nome da tabela de email
                 */
                $email->useTable = 'emails_enviados';
                
                
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
                    $email->genericInsert( $gravaEmail );
                    
                    echo json_encode(array(

                        'message' => 'Email enviado com sucesso!',
                        "style" =>'success',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => false,
                        'before' => false,
                        'icon'   => '',
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
                    $email->genericInsert( $gravaEmail );
                    
                    echo json_encode(array(
                    
                        'message' => 'Problema no servidor de envio dos emails, contate o suporte.',
                        "style" =>'danger',
                        'time' => 5000,
                        'size' => 'sm',
                        'callback' => false,
                        'before' => false,
                        'icon'   => '',
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
                    'icon'   => '',
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
                'icon'   => '',
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
    
    
    
    
}

?>