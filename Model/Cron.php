<?php 


/**
* 
*/
class Cron extends AppModel
{
	
	public $name = 'Cron';

	public $primaryKey = 'id';

    private $tableSms = 'reservas.envio_sms';
    
    private $tableEmail = 'reservas.envio_emails';
            
	public function situacaoAgendadaEmail( $empresa = null , $dias = 1 ) {
        
            if( !is_null($empresa) ){
                $empresa = " AND Calendar.empresas_id = {$empresa} ";
            }
        
        	try{
            
                    $sql = "SELECT DISTINCT
                                Calendar.id AS fullcalendar_id,
                                Cliente.email,
                                Cliente.celular,
                                Cliente.telefone,
                                (Calendar.valor_total - Calendar.desconto) valor,
                                Calendar.start,
                                Calendar.end,
                                Calendar.clientes_id,
                                Calendar.empresas_id
                            FROM
                                reservas.fullcalendar AS Calendar
                                    INNER JOIN
                                reservas.clientes AS Cliente ON Cliente.id = Calendar.clientes_id
                                    
                            WHERE
                                `Calendar`.`status` = 1
                                    ".$empresa."
                                    AND Calendar.tipos_pagamentos_id IN (6)
                                    AND DATEDIFF(DATE(`Calendar`.`start`),
                                        DATE(CURRENT_DATE())) = {$dias}
                                    AND Calendar.id not in (select fullcalendar_id from {$this->tableEmail} )    
                                    ORDER BY Calendar.id DESC LIMIT 50;";
        					
                    return $this->query($sql);
                    
                } catch (Exception $ex) {
                    throw $ex;
                }
	}
    
    
    public function situacaoAgendadaSMS( $empresa = null , $dias = 1 ) {
        
            if( !is_null($empresa) ){
                $empresa = " AND Calendar.empresas_id = {$empresa} ";
            }
        
        	try{
            
                    $sql = "SELECT DISTINCT
                                Calendar.id AS fullcalendar_id,
                                Cliente.email,
                                Cliente.celular,
                                Cliente.telefone,
                                (Calendar.valor_total - Calendar.desconto) valor,
                                Calendar.start,
                                Calendar.end,
                                Calendar.clientes_id,
                                Calendar.empresas_id
                            FROM
                                reservas.fullcalendar AS Calendar
                                    INNER JOIN
                                reservas.clientes AS Cliente ON Cliente.id = Calendar.clientes_id
                                    
                            WHERE
                                `Calendar`.`status` = 1
                                    ".$empresa."
                                    AND Calendar.tipos_pagamentos_id IN (6)
                                    AND DATEDIFF(DATE(`Calendar`.`start`),
                                        DATE(CURRENT_DATE())) = {$dias}
                                    AND Calendar.id not in (select fullcalendar_id from {$this->tableSms} )     
                                    ORDER BY Calendar.id DESC LIMIT 50    ;";
        					
                    return $this->query($sql);
                    
                } catch (Exception $ex) {
                    throw $ex;
                }
	}
    
    
    public final function gravaEmail( $itens ){
        try{
            
            $inserts = array();
            
            if( !empty($itens) ) {
                
                foreach( $itens as $item ){
                    $inserts[] = "( {$item['fullcalendar_id']}, {$item['clientes_id']}, {$item['empresas_id']}, NOW(), {$item['status']}, '{$item['conteudo']}')";    
                }
                
                $sql = "INSERT INTO {$this->tableEmail}
                    (
                    `fullcalendar_id`,
                    `clientes_id`,
                    `empresas_id`,
                    `created`,
                    `status`,
                    `conteudo`)
                    VALUES ". join( ' ,', $inserts ) ." ;";
    					
                return $this->query($sql);
                
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }



    public final function gravaSMS( $itens ){
        try{
            
            $inserts = array();
            
            if( !empty($itens) ) {
                
                foreach( $itens as $item ){
                    $inserts[] = "( {$item['fullcalendar_id']}, {$item['clientes_id']}, {$item['empresas_id']}, NOW(), {$item['status']}, '{$item['conteudo']}', '{$item['sms_id']}')";    
                }
                
               $sql = "INSERT INTO {$this->tableSms}
                    (
                    `fullcalendar_id`,
                    `clientes_id`,
                    `empresas_id`,
                    `created`,
                    `status`,
                    `conteudo`, 
                    `sms_id`)
                    VALUES ". join( ' ,', $inserts ) ." ;";
    					
                return $this->query($sql);
                
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    
    public function SMSlastId() {
        
        $sql = "SELECT sms_id FROM {$this->tableSms} ORDER BY id DESC LIMIT 1;";
        
        $retorno = $this->query($sql);
        
        if( empty($retorno[0]['sms_id']) ){
            return (int) $retorno[0]['sms_id'];
        }
        return 8;
    }



}
