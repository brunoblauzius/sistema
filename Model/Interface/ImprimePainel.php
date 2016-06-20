<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author BRUNO
 */
interface ImprimePainel {
    //put your code here
    public function getPainel( VerificaEstadoPainel $estado );
    public function setProximo( ImprimePainel $proximo);
}
