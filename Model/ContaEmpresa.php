<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContaEmpresa
 *
 * @author bruno.blauzius
 */
class ContaEmpresa extends AppModel {
    //put your code here
    
    public $useTable = 'contas_empresas';

    public $name = 'ContaEmpresa';

    public $primaryKey = 'id';
    
    
    public final function inserirContaEmpresa( $empresaId ){
        try {
           
            $sql = "INSERT INTO  reservas.contas_empresas (
                                empresas_id,
                                situacao_contas_id,
                                tipos_pagamentos_id, 
                                contas_empresas_tipos_id,
                                created, 
                                expirar,
                                valor,
                                qtde_funcionarios,
                                duracao_contrato,
                                valor_funcionario_adicional,
                                qtde_empresas_conta,
                                reservas_mes,
                                envio_email_dados_reserva,
                                lembrete_reserva,
                                lista_convidados_cliente,
                                emails_personalizados,
                                controle_presencao_portaria,
                                gerenciamento_ingressos,
                                integracao_midias_sociais,
                                gestao_de_eventos,
                                gestao_ordens_servico,
                                intranet 
                            ) 
                                SELECT
                                    {$empresaId},
                                    1, 
                                    1,
                                    id,
                                    now(),
                                    date_add(now(), interval 1 month),
                                    valor,
                                    qtde_funcionarios,
                                    duracao_contrato,
                                    valor_funcionario_adicional,
                                    qtde_empresas_conta,
                                    reservas_mes,
                                    envio_email_dados_reserva,
                                    lembrete_reserva,
                                    lista_convidados_cliente,
                                    emails_personalizados,
                                    controle_presencao_portaria,
                                    gerenciamento_ingressos,
                                    integracao_midias_sociais,
                                    gestao_de_eventos,
                                    gestao_ordens_servico,
                                    intranet
                                FROM
                                    reservas.contas_empresas_tipos WHERE id = 2;";
                                    
              return $this->query($sql);
              
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
