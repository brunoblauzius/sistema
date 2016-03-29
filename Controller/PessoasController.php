<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PessoasController
 *
 * @author blauzius
 */
class PessoasController extends AppController {
    
    public  $ClasseAllow = array('cadastroSite');
    private $Pessoa = null;
    private $Fisica = null;
    private $Usuario = null;
    private $Contato = null;
    private $Email   = null;
    
    
    public function __construct() {
        
        parent::__construct();
        $this->Pessoa  = new Pessoa();
        $this->Fisica  = new Fisica();
        $this->Usuario = new Usuario();
        $this->Contato = new Contato();
        $this->Email   = new Email();
    }
    
    
    public function index(){
        try {
            
            $this->layout = 'painel';
            /**
             * recuperar dados da empresa
             */
            
            $proprietarios = $this->Pessoa->proprietarioEmpresas();
            
            
                        
            $this->set('title_layout', 'Proprietários de Empresas');
            $this->set('proprietarios', $proprietarios);
            $this->render();
            
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function cadastro(){
        try {
            
            $this->layout = 'painel';
            $this->set('title_layout', 'Cadastro de Empresa');
            $this->render();
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public function add() {
        try{
            $pessoaId   = 0;
            $telefones  = $_POST['Contato'];
            $created    = date('Y-m-d H:i:s');
            /**
             * RETIRADO CARACTERES INDESEJADOS
             */
            $_POST[$this->Fisica->name]['cpf'] = Utils::returnNumeric($_POST[$this->Fisica->name]['cpf']);
            
            /**
             * LIMPANDO OS CARACTERES HTML, PHP, CSS, JS
             */
            $_POST = Utils::sanitazeArray( $_POST );
                        
            /**
             * criar o metodo marge para fazer o merge dos arrays e a verificação de dados inconsistentes
             */
            $this->Pessoa->data = array_merge($this->Pessoa->data, $_POST[$this->Fisica->name] );
            $this->Pessoa->data = array_merge($this->Pessoa->data, $_POST['Email'] );
            $this->Pessoa->data = array_merge($this->Pessoa->data, $_POST[$this->Usuario->name] );
            
            
            /**
             * validação dos meus campos para o formulário
             */
            
            if( $this->Pessoa->validates() ){
                
                /**
                 * INSERIR PESSOA 
                 */
                $this->Pessoa->useTable = 'pessoas';
                $pessoaId = $this->Pessoa->genericInsert( array( 
                        'created'     => $created,
                        'tipo_pessoa' => 1,
                    ));
                /**
                 * INSERIR PESSOA FISICA
                 */
                
                $this->Fisica->genericInsert(array(
                    'pessoas_id' => $pessoaId,
                    'nome'       => $_POST[$this->Fisica->name]['nome'],
                    'cpf'        => $_POST[$this->Fisica->name]['cpf'],
                    'rg'         => $_POST[$this->Fisica->name]['rg'],
                ));
                
                /**
                 * INSERIR USUARIO
                 */
                $userKey = Authentication::uuid();
                
                $this->Usuario->genericInsert(array(
                    'pessoas_id'      => $pessoaId,
                    'roles_id'        => 4,
                    'perfil_teste'    => 0,
                    'status'          => 1,
                    'email'           => $_POST['Email']['email'],
                    'login'           => $_POST[$this->Usuario->name]['login'],
                    'senha'           => Authentication::password($_POST[$this->Usuario->name]['senha']),
                    'chave'           => $userKey,
                    'created'         => $created,
                ));
                
                /**
                 * INSERIR CONTATO
                 */
                $this->Contato->inserirContatosPessoa($pessoaId, $telefones);
                /**
                 * INSERIR EMAIL
                 */
                $this->Email->inserirEmailPessoa($pessoaId, $_POST['Email']['email']);
                
                
                if(  $pessoaId > 0 ) {
                    //enviar email
                    //                        
//                        #recupero o corpo do meu email para ser cadastrado
//                        $email = new Email();
//                        $registro = $email->find('first', array('tag' => 'cadastro_sucesso'));
//                        #faço a troca de siglas para personalizar o email
//                        $array = array(
//                               '__NOME_REMETENTE__' => $_POST[$this->Fisica->name]['nome'],
//                               '__DATE__' => date('d/m/Y h:i:s'),
//                               '__URL__'  => Router::url(array('Pages', 'ativarConta', $chave)),
//                                );
//                        
//                        #envio o email de confirmação para o meu cliente cadastrado
//                        $objeto = new MailPHPMailer();
//                        $objeto->setAssunto('Cadastro realizado com sucesso!');
//                        $objeto->setRemetente();
//                        $objeto->setDestinatario( $_POST[$this->Pessoa->name]['email'] , $_POST[$this->Pessoa->name]['nome']);
//                        $objeto->setBody( str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']) );
//                        $objeto->sendMail();
//                        
//                        #saida para o usuario
                        
                        $_SESSION['cadastroEmpresa']['pessoas_id'] = $pessoaId;
                    
                        $url = Router::url(array('Empresas', 'cadastro'));
                        echo json_encode(array(
                            'funcao' => "sucessoForm( 'Seu cadastro foi efetuado com sucesso', '#PessoaAddForm' );"
                                      . "redirect('{$url}');",
                        ));
                        
                } else {
                    #caso de erro fazer esse procedimento
                }
                
            } else {
                echo json_encode(array(
                    'erros' => ($this->Pessoa->validateErros),
                    'form'  => $this->Pessoa->name . 'AddForm',
                ));
            }
            
            
            
        } catch (Exception $ex) {
            #em caso de erro fazer esse procedimento
            echo $ex->getMessage();
        }
    }
    
    public function cadastroSite(){
        try {
            
            $_SESSION = $_POST;
            /**
             * criar uma pessoa 
             */
            
            /**
             * criar uma Pessoa Fisica
             */
            
            /**
             * cria um usuario
             */
            
            Router::redirect(array('pages', 'cadastro-estabelecimento'));
            
        } catch (Exception $ex) {
            
        }
    }
    
}
