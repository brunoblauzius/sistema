<?php

/**
 * Description of 
 *
 * @author blauzius
 */
class WebservicesController extends AppController {

    public $ClasseAllow = array('cep', 'listarEmpresas', 'autenticacaoFacebook', 'cadastroMobileFacebook', 'cadastroMobile', 'autenticacaoMobile');
    private $Pessoa = null;
    private $User = null;

    public function __construct() {
        parent::__construct();
        $this->Pessoa = new Pessoa();
        $this->User = new Usuario();
    }

    public function cadastroEmpresa() {
        try {
            $_POST = Utils::sanitazeArray($_POST);
            $rg = NULL;
            $tipoPessoa = $_POST[$this->Pessoa->name]['tipo_pessoa'];
            $nome = $_POST[$this->Pessoa->name]['nome'];
            $email = $_POST[$this->Pessoa->name]['email'];
            $razao = $_POST['Juridica']['razao'];
            $fantasia = $_POST['Juridica']['fantasia'];
            $ie = $_POST['Juridica']['ie'];
            $senha = Authentication::password($_POST[$this->Pessoa->name]['senha']);

            if ($tipoPessoa == 1) {
                $cpfCnpj = Utils::returnNumeric($_POST['Fisica']['cpf']);
                $_POST[$this->Pessoa->name]['cpf'] = Utils::returnNumeric($_POST['Fisica']['cpf']);
            } else {
                $this->Pessoa->validate = $this->Pessoa->validate_fisica;
                $cpfCnpj = Utils::returnNumeric($_POST['Juridica']['cnpj']);
                $_POST[$this->Pessoa->name]['cnpj'] = Utils::returnNumeric($_POST['Juridica']['cnpj']);
                $_POST[$this->Pessoa->name]['razao'] = $_POST['Juridica']['razao'];
                $_POST[$this->Pessoa->name]['fantasia'] = $_POST['Juridica']['fantasia'];
                $_POST[$this->Pessoa->name]['ie'] = $_POST['Juridica']['ie'];
            }

            $this->Pessoa->data = $_POST[$this->Pessoa->name];
            if ($this->Pessoa->validates()) {
                $retorno = $this->Pessoa->cadastroEmpresa($nome, $cpfCnpj, $rg, $razao, $fantasia, $ie, $email, $senha, $tipoPessoa);
                if (isset($retorno['pessoaId']) && $retorno['pessoaId'] > 0) {
                    //enviar email
                    #recupero a chave do usuario
                    $chave = $this->Pessoa->recuperaChave($cpfCnpj);
                    #recupero o corpo do meu email para ser cadastrado
                    $email = new Email();
                    $registro = $email->find('first', array('tag' => 'cadastro_sucesso'));
                    #faço a troca de siglas para personalizar o email
                    $array = array(
                        '__NOME_REMETENTE__' => $_POST[$this->Pessoa->name]['nome'],
                        '__DATE__' => date('d/m/Y h:i:s'),
                        '__URL__' => Router::url(array('Pages', 'ativarConta', $chave)),
                    );

                    #envio o email de confirmação para o meu cliente cadastrado
                    $objeto = new MailPHPMailer();
                    $objeto->setAssunto('Cadastro realizado com sucesso!');
                    $objeto->setRemetente();
                    $objeto->setDestinatario($_POST[$this->Pessoa->name]['email'], $_POST[$this->Pessoa->name]['nome']);
                    $objeto->setBody(str_replace(array_keys($array), array_values($array), $registro[0]['Email']['corpo_mail']));
                    $email = $objeto->sendMail();

                    #saida para o usuario
                    echo json_encode(array(
                        'erro' => false,
                        'mensagem' => "Seu cadastro foi efetuado com sucesso",
                        'pessoa_id' => (int) $retorno['pessoaId'],
                        'envio_email' => $email
                    ));
                } else {
                    #caso de erro fazer esse procedimento
                }
            } else {
                echo json_encode(array(
                    'erro' => true,
                    'erros' => $this->Pessoa->validateErros,
                ));
            }
        } catch (Exception $ex) {
            #em caso de erro fazer esse procedimento
            echo json_encode(array(
                'erro' => true,
                'erros' => utf8_encode($ex->getMessage()),
            ));
        }
    }

    public function login() {

        try {
            $this->User->validate = $this->User->validate_login;
            $_POST = Utils::sanitazeArray($_POST);
            $this->User->data = $_POST[$this->User->name];
            if ($this->User->validates()) {

                $this->User->data['senha'] = Authentication::password($this->User->data['senha']);
                /**
                 * toda a minha validação de status da conta, usuario ou empresa está na procedure.
                 * referencia MODEL/USUARIOS.PHP
                 * metodo LOGAR
                 */
                $usuario[$this->User->name] = $this->User->logar($this->User->data['email'], $this->User->data['senha']);
                if (( count($usuario[$this->User->name]) > 0 ) && ( $usuario[$this->User->name]['status'] == true )) {
                    echo json_encode(array(
                        'erro' => false,
                        'usuario' => array_shift($usuario)
                    ));
                } else {
                    throw new Exception('Não foi possivel logar, verifique usuário e senha, ou verifique seu e-mail para ativar sua conta!');
                }
            } else {
                echo json_encode(array(
                    'erro' => true,
                    'erros' => $this->User->validateErros,
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erro' => true,
                'mensagem' => utf8_decode($ex->getMessage()),
            ));
        }
    }

    public function cep() {
        try {
            $cep = (int) $_POST['cep'];
            echo CurlStatic::send(array('valor' => $cep), 'json', 'http://mynight.com.br/ws/SOA/cep.php', 'GET');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function listaEmpresa() {
        try {
            $hashIdEmpresa = $_POST['valor'];
            $sql = "SELECT * FROM vw_empresa_full WHERE MD5(pessoa_id) = '{$hashIdEmpresa}';";
            $empresa = $this->Pessoa->query($sql);
            echo json_encode($empresa[0]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function listaProdutos() {
        try {
            $ProdutosSistema = new Carrinho();
            $lista = $ProdutosSistema->recuperarProdutosSistema();
            $new = array();
            foreach ($lista as $value) {
                if ($value['id'] != 1) {
                    $new[] = array(
                        'id' => $value['id'],
                        'nome' => utf8_encode($value['nome']),
                        'valor' => $value['valor']
                    );
                }
            }

            echo json_encode($new);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @todo metodo que lista todas as empresas para o app
     */
    public function listarEmpresas() {
        try {

            $Empresas = new Empresa();
            $telefone = new Contato();

            $registros = $Empresas->query('SELECT * FROM vw_empresas_sistema WHERE status = 1');

            $i = 0;

            foreach ($registros as $registro) {
                $registros[$i] = array_merge($registro, array('telefones' => $telefone->findEmpresasContatos($registro['id'])));
                $i++;
            }

            echo json_encode($registros);
        } catch (Exception $ex) {
            
        }
    }

    public function autenticacaoFacebook() {
        try {

            $facebook = new Facebook();

            $usuario = $facebook->setFacebookId((int) $_POST['facebook_id'])
                    ->facebookIdNull()
                    ->authentiction();

            echo json_encode(array(
                'erro' => false,
                'code' => 000,
                'message' => 'success',
                'resultado' => $usuario
            ));
        } catch (Exception $ex) {
            echo json_encode(array(
                'erro' => true,
                'code' => $ex->getCode(),
                'message' => $ex->getMessage(),
            ));
        }
    }

    public function autenticacaoMobile() {
        try {

            $facebook = new Mobile();


            $usuario = $facebook->setEmail($_POST['email'])
                    ->setPass($_POST['senha'])
                    ->authentiction();

            echo json_encode(array(
                'erro' => false,
                'code' => 000,
                'message' => 'success',
                'resultado' => $usuario
            ));
        } catch (Exception $ex) {
            echo json_encode(array(
                'erro' => true,
                'code' => $ex->getCode(),
                'message' => $ex->getMessage(),
            ));
        }
    }

    public function cadastroMobileFacebook() {
        try {

            $facebook = new Facebook();

            if (empty($_POST)) {
                throw new Exception('erro do post');
            }

            $facebook->data = $_POST;

            if ($facebook->validates()) {

                $dados = $facebook->setEmail($facebook->data['email'])
                        ->setFacebookId($facebook->data['facebook_id'])
                        ->setNome($facebook->data['nome'])
                        ->setPhone($facebook->data['telefone'])
                        ->register();

                echo json_encode(array(
                    'erro' => false,
                    'code' => 000,
                    'message' => 'success',
                    'resultado' => $dados
                ));
            } else {
                echo json_encode(array(
                    'erro' => true,
                    'code' => 001,
                    'errors' => $facebook->validateErros,
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erro' => true,
                'code' => $ex->getCode(),
                'message' => $ex->getMessage(),
            ));
        }
    }

    public function cadastroMobile() {
        try {

            $model = new Mobile();

            if (empty($_POST)) {
                throw new Exception('erro do post');
            }

            $model->data = $_POST;

            if ($model->validates()) {

                $dados = $model->setEmail($model->data['email'])
                        ->setNome($model->data['nome'])
                        ->setPhone($model->data['telefone'])
                        ->setPass($model->data['senha'])
                        ->register();

                echo json_encode(array(
                    'erro' => false,
                    'code' => 000,
                    'message' => 'success',
                    'resultado' => $dados
                ));
            } else {
                echo json_encode(array(
                    'erro' => true,
                    'code' => 001,
                    'errors' => $model->validateErros,
                ));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'erro' => true,
                'code' => $ex->getCode(),
                'message' => $ex->getMessage(),
            ));
        }
    }

}
