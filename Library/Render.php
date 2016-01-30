<?php

/**
 * classe que renderiza a minha view pela classe desejada
 * @version 1.0
 */
class Render {
    
    public $_caminhoUrl = null;
    
    
    public $Session = null;
    
    /**
     * @version 1.0
     * @todo contudo renderizado
     * @var string 
     */
    private $content   = null;
    /**
     * @version 1.0
     * @todo contudo renderizado
     * @var string 
     */
    protected $request = null;
    /**
     * @version 1.0
     * @todo atributo para que seja renderizada ou não a view
     * @var string 
     */
    public $autoRender = true;
    /**
     * @version 1.0
     * @todo layout qual eu irei renderizar
     * @var string 
     */
    public $layout     = 'default';

    /**
     * @version 1.0
     * @todo nome da view que eu estou
     * @var string 
     */
    public $view       = null;
    /**
     * @version 1.0
     * @todo estensão da minha view
     * @var string 
     */
    public $viewExtension  = '.php';
    
    /**
     * @version 1.0
     * @todo nome do meu controller
     * @var string 
     */
    protected $controller = null;
    
    /**
     * @version 1.0
     * @todo nome do meu metodo atual
     * @var string 
     */
    protected $method     = null;
    
    /**
     * @version 1.0
     * @todo minha url em parametros
     * @var array 
     */
    public $url = array(
        'server' => WWW,
        'uri'    => REQUEST_URI,
    );
    
    public $charset = 'UTF-8';
    
    public $viewVars = array();
  
    /**
     * @version 1.0
     * @todo indica o tipo da minha requisição
     * @var string 
     */
    protected $requestMethod = null;
    
    
    public function __construct() {
        $this->requestMethod = strtoupper( $_SERVER['REQUEST_METHOD'] );
        
        if(isset( $_GET['controller'] )){
            $this->controller = $_GET['controller'];
        }
        if( isset( $_GET['action'] ) ){
            $this->method     = $_GET['action'];
            $this->view       = $this->method;
        } else {
            $this->method = 'index'; 
            $this->view       = $this->method;
        }
        if(!isset($_GET['controller'])) {
            $this->controller = 'Pages'; 
        }
        $this->_caminhoUrl = $this->urlRoot();
        $this->Session = $_SESSION;

    }
    
    
    
    public function set($atributo = null, $valor = null ){
        $this->viewVars += array( $atributo => $valor );
    }
    
    public function get(){
        return extract( $this->viewVars );
    }
    
    public function setController( $atributto ){
        $this->controller = $atributto;
    }

    public function setMethodo( $atributto ){
        $this->method = $atributto;
        $this->view   = $atributto;
    }

    
    /**
     * @version 1.0
     * @todo verifico o tipo de requisição estou fazendo
     * @var string 
     */
    public function is( $type = NULL ){
        if( $this->requestMethod == strtoupper($type) ){
            return true;
        } else if( $this->requestMethod == strtoupper($type) ){
            return true;
        } else if( $this->requestMethod == strtoupper($type) ){
            return true;
        }
        return false;
    }
    
    
    /**
     * @todo metodo que renderiza a url padrão do sistema
     */
    public function urlRoot( ) {
        $baseDir = null;
        $Patch = getcwd();
	
		if( PHP_OS === 'WINNT' ){
            $barra = '\\';
        } else {
            $barra = '/';
        }

        $Patch = explode( $barra , $Patch );

        if(is_array($Patch)){
            //$Patch = array_reverse($Patch); 
			$Patch2 = $Patch; 
            $baseDir = array_shift($Patch);
            $baseDir = array_shift($Patch);

            
            //if(!is_null($baseDir) && $baseDir != 'www' || $baseDir != 'php' || $baseDir != 'C:' || $baseDir != NULL  ){
                
				return   WWW . '/bruno.blauzius/sistema/';
            //}
        }
        return WWW . '/' ; 
    }
    
    public static function root( ) {
        $baseDir = null;
        $Patch = getcwd();
	
		if( PHP_OS === 'WINNT' ){
            $barra = '\\';
        } else {
            $barra = '/';
        }

        $Patch = explode( $barra , $Patch );

        if(is_array($Patch)){
            //$Patch = array_reverse($Patch); 
			$Patch2 = $Patch; 
            $baseDir = array_shift($Patch);
            $baseDir = array_shift($Patch);

            
            //if(!is_null($baseDir) && $baseDir != 'www' || $baseDir != 'php' || $baseDir != 'C:' || $baseDir != NULL ){
                
				return   WWW . '/bruno.blauzius/sistema/';
           // }
        }
        return WWW . '/' ; 
    }
     
    /**
     * @todo metodo que renderiza a url padrão do sistema
     
    public function urlRoot( ) {
        $baseDir = null;
        $Patch = getcwd();
	
		if( PHP_OS === 'WINNT' ){
            $barra = '\\';
        } else {
            $barra = '/';
        }

        $Patch = explode( $barra , $Patch );

        if(is_array($Patch)){
			
            $Patch = array_reverse($Patch); 
			
            $baseDir = array_shift($Patch);

            if(!is_null($baseDir) && $baseDir != 'www' || $baseDir != 'php' || $baseDir != 'C:' || $baseDir != NULL ){
                
				return   WWW . '/' . $baseDir . '/';
            }
        }
        return WWW . '/' ; 
    }
    
    public static function root( ) {
        $baseDir = null;
        $Patch = getcwd();

        if( PHP_OS === 'WINNT' ){
            $barra = '\\';
        } else {
            $barra = '/';
        }


        $Patch = explode( $barra , $Patch );

        if(is_array($Patch)){
            $Patch = array_reverse($Patch);
            $baseDir = array_shift($Patch);

            if(!is_null($baseDir) && $baseDir != 'www' || $baseDir != 'php' || $baseDir != 'C:' || $baseDir != NULL ){
                return   WWW . '/' . $baseDir . '/';
            }
        }
        return WWW . '/' ; 
    }*/
    
    public static function url( $url = NULL ) {
        if( !empty($url) && is_array($url) ){
           return self::root() . join('/', $url);
        } else if( !empty($url) && is_string($url) ){
           return self::root()  . $url;
        }
        return self::root() ; 
    }
    
    /**
     * @version 1.0
     * @todo metodo que renderiza a minha view 
     * @var string 
     */
    public final function render( array $page = null, $layout = NULL ) {
        
        if( !empty($page) && is_array($page) ){
            
            if( !empty($page['controller']) ){
                $this->controller = $page['controller'];
            }
            
            if( !empty($page['view']) ){
                $this->view = $page['view'];
            }
            
            if( !is_null($layout)){
                $this->layout = $layout;
            }
            
        }
        
        try{
            if ( $this->autoRender ) {
                //metodo que renderiza a pagina
                if( $this->_isView() ) {
                    echo $this->getViewLayout();
                } 
            }
        } catch (PageException $ex) {
            echo $ex->pageNotFound();
        } catch (DirException $e){
            echo $e->dirNotFound();
        }
        
    }
    
    /**
     * @version 1.0
     * @todo metodo que eu verifico se a meu diretorio e minha view existe para que seja renderizada
     * @var string 
     */
    public final function _isView() {
        try{
            //verifico se meu diretório existe
            if(file_exists('View'. DS .ucfirst($this->controller))){
                //verifico se minhapagina existe
                if (file_exists('View' . DS . ucfirst($this->controller) . DS . $this->view . $this->viewExtension ) ) {
                    return true;
                } else {
                    throw new PageException("Pagina $this->view.php não encontrada", 404);
                }
            } else {
                throw new DirException("Diretorio View/$this->controller não encontrado", 001 );
            }
        } catch (PageException $ex ) {
            throw $ex;
        } catch (DirException $e ){
            throw $e;
        }
    }
    
    /**
     * @version 1.0
     * @todo metodo que recupera a view e manda para a tela
     * @var string 
     */
    protected final function getViewContent(){
        try{
            ob_start();
            
            extract($this->viewVars);
            require_once('View' . DS . ucfirst($this->controller) . DS . $this->view.$this->viewExtension );
            
                $this->content = ob_get_contents();
            
            ob_end_clean();
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * @version 1.0
     * @todo metodo que renderiza o layout que eu desejo
     * @return type
     * @throws Exception
     */
    public function getViewLayout(){
        try{
            ob_start();
            
            extract($this->viewVars);
            require_once('View' . DS . 'Layouts' . DS . $this->layout.$this->viewExtension );
            
                $this->content = ob_get_contents();
            
            ob_end_clean();
            return $this->content;
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * @version 1.0
     * @todo metodo que retorna para\ a tela a view desejada
     * @var string 
     */
    public final function showView(){
        $this->getViewContent();
        return $this->content;
    } 
}
