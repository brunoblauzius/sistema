<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lista
 *
 * @author BRUNO
 */
class Lista extends AppModel{
    //put your code here
    
    public $useTable = 'tipos_listas';
    
    public $name = 'Lista';
    
    public $primaryKey = 'id';
    
    private $path;
    
    public function __construct() {
        parent::__construct();
    }
    
    public $validate = array(
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            )
        ),
    );
    
    public function listarCadastrosListaPromoters( $pessoasId, $eventosId ){
        try {
            
            $sql = " SELECT 
                        id,
                        quantidade
                    FROM
                        reservas.eventos_has_tipos_listas etp
                            INNER JOIN
                        tipos_listas tp ON tp.id = etp.tipos_listas_id
                        WHERE etp.eventos_id = $eventosId
                        AND pessoas_id = $pessoasId; ";
            
            $registros = $this->query($sql);
            $lista = array();
            
            foreach ( $registros as $registro ){
                $lista[$registro['id']] = $registro['quantidade'];
            }
            
            return $lista;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function totalNalistaEvento( $eventoId ){
        try {
            
            $sql="SELECT 
                        sum(quantidade) total
                    FROM
                        reservas.eventos_has_tipos_listas etp
                        WHERE etp.eventos_id = $eventoId;";
            $registro = $this->query($sql);
            
            return $registro[0]['total'];
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function copyListaPromoter( $pessoasIdCopy, $pessoasId, $eventosId){
        try {
            
            $registros = $this->listarCadastrosListaPromoters($pessoasIdCopy, $eventosId);
            
            if( count($registros) == 0 ){
                throw new Exception('Não existe nenhuma lista relacionada a esse funcionário');
            }
            
            $sql = "INSERT INTO eventos_has_tipos_listas ( eventos_id, tipos_listas_id, pessoas_id, empresas_id, quantidade ) 
                        SELECT eventos_id, tipos_listas_id, $pessoasId, empresas_id, quantidade 
                        FROM eventos_has_tipos_listas WHERE eventos_id = $eventosId AND pessoas_id = $pessoasIdCopy; ";
            $this->query($sql);
                 
            return $registros;
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function listaDisponivel( $pessoasId ){
        try {
            
            $sql = " SELECT 
                            TL.id,
                            TL.title
                        FROM
                            eventos_has_tipos_listas AS ETL
                                INNER JOIN
                            tipos_listas AS TL ON TL.id = ETL.tipos_listas_id
                        WHERE
                            ETL.pessoas_id = {$pessoasId}
                                AND ETL.quantidade > 0; ";
                            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
