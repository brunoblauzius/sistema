<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HTML
 *
 * @author bruno.blauzius
 */
class HTML {
    //put your code here
    
    /**
     * @uses HTML::img('teste.jpg', array(
     *                                      'class' => 'form', 
     *                                      'style' => 'width:200px;', 
     *                                      'title' => 'sei la')
     *                  );
     * 
     * @todo metodo que gera uma imagem no sevidor
     * @author Bruno Blauzius Schuindt
     * @version 1.0
     * @param string/array $image
     * @param array $style
     * @return string
     */
    public static function img( $image, array $style = NULL ){
        
        $styles = array();
        
        if( !empty($image) && is_string($image) )
        {
            $image = array('View', 'webroot', 'image', $image);
        } 
        else if(is_array($image) && !in_array('image', $image)) 
        {
            $image = array_merge(array('View', 'webroot'), $image);
        }
        
        if( !empty($style) ){
            foreach ( $style as $key => $value ){
                $styles[] = " $key = '$value' ";
            }
            $style = join(' ', $styles);
        }
        
        return '<img src="'.Router::url( $image ).'" '.$style.' >';
        
    }
    
}
