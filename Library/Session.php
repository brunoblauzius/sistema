<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 */
class Session {
    
    private static $timeLogin = 30;
    
    public static function initAuth(){
        $_SESSION['Auth'] = array(
            'time' => time(),
            'timelogged' => time(),
            'host' => '',
            'keyUser' => '',
        );
    }
    
    public static function createSession( $list ){
        try{
            $model = key($list);
            foreach ( $list[$model] as $key => $value ){
                if( $key != 'senha' ){
                    $_SESSION[$model][$key] = $value;
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public static function valueNode( $node ){ 
        if( !is_null($node)){
            if( isset($_SESSION['Usuario'][$node])){
                return $_SESSION['Usuario'][$node];
            }
        }
    }
    
    public static function read( $value ){
        
        $values = explode('.', $value);
        
        if( !empty($values)){
            if( isset($_SESSION[$values[0]][$values[1]])){
                return $_SESSION[$values[0]][$values[1]];
            }
        }
    }
    
    public static function timeLogged(){
        return (int) 60 - date('i',$_SESSION['Auth']['time'] - time());
    }
    
    
    public static function logoutTimeLimit() {
        if( self::timeLogged() === self::$timeLogin ) {
            unset( $_SESSION['Usuario'] );
            unset( $_SESSION['Auth'] );
        }
    }
    
    public static function check( $name ){
        return isset( $_SESSION[$name] );
    }
    
    public static function isLogged(){
        if( self::check('Auth') && self::check('Usuario') ) {
            //verifica o meu tempo de login
            self::logoutTimeLimit();
        } else {
            header('Location: ' . Router::url() ); 
        }
    }
    
    public static function logout(){
		foreach( $_SESSION as $key => $sessao ){
			unset( $_SESSION[$key] );
		}
        return true;
    }
    
}
