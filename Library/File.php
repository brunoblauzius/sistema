<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of read
 *
 * @author bruno.blauzius
 */
class File {
    //put your code here
    
    private $arquivo = null;
    
    private $path = null;
    
    private $file = null;
    
    public function getArquivo() {
        return $this->arquivo;
    }

    public function getPath() {
        return $this->path;
    }

    public function getFile() {
        return $this->file;
    }

    public function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
        return $this;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function setFile($file) {
        $this->file = $file;
        return $this;
    }

        
    
    public function __construct ( $file, $path = null ) {
        
        if(is_null($path)) {
            $path = __DIR__;
        }
        
        $this->path = $path;
        
        $this->file = $file;
        
        $this->path = $this->path . DIRECTORY_SEPARATOR . $file;
        
        $this->arquivo = file( $this->path );
        
        $this->splitLines();
    }
    
    
    public function splitLines(){
        
        $newArquiv = array();
        
        $cabecalho = explode(';', $this->arquivo[0]);
        array_shift($this->arquivo);
        
        foreach ($this->arquivo as $string ){
            $explode = explode(';', $string);
            $newArquiv[] = array(
                trim($cabecalho[0]) => trim($explode[0]),
                trim($cabecalho[1]) => trim($explode[1]),
                trim($cabecalho[2]) => trim($explode[2]),
                trim($cabecalho[3]) => $this->forDataBase(trim($explode[3])),
            );
        }
        $this->arquivo = $newArquiv;
    }
    
    public function forDataBase( $data ){
        if( !empty($data) ){				
                $exData = explode(' ', $data);

                if( preg_match( '/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $exData[0] ) ){
                   $data = explode('/', $exData[0]);
                   $data = implode( '-',array_reverse($data) ). ' ' . $exData[1];
                } else if( preg_match( '/[0-9]{4}\-[0-9]{2}\-[0-9]{2}/', $exData[0] ) ){
                   $data = explode('-', $exData[0]);
                   $data = implode( '/',array_reverse($data) ) . ' ' . $exData[1] ;
                } else {
                   $data = (  'data no formato inválido'  );
                }
        }
        return $data;
    }
    
}