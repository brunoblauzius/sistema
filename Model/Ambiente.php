<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Ambiente extends AppModel{
    
    public $useTable = 'ambientes';
    
    public $primaryKey = 'id';
    
    public $name = 'Ambiente';
    
    public $validate = array(
        'nome' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'salaoes_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
        'capacidade' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'mensagem' => Enum::VAZIO,
            ),
        ),
    );
    
    
    public function findById( $empresaId, $id = null ){
        try {
            $AMBIENTE = null;
            
            if(!is_null($id)){
                $AMBIENTE = " AND Ambiente.id = $id ";
            }
            
            $sql = "SELECT 
                Ambiente.id,
                Ambiente.saloes_id,
                Ambiente.nome,
                Ambiente.status,
                Ambiente.capacidade,
                Salao.nome as salao
            FROM
                reservas.ambientes AS Ambiente
                    INNER JOIN
                reservas.saloes AS Salao ON Salao.id = Ambiente.saloes_id
            WHERE Salao.empresas_id = $empresaId " 
                    . $AMBIENTE . 
            " ORDER BY Ambiente.nome DESC;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function AmbientesSalao( $saloesId, $empresaId ){
        try {
                        
            $sql = "SELECT 
                Ambiente.id,
                Ambiente.saloes_id,
                UPPER(Ambiente.nome) as nome,
                Ambiente.status,
                Ambiente.capacidade
            FROM
                reservas.ambientes AS Ambiente
                    INNER JOIN
                reservas.saloes AS Salao ON Salao.id = Ambiente.saloes_id
            WHERE Salao.empresas_id = $empresaId AND  Ambiente.saloes_id = $saloesId "
                    . " ORDER BY Ambiente.nome DESC;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function ambientesReservas($reservasId){
        
        try {
            $arraySaida = array();
            
            if( !empty($reservasId)){
                $sql = "SELECT 
                            Ambiente.id, Ambiente.nome
                        FROM
                            reservas.reservas_has_ambientes AS ResAmbi
                                INNER JOIN
                            ambientes AS Ambiente ON ResAmbi.ambientes_id = Ambiente.id
                        WHERE
                            reservas_id = $reservasId;";
                
                $registros = $this->query($sql);
                
                foreach ( $registros as $ambiente ){
                   $arraySaida[$ambiente['id']] = $ambiente['nome']; 
                }
                                
            }
            
            return $arraySaida;
            
        } catch (Exception $ex) {
            
        }
        
    }
    
}