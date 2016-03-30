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
                    Calendar . qtde_pessoas, 
                    Calendar . descricao_cliente, 
                    Calendar . descricao_interna, 
                    Calendar . assentos, 
                    Calendar . status as status_reserva, 
                    Ambiente . nome as ambiente,
                    Pessoa.nome as funcionario,
                    Cliente.nome as cliente,
                    Cliente.telefone,
                    Cliente.email,
                    EmailEnviado.status,
                    EmailEnviado.created as data_envio,
                    EmailEnviado.total_enviado,
                    EmailEnviado.confirm
            from
                    reservas as Calendar
                        inner join
                    pessoaFisica as Pessoa ON Pessoa.pessoas_id = Calendar.pessoas_id
                        inner join
                    clientes as Cliente ON Cliente.id = Calendar.clientes_id
                        inner join
                    ambientes as Ambiente ON Ambiente.id = Calendar.ambientes_id
                        left join
                    emails_enviados AS EmailEnviado ON EmailEnviado.reservas_id = Calendar.id
            where
                    Calendar.empresas_id = {$empresaId}
                            " . $FUNC . "
                            " . $AMBIENTE . "
                            and Calendar.status in (0,1)
                    " . $DATE . " ORDER BY Cliente.nome ASC;";



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
                'created'      => date('Y-m-d H:i:s'),
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
            if( !empty($reservaId) ){
                $sql = "DELETE FROM reservas.reservas_has_mesas 
                        WHERE
                            reservas_id = $reservaId;";

                return $this->query($sql);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function recuperaDadosReservaEmail( $reservaId ){
        try {
            $sql = "SELECT 
                        UPPER(Salao.nome) AS salao,
                        UPPER(Ambiente.nome) AS ambiente,
                        Ambiente.capacidade,
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
    
    
    public function reservasMesasRestantes( $empresaId, $data = null ){
        try {
            
            if(is_null($data)){
                $data = 'CURRENT_DATE()';
            }
            
            $sql = "SELECT 
                        (SELECT COUNT(*) FROM reservas_has_mesas AS Res
                                    LEFT JOIN mesas AS Mesa ON Mesa.id = Res.mesas_id
                                    WHERE Mesa.status = 1 AND Mesa.ambientes_id = Reserva.ambientes_id AND DATE(data) = DATE('{$data}')) AS mesasReservadas,
                        (select count(*) FROM mesas WHERE status = 1 AND ambientes_id = Ambiente.id) AS totalMesas,
                        DATE('{$data}'),
                        Ambiente.nome AS ambiente
                    FROM
                        ambientes AS Ambiente
                        left JOIN reservas AS Reserva ON Ambiente.id = Reserva.ambientes_id
                    WHERE
                        Ambiente.empresas_id = $empresaId
                            GROUP BY Ambiente.id;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    
    public function deletaCadastroInicio( $empresasId, $pessoasId, $data){
        try {
            
            $sql = "SELECT * FROM reservas "
                    . "WHERE empresas_id = $empresasId 
                            AND pessoas_id = $pessoasId
                            AND clientes_id = 1
                            AND saloes_id = 1
                            AND ambientes_id = 1 
                            AND qtde_pessoas = 1
                            AND date(start) = date('$data') ORDER BY 1 DESC LIMIT 1;";
            $registro = $this->query($sql);
            
            if( !empty($registro) ){
                $sql = "DELETE FROM reservas 
                            WHERE
                                id = {$registro[0]['id']};";

                return $this->query($sql);
            } else {
                throw new Exception('', 123456);
            }
            
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    final public function gravaEnvioEmail( $dados ){
        try {
            
           $emailEnviado =  $this->query("SELECT * FROM emails_enviados WHERE reservas_id = {$dados['reservas_id']}");
            
           if( count($emailEnviado) <= 0 ){
               
               $this->useTable = 'emails_enviados';
               return $this->genericInsert( $dados );
               
           } else {
               $sql = "
                   UPDATE reservas.emails_enviados 
                        SET 
                            status = {$dados['status']},
                            total_enviado = (total_enviado + 1)
                        WHERE
                            reservas_id = {$dados['reservas_id']};";
               return $this->query($sql);
           }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function confirmReserva( $token ){
        try {
                     
            if( !empty($token) ){
                
                $reserva = $this->query("SELECT * FROM reservas where token = '{$token}' and status = 1;");
                $reserva = array_shift($reserva); 
                
                
                if( !empty($reserva) ){
                    /**
                     * verifico se ja foi enviado o email para o cliente
                     */
                    $enviado = $this->query("select * from emails_enviados where reservas_id = {$reserva['id']};");
                    
//                    if(count($enviado) <= 0){
//                        throw new Exception("Você não pode confirmar essa reserva, reenvie o email para o cliente antes de confirmar!");
//                    }
                    
                    if( count($enviado) > 0 )
                    {
                        $sql = "UPDATE emails_enviados 
                                 SET 
                                     confirm = 1,
                                     status  = 1
                                 WHERE
                                     reservas_id = {$reserva['id']};";
                    } 
                    else 
                    {
                        $sql = "INSERT INTO `emails_enviados`
                                    (
                                        `reservas_id`,
                                        `empresas_id`,
                                        `pessoas_id`,
                                        `clientes_id`,
                                        `created`,
                                        `status`,
                                        `confirm`,
                                        `total_enviado`
                                    )
                                        VALUES
                                    (
                                        {$reserva['id']},
                                        {$reserva['empresas_id']},
                                        {$reserva['pessoas_id']},
                                        {$reserva['clientes_id']},
                                        now(),
                                        1,
                                        1,
                                        1
                                    );";
                    }
                    return $this->query($sql);
                } 
            }
           
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    
    
    
    final public function inserirConvidado( $clienteId, $reservaID ){
        try {
            
            $sql = "SELECT * FROM clientes_convidados WHERE clientes_id = $clienteId AND reservas_id = $reservaID;";
            $clienteReserva = $this->query($sql);
            
            if(count($clienteReserva) <= 0 ){
                $sql = "INSERT INTO clientes_convidados ( clientes_id, reservas_id , created) VALUES( $clienteId, $reservaID , NOW() );";
                return $this->query($sql);
            } 
//            else {
//                throw new Exception('Este cliente já foi cadastrado para essa reserva!');
//            }
                        
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    final public function desvincularConvidado( $clienteId, $reservaID ){
        try {
            
            $sql = "DELETE FROM clientes_convidados WHERE clientes_id = $clienteId AND reservas_id = $reservaID;";
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function verificarLimiteDeConvidados( $reservaId ){
        try {
            
            $sql = " SELECT 
                        Reserva.qtde_pessoas - (SELECT 
                                COUNT(*)
                            FROM
                                clientes_convidados
                            WHERE
                                reservas_id = Reserva.id) AS total
                    FROM
                        reservas AS Reserva
                    WHERE
                        Reserva.id = $reservaId;";
            
            $reserva = $this->query($sql);
           
            if( $reserva[0]['total'] <= 0){
                throw new Exception('Limite de convidados excedidos!');
            }
            
            return $reserva[0]['total'];
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    final public function convidados( $reservaID ){
        try {
            
            $sql = "SELECT 
                        Cliente.*
                    FROM
                        clientes AS Cliente
                            INNER JOIN
                        clientes_convidados AS Convidados ON Convidados.clientes_id = Cliente.id
                    WHERE
                        Convidados.reservas_id = $reservaID
                             ORDER BY Cliente.nome ASC ;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function listaConvidados( $token ){
        try {
            
            $sql = "SELECT 
                        Cliente.*, 
                        Convidados.created AS data_convite
                    FROM
                        reservas AS Reserva
                            INNER JOIN
                        clientes_convidados AS Convidados ON Convidados.reservas_id = Reserva.id
                            INNER JOIN
                        clientes AS Cliente ON Convidados.clientes_id = Cliente.id
                    WHERE
                        Reserva.token = '{$token}'"
                        . " ORDER BY Cliente.nome ASC;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function countReservasExcedido( $empresasId = NULl ){
        try {
            $sql = "SELECT 
                            COUNT(*) AS total
                        FROM
                            reservas
                        WHERE
                            empresas_id = $empresasId
                                AND CONCAT(MONTH(start), '-', YEAR(start)) = CONCAT(MONTH(NOW()), '-', YEAR(NOW()));";
            $retorno = $this->query($sql);
            $totalCadastrado = array_shift($retorno[0]);
            
            return Session::read('ContaEmpresa.reservas_mes') - $totalCadastrado; 
                        
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function confirmPresencaConvite( $clienteId, $reservasId ){
        try {
            
            $sql = "UPDATE clientes_convidados 
                    SET 
                        confirmado = 1
                    WHERE
                        reservas_id = {$reservasId} AND clientes_id = {$clienteId};";
                        
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function confirmadosParaEvento($ReservasId){
        try {
            
            $sql = "SELECT 
                        COUNT(*) total_pessoas_lista,
                        SUM(confirmado) confirmados,
                        SUM(IF(confirmado = 0, 1, 0)) nao_confirmados
                    FROM
                        clientes_convidados
                    WHERE
                        reservas_id = {$ReservasId};";
            
            $retorno = $this->query($sql);
            
            return $retorno[0];
                        
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function listarConvidadosHostess( $token ){
        try {
            
            $sql = "SELECT 
                        *
                    FROM
                        vw_listaConvidados
                    WHERE
                        token = '{$token}' ORDER BY confirmado, nome ASC;";
            
            return $this->query($sql);
                                    
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function buscaConvidadoHostess( $nome, $date = NULL, $empresasId = null ){
        try {
        
            if( $date === null ){
                $date = date('Y-m-d');
            }
            
            $sql = "SELECT 
                        *
                    FROM
                        reservas.vw_listaConvidados
                    WHERE
                        empresas_id = $empresasId 
                            AND DATE(start) = DATE('{$date}')
                            AND nome LIKE '%{$nome}%' "
                    . " ORDER BY nome, confirmado ASC;";
                            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function graficoReservasConvidados( $empresasId ){
        try {
            
            $sql = " SELECT 
                        COUNT(Reserva.id) total,
                        CONCAT(YEAR(Reserva.start),
                                '-',
                                MONTH(Reserva.start)) AS date,
                        MONTHNAME(Reserva.start) month_name,
                        MONTH(Reserva.start) month,
                        SUM(IF(ReservaClientes.confirmado = 1, 1, 0)) AS confirm,
                        SUM(ReservaClientes.status) AS not_confirm
                    FROM
                        reservas AS Reserva
                            INNER JOIN
                        clientes_convidados AS ReservaClientes ON ReservaClientes.reservas_id = Reserva.id
                    WHERE
                        DATE(Reserva.start) BETWEEN DATE_SUB(DATE(CURRENT_DATE()),
                            INTERVAL 2 MONTH) AND DATE(CURRENT_DATE())
                            AND Reserva.empresas_id = {$empresasId}
                    GROUP BY MONTH(Reserva.start)
                    ORDER BY MONTH(Reserva.start) ASC;";
            
            $retorno = $this->query($sql);
            
            /**
             * fazer os ajustes para a view
             */
            foreach ( $retorno as $node ){
                $labels[] = $node['month_name'];
                
                $datasets = array(
                    /*CONFIRM*/
                     array(
                         'fillColor' => "#f7aa04",
                         'strokeColor' => "#f7aa04",
                         'data' => array(56,55,40)
                     ),
                    /*NOT CONFIRM*/
                         array(
                         'fillColor' => "#79D1CF",
                         'strokeColor' => "#79D1CF",
                         'data' => array(56,55,40)
                     )
                 );
                
                $confirm[] = intval($node['confirm']);
                $notConfirm[] = intval($node['not_confirm']);
                
            }
            
            
            $datasets[0]['data'] = $notConfirm; 
            $datasets[1]['data'] = $confirm; 
            
            
            $dados['labels'] = $labels;
            $dados['datasets'] = $datasets;
            
            
            return $dados;   
            
        } catch (PDOException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function deletarReserva( $id ){
        try {
            
            if( !empty($id) )
            {
                $sql = "DELETE FROM reservas_has_clientes 
                        WHERE
                            reservas_id = $id;
                        DELETE FROM reservas_has_mesas 
                        WHERE
                            reservas_id = $id;";

                $this->query($sql);

                return $this->genericDelete($id);
                
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
