<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Authentication
 *
 */
abstract class Authentication {

    public static function password( $password ) {
        return hash('sha512', strip_tags(trim($password)));
    }   
    
    
    public static function verificaNivelUser( $nivel ){
        return (  $nivel === (int) Session::read('Usuario.roles_id') );
    }
    
    
    public static function uuid(){
        return uniqid() . rand(0, 5000);
    }
    
}
