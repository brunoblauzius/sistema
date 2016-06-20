<?php

class Evento extends AppModel {

    //put your code here
    public $useTable = 'eventos';
    public $name = 'Evento';
    public $primaryKey = 'id';
    private $path;

    public function __construct() {
        parent::__construct();
        $this->data[$this->name]['created'] = date('Y-m-d H:i:s');
        $this->path = ROOT . DS . 'View/webroot/img/eventos_banner';
    }

    public $validate = array(
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            )
        ),
        'data' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            )
        ),
        'hora_inicio' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            )
        ),
    );

    /**
     * 
     * @param array $files
     * @param array $post
     */
    public function uploadBanner(array $files, array &$post, $width = 800, $height = 350) {
        if (!empty($files) && $files['arquivo']['error'] == 0) {
            try {

                $extensionPermiss = array('jpg', 'jpeg', 'png', 'gif');

                /* codigo de upload */
                if (!file_exists($this->path)) {
                    mkdir($this->path);
                }

                /**
                 * Verificar os dados do arquivo
                 */
                $fullName = pathinfo($files['arquivo']['name'], PATHINFO_BASENAME);
                $fileName = pathinfo($files['arquivo']['name'], PATHINFO_FILENAME);
                $extension = pathinfo($files['arquivo']['name'], PATHINFO_EXTENSION);

                $pathFile = $this->path . DS . URL::sanitizeTitleWithDashes($fileName) . '.' . $extension;

                if (in_array(strtolower($extension), $extensionPermiss)) {

                    require_once("Library/wideimage/WideImage.php");

                    WideImage::load($files['arquivo']['tmp_name'])->resize($width, $height, 'outside')->saveToFile($pathFile, 90);
                    $post['imagem'] =  URL::sanitizeTitleWithDashes($fileName) . '.' . $extension;
                    
                } else {
                    throw new Exception('é permitido somente arquivos do tipo ' . join(',', $extensionPermiss));
                }
            } catch (Exception $ex) {
                throw $ex;
            }
        }
    }

    public function findAll($empresas_id) {
        try {

            return $this->query("SELECT 
                                        *
                                    FROM
                                        reservas.eventos
                                    WHERE
                                        empresas_id = {$empresas_id}
                                        AND CONCAT(YEAR(data), '-', MONTH(data)) = CONCAT(YEAR(NOW()), '-', MONTH(NOW()));");
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function insertList($post) {
        try {

            /**
             * verifico se ja existe na lista
             */
            $sql = "SELECT 
                        count(pessoas_id) as count
                     FROM
                         reservas.eventos_has_tipos_listas etp
                         WHERE etp.eventos_id = {$_POST['eventos_id']}
                         AND etp.pessoas_id = {$_POST['pessoas_id']}
                         AND etp.empresas_id = {$_POST['empresas_id']};";

            $verifica = $this->query($sql);

            if ($verifica[0]['count'] == 0) {

                $joins = [];
                foreach ($post['qtde'] as $key => $value) {
                    $joins[] = "({$key}, '{$value}', {$_POST['pessoas_id']},{$_POST['empresas_id']}, {$_POST['eventos_id']} )";
                }

                $sql = "INSERT INTO eventos_has_tipos_listas( tipos_listas_id, quantidade, pessoas_id, empresas_id, eventos_id ) VALUES " . join(',', $joins);

                return $this->query($sql);
            } else {
                /**
                 * update
                 */
                $sql = NULL;

                foreach ($post['qtde'] as $key => $value) {

                    $sql .= " UPDATE eventos_has_tipos_listas SET quantidade = '{$value}' WHERE tipos_listas_id = $key "
                            . "AND eventos_id = {$_POST['eventos_id']} "
                            . "AND empresas_id = {$_POST['empresas_id']} "
                            . "AND pessoas_id = {$_POST['pessoas_id']};";
                }
                return $this->query($sql);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function quebraLinha($nomes) {

        $explode = explode('<br />', nl2br($nomes));
        $newArr = array();
        foreach ($explode as $line) {
            $newArr[] = $this->tratarQuebraLinha($line);
        }
        return $newArr;
    }

    private function tratarQuebraLinha($line) {
        $explode = explode('-', $line);
        if (count($explode) > 1) {
            return array(
                'nome' => trim($explode[0]),
                'telefone' => trim($explode[1]),
            );
        } else {
            return array(
                'nome' => Utils::returnStrings($line),
                'telefone' => Utils::returnNumeric($line),
            );
        }
    }

    /**
     * @todo metodo que adiciona os clientes a uma lista vip de um evento
     * @param int $pessoasId
     * @param int $eventosId
     * @param int $tiposListasId
     * @return boolean
     * @throws Exception
     */
    public function addClientVipList($pessoasId, $eventosId, $tiposListasId, $funcionariosPessoasId) {
        try {

            if (!empty($pessoasId) && !empty($eventosId) && !empty($tiposListasId)) {
                
                $sql= "SELECT * FROM eventos_pessoas WHERE pessoas_id = $pessoasId AND tipos_listas_id = $tiposListasId";
                $record = $this->query($sql);
                
                if( empty($record) ){
                    $sql = "INSERT INTO eventos_pessoas ( pessoas_id, eventos_id, tipos_listas_id, funcionarios_pessoas_id ) VALUES ( {$pessoasId}, {$eventosId}, {$tiposListasId}, {$funcionariosPessoasId} );";
                    return $this->query($sql);
                }
                
            } else {
                echo "$pessoasId, $eventosId, $tiposListasId;<br>";
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * @todo retorna todos os clientes da lista do evento
     * @param string $eventosId deve se passar o has md5 do id
     * @return array
     * @throws Exception
     */
    public function clientsInList( $eventosId ){
        try {
            
            $sql = " SELECT 
                        evetp.pessoas_id,
                        evetp.eventos_id,
                        evetp.presente,
                        upper(cl.nome) as nome,
                        cl.telefone,
                        tl.title,
                        tl.sexo,
                        upper(pf.nome) as promoter
                    FROM
                        eventos_pessoas AS evetp
                            left JOIN
                        vw_clientes AS cl ON cl.pessoas_id = evetp.pessoas_id
                            left JOIN
                        tipos_listas AS tl ON tl.id = evetp.tipos_listas_id
                            right JOIN
                        pessoaFisica AS pf ON pf.pessoas_id = evetp.funcionarios_pessoas_id
                    WHERE
                        presente = 0
                        AND md5(eventos_id) = '$eventosId';";

            return $this->query($sql);

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    public function validTokenEnterprises( $token, $empresasId ){
        try {
            
            $sql = "select * from eventos where md5(id) = '{$token}' and empresas_id = $empresasId;";
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function clientsInListByNome( $nome ){
        try {
            
            $NOME = NULL;
            
            if( !empty($nome)){
             $NOME = "AND lower(cl.nome) like lower(CAST(_latin1'%{$nome}%' AS CHAR CHARACTER SET utf8));";   
            }
            
            $sql = " SELECT 
                        evetp.pessoas_id,
                        evetp.eventos_id,
                        evetp.presente,
                        upper(cl.nome) as nome,
                        cl.telefone,
                        tl.title,
                        tl.sexo,
                        upper(pf.nome) as promoter
                    FROM
                        eventos_pessoas AS evetp
                            left JOIN
                        vw_clientes AS cl ON cl.pessoas_id = evetp.pessoas_id
                            left JOIN
                        tipos_listas AS tl ON tl.id = evetp.tipos_listas_id
                            right JOIN
                        pessoaFisica AS pf ON pf.pessoas_id = evetp.funcionarios_pessoas_id
                    WHERE
                        presente = 0
                        $NOME LIMIT 200";

            return $this->query($sql);

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function clientsMyList( $pessoasId, $eventosId ){
        try {
            
            
            $sql = " SELECT 
                        evetp.pessoas_id,
                        evetp.eventos_id,
                        evetp.presente,
                        upper(cl.nome) as nome,
                        cl.telefone,
                        tl.title,
                        tl.sexo,
                        upper(pf.nome) as promoter
                    FROM
                        eventos_pessoas AS evetp
                            left JOIN
                        vw_clientes AS cl ON cl.pessoas_id = evetp.pessoas_id
                            left JOIN
                        tipos_listas AS tl ON tl.id = evetp.tipos_listas_id
                            right JOIN
                        pessoaFisica AS pf ON pf.pessoas_id = evetp.funcionarios_pessoas_id
                    WHERE
                        evetp.funcionarios_pessoas_id = $pessoasId
                        AND evetp.eventos_id = $eventosId;";

            return $this->query($sql);

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function relatorioPorLista( $pessoasId, $eventosId ){
        try {
            $sql = " SELECT 
                            count(evetp.tipos_listas_id) total, 
                        evetp.eventos_id,
                        sum(if(evetp.presente = 0, 1, 0)) nao_presente,
                        sum(if(evetp.presente = 1, 1, 0)) presente,
                        tl.title,
                        tl.sexo,
                        upper(pf.nome) as promoter
                    FROM
                        eventos_pessoas AS evetp
                            left JOIN
                        vw_clientes AS cl ON cl.pessoas_id = evetp.pessoas_id
                            left JOIN
                        tipos_listas AS tl ON tl.id = evetp.tipos_listas_id
                            right JOIN
                        pessoaFisica AS pf ON pf.pessoas_id = evetp.funcionarios_pessoas_id
                    WHERE
                        evetp.funcionarios_pessoas_id = $pessoasId
                        AND evetp.eventos_id = $eventosId
                        GROUP BY evetp.tipos_listas_id";

            return $this->query($sql);

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function relatorioResumoFuncionario( $pessoasId, $eventosId ){
        try {
            $sql = " SELECT 
                        count(evetp.eventos_id) total,
                        sum(if(tl.sexo = 2, 1, 0)) unissex,
                        sum(if(tl.sexo = 1, 1, 0)) masculino,
                        sum(if(tl.sexo = 0, 1, 0)) feminino
                    FROM
                        eventos_pessoas AS evetp
                            left JOIN
                        tipos_listas AS tl ON tl.id = evetp.tipos_listas_id
                    WHERE
                        evetp.funcionarios_pessoas_id = $pessoasId
                        AND evetp.eventos_id = $eventosId
                        GROUP BY evetp.eventos_id; ";

            return $this->query($sql);

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function liberarClientePortaria($pessoasId, $eventosId){
        try {
            
            $sql = "update eventos_pessoas set presente = 1 where pessoas_id = {$pessoasId} and eventos_id = {$eventosId};";
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * 
     * @param int $empresasId
     * @param string $eventosId
     * @param int $pessoasId
     * @param boolean $date
     * @throws Exception
     */
    public function relatorioListas( $empresasId, $eventosId = null, $pessoasId = null, $date = true ){
        try {
            $EVENTOS = null;
            $DATE = null;
            $FUNCIONARIOS = null;
            
            if( !empty($eventosId) ){
                $EVENTOS = " AND MD5(EP.eventos_id) = '$eventosId' " ;
            }
            
            if( $date === true ){
                $DATE = " AND CONCAT(YEAR(EVT.data), '-', MONTH(EVT.data)) = CONCAT(YEAR(NOW()), '-', MONTH(NOW())) " ;
            }
            
            if( !empty($pessoasId) ){
                $FUNCIONARIOS = " AND EP.funcionarios_pessoas_id = $pessoasId ";
            }
            
            $sql = "SELECT 
                        COUNT(EVT.empresas_id) total,
                        SUM(IF(TL.sexo = 2, 1, 0)) unissex,
                        SUM(IF(TL.sexo = 1, 1, 0)) male,
                        SUM(IF(TL.sexo = 0, 1, 0)) female,
                        EVT.title,
                        EVT.empresas_id,
                        EP.eventos_id,
                        TL.title as lista
                    FROM
                        eventos_pessoas AS EP
                            INNER JOIN
                        eventos AS EVT ON EVT.id = EP.eventos_id
                            INNER JOIN
                        tipos_listas AS TL ON TL.id = EP.tipos_listas_id
                    WHERE
                        EVT.empresas_id = $empresasId
                            $EVENTOS
                            $DATE
                            $FUNCIONARIOS
                    GROUP BY EP.tipos_listas_id;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public final function relatorioTotalEvento($eventosId){
        try {
            
            $sql = "SELECT 
                        COUNT(EVT.empresas_id) total,
                        SUM(IF(TL.sexo = 2, 1, 0)) unissex,
                        SUM(IF(TL.sexo = 1, 1, 0)) male,
                        SUM(IF(TL.sexo = 0, 1, 0)) female,
                        EVT.title,
                        EVT.empresas_id,
                        EP.eventos_id
                    FROM
                        eventos_pessoas AS EP
                            INNER JOIN
                        eventos AS EVT ON EVT.id = EP.eventos_id
                            INNER JOIN
                        tipos_listas AS TL ON TL.id = EP.tipos_listas_id
                    WHERE
                        MD5(EP.eventos_id) = '$eventosId'
                            AND CONCAT(YEAR(EVT.data), '-', MONTH(EVT.data)) = CONCAT(YEAR(NOW()), '-', MONTH(NOW()))
                    GROUP BY EP.eventos_id;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function graficoEventosPessoasListas( $empresasId ){
        try {
            
            $sql = " SELECT 
                        EVT.title,
                        EVT.data,
                        MONTHNAME(data) month_name,
                        MONTH(data) month,
                        SUM(EVTL.quantidade) total_disponivel,
                        (SELECT COUNT(*) FROM
                                eventos_pessoas WHERE eventos_id = EVTL.eventos_id) pessoas
                    FROM
                        eventos_has_tipos_listas AS EVTL
                            INNER JOIN
                        eventos AS EVT ON EVTL.eventos_id = EVT.id
                    WHERE
                        EVT.empresas_id = $empresasId
                    GROUP BY EVTL.eventos_id; ";
            
            $registros = $this->query($sql);
            
            
        /**
             * fazer os ajustes para a view
             */
            foreach ( $registros as $node ){
                $labels[] = Utils::getDate($node['data']);
                
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
                
                $total_disponivel[] = intval($node['total_disponivel']);
                $pessoas[] = intval($node['pessoas']);
                
            }
            
            
            $datasets[1]['data'] = $pessoas; 
            $datasets[0]['data'] = $total_disponivel; 
            
            
            $dados['labels'] = $labels;
            $dados['datasets'] = $datasets;
            
            
            return $dados;   
            
        } catch (PDOException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function verificaEventosParaPromoter( $pessoasId ){
        try {
            
            $sql = "SELECT 
                        *
                    FROM
                        eventos_has_tipos_listas AS EVTL
                            INNER JOIN
                        eventos AS EVT on EVT.id = EVTL.eventos_id
                        WHERE 
                            EVTL.pessoas_id = $pessoasId
                            AND CONCAT(YEAR(EVT.data), '-', MONTH(EVT.data)) = CONCAT(YEAR(NOW()), '-', MONTH(NOW()))
                        GROUP BY EVTL.eventos_id;";
            return $this->query($sql);
            
        } catch (PDOException $ex) {
            throw $ex;
        }
    }
    
}
