<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mesa
 *
 * @author bruno.blauzius
 */
class Mesa extends AppModel{
    //put your code here
    
    public $useTable = 'mesas';
    
    public $primaryKey = 'id';
    
    public $name = 'Mesa';
    
    public $validate = array(
        'nome' => array(
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
    );
    
    
    public function findById( $empresaId, $id = null ){
        try {
            $MESA = null;
            
            if(!is_null($id)){
                $MESA = " AND Mesa.id = $id ";
            }
            
            $sql = "SELECT 
                        Mesa.id,
                        Mesa.ambientes_id,
                        Mesa.empresas_id,
                        Mesa.nome,
                        Mesa.status,
                        Ambiente.nome AS ambiente
                    FROM
                        reservas.mesas AS Mesa
                            INNER JOIN
                        reservas.ambientes AS Ambiente ON Ambiente.id = Mesa.ambientes_id
                    WHERE
                        Mesa.empresas_id = $empresaId 
                        " .$MESA. "
                    ORDER BY Mesa.nome DESC;";

            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function mesasAmbiente( $empresaId, $ambienteId, $dataReserva){
        try {
            
            $AMBIENTE = NULL;
            
            if(is_array($ambienteId)){
                $AMBIENTE = " AND ambientes_id in ( " . join(',', $ambienteId) . ');';
            } else {
                $AMBIENTE = " AND ambientes_id = $ambienteId; ";
            }
            
            if( !empty($ambienteId) && !empty($dataReserva) && !empty($empresaId) ){
                $sql = "SELECT 
                        *
                    FROM
                        reservas.mesas AS Mesa
                    WHERE
                        Mesa.status = 1
                        AND
                        Mesa.id NOT IN (SELECT 
                                mesas_id
                            FROM
                                reservas.reservas_has_mesas
                            WHERE
                                DATE(data) = DATE('{$dataReserva}'))
                            AND empresas_id = $empresaId"
                            .$AMBIENTE;
            
                return $this->query($sql);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function mesasReservadasDisponiveis( $ambienteId, $reservaId, $data ){
        try {
            $sql = "SELECT 
                        *
                    FROM
                        reservas.mesas AS Mesa
                    WHERE
                        Mesa.status = 1
                        AND 
                        Mesa.ambientes_id = $ambienteId
                            AND Mesa.id NOT IN (SELECT 
                                mesas_id
                            FROM
                                reservas.reservas_has_mesas
                            WHERE
                                DATE(data) = DATE('{$data}'))
                            OR Mesa.id IN (SELECT 
                                mesas_id
                            FROM
                                reservas.reservas_has_mesas
                            WHERE
                                reservas_id = $reservaId); ";
                                    
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function mesasReservas( $reservaId ){
        try {
            $sql = "SELECT 
                        Mesa.id, Mesa.nome
                    FROM
                        reservas.reservas_has_mesas AS ReservaMesa
                            INNER JOIN
                        reservas.mesas AS Mesa ON Mesa.id = ReservaMesa.mesas_id
                    WHERE
                        ReservaMesa.reservas_id = $reservaId;";
            
           $mesas = $this->query($sql);
           
           $mesas = $this->mesasReservasList($mesas, 'id');
           
           $mesas = $this->selectIn($mesas);
           
           return $mesas;
           
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function mesasReservasList($array, $node ){
        $newArray = array();
        foreach ($array as $value) {
            $newArray[] = ($value[$node]);
        }
        return $newArray[0] = $newArray;
    }
    
    
    public function selectIn( array $mesas ){
        try {
            
            if( !empty($mesas) ){
                $in = join(', ', $mesas);
                $sql = "SELECT * FROM reservas.mesas WHERE id IN ( $in );";
                $lista = $this->query($sql);
                return $this->lista($lista);
            }
            return array();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function inserirMesasCadastroSite( $empresasId, $quantidade, $ambienteId ){
        try {
            $mesaId = array();
            if( !empty($empresasId) && !empty($quantidade) && !empty($ambienteId) )
            {
                for ($index = 1; $index < $quantidade; $index++)
                {
                    $mesaId[] = $this->genericInsert(array(
                        'ambientes_id'  => $ambienteId,
                        'empresas_id'   => $empresasId,
                        'nome'          => $index,
                        'status'        => true
                    ));
                } 
            }
            
            return $mesaId;
            
        } catch (Exception $ex) {
            
        }
    }
    
}
