<?php
    session_start();
    
	
    error_reporting( true );
    ini_set( "display_errors", true );

    
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(__FILE__));
    define('WWW', "http://" . $_SERVER['HTTP_HOST']);
    define('REQUEST_URI', $_SERVER['REQUEST_URI']);
    define('PATH_SERVER', dirname(__FILE__) );
	
    date_default_timezone_set('America/Sao_Paulo');

    function __autoload( $classe ) { 
        $classe = $classe . '.php';
        if (file_exists('Controller' . DS . $classe ) ) {
            require_once 'Controller' . DS . $classe;
        } 
        else if (file_exists('Model' . DS . $classe ) ) {
            require_once 'Model' . DS . $classe;
        }
        else if (file_exists('Model' . DS . 'Entity' . DS . $classe ) ) {
            require_once 'Model' . DS . 'Entity' . DS . $classe;
        }
        else if (file_exists('Library' . DS . $classe ) ) {
            require_once 'Library' . DS . $classe;
        }
        else if (file_exists('Exceptions' . DS . $classe ) ) {
            require_once 'Exceptions' . DS . $classe;
        } else {
            ///se a pagina nao for encontrada ela renderiza errorPage
            ErrorPage::page404NotFound( $classe ); 
        }
    }

$Router = new Router();
$Router->invoke();
