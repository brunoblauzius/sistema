<?php

class EnderecosController extends AppController{

	
	public $Endereco = null;
	public $Funcionario = null;
	
	public function __construct(){
		parent::__construct();
		$this->layout = 'painel';
		
		$this->Funcionario = new Funcionario();
		$this->Endereco    = new Endereco();
	}
	
	
	public function cadastro(){
		try{
			
			$funcionario = $this->Funcionario->find('first', array('md5(pessoas_id)' => $_GET['param']));
			$funcionario = array_shift($funcionario);
			$_SESSION['Form']['pessoas_id'] = (int) $funcionario[$this->Funcionario->name]['pessoas_id'];
			$objeto = new Funcionarios( null, (int) $funcionario[$this->Funcionario->name]['pessoas_id'] );
			
			$this->set('title_layout', 'Endereços - Cadastro');
			$this->set('funcionario', $objeto);
			$this->render();
			
		} catch ( Exception $ex ){
			echo $ex->getMessage();
		}
	}
	
	public function add() {
		try{
		
			if( $this->is('post') || $this->is('put') ){
				$_POST[$this->Endereco->name]['pessoas_id'] = $_SESSION['Form']['pessoas_id'];
				$this->Endereco->data = $_POST[$this->Endereco->name];
				
				/**
				*VALIDAÇÃO DOS CAMPOS
				*/
				if( $this->Endereco->validates() ){
					
					/**
					*PERSISTE OS DADOS
					*/
					if( $this->Endereco->genericInsert( $this->Endereco->data ) ){
						$url = Router::url(array('Funcionarios', 'perfil', md5($_SESSION['Form']['pessoas_id']) ));
						echo json_encode(array(
							'funcao' => "sucessoForm( 'Cadastro foi efetuado com sucesso!', '#EnderecosAddForm' );
										 redirect('{$url}', '".'#EnderecosAddForm'."')",
						));
					} else {
						echo json_encode(array(
								'funcao' => "infoErro('Houve um erro ao inserir, contate o suporte', '#EnderecosAddForm');",
							));
					}
				}else{
					echo json_encode(array(
						'erros' => $this->Endereco->validateErros,
						'form'  => 'EnderecosAddForm',
					));
				}
				
			}
		
		} catch (Exeception $ex ){
			echo $ex->getMessage();
		}
		
	}
	
	public function editar(){
		try{
		
			$funcionario = $this->Endereco->find('all', array('md5(id)' => $_GET['param'] ));
			$funcionario = array_shift($funcionario);
			$_SESSION['Form']['id'] 		= (int) $funcionario[$this->Endereco->name]['id'];
			$_SESSION['Form']['pessoas_id'] = (int) $funcionario[$this->Endereco->name]['pessoas_id'];
			
			$endereco = $this->Endereco->findEndereco( $funcionario[$this->Endereco->name]['pessoas_id'] );
			
			$this->set('title_layout', 'Endereços - Editar');
			$this->set('endereco', $endereco);
			$this->render();
			
		} catch ( Exception $ex ){
			echo $ex->getMessage();
		}
	}
	
	public function edit(){
		try{
			if( $this->is('post') || $this->is('put') ){
			
				
				$_POST[$this->Endereco->name]['id'] = $_SESSION['Form']['id'];
				$this->Endereco->data = $_POST[$this->Endereco->name];
				
				/**
				*VALIDAÇÃO DOS CAMPOS
				*/
				
				if( $this->Endereco->validates() ){
					
					/**
					*PERSISTE OS DADOS
					*/
					if( $this->Endereco->genericUpdate( $this->Endereco->data ) ){
									
						$url = Router::url(array('Funcionarios', 'perfil', md5($_SESSION['Form']['pessoas_id'])));
						echo json_encode(array(
							'funcao' => "sucessoForm( 'Cadastro foi efetuado com sucesso!', '#EnderecosEditForm' );
										 redirect('{$url}', '".'#EnderecosEditForm'."')",
						));
					} else {
						echo json_encode(array(
								'funcao' => "infoErro('Houve um erro ao inserir, contate o suporte', '#EnderecosEditForm');",
							));
					}
				}else{
					echo json_encode(array(
						'erros' => $this->Endereco->validateErros,
						'form'  => 'EnderecosEditForm',
					));
				}
				
			}
		} catch ( Exception $ex){
			$ex->getMessage();
		}
	}
	

}