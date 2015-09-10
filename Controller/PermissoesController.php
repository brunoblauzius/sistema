 <?php


class PermissoesController extends AppController {
    
    public $ClasseAllow  = false;
    
    public $Control      = null;
    
    public $Metodo       = null;
    
    public $Grupo = null;
   
    
    
    public function __construct() {
        parent::__construct();
        
        $this->Control = new Control();
        
        $this->Metodo  = new Metodo();
        
        $this->Grupo = new Grupo();
                
        $this->layout = 'painel';
    }
    
    public function index(){
        try{
            $grupos = array();
            $controllerMetodos = array();
            $aclLista = array();
			
            $grupos = $this->Grupo->findAll();
			$controllerMetodos = $this->Control->findControllerMethods();
            $aclLista          = $this->ACL->findAclAll();
			
            $this->set('controllerMetodos', $controllerMetodos);
            $this->set('grupos', $grupos);
            $this->set('aclLista', $aclLista);
            $this->set('title_layout', 'Permissões: Home');
            $this->render();
            
        } catch (Exception $ex) {
			echo $ex->getMessage();
        }
    }
    
    /**
     * @todo metodo que renderiza a view das controladoras do sistema
     */
    public function controladora(){
        try{
            $controllers = $this->Control->find('all');
            $this->set('controllers', $controllers);
            $this->set('controlName', $this->Control->name);
            $this->set('title_layout', 'Permissões: Controladora');
            $this->render();
            
        } catch (Exception $ex) {

        }
    }
    
    /**
     * @todo metodo que renderiza a view de cadastro das controladoras
     */
    public function controladoraCadastro(){
        try{
            
            $this->set('title_layout', 'Permissões: Controladora (cadastro)');
            $this->render();
            
        } catch (Exception $ex) {

        }
    }
    
    /**
     * @todo  metodo que renderiza a view de edição das minhas controladoras cadastradas no sistema
     */
    public function controladoraEditar(){
        try{
            
            $registro = array();
            $id = (int) $_GET['param'];
            if( !is_null($id) ){
                
                if(isset($_SESSION['ControlForm'])){
                    unset($_SESSION['ControlForm']);
                }
                
                $registro = $this->Control->find('first',array( 'id' => $id ));
                $registro = array_shift($registro);
                
                if( !empty($registro) ){
                    $_SESSION['ControlForm']['id'] = (int) $registro[$this->Control->name]['id'];
                }
            }
            
            $this->set('registro', $registro );
            $this->set('controlName', $this->Control->name );
            $this->set('title_layout', 'Permissões: Controladora (cadastro)');
            $this->render();
            
        } catch (Exception $ex) {

        }
    }
    
    /**
     * @todo metodo que realiza a inserção da alteração das minhas controladoras
     */
    public function controladoraEdit() {
       try{
            if( isset($_SESSION['ControlForm'])){
               $_POST[$this->Control->name]['id'] = $_SESSION['ControlForm']['id'];
            }
            
            $_POST = Utils::sanitazeArray( $_POST );
            $this->Control->data =  $_POST[$this->Control->name] ;
            
            $this->Control->validate = $this->Control->validate_edit;
            
            if ( $this->Control->validates() ) {
                if( $this->Control->genericUpdate( $this->Control->data ) ) {
                    $url = $this->urlRoot() . 'Permissoes/controladora';
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Alteração foi efetuada com sucesso!', '#PermissoesControladoraEditForm' );"
                                  . "redirect('{$url}')",
                    ));               
                } 
            } else {
                echo json_encode(array(
                    'erros' => ($this->Control->validateErros),
                    'form'  => 'PermissoesControladoraEditForm',
                ));
            }
            
            
       } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesControladoraAddForm' );",
            ));
       }
    }
    
    
    /**
     * @todo metodo que realiza a inserção da alteração das minhas controladoras
     */
    
    public function controladoraAdd(){
        try{
            $_POST = Utils::sanitazeArray( $_POST );
            $this->Control->data =  $_POST[$this->Control->name] ;
            
            
            if ( $this->Control->validates() ) {
                if( $this->Control->genericInsert( $this->Control->data ) ) {
                    $url = $this->urlRoot() . 'Permissoes/controladora';
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Cadastro foi efetuado com sucesso!', '#PermissoesControladoraAddForm' );"
                                  . "redirect('{$url}')",
                    ));
                } 
            } else {
                echo json_encode(array(
                    'erros' => ($this->Control->validateErros),
                    'form'  => 'PermissoesControladoraAddForm',
                ));
            }

        } catch (Exception $ex) {
            echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesControladoraAddForm' );",
                ));
        }
    }
    
    /**
     * @todo metodo que executa a ação de excluir um cadastro
     */
    public function controladoraDeletar(){
        try{
            $id = (int) $_GET['param'];
            
            if(!is_null($id)) {
                if( $this->Control->genericDelete($id, 'id') ) {
                    $url = $this->urlRoot() . 'Permissoes/controladora';
                    echo json_encode(array(
                        'funcao' => "alertaSucesso();"
                                  . "redirect('{$url}');",
                    ));
                }
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesControladoraAddForm' );",
            ));
        }
    }
    
    
    public function metodos() {
        try{
            $metodos = $this->Metodo->find('all');
            $lista   = array();
            
            foreach ($metodos as $metodo) {
                $lista[] = new MetodoEntity(
                        $metodo[$this->Metodo->name]['id'], 
                        $metodo[$this->Metodo->name]['nome'], 
                        $metodo[$this->Metodo->name]['ativo'], 
                        $metodo[$this->Metodo->name]['descricao'], 
                        $this->Control->findName($metodo[$this->Metodo->name]['controllers_id']),
                        $metodo[$this->Metodo->name]['is_page'],
                        $metodo[$this->Metodo->name]['menu_primario'],
                        $metodo[$this->Metodo->name]['menu_secundario'],
                        $metodo[$this->Metodo->name]['nome_link']);
            }
            
            $this->set('metodos', $lista);
            $this->set('title_layout', 'Permissões: Metodos');
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function metodosCadastro(){
        try{
            
            $controladoras = $this->Control->find('all', array('ativo' => true), NULL, NULL, array('nome ASC'));
            $this->set('controladoras', $controladoras);
            $this->set('title_layout', 'Permissões: Metodos (cadastro)');
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    /**
     * @todo metodo que realiza a inserção da alteração dos meus metodos
     */
    
    public function metodosAdd(){
        try{
                
            $novoArray = array();
            $i = 0;
            
            foreach ($_POST[$this->Metodo->name]['nome'] as $nome) {

                $novoArray[][$this->Metodo->name] = array(
                    'controllers_id' => $_POST[$this->Metodo->name]['controllers_id'],
                    'nome'           => $nome,
                    'descricao'      => current($_POST[$this->Metodo->name]['descricao']),
                    'ativo'          => $_POST[$this->Metodo->name]['ativo'],
                    'is_page'        => current($_POST[$this->Metodo->name]['is_page']),
                    'nome_link'      => current($_POST[$this->Metodo->name]['nome_link']),
                    'menu_primario'  => current($_POST[$this->Metodo->name]['menu_primario']),
                    'menu_secundario'=> current($_POST[$this->Metodo->name]['menu_secundario']),
                );
                
                next($_POST[$this->Metodo->name]['descricao']);
                next($_POST[$this->Metodo->name]['is_page']);
                next($_POST[$this->Metodo->name]['nome_link']);
                next($_POST[$this->Metodo->name]['menu_primario']);
                next($_POST[$this->Metodo->name]['menu_secundario']);
            }
            
            foreach ($novoArray as $registro) {
                $this->Metodo->genericInsert( $registro[$this->Metodo->name] );
            }
            
            $url = $this->urlRoot() . 'Permissoes/metodos';
            echo json_encode(array(
                'funcao' => "sucessoForm( 'Cadastro foi efetuado com sucesso!', '#PermissoesMetodosAddForm' );"
                          . "redirect('{$url}')",
            ));

        } catch (Exception $ex) {
            echo json_encode(array(
                    'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesMetodosAddForm' );",
                ));
        }
    }
    
//     public function metodosAdd2(){
//        try{
//            
//            $_POST = Utils::sanitazeArray( $_POST );
//            $this->Metodo->data =  $_POST[$this->Metodo->name] ;
//            
//            
//            if ( $this->Metodo->validates() ) {
//                if( $this->Metodo->genericInsert( $this->Metodo->data ) ) {
//                    $url = $this->urlRoot() . 'Permissoes/metodos';
//                    echo json_encode(array(
//                        'funcao' => "sucessoForm( 'Cadastro foi efetuado com sucesso!', '#PermissoesMetodosAddForm' );"
//                                  . "redirect('{$url}')",
//                    ));
//                } 
//            } else {
//                echo json_encode(array(
//                    'erros' => ($this->Metodo->validateErros),
//                    'form'  => 'PermissoesMetodosAddForm',
//                ));
//            }
//
//        } catch (Exception $ex) {
//            echo json_encode(array(
//                    'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesMetodosAddForm' );",
//                ));
//        }
//    }
    
    public function metodosEditar(){
        try{
            
            if(isset($_SESSION['MetodoForm'])) {
                unset($_SESSION['MetodoForm']);
            }
            
            $id = intval($_GET['param']);
            
            $metodo = $this->Metodo->find('all', array('id' => $id ) );
            $metodo = array_shift($metodo);
            
            $objeto = new MetodoEntity(
                    $metodo[$this->Metodo->name]['id'], 
                    $metodo[$this->Metodo->name]['nome'], 
                    $metodo[$this->Metodo->name]['ativo'], 
                    $metodo[$this->Metodo->name]['descricao'], 
                    $metodo[$this->Metodo->name]['controllers_id'],
                    $metodo[$this->Metodo->name]['is_page'],
                    $metodo[$this->Metodo->name]['menu_primario'],
                    $metodo[$this->Metodo->name]['menu_secundario'],
                    $metodo[$this->Metodo->name]['nome_link']
                    );
            
            if( is_object($objeto) && !empty($objeto) ){
                $_SESSION['MetodoForm']['id'] = $objeto->getId();
            }
            
            $controladoras = $this->Control->find('all', array('ativo' => true), NULL, NULL, array('nome ASC'));
            $this->set('controladoras', $controladoras);
            $this->set('metodo', $objeto);
            $this->set('title_layout', 'Permissões: Metodos (cadastro)');
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    /**
     * @todo metodo que realiza a inserção da alteração das minhas controladoras
     */
    public function metodosEdit() {
       try{
            if( isset($_SESSION['MetodoForm'])){
               $_POST[$this->Metodo->name]['id'] = $_SESSION['MetodoForm']['id'];
            }
            
            $_POST = Utils::sanitazeArray( $_POST );
            $this->Metodo->data =  $_POST[$this->Metodo->name] ;
            
            $this->Metodo->validate = $this->Metodo->validate_edit;
            
            if ( $this->Metodo->validates() ) {
                if( $this->Metodo->genericUpdate( $this->Metodo->data ) ) {
                    $url = $this->urlRoot() . 'Permissoes/metodos';
                    echo json_encode(array(
                        'funcao' => "sucessoForm( 'Alteração foi efetuada com sucesso!', '#PermissoesMetodosEditForm' );"
                                  . "redirect('{$url}')",
                    ));               
                } 
            } else {
                echo json_encode(array(
                    'erros' => ($this->Metodo->validateErros),
                    'form'  => 'PermissoesMetodosEditForm',
                ));
            }
            
            
       } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesMetodosEditForm' );",
            ));
       }
    }
    
    /**
     * @todo metodo que executa a ação de excluir um cadastro
     */
    public function metodosDeletar(){
        try{
            $id = (int) $_GET['param'];
            
            if(!is_null($id)) {
                if( $this->Metodo->genericDelete($id, 'id') ) {
                    $url = $this->urlRoot() . 'Permissoes/metodos';
                    echo json_encode(array(
                        'funcao' => "alertaSucesso();"
                                  . "redirect('{$url}');",
                    ));
                }
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'funcao' => "infoErro( '{$ex->getMessage()}', '#PermissoesControladoraAddForm' );",
            ));
        }
    }
    
    
    public function addGroupsActions(){
        try {
            
            if( $this->is('post') || $this->is('put') ){
                                
                $controlNome = $this->Control->find('first', array('id' => $_POST[$this->ACL->name]['controllers_id'] ), array('nome') );
                $metodoNome  = $this->Metodo->find('first', array('id' => $_POST[$this->ACL->name]['metodos_id'] ), array('nome') );
                
                $_POST[$this->ACL->name]['metodos_nome']     = $metodoNome[0][$this->Metodo->name]['nome'];
                $_POST[$this->ACL->name]['controllers_nome'] = $controlNome[0][$this->Control->name]['nome'];
                
                  
                
                if( !$this->ACL->countAcl($_POST[$this->ACL->name]) ) {
                    $_POST[$this->ACL->name]['ativo'] = 1;
                    if( !$this->ACL->countAcl($_POST[$this->ACL->name]) ) {
                        if( $this->ACL->genericInsert($_POST[$this->ACL->name]) ){
                            echo json_encode(array(
                                'erro' => 0,
                                'acao' => 'insert',
                            ));
                        }
                    }
                    
                } else {
                    
                    if( $_POST[$this->ACL->name]['ativo'] == 0 ) {
                        $_POST[$this->ACL->name]['ativo'] = 1;
                        
                        if( $this->ACL->aclUpdate($_POST[$this->ACL->name]) ){
                             echo json_encode(array(
                                 'erro' => 0,
                                 'acao' => 'insert',
                             ));
                         }
                    } else {
                        $_POST[$this->ACL->name]['ativo'] = 0;
                        if( $this->ACL->aclUpdate($_POST[$this->ACL->name]) ){
                             echo json_encode(array(
                                 'erro' => 0,
                                 'acao' => 'update',
                             ));
                         }
                    }
                    
                }
                
                
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function verificaListaMetodo ( $listaAcl, $idGrupo, $idMetodo, $idController) {
        foreach ($listaAcl as $acl) {
            if( $acl->getMetodoId() == $idMetodo && $acl->getGrupoId() == $idGrupo && $acl->getControllerId() == $idController && $acl->getAtivo() == TRUE ) {
                return $acl->getMetodoId();
            }
        }
        return FALSE;
    }
    
    public function listAllMethods(){
        try {
            $this->layout = 'null';
            $controllerName = trim( $_POST['controllers_name'].'Controller' );
            $appController = get_class_methods('AppController');
            $Class         = get_class_methods($controllerName);
            $listaDB       = $this->Metodo->findAll($_POST['controllers_id']);
            $listaDB       = ( $this->Metodo->inList($listaDB) );
            $Class         = array_diff($Class, $appController);
            $this->set('lista', array_diff( $Class, $listaDB ) );
            $this->render();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
}
