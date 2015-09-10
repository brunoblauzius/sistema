<?php

class Especialidade extends AppModel{
	
	public $useTable = 'tipos_servicos';
	
	public $name   = 'Especialidade';
	
	public $primaryKey = 'id';
	
	
	public $validate = array(
		'nome' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'mensagem' => 'Este campo é requirido',
			),
		),
	);

	public function listAll( $empresa_id = null){
		try{
			$newList = array();
			
			$servico = null;
			
			$this->useTable = 'servicos';
			$this->name     = 'Servico';
			$servicos = $this->find('all', array( 'empresas_id' => $empresa_id, 'status' => true ));
			
			
			$this->useTable = 'tipos_servicos';
			$this->name     = 'Especialidade';
			
			foreach ( $servicos as $servico ) {
				
				$especialidades = $this->find('all', array('empresas_id' => $empresa_id, 'status' => true, 'servicos_id' => $servico['Servico']['id'] ));
				
				$objeto = new Servicos( 
								  $servico['Servico']['id'],
								  $servico['Servico']['nome'],
								  null,
								  null
								  );
								  	  
					$objeto->setEspecialidades( $this->lista( (int) $servico['Servico']['id'] ) );
				
				$newList[] = $objeto;
			}
			return $newList;
		}catch( Exception $ex ){
			throw $ex;
		}
	}
	
	
	public function servicosEspecialidades( $empresa_id = null){
		try{
		
			$newList = array();
			$ServicoModel = new Servico();
			
			$sql = "SELECT DISTINCT
						Servico.*
					FROM
						agentus_database.servicos AS Servico
							INNER JOIN
						agentus_database.tipos_servicos AS TipoServico ON TipoServico.servicos_id = Servico.id
					WHERE
						Servico.empresas_id = {$empresa_id};";
			
			$servicos = $ServicoModel->query( $sql );
			
			foreach( $servicos as $servico ){
				
				$object = new Servicos( 
							  $servico['id'],
							  $servico['nome']
							  );	  
				$object->setEspecialidades( $this->lista( (int) $servico['id'] ) );
				$newList[] = $object;
			}		
			return $newList;
			
		}catch( Exception $ex ){
			throw $ex;
		}
	}
	
	private function lista( $servicosId ){
		#instacio meu objeto
		$lista = array();
		
		#recupero minha especialidade
		$especialidades = $this->find('all', array('servicos_id' => $servicosId, 'status' => true ));
		
		foreach( $especialidades as $especialidade ){
						
			$lista[] = new Especialidades(
				$especialidade['Especialidade']['id'], 
				$especialidade['Especialidade']['nome'], 
				$especialidade['Especialidade']['status']
			);
		}
		return $lista;
	}
	
	
	public function verificaPessoaEspecialidade( $pessoaId, $especialidadeId ){
		$sql = "SELECT COUNT(*) as total FROM pessoas_has_tipos_servicos WHERE pessoas_id = {$pessoaId} AND tipos_servicos_id = {$especialidadeId};";
		$retorno = $this->query($sql);
		return ( $retorno[0]['total'] == 1 );
	}
	
	public function ativaPessoaEspecialidade( $pessoaId, $especialidadeId, $status ){
		try{
		
			$sql = "UPDATE pessoas_has_tipos_servicos 
					SET 
						status = {$status}
					WHERE
						pessoas_id = {$pessoaId}
							AND tipos_servicos_id = {$especialidadeId};";
			$retorno = $this->query($sql);
			
		}catch( Exception $ex ){
			throw $ex;
		}
	}


	public function relacaoServicos( $pessoaId ){
		try{
		
			 $sql = "	SELECT DISTINCT
							Servico.id, Servico.nome
						FROM
							agentus_database.pessoas_has_tipos_servicos AS MeusServicos
								INNER JOIN
							agentus_database.tipos_servicos AS TipoServico ON TipoServico.id = MeusServicos.tipos_servicos_id
								INNER JOIN
							agentus_database.servicos AS Servico ON Servico.id = TipoServico.servicos_id
						WHERE
							MeusServicos.pessoas_id = {$pessoaId}
								AND Servico.status = 1
						;";
						
		    $retorno = $this->query($sql);
		    return $retorno;
		}catch(Exception $ex){
			echo json_encode(array(
				'funcao' => "infoErro('".$ex->getMessage()."', '#ProfissionalFormEdit');",
			));
		}
	}
	
	
	public function listToServicos( $pessoaId, $servicoId ){
		try{
		
			 $sql = "	SELECT DISTINCT
							TipoServico.id, TipoServico.nome
						FROM
							agentus_database.pessoas_has_tipos_servicos AS MeusServicos
								INNER JOIN
							agentus_database.tipos_servicos AS TipoServico ON TipoServico.id = MeusServicos.tipos_servicos_id
						WHERE
							MeusServicos.pessoas_id = {$pessoaId}
								AND TipoServico.status = 1
								AND MeusServicos.status = 1
								and TipoServico.servicos_id = {$servicoId};";
						
		    $retorno = $this->query($sql);
			return $retorno;
			
		}catch(Exception $ex){
			echo json_encode(array(
				'funcao' => "infoErro('".$ex->getMessage()."', '#ProfissionalFormEdit');",
			));
		}
	}
	
}