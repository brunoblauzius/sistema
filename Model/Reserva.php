<?php

class Reserva extends AppModel {

    public $useTable = 'reservas';
    public $name = 'Reserva';
    public $primaryKey = 'id';
    private $totalLista = 0;
    public $validate = array(
        'data' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'hora' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'qtde_pessoas' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
            'isInt' => array(
                'rule' => array('isInt'),
                'mensagem' => 'Insira um valor numérico',
            ),
        ),
        'pessoas_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'clientes_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'saloes_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'ambientes_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'start' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'end' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
    );

    public function sanitizeAgenda($array = array()) {

        $list = array();

        $reservasId = null;

        $id = null;

        if (!empty($array['servico_id'][0]) && is_array($array['servico_id'])) {

            if (isset($_SESSION['reservas_id'])) {

                $reservasId = $_SESSION['reservas_id'];
            }

            foreach ($array['servico_id'] as $registro) {

                if (isset($array['id'])) {

                    $id = current($array['id']);
                }

                $valor = current($array['valor']);

                $tipoServico = current($array['tipo_servico_id']);

                $list[] = array(
                    'id' => $id,
                    'reservas_id' => $reservasId,
                    'servico_id' => $registro,
                    'tipo_servico_id' => $tipoServico,
                    'valor' => $valor
                );

                $this->totalLista += $valor;

                next($array['valor']);

                next($array['tipo_servico_id']);

                if (isset($array['id'])) {
                    next($array['id']);
                }
            }
        }
        return $list;
    }

    public function sanitizeAgendaDespesa($array = array(), $reservasId) {

        $list = array();
        if (!empty($array['nome'][0]) && is_array($array['nome'])) {

            $id = null;
            foreach ($array['nome'] as $nome) {

                if (isset($array['id'])) {
                    $id = current($array['id']);
                }

                $valor = current($array['valor']);
                $data = current($array['data']);

                $list[] = array(
                    'id' => $id,
                    'reservas_id' => $reservasId,
                    'nome' => $nome,
                    'data' => Utils::revertDate($data),
                    'valor' => $valor
                );
                //$this->totalLista += $valor;
                next($array['valor']);
                next($array['data']);

                if (isset($array['id'])) {
                    next($array['id']);
                }
            }
        }
        return $list;
    }

    public function getTotalLista() {

        return $this->totalLista;
    }

    public function inserirItensAgenda(array $lista, $clienteId, $empresaId, $pessoaId, $registroId) {

        try {

            $listaInserts = array();

            if (!empty($lista)) {
                foreach ($lista as $registro) {
                    $sql = "INSERT INTO reservas_has_tipos_servicos(reservas_id,clientes_id,pessoas_id,empresas_id,tipos_servicos_id,servicos_id,valor) 

							VALUES({$registroId},{$clienteId},{$pessoaId},{$empresaId},{$registro['tipo_servico_id']},{$registro['servico_id']},{$registro['valor']});";

                    $id = $this->query($sql);
                    $listaInserts[] = $id;
                }
            }

            return $listaInserts;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function insertAndUpdateItensAgenda(array $lista, $clienteId, $empresaId, $pessoaId) {

        try {
            $listaInserts = array();
            if (!empty($lista)) {
                foreach ($lista as $registro) {
                    /**
                     * 	verificando se existe o registro
                     */
                    if (!empty($registro['id'])) {

                        $sql = "UPDATE reservas_has_tipos_servicos SET 
                                reservas_id = {$registro['reservas_id']},
                                clientes_id     = {$clienteId},
                                pessoas_id      = {$pessoaId},
                                empresas_id		= {$empresaId},
                                tipos_servicos_id = {$registro['tipo_servico_id']},
                                servicos_id       = {$registro['servico_id']},
                                valor 			  = {$registro['valor']} 
                                WHERE 
                                        id = {$registro['id']};";
                    } else {

                        $sql = "INSERT INTO reservas_has_tipos_servicos(reservas_id,clientes_id,pessoas_id,empresas_id,tipos_servicos_id,servicos_id,valor) 
				VALUES({$registro['reservas_id']},{$clienteId},{$pessoaId},{$empresaId},{$registro['tipo_servico_id']},{$registro['servico_id']},{$registro['valor']});";
                    }
                    $listaInserts[] = $this->query($sql);
                }
            }

            return $listaInserts;
        } catch (Exception $e) {

            throw $e;
        }
    }

    public function insertAndUpdateItensDespesasAgenda(array $lista, $empresaId) {

        try {
            $listaInserts = array();
            if (!empty($lista)) {
                foreach ($lista as $registro) {
                    /**
                     * 	verificando se existe o registro
                     */
                    $despesaId = null;

                    if (!empty($registro['id'])) {
                       $sql = "UPDATE reservas.despesas SET 
                                nome         	  = '{$registro['nome']}',
                                data_vencimento   = '{$registro['data']}',
                                valor 		  = {$registro['valor']} 
                                WHERE 
                                    id = {$registro['id']};";

                        $despesaId = $this->query($sql);
                    } else {

                        $sql = "INSERT INTO `reservas`.`despesas`
                                            ( `empresas_id`, `nome`, `valor`, `data_vencimento`, `created` )
                                 VALUES ( $empresaId, '{$registro['nome']}', {$registro['valor']}, '{$registro['data']}', NOW() );";

                        $despesaId = $this->query($sql);

                        $sql = "INSERT INTO `reservas`.`reservas_has_despesas`
                                    (`reservas_id`, `despesas_id`, `empresas_id`)
                                VALUES
                                    ( {$registro['reservas_id']}, $despesaId, $empresaId );";

                        $this->query($sql);
                    }
                }
            }

            return $despesaId;
        } catch (Exception $e) {
            throw $e;
        }
    }

    

    public function listAllEmpresas($empresaId, $pessoasId = null) {

        try {

            $PESSOA = null;

            if (!empty($pessoasId)) {

                $PESSOA = " AND pessoas_id = {$pessoasId} ";
            }



            $sql = "SELECT 

							id,

							title,

							start,

							end,

							color, 

							textColor,

							editable

						FROM

							reservas.reservas

						WHERE

								empresas_id = $empresaId

								" . $PESSOA . "

								AND `status` in (0,1,2);";

            $retorno = $this->query($sql);



            return $retorno;
        } catch (Exception $e) {

            throw $e;
        }
    }

    public function perfil($perfilId, $empresaId = null) {

        try {

            $AndEmpresa = null;

            if (!empty($empresaId)) {
                $AndEmpresa = " AND Calendar.empresas_id = {$empresaId}";
            }



            $sql = "SELECT 
                        Calendar.id,
                        Calendar.start,
                        Calendar.end,
                        Calendar.status,
                        Calendar.descricao_interna,
                        Calendar.descricao_cliente,
                        Calendar.qtde_pessoas,
                        Calendar.token,
                        Calendar.pessoas_id,
                        Salao.nome as salao,
                        Ambiente.nome as ambiente,
                        Fisica.nome as funcionario,
                        Cliente.nome as cliente,
                        Cliente.rg,
                        Cliente.email,
                        Cliente.dt_nascimento,
                        Cliente.email,
                        Cliente.telefone
                    FROM
                        reservas.reservas as Calendar
                        inner join pessoaFisica as Fisica on Fisica.pessoas_id = Calendar.pessoas_id
                        inner join saloes as Salao on Calendar.saloes_id = Salao.id
                        inner join ambientes as Ambiente on Calendar.ambientes_id = Ambiente.id
                        inner join clientes as Cliente on Cliente.id = Calendar.clientes_id
                    WHERE
                        md5(Calendar.id) = '{$perfilId}'
                        AND `Calendar`.`status` in (0,1,2) " . $AndEmpresa;

            $retorno = $this->query($sql);

            return array_shift($retorno);
            
        } catch (Exception $e) {

            throw $e;
        }
    }

    

    public function filtrar($empresaId, $ambientesId = null, $dataInicio = null, $dataFim = NULL, $funcionarioId = null) {

        try {

            $FUNC = NULL;
            $AMBIENTE = NULL;

            $DATE = NULL;

            if (!empty($ambientesId)) {
                $AMBIENTE = " and Calendar.ambientes_id = {$ambientesId} ";
            }
            
            if (!empty($funcionarioId)) {
                $FUNC = " and Calendar.pessoas_id = {$funcionarioId} ";
            }
            
            if (!empty($dataInicio) && !empty($dataFim)) {

                $DATE = " and date(Calendar.start) between date('{$dataInicio}') AND date('{$dataFim}')  ";
            } else if (!empty($dataInicio) && empty($dataFim)) {

                $dataFim = $dataInicio;

                $DATE = " and date(Calendar.start) between date('{$dataInicio}') AND date('{$dataFim}')  ";
            }



            $sql = "SELECT 
                    Calendar . id, 
                    Calendar . title,
                    Calendar . start, 
                    Calendar . end, 
                    Calendar . token, 
                    Ambiente . nome as ambiente,
                    Pessoa.nome as funcionario,
                    Cliente.nome as cliente,
                    Cliente.telefone,
                    Cliente.email
            from
                    reservas as Calendar
                        inner join
                    pessoaFisica as Pessoa ON Pessoa.pessoas_id = Calendar.pessoas_id
                        inner join
                    clientes as Cliente ON Cliente.id = Calendar.clientes_id
                        inner join
                    ambientes as Ambiente ON Ambiente.id = Calendar.ambientes_id
            where
                    Calendar.empresas_id = {$empresaId}
                            " . $FUNC . "
                            " . $AMBIENTE . "
                            and Calendar.status = TRUE
                    " . $DATE . ";";



            $retorno = $this->query($sql);

            return $retorno;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    

    public function cancelarRegistro($token) {

        try {
            
            $sql = "UPDATE reservas 
                        SET 
                            status = 2,
                            color = '#c91236'
                        WHERE
                            token = '{$token}';";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function deleteItenLista($idFullcalenda, $empresasId, $tipoServicosId, $sevicosId) {

        try {



            $sql = "DELETE FROM

						reservas_has_tipos_servicos

					WHERE

						reservas_id = {$idFullcalenda} 

						AND empresas_id = {$empresasId}

						AND tipos_servicos_id = {$tipoServicosId}

						AND servicos_id = {$sevicosId};";

            return $this->query($sql);
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function countAssossiationList($reservasId, $empresasId, $tiposServicosId, $servicosId) {

        try {

            $sql = "SELECT 

						count(*) as count

					FROM

						reservas_has_tipos_servicos

					WHERE

						reservas_id       = {$reservasId}  

						AND empresas_id       = {$empresasId} 

						AND tipos_servicos_id = {$tiposServicosId} 

						AND servicos_id       = {$servicosId} ;";



            $return = $this->query($sql);

            if ($return[0]['count'] == 1) {

                return true;
            } else {

                return false;
            }
        } catch (Exception $e) {

            throw $e;
        }
    }

    public function listarDespesasRegistro($empresaId, $reservasId) {
        try {
            $sql = "SELECT 
                        Despesa.id, Despesa.nome, Despesa.valor, Despesa.data_vencimento
                    FROM
                        reservas.despesas AS Despesa
                            INNER JOIN
                        reservas.reservas_has_despesas AS CalendarDespesa ON Despesa.id = CalendarDespesa.despesas_id
                    WHERE
                        CalendarDespesa.empresas_id = {$empresaId}
                            AND CalendarDespesa.reservas_id = {$reservasId};";
            return $this->query($sql);
        } catch (Exception $ex) {
            
        }
    }
    
    public function mesasReservas( $mesas, $reservaId, $data ){
        try {
            
            if(is_array($mesas) && !empty($mesas) ){
                
                $joins = array();
                /**
                 * preparar os joins para o insert
                 */
                foreach ( $mesas as $mesa ){
                    $joins[] = "( $mesa, $reservaId, '{$data}' )";
                }


                $sql = "INSERT INTO `reservas`.`reservas_has_mesas`
                        ( `mesas_id`, `reservas_id`, `data` )
                            VALUES ".  join(',', $joins).";";
                
                return $this->query($sql);
                
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    public function listarMesasReservas( $reservaId ){
        try {
            
            $sql = "SELECT 
                        Mesa.id,
                        Mesa.nome
                    FROM
                        reservas.reservas_has_mesas AS MesaReserva
                            INNER JOIN
                        reservas.mesas AS Mesa ON Mesa.id = MesaReserva.mesas_id
                    WHERE
                        MesaReserva.reservas_id = $reservaId;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw  $ex;
        }
    }
    
    
    public function cadastroBasico( $empresaId, $usuarioId, $data ){
        try {
            
            $array = array(
                'empresas_id'  => $empresaId,
                'pessoas_id'   => $usuarioId,
                'clientes_id'  => 1,
                'saloes_id'    => 1,
                'ambientes_id' => 1,
                'qtde_pessoas' => 1,
                'title'        => 'cadastro iniciado',
                'start'        => $data,
                'end'          => $data,
                'color'        => '#FFD743',
                'status'       => 0,
            );

            return $this->genericInsert($array);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function verificaDisponibilidade( $data, $empresaId ){
        try {
            
            $sql = "SELECT 
                        count(*) as total
                    FROM
                        reservas.reservas
                    WHERE
                        status = 0
                                    AND empresas_id = $empresaId
                            AND DATE(start) = DATE('{$data}');";
            
            $retorno = $this->query($sql); 
            
            $retorno = array_shift($retorno[0]);
            
            if( $retorno ){
                throw new Exception('Data indisponível para reservar, aguarde até que seja concluida a reserva em aberto!', 2018);
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function deletaMesas( $reservaId ){
        try {
            
            $sql = "DELETE FROM reservas.reservas_has_mesas 
                    WHERE
                        reservas_id = $reservaId;";
            
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function recuperaDadosReservaEmail( $reservaId ){
        try {
            $sql = "SELECT 
                        UPPER(Salao.nome) AS salao,
                        UPPER(Ambiente.nome) AS ambiente,
                        UPPER(Cliente.nome) AS cliente,
                        Cliente.email
                    FROM
                        reservas AS Reseva
                            INNER JOIN
                        saloes AS Salao ON Salao.id = Reseva.saloes_id
                            INNER JOIN
                        ambientes AS Ambiente ON Ambiente.id = Reseva.ambientes_id
                            INNER JOIN
                        clientes AS Cliente ON Cliente.id = Reseva.clientes_id
                    WHERE
                        Reseva.id = $reservaId
                    ;";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function graficoCasas( $pessoasId , $roleId ){
        try {
            
            if( $roleId < 4 ){
                $empresaModel = new Empresa();
                $proprietarioId = $empresaModel->proprietario( md5($pessoasId) );
                $pessoasId = intval($proprietarioId[0]['pessoas_id']);
            } 
            
            $sql = "SELECT
                        COUNT(*) AS total,
                        CONCAT( YEAR(Reserva.start), '-', MONTH(Reserva.start) ) AS data,
                        SUM(qtde_pessoas) AS total_pessoas,
                        Reserva.empresas_id,
                        upper(Juridica.nome_fantasia) as nome_fantasia
                    FROM
                        reservas AS Reserva
                            INNER JOIN
                        pessoaJuridica AS Juridica ON Juridica.id = Reserva.empresas_id
                                    INNER JOIN
                        empresas AS Empresa ON Empresa.id = Reserva.empresas_id
                    WHERE
                        DATE(Reserva.start) BETWEEN DATE('2015-01-01') AND DATE('2015-12-01')
                            AND Empresa.pessoas_id = {$pessoasId}
                            AND Reserva.status = 1
                    GROUP BY Reserva.empresas_id, MONTH(Reserva.start), YEAR(Reserva.start) order by Reserva.start DESC;";
            
            $retorno = $this->query($sql);
            
            return $this->createDataChart($retorno);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    private final function arrayColumn( $newArray, $column ){
        foreach ($newArray as $value){
            if( key($value) == $column ){
                $array[] = $value[$column];
            }
        }
        return $array;
    }
    
    private final function createDataChart( array $dadosDB ){
        
        $newArray = array();
        $arrayKeys = array();
        $arrayEmpresas = array();
        $arrayEmpresasValores = array();
        $arraySaida = array();
        
        foreach ($dadosDB as $dado ){ 
            $fantasia = str_replace(' ', '_', trim(strtolower($dado['nome_fantasia'])));
            if(!in_array($fantasia, $arrayKeys)){
                $arrayKeys[] = $fantasia;
                $arrayEmpresas[] = trim(($dado['nome_fantasia']));
            }
        }
        
        foreach ($dadosDB as $dado ) { 
            
            $fantasia = str_replace(' ', '_', trim(strtolower($dado['nome_fantasia'])));
            
            if( !in_array($dado['data'], $this->arrayColumn($newArray, 'period'))){
                $newArray[] = array(
                    'period' => $dado['data'],
                    $fantasia => $dado['total'],
                );
            } else {
                
                $key =  array_keys($this->arrayColumn($newArray, 'period'), $dado['data']) ;
                $key = array_shift($key);
                $emp = array($fantasia => $dado['total']);
                $newArray[$key] = array_merge( $newArray[$key] , $emp);
            }
        }
        
        
        $arraySaida['keys'] = $arrayKeys;
        $arraySaida['empresas'] = $arrayEmpresas;
        $arraySaida['dados'] = $newArray;
        return $arraySaida;
        
    }
    
}
