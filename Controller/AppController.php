<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppController
 *
 */
class AppController extends Render {

    public $ClasseAllow = true;
    public $ACL = null;
    public $Util = null;
    public $Empresa = null;
    public $empresas_id = NULL;
    public $pessoas_id = NULL;
    public $isNotEditAgenda = array(2, 3, 4, 5);

    public $systemName = ' My Night - reservas ';
    
    
    public $css = array();
    public $js  = array();
    
    
    
    
    public function __construct() {
        try {
            //rendereiza o construtor da classe pai
            $empresasRelacionadas = array();
            parent::__construct();
            
            $this->empresas_id = Session::read('Empresa.empresas_id'); /* PEGAR O ID DA EMPRESA NA SEÇÃO */
            $this->pessoas_id  = Session::read('Usuario.pessoas_id'); /* PEGAR O ID DA EMPRESA NA SEÇÃO */

            $this->css = array(
                'css/bootstrap', 
                'css/bootstrap-reset', 
                'font-awesome/css/font-awesome',
                'css/style',
                'css/style-responsive',
                'js/advanced-datatable/css/demo_page',
                'js/advanced-datatable/css/demo_table',
                'css/Icomoon/style',
                'css/preloader',
                'js/data-tables/DT_bootstrap',
                );
            
            $this->js = array(
                'js/jquery-1.11.1.min',
                'js/jquery-ui-1.9.2.custom.min',
                'js/ajaxForm',
                'js/ckeditor/ckeditor',
                'bs3/js/bootstrap.min',
                'js/jquery.scrollTo.min',
                'js/jQuery-slimScroll-1.3.0/jquery.slimscroll',
                'js/jquery.nicescroll',
                'js/dashboard',
                'js/sparkline/jquery.sparkline',
                'js/advanced-datatable/js/jquery.dataTables.min',
                'js/advanced-datatable/js/dataTables.bootstrap.min',
                'js/advanced-datatable/js/dataTables.responsive.min',
                'js/dynamic_table_init',
                'js/jquery.mask.min',
                'js/funcoes',
                'js/permission_js',
                'js/scripts',
            );
            
            $this->ACL     = new ACL();
            $this->Util    = new Utils();
            $this->Empresa = new Empresa();
            
            /**
             * definindo a data hora local
             */
            date_default_timezone_set('America/Sao_Paulo');

            
            /**
             * fazendo minha verificação de permissões para niveis de usuarios
             */
            if (Session::check('Auth') && Session::check('Usuario')) {

                if ($this->ACL->authenticacaoUser($this->controller, $this->view, Session::read('Usuario.roles_id'))) {
                    Session::isLogged();
                } else {
                    //verifica se é um metodo ou pagina
                    if ($this->autoRender == true) {
                        throw new PageException("Pagina $this->view.php não encontrada", 405);
                    }
                }
            } else {
                //logica para o usuario publico
                if ($this->ACL->authenticacaoUser($this->controller, $this->view, 1)) {
                    //header('Location: ' . Router::url() . 'Erros/areaRestrita' );
                } else {
                    //verifica se é um metodo ou pagina
                    if ($this->autoRender) {
                        //redireciona para a pagina de area restrita
                        throw new PageException("Pagina $this->view.php não encontrada", 405);
                    }
                }
            }
            
            /**
             * variaveis pora todas as areas do sistema
             */
            
            if( in_array(Session::read('Usuario.roles_id'), array(3,4))  ){
                $empresasRelacionadas = $this->Empresa->empresasRelacionadas( md5($this->pessoas_id), Session::read('Usuario.roles_id') );
            } 
            $this->set('empresasRelacionadas', $empresasRelacionadas);
            $this->set('css', $this->css);
            
        } catch (PageException $ex) {
            echo $ex->pageNotFound();
            exit();
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
        }
    }

    public function AclCheck($controller, $metodo, $roleId) {
        try {
            $lista = $this->ACL->carregarPermissoes($roleId);
            foreach ($lista as $item) {
                if (($item['controllers_nome'] == $controller) && ($item['metodos_nome'] == $metodo)) {
                    return TRUE;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            
        }
    }

    public function createListMenu() {
        $lista = $this->ACL->carregarMenu(Session::read('Usuario.roles_id'));
        $newList = array();
        $menu = array();
        foreach ($lista as $valor) {
            if (!in_array($valor['controllers_nome'], array_keys($newList))) {
                $newList[$valor['controllers_nome']] = array(
                    'controllers_nome' => $valor['controllers_nome'],
                    'link_name' => $valor['link_name'],
                );
            }
        }


        foreach ($newList as $controller) {
            $menu[] = array(
                'link_name' => $controller['link_name'],
                'controller' => $controller['controllers_nome'],
                'links' => $this->listLinks($lista, $controller['controllers_nome']),
            );
        }
        return ($menu);
    }

    public function listLinks(array $lista, $controller) {
        $newLista = array();
        foreach ($lista as $registro) {
            if ($controller == $registro['controllers_nome']) {
                $newLista[] = array(
                    'action' => $registro['metodos_nome'],
                    'nome_link' => $registro['nome_link']
                );
            }
        }

        return $newLista;
    }

    public function infoError($ex) {
        try {
            
        } catch (Exception $ex) {
            
        }
    }

    /**
     * 	@todo methodo que verifica dos nodes da lista que estão vazios
     * 	@return boolean
     */
    public function nodesIsNull(array $lista) {
        $retorno = false;
        foreach ($lista as $nodesArray) {
            if (empty($nodesArray['servico_id']) || empty($nodesArray['tipo_servico_id']) || empty($nodesArray['valor'])) {
                $retorno = true;
            }
        }
        return $retorno;
    }

    public function verificaContaEmpresa() {

        $diferencaDias = null;
        $tempoMes = null;

        try {

            /**
             * recupero os dados da empresa logada
             */
            $empresa = new Empresa();
            $contaEmpresa = $empresa->contaEmpresa($this->empresas_id);

            /**
             * VERIFICO SE É MEU PERFIL TESTE
             */
            if ($contaEmpresa['contas_empresas_tipos'] == 1) {
                $tempoMes = 1;
            } else {
                $tempoMes = 1;
            }

            /**
             * recupero os dias que restam para espirar a conta
             */
            $diferencaDias = DateUtils::calculoDiferencaData(date('Y-m-d'), Utils::adicionaMes($tempoMes, $contaEmpresa['created']));

            /**
             * verifico se ja experiou a conta
             */
            if ($diferencaDias <= 0) {
                throw new BusinessException('Fora do periodo de utilização, desculpe pelo transtorno. Para continuar utilizando normalmente o sistema clique no link abaixo!', 112);
            }
        } catch (BusinessException $ex) {
            throw $ex;
        }
    }

    protected function checaEmpresa() {
        try {
            if (!Session::check('Empresa')) {
                throw new Exception('Olá administrador, selecione uma empresa cadastrada em sua conta e continue utilizando normalmente esta área!', 2015);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
