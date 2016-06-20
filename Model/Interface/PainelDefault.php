<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PainelDefault
 *
 * @author BRUNO
 */
class PainelDefault implements ImprimePainel{
    
    private $proximo;

    public function setProximo( ImprimePainel $proximo) {
        $this->proximo = $proximo;
        return $this;
    }
    
    public function getPainel( VerificaEstadoPainel $estado ) {
        
        if( $estado->getEstado() === PainelConstantes::PADRAO ){
            echo PainelConstantes::PADRAO;
        } else {
            return $this->proximo->getPainel( $estado );
        }
        
    }

//put your code here
}
