<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrosController
 *
 * @author bruno.blauzius
 */
class ErrosController extends AppController{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function areaRestrita() {
        $this->layout = 'default';
        $this->set('title_layout', 'Area restrita');
        $this->render();
    }
    
    public function erro404() {
        $this->layout = 'default';
        $this->set('title_layout', 'Página não Existe');
        $this->render();
    }
    
}
