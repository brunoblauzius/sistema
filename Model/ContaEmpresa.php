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
            
            $sql = "SELECT
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
            $registro = $this->query($sql);
            $registro = array_shift($registro);
            
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
                                VALUES(
                                    {$empresaId},
                                    1, 
                                    1,
                                    2,
                                    NOW(),
                                    DATE_ADD(NOW(), INTERVAL 1 MONTH),
                                    {$registro['valor']},
                                    {$registro['qtde_funcionarios']},
                                    {$registro['duracao_contrato']},
                                    {$registro['valor_funcionario_adicional']},
                                    {$registro['qtde_empresas_conta']},
                                    {$registro['reservas_mes']},
                                    {$registro['envio_email_dados_reserva']},
                                    {$registro['lembrete_reserva']},
                                    {$registro['lista_convidados_cliente']},
                                    {$registro['emails_personalizados']},
                                    {$registro['controle_presencao_portaria']},
                                    {$registro['gerenciamento_ingressos']},
                                    {$registro['integracao_midias_sociais']},
                                    {$registro['gestao_de_eventos']},
                                    {$registro['gestao_ordens_servico']},
                                    {$registro['intranet']} 
                                );";
                                    
              return $this->query($sql);
              
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
}
