<?php

/**
 * Classe Router ela é encarregada de instanciar todos os meus metodos e renderizar na view
 *
 */

class Router extends Render {
    
    public $request = null;
    
    public function __construct() {
        parent::__construct();
        $this->Controll($this->controller);
    }
    
    /**
     * @version 1.0
     * @todo metodo no qual invoco minha classe e o metodo a ser usado
     * @var string 
     */
    public final function invoke() {
        try{
            if( file_exists( 'Controller' . DS . $this->controller . '.php' ) ) {
                if(class_exists($this->controller)) {
                    if( method_exists($this->controller, $this->method) ) {
                        call_user_func_array( array( new $this->controller, $this->method), array() );
                    } else {
                        throw new PageException( "Pagina $this->view.php não encontrada", 404 );
                    }
                } else {
                    throw new PageException( "Pagina $this->view.php não encontrada", 404 );
                    //echo 'arquivo encontrado mais a classe está com o nome errado...';
                }
            } else {
                throw new PageException( "Pagina $this->view.php não encontrada", 404 );
                //echo 'não achou o arquivo...';
            }
        } catch (PageException $ex) {
            echo $ex->pageNotFound();
        }
    }
    
    /**
     * @version 1.0
     * @todo metodo que muda o nome da controller para que senha feita a verificação no invoke
     * @var string 
     */
    public function Controll(&$Classe){
        $Classe = ucfirst($Classe).'Controller';
    }
    
    
    
}
