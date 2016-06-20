<?php


require_once 'Interface/TemplateRegisterApp.php';

/**
 * Description of Mobile
 *
 * @author BRUNO
 */
class Mobile extends TemplateRegisterApp {

    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'senha' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'telefone' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO
            ),
            'email' => array(
                'rule' => array('email'),
                'mensagem' => Enum::EMAIL_INVALIDO
            ),
        ),
    );
    
    public function sqlAutentication() {
        return "SELECT * FROM vw_clientes WHERE email = '{$this->getEmail()}' AND senha = '".Authentication::password($this->getPass())."}' ";
    }
    
    public function cadastro($created) {
        
        /**
        * criar uma pessoa
        */
         $modelPessoa = new Pessoa();
         $pessoasId = $modelPessoa->genericInsert(array(
             'tipo_pessoa' => 1,
             'created'     => $created,
         ));
        /**
         * criar uma pessoa fisica
         */
         $ModelPF = new Fisica();
         $ModelPF->genericInsert(array(
             'pessoas_id' => $pessoasId,
             'cpf'  => '00000000000',
             'nome' => $this->getNome(),
         ));
        /**
         * criar um contato
         */
        $modelContato = new Contato();
        $contatoId = $modelContato->genericInsert(array(
            'telefone' => Utils::returnNumeric( $this->getPhone() ),
            'tipo'     => 1,
        ));
        $modelContato->inserirContato($pessoasId, $contatoId);
        
        /**
         * criar um email
         */
        if( $this->getEmail() != NULL ){
            $modelEmail = new Email();
            $modelEmail->inserirEmailPessoa($pessoasId, $this->getEmail());
        }
        
        /**
         * criar um usuario
         */         
         if( $this->getPass() != null ){
             
            $modelUsuario = new Usuario();
            $this->setPass( Authentication::password($this->getPass()) );
            
            $usuarioId = $modelUsuario->genericInsert(array(
               'roles_id' => 1,
               'pessoas_id' => $pessoasId,
               'status' => 1,
               'perfil_teste' => 0,
               'created' => $created,
               'email' => $this->getEmail(),
               'login' => $this->getEmail(),
               'senha' => $this->getPass(),
               'chave' => Authentication::uuid(),
           ));
        }
         
        $modelCliente = new Cliente();
        $modelCliente->genericInsert(array(
            'pessoas_id' => $pessoasId,
            'status' => 1,
            'sexo'   => 0,
        ));

        return $modelCliente->recuperaCliente($this->getNome(), $this->getPhone()); 
    }

    
    public function update($created, $registro) {
        return $registro;
    }
}
