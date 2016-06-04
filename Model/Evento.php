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
    public function uploadBanner( array $files, array &$post){
        if(!empty($files) && $files['arquivo']['error'] == 0){
            
            /*codigo de upload*/
            if(file_exists($this->path)){
                mkdir($this->path);
            }
            
            
            
        }
    }
    
    public function findAll( $empresas_id ){
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
    
    
    public function insertList( $post ){
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
            
            if( $verifica[0]['count'] === 0 ){
                
                $joins = [];
                foreach ( $post['qtde'] as $key => $value ){
                    $joins[] = "({$key}, '{$value}', {$_POST['pessoas_id']},{$_POST['empresas_id']}, {$_POST['eventos_id']} )";
                }

                $sql = "INSERT INTO eventos_has_tipos_listas( tipos_listas_id, quantidade, pessoas_id, empresas_id, eventos_id ) VALUES " . join(',', $joins);
                
                return $this->query($sql);
                
            } else {
                /**
                 * update
                 */
                $sql = NULL;
                
                foreach ( $post['qtde'] as $key => $value ){
                    
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
    
    
    
    
}
