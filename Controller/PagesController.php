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
            'scripts/funcoes.site',
            'scripts/ajaxForm',
            'scripts/criar.conta',
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
            'css/pricing-tables',
            'css/social',
            '3dParty/fontello/css/fontello',
            
        ));
        
        $this->layout = 'layout_site';       
        $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
        $this->set('title_layout', 'My Nyght Software Controle de Eventos e Reservas - ' . $this->systemName );
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
             $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
            $this->set('title_layout', ' Logar no sistema' . $this->systemName);
            $this->render();
        }
    }
    
    
    public function criarConta(){
                
        if( isset($_GET['param']) && !empty($_GET['param'])){
            $_SESSION['Produto']['id'] = intval(isset($_GET['param']));
        } else {
            $_SESSION['Produto']['id'] = 2;
        }
        
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
            'scripts/funcoes.site',
            'scripts/ajaxForm',
            'scripts/criar.conta',
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
        
        $this->layout = 'layout_site_menu_sem_link';
         $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
        $this->set('title_layout', ' Crie sua conta com a my night ' . $this->systemName );
        $this->render();
    }
    
    
    public function cadastroEstabelecimento(){
        
        if( Session::check('Pessoa') ){
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
                'scripts/funcoes.site',
                'scripts/ajaxForm',
                'scripts/criar.conta',
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
            $this->layout = 'layout_site_menu_sem_link';   
             $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
            $this->set('title_layout', ' Crie sua conta com a my night ' . $this->systemName );
            $this->render();
        } else {
            Render::redirect(array('Pages','criar-conta'));
        }
    }
    
    public function primeirasConfiguracoes(){
               
//        $_SESSION = Array
//            (
//                'Pessoa' => Array
//                    (
//                        'nome' => 'Bruno Blauzius Schuindt',
//                        'email' => 'brunoblauzius@gmail.com',
//                        'ddd' => 41,
//                        'telefone' => 97268858,
//                        'senha' => 'blauzius02',
//                        'confirm_senha' => 'blauzius02',
//                        'termo' => 1,
//                        'pessoas_id' => 18,
//                        'pessoaFisica_id' => 17,
//                        'usuarios_id' => 17,
//                    ),
//
//                'Empresa' => Array
//                    (
//                        'nome_fantasia' => 'Minha Empresa Teste',
//                        'pessoaJuridica_id' => 12,
//                        'empresas_id' => 12,
//                    ),
//
//                'Endereco' => Array
//                    (
//                        'cep' => 83331210,
//                        'logradouro' => 'Rua Leila Diniz', 
//                        'bairro' => 'Maria Antonieta' ,
//                        'cidade' => 'Pinhais',
//                        'uf' => 'PR',
//                        'numero' => 5632,
//                    ),
//
//            );
        
        if( Session::check('Empresa') ){
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
                'scripts/funcoes.site',
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
            
            $this->layout = 'layout_site_menu_sem_link';
             $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
            $this->set('title_layout', ' Crie sua conta com a my night ' . $this->systemName );
            $this->render();
            
        } else {
            Render::redirect(array('Pages','cadastro-estabelecimento'));
        }
                        
    }


    public function ativarConta(){
        try{
            
            if( isset($_GET['param']) && !is_null($_GET['param'])){
                $this->User->ativaConta( trim($_GET['param']) );
            
                $this->layout = 'default';
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
                    'scripts/funcoes.site',
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

                $this->layout = 'layout_site_menu_sem_link';
                 $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
                $this->set('title_layout', 'Conta Ativada!');
                $this->render();
            } else {
                Render::redirect();
            }
            
        } catch (Exception $ex) {

        }
    }
    
    public function cadastroSucesso(){
        try{
            
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
                'scripts/funcoes.site',
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
            $this->layout = 'layout_site_menu_sem_link';   
             $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
            $this->set('title_layout', 'Cadastro efetuado com sucesso');
            $this->render();
            
        } catch (Exception $ex) {
            
        }
    }
    
    public function vejaPlanos() {
        try{
            
            $this->layout = 'default';
             $this->set('description', 'Otimize o trabalho de gerenciamento de reservas e eventos e de quebra receba uma ferramenta poderosíssima de gestão de clientes. Com o MyNight, você terá informações da mais alta qualidade para conseguir visualizar como está a procura por reservas na sua casa, verificando o perfil do cliente, reservas por dia da semana, ociosidade do salão, clientes mais frequentes, taxas de no-show e muito mais!');
            $this->set('title_layout', 'Veja os planos para sua empresa');
            $this->render();
            
        } catch (Exception $ex) {
            
        }
    }
    
    
    public function sendContato(){
       
        $parameters = array(
            'destinatario'      =>  'contato@mynight.com.br',
            'nome_destinatario' =>  'Administrador my night',
            'layout'            =>  'email_contato',
        );
        
        $parameters = array_merge($parameters, $_POST);
        
        $retorno = CurlStatic::send($parameters, 'json', Enum::URL_SERVIDOR_DE_EMAIL , 'POST');
        $retorno = json_decode($retorno, TRUE);
        
        if($retorno['success'] == true ){
            echo json_encode(array(
                    'erro' => false,
                    'mensagem' => '',
                    'funcao' => "msg_sucesso( 'Seu contato foi enviado com sucesso, aguarde e retornaremos em breve!' , '#ContatoSend');limparFormulario();"
                ));
        } else {
            unset($retorno['success']);
            unset($retorno['style']);
            $this->User->validateErros = $retorno;                    
            echo json_encode(array(
                    'erro' => true,
                    'funcao' => "msg_erro( '{$this->User->refactoryError()}' , '#ContatoSend');hideLoaderForm('#ContatoSend');",
                ));
        }
        
    }
    
}
