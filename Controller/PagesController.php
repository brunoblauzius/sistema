<?php

/**
 * Paginas iniciais do sistema
 * @version 1.0
 */
class PagesController extends AppController{
    
    public $ClasseAllow = array('index', 'login', 'ativarConta', 'cadastroSucesso', 'criarConta', 'sendContato', 'cadastroEstabelecimento', 'primeirasConfiguracoes');
    
    public $User = null;
    
    public function __construct() {
        parent::__construct();
        $this->css = array();
        $this->js  = array();
        $this->User = new Usuario();
    }
    
    public function index() {
        
        $this->addJs(array(
            '3dParty/jquery-1.11.0.min',
            '3dParty/bootstrap/js/bootstrap.min',
            '3dParty/jquery.touchSwipe.min',
            '3dParty/gauge.min',
            '3dParty/rs-plugin/js/jquery.themepunch.tools.min',
            '3dParty/rs-plugin/js/jquery.themepunch.revolution.min',
            '3dParty/requestAnimationFramePolyfill.min',
            '3dParty/jquery.scrollTo.min',
            '3dParty/colorbox/jquery.colorbox-min',
            'scripts/pi.global.min',
            'scripts/pi.slider',
            'scripts/pi.init.slider',
            '3dParty/jquery.easing.1.3',
            'scripts/pi.counter',
            'scripts/pi.init.counter',
            'scripts/pi.parallax',
            'scripts/pi.init.parallax',
            'scripts/pi.init.revolutionSlider',
        ));
        
        $this->addCss(array(
            '3dParty/bootstrap/css/bootstrap.min',
            'css/global',
            '3dParty/rs-plugin/css/pi.settings',
            'css/typo',
            '3dParty/colorbox/colorbox',
            'css/portfolio',
            'css/slider',
            'css/counters',
            'css/social',
            '3dParty/fontello/css/fontello',
        ));
        
        $this->layout = 'layout_site';       
        $this->set('title_layout', ' Sistemas de reservas para bares, restaurantes e casas noturnas ' . $this->systemName );
        $this->render();
        
    }
    
    
    public function login() {
        
        $this->addJs(array(
            '3dParty/jquery-1.11.0.min',
            '3dParty/bootstrap/js/bootstrap.min',
            '3dParty/requestAnimationFramePolyfill.min',
            '3dParty/jquery.scrollTo.min',
            '3dParty/colorbox/jquery.colorbox-min',
            'scripts/pi.global.min',
            '3dParty/jquery.easing.1.3',
            'scripts/pi.parallax',
            'scripts/pi.init.parallax',            
            'scripts/pi.init.revolutionSlider',
        ));
        
        $this->addCss(array(
            '3dParty/bootstrap/css/bootstrap.min',
            'css/global',
            '3dParty/rs-plugin/css/pi.settings',
            'css/typo',
            'css/boxes',
            'css/social',
            '3dParty/fontello/css/fontello',
        ));
        
        if( Session::check('Usuario')){
            header('Location: ' . Router::url(array('Usuarios', 'painel')));
            exit();
        } else {
            $this->layout = 'layout_site_not_header';
            $this->set('title_layout', ' Logar no sistema' . $this->systemName);
            $this->render();
        }
    }
    
    
    public function criarConta(){
        
        $this->addJs(array(
            '3dParty/jquery-1.11.0.min',
            '3dParty/bootstrap/js/bootstrap.min',
            '3dParty/jquery.touchSwipe.min',
            '3dParty/gauge.min',
            '3dParty/rs-plugin/js/jquery.themepunch.tools.min',
            '3dParty/rs-plugin/js/jquery.themepunch.revolution.min',
            '3dParty/requestAnimationFramePolyfill.min',
            '3dParty/jquery.scrollTo.min',
            '3dParty/colorbox/jquery.colorbox-min',
            'scripts/pi.global.min',
            'scripts/pi.slider',
            'scripts/pi.init.slider',
            '3dParty/jquery.easing.1.3',
            'scripts/pi.counter',
            'scripts/pi.init.counter',
            'scripts/pi.parallax',
            'scripts/pi.init.parallax',
            'scripts/pi.init.revolutionSlider',
        ));
        
        $this->addCss(array(
            '3dParty/bootstrap/css/bootstrap.min',
            'css/global',
            '3dParty/rs-plugin/css/pi.settings',
            'css/typo',
            '3dParty/colorbox/colorbox',
            'css/portfolio',
            'css/slider',
            'css/counters',
            'css/social',
            '3dParty/fontello/css/fontello',
        ));
        
        $this->layout = 'layout_site';          
        $this->set('title_layout', ' Crie sua conta com a my night ' . $this->systemName );
        $this->render();
    }
    
    
    public function cadastroEstabelecimento(){
        
        $this->addJs(array(
            '3dParty/jquery-1.11.0.min',
            '3dParty/bootstrap/js/bootstrap.min',
            '3dParty/jquery.touchSwipe.min',
            '3dParty/gauge.min',
            '3dParty/rs-plugin/js/jquery.themepunch.tools.min',
            '3dParty/rs-plugin/js/jquery.themepunch.revolution.min',
            '3dParty/requestAnimationFramePolyfill.min',
            '3dParty/jquery.scrollTo.min',
            '3dParty/colorbox/jquery.colorbox-min',
            'scripts/pi.global.min',
            'scripts/pi.slider',
            'scripts/pi.init.slider',
            '3dParty/jquery.easing.1.3',
            'scripts/pi.counter',
            'scripts/pi.init.counter',
            'scripts/pi.parallax',
            'scripts/pi.init.parallax',
            'scripts/pi.init.revolutionSlider',
            'scripts/cep',
        ));
        
        $this->addCss(array(
            '3dParty/bootstrap/css/bootstrap.min',
            'css/global',
            '3dParty/rs-plugin/css/pi.settings',
            'css/typo',
            '3dParty/colorbox/colorbox',
            'css/portfolio',
            'css/slider',
            'css/counters',
            'css/social',
            '3dParty/fontello/css/fontello',
        ));
        
        $this->layout = 'layout_site';          
        $this->set('title_layout', ' Crie sua conta com a my night ' . $this->systemName );
        $this->render();
    }
    
    public function primeirasConfiguracoes(){
        
        $this->addJs(array(
            '3dParty/jquery-1.11.0.min',
            '3dParty/bootstrap/js/bootstrap.min',
            '3dParty/jquery.touchSwipe.min',
            '3dParty/gauge.min',
            '3dParty/rs-plugin/js/jquery.themepunch.tools.min',
            '3dParty/rs-plugin/js/jquery.themepunch.revolution.min',
            '3dParty/requestAnimationFramePolyfill.min',
            '3dParty/jquery.scrollTo.min',
            '3dParty/colorbox/jquery.colorbox-min',
            'scripts/pi.global.min',
            'scripts/pi.slider',
            'scripts/pi.init.slider',
            '3dParty/jquery.easing.1.3',
            'scripts/pi.counter',
            'scripts/pi.init.counter',
            'scripts/pi.parallax',
            'scripts/pi.init.parallax',
            'scripts/pi.init.revolutionSlider',
            'scripts/cep',
            'scripts/config-primary',
        ));
        
        $this->addCss(array(
            '3dParty/bootstrap/css/bootstrap.min',
            'css/global',
            '3dParty/rs-plugin/css/pi.settings',
            'css/typo',
            '3dParty/colorbox/colorbox',
            'css/portfolio',
            'css/slider',
            'css/counters',
            'css/social',
            '3dParty/fontello/css/fontello',
        ));
        
        $this->layout = 'layout_site';          
        $this->set('title_layout', ' Crie sua conta com a my night ' . $this->systemName );
        $this->render();
    }


    public function ativarConta(){
        try{
            $this->layout = 'default';
            if( isset($_GET['param']) && !is_null($_GET['param'])){
                
                $this->User->ativaConta( trim($_GET['param']) );
                $this->set('title_layout', 'Conta Ativada!');
                $this->render();
                
            }
        } catch (Exception $ex) {

        }
    }
    
    public function cadastroSucesso(){
        try{
            
            $this->layout = 'default';
            $this->set('title_layout', 'Cadastro efetuado com sucesso');
            $this->render();
            
        } catch (Exception $ex) {
            
        }
    }
    
    public function vejaPlanos() {
        try{
            
            $this->layout = 'default';
            $this->set('title_layout', 'Veja os planos para sua empresa');
            $this->render();
            
        } catch (Exception $ex) {
            
        }
    }
    
    
    public function sendContato(){
       
        $parameters = array(
            'destinatario'      =>  'brunoblauzius@gmail.com',
            'nome_destinatario' =>  'Administrador my night',
            'layout'            =>  'email_contato',
        );
        
        $parameters = array_merge($parameters, $_POST);
        
        echo CurlStatic::send($parameters, 'json', 'http://mynight.com.br/ws/ServidorDeEmails/', 'POST');
        exit();
    }
    
}
