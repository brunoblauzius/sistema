<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorPage
 *
 */
class ErrorPage extends Render{

    public final static function page404NotFound( $classeNotFound ){
        try{
            
            echo "Erro: a pagina $classeNotFound não foi encontrada ";
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public final static function DirNotFound( $dirNotFound ){
        try{
            
            echo "Erro: O diretório $dirNotFound não foi encontrada ";
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
}
