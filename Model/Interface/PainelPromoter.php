<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PainelPromoter
 *
 * @author BRUNO
 */
class PainelPromoter extends TemplatePainel implements ImprimePainel{
    
    private $proximo;

    /**
     * 
     * @param ImprimePainel $proximo
     * @return \PainelPromoter
     */
    public function setProximo( ImprimePainel $proximo) {
        $this->proximo = $proximo;
        return $this;
    }
    
    /**
     * 
     * @param VerificaEstadoPainel $estado
     * @return type
     */
    public function getPainel( VerificaEstadoPainel $estado ) {
        
        if( $estado->getEstado() === PainelConstantes::PROMOTER ){
            
            $this->imprimirPainel( $estado->getClass() );
            
        } else {
            return $this->proximo->getPainel( $estado );
        }
    }

    /**
     * 
     * @param AppController $class
     */
    protected function parametros(AppController $class) {
        $endereco = null;
        $modelEventos = new Evento();
        $meusEventos = $modelEventos->verificaEventosParaPromoter(Session::read('Usuario.pessoas_id'));
        
        if( Session::check('Empresa')){            
            $modelEndereco = new Endereco();
            $endereco = $modelEndereco->findEnderecosEmpresa( Session::read('Empresa.empresas_id') );
            $endereco = $endereco[0];
        }
        $class->set('title_layout', 'Painel Administrativo');
        $class->set( 'endereco' , $endereco);
        $class->set( 'meusEventos' , $meusEventos);
    }

    /**
     * 
     * @param \AppController $class
     */
    protected function renderFile(\AppController $class) {
        $class->render(array('controller' => 'Usuarios', 'view' => 'promoters'), 'painel' );
    }

//put your code here
}
