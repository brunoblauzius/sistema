<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageException
 *
 */
class PageException extends Exception {
    //put your code here
    
    public function __construct($message, $code =0, $previous = NULL) {
        parent::__construct($message, $code, $previous = NULL);
    }
    
    public final function pageNotFound( $pagina = null) {
        switch ($this->getCode()) {
            case 404:
                //header('Location: ' . Router::url() . 'Erros/erro404' );
                $view = new Router();
                $view->layout = 'default';
                $view->setController('Erros');
                $view->setMethodo('erro404');
                $view->render();
                break;
				
			case 405:
                //header('Location: ' . Router::url() . 'Erros/erro404' );
                $view = new Router();
                $view->layout = 'default';
                $view->setController('Erros');
                $view->setMethodo('areaRestrita');
                $view->render();
                break;
            default:
                
                break;
        }
    }
	
    
    
    
}
