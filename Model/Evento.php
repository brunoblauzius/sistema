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
    public function addClientVipList($pessoasId, $eventosId, $tiposListasId) {
        try {

            if (!empty($pessoasId) && !empty($eventosId) && !empty($tiposListasId)) {
                
                $sql= "SELECT * FROM eventos_pessoas WHERE pessoas_id = $pessoasId AND tipos_listas_id = $tiposListasId";
                $record = $this->query($sql);
                
                if( empty($record) ){
                    $sql = "INSERT INTO eventos_pessoas ( pessoas_id, eventos_id, tipos_listas_id ) VALUES ( {$pessoasId}, {$eventosId}, {$tiposListasId} );";
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
     * @param int $eventosId
     * @return array
     * @throws Exception
     */
    public function clientsInList( $eventosId ){
        try {
            
            $sql = " SELECT 
                        evetp.pessoas_id,
                        evetp.eventos_id,
                        evetp.presente,
                        pf.nome,
                        tl.title
                    FROM
                        eventos_pessoas AS evetp
                            INNER JOIN
                        pessoaFisica AS pf ON pf.pessoas_id = evetp.pessoas_id
                        inner join tipos_listas as tl on tl.id = evetp.tipos_listas_id
                    WHERE
                    evetp.eventos_id = $eventosId;";

            return $this->query($sql);

        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
