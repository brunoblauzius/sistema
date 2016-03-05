<?php


class Cookie {
    
    
    public function __construct() {}
    
    /**
     * @metodo que gera um cookie serializado
     * @param type array $params
     * @param type string $name
     * @param type int $duration
     */
    public static function add( $params, $name = 'MyCookie', $duration = null ){
        /**
         * se a duração for vazia ela recebe a duração para expirar por um dia.
         */
        if( $duration == NULL){
            $duration = time()+60*60*24;
        }
        return setcookie($name, serialize($params), $duration );
    }
    
    /**
     * @todo verifica se existe meu cookie
     * @param type string  $name
     * @return type boolean
     */
    public static function existCookie( $name = 'MyCookie' ){
        return isset( $_COOKIE[$name] );
    }
    
    
    /**
     * @todo metodo que exclui o cookie do usuario
     * @param type string $name
     */
    public static function deleteCookie($name = 'MyCookie' ){
        setcookie($name, null, time()-3600);
        unset( $_COOKIE[$name] );
        return Cookie::existCookie($name);
    }
    
    /**
     * @metodo que recupera o valor do cookie
     * @param type string $name
     * @return type array/string
     */
    public static function read( $name = 'MyCookie' ){
        return unserialize( $_COOKIE[$name] );
    }
    
}