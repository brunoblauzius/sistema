<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Carrinho
 *
 * @author bruno.blauzius
 */
class Carrinho extends AppModel {


    public $useTable = 'pagseguro_pagamentos';

    public $name = 'Carrinho';

    public $primaryKey = 'id';


    public function recuperarProdutosSistema(){
        try {
            
            $sql = "SELECT 
                        id,
                        nome,
                        valor
                    FROM
                        reservas.contas_empresas_tipos
                    WHERE
                        status = 1;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function recuperarItensSistema(){
        try {
            
            $sql = "SELECT 
                        id,
                        nome,
                        valor
                    FROM
                        reservas.contas_empresas_tipos
                    WHERE
                        status = 2;";
            
            return $this->query($sql);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    
    public function listarContaEmpresaEstatus( $empresasId ){
        try {
            $sql = "SELECT 
                        PagP.id,
                        ContEmp.empresas_id,
                        PagStat.nome as status_pagamento,
                        PagTip.nome as tipo_pagamento,
                        PagIdent.nome as modo_pagamento,
                        PagP.created,
                        PagP.modified,
                        PagP.codigo,
                        PagP.reference,
                        PagP.grossamount
                    FROM
                        reservas.pagseguro_conta_empresas AS PagCE
                            INNER JOIN
                        reservas.contas_empresas AS ContEmp ON ContEmp.id = PagCE.contas_empresas_id
                            INNER JOIN
                        reservas.pagseguro_pagamentos AS PagP ON PagP.id = PagCE.pagseguro_pagamentos_id
                            LEFT JOIN
                        reservas.pagseguro_status_transacao AS PagStat ON PagStat.id = PagP.pagseguro_status_transacao_id
                            LEFT JOIN
                        reservas.pagseguro_tipo_transacao AS PagTip ON PagTip.id = PagP.pagseguro_tipo_transacao_id
                            LEFT JOIN
                        reservas.pagseguro_identificador_meio_pagamento AS PagIdent ON PagIdent.id = PagP.pagseguro_identificador_meio_pagamento_id
                    WHERE
                        ContEmp.empresas_id = {$empresasId} 
                        AND PagStat.id not in( 6 , 7 )
                    ORDER BY created DESC LIMIT 1;";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    public function itensLista( $pagseguroPagammentoId ){
        try {
            $sql = "SELECT 
                        Iten.id,
                        Iten.contas_empresas_tipos_id,
                        Iten.quantidade,
                        Iten.valor,
                        ContasEmpresaTipos.nome
                    FROM
                        reservas.pagseguro_pagamentos as Pag
                        inner join reservas.pagseguro_pagamentos_itens as Iten on Iten.pagseguro_pagamentos_id = Pag.id
                        inner join reservas.contas_empresas_tipos as ContasEmpresaTipos on ContasEmpresaTipos.id = Iten.contas_empresas_tipos_id
                    where Iten.pagseguro_pagamentos_id = {$pagseguroPagammentoId};";
            return $this->query($sql);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
        
}
