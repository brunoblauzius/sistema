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
        $this->_caminhoUrl = $this->urlRoot();
    }
    
    
    
    public function set($atributo = null, $valor = null ){
        if( !is_null($valor) ){
            $this->viewVars = array_merge($this->viewVars , array( $atributo => $valor ) );
        } else {
            $this->viewVars = array_merge($this->viewVars , $atributo);
        }
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
    
    
    public static function root( ) {
        $baseDir = null;
        $Patch = getcwd();
	$arrayExcludes = array('www', '', 'var', 'C:', 'xampp', 'htdocs', 'ws.bcitecnologia.com.br', 'html');
        
	if( PHP_OS === 'WINNT' ){
            $barra = '\\';
        } else {
            $barra = '/';
        }

        $Patch = explode( $barra , $Patch );

        if(is_array($Patch)){
	
            $Patch = array_reverse($Patch);
            foreach ( $Patch as $keyEx => $exclude ){
                if(in_array($exclude, $arrayExcludes)){
                    unset($Patch[$keyEx]);
                }
            }
            $baseDir = array_reverse($Patch);
           
            return   WWW . '/' . join('/', $baseDir) . '/';
            
        }
        return WWW . '/' ; 
    }
   
    /**
     * @todo metodo que renderiza a url padrão do sistema
      */
    public function urlRoot() {
        return self::root();
    }
    
    
    public static function url( $url = NULL ) {
        if( !empty($url) && is_array($url) ){
           return self::root() . join('/', $url);
        } else if( !empty($url) && is_string($url) ){
           return self::root()  . $url;
        }
        return self::root() ; 
    }
 
    /**
     * 
     * @param string $element
     * @param string $mode
     * @return string
     * @throws Exception
     */
    public final function element( $element = 'index', $mode = 'html'  )
    {
        try{
            ob_start();
            extract($this->viewVars);
            
            require_once('View' . DS . 'Layouts' . DS . $mode . DS .  $element . '.php' );
            
            $content = ob_get_contents();
            
            ob_end_clean();
            return $content;
            
        } catch (Exception $ex) {
            throw $ex;
        }
        
    } 

}
