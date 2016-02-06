<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url('Usuarios/painel')?>"> <i class="fa fa-home"></i> Painel</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url(array('Empresas/empresasRelacionadas', md5($contaEmpresa['empresas_id'])));?>">Empresas Relacionadas</a>
            </li>
            <li>
                <a class="current" href="">Conta Empresa</a>
            </li>
        </ul>
    </div>
</div>


<div class="col-md-12">
    <section class="panel panel-success">
        <header class="panel-heading">
            Dados da Empresa.
        </header>
        <div class="panel-body ">
            <section class="row" style="margin-bottom: 20px;" >
                
                <div class="col-sm-4">
                    Razão social: <strong><?= ($empresa['razao'])?></strong>
                </div>
                <div class="col-sm-4">
                    Nome Fantasia: <strong><?= ($empresa['nome_fantasia'])?></strong>
                </div>
                <div class="col-sm-4">
                    Data de Criação da conta: <strong><?= Utils::convertData($contaEmpresa['created'])?></strong>
                </div>                
            </section>
            <section class="row">
                <div class="col-sm-4">
                    CNPJ: <strong><?= Utils::formatarCPFCNPJ($empresa['cnpj'])?></strong>
                </div>
                <div class="col-sm-4">
                    IE: <strong><?= ($empresa['ie'])?></strong>
                </div>
                <div class="col-sm-4">
                    Situação da Empresa: <strong  class="label label-primary"> <?= ($empresa['situacao_empresas'])?></strong>
                </div>
            </section>
        </div>
    </section>
</div>


<div class="col-md-12">
    <section class="panel panel-success">
        <header class="panel-heading">
            Conta Empresa
        </header>
        <div class="panel-body ">
            <section class="row" style="margin-bottom: 20px;" >
                
                <div class="col-sm-4">
                    Tipo de conta: <strong><?= ($contaEmpresa['tipo_conta'])?></strong>
                </div>
                <div class="col-sm-4">
                    Data de Criação da conta: <strong><?= Utils::convertData($contaEmpresa['created'])?></strong>
                </div>
                <div class="col-sm-4">
                    Duração do contrato: <strong><?= ($contaEmpresa['duracao_contrato'])?> Dias</strong>
                </div>
                
            </section>
            <section class="row">
                <div class="col-sm-4">
                    Situação da Conta: <strong class="label label-default"><?= ($contaEmpresa['situacao_conta'])?></strong>
                </div>
                <div class="col-sm-4">
                    Tipo de pagamento efetuado: <strong><?= ($contaEmpresa['tipo_pagamento'])?></strong>
                </div>
                <div class="col-sm-4">
                    Valor mensal: <strong>R$ <?= Utils::real($contaEmpresa['valor'])?></strong>
                </div>
            </section>
        </div>
    </section>
</div>

<div class="col-md-6">
    <section class="panel panel-success">
        <header class="panel-heading">
           Alterar dados da Conta.
        </header>
        <div class="panel-body ">
            
            <form action="<?= Router::url(array('Empresas', 'alterarConta'))?>" method="post" accept-charset="utf-8" id="EmpresaAlterarContaForm">
                
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-4" style="padding-top:5px;">
                        Tipo de Conta:
                    </div>
                    <div class="col-sm-8 form-group form-group-sm">
                        <select name="TipoConta[id]" class="form-control ">
                            <?php foreach ($TipoContas as $TipoConta) :?>
                                <?php if( $TipoConta['TipoConta']['id'] == $contaEmpresa['contas_empresas_tipos_id'] ):?>
                                    <option value="<?= $TipoConta['TipoConta']['id']?>" selected="selected"><?= $TipoConta['TipoConta']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $TipoConta['TipoConta']['id']?>"><?= $TipoConta['TipoConta']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-4" style="padding-top:5px;">
                        Situação da Empresa:
                    </div>
                    <div class="col-sm-8 form-group form-group-sm">
                        <select name="SituacaoEmpresa[id]" class="form-control ">
                            <?php foreach ($situacaoEmpresas as $situacao) :?>
                                <?php if( $situacao['SituacaoEmpresa']['id'] == $empresa['situacao_empresas_id'] ):?>
                                    <option value="<?= $situacao['SituacaoEmpresa']['id']?>" selected="selected"><?= $situacao['SituacaoEmpresa']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $situacao['SituacaoEmpresa']['id']?>"><?= $situacao['SituacaoEmpresa']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-4" style="padding-top:5px;">
                        Situação da Conta:
                    </div>
                    <div class="col-sm-8 form-group form-group-sm">
                        <select name="SituacaoConta[id]" class="form-control ">
                            <?php foreach ($situacaoContas as $situacaoConta) :?>
                                <?php if( $situacaoConta['SituacaoConta']['id'] == $contaEmpresa['situacao_contas_id'] ):?>
                                    <option value="<?= $situacaoConta['SituacaoConta']['id']?>" selected="selected"><?= $situacaoConta['SituacaoConta']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $situacaoConta['SituacaoConta']['id']?>"><?= $situacaoConta['SituacaoConta']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-4" style="padding-top:5px;">
                        Tipo de Pagamento:
                    </div>
                    <div class="col-sm-8 form-group form-group-sm">
                        <select name="TiposPagamento[id]" class="form-control ">
                            <?php foreach ($tiposPagamentos as $tiposPagamento) :?>
                                <?php if( $tiposPagamento['TiposPagamento']['id'] == $contaEmpresa['tipos_pagamentos_id'] ):?>
                                    <option value="<?= $tiposPagamento['TiposPagamento']['id']?>" selected="selected"><?= $tiposPagamento['TiposPagamento']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $tiposPagamento['TiposPagamento']['id']?>"><?= $tiposPagamento['TiposPagamento']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-4">
                        <button class="btn btn-primary">Atualizar Conta</button>
                    </div>
                </section>
                
                
            </form>
        </div>
    </section>
</div>


<div class="col-md-6">
    <section class="panel panel-success">
        <header class="panel-heading">
           Configurações da minha conta.
        </header>
        <div class="panel-body ">
            
            
            <form action="<?= Router::url(array('Empresas', 'alterarDadosConta'))?>" method="post" accept-charset="utf-8" id="AlterarDadosContaForm">
                
                <section class="col-sm-6 marginNull" style="" > 
                    <div class="col-sm-12">
                        <small>Funcionários adicionais:</small>
                        <div class="form-group form-group-sm">
                            <input type="text" name="Conta[qtde_funcionarios]" class="form-control"value="<?= $contaEmpresa['qtde_funcionarios']?>">
                        </div>
                    </div>
                </section>
                <section class="col-sm-6 marginNull" style="" > 
                    <div class="col-sm-12 ">
                        <small>Valor Adicional:</small>
                        <div class="form-group form-group-sm ">
                            <input type="text" name="Conta[valor_funcionario_adicional]" class="form-control money" value="<?= $contaEmpresa['valor_funcionario_adicional']?>"> 
                        </div>
                    </div>
                </section>
                
                <section class="col-sm-6" style="" > 
                    <div class="col-sm-12">
                        <small>Duração do contrato:</small>
                        <div class="form-group form-group-sm ">
                            <input type="text" name="Conta[duracao_contrato]" class="form-control"value="<?= $contaEmpresa['duracao_contrato']?>"> 
                        </div>
                    </div>
                </section>
                
                <section class="col-sm-6" style="" > 
                    <div class="col-sm-12">
                        <small>Quantidade de Empresas:</small>
                        <div class="form-group form-group-sm ">
                            <input type="text" name="Conta[qtde_empresas_conta]" class="form-control"value="<?= $contaEmpresa['qtde_empresas_conta']?>"> 
                        </div>
                    </div>
                </section>
                
                <section class="col-sm-6" style="" > 
                    <div class="col-sm-12">
                        <small>Limite de reserva no mês:</small>
                        <div class="form-group form-group-sm ">
                            <input type="text" name="Conta[reservas_mes]" class="form-control"value="<?= $contaEmpresa['reservas_mes']?>"> 
                        </div>
                    </div>
                </section>
                
                <section class="col-sm-6" style="" > 
                    <div class="col-sm-12">
                        <small>Valor mensalidade:</small>
                        <div class="form-group form-group-sm ">
                            <input type="text" name="Conta[valor]" class="form-control money"value="<?= $contaEmpresa['valor']?>"> 
                        </div>
                    </div>
                </section>
                
                <div class="clearfix"></div>
                
                <section class="col-sm-12" style="" > 
                    <div class="col-sm-6">
                        <small>Avisos de e-mail com dados da reserva:</small>
                        <?php 
                            $envio_email_dados_reserva = NULL;
                            if($contaEmpresa['envio_email_dados_reserva'] == 1){
                                $envio_email_dados_reserva = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[envio_email_dados_reserva]" value="0" > 
                                <input type="checkbox" name="Conta[envio_email_dados_reserva]" <?= $envio_email_dados_reserva?> value="1" > 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <small>Lembrete da reserva:</small>
                        <?php 
                            $lembrete_reserva = NULL;
                            if($contaEmpresa['lembrete_reserva'] == 1){
                                $lembrete_reserva = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[lembrete_reserva]" value="0" > 
                                <input type="checkbox" name="Conta[lembrete_reserva]" <?= $lembrete_reserva?> value="1"> 
                            </div>
                        </div>
                    </div>
                </section>
                
                <section class="col-sm-12" style="" > 
                    <div class="col-sm-6">
                        <small>Controle de presença na portario (Hostess):</small>
                        <?php 
                            $controle_presencao_portaria = NULL;
                            if($contaEmpresa['controle_presencao_portaria'] == 1){
                                $controle_presencao_portaria = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[controle_presencao_portaria]" value="0" > 
                                <input type="checkbox" name="Conta[controle_presencao_portaria]" <?= $controle_presencao_portaria?> value="1"> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <small>Gerenciamento de ingressos:</small>
                        <?php 
                            $gerenciamento_ingressos = NULL;
                            if($contaEmpresa['gerenciamento_ingressos'] == 1){
                                $gerenciamento_ingressos = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[gerenciamento_ingressos]" value="0" > 
                                <input type="checkbox" name="Conta[gerenciamento_ingressos]" <?= $gerenciamento_ingressos?> value="1"> 
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-sm-12" style="" > 
                    <div class="col-sm-6">
                        <small>Lista de convidados para o cliente:</small>
                        <?php 
                            $lista_convidados_cliente = NULL;
                            if($contaEmpresa['lista_convidados_cliente'] == 1){
                                $lista_convidados_cliente = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[lista_convidados_cliente]" value="0" > 
                                <input type="checkbox" name="Conta[lista_convidados_cliente]" <?= $lista_convidados_cliente?> value="1"> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <small>Personalização de e-mails:</small>
                        <?php 
                            $emails_personalizados = NULL;
                            if($contaEmpresa['emails_personalizados'] == 1){
                                $emails_personalizados = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[emails_personalizados]" value="0" > 
                                <input type="checkbox" name="Conta[emails_personalizados]" <?= $emails_personalizados?> value="1"> 
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-sm-12" style="" > 
                    <div class="col-sm-6">
                        <small>Midias Sociais:</small>
                        <?php 
                            $integracao_midias_sociais = NULL;
                            if($contaEmpresa['integracao_midias_sociais'] == 1){
                                $integracao_midias_sociais = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[integracao_midias_sociais]" value="0" > 
                                <input type="checkbox" name="Conta[integracao_midias_sociais]" <?= $integracao_midias_sociais?> value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <small>Gestão de Eventos:</small>
                        <?php 
                            $gestao_de_eventos = NULL;
                            if($contaEmpresa['gestao_de_eventos'] == 1){
                                $gestao_de_eventos = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[gestao_de_eventos]" value="0" > 
                                <input type="checkbox" name="Conta[gestao_de_eventos]" <?= $gestao_de_eventos?> value="1"> 
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-sm-12" style="" > 
                    <div class="col-sm-6">
                        <small>Gestão de Ordens de Serviço:</small>
                        <?php 
                            $gestao_ordens_servico = NULL;
                            if($contaEmpresa['gestao_ordens_servico'] == 1){
                                $gestao_ordens_servico = 'checked';
                            }
                        ?>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" name="Conta[gestao_ordens_servico]" value="0" > 
                                <input type="checkbox" name="Conta[gestao_ordens_servico]" <?= $gestao_ordens_servico?> value="1"> 
                            </div>
                        </div>
                    </div>
                </section>
                
                
                <div class="clearfix"></div>
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-4">
                        <button class="btn btn-primary">Atualizar Dados</button>
                    </div>
                </section>
            </form>
            
        </div>
    </section>
</div>


