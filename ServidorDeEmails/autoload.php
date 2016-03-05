<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('WWW', "http://" . $_SERVER['HTTP_HOST']);
define('REQUEST_URI', $_SERVER['REQUEST_URI']);
define('PATH_SERVER', dirname(__FILE__) );
	
date_default_timezone_set('America/Sao_Paulo');

function __autoload( $filename = NULL ){
    
    $filename .= '.php' ;
    
    if(file_exists('Library'. DS . $filename))
    {
        require_once 'Library'. DS . $filename;
    }
    else if(file_exists('Model'. DS . $filename))
    {
        require_once 'Model'. DS . $filename;
    }
    else if(file_exists('Model'. DS .'Object'. DS . $filename))
    {
        require_once 'Model'. DS .'Object'. DS . $filename;
    }
    else if(file_exists('Controller'. DS . $filename))
    {
        require_once 'Controller'. DS . $filename;
    }
    else if(file_exists('View'. DS . 'Helpers' . DS . $filename))
    {
        require_once 'View'. DS . 'Helpers' . DS . $filename;
    }
    
}

