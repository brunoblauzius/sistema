<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChainPainel
 *
 * @author BRUNO
 */
class ChainPainel{
    //put your code here
    
    private $rolesId;
    private $estado;
    
    public function __construct( $rolesId, AppController $class ) {
        $this->estado = new VerificaEstadoPainel();
        $this->estado->setEstado($rolesId);
        $this->estado->setClass($class);
    }
 
    
    public function getPainel(){
        $painelDefault = new PainelDefault();
        $painelAdmn    = new PainelAdmin();
        $painelPromoter    = new PainelPromoter();
        $painelGerente    = new PainelGerente();
        $painelProprietario    = new PainelProprietario();
        
        $painelDefault->setProximo($painelAdmn);
        $painelAdmn->setProximo($painelPromoter);
        $painelPromoter->setProximo($painelGerente);
        $painelGerente->setProximo($painelProprietario);
        
        $painelDefault->getPainel( $this->estado );
    }
    
}
