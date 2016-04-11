<?php

/**
 * Description of EventosController
 *
 * @author bruno.blauzius
 */
class EventosController extends AppController {
    //put your code here
    
    public $ClasseAllow = array('cadastro');
    
    public function __construct() {
        parent::__construct();
        $this->layout = 'painel';
    }
    
    public function index(){
        $this->addCss(array(
            'js/morris-chart/morris',
        ));
        $this->addJs(
            array(
                'js/morris-chart/morris',
                'js/morris-chart/raphael-min',
                'js/eventos.init'
            )
        );
        $this->render();
    }
    
    public function cadastro(){
        
        $this->layout = 'null';
        
        $this->render();
        
    }
    
}
