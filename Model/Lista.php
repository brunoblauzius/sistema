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
    
    public function listarCadastrosListaPromoters( $pessoasId, $empresasId ){
        try {
            
            $sql = " SELECT 
                        id,
                        quantidade
                    FROM
                        reservas.eventos_has_tipos_listas etp
                            INNER JOIN
                        tipos_listas tp ON tp.id = etp.tipos_listas_id
                        WHERE etp.empresas_id = $empresasId
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
    
}
